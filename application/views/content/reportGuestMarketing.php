<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>

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
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#summaryAffiliate">
                            SUMMARY
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailAffiliate">
                            DETAIL
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="row gx-4">
                        <div class="col-md-12 mt-3">
                            <div class="tab-pane" id="detailAffiliate">
                                <div class="card">
                                    <h3 id="reportTitle" class="card-header card-header-info"
                                        style="font-weight: bold; color: #666666;">
                                        REPORT GUEST MARKETING:
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
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">DATEREGISTER</th>
                                                        <th style="text-align: center;">AFFILIATOR</th>
                                                        <th style="text-align: center;">CLINIC</th>
                                                        <th style="text-align: center;">PROMOTION</th>
                                                        <th style="text-align: center;">GUESTNAME</th>
                                                        <th style="text-align: center;">WA</th>
                                                        <th style="text-align: center;">APPTDATE</th>
                                                        <th style="text-align: center;">SHOWDATE</th>
                                                        <th style="text-align: center;">AMOUNT</th>
                                                        <th style="text-align: center;">COMMISSION</th>
                                                        <?php if ($level == 1): ?>
                                                            <th style="text-align: center;">REQ BOOK DATE</th>
                                                            <th style="text-align: center;">REQ BOOK TIME</th>
                                                            <th style="text-align: center;">ACT</th>
                                                        <?php endif; ?>
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
                                                        <?php if ($level == 1): ?>
                                                            <th style="text-align: right"></th>
                                                            <th style="text-align: right"></th>
                                                            <th style="text-align: right"></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="report-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane show active" id="summaryAffiliate">
                                <div class="card">
                                    <h3 id="reportTitle" class="card-header card-header-info"
                                        style="font-weight: bold; color: #666666;">
                                        REPORT GUEST MARKETING SUMMARY:
                                    </h3>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <div id="loadingIndicator2" style=" text-align:center; margin-top: 20px;">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                <p>Loading data...</p>
                                            </div>

                                            <table id="tableSummary" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">AFFILIATE</th>
                                                        <th style="text-align: center;">GUEST</th>
                                                        <th style="text-align: center;">GUEST APPT</th>
                                                        <th style="text-align: center;">GUEST SHOW</th>
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
                                                        <th style="text-align: right"></th>
                                                    </tr>
                                                </tfoot>
                                                <tbody id="report-bodysummary">
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

</script>

<script>
    $(document).ready(function () {
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true
        });

        const tableSum = $('#tableSummary').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true
        });

        function fetchData() {
            const formData = $('#form-cari-invoice').serialize();

            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $('#loadingIndicator2').show();
            $('#report-bodysummary').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('App/handleReportGuestMarketing') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rows = res.data || [];
                    const rowssummary = res.dataSummary || [];
                    const level = <?= json_encode($level) ?>;
                    const dataFormatted = [];
                    const dataFormattedSummary = [];

                    let total = 0;
                    let totalcommission = 0;

                    const formData = $('#form-cari-invoice').serializeArray();
                    const start = formData.find(item => item.name === 'dateStart')?.value;
                    const end = formData.find(item => item.name === 'dateEnd')?.value;

                    // Format tanggal (opsional)
                    function formatDate(dateStr) {
                        const options = { day: '2-digit', month: 'short', year: 'numeric' };
                        return new Date(dateStr).toLocaleDateString('en-GB', options);
                    }

                    $('#reportTitle').text(`REPORT GUEST MARKETING: ${formatDate(start)} - ${formatDate(end)}`);

                    rows.forEach((row, i) => {
                        const cellphonenumber = row.CELLPHONENUMBER?.replace(/\D/g, '') || '';
                        const newNumber = cellphonenumber.replace(/^0/, '62');
                        const amount = parseFloat(row.AMOUNT || 0);
                        total += amount;
                        const commission = parseFloat(row.COMMISSION || 0);
                        totalcommission += commission;

                        const act = level == 1
                            ? `
                            <a href="https://wa.me/${newNumber}" target="_blank">
                                    <i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i>
                                </a>`
                            : '';

                        const req = level == 1
                            ? row.DATEBOOKREQ
                            : '';

                        const reqtime = level == 1
                            ? row.TIMEBOOKREQ
                            : '';

                        dataFormatted.push([
                            i + 1,
                            row.DATEREGISTER || '',
                            row.ADMINNAME || '',
                            row.LOCATIONNAME || '',
                            row.PROMOTION || '',
                            row.GUESTNAME || '',
                            row.CELLPHONENUMBER || '',
                            row.APPTDATE || '',
                            row.SHOWDATE || '',
                            amount.toLocaleString(),
                            commission.toLocaleString(),
                            req,
                            reqtime,
                            act
                        ]);
                    });

                    // Masukkan data ke DataTable
                    table.clear().rows.add(dataFormatted).draw();

                    // Update total di footer
                    $(table.column(9).footer()).html(total.toLocaleString());
                    $(table.column(10).footer()).html(totalcommission.toLocaleString());


                    let totalguest = 0;
                    let totalappt = 0;
                    let totalshow = 0;
                    let totalcommissionsumaffiliate = 0;

                    console.log(rowssummary);
                    


                    rowssummary.forEach((row, i) => {
                        const guest = row.TOTALGUEST || 0;
                        totalguest += guest;
                        
                        const appt = row.TOTALAPPT || 0
                        totalappt += appt;

                        const show = row.TOTALSHOW || 0
                        totalshow += show;

                        const totalcommissionsum = parseFloat(row.TOTALCOMMISSION || 0);
                        totalcommissionsumaffiliate += totalcommissionsum;

                        dataFormattedSummary.push([
                            i + 1,
                            row.ADMINNAME || '',
                            guest,
                            appt,
                            show,
                            totalcommissionsum.toLocaleString(),
                        ]);
                    });

                    // Masukkan data ke DataTable

                    console.log(dataFormattedSummary);
                    
                    tableSum.clear().rows.add(dataFormattedSummary).draw();

                    // Update total di footer
                    $(tableSum.column(2).footer()).html(totalguest);
                    $(tableSum.column(3).footer()).html(totalappt);
                    $(tableSum.column(4).footer()).html(totalshow);
                    $(tableSum.column(5).footer()).html(totalcommissionsumaffiliate.toLocaleString());
                },
                error: function () {
                    $('#report-body').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);

                    $('#report-bodysummary').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                },
                complete: function () {
                    $('#loadingIndicator').hide();
                     $('#loadingIndicator2').hide();
                }
            });
        }

        // Trigger pertama kali saat page load
        fetchData();

        // Saat form di-submit
        $('#form-cari-invoice').on('submit', function (e) {
            e.preventDefault();
            fetchData();
        });
    });
</script>



</html>