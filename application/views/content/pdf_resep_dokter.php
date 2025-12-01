<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>favicon.ico">
	<link rel="icon" type="image/ico" href="<?=base_url()?>favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ELECTRONIC MEDICAL RECORD</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<!--Fonts and icons-->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<!-- CSS Files -->
	<!--<link href="<?=base_url()?>assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />-->
	<link href="<?=base_url()?>assets/css/material-dashboard.min.css?v=2.1.0" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.css" rel="stylesheet"/>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="<?=base_url()?>assets/js/plugins/timepicker.min.js"></script>

	<!--<link href="<?=base_url()?>assets/demo/demo.css" rel="stylesheet" />-->
	<style>
		/*untuk hide scrolbar browser*/
		::-webkit-scrollbar {
			width: 0px;
			background: transparent;  /*make scrollbar transparent */
		}
		/*jika menggunakan material-dashboard.css?v=2.1.1, free version
		uncomment..
		.sidebar .nav li a, .sidebar .nav li .dropdown-menu a {
		  padding-left: 10px;
		  padding-right: 10px;
		}
		.sidebar .logo a.logo-mini {
			opacity: 1;
			float: left;
			width: 30px;
			text-align: center;
			margin-left: 23px;
			margin-right: 15px;
		}
		.sidebar .logo .simple-text {
		  text-align: left;
		}
		*/
		.modal-header, .modal-header h4 {
		  background: linear-gradient(60deg,#ab47bc,#8e24aa);
		  color:white !important;
		  text-align: center;
		}
		.modal-dialog .modal-header {
		  padding: 1rem;
		}
		.modal-header .close {
		  color:white !important;
		}
		.modal-footer {
		  background-color: #f9f9f9;
		}
		#loading-status {
		  position:fixed;
		  top:40%;
		  right:40%;
		  background-color:#FFF;
		  border:3px solid #000;
		  padding:5px 7px;
		  border-radius:5px;
		  -moz-border-radius: 5px;
		  -webkit-border-radius: 5px;
		  z-index: 10000000 !important;
		  display:none;
		}
		.rata-kanan,table td.rata-kanan {
		  text-align : right;
		}
		.kolom-default,table td.kolom-default {
		  background-color: #999;
		}
		.kolom-biru,table td.kolom-biru {
		  background-color: #00bcd4;
		}
	</style>

	<script> 
		//variable global
		var _HOST = "<?=base_url()?>";
	</script>
</head>
<body class="bg-white">
<?php 
    $db_oriskin = $this->load->database('oriskin', true);
    $rd = $db_oriskin->query("select * from resep_dokter where id_member = '".$id_member."' ")->row();

    $ard = $db_oriskin->query("
        select * from aura_plus_rd as a
        join mstreatment as b 
        on a.aura_plus=b.id
        where a.id_member = '".$id_member."' 
        and a.kode_resep = '".$kode_resep."'
    ")->result_array();

    $brd = $db_oriskin->query("
        select * from beauty_plus_rd as a
        join mstreatment as b 
        on a.beauty_plus=b.id
        where a.id_member = '".$id_member."' 
        and a.kode_resep = '".$kode_resep."'
    ")->result_array();

    $mrd = $db_oriskin->query("
        select * from mps_rd as a
        join mstreatment as b 
        on a.mps=b.id
        where a.id_member = '".$id_member."' 
        and a.kode_resep = '".$kode_resep."'
    ")->result_array();
?>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-3">
                <img src="<?= base_url('assets/img/ORISKINLOGOWATERMARK.png') ?>" alt="" width="150">
            </div>

            <div class="col-md-6 mt-3">
                <h3 class="text-center"><b>FORM KONSULTASI DOKTER</b></h2>
            </div>

            <div class="col-md-12 mt-3">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">

                        <div class="row">
                            <div class="col-md-6">
                                <span>Tanggal: </span> <u><?= $tgl ?></u>
                            </div>

                            <div class="col-md-6 text-right">
                                <span>No. ID Member: </span> <u><?= $id_member ?></u>
                            </div>

                            <!-- SESI Detail Pasien -->
                                <div class="col-md-12">
                                    <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                        <h4 class="card-title text-dark mb-0"><b>Detail Pasien</b></h4>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 130px;">Nama Lengkap</td>
                                            <td><input type="text" class="form-control" value="<?= $nama_lengkap ?>" disabled></td>
                                        </tr>

                                        <tr>
                                            <td style="width: 130px;">Jenis Kelamin</td>
                                            <td><input type="text" class="form-control" value="<?= $jk ?>" disabled></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-4">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 80px;">Usia</td>
                                            <td><input type="text" class="form-control" value="<?= $usia ?>" disabled></td>
                                        </tr>

                                        <tr>
                                            <td style="width: 80px;">TB/BB</td>
                                            <td><input type="text" class="form-control" value="<?= $jk ?>" disabled></td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-4">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td style="width: 90px;">Alamat</td>
                                            <td><input type="text" class="form-control" value="<?= $alamat ?>" disabled></td>
                                        </tr>

                                        <tr>
                                            <td style="width: 90px;">No. Telp</td>
                                            <td><input type="text" class="form-control" value="<?= $no_tlp ?>" disabled></td>
                                        </tr>
                                    </table>
                                </div>
                            <!-- END SESI Detail Pasien -->

                            <!-- SESI Anamnesa -->
                                <div class="col-md-12">
                                    <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                        <h4 class="card-title dark-white mb-0"><b>Anamnesa</b></h4>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-check">
                                        <label for="" class="mr-5">Jenis Kulit</label>
                                        <?php
                                            $selectedValues = $jenis_kulit;
                                            $jenisKulitValues = explode(",", $selectedValues);
                                        ?>

                                        <div class="d-inline ml-5">
                                            <label class="form-check-label checkbox_jk">
                                                <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Normal" <?= in_array("Normal", $jenisKulitValues) ? "checked" : "" ?> required>
                                                Normal
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>

                                            <label class="form-check-label checkbox_jk">
                                                <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Kering" <?= in_array("Kering", $jenisKulitValues) ? "checked" : "" ?> required>
                                                Kering
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>

                                            <label class="form-check-label checkbox_jk">
                                                <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Berminyak" <?= in_array("Berminyak", $jenisKulitValues) ? "checked" : "" ?> required>
                                                Berminyak
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>

                                            <label class="form-check-label checkbox_jk">
                                                <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Kombinasi" <?= in_array("Kombinasi", $jenisKulitValues) ? "checked" : "" ?> required>
                                                Kombinasi
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>

                                            <label class="form-check-label checkbox_jk">
                                                <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Sensitif" <?= in_array("Sensitif", $jenisKulitValues) ? "checked" : "" ?> required>
                                                Sensitif
                                                <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for=""><b>Riwayat Sebelumnya</b></label>
                                </div>

                                <div class="col-md-8">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>
                                                <li><label for="">Pemakaian Produk Skincare</label></li>
                                            </td>
                                            <td style="width: 70%;">
                                                <input type="text" class="form-control ml-3" value="<?= $pemakaian_produk_skincare ?>" disabled>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <li><label for="">Treatment</label></li>
                                            </td>
                                            <td style="width: 70%;">
                                                <input type="text" class="form-control ml-3" value="<?= $treatment ?>" disabled>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <li><label for="">Penyakit</label></li>
                                            </td>
                                            <td style="width: 70%;">
                                                <input type="text" class="form-control ml-3" value="<?= $penyakit ?>" disabled>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <li><label for="">Permasalahan Kulit</label></li>
                                            </td>
                                            <td style="width: 70%;">
                                                <input type="text" class="form-control ml-3" value="<?= $permasalahan_kulit ?>" disabled>
                                            </td>
                                        </tr>
                                    </table>

                                    <input type="text" class="form-control ml-3" disabled style="width: 100%;">
                                    <input type="text" class="form-control ml-3" disabled style="width: 100%;">
                                </div>

                                <div class="col-md-4">
                                    <img src="<?= base_url('assets/img/face.png') ?>" alt="" width="300" style="border: solid #95561e63 1px; border-radius: 14px;">
                                </div>
                            <!-- END SESI Anamnesa -->

                            <!-- SESI Rekomendasi (Treatment) -->
                                <div class="col-md-12">
                                    <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                        <h4 class="card-title dark-white mb-0"><b>Rekomendasi (Treatment)</b></h4>
                                    </div>
                                </div>
                                
                                <!-- COMENT CHECKBOX AURA PLUS -->
                                    <div class="col-md-4">
                                        <div>
                                            <label for=""><b class="text-dark">AURA PLUS</b></label>
                                        </div>

                                        <?php foreach($ard as $row){ ?>
                                            <label class="form-check-label checkbox_aura_plus ml-3" style="font-size: 12px !important;">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <?= $row['name'] ?>
                                            </label>

                                            <div>
                                                <b>QTY:</b> <?= $row['qty_aura_plus'] ?>
                                            </div>
                                        <?php } ?>

                                    </div>
                                <!-- END COMENT CHECKBOX AURA PLUS -->

                                <!-- COMENT CHECKBOX BEAUTY PLUS -->
                                    <div class="col-md-4">
                                        <div>
                                            <label for=""><b class="text-dark">BEAUTY PLUS</b></label>
                                        </div>

                                        <?php foreach($brd as $row){ ?>
                                            <label class="form-check-label checkbox_aura_plus ml-3" style="font-size: 12px !important;">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <?= $row['name'] ?>
                                            </label>

                                            <div>
                                                <b>QTY:</b> <?= $row['qty_beauty_plus'] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <!-- END COMENT CHECKBOX BEAUTY PLUS -->
                                
                                <!-- COMENT CHECKBOX MPS -->
                                    <div class="col-md-4">
                                        <div>
                                            <label for=""><b class="text-dark">MPS</b></label>
                                        </div>

                                        <?php foreach($mrd as $row){ ?>
                                            <label class="form-check-label checkbox_aura_plus ml-3" style="font-size: 12px !important;">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <?= $row['name'] ?>
                                            </label>

                                            <div>
                                                <b>QTY:</b> <?= $row['qty_mps'] ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <!-- END COMENT CHECKBOX MPS -->
                            <!-- END SESI Rekomendasi (Treatment) -->

                            <div class="col-md-12 mt-5">
                                <label for="" class="mb-0 btn-sm text-white" style="cursor: auto; position: relative; z-index: 1; background-color: #bd9675;"><b>Notes</b></label>
                                <div style="border: solid #95561e63 1px; border-radius: 14px; position: relative; bottom: 18px; padding: 15px;">
                                    <textarea name="notes" class="form-control" rows="8" disabled><?= $notes ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row justify-content-end">
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-header" style="background-color: #95561e63;">
                                                <h4 class="card-title text-center mb-0 text-dark"><b>Tanda Tangan Dokter</b></h4>
                                            </div>

                                            <div class="card-body" style="border: solid #95561e63 1px;">
                                                <div style="margin-bottom: 6rem;"></div>
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
    </div>

    <script src="<?=base_url()?>assets/js/core/jquery.min.js"></script>

    <script>
        // JENIS KULIT
            $(function(){
                var requiredCheckboxes = $('.checkbox_jk :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
        // END JENIS KULIT

        // AURA PLUS
            <?php foreach($data_ap as $row){ ?>
                function aura_plus<?= $row['TREATMENTID'] ?>(checkbox) {
                    var input = document.getElementById("qty_aura_plus<?= $row['TREATMENTID'] ?>");
                    if (checkbox.checked) {
                        input.style.display = "block";
                        input.setAttribute("required", "true");
                    } else {
                        input.style.display = "none";
                        input.removeAttribute("required");
                    }
                }
            <?php } ?>

            $(function(){
                var requiredCheckboxes = $('.checkbox_aura_plus :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
        // END AURA PLUS

        // BEAUTY PLUS
            <?php foreach($data_bp as $row){ ?>
                function beauty_plus<?= $row['TREATMENTID'] ?>(checkbox) {
                    var input = document.getElementById("qty_beauty_plus<?= $row['TREATMENTID'] ?>");
                    if (checkbox.checked) {
                        input.style.display = "block";
                        input.setAttribute("required", "true");
                    } else {
                        input.style.display = "none";
                        input.removeAttribute("required");
                    }
                }
            <?php } ?>

            $(function(){
                var requiredCheckboxes = $('.checkbox_beauty_plus :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
        // END BEAUTY PLUS

        // MPS
            <?php foreach($data_mps as $row){ ?>
                function mps<?= $row['TREATMENTID'] ?>(checkbox) {
                    var input = document.getElementById("qty_mps<?= $row['TREATMENTID'] ?>");
                    if (checkbox.checked) {
                        input.style.display = "block";
                        input.setAttribute("required", "true");
                    } else {
                        input.style.display = "none";
                        input.removeAttribute("required");
                    }
                }
            <?php } ?>

            $(function(){
                var requiredCheckboxes = $('.checkbox_mps :checkbox[required]');
                requiredCheckboxes.change(function(){
                    if(requiredCheckboxes.is(':checked')) {
                        requiredCheckboxes.removeAttr('required');
                    } else {
                        requiredCheckboxes.attr('required', 'required');
                    }
                });
            });
        // END MPS
    </script>

    <script src="<?=base_url()?>assets/js/core/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/core/popper.min.js"></script>
	<script src="<?=base_url()?>assets/js/core/bootstrap-material-design.min.js"></script>
	<script src="<?=base_url()?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<!-- Plugin for the momentJs  -->
	<script src="<?=base_url()?>assets/js/plugins/moment.min.js"></script>
	<!--  Plugin for Sweet Alert -->
	<script src="<?=base_url()?>assets/js/plugins/sweetalert2.js"></script>
	<!-- Forms Validations Plugin -->
	<script src="<?=base_url()?>assets/js/plugins/jquery.validate.min.js"></script>
	<!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
	<script src="<?=base_url()?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>
	<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
	<script src="<?=base_url()?>assets/js/plugins/bootstrap-selectpicker.js"></script>
	<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
	<script src="<?=base_url()?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
	<!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
	<script src="<?=base_url()?>assets/js/plugins/jquery.dataTables.min.js"></script>
	<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
	<script src="<?=base_url()?>assets/js/plugins/bootstrap-tagsinput.js"></script>
	<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
	<script src="<?=base_url()?>assets/js/plugins/jasny-bootstrap.min.js"></script>
	<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
	<script src="<?=base_url()?>assets/js/plugins/fullcalendar.min.js"></script>
	<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
	<script src="<?=base_url()?>assets/js/plugins/jquery-jvectormap.js"></script>
	<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
	<script src="<?=base_url()?>assets/js/plugins/nouislider.min.js"></script>
	<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<!-- Library for adding dinamically elements -->
	<script src="<?=base_url()?>assets/js/plugins/arrive.min.js"></script>
	<!--  Google Maps Plugin    -->
	<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
	<!-- Chartist JS -->
	<script src="<?=base_url()?>assets/js/plugins/chartist.min.js"></script>
	<!--S:hendi-->
	<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
	<!--S:hendi-->
	<!--  Notifications Plugin    -->
	<script src="<?=base_url()?>assets/js/plugins/bootstrap-notify.js"></script>
	<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="<?=base_url()?>assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>-->
	<!--<script src="<?=base_url()?>assets/js/material-dashboard.min.js?v=2.1.0" type="text/javascript"></script>-->
	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="<?=base_url()?>assets/demo/demo.js"></script>
	<!-- Hendi -->
	<script src="<?=base_url()?>assets/js/initapp.js"></script>

    <script>
        window.print()
    </script>

    </body>
</html>
