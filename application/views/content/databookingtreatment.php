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
	$location_list = $db_oriskin->query("select id, name from mslocation where isactive='true' order by name")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$location = $this->session->userdata('locationid');
	$btcid = (isset($_GET['btcid']) ? $this->input->get('btcid') : '');

	# dibuat langsung di view untuk memudahkan 
	# tidak dibuat di model

	$no_invoice = $this->session->userdata('locationid');
	# dipindahkan ke atas biar terbaca saat pertama load
	//$datestart = $this->input->get('datestart');
	//$dateend = $this->input->get('dateend');
	
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	
	# query
	$sql1 = "
			select  a.* , b.firstname as customername, b.cellphonenumber as cellphonenumber,h.name as treatmentname,c.name as locationname,d.name as btcname,g.name as jobname,f.name as statusname 
			from trdoingtreatment a 
			inner join mscustomer b on a.customerid = b.id 
			inner join mslocation c on a.locationid = c.id 
			left join msemployee d on a.treatmentdoingbyid=d.id 
			inner join msemployeedetail e on d.id = e.employeeid
			inner join msstatus f on a.status = f.id
			inner join msjob g on e.jobid=g.id 
			inner join mstreatment h on a.producttreatmentid=h.id
			where e.jobid in (6,12,13,14,41,71,79,40,39) and a.treatmentdate = '".$datestart."' and a.status not in (3)
		   ";

	if ($location != '')
		$sql1 .= " and a.locationid = '".$location."'";

	if ($btcid != '') 
		$sql1 .= " and a.treatmentdoingbyid = '".$btcid."'";

	$sql1 .= " order by a.treatmentdoingbyid asc";
	
	$header = $db_oriskin->query($sql1)->result_array();
	//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");

	# query untuk filter btc
	$sql2 = "			
			select a.id as btcid, a.name as btcname
			from msemployee a 
			inner join msemployeedetail b on a.id = b.employeeid
			Where b.jobid in (6,13,12,14) and a.isactive='true'
			";
	
	if ($location != '')
		$sql2 .= " and b.locationid = '".$location."'";

	$sql2 .= " order by a.name";

	$btc = $db_oriskin->query($sql2)->result_array();
?>

<div class="container-fluid">
<div class="col-md-12">
		
      		<div class="card">
        		<div class="card-header card-header-warning">
            		<h4 class="card-title">Report Booking Treatment Clinic</h4>
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
								
								<button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info" value="true" ><i ></i> Cari</button>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
										<label class="bmd-label-static">BTC</label>
										<select id="btcid" name="btcid" class="form-control form-select" onchange="$('#btn-cari').trigger('click');">
											<option value="">-- Semua BTC --</option>
										<?php 
											if (count($btc) > 0) {
												foreach ($btc as $b) {
													echo '<option value="'.$b['btcid'].'" '.($b['btcid'] == $btcid ? 'selected' : '').'>'.$b['btcname'].'</option>';
												}
											}
									 	?>
										</select>
									</div>
								</div>
							</div>
						</form>
					</div>
						
					<div class="toolbar">
					</div>
					<div>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
									
											<th width="50px" class="text-center">No</th>
											<th width="200px" class="text-center">Clinic</th>
											<th width="100px" class="text-center">Date</th>
											<th width="150px" class="text-center">Customer</th>
											<th width="150px" class="text-center">CellPhone</th>
											<th width="350px" class="text-center">Treatment</th>
											<th width="30px" class="text-center">Qty</th>
											<th width="200px" class="text-center">Doing By</th>
											<th width="200px" class="text-center">Doing Jobs</th>
											<th width="100px" class="text-center">ID</th>
											<th width="100px"class="text-center">Start</th>
											<th width="100px" class="text-center">End</th>
											<th width="80px" class="text-center">Duration</th>
											
										
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
												$no = 0;

												foreach ($header as $v)
													 {
													

													echo '<tr>
													<td class="first-col sticky-col">
													<span id="no-'.$v['id'].'">'.++$no.'</span>
												</td>
												<td class="text-center">
												<span id="sp-locationname-'.$v['id'].'">'.$v['locationname'].'</span>
												<input type="text" id="locationname-'.$v['id'].'" value= "'.$v['locationname'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-treatmentdate-'.$v['id'].'">'.substr($v['treatmentdate'], 0, 10).'</span>
													<input type="date" id="treatmentdate-'.$v['id'].'" value="'.substr($v['treatmentdate'], 0, 10).'" style="width: 100px; display: none;">
												</td>											
												
												<td class="first-col sticky-col">
													<span id="sp-customername-'.$v['id'].'">'.$v['customername'].'</span>
													<input type="text" id="customername-'.$v['id'].'" value="'.$v['customername'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-left">
													<span id="sp-cellphonenumber-'.$v['id'].'">'.$v['cellphonenumber'].'</span>
													<input type="text" id="cellphonenumber-'.$v['id'].'" value="'.$v['cellphonenumber'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-left">
													<span id="sp-treatmentname-'.$v['id'].'">'.$v['treatmentname'].'</span>
													<input type="text" id="treatmentname-'.$v['id'].'" value="'.$v['treatmentname'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">1</td>
												<td class="text-center">
													<span id="sp-btcname-'.$v['id'].'">'.$v['btcname'].'</span>
													<input type="text" id="btcname-'.$v['id'].'" value= "'.$v['btcname'].'" style="width: 200px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-jobname-'.$v['id'].'">'.$v['jobname'].'</span>
													<input type="text" id="jobname-'.$v['id'].'" value= "'.$v['jobname'].'" style="width: 200px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-treatmentdoingbyid-'.$v['id'].'">'.$v['treatmentdoingbyid'].'</span>
													<input type="number" id="treatmentdoingbyid-'.$v['id'].'" value= "'.$v['treatmentdoingbyid'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-starttreatment-'.$v['id'].'">'.$v['starttreatment'].'</span>
													<input type="text" id="starttreatment-'.$v['id'].'" value="'.$v['starttreatment'].'" class="starttreatment timepickers" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-endtreatment-'.$v['id'].'">'.$v['endtreatment'].'</span>
													<input type="text" id="endtreatment-'.$v['id'].'" value="'.$v['endtreatment'].'" class="endtreatment timepickers" style="width: 50px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-duration-'.$v['id'].'">'.$v['duration'].'</span>
													<input type="number" id="duration-'.$v['id'].'" value="'.$v['duration'].'" style="width: 50px; display: none;">
												</td>
												
														  </tr>';
												}
											}
										?>
										</tbody>
										
									<tfoot>
									<tr>
											<th colspan="6" style="text-align:right">Total:</th
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
									$(document).ready(function () {
										// untuk judul
										var datestart = '<?= $datestart ?>';
									  var datestart_split = datestart.split('-'); 
									  var datestart_indo = datestart_split[2]+'-'+datestart_split[1]+'-'+datestart_split[0];
									  

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
												.column( 7, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
											
											// Total filtered rows on the selected column (code part added)
											
											var sumCol11Filtered2 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0 );

											$( api.column( 7 ).footer() ).html(
												numberFormat(sumCol11Filtered2, 0, ',', '.')
											);
										},
									
										dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
										buttons: [
											{ 
												extend: 'pdfHtml5',
												title: 'Data Booking Treatment - Daily\n Period: '+datestart_indo+'',
												className: 'btn-warning',
												orientation: 'landscape',
                								pageSize: 'A4',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Data Booking Treatment - Daily\n Period: '+datestart_indo+'',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12]
												},
												footer: true,
												title: 'Data Booking Treatment - Daily\n Period: '+datestart_indo+'',
												customize: function (win) {
													$(win.document.body).find('h1').css('font-size', '15pt');
													$(win.document.body).find('h1').css('text-align', 'center'); 
													/*$(win.document.body).find('tr').each(function(index) {
														$(this).find('td:first').html(index); // no urut
													});*/
												}
											},
											{ extend: 'excelHtml5',title: 'Data Booking Treatment - Daily', footer: true },
																				
										]
									  });
									  /*$('#example_filter input[type=search]').on('focusout', function() {
										var filtered = table.rows({search:'applied'});
										var jml = filtered.count();
										var total_amount = 0;
										var total_buy = 0;

										for (i = 0; i < jml; i++) {
											//alert(table.rows(i).data()[0]['']);
											//alert(filtered.row(i).index());
											alert(filtered.row(i).index().);
										}

									  });*/
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

	function changeSPJob(_value, e) {
		$('#sp-jobname').html($('#list-job option[value="' + _value + '"]').text());
	}

	function changeSPLocation(_value, e) {
		$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
	}
</script>