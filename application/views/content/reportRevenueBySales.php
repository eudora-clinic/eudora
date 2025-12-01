<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Revenue By Sales</title>

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
    $level = $this->session->userdata('level');
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class="card p-2 col-md-9">
                <form id="form-cari-invoice" method="post" action="<?= base_url('reportRevenueBySales') ?>">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                <input type="date" name="dateStart" class="form-control filter_period"
                                    value="<?= $dateStart ?>" required>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date End</label>
                                <input type="date" name="dateEnd" class="form-control filter_period"
                                    value="<?= $dateEnd ?>" required>

                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-group">
                                <button type="submit" name="submit"
                                    class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i>
                                    Search</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>


            <div>
                <ul class="nav nav-tabs active mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#summary">SUMMARY REVENUE</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detail">DETAIL REVENUE</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="summary">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    SUMMARY REVENUE: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="row p-4 filter-container">

                                    <label for="filterBranch">BRANCH:</label>
                                    <select id="filterBranch" multiple="multiple">
                                        <option value="">ALL</option>
                                        <?php foreach ($locationList as $location) { ?>
                                            <option value="<?= htmlspecialchars($location['name']) ?>">
                                                <?= htmlspecialchars($location['name']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>



                                    <label for="filterStaff">STAFF:</label>
                                    <select id="filterStaff" multiple="multiple">
                                        <option value="">ALL</option>
                                        <?php foreach ($staffSalesInvoice as $staff) { ?>
                                            <option value="<?= htmlspecialchars($staff['EMPLOYEENAME']) ?>">
                                                <?= htmlspecialchars($staff['EMPLOYEENAME']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">SALES</th>
                                                    <th style="text-align: center;">PRODUCT</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">PACKAGE</th>
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
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                </tr>
                                            </tfoot>

                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($summaryRevenueBySales as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: centee;"><?= $row['SALESNAME'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['PRODUK'], 0, '.', ',') ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['TREATMENT'], 0, '.', ',') ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['PACKAGE'], 0, '.', ',') ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['TOTAL'], 0, '.', ',') ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="detail">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    DETAIL REVENUE: <?= $dateStart ?> - <?= $dateEnd ?>
                                    </h4>

                                    <div class="row p-4 filter-container">
                                        
                                            <label for="filterBranch2">BRANCH:</label>
                                            <select id="filterBranch2" multiple="multiple">
                                                <option value="">ALL</option>
                                                <?php foreach ($locationList as $location) { ?>
                                                    <option value="<?= htmlspecialchars($location['name']) ?>">
                                                        <?= htmlspecialchars($location['name']) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                     


                                        <label for="filterStaff2">STAFF:</label>
                                        <select id="filterStaff2" multiple="multiple">
                                            <option value="">ALL</option>
                                            <?php foreach ($staffSalesInvoice as $staff) { ?>
                                                <option value="<?= htmlspecialchars($staff['EMPLOYEENAME']) ?>">
                                                    <?= htmlspecialchars($staff['EMPLOYEENAME']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableDetailPayment" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">LOCATION</th>
                                                        <th style="text-align: center;">SALES</th>
                                                        <th style="text-align: center;">SALES2</th>
                                                        <th style="text-align: center;">SALES3</th>
                                                        <th style="text-align: center;">MEMBER</th>
                                                        <th style="text-align: center;">INVOICEDATE</th>
                                                        <th style="text-align: center;">INVOICENO</th>
                                                        <th style="text-align: center;">TYPE TRANSACTION</th>
                                                        <th style="text-align: center;">AMOUNT</th>
                                                        <th style="text-align: center;">CELLPHONENUMBER</th>
                                                        <th style="text-align: center;">CUSTOMERCODE</th>
                                                        <th style="text-align: center;">CUSTOMERID</th>
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
                                                        <th style="text-align: right"></th>

                                                    </tr>
                                                </tfoot>

                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($detailRevenueBySales as $row) {
                                                        ?>
                                                        <tr role="" style="font-weight: 400;">
                                                            <td style="text-align: center;"><?= $no++ ?></td>
                                                            <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['SALESNAME'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['SALES2NAME'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['SALES3NAME'] ?></td>
                                                            <td style="text-align: centee;"><?= $row['MEMBERNAME'] ?></td>
                                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                            <?php if ($level != 4): ?>
                                                                <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                            <?php endif; ?>
                                                            <?php if ($level == 4): ?>
                                                                <td style="text-align: center;">
                                                                    <?php
                                                                    $invoiceNo = $row['INVOICENO'];
                                                                    $invoiceType = $row['INVOICETYPE'];
                                                                    $url = '#';

                                                                    if ($invoiceType == 1) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceMembership';
                                                                    } elseif ($invoiceType == 2) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceDownMembership';
                                                                    } elseif ($invoiceType == 3) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceTreatment';
                                                                    } elseif ($invoiceType == 4) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceDownTreatment';
                                                                    } elseif ($invoiceType == 5) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceRetail';
                                                                    } elseif ($invoiceType == 6) {
                                                                        $url = 'https://sys.eudoraclinic.com:84/app/invoiceDownRetail';
                                                                    }
                                                                    ?>
                                                                    <a href="<?= $url ?>?invoice=<?= urlencode($invoiceNo) ?>"
                                                                        target="_blank">
                                                                        <?= $invoiceNo ?>
                                                                    </a>
                                                                </td>
                                                            <?php endif; ?>

                                                            <td style="text-align: center;"><?= $row['TYPETRANSACTION'] ?>
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <?= number_format($row['AMOUNT'], 0, '.', ',') ?></td>
                                                            <td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?>
                                                            </td>
                                                            <td style="text-align: center;"><?= $row['CUSTOMERCODE'] ?></td>
                                                            <td style="text-align: center;"><?= $row['CUSTOMERID'] ?></td>
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
        var table = $('#tableDailySales').DataTable({
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

                var sumCol11Filtered12 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered13 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered15 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered16 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(3).footer()).html(
                    numberFormat(sumCol11Filtered12,)
                );
                $(api.column(4).footer()).html(
                    numberFormat(sumCol11Filtered13,)
                );

                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered15, 0)
                );
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
                title: 'SUMMARY REVENUE BY SALES',
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

        $('#filterBranch, #filterStaff').select2({
            width: '200px'
        });

        $('#filterStaff').on('change', function () {
            var valuesss = $(this).val().join('|');
            table.column(2).search(valuesss, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterBranch').on('change', function () {
            var valuesss = $(this).val().join('|');
            table.column(1).search(valuesss, true, false).draw(); // Kolom ke-8 (Branch)
        });



        var table2 = $('#tableDetailPayment').DataTable({
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

                var sumCol11Filtered16 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);


                $(api.column(9).footer()).html(
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
                title: 'REPORT DETAIL REVENUE BY SALES',
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

        $('#filterBranch2, #filterStaff2').select2({
            width: '200px'
        });

        $('#filterStaff2').on('change', function () {
            var valuessss = $(this).val().join('|');
            table2.column(2).search(valuessss, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterBranch2').on('change', function () {
            var valuessss = $(this).val().join('|');
            table2.column(1).search(valuessss, true, false).draw(); // Kolom ke-8 (Branch)
        });

    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableDetailPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>