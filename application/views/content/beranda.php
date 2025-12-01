<?php
  
?>
<style>
  .card .card-header.card-header-icon i, .card .card-header.card-header-text i {
    width: 33px;
    height: 33px;
    text-align: center;
    line-height: 33px;
    font-size: 24px;
  }
  .bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
    color: #fff;
  }
</style>
<div class="container-fluid">
<?php //if (isset($pesan)) { ?>
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<i class="material-icons">close</i>
		</button>
		<span>Welcome to Operational Clinic <strong><?=$this->session->userdata('nama_lengkap')?>...</strong></span>
	</div> 
<?php //} ?>
</div>
