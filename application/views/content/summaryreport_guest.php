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
            		<h4 class="card-title">Summary Report Guest Online</h4>
        		</div>
				<div class="card-body">
				<div class="toolbar">
						<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="form-row mt-2">
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
									<label >Date Start</label>
										<input type="date" id="datestart" name="datestart" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $datestart ?>">
									</div>
								</div>
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
									<label >Date End</label>
										<input type="date" id="dateend" name="dateend" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $dateend ?>">
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
							$query = $db_oriskin->query("EXEC spReportSummaryGuestOnline '".$datestart."','".$dateend."', '32' ");
							
								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
							
						
						
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="100px" class="text-center">Pengelola</th>
											<th width="150px" class="first-col sticky-col">Clinic</th>
											<th width="50px" class="text-center">Total Guest</th>
											<th width="50px" class="text-center">Total Call</th>
											<th width="50px"class="text-center">Call (%)</th>
											<th width="50px" class="text-center">Total Appt</th>
											<th width="50px" class="text-center">Appt (%)</th>
											<th width="50px" class="text-center">Total Try</th>
											<th width="50px"class="text-center">Try (%)</th>
											<th width="50px" class="text-center">Total Join</th>
											<th width="50px"class="text-center">Join (%)</th>
											<th width="80px" class="text-center">Amount</th>
											<th width="50px" class="text-center">Total Not Join</th>
											<th width="50px"class="text-center" >Not Join (%)</th>
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
												$total_guest = 0;
												$total_call = 0;
												$total_percentcall = 0;
												$total_appt = 0;
												$total_percentappt = 0;
												$total_try = 0;
												$total_percenttry = 0;
												$total_join = 0;
												$total_percentjoin = 0;
												$total_notjoin = 0;
												$total_percentnotjoin = 0;
												$total_amount = 0;

												foreach ($header as $v)
													 {
														$total_guest += $v['TOTALGUESTONLINE'];
														$total_call += $v['TOTALCALL'];
														$total_percentcall = ($total_call!=0)?($total_call/$total_guest) * 100:0;;
														$total_appt += $v['TOTALAPPT'];
														$total_percentappt = ($total_appt!=0)?($total_appt/$total_guest) * 100:0;;
														$total_try += $v['TOTALTRY'];
														$total_percenttry = ($total_try!=0)?($total_try/$total_guest) * 100:0;;
														$total_join += $v['TOTALJOIN'];
														$total_percentjoin = ($total_join!=0)?($total_join/$total_guest) * 100:0;;
														$total_notjoin += $v['TOTALNOTJOIN'];
														$total_percentnotjoin = ($total_notjoin!=0)?($total_notjoin/$total_guest) * 100:0;;
														$total_amount += $v['TOTALAMOUNT'];

													echo '<tr>
												
												
													
												<td class="text-center">'.$v['PENGELOLA'].'</td>
												<td class="first-col sticky-col">'.$v['LOCATIONNAME'].'</td>
												<td class="text-center">'.$v['TOTALGUESTONLINE'].'</td>
												<td class="text-center">'.$v['TOTALCALL'].'</td>
												<td class="text-center">'.$v['PRECENTAGECALL'].'</td>
												<td class="text-center">'.$v['TOTALAPPT'].'</td>
												<td class="text-center">'.$v['PRECENTAGEAPPT'].'</td>
												<td class="text-center">'.$v['TOTALTRY'].'</td>
												<td class="text-center">'.$v['PRECENTAGETRY'].'</td>
												<td class="text-center">'.$v['TOTALJOIN'].'</td>
												<td class="text-center">'.$v['PRECENTAGEJOIN'].'</td>
												<td class="text-center">'.number_format($v['TOTALAMOUNT'], 0, ',', '.').'</td>
												<td class="text-center">'.$v['TOTALNOTJOIN'].'</td>
												<td class="text-center">'.$v['PRECENTAGENOTJOIN'].'</td>
												
												
												
												
														  </tr>';
												}
											}
										?>
										</tbody>
										
									<tfoot>
										<tr>
											<th colspan="2" style="text-align:right">Total:</th>
											
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:right"></th>
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
												.column( 2, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 3, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 4, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 5, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 6, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 7, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 8, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											pageTotal = api
												.column( 9, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );

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

											total = api
												.column( 12)
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
								
											// Total over this page
											pageTotal = api
												.column( 13, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
										

											// Total filtered rows on the selected column (code part added)
											
											var sumCol11Filtered2 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered3 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered5 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered7 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered9 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered11 = display.map(el => data[el][11]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											var sumCol11Filtered12 = display.map(el => data[el][12]).reduce((a, b) => intVal(a) + intVal(b), 0 );
											
										
											// Update footer
											/*$( api.column( 11 ).footer() ).html(
												'Rp. '+pageTotal +' ( Rp. '+ total +' total) (Rp. ' + sumCol11Filtered +' filtered)'
											);*/
											
											$( api.column( 2 ).footer() ).html(
												numberFormat(sumCol11Filtered2, 0, ',', '.')
											);
											$( api.column( 3 ).footer() ).html(
												numberFormat(sumCol11Filtered3, 0, ',', '.')
											);
												$( api.column( 4 ).footer() ).html(
												numberFormat((sumCol11Filtered3/sumCol11Filtered2)*100, 2, ',', '.')
											);
											$( api.column( 5 ).footer() ).html(
												numberFormat(sumCol11Filtered5, 0, ',', '.')
											);
												$( api.column( 6 ).footer() ).html(
												numberFormat((sumCol11Filtered5/sumCol11Filtered2)*100, 2, ',', '.')
											);
											$( api.column( 7 ).footer() ).html(
												numberFormat(sumCol11Filtered7, 0, ',', '.')
											);
												$( api.column( 8 ).footer() ).html(
												numberFormat((sumCol11Filtered7/sumCol11Filtered2)*100, 2, ',', '.')
											);
											$( api.column( 9 ).footer() ).html(
												numberFormat(sumCol11Filtered9, 0, ',', '.')
											);
											$( api.column( 10 ).footer() ).html(
												numberFormat((sumCol11Filtered9/sumCol11Filtered2)*100, 2, ',', '.')
											);
											$( api.column( 11 ).footer() ).html(
												numberFormat(sumCol11Filtered11, 0, ',', '.')
											);
											$( api.column( 12 ).footer() ).html(
												numberFormat(sumCol11Filtered12, 0, ',', '.')
											);
											$( api.column( 13 ).footer() ).html(
												numberFormat((sumCol11Filtered12/sumCol11Filtered2)*100, 2, ',', '.')
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
												title: 'Summary Guest Online Oriskin\n Period: '+datestart_indo+' - '+dateend_indo,
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'LEGAL',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Summary Guest Online Oriskin\n Period: '+datestart_indo+' - '+dateend_indo,
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]
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
												title: 'Summary Guest Online Oriskin\n Period: '+datestart_indo+' - '+dateend_indo,
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
<script>
	//_mod dideklarasikan di initapp.js
	_mod = '<?=$mod?>';
  
	function editHeader(_id, e) {
		e.preventDefault();
		$('#sp-call-'+_id).hide();
		$('#sp-appt-'+_id).hide();
		$('#sp-show-'+_id).hide();
		$('#sp-ro-'+_id).hide();
		$('#sp-remarks-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#call-'+_id).val($('#sp-call-'+_id).html());
		$('#appt-'+_id).val($('#sp-appt-'+_id).html());
		$('#show-'+_id).val($('#sp-show-'+_id).html());
		$('#ro-'+_id).val($('#sp-ro-'+_id).html());
		$('#remarks-'+_id).val($('#sp-remarks-'+_id).html());
		$('#call-'+_id).show();
		$('#appt-'+_id).show();
		$('#show-'+_id).show();
		$('#ro-'+_id).show();
		$('#remarks-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _call = $('#call-'+_id).val();
			var _appt = $('#appt-'+_id).val();
			var _show = $('#show-'+_id).val();
			var _ro = $('#ro-'+_id).val();
			var _remarks = $('#remarks-'+_id).val();
			

			$.post(_HOST+'App/updateDetailOrder', {id:_id,call:_call,appt:_appt,show:_show,ro:_ro,remarks:_remarks}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-call-'+_id).show();
			$('#sp-appt-'+_id).show();
			$('#sp-show-'+_id).show();
			$('#sp-ro-'+_id).show();
			$('#sp-remarks-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#call-'+_id).hide();
			$('#appt-'+_id).hide();
			$('#show-'+_id).hide();
			$('#ro-'+_id).hide();
			$('#remarks-'+_id).hide();
			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>

<script>
	function changeSPJob(_value, e) {
		$('#sp-jobname').html($('#list-job option[value="' + _value + '"]').text());
	}

	function changeSPLocation(_value, e) {
		$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
	}
</script>