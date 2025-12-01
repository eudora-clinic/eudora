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
	$location_list = $db_oriskin->query("select id, name from mslocation where isactive='true' order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$location = (isset($_GET['locationid']) ? $this->input->get('locationid') : 1);
?>

<div class="container-fluid">
<div class="col-md-12">
		<a class="btn btn-danger" href="<?=base_url('add-booking')?>" role="button">Input Booking</a>
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Summary Booking Online</h4>
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
									<label >Klinik</label>
									<input id="locationid" name="locationid" class="form-control form-select" list="list-location" required="true" aria-required="true" onfocusout="changeSPLocation(this.value, event);">
									<datalist id="list-location">
									<?php foreach ($location_list as $j) { ?>
										<option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
									<?php } ?>
									</datalist>
									</div>
								</div>
								<button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info" value="true" ><i ></i> Cari</button>
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
							$query = $db_oriskin->query("select  * from trdoingtreatment where treatmentdate = '".$datestart."' and locationid = '".$location."'");
							
								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
							
						
						
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
									
											<th width="50px" class="text-center">Location Id</th>
											<th width="50px" class="text-center">Customer Id</th>
											<th width="50px" class="text-center">Date</th>
											<th width="50px"class="text-center">Start</th>
											<th width="50px" class="text-center">End</th>
											<th width="50px" class="text-center">Duration</th>
										
											
											
											
											
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												
												

												foreach ($header as $v)
													 {
													

													echo '<tr>
												
												
													
												<td class="text-center">'.$v['locationid'].'</td>
												<td class="first-col sticky-col">'.$v['customerid'].'</td>
												<td class="first-col sticky-col">'.substr($v['treatmentdate'], 0, 10).'</td>
												<td class="text-center">'.$v['starttreatment'].'</td>
												<td class="text-center">'.$v['endtreatment'].'</td>
												<td class="text-center">'.$v['duration'].'</td>
												
														  </tr>';
												}
											}
										?>
										</tbody>
										
									<tfoot>
										
									</tfoot>
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