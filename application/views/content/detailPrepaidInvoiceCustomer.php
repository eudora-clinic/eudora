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


<div class="card">
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
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#historyRetail">HISTORY INVOICE PRODUCT</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#upcomingAppt">UPCOMING APPOINTMENT</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#exchangePackage">EXCHANGE PACKAGE</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#historyExhcange">HISTORY EXCHANGE</a>
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
                                        <th style="text-align: center;">PURCHASE DATE</th>
                                        <th style="text-align: center;">PURCHASE PRICE</th>
                                        <th style="text-align: center;">INVOICENO</th>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">BALANCE</th>
                                        <th style="text-align: center;">REMARKS</th>
                                        <th style="text-align: center;">STATUS</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($treatment_info as $row) {
                                        $status = '';
                                        $bgcolor = '';
                                        $statusPrepaid = 2;

                                        if ($row['STATUS'] == 2) {
                                            if ($row['REMAINING'] > 0) {
                                                $status = 'Ready';
                                                $bgcolor = 'bg-success';
                                                $statusPrepaid = 1;
                                            } else {
                                                $status = 'Completed';
                                                $bgcolor = 'bg-danger';
                                                $statusPrepaid = 2;
                                            }
                                        } elseif ($row['STATUS'] == 2) {
                                            $status = 'Completed';
                                            $bgcolor = 'bg-danger';
                                            $statusPrepaid = 2;
                                        } elseif ($row['STATUS'] == 9) {
                                            $status = 'Upgraded';
                                            $bgcolor = 'bg-danger';
                                            $statusPrepaid = 2;
                                        }
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['SALES'] ?>, <?= $row['SALES2'] ?></td>
                                            <td style="text-align: center;"><?= $row['LOCATION'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['TOTALAMOUNT'], 0, ',', ',') ?>
                                            </td>
                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                            <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                            <td style="text-align: center;">
                                                <?= $row['REMAINING'] ?>/<?= $row['TOTALTREATMENTS'] ?>
                                            </td>
                                            <td style="text-align: center;"><?= $row['REMARKS'] ?></td>
                                            <td class="f-td text-center text-white <?= $bgcolor ?>"><?= $status ?></td>
                                            <td class="f-td text-center text-white">
                                                <button
                                                    onclick="exchangeTreatment('<?= $row['TREATMENTNAME'] ?>','<?= $row['INVOICENO'] ?>', <?= $row['UNITPRICE'] ?>, <?= $row['REMAINING'] ?>, <?= $row['TREATMENTID'] ?>, <?= $customerId ?>, 1)"
                                                    class="btn btn-sm btn-primary" <?= $statusPrepaid == 2 ? 'hidden' : '' ?>>
                                                    EXCHANGE
                                                </button>
                                            </td>
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
                                        <th style="text-align: center;">PURCHASE DATE</th>
                                        <th style="text-align: center;">INVOICENO</th>
                                        <th style="text-align: center;">PACKAGE</th>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">BALANCE</th>
                                        <th style="text-align: center;">REMARKS</th>
                                        <th style="text-align: center;">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($membership_treatmentBenefit as $row) {
                                        $status = '';
                                        $bgcolor = '';

                                        if ($row['STATUS'] == 2 && $row['ISFULL'] == 0) {
                                            if ($row['REMAINING'] > 0) {
                                                $status = 'Ready';
                                                $bgcolor = 'bg-success';
                                            } else {
                                                $status = 'Completed';
                                                $bgcolor = 'bg-danger';
                                            }
                                        } elseif ($row['STATUS'] == 2 && $row['ISFULL'] == 1) {
                                            $status = 'Completed';
                                            $bgcolor = 'bg-danger';
                                        } elseif ($row['STATUS'] == 28) {
                                            $status = 'Membership Expired';
                                            $bgcolor = 'bg-danger';
                                        }
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['SALESNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICELOCATION'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                            <td style="text-align: center;"><?= $row['MEMBERSHIPNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                            <td style="text-align: center;">
                                                <?= $row['REMAINING'] ?>/<?= $row['TREAMENTTIMES'] ?>
                                            </td>
                                            <td style="text-align: center;"><?= $row['REMARKS'] ?></td>
                                            <td class="f-td text-center text-white <?= $bgcolor ?>"><?= $status ?></td>
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
                                        <th style="text-align: center;">CUSTOMERNAME</th>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">TREATMENTDATE</th>
                                        <th style="text-align: center;">INVOICENO</th>
                                        <th style="text-align: center;">DOING AT</th>
                                        <th style="text-align: center;">DOINGBY</th>
                                        <th style="text-align: center;">CONSUMED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($history_doing as $row) {
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
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
                <div class="panel-body tab-pane" id="upcomingAppt">
                    <div class="table-wrapper p-4">
                        <div class="table-responsive">
                            <table id="tablehupcomingAppt" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">NO</th>
                                        <th style="text-align: center;">NAME</th>
                                        <th style="text-align: center;">LOCATION</th>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">DATE</th>
                                        <th style="text-align: center;">TIME</th>
                                        <th style="text-align: center;">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listAppointment as $row) {
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['FULLNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['LOCATION'] ?></td>
                                            <td style="text-align: center;"><?= $row['REMARKS'] ?></td>
                                            <td style="text-align: center;"><?= $row['APPOINTMENTDATE'] ?></td>
                                            <td style="text-align: center;"><?= $row['TIME'] ?></td>
                                            <td style="text-align: center;"><?= $row['STATUS_TEXT'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-body tab-pane" id="historyRetail">
                    <div class="table-wrapper p-4">
                        <div class="table-responsive">
                            <table id="tablehistoryRetail" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">NO</th>
                                        <th style="text-align: center;">NAME</th>
                                        <th style="text-align: center;">LOCATION</th>
                                        <th style="text-align: center;">PRODUCT</th>
                                        <th style="text-align: center;">DATE</th>
                                        <th style="text-align: center;">QTY</th>
                                        <th style="text-align: center;">INVOICENO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listHistoryRetail as $row) {
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['FULLNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['LOCATION'] ?></td>
                                            <td style="text-align: center;"><?= $row['PRODUCT'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                            <td style="text-align: center;"><?= $row['QTY'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-body tab-pane" id="exchangePackage">
                    <div class="table-wrapper p-4">
                        <div class="table-responsive">
                            <table id="tableexchangePackage" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">NO</th>
                                        <th style="text-align: center;">SALES</th>
                                        <th style="text-align: center;">PURCHASE DATE</th>
                                        <th style="text-align: center;">INVOICENO</th>
                                        <th style="text-align: center;">NETTPRICE</th>
                                        <th style="text-align: center;">PACKAGE</th>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">BALANCE</th>
                                        <th style="text-align: center;">STATUS</th>
                                        <th style="text-align: center;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($membershipExchange as $row) {
                                        $status = '';
                                        $bgcolor = '';
                                        $statusPrepaidExchange = 2;
                                        if ($row['STATUS'] == 2 && $row['ISFULL'] == 0) {
                                            if ($row['REMAINING'] > 0) {
                                                $status = 'Ready';
                                                $bgcolor = 'bg-success';
                                                $statusPrepaidExchange = 1;

                                            } else {
                                                $status = 'Completed';
                                                $bgcolor = 'bg-danger';
                                                $statusPrepaidExchange = 2;
                                            }
                                        } elseif ($row['STATUS'] == 2 && $row['ISFULL'] == 1) {
                                            $status = 'Completed';
                                            $bgcolor = 'bg-danger';
                                            $statusPrepaidExchange = 2;
                                        } elseif ($row['STATUS'] == 28) {
                                            $status = 'Membership Expired';
                                            $bgcolor = 'bg-danger';
                                            $statusPrepaidExchange = 2;
                                        }
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['SALESNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                            <td style="text-align: right;">
                                                <?= number_format($row['NETTPRICE'], 0, ',', ',') ?>
                                            </td>
                                            <td style="text-align: center;"><?= $row['MEMBERSHIPNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                            <td style="text-align: center;">
                                                <?= $row['REMAINING'] ?>/<?= $row['TREAMENTTIMES'] ?>
                                            </td>
                                            <td class="f-td text-center text-white <?= $bgcolor ?>"><?= $status ?></td>
                                            <td class="f-td text-center text-white">
                                                <button
                                                    onclick="exchangeTreatment('<?= $row['TREATMENTNAME'] ?>','<?= $row['INVOICENO'] ?>', <?= $row['UNITPRICE'] ?>, <?= $row['REMAINING'] ?>, <?= $row['TREATMENTID'] ?>, <?= $customerId ?>, 2)"
                                                    class="btn btn-sm btn-primary" <?= $statusPrepaidExchange == 2 ? 'hidden' : '' ?>>
                                                    EXCHANGE
                                                </button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel-body tab-pane" id="historyExhcange">
                    <div class="table-wrapper p-4">
                        <div class="table-responsive">
                            <table id="tablehistoryExchange" class="table table-striped table-bordered"
                                style="width:100%">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">Customer</th>
                                        <th style="text-align: center;">Treatment</th>
                                        <th style="text-align: center;">Qty</th>
                                        <th style="text-align: center;">Amount</th>
                                        <th style="text-align: center;">Invoiceno</th>
                                        <th style="text-align: center;">Exchange Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($listHistoryExchange as $row) {
                                        ?>
                                        <tr role="" style="font-weight: 400;">
                                            <td style="text-align: center;"><?= $no++ ?></td>
                                            <td style="text-align: center;"><?= $row['FULLNAME'] ?></td>
                                            <td style="text-align: center;"><?= $row['TREATMENT'] ?></td>
                                            <td style="text-align: center;"><?= $row['QTY'] ?></td>
                                            <td style="text-align: center;"><?= $row['AMOUNT'] ?></td>
                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                            <td style="text-align: center;"><?= $row['EXCHANGEDATE'] ?></td>

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

<div class="modal fade modal-transparent modal-fullscreen" id="prePaid" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="dialog" style=" max-width: 90%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="ml-auto d-flex">
                    <button type="button" class="btn btn-secondary mr-2" id="btnSetToZero">
                        Set Point To 0
                    </button>
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="btnSaveExchange">
                        Close and Save
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3"> <!-- Baris 1 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="treatmentName">Treatment Name</label>
                            <input type="text" id="treatmentName" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoiceNo">Invoice No</label>
                            <input type="text" id="invoiceNo" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3"> <!-- Baris 2 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="remaining">Remaining</label>
                            <input type="number" id="remaining" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exchangePoint">Exchange Point</label>
                            <input type="number" id="exchangePoint" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <input type="number" id="typeTransaction" class="form-control" hidden>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="qty">Qty (Max: <span id="maxQty">1</span>)</label>
                            <input type="number" id="qty" class="form-control" min="1" value="1">
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
                <input type="text" id="customerId" class="form-control" hidden>
                <input type="text" id="treatmentId" class="form-control" hidden>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
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

        $('#tablehupcomingAppt').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#tablehistoryRetail').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

         $('#tablehistoryExchange').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        


        $('#tableexchangePackage').DataTable({
            "pageLength": 100,
            "lengthMenu": [2, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

    });


    $('#tblPrepaidTreatment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablehistoryDetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablePackageDetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablehupcomingAppt').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tablehistoryRetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableexchangePackage').removeClass('display').addClass(
        'table table-striped table-hover table-compact');


    function exchangeTreatment(treatmentname, invoceno, unitprice, remaining, treatmentid, customerid, type) {
        console.log('berhasil');

        $("#prePaid").modal("show");

        $("#treatmentName").val(treatmentname);
        $("#invoiceNo").val(invoceno);
        $("#remaining").val(remaining);
        $("#exchangePoint").val(unitprice);
        $("#customerId").val(customerid);
        $("#treatmentId").val(treatmentid);
        $("#typeTransaction").val(type);
        $("#qty").val(1);
        $("#qty").attr("max", remaining);
        $("#maxQty").text(remaining);
        $("#qty").data("unitprice", unitprice);

        updateExchangePoint();
    }

    function updateExchangePoint() {
        var qty = parseInt($("#qty").val()) || 1;
        var unitprice = parseFloat($("#qty").data("unitprice")) || 0;
        var total = qty * unitprice;
        $("#exchangePoint").val(total);
    }

    $(document).on("input", "#qty", function () {
        var qty = parseInt($(this).val());
        var max = parseInt($(this).attr("max")) || 1;

        if (qty < 1) {
            $(this).val(1);
        } else if (qty > max) {
            $(this).val(max);
        }

        updateExchangePoint();
    });


    $("#btnSetToZero").click(function () {
        $("#exchangePoint").val(0);
    });

    $("#btnSaveExchange").click(function () {
        const data = {
            customerId: $("#customerId").val(),
            treatmentId: $("#treatmentId").val(),
            invoiceNo: $("#invoiceNo").val(),
            qty: parseInt($("#qty").val()),
            totalPoint: parseFloat($("#exchangePoint").val()),
            typeTransaction: parseInt($("#typeTransaction").val()),
        };

        $.ajax({
            url: "<?= base_url() . 'App/saveExchangeTreatment' ?>",
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);

                alert("Data berhasil disimpan!");
                $("#prePaid").modal("hide");
                setTimeout(function () {
                    location.reload();
                }, 200);
            },
            error: function () {
                alert("Gagal menyimpan data.");
            }
        });
    });
</script>