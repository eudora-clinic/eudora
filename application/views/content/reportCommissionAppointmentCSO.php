<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Appointment CSO</title>

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
        "IM_CSO.pdf",
        "IM_TERAPIS.pdf"
    ];

    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <?php if ($level != 1) { ?>
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="post" action="<?= base_url('reportCommissionAppointmentCSO') ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PERIOD</label>
                                    <input type="month" name="period" class="form-control filter_period" value="<?= $period ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="locationIdSearch" name="locationIdSearch" class="form-control text-uppercase " required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationIdSearch == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <?php if ($level == 1) { ?>
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="post" action="<?= base_url('reportCommissionAppointmentCSO') ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PERIOD</label>
                                    <input type="month" name="period" class="form-control filter_period" value="<?= $period ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div class="" id="hwDokter">
                        <div class="card">
                            <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                REPORT COMMISSION CSO FROM DOING THERAPIST: <?= $period ?>
                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="text-align: center;">NO</th>
                                                <th style="text-align: center;">CLINIC</th>
                                                <th style="text-align: center;">THERAPIST</th>
                                                <th style="text-align: center;">TARGET CSO</th>
                                                <th style="text-align: center;">TOTAL DOING</th>
                                                <th style="text-align: center;">PERCENTAGE</th>
                                                <th style="text-align: center;">COMMISSION CSO</th>
                                                <th style="text-align: center;">TARGET BTC</th>
                                                <th style="text-align: center;">PERCENTAGE BTC</th>
                                                <th style="text-align: center;">COMMISSION BTC</th>
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
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($listCommissionAppointmentCso as $row) {
                                            ?>
                                                <tr role="" style="font-weight: 400;">
                                                    <td style="text-align: center;"><?= $no++ ?></td>
                                                    <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                    <td style="text-align: center;"><?= $row['EMPLOYEENAME'] ?></td>
                                                    <td style="text-align: center;"><?= $row['TARGET'] ?></td>
                                                    <td style="text-align: center;"><?= $row['TOTALDOING'] ?></td>
                                                    <td style="text-align: center;"><?= $row['PERCENTAGE'] ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['COMMISSION'], 0, ',', ',') ?></td>
                                                    <td style="text-align: center;"><?= $row['TARGETBTC'] ?></td>
                                                    <td style="text-align: center;"><?= $row['PERCENTAGEBTC'] ?></td>
                                                    <td style="text-align: right;"><?= number_format($row['COMMISSIONBTC'], 0, ',', ',') ?></td>
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
            "lengthMenu": [5, 10, 15, 20, 25, 100],
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

                var sumCol11Filtered3 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered4 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var sumCol11Filtered8 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered9 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);

                var percentage = (sumCol11Filtered4 / sumCol11Filtered3 ) * 100

                $(api.column(3).footer()).html(
                    numberFormat(sumCol11Filtered3, )
                );

                $(api.column(4).footer()).html(
                    numberFormat(sumCol11Filtered4, )
                );

                $(api.column(5).footer()).html(
                    numberFormat(percentage, )
                );

                $(api.column(6).footer()).html(
                    numberFormat(sumCol11Filtered8, )
                );

                $(api.column(9).footer()).html(
                    numberFormat(sumCol11Filtered9, )
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
            buttons: ['excel']
        });

    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>