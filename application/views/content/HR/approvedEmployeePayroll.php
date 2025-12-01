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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
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
                        <input type="month" id="filterMonth" class="form-control" value="2025-10">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="filterLocation"><strong>Company</strong></label>
                        <select id="filterLocation" class="form-control select2">
                            <option value="">-- Pilih Company --</option>
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
    </div>

    <div id="summaryContainer">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-users fa-3x mb-3"></i>
            <p>Pilih bulan dan company, lalu klik "Generate Summary" untuk menampilkan data</p>
        </div>
    </div>
</div>

<!-- jQuery, Bootstrap, Select2, Toastr -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#filterLocation').select2({
            placeholder: 'Pilih lokasi',
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

            if (!month || !location) {
                toastr.warning('Pilih bulan dan lokasi terlebih dahulu!');
                return;
            }

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
                url: '<?= base_url("ControllerHr/employeePayroll"); ?>',
                method: 'GET',
                data: filters,
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success' && res.results.length > 0) setTimeout(() => {
                        renderSummary(res);
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
        function renderSummary(data) {
            if (!data || !data.results || data.results.length === 0) {
                $('#summaryContainer').html(`
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle mr-2"></i>Tidak ada data payroll untuk kriteria yang dipilih.
                        </div>
                    `);
                return;
            }
            let html = ``;

            data.results.forEach((group, index) => {
                if (group.data.length === 0) {
                    html += `
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-secondary text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-users mr-2"></i>${group.payroll_group}</span>
                                    <small>${formatDate(group.period_start)} - ${formatDate(group.period_end)}</small>
                                </div>
                            </div>
                            <div class="card-body text-center py-4 text-muted">
                                <i class="fas fa-user-slash fa-2x mb-2"></i>
                                <p>Tidak ada data karyawan dalam kelompok ini</p>
                            </div>
                        </div>`;
                } else {
                    html += `
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" 
                                 data-toggle="collapse" href="#group${index}" aria-expanded="true">
                                <div>
                                    <i class="fas fa-users mr-2"></i>
                                    <strong>${group.payroll_group}</strong>
                                    <span class="badge badge-info ml-2">${group.data.length} Karyawan</span>
                                    <span class="badge badge-info ml-2">${group.companyname}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <small class="mr-3">${formatDate(group.period_start)} - ${formatDate(group.period_end)}</small>
                                    <i class="collapse-icon fas fa-chevron-down"></i>
                                </div>
                            </div>
                            <div id="group${index}" class="collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        ${renderEmployees(group.data)}
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }
            });

            $('#summaryContainer').html(html);
            $('.card-header').on('click', function () {
                $(this).find('.collapse-icon').toggleClass('fa-chevron-down fa-chevron-up');
            });
        }
        function renderEmployees(employees) {
            let html = '';
            employees.forEach(emp => {
                const isNegativeSalary = emp.takehomepay < 0;
                const salaryClass = isNegativeSalary ? 'negative-salary' : 'text-success';

                const isPaid = emp.status == 'Paid';

                // Format allowance list
                const allowanceList = emp.allowance && emp.allowance.length > 0
                    ? emp.allowance.map(a =>
                        `<li class="d-flex justify-content-between">
                                <span>${a.allowancename}</span>
                                <span class="text-success">Rp ${formatNumber(a.amount)}</span>
                            </li>`
                    ).join('')
                    : '<li class="text-muted">Tidak ada tunjangan</li>';

                const deductionList = emp.deduction && emp.deduction.length > 0
                    ? emp.deduction.map(a =>
                        `<li class="d-flex justify-content-between">
                                <span class="text-danger">${a.deductionname}</span>
                                <span class="text-danger">Rp ${formatNumber(a.amount)}</span>
                            </li>`
                    ).join('')
                    : '<li class="text-muted">Tidak ada potongan</li>';

                // Format leaves
                const leavesList = emp.leave && emp.leave.length > 0
                    ? emp.leave.map(l =>
                        `<span class="badge badge-info mr-1">${l.leavename}: ${l.total}</span>`
                    ).join('')
                    : '<span class="text-muted">Tidak ada cuti</span>';

                html += `
                    <div class="col-md-6 col-lg-4">
                        <div class="card employee-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">${emp.nip} - ${emp.name}</h6>
                                    <div>
                                    <span class="badge ${isNegativeSalary ? 'badge-danger' : 'badge-success'}">
                                        ${isNegativeSalary ? 'Minus' : 'Aktif'}
                                    </span>
                                    <span class="badge ${isPaid ? 'badge-success' : 'badge-danger'}">
                                        ${isPaid ? 'Sudah Dibayarkan' : 'Belum Dibayarkan'}
                                    </span>
                                    </div>
                                </div>                            
                                <div class="summary-stats mb-2">
                                                 
                                <div class="employee-status text-muted mb-2">
                                    <small>
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        Join: ${formatDate(emp.join_date)}<br>
                                        <i class="fas fa-calendar-times mr-1"></i>
                                        End: ${formatDate(emp.end_date)}
                                    </small>
                                </div>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <div class="text-danger">
                                                <strong>${emp.totalalpha}</strong><br>
                                                <small>Alpha</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-warning">
                                                <strong>${emp.totaloff}</strong><br>
                                                <small>Off</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-success">
                                                <strong>${emp.totalon}</strong><br>
                                                <small>On</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-2">
                                    <small><strong>Gaji Pokok:</strong> Rp ${formatNumber(emp.basesalary)}</small>
                                </div>

                                ${emp.isprorate ? `
                                    <div class="mb-2">
                                        <small><strong>Gaji Prorate:</strong> Rp ${formatNumber(emp.sallaryprorate)}</small>
                                    </div>
                                ` : ''}

                                <div class="mb-2">
                                    <small>
                                        <strong>BPJS:</strong>
                                        <span class="bpjs-status ${emp.is_bpjs_health_registered ? 'text-success' : 'text-danger'}">
                                            <i class="fas ${emp.is_bpjs_health_registered ? 'fa-check' : 'fa-times'}"></i>
                                        </span> Kesehatan
                                        <span class="bpjs-status ${emp.is_bpjs_tk_registered ? 'text-success' : 'text-danger'} ml-2">
                                            <i class="fas ${emp.is_bpjs_tk_registered ? 'fa-check' : 'fa-times'}"></i>
                                        </span> TK
                                    </small>
                                </div>
                                
                                <div class="mb-2">
                                    <small><strong>Cuti:</strong> ${leavesList}</small>
                                </div>
                                
                                <div class="mb-2">
                                    <small><strong>Tunjangan:</strong></small>
                                    <ul class="allowance-list small">
                                        ${allowanceList}
                                    </ul>
                                </div>

                                <div class="mb-2">
                                    <small><strong>Potongan:</strong></small>
                                    <ul class="allowance-list small">
                                        ${deductionList}
                                        <li class="d-flex justify-content-between" >
                                            <span class="text-danger">PPH21</span>
                                            <span class="text-danger">Rp ${formatNumber(emp.pph21)}</span>
                                        </li >
                                    </ul>
                                </div>

                                
                                <hr>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>Take Home Pay:</strong>
                                    <span class="${salaryClass} take-home-pay">Rp ${formatNumber(emp.takehomepay)}</span>
                                </div>
                            </div>
                             <button class="btn btn-sm btn-outline-success me-2" onclick="updatePaymentStatus(${emp.sallarypayrollid})">
                                <i class="fas fa-money-check-alt"></i> <i class="fas fa-paper-plane ms-1"></i> 
                                Update Status Pembayaran & Kirim Slip Gaji
                            </button>
                        </div>
                    </div>`;
            });
            return html;
        }
        function formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }
        window.loadSummary = loadSummary;
    });

    const baseUrlHr = "<?= base_url('ControllerHr') ?>";


    function updatePaymentStatus(sallarypayrollid) {
        let confirmActive = confirm("Yakin ingin mengupdate status pembayaran dan mengirim slip gaji ke karyawan?");
        if (confirmActive) {
            $.ajax({
                url: baseUrlHr + "/updatePaymentStatus",
                type: "POST",
                data: { id: sallarypayrollid },
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    if (response.status === "success") {
                        alert(response.message);
                        loadSummary(true);
                    } else {
                        alert("Gagal mengubah status!");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    }
</script>


</html>