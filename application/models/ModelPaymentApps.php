<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelPaymentApps extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->db_oriskin = $this->load->database('oriskin', true);
	}

	public function getTransactionsCustomer($customerid)
	{
		$this->db_oriskin->where('customer_id', $customerid);
		$this->db_oriskin->order_by('id', 'DESC');
		$transactions = $this->db_oriskin->get('transactions_apps')->result_array();

		foreach ($transactions as &$trx) {
			switch ($trx['status']) {
				case 'PAID':
					$trx['status'] = 'Selesai';
					$trx['payment_status'] = 2;
					break;
				case 'PENDING':
					$trx['status'] = 'Menunggu Pembayaran';
					$trx['payment_status'] = 1;
					break;
				case 'CANCELED':
					$trx['status'] = 'Dibatalkan';
					$trx['payment_status'] = 3;
					break;
				case 'EXPIRED':
					$trx['status'] = 'Expired';
					$trx['payment_status'] = 4;
					break;
				default:
					$trx['status'] = $trx['status'];
					$trx['payment_status'] = 0;
			}

			$details = $this->db_oriskin
				->where('transaction_id', $trx['id'])
				->get('transaction_details_apps')
				->result_array();

			foreach ($details as &$d) {
				if ($d['product_type_id'] == 1) {
					$q = $this->db_oriskin->get_where('mstreatment', ['id' => $d['product_id']])->row_array();
					$d['product_name'] = $q['name'] ?? null;
					$d['product_image'] = $q['image'] ?? null;
				} elseif ($d['product_type_id'] == 2) {
					$q = $this->db_oriskin->get_where('msproductmembershiphdr', ['id' => $d['product_id']])->row_array();
					$d['product_name'] = $q['name'] ?? null;
					$d['product_image'] = $q['image'] ?? null;
				} elseif ($d['product_type_id'] == 3) {
					$q = $this->db_oriskin->get_where('msproduct', ['id' => $d['product_id']])->row_array();
					$d['product_name'] = $q['name'] ?? null;
					$d['product_image'] = $q['image'] ?? null;
				}
			}

			$trx['products'] = $details;
		}
		return $transactions;
	}


	public function getTransactionsCustomerById($customerid, $id)
	{
		$this->db_oriskin->where('customer_id', $customerid);
		$this->db_oriskin->where('id', $id);
		$transaction = $this->db_oriskin->get('transactions_apps')->row_array();

		if (!$transaction) {
			return null; // atau return array kosong
		}

		// Konversi status
		switch ($transaction['status']) {
			case 'PAID':
				$transaction['status'] = 'Selesai';
				$transaction['payment_status'] = 2;
				break;
			case 'PENDING':
				$transaction['status'] = 'Menunggu Pembayaran';
				$transaction['payment_status'] = 1;
				break;
			case 'CANCELED':
				$transaction['status'] = 'Dibatalkan';
				$transaction['payment_status'] = 3;
				break;
			case 'EXPIRED':
				$transaction['status'] = 'Expired';
				$transaction['payment_status'] = 4;
				break;
			default:
				$transaction['status'] = $transaction['status'];
				$transaction['payment_status'] = 0;
		}

		$details = $this->db_oriskin
			->where('transaction_id', $transaction['id'])
			->get('transaction_details_apps')
			->result_array();

		foreach ($details as &$detail) {
			switch ($detail['product_type_id']) {
				case 1:
					$product = $this->db_oriskin->get_where('mstreatment', ['id' => $detail['product_id']])->row_array();
					break;
				case 2:
					$product = $this->db_oriskin->get_where('msproductmembershiphdr', ['id' => $detail['product_id']])->row_array();
					break;
				case 3:
					$product = $this->db_oriskin->get_where('msproduct', ['id' => $detail['product_id']])->row_array();
					break;
				default:
					$product = null;
			}

			if ($product) {
				$detail['product_name'] = $product['name'] ?? 'Produk tidak ditemukan';
				$detail['product_image'] = $product['image'] ?? null;
				$detail['product_description'] = $product['description'] ?? null;
			} else {
				$detail['product_name'] = 'Produk tidak ditemukan';
				$detail['product_image'] = null;
				$detail['product_description'] = null;
			}
		}

		$transaction['products'] = $details;

		return $transaction;
	}

	public function validationToken($token, $customerid)
	{
		$this->db_oriskin->where('customerid', $customerid);
		$this->db_oriskin->where('token', $token);
		$query = $this->db_oriskin->get('usersApps');

		return $query->num_rows() > 0;
	}


	public function getCustomerSaldoHistory($customerid)
	{
		$sql = "
        SELECT 
             CAST(d.subtotal * 0.3 AS DECIMAL(18,2)) AS amount,
            'Pembelian ' + e.name AS description,
            a.firstname + ' ' + a.lastname AS customername,
            CONVERT(VARCHAR(10), c.transaction_date, 120) AS date,
			c.id
        FROM mscustomer a
        INNER JOIN slguestlog b ON a.guestlogid = b.id
        INNER JOIN transactions_apps c ON a.id = c.customer_id
        INNER JOIN transaction_details_apps d ON c.id = d.transaction_id
        INNER JOIN msproductmembershiphdr e ON d.product_id = e.id
        WHERE b.refferalid = ?
          AND d.product_id IN (2121, 2122, 2119)
          AND d.product_type_id = 2
		AND c.status = 'PAID'
    ";

		$query = $this->db_oriskin->query($sql, [$customerid]);
		return $query->result_array();
	}


	public function getCustomerSaldo($customerid)
	{
		$sql = "
        SELECT
            SUM(d.subtotal * 0.3) 
              - ISNULL((
					SELECT SUM(withdraw_amount) 
					FROM customer_withdraw_history w
					WHERE w.customer_id = ?
					  AND w.withdraw_status IN ('PENDING','ACCEPTED', 'SUCCEEDED') 
				), 0) AS totalsaldo
        FROM mscustomer a
        INNER JOIN slguestlog b ON a.guestlogid = b.id
        INNER JOIN transactions_apps c ON a.id = c.customer_id
        INNER JOIN transaction_details_apps d ON c.id = d.transaction_id
        WHERE b.refferalid = ?
          AND d.product_id IN (2121, 2122, 2119)
          AND d.product_type_id = 2
		  AND c.status = 'PAID'
        GROUP BY a.id
    ";

		$query = $this->db_oriskin->query($sql, [$customerid, $customerid]);
		$result = $query->row_array();

		return $result ? $result['totalsaldo'] : 0;
	}


	public function getCustomerWithdrawHistory($customerid)
	{
		$sql = "
        SELECT a.withdraw_amount as amount, 
		'Penarikan saldo' as description, 
		a.id, 
		CONVERT(VARCHAR(10), a.request_date, 120) AS date, 
		a.withdraw_status as status 
		FROM customer_withdraw_history a 
		inner join mscustomer b ON a.customer_id = b.id
		WHERE a.customer_id = ?
    ";

		$query = $this->db_oriskin->query($sql, [$customerid]);
		return $query->result_array();
	}

	public function save_account($data)
	{
		return $this->db_oriskin->insert('msaccount', $data);
	}

	public function save_bank_account($data)
	{
		return $this->db_oriskin->insert('bank_account', $data);
	}

	public function get_account_by_id($id)
	{
		$this->db_oriskin->select('*');
		$this->db_oriskin->from('msaccount');
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->get()->row_array();
	}

	public function update_account($id, $data)
	{
		$this->db_oriskin->where('id', $id);
		return $this->db_oriskin->update('msaccount', $data);
	}

	public function createPayoutCustomer($data)
	{
		$this->db_oriskin->insert('customer_withdraw_history', $data);
		return $this->db_oriskin->affected_rows() > 0;
	}
	public function getAllPayoutCustomers($date=null)
	{
		$this->db_oriskin->select("ch.*,CONCAT(c.firstname, ' ', c.lastname) as customername");
		$this->db_oriskin->from('customer_withdraw_history ch');
		$this->db_oriskin->join('mscustomer c','c.id=ch.customer_id','left');
		if(!empty($date)){
			$this->db_oriskin->where("ch.request_date >=", $date.' 00:00:00');
			$this->db_oriskin->where("ch.request_date <=", $date.' 23:59:59');
		}
		$this->db_oriskin->order_by('id', 'DESC');
		return $this->db_oriskin->get()->result_array();
	}

	public function getPayoutCustomerById($customer_id)
	{
		$this->db_oriskin->select('ch.*,CONCAT(c.firstname, ' - ', c.lastname) as customername');
		$this->db_oriskin->from('customer_withdraw_history ch');
		$this->db_oriskin->join('mscustomer c','c.id=ch.customerid','left');
		$this->db_oriskin->where('customer_id', $customer_id);
		$this->db_oriskin->order_by('id', 'DESC');
		return $this->db_oriskin->get()->result_array();
	}
}
