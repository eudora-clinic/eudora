<form id="editCompanyForm" onsubmit="return false;">
    <input type="hidden" name="id" value="<?= $companyData['id'] ?? '' ?>">
    <input type="hidden" name="employeeid" value="<?= $employeeid ?>">

    <div class="row">
        <!-- Kolom 1: Data Perusahaan -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Perusahaan <span class="text-danger">*</span></label>
                <select id="companyid" name="companyid" class="form-select" required>
                    <option value="">Select Perusahaan</option>
                    <?php foreach ($companyList as $company) { ?>
                        <option value="<?= $company['id'] ?>" <?= (isset($companyData['companyid']) && $companyData['companyid'] == $company['id'] ? 'selected' : '') ?>>
                            <?= $company['companyname'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Department</label>
                <select id="departmentid" name="departmentid" class="form-select">
                    <option value="">Select Department</option>
                    <?php foreach ($departmentList as $dept) { ?>
                        <option value="<?= $dept['id'] ?>" <?= (isset($companyData['departmentid']) && $companyData['departmentid'] == $dept['id'] ? 'selected' : '') ?>>
                            <?= $dept['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                <select id="jobid" name="jobid" class="form-select" required>
                    <option value="">Select Jabatan</option>
                    <?php foreach ($jobList as $job) { ?>
                        <option value="<?= $job['id'] ?>" <?= (isset($companyData['jobid']) && $companyData['jobid'] == $job['id'] ? 'selected' : '') ?>>
                            <?= $job['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">BPJS Kesehatan <span class="text-danger">*</span></label>
                <select name="is_bpjs_health_registered" class="form-select" required>

                    <option value="0" <?= (isset($companyData['is_bpjs_health_registered']) && $companyData['is_bpjs_health_registered'] == 0) ? 'selected' : '' ?>>Tidak Terdaftar</option>
                    <option value="1" <?= (isset($companyData['is_bpjs_health_registered']) && $companyData['is_bpjs_health_registered'] == 1) ? 'selected' : '' ?>>Terdaftar</option>
                </select>
            </div>
        </div>

        <!-- Kolom 2: Data Kontrak & Gaji -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Tipe Employment <span class="text-danger">*</span></label>
                <select id="employmenttypeid" name="employmenttypeid" class="form-select" required>
                    <option value="">Select Tipe Employment</option>
                    <?php foreach ($employmentTypeList as $type) { ?>
                        <option value="<?= $type['id'] ?>" <?= (isset($companyData['employmenttypeid']) && $companyData['employmenttypeid'] == $type['id'] ? 'selected' : '') ?>>
                            <?= $type['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipe Gaji <span class="text-danger">*</span></label>
                <select id="salarytypeid" name="salarytypeid" class="form-select" required>
                    <option value="">Select Tipe Gaji</option>
                    <?php foreach ($salaryTypeList as $type) { ?>
                        <option value="<?= $type['id'] ?>" <?= (isset($companyData['salarytypeid']) && $companyData['salarytypeid'] == $type['id'] ? 'selected' : '') ?>>
                            <?= $type['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Gaji Pokok <span class="text-danger">*</span></label>
                <input type="text" name="basesalary" class="form-control"
                    value="<?= isset($companyData['basesalary']) ? number_format($companyData['basesalary'], 0, ',', '.') : '' ?>"
                    required oninput="formatRupiah(this)">
            </div>

            <div class="mb-3">
                <label class="form-label">BPJS Ketenagakerjaan <span class="text-danger">*</span></label>
                <select name="is_bpjs_tk_registered" class="form-select" required>
                    <option value="0" <?= (isset($companyData['is_bpjs_tk_registered']) && $companyData['is_bpjs_tk_registered'] == 0) ? 'selected' : '' ?>>Tidak Terdaftar</option>
                    <option value="1" <?= (isset($companyData['is_bpjs_tk_registered']) && $companyData['is_bpjs_tk_registered'] == 1) ? 'selected' : '' ?>>Terdaftar</option>
                </select>
            </div>
        </div>

        <!-- Kolom 3: Data Payroll & Status -->
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Payroll Group <span class="text-danger">*</span></label>
                <select id="payrollgroupid" name="payrollgroupid" class="form-select" required>
                    <option value="">Select Payroll Group</option>
                    <?php foreach ($payrollGroupList as $group) { ?>
                        <option value="<?= $group['id'] ?>" <?= (isset($companyData['payrollgroupid']) && $companyData['payrollgroupid'] == $group['id'] ? 'selected' : '') ?>>
                            <?= $group['groupname'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                <input type="date" name="startdate" class="form-control" value="<?= $companyData['startdate'] ?? '' ?>"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Berakhir</label>
                <input type="date" name="enddate" class="form-control" value="<?= $companyData['enddate'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                <select name="isactive" class="form-select" required>
                    <option value="1" <?= (isset($companyData['isactive']) && $companyData['isactive'] == 1) ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= (isset($companyData['isactive']) && $companyData['isactive'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Area untuk error messages -->
    <div id="formErrors" class="alert alert-danger d-none mt-3"></div>
</form>

<script>

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

        // Tambahkan ke container toast
        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        toastContainer.appendChild(toast);

        // Inisialisasi dan tampilkan toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

        // Hapus toast setelah selesai
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.position = 'fixed';
        container.style.top = '20px';
        container.style.right = '20px';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    }
    function formatRupiah(el) {
        let angka = el.value.replace(/[^,\d]/g, "");
        let rupiah = "";
        let split = angka.split(",");
        let sisa = split[0].length % 3;
        rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        el.value = rupiah ? rupiah : "";
    }

    function saveCompany() {
        const formData = new FormData(document.getElementById('editCompanyForm'));

        // Convert Rupiah format back to number
        const basesalaryInput = document.querySelector('input[name="basesalary"]');
        const basesalaryValue = basesalaryInput.value.replace(/[^0-9]/g, "");
        formData.set('basesalary', basesalaryValue);

        const saveBtn = document.querySelector('#companyModal .btn-primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        saveBtn.disabled = true;

        fetch('<?= base_url('ControllerHr/saveEmployeeCompany') ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('companyModal')).hide();
                    showToast('Data company berhasil disimpan', 'success');
                    loadEmployeeData();
                } else {
                    showFormErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan saat menyimpan data', 'error');
            })
            .finally(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;
            });
    }

    function showFormErrors(errors) {
        const errorDiv = document.getElementById('formErrors');
        if (errors && Object.keys(errors).length > 0) {
            let errorHtml = '<ul>';
            for (const key in errors) {
                errorHtml += `<li>${errors[key]}</li>`;
            }
            errorHtml += '</ul>';
            errorDiv.innerHTML = errorHtml;
            errorDiv.classList.remove('d-none');
        } else {
            errorDiv.classList.add('d-none');
        }
    }
</script>