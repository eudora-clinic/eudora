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
            		<h4 class="card-title">Update Payment</h4>
        		</div>
				<div class="card-body">
					<div class="toolbar">
						<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="row">
								<label class="col-md-2 col-form-label">Payment ID</label>
								<div class="col-md-4">
									<div class="form-group bmd-form-group">
										<input type="text" id="paymentid" name="paymentid" class="form-control" required="true" aria-required="true" placeholder="ketik no Payment yang akan dicari" value="<?= (isset($_GET['paymentid']) ? $_GET['paymentid'] : '') ?>">
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
								$paymentid = $this->input->get('paymentid');
								# load database oriskin (lihat di config/database.php)
								$db_oriskin = $this->load->database('oriskin', true);
								# query
								$query = $db_oriskin->query("select  id,name, isactive from mspaymenttype where id = '".$paymentid."' order by id DESC");
								if ($query->num_rows() <= 0) {
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>No. Invoice <strong>'.$paymentid.'</strong> tidak ditemukan</span>
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
											<th width="20%" class="second-col sticky-col"><b>NAME</b></th>
											<th width="20%" class="second-col sticky-col"><b>STATUS</b></th>
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
																<span id="sp-name-'.$v['id'].'">'.$v['name'].'</span>
																<input type="text" id="name-'.$v['id'].'" value="'.$v['name'].'" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-isactive-'.$v['id'].'">'.$v['isactive'].'</span>
																<input type="text" id="isactive-'.$v['id'].'" value="'.$v['isactive'].'" style="width: 100%; display: none;">
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
		$('#sp-isactive-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#isactive-'+_id).val($('#sp-isactive-'+_id).html());
		$('#isactive-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _id = $('#id-'+_id).val();
			var _isactive = $('#isactive-'+_id).val();
			
			$.post(_HOST+'App/updateExistingvalue', {id:_id,isactive:_isactive}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-isactive-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#isactive-'+_id).hide();
			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>
