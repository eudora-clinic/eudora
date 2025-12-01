<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First Visit Customer Report</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.25rem;
        }

        .btn-primary {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.3);
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e1e5ee;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(72, 149, 239, 0.25);
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .summary-card h5 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .summary-card .number {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            margin: 0 3px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            border: none !important;
        }

        .dt-buttons .btn {
            border-radius: 8px;
            margin-right: 5px;
        }

        .page-title {
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6c757d;
            margin-bottom: 2rem;
        }

        .icon-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            margin-right: 15px;
        }
    </style>
</head>


<div>


    <!-- Filter Section -->
    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="datestart" class="form-label fw-semibold">Start Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" id="datestart" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="dateend" class="form-label fw-semibold">End Date</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" id="dateend" class="form-control">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button id="btnGenerate" class="btn btn-primary w-100">
                        <i class="fas fa-chart-bar me-2"></i>Generate Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4" id="summaryCards" style="display: none;">
        <div class="col-md-6">
            <div class="summary-card">
                <h5><i class="fas fa-users me-2"></i>Total Customers</h5>
                <div class="number" id="totalCustomer">0</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="summary-card">
                <h5><i class="fas fa-money-bill-wave me-2"></i>Grand Total Amount</h5>
                <div class="number" id="grandTotalAmount">Rp 0</div>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3">Loading report data...</p>
    </div>

    <!-- Table Result -->
    <div class="card" id="tableCard" style="display: none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Report Results</h5>
            <div class="btn-group" id="exportButtons" style="display: none;">
                <button class="btn btn-success btn-sm" id="btnExcel">
                    <i class="fas fa-file-excel me-1"></i> Export to Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="resultTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>First Visit</th>
                            <th>Admin</th>
                            <th>Ads</th>
                            <th class="text-end">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="card text-center py-5" id="emptyState">
        <div class="card-body">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Data Available</h5>
            <p class="text-muted">Select a date range and generate a report to view data</p>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Initialize DataTable
        const dataTable = $('#resultTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel me-1"></i> Excel',
                    className: 'btn-success btn-sm',
                    title: 'First Visit Customer Report'
                }
            ],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            },
            pageLength: 10,
            ordering: true,
            responsive: true,
            autoWidth: false,
            order: [[3, 'desc']] // Default sort by First Visit date
        });

        // Set default dates (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);

        $("#datestart").val(thirtyDaysAgo.toISOString().split('T')[0]);
        $("#dateend").val(today.toISOString().split('T')[0]);

        // Generate Report Button Click
        $("#btnGenerate").click(function () {
            const datestart = $("#datestart").val();
            const dateend = $("#dateend").val();

            if (!datestart || !dateend) {
                alert("Please select both start and end dates!");
                return;
            }

            // Show loading state
            $("#btnGenerate").prop("disabled", true).html('<i class="fas fa-spinner fa-spin me-2"></i> Generating...');
            $("#loadingSpinner").show();
            $("#emptyState").hide();
            $("#tableCard").hide();
            $("#summaryCards").hide();

            // Simulate API call (replace with actual AJAX call)
            setTimeout(function () {
                // This is a simulation - replace with your actual AJAX call
                simulateApiResponse(datestart, dateend);
            }, 1500);
        });

        // Function to simulate API response (replace with your actual AJAX call)
        function simulateApiResponse(datestart, dateend) {
            $.ajax({
                url: "<?= base_url('ControllerReport/getReportFirstVisit') ?>",
                method: "GET",
                data: { datestart: datestart, dateend: dateend },
                dataType: "json",
                success: function (res) {
                    processApiResponse(res);
                },
                error: function (xhr) {
                    $("#btnGenerate").prop("disabled", false).text("Generate Report");
                    console.error(xhr.responseText);
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        }

        // Function to process API response
        function processApiResponse(res) {
            // Reset button state
            $("#btnGenerate").prop("disabled", false).html('<i class="fas fa-chart-bar me-2"></i> Generate Report');
            $("#loadingSpinner").hide();

            if (res.status !== "success") {
                alert(res.message);
                $("#emptyState").show();
                return;
            }

            const data = res.results[0].data || [];
            const total_customer = res.total_customer || 0;
            const grand_total_amount = res.grand_total_amount || 0;

            // Update summary cards
            $("#totalCustomer").text(total_customer);
            $("#grandTotalAmount").text("Rp " + parseInt(grand_total_amount).toLocaleString());
            $("#summaryCards").show();

            // Clear and populate DataTable
            dataTable.clear();

            if (data.length === 0) {
                $("#emptyState").show();
                $("#tableCard").hide();
                $("#exportButtons").hide();
            } else {
                $.each(data, function (i, item) {
                    dataTable.row.add([
                        i + 1,
                        item.customername || '-',
                        item.cellphonenumber || '-',
                        item.firstvisit ? item.firstvisit.split('T')[0] : '-',
                        item.adminname || '-',
                        item.ads || '-',
                        '<div class="text-end">Rp ' + (item.total_amount || 0).toLocaleString() + '</div>'
                    ]);
                });

                dataTable.draw();
                $("#tableCard").show();
                $("#exportButtons").show();
                $("#emptyState").hide();
            }
        }

        // Manual Excel export button
        $("#btnExcel").click(function () {
            $(".buttons-excel").click();
        });
    });
</script>

</html>