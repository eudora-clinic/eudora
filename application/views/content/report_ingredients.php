<?php
error_reporting(0);
ini_set('display_errors', 0);
$db_oriskin = $this->load->database('oriskin', true);
$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m-d'));
$userid = $this->session->userdata('userid');

$level = $this->session->userdata('level');

$query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
$locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

$locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

$dateSearch = (isset($_GET['dateSearch']) ? $this->input->get('dateSearch') : date('Y-m-d'));

$locationId = (isset($_GET['locationId']) ? $this->input->get('locationId') : $locationList[0]['id']);

$report_ingredients = $db_oriskin->query("EXEC [spEudoraReportUsingIngredients] '" . $locationId . "', '" . $dateend . "', 1  ")->result_array();

?>

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

    input[type="text"],
    input[type="date"],
    input[type="number"],
    select {
        width: 100%;
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 5px;
        transition: all 0.3s;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    input[type="number"]:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
    }
</style>

<?php
$level = $this->session->userdata('level');
?>

<div class="mycontaine" style="font-weight:900;">
    <div class="card p-2 col-md-6">
        <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
            <div class="row g-3" style="display: flex; align-items: center;">
                <!-- <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Date Start</label>
                        <input type="date" name="datestart" class="form-control filter_period" value="<?= $datestart ?>" required>
                    </div>
                </div> -->
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Stock Balance Per</label>
                        <input type="date" name="dateend" class="form-control filter_period" value="<?= $dateend ?>"
                            required>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="">
                        <select id="locationId" name="locationId" class="form-control text-uppercase" required="true"
                            aria-required="true">
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
                            class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i> Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="">
        <div class="row gx-4">
            <div class="col-md-12 mt-3">
                <div>
                    <div class="card">
                        <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                            STOCK BALANCE PER: <?= $dateend ?>
                        </h3>
                        <div class="table-wrapper p-4">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered" style="width:100%">
                                    <thead class="bg-thead">
                                        <tr role="">
                                            <th class="text-center">Code</th>
                                            <th class="text-center">Ingredients</th>
                                            <th class="text-center">Unit</th>
                                            <th class="text-center">Stock In</th>
                                            <th class="text-center">Stock Out</th>
                                            <th class="text-center">Stock Used</th>
                                            <th class="text-center">Adjustment In</th>
                                            <th class="text-center">Adjustment Out</th>
                                            <th class="text-center">Current Stock</th>
                                            <?php if ($level == 4) { ?>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Amount</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <?php
                                            // Tentukan jumlah kolom (th) berdasarkan level
                                            if ($level == 4) {
                                                $thCount = 11;
                                            } elseif ($level == 8) {
                                                $thCount = 9;
                                            } else {
                                                $thCount = 9;
                                            }

                                            for ($i = 0; $i < $thCount; $i++) {
                                                echo '<th style="text-align: right"></th>';
                                            }
                                            ?>
                                        </tr>
                                    </tfoot>


                                    <tbody>
                                        <?php foreach ($report_ingredients as $row) {
                                            ?>
                                            <tr role="">
                                                <td style="text-align: center;width:150px"><?= $row['CODE'] ?></td>
                                                <td style="text-align: center;width:150px"><?= $row['INGREDIENTS'] ?></td>
                                                <td style="text-align: center;width:110px"><?= $row['UNIT'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['STOCKIN'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['STOCKOUT'] ?></td>
                                                <td style="text-align: center;width:100px">
                                                    <?= number_format($row['USEQTY']) ?>
                                                </td>
                                                <td style="text-align: center;width:100px"><?= $row['ADJUSTMENTIN'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['ADJUSTMENTOUT'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['CURRENT_STOCK'] ?></td>
                                                <?php if ($level == 4) { ?>
                                                    <td style="text-align: center;width:100px"><?= $row['UNITPRICE'] ?></td>
                                                    <td style="text-align: center;width:100px"><?= $row['AMOUNT'] ?></td>

                                                <?php } ?>
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
        // untuk judul
        var datestart = '<?= $datestart ?>';
        var dateend = '<?= $dateend ?>';
        var datestart_split = datestart.split('-');
        var dateend_split = dateend.split('-');
        var datestart_indo = datestart_split[2] + '-' + datestart_split[1] + '-' + datestart_split[0];
        var dateend_indo = dateend_split[2] + '-' + dateend_split[1] + '-' + dateend_split[0];

        $('#example').DataTable({
            paging: true,
            pageLength: 10,
            ordering: true,
            select: true,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api();

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                // Kolom dasar (selalu ada)
                var sum3 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sum4 = display.map(el => data[el][4]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sum5 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sum6 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sum7 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sum8 = display.map(el => data[el][8]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(3).footer()).html(numberFormat(sum3));
                $(api.column(4).footer()).html(numberFormat(sum4));
                $(api.column(5).footer()).html(numberFormat(sum5));
                $(api.column(6).footer()).html(numberFormat(sum6));
                $(api.column(7).footer()).html(numberFormat(sum7));
                $(api.column(8).footer()).html(numberFormat(sum8));

                // Kolom tambahan hanya untuk level 4 (Unit Price + Amount)
                if (api.columns().count() > 9) {
                    var sum9 = display.map(el => data[el][9]).reduce((a, b) => intVal(a) + intVal(b), 0);
                    var sum10 = display.map(el => data[el][10]).reduce((a, b) => intVal(a) + intVal(b), 0);

                    $(api.column(9).footer()).html(numberFormat(sum9));
                    $(api.column(10).footer()).html(numberFormat(sum10));
                }
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
                title: 'Stock Ingredients \n Period: ' + datestart_indo + ' - ' + dateend_indo,
                className: 'btn-danger',
                orientation: 'potrait',
                pageSize: 'LEGAL',
                footer: true
            }, 'excel']
        });
    });

</script>