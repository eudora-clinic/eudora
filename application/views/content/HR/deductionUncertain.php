<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Presensi Payroll</title>

    <!-- Bootstrap 4 CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Select2 CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"> -->
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        .card-header {
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .card-header:hover {
            background-color: #0056b3 !important;
        }

        .employee-card {
            border-left: 4px solid #007bff;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .employee-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .badge-attendance {
            font-size: 0.8rem;
        }

        .summary-stats {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
        }

        .take-home-pay {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .allowance-list {
            list-style-type: none;
            padding-left: 0;
        }

        .allowance-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .allowance-list li:last-child {
            border-bottom: none;
        }

        .collapse-icon {
            transition: transform 0.3s;
        }

        .collapsed .collapse-icon {
            transform: rotate(-90deg);
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .negative-salary {
            color: #dc3545 !important;
        }

        .employee-status {
            font-size: 0.85rem;
        }

        .bpjs-status {
            display: inline-block;
            width: 20px;
            text-align: center;
        }
    </style>
</head>

<div class="">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-filter mr-2"></i>Filter Data</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="filterMonth"><strong>Bulan</strong></label>
                        <input type="month" id="filterMonth" class="form-control">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="filterLocation"><strong>Company</strong></label>
                        <select id="filterLocation" class="form-control select2">
                            <option value="">-- Semua --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="btnSearch" class="btn btn-primary w-100">
                        <i class="fas fa-sync-alt mr-1"></i> Search
                    </button>
                </div>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0">Data Potongan Tak Tentu</h5>
                <button class="btn btn-success" onclick="addUncertainCompany()">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </div>
            <div class="card-body p-3">
                <div id="summaryContainer"></div>
            </div>
        </div>

    </div>
</div>

<!-- jQuery, Bootstrap, Select2, Toastr -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->

<script>
    const now = new Date();
    now.setMonth(now.getMonth());

    const beforeMonth = now.toISOString().slice(0, 7);

    document.getElementById('filterMonth').value = beforeMonth;

    $(document).ready(function () {
        $('#filterLocation').select2({
            placeholder: 'Semua',
            ajax: {
                url: '<?= base_url("ControllerHr/getCompany"); ?>',
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data.map(loc => ({ id: loc.id, text: loc.companyname }))
                })
            }
        });

        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };

        $('#btnSearch').on('click', function () {
            loadSummary(true);
        });

        function loadSummary(showAlert = false) {
            const month = $('#filterMonth').val();
            const location = $('#filterLocation').val();

            $('#summaryContainer').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary mb-2"></div>
                        <div>Loading data...</div>
                    </div>
                `);
            simulateAjaxCall(month, location, showAlert);
        }
        function simulateAjaxCall(month, location, showAlert) {
            const filters = {
                month: month,
                companyid: location
            }
            $.ajax({
                url: '<?= base_url("ControllerHr/deductionUncertain"); ?>',
                method: 'GET',
                data: filters,
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success' && res.results.length > 0) setTimeout(() => {
                        renderTable(res);
                        if (showAlert) toastr.success('Data berhasil ditampilkan');
                    }, 1000);
                    if (res.status === 'success' && res.results.length == 0) setTimeout(() => {
                        if (showAlert) toastr.success('Belum ada data di generate di bulan ini untuk perusahaan ini');
                        $('#summaryContainer').html(`
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i>Belum ada data payroll yang di generate di bulan ini di perusahaan ini
                        </div>
                    `);
                        return;
                    }, 1000);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function renderTable(res) {
            const rows = res.results.map((item, index) => {
                const statusBadge = item.isactive == 1
                    ? '<span class="badge badge-success">Aktif</span>'
                    : '<span class="badge badge-danger">Tidak Aktif</span>';

                return `
            <tr>
                <td>${index + 1}</td>
                <td>${item.employeename}</td>
                <td>${item.companyname}</td>
                <td>${res.month}</td>
                <td>${item.deductionname}</td>
                <td>Rp ${parseInt(item.amount).toLocaleString()}</td>
                <td>${item.description ? item.description : '-'}</td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-warning btn-sm btn-edit" onclick="editUncertainCompany(${item.id})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </td>
            </tr>
        `;
            }).join('');

            const tableHtml = `
        <div class="table-responsive">
            <table id="uncertainTable" class="table table-striped table-bordered"
                                            style="width:100%">
                <thead class="bg-thead">
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th style="text-align: center;">Nama Karyawan</th>
                        <th style="text-align: center;">Company</th>
                        <th style="text-align: center;">Period</th>
                        <th style="text-align: center;">Potongan</th>
                        <th style="text-align: center;">Amount</th>
                        <th style="text-align: center;">Deskripsi</th>
                        <th style="text-align: center;">Status Aktif</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    ${rows}
                </tbody>
            </table>
        </div>
    `;

            $("#summaryContainer").html(tableHtml);

            $("#uncertainTable").DataTable({
                pageLength: 10,
                order: [[0, "asc"]],
                autoWidth: false,
                responsive: true,
            });

            $("#btnAdd").on("click", function () {
                addUncertainCompany();
                console.log('pantek');

            });
        }

        window.loadSummary = loadSummary;

        loadSummary(true);
    });

    function addUncertainCompany() {
        const month = $('#filterMonth').val();
        console.log(month);

        $.ajax({
            url: '<?= base_url('ControllerHr/getDeductionUncertain/') ?>0/' + month,
            type: 'GET',
            success: function (response) {
                $('#uncertainDeductionModal').remove();
                $('body').append(response);
                $('#uncertainDeductionModal').modal('show');
            },
        });
    }

    function editUncertainCompany(id) {
        const month = $('#filterMonth').val();

        $.ajax({
            url: '<?= base_url('ControllerHr/getDeductionUncertain/') ?>' + id + '/' + month,
            type: 'GET',
            success: function (response) {
                $('#uncertainDeductionModal').remove();
                $('body').append(response);
                $('#uncertainDeductionModal').modal('show');
            },
        });
    }

</script>


</html>