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

        .subtotal-row {
            background-color: #f0f8ff;
            /* atau warna lain sesuai keinginan */
            font-weight: bold;
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
            <div class="card p-2 col-md-7">
                <?php
                $today = date('Y-m');
                $defaultLocation = $locationList[0]['id'];
                $dateEndVal = !empty($dateEnd) ? $dateEnd : $today;
                $firstLocation = !empty($locationId) ? $locationId : $defaultLocation;
                ?>
                <form id="form-cari-invoice">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Period</label>
                                <input type="month" name="dateEnd" class="form-control filter_period"
                                    value="<?= $dateEndVal ?>" required>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <select id="locationId" name="locationId" class="form-control text-uppercase "
                                    required="true" aria-required="true">
                                    <option value="">Select Branch</option>
                                    <?php foreach ($locationList as $j) { ?>
                                        <option value="<?= $j['id'] ?>" <?= ($firstLocation == $j['id'] ? 'selected' : '') ?>>
                                            <?= $j['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
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

            <div class=" ">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    REPORT PROFIT AND LOSS: <?= $dateEndVal ?>
                                     <button class="btn btn-primary btn-sm btn-add">REGENEREATE</button>
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
                                                    <th style="text-align: center;">OUTLET</th>
                                                    <th style="text-align: center;">COST/SALES</th>
                                                    <th style="text-align: center;">AMOUNT</th>
                                                    <th style="text-align: center;">PERCENTAGE</th>
                                                </tr>
                                            </thead>
                                            <!-- <tfoot>
                                                <tr>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                    <th style="text-align: right"></th>
                                                </tr>
                                            </tfoot> -->
                                            <tbody id="report-body">
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
            buttons: ['excel', {
                extend: 'pdfHtml5',
                text: 'Export PDF',
                orientation: 'portrait',
                pageSize: 'A4',
                filename: function () {
                    const period = $('.filter_period').val(); // format: YYYY-MM
                    const location = $('#locationId option:selected').text().trim();
                    return `Laporan_Profit_Loss_${location}_${period}`;
                },
                title: '',
                customize: function (doc) {
                    const period = $('.filter_period').val(); // misalnya: 2025-07
                    const location = $('#locationId option:selected').text().trim();
                    doc.content.splice(0, 0, {
                        text: [
                            { text: 'LAPORAN PROFIT & LOSS\n', fontSize: 14, bold: true },
                            { text: `Periode: ${period}\n`, fontSize: 11 },
                            { text: `Cabang: ${location}`, fontSize: 11 }
                        ],
                        fontSize: 16,
                        alignment: 'center',
                        bold: true,
                        margin: [0, 0, 0, 12]
                    });

                    doc.styles.tableHeader.alignment = 'center';
                    doc.defaultStyle.fontSize = 10;
                    doc.footer = function (currentPage, pageCount) {
                        return {
                            text: 'Halaman ' + currentPage.toString() + ' dari ' + pageCount,
                            alignment: 'right',
                            margin: [0, 10, 20, 0]
                        };
                    };
                }
            }]
        });

        function fetchData() {
            const formData = $('#form-cari-invoice').serialize();

            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('App/getProfitAndLoss') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rows = res.data || [];
                    const level = <?= json_encode($level) ?>;
                    const formData = $('#form-cari-invoice').serializeArray();
                    const end = formData.find(item => item.name === 'dateEnd')?.value;

                    function formatDate(dateStr) {
                        const options = { month: 'short', year: 'numeric' };
                        return new Date(dateStr).toLocaleDateString('en-GB', options);
                    }

                    $('#reportTitle').text(`REPORT EXPEND COST: ${formatDate(end)}`);

                    const groupedData = {};
                    let grandTotal = 0;
                    let totalPercentage = 0;
                    let percentageCount = 0;

                    rows.forEach((row) => {
                        const type = row.EXPEND || 'UNKNOWN';
                        const amount = parseFloat(row.AMOUNT || 0);
                        const percentage = parseFloat(row.PERCENTAGE) || 0;
                        const formattedPercentage = !isNaN(percentage) ? `${percentage.toFixed(2)}%` : '';

                        grandTotal += amount;
                        if (!isNaN(percentage)) {
                            totalPercentage += percentage;
                            percentageCount++;
                        }

                        if (!groupedData[type]) {
                            groupedData[type] = {
                                total: 0,
                                rows: []
                            };
                        }

                        groupedData[type].total += amount;
                        groupedData[type].rows.push([
                            row.LOCATIONNAME || '',
                            row.COSTTYPE || '',
                            amount.toLocaleString(),
                            formattedPercentage
                        ]);
                    });

                    const dataFormatted = [];
                    Object.entries(groupedData).forEach(([type, group]) => {
                        dataFormatted.push([
                            `<strong>${type}</strong>`, '', '', ''
                        ]);
                        let groupTotal = 0;
                        let percentageTotal = 0;

                        group.rows.forEach(row => {
                            const amount = parseFloat(row[2].replace(/,/g, '')) || 0;
                            const percentage = parseFloat(row[3]) || 0;

                            groupTotal += amount;
                            percentageTotal += percentage;

                            dataFormatted.push(row);
                        });
                        dataFormatted.push([
                            `<div class="subtotal-row"><strong>Subtotal ${type}</strong></div>`,
                            '',
                            `<div class="subtotal-row"><strong>${groupTotal.toLocaleString()}</strong></div>`,
                            `<div class="subtotal-row"><strong>${percentageTotal.toFixed(2)}%</strong></div>`
                        ]);
                    });

                    let totalIN = 0;
                    let totalOUT = 0;


                    rows.forEach(row => {
                        const amount = parseFloat(row.AMOUNT || 0);
                        const type = row.TYPE || '';

                        if (type === 'IN') {
                            totalIN += amount;
                        } else if (type === 'OUT') {
                            totalOUT += amount;
                        }
                    });


                    const pnlValue = totalIN - totalOUT;

                    const pnlPercentage = (pnlValue / totalIN * 100)

                    dataFormatted.push([
                        '<strong style="background-color:#d9edf7">PNL</strong>', '', `<strong>${pnlValue.toLocaleString()}</strong>`,
                        `<strong>${pnlPercentage.toFixed(2)}%</strong>`
                    ]);
                    table.clear().rows.add(dataFormatted).draw();
                },


                error: function () {
                    $('#report-body').html(`
                        <tr><td colspan="4" class="text-center text-danger">Gagal memuat data.</td></tr>
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
</script>



</html>