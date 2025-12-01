<style>
	.hidden-input {
		position: absolute;
		top: -9999px;
		left: -9999px;
		border: none;
		padding: 0;
		background: transparent;
	}

	/*sementara hanya berjalan di firefox*/
	.bootstrap-select>.dropdown-toggle.bs-placeholder,
	.bootstrap-select>.dropdown-toggle.bs-placeholder:active,
	.bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
	.bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
		color: #fff;
	}

	.table {
		table-layout: fixed;
		min-width: auto;

	}

	.table-wrapper {
		overflow-x: scroll;
		overflow-y: scroll;
		width: 100%;
		height: 100%;
		max-height: 100%;
		margin-top: 20px;
	}

	.table-wrapper table thead {
		position: -webkit-sticky;
		position: sticky;
		background-color: #f5f5f5;
		top: 0;
		z-index: 90;
	}

	.first-col {
		left: 0;
	}

	.second-col {
		left: 112px;
	}

	.sticky-col {
		position: -webkit-sticky;
		position: sticky;
		background-color: #f5f5f5;
	}

	.table-wrapper::-webkit-scrollbar {
		-webkit-appearance: none;
		width: 6px;
	}

	::-webkit-scrollbar-thumb {
		border-radius: 4px;
		background-color: rgba(0, 0, 0, .5);
		-webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
	}

	@page {
		size: auto;
	}
</style>
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

$db_oriskin = $this->load->database('oriskin', true);
$locationid = $this->session->userdata('locationid');
$userid = $this->session->userdata('userid');
$currentMonth = date('Y-m');
$db_oriskin = $this->load->database('oriskin', true);
$query = $db_oriskin->query("EXEC [spReportCallApptDetailPotential]  '" . $currentMonth . "','" . $locationid . "' ");
$header = $query->result_array();
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="card">
				<div class="card-header card-header-primary">
					<h4 class="card-title">CALL APPT POTENTIAL LEAVER</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<!--<table id="dt-realisasi" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid">-->
						<table id="example" class="table text-center table-bordered" style="width:100%">
							<thead class="thead-danger">
								<tr role="">
									<th width="60px" class="text-center">Cust. ID</th>
									<th width="150px" class="text-center">Name</th>
									<th width="150px" class="text-center">Cellphonenumber</th>
									<th width="150px" class="text-center">Whatsapp</th>

									<th width="90px" class="text-center">LastDoing</th>
									<th width="260px" class="text-center">Last Treatment</th>
									<th width="200px" class="text-center">Status</th>
									<th width="260px" class="text-center">Appt</th>
									<th width="250px" class="text-center">Follow Up</th>
									<th width="250px" class="text-center">Call Date</th>
									<th width="420px" class="text-center">Action</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if (isset($header)) {
									foreach ($header as $v) {
										$dateString =  explode('-', substr($v['LASTDOING'], 0, 10));
										$treatmentdate = $v['LASTDOING'] ? $dateString[2] . '-' . $dateString[1] . '-' . $dateString[0] : 'NAN';
										
										//$note = $db_oriskin->query("SELECT ISNULL(remarks, '') AS note FROM slpotential_note WHERE CUSTOMERID = '" . $v['CUSTOMERID'] . "'")->row()->note ?? '';
										//$calldate = $db_oriskin->query("SELECT ISNULL(calldate, '') AS calldate FROM slpotential_note WHERE CUSTOMERID = '" . $v['CUSTOMERID'] . "'")->row()->calldate ?? '';

										$note = $db_oriskin->query("SELECT ISNULL(remarks, '') AS note FROM sllcwithonemembershipactive WHERE CUSTOMERID = '" . $v['CUSTOMERID'] . "'")->row()->note ?? '';
										$calldate = $db_oriskin->query("SELECT ISNULL(calldate, '') AS calldate FROM sllcwithonemembershipactive WHERE CUSTOMERID = '" . $v['CUSTOMERID'] . "'")->row()->calldate ?? '';

										// Periksa apakah calldate adalah 1900-01-01 dan kosongkan jika ya
										if ($calldate == '1900-01-01') {
											$calldate = '';
										}

										$cellphonenumber = preg_replace('/\D/', '', $v['CELLPHONENUMBER']);
										$country_code = '62';
										$new_number = substr_replace($cellphonenumber, '+' . $country_code, 0, ($cellphonenumber[0] == '0'));
										echo
										'<tr>
											<td class="irst-col sticky-col">' . $v['CUSTOMERID'] . '</td>
											<td class="text-center">' . $v['LCNAME'] . '</td>
											<td class="text-center">' . $v['CELLPHONENUMBER'] . '</td>
											<td class="text-center">
                                                <a href="https://wa.me/' . $new_number . '" >
                                                    <i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i>
                                                </a>
                                            </td>
											
											<td class="text-center">' . $v['LASTDOING'] . '</td>
											<td class="text-center">' . $v['LASTTREATMENT'] . '</td>
											<td class="text-center">' . $v['STATUSMEMBER'] . '</td>
											<td class="text-center">' . $v['APPTDATE'] . '</td>
											<td class="text-center">
												<span data-id="' . $v['CUSTOMERID'] . '" class="spn-note" style="display: block;">' . $note . '</span>
												<button data-id="' . $v['CUSTOMERID'] . '" class="btn btn-sm btn-danger btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
												<textarea data-id="' . $v['CUSTOMERID'] . '" class="txt-note" style="display: none;width:250px" >' . $note . '</textarea>
												<button data-id="' . $v['CUSTOMERID'] . '" class="btn btn-sm btn-danger btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>
											</td>
											<td class="text-center">' . $calldate . '</td>
											<td class="text-center">
												<a class="btn btn-primary" href="https://app.oriskin.co.id:84/historymember/erm_ref/' . $v['CUSTOMERID'] . '" role="button">Detail</a>
												<a class="btn btn-primary" href="https://app.oriskin.co.id:84/operationalclinic/list_booking" role="button" target="_blank">Booking</a>
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
		<!-- end content-->
	</div>
	<!--  end card  -->
</div>
<!-- end col-md-12 -->
</div>
<!-- end row -->
</div>
<script>
	// fungsi untuk format angka jadi 999,999.00 atau 999.999,00
	var numberFormat = function(number, decimals, dec_point, thousands_sep) {
		number = (number + '')
			.replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			s = '',
			toFixedFix = function(n, prec) {
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
	var locationid = "<?= $locationid ?>";
	var period = "<?= $currentMonth ?>";
	$(document).ready(function() {
		$(".btn-edit").each(function(index) {
			$(this).on("click", function() {
				let id = $(this).data('id');
				//alert('edit '+id);
				$(this).hide();
				$(this).parent().find('.spn-note').hide();

				$(this).parent().find('.txt-note').show();

				$(this).parent().find('.btn-save').show();
			});
		});

		$(".btn-save").each(function(index) {
			$(this).on("click", function() {
				let id = $(this).data('id');
				//alert('save '+id);
				let note = $(this).parent().find('.txt-note').val();
				let calldate = $(this).parent().find('.txt-calldate').val();


				$.post("<?= base_url('save-note-followup-doing-potential') ?>", {
					customerid: id,
					note: note,
					period: period,
					locationid: locationid,
					calldate: calldate
				}, function(res) {

				}).done(function(res) {
					console.log(res);
				}).fail(function() {
					console.log("error");
				});

				$(this).parent().find('.spn-note').html(note);
				$(this).hide();
				$(this).parent().find('.txt-note').hide();

				$(this).parent().find('.spn-note').show();

				$(this).parent().find('.btn-edit').show();
			});
		});
	});
</script>


<script>
	$(document).ready(function() {
		$('#example').DataTable({
			dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
			order: [[8, 'desc']],
			buttons: [{
				extend: 'pdfHtml5',
				title: 'Data Call Last Doing 21 Days',
				className: 'btn-danger',
				orientation: 'landscape',
				pageSize: 'A2',
				exportOptions: {
					columns: [0, 1, 2, 3, 5, 6, 7, 8, 10],
				}
			}, 'excel'],
		});
	});
</script>