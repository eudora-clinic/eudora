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
ini_set('sqlsrv.ClientBufferMaxKBSize', '10485760');
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '10485760');
# Penambahan select option job dan location
# load database oriskin (lihat di config/database.php)

$db_oriskin = $this->load->database('oriskin', true);

$url_browser = $_SERVER['REQUEST_URI'];
$location_id = $this->session->userdata('locationid');

if (@$period == null) {
    $period = '';
    $locationid = '';
}

$thisMonth = date('Y-m-d');
$datestart = (isset($_GET['period']) ? $this->input->get('period') : $thisMonth);

$yearMonth = date('Y-m', strtotime($period));
$dayOnly = date('d', strtotime($period));
?>

<style>
    .btn-primary {
        background-color: #e0bfb2 !important;
        color: #666666 !important;
        border: none;
        transition: background-color 0.3s ease;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <!-- SEARCH -->
        <div class="col-md-6 card p-2">
            <form action="<?= base_url('search_list_booking') ?>" method="post" class="mb-0 form_search_list_booking">
                <div class="hidden" id="pilih_klinik_search">
                    <div class="form-group">
                        <?php
                        if (strpos($url_browser, '/operationalactivity/App/list_booking') !== false) {
                            if (preg_match('/\/operationalactivity\/App\/list_booking\/(\d{4}-\d{2}-\d{2})\/(\d+)/', $url_browser, $matches)) {
                                $selected_value = $matches[2];
                            } else {
                                $selected_value = $location_id;
                            }
                        ?>
                            <?php { ?>
                                <option value="<?= $location_id ?>" <?= set_select('locationid', $location_id, ($selected_value == $location_id)); ?>></option>
                            <?php } ?>
                        <?php } else { ?>
                            <?php { ?>
                                <option value="<?= $location_id ?>" <?= set_select('locationid', $location_id); ?>></option>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <input type="hidden" name="doingid_btc" class="val_doingid_btc">
                <input type="hidden" name="doingid_dokter" class="val_doingid_dokter">
                <input type="hidden" name="period_edit" value="<?= $period ?>">
                <input type="hidden" name="locationid_edit" value="<?= $locationid ?>">
                <input type="hidden" name="locationid" class="form-control filter_period" value="<?= $location_id ?>" required>

                <div class="row g-3 ml-2 mb-3" style="display: flex; align-items: center;">

                    <div class="col-md-9 ">
                        <div class="form-group">
                            <label for="">Search Tanggal</label>

                            <input type="date" name="period" class="form-control filter_period" value="<?= $period ?>" required>

                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i> Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- END SEARCH -->

        <!-- TABS DOKTER & BTC -->
        <div class="col-md-12 mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#btc" style=" background-color: #e0bfb2; color: #666666;">
                        BEAUTY THERAPIST
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#dokter" style=" background-color: #e0bfb2; color: #666666;">
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

            <script>
                // Definisi variabel dari PHP ke JavaScript
                var $data_tabs_btc = <?php echo json_encode($data_tabs_btc); ?>;
                var $data_tabs_dokter = <?php echo json_encode($data_tabs_dokter); ?>;

                // Menampilkan data di console
                console.log($data_tabs_btc);
                console.log($data_tabs_dokter);
            </script>

            <div class="tab-content p-0 mt-3">
                <!-- TABS BTC -->
                <div class="tab-pane show active" id="btc">
                    <div class="row">
                        <?php foreach ($data_tabs_btc as $row) { ?>
                            <div class="col-md-4">
                                <div class="card mt-0" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 14px;">
                                    <div class="card-header" style="background-color: #8c5e4e;">
                                        <h3 class="card-title text-center text-white">
                                            <b><?= $row['waktu_btc']['TIMESTART'] ?> -
                                                <?= $row['waktu_btc']['TIMEFINISH'] ?></b>
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                foreach ($row['data_btc'] as $dbtc) {
                                                    $timestart = $dbtc['TIMESTART'];

                                                    if ($dbtc['REMARKS'] != "FOR TRIAL") {
                                                        $show_time = 0;
                                                    } else {
                                                        $show_time = 1;
                                                    }

                                                    if ($dbtc['REMARKS'] == 'AVAILABLE') {
                                                        $modal_list_btc = '#modal_list_btc_available' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_available"';
                                                    } else if ($dbtc['REMARKS'] == 'NOT AVAILABLE') {
                                                        $modal_list_btc = '#modal_list_btc_not_available' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_not_available"';
                                                    } else {
                                                        $modal_list_btc = '#modal_list_btc' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc"';
                                                    }
                                                ?>

                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="<?= $modal_list_btc ?>" <?= $class_modal_list_btc ?>>
                                                        <div class="card mb-1 mt-1 <?php
                                                                                    if ($dbtc['REMARKS'] == 'ON PROGRESS') {
                                                                                        echo "bg-primary";
                                                                                    } elseif ($dbtc['REMARKS'] == 'ON BOOKING' || $dbtc['REMARKS'] == 'FINISH') {
                                                                                        echo "bg-danger";
                                                                                    } elseif ($dbtc['REMARKS'] == 'WAITING CONFIRMATION' || $dbtc['REMARKS'] == 'NOT CONFIRMATION') {
                                                                                        echo "bg-warning";
                                                                                    } elseif ($dbtc['REMARKS'] == 'AVAILABLE') {
                                                                                        echo "bg-success";
                                                                                    } elseif ($dbtc['REMARKS'] == 'NOT AVAILABLE') {
                                                                                        echo "bg-secondary";
                                                                                    } else {
                                                                                        echo "bg-info";
                                                                                    }
                                                                                    ?>
                                                    ">

                                                            <div class="card-body">
                                                                <p class="mb-0 text-white">
                                                                    <b><?= $dbtc['EMPLOYEENAME'] ?></b>
                                                                </p>
                                                                <?php if (!$dbtc['CUSTOMERNAME'] == null) { ?>
                                                                    <p class="mb-0 text-white">
                                                                        <b style="font-weight: 700 !important;">CUSTOMERNAME:</b>
                                                                        <?= $dbtc['CUSTOMERNAME'] ?>
                                                                    </p>
                                                                <?php } ?>
                                                                <?php if (!$dbtc['CELLPHONENUMBER'] == null) { ?>
                                                                    <p class="mb-0 text-white">
                                                                        <b style="font-weight: 700 !important;">CELLPHONENUMBER:</b>
                                                                        <?= $dbtc['CELLPHONENUMBER'] ?>
                                                                    </p>
                                                                <?php } ?>

                                                                <span class="badge badge-primary text-white badge_status_remark" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $dbtc['REMARKS'] ?>)</span>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- MODAL LIST BTC -->
                                                    <div class="modal fade modalHide_btc" id="modal_list_btc<?= $dbtc['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($dbtc['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">DETAIL</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="table-responsive" style="border-top: 1px solid #dee2e6;">
                                                                        <table class="table table-bordered text-center">
                                                                            <thead class="fw-bold">
                                                                                <tr>
                                                                                    <th style="font-weight: bold;">ID</th>
                                                                                    <th style="font-weight: bold;">CUSTOMERNAME</th>
                                                                                    <th style="font-weight: bold;">CELLPHONE</th>
                                                                                    <th style="font-weight: bold;">TREATMENTNAME</th>
                                                                                    <th style="font-weight: bold;">TIMESTART</th>
                                                                                    <th style="font-weight: bold;">REMARKSBOOKING</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?= $dbtc['CUSTOMERID'] ?></td>
                                                                                    <td><?= $dbtc['CUSTOMERNAME'] ?></td>
                                                                                    <td><?= $dbtc['CELLPHONENUMBER'] ?></td>
                                                                                    <td><?= $dbtc['TREATMENTNAME'] ?></td>
                                                                                    <td><?= $dbtc['TIMESTART'] ?></td>
                                                                                    <td><?= $dbtc['QTY'] ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                    <div class="table-responsive" style="border-top: 1px solid #dee2e6;">
                                                                        <table class="table table-bordered text-center">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="font-weight: bold;">REMARKS</th>
                                                                                    <th style="font-weight: bold;">LAST CONSULTATION</th>
                                                                                    <th style="font-weight: bold;">HARI</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php if ($dbtc['REMARKS'] != 'AVAILABLE') { ?>
                                                                                    <input type="hidden" value="<?= $dbtc['DOINGID'] ?>" class="doingid_modal_btc">
                                                                                    <?php
                                                                                    $isDocterAbsen = $db_oriskin->query("SELECT ISNULL(employeeid, '') AS employeeid from msabsen where locationid = $location_id and period = '$yearMonth' and tgl_absen = '$dayOnly' and jobid= 12")->row()->employeeid ?? 0;
                                                                                    $lastConsultation = $db_oriskin->query("SELECT ISNULL(CONVERT(VARCHAR(10), MAX(treatmentdate), 120), '') AS lastconsultation FROM trdoingtreatment WHERE statusshowdokter2=1 AND status != 3 AND customerid = '" . $dbtc['CUSTOMERID'] . "'")->row()->lastconsultation ?? 0;

                                                                                    if ($lastConsultation != 0) {
                                                                                        $lastConsultationDate = new DateTime($lastConsultation);
                                                                                    } else {
                                                                                        $lastConsultationDate = new DateTime($period);
                                                                                    }

                                                                                    $datestartDate = new DateTime($period);
                                                                                    $diff = $lastConsultationDate->diff($datestartDate)->days;



                                                                                    ?>

                                                                                <?php } ?>
                                                                                <tr>
                                                                                <td><?= $dbtc['REMARKSBOOKING'] ?></td>
                                                                                    <td><?= !empty($lastConsultation) ? $lastConsultation : '0' ?></td>

                                                                                    <td><?= $diff ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <?php if ($dbtc['REMARKS'] != 'AVAILABLE') { ?>
                                                                        <!-- dapetin value doingid nya buat di pindahkan -->
                                                                        <input type="hidden" value="<?= $dbtc['DOINGID'] ?>" class="doingid_modal_btc">


                                                                        <?php
                                                                        $show_dokter = $db_oriskin->query("SELECT ISNULL(statusshowdokter, '') AS statusshowdokter FROM trdoingtreatment WHERE id = '" . $dbtc['DOINGID'] . "'")->row()->statusshowdokter ?? 0;
                                                                        $status = $db_oriskin->query("SELECT ISNULL(status, '') AS status FROM trdoingtreatment WHERE id = '" . $dbtc['DOINGID'] . "'")->row()->status ?? 0;

                                                                        echo "<script>console.log('Status: " . $status . "');</script>";

                                                                        $isDocterAbsen = $db_oriskin->query("SELECT ISNULL(employeeid, '') AS employeeid from msabsen where locationid = $location_id and period = '$yearMonth' and tgl_absen = '$dayOnly' and jobid= 12")->row()->employeeid ?? 0;
                                                                        $lastConsultation = $db_oriskin->query("SELECT ISNULL(CONVERT(VARCHAR(10), MAX(treatmentdate), 120), '') AS lastconsultation FROM trdoingtreatment WHERE statusshowdokter2=1 AND status != 3 AND customerid = '" . $dbtc['CUSTOMERID'] . "'")->row()->lastconsultation ?? 0;

                                                                        if ($lastConsultation != 0) {
                                                                            $lastConsultationDate = new DateTime($lastConsultation);
                                                                        } else {
                                                                            $lastConsultationDate = new DateTime($period);
                                                                        }

                                                                        $datestartDate = new DateTime($period);
                                                                        $diff = $lastConsultationDate->diff($datestartDate)->days;
                                                                        $disableStartButton = ($diff > 30 || $lastConsultation == 0 && $isDocterAbsen != 0) ? 'disabled' : '';


                                                                        if ($show_dokter == 0) {
                                                                        ?>
                                                                            <button type="button" class="btn btn-warning ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 1)">KONSULTASI DOKTER</button>
                                                                        <?php
                                                                        } elseif ($show_dokter == 1) {
                                                                        ?>
                                                                            <button type="button" class="btn btn-success ml-3 btn-sm btn-action" disabled>SUDAH KONSULTASI</button>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <button type="button" class="btn btn-secondary ml-3 btn-sm btn-action" disabled></button>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <?php if ($dbtc['REMARKS'] == 'WAITING CONFIRMATION' || $dbtc['REMARKS'] == 'ON BOOKING') { ?>
                                                                            <button type="button" class="btn btn-info ml-3 btn-sm btn-action" onclick="edit_doingid_btc(this); $('.modalHide_btc').modal('hide');">EDIT</button>
                                                                        <?php } ?>
                                                                        <button type="button" class="btn btn-primary ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 16)">START</button>
                                                                        <button type="button" class="btn btn-success ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 17)">FINISH</button>
                                                                        <?php if ($dbtc['REMARKS'] != 'FINISH') { ?>
                                                                            <button type="button" class="btn btn-danger ml-3 btn-sm btn-action" onclick="updateStatus('<?= $dbtc['DOINGID'] ?>', 3)">VOID</button>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END MODAL LIST BTC -->

                                                    <!-- MODAL LIST BTC AVAILABLE -->
                                                    <div class="modal fade" id="modal_list_btc_available<?= $dbtc['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($dbtc['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">DETAIL</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="<?= base_url('app/proses_booking_btc') ?>" method="post">
                                                                        <input type="hidden" name="employeeid_timestart_period_locationid_empid" value="<?= $dbtc['EMPLOYEEID'] . '_' . $timestart . '_' . $period . '_' . $locationid . '_' . $show_time ?>" required>
                                                                        <button type="submit" class="btn btn-success btn-block">Booking </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END MODAL LIST BTC AVAILABLE -->

                                                    <!-- MODAL EDIT -->
                                                    <div class="modal fade" id="modal_list_btc_available_edit<?= $dbtc['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($dbtc['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data
                                                                    </h5>
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
                                                                        <input type="hidden" name="empid" value="<?= $show_time ?>">

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
                        <?php foreach ($data_tabs_dokter as $row) { ?>
                            <div class="col-md-4">
                                <div class="card mt-0" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 14px;">
                                    <div class="card-header" style="background-color: #8c5e4e;">
                                        <h3 class="card-title text-center text-white">
                                            <b><?= $row['waktu_dokter']['TIMESTART'] ?> -
                                                <?= $row['waktu_dokter']['TIMEFINISH'] ?></b>
                                        </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                foreach ($row['data_dokter'] as $ddokter) {
                                                    $timestart = $ddokter['TIMESTART'];

                                                    if ($ddokter['REMARKS'] == 'AVAILABLE') {
                                                        $modal_list_dokter = '#modal_list_dokter_available' . $ddokter['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_dokter = 'class="ubah_data_target_modal_list_dokter_available"';
                                                    } else if ($ddokter['REMARKS'] == 'NOT AVAILABLE') {
                                                        $modal_list_dokter = '#modal_list_dokter_not_available' . $ddokter['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_dokter = 'class="ubah_data_target_modal_list_dokter_not_available"';
                                                    } else {
                                                        $modal_list_dokter = '#modal_list_dokter' . $ddokter['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_dokter = 'class="ubah_data_target_modal_list_dokter"';
                                                    }
                                                ?>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="<?= $modal_list_dokter ?>" <?= $class_modal_list_dokter ?>>
                                                        <div class="card mb-1 mt-1 <?php
                                                                                    if ($ddokter['REMARKS'] == 'ON PROGRESS') {
                                                                                        echo "bg-primary";
                                                                                    } elseif ($ddokter['REMARKS'] == 'ON BOOKING' || $ddokter['REMARKS'] == 'FINISH') {
                                                                                        echo "bg-danger";
                                                                                    } elseif ($ddokter['REMARKS'] == 'WAITING CONFIRMATION' || $ddokter['REMARKS'] == 'NOT CONFIRMATION') {
                                                                                        echo "bg-warning";
                                                                                    } elseif ($ddokter['REMARKS'] == 'AVAILABLE') {
                                                                                        echo "bg-success";
                                                                                    } elseif ($ddokter['REMARKS'] == 'NOT AVAILABLE') {
                                                                                        echo "bg-secondary";
                                                                                    } else {
                                                                                        echo "bg-info";
                                                                                    }
                                                                                    ?>
                                                        ">

                                                            <div class="card-body">
                                                                <p class="mb-0 text-white">
                                                                    <b><?= $ddokter['EMPLOYEENAME'] ?></b>
                                                                </p>
                                                                <?php if (!$ddokter['CUSTOMERNAME'] == null) { ?>
                                                                    <p class="mb-0 text-white">
                                                                        <b style="font-weight: 700 !important;">CUSTOMERNAME:</b>
                                                                        <?= $ddokter['CUSTOMERNAME'] ?>
                                                                    </p>
                                                                <?php } ?>
                                                                <span class="badge badge-primary text-white" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $ddokter['REMARKS'] ?>)</span>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- MODAL LIST DOKTER -->
                                                    <div class="modal fade modalHide_dokter" id="modal_list_dokter<?= $ddokter['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($ddokter['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">DETAIL</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="table-responsive" style="border-top: 1px solid #dee2e6;">
                                                                        <table class="table table-bordered text-center">
                                                                            <thead class="fw-bold">
                                                                                <tr>
                                                                                    <th style="font-weight: bold;">ID</th>
                                                                                    <th style="font-weight: bold;">CUSTOMERNAME</th>
                                                                                    <th style="font-weight: bold;">TREATMENTNAME</th>
                                                                                    <th style="font-weight: bold;">TIMESTART</th>
                                                                                    <th style="font-weight: bold;">QTY</th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><?= $ddokter['CUSTOMERID'] ?></td>
                                                                                    <td><?= $ddokter['CUSTOMERNAME'] ?></td>
                                                                                    <td><?= $ddokter['TREATMENTNAME'] ?></td>
                                                                                    <td><?= $ddokter['TIMESTART'] ?></td>
                                                                                    <td><?= $ddokter['QTY'] ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                    <div class="table-responsive" style="border-top: 1px solid #dee2e6;">
                                                                        <table class="table table-bordered text-center">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th style="font-weight: bold;">REMARKS</th>
                                                                                    <th style="font-weight: bold;">LAST CONSULTATION</th>
                                                                                    <th style="font-weight: bold;">HARI</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php if ($ddokter['REMARKS'] != 'AVAILABLE') { ?>
                                                                                    <input type="hidden" value="<?= $ddokter['DOINGID'] ?>" class="doingid_modal_btc">
                                                                                    <?php
                                                                                    $isDocterAbsen = $db_oriskin->query("SELECT ISNULL(employeeid, '') AS employeeid from msabsen where locationid = $location_id and period = '$yearMonth' and tgl_absen = '$dayOnly' and jobid= 12")->row()->employeeid ?? 0;
                                                                                    $lastConsultation = $db_oriskin->query("SELECT ISNULL(CONVERT(VARCHAR(10), MAX(treatmentdate), 120), '') AS lastconsultation FROM trdoingtreatment WHERE statusshowdokter2=1 AND status != 3 AND customerid = '" . $ddokter['CUSTOMERID'] . "'")->row()->lastconsultation ?? 0;

                                                                                    if ($lastConsultation != 0) {
                                                                                        $lastConsultationDate = new DateTime($lastConsultation);
                                                                                    } else {
                                                                                        $lastConsultationDate = new DateTime($period);
                                                                                    }

                                                                                    $datestartDate = new DateTime($period);
                                                                                    $diff = $lastConsultationDate->diff($datestartDate)->days;



                                                                                    ?>

                                                                                <?php } ?>
                                                                                <tr>
                                                                                <td><?= $ddokter['REMARKSBOOKING'] ?></td>
                                                                                    <td><?= !empty($lastConsultation) ? $lastConsultation : '0' ?></td>

                                                                                    <td><?= $diff ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <?php if ($ddokter['REMARKS'] != 'AVAILABLE') { ?>
                                                                        <!-- dapetin value doingid nya buat di pindahkan -->
                                                                        <input type="hidden" value="<?= $ddokter['DOINGID'] ?>" class="doingid_modal_dokter">

                                                                        <?php
                                                                        $show_dokter = $db_oriskin->query("SELECT ISNULL(statusshowdokter, '') AS statusshowdokter FROM trdoingtreatment WHERE id = '" . $ddokter['DOINGID'] . "'")->row()->statusshowdokter ?? 0;
                                                                        $status = $db_oriskin->query("SELECT ISNULL(status, '') AS status FROM trdoingtreatment WHERE id = '" . $ddokter['DOINGID'] . "'")->row()->status ?? 0;

                                                                        echo "<script>console.log('Status: " . $status . "');</script>";

                                                                        $isDocterAbsen = $db_oriskin->query("SELECT ISNULL(employeeid, '') AS employeeid from msabsen where locationid = $location_id and period = '$yearMonth' and tgl_absen = '$dayOnly' and jobid= 12")->row()->employeeid ?? 0;
                                                                        $lastConsultation = $db_oriskin->query("SELECT ISNULL(CONVERT(VARCHAR(10), MAX(treatmentdate), 120), '') AS lastconsultation FROM trdoingtreatment WHERE statusshowdokter2=1 AND status != 3 AND customerid = '" . $ddokter['CUSTOMERID'] . "'")->row()->lastconsultation ?? 0;

                                                                        if ($lastConsultation != 0) {
                                                                            $lastConsultationDate = new DateTime($lastConsultation);
                                                                        } else {
                                                                            $lastConsultationDate = new DateTime($period);
                                                                        }

                                                                        $datestartDate = new DateTime($period);
                                                                        $diff = $lastConsultationDate->diff($datestartDate)->days;
                                                                        $disableStartButton = ($diff > 30 || $lastConsultation == 0 && $isDocterAbsen != 0) ? 'disabled' : '';

                                                                        if ($show_dokter == 0) {
                                                                        ?>
                                                                            <button type="button" class="btn btn-warning ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 1)">KONSULTASI DOKTER</button>
                                                                        <?php
                                                                        } elseif ($show_dokter == 1) {
                                                                        ?>
                                                                            <button type="button" class="btn btn-success ml-3 btn-sm btn-action" disabled>SUDAH KONSULTASI</button>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <button type="button" class="btn btn-secondary ml-3 btn-sm btn-action" disabled></button>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                        <?php if ($ddokter['REMARKS'] == 'WAITING CONFIRMATION' || $ddokter['REMARKS'] == 'ON BOOKING') { ?>
                                                                            <button type="button" class="btn btn-info ml-3 btn-sm btn-action" onclick="edit_doingid_dokter(this); $('.modalHide_dokter').modal('hide');">EDIT</button>
                                                                        <?php } ?>
                                                                        <button type="button" class="btn btn-primary ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 16)">START</button>
                                                                        <button type="button" class="btn btn-success ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 17)">FINISH</button>
                                                                        <?php if ($ddokter['REMARKS'] != 'FINISH') { ?>
                                                                            <button type="button" class="btn btn-danger ml-3 btn-sm btn-action" onclick="updateStatus('<?= $ddokter['DOINGID'] ?>', 3)">VOID</button>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END MODAL LIST DOKTER -->

                                                    <!-- MODAL LIST DOKTER AVAILABLE -->
                                                    <div class="modal fade" id="modal_list_dokter_available<?= $ddokter['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($ddokter['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">DETAIL</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="<?= base_url('app/proses_booking_dokter') ?>" method="post">
                                                                        <input type="hidden" name="employeeid_timestart_period_locationid" value="<?= $ddokter['EMPLOYEEID'] . '_' . $timestart . '_' . $period . '_' . $locationid ?>" required>
                                                                        <button type="submit" class="btn btn-success btn-block">Booking</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- END MODAL LIST DOKTER AVAILABLE -->

                                                    <!-- MODAL EDIT -->
                                                    <div class="modal fade" id="modal_list_dokter_available_edit<?= $ddokter['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($ddokter['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">EDIT DATA
                                                                    </h5>
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
        var form = $('.form_search_list_booking');
        var element_pilih_klinik = document.getElementById("pilih_klinik_search");

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
        var form = $('.form_search_list_booking');
        var element_pilih_klinik = document.getElementById("pilih_klinik_search");

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
        var dateDoing = '<?= $period ?>';

        console.log(dateDoing);

        var _confirm = confirm('Anda Yakin?');
        if (_confirm) {
            $.ajax({
                type: 'POST',
                url: _HOST + 'App/updateTrDoingTreatmentStatusV2',
                data: {
                    id: doingId,
                    status: newStatus,
                    dateDoing: dateDoing,
                },
                success: function(response) {
                    alert(response);
                    $('#status_' + doingId).text(response.remarks);
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses permintaan.');
                }
            });
        }
    }
</script>


<script>
    // Fungsi untuk menampilkan SweetAlert saat tombol diklik
    $(document).on('click', '.ubah_data_target_modal_list_btc_not_available', function() {
        Swal.fire({
            title: 'PERINGATAN!',
            text: 'Batas waktu penginputan sudah habis.',
            icon: 'warning',
            confirmButtonText: 'Tutup'
        });
    });
</script>

<script>
    // Fungsi untuk menampilkan SweetAlert saat tombol diklik
    $(document).on('click', '.ubah_data_target_modal_list_dokter_not_available', function() {
        Swal.fire({
            title: 'PERINGATAN!',
            text: 'Batas waktu penginputan sudah habis.',
            icon: 'warning',
            confirmButtonText: 'Tutup'
        });
    });
</script>

<script>
    // Fungsi untuk menampilkan SweetAlert saat tombol diklik
    $(document).on('click', '.ubah_data_target_modal_list_btc_trial', function() {
        Swal.fire({
            title: 'PERINGATAN!',
            text: 'Slot ini sudah terisi.',
            icon: 'warning',
            confirmButtonText: 'Tutup'
        });
    });
</script>