<style>
    .width-th th {
        width: 100px !important;
    }

    /*sementara hanya berjalan di firefox*/
    .bootstrap-select>.dropdown-toggle.bs-placeholder,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
        color: #fff;
    }

    .table {
        table-layout: fixed;
        min-width: auto;

    }

    .table-wrapper {
        overflow-x: scroll;
        overflow-y: scroll;
        width: 100%;
        height: 100%;
        max-height: 100%;
        margin-top: 20px;
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
        left: 0;
    }

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        background-color: #f5f5f5;
    }

    .table-wrapper::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0, 0, 0, .5);
        -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
    }

    @page {
        size: auto;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .nav-tabs .nav-item .nav-link,
    .nav-tabs .nav-item .nav-link:hover {
        color: #333 !important;
    }

    .nav-tabs .nav-item .nav-link {
        border: 1px solid transparent !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item .nav-link:focus {
        border: 1px solid transparent !important;
        border-color: #dee2e6 #dee2e6 #fafafa !important;
        color: #333 !important;
    }

    /* timepicker supaya di tengah  */
    .main_container__1GGJE.main_blue__1ol4p {
        margin-left: auto !important;
        margin-right: auto !important;
        top: 50% !important;
        left: 0 !important;
        right: 0 !important;
        text-align: center !important;
    }

    .scroll-modal-view {
        overflow: scroll;
        height: 500px;
    }

    ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 8px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0, 0, 0, .5);
        box-shadow: 0 0 1px rgba(255, 255, 255, .5);
    }

    .scroll-modal-view {
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-body {
        overflow-y: auto;
    }

    body {
        font-family: 'Arial', sans-serif;
        margin: 10px;
        padding: 0;

    }
</style>

<?php
$db_oriskin = $this->load->database('oriskin', true);

$data_search = $db_oriskin->query("Exec spClinicFindCustomer '" . $s . "' ")->result_array();
?>

<?php
# display error
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
# unlimited time
ini_set('max_execution_time', -1);
$q = (isset($_GET['q']) ? $this->input->get('q') : '');
# dibuat langsung di view untuk memudahkan
# tidak dibuat di model
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);
$customerId = '';
$fullname = '';
$membercode = '';
$membership_treatment = array();
$history_doing = array();
$treatment_info = array();

$customer = $db_oriskin->query("Exec spClinicFindCustomer '" . $s . "'")->result_array();
if (!empty($customer)) {
    // Jika tidak kosong, dapatkan data dari hasil query
    $customerId = $customer[0]['IDFROMDB'];
    $fullname = $customer[0]['FIRSTNAME'] . ' ' . $customer[0]['LASTNAME'];
    $membercode = $customer[0]['MEMBERID'];
    //echo $customerId; die();
} else {
    // Jika hasil query kosong, lakukan tindakan yang sesuai (misalnya, menampilkan pesan atau melakukan tindakan lainnya)
    echo "<script>alert('Data tidak ditemukan');</script>";
}

# ======================================
# TAMBAHAN UNTUK MODAL DOING TREATMENT
# ======================================
$locationid = $this->session->userdata('locationid');
$location = $db_oriskin->query("SELECT id, name FROM mslocation where isactive=1 and name not like '%NEW TRIX%'")->result_array();


# ======================================

$split_values           = explode('_', $etpl);

$split_employeeid       = $split_values[0];
$split_timestart        = $split_values[1];
$split_period           = $split_values[2];
$split_locationid       = $split_values[3];

$sql = "
        SELECT a.id, a.name, b.locationid, c.id as assistid, c.name as jobname FROM msemployee a
        INNER JOIN msemployeedetail b ON a.id = b.employeeid
        INNER JOIN msjob c ON b.jobid = c.id
        WHERE a.isactive = 1
        AND b.locationid = '" . $split_locationid . "'
        AND c.id in(6,73)
        ORDER BY a.name
    ";
$assist_by = $db_oriskin->query($sql)->result_array();

$employee_doing = $employee_assist = [];

$sp_absen_doing = $db_oriskin->query("SELECT LOCATIONID, LOCATIONNAME, ABSENCEDATE, TIMESTART, TIMEFINISH, EMPLOYEEID, EMPLOYEENAME FROM [fnReportAbsenceDoingDoctor]('$split_period', $split_locationid) where EMPLOYEEID = '$split_employeeid' and TIMESTART = '$split_timestart' ")->row();

$frontdesk = $db_oriskin->query("
        SELECT a.id, a.name, b.locationid FROM msemployee a
        INNER JOIN msemployeedetail b ON a.id = b.employeeid
        INNER JOIN msjob c ON b.jobid = c.id
        WHERE a.isactive = 1
        AND locationid = '" . $split_locationid . "'
        AND c.name like '%FRONT DESK%'
        ORDER BY a.name
    ")->result_array();

// echo $db_oriskin->last_query();
?>
<body>
    

<div class="mycontaine">
    <div class="row">
        <div class="card p-2 col-md-6">
            <form action="<?= base_url('App/search_data_booking_dokter') ?>" method="post">
                <input type="hidden" name="etpl" value="<?= $etpl ?>">
                <div class="row g-3" style="display: flex; align-items: center;">
                    <div class="col-md-9 form-group pl-4">
                        <div class="input-group">
                            <input type="text" class="form-control text-uppercase" name="search" value="<?= set_value('search') ?>" required placeholder="Name / HP / SSID / Customer Code / Member Code">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn w-100 btn-primary">Search</button>
                    </div>
                </div>
            </form>

        </div>

        <div class="col-md-12">
            <div class="card">
            <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                        ERM BOOKING
                    </h3>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="existingcustomer" style="width: 100% !important;">
                            <thead class="bg-thead">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">First Name</th>
                                    <th class="text-center">Last Name</th>
                                    <th class="text-center">Member ID</th>
                                    <th class="text-center">Origin</th>
                                    <th class="text-center">HP</th>
                                    <th class="text-center">Autopay NO</th>
                                    <th class="text-center">Purchases<br>(1 year)</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <?php
                            if (@$s != null) {
                                $data_member = $db_oriskin->query("Exec spClinicFindCustomer '" . $s . "' ")->result_array();
                            ?>
                                <tbody>
                                    <?php foreach ($data_member as $row) { ?>
                                        <tr>
                                            <td><?= $row['ID'] ?></td>
                                            <td><?= $row['FIRSTNAME'] ?></td>
                                            <td><?= $row['LASTNAME'] ?></td>
                                            <td><?= $row['MEMBERID'] ?></td>
                                            <td><?= $row['ORIGINCUSTOMER'] ?></td>
                                            <td><?= $row['CELLPHONE'] ?></td>
                                            <td><?= $row['AUTOPAYCARDNO'] ?></td>
                                            <td><?= number_format($row['AMOUNT'], 0, ',', '.'); ?></td>
                                            <td>
                                                <span class="btn btn-primary" style="cursor: pointer;" data-toggle="modal" data-target="#view<?= $row['ID'] ?>">View</span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<?php
if (@$s != null) {
    $data_member            = $db_oriskin->query("Exec spClinicFindCustomer '" . $s . "' ")->result_array();
?>

    <?php foreach ($data_member as $row) {
        # query tab membership treatment
        $membership_treatment = $db_oriskin->query("Exec spClinicFindHistoryMembershipTreatmentDtl '" . $row['IDFROMDB'] . "' ")->result_array();
        # query tab history doing
        $history_doing = $db_oriskin->query("Exec spClinicFindHistoryTreatmentMemberErm '" . $row['IDFROMDB'] . "' ")->result_array();
        # query tab Treatment Info
        $treatment_info = $db_oriskin->query("Exec spClinicFindHistoryTreatmentDtl '" . $row['IDFROMDB'] . "' ")->result_array();
    ?>

        <!-- MODAL VIEW -->
        <div class="modal fade modal-transparent modal-fullscreen" id="view<?= $row['ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CUSTOMER DOING TREATMENT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row scroll-modal-view">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#treatment-info<?= $row['ID'] ?>">
                                            TREATMENT INFO
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#membership-treatment<?= $row['ID'] ?>">
                                            MEMBERSHIP TREATMENT
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#history-doing<?= $row['ID'] ?>">
                                            HISTORY DOING
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="treatment-info<?= $row['ID'] ?>">
                                        <div class="table-responsive">
                                            <table id="tbl-treatment-info<?= $row['ID'] ?>" class="table table-bordered display highlight cell-border row-border table-responsive" style="width:100%">
                                                <thead class="bg-thead">
                                                <tr role="">
                                                        <th style="text-align: center; font-size: 12px !important;">Invoice #</th>
                                                        <th style="text-align: center; font-size: 12px !important;">Treatment</th>
                                                        <th style="text-align: center; font-size: 12px !important;">TR. Times</th>
                                                        <th style="text-align: center; font-size: 12px !important;">TR. Free</th>
                                                        <th style="text-align: center; font-size: 12px !important;">TR. Total</th>
                                                        <th style="text-align: center; font-size: 12px !important;">TR. Used</th>
                                                        <th style="text-align: center; font-size: 12px !important;">TR. Remaining</th>
                                                        <th style="text-align: center; font-size: 12px !important;">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($treatment_info) > 0) {

                                                        foreach ($treatment_info as $ti) { {
                                                                $status = '';
                                                                $bgcolor = '';

                                                                if ($ti['STATUS'] == 2) {
                                                                    if ($ti['REMAINING'] > 0) {
                                                                        //$status = 'Ready';
                                                                        $status = '<button class="btn btn-sm btn-danger btn-xs check-in-treatment" data-toggle="modal" data-target="#modalNewDoingTreatment" onclick="initModalNewDoingTreatment(this,\'' . $ti['INVOICENO'] . '\',\'' . $ti['TREATMENTID'] . '\',\'' . $ti['TREATMENTNAME'] . '\',\'' . $row['IDFROMDB'] . '\');">Booking</button>';
                                                                        $bgcolor = 'bg-success';
                                                                    } else {
                                                                        $status = 'Completed';
                                                                        $bgcolor = 'bg-danger';
                                                                    }
                                                                } elseif ($ti['STATUS'] == 2) {
                                                                    $status = 'Completed';
                                                                    $bgcolor = 'bg-danger';
                                                                } elseif ($ti['STATUS'] == 9) {
                                                                    $status = 'Upgraded';
                                                                    $bgcolor = 'bg-danger';
                                                                }
                                                            }

                                                            //$dateString = explode('-', substr($hd['TREATMENTDATE'], 0, 10));
                                                            //$treatmentdate = $dateString[2].'-'.$dateString[1].'-'.$dateString[0];

                                                            echo '<tr style="font-weight: 400; font-size: 12px;">
                                                                                <td class="text-center">' . $ti['INVOICENO'] . '</td>
                                                                                <td class="text-left">' . $ti['TREATMENTNAME'] . '</td>
                                                                                <td class="text-center">' . $ti['TREAMENTTIMES'] . '</td>
                                                                                <td class="text-center">' . $ti['FREETREATMENTTIMES'] . '</td>
                                                                                <td class="text-center">' . $ti['TOTALTREATMENTS'] . '</td>
                                                                                <td class="text-center">' . $ti['USEDTIMES'] . '</td>
                                                                                <td class="text-center">' . $ti['REMAINING'] . '</td>
                                                                                <td class="f-td text-center text-white ' . $bgcolor . '">' . $status . '</td>
                                                                            </tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="membership-treatment<?= $row['ID'] ?>">
                                        <div class="table-responsive">
                                            <table id="tbl-membership-treatment<?= $row['ID'] ?>" class="table table-bordered display highlight cell-border row-border table-responsive" style="width:100%">
                                            <thead class="bg-thead">
                                                    <tr role="">
                                                    <th style="text-align: center; font-size: 12px !important;">Invoice #</th>
                                                        <th style="text-align: center; font-size: 12px !important;  ">Membership Name</th>
                                                        <th style="text-align: center; font-size: 12px !important;  ">Treatment</th>
                                                        <th style="text-align: center; font-size: 12px !important;  ">TR. Times</th>
                                                        <th style="text-align: center; font-size: 12px !important; display: none;">TR. Total</th>
                                                        <th style="text-align: center; font-size: 12px !important; ">TR. Used</th>
                                                        <th style="text-align: center; font-size: 12px !important; ">TR. Remaining</th>
                                                        <th style="text-align: center; font-size: 12px !important; ">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($membership_treatment) > 0) {
                                                        foreach ($membership_treatment as $mt) {
                                                            $status = '';
                                                            $bgcolor = '';

                                                            if ($mt['STATUS'] == 2 && $mt['ISFULL'] == 0) {
                                                                if ($mt['REMAINING'] > 0) {
                                                                    //$status = 'Ready';
                                                                    $status = '<button class="btn btn-sm btn-danger btn-xs check-in-treatment" data-toggle="modal" data-target="#modalNewDoingTreatment" onclick="initModalNewDoingTreatment(this,\'' . $mt['INVOICENO'] . '\',\'' . $mt['TREATMENTID'] . '\',\'' . $mt['TREATMENTNAME'] . '\',\'' . $row['IDFROMDB'] . '\');">Booking</button>';
                                                                    $bgcolor = 'bg-success';
                                                                } else {
                                                                    $status = 'Completed';
                                                                    $bgcolor = 'bg-danger';
                                                                }
                                                            } elseif ($mt['STATUS'] == 2 && $mt['ISFULL'] == 1) {
                                                                $status = 'Completed';
                                                                $bgcolor = 'bg-danger';
                                                            } elseif ($mt['STATUS'] == 28) {
                                                                $status = 'Membership Expired';
                                                                $bgcolor = 'bg-danger';
                                                            }

                                                         echo '<tr style="font-weight: 400; font-size: 12px;">
                                                                                <td class="text-center">' . $mt['INVOICENO'] . '</td>
                                                                                <td class="text-left">' . $mt['MEMBERSHIPNAME'] . '</td>
                                                                                <td class="text-left">' . $mt['TREATMENTNAME'] . '</td>
                                                                                <td class="text-right">' . number_format($mt['TREAMENTTIMES'], 0, '.', '') . '</td>
                                                                                <td class="text-right" style="display: none;">' . number_format($mt['TOTALTREATMENTS'], 0, '.', ',') . '</td>
                                                                                <td class="text-right">' . number_format($mt['USEDTIMES'], 0, '.', ',') . '</td>
                                                                                <td class="text-right">' . number_format($mt['REMAINING'], 0, '.', ',') . '</td>
                                                                                <td class="f-td text-center text-white ' . $bgcolor . '">' . $status . '</td>
                                                                            </tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="history-doing<?= $row['ID'] ?>">
                                        <div class="table-responsive">
                                            <table id="tbl-history-doing<?= $row['ID'] ?>" class="table table-bordered display highlight cell-border row-border table-responsive" style="width:100%">
                                            <thead class="bg-thead">
                                                    <tr role="">
                                                        <th style="text-align: center; font-size: 12px !important;">Doing Date</th>
                                                        <th style="text-align: center; font-size: 12px !important;">Type</th>
                                                        <th style="text-align: center; font-size: 12px !important;">Treatment</th>
                                                        <th style="text-align: center; font-size: 12px !important;">Doing By</th>
                                                        <th style="text-align: center; font-size: 12px !important">Doing Pos.</th>
                                                        <th style="text-align: center; font-size: 12px !important">Assist By</th>
                                                        <th style="text-align: center; font-size: 12px !important">Status</th>
                                                        <th style="text-align: center; font-size: 12px !important;">S.O.A.P</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($history_doing) > 0) {
                                                        foreach ($history_doing as $hd) {
                                                            //$dateString = explode('-', substr($hd['TREATMENTDATE'], 0, 10));
                                                            //$treatmentdate = $dateString[2].'-'.$dateString[1].'-'.$dateString[0];
                                                            $note = $db_oriskin->query("SELECT ISNULL(note, '') AS note FROM historydoingnote WHERE doingid = '" . $hd['DOINGID'] . "'")->row()->note ?? '';

                                                           echo '<tr style="font-weight: 400; font-size: 12px;">
                                                                                <!--<td class="text-center">' . $hd['DOINGID'] . '</td>-->
                                                                                <td class="text-center">' . $hd['TREATMENTDATE'] . '</td>
                                                                                <!--<td class="text-left">' . $hd['CUSTOMERNAME'] . '</td>-->
                                                                                <td class="text-left">' . $hd['CLIENTTYPE'] . '</td>
                                                                                <td class="text-left">' . $hd['TREATMENTNAME'] . '</td>
                                                                                <!--<td class="text-right">' . number_format($hd['RATE'], 0, '.', ',') . '</td>-->
                                                                                <td class="text-left">' . $hd['DOINGBY'] . '</td>
                                                                                <td class="text-left">' . $hd['DOINGBYJOB'] . '</td>
                                                                                <td class="text-left">' . $hd['ASSISTBY'] . '</td>
                                                                                <!--<td class="text-left">' . $hd['ASSISTBYJOB'] . '</td>-->
                                                                                <!--<td class="text-center">' . $hd['STARTTREATMENT'] . '</td>-->
                                                                                <!--<td class="text-center">' . $hd['ENDTREATMENT'] . '</td>-->
                                                                                <!--<td class="text-center">' . $hd['DURATION'] . '</td>-->
                                                                                <!--<td class="text-left">' . $hd['FRONTDESK'] . '</td>-->
                                                                                <td class="text-left">' . $hd['STATUSNAME'] . '</td>
                                                                                <td class="text-center">
                                                                                    <span data-id="' . $hd['DOINGID'] . '" class="spn-note" style="display: block;">' . $note . '</span>
                                                                                    <button data-id="' . $hd['DOINGID'] . '" class="btn btn-sm btn-info btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
                                                                                    <textarea data-id="' . $hd['DOINGID'] . '" class="txt-note" style="display: none;width:500px">' . $note . '</textarea>
                                                                                    <button data-id="' . $hd['DOINGID'] . '" class="btn btn-sm btn-info btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>
                                                                                </td>
                                                                            </tr>';
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $('#tbl-treatment-info<?= $row['ID'] ?>').DataTable({
                "pageLength": 2,
                "lengthMenu": [2, 10, 15, 20, 25],
                select: true,
                'bAutoWidth': false,
            });

            $('#tbl-membership-treatment<?= $row['ID'] ?>').DataTable({
                "pageLength": 2,
                "lengthMenu": [2, 10, 15, 20, 25],
                select: true,
                'bAutoWidth': false,
            });

            $('#tbl-history-doing<?= $row['ID'] ?>').DataTable({
                "pageLength": 2,
                "lengthMenu": [2, 10, 15, 20, 25],
                select: true,
                'bAutoWidth': false,
            });
        </script>
        <!-- END MODAL VIEW -->
    <?php } ?>

    <!-- Modal Add Doing Treatment -->
    <div class="modal fade modal-transparent modal-fullscreen" id="modalNewDoingTreatment" tabindex="-1" role="dialog" aria-labelledby="modalNewDoingTreatment">
        <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; ">
            <div class="modal-content">
                <form class="form-horizontal" action="<?= base_url('savedoingtreatment') ?>" role="form" method="post">

                    <input type="hidden" name="customerid" value="<?= $customerId ?>">
                    <input type="text" id="idfromdb" name="idfromdb" class="form-control form-control-sm pl-2" required readonly hidden />

                    <div class="modal-header" style="background: linear-gradient(60deg,#26c6da,#00acc1);">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="modalNewDoingTreatmentLabel" style="background: linear-gradient(60deg,#26c6da,#00acc1);">ADD DOING TREATMENT</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Invoice :</label>
                                <input type="text" id="invoicenotreatment" name="invoiceno" class="form-control form-control-sm pl-2" required readonly />
                            </div>
                            <div class="col-md-8">
                                <label>Treatment :</label>
                                <select class="form-control form-control-sm pl-2" id="treatmentselect" name="producttreatmentid" style="pointer-events: none;" required readonly>
                                    <option value="">SELECT A TREATMENT</option>
                                </select>
                            </div>
                            <!--
                                    <div class="col-md-1">
                                        <input type="text" class="form-control text-uppercase hide"	id="treatmentidmodal" name="producttreatmentid"/>
                                    </div>
                                    -->
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Location :</label>
                                <select class="form-control form-control-sm" id="locationselect" name="locationid" required="true">
                                    <option value="<?= $sp_absen_doing->LOCATIONID ?>" selected><?= $sp_absen_doing->LOCATIONNAME ?></option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Front Desk :</label>
                                <select class="form-control form-control-sm" id="frontdeskselect" name="frontdeskid" required="true">
                                    <option value="">SELECT A FRONT DESK</option>
                                    <?php foreach ($frontdesk as $row) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="control-label">Treatment Date :</label>
                                <input type="text" class="form-control form-control-sm text-uppercase" value="<?= $sp_absen_doing->ABSENCEDATE ?>" name="treatmentdate" placeholder="Treatment Date" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Start Time :</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $sp_absen_doing->TIMESTART ?>" name="starttreatment" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>End Time :</label>
                                <input type="text" class="form-control form-control-sm" value="<?= $sp_absen_doing->TIMEFINISH ?>" name="endtreatment" readonly>
                            </div>
                            <div class="col-md-2">
                                <label>Dur(min) :</label>
                                <?php
                                $timeStart = strtotime($sp_absen_doing->TIMESTART);

                                $timeFinish = strtotime($sp_absen_doing->TIMEFINISH);

                                $durationInSeconds = $timeFinish - $timeStart;

                                $durationInMinutes = $durationInSeconds / 60;
                                ?>

                                <input type="text" class="form-control form-control-sm" value="<?= $durationInMinutes ?>" id="duration" name="duration" readonly>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Doing By :</label>
                                <select class="form-control form-control-sm" id="doingbyselect" name="treatmentdoingbyid" required>
                                    <option value="<?= $sp_absen_doing->EMPLOYEEID ?>" selected><?= $sp_absen_doing->EMPLOYEENAME ?></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Assist By :</label>
                                <select class="form-control form-control-sm" id="assistbyselect" name="treatmentassistbyid">
                                    <option value="">ASSIST BY</option>
                                    <?php foreach ($assist_by as $row) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-2" style="display: none;">
                                <label>Voucher :</label>
                                <input type="text" id="voucherusedno" name="voucherused" class="form-control form-control-sm text-uppercase">
                            </div>
                            <div class="col-md-4">
                                <label>Remarks</label>
                                <input type="text" id="voucherusedno" name="remarks" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <input type="submit" class="btn btn-primary pull-right" value="Confirm and Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Add Doing Treatment -->
<?php } ?>

<script>
    $(document).ready(function() {
        // untuk judul
        var customerId = '<?= $customerId ?>';

        $(".btn-edit").each(function(index) {
            $(this).on("click", function() {
                let id = $(this).data('id');
                //alert('edit '+id);
                $(this).hide();
                $(this).parent().find('.spn-note').hide();
                $(this).parent().find('.txt-note').show();
                $(this).parent().find('.btn-save').show();
            });
        });

        $(".btn-save").each(function(index) {
            $(this).on("click", function() {
                let id = $(this).data('id');
                //alert('save '+id);
                let note = $(this).parent().find('.txt-note').val();

                $.post("<?= base_url('save-note-history-doing') ?>", {
                    doingid: id,
                    note: note
                }, function(res) {
                    //
                }).done(function(res) {
                    console.log(res);
                }).fail(function() {
                    console.log("error");
                });

                $(this).parent().find('.spn-note').html(note);
                $(this).hide();
                $(this).parent().find('.txt-note').hide();
                $(this).parent().find('.spn-note').show();
                $(this).parent().find('.btn-edit').show();
            });
        });

        // ======================================
        // TAMBAHAN UNTUK MODAL DOING TREATMENT
        // ======================================
        let _location = <?= json_encode($locationid) ?>;
        let _frontdesk = <?= json_encode($frontdesk) ?>;
        let _employee_doing = <?= json_encode($employee_doing) ?>;
        let _employee_assist = <?= json_encode($employee_assist) ?>;

        let _frontdesk_filter = [];
        let _employee_doing_filter = [];
        let _employee_assist_filter = [];

        $(document).on('change', '#locationselect', function(e) {
            let _locationid = this.value;
            let _html = '';
            // frontdesk
            _frontdesk_filter = _frontdesk.filter(function(v) {
                return v.locationid == _locationid;
            });

            _html = '<option value="">SELECT A FRONT DESK</option>';
            Object.entries(_frontdesk_filter).forEach(([key, val]) => {
                _html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
            });

            $(document).find('#frontdeskselect').html(_html);
            $(document).find('#doingbyselect').html('<option value="">DOING BY</option>');
            $(document).find('#assistbyselect').html('<option value="">ASSIST BY</option>');
        });

        $('#treatmentdate').on('focusout', function(e) {
            if ($('#locationselect').val() == '')
                $('#locationselect').focus();
            else
                getEmployeeDoingBy();
        });

        // timepicker1
        var timepicker1 = new TimePicker('#starttreatment', {
            lang: 'en',
            theme: 'blue',
        });
        timepicker1.on('change', function(evt) {
            var value = ((evt.hour).padStart(2, '0') || '00') + ':' + (evt.minute || '00');
            evt.element.value = value;
            calculateDuration()
        });
        // timepicker2
        var timepicker2 = new TimePicker('#endtreatment', {
            lang: 'en',
            theme: 'blue',
        });
        timepicker2.on('change', function(evt) {
            var value = ((evt.hour).padStart(2, '0') || '00') + ':' + (evt.minute || '00');
            evt.element.value = value;
            calculateDuration()
        });

        $(document).on('submit', '#savedoingtreatment', function(e) {
            e.preventDefault();
            let _url = $(this).attr("action");
            let _data = new FormData(this);

            $.ajax({
                type: 'post',
                url: _url,
                data: _data,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#savedoingtreatment #btn-save').attr('disabled', 'disabled');
                    $('#savedoingtreatment #btn-save').html('Saving...');
                },
                complete: function() {
                    $('#savedoingtreatment #btn-save').removeAttr('disabled');
                    $('#savedoingtreatment #btn-save').html('Confirm And Save');
                },
                success: function(result) {
                    let _res = result.split('|');
                    let _kd = _res[0];
                    let _ket = _res[1];

                    if (_kd == '1') { // success
                        // alert(_ket);
                        // location.reload();
                    } else {
                        alert(_ket);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText);
                }
            });
        });
        // ======================================
    });

    function initModalNewDoingTreatment(_obj, _invoiceno, _treatmentid, _treatmentname, _idfromdb) {
        $(document).find('#invoicenotreatment').val(_invoiceno);
        $(document).find('#treatmentselect').html('<option value="' + _treatmentid + '">' + _treatmentname + '</option>');
        $(document).find('#treatmentselect').val(_treatmentid);
        $(document).find('#idfromdb').val(_idfromdb);

        console.log(_idfromdb);
    }
    // menghitung durasi
    function calculateDuration() {
        let _date = $('#treatmentdate').val().split('/');
        let _startdate = _date[2] + '-' + _date[1] + '-' + _date[0];
        let _starttime = $('#starttreatment').val();
        let _endtime = $('#endtreatment').val();
        let _diff = new Date(_startdate + ' ' + _endtime) - new Date(_startdate + ' ' + _starttime);
        let _minutes = Math.floor((_diff / 1000) / 60);
        if (_minutes < 0) {
            //alert('Date invalid.');
            $(document).find("#duration").val(0);
        } else {
            $(document).find("#duration").val(_minutes);
            getEmployeeDoingBy();
        }
    }

    // fungsi get doingby
    function getEmployeeDoingBy() {
        let _locationid = $('#locationselect').val();
        let _date = $('#treatmentdate').val().split('/');
        let _startdate = _date[2] + '-' + _date[1] + '-' + _date[0];
        let _starttime = $('#starttreatment').val();
        let _endtime = $('#endtreatment').val();
        let _url = '<?= base_url('getemployeedoingby') ?>' + '?locationid=' + _locationid + '&treatmentdate=' + _startdate + '&starttreatment=' + _starttime + '&endtreatment=' + _endtime;
        let _html = '';

        $.ajax({
            type: 'get',
            url: _url,
            //data: _data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                // code here
            },
            complete: function() {
                // code here
            },
            success: function(result) {
                let _res = JSON.parse(result);
                // doing by
                _html = '<option value="">DOING BY</option>';
                Object.entries(_res).forEach(([key, val]) => {
                    _html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                });
                $(document).find('#doingbyselect').html(_html);
                // assist by
                _html = '<option value="">ASSIST BY</option>';
                Object.entries(_res).forEach(([key, val]) => {
                    _html += '<option value="' + val['id'] + '">' + val['name'] + '</option>';
                });

                $(document).find('#assistbyselect').html(_html);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error status code: ' + jqXHR.status + ' errorThrown: ' + errorThrown + ' responseText: ' + jqXHR.responseText);
            }
        });
    }
</script>


<script>
    $(document).ready(function() {
        $('#existingcustomer').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,

        });
    });
</script>