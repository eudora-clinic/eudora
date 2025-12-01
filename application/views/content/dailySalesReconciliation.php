<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Daily Sales Report</title>

    <style>
        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }


        .nav-tabs {
            border-bottom: 2px solid #e0bfb2;
        }

        .nav-tabs .nav-item {
            margin-right: 5px;
        }

        .nav-tabs .nav-link {
            background-color: #f5e5de;
            /* Warna latar belakang tab */
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            /* Warna teks */
            border-radius: 8px 8px 0 0;
            /* Membuat sudut atas membulat */
            padding: 10px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e0bfb2;
            color: white;
        }

        .nav-tabs .nav-link.active {
            background-color: #e0bfb2 !important;
            color: white;
            border-bottom: 2px solid #d1a89b;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        .tab-content {
            padding: 0 !important;
        }

        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }
    </style>



    <?php

    $db_oriskin = $this->load->database('oriskin', true);
    // $locationId = $this->session->userdata('locationid');
    $userid = $this->session->userdata('userid');
    $locationIdFromUserdata = $this->session->userdata('locationid');
    $level = $this->session->userdata('level');
    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

    $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();
    $locationId = (isset($_GET['locationId']) ? $this->input->get('locationId') : $locationIdFromUserdata);

    $dateSearch = (isset($_GET['dateSearch']) ? $this->input->get('dateSearch') : date('Y-m-d'));

    $dailySalesReport = $db_oriskin->query("Exec spClinicDailySalesReport '" . $dateSearch . "', '" . $locationId . "' ")->result_array();
    $detailPayment = $db_oriskin->query("Exec spClinicDetailByPaymentPerDay '" . $dateSearch . "', '" . $locationId . "' ")->result_array();
    $summaryPayment = $db_oriskin->query("Exec spClinicSummaryByPaymentReconciliation '" . $dateSearch . "', '" . $locationId . "' ")->result_array();
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <?php if ($level == 4 || $level == 3 || $level == 6 || $level == 8) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>PERIOD</label>
                                    <input type="date" class="form-control text-uppercase" name="dateSearch" id="dateSearch"
                                        value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <!-- <label class="form-label mt-2">Location</label> -->
                                    <select id="locationId" name="locationId" class="form-control text-uppercase "
                                        required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>>
                                                <?= $j['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm top-responsive  btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <?php if ($level != 4 && $level != 3 && $level != 6 && $level != 8) { ?>
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3" style="display: flex; align-items: center;">
                            <div class="col-md-9 form-group pl-4">
                                <div class="form-group bmd-form-group">
                                    <label>PERIOD</label>
                                    <input type="date" class="form-control text-uppercase" name="dateSearch" id="dateSearch"
                                        value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn w-100 btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <div>
                <ul class="nav nav-tabs active mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#dailySales">DAILY SALES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailPayment">DETAIL PAYMENT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#summaryPayment">SUMMARY PAYMENT</a>
                    </li>


                </ul>
            </div>

            <div class="tab-content">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    DAILY SALES: <?= $dateSearch ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">DATE</th>
                                                    <th style="text-align: center;">INVOICE</th>
                                                    <th style="text-align: center;">MEMBER</th>
                                                    <th style="text-align: center;">CONSULTANT</th>
                                                    <th style="text-align: center;">BEAUTICIAN</th>
                                                    <th style="text-align: center;">BC</th>
                                                    <th style="text-align: center;">DOCTOR</th>

                                                    <th style="text-align: center;">FRONTDESK</th>
                                                    <!-- <th style="text-align: center;">TYPE</th> -->
                                                    <th style="text-align: center;">PRODUCT</th>

                                                    <th style="text-align: center;">MGM ID</th>
                                                    <th style="text-align: center;">PRICE</th>
                                                    <th style="text-align: center;">TOTAL DISC</th>
                                                    <th style="text-align: center;">REASON</th>
                                                    <th style="text-align: center;">QTY</th>
                                                    <th style="text-align: center;">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>

                                                    <!-- <th style="text-align: right"></th> -->
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>

                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>

                                                </tr>
                                            </tfoot>

                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($dailySalesReport as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                        <td style="text-align: centee;"><?= $row['INVOICENO'] ?></td>
                                                        <td style="text-align: centee;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CONSULTANT'] ?></td>
                                                        <td style="text-align: center;"><?= $row['BEAUTICIAN'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FROMBC'] ?></td>

                                                        <td style="text-align: center;"><?= $row['DOCTOR'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FRONTDESK'] ?></td>

                                                        <td style="text-align: center;">
                                                            <?= $row['PRODUCTNAME'] ?>
                                                            <?= !empty($row['REMARKS']) ? ' : ' . $row['REMARKS'] : '' ?>
                                                        </td>

                                                        <td style="text-align: center;"><?= $row['ITEMCODE'] ?></td>

                                                        <td style="text-align: center;">
                                                            <?= number_format($row['PRICE'], 0, '.', ',') ?>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['TOTALDISCOUNT'], 0, '.', ',') ?>
                                                        </td>

                                                        <td style="text-align: center;"><?= $row['DISCOUNTREASON'] ?></td>
                                                        <td style="text-align: right;"><?= $row['QTY'] ?></td>



                                                        <td style="text-align: right;">
                                                            <?= number_format($row['TOTAL'], 0, '.', ',') ?>
                                                        </td>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="detailPayment">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    DETAIL PAYMENT : <?= $dateSearch ?>
                                    </h4>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableDetailPayment" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">INVOICE</th>
                                                        <th style="text-align: center;">PAYMENT</th>
                                                        <th style="text-align: center;">EDC</th>
                                                        <th style="text-align: center;">CARD TYPE</th>
                                                        <th style="text-align: center;">INSTALLMENT</th>
                                                        <th style="text-align: center;">AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th style="text-align: right"></th>
                                                        <th style="text-align: right"></th>
                                                        <th style="text-align: right"></th>
                                                        <th style="text-align: right"></th>
                                                        <th style="text-align: right"></th>

                                                        <th style="text-align: right"></th>
                                                        <th style="text-align: right"></th>
                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($detailPayment as $row) {
                                                        ?>
                                                        <tr role="" style="font-weight: 400;">
                                                            <td style="text-align: center;"><?= $no++ ?></td>
                                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['PAYMENTNAME'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['EDCNAME'] ?></td>
                                                            <td style="text-align: center;"><?= $row['CARDTYPENAME'] ?></td>
                                                            <td style="text-align: center;"><?= $row['INSTALLMENTNAME'] ?>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?= number_format($row['AMOUNT'], 0, '.', ',') ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="summaryPayment">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    SUMMARY PAYMENT : <?= $dateSearch ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableSummaryPayment" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">PAYMENT</th>
                                                    <th style="text-align: center;">EDC</th>
                                                    <th style="text-align: center;">CARD TYPE</th>
                                                    <th style="text-align: center;">INSTALLMENT</th>
                                                    <th style="text-align: center;">AMOUNT</th>
                                                    <th style="text-align: center;">SETTLEMENT</th>
                                                    <th style="text-align: center;">BALANCE</th>
                                                    <th style="text-align: center;">AMOUNT RECEIVED</th>
                                                    <th style="text-align: center;">MDR</th>
                                                    <th style="text-align: center;">STATUS</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                </tr>
                                            </tfoot>

                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($summaryPayment as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>

                                                        <td style="text-align: centee;"><?= $row['PAYMENTNAME'] ?></td>
                                                        <td style="text-align: centee;"><?= $row['EDCNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CARDTYPENAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['INSTALLMENTNAME'] ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['AMOUNT'], 0, '.', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['AMOUNTSETTLEMENT'], 0, '.', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['AMOUNTBALANCE'], 0, '.', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= is_null($row['AMOUNTRECEIVED']) ? '<span class="text-muted">Belum Reconciliation</span>' : number_format($row['AMOUNTRECEIVED'], 0, '.', ',') ?>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <?= is_null($row['MDR']) ? '<span class="text-muted">Belum Reconciliation</span>' : number_format($row['MDR'], 0, '.', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                          
                                                            <small style="
                                                                    <?php
                                                                    if (is_null($row['STATUS'])) {
                                                                        echo 'color: #dc3545; font-weight: bold;'; // merah untuk "Belum Reconciliation"
                                                                    } elseif ($row['STATUS'] == 1) {
                                                                        echo 'color: #fd7e14; font-weight: bold;'; // oranye untuk "Belum Approved"
                                                                    } elseif ($row['STATUS'] == 2) {
                                                                        echo 'color: #28a745; font-weight: bold;'; // hijau untuk "Approved"
                                                                    } else {
                                                                        echo 'color: gray;';
                                                                    }
                                                                    ?>
                                                                ">
                                                                <?php
                                                                if (is_null($row['STATUS'])) {
                                                                    echo 'Belum Reconciliation';
                                                                } elseif ($row['STATUS'] == 1) {
                                                                    echo 'Belum Approved';
                                                                } elseif ($row['STATUS'] == 2) {
                                                                    echo 'Approved';
                                                                } else {
                                                                    echo 'Status Tidak Dikenal';
                                                                }
                                                                ?>
                                                            </small>
                                                        </td>



                                                        <td style="text-align: center;">
                                                            <button class="btn-sm btn-primary btn-detail"
                                                                style="cursor: pointer;" data-id="<?= $row['IDRECON'] ?>"
                                                                data-locationid="<?= $row['LOCATIONID'] ?>"
                                                                data-invoicedate="<?= $row['DATEINV'] ?>"
                                                                data-paymentname="<?= $row['PAYMENTNAME'] ?>"
                                                                data-amount="<?= $row['AMOUNT'] ?>"
                                                                data-paymentid="<?= $row['PAYMENTID'] ?>">DETAIL</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="detailSection" class="p-4" style="display: none;">
                                    <h4 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                        RECONCILIATION DETAILS
                                    </h4>
                                    <div id="detailContent" style="margin-top: 20px;">
                                        <!-- Content will be loaded here via AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Reconciliation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editId">

                        <div class="form-column">
                            <label for="editAmountOmset" class="form-label mt-2"><strong>AMOUNT OMSET:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" id="editAmountOmset" class="form-control" readonly>
                        </div>

                        <div class="form-column">
                            <label for="editAmountReceived" class="form-label mt-2"><strong>AMOUNT
                                    RECEIVED:</strong><span class="text-danger">*</span></label>
                            <input type="number" id="editAmountReceived" class="form-control currency-input" required>
                        </div>

                        <div class="form-column">
                            <label for="editReceivedDate" class="form-label mt-2"><strong> RECEIVED DATE:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="date" id="editReceivedDate" class="form-control" required>
                        </div>

                        <div class="form-column">
                            <label for="mdrUpdate" class="form-label mt-2"><strong>MDR
                                    :</strong><span class="text-danger">*</span></label>
                            <input type="number" id="mdrUpdate" class="form-control currency-input" required>
                        </div>

                        <!-- <div class="form-column">
                            <label for="editCurrentMdr" class="form-label mt-2"><strong>CURRENT MDR:</strong><span
                                    class="text-danger">*</span></label>
                            <p id="editCurrentMdr" class="form-control-static"></p>
                        </div>

                        <div class="form-column">
                            <label for="editMdrPreview" class="form-label mt-2"><strong>NEW MDR
                                    PREVIEW:</strong></label>
                            <p id="editMdrPreview" class="form-control-static font-weight-bold"></p>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Reconciliation</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="createForm">
                    <div class="modal-body">
                        <input type="hidden" id="createPaymentId">
                        <input type="hidden" id="createLocationId">
                        <!-- <div class="form-column">
                            <label for="createPaymentType" class="form-label mt-2"><strong>PAYMENT TYPE:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" id="createPaymentType" class="form-control" readonly>
                        </div> -->

                        <div class="form-column">
                            <label for="createAmountOmset" class="form-label mt-2"><strong>AMOUNT OMSET:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" id="createAmountOmset" class="form-control" readonly>
                        </div>

                        <div class="form-column">
                            <label for="createTransactionDate" class="form-label mt-2"><strong> TRANSACTION
                                    DATE:</strong><span class="text-danger">*</span></label>
                            <input type="date" id="createTransactionDate" class="form-control" required readonly>
                        </div>


                        <div class="form-column">
                            <label for="createAmountReceived" class="form-label mt-2"><strong>AMOUNT
                                    RECEIVED:</strong><span class="text-danger">*</span></label>
                            <input value="0" type="text" id="createAmountReceived" class="form-control currency-input"
                                required>
                        </div>

                        <div class="form-column">
                            <label for="createReceivedDate" class="form-label mt-2"><strong> RECEIVED
                                    DATE:</strong><span class="text-danger">*</span></label>
                            <input type="date" id="createReceivedDate" class="form-control" required>
                        </div>

                        <div class="form-column">
                            <label for="mdrCreate" class="form-label mt-2"><strong>MDR
                                    :</strong><span class="text-danger">*</span></label>
                            <input value="0" type="text" id="mdrCreate" class="form-control currency-input" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Lampiran -->
    <div class="modal fade" id="modalAddLampiran" tabindex="-1" aria-labelledby="modalAddLampiranLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formUploadLampiran" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Lampiran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="lampiran-id">
                        <input type="hidden" name="numberOfImage" id="numberOfImage">

                        <label for="lampiran" class="form-label">Pilih Gambar:</label>
                        <input type="file" name="lampiran" id="lampiran" accept="image/*" class="form-control" required
                            onchange="previewLampiran(event)">

                        <div id="preview-lampiran" class="mt-3 text-center" style="display: none;">
                            <img id="lampiran-img-preview" src="#" alt="Preview"
                                style="max-width: 100%; max-height: 300px; border: 1px solid #ccc; border-radius: 6px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalUpdateLampiran" tabindex="-1" aria-labelledby="modalUpdateLampiranLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto">
            <form id="formUpdateLampiran" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Lampiran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="lampiran-idupdate">
                        <input type="hidden" name="old_image" id="lampiran-old-image">
                        <input type="hidden" name="numberOfImage" id="lampiran-idupdatenumberOfImage">

                        <div id="current-image-preview" class="mb-2 text-center"
                            style="max-width: 200px; max-height: 200px; border: 1px solid #ccc; border-radius: 6px; display: block">
                        </div>

                        <?php if ($level == 8 || $level == 4) { ?>
                            <label for="lampiran-update" class="form-label">Pilih Gambar:</label>
                            <input type="file" name="lampiran-update" id="lampiran-update" accept="image/*"
                                class="form-control" required onchange="previewLampiranUpdate(event)">

                            <div id="preview-lampiran-update" class="mt-3" style="display: none;">
                                <img id="lampiran-img-preview-update" src="#" alt="Preview"
                                    style="max-width: 200px; max-height: 200px; border: 1px solid #ccc; border-radius: 6px;">
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($level == 8 || $level == 4) { ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Lampiran</button>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Preview Gambar Fullscreen -->
    <div id="imagePreviewModal"
        style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.8); justify-content:center; align-items:center;">
        <button id="closePreviewBtn"
            style="position:absolute; top:20px; right:20px; background:red; color:white; border:none; padding:10px 15px; border-radius:5px; cursor:pointer;">X</button>
        <img id="fullImagePreview" src="" alt="Preview" style="max-width:90vw; max-height:90vh; border-radius:10px;">
    </div>

</body>
<script>
    var numberFormat = function (number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };

        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }

        return s.join(dec);
    }

    $(document).ready(function () {
        $('#tableDailySales').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered12 = display.map(el => data[el][11]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered13 = display.map(el => data[el][12]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered15 = display.map(el => data[el][14]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered16 = display.map(el => data[el][15]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(11).footer()).html(
                    numberFormat(sumCol11Filtered12,)
                );
                $(api.column(12).footer()).html(
                    numberFormat(sumCol11Filtered13,)
                );

                $(api.column(14).footer()).html(
                    numberFormat(sumCol11Filtered15, 0)
                );
                $(api.column(15).footer()).html(
                    numberFormat(sumCol11Filtered16, 0)
                );

            },
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Daily Sales Report',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                // exportOptions: {
                //     columns: [0, 1, 2, 3, 4]
                // },
                customize: function (doc) {

                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function (row, index) {
                        if (index > 0 && row[0].text !== '') {
                            row[0].text = rowCount;
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;

                    doc.content[1].layout = {
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                }
            }, 'excel']
        });



        $('#tableDetailPayment').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered16 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);


                $(api.column(6).footer()).html(
                    numberFormat(sumCol11Filtered16, 0)
                );

            },
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Detail Payment',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                // exportOptions: {
                //     columns: [0, 1, 2, 3, 4]
                // },
                customize: function (doc) {

                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function (row, index) {
                        if (index > 0 && row[0].text !== '') {
                            row[0].text = rowCount;
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;

                    doc.content[1].layout = {
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                }
            }, 'excel']
        });

        $('#tableSummaryPayment').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered16 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered15 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered17 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered18 = display.map(el => data[el][8]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered19 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(6).footer()).html(
                    numberFormat(sumCol11Filtered16, 0)
                );

                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered15, 0)
                );

                $(api.column(7).footer()).html(
                    numberFormat(sumCol11Filtered17, 0)
                );

                $(api.column(8).footer()).html(
                    numberFormat(sumCol11Filtered18, 0)
                );

                $(api.column(9).footer()).html(
                    numberFormat(sumCol11Filtered19, 0)
                );

            },
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Summary Payment',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                // exportOptions: {
                //     columns: [0, 1, 2, 3, 4]
                // },
                customize: function (doc) {

                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function (row, index) {
                        if (index > 0 && row[0].text !== '') {
                            row[0].text = rowCount;
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;

                    doc.content[1].layout = {
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                }
            }, 'excel']
        });
    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableDetailPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableSummaryPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

<script>
    $(document).ready(function () {
        var level = '<?= $level ?>';
        $('.btn-detail').click(function () {
            var id = $(this).data('id');
            var locationid = $(this).data('locationid');
            var invoicedate = $(this).data('invoicedate');
            var paymentid = $(this).data('paymentid');
            var paymentname = $(this).data('paymentname');
            var amount = $(this).data('amount');

            console.log(id, locationid, invoicedate, paymentid);

            if (id !== null && id !== undefined && id !== '') {
                loadDetailData(id);
            } else {
                if (level == 8 || level == 4) {
                    $('#detailSection').show();
                    $('#detailContent').html(`
                        <div class="card text-center shadow-sm p-4 border border-info">
                            <div class="card-body">
                                <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                                <h5 class="card-title text-primary">Data Rekonsiliasi Tidak Ditemukan</h5>
                                <p class="card-text text-muted">Belum ada data rekonsiliasi yang tercatat untuk transaksi ini. Silakan tambahkan data baru jika diperlukan.</p>
                                <button class="btn btn-success mt-2" id="btnAddNew">
                                    <i class="fas fa-plus-circle me-1"></i> Tambah Data Rekonsiliasi
                                </button>
                            </div>
                        </div>
                    `);
                } else if (level == 4 || level == 8) {
                    $('#detailSection').show();
                    $('#detailContent').html(`
                        <div class="card text-center shadow-sm p-4 border border-info">
                            <div class="card-body">
                                <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                                <h5 class="card-title text-primary">Data Rekonsiliasi Tidak Ditemukan</h5>
                                <p class="card-text text-muted">Belum ada data rekonsiliasi yang tercatat untuk transaksi ini. Silakan tambahkan data baru jika diperlukan.</p>
                            </div>
                        </div>
                    `);
                }



                $('#btnAddNew').click(function () {
                    $('#createModal').modal('show');
                    $('#createPaymentId').val(paymentid);
                    $('#createLocationId').val(locationid);
                    $('#createAmountOmset').val(amount);
                    $('#createPaymentType').val(paymentname);
                    $('#createTransactionDate').val(invoicedate);

                    calculateCreateMdrPreview();
                });
            }

        });

        function loadDetailData(id) {
            $.ajax({
                url: '<?= base_url('') ?>App/getDetailReconciliation/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    $('#detailSection').show();
                    if (response.data && response.data.length > 0) {
                        const hasLampiran = response.data[0].image && response.data[0].image !== '';
                        const hasLampiran2 = response.data[0].image_2 && response.data[0].image_2 !== '';
                        const addNewRecon = response.data[0].status == 1 && (level == 8 || level == 4)

                        const lampiranButton = hasLampiran
                            ? `<button class="btn-sm btn-success me-2 btn-update-lampiran" style="margin-bottom: 20px; cursor: pointer" data-id="${response.data[0].id}" data-image="${response.data[0].image}" data-numberofimage="1">Lihat Lampiran 1</button>`
                            : (level == 8 || level == 4
                                ? `<button class="btn-sm btn-primary me-2" id="btnAddLampiran" style="margin-bottom: 20px; cursor: pointer">Add Lampiran</button>`
                                : `<span class="text-muted me-2" style="margin-bottom: 20px;">Tidak ada lampiran</span>`)

                        const lampiranButton2 = hasLampiran2
                            ? `<button class="btn-sm btn-success me-2 btn-update-lampiran" style="margin-bottom: 20px; cursor: pointer" data-id="${response.data[0].id}" data-image="${response.data[0].image_2}" data-numberofimage="2">Lihat Lampiran 2</button>`
                            : ((level == 8 || level == 4) && hasLampiran
                                ? `<button class="btn-sm btn-primary me-2" id="btnAddLampiran2" style="margin-bottom: 20px; cursor: pointer">Add Lampiran</button>`
                                : `<span class="text-muted me-2" style="margin-bottom: 20px;">Tidak ada lampiran</span>`)

                        const buttonAddNewRecon = addNewRecon
                            ? `<button class="btn-sm btn-primary me-2" id="addNewRecon" style="margin-bottom: 20px; cursor: pointer">Add New Recon</button>`
                            : ''


                        var html = `
                            <div class="table-responsive">
                               ${lampiranButton} ${lampiranButton2}   ${buttonAddNewRecon}  
                                <table id="detailTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead class="bg-thead">
                                        <tr>
                                            <th >ID</th>
                                            <th>Amount Omset</th>
                                            <th>Amount Received</th>
                                            <th>Received Date</th>
                                            <th>Transaction Date</th>
                                            <th>MDR</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

                        response.data.forEach(function (item) {
                            let actionButtons = '';
                            let updateLampiran = '';

                            if (item.status == 1 && (level == 8 || level == 4)) {
                                actionButtons = `
                                    <td class="row" style="justify-content: center;">
                                        <button class="btn btn-sm btn-warning btn-edit" data-id="${item.id}">Update</button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">Void</button>
                                        <button class="btn btn-sm btn-danger btn-approve" data-id="${item.id}">Approved</button>
                                    </td>
                                `;

                            } else if (item.status == 1 && (level == 4 || level == 8)) {
                                actionButtons = `
                                    <td class="row" style="justify-content: center;">
                                        <button class="btn btn-sm btn-danger btn-approve" data-id="${item.id}">Approved</button>
                                    </td>
                                `;
                            }

                            html += `
                                <tr>
                                    <td class="text-center">${item.id}</td>
                                    <td class="text-center">${formatCurrency(item.amountomset)}</td>
                                    <td class="text-center">${formatCurrency(item.amountreceived)}</td>
                                    <td class="text-center">${formatDate(item.receiveddate)}</td>
                                    <td class="text-center">${formatDate(item.transactiondate)}</td>
                                    <td class="text-center">${formatCurrency(item.mdr)}</td>
   
                                    <td class="text-center">${getStatusText(item.status)}</td>
                                    ${actionButtons}  
                                    
                                </tr>`;
                        });

                        // ${updateLampiran}

                        html += `</tbody></table></div>`;
                        $('#detailContent').html(html);

                        // Tambahkan event handler untuk tombol edit/delete
                        $('.btn-edit').click(function () {
                            var id = $(this).data('id');
                            openEditModal(id);
                        });

                        $('#addNewRecon').click(function () {
                            $('#createModal').modal('show');
                            $('#createPaymentId').val(response.data[0].paymentid);
                            $('#createLocationId').val(response.data[0].locationid);
                            $('#createAmountOmset').val(response.data[0].amountomset);
                            $('#createTransactionDate').val(formatDate2(response.data[0].transactiondate));

                            calculateCreateMdrPreview();
                        });

                        $('.btn-delete').click(function () {
                            var id = $(this).data('id');
                            deleteReconciliation(id);
                        });

                        $('.btn-approve').click(function () {
                            var id = $(this).data('id');
                            approveReconciliation(id);
                        });

                        if (!hasLampiran) {
                            $('#btnAddLampiran').click(function () {
                                $('#lampiran-id').val(response.data[0].id);
                                $('#modalAddLampiran').modal('show');
                                $('#numberOfImage').val(1);
                            });
                        }

                        if (!hasLampiran2) {
                            $('#btnAddLampiran2').click(function () {
                                $('#lampiran-id').val(response.data[0].id);
                                $('#modalAddLampiran').modal('show');

                                $('#numberOfImage').val(2);
                            });
                        }

                        $('#detailTable').DataTable({
                            "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                            "responsive": true,
                            "language": {
                                "search": "Search:",
                                "lengthMenu": "Show _MENU_ entries",
                                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                                "paginate": {
                                    "previous": "Previous",
                                    "next": "Next"
                                }
                            },
                            "columnDefs": [
                                { "orderable": false, "targets": [8] }, // Non-aktifkan sorting untuk kolom action
                                { "className": "dt-center", "targets": "_all" }, // Pusatkan semua kolom
                                { "width": "5%", "targets": 0 }, // Atur lebar kolom ID
                                { "width": "10%", "targets": 8 } // Atur lebar kolom action
                            ]
                        });

                    }
                },
                error: function (xhr, status, error) {
                    $('#detailSection').show();
                    $('#detailContent').html(`
                    <div class="alert alert-danger">
                        Error loading data: ${error}
                    </div>
                `);
                }
            });
        }

        function deleteReconciliation(id) {
            $.ajax({
                url: '<?= base_url('App/deleteReconciliation/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Data berhasil divoid');
                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        function approveReconciliation(id) {
            $.ajax({
                url: '<?= base_url('App/approveReconciliation/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Data berhasil di approved');
                        loadDetailData(id);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString();
        }

        function formatDate2(dateString) {
            const date = new Date(dateString);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }


        function getStatusText(status) {
            const statusMap = {
                1: 'Draft',
                2: 'Approved',
                3: 'Void'
            };
            return statusMap[status] || 'Unknown';
        }// Fungsi untuk membuka modal edit
        function openEditModal(id) {

            console.log(id);

            $.ajax({
                url: '<?= base_url('App/getDetailForEdit/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {

                    if (response.success) {
                        const data = response.data[0]
                        $('#editModal').modal('show');
                        $('#editId').val(data.id);
                        $('#editAmountOmset').val(data.amountomset);
                        $('#editAmountReceived').val(data.amountreceived);
                        const receivedDate = new Date(data.receiveddate);
                        const formattedDate = receivedDate.toISOString().split('T')[0];
                        $('#editReceivedDate').val(formattedDate);
                        $('#mdrUpdate').val(data.mdr);


                        // Hitung preview MDR
                        calculateMdrPreview();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }


        $('#editForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                id: $('#editId').val(),
                amountreceived: $('#editAmountReceived').val().replace(/,/g, ''),
                receiveddate: $('#editReceivedDate').val(),
                mdrUpdate: $('#mdrUpdate').val()
            };

            $.ajax({
                url: '<?= base_url('App/updateReconciliation') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        alert('Data berhasil diperbarui');
                        $('#editModal').modal('hide');
                        loadDetailData(formData.id);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('gatau error apa');
                }

            });
        });


        $('#createForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                amountreceived: $('#createAmountReceived').val().replace(/,/g, ''),
                receiveddate: $('#createReceivedDate').val(),
                paymentid: $('#createPaymentId').val(),
                locationid: $('#createLocationId').val(),
                amountomset: $('#createAmountOmset').val(),
                transactiondate: $('#createTransactionDate').val(),
                mdrCreate: $('#mdrCreate').val(),
            };

            $.ajax({
                url: '<?= base_url('App/createReconciliation') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    // console.log(response);

                    if (response.success) {
                        alert('Data berhasil diperbarui');
                        $('#createModal').modal('hide');
                        // loadDetailData(formData.id);
                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('gatau error apa');
                }

            });
        });

        $('#formUploadLampiran').submit(function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '<?= base_url('App/uploadLampiran') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    if (res.status === 200) {
                        alert('Lampiran berhasil diupload');
                        $('#modalAddLampiran').modal('hide');
                        // reload ulang datanya
                        loadDetailData(formData.get('id'));
                    } else {
                        alert(res.message || 'Gagal upload');
                    }
                },
                error: function () {
                    alert('Upload gagal.');
                }
            });
        });

        $('#formUpdateLampiran').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: '<?= base_url("App/updateLampiran") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res.success) {
                        alert('Lampiran berhasil diupdate');
                        $('#modalUpdateLampiran').modal('hide');
                        loadDetailData(formData.get('id'));
                        // reloadData(); // fungsi untuk refresh table, kalau ada
                    } else {
                        alert(res.message || 'Gagal update lampiran');
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat mengupdate lampiran');
                }
            });
        });


        // $('#editAmountReceived').on('input', calculateMdrPreview);
        // $('#createAmountReceived').on('input', calculateCreateMdrPreview);
    });
</script>

<script>
    function previewLampiran(event) {
        const input = event.target;
        const preview = document.getElementById('lampiran-img-preview');
        const container = document.getElementById('preview-lampiran');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
            preview.src = '#';
        }
    }

    function previewLampiranUpdate(event) {
        const input = event.target;
        const preview = document.getElementById('lampiran-img-preview-update');
        const container = document.getElementById('preview-lampiran-update');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
            preview.src = '#';
        }
    }

    // Tampilkan modal update dan isi data
    $(document).on('click', '.btn-update-lampiran', function () {
        const id = $(this).data('id');
        const image = $(this).data('image');
        const numberOfImage = $(this).data('numberofimage');

        $('#lampiran-idupdate').val(id);
        $('#lampiran-old-image').val(image);
        $('#lampiran-idupdatenumberOfImage').val(numberOfImage);

        if (image) {
            $('#current-image-preview').html(`
            <img id="preview-trigger-image" src="https://sys.eudoraclinic.com:84/app/${image}" style="max-width: 100%; border-radius: 5px; cursor: pointer; align-items: center; text-align: center">
        `);

            $('#preview-trigger-image').on('click', function () {
                $('#fullImagePreview').attr('src', $(this).attr('src'));
                $('#imagePreviewModal').css('display', 'flex');
            });
        } else {
            $('#current-image-preview').html('<span class="text-muted">Belum ada lampiran</span>');
        }


        $('#modalUpdateLampiran').modal('show');
    });

    $('#closePreviewBtn').on('click', function () {
        $('#imagePreviewModal').hide();
        $('#fullImagePreview').attr('src', '');
    });



    // Tampilkan modal update dan isi data
    $(document).on('click', '.btn-full-lampiran', function () {
        const image = $(this).data('image');

        $('#lampiran-idupdate').val(id);
        $('#lampiran-old-image').val(image);

        if (image) {
            $('#current-image-preview').html(`<img src="https://sys.eudoraclinic.com:84/app/${image}" style="max-width: 100%; border-radius: 5px;">`);
        } else {
            $('#current-image-preview').html('<span class="text-muted">Belum ada lampiran</span>');
        }

        $('#modalUpdateLampiran').modal('show');
    });

    // Submit form update

    // Submit form update


</script>


</html>