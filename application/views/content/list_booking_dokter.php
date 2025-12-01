<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php 
    # display error
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    # unlimited time
    ini_set('max_execution_time', -1);
    ini_set('memory_limit', '-1');
    // Setting memory limit sql server to 10GB
    ini_set('sqlsrv.ClientBufferMaxKBSize','10485760');
    ini_set('pdo_sqlsrv.client_buffer_max_kb_size','10485760');
    # Penambahan select option job dan location
    # load database oriskin (lihat di config/database.php)

    $db_oriskin = $this->load->database('oriskin', true);

    $url_browser = $_SERVER['REQUEST_URI'];

    if(@$period == null){
        $period = '';
        $locationid = '';
    }

?>

<div class="container-fluid">
    <div class="row">
        <!-- SEARCH -->
            <div class="col-md-12">
                <form action="<?= base_url('search_list_booking') ?>" method="post" class="mb-0 form_search_list_booking">
                    <div class="row">
                        <input type="hidden" name="doingid_btc" class="val_doingid_btc">
                        <input type="hidden" name="doingid_dokter" class="val_doingid_dokter">
                        <input type="hidden" name="period_edit" value="<?= $period ?>">
                        <input type="hidden" name="locationid_edit" value="<?= $locationid ?>">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Search Tanggal</label>
                                <?php
                                    if (strpos($url_browser, '/reportanalystic/App/list_booking') !== false) {
                                        if (preg_match('/\/reportanalystic\/App\/list_booking\/(\d{4}-\d{2}-\d{2})\/(\d+)/', $url_browser, $matches)) {
                                            $selected_date = $matches[1];
                                            $selected_value = $matches[2];
                                    ?>
                                        <input type="date" name="period" class="form-control filter_period" value="<?= $selected_date ?>" required>
                                    <?php }else{ ?>
                                        <input type="date" name="period" class="form-control filter_period" value="<?= set_value('period') ?>" required>
                                    <?php
                                        }
                                    }else{
                                ?>
                                    <input type="date" name="period" class="form-control filter_period" value="<?= set_value('period') ?>" required>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-4" id="pilih_klinik_search">
                            <div class="form-group">
                                <?php 
                                    if (strpos($url_browser, '/reportanalystic/App/list_booking') !== false) {
                                        if (preg_match('/\/reportanalystic\/App\/list_booking\/(\d{4}-\d{2}-\d{2})\/(\d+)/', $url_browser, $matches)) {
                                            $selected_value = $matches[2];
                                        } else {
                                            $selected_value = '';
                                        }
                                    ?>
                                        <select name="locationid" id="lib_select1" class="form-control filter_locationid" required>
                                            <option value="">Pilih Klinik</option>
                                            <?php foreach ($klinik as $k) { ?>
                                                <option value="<?= $k['id'] ?>" <?= set_select('locationid', $k['id'], ($selected_value == $k['id'])); ?>><?= $k['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    <?php }else{ ?>
                                        <select name="locationid" id="lib_select1" class="form-control filter_locationid" required>
                                            <option value="">Pilih Klinik</option>
                                            <?php foreach ($klinik as $k) { ?>
                                                <option value="<?= $k['id'] ?>" <?= set_select('locationid', $k['id']); ?>><?= $k['name'] ?></option>
                                            <?php } ?>
                                        </select>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-sm btn-dark top-responsive search_list_booking"><i ></i> Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <!-- END SEARCH -->

        <div class="col-ma-12"></div>

        <!-- TABS DOKTER & BTC -->
            <div class="col-md-12 mt-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#btc">
                            BEAUTY THERAPIST
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#dokter">
                            DOKTER
                        </a>
                    </li>
                </ul>

                <!-- VIEW BATALKAN EDIT -->
                    <div class="row" style="display: none;" id="batalkan_edit">
                        <div class="col-md-8">
                            <h3>
                                Pilih Sesi dan Dokter/Therapis yg Available untuk Edit.
                            </h3>
                        </div>

                        <div class="col-md-4 float-left">
                            <button type="button" class="btn btn-danger mt-3" onclick="batalkan_edit()" style="float: right;">
                                Batalkan Edit 
                            </button>
                        </div>
                    </div>
                <!-- END VIEW BATALKAN EDIT -->
                
                <div class="tab-content p-0 mt-3">
                    <!-- TABS BTC -->
                        <div class="tab-pane show active" id="btc">
                            <div class="row">
                                <?php foreach ($data_tabs_btc as $row){ ?>
                                    <div class="col-md-4">
                                        <div class="card mt-0" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 14px;">
                                            <div class="card-header bg-info">
                                                <h3 class="card-title text-center text-white"><b><?= $row['waktu_btc']['TIMESTART'] ?> - <?= $row['waktu_btc']['TIMEFINISH'] ?></b></h3>

                                                <div class="d-flex justify-content-center">
                                                    <table class="text-white">
                                                        <tr>
                                                            <th>NEW</th>
                                                            <th>:</th>
                                                            <td><?= $row['result_slot_new'] ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th>LC</th>
                                                            <th>:</th>
                                                            <td><?= $row['result_slot_lc'] ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php 
                                                            foreach($row['data_btc'] as $dbtc){
                                                                $timestart = $dbtc['TIMESTART'];

                                                                if($dbtc['REMARKS'] == 'AVAILABLE'){
                                                                    $modal_list_btc         = '#modal_list_btc_available'.$dbtc['EMPLOYEEID'].$timestart.'';
                                                                    $class_modal_list_btc   = 'class="ubah_data_target_modal_list_btc_available"';
                                                                }else{
                                                                    $modal_list_btc         = '#modal_list_btc'.$dbtc['EMPLOYEEID'].$timestart .'';
                                                                    $class_modal_list_btc   = 'class="ubah_data_target_modal_list_btc"';
                                                                }
                                                        ?>

                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="<?= $modal_list_btc ?>" <?= $class_modal_list_btc ?> >
                                                                <div class="card mb-1 mt-1 <?php 
                                                                    if($dbtc['REMARKS'] == 'ON BOOKING' || $dbtc['REMARKS'] == 'ON PROGRESS' || $dbtc['REMARKS'] == 'FINISH'){
                                                                        echo "bg-danger";
                                                                    }elseif($dbtc['REMARKS'] == 'ON BOOKING' || $dbtc['REMARKS'] == 'ON PROGRESS'){
                                                                        echo "bg-danger";
                                                                    }elseif($dbtc['REMARKS'] == 'WAITING CONFIRMATION' || $dbtc['REMARKS'] == 'NOT CONFIRMATION' || $dbtc['REMARKS'] == 'WAITING CONFIRMATION'){
                                                                        echo "bg-warning";
                                                                    }elseif($dbtc['REMARKS'] == 'AVAILABLE'){
                                                                        echo "bg-success";
                                                                    }else{
                                                                        echo "bg-info";
                                                                    } ?>">

                                                                    <div class="card-body">
                                                                        <p class="mb-0 text-white">
                                                                            <b><?= $dbtc['EMPLOYEENAME'] ?></b>
                                                                        </p>
                                                                        <?php if(!$dbtc['CUSTOMERNAME'] == null){ ?>
                                                                            <p class="mb-0 text-white">
                                                                                <b style="font-weight: 700 !important;">CUSTOMERNAME:</b> <?= $dbtc['CUSTOMERNAME'] ?>
                                                                            </p>
                                                                        <?php } ?>
                                                                        <span class="badge badge-primary text-white badge_status_remark" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $dbtc['REMARKS'] ?>)</span>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            <!-- MODAL LIST BTC -->
                                                                <div class="modal fade modalHide_btc" id="modal_list_btc<?= $dbtc['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($dbtc['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <table class="table table-bordered text-center">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <th>CUSTOMERNAME</th>
                                                                                            <th>TREATMENTNAME</th>
                                                                                            <th>TIMESTART</th>
                                                                                            <th>QTY</th>
                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><?= $dbtc['CUSTOMERID'] ?></td>
                                                                                            <td><?= $dbtc['CUSTOMERNAME'] ?></td>
                                                                                            <td><?= $dbtc['TREATMENTNAME'] ?></td>
                                                                                            <td><?= $dbtc['TIMESTART'] ?></td>
                                                                                            <td><?= $dbtc['QTY'] ?></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <?php if($dbtc['REMARKS'] != 'AVAILABLE'){ ?>
                                                                                    <!-- dapetin value doingid nya buat di pindahkan -->
                                                                                    <input type="hidden" value="<?= $dbtc['DOINGID'] ?>" class="doingid_modal_btc">

                                                                                    <?php if($dbtc['REMARKS'] == 'WAITING CONFIRMATION' || $dbtc['REMARKS'] == 'ON BOOKING'){ ?>
                                                                                        <button type="button" class="btn btn-info ml-3 btn-sm btn-action" onclick="edit_doingid_btc(this); $('.modalHide_btc').modal('hide');">EDIT</button>
                                                                                    <?php } ?>
                                                                                    <button type="button" class="btn btn-primary ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 16)">START</button>
                                                                                    <button type="button" class="btn btn-success ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 17)">FINISH</button>
                                                                                    <?php if($dbtc['REMARKS'] != 'FINISH'){ ?>
                                                                                        <button type="button" class="btn btn-danger ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 3)">VOID</button>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL LIST BTC -->

                                                            <!-- MODAL LIST BTC AVAILABLE -->
                                                                <div class="modal fade" id="modal_list_btc_available<?= $dbtc['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($dbtc['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <form action="<?= base_url('app/proses_booking_btc') ?>" method="post">
                                                                                    <input type="hidden" name="employeeid_timestart_period_locationid" value="<?= $dbtc['EMPLOYEEID'].'_'.$timestart.'_'.$period.'_'.$locationid ?>" required>
                                                                                    <button type="submit" class="btn btn-success btn-block">Booking</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL LIST BTC AVAILABLE -->

                                                            <!-- MODAL EDIT -->
                                                                <div class="modal fade" id="modal_list_btc_available_edit<?= $dbtc['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($dbtc['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <form action="<?= base_url('App/edit_list_booking') ?>" method="post">
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="doingid" class="val_doingid_btc">
                                                                                    <input type="hidden" name="employeeid" value="<?= $dbtc['EMPLOYEEID'] ?>">
                                                                                    <input type="hidden" name="timestart" value="<?= $dbtc['TIMESTART'] ?>">
                                                                                    <input type="hidden" name="timefinish" value="<?= $dbtc['TIMEFINISH'] ?>">
                                                                                    <input type="hidden" name="period" value="<?= $period ?>">
                                                                                    <input type="hidden" name="locationid" value="<?= $locationid ?>">

                                                                                    <div class="alert alert-warning text-center text-dark" role="alert">
                                                                                        Apakah anda yakin ingin merubah data ini ??
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-info">Edit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL EDIT -->
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <!-- END TABS BTC -->

                    <!-- TABS DOKTER -->
                        <div class="tab-pane" id="dokter">
                            <div class="row">
                                <?php foreach ($data_tabs_dokter as $row) {?>
                                    <div class="col-md-4">
                                        <div class="card mt-0" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 14px;">
                                            <div class="card-header bg-info">
                                                <h3 class="card-title text-center text-white"><b><?= $row['waktu_dokter']['TIMESTART'] ?> - <?= $row['waktu_dokter']['TIMEFINISH'] ?></b></h3>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <?php 
                                                            foreach($row['data_dokter'] as $ddokter){
                                                                $timestart = $ddokter['TIMESTART'];

                                                                if($ddokter['REMARKS'] == 'AVAILABLE'){
                                                                    $modal_list_dokter         = '#modal_list_dokter_available'.$ddokter['EMPLOYEEID'].$timestart.'';
                                                                    $class_modal_list_dokter   = 'class="ubah_data_target_modal_list_dokter_available"';
                                                                }else{
                                                                    $modal_list_dokter         = '#modal_list_dokter'.$ddokter['EMPLOYEEID'].$timestart .'';
                                                                    $class_modal_list_dokter   = 'class="ubah_data_target_modal_list_dokter"';
                                                                }
                                                        ?>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="<?= $modal_list_dokter ?>" <?= $class_modal_list_dokter ?> >
                                                                <div class="card mb-1 mt-1 <?php 
                                                                    if($ddokter['REMARKS'] == 'ON BOOKING' || $ddokter['REMARKS'] == 'ON PROGRESS' || $ddokter['REMARKS'] == 'FINISH'){
                                                                        echo "bg-danger";
                                                                    }elseif($ddokter['REMARKS'] == 'ON BOOKING' || $ddokter['REMARKS'] == 'ON PROGRESS'){
                                                                        echo "bg-danger";
                                                                    }elseif($ddokter['REMARKS'] == 'WAITING CONFIRMATION' || $ddokter['REMARKS'] == 'NOT CONFIRMATION' || $ddokter['REMARKS'] == 'WAITING CONFIRMATION'){
                                                                        echo "bg-warning";
                                                                    }elseif($ddokter['REMARKS'] == 'AVAILABLE'){
                                                                        echo "bg-success";
                                                                    }else{
                                                                        echo "bg-info";
                                                                    } ?>">

                                                                    <div class="card-body">
                                                                        <p class="mb-0 text-white">
                                                                            <b><?= $ddokter['EMPLOYEENAME'] ?></b>
                                                                        </p>
                                                                        <?php if(!$ddokter['CUSTOMERNAME'] == null){ ?>
                                                                            <p class="mb-0 text-white">
                                                                                <b style="font-weight: 700 !important;">CUSTOMERNAME:</b> <?= $ddokter['CUSTOMERNAME'] ?>
                                                                            </p>
                                                                        <?php } ?>
                                                                        <span class="badge badge-primary text-white" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $ddokter['REMARKS'] ?>)</span>
                                                                    </div>
                                                                </div>
                                                            </a>

                                                            <!-- MODAL LIST DOKTER -->
                                                                <div class="modal fade modalHide_dokter" id="modal_list_dokter<?= $ddokter['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($ddokter['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <table class="table table-bordered text-center">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>ID</th>
                                                                                            <th>CUSTOMERNAME</th>
                                                                                            <th>TREATMENTNAME</th>
                                                                                            <th>QTY</th>
                                                                                        </tr>
                                                                                    </thead>

                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td><?= $ddokter['CUSTOMERID'] ?></td>
                                                                                            <td><?= $ddokter['CUSTOMERNAME'] ?></td>
                                                                                            <td><?= $ddokter['TREATMENTNAME'] ?></td>
                                                                                            <td><?= $ddokter['QTY'] ?></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            
                                                                            <div class="modal-footer">
                                                                                <?php if($ddokter['REMARKS'] != 'AVAILABLE'){ ?>
                                                                                    <!-- dapetin value doingid nya buat di pindahkan -->
                                                                                    <input type="hidden" value="<?= $ddokter['DOINGID'] ?>" class="doingid_modal_dokter">

                                                                                    <?php if($ddokter['REMARKS'] == 'WAITING CONFIRMATION' || $ddokter['REMARKS'] == 'ON BOOKING'){ ?>
                                                                                        <button type="button" class="btn btn-info ml-3 btn-sm btn-action" onclick="edit_doingid_dokter(this); $('.modalHide_dokter').modal('hide');">EDIT</button>
                                                                                    <?php } ?>
                                                                                    <button type="button" class="btn btn-primary ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 16)">START</button>
                                                                                    <button type="button" class="btn btn-success ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 17)">FINISH</button>
                                                                                    <?php if($ddokter['REMARKS'] != 'FINISH'){ ?>
                                                                                        <button type="button" class="btn btn-danger ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 3)">VOID</button>
                                                                                    <?php } ?>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL LIST DOKTER -->

                                                            <!-- MODAL LIST DOKTER AVAILABLE -->
                                                                <div class="modal fade" id="modal_list_dokter_available<?= $ddokter['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($ddokter['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <div class="modal-body">
                                                                                <form action="<?= base_url('app/proses_booking_dokter') ?>" method="post">
                                                                                    <input type="hidden" name="employeeid_timestart_period_locationid" value="<?= $ddokter['EMPLOYEEID'].'_'.$timestart.'_'.$period.'_'.$locationid ?>" required>
                                                                                    <button type="submit" class="btn btn-success btn-block">Booking</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL LIST DOKTER AVAILABLE -->

                                                            <!-- MODAL EDIT -->
                                                                <div class="modal fade" id="modal_list_dokter_available_edit<?= $ddokter['EMPLOYEEID'].$timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog <?php if($ddokter['REMARKS'] != 'AVAILABLE'){echo 'modal-lg';} ?>" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>

                                                                            <form action="<?= base_url('App/edit_list_booking') ?>" method="post">
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="doingid" class="val_doingid_dokter"> <br><br>
                                                                                    <input type="hidden" name="employeeid" value="<?= $ddokter['EMPLOYEEID'] ?>"> <br><br>
                                                                                    <input type="hidden" name="timestart" value="<?= $ddokter['TIMESTART'] ?>"> <br><br>
                                                                                    <input type="hidden" name="timefinish" value="<?= $ddokter['TIMEFINISH'] ?>"> <br><br>
                                                                                    <input type="hidden" name="period" value="<?= $period ?>"> <br><br>
                                                                                    <input type="hidden" name="locationid" value="<?= $locationid ?>"> <br><br>

                                                                                    <div class="alert alert-warning text-center text-dark" role="alert">
                                                                                        Apakah anda yakin ingin merubah data ini ??
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-info">Edit</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <!-- END MODAL EDIT -->
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <!-- END TABS DOKTER -->
                </div>
            </div>
        <!-- END TABS DOKTER & BTC -->
    </div>
</div>

<script>
    // EDIT
        // BTC
            function edit_doingid_btc(button) {
                // PINDAHIN VALUE
                    var val_doingid_btc = $(button).siblings('.doingid_modal_btc').val();
                    
                    $(".val_doingid_btc").val(val_doingid_btc);
                // END PINDAHIN VALUE

                // UBAH DATA TARGET MENJADI NONE
                    var class_ubah_data_target_modal_list_btc = document.querySelectorAll('.ubah_data_target_modal_list_btc');

                    class_ubah_data_target_modal_list_btc.forEach(function(data_target_modal_list_btc) {
                        var currentTarget = data_target_modal_list_btc.getAttribute('data-target');
                        var time = currentTarget.substr(currentTarget.length - 5);
                        var newTarget = '#none';

                        data_target_modal_list_btc.setAttribute('data-target', newTarget);
                    });
                // END UBAH DATA TARGET MENJADI NONE

                // UBAH ID MODAL LIST BTC AVAILABLE MENJADI MODAL UNTUK EDIT
                    var class_ubah_data_target_modal_list_btc_available = document.querySelectorAll('.ubah_data_target_modal_list_btc_available');

                    class_ubah_data_target_modal_list_btc_available.forEach(function(data_target_modal_list_btc_available) {
                        var currentTarget = data_target_modal_list_btc_available.getAttribute('data-target');
                        var newTarget = currentTarget.replace(/modal_list_btc_available/, 'modal_list_btc_available_edit');

                        data_target_modal_list_btc_available.setAttribute('data-target', newTarget);
                    });
                // END UBAH ID MODAL LIST BTC AVAILABLE MENJADI MODAL UNTUK EDIT

                // MANIPULASI SEARCH BTC
                    var form                    = $('.form_search_list_booking');
                    var element_pilih_klinik    = document.getElementById("pilih_klinik_search");

                    form.attr('action', '<?= base_url("search_list_booking_edit") ?>');
                    element_pilih_klinik.style.display = "none";
                // END MANIPULASI SEARCH BTC

                // BATALKAN EDIT
                    var element = document.getElementById("batalkan_edit");
                    if (element.style.display === "none") {
                        element.style.display = "";
                    } else {
                        element.style.display = "none";
                    }
                // END BATALKAN EDIT
            }
        // END BTC

        // DOKTER
            function edit_doingid_dokter(button) {
                // PINDAHIN VALUE
                    var val_doingid_dokter = $(button).siblings('.doingid_modal_dokter').val();
                    
                    $(".val_doingid_dokter").val(val_doingid_dokter);
                // END PINDAHIN VALUE

                // MODAL LIST DOKTER
                    var class_ubah_data_target_modal_list_dokter = document.querySelectorAll('.ubah_data_target_modal_list_dokter');

                    class_ubah_data_target_modal_list_dokter.forEach(function(data_target_modal_list_dokter) {
                        var currentTarget = data_target_modal_list_dokter.getAttribute('data-target');
                        var time = currentTarget.substr(currentTarget.length - 5);
                        var newTarget = '#none';

                        data_target_modal_list_dokter.setAttribute('data-target', newTarget);
                    });
                // END MODAL LIST DOKTER

                // MODAL LIST DOKTER AVAILABLE
                    var class_ubah_data_target_modal_list_dokter_available = document.querySelectorAll('.ubah_data_target_modal_list_dokter_available');

                    class_ubah_data_target_modal_list_dokter_available.forEach(function(data_target_modal_list_dokter_available) {
                        var currentTarget = data_target_modal_list_dokter_available.getAttribute('data-target');
                        var newTarget = currentTarget.replace(/modal_list_dokter_available/, 'modal_list_dokter_available_edit');

                        data_target_modal_list_dokter_available.setAttribute('data-target', newTarget);
                    });
                // END MODAL LIST DOKTER AVAILABLE

                // MANIPULASI SEARCH DOKTER
                    var form                    = $('.form_search_list_booking');
                    var element_pilih_klinik    = document.getElementById("pilih_klinik_search");

                    form.attr('action', '<?= base_url("search_list_booking_edit") ?>');
                    element_pilih_klinik.style.display = "none";
                // END MANIPULASI SEARCH DOKTER

                // BATALKAN EDIT
                    var element = document.getElementById("batalkan_edit");
                    if (element.style.display === "none") {
                        element.style.display = "";
                    } else {
                        element.style.display = "none";
                    }
                // END BATALKAN EDIT
            }
        // END DOKTER
        
        function batalkan_edit() {
            location.reload();
        }
    // END EDIT
</script>


<script>
    function updateStatus(doingId, newStatus) {
        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            $.post(_HOST + 'App/updateTrDoingTreatmentStatus', { id: doingId, status: newStatus }, function(result) {
                alert(result);
                location.reload();
            });
        }
    }
</script>