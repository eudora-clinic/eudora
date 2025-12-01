<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Hand Work Dokter</title>

    <style>
        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 10px 0;
        }

        .filter-container select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }

        /* Agar select dropdown memiliki padding lebih baik */
        .filter-container select:focus {
            outline: none;
            border-color: #007bff;
        }

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
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="post"
                        action="<?= base_url('reportFilledLinkReview') ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="date" name="dateStart" class="form-control filter_period"
                                        value="<?= $dateStart ?>" required>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Date End</label>
                                    <input type="date" name="dateEnd" class="form-control filter_period"
                                        value="<?= $dateEnd ?>" required>
                                </div>
                            </div>

                            <div class="col-md-4">
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
                        <a class="nav-link active" data-toggle="tab" href="#hwTherapist">SUMMARY REVIEW</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailCustomerNotFill">DETAIL CUSTOMER NOT REVIEW</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailCustomerFill">DETAIL CUSTOMER REVIEW</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailCustomerFillByDate">DETAIL CUSTOMER REVIEW BY DATE</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="hwTherapist">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    SUMMARY REVIEW: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableHwTherapist" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">EMPLOYEENAME</th>
                                                    <th style="text-align: center;">TOTALCUSTOMER</th>
                                                    <th style="text-align: center;">TOTALCUSTOMER REVIEW</th>
                                                    <th style="text-align: center;">TOTALCUSTOMER NOT REVIEW</th>
                                                    <th style="text-align: center;">TOTALCUSTOMER REVIEW BY DATE</th>
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
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($summaryReview as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TOTALCUSTOMER'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TOTALCUSTOMERFILLEDLINK'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TOTALCUSTOMERNOTFILLEDLINK'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TOTALCUSTOMERFILLEDBYDATE'] ?></td>  
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane" id="detailCustomerNotFill">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    DETAIL CUSTOMER NOT REVIEW DOING: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="detailCustomerNotFillTable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CLINIC</th>
                                                    <th style="text-align: center;">CUSTOMERNAME</th>
                                                    <th style="text-align: center;">TREATMENTDATE</th>
                                                    <th style="text-align: center;">EMPLOYEENAME</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($detailCustomerNotFill as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FULLNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENTDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane" id="detailCustomerFill">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    DETAIL CUSTOMER REVIEW BY DOING: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="detailCustomerFillTable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CLINIC</th>
                                                    <th style="text-align: center;">CUSTOMERNAME</th>
                                                    <th style="text-align: center;">TREATMENTDATE</th>
                                                    <th style="text-align: center;">EMPLOYEENAME</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($detailCustomerFill as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FULLNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENTDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="detailCustomerFillByDate">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    DETAIL CUSTOMER REVIEW BY DATE: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="detailCustomerFillByDateTable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CUSTOMERNAME</th>
                                                    <th style="text-align: center;">CELLPHONENUMBER</th>
                                                    <th style="text-align: center;">GOOGLENAME</th>
                                                    <th style="text-align: center;">LINK REVIEW</th>
                                                    <th style="text-align: center;">REVIEW DATE</th>
                                                    <th style="text-align: center;">EMPLOYEENAME</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($detailCustomerFillByDate as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?></td>
                                                        <td style="text-align: center;"><?= $row['GOOGLENAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['LINKREVIEW'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CREATEDATELINK'] ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
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
        $('#tableHwTherapist').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
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


                var sumCol11Filtered2 = display.map(el => data[el][2]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered3 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered4 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered5 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(2).footer()).html(
                    numberFormat(sumCol11Filtered2,)
                );

                $(api.column(3).footer()).html(
                    numberFormat(sumCol11Filtered3,)
                );

                $(api.column(4).footer()).html(
                    numberFormat(sumCol11Filtered4,)
                );

                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered5,)
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
            buttons: ['excel']
        });

         $('#detailCustomerNotFillTable').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
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
            buttons: ['excel']
        });

         $('#detailCustomerFillTable').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
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
            buttons: ['excel']
        });

         $('#detailCustomerFillByDateTable').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
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
            buttons: ['excel']
        });


    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>