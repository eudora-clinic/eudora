<form id="editAllowanceForm" onsubmit="return false;">
    <input type="hidden" name="id" value="<?= $allowance['id'] ?? '' ?>">
    <input type="hidden" name="employeeid" value="<?= $employeeid ?>">
    <input type="hidden" name="companyid" value="<?= $companyid ?>">

    <div class="row">
        <!-- Kolom 1: Data Allowance -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Jenis Tunjangan <span class="text-danger">*</span></label>
                <select id="allowancetypeid" name="allowancetypeid" class="form-select" required>
                    <option value="">Select Jenis Tunjangan</option>
                    <?php foreach ($allowanceTypeList as $type) { ?>
                        <option value="<?= $type['id'] ?>" <?= (isset($allowance['allowancetypeid']) && $allowance['allowancetypeid'] == $type['id'] ? 'selected' : '') ?>
                            data-isactive="<?= $type['isactive'] ?>">
                            <?= $type['allowance_name'] ?>
                            <?= $type['isactive'] == 0 ? ' (Tidak Aktif)' : '' ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Tunjangan <span class="text-danger">*</span></label>
                <input type="text" name="amount" class="form-control"
                    value="<?= isset($allowance['amount']) ? number_format($allowance['amount'], 0, ',', '.') : '' ?>"
                    required oninput="formatRupiah(this)" placeholder="Masukkan jumlah tunjangan">
            </div>
        </div>

        <!-- Kolom 2: Info Tambahan -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Karyawan</label>
                <input type="text" class="form-control" value="<?= $employeeName ?>" readonly disabled>
                <small class="text-muted">Nama karyawan yang akan menerima tunjangan</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Perusahaan</label>
                <input type="text" class="form-control" value="<?= $companyName ?>" readonly disabled>
                <small class="text-muted">Perusahaan pemberi tunjangan</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                <select name="isactive" class="form-select" required>
                    <option value="1" <?= (isset($allowance['isactive']) && $allowance['isactive'] == 1) ? 'selected' : 'selected' ?>>Aktif</option>
                    <option value="0" <?= (isset($allowance['isactive']) && $allowance['isactive'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Informasi tambahan -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="alert alert-info">
                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi</h6>
                <ul class="mb-0">
                    <li>Tunjangan akan ditambahkan ke payroll karyawan</li>
                    <li>Pastikan jenis tunjangan sesuai dengan kebijakan perusahaan</li>
                    <li>Status "Tidak Aktif" akan menonaktifkan tunjangan tanpa menghapus data</li>
                </ul>
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

    // Validasi pilihan allowance type yang aktif
    document.addEventListener('DOMContentLoaded', function () {
        const allowanceTypeSelect = document.getElementById('allowancetypeid');
        if (allowanceTypeSelect) {
            allowanceTypeSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const isActive = selectedOption.getAttribute('data-isactive');

                if (isActive === '0') {
                    if (!confirm('Jenis tunjangan ini tidak aktif. Apakah Anda yakin ingin melanjutkan?')) {
                        this.value = '';
                    }
                }
            });
        }
    });

    function saveAllowance() {
        const formData = new FormData(document.getElementById('editAllowanceForm'));

        // Convert Rupiah format back to number
        const amountInput = document.querySelector('input[name="amount"]');
        const amountValue = amountInput.value.replace(/[^0-9]/g, "");
        formData.set('amount', amountValue);

        // Validasi amount tidak boleh 0
        if (parseFloat(amountValue) === 0) {
            showFormErrors({ amount: 'Jumlah tunjangan tidak boleh 0' });
            return;
        }

        const saveBtn = document.querySelector('#allowanceModal .btn-primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        saveBtn.disabled = true;

        fetch('<?= base_url('ControllerHr/saveEmployeeAllowance') ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('allowanceModal')).hide();
                    showToast('Data tunjangan berhasil disimpan', 'success');
                    loadEmployeeData(); // Refresh employee list
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