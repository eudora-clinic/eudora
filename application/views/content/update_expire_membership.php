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
        		<div class="card-header card-header-primary">
            		<h4 class="card-title">Update Expire Membership</h4>
        		</div>
				<div class="card-body">
					<form id="form-add-employee" method="post" action="<?= base_url().'App/updateExpireMembership' ?>">
						<div class="row">
							<div class="col-md-6">
								<?php 
								$pesan = $this->session->flashdata('pesan');
								if (!isset($pesan)) { ?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<i class="material-icons">close</i>
									</button>
									<span>1. Sebelum melakukan update harap dibackup dulu.</span>
									<span>2. Proses update tidak bisa dikembalikan.</span>
								</div>
								<?php } ?>
								<?php 
									//$pesan = $this->session->flashdata('pesan');

									if (isset($pesan) && $pesan != '') { 
										echo '<div class="alert alert-info">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>
													<b> Info - </b>'.$pesan.'</span>
												</div>';
									} else {
										echo '';
									}
								?>
							</div>
						</div>
						<div class="row" style="margin-top: 15px; margin-left: 5px;">
							<button type="submit" id="btn-proses" class="col-md-4 btn btn-sm btn-info" onclick="var comf = confirm('Anda yakin?'); if (!comf) return false;"><i class="fa fa-setting"></i> Proses Update Expire Membership</button>
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

</script>
