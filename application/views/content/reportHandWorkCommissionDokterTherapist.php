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
    <?php
    $level = $this->session->userdata('level');

    $file_list = [
        "IM_HWTERAPIS.pdf",
        "IM_HWDOKTER.pdf",
        "IM_HWDOKTER_RAHMA.pdf"
    ];
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <?php if ($level == 1) { ?>
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="post"
                        action="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">
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
            <?php } ?>

            <?php if ($level != 1) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="post"
                        action="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="date" name="dateStart" class="form-control filter_period"
                                        value="<?= $dateStart ?>" required>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date End</label>
                                    <input type="date" name="dateEnd" class="form-control filter_period"
                                        value="<?= $dateEnd ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
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

                            <div class="col-md-3 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" name="submit"
                                        class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <div>
                <ul class="nav nav-tabs active mt-3">

                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#hwTherapist">SUMMARY</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#hwDokter">DETAIL</a>
                    </li>


                </ul>
            </div>

            <div class="tab-content">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane" id="hwDokter">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    DETAIL HAND WORK DOKTER DAN THERAPIST: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="row p-4 filter-container">
                                    <label for="filterSection">SECTION:</label>
                                    <select id="filterSection">
                                        <option value="">ALL</option>
                                        <option value="DOKTER">DOKTER</option>
                                        <option value="BEAUTY THERAPIST">BEAUTY THERAPIST</option>
                                    </select>


                                    <label for="filterStaff">STAFF:</label>
                                    <select id="filterStaff" multiple="multiple">
                                        <option value="">ALL</option>
                                        <?php foreach ($staffEmployee as $staff) { ?>
                                            <option value="<?= htmlspecialchars($staff['name']) ?>">
                                                <?= htmlspecialchars($staff['name']) ?>
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
                                                    <th style="text-align: center;">CLINIC</th>
                                                    <th style="text-align: center;">CUSTOMERNAME</th>
                                                    <th style="text-align: center;">TREATMENTDATE</th>
                                                    <th style="text-align: center;">INVOICENO</th>
                                                    <th style="text-align: center;">DOINGBY</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">ASSIST BY</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">QTY</th>
                                                    <th style="text-align: center;">NETTPRICE</th>
                                                    <th style="text-align: center;">MARKETING COMMISSION</th>
                                                    <th style="text-align: center;">RATE</th>
                                                    <th style="text-align: center;">COMMISSION DOING</th>
                                                    <th style="text-align: center;">COMMISSION ASSIST</th>
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
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listHandWorkDokterTherapist as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENTDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                        <td style="text-align: center;"><?= $row['DOINGBYNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['JOB'] ?></td>
                                                        <td style="text-align: center;"><?= $row['ASSISTBYNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENT'] ?></td>
                                                        <td style="text-align: center;"><?= $row['QTY'] ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['NETTPRICE'], 0, ',', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $row['MARKETINGCOOMISIOM'] ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $row['RATE'] ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['COMMISION'], 0, ',', ',') ?>
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['COMMISSIONASSIST'], 0, ',', ',') ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane show active" id="hwTherapist">
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    REPORT SUMMARY HAND WORK: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableHwTherapist" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CLINIC</th>
                                                    <th style="text-align: center;">EMPLOYEENAME</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">COMMISSION</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
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
                                                foreach ($summaryHandWork as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['JOB'] ?></td>
                                                        <td style="text-align: right;">
                                                            <?= number_format($row['COMMISSION'], 0, ',', ',') ?>
                                                        </td>
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

            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                style="font-weight: bold; color: #666666;">
                LAMPIRAN INTERNAL MEMO HW DOKTER AND TERAPIS

                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMemo"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Lihat Lampiran
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMemo">
                        <?php foreach ($file_list as $file): ?>
                            <a class="dropdown-item" href="<?= base_url('uploads/memo/' . $file) ?>" target="_blank">
                                <?= $file ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </h3>
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

                var sumCol11Filtered7 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered8 = display.map(el => data[el][10]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered11 = display.map(el => data[el][13]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered13 = display.map(el => data[el][14]).reduce((a, b) => intVal(a) + intVal(b), 0);




                $(api.column(9).footer()).html(
                    numberFormat(sumCol11Filtered7,)
                );

                $(api.column(10).footer()).html(
                    numberFormat(sumCol11Filtered8,)
                );

                $(api.column(13).footer()).html(
                    numberFormat(sumCol11Filtered11,)
                );

                $(api.column(14).footer()).html(
                    numberFormat(sumCol11Filtered13,)
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
                title: 'REPORT HAND WORK DOKTER',
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

                var sumCol11Filtered8 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);


                $(api.column(4).footer()).html(
                    numberFormat(sumCol11Filtered8,)
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
                title: 'REPORT HAND WORK THERAPIST',
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


        $('#filterSection').on('change', function () {
            table.column(6).search(this.value).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterStaff').select2({
            width: '200px' // Sesuaikan ukuran dropdown
        });

        $('#filterStaff').on('change', function () {
            var valuesss = $(this).val().join('|');
            table.column(5).search(valuesss, true, false).draw(); // Kolom ke-8 (Branch)
        });
    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>