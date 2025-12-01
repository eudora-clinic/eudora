
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
	.nav-tabs {
		border-bottom: 1px solid #dee2e6;
	}
	.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover {
		color: #333 !important;
	}
	.nav-tabs .nav-item .nav-link {
		border: 1px solid transparent !important;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active, .nav-tabs .nav-item .nav-link:focus {
		border: 1px solid transparent !important;
		border-color: #dee2e6 #dee2e6 #fafafa !important;
		color: #333 !important;
	}
	/* timepicker supaya di tengah  */
	.main_container__1GGJE.main_blue__1ol4p {
		margin-left: auto !important;
		margin-right: auto !important;
		top: 50%  !important;
		left: 0 !important;
		right: 0 !important;
		text-align: center !important;
	}
</style>
<?php
	# display error
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	# unlimited time
	ini_set('max_execution_time', -1);
	$q = (isset($_GET['q']) ? $this->input->get('q') : '');
	# dibuat langsung di view untuk memudahkan
	# tidak dibuat di model
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	$customerId = '';
	$fullname = '';
	$membercode = '';
	$membership_treatment = array();
	$history_doing = array();
	$treatment_info = array();

	$customer = $db_oriskin->query("Exec spClinicFindCustomer '".$id_ref."'")->result_array();
	$customerId = $customer[0]['IDFROMDB'];
	$fullname = $customer[0]['FIRSTNAME'] . ' ' . $customer[0]['LASTNAME'];
	$membercode = $customer[0]['MEMBERID'];
	//echo $customerId; die();
	# query tab membership treatment
	$membership_treatment = $db_oriskin->query("Exec spClinicFindHistoryMembershipTreatmentDtl '".$id_ref."' ")->result_array();
	# query tab history doing
	$history_doing = $db_oriskin->query("Exec spClinicFindHistoryTreatmentMemberErm '".$id_ref."' ")->result_array();
	# query tab Treatment Info
	$treatment_info = $db_oriskin->query("Exec spClinicFindHistoryTreatmentDtl '".$id_ref."' ")->result_array();
	# ======================================
	# TAMBAHAN UNTUK MODAL DOING TREATMENT
	# ======================================
	$location = $db_oriskin->query("SELECT id, name FROM mslocation where isactive=1 and name not like '%new%'")->result_array();

	$sql = "SELECT a.id, a.name, b.locationid FROM msemployee a
			INNER JOIN msemployeedetail b ON a.id = b.employeeid
			INNER JOIN msjob c ON b.jobid = c.id
			WHERE a.isactive = 1 /*AND b.locationid = 1*/ AND c.name like '%FRONT DESK%'
			ORDER BY a.name";
	$frontdesk = $db_oriskin->query($sql)->result_array();

	# DOING BY DAN ASSIST BY ISINYA SAMA
	# DILOAD PAKE AJAX SETELAH PILIH JAM (HITUNG DURASI)
	$employee_doing = $employee_assist = [];
	# ======================================
?>
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-info">
            		<h4 class="card-title">ELECTRONIC MEDICAL RECORD</h4>
        		</div>
				<div class="card-body">
 				<a href="<?= base_url('new_menu')?>" class="btn btn-primary">Back</a>
					<div class="row gx-4">
						<div class="col-md-12 mt-3">


						</div>
						<div class="col-md-12 mt-3">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs">
							<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#treatment-info">Treatment Info</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#membership-treatment">Membership Treatment</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#history-doing">History Doing</a>
								</li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane" id="membership-treatment">
									<div class="table-wrapper">
										<table id="tbl-membership-treatment" class="table table-bordered display highlight cell-border row-border" style="width:100%">
											<thead class="thead-danger">
												<tr role="" class="bg-info text-white">
													<th style="text-align: center;width:100px;">Invoice #</th>
													<th style="text-align: center;width:100px">Membership Name</th>
													<th style="text-align: center;width:100px">Treatment</th>
													<th style="text-align: center;width:30px">TR. Times</th>
													<th style="text-align: center;display: none;width:30px">TR. Total</th>
													<th style="text-align: center;width:40px">TR. Used</th>
													<th style="text-align: center;width:50px">TR. Remaining</th>
													<th style="text-align: center;width:100px">Remarks</th>

												</tr>
											</thead>
											<tbody>
												<?php
													if (count($membership_treatment) > 0) {
														foreach ($membership_treatment as $mt) {
															$status = '';
															$bgcolor = '';

															if ($mt['STATUS'] == 2 && $mt['ISFULL'] == 0) {
																if ($mt['REMAINING'] > 0) {
																	//$status = 'Ready';
																	$status = '<button class="btn btn-sm btn-danger btn-xs check-in-treatment" data-toggle="modal" data-target="#modalNewDoingTreatment" onclick="initModalNewDoingTreatment(this,\''.$mt['INVOICENO'].'\',\''.$mt['TREATMENTID'].'\',\''.$mt['TREATMENTNAME'].'\');">Booking</button>';
																	$bgcolor = 'bg-success';
																} else {
																	$status = 'Completed';
																	$bgcolor = 'bg-danger';
																}
															} elseif ($mt['STATUS'] == 2 && $mt['ISFULL'] == 1) {
																$status = 'Completed';
																$bgcolor = 'bg-danger';
															} elseif ($mt['STATUS'] == 28) {
																$status = 'Membership Expired';
																$bgcolor = 'bg-danger';
															}

															echo '<tr>
																	<td class="text-center">'.$mt['INVOICENO'].'</td>
																	<td class="text-left">'.$mt['MEMBERSHIPNAME'].'</td>
																	<td class="text-left">'.$mt['TREATMENTNAME'].'</td>
																	<td class="text-right">'.number_format($mt['TREAMENTTIMES'], 0, '.', '').'</td>
																	<td class="text-right" style="display: none;">'.number_format($mt['TOTALTREATMENTS'], 0, '.', ',').'</td>
																	<td class="text-right">'.number_format($mt['USEDTIMES'], 0, '.', ',').'</td>
																	<td class="text-right">'.number_format($mt['REMAINING'], 0, '.', ',').'</td>
																	<td class="f-td text-center text-white '.$bgcolor.'">'.$status.'</td>

																</tr>';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="history-doing">
									<div class="table-wrapper">
										<table id="tbl-history-doing" class="table table-bordered display highlight cell-border row-border" style="width:100%">
											<thead class="thead-danger">
												<tr role="" class="bg-info text-white">
													<!--<th class="first-col sticky-col" style="text-align: center;width:50px;">ID</th>-->
													<th style="text-align: center;width:100px;">Doing Date</th>
													<!--<th style="text-align: center;width:100px;">Customer</th>-->
													<th style="text-align: center;width:100px;">Type</th>
													<th style="text-align: center;width:100px;">Treatment</th>
													<!--<th style="text-align: center;">Rate</th>-->
													<th style="text-align: center;width:100px;">Doing By</th>
													<th style="text-align: center;width:80px;">Doing Pos.</th>
													<th style="text-align: center;width:80px;">Assist By</th>
													<!--<th style="text-align: center;">Assist Pos.</th>-->
													<!--<th style="text-align: center;width:50px;">Start</th>-->
													<!--<th style="text-align: center;width:50px;">End</th>-->
													<!--<th style="text-align: center;width:50px;">Duration</th>-->
													<!--<th style="text-align: center;">FD</th>-->
													<th style="text-align: center;width:70px;">Status</th>
													<th style="text-align: center;width:500px;">S.O.A.P</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if (count($history_doing) > 0) {
														foreach ($history_doing as $hd) {
															//$dateString = explode('-', substr($hd['TREATMENTDATE'], 0, 10));
															//$treatmentdate = $dateString[2].'-'.$dateString[1].'-'.$dateString[0];
															$note = $db_oriskin->query("SELECT ISNULL(note, '') AS note FROM historydoingnote WHERE doingid = '".$hd['DOINGID']."'")->row()->note ?? '';

															echo '<tr>
																	<!--<td class="text-center">'.$hd['DOINGID'].'</td>-->
																	<td class="text-center">'.$hd['TREATMENTDATE'].'</td>
																	<!--<td class="text-left">'.$hd['CUSTOMERNAME'].'</td>-->
																	<td class="text-left">'.$hd['CLIENTTYPE'].'</td>
																	<td class="text-left">'.$hd['TREATMENTNAME'].'</td>
																	<!--<td class="text-right">'.number_format($hd['RATE'], 0, '.', ',').'</td>-->
																	<td class="text-left">'.$hd['DOINGBY'].'</td>
																	<td class="text-left">'.$hd['DOINGBYJOB'].'</td>
																	<td class="text-left">'.$hd['ASSISTBY'].'</td>
																	<!--<td class="text-left">'.$hd['ASSISTBYJOB'].'</td>-->
																	<!--<td class="text-center">'.$hd['STARTTREATMENT'].'</td>-->
																	<!--<td class="text-center">'.$hd['ENDTREATMENT'].'</td>-->
																	<!--<td class="text-center">'.$hd['DURATION'].'</td>-->
																	<!--<td class="text-left">'.$hd['FRONTDESK'].'</td>-->
																	<td class="text-left">'.$hd['STATUSNAME'].'</td>
																	<td class="text-center">
																		<span data-id="'.$hd['DOINGID'].'" class="spn-note" style="display: block;">'.$note.'</span>
																		<button data-id="'.$hd['DOINGID'].'" class="btn btn-sm btn-info btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
																		<textarea data-id="'.$hd['DOINGID'].'" class="txt-note" style="display: none;width:500px">'.$note.'</textarea>
																		<button data-id="'.$hd['DOINGID'].'" class="btn btn-sm btn-info btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>
																	</td>
																</tr>';
														}
													}
												?>
											</tbody>
										</table>
									</div>
								</div>

								<div class="tab-pane show active" id="treatment-info">
									<div class="table-wrapper">
										<table id="tbl-treatment-info" class="table table-bordered display highlight cell-border row-border" style="width:100%">
											<thead class="thead-danger">
												<tr role="" class="bg-info text-white">
													<!--<th class="first-col sticky-col" style="text-align: center;width:50px;">ID</th>-->
													<th style="text-align: center;width:100px;">Invoice #</th>
													<th style="text-align: center;width:100px;">Treatment</th>
													<th style="text-align: center;width:100px;">TR. Times</th>
													<!--<th style="text-align: center;">Rate</th>-->
													<th style="text-align: center;width:100px;">TR. Free</th>
													<th style="text-align: center;width:80px;">TR. Total</th>
													<th style="text-align: center;width:80px;">TR. Used</th>
													<th style="text-align: center;width:80px;">TR. Remaining</th>
													<th style="text-align: center;width:100px">Remarks</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if (count($treatment_info) > 0) {
														
															foreach ($treatment_info as $ti) {
															{
															$status = '';
															$bgcolor = '';

															if ($ti['STATUS'] == 2) {
																if ($ti['REMAINING'] > 0) {
																	//$status = 'Ready';
																	$status = '<button class="btn btn-sm btn-danger btn-xs check-in-treatment" data-toggle="modal" data-target="#modalNewDoingTreatment" onclick="initModalNewDoingTreatment(this,\''.$ti['INVOICENO'].'\',\''.$ti['TREATMENTID'].'\',\''.$ti['TREATMENTNAME'].'\');">Booking</button>';
																	$bgcolor = 'bg-success';
																} else {
																	$status = 'Completed';
																	$bgcolor = 'bg-danger';
																}
															} elseif ($ti['STATUS'] == 2 ) {
																$status = 'Completed';
																$bgcolor = 'bg-danger';
															} elseif ($ti['STATUS'] == 9) {
																$status = 'Upgraded';
																$bgcolor = 'bg-danger';
															}
															}
															
															//$dateString = explode('-', substr($hd['TREATMENTDATE'], 0, 10));
															//$treatmentdate = $dateString[2].'-'.$dateString[1].'-'.$dateString[0];

															echo '<tr>
																	<td class="text-center">'.$ti['INVOICENO'].'</td>
																	<td class="text-left">'.$ti['TREATMENTNAME'].'</td>
																	<td class="text-center">'.$ti['TREAMENTTIMES'].'</td>
																	<td class="text-center">'.$ti['FREETREATMENTTIMES'].'</td>
																	<td class="text-center">'.$ti['TOTALTREATMENTS'].'</td>
																	<td class="text-center">'.$ti['USEDTIMES'].'</td>
																	<td class="text-center">'.$ti['REMAINING'].'</td>
																	<td class="f-td text-center text-white '.$bgcolor.'">'.$status.'</td>
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Add Doing Treatment -->
<div class="modal fade modal-transparent modal-fullscreen" id="modalNewDoingTreatment" tabindex="-1" role="dialog" aria-labelledby="modalNewDoingTreatment">
	<div class="modal-dialog modal-lg" role="dialog">
		<div class="modal-content">
			<form id="savedoingtreatment" class="form-horizontal" action="<?= base_url('savedoingtreatment') ?>" role="form" method="post">
				<input type="hidden" name="customerid" value="<?= $id_ref ?>">
				<div class="modal-header" style="background: linear-gradient(60deg,#26c6da,#00acc1);">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title" id="modalNewDoingTreatmentLabel" style="background: linear-gradient(60deg,#26c6da,#00acc1);">Add Doing Treatment</h4>
				</div>
				<div class="modal-body">
					<div class="row mb-4">
						<div class="col-md-4">
							<label>Invoice :</label>
							<input type="text" id="invoicenotreatment" name="invoiceno" class="form-control form-control-sm pl-2" required readonly/>
						</div>
						<div class="col-md-8">
							<label>Treatment :</label>
							<select class="form-control form-control-sm pl-2" id="treatmentselect" name="producttreatmentid" style="pointer-events: none;" required readonly>
								<option value="">SELECT A TREATMENT</option>
							</select>
						</div>
						<!--
						<div class="col-md-1">
							<input type="text" class="form-control text-uppercase hide"	id="treatmentidmodal" name="producttreatmentid"/>
						</div>
						-->
					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<label>Location :</label>
							<select class="form-control form-control-sm" id="locationselect" name="locationid" required="true">
								<option value="">SELECT LOCATION</option>
								<?php
									foreach ($location as $l) {
										echo '<option value="'.$l['id'].'">'.$l['name'].'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<label>Front Desk :</label>
							<select class="form-control form-control-sm" id="frontdeskselect" name="frontdeskid" required="true">
								<option value="">SELECT A FRONT DESK</option>
							</select>
						</div>

					</div>
					<div class="row mb-4">
						<div class="col-md-6">
							<label class="control-label">Treatment Date :</label>
							<input type="text" class="form-control form-control-sm text-uppercase datepicker" id="treatmentdate" name="treatmentdate"	placeholder="Treatment Date" required>
						</div>
						<div class="col-md-2">
							<label>Start Time :</label>
							<input type="text" class="form-control form-control-sm" id="starttreatment" name="starttreatment" required>
						</div>
						<div class="col-md-2">
							<label>End Time :</label>
							<input type="text" class="form-control form-control-sm"	id="endtreatment" name="endtreatment" required>
						</div>
						<div class="col-md-2">
							<label>Dur(min) :</label>
							<input type="text" class="form-control form-control-sm" id="duration" name="duration" readonly>
						</div>
					</div>
					<div class="row mb-4">
						<div class="col-md-5">
							<label>Doing By :</label>
							<select class="form-control form-control-sm" id="doingbyselect" name="treatmentdoingbyid" required>
								<option value="">DOING BY</option>
							</select>
						</div>
						<div class="col-md-5">
							<label>Assist By :</label>
							<select class="form-control form-control-sm" id="assistbyselect" name="treatmentassistbyid">
								<option value="">ASSIST BY</option>
							</select>
						</div>
						<div class="col-md-2">
							<label>Voucher :</label>
							<input type="text" id="voucherusedno" name="voucherused" class="form-control form-control-sm text-uppercase">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="d-flex align-items-center">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
						<input id="btn-save" type="submit" class="btn btn-primary pull-right"	value="Confirm and Save">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Modal Add Doing Treatment -->
<script>
	$(document).ready(function () {
		// untuk judul
		var customerId = '<?= $customerId ?>';

		$('#tbl-treatment-info').DataTable({
			paging: true,
			pageLength : 100,
			//scrollY: "300px",
			//scrollCollapse: true,
			order: [[0, 'asc']],
		});

		$('#tbl-membership-treatment').DataTable({
			paging: true,
			pageLength : 100,
			//scrollY: "300px",
			//scrollCollapse: true,
			order: [[0, 'asc']],
		});

		$('#tbl-history-doing').DataTable({
			paging: true,
			pageLength : 100,
			//scrollY: "300px",
			//scrollCollapse: true,
			order: [[0, 'desc']],
			rowCallback: function(row, data) {
				let dateString = ((data[0]).substring(0, 10)).split('-');
				let reatmentdate = dateString[2]+'-'+dateString[1]+'-'+dateString[0];
				$('td:eq(0)', row).html('<b>'+reatmentdate+'</b>');
			}
		});
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
            $(this).on("click", function() {
                let id = $(this).data('id');
                let note = $(this).parent().find('.txt-note').val();

                $.post("<?= base_url('save-note-history-doing') ?>", {
                    doingid: id,
                    note: note
                }, function(res) {
                }).done(function(res) {
                    let response = JSON.parse(res);
					console.log(response);
					
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Failed',
                            text: response.message
                        });
                    }
                }).fail(function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Failed',
                        text: 'An unexpected error occurred'
                    });
                });

                $(this).parent().find('.spn-note').html(note);
                $(this).hide();
                $(this).parent().find('.txt-note').hide();
                $(this).parent().find('.spn-note').show();
                $(this).parent().find('.btn-edit').show();
            });
        });

		// ======================================
		// TAMBAHAN UNTUK MODAL DOING TREATMENT
		// ======================================
		let _location = <?= json_encode($location) ?>;
		let _frontdesk = <?= json_encode($frontdesk) ?>;
		let _employee_doing = <?= json_encode($employee_doing) ?>;
		let _employee_assist = <?= json_encode($employee_assist) ?>;

		let _frontdesk_filter = [];
		let _employee_doing_filter = [];
		let _employee_assist_filter = [];

		$(document).on('change', '#locationselect', function(e) {
			let _locationid = this.value;
			let _html = '';
			// frontdesk
			_frontdesk_filter = _frontdesk.filter(function(v) {
				return v.locationid == _locationid;
			});

			_html = '<option value="">SELECT A FRONT DESK</option>';
			Object.entries(_frontdesk_filter).forEach(([key, val]) => {
				_html += '<option value="'+val['id']+'">'+val['name']+'</option>';
			});

			$(document).find('#frontdeskselect').html(_html);
			$(document).find('#doingbyselect').html('<option value="">DOING BY</option>');
			$(document).find('#assistbyselect').html('<option value="">ASSIST BY</option>');
		});
	
		$('#treatmentdate').on('focusout', function(e) {
			if ($('#locationselect').val() == '') 
				$('#locationselect').focus();
			else
				getEmployeeDoingBy();
		});

		// timepicker1
		var timepicker1 = new TimePicker('#starttreatment', {
			lang: 'en',
			theme: 'blue',
		});
		timepicker1.on('change', function(evt) {
			var value = ((evt.hour).padStart(2, '0') || '00') + ':' + (evt.minute || '00');
			evt.element.value = value;
			calculateDuration()
		});
		// timepicker2
		var timepicker2 = new TimePicker('#endtreatment', {
			lang: 'en',
			theme: 'blue',
		});
		timepicker2.on('change', function(evt) {
			var value = ((evt.hour).padStart(2, '0') || '00') + ':' + (evt.minute || '00');
			evt.element.value = value;
			calculateDuration()
		});
			
        $(document).on('submit', '#savedoingtreatment', function(e) {
      		e.preventDefault();
            let _url = $(this).attr("action");
      		let _data = new FormData(this);

      		$.ajax({
      			type: 'post',
      			url: _url,
      			data: _data,
      			cache:false,
      			contentType: false,
      			processData: false,
      			beforeSend: function() {
                    $('#savedoingtreatment #btn-save').attr('disabled', 'disabled');
                    $('#savedoingtreatment #btn-save').html('Saving...');
      			},
      			complete: function() {
                    $('#savedoingtreatment #btn-save').removeAttr('disabled');
                    $('#savedoingtreatment #btn-save').html('Confirm And Save');
      			},
      			success: function(result) {
					let _res = result.split('|');
					let _kd = _res[0];
					let _ket = _res[1];

					if (_kd == '1') { // success
						alert(_ket);
						location.reload();
					} else {
						alert(_ket);
					}
      			},
      			error: function(jqXHR, textStatus, errorThrown) {
      				alert('Error status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText);
      			}
      		});
      	});
		// ======================================
	});

	function initModalNewDoingTreatment(_obj, _invoiceno, _treatmentid, _treatmentname) {
		$(document).find('#invoicenotreatment').val(_invoiceno);
		$(document).find('#treatmentselect').html('<option value="' + _treatmentid + '">' + _treatmentname + '</option>');
		$(document).find('#treatmentselect').val(_treatmentid);
	}
	// menghitung durasi
	function calculateDuration() {
		let _date = $('#treatmentdate').val().split('/');
		let _startdate = _date[2]+'-'+_date[1]+'-'+_date[0];
		let _starttime = $('#starttreatment').val();
		let _endtime = $('#endtreatment').val();
		let _diff = new Date(_startdate+' '+_endtime) - new Date(_startdate+' '+_starttime);
		let _minutes = Math.floor((_diff / 1000) / 60);
		if (_minutes < 0) {
			//alert('Date invalid.');
			$(document).find("#duration").val(0);
		} else {
			$(document).find("#duration").val(_minutes);
			getEmployeeDoingBy();
		}
	}

	// fungsi get doingby
	function getEmployeeDoingBy() {
		let _locationid = $('#locationselect').val();
		let _date = $('#treatmentdate').val().split('/');
		let _startdate = _date[2]+'-'+_date[1]+'-'+_date[0];
		let _starttime = $('#starttreatment').val();
		let _endtime = $('#endtreatment').val();
		let _url = '<?= base_url('getemployeedoingby') ?>'+'?locationid='+_locationid+'&treatmentdate='+_startdate+'&starttreatment='+_starttime+'&endtreatment='+_endtime;
		let _html = '';

		$.ajax({
			type: 'get',
			url: _url,
			//data: _data,
			cache:false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				// code here
			},
			complete: function() {
				// code here
			},
			success: function(result) {
				let _res = JSON.parse(result);
				// doing by
				_html = '<option value="">DOING BY</option>';
				Object.entries(_res).forEach(([key, val]) => {
					_html += '<option value="'+val['id']+'">'+val['name']+'</option>';
				});
				$(document).find('#doingbyselect').html(_html);
				// assist by
				_html = '<option value="">ASSIST BY</option>';
				Object.entries(_res).forEach(([key, val]) => {
					_html += '<option value="'+val['id']+'">'+val['name']+'</option>';
				});

				$(document).find('#assistbyselect').html(_html);
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText);
			}
		});
	}
</script>
