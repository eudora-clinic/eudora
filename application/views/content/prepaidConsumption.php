<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style>
    .card {
        /* max-width: 650px; */
        margin: auto;
        border-radius: 15px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        background: #ffffff;
        color: #333;
    }

    .card-header {
        /* background: linear-gradient(to right, #007bff, #00c6ff); */
        /* color: white; */
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        padding: 15px;
    }

    .card-body {
        padding: 25px;
    }

    .hidden-save {
        display: none !important;
    }


    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .info-item i {
        width: 30px;
        text-align: center;
        margin-right: 10px;
        color: #007bff;
        font-size: 18px;
    }

    .btn-modal {
        display: block;
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        border-radius: 8px;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-save {
        display: block;
        width: 100%;
        margin-top: 15px;
        padding: 10px;
        border-radius: 8px;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-modal:hover {
        background-color: #0056b3;
        color: white;
    }

    .toast {
        visibility: hidden;
        /* Sembunyikan secara default */
        min-width: 250px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 4px;
        padding: 16px;
        position: fixed;
        z-index: 9999;
        right: 40%;
        top: 20px;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.5s, visibility 0.5s;
    }

    .toast.show {
        visibility: visible;
        opacity: 1;
    }

    .toast.success {
        background-color: #28a745;
        /* Warna hijau untuk sukses */
    }

    .toast.error {
        background-color: #dc3545;
        /* Warna merah untuk error */
    }

    table.dataTable tbody td {
        text-align: center;
    }
</style>
<?php
$assistOption = "";
foreach ($assist_by as $assist) {
    $assistOption .= "<option value='{$assist['id']}'>{$assist['name']}</option>";
}

$frondeskOption = "";
foreach ($frontdesk as $frontdeskrow) {
    $frondeskOption .= "<option value='{$frontdeskrow['id']}'>{$frontdeskrow['name']}</option>";
}

$level = $this->session->userdata('level');

$currentMonth = date('m');
$appointmentMonth = date('m', strtotime($appointmentdate));


?>
<div class="card">
    <div class="card-header">📅 Detail Appointment</div>
    <input type="number" id="appointmentId" value="<?= $appointmentId; ?>" hidden>
    <input type="number" id="customerid" value="<?= $customerid; ?>" hidden>

    <input hidden id="idfromdb" name="idfromdb" class="form-control form-control-sm pl-2" required readonly
        value="<?= htmlspecialchars($customerid); ?>" />
    <input hidden id="treatmentdoingbyid" name="treatmentdoingbyid" class="form-control form-control-sm pl-2" required
        readonly value="<?= htmlspecialchars($employeeid); ?>" />
    <input hidden id="locationid" name="locationid" class="form-control form-control-sm pl-2" required readonly
        value="<?= htmlspecialchars($locationId); ?>" />
    <input hidden type="text" class="form-control form-control-sm" value="<?= $starttreatment ?>" name="starttreatment"
        id="starttreatment" readonly>
    <input hidden type="text" class="form-control form-control-sm" value="<?= $starttreatment ?>" name="endtreatment"
        id="endtreatment" readonly>
    <input hidden type="text" id="voucherusedno" name="voucherused" class="form-control form-control-sm text-uppercase">
    <input hidden type="text" class="form-control form-control-sm" value="<?= $duration ?>" id="duration"
        name="duration" readonly>
    <input hidden type="text" class="form-control form-control-sm text-uppercase" value="<?= $appointmentdate ?>"
        id="treatmentdate" name="treatmentdate" placeholder="Treatment Date" readonly>
    <input hidden id="bookingid" name="bookingid" class="form-control form-control-sm pl-2" required readonly
        value="<?= htmlspecialchars($appointmentId); ?>" />
    <input hidden id="remarks" name="remarks" class="form-control form-control-sm pl-2" required readonly
        value="<?= htmlspecialchars($remarks); ?>" />

    <div class="card-body">
        <div class="row" style="justify-content: space-around; align-items: center;">
            <div>
                <div class="info-item"><i class="fas fa-user"></i> <strong>Customer Name :&nbsp; </strong>
                    <?= $appointmentDetail[0]['CUSTOMERNAME']; ?> (<?= $appointmentDetail[0]['CUSTOMERID']; ?>)</div>
                <div class="info-item"><i class="fas fa-user"></i> <strong>Cellphone :&nbsp; </strong>
                    <a href="https://wa.me/62<?= $appointmentDetail[0]['CELLPHONENUMBER']; ?>" target="_blank"
                        type="button" class="btn btn-secondary m-0">
                        <i class="fab fa-whatsapp" style="font-size:24px;color:#25D366;"></i></a>
                    <?= $appointmentDetail[0]['CELLPHONENUMBER']; ?>
                </div>
                <div class="info-item"><i class="fas fa-comment"></i> <strong>Remarks :&nbsp; </strong>
                    <?= htmlspecialchars($remarks); ?></div>
                <div class="info-item"><i class="fas fa-calendar-alt"></i> <strong>Appointment Date :&nbsp; </strong>
                    <?= htmlspecialchars($appointmentdate); ?></div>
                <div class="info-item"><i class="fas fa-calendar-alt"></i> <strong>Createby :&nbsp; </strong>
                    <?= htmlspecialchars($appointmentDetail[0]['CREATEBY']); ?>
                    (<?= htmlspecialchars($appointmentDetail[0]['CREATETIME']); ?>)</div>
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Google Name:&nbsp;</strong>
                    <?= htmlspecialchars($appointmentDetail[0]['GOOGLENAME']); ?> (
                    <?= htmlspecialchars($appointmentDetail[0]['STAFFNAME']); ?>)

                    <button class="btn btn-sm btn-primary btn-addgoogle">Add/Edit</button>

                </div>
            </div>
            <div>
                <div class="info-item"><i class="fas fa-id-badge"></i> <strong>Doing By :&nbsp; </strong>
                    <?= $appointmentDetail[0]['EMPLOYEENAME']; ?> (<?= $appointmentDetail[0]['EMPLOYEEID']; ?>)</div>
                <div class="info-item"><i class="fas fa-hourglass-start"></i> <strong>Start Treatment :&nbsp; </strong>
                    <?= htmlspecialchars($starttreatment); ?></div>
                <div class="info-item"><i class="fas fa-map-marker-alt"></i> <strong>Branch :&nbsp; </strong>
                    <?= $appointmentDetail[0]['LOCATIONNAME']; ?></div>
                <div class="info-item"><i class="fas fa-map-marker-alt"></i> <strong>Customer Code :&nbsp; </strong>
                    <?= $appointmentDetail[0]['CUSTOMERCODE']; ?></div>
                <div class="info-item"><i class="fas fa-calendar-alt"></i> <strong>Lastmodifiedby :&nbsp; </strong>
                    <?= htmlspecialchars($appointmentDetail[0]['UPDATEBY']); ?>
                    (<?= htmlspecialchars($appointmentDetail[0]['LASTMODIFIED']); ?>)</div>
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    <strong>Link Review:&nbsp;</strong>
                    <?= htmlspecialchars($appointmentDetail[0]['LINKREVIEW']); ?> (
                    <?= htmlspecialchars($appointmentDetail[0]['STAFFNAME']); ?>)
                    <button class="btn btn-sm btn-primary btn-addgoogle">Add/Edit</button>
                </div>
            </div>
        </div>

        <div class="card-header">📅 Used Treatment</div>
        <table id="tbl-treatment-used" class="table table-striped table-bordered" style="width:100%">
            <thead class="bg-thead">
                <tr role="" style="font-weight: 400;">
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">No</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">DOINGID</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">BOOKID</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Invoice</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Treatment
                    </th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">qty</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Doing By</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Assist By
                    </th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Treatment
                        Exchange</th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Qty Exchange
                    </th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Status By
                        Customer
                    </th>
                    <th style="text-align: center; font-size: 12px !important; text-transform: uppercase;">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>


        <div id="membershipTablesContainer" class="mt-2">
            <!-- Tabel dinamis akan ditambahkan di sini -->
        </div>


        <!-- $appointmentDetail[0]['STATUS'] != 5 && $employeeid != 0 && ($locationId == 11 || $locationId == 13) && ($level != 2 && $level != 10 && $level != 11 && $level != 12 && $level != 13)
     -->
        <?php if (
            $appointmentDetail[0]['STATUS'] != 5 && $employeeid != 0 && ($locationId == 13) && ($level != 2 && $level != 10 && $level != 11 && $level != 12 && $level != 13)
        ) { ?>
            <div class="row col-md-12" style="align-items: center; justify-content: space-around;">
                <button class="btn btn-primary btn-modal col-md-5" data-bs-toggle="modal" data-bs-target="#prePaid">
                    <i class="fas fa-eye"></i> View Prepaid
                </button>
                <button class="btn btn-primary col-md-5 hidden-save" id="btn-save" onclick="savePrepaidConsumption()">
                    Simpan
                </button>
            </div>
        <?php } ?>

        <?php
        $treatmentDate = date('Y-m-d', strtotime($appointmentdate));
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        $yesterday2Days = date('Y-m-d', strtotime('-2 day'));


        if (
            $appointmentDetail[0]['STATUS'] != 5 &&
            $employeeid != 0 &&
            !in_array($level, [2, 10, 11, 12, 13]) &&
            ($treatmentDate >= $today || $treatmentDate == $yesterday || $treatmentDate == $yesterday2Days)
        ) {
            ?>
            <div class="row col-md-12" style="align-items: center; justify-content: space-around;">
                <button class="btn btn-primary btn-modal col-md-5" data-bs-toggle="modal" data-bs-target="#prePaid">
                    <i class="fas fa-eye"></i> View Prepaid
                </button>
                <button class="btn btn-primary col-md-5 hidden-save" id="btn-save" onclick="savePrepaidConsumption()">
                    Simpan
                </button>
            </div>
        <?php } ?>

        <?php
        $treatmentDate = date('Y-m-d', strtotime($appointmentdate));
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        if (
            $appointmentDetail[0]['STATUS'] == 5 &&
            !in_array($level, [2, 10, 11, 12, 13]) &&
            (
                $level == 4 ||
                $treatmentDate >= $today ||
                $treatmentDate == $yesterday
            )
        ) {
            ?>
            <div class="row col-md-12" style="align-items: center; justify-content: space-around;">
                <button class="btn btn-primary col-md-5" onclick="voidBookingAndPrepaid()">
                    <i class="fas fa-eye"></i> VOID BOOKING AND PREPAID
                </button>
                <button class="btn btn-primary btn-modal col-md-5" data-bs-toggle="modal" data-bs-target="#prePaid">
                    <i class="fas fa-eye"></i> View Prepaid
                </button>
                <button class="btn btn-primary col-md-5 hidden-save" id="btn-save" onclick="savePrepaidConsumption()">
                    Simpan
                </button>
            </div>
        <?php } ?>

    </div>
</div>

<?php if ($appointmentDetail[0]['STATUS'] == 5) { ?>
    <div class="card mt-3">
        <div class="card-header">Detail Customer</div>
        <ul class="nav nav-tabs active mt-3">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#treatmetDetail">TREATMENT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#packageDetail">PACKAGE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#historyDetail">HISTORY PREPAID</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div class="panel-body tab-pane show active" id="treatmetDetail">
                        <div class="table-wrapper p-4">
                            <div class="table-responsive">
                                <table id="tblPrepaidTreatment" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th style="text-align: center;">NO</th>
                                            <th style="text-align: center;">SALES</th>
                                            <th style="text-align: center;">PURCHASE AT</th>
                                            <th style="text-align: center;">INVOICE DATE</th>
                                            <th style="text-align: center;">INVOICENO</th>
                                            <th style="text-align: center;">TREATMENT</th>
                                            <th style="text-align: center;">TOTAL</th>
                                            <th style="text-align: center;">FREE</th>
                                            <th style="text-align: center;">USED TIMES</th>
                                            <th style="text-align: center;">SISA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($treatment_info as $row) {
                                            ?>
                                            <tr role="" style="font-weight: 400;">
                                                <td style="text-align: center;"><?= $no++ ?></td>
                                                <td style="text-align: center;"><?= $row['SALES'] ?>, <?= $row['SALES2'] ?></td>
                                                <td style="text-align: center;"><?= $row['LOCATION'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['TOTALTREATMENTS'] ?></td>
                                                <td style="text-align: center;"><?= $row['FREETREATMENTTIMES'] ?></td>
                                                <td style="text-align: center;"><?= $row['USEDTIMES'] ?></td>
                                                <td style="text-align: center;"><?= $row['REMAINING'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body tab-pane" id="packageDetail">
                        <div class="table-wrapper p-4">
                            <div class="table-responsive">
                                <table id="tablePackageDetail" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th style="text-align: center;">NO</th>
                                            <th style="text-align: center;">SALES</th>
                                            <th style="text-align: center;">PURCHASE AT</th>
                                            <th style="text-align: center;">INVOICE DATE</th>
                                            <th style="text-align: center;">INVOICENO</th>
                                            <th style="text-align: center;">PACKAGE</th>
                                            <th style="text-align: center;">TREATMENT</th>
                                            <th style="text-align: center;">TOTAL</th>
                                            <th style="text-align: center;">FREE</th>
                                            <th style="text-align: center;">USED TIMES</th>
                                            <th style="text-align: center;">SISA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($membership_treatmentBenefit as $row) {
                                            ?>
                                            <tr role="" style="font-weight: 400;">
                                                <td style="text-align: center;"><?= $no++ ?></td>
                                                <td style="text-align: center;"><?= $row['SALESNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICELOCATION'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                <td style="text-align: center;"><?= $row['MEMBERSHIPNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['TREAMENTTIMES'] ?></td>
                                                <td style="text-align: center;">0</td>
                                                <td style="text-align: center;"><?= $row['USEDTIMES'] ?></td>
                                                <td style="text-align: center;"><?= $row['REMAINING'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body tab-pane" id="historyDetail">
                        <div class="table-wrapper p-4">
                            <div class="table-responsive">
                                <table id="tablehistoryDetail" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th style="text-align: center;">NO</th>
                                            <th style="text-align: center;">INVOICENO</th>
                                            <th style="text-align: center;">CUSTOMERNAME</th>
                                            <th style="text-align: center;">TREATMENT</th>
                                            <th style="text-align: center;">TREATMENTDATE</th>
                                            <th style="text-align: center;">INVOICENO</th>
                                            <th style="text-align: center;">DOING LOCATION</th>
                                            <th style="text-align: center;">DOINGBY</th>
                                            <th style="text-align: center;">QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($history_doing as $row) {
                                            ?>
                                            <tr role="" style="font-weight: 400;">
                                                <td style="text-align: center;"><?= $no++ ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                <td style="text-align: center;"><?= $row['TREATMENTDATE'] ?></td>
                                                <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                <td style="text-align: center;"><?= $row['LOCATIONDOING'] ?></td>
                                                <td style="text-align: center;"><?= $row['DOINGBY'] ?>,<?= $row['ASSISTBY'] ?>
                                                </td>
                                                <td style="text-align: center;"><?= $row['QTY'] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade modal-transparent modal-fullscreen" id="prePaid" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; max-width: 90%;">
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
                                <a class="nav-link active" data-toggle="tab" href="#treatment-info">
                                    TREATMENT INFO
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#membership-treatment">
                                    MEMBERSHIP TREATMENT
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#history-doing">
                                    HISTORY DOING
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="treatment-info">
                                <div class="table-responsive">
                                    <table id="tbl-treatment-info" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="bg-thead">
                                            <tr role="" style="font-size: 12px !important;">
                                                <th style="text-align: center; font-size: 12px !important">Invoice #
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important" hidden>
                                                    Treatment</th>
                                                <th style="text-align: center; font-size: 12px !important" hidden>
                                                    TreatmentId</th>
                                                <th style="text-align: center; font-size: 12px !important" hidden>
                                                    remaining</th>
                                                <th style="text-align: center; font-size: 12px !important">Purchase Date
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">Treatment
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">Balance</th>
                                                <th style="text-align: center; font-size: 12px !important">Used Times
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">Usable</th>
                                                <th style="text-align: center; font-size: 12px !important">Unit Price
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">Total</th>
                                                <th style="text-align: center; font-size: 12px !important">REMARKS</th>
                                                <th style="text-align: center; font-size: 12px !important">STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($treatment_info as $row) {
                                                $status = '';
                                                $bgcolor = '';

                                                if ($row['STATUS'] == 2 || $row['STATUS'] == 10) {
                                                    if ($row['REMAINING'] > 0) {
                                                        $status = '<button class="btn btn-sm btn-primary btn-xx use-btn-membership">USE</button>';
                                                        $bgcolor = 'bg-success';
                                                    } else {
                                                        $status = 'Completed';
                                                        $bgcolor = 'bg-danger';
                                                    }
                                                } elseif ($row['STATUS'] == 2 || $row['STATUS'] == 10) {
                                                    $status = 'Completed';
                                                    $bgcolor = 'bg-danger';
                                                } elseif ($row['STATUS'] == 9) {
                                                    $status = 'Upgraded';
                                                    $bgcolor = 'bg-danger';
                                                }
                                                ?>
                                                <tr
                                                    style="font-weight: 400; text-align: center; font-size: 12px !important;">
                                                    <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                    <td style="text-align: center;" hidden><?= $row['TREATMENTNAME'] ?></td>
                                                    <td style="text-align: center;" hidden><?= $row['TREATMENTID'] ?></td>
                                                    <td style="text-align: center;" hidden><?= $row['REMAINING'] ?></td>
                                                    <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                    <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                    <td style="text-align: center;">
                                                        <?= $row['REMAINING'] ?>/<?= $row['TOTALTREATMENTS'] ?>
                                                    </td>
                                                    <td style="text-align: center;"><?= $row['USEDTIMES'] ?></td>
                                                    <td style="text-align: center;"><?= $row['REMAINING'] ?></td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($row['UNITPRICE'], 0, ',', ',') ?>
                                                    </td>
                                                    <td style="text-align: right;">
                                                        <?= number_format($row['TOTALAMOUNT'], 0, ',', ',') ?>
                                                    </td>
                                                    <td style="text-align: center;"><?= $row['REMARKS'] ?></td>
                                                    <td class="f-td text-center text-white <?= $bgcolor ?>"><?= $status ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="membership-treatment">
                                <div class="table-responsive">
                                    <table id="tbl-membership-treatment" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="bg-thead">
                                            <tr role="">
                                                <th style="text-align: center; font-size: 12px !important;">Invoice #
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important;" hidden>
                                                    Treatment</th>
                                                <th style="text-align: center; font-size: 12px !important;" hidden>
                                                    Treatmentid</th>
                                                <th style="text-align: center; font-size: 12px !important;" hidden>
                                                    remaining</th>
                                                <th style="text-align: center; font-size: 12px !important;  ">Membership
                                                    Name</th>
                                                <th style="text-align: center; font-size: 12px !important;  ">Treatment
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important;  ">TR. Times
                                                </th>
                                                <th
                                                    style="text-align: center; font-size: 12px !important; display: none;">
                                                    TR. Total</th>
                                                <th style="text-align: center; font-size: 12px !important; ">Used Times
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important; ">Remaining
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important; ">REMARKS
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important; ">STATUS
                                                </th>
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
                                                            $status = '<button class="btn btn-sm btn-primary btn-xs use-btn-membership">USE</button>';
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
                                                                                <td hidden class="text-left">' . $mt['TREATMENTNAME'] . '</td>
                                                                                <td hidden class="text-left">' . $mt['TREATMENTID'] . '</td>
                                                                                <td hidden class="text-left">' . $mt['REMAINING'] . '</td>
                                                                                <td class="text-left">' . $mt['MEMBERSHIPNAME'] . '</td>
                                                                                <td class="text-left">' . $mt['TREATMENTNAME'] . '</td>                                                                                
                                                                                <td class="text-right">' . number_format($mt['TREAMENTTIMES'], 0, '.', '') . '</td>
                                                                                <td class="text-right" style="display: none;">' . number_format($mt['TOTALTREATMENTS'], 0, '.', ',') . '</td>
                                                                                <td class="text-right">' . number_format($mt['USEDTIMES'], 0, '.', ',') . '</td>
                                                                                <td class="text-right">' . number_format($mt['REMAINING'], 0, '.', ',') . '</td>
                                                                                 <td class="text-left">' . $mt['REMARKS'] . '</td>
                                                                                <td class="f-td text-center text-white ' . $bgcolor . '">' . $status . '</td>
                                                                            </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="history-doing">
                                <div class="table-responsive">
                                    <table id="tbl-history-doing" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="bg-thead">
                                            <tr role="">
                                                <th style="text-align: center; font-size: 12px !important">NO</th>
                                                <th style="text-align: center; font-size: 12px !important">CUSTOMERNAME
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">TREATMENT
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">TREATMENTDATE
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">INVOICENO
                                                </th>
                                                <th style="text-align: center; font-size: 12px !important">DOING AT</th>
                                                <th style="text-align: center; font-size: 12px !important">DOINGBY</th>
                                                <th style="text-align: center; font-size: 12px !important">CONSUMED</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($history_doing as $row) {
                                                ?>
                                                <tr role="" style="font-weight: 400; font-size: 12px !important">
                                                    <td style="text-align: center;"><?= $no++ ?></td>
                                                    <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                    <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                    <td style="text-align: center;"><?= $row['TREATMENTDATE'] ?></td>
                                                    <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                    <td style="text-align: center;"><?= $row['LOCATIONDOING'] ?></td>
                                                    <td style="text-align: center;">
                                                        <?= $row['DOINGBY'] ?>,<?= $row['ASSISTBY'] ?>
                                                    </td>
                                                    <td style="text-align: center;"><?= $row['QTY'] ?></td>
                                                </tr>
                                            <?php } ?>
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

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">EDIT PREPAID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="updateForm">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input disabled type="text" class="form-control" id="treatmentnameupdate"
                                name="treatmentnameupdate" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="doingBy">QTY</label>
                        </div>

                        <div class="col-sm-8">
                            <input type="number" name="doingQty" id="doingQty" class="form-control"
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                placeholder="Masukkan jumlah">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="doingBy" class="col-sm-4 col-form-label">DOING BY</label>
                        <div class="col-sm-8">
                            <select id="doingBy" name="doingBy" class="form-control" required>
                                <option value="">-NONE-</option>
                                <?php foreach ($employeeDoing as $j) { ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="assistBy" class="col-sm-4 col-form-label">ASSIST BY</label>
                        <div class="col-sm-8">
                            <select id="assistBy" name="assistBy" class="form-control">
                                <option value="">-NONE-</option>
                                <?php foreach ($assist_by as $j) { ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" id="updateId" name="updateId">

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="updateGoogleModal" tabindex="-1" role="dialog" aria-labelledby="updateGoogleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateGoogleModalLabel">UPDATE GOOGLE REVIEW</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="updateFormGoogle">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="googleAccount">GOOGLE ACCOUNT</label>
                        </div>

                        <div class="col-sm-10">
                            <input type="text" name="googleAccount" id="googleAccount" class="form-control"
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                placeholder="Nama Account Google"
                                value="<?= htmlspecialchars($appointmentDetail[0]['GOOGLENAME']); ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="googleAccount">LINK REVIEW</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" name="linkReview" id="linkReview" class="form-control"
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                placeholder="Link Review Google"
                                value="<?= htmlspecialchars($appointmentDetail[0]['LINKREVIEW']); ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <label for="googleAccount">STAFF EMPLOYEE</label>
                        </div>
                        <div class="col-sm-10">
                            <select id="employeeidLinkReview" name="employeeidLinkReview" class="form-control">
                                <option value="">-NONE-</option>
                                <?php foreach ($employeeDoing as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($appointmentDetail[0]['STAFFID']) && $appointmentDetail[0]['STAFFID'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="customerId" name="customerId"
                        value="<?= htmlspecialchars($appointmentDetail[0]['CUSTOMERID']); ?>">
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="updateExchangeModal" tabindex="-1" role="dialog" aria-labelledby="updateModalExchangeLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="updateModalExchangeLabel">Exchange Prepaid</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="updateFormChange">
                    <input type="number" hidden id="doingidChange" name="doingidChange" required>
                    <input type="number" hidden id="qtyBefore" name="qtyBefore" required>
                    <input type="number" hidden id="treatmentExchangeId" name="treatmentExchangeId" required>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="treatmentExchangeId">TREATMENT</label>
                        </div>
                        <div class="col-sm-8">
                            <select id="treatmentSearch" required data-placeholder="Search Treatment"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="doingBy">QTY</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" name="qtyExchange" id="qtyExchange" class="form-control"
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <label for="remarkExchange">NOTE</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" name="remarkExchange" id="remarkExchange" class="form-control"
                                style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<div id="toast" class="toast">
    <div id="toast-message"></div>
</div>

<script>
    $('#tbl-treatment-info').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tblPrepaidTreatment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablehistoryDetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablePackageDetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

<script>
    var levelAccess = <?= $level ?>

    function initModalNewDoingTreatment(_obj, _invoiceno, _treatmentid, _treatmentname,) {
        $(document).find('#invoicenotreatment').val(_invoiceno);
        $(document).find('#treatmentselect').html('<option value="' + _treatmentid + '">' + _treatmentname + '</option>');
        $(document).find('#treatmentselect').val(_treatmentid);
    }
    $(document).ready(function () {
        $(".btn-modal").on("click", function () {
            $("#prePaid").modal("show");
        });

        $(".btn-addgoogle").on("click", function () {
            $("#updateGoogleModal").modal("show");
        });


        if ($.fn.DataTable.isDataTable("#tbl-treatment-info")) {
            $("#tbl-treatment-info").DataTable().destroy();
        }


        if ($.fn.DataTable.isDataTable("#tbl-membership-treatment")) {
            $("#tbl-membership-treatment").DataTable().destroy();
        }

        if ($.fn.DataTable.isDataTable("#tbl-history-doing")) {
            $("#tbl-history-doing").DataTable().destroy();
        }

        let table = $('#tbl-treatment-used').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
            "ordering": false,
            "bAutoWidth": false
        });

        $('#tbl-treatment-info').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#tbl-membership-treatment').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#tbl-history-doing').DataTable({
            "pageLength": 5,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            "info": false,
            'bAutoWidth': false
        });

        $('#tblPrepaidTreatment').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#tablehistoryDetail').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#tablePackageDetail').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $("#treatmentSearch").select2({
            width: '100%',
            ajax: {
                url: "App/searchServices",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#treatmentSearch").on("select2:select", function (e) {
            let data = e.params.data;
            console.log(data);

            $("#treatmentExchangeId").val(data.id);
        });


        function loadAppointmentDetails() {
            let appointmentId = $("#appointmentId").val();
            var level = '<?= $level ?>';
            $.ajax({
                url: "<?= base_url('App/detailPrepaidConsumption'); ?>",
                type: "GET",
                data: {
                    appointmentId: appointmentId
                },
                dataType: "json",
                success: function (response) {
                    table.clear().draw();

                    let no = 1;
                    let dataSet = [];

                    response.forEach(function (row) {
                        let deleteBtn = "";
                        let editBtn = "";
                        let exchangeBtn = "";
                        let fingerStatusBtn = "";

                        if (row.statuschange === 0 || row.statuschange === null) {
                            exchangeBtn = `
                            <button class="btn btn-danger btn-sm exchange-btn text-center"
                                data-id="${row.ID}" 
                                data-treatmentidchange="${row.treatmentidchange ?? ''}" 
                                data-qtychange="${row.qtychange ?? ''}" 
                                data-qtybefore="${row.QTY}" 
                                data-remarks="${row.remarks ?? ''}" 
                                data-treatmentname="${row.treatmentchangename ?? ''}">
                                Exchange
                            </button>`;
                        }

                        let today = new Date();
                        let yesterday = new Date();
                        yesterday.setDate(today.getDate() - 1);

                        let todayStr = today.toISOString().split('T')[0];
                        let yesterdayStr = yesterday.toISOString().split('T')[0];

                        let appointmentDateStr = row.APPOINTMENTDATE?.split('T')[0] ?? row.APPOINTMENTDATE;

                        const forbiddenLevels = [2, 10, 11, 12, 13];

                        if (
                            row.STATUS == 5 &&
                            !forbiddenLevels.includes(level) &&
                            (
                                level == 4 ||
                                appointmentDateStr == todayStr ||
                                appointmentDateStr == yesterdayStr
                            )
                        ) {
                            editBtn = `<button class="btn btn-primary btn-sm update-btn text-center" data-treatment-name="${row.TREATMENTNAME}" data-id="${row.ID}" data-qty="${row.QTY}" data-doing-by="${row.DOINGBYID}" data-assist-by="${row.ASSISTBYID}">EDIT</button>`;
                            if (response.length > 1) {
                                deleteBtn = `<button class="btn btn-danger btn-sm delete-btn text-center" data-id="${row.ID}">VOID</button>`;
                            }
                        }

                        if (row.status_finger_customer == 1) {
                            fingerStatusBtn = `<button class="btn btn-success btn-sm text-center">Approved By Finger</button>`;
                        } else if (row.status_finger_customer == 0) {
                            fingerStatusBtn = `<button class="btn btn-danger btn-sm text-center">Not Yet Approved By Finger</button>`;
                        }

                        dataSet.push([
                            `<td class="text-center">${no++}</td>`,
                            `<td class="text-center">${row.ID}</td>`,
                            `<td class="text-center">${row.BOOKINGID}</td>`,
                            `<td class="text-center">${row.INVOICENO}</td>`,
                            `<td class="text-center">${row.TREATMENTNAME}</td>`,
                            `<td class="text-center">${row.QTY}</td>`,
                            `<td class="text-center">${row.DOINGBY}</td>`,
                            `<td class="text-center">${row.ASSISTBY ? row.ASSISTBY : '-'}</td>`,
                            `<td class="text-center">${row.treatmentchangename ? row.treatmentchangename : '-'}</td>`,
                            `<td class="text-center">${row.qtychange ? row.qtychange : '-'}</td>`,
                            `<td class="text-center">
                                ${fingerStatusBtn}
                            </td>`,
                            `<td class="text-center">${editBtn} ${deleteBtn} ${exchangeBtn}</td>`,
                        ]);

                    });

                    table.rows.add(dataSet).draw();

                    if (response.length > 0) {
                        $("#tbl-treatment-used").removeClass("hidden-save");
                    } else {
                        $("#tbl-treatment-used").addClass("hidden-save");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }

        $('#tbl-treatment-used tbody').on('click', '.delete-btn', function () {
            let doingId = $(this).data("id");
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: "<?= base_url('App/updatePrepaidConsumption'); ?>", // Sesuaikan dengan URL
                    type: "POST",
                    data: {
                        id: doingId,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            showToast("Treatment Used berhasil diperbarui!", "success");
                            location.reload();
                        } else {
                            showToast("Treatment Used gagal diperbarui!", "error");
                        }
                        loadAppointmentDetails();
                    },
                    error: function (xhr, status, error) {
                        alert("Gagal menghapus data!");
                    }
                });
            }
        });

        $(document).on('click', '.update-btn', function () {
            let id = $(this).data('id');
            let qty = $(this).data('qty');
            let doingBy = $(this).data('doing-by');
            let assistBy = $(this).data('assist-by');
            let treatmentnameupdate = $(this).data('treatment-name');

            // Set data ke modal
            $('#updateId').val(id);
            $('#doingQty').val(qty);
            $('#doingBy').val(doingBy);
            $('#assistBy').val(assistBy);
            $('#treatmentnameupdate').val(treatmentnameupdate);

            // Tampilkan modal
            $('#updateModal').modal('show');
        });


        $(document).on('click', '.exchange-btn', function () {
            let id = $(this).data('id');
            let treatmentidchange = $(this).data('treatmentidchange');
            let qtychange = $(this).data('qtychange');
            let qtybefore = $(this).data('qtybefore');
            let treatmentname = $(this).data('treatmentname');

            let remarks = $(this).data('remarks');

            $('#treatmentExchangeId').val(treatmentidchange);
            $('#qtyExchange').val(qtychange);
            $('#doingidChange').val(id);
            $('#qtyBefore').val(qtybefore);
            $('#remarkExchange').val(remarks);

            if (treatmentidchange) {
                let option = new Option(treatmentname, treatmentidchange, true, true);
                $('#treatmentSearch').append(option).trigger('change');
            }

            $('#updateExchangeModal').modal('show');
        });


        $("#modalNewDoingTreatment form").on("submit", function (event) {
            event.preventDefault();

            let formData = $(this).serialize();


            $.ajax({
                url: "<?= base_url('App/savePrepaidConsumption') ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function () {
                    $("input[type=submit]").prop("disabled", true).val("Saving...");
                },
                success: function (response) {
                    if (response.status === "success") {
                        showToast("Treatment Used berhasil disimpan!", "success");
                        location.reload();
                    } else {
                        alert("Terjadi kesalahan: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert("AJAX Error: " + error);
                },
                complete: function () {
                    $("input[type=submit]").prop("disabled", false).val("Confirm and Save");
                }
            });

        });

        function showToast(message, type) {
            const toast = document.getElementById("toast");
            const toastMessage = document.getElementById("toast-message");

            toastMessage.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        loadAppointmentDetails();

        $('#updateForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "<?= base_url('ControllerPOS/updatePrepaidConsumptionV2'); ?>",
                type: "POST",
                data: formData,
                dataType: "json", 
                success: function (response) {
                    if (response.status === 'success') {
                        $('#updateModal').modal('hide');
                        loadAppointmentDetails();
                        alert(response.message);
                    } else {
                        alert(response.message || 'Error updating data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error updating data:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });

        $('#updateFormChange').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Ambil data form

            $.ajax({
                url: "<?= base_url('ControllerPOS/changeTreatmentPrepaid'); ?>",
                type: "POST",
                data: formData,
                dataType: "json", // pastikan ini "json" supaya response otomatis diparse
                success: function (response) {
                    if (response.status === 'success') {
                        $('#updateExchangeModal').modal('hide');
                        loadAppointmentDetails(); // Reload data setelah update
                        alert(response.message);
                    } else {
                        alert(response.message || 'Error updating data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error updating data:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });

        $('#updateFormGoogle').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Ambil data form

            console.log(formData);


            $.ajax({
                url: "<?= base_url('ControllerPOS/updateGoogleReviewCustomer'); ?>",
                type: "POST",
                data: formData,
                dataType: "json", // pastikan ini "json" supaya response otomatis diparse
                success: function (response) {
                    if (response.status === 'success') {
                        $('#updateGoogleModal').modal('hide');
                        setTimeout(function () {
                            location.reload();
                        }, 200);
                        alert(response.message);
                    } else {

                        alert(response.message || 'Error updating data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error updating data:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });
    });


    document.addEventListener("DOMContentLoaded", function () {
        //FOR MEMBERSHIP
        let usedMembershipIds = [];

        function toggleSaveButton() {



            if (usedMembershipIds.length > 0) {
                console.log(usedMembershipIds);
                $("#btn-save").removeClass("hidden-save"); // atau .removeClass('hidden-save')
            } else {
                $("#btn-save").addClass("hidden-save"); // atau .addClass('hidden-save')
            }
        }

        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("use-btn-membership")) {
                const button = e.target;
                const row = button.closest("tr");
                console.log(row);

                const data = {
                    invoiceno: row.cells[0].innerText.trim(),
                    treatmentname: row.cells[1].innerText.trim(),
                    treatmentid: row.cells[2].innerText.trim(),
                    remaining: row.cells[3].innerText.trim(),
                    id: row.cells[2].innerText.trim() + '-' + row.cells[0].innerText.trim(),
                };

                if (usedMembershipIds.includes(data.id) && levelAccess != 4) {
                    alert("This product has already been used!");
                    return;
                }

                usedMembershipIds.push(data.id);

                toggleSaveButton();

                const newTableHtmlMembership = `
                    <div class="table-wrapper product-table-wrapper-membership card" data-id-membership="${data.id}">
                        <div class="p-4">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">INVOICE</th>
                                        <th style="text-align: center;">TREATMENTNAME</th>
                                         <th style="text-align: center;">TREATMENTID</th>
                                        <th style="text-align: center;">REMAINING</th>
                                        <th style="text-align: center;">QTY</th>
                                        <th style="text-align: center;">CSO</th>
                                        <th style="text-align: center;">ASSIST BY</th>
                                        <th style="text-align: center;">ACT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;" class="invoiceno">${data.invoiceno}</td>
                                        <td style="text-align: center;" class="treatmentname">${data.treatmentname}</td>
                                        <td style="text-align: center;" class="treatmentid" >${data.treatmentid}</td>
                                        <td style="text-align: center;" class="remaining" >${data.remaining}</td>
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control qty" value="1" min="1" style="width: 70px;">
                                        </td>

                                        <td style="text-align: center;">
                                            <select class="form-control cso" >
                                                <?= $frondeskOption ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center;">
                                            <select class="form-control assist">
                                                <option value="">NO ASSIST</option>
                                                <?= $assistOption ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-sm remove-btn-membership">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;

                const containerMembership = document.getElementById("membershipTablesContainer");
                containerMembership.insertAdjacentHTML("beforeend", newTableHtmlMembership);

                const newTableMembership = containerMembership.lastElementChild;

                const updateTotal = () => {
                    const qtyInput = newTableMembership.querySelector(".qty");
                    const remaining = parseInt(newTableMembership.querySelector(".remaining").innerText.trim()) || 0;
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty < 1) {
                        alert("QTY harus minimal 1!");
                        qtyInput.value = 1;
                    } else if (qty > remaining) {
                        alert("QTY tidak boleh lebih besar dari remaining!");
                        qtyInput.value = remaining;
                    }
                };

                newTableMembership.querySelector(".qty").addEventListener("input", updateTotal);

                newTableMembership.querySelector(".remove-btn-membership").addEventListener("click", function () {
                    const wrapperMembership = this.closest(".product-table-wrapper-membership");
                    const productIdMembership = wrapperMembership.getAttribute("data-id-membership");

                    usedMembershipIds = usedMembershipIds.filter((id) => id !== productIdMembership);
                    wrapperMembership.remove();
                    toggleSaveButton();
                });

            }
        });


        //END FOR MEMBERSHIP
    });

    function savePrepaidConsumption() {
        const idfromdb = document.getElementById('idfromdb').value;
        const treatmentdoingbyid = document.getElementById('treatmentdoingbyid').value;
        const locationid = document.getElementById('locationid').value;
        const starttreatment = document.getElementById('starttreatment').value;
        const endtreatment = document.getElementById('endtreatment').value;
        const voucherusedno = document.getElementById('voucherusedno').value;
        const duration = document.getElementById('duration').value;
        const treatmentdate = document.getElementById('treatmentdate').value;
        const bookingid = document.getElementById('bookingid').value;
        const remarks = document.getElementById('remarks').value;


        let hasError = false;
        if (!idfromdb || !treatmentdoingbyid || !locationid || !starttreatment || !endtreatment || !duration || !treatmentdate || !bookingid) {
            alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
            return false;
        }

        const selectedPrepaid = [];
        document.querySelectorAll('.product-table-wrapper-membership').forEach(wrapper => {
            const invoiceno = wrapper.querySelector('.invoiceno').textContent;
            const qty = wrapper.querySelector('.qty').value;
            const producttreatmentid = wrapper.querySelector('.treatmentid').textContent;
            const frontdeskid = wrapper.querySelector('.cso').value;
            const treatmentassistbyid = wrapper.querySelector('.assist').value;


            if (!invoiceno || !qty || !producttreatmentid || !frontdeskid) {
                alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
                return false;
            }

            selectedPrepaid.push({
                invoiceno,
                qty,
                producttreatmentid,
                frontdeskid,
                treatmentassistbyid
            });
        });

        if (selectedPrepaid.length === 0) {
            alert('Product package belum ditambahkan!');
            hasError = true;
        }

        const transactionData = {
            idfromdb,
            treatmentdoingbyid,
            locationid,
            starttreatment,
            endtreatment,
            voucherusedno,
            duration,
            treatmentdate,
            bookingid,
            prepaid: selectedPrepaid,
            remarks
        };

        // console.log(transactionData);

        if (hasError) {
            return false;
        }
        if (confirm("Apakah Anda yakin ingin menyimpan data ini? Pastikan data sudah benar!")) {
            $.ajax({
                url: "<?= base_url() . 'App/savePrepaidConsumptionV2' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    alert('berhasil memotong prepaid');
                    setTimeout(function () {
                        location.reload();
                    }, 200);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            })
        };
    }

    function voidBookingAndPrepaid() {
        const bookingid = document.getElementById('bookingid').value;

        const transactionData = {
            bookingid
        };

        if (confirm("Apakah Anda yakin ingin void booking dan prepaid yang sudah tersimpan!")) {
            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/voidBookingAndPrepaid' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    alert('berhasil void booking dan prepaid');
                    setTimeout(function () {
                        location.reload();
                    }, 200);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            })
        };
    }
</script>