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

if (@$period == null) {
    $period = '';
    $locationid = '';
}

$locationid = $this->session->userdata('locationid');


?>

<div class="container-fluid">
    <div class="row">
        <!-- SEARCH -->
        <div class="col-md-12">
            <form action="<?= base_url('search_list_booking_edit') ?>" method="post" class="mb-0 form_search_list_booking">
                <div class="row">
                    <input type="hidden" name="doingid_btc" value="<?= $doingid_btc ?>">
                    <input type="hidden" name="doingid_dokter" value="<?= $doingid_dokter ?>">
                    <input type="hidden" name="locationid" value="<?= $locationid ?>">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Search Tanggal</label>
                            <?php
                            if (strpos($url_browser, '/reportanalystic_dev_ahmad/App/list_booking') !== false) {
                                if (preg_match('/\/reportanalystic_dev_ahmad\/App\/list_booking\/(\d{4}-\d{2}-\d{2})\/(\d+)/', $url_browser, $matches)) {
                                    $selected_date = $matches[1];
                                    $selected_value = $matches[2];
                            ?>
                                    <input type="date" name="period" class="form-control filter_period" value="<?= $selected_date ?>" min="<?= date('Y-m-d') ?>" required>
                                <?php } else { ?>
                                    <input type="date" name="period" class="form-control filter_period" value="<?= set_value('period') ?>" min="<?= date('Y-m-d') ?>" required>
                                <?php
                                }
                            } else {
                                ?>
                                <input type="date" name="period" class="form-control filter_period" value="<?= set_value('period') ?>" min="<?= date('Y-m-d') ?>" required>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-sm btn-dark top-responsive search_list_booking"><i></i> Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- END SEARCH -->

        <div class="col-ma-12">

        </div>

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

            <div class="row">
                <div class="col-md-8">
                    <h3>
                        Pilih Sesi dan Dokter/Therapis yg Available untuk Edit.
                    </h3>
                </div>

                <div class="col-md-4 float-left">
                    <a href="<?= base_url('App/list_booking/' . $period_edit . '/' . $locationid_edit) ?>" class="btn btn-danger mt-3" style="float: right;">
                        Batalkan Edit
                    </a>
                </div>
            </div>

            <div class="tab-content p-0 mt-3">
                <!-- TABS BTC -->
                <div class="tab-pane show active" id="btc">
                    <div class="row">
                        <?php foreach ($data_tabs_btc as $row) { ?>
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
                                                foreach ($row['data_btc'] as $dbtc) {
                                                    $timestart = $dbtc['TIMESTART'];

                                                    if ($dbtc['REMARKS'] != "FOR TRIAL") {
                                                        $show_time = 0;
                                                    } else {
                                                        $show_time = 1;
                                                    }

                                                    if ($dbtc['REMARKS'] == 'AVAILABLE') {
                                                        $modal_list_btc = '#modal_list_btc_available_edit' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_available"';
                                                    } else if ($dbtc['REMARKS'] == 'NOT AVAILABLE') {
                                                        $modal_list_btc = '#modal_list_btc_not_available' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_not_available"';
                                                    } else if ($dbtc['REMARKS'] == 'ALREADY FILLED') {
                                                        $modal_list_btc = '#modal_list_btc_trial' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_trial"';
                                                    } else if ($dbtc['REMARKS'] == 'FOR TRIAL') {
                                                        $modal_list_btc = '#modal_list_btc_available_edit' . $dbtc['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_btc = 'class="ubah_data_target_modal_list_btc_available"';
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
                                                                                    } elseif ($dbtc['REMARKS'] == 'FOR TRIAL') {
                                                                                        echo "bg-success";
                                                                                    } elseif ($dbtc['REMARKS'] == 'NOT AVAILABLE') {
                                                                                        echo "bg-secondary";
                                                                                    } elseif ($dbtc['REMARKS'] == 'ALREADY FILLED') {
                                                                                        echo "bg-secondary";
                                                                                    } else {
                                                                                        echo "bg-info";
                                                                                    } ?>">

                                                            <div class="card-body">
                                                                <p class="mb-0 text-white">
                                                                    <b><?= $dbtc['EMPLOYEENAME'] ?></b>
                                                                </p>
                                                                <?php if (!$dbtc['CUSTOMERNAME'] == null) { ?>
                                                                    <p class="mb-0 text-white">
                                                                        <b style="font-weight: 700 !important;">CUSTOMERNAME:</b> <?= $dbtc['CUSTOMERNAME'] ?>
                                                                    </p>
                                                                <?php } ?>
                                                                <?php if ($show_time != 0 && $dbtc['CUSTOMERID'] == 0 && $dbtc['REMARKS'] != 'ALREADY FILLED') { ?>
                                                                    <p class="mb-0 text-red">
                                                                        <b style="font-weight: 700 !important; color:red">FOR TRIAL</b>
                                                                    </p>
                                                                <?php } ?>
                                                                <span class="badge badge-primary text-white badge_status_remark" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $dbtc['REMARKS'] ?>)</span>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- MODAL EDIT -->
                                                    <div class="modal fade" id="modal_list_btc_available_edit<?= $dbtc['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($dbtc['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form action="<?= base_url('App/edit_list_booking_tgl') ?>" method="post">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="doingid" value="<?= $doingid_btc ?>">
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
                                    <div class="card-header bg-info">
                                        <h3 class="card-title text-center text-white"><b><?= $row['waktu_dokter']['TIMESTART'] ?> - <?= $row['waktu_dokter']['TIMEFINISH'] ?></b></h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                foreach ($row['data_dokter'] as $ddokter) {
                                                    $timestart = $ddokter['TIMESTART'];

                                                    if ($ddokter['REMARKS'] == 'AVAILABLE' && $doingid_dokter != null) {
                                                        $modal_list_dokter         = '#modal_list_dokter_available_edit' . $ddokter['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_dokter   = 'class="ubah_data_target_modal_list_dokter_available"';
                                                    } else {
                                                        $modal_list_dokter         = '#modal_list_dokter' . $ddokter['EMPLOYEEID'] . $timestart . '';
                                                        $class_modal_list_dokter   = 'class="ubah_data_target_modal_list_dokter"';
                                                    }
                                                ?>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="<?= $modal_list_dokter ?>" <?= $class_modal_list_dokter ?>>
                                                        <div class="card mb-1 mt-1 <?php
                                                                                    if ($ddokter['REMARKS'] == 'ON BOOKING' || $ddokter['REMARKS'] == 'ON PROGRESS' || $ddokter['REMARKS'] == 'FINISH') {
                                                                                        echo "bg-danger";
                                                                                    } elseif ($ddokter['REMARKS'] == 'ON BOOKING' || $ddokter['REMARKS'] == 'ON PROGRESS') {
                                                                                        echo "bg-danger";
                                                                                    } elseif ($ddokter['REMARKS'] == 'WAITING CONFIRMATION' || $ddokter['REMARKS'] == 'NOT CONFIRMATION' || $ddokter['REMARKS'] == 'WAITING CONFIRMATION') {
                                                                                        echo "bg-warning";
                                                                                    } elseif ($ddokter['REMARKS'] == 'AVAILABLE') {
                                                                                        echo "bg-success";
                                                                                    } else {
                                                                                        echo "bg-info";
                                                                                    } ?>">

                                                            <div class="card-body">
                                                                <p class="mb-0 text-white">
                                                                    <b><?= $ddokter['EMPLOYEENAME'] ?></b>
                                                                </p>
                                                                <?php if (!$ddokter['CUSTOMERNAME'] == null) { ?>
                                                                    <p class="mb-0 text-white">
                                                                        <b style="font-weight: 700 !important;">CUSTOMERNAME:</b> <?= $ddokter['CUSTOMERNAME'] ?>
                                                                    </p>
                                                                <?php } ?>
                                                                <span class="badge badge-primary text-white" style="font-size: 12px !important; background-color: #1e88e5 !important;">(<?= $ddokter['REMARKS'] ?>)</span>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- MODAL EDIT -->
                                                    <div class="modal fade" id="modal_list_dokter_available_edit<?= $ddokter['EMPLOYEEID'] . $timestart ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog <?php if ($ddokter['REMARKS'] != 'AVAILABLE') {
                                                                                        echo 'modal-lg';
                                                                                    } ?>" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header" style="background: #2bbcd5 !important;">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>

                                                                <form action="<?= base_url('App/edit_list_booking_tgl') ?>" method="post">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="doingid" value="<?= $doingid_dokter ?>">
                                                                        <input type="hidden" name="employeeid" value="<?= $ddokter['EMPLOYEEID'] ?>">
                                                                        <input type="hidden" name="timestart" value="<?= $ddokter['TIMESTART'] ?>">
                                                                        <input type="hidden" name="timefinish" value="<?= $ddokter['TIMEFINISH'] ?>">
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
                <!-- END TABS DOKTER -->
            </div>
        </div>
        <!-- END TABS DOKTER & BTC -->
    </div>
</div>

<script>
    function updateStatus(doingId, newStatus) {
        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            $.post(_HOST + 'App/updateTrDoingTreatmentStatus', {
                id: doingId,
                status: newStatus
            }, function(result) {
                alert(result);
                location.reload();
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
    $(document).on('click', '.ubah_data_target_modal_list_btc_trial', function() {
        Swal.fire({
            title: 'PERINGATAN!',
            text: 'Slot ini sudah terisi.',
            icon: 'warning',
            confirmButtonText: 'Tutup'
        });
    });
</script>