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
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m-d'));
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Report Detail Done Deal-Daily</h4>
        		</div>
				<div class="card-body">
				<div class="toolbar">
						<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="form-row mt-2 md-2" >
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
									<label >Date Start</label>
										<input type="date" id="datestart" name="datestart" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $datestart ?>">
									</div>
								</div>
								<button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info" value="true" onclick="if($('#dateend').val() < $('#datestart').val()) {alert('Date End tidak boleh lebih kecil dari Date Start');return false;}"><i ></i> Cari</button>
							</div>
						</form>
					</div>
						
					<div class="toolbar">
					</div>
					<div>
						<?php
							# dibuat langsung di view untuk memudahkan 
							# tidak dibuat di model
						
							$no_invoice = $this->session->userdata('locationid');
							# dipindahkan ke atas biar terbaca saat pertama load
							//$datestart = $this->input->get('datestart');
							//$dateend = $this->input->get('dateend');
							
							# load database oriskin (lihat di config/database.php)
							$db_oriskin = $this->load->database('oriskin', true);
							
							# query
							$query = $db_oriskin->query("EXEC spReportdetailDoneDealRangeDaily '".$datestart."', '".$no_invoice."' ");
							
								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
							
						
						
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="150px" class="text-center">RSM</th>
										<th width="150px" class="text-center">Pengelola</th>
											<th width="100px" class="first-col sticky-col">Clinic</th>
											<th width="100px" class="text-center">ID</th>
											<th width="300px" class="text-center">Membership/Treatment Name</th>
											<th width="200px" class="text-center">Expiredate</th>
											<th width="50px"class="text-center">Qty</th>
											<th width="100px" class="text-center">Call</th>
											<th width="100px" class="text-center">Appt</th>
											<th width="150px" class="text-center">Donedeal Date</th>
											<th width="150px" class="text-center">Total Donedeal</th>
											<th width="200px" class="text-center">Amount deal</th>
											<th width="50px"class="text-center">Show</th>
											<th width="50px"class="text-center">NoRO</th>
											<th width="200px"class="text-center">Solution</th>
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
											

												foreach ($header as $v)
													 {
														

													echo '<tr>
												
												
													
												<td class="text-center">'.$v['RSM'].'</td>
												<td class="text-center">'.$v['PENGELOLA'].'</td>
												<td class="text-center">'.$v['LOCATIONNAME'].'</td>
												<td class="text-center">'.$v['CUSTOMERID'].'</td>
												<td class="text-center">'.$v['MEMBERSHIPNAME'].'</td>
												<td class="text-center">'.$v['EXPIREDATE'].'</td>
												<td class="text-center">'.$v['QTY'].'</td>
												<td class="text-center">'.$v['CALL'].'</td>
												<td class="text-center">'.$v['TOTALAPPT'].'</td>
												<td class="text-center">'.$v['DONEDEALDATE'].'</td>
												<td class="text-center">'.number_format($v['TOTALAMOUNTDONEDEAL'], 0, ',', '.').'</td>
												<td class="text-center">'.number_format($v['AMOUNT'], 0, ',', '.').'</td>
												<td class="text-center">'.$v['TOTALSHOW'].'</td>
												<td class="text-center">'.$v['TOTALNORO'].'</td>
												<td class="text-center">'.$v['SOLUSI'].'</td>
												
														  </tr>';
												}
											}
										?>
										</tbody>
										
									<tfoot>
										<tr>
											<th colspan="10" style="text-align:center">Total</th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											
										
											
											
											
											
											
												
											<th></th>
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

  									  $('#example').DataTable({
										"footerCallback": function ( row, data, start, end, display ) {
											var api = this.api(), data;
								
											// Remove the formatting to get integer data for summation
											var intVal = function ( i ) {
												return typeof i === 'string' ?
													i.replace(/\./g, '')*1 :
													typeof i === 'number' ?
														i : 0;
											};
								
											// Total over all pages
											
											
											// Total over this page
										


											pageTotal = api
												.column( 10, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 11, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											
										

											// Total filtered rows on the selected column (code part added)
											
											
											var sumCol11Filtered10 = display.map(el => data[el][10]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered11 = display.map(el => data[el][11]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											
											
										
											// Update footer
											/*$( api.column( 11 ).footer() ).html(
												'Rp. '+pageTotal +' ( Rp. '+ total +' total) (Rp. ' + sumCol11Filtered +' filtered)'
											);*/
											
											
											$( api.column( 10 ).footer() ).html(
												numberFormat(sumCol11Filtered10, 0, ',', '.')
											);
											$( api.column( 11 ).footer() ).html(
												numberFormat(sumCol11Filtered11, 0, ',', '.')
											);
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
												title: 'Summary Report Donedeal RO\n Period: '+datestart_indo+'',
												className: 'btn-danger',
												orientation: 'landscape',
                										pageSize: 'A3',
												exportOptions: {
													columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Summary Report Donedeal RO\n Period: ',
												exportOptions: {
													columns: [0, 1, 2, 3, 4,5,6,7,8,9,10,11,12,13,14]
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
												title: 'Summary Report Donedeal RO\n Period: ',
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
  	<!-- end row -->
</div>
