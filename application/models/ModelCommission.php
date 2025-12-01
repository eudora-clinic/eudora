<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelCommission extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db_oriskin = $this->load->database('oriskin', true);
    }

    public function getCommissionSubscription($period)
    {
        $sql = "SELECT 
                c.name AS employeename, 
                c.nip AS nip,
                a.invoiceno, 
                CONVERT(VARCHAR(7), a.invoicedate, 120) AS invoicedate, 
                e.name AS item,
                d.firstname + ' ' + d.lastname AS customername,
                f.name as locationname,
                CASE 
                    WHEN b.productmembershiphdrid = 2028 THEN 250000
                    WHEN b.productmembershiphdrid = 2029 THEN 500000
                    WHEN b.productmembershiphdrid = 2030 THEN 800000
                    ELSE 0
                END AS commission
            FROM slinvoicemembershiphdr a 
            INNER JOIN slinvoicemembershipdtl b ON a.id = b.id 
            INNER JOIN msemployee c ON a.salesid = c.id
            INNER JOIN mscustomer d ON a.customerid = d.id
            INNER JOIN msproductmembershiphdr e ON b.productmembershiphdrid = e.id
            INNER JOIN mslocation f ON a.locationsalesid = f.id
            WHERE 
                CONVERT(VARCHAR(7), a.invoicedate, 120) = ?
                AND b.productmembershiphdrid IN (2028, 2029, 2030)
                AND a.status = 2";

        return $this->db_oriskin->query($sql, [$period])->result_array();
    }

    public function getReportCommissionPerInvoice($dateStart, $dateEnd, $userid, $type)
    {
        $query = "Exec SpEudoraCommissionPerInvoice   ?, ?, ?, ?";
        return $this->db_oriskin->query($query, [$dateStart, $dateEnd, $userid, $type])->result_array();
    }
}
