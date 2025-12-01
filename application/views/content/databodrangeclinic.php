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
	$month_list = $db_oriskin->query("select id, name from msmonth order by id")->result_array();
	$period = (isset($_GET['period']) ? $this->input->get('period') : date('Y-m'));
	$dob = (isset($_GET['dob']) ? $this->input->get('dob') : date('m'));
	
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Birth of Date</h4>
        		</div>
				<div class="card-body">
				<div class="toolbar">
					</div> 
					<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
						<div class="form-row mt-2">
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
										<label class="bmd-label-static">Month Of Birth</label>
										<select id="dob" name="dob" class="form-control form-select" onchange="changeSPMonth(this.value, event);">
										<option value="">-- Month Of Birth --</option>
										<?php foreach ($month_list as $j) { ?>
											<option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info" value="true" onclick="if($('#dateend').val() < $('#datestart').val()) {alert('Date End must more than Date Start');return false;}"><i ></i> Search</button>
							</div>
						</form>
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
							$query = $db_oriskin->query("EXEC spReportDetailBirthDayPerCatCustomer '".$period."', '".$no_invoice."','".$dob."'");
							
								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
							
						
						
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="60px" class="text-center">No</th>
										<th width="180px" class="text-center">Customer Type</th>
										<th width="100px" class="text-center">BOD</th>
										<th width="90px" class="text-center">Id</th>
										<th width="200px" class="first-col sticky-col">Name</th>
										<th width="150px" class="text-center">Cellphone</th>
										<th width="300px" class="text-center">Follow Up</th>
										
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
												$no = 0;
												foreach ($header as $v)
													 {
														
														$note = $db_oriskin->query("SELECT ISNULL(note, '') AS note FROM historyfollowubodnote WHERE CUSTOMERID = '".$v['CUSTOMERID']."'")->row()->note ?? '';
														
													echo '<tr>
												
												
												<td class="text-center">'.++$no.'</td>	
												<td class="text-center">'.$v['CUSTOMERTYPE'].'</td>	
												<td class="text-center">'.$v['DOB'].'</td>	
												<td class="first-col sticky-col">'.$v['CUSTOMERID'].'</td>
												<td class="text-center">'.$v['LCNAME'].'</td>
												<td class="text-center">'.$v['CELLPHONENUMBER'].'</td>
												<td class="text-center">
																		<span data-id="'.$v['CUSTOMERID'].'" class="spn-note" style="display: block;">'.$note.'</span>
																		<button data-id="'.$v['CUSTOMERID'].'" class="btn btn-sm btn-danger btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
																		<textarea data-id="'.$v['CUSTOMERID'].'" class="txt-note" style="display: none;width:300px">'.$note.'</textarea>
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
												title: 'Data Birth of Date',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'a3',
												exportOptions: {
													columns: [0, 1, 2, 3,4,5,6]
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
												title: 'Data Birth of Date',
												exportOptions: {
													columns: [0, 1, 2, 3,4,5,6]
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
												title: 'Data Birth of Date',
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

				$.post("<?= base_url('save-note-followup-bod') ?>", {customerid: id, note: note}, function(res) {
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

<script>
	function changeSPMonth(_value, e) {
		$('#sp-month').html($('#list-month option[value="' + _value + '"]').text());
	}

	function changeSPLocation(_value, e) {
		$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
	}
</script>
