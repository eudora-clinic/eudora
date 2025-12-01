<?php
# Penambahan select option job dan location
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);
$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($datestart . " +1 day")));
$period = (isset($_GET['period']) ? $this->input->get('period') : date('Y-m'));
?>

<div class="card shadow mb-4" style="margin-left:20px; margin-right:20px;">
	<div class="card-body">
		<h4 class="card-title mb-3">LC With One Membership Active</h4>


		<?php
		# display error
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		# unlimited time
		ini_set('max_execution_time', -1);
		ini_set('memory_limit', '-1');
		// Setting memory limit sql server to 512M
		ini_set('sqlsrv.ClientBufferMaxKBSize', '524288');
		ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');
		# dibuat langsung di view untuk memudahkan
		# tidak dibuat di model
		$locationid = $this->session->userdata('locationid');
		$userid = $this->session->userdata('userid');
		$date = $datestart;
		$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($date . " +1 day")));



		# dipindahkan ke atas biar terbaca saat pertama load
		//$datestart = $this->input->get('datestart');
		//$dateend = $this->input->get('dateend');
		# load database oriskin (lihat di config/database.php)
		$db_oriskin = $this->load->database('oriskin', true);
		# query
		$query = $db_oriskin->query("SELECT
                    a.id,
                    a.locationid AS LOCATIONID,
                    c.name AS LOCATIONNAME,
                    a.customerid AS CUSTOMERID,
                    b.firstname + (CASE WHEN b.lastname IS NULL THEN '' ELSE ' ' + b.lastname END) AS CUSTOMERNAME,
                    b.cellphonenumber AS CELLPHONENUMBER,
                    a.period AS PERIOD,
                    a.remarks AS REMARKS
                    FROM sllcwithonemembershipactive a INNER JOIN mscustomer b ON a.customerid = b.id
                    INNER JOIN mslocation c ON a.locationid = c.id
                    WHERE a.period = '" . $period . "' AND a.locationid = '" . $locationid . "'");
		$header = $query->result_array();
		?>


		<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
			<div class="form-row mt-9">
				<div class="form-group col-md-3">
					<div class="form-group bmd-form-group">
						<label>PERIOD</label>
						<input type="month" id="period" name="period" class="form-control" required="true"
							aria-required="true" placeholder="" value="<?= $period ?>">
					</div>
				</div>
			</div>
			<button type="submit" name="submit" class="btn-sm btn-outline-primary" style="width: 150px; height:100%;"
				value="true">Cari</button>
		</form>

		<div class="tab-content">
			<div class="card-body">

				<div class="table-responsive">
					<table class="table table-bordered table-responsive-xl" id="example" width="100%" cellspacing="0">
						<thead style="background-color: #00BCD4; color: white;">
							<tr>
								<th width="60px" class="text-center">No</th>
								<th width="100px" class="first-col text-center sticky-col">CLINIC</th>
								<th width="70px" class="text-center">CUSTOMERID</th>
								<th width="70px" class="text-center">CUSTOMERNAME</th>
								<th width="70px" class="text-center">CELLPHONENUMBER</th>
								<th width="70px" class="text-center">WA</th>
								<th width="50px" class="text-center">PERIOD</th>
								<th width="200px" class="text-center">REMARKS</th>
								<th width="20px" class="text-center">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (isset($header)) {
								$no = 0;
								foreach ($header as $v) {
									$cellphonenumber = preg_replace('/\D/', '', $v['CELLPHONENUMBER']);
									$country_code = '62';
									$new_number = substr_replace($cellphonenumber, '+' . $country_code, 0, ($cellphonenumber[0] == '0'));
									echo
										'<tr>
                                <td class="text-center">
									<span id="no-' . $v['id'] . '">' . ++$no . '</span>
								</td>
                                <td class="text-center">' . $v['LOCATIONNAME'] . '</td>

                                <td class="text-center">
                                    <span id="sp-customerid-' . $v['id'] . '">' . $v['CUSTOMERID'] . '</span>
                                    <input type="date" id="edit-customerid-' . $v['id'] . '" value="' . $v['CUSTOMERID'] . '" style="width: 100px; display: none;">
                                </td>
                                <td class="text-center">' . $v['CUSTOMERNAME'] . '</td>
                                <td class="text-center">' . $v['CELLPHONENUMBER'] . '</td>
                                    <td style="text-align: center; vertical-align: middle;">
										<a href="https://wa.me/<?php echo $new_number; ?>">
											<i class="fa-brands fa-whatsapp fa-beat-fade fa-2xl"></i>
										</a>
									</td>

                                <td class="text-center">' . $v['PERIOD'] . '</td>

                                <td class="text-center">
                                    <span id="sp-remarks-' . $v['id'] . '">' . $v['REMARKS'] . '</span>
                                    <input type="text" id="edit-remarks-' . $v['id'] . '" value="' . $v['REMARKS'] . '" style="display: none;">
                                </td>

								<td class="text-center">
								<div class="btn-group">
									<button class="btn btn-sm btn-info" id="btn-edit-header-' . $v['id'] . '" onclick="editRow(' . $v['id'] . ');">Edit</button>
								<button class="btn btn-sm btn-info" id="btn-save-header-' . $v['id'] . '" style="display: none;" onclick="saveRow(' . $v['id'] . ');">Save</button>
								</div>

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
	</div> <!-- end card-body-->
</div>


<script>
	// fungsi untuk format angka jadi 999,999.00 atau 999.999,00
	var numberFormat = function (number, decimals, dec_point, thousands_sep) {


		number = (number + '')
			.replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + (Math.round(n * k) / k)
					.toFixed(prec);
			};

		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
			.split('.');

		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}

		if ((s[1] || '')
			.length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1)
				.join('0');
		}

		return s.join(dec);
	}
</script>


<script>
	$(document).ready(function () {
		$('#example').DataTable({
			dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
			buttons: [
				{
					extend: 'pdfHtml5',
					title: 'Data Doing Verification',
					className: 'btn-danger',
					orientation: 'landscape',
					pageSize: 'LEGAL',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6]
					},

				}, 'excel'
			]
		});
	});
</script>


<script>
	function editRow(id) {
		$('#sp-remarks-' + id).hide();
		$('#btn-edit-header-' + id).hide();

		$('#edit-remarks-' + id).show();
		$('#btn-save-header-' + id).show();
	}


	function saveRow(id) {
		const remarks = $('#edit-remarks-' + id).val();

		// Perbarui data pada tabel trdoingtreatment
		$.ajax({
			type: 'POST',
			url: "<?= base_url('save-remarks-one-membership-active') ?>", // Gantilah URL ke yang sesuai
			data: {
				id: id,
				remarks: remarks
			},
			success: function (response) {
				if (response === 'Success') {
					// Jika pembaruan berhasil, perbarui tampilan di halaman
					$('#sp-remarks-' + id).text(remarks);

					$('#sp-remarks-' + id).show();
					$('#btn-edit-header-' + id).show();

					$('#edit-remarks-' + id).hide();
					$('#btn-save-header-' + id).hide();
				} else {
					// Handle error jika pembaruan gagal
					alert('Gagal menyimpan data. Silakan coba lagi.');
				}
			}
		});
	}
</script>