<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    .btn-primary {
        background-color: #e0bfb2 !important;
        color: #666666 !important;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #d4a995 !important;
    }

    .table-wrapper {
        margin-top: 20px;
        overflow-x: auto;
    }

    th,
    td {
        text-align: center;
        vertical-align: middle;
    }

    select.form-select {
        border-radius: 8px;
        padding: 10px;
    }

    .form-control {
        border-radius: 8px;
        padding: 8px;
        font-size: 14px;
    }

    .hidden {
        display: none;
    }

    .input-group-text {
        background-color: #e9ecef;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }

    .jumlah-input {
        text-align: center;
    }

    .remove-btn {
        color: #fff !important;
        background-color: #dc3545 !important;
        border: none;
        transition: 0.3s ease;
    }

    .remove-btn:hover {
        background-color: #c82333 !important;
        box-shadow: 0px 2px 6px rgba(220, 53, 69, 0.5);
    }

    .use-btn {
        color: #fff;
        background-color: #007bff;
        border: none;
        transition: 0.3s ease;
    }

    .use-btn:hover {
        background-color: #0056b3;
        box-shadow: 0px 2px 6px rgba(0, 123, 255, 0.5);
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
        color: #333;
    }

    /* Menambahkan efek fokus pada input dan dropdown */
    input[type="text"]:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Styling untuk dropdown */
    select {
        background-color: #f9f9f9;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    select:hover {
        background-color: #f1f1f1;
    }

    /* Styling untuk option dalam dropdown */
    option {
        padding: 10px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-column {
        flex: 1;
        min-width: 250px;
        box-sizing: border-box;
    }

    .mycontainer {
        font-size: 14px !important;
    }

    /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
    .mycontainer * {
        font-size: inherit !important;
    }

    /* --- SELECT2 FULL WIDTH + HEIGHT RAPI --- */
    .select2-container {
        width: 100% !important;
    }

    /* Perbaikan layout form */
    .form-section {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .employee-search-container {
        margin-bottom: 20px;
    }

    @media (min-width: 992px) {
        .mycontainer {
            width: 100%;
            transform: none;
        }
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .form-column {
            min-width: 100%;
        }
    }
</style>

<form id="uncertainAllowanceForm" onsubmit="return false;">
    <input type="hidden" name="id" value="<?= $allowanceUncertain['id'] ?? '' ?>">
    <input type="hidden" name="employeeid" id="employeeid" value="<?= $allowanceUncertain['employeeid'] ?? '' ?>">
    <input type="hidden" name="employeecompanyid" id="employeecompanyid"
        value="<?= $allowanceUncertain['employeecompanyid'] ?? '' ?>">
    <input type="hidden" name="companyid" id="companyid" value="<?= $allowanceUncertain['companyid'] ?? '' ?>">
    <input type="hidden" name="payrollid" id="payrollid" value="<?= $allowanceUncertain['payrollid'] ?? '' ?>">
    <input type="hidden" name="month" id="month" value="<?= $month ?? '' ?>">

    <div class="form-section">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Jenis Tunjangan <span class="text-danger">*</span></label>
                    <select id="allowanceid" name="allowanceid" class="form-control" required>
                        <option value="">Select Jenis Tunjangan</option>
                        <?php foreach ($allowancetype as $type) { ?>
                            <option value="<?= $type['id'] ?>" <?= (isset($allowanceUncertain['allowanceid']) && $allowanceUncertain['allowanceid'] == $type['id'] ? 'selected' : '') ?>
                                data-isactive="<?= $type['isactive'] ?>">
                                <?= $type['allowance_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Tunjangan <span class="text-danger">*</span></label>
                    <input type="text" name="amount" class="form-control"
                        value="<?= isset($allowanceUncertain['amount']) ? number_format($allowanceUncertain['amount'], 0, ',', '.') : '' ?>"
                        required oninput="formatRupiah(this)" placeholder="Masukkan jumlah tunjangan">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="4"><?= $allowanceUncertain['description'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="filterMonthForm" class="form-label"><strong>Bulan</strong></label>
                    <input type="month" id="filterMonthForm" class="form-control" value="<?= $month ?>" disabled
                        readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="employee-search-container">
                    <label for="employeeSearch" class="form-label">Employee <span class="text-danger">*</span></label>
                    <select id="employeeSearch" required data-placeholder="Search Employee"
                        class="form-control"></select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Perusahaan</label>
                    <input type="text" id="companyName" class="form-control" readonly
                        value="<?= $allowanceUncertain['companyname'] ?>">
                    <small class="text-muted">Perusahaan pemberi tunjangan</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Aktif <span class="text-danger">*</span></label>
                    <select name="isactive" class="form-control" required="true" aria-required="true">
                        <option value="1" <?= (isset($allowanceUncertain['isactive']) && $allowanceUncertain['isactive'] == 1) ? 'selected' : 'selected' ?>>Aktif</option>
                        <option value="0" <?= (isset($allowanceUncertain['isactive']) && $allowanceUncertain['isactive'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
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
        // sederhana: gunakan alert bila belum ada toast library
        // kamu bisa ganti ke SweetAlert atau bootstrap toast
        if (type === 'success') {
            // jika mau: gunakan toastr/sweetalert
            alert(message);
        } else {
            alert(message);
        }
    }
    $(document).ready(function () {
        let isEdit = $("input[name='id']").val() !== "";

        if (isEdit) {
            let employeeId = $("#employeeid").val();
            let employeeName = "<?= $allowanceUncertain['employeename'] ?? '' ?>";

            if (employeeId && employeeName) {
                let option = new Option(employeeName, employeeId, true, true);
                $("#employeeSearch").append(option).trigger("change");
            }
            $("#employeeSearch").prop("disabled", true);
            $("#companyName").prop("readonly", true).addClass("bg-light");
            $("#employeeid").prop("readonly", true);
            $("#employeecompanyid").prop("readonly", true);
            $("#companyid").prop("readonly", true);
            $("#payrollid").prop("readonly", true);
            $("#filterMonthForm").prop("disabled", true).prop("readonly", true);
        }

        $("#employeeSearch").select2({
            width: '100%',
            placeholder: "Search Employee",
            dropdownParent: $("#uncertainAllowanceModal"),
            ajax: {
                url: "ControllerHr/searchEmployeeForUncertainAllowance",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#employeeSearch").on("select2:select", function (e) {
            let data = e.params.data;

            console.log(data.data);
            
            $("#employeeid").val(data.data.id);
            $("#companyName").val(data.data.companyname);
            $("#employeecompanyid").val(data.data.employeecompanyid);
            $("#companyid").val(data.data.companyidemployee);
            $("#payrollid").val(data.data.payrollid);
        });
    });

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

    function saveAllowance() {
        const formData = new FormData(document.getElementById('uncertainAllowanceForm'));
        const amountInput = document.querySelector('input[name="amount"]');
        const amountValue = amountInput.value.replace(/[^0-9]/g, "");
        formData.set('amount', amountValue);

        if (parseFloat(amountValue) === 0) {
            showFormErrors({ amount: 'Jumlah tunjangan tidak boleh 0' });
            return;
        }

        const saveBtn = document.querySelector('#uncertainAllowanceModal .btn-primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        saveBtn.disabled = true;

        console.log('Data yang akan dikirim:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        const $modal = $('#uncertainAllowanceModal');


        fetch('<?= base_url('ControllerHr/saveEmployeeAllowanceUncertain') ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    $modal.modal('hide');
                    showToast('Data tunjangan berhasil disimpan', 'success');
                    loadSummary(true);
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
        const errorContainer = document.getElementById('formErrors');
        errorContainer.innerHTML = '';

        if (Object.keys(errors).length > 0) {
            errorContainer.classList.remove('d-none');
            for (const [field, message] of Object.entries(errors)) {
                const errorItem = document.createElement('div');
                errorItem.textContent = message;
                errorContainer.appendChild(errorItem);
            }
        } else {
            errorContainer.classList.add('d-none');
        }
    }
</script>