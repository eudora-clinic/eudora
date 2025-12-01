<?php 
$db_oriskin = $this->load->database('oriskin', true);

$msc = $db_oriskin->query("select * from mscustomer where id = '".$id_ref."' ")->row();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background-color: #95561e63;">
                    <h4 class="card-title text-center"><b>FORM KONSULTASI DOKTER</b></h4>
                </div>
                <div class="card-body">

                    <div class="row gx-4">
                        <div class="col-md-12 mt-3">
                        </div>
                        <div class="col-md-12 mt-3">

                            <!-- Tab panes -->
                            <form action="<?= base_url('App/proses_resep_dokter') ?>" method="post" target="_blank">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" name="tgl" value="<?= date('d-m-Y') ?>" placeholder="Tanggal" readonly>
                                    </div>

                                    <div class="col">
                                        <input type="text" class="form-control" name="id_member" value="<?= $id_ref ?>" placeholder="No. ID Member" readonly>
                                    </div>

                                    <!-- SESI Detail Pasien -->
                                        <div class="col-md-12">
                                            <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                                <h4 class="card-title text-dark"><b>Detail Pasien</b></h4>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="nama_lengkap" value="<?= $msc->firstname . $msc->lastname ?>" placeholder="Nama Lengkap" readonly>
                                            <select name="jk" class="form-control" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="Laki - Laki">Laki - Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="alamat" value="<?= $msc->address ?>" placeholder="Alamat" readonly>
                                            <input type="text" class="form-control" name="tb_bb" placeholder="TB/BB" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="no_tlp" value="<?= $msc->cellphonenumber ?>" placeholder="No. Telp" readonly>
                                            <input type="text" class="form-control" name="usia" placeholder="Usia" required>
                                        </div>
                                    <!-- END SESI Detail Pasien -->

                                    <!-- SESI Anamnesa -->
                                        <div class="col-md-12">
                                            <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                                <h4 class="card-title dark-white"><b>Anamnesa</b></h4>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <label for="" class="mr-5">Jenis Kulit</label>

                                                <div class="d-inline ml-5">
                                                    <label class="form-check-label checkbox_jk">
                                                        <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Normal" required>
                                                        Normal
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>

                                                    <label class="form-check-label checkbox_jk">
                                                        <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Kering" required>
                                                        Kering
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>

                                                    <label class="form-check-label checkbox_jk">
                                                        <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Berminyak" required>
                                                        Berminyak
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>

                                                    <label class="form-check-label checkbox_jk">
                                                        <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Kombinasi" required>
                                                        Kombinasi
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>

                                                    <label class="form-check-label checkbox_jk">
                                                        <input class="form-check-input" name="jenis_kulit[]" type="checkbox" value="Sensitif" required>
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

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="pemakaian_produk_skincare" placeholder="Pemakaian Produk Skincare" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="treatment" placeholder="Treatment" required>
                                        </div>

                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="penyakit" placeholder="penyakit" required>
                                        </div>

                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="permasalahan_kulit" placeholder="Permasalahan Kulit" required>
                                        </div>
                                    <!-- END SESI Anamnesa -->

                                    <!-- SESI Rekomendasi (Treatment) -->
                                        <div class="col-md-12">
                                            <div class="card-header mt-3 mb-3" style="background-color: #95561e63;">
                                                <h4 class="card-title dark-white"><b>Rekomendasi (Treatment)</b></h4>
                                            </div>
                                        </div>
                                        
                                        <!-- COMENT CHECKBOX AURA PLUS -->
                                            <div class="col-md-4">
                                                <div>
                                                    <!-- <label for=""><b class="text-dark">AURA PLUS</b></label> -->
                                                    <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal_aura_plus" style="background-color: #bd9675;"><b>AURA PLUS</b></button>
                                                </div>

                                                <!-- MODAL AURA PLUS -->
                                                    <div class="modal fade" id="modal_aura_plus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background: #d6bdaa!important;">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><b>AURA PLUS</b></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <?php foreach($data_ap as $row){ ?>
                                                                                <div class="col-md-4">
                                                                                    <label class="form-check-label checkbox_aura_plus" style="font-size: 12px !important;">
                                                                                        <input class="form-check-input" name="aura_plus[]" type="checkbox" value="<?= $row['TREATMENTID'] ?>" onchange="aura_plus<?= $row['TREATMENTID'] ?>(this)">
                                                                                        <?= $row['TREATMENTNAME'] ?>
                                                                                        <span class="form-check-sign">
                                                                                            <span class="check"></span>
                                                                                        </span>
                                                                                    </label>

                                                                                    <input type="number" name="qty_aura_plus[<?= $row['TREATMENTID'] ?>]" id="qty_aura_plus<?= $row['TREATMENTID'] ?>" placeholder="Masukan QTY" style="display:none;">
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- END MODAL AURA PLUS -->
                                            </div>
                                        <!-- END COMENT CHECKBOX AURA PLUS -->

                                        <!-- COMENT CHECKBOX BEAUTY PLUS -->
                                            <div class="col-md-4">
                                                <div>
                                                    <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal_beauty_plus" style="background-color: #bd9675;"><b>BEAUTY PLUS</b></button>
                                                </div>

                                                <!-- MODAL BEAUTY PLUS -->
                                                    <div class="modal fade" id="modal_beauty_plus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background: #d6bdaa!important;">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><b>BEAUTY PLUS</b></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <?php foreach($data_bp as $row){ ?>
                                                                                <div class="col-md-4">
                                                                                    <label class="form-check-label checkbox_beauty_plus" style="font-size: 12px !important;">
                                                                                        <input class="form-check-input" name="beauty_plus[]" type="checkbox" value="<?= $row['TREATMENTID'] ?>" onchange="beauty_plus<?= $row['TREATMENTID'] ?>(this)">
                                                                                        <?= $row['TREATMENTNAME'] ?>
                                                                                        <span class="form-check-sign">
                                                                                            <span class="check"></span>
                                                                                        </span>
                                                                                    </label>

                                                                                    <input type="number" name="qty_beauty_plus[<?= $row['TREATMENTID'] ?>]" id="qty_beauty_plus<?= $row['TREATMENTID'] ?>" placeholder="Masukan QTY" style="display:none;">
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- END MODAL BEAUTY PLUS -->
                                            </div>
                                        <!-- END COMENT CHECKBOX BEAUTY PLUS -->
                                        
                                        <!-- COMENT CHECKBOX MPS -->
                                            <div class="col-md-4">
                                                <div>
                                                    <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal_mps" style="background-color: #bd9675;"><b>MPS</b></button>
                                                </div>

                                                <!-- MODAL MPS -->
                                                    <div class="modal fade" id="modal_mps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background: #d6bdaa!important;">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><b>MPS</b></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                
                                                                <div class="modal-body">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <?php foreach($data_mps as $row){ ?>
                                                                                <div class="col-md-4">
                                                                                    <label class="form-check-label checkbox_mps" style="font-size: 12px !important;">
                                                                                        <input class="form-check-input" name="mps[]" type="checkbox" value="<?= $row['TREATMENTID'] ?>" onchange="mps<?= $row['TREATMENTID'] ?>(this)">
                                                                                        <?= $row['TREATMENTNAME'] ?>
                                                                                        <span class="form-check-sign">
                                                                                            <span class="check"></span>
                                                                                        </span>
                                                                                    </label>

                                                                                    <input type="number" name="qty_mps[<?= $row['TREATMENTID'] ?>]" id="qty_mps<?= $row['TREATMENTID'] ?>" placeholder="Masukan QTY" style="display:none;">
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- END MODAL MPS -->
                                            </div>
                                        <!-- END COMENT CHECKBOX MPS -->
                                    <!-- END SESI Rekomendasi (Treatment) -->

                                    <div class="col-md-12 mt-5">
                                        <label for="" class="mb-0 btn-sm text-white" style="cursor: auto; position: relative; z-index: 1; background-color: #bd9675;"><b>Notes</b></label>
                                        <div style="border: solid #95561e63 1px; border-radius: 14px; position: relative; bottom: 18px; padding: 15px;">
                                            <textarea name="notes" class="form-control" rows="8" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-block" data-toggle="modal" data-target="#modal_submit" style="background-color: #95561e63;">Submit</button>
                                    </div>

                                    <!-- MODAL SUBMIT -->
                                        <div class="modal fade" id="modal_submit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background: #d6bdaa!important;">
                                                        <h5 class="modal-title" id="exampleModalLabel"><b>ANNOUNCEMENT</b></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    
                                                    <div class="modal-body">
                                                        <div class="alert alert-warning text-center" role="alert">
                                                            <b>Pastikan data sudah terisi dengan benar !!</b>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn" style="background-color: #95561e63;">Oke</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- END MODAL SUBMIT -->

                                    <!-- <div class="col-md-12">
                                        <div class="row justify-content-end">
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header bg-primary">
                                                        <h4 class="card-title text-center text-white"><b>Tanda Tangan Dokter</b></h4>
                                                    </div>

                                                    <div class="card-body">
                                                        <div style="margin-bottom: 6rem;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </form>

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

        // $(function(){
        //     var requiredCheckboxes = $('.checkbox_aura_plus :checkbox[required]');
        //     requiredCheckboxes.change(function(){
        //         if(requiredCheckboxes.is(':checked')) {
        //             requiredCheckboxes.removeAttr('required');
        //         } else {
        //             requiredCheckboxes.attr('required', 'required');
        //         }
        //     });
        // });
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

        // $(function(){
        //     var requiredCheckboxes = $('.checkbox_beauty_plus :checkbox[required]');
        //     requiredCheckboxes.change(function(){
        //         if(requiredCheckboxes.is(':checked')) {
        //             requiredCheckboxes.removeAttr('required');
        //         } else {
        //             requiredCheckboxes.attr('required', 'required');
        //         }
        //     });
        // });
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

        // $(function(){
        //     var requiredCheckboxes = $('.checkbox_mps :checkbox[required]');
        //     requiredCheckboxes.change(function(){
        //         if(requiredCheckboxes.is(':checked')) {
        //             requiredCheckboxes.removeAttr('required');
        //         } else {
        //             requiredCheckboxes.attr('required', 'required');
        //         }
        //     });
        // });
    // END MPS
</script>