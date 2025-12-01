<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commission Report</title>

    <!-- Bootstrap 4 & FontAwesome -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->

    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css"> -->

    <style>
        .card { margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .table th { background-color: #f8f9fa; }
        .commission-positive { color: #28a745; font-weight: bold; }
        .loading-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(255,255,255,0.8);
            display: flex; justify-content: center; align-items: center;
            z-index: 1050;
        }
        .summary-table th { background-color: #007bff; color: white; }
        .total-row { background-color: #e3f2fd !important; font-weight: bold; }
        .table-hover tbody tr:hover { background-color: rgba(0,123,255,0.1); }
    </style>
</head>

<body>
<div class="container-fluid mt-4">
    <div class="card">


        <div class="card-body">
            <!-- Filter -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label><strong>Start Date</strong></label>
                    <input type="date" id="startDate" class="form-control" value="<?= date('Y-m-01') ?>">
                </div>
                <div class="col-md-3">
                    <label><strong>End Date</strong></label>
                    <input type="date" id="endDate" class="form-control" value="<?= date('Y-m-t') ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="btnFilter" class="btn btn-primary w-100">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab">
                        <i class="fas fa-chart-bar mr-1"></i> Summary
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail" role="tab">
                        <i class="fas fa-list mr-1"></i> Detail
                    </a>
                </li>
            </ul>

            <div class="tab-content mt-3" id="reportTabsContent">
                <!-- Summary Tab -->
                <div class="tab-pane fade show active" id="summary" role="tabpanel">
                    <div id="summaryContainer" class="p-3">
                        <table id="summaryTable" class="table table-striped table-hover summary-table w-100">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th>Sales Name</th>
                                    <th>Total Transaksi</th>
                                    <th>Total Amount</th>
                                    <th>Total Komisi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Detail Tab -->
                <div class="tab-pane fade" id="detail" role="tabpanel">
                    <div id="detailContainer" class="p-3">
                        <table id="detailTable" class="table table-striped table-hover w-100">
                            <thead class="thead-light">
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Tanggal</th>
                                    <th>Product</th>
                                    <th>Sales</th>
                                    <th>Location</th>
                                    <th>Amount</th>
                                    <th>Bulan</th>
                                    <th>Komisi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 3000
    };

    const baseUrl = "<?= base_url('ControllerReport/get_commission_report_invoice_lifetime'); ?>";

    // Inisialisasi DataTables
    let summaryTable = $('#summaryTable').DataTable({
        columns: [
            { data: 'locationname' },
            { data: 'sales_name' },
            { data: 'total_transaksi' },
            { data: 'total_amount', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
            { data: 'total_commission', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') }
        ]
    });

    let detailTable = $('#detailTable').DataTable({
        columns: [
            { data: 'invoiceno' },
            { data: 'invoicedate' },
            { data: 'product_name' },
            { data: 'sales_name' },
            { data: 'locationname' },
            { data: 'totalamount', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
            { data: 'totalmonth' },
            { data: 'commission', render: data => data > 0 ? `<span class="badge badge-success">Rp ${new Intl.NumberFormat('id-ID').format(data)}</span>` : '-' }
        ]
    });

    // Event Filter
    $('#btnFilter').on('click', function () {
        loadCommissionData();
    });

    // Load awal
    loadCommissionData();

    function loadCommissionData() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();

        if (!startDate || !endDate) {
            toastr.warning('Pilih tanggal mulai dan tanggal akhir!');
            return;
        }
        if (new Date(startDate) > new Date(endDate)) {
            toastr.error('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
            return;
        }

        showLoading();

        $.ajax({
            url: baseUrl,
            type: 'GET',
            data: { start_date: startDate, end_date: endDate },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    summaryTable.clear().rows.add(response.summary).draw();
                    detailTable.clear().rows.add(response.data).draw();
                    toastr.success('Data berhasil dimuat');
                } else {
                    toastr.error('Gagal memuat data');
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                toastr.error('Terjadi kesalahan saat memuat data');
            },
            complete: function () {
                hideLoading();
            }
        });
    }

    // Supaya DataTables tidak rusak saat ganti tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });

    function showLoading() {
        $('body').append(`
            <div class="loading-overlay">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2"></div>
                    <div>Loading data...</div>
                </div>
            </div>
        `);
    }

    function hideLoading() {
        $('.loading-overlay').remove();
    }
});
</script>
</body>
</html>
