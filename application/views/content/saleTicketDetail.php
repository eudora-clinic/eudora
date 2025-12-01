<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Sale Ticket Detail</title>

    <script src="https://cdn.jsdelivr.net/npm/datatables-rowsgroup@2.0.0/dataTables.rowsGroup.min.js"></script>


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
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class="card p-2 col-md-9">
                <form id="form-cari-invoice" method="post" action="<?= base_url('saleTicketDetail') ?>">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                <input type="date" name="dateStart" class="form-control filter_period" value="<?= $dateStart ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Date End</label>
                                <input type="date" name="dateEnd" class="form-control filter_period" value="<?= $dateEnd ?>" required>

                            </div>
                        </div>

                        <div class="col-md-3">
                                <div class="form-group">
                                    <select id="locationId" name="locationId" class="form-control text-uppercase " required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i> Search</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div>
                        <div class="card">
                            <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                DETAIL REVENUE: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h4>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableSaleTicketDetail" class="table table-striped table-bordered" style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">SALES</th>
                                                    <th style="text-align: center;">MEMBER</th>
                                                    <th style="text-align: center;">INVOICEDATE</th>
                                                    <th style="text-align: center;">INVOICENO</th>
                                                    <th style="text-align: center;">TYPE TRANSACTION</th>
                                                    <th style="text-align: center;">PRODUCT</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">AMOUNT TOTAL</th>
                                                    <th style="text-align: center;">AMOUNT RECEIVED</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="10" style="text-align:right;"><strong>Total:</strong></th>
                                                    <th>
                                                        <strong>
                                                            <?= number_format(array_sum(array_column($detailRevenueBySales, 'AMOUNTPRODUCT'))) ?>
                                                        </strong>
                                                    </th>
                                                    <th>
                                                        <strong>
                                                            <?= number_format(array_sum(array_column($detailRevenueBySales, 'AMOUNT'))) ?>
                                                        </strong>
                                                    </th>
                                                </tr>
                                            </tfoot>

                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($detailRevenueBySales as $row): ?>
                                                    <?php
                                                    $treatments = json_decode($row['treatments'], true);
                                                    if (empty($treatments)) {
                                                        $treatments = [['code' => $row['CODE'], 'name' => $row['TREATMENTNAME']]];
                                                    }
                                                    $rowspan = count($treatments);
                                                    ?>
                                                    <?php foreach ($treatments as $i => $t): ?>
                                                        <tr>
                                                            <?php if ($i == 0): ?>
                                                                <td rowspan="<?= $rowspan ?>"><?= $no++ ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['LOCATIONNAME'] ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['SALESNAME'] ?>, <?= $row['SALES2NAME'] ?>, <?= $row['SALES3NAME'] ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['MEMBERNAME'] ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['INVOICEDATE'] ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['INVOICENO'] ?? '-' ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['TYPETRANSACTION'] ?? '-' ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= $row['TREATMENTNAME'] ?? '-' ?></td>
                                                            <?php endif; ?>
                                                            <td><?= $t['code'] ?></td>
                                                            <td><?= $t['name'] ?></td>
                                                            <?php if ($i == 0): ?>
                                                                <td rowspan="<?= $rowspan ?>"><?= number_format($row['AMOUNTPRODUCT']) ?></td>
                                                                <td rowspan="<?= $rowspan ?>"><?= number_format($row['AMOUNT']) ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
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

    
</body>

<script>
    $(document).ready(function () {
        $('#tableSaleTicketDetail').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export Excel',
                    className: 'btn btn-sm btn-success',
                    title: 'Revenue Report <?= $dateStart ?> to <?= $dateEnd ?>',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            ordering: false
        });
    });
</script>



</html>