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

<body>
    <div>
        <div class="mycontaine">
            <div class="card p-2 col-md-9">
                <form id="form-cari-invoice" method="post" action="<?= base_url('reportUsedIngridients') ?>">
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
            <div class="">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div>
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    STOCK USED BY PREPAID: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="row p-4 filter-container">
                                    <label for="filterBranch">Branch:</label>
                                    <select id="filterBranch" multiple="multiple">
                                        <option value="">All</option>
                                        <?php foreach ($location_list as $location) { ?>
                                            <option value="<?= htmlspecialchars($location['name']) ?>">
                                                <?= htmlspecialchars($location['name']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <label for="filterPromotion">Treatment:</label>
                                    <select id="filterPromotion" multiple="multiple">
                                        <option value="">All</option>
                                        <?php foreach ($treatment as $adv) { ?>
                                            <option value="<?= htmlspecialchars($adv['TREATMENTNAME']) ?>">
                                                <?= htmlspecialchars($adv['TREATMENTNAME']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <label for="filterBarang">Barang:</label>
                                    <select id="filterBarang" multiple="multiple">
                                        <option value="">All</option>
                                        <?php foreach ($ingridients as $adv) { ?>
                                            <option value="<?= htmlspecialchars($adv['BARANG']) ?>">
                                                <?= htmlspecialchars($adv['BARANG']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr role="">
                                                    <th class="text-center">LOCATION</th>
                                                    <th class="text-center">TREATMENT CODE</th>
                                                    <th class="text-center">TREATMENT NAME</th>
                                                    <th class="text-center">CODE BARANG</th>
                                                    <th class="text-center">NAMA BARANG</th>
                                                    <th class="text-center">TOTALQTYPREPAID</th>
                                                    <th class="text-center">PEMAKAIAN PER TREATMENT</th>
                                                    <th class="text-center">TOTAL DIGUNAKAN</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php foreach ($reportUsedIngridients as $row) {
                                                    ?>
                                                    <tr role="">
                                                        <td style="text-align: center;width:150px">
                                                            <?= $row['LOCATIONNAME'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:150px">
                                                            <?= $row['TREATMENTCODE'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:110px">
                                                            <?= $row['TREATMENTNAME'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:100px"><?= $row['CODEBARANG'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:100px"><?= $row['BARANG'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:100px">
                                                            <?= $row['TOTALQTYPREPAID'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:100px">
                                                            <?= $row['TOTALQTYBARANGPERTREATMENT'] ?>
                                                        </td>

                                                        <td style="text-align: center;width:100px"><?= $row['QTYUSED'] ?>
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
        </div>
    </div>
</body>



<script>
    $(document).ready(function () {
        var datestart = '<?= $dateStart ?>';
        var dateend = '<?= $dateEnd ?>';
        var datestart_split = datestart.split('-');
        var dateend_split = dateend.split('-');
        var datestart_indo = datestart_split[2] + '-' + datestart_split[1] + '-' + datestart_split[0];
        var dateend_indo = dateend_split[2] + '-' + dateend_split[1] + '-' + dateend_split[0];

        var table = $('#example').DataTable({
            paging: true,
            pageLength: 10,
            "footerCallback": function (row, data, start, end, display) { },
            dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Stock Ingredients \n Period: ' + datestart_indo + ' - ' + dateend_indo,
                className: 'btn-danger',
                orientation: 'potrait',
                pageSize: 'LEGAL',
                footer: true
            }, 'excel'],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered12 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered13 = display.map(el => data[el][6]).reduce((a, b) => intVal(a) + intVal(b), 0);
                var sumCol11Filtered14 = display.map(el => data[el][7]).reduce((a, b) => intVal(a) + intVal(b), 0);


                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered12,)
                );
                $(api.column(6).footer()).html(
                    numberFormat(sumCol11Filtered13,)
                );
                $(api.column(7).footer()).html(
                    numberFormat(sumCol11Filtered14,)
                );


            }
        });

        function escapeRegex(text) {
            return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, '\\$&');
        }

        $('#filterPromotion, #filterBranch, #filterBarang').select2({
            width: '200px' // Sesuaikan ukuran dropdown
        });

        // Filter berdasarkan Cabang
        $('#filterBranch').on('change', function () {
            var valuesss = $(this).val().join('|');
            table.column(0).search(valuesss, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterPromotion').on('change', function () {
            var value = $(this).val().join('|');
            table.column(2).search(value, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterBarang').on('change', function () {
            var rawValues = $(this).val() || []; // jaga-jaga kalau kosong
            var escapedValues = rawValues.map(escapeRegex);
            var regexPattern = escapedValues.join('|'); // gabungkan pakai OR
            table.column(4).search(regexPattern, true, false).draw(); // kolom ke-5 (index 4)
        });

    });
</script>