<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Summary Revenue Per Day</title>

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
    $locationId = (isset($_GET['locationId']) ? $this->input->get('locationId') :  $locationIdFromUserdata);

    $dateSearch = (isset($_GET['dateSearch']) ? $this->input->get('dateSearch') : date('Y-m '));

    $dailySalesReport = $db_oriskin->query("Exec spClinicSummaryRevenuePerDay '" . $dateSearch . "', '" . $locationId . "' ")->result_array();

    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <?php if ($level != 4 && $level != 3 && $level != 8 && $level != 9) { ?>
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3" style="display: flex; align-items: center;">
                            <div class="col-md-9 form-group pl-4">
                                <div class="form-group bmd-form-group">
                                    <label>PERIOD</label>
                                    <input type="month" class="form-control text-uppercase" name="dateSearch" id="dateSearch" value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn w-100 btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>


            <?php if ($level == 4 || $level == 3 || $level == 8 || $level == 9) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>PERIOD</label>
                                    <input type="month" class="form-control text-uppercase" name="dateSearch" id="dateSearch" value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <!-- <label class="form-label mt-2">Location</label> -->
                                    <select id="locationId" name="locationId" class="form-control text-uppercase " required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                     <button type="submit" class="btn btn-sm top-responsive btn-primary">Search</button>
                                </div>
                               
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
            <div>
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">

                        <div class="card">
                            <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                SUMMARY REVENUE: <?= $dateSearch ?>
                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="text-align: center;">DAY</th>
                                                <th style="text-align: center;">PRODUCT</th>
                                                <th style="text-align: center;">MEMBERSHIP</th>
                                                <th style="text-align: center;">TREATMENT</th>
                                                <th style="text-align: center;">TOTAL</th>
                                                <th style="text-align: center;">DP</th>
                                                <th style="text-align: center;">FREEZE</th>
                                                <th style="text-align: center;">CANCEL</th>

                                                <th style="text-align: center;">AUTOPAY</th>
                                                <th style="text-align: center;">MANUAL PAYMENT</th>
                                                <th style="text-align: center;">PROMO EXCLUDED</th>

                                                <th style="text-align: center;">TOTAL OTHER</th>
                                                <th style="text-align: center;">GRAND TOTAL</th>
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
                                            foreach ($dailySalesReport as $row) {
                                            ?>
                                                <tr role="" style="font-weight: 400;">
                                                    <td style="text-align: center;"><?= $row['DAYINV'] ?></td>

                                                    <td style="text-align: right;"><?= number_format($row['PRODUK'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['MEMBERSHIP'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['TREATMENT'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['TOTAL'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['DP'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['FREEZE'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['CANCEL'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['AUTOPAY'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['MANUALPAYMENT'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['PROMOEXCLUDEFROMREVENUE'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['TOTALOTHERS'], 0, '.', ',') ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['GRANDTOTAL'], 0, '.', ',') ?></td>

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
</body>
<script>
    var numberFormat = function(number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
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

    $(document).ready(function() {
        $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function(i) {
                    return typeof i === 'string' ? i.replace(
                            /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered1 = display.map(el => data[el][1]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered2 = display.map(el => data[el][2]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered3 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered4 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered5 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered6 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered7 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered8 = display.map(el => data[el][8]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered9 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered10 = display.map(el => data[el][10]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered11 = display.map(el => data[el][11]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered12 = display.map(el => data[el][12]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(1).footer()).html(
                    numberFormat(sumCol11Filtered1, )
                );
                $(api.column(2).footer()).html(
                    numberFormat(sumCol11Filtered2, )
                );

                $(api.column(3).footer()).html(
                    numberFormat(sumCol11Filtered3, 0)
                );
                $(api.column(4).footer()).html(
                    numberFormat(sumCol11Filtered4, 0)
                );

                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered5, )
                );
                $(api.column(6).footer()).html(
                    numberFormat(sumCol11Filtered6, )
                );

                $(api.column(7).footer()).html(
                    numberFormat(sumCol11Filtered7, 0)
                );
                $(api.column(8).footer()).html(
                    numberFormat(sumCol11Filtered8, 0)
                );

                $(api.column(9).footer()).html(
                    numberFormat(sumCol11Filtered9, )
                );
                $(api.column(10).footer()).html(
                    numberFormat(sumCol11Filtered10, )
                );

                $(api.column(11).footer()).html(
                    numberFormat(sumCol11Filtered11, 0)
                );
                $(api.column(12).footer()).html(
                    numberFormat(sumCol11Filtered12, 0)
                );

            },
            "drawCallback": function(settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Revenue Daily',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                // exportOptions: {
                //     columns: [0, 1, 2, 3, 4]
                // },
                customize: function(doc) {

                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function(row, index) {
                        if (index > 0 && row[0].text !== '') {
                            row[0].text = rowCount;
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;

                    doc.content[1].layout = {
                        hLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                }
            }, 'excel']
        });


    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>