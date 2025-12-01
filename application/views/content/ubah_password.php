<?php
    #created by Hendi
    #2019-08-12
?>
<form id="ubah-password-form" class="form-horizontal" action="<?=base_url()?>App/setPassword" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="margin-top: 0;margin-bottom: 10px;">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">repeat</i>
                        </div>
                        <h4 class="card-title">Ubah Password</h4>
                    </div>
                    <div class="card-body">
                        <input type="text" name="sts" value="edit" hidden> 
                        <div class="row">
                            <label class="col-md-4 col-form-label">Password Lama</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="password" name="password_lama" class="form-control" required="true" aria-required="true" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-4 col-form-label">Password Baru</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="password" name="password_baru" class="form-control" required="true" aria-required="true" value="">
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <label class="col-md-4 col-form-label">Konfirmasi Password</label>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <input type="password" name="konfirmasi_password" class="form-control" required="true" aria-required="true" value="">
                                </div>
                            </div>
                        </div>         
                    </div>
                    <div class="card-footer ml-auto">
                        <button type="submit" class="btn btn-rose pull-right"><span class="btn-label"><i class="material-icons">check</i></span> Simpan</button>
                        <button type="button" class="btn btn-default pull-right" onclick="window.location=_HOST;"><span class="btn-label"><i class="material-icons">undo</i></span> Tutup</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</form>
<script>
    //_mod dideklarasikan di initapp juga method submitnya.
    _mod = '<?=$mod?>';
</script>
