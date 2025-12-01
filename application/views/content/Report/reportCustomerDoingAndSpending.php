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
                <?php
                $today = date('Y-m-d');               // tanggal hari ini
                $firstOfMonth = date('Y-m-01');       // tanggal 1 di bulan ini
                $dateStartVal = !empty($dateStart) ? $dateStart : $firstOfMonth;
                $dateEndVal = !empty($dateEnd) ? $dateEnd : $today;
                ?>
                <form id="form-cari-invoice">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                <input type="date" name="dateStart" class="form-control filter_period"
                                    value="<?= $dateStartVal ?>" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date End</label>
                                <input type="date" name="dateEnd" class="form-control filter_period"
                                    value="<?= $dateEndVal ?>" required>
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
                                    SUMMARY CUSTOMER DOING : <?= $dateStartVal ?> - <?= $dateEndVal ?>
                                </h3>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p>Loading data...</p>
                                        </div>
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th rowspan="2" style="text-align: center;">NO</th>
                                                    <th rowspan="2" style="text-align: center;">LOCATION</th>
                                                    <th colspan="4" style="text-align: center;">CUSTOMER DOING</th>
                                                    <th colspan="3" style="text-align: center;">CUSTOMER DOING
                                                        TRANSACTION
                                                    </th>
                                                    <th colspan="2" style="text-align: center;">CUSTOMER DOING NO
                                                        TRANSACTION
                                                    </th>
                                                    <th rowspan="2" style="text-align: center;">% DOING VS TRANSACTION
                                                    </th>
                                                    <th rowspan="2" style="text-align: center;">AMOUNT TRANSACTION</th>
                                                </tr>
                                                <tr>
                                                    <!-- CUSTOMER DOING -->
                                                    <th style="text-align: center;">TOTAL</th>
                                                    <th style="text-align: center;">NEW CUSTOMER</th>
                                                    <th style="text-align: center;">NEW MEMBER</th>
                                                    <th style="text-align: center;">CUSTOMER EXISTING</th>

                                                    <!-- CUSTOMER TRANSACTION -->
                                                    <th style="text-align: center;">TOTAL</th>
                                                    <th style="text-align: center;">NEW MEMBER</th>
                                                    <th style="text-align: center;">CUSTOMER EXISTING</th>

                                                    <!-- CUSTOMER NO TRANSACTION -->
                                                    <th style="text-align: center;">TOTAL</th>
                                                    <th style="text-align: center;">CUSTOMER EXISTING</th>
                                                </tr>
                                            </thead>

                                            <tbody id="report-body-summary">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="detail">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    DETAIL CUSTOMER DOING : <?= $dateStartVal ?> - <?= $dateEndVal ?>
                                    </h4>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableDetailPayment" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">LOCATION</th>
                                                        <th style="text-align: center;">CUSTOMER</th>
                                                        <th style="text-align: center;">CELLPHONENUMBER</th>
                                                        <th style="text-align: center;">TYPE</th>
                                                        <th style="text-align: center;">AMOUNT</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="report-body-detail">
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
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            destroy: true,
            dom: 'Bfrtip',
            buttons: [
                'excel',
                {
                    extend: 'pdfHtml5',
                    text: 'Export PDF',
                    title: 'Daily Sales Report',
                    pageSize: 'A4',
                    orientation: 'landscape',
                    exportOptions: { columns: ':visible' },
                    customize: function (doc) {
                        const tableNode = doc.content.find(c => c.table);
                        if (tableNode) {
                            tableNode.table.widths = Array(13).fill('*'); // 12 kolom auto-width

                            const headerBg = '#f5e0d8'; // warna background header
                            

                            // Header rows
                            const headerRows = [
                                [
                                    { text: 'NO', rowSpan: 2, alignment: 'center', bold: true, fillColor: headerBg },
                                    { text: 'LOCATION', rowSpan: 2, alignment: 'center', bold: true, fillColor: headerBg },
                                    { text: 'CUSTOMER DOING', colSpan: 4, alignment: 'center', bold: true, fillColor: headerBg }, {}, {}, {},
                                    { text: 'CUSTOMER DOING TRANSACTION', colSpan: 3, alignment: 'center', bold: true, fillColor: headerBg }, {}, {},
                                    { text: 'CUSTOMER DOING NO TRANSACTION', colSpan: 2, alignment: 'center', bold: true, fillColor: headerBg }, {},
                                    { text: 'AMOUNT TRANSACTION', rowSpan: 2, alignment: 'center', bold: true, fillColor: headerBg },
                                    { text: '% DOING VS TRANSACTION', rowSpan: 2, alignment: 'center', bold: true, fillColor: headerBg }
                                ],
                                [
                                    // Baris kedua: total harus 12 cell!
                                    { text: '', fillColor: headerBg }, // untuk AMOUNT TRANSACTION
                                    { text: '', fillColor: headerBg }, // tambahkan 1 cell kosong supaya total 12
                                    { text: 'TOTAL', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'NEW CUSTOMER', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'NEW MEMBER', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'CUSTOMER EXISTING', alignment: 'center', bold: true, fillColor: headerBg , valign: 'middle'},
                                    { text: 'TOTAL', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'NEW MEMBER', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'CUSTOMER EXISTING', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'TOTAL', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: 'CUSTOMER EXISTING', alignment: 'center', bold: true, fillColor: headerBg, valign: 'middle' },
                                    { text: '', fillColor: headerBg },
                                    { text: '', fillColor: headerBg }   // tambahkan 1 cell kosong supaya total 12
                                ]
                            ];


                            // replace header bawaan DataTables
                            tableNode.table.body.splice(0, 1, ...headerRows);

                            // Tambahkan border untuk semua sel
                            doc.content.forEach(function (c) {
                                if (c.table) {
                                    c.layout = {
                                        hLineWidth: function () { return 0.5; },
                                        vLineWidth: function () { return 0.5; },
                                        hLineColor: function () { return '#999'; },
                                        vLineColor: function () { return '#999'; },
                                        paddingLeft: function () { return 2; },
                                        paddingRight: function () { return 2; },
                                        paddingTop: function () { return 3; },
                                        paddingBottom: function () { return 3; }
                                    };
                                }
                            });
                        }

                        doc.styles.tableHeader.fontSize = 9;
                        doc.defaultStyle.fontSize = 8;
                    }

                }

            ]
        });

        const table2 = $('#tableDetailPayment').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            destroy: true,
            dom: 'Bfrtip',
            buttons: ['excel']
        });


        function fetchData() {
            const formData = $('#form-cari-invoice').serialize();
            $('#loadingIndicator').show();
            $('#report-body-summary').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('ControllerReport/getReportCustomerDoingAndSpending') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rows = res.data || [];
                    const dataFormatted = [];
                    const formData = $('#form-cari-invoice').serializeArray();
                    const start = formData.find(item => item.name === 'dateStart')?.value;
                    const end = formData.find(item => item.name === 'dateEnd')?.value;
                    function formatDate(dateStr) {
                        const options = { month: 'short', year: 'numeric' };
                        return new Date(dateStr).toLocaleDateString('en-GB', options);
                    }

                    $('#reportTitle').text(`REPORT EXPEND COST: ${formatDate(start)} - ${formatDate(end)}`);
                    rows.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.LOCATIONNAME || '',
                            row.TOTALCUSTOMER || 0,
                            row.TOTALNEWCUSTOMER || 0,
                            row.TOTALNEWMEMBER || 0,
                            row.TOTALCUSTOMEREXISTING || 0,
                            row.TOTALCUSTOMERTRANSAKSI || 0,
                            row.TOTALNEWMEMBER || 0,
                            row.TOTALCUSTOMERTRANSAKSIEXISTING || 0,
                            row.TOTALCUSTOMERNOTRANSAKSI || 0,
                            row.TOTALCUSTOMERNOTRANSAKSIEXISTING || 0,
                            row.TOTALCUSTOMER
                            ? parseFloat(((row.TOTALCUSTOMERTRANSAKSI / row.TOTALCUSTOMER) * 100).toFixed(2))
                            : 0,
                        numberFormat(row.AMOUNTTRANSAKSI) || 0
                        ]);
                });
            table.clear().rows.add(dataFormatted).draw();


            const rows_detail = res.data_detail || [];
            const dataFormattedDetail = [];

            rows_detail.forEach((row, i) => {
                dataFormattedDetail.push([
                    i + 1,
                    row.LOCATIONNAME || '',
                    row.CUSTOMERNAME || '',
                    row.CELLPHONENUMBER || '',
                    row.TYPE || '',
                    numberFormat(row.AMOUNT) || ''
                ]);
            });
            table2.clear().rows.add(dataFormattedDetail).draw();

        },
        error: function () {
            $('#report-body-summary').html(`
                        <tr><td colspan="12" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
        },
        complete: function () {
            $('#loadingIndicator').hide();
        }
    });
        }
    fetchData();
    $('#form-cari-invoice').on('submit', function (e) {
        e.preventDefault();
        fetchData();
    });

    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableDetailPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>