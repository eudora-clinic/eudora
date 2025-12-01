<style>
	/*sementara hanya berjalan di firefox*/
	.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
		color: #fff;
	}
	.table {
		table-layout: fixed;
		width: 100%;
	}
	.table, .table thead tr th, .table>thead>tr>th, .table thead tr th, .table>tbody>tr>th {
		font-size: 10rem;
		border: 1px solid rgba(0,0,0,.06);
		text-align: center;
	}
	.table thead tr td, .table>thead>tr>td, .table tbody tr td, .table>tbody>tr>td {
		font-size: 10rem;
		border: 1px solid rgba(0,0,0,.06);
	}
	.table-wrapper {
		overflow-x: scroll;
		overflow-y: scroll;
		width: 100%;
		height: 400px;
		max-height: 400px;
		margin-top: 30px;
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
		width: 7px;
	}
	::-webkit-scrollbar-thumb {
		border-radius: 4px;
		background-color: rgba(0,0,0,.5);
		-webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
	}
</style>
<?php
	# Penambahan select option job dan location
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);	
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$location_list = $db_oriskin->query("select id, name from mslocation where isactive='true' order by id")->result_array();
	
?>
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-primary">
            		<h4 class="card-title">Input Guest Online Oriskin</h4>
        		</div>
				<div class="card-body">
					<form id="form-add-employee" method="post" action="<?= base_url().'App/insertMsemployee' ?>">
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Name</b></label>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<input type="text" id="name" name="name" class="form-control">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Cellphone Number</b></label>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<input type="number" id="cellphonenumber" name="cellphonenumber" class="form-control" required="true" aria-required="true">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Guest Type</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input id="guesttypeid" name="guesttypeid" class="form-control form-select" list="list-job" required="true" aria-required="true" onfocusout="changeSPJob(this.value, event);">
									<datalist id="list-job">
									<?php foreach ($job_list as $j) { ?>
										<option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
									<?php } ?>
									</datalist>
								</div>
							</div>
							<span id="sp-jobname" class="col-md-8 col-form-label" style="text-align: left;"></span>
						</div>
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Klinik</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input id="locationid" name="locationid" class="form-control form-select" list="list-location" required="true" aria-required="true" onfocusout="changeSPLocation(this.value, event);">
									<datalist id="list-location">
									<?php foreach ($location_list as $j) { ?>
										<option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
									<?php } ?>
									</datalist>
								</div>
							</div>
							<span id="sp-locationname" class="col-md-8 col-form-label" style="text-align: left;"></span>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<input type="hidden" id="amount" name="amount" value= '0'>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Call</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input type="number" id="call" name="call" class="form-control"  aria-required="true">
								</div>
							</div>
						
							<label class="col-md-2 col-form-label"><b>Appt</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input type="time" id="appt" name="appt" class="form-control"  aria-required="true" value="00:00">
								</div>
							</div>
                        </div>
						<div class="row">
							<label class="col-md-2 col-form-label"><b>Try</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input type="number" id="try" name="try" class="form-control"  aria-required="true">
								</div>
							</div>
							<label class="col-md-2 col-form-label"><b>Remarks</b></label>
							<div class="col-md-2">
								<div class="form-group bmd-form-group">
									<input type="text" id="remarks" name="remarks" class="form-control"  aria-required="true">
								</div>
							</div>
                        </div>
						<div class="row" style="margin-top: 15px;">
							<label class="col-md-2 col-form-label">&nbsp;</label>
							<button type="submit" id="btn-simpan" class="col-md-2 btn btn-sm btn-info"><i class="fa fa-save"></i> Simpan</button>
							<a href="<?= base_url().'employee' ?>" id="btn-kembali" class="col-md-2 btn btn-sm btn-default"><i class="fa fa-undo"></i> Batal</a>
						</div>	
					</form>
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
