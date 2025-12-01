<style>
		/*sementara hanya berjalan di firefox*/
		.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
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
		left: 0;
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
		background-color: rgba(0,0,0,.5);
		-webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
	}
	@page {
		size: auto;
	}
</style>

<?php
	# Penambahan select option job dan location
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	$date = date('Y-m-d');
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date( "Y-m-d", strtotime( $date . "-0 day")));
	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date( "Y-m-d", strtotime( $date . "-0 day")));
	$period = (isset($_GET['period']) ? $this->input->get('period') : date('Y-m'));
	$locationid = $this->session->userdata('locationid');
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-info">
            		<h4 class="card-title">Report Detail New LC All Clinic</h4>
        		</div>
				<div class="card-body">

					<div class="toolbar">
						<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="form-row mt-2">
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
										<label >Period</label>
										<input type="month" id="period" name="period" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $period ?>">
									</div>
								</div>

								<button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info mt-4" value="true" ><i ></i> Search</button>
							</div>
						</form>
					</div>
					<div>
						<?php
							# dibuat langsung di view untuk memudahkan
							# tidak dibuat di model

							// $locationid = $this->session->userdata('locationid');
							# dipindahkan ke atas biar terbaca saat pertama load
							//$datestart = $this->input->get('datestart');
							//$dateend = $this->input->get('dateend');

							# load database oriskin (lihat di config/database.php)
							$db_oriskin = $this->load->database('oriskin', true);

							# query
							$query = $db_oriskin->query("EXEC spReportDetailNewLCAllClinicVsDoingV2 '".$period."', '".$locationid."'");

								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");



						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="" class="bg-info text-white">
										<th width="100px" class="text-center">CLINIC</th>
										<th width="100px" class="text-center">INVOICENO</th>
										<th width="100px" class="text-center">ID</th>
										<th width="90px" class="text-center">SALES</th>

										<th width="100px" class="text-center">LCNAME</th>
                    <th width="100px" class="text-center">CELLPHONE</th>
                    <th width="100px" class="text-center">WHATSAPP</th>
										<th width="200px" class="text-center">MEMBERSHIP</th>
										<th width="75px" class="text-center">AMOUNT</th>
										<th width="100px"class="text-center">DATE JOIN</th>
										<th width="100px" class="text-center">FIRST DOING</th>
										<th width="100px" class="text-center">LAST DOING</th>
										<th width="100px" class="text-center">TRIAL</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												foreach ($header as $v)
													 {
                             $cellphonenumber = preg_replace('/\D/', '',  $v['CELLPHONENUMBER']);
                             $country_code = '62';
                             $new_number = substr_replace($cellphonenumber, '+'.$country_code, 0, ($cellphonenumber[0] == '0'));
													echo '<tr>
												<td class="First-col sticky-col">'.$v['LOCATIONNAME'].'</td>
												<td class="Second-col sticky-col">'.$v['INVOICENO'].'</td>
												<td class="text-center">'.$v['CUSTOMERID'].'</td>
												<td class="text-center">'.$v['SALESNAME'].'</td>
												<td class="text-center">'.$v['LCNAME'].'</td>
                        <td class="text-center">'.$v['CELLPHONENUMBER'].'</td>
                        <td class="text-center"><a href="https://wa.me/' . $new_number . '" ><i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i></a></td>
												<td class="text-center">'.$v['MEMBERSHIPNAME'].'</td>
												<td class="text-center">'. number_format($v['TOTALAMOUNT'], 0, '.', ',') .'</td>
												<td class="text-center">'.$v['INVOICEDATE'].'</td>
												<td class="text-center"';
												if ($v['FIRSTDOING'] == 'NO DOING') {
														echo ' style="color: red;"';
												} elseif (strtotime($v['FIRSTDOING']) !== false) {
														echo ' style="color: green;"';
												}
												echo '>' . $v['FIRSTDOING'] . '</td>
														<td class="text-center"';
												if ($v['LASTDOING'] == 'NO DOING') {
														echo ' style="color: red;"';
												} elseif (strtotime($v['LASTDOING']) !== false) {
														echo ' style="color: green;"';
												}
												echo '>' . $v['LASTDOING'] . '</td>

												<td class="text-center"';
												if ($v['TRIAL'] == 'NO TRIAL') {
														echo ' style="color: red;"';
												} elseif ($v['TRIAL'] == 'DONE') {
														echo ' style="color: green;"';
												}
												echo '>' . $v['TRIAL'] . '</td>
														  </tr>';
												}
											}
										?>
										</tbody>

									<tfoot>
										<tr>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
                      <th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
                      <th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
										</tr>
									</tfoot>
								</table>
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

									$(document).ready(function () {
									  // untuk judul
									  var datestart = '<?= $datestart ?>';
									  var dateend = '<?= $dateend ?>';
									  var datestart_split = datestart.split('-');
									  var dateend_split = dateend.split('-');
									  var datestart_indo = datestart_split[2]+'-'+datestart_split[1]+'-'+datestart_split[0];
									  var dateend_indo = dateend_split[2]+'-'+dateend_split[1]+'-'+dateend_split[0];

										var period = '<?= $period ?>';
										var period_split = period.split('-');
										var period_indo = period_split[1]+'-'+period_split[0];

  									  $('#example').DataTable({
										"footerCallback": function ( row, data, start, end, display ) {

										},
										dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
										buttons: [
											/*{
												extend: 'excel',
												className: 'btn-success',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
												},
												title: 'Data Guest Online Oriskin',
												customize: function (xlsx) {
													var sheet1 = xlsx.xl.worksheets['sheet1.xml'];
												},
												exportOptions: {
													orthogonal: 'export',
													format: {
														body: function (data, row, column) {
															if (column == 0)
																return row+1; // no urut
															else if (column == 6)
																return data.replace(/(&nbsp;|<([^>]+)>)/ig, '').replace(/[0-9]/g, '').replace('%', ''); // menghilangkan persentase
															else
																return data.replace(/(&nbsp;|<([^>]+)>)/ig, '');
														}
													}
												}
											},*/
											{
												extend: 'pdfHtml5',
												title: 'Report Data New LC All Clinic Vs Doing\n Period: '+period_indo,
												className: 'btn-info',
												orientation: 'landscape',
                										pageSize: 'LEGAL',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5,7,8,9,10,11,12]
												},
												footer: true,
												customize: function (doc) {
													var tblBody = doc.content[1].table.body;
													// ***
													//This section creates a grid border layout
													// ***
													doc.content[1].layout = {
													hLineWidth: function(i, node) {
														return (i === 0 || i === node.table.body.length) ? 2 : 1;},
													vLineWidth: function(i, node) {
														return (i === 0 || i === node.table.widths.length) ? 2 : 1;},
													hLineColor: function(i, node) {
														return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';},
													vLineColor: function(i, node) {
														return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';}
													};
													// ***
													//This section loops thru each row in table looking for where either
													//the second or third cell is empty.
													//If both cells empty changes rows background color to '#FFF9C4'
													//if only the third cell is empty changes background color to '#FFFDE7'
													// ***
													$(doc.content[1].table.body).each(function (i, row) {
														 if (row[9].text === 'NO DOING') {
																 row[9].style = { fillColor: 'red', color: 'white' }; // Change background to red
														 } else if (Date.parse(row[9].text)) {
																 row[9].style = { fillColor: 'green', color: 'white' }; // Change background to green
														 }

														 if (row[10].text === 'NO DOING') {
																 row[10].style = { fillColor: 'red', color: 'white' }; // Change background to red
														 } else if (Date.parse(row[10].text)) {
																 row[10].style = { fillColor: 'green', color: 'white' }; // Change background to green
														 }

														 if (row[11].text === 'NO TRIAL') {
																 row[11].style = { fillColor: 'red', color: 'white' }; // Change background to red
														 } else if (row[11].text === 'DONE') {
																 row[11].style = { fillColor: 'green', color: 'white' }; // Change background to green
														 }
												 });
													$('#tableID').find('tr').each(function (ix, row) {
														var index = ix;
														var rowElt = row;
														$(row).find('td').each(function (ind, elt) {
															if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
																delete tblBody[index][ind].style;
																tblBody[index][ind].fillColor = '#FFF9C4';
															}
															else
															{
																if (tblBody[index][2].text == '') {
																	delete tblBody[index][ind].style;
																	tblBody[index][ind].fillColor = '#FFFDE7';
																}
															}
														});
													});
												}
											},
											{
												extend: 'print',
												title: 'Report Detail New LC All Clinic VS Doing '+period_indo,
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5,7,8,9,10,11,12]
												},
												footer: true,
												customize: function (win) {
													$(win.document.body).find('h1').css('font-size', '15pt');
													$(win.document.body).find('h1').css('text-align', 'center');
													/*$(win.document.body).find('tr').each(function(index) {
														$(this).find('td:first').html(index); // no urut
													});*/
												}
											},
											{
												extend: 'excelHtml5',
												title: 'Report Detail New LC All Clinic VS Doing period: '+period_indo,
												footer: true
											},


										]
									  });

									});
								</script>
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

		<script>

			function changeSPJob(_value, e) {
				$('#sp-jobname').html($('#list-job option[value="' + _value + '"]').text());
			}

			function changeSPLocation(_value, e) {
				$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
			}
		</script>
