<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Commission Report - Product Therapist</title>


    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</head>

<body class="p-4 bg-light">
    <div class="bg-white shadow p-4 rounded-3">
        <!-- Filter -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" id="start_date" class="form-control" />
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" id="end_date" class="form-control" />
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button id="btnFilter" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="reportTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary"
                    type="button" role="tab">Summary</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button"
                    role="tab">Details</button>
            </li>
        </ul>

        <div class="tab-content" id="reportTabsContent">
            <!-- Summary Tab -->
            <div class="tab-pane fade show active" id="summary" role="tabpanel">
                <table id="tableSummary" class="table table-striped table-bordered" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Location</th>
                            <th>Therapist</th>
                            <th>Total Komisi</th>
                            <th>Total Transaksi</th>
                            <th>Total Qty</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Detail Tab -->
            <div class="tab-pane fade" id="details" role="tabpanel">
                <table id="tableDetails" class="table table-striped table-bordered" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>Invoice No</th>
                            <th>Invoice Date</th>
                            <th>Product Name</th>
                            <th>Amount</th>
                            <th>Qty</th>
                            <th>Therapist</th>
                            <th>Location</th>
                            <th>Komisi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let baseUrl = '<?= base_url('ControllerReport/get_commission_report_invoice_product_therapist'); ?>';

            let tableSummary = $('#tableSummary').DataTable({
                columns: [
                    { data: 'locationname' },
                    { data: 'salesname' },
                    { data: 'total_komisi', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
                    { data: 'total_transaksi' },
                    { data: 'total_qty' },
                    { data: 'total_amount', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') }
                ]
            });

            let tableDetails = $('#tableDetails').DataTable({
                columns: [
                    { data: 'invoiceno' },
                    { data: 'invoicedate' },
                    { data: 'productname' },
                    { data: 'amount', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
                    { data: 'qty' },
                    { data: 'salesname' },
                    { data: 'locationname' },
                    { data: 'komisi', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') }
                ]
            });

            function loadData() {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();

                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    data: { start_date, end_date },
                    dataType: 'json',
                    beforeSend: function () {
                        $('#btnFilter').prop('disabled', true).text('Loading...');
                    },
                    success: function (res) {
                        console.log(res.data);

                        if (res.status === 'success') {
                            tableSummary.clear().rows.add(res.summary).draw();
                            tableDetails.clear().rows.add(res.data).draw();
                            $('#start_date').val(res.start_date);
                            $('#end_date').val(res.end_date);
                        }
                    },
                    complete: function () {
                        $('#btnFilter').prop('disabled', false).text('Filter');
                    }
                });
            }

            $('#btnFilter').click(function () {
                loadData();
            });

            loadData(); // load default (bulan berjalan)
        });
    </script>
</body>

</html>