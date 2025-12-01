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
                $period = date('Y-m');
                $periodVal = !empty($periodSearch) ? $periodSearch : $period;

                ?>
                <form id="form-cari-invoice">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Period</label>
                                <input type="month" name="periodSearch" class="form-control filter_period"
                                    value="<?= $periodVal ?>" required>
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
                            DETAIL CUSTOMER SPEND
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailNewMember">
                            DETAIL NEW MEMBER
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p>Loading data...</p>
                    </div>
                    <div class="row gx-4">
                        <div class="col-md-12 mt-3">
                            <div class="tab-pane" id="detailAffiliate">
                                <div class="card">
                                    <h3 id="reportTitle" class="card-header card-header-info"
                                        style="font-weight: bold; color: #666666;">
                                        REPORT CUSTOMER SPEND: <?= $periodVal ?>
                                    </h3>


                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableDailySales" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">LOCATIONNAME</th>
                                                        <th style="text-align: center;">CUSTOMERNAME</th>
                                                        <th style="text-align: center;">CELLPHONENUMBER</th>
                                                        <th style="text-align: center;">AMOUNT</th>
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
                                                <tbody id="report-bodycustomerspend">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane show active" id="summaryAffiliate">
                                <div class="card">
                                    <h3 id="reportTitleSum" class="card-header card-header-info"
                                        style="font-weight: bold; color: #666666;">
                                        REPORT SUMMARY REVENUE: <?= $periodVal ?>
                                    </h3>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableSummary" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">LOCATIONNAME</th>
                                                        <th style="text-align: center;">TOTAL CUSTOMER SPEND</th>
                                                        <th style="text-align: center;">TOTAL NEW MEMBER</th>
                                                        <th style="text-align: center;">AMOUNT</th>
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
                                                <tbody id="report-bodysummary">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="detailNewMember">
                                <div class="card">
                                    <h3 id="reportTitleNew" class="card-header card-header-info"
                                        style="font-weight: bold; color: #666666;">
                                        REPORT NEW MEMBER: <?= $periodVal ?>
                                    </h3>


                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableNewMember" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">LOCATIONNAME</th>
                                                        <th style="text-align: center;">CUSTOMERNAME</th>
                                                        <th style="text-align: center;">CELLPHONENUMBER</th>
                                                        <th style="text-align: center;">AMOUNT</th>
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
                                                <tbody id="report-bodynewmember">
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
            destroy: true,
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        const tableSum = $('#tableSummary').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        const tableNewMember = $('#tableNewMember').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
            dom: 'Bfrtip',
            buttons: ['excel']
        });



        function fetchData() {
            const formData = $('#form-cari-invoice').serialize();

            const periodVal = formData.split("=")[1]; // hasil: "2025-08"

            // Update teks di <h3>
            document.getElementById("reportTitle").innerText = "REPORT CUSTOMER SPEND: " + periodVal;
document.getElementById("reportTitleSum").innerText = "REPORT SUMMARY REVENUE: " + periodVal;
document.getElementById("reportTitleNew").innerText = "REPORT NEW MEMBER: " + periodVal;

            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('ControllerReport/handleReportRevenueByCustomer') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rowscustomerspend = res.dataCustomerSpend || [];
                    const rowssummary = res.dataSummary || [];
                    const rowsnewmbemer = res.dataNewMember || [];

                    const dataCustomerSpendFormatted = [];
                    const dataFormattedSummary = [];
                    const dataNewMember = [];

                    let total = 0;


                    rowscustomerspend.forEach((row, i) => {

                        const amount = parseFloat(row.TOTAL || 0);
                        total += amount;

                        dataCustomerSpendFormatted.push([
                            i + 1,
                            row.LOCATIONNAME || '',
                            row.CUSTOMERNAME || '',
                            row.CELLPHONENUMBER || '',
                            amount.toLocaleString() || ''
                        ]);
                    });

                    // Masukkan data ke DataTable
                    table.clear().rows.add(dataCustomerSpendFormatted).draw();

                    // Update total di footer
                    $(table.column(4).footer()).html(total.toLocaleString());


                    let totalFronNewMember = 0;

                    rowsnewmbemer.forEach((row, i) => {
                        const amount = parseFloat(row.TOTAL || 0);
                        totalFronNewMember += amount;

                        dataNewMember.push([
                            i + 1,
                            row.LOCATIONNAME || '',
                            row.CUSTOMERNAME || '',
                            row.CELLPHONENUMBER || '',
                            amount.toLocaleString() || ''
                        ]);
                    });

                    // Masukkan data ke DataTable
                    tableNewMember.clear().rows.add(dataNewMember).draw();

                    // Update total di footer
                    $(tableNewMember.column(4).footer()).html(totalFronNewMember.toLocaleString());

                    let totalFromSummary = 0;
                    let totalNewMember = 0;
                    let totalCustomerExpend = 0;

                    rowssummary.forEach((row, i) => {
                        const amount = parseFloat(row.TOTALSPEND || 0);
                        totalFromSummary += amount;

                        const newmember = parseFloat(row.TOTALNEWMEMBER || 0);
                        totalNewMember += newmember;

                        const customerspend = parseFloat(row.TOTALCUSTOMERSPEND || 0);
                        totalCustomerExpend += customerspend;

                        dataFormattedSummary.push([
                            i + 1,
                            row.LOCATIONNAME || '',
                            row.TOTALCUSTOMERSPEND || '',
                            row.TOTALNEWMEMBER || '',
                            amount.toLocaleString() || ''
                        ]);
                    });

                    // Masukkan data ke DataTable
                    tableSum.clear().rows.add(dataFormattedSummary).draw();

                    // Update total di footer
                    $(tableSum.column(2).footer()).html(totalCustomerExpend.toLocaleString());
                    $(tableSum.column(3).footer()).html(totalNewMember.toLocaleString());
                    $(tableSum.column(4).footer()).html(totalFromSummary.toLocaleString());


                },
                error: function () {
                    $('#report-bodycustomerspend').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                    $('#report-bodysummary').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                    $('#report-bodynewmember').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                },
                complete: function () {
                    $('#loadingIndicator').hide();
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