<form id="editEmployeeForm" onsubmit="return false;">
    <input type="hidden" name="id" value="<?= $employee['id'] ?? '' ?>">

    <div class="row">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="<?= $employee['nik'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= $employee['name'] ?? '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" name="placeofbirth" class="form-control"
                    value="<?= $employee['placeofbirth'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="dateofbirth" class="form-control"
                    value="<?= $employee['dateofbirth'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="4"><?= $employee['address'] ?? '' ?></textarea>
            </div>

        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">NIP <span class="text-danger">*</span></label>
                <input required type="text" name="nip" class="form-control" value="<?= $employee['nip'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Default Shift <span class="text-danger">*</span></label>
                <select id="defaultshiftid" name="defaultshiftid" class="form-select" required>
                    <option value="">Select Default Shift</option>
                    <?php foreach ($listShift as $j) { ?>
                        <option value="<?= $j['id'] ?>" <?= (isset($employee['defaultshiftid']) && $employee['defaultshiftid'] == $j['id'] ? 'selected' : '') ?>>
                            <?= $j['shiftname'] ?> - <?= $j['shiftcode'] ?> (<?= $j['timein'] ?> -
                            <?= $j['timeout'] ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="sex" class="form-select">
                    <option value="M" <?= (isset($employee['sex']) && $employee['sex'] == 'M') ? 'selected' : '' ?>>
                        Laki-laki</option>
                    <option value="F" <?= (isset($employee['sex']) && $employee['sex'] == 'F') ? 'selected' : '' ?>>
                        Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Outlet <span class="text-danger">*</span></label>
                <select id="locationid" name="locationid" class="form-select" required>
                    <option value="">Select Outlet</option>
                    <?php foreach ($locationListt as $j) { ?>
                        <option value="<?= $j['id'] ?>" <?= (isset($employee['locationid']) && $employee['locationid'] == $j['id'] ? 'selected' : '') ?>>
                            <?= $j['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Karyawan Office<span class="text-danger">*</span></label>
                <select required name="isofficeemployee" class="form-select">
                    <option value="1" <?= (isset($employee['isofficeemployee']) && $employee['isofficeemployee'] == 1) ? 'selected' : 'selected' ?>>Ya</option>
                    <option value="0" <?= (isset($employee['isofficeemployee']) && $employee['isofficeemployee'] == 0) ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                <select required name="isactive" class="form-select">
                    <option value="1" <?= (isset($employee['isactive']) && $employee['isactive'] == 1) ? 'selected' : 'selected' ?>>Aktif</option>
                    <option value="0" <?= (isset($employee['isactive']) && $employee['isactive'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Perlu Presensi<span class="text-danger">*</span></label>
                <select required name="isneedpresensi" class="form-select">
                    <option value="1" <?= (isset($employee['isneedpresensi']) && $employee['isneedpresensi'] == 1) ? 'selected' : 'selected' ?>>Ya</option>
                    <option value="0" <?= (isset($employee['isneedpresensi']) && $employee['isneedpresensi'] == 0) ? 'selected' : '' ?>>Tidak</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                <input required type="text" name="cellphonenumber" class="form-control"
                    value="<?= $employee['cellphonenumber'] ?? '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Job <span class="text-danger">*</span></label>
                <select id="jobid" name="jobid" class="form-select" required>
                    <option value="">Select Job</option>
                    <?php foreach ($jobList as $j) { ?>
                        <option value="<?= $j['id'] ?>" <?= (isset($employee['jobid']) && $employee['jobid'] == $j['id'] ? 'selected' : '') ?>>
                            <?= $j['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input required type="text" name="email" class="form-control" value="<?= $employee['email'] ?? '' ?>">
            </div>
        </div>
    </div>

    <!-- Baris 2: Data Employment -->
    <div class="row mt-4">
        <div class="col-12">
            <h6 class="mb-3 text-primary">Data Employment</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                        <input required type="date" name="startdate" class="form-control"
                            value="<?= $employee['startdate'] ?? '' ?>">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                        <input required type="date" name="enddate" class="form-control"
                            value="<?= $employee['enddate'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nomor Rekening</label>
                        <input type="text" name="accountnumber" class="form-control"
                            value="<?= $employee['accountnumber'] ?? '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris 3: Data Tambahan (jika ada) -->
    <div class="row mt-4">
        <div class="col-12">
            <h6 class="mb-3 text-primary">Data Tambahan</h6>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <select id="religionid" name="religionid" class="form-select">
                            <option value="">Select Religion</option>
                            <?php foreach ($religionList as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($employee['religionid']) && $employee['religionid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                        <select required name="bloodtype" class="form-select">
                            <option value="">-- Pilih Golongan Darah --</option>
                            <option value="A" <?= (isset($employee['bloodtype']) && $employee['bloodtype'] == 'A') ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= (isset($employee['bloodtype']) && $employee['bloodtype'] == 'B') ? 'selected' : '' ?>>B</option>
                            <option value="AB" <?= (isset($employee['bloodtype']) && $employee['bloodtype'] == 'AB') ? 'selected' : '' ?>>AB</option>
                            <option value="O" <?= (isset($employee['bloodtype']) && $employee['bloodtype'] == 'O') ? 'selected' : '' ?>>O</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kategori Pajak <span class="text-danger">*</span></label>
                        <select id="taxcategoryid" name="taxcategoryid" class="form-select" required>
                            <option value="">Select Kategori Pajak</option>
                            <?php foreach ($categoryTax as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($employee['taxcategoryid']) && $employee['taxcategoryid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['code'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS Ketenagakerjaan</label>
                        <input type="text" name="bpjstknumber" class="form-control"
                            value="<?= $employee['bpjstknumber'] ?? '' ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">NPWP</label>
                        <input type="text" name="npwp" class="form-control" value="<?= $employee['npwp'] ?? '' ?>"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS Kesehatan</label>
                        <input type="text" name="bpjshealtnumber" class="form-control"
                            value="<?= $employee['bpjshealtnumber'] ?? '' ?>" required>
                    </div>
                </div>
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

        const toastContainer = document.getElementById('toastContainer') || createToastContainer();
        toastContainer.appendChild(toast);

        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();

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

    function saveEmployee(id) {
        const formData = new FormData(document.getElementById('editEmployeeForm'));

        // Jika tambah data baru, id akan kosong
        const isEdit = id && id !== '0';
        const action = isEdit ? 'updateDataEmployeeDetail' : 'createDataEmployeeDetail';

        const saveBtn = document.querySelector('#employeeEditModal .btn-primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        saveBtn.disabled = true;

        fetch('<?= base_url('ControllerHr/') ?>' + action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('employeeEditModal')).hide();
                    showToast(isEdit ? 'Data karyawan berhasil diupdate' : 'Data karyawan berhasil ditambahkan', 'success');
                    if (isEdit) {
                        loadEmployeeData();
                    } else {
                        getNewEmployeeIdAndFilter({
                            employeeId: data.employeeId,
                            employeeName: data.employeeName
                        });
                    }
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