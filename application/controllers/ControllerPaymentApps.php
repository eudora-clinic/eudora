<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ControllerPaymentApps extends CI_Controller
{
    private $apiKey = "xnd_production_25ykc7t8fCA7AflOxJfYee4T2RxOKKbZwnvUqS6TyKQWFUnN4JBkIi0vOe84BE";
    private $apiKeyDev = "xnd_development_xD7p4LUZY8lm3aYer3Q5rYZAkFbMZLd4DVtMPT5vty8A0gJohRAo9GWuymrIIZ";
    private $webhook_token = "tqUj8SEStnqUMzG2rQQcmahUgvy1HIz2RHJngj9XLpSJ7m2A";
    function __construct()
    {
        parent::__construct();
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("If-Modified-Since: Mon, 22 Jan 2008 00:00:00 GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Cache-Control: private");
        header("Pragma: no-cache");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers: Content-Type');
        $this->load->model('ModelPaymentApps');
        $this->load->library('Utility');
        $this->load->library('Datatables');
        date_default_timezone_set('Asia/Jakarta');
    }

    function content($type = "", $param1 = "", $param2 = "")
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        if (!$this->session->userdata('is_login')) {
            $this->load->view('login');
        } else {
            switch ($type) {
                case 'payoutSubAccountXendit':
                    $data['title'] = 'payoutSubAccountXendit';
                    $data['content'] = 'Finance/payoutSubAccountXendit';
                    $data['mod'] = $type;
                    $id = $this->uri->segment(2);
                    if ($id) {
                        $data['id'] = $id;
                    }
                    break;
                case 'listCustomerWithdraw':
                    $data['title'] = 'listCustomerWithdraw';
                    $data['content'] = 'Finance/listCustomerWithdraw';
                    $data['mod'] = $type;
                    $id = $this->uri->segment(2);
                    if ($id) {
                        $data['id'] = $id;
                    }
                    break;
                case 'listSubAccountXendit':
                    $data['title'] = 'listSubAccountXendit';
                    $data['content'] = 'Finance/listSubAccountXendit';
                    $data['mod'] = $type;
                    break;
            }
            $this->load->view('index', $data);
        }
    }

    function sendNotif($data)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $api_url = 'https://wa7029.cloudwa.my.id/api/v1/messages';
        $api_token = array(
            'Authorization: Bearer u0jEy0iWfjZER7Dn.Q4bY4xxSQ3iFJgTdwCh7GUPg54Jpb40z',
            'Content-Type: application/json'
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $api_token,
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function create_invoice()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',

            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',

            ]);
            return;
        }

        $db_oriskin = $this->load->database('oriskin', true);
        $post = json_decode($this->input->raw_input_stream, true);

        if (empty($post['detail']) || !is_array($post['detail'])) {
            echo json_encode(['success' => false, 'message' => 'Detail produk tidak ada']);
            return;
        }
        if (empty($post['customer_id']) || empty($post['amount']) || empty($post['location_id'])) {
            echo json_encode(['success' => false, 'message' => 'Data transaksi tidak lengkap']);
            return;
        }
        $db_oriskin->trans_begin();

        try {
            $invoiceno = "INV" . date("YmdHis");

            $dataHeader = [
                'invoiceno' => $invoiceno,
                'transaction_date' => date('Y-m-d H:i:s'),
                'customer_id' => $post['customer_id'],
                'total_amount' => $post['amount'],
                'location_id' => $post['location_id'],
                'payment_method' => null,
                'consultant_id' => $post['consultant_id'],
            ];

            $db_oriskin->select('xendit_id');
            $db_oriskin->from('mslocation');
            $db_oriskin->where('id', $post['location_id']);
            $row = $db_oriskin->get()->row();

            $for_user_id = $row ? $row->xendit_id : null;


            $db_oriskin->insert('transactions_apps', $dataHeader);
            $transaction_id = $db_oriskin->insert_id();
            $is_split = false;
            foreach ($post['detail'] as $item) {

                $invoicedetailno = $invoiceno . $item['producttypeid'] . $item['productid'];
                $dataDetail = [
                    'transaction_id' => $transaction_id,
                    'product_id' => $item['productid'],
                    'product_type_id' => $item['producttypeid'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'discount_percent' => 0,
                    'discount_value' => 0,
                    'discount_remarks' => null,
                    'invoiceno_detail' => $invoicedetailno
                ];
                $db_oriskin->insert('transaction_details_apps', $dataDetail);

                $db_oriskin->where('id', $item['id']);
                $db_oriskin->update('customer_cart', [
                    'isactive' => 0,
                    'is_on_payment' => 0
                ]);

                if (
                    $item['producttypeid'] == 2 &&
                    in_array($item['productid'], [2121, 2120, 2119])
                ) {
                    $is_split = true;
                }
            }
            $db_oriskin->trans_commit();
            $external_id = $invoiceno;
            $amount = $post['amount'];

            $data = [
                "external_id" => $external_id,
                "amount" => $amount,
                "description" => "Pembelian Product Eudora"
            ];

            $headers = [
                "Content-Type: application/json"
            ];

            if ($for_user_id) {
                $headers[] = "for-user-id: $for_user_id";
            }

            if ($is_split && $for_user_id) {
                $headers[] = "with-split-rule: splitru_69385a48-258d-4364-a935-832bde02f9d8";
            }

            $ch = curl_init("https://api.xendit.co/v2/invoices");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($ch);
            if ($response === false) {
                echo json_encode([
                    'success' => false,
                    'transaction_id' => $transaction_id,
                    'message' => 'Gagal connect ke Xendit'
                ]);
                return;
            }
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['id']) && !empty($result['invoice_url'])) {
                $db_oriskin->where('id', $transaction_id);
                $db_oriskin->update('transactions_apps', [
                    'payment_due' => $result['expiry_date'],
                    'invoice_url' => $result['invoice_url'],
                ]);

                echo json_encode([
                    'success' => true,
                    'transaction_id' => $transaction_id,
                    'result' => $result,
                    'invoice_url' => $result['invoice_url']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'transaction_id' => $transaction_id,
                    'message' => 'Gagal membuat invoice di Xendit',
                    'error_detail' => $result
                ]);
            }

        } catch (Exception $e) {
            $db_oriskin->trans_rollback();
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    public function toggleActive()
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $this->output->set_content_type('application/json');

        $id = $this->input->post('id');

        $account = $this->ModelPaymentApps->get_account_by_id($id);

        if (!$account) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
            return;
        }

        $newStatus = $account['isactive'] == 1 ? 0 : 1;

        $data = [
            'isactive' => $newStatus,
            'updatedby' => $this->session->userdata('userid'),
            'updatedat' => date('Y-m-d H:i:s')
        ];

        $update = $this->ModelPaymentApps->update_account($id, $data);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => "Status berhasil diubah menjadi " . ($newStatus == 1 ? 'Active' : 'Nonactive')
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => "Gagal update status",
                'db_error' => $db_oriskin->error()
            ]);
        }
        exit;
    }


    public function webhook()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $payload = json_decode($this->input->raw_input_stream, true);
        $db_oriskin = $this->load->database('oriskin', true);

        if (isset($payload['status']) && $payload['status'] === "PAID") {
            $updateData = [
                'status' => $payload['status'],
                'paid_at' => date('Y-m-d H:i:s'),
                'payment_id' => $payload['id'],
                'payment_method' => isset($payload['payment_method']) ? $payload['payment_method'] : null
            ];

            $db_oriskin->where('invoiceno', $payload['external_id']);
            $db_oriskin->update('transactions_apps', $updateData);

            $insertData = [
                'id' => $payload['id'],
                'amount' => $payload['amount'],
                'status' => $payload['status'],
                'created' => isset($payload['created']) ? $payload['created'] : date('Y-m-d H:i:s'),
                'is_high' => isset($payload['is_high']) ? (int) $payload['is_high'] : 0,
                'paid_at' => isset($payload['paid_at']) ? $payload['paid_at'] : null,
                'updated' => isset($payload['updated']) ? $payload['updated'] : null,
                'user_id' => $payload['user_id'],
                'currency' => $payload['currency'],
                'payment_id' => $payload['payment_id'],
                'description' => isset($payload['description']) ? $payload['description'] : null,
                'external_id' => $payload['external_id'],
                'paid_amount' => $payload['paid_amount'],
                'ewallet_type' => isset($payload['ewallet_type']) ? $payload['ewallet_type'] : null,
                'merchant_name' => isset($payload['merchant_name']) ? $payload['merchant_name'] : null,
                'payment_method' => isset($payload['payment_method']) ? $payload['payment_method'] : null,
                'payment_channel' => isset($payload['payment_channel']) ? $payload['payment_channel'] : null,
                'payment_method_id' => isset($payload['payment_method_id']) ? $payload['payment_method_id'] : null,
            ];

            $db_oriskin->insert('transaction_payment_detail', $insertData);
        }


        if (isset($payload['status']) && $payload['status'] === "EXPIRED") {
            $updateData = [
                'status' => $payload['status']
            ];

            $db_oriskin->where('invoiceno', $payload['external_id']);
            $db_oriskin->where('status', 'PENDING');
            $db_oriskin->update('transactions_apps', $updateData);
        }

        http_response_code(200);
        echo json_encode(["status" => "ok"]);
    }


    public function getTransactionsCustomer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelPaymentApps->getTransactionsCustomer($customerid);

        echo json_encode([
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ]);

    }

    public function getTransactionsCustomerById($id)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelPaymentApps->getTransactionsCustomerById($customerid, $id);

        echo json_encode([
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ]);

    }

    public function insertProductDirectBuy()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);
        $headers = $this->input->request_headers();

        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null || $customerid === null) {
            $response = [
                'status' => false,
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $productid = $postData["productid"] ?? null;
        $customerid = $postData["customerid"] ?? null;
        $producttypeid = $postData["producttypeid"] ?? null;
        $qty = $postData["qty"] ?? 1;

        $db_oriskin->where('customerid', $customerid)->update('customer_direct_buy', ['isactive' => 0]);

        $newCustomerProducts = [2121, 2120, 2119];
        $newCustomerProductType = 2;

        if (in_array($productid, $newCustomerProducts) && $producttypeid == $newCustomerProductType) {

            $db_oriskin->select('1', false);
            $db_oriskin->from('transactions_apps ta');
            $db_oriskin->join('transaction_details_apps td', 'td.transaction_id = ta.id');
            $db_oriskin->where('ta.customer_id', $customerid);
            $db_oriskin->where_in('td.product_id', $newCustomerProducts);
            $db_oriskin->where('td.product_type_id', $newCustomerProductType);
            $db_oriskin->where_not_in('ta.status', ['CANCELED', 'EXPIRED']);

            $result = $db_oriskin->get()->row_array();

            if ($result) {
                echo json_encode([
                    'status' => false,
                    'code' => 200,
                    'message' => 'Kamu sudah pernah membeli paket new customer offer',
                ]);
                return;
            }
        }


        $dataCreate = [
            "productid" => $productid,
            "customerid" => $customerid,
            "producttypeid" => $producttypeid,
            "qty" => $qty,
            "isactive" => 1
        ];

        if ($db_oriskin->insert("customer_direct_buy", $dataCreate)) {
            echo json_encode([
                "status" => true,
                "message" => "Berhasil menambahkan product ke keranjang",
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal menambahkan product ke keranjang",
            ]);
        }

    }

    public function getProductDirectBuy()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $headers = $this->input->request_headers();

        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null || $customerid === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required'
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found'
            ]);
            return;
        }

        $queryTreatments = $db_oriskin->query("
        	EXEC spEudoraGetCustomerCart ?, ?
    	", [$customerid, 3]);

        $result = $queryTreatments->result_array();

        echo json_encode([
            'status' => 'success',
            'data' => $result
        ]);
    }
    public function canceledPayment()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);
        $headers = $this->input->request_headers();

        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null || $customerid === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $update = $db_oriskin->where('id', $postData['id'])->update('transactions_apps', ['status' => 'CANCELED']);

        if ($update) {
            echo json_encode([
                "status" => true,
                "message" => "Berhasil membatalkan pemesanan",
            ]);
        } else {
            echo json_encode([
                "status" => false,
                "message" => "Gagal membatalkan pemesanan",
            ]);
        }

    }


    public function getCustomerSaldoHistory()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelPaymentApps->getCustomerSaldoHistory($customerid);

        echo json_encode([
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ]);

    }

    public function getCustomerSaldo()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelPaymentApps->getCustomerSaldo($customerid);

        echo json_encode([
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ]);

    }


    public function getCustomerWithdrawHistory()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $headers = $this->input->request_headers();
        $token = isset($headers['auth_token_customer']) ? $headers['auth_token_customer'] : null;
        $customerid = isset($headers['customerid']) ? $headers['customerid'] : null;

        if ($token === null) {
            $response = [
                'status' => 'error',
                'code' => 401,
                'message' => 'Authorization token is required',
                'token' => $token
            ];
            echo json_encode($response);
            return;
        }

        $is_token_valid = $this->ModelPaymentApps->validationToken($token, $customerid);

        if (!$is_token_valid) {
            echo json_encode([
                'status' => 'error',
                'code' => 401,
                'message' => 'Invalid token or customer not found',
                'token' => $token
            ]);
            return;
        }

        $data = $this->ModelPaymentApps->getCustomerWithdrawHistory($customerid);

        echo json_encode([
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ]);

    }


    public function create_payment()
    {
        $url = "https://api.xendit.co/v3/payment_requests";

        $data = [
            "reference_id" => "test-" . time(),
            "type" => "PAY",
            "country" => "ID",
            "currency" => "IDR",
            "request_amount" => 10000,
            "channel_code" => "INDOMARET",
            "channel_properties" => [
                "display_name" => "John Doe",
                "success_return_url" => "https://xendit.co/success",
                "payer_name" => 'Joko'
            ],
            "metadata" => [
                "my_custom_id" => "merchant-123"
            ]
        ];

        $payload = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKeyDev . ":");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }
        curl_close($ch);
    }


    public function getPaymentChannel()
    {
        $url = "https://api.xendit.co/payouts_channels";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKeyDev . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }

        curl_close($ch);
    }

    public function getBalanceXendit($accountId = null)
    {
        $url = "https://api.xendit.co/balance";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $headers = [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ];

        if (!empty($accountId)) {
            $headers[] = "for-user-id:$accountId";
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menghubungi API Xendit.",
                "error_detail" => $curlError
            ]);
            return;
        }

        $data = json_decode($response, true);

        if ($httpcode >= 400) {
            echo json_encode([
                "status" => "error",
                "code" => $httpcode,
                "message" => $data['message'] ?? "Terjadi kesalahan dari Xendit.",
                "response" => $data
            ]);
            return;
        }

        echo json_encode([
            "status" => "success",
            "balance" => $data['balance'] ?? 0, // kalau null, fallback ke 0
            "currency" => $data['currency'] ?? 'IDR',
            "raw" => $data
        ]);
    }


    public function getBalanceXenditMain()
    {
        $url = "https://api.xendit.co/balance";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menghubungi API Xendit.",
                "error_detail" => $curlError
            ]);
            return;
        }

        $data = json_decode($response, true);

        if ($httpcode >= 400) {
            echo json_encode([
                "status" => "error",
                "code" => $httpcode,
                "message" => $data['message'] ?? "Terjadi kesalahan dari Xendit.",
                "response" => $data
            ]);
            return;
        }

        echo json_encode([
            "status" => "success",
            "balance" => $data['balance'],
            "currency" => $data['currency'] ?? 'IDR',
            "raw" => $data
        ]);
    }

    public function saveAccount()
    {
        $post = $this->input->post();
        $user_id = $this->session->userdata('userid');

        $data = [
            'account_holder_name' => $post['account_holder_name'],
            'account_number' => $post['account_number'],
            'subaccountid' => $post['subaccountid'],
            'channel_code' => $post['channel_code'],
            'channel_name' => $post['channel_name'] ?? null,
            'createdat' => date('Y-m-d H:i:s'),
            'createdby' => $user_id
        ];

        $result = $this->ModelPaymentApps->save_account($data);
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data account!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data account!'
            ]);
        }

    }

    public function saveBankAccount()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $post = $this->input->post();
        $user_id = $this->session->userdata('userid');

        $data = [
            'account_holder_name' => isset($post['account_holder_name']) ? $post['account_holder_name'] : null,
            'account_number' => isset($post['account_number']) ? $post['account_number'] : null,
            'customerid' => isset($post['customerid']) ? $post['customerid'] : null,
            'channel_code' => isset($post['channel_code']) ? $post['channel_code'] : null,
            'channel_name' => isset($post['channel_name']) ? $post['channel_name'] : null,
            'createdat' => date('Y-m-d H:i:s')
        ];

        $result = $this->ModelPaymentApps->save_bank_account($data);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data account!'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data account!',
                'data' => $data
            ]);
        }
    }

    public function getTransactionXendit($accountId)
    {

        $json = file_get_contents("php://input");
        $postData = json_decode($json, true);
        if (!$postData) {
            $postData = $_POST;
        }

        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $date = $_GET['date'];
            $start = $date . "T00:00:00Z";
            $end = $date . "T23:59:59Z";
        } else if (isset($postData['date']) && !empty($postData['date'])) {
            $date = $postData['date'];
            $start = $date . "T00:00:00Z";
            $end = $date . "T23:59:59Z";
        } else {
            $end = gmdate("Y-m-d\TH:i:s\Z");  
            $start = gmdate("Y-m-d\TH:i:s\Z", strtotime("-30 days"));     
        }
        $url = "https://api.xendit.co/transactions?created[gte]=" . urlencode($start) . "&created[lte]=" . urlencode($end);
        error_log("XENDIT URL: " . $url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11",
            "for-user-id:$accountId"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        error_log("XENDIT HTTP CODE: " . $httpcode);
        error_log("XENDIT RESPONSE: " . $response);

        if ($response === false) {
            echo json_encode([
                "success" => false,
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }
        curl_close($ch);
    }

    public function getTransactionXenditMain()
    {
        $json = file_get_contents("php://input");
        $postData = json_decode($json, true);
        if (!$postData) {
            $postData = $_POST;
        }

        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $date = $_GET['date'];
            $start = $date . "T00:00:00Z";
            $end = $date . "T23:59:59Z";
        } else if (isset($postData['date']) && !empty($postData['date'])) {
            $date = $postData['date'];
            $start = $date . "T00:00:00Z";
            $end = $date . "T23:59:59Z";
        } else {
            $end = gmdate("Y-m-d\TH:i:s\Z");  
            $start = gmdate("Y-m-d\TH:i:s\Z", strtotime("-30 days"));     
        }
        $url = "https://api.xendit.co/transactions?created[gte]=" . urlencode($start) . "&created[lte]=" . urlencode($end);
        error_log("XENDIT URL: " . $url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11",
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        error_log("XENDIT HTTP CODE: " . $httpcode);
        error_log("XENDIT RESPONSE: " . $response);

        if ($response === false) {
            echo json_encode([
                "success" => false,
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }
        curl_close($ch);
    }


    function getPayoutChannel()
    {
        $url = "https://api.xendit.co/payouts_channels";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            $data = json_decode($response, true);

            if (is_array($data)) {
                $filtered = array_filter($data, function ($item) {
                    return isset($item['currency']) && $item['currency'] === "IDR";
                });
                $search = isset($_GET['q']) ? strtolower($_GET['q']) : '';

                if ($search !== '') {
                    $filtered = array_filter($filtered, function ($item) use ($search) {
                        return (strpos(strtolower($item['channel_name']), $search) !== false) ||
                            (strpos(strtolower($item['channel_code']), $search) !== false);
                    });
                }

                echo json_encode(array_values($filtered));
            } else {
                echo $response;
            }
        }
        curl_close($ch);
    }

    public function getTransactionXenditByDate($accountId)
    {
        $date = $this->input->get('date');
        $start_date = $date . 'T00:00:00Z';
        $end_date = $date . 'T23:59:59Z';

        $query = [];
        if (!empty($start_date)) {
            $query[] = "filter[created][gte]=" . $start_date;
        }
        if (!empty($end_date)) {
            $query[] = "filter[created][lte]=" . $end_date;
        }

        $url = "https://api.xendit.co/transactions";
        if (!empty($query)) {
            $url .= "?" . implode("&", $query);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }

        curl_close($ch);
    }


    public function getListSubAccountXendit()
    {
        $url = "https://api.xendit.co/v2/accounts?limit=50";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }
        curl_close($ch);
    }

    public function getListSubAccountXenditById($accountid)
    {
        $url = "https://api.xendit.co/v2/accounts/" . $accountid;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }
        curl_close($ch);
    }


    public function createPayout($accountid)
    {
        $url = "https://api.xendit.co/v2/payouts";
        error_reporting(0);
        ini_set('display_errors', 0);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $account = $db_oriskin->select("*")->from("msaccount")->where('subaccountid', $accountid)->get()->row_array();

        $data = [
            "reference_id" => $this->input->post("reference_id"),
            "channel_code" => $account['channel_code'],
            "channel_properties" => [
                "account_number" => $account['account_number'],
                "account_holder_name" => $account['account_holder_name']
            ],
            "amount" => (int) $this->input->post("amount"),
            "description" => $this->input->post("description"),
            "currency" => "IDR"
        ];

        $payload = json_encode($data);
        $token = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 20);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11",
            "Idempotency-key:$token",
            "for-user-id: $accountid"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
            return;
        }

        $result = json_decode($response, true);

        if (isset($result['id'])) {
            $detailUrl = "https://api.xendit.co/v2/payouts/" . $result['id'];

            $ch2 = curl_init($detailUrl);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "api-version: 2024-11-11",
                "for-user-id: $accountid"
            ]);
            curl_setopt($ch2, CURLOPT_USERPWD, $this->apiKey . ":");
            $detailResponse = curl_exec($ch2);
            curl_close($ch2);

            $detail = json_decode($detailResponse, true);

            if ($detail && isset($detail['id'])) {
                $insertData = [
                    'payout_id' => $detail['id'],
                    'reference_id' => $detail['reference_id'],
                    'business_id' => $detail['business_id'],
                    'status' => $detail['status'],
                    'accountid' => $accountid,
                    'amount' => $detail['amount'],
                    'net_amount' => $detail['net_amount'] ?? null,
                    'currency' => $detail['currency'],
                    'channel_code' => $detail['channel_code'],
                    'description' => $detail['description'],
                    'created' => $detail['created'],
                    'updated' => $detail['updated'],
                    'payout_token' => $token,
                    'estimated_arrival_time' => $detail['estimated_arrival_time']
                ];
                $insert = $db_oriskin->insert('payout_history', $insertData);

                if (!$insert) {
                    $error = $db_oriskin->error(); // ambil error dari CI
                    log_message('error', 'DB Insert Error: ' . print_r($error, true));
                    echo json_encode([
                        "status" => "db_error",
                        "error" => $error,
                        "insert_data" => $insertData
                    ]);
                    return;
                }
            }
        }

        echo json_encode([
            "status" => "success",
            "message" => "Berhasil melakukan withdraw",
            "data" => $result,
            "payout_data" => $detail
        ]);
    }

    public function approvePayoutCustomer($id)
    {
        $url = "https://api.xendit.co/v2/payouts";
        error_reporting(0);
        ini_set('display_errors', 0);

        $db_oriskin = $this->load->database('oriskin', true);

        $customer = $db_oriskin->select("*")
            ->from("customer_withdraw_history")
            ->where('id', $id)
            ->get()
            ->row_array();

        if (!$customer) {
            echo json_encode([
                "status" => "error",
                "message" => "Data customer tidak ditemukan"
            ]);
            return;
        }

        $amount = max(0, (int) $customer['withdraw_amount'] - 2500);

        $data = [
            "reference_id" => $customer["refference_id"],
            "channel_code" => $customer['channel_code'],
            "channel_properties" => [
                "account_number" => $customer['account_number'],
                "account_holder_name" => $customer['account_holder_name']
            ],
            "amount" => $amount,
            "description" => $customer['description'],
            "currency" => $customer['currency']
        ];

        $payload = json_encode($data);
        $token = $customer["refference_id"];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11",
            "Idempotency-key: $token"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false || $curlError) {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menghubungi API Xendit",
                "error_detail" => $curlError
            ]);
            return;
        }

        $result = json_decode($response, true);

        if (isset($result['error_code']) || (isset($result['status']) && $result['status'] === 'error')) {
            echo json_encode([
                "status" => "error",
                "message" => $result['message'],
                "error_code" => $result['error_code'] ?? null,
                "response" => $result
            ]);
            return;
        }

        $db_oriskin->where('id', $id)->update('customer_withdraw_history', [
            'withdraw_status' => $result['status'] ?? 'PENDING',
            'updatedat' => date('Y-m-d H:i:s'),
            'payout_id' => $result['id'] ?? null,
            'net_amount' => $amount
        ]);

        echo json_encode([
            "status" => "success",
            "message" => "Berhasil melakukan approve withdraw customer",
            "data" => $result
        ]);
    }

    public function getAccountByAccountId($accountid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $account = $db_oriskin
            ->select("*")
            ->from('msaccount')
            ->where('subaccountid', $accountid)
            ->get()
            ->result_array();


        if ($account) {
            echo json_encode([
                "status" => "success",
                "message" => "Berhasil menampilkan data",
                "data" => $account
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menampilkan data"
            ]);
        }
    }

    public function getAllBankAccount()
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $account = $db_oriskin
            ->select("*")
            ->from('bank_account')
            ->get()
            ->result_array();

        if ($account) {
            echo json_encode([
                "status" => "success",
                "message" => "Berhasil menampilkan data",
                "data" => $account
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menampilkan data"
            ]);
        }
    }

    public function getBankAccountByCustomerId($customerid)
    {
        error_reporting(0);
        ini_set('display_errors', 0);
        $db_oriskin = $this->load->database('oriskin', true);
        $account = $db_oriskin
            ->select("*")
            ->from('bank_account')
            ->where('customerid', $customerid)
            ->get()
            ->result_array();


        if ($account) {
            echo json_encode([
                "status" => "success",
                "message" => "Berhasil menampilkan data",
                "data" => $account
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Gagal menampilkan data"
            ]);
        }
    }

    public function payoutWebhook()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $rawPayload = $this->input->raw_input_stream;
        $payload = json_decode($rawPayload, true);
        $db_oriskin = $this->load->database('oriskin', true);
        
        if (!isset($payload['data']) || !isset($payload['data']['id'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid payload']);
            return;
        }

        $data = $payload['data'];

        if (isset($data['reference_id']) && strpos($data['reference_id'], 'WITHDRAW_CUSTOMER_') !== false) {
            $referenceId = $data['reference_id'];
            $updateWithdraw = [
                'withdraw_status'        => $data['status'] ?? null,
                'updatedat'              => $data['updated'] ?? date('Y-m-d H:i:s'),
                'failure_code'           => $data['failure_code'] ?? null,
                'paid_at'                => $data['paid_at'] ?? null
            ];

            $db_oriskin->where('refference_id', $referenceId);
            $db_oriskin->update('customer_withdraw_history', $updateWithdraw);
        }else{
            $updateData = [
                'status'        => $data['status'] ?? null,
                'updated'       => $data['updated'] ?? date('Y-m-d H:i:s'),
                'failure_code'  => $data['failure_code'] ?? null,
                'paid_at'       => $data['paid_at'] ?? null,
                'net_amount'    => $detail['net_amount'] ?? null,
            ];

            $db_oriskin->where('payout_id', $data['id']);
            $db_oriskin->update('payout_history', $updateData);
        }

        http_response_code(200);
        echo json_encode(['status' => 'ok']);
    }

    public function cancelPayout($accountid, $referenceid)
    {
        $url = "https://api.xendit.co/v2/payouts/$payoutid/cancel";
        error_reporting(0);
        ini_set('display_errors', 0);
        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);
        $db_oriskin = $this->load->database('oriskin', true);

        $account = $db_oriskin->select("*")->from("msaccount")->where('subaccountid', $accountid)->get()->row_array();

        $data = [
            "reference_id" => "myref-" . time(),
            "channel_code" => $account['channel_code'],
            "channel_properties" => [
                "account_number" => $account['account_number'],
                "account_holder_name" => $account['account_holder_name']
            ],
            "amount" => (int) $this->input->post("amount"),
            "description" => $this->input->post("description"),
            "currency" => "IDR"
        ];

        $payload = json_encode($data);
        $token = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 20);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "api-version: 2024-11-11",
            "Idempotency-key:$token",
            "for-user-id: $accountid"
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            echo json_encode([
                "error" => curl_error($ch)
            ]);
        } else {
            echo $response;
        }

        curl_close($ch);
    }

    public function cancelPayoutCustomer($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        $customer = $db_oriskin->select("*")->from("customer_withdraw_history")->where('id', $id)->get()->row_array();
    
        if($customer['withdraw_status'] == 'PENDING'){
            $updated = $db_oriskin->where('id', $id)
                      ->update('customer_withdraw_history', ['withdraw_status' => 'CANCELED']);

            if ($updated) {
                    echo json_encode([
                    "status"=>'succes',
                    "message" => "Berhasil membatalkan pengajuan!"
                ]);
            } else {
                    echo json_encode([
                    "status"=>'error',
                    "message" => "Withdraw telah success,tidak bisa membatalkan proses withdraw"
                ]);
            }
            
        }else if($customer['withdraw_status']== "ACCEPTED"){
            $payoutid = $customer['payout_id'];

            $url = "https://api.xendit.co/v2/payouts/$payoutid/cancel";

            error_reporting(0);
            ini_set('display_errors', 0);
            $json = file_get_contents('php://input');
            $postData = json_decode($json, true);
            
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "api-version: 2024-11-11",
                "Idempotency-key:$payoutid"
            ]);
            curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ":");
            curl_setopt($ch, CURLOPT_POST, true);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($response === false) {
                echo json_encode([
                    "status"=>'error',
                    "message" => curl_error($ch)
                ]);
            } else {
                echo $response;
            }

            curl_close($ch);
        }else{
            echo json_encode([
                    "status"=>'error',
                    "message" => "Gagal membatalkan pengajuan!"
                ]);
        }

        
    }

    public function updateAccount()
    {
        $post = $this->input->post();

        if (!$post['id']) {
            echo json_encode(["success" => false, "message" => "ID tidak boleh kosong"]);
            return;
        }

        $updateData = [
            "account_holder_name" => $post['account_holder_name'],
            "account_number" => $post['account_number'],
            "locationid" => $post['locationid'],
            "channel_code" => $post['channel_code'],
            "updatedat" => date("Y-m-d H:i:s"),
            "updatedby" => 1
        ];

        $this->db_oriskin->where("id", $post['id']);
        $ok = $this->db_oriskin->update("msaccount", $updateData);

        if ($ok) {
            echo json_encode(["success" => true, "message" => "Berhasil update account"]);
        } else {
            echo json_encode(["success" => false, "message" => "Gagal update account"]);
        }
    }

    public function getAccountById($id)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        try {
            $account = $db_oriskin
                ->select("*")
                ->from("msaccount")
                ->where('id', $id)
                ->get()
                ->row_array();

            if ($account) {
                echo json_encode([
                    "success" => true,
                    "message" => "Berhasil ambil data",
                    "data" => $account
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Data account tidak ditemukan"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "message" => "Error: " . $e->getMessage()
            ]);
        }
    }

    public function getPayoutHistory($accountid)
    {
        $db_oriskin = $this->load->database('oriskin', true);
        try {
            $account = $db_oriskin
                ->select("*")
                ->from("payout_history")
                ->where("accountid", $accountid)
                ->order_by("id", "DESC")
                ->get()
                ->result();

            if ($account) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Berhasil ambil data",
                    "data" => $account
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Data account tidak ditemukan"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "success",
                "message" => "Error: " . $e->getMessage()
            ]);
        }
    }

    public function createPayoutCustomer()
    {
        error_reporting(0);
        ini_set('display_errors', 0);

        $json = file_get_contents('php://input');
        $postData = json_decode($json, true);

        $refference_id = "WITHDRAW_CUSTOMER_" . date("YmdHis");

        $data = [
            "refference_id" => $refference_id,
            "channel_code" => $postData['channel_code'],
            "account_number" => $postData['account_number'],
            "account_holder_name" => $postData['account_holder_name'],
            "withdraw_amount" => (int) $postData['amount'],
            "description" => "Withdraw customer",
            "currency" => "IDR",
            "customer_id" => $postData['customer_id'],
            "withdraw_status" => "PENDING",
            "request_date" => date('Y-m-d H:i:s')
        ];

        $result = $this->ModelPaymentApps->createPayoutCustomer($data);

        if ($result) {
            try {
                $user = $db_oriskin->where('id', 55)->get('msuser')->row_array();

                if ($user) {
                    $token   = bin2hex(random_bytes(32));
                    $expired = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                    $db_oriskin->insert('user_token', [
                        'userid'       => 55,
                        'magic_token'  => $token,
                        'expired_time' => $expired,
                        'createdby'    => $userid ?? null,
                    ]);
                    $magic_link = base_url('magic_login?token=' . $token . '&redirect=listCustomerWithdraw');
                    $data = [
                        "recipient_type" => "individual",
                        "to" => "6281528440883",
                        "type" => "text",
                        "text" => [
                            "body" => "Halo,\n\nAda permintaan approval withdraw customer terbaru.\n\nKlik link berikut untuk melakukan approval:\n{$magic_link}."
                        ]
                    ];
                    $this->sendNotif($data);
                }

            } catch (Throwable $e) {
                log_message('error', 'Error dalam proses kirim magic link: ' . $e->getMessage());
            }
            echo json_encode([
                "status" => "success",
                "message" => "Berhasil melakukan withdraw",
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data gagal di insert',
            ]);
        }

    }

    public function getPayoutCustomer()
    {
        $date = $this->input->get('date') ?? null;
        try {
            $data = $this->ModelPaymentApps->getAllPayoutCustomers($date);

            if ($data) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Berhasil ambil data",
                    "data" => $data
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Data account tidak ditemukan"
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "status" => "success",
                "message" => "Error: " . $e->getMessage()
            ]);
        }
    }

}


