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
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m-d'));
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Member not doing 14 days - 365 days</h4>
        		</div>
				<div class="card-body">
				<div class="toolbar">
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
							$query = $db_oriskin->query("EXEC spReportCallApptFd '".$no_invoice."' ");
							
								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
							
						
						
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="60px" class="text-center">Id</th>
											<th width="150px" class="first-col sticky-col">Name</th>
											<th width="150px" class="text-center">Cellphone</th>
											<th width="90px"class="text-center">Last Doing</th>
											<th width="90px"class="text-center">Day-LD</th>
											<th width="260px" class="text-center">Last Treatment</th>
											<th width="250px" class="text-center">Follow Up</th>
										
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
										
												foreach ($header as $v)
													 {
														$dateString = explode('-', substr($v['LASTDOINGLD'], 0, 10));
														$treatmentdate = $dateString[2].'-'.$dateString[1].'-'.$dateString[0];
														$note = $db_oriskin->query("SELECT ISNULL(note, '') AS note FROM historyfollowupdoingnote WHERE CUSTOMERID = '".$v['CUSTOMERID']."'")->row()->note ?? '';
														
													echo '<tr>
												
												
													
												<td class="irst-col sticky-col">'.$v['CUSTOMERID'].'</td>
												<td class="text-center">'.$v['LCNAME'].'</td>
												<td class="text-center">'.$v['CELLPHONE'].'</td>
												<td class="text-center">'.$treatmentdate.'</td>
												<td class="text-center">'.$v['MONTHLD'].'</td>
												<td class="text-center">'.$v['LASTTREATMENT'].'</td>
												<td class="text-center">
																		<span data-id="'.$v['CUSTOMERID'].'" class="spn-note" style="display: block;">'.$note.'</span>
																		<button data-id="'.$v['CUSTOMERID'].'" class="btn btn-sm btn-danger btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
																		<textarea data-id="'.$v['CUSTOMERID'].'" class="txt-note" style="display: none;width:250px">'.$note.'</textarea>
																		<button data-id="'.$v['CUSTOMERID'].'" class="btn btn-sm btn-danger btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>
												</td>
												
												
												
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
										paging: false,
										//scrollY: "300px",
									    //scrollCollapse: true,
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
												title: 'Data Member not doing 14 days - 365 days',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'LEGAL',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5,6]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Data Member not doing 14 days - 365 days',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5,6]
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
												title: 'Data Member not doing 14 days - 365 days',
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
	$(document).ready(function () {
		

		$(".btn-edit").each(function(index) {
			$(this).on("click", function(){
				let id = $(this).data('id');
				//alert('edit '+id);
				$(this).hide();
				$(this).parent().find('.spn-note').hide();
				$(this).parent().find('.txt-note').show();
				$(this).parent().find('.btn-save').show();
			});
		});

		$(".btn-save").each(function(index) {
			$(this).on("click", function(){
				let id = $(this).data('id');
				//alert('save '+id);
				let note = $(this).parent().find('.txt-note').val();

				$.post("<?= base_url('save-note-followup-doing') ?>", {customerid: id, note: note}, function(res) {
					//
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

