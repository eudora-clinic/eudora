<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Employee & Company | HRIS</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #1d4ed8;
            --gray-light: #f1f5f9;
            --gray: #6b7280;
            --text-dark: #111827;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h3 {
            font-weight: 700;
            color: var(--text-dark);
        }

        .filter-card {
            border: none;
            border-radius: 14px;
            background: white;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.2s ease-in-out;
        }

        .filter-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
        }

        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
        }

        .employee-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
            transition: all 0.25s ease-in-out;
            border-left: 5px solid var(--primary);
        }

        .employee-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.07);
        }

        .employee-card-header {
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }

        .employee-name {
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--text-dark);
        }

        .badge-status {
            font-size: 0.85rem;
            border-radius: 6px;
        }

        .company-section {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .company-card {
            background: white;
            border-radius: 10px;
            border-left: 3px solid var(--primary);
            padding: 0.75rem 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .company-card h6 {
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .loading-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid rgba(67, 97, 238, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .empty-state {
            text-align: center;
            color: var(--gray);
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--gray);
        }
    </style>
</head>


<div class="">
    <div class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="isactive" class="form-label fw-semibold">Status Aktif</label>
                <select id="isactive" class="form-select">
                    <option value="">Semua</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="locationid" class="form-label fw-semibold">Lokasi</label>
                <select id="locationid" class="form-select"></select>
            </div>

            <div class="col-md-4">
                <label for="employeeid" class="form-label fw-semibold">Nama Employee</label>
                <select id="employeeid" class="form-select"></select>
            </div>

            <div class="col-md-1 text-end">
                <button id="btnReset" class="btn btn-outline-secondary w-100"><i class="fas fa-rotate"></i></button>
            </div>

            <div class="col-md-1 text-end">
                <button onclick="addNewEmployee()" id="" class="btn btn-outline-secondary w-100"><i
                        class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>
        </div>
    </div>
    <div id="loadingState" class="loading-state">
        <div class="loading-spinner mb-3"></div>
        <p class="text-muted">Memuat data employee...</p>
    </div>

    <div id="employeeList"></div>

    <div id="emptyState" class="empty-state" style="display: none;">
        <i class="fas fa-user-slash"></i>
        <p>Tidak ada data ditemukan.</p>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#locationid').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih lokasi',
            ajax: {
                url: '<?= base_url("ControllerHr/getLocations"); ?>',
                dataType: 'json',
                delay: 250,
                processResults: data => ({
                    results: data.map(loc => ({ id: loc.id, text: loc.name }))
                })
            }
        });

        $('#employeeid').select2({
            theme: 'bootstrap-5',
            placeholder: 'Cari nama karyawan',
            ajax: {
                url: '<?= base_url("ControllerHr/searchEmployeeCompany"); ?>',
                dataType: 'json',
                delay: 250,
                data: params => ({ search: params.term }),
                processResults: data => ({
                    results: data.map(emp => ({ id: emp.id, text: emp.name }))
                })
            }
        });


        $('#isactive, #locationid, #employeeid').on('change', loadEmployeeData);

        $('#btnReset').click(() => {
            $('#isactive').val('');
            $('#locationid').val(null).trigger('change');
            $('#employeeid').val(null).trigger('change');
            loadEmployeeData();
        });

        function loadEmployeeData() {
            const filters = {
                isactive: $('#isactive').val(),
                locationid: $('#locationid').val(),
                employeeid: $('#employeeid').val(),
            };

            $('#loadingState').show();
            $('#employeeList').html('');
            $('#emptyState').hide();

            $.ajax({
                url: '<?= base_url("ControllerHr/listEmployeeCompany"); ?>',
                method: 'GET',
                data: filters,
                dataType: 'json',
                success: function (res) {
                    $('#loadingState').hide();
                    if (res.status === 'success' && res.data.length > 0) renderEmployeeCards(res.data);
                    else $('#emptyState').show();
                },
                error: function (xhr) {
                    $('#loadingState').hide();
                    $('#emptyState').show();
                    console.error(xhr.responseText);
                }
            });
        }

        function renderEmployeeCards(data) {
            let html = '';
            data.forEach((emp, idx) => {
                const active = emp.isactive ? 'Aktif' : 'Tidak Aktif';
                const badgeClass = emp.isactive ? 'bg-success' : 'bg-secondary';

                html += `
                <div class="employee-card">
                    <div class="employee-card-header" data-bs-toggle="collapse" data-bs-target="#emp-${idx}">
                        <div>
                            <div class="employee-name">${emp.name} - ${emp.locationname}</div>
                            <small class="text-muted">NIP : ${emp.nip || '-'}</small>
                            <small class="text-muted">Handphone : ${emp.cellphonenumber || '-'}</small>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="${emp.accountid ? 'resetAccount(' + emp.accountid + ')' : 'createAccount(' + emp.id + ')'}">
                                <i class="fas ${emp.accountid ? 'fa-redo-alt' : 'fa-user-plus'}"></i> ${emp.accountid ? 'Reset Akun' : 'Create Akun'}
                            </button>
                            ${emp.accountid ? `
                            <button class="btn btn-sm ${emp.isaccountactive ? 'btn-outline-warning' : 'btn-outline-success'} me-2" 
                                    onclick="${emp.isaccountactive ? 'deactivateAccount(' + emp.accountid + ')' : 'activateAccount(' + emp.accountid + ')'}"
                                    title="${emp.isaccountactive ? 'Nonaktifkan Akun' : 'Aktifkan Akun'}">
                                <i class="fas ${emp.isaccountactive ? 'fa-ban' : 'fa-check-circle'}"></i> ${emp.isaccountactive ? 'Nonaktifkan' : 'Aktifkan'}
                            </button>
                            <button class="btn btn-sm btn-outline-info me-2" onclick="showPassword('${emp.password}')" title="Lihat Password">
                                <i class="fas fa-eye"></i> Lihat Password
                            </button>
                            ` : ''}
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="editEmployee(${emp.id})"><i class="fas fa-edit"></i> EDIT EMPLOYEE</button>
                            <button class="btn btn-sm btn-outline-success me-2" onclick="addCompany(${emp.id})"><i class="fas fa-plus"></i> ADD EMPLOYEE COMPANY</button>
                            
                            <span class="badge ${badgeClass} badge-status">${active}</span>
                            <i class="fas fa-chevron-down ms-2 text-primary"></i>
                        </div>
                    </div>

                    <div class="collapse company-section" id="emp-${idx}">
                `;

                // <button class="btn btn-sm btn-outline-danger me-2" onclick="deleteEmployee(${emp.id})"><i class="fas fa-trash"></i></button>

                if (emp.companies?.length > 0) {
                    emp.companies.forEach(c => {
                        html += `
                            <div class="company-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>${c.companyname}</h6>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary me-2" onclick="editCompany(${c.employee_companyid})"><i class="fas fa-edit"></i> EDIT EMPLOYEE COMPANY</button>
                                        <button class="btn btn-sm btn-outline-success" onclick="addAllowance(${c.id}, ${emp.id})"><i class="fas fa-plus"></i> ADD ALLOWANCE</button>
                                        <button class="btn btn-sm btn-outline-danger me-2" onclick="deleteCompany(${c.employee_companyid})"><i class="fas fa-trash"></i>DELETE EMPLOYEE COMPANY</button>
                                    </div>
                                </div>
                                <p class="text-muted mb-2"><i class="fas fa-briefcase me-2"></i>${c.jobname}</p>
                                <p class="text-muted mb-2"><i class="fas fa-calendar me-2"></i>${c.startdate} - ${c.enddate}</p>
                                <p class="text-muted mb-2"><i class="fas fa-user-tie me-2"></i>${c.employmenttype}</p>
                                <p class="text-muted mb-2"><i class="fas fa-wallet me-2"></i>${c.salarytype}</p>
                                <p class="mb-2 ${c.is_bpjs_tk_registered == 1 ? 'text-success' : 'text-danger'}">
                                    <i class="fas fa-briefcase me-2"></i>BPJS Ketenagakerjaan ${c.is_bpjs_tk_registered == 1 ? 'Terdaftar' : 'Tidak Terdaftar'}
                                </p>
                                <p class="mb-2 ${c.is_bpjs_health_registered == 1 ? 'text-success' : 'text-danger'}">
                                    <i class="fas fa-heartbeat me-2"></i>BPJS Kesehatan ${c.is_bpjs_health_registered == 1 ? 'Terdaftar' : 'Tidak Terdaftar'}
                                </p>
                                <small class="badge bg-light text-dark mb-2">
                                    <i class="fas fa-money-bill-wave me-2"></i>Payroll - (${c.payrollgroup}) | 
                                    Salary: Rp ${parseInt(c.basesalary).toLocaleString('id-ID')}
                                </small>
                                <hr class="my-2">
                        `;

                        if (c.allowances?.length > 0) {
                            html += '<ul class="mb-0">';
                            c.allowances.forEach(a => {
                                const isActive = a.is_active == 1 || a.isactive == 1 || a.status == 'active';
                                const badgeClass = isActive ? 'bg-success' : 'bg-secondary';
                                const statusText = isActive ? 'Aktif' : 'Tidak Aktif';

                                html += `
                                    <li class="d-flex justify-content-between align-items-center mb-1">
                                        <div>
                                            <span class="fw-semibold">${a.allowance_name}:</span>
                                            <span class="text-success fw-semibold ms-1">Rp ${parseInt(a.amount).toLocaleString('id-ID')}</span>
                                            <span class="badge ${badgeClass} badge-sm ms-2">${statusText}</span>
                                        </div>
                                        <div>
                                        <button class="btn btn-xs btn-outline-primary btn-sm ms-2" onclick="editAllowance(${a.id})" title="Edit Allowance">
                                            <i class="fas fa-edit fa-xs"></i>EDIT ALLOWANCE
                                        </button>
                                        
                                        </div>
                                    </li>
                                `;
                            });
                            html += '</ul>';
                        } else {
                            html += '<p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i>Tidak ada allowance.</p>';
                        }
                        html += `</div>`;
                    });
                } else {
                    html += `<p class="text-muted">Belum terdaftar di company manapun.</p>`;
                }

                html += `</div></div>`;
            });

            $('#employeeList').html(html);
        }

        // <button class="btn btn-sm btn-outline-danger me-2" onclick="deleteAllowance(${a.id})"><i class="fas fa-trash"></i>DELETE ALLOWANCE</button>
        function getNewEmployeeIdAndFilter(employeeData) {
            if (employeeData && employeeData.employeeId) {
                const employeeId = employeeData.employeeId;
                const employeeName = employeeData.employeeName;
                
                $('#isactive').val('');
                $('#locationid').val(null).trigger('change');

                const newOption = new Option(employeeName, employeeId, true, true);
                $('#employeeid').append(newOption).trigger('change');

                // Tunggu sebentar agar Select2 ter-update, lalu load data
                setTimeout(() => {
                    loadEmployeeData();

                    // Tampilkan pesan info
                    showToast(`Data karyawan baru berhasil ditambahkan dan difilter`, 'info');
                }, 800);
            } else {
                // Fallback: load data biasa jika employeeId tidak tersedia
                loadEmployeeData();
            }
        }
        window.loadEmployeeData = loadEmployeeData;
        window.renderEmployeeCards = renderEmployeeCards;
        window.getNewEmployeeIdAndFilter = getNewEmployeeIdAndFilter;

        loadEmployeeData();
    });

    // Fungsi untuk edit employee

    const baseUrl = "<?= base_url('ControllerEmployeeApps') ?>";
    const baseUrlHr = "<?= base_url('ControllerHr') ?>";

    function editEmployee(id) {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeDetail/') ?>' + id,
            type: 'GET',
            success: function (response) {
                $('#employeeEditModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('employeeEditModal'));
                modal.show();
            }
        });
    }

    // Fungsi untuk tambah employee baru
    function addNewEmployee() {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeDetail/') ?>' + '0',
            type: 'GET',
            success: function (response) {
                $('#employeeEditModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('employeeEditModal'));
                modal.show();
            }
        });
    }

    function addCompany(employeeId) {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeCompany/') ?>' + '0/' + employeeId,
            type: 'GET',
            success: function (response) {

                console.log(response);

                $('#companyModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('companyModal'));
                modal.show();
            }
        });
    }

    function editCompany(companyId) {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeCompany/') ?>' + companyId,
            type: 'GET',
            success: function (response) {
                $('#companyModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('companyModal'));
                modal.show();
            }
        });
    }

    function addAllowance(companyId, employeeId) {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeAllowance/') ?>' + '0/' + employeeId + '/' + companyId,
            type: 'GET',
            success: function (response) {
                $('#allowanceModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('allowanceModal'));
                modal.show();
            }
        });
    }

    function editAllowance(allowanceId) {
        $.ajax({
            url: '<?= base_url('ControllerHr/getEmployeeAllowance/') ?>' + allowanceId,
            type: 'GET',
            success: function (response) {
                $('#allowanceModal').remove();
                $('body').append(response);
                var modal = new bootstrap.Modal(document.getElementById('allowanceModal'));
                modal.show();
            }
        });
    }


    function activateAccount(accountid) {
        let confirmActive = confirm("Yakin ingin mengubah status keaktifan akun ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "/toggleActive",
                type: "POST",
                data: { id: accountid },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadEmployeeData();
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

    function deleteEmployee(employeeid) {
        let confirmActive = confirm("Yakin ingin mengubah status keaktifan akun ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "/deleteEmployee",
                type: "POST",
                data: { id: employeeid },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadEmployeeData();
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

    function createAccount(employeeId) {
        if (!confirm('Apakah Anda yakin ingin membuat akun untuk employee ini?')) {
            return;
        }

        const formData = new FormData();
        formData.append('employeeid', employeeId);

        if (!formData.get('employeeid')) {
            alert("Silahkan pilih employee terlebih dahulu!");
            return;
        }

        $.ajax({
            url: "<?= base_url('ControllerEmployeeApps/accountRegistration') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                let res = typeof response === "string" ? JSON.parse(response) : response;
                if (res.status) {
                    alert(res.message);
                    loadEmployeeData();
                } else {
                    alert("Error: " + res.message);
                }
            },
            error: function () {
                alert("Terjadi kesalahan saat menyimpan account.");
            }
        });
    }

    function resetAccount(accountid) {
        let confirmReset = confirm("Yakin ingin mereset password akun ini?");
        if (confirmReset) {
            $.ajax({
                url: baseUrl + "/resetPassword",
                type: "POST",
                data: { id: accountid },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadData();
                    } else {
                        alert("Gagal mengubah status keaktifan");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    }

    function showPassword(password) {
        // Gunakan SweetAlert jika available
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Password Akun',
                html: `
                <div class="input-group">
                    <input type="text" class="form-control font-monospace" value="${password}" readonly id="swalPassword">
                    <button class="btn btn-outline-primary" onclick="copySwalPassword()">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <small class="text-muted d-block mt-2">Klik copy untuk menyalin password</small>
            `,
                showCloseButton: true,
                showConfirmButton: false,
                didOpen: () => {
                    document.getElementById('swalPassword').select();
                }
            });
        } else {
            // Fallback ke modal Bootstrap
            showPasswordModal(password);
        }
    }

    function copySwalPassword() {
        const passwordInput = document.getElementById('swalPassword');
        passwordInput.select();
        document.execCommand('copy');

        // Show feedback
        const copyBtn = document.querySelector('#swalPassword ~ button');
        const originalHtml = copyBtn.innerHTML;
        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
        copyBtn.classList.remove('btn-outline-primary');
        copyBtn.classList.add('btn-success');

        setTimeout(() => {
            copyBtn.innerHTML = originalHtml;
            copyBtn.classList.remove('btn-success');
            copyBtn.classList.add('btn-outline-primary');
        }, 2000);
    }


    function deleteCompany(employee_companyid) {
        let confirmActive = confirm("Yakin ingin menghapus employee di company ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrlHr + "/deleteEmployeeCompanyById",
                type: "POST",
                data: { id: employee_companyid },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadEmployeeData();
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

    function deleteAllowance(allowanceid) {
        let confirmActive = confirm("Yakin ingin menghapus tunjangan ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "/deleteAllowance",
                type: "POST",
                data: { id: employeeid },
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadEmployeeData();
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