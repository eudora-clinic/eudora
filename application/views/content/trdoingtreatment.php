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
		font-size: 1rem;
		border: 1px solid rgba(0,0,0,.06);
		text-align: center;
	}
	.table thead tr td, .table>thead>tr>td, .table tbody tr td, .table>tbody>tr>td {
		font-size: 1rem;
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
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-success">
            		<h4 class="card-title">Edit Data Doing Treatment</h4>
        		</div>
				<div class="card-body">
					<div class="toolbar">
						<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="row">
								<label class="col-md-2 col-form-label">ID Treatment</label>
								<div class="col-md-4">
									<div class="form-group bmd-form-group">
										<input type="text" id="idtreatment" name="idtreatment" class="form-control" required="true" aria-required="true" placeholder="ketik no invoice yang akan dicari" value="<?= (isset($_GET['idtreatment']) ? $_GET['idtreatment'] : '') ?>">
									</div>
								</div>
								<button type="submit" id="btn-cari" name="submit" class="col-md-2 btn btn-sm btn-info" value="true"><i class="fa fa-search"></i> Cari</button>
							</div>
						</form>
					</div>
					<div id="result" style="display: <?= (isset($_GET['submit']) ? 'block;' : 'none;') ?>">
						<?php
							# dibuat langsung di view untuk memudahkan 
							# tidak dibuat di model
							if (isset($_GET['submit'])) {
								$idtreatment = $this->input->get('idtreatment');
								# load database oriskin (lihat di config/database.php)
								$db_oriskin = $this->load->database('oriskin', true);
								# query
								$query = $db_oriskin->query("select  id, treatmentdate, qty, status from trdoingtreatment where id = '".$idtreatment."' order by id");
								if ($query->num_rows() <= 0) {
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>No. Invoice <strong>'.$idtreatment.'</strong> tidak ditemukan</span>
											</div>';
								} else { 
									$header = $query->result_array();
									//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
								} 
							}
						?>
						<div class="table-wrapper">
							<div class="material-datatables">
								<!--<table id="dt-realisasi" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid">-->
								<table id="dt-invoice-membership" class="table table-bordered" cellspacing="0" width="100%" role="grid">
									<thead>
										<tr role="">
											<th width="20%" class="first-col sticky-col"><b>ID</b></th>
											<th width="20%" class="second-col sticky-col"><b>TREATMENT DATE</b></th>
											<th width="20%" class="second-col sticky-col"><b>QTY</b></th>
											<th width="10%"><b>STATUS</b></th>
											<th width="20%"><b>Aksi</b></th>
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												foreach ($header as $v) {
													echo '<tr>
															<td class="text-center">
																<span id="sp-id-'.$v['id'].'">'.$v['id'].'</span>
																<input type="text" id="id-'.$v['id'].'" value="'.$v['id'].'" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-treatmentdate-'.$v['id'].'">'.$v['treatmentdate'].'</span>
																<input type="text" id="treatmentdate-'.$v['id'].'" value="'.$v['treatmentdate'].'" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-qty-'.$v['id'].'">'.$v['qty'].'</span>
																<input type="text" id="qty-'.$v['id'].'" value="'.$v['qty'].'" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-status-'.$v['id'].'">'.$v['status'].'</span>
																<input type="text" id="status-'.$v['id'].'" value="'.$v['status'].'" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<button id="btn-edit-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="editHeader(&apos;'.$v['id'].'&apos;, event);"><i class="material-icons">edit</i> Edit Header</button>
																<button id="btn-save-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="saveHeader(&apos;'.$v['id'].'&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save Header</button>
																
															</td>
														  </tr>';
												}
											}
										?>
									</tbody>
									<tfoot></tfoot>
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
		$('#sp-id-'+_id).hide();
		$('#sp-treatmentdate-'+_id).hide();
		$('#sp-qty-'+_id).hide();
		$('#sp-status-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#id-'+_id).val($('#sp-id-'+_id).html());
		$('#treatmentdate-'+_id).val($('#sp-treatmentdate-'+_id).html());
		$('#qty-'+_id).val($('#sp-qty-'+_id).html());
		$('#status-'+_id).val($('#sp-status-'+_id).html());
		$('#id-'+_id).show();
		$('#treatmentdate-'+_id).show();
		$('#qty-'+_id).show();
		$('#status-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _id = $('#id-'+_id).val();
			var _treatmentdate = $('#treatmentdate-'+_id).val();
			var _qty = $('#qty-'+_id).val();
			var _status = $('#status-'+_id).val();

			$.post(_HOST+'App/updateTrdoingTreatment', {id:_id,treatmentdate:_treatmentdate,qty:_qty,status:_status}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-id-'+_id).show();
			$('#sp-treatmentdate-'+_id).show();
			$('#sp-qty-'+_id).show();
			$('#sp-status-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#sp-id-'+_id).hide();
			$('#treatmentdate-'+_id).hide();
			$('#qty-'+_id).hide();
			$('#status-'+_id).hide();
			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>
