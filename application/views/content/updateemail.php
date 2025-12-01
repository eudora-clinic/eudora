<style>
thead th {
    font-weight: bold;
}
</style>

<?php
ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	# unlimited time
	ini_set('max_execution_time', -1);
	ini_set('memory_limit', '-1');
	 // Setting memory limit sql server to 512M
	ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
	ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
	# Penambahan select option job dan location
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$location_list = $db_oriskin->query("select id, name from mslocation where isactive='true' order by id")->result_array();
    $location = (isset($_GET['locationid']) ? $this->input->get('locationid') : 2);
    $customerid = $db_oriskin->query("select id from mscustomer")->result_array();
?>


<div class="card shadow mb-4" style="margin-left:20px; margin-right:20px;">
                <div class="card-body">
                    <h4 class="card-title mb-3">Master Data Customer</h4>

<form class="form-group" method="get" action="<?= current_url() ?>">
  <div class="form-group">
    <input type="number" name="id" class="form-control"  value="<?= (isset($_GET['id']) ? $_GET['id'] : '') ?>"
    id="exampleInputEmail1" aria-describedby="id" placeholder="Enter Customer ID">
    <small id="id" class="form-text text-muted">Masukkan ID Cust.</small>
  </div>
  <button type="submit" name="submit" value="true" class="btn btn-primary">Submit</button>
</form>

<div id="result" style="display: <?= (isset($_GET['submit']) ? 'block;' : 'none;') ?>">
<?php
if (isset($_GET['submit'])) {
    $id = $this->input->get('id');
    # Load database oriskin (lihat di config/database.php)
    $db_oriskin = $this->load->database('oriskin', true);

    # Query untuk mengambil data dari mscustomer berdasarkan customer ID
    $query = $db_oriskin->query("SELECT a.id, a.firstname, a.lastname, a.ssid, a.locationid, CONVERT(VARCHAR(10),a.dateofbirth,120) AS dateofbirth,
																a.cellphonenumber, a.email, a.address
																FROM mscustomer a
                                                                WHERE a.id = '$id' ")->result_array();

    # Query untuk mengambil data dari slinvoicemembershiphdr dan slinvoicemembershipdtl berdasarkan customer ID
    $membershipdtl = $db_oriskin->query("SELECT
        a.id AS LOCATIONID,
        a.name AS LOCATIONNAME,
        b.id AS CUSTOMERID,
        b.firstname + (CASE WHEN b.lastname IS NULL THEN '' ELSE ' ' + b.lastname END) AS LCNAME,
        b.dateofbirth AS DATEOFBIRTH,
        c.invoiceno AS INVOICENO,
        MAX(c.invoicedate) AS INVOICEDATE,
        e.name AS MEMBERSHIPNAME,
        d.totalmonth AS TOTALMONTH,
        d.totalamount AS TOTALAMOUNT,
        MAX(f.treatmentdate) AS LASTDOING
        FROM slinvoicemembershiphdr c
        INNER JOIN slinvoicemembershipdtl d ON c.id = d.id
        INNER JOIN msproductmembershiphdr e ON d.productmembershiphdrid = e.id
        INNER JOIN mscustomer b ON c.customerid = b.id
        INNER JOIN mslocation a ON c.locationsalesid = a.id
        LEFT JOIN trdoingtreatment f ON b.id = f.customerid
        WHERE e.name NOT LIKE '%STOP CARD%' AND e.name NOT LIKE '%PROMO MARKETING%' AND b.id = '$id' AND c.status=2
        AND a.name NOT LIKE'%NEW TRIX%' AND a.isactive='true'
        GROUP BY
        a.id,
        a.name,
        b.id,
        b.firstname + (CASE WHEN b.lastname IS NULL THEN '' ELSE ' ' + b.lastname END),
        b.dateofbirth,
        c.invoiceno,
        e.name,
        d.totalmonth,
        d.totalamount")->result_array();


    if (empty($query)) {
        echo '<div class="alert alert-danger" role="alert">
            <i class="dripicons-wrong mr-2"></i> Customer ID <strong>' . $id . '</strong> tidak ditemukan!
        </div>';
    } else {
        $header = $query;
    }

}
?>


            <div class="card shadow mb-4" style="margin-left:20px; margin-right:20px;">
                <div class="card-body">
                    <h4>Detail Customer</h4>
                    	<ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                            <li class="nav-item">
                                <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-none d-lg-block" style="color: black">Customer</span>
                                </a>
                            </li>
                        </ul>

            <div class="tab-content">
                <div class="tab-pane show active" id="home-b2">
					<div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive-xxl" width="130%" cellspacing="0">
                                    <thead style="background-color: #9C27B0; color: white;">
                                        <tr>
                                            <th><strong>ID</strong></th>
                                            <th><strong>Firstname</strong></th>
                                            <th><strong>Lastname</strong></th>
                                            <th><strong>Ssid</strong></th>
                                            <th><strong>Address</strong></th>
                                            <th><strong>Date of Birth</strong></th>
                                            <th><strong>LocationID</strong></th>
                                            <th><strong>Cellphonenumber</strong></th>
                                            <th><strong>Email</strong></th>
                                            <th><strong>Action</strong></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if (isset($header)) {
                                            foreach ($header as $v)
                                                {
                                                echo
                                        '<tr>
                                            <td class="text-center">
                                                <span id="sp-id-'.$v['id'].'">'.$v['id'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-firstname-'.$v['id'].'">'.$v['firstname'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-lastname-'.$v['id'].'">'.$v['lastname'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-ssid-'.$v['id'].'">'.$v['ssid'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-address-'.$v['id'].'">'.$v['address'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-dateofbirth-'.$v['id'].'">'.$v['dateofbirth'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-locationid-'.$v['id'].'">'.$v['locationid'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-cellphonenumber-'.$v['id'].'">'.$v['cellphonenumber'].'</span>
                                            </td>
                                            <td class="text-center">
                                                <span id="sp-email-'.$v['id'].'">'.$v['email'].'</span>
                                                <input type="email" id="email-'.$v['id'].'" value="'.$v['email'].'" style="width: 250px; display: none;">
                                            </td>

                                            <td class="text-center">
                                                <button id="btn-edit-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="editHeader(&apos;'.$v['id'].'&apos;, event);" ><i class="material-icons" >edit</i></button>
                                                <button id="btn-save-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="saveHeader(&apos;'.$v['id'].'&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save</button>
                                            </td>
                                        </tr>';
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                        

                    </div>
				</div> <!-- end card-body-->
            </div>

</div>
</div>

<script>
	//_mod dideklarasikan di initapp.js
	_mod = '<?=$mod?>';

	function editHeader(_id, e) {
		e.preventDefault();
    $('#sp-email-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();

    $('#email-'+_id).val($('#sp-email-'+_id).html());

    $('#email-'+_id).show();

		$('#btn-save-header-'+_id).show();
	}

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');

		if (_confirm) {
      var _email = $('#email-'+_id).val();


			$.post(_HOST+'App/updateCustomerEmail', {id:_id,email:_email},
            function(result) {
				alert(result);
				location.reload();
			});
		} else {
      $('#sp-email-'+_id).show();
			$('#btn-edit-header-'+_id).show();

      $('#email-'+_id).hide();
			$('#btn-save-header-'+_id).hide();
		}
	}


</script>
