<form id="companyForm" onsubmit="return false;">
    <input type="hidden" name="id" value="<?= isset($companyData['id']) ? $companyData['id'] : '' ?>">

    <div class="row">
        <!-- Kolom 1: Data Perusahaan -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Company Code <span class="text-danger">*</span></label>
                <input type="text" name="companycode" class="form-control"
                    value="<?= isset($companyData['companycode']) ? $companyData['companycode'] : '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                <input type="text" name="companyname" class="form-control"
                    value="<?= isset($companyData['companyname']) ? $companyData['companyname'] : '' ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control"
                    rows="3"><?= isset($companyData['address']) ? $companyData['address'] : '' ?></textarea>
            </div>
        </div>

        <!-- Kolom 2: Data Kontak -->
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                    value="<?= isset($companyData['phone']) ? $companyData['phone'] : '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?= isset($companyData['email']) ? $companyData['email'] : '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" name="website" class="form-control"
                    value="<?= isset($companyData['website']) ? $companyData['website'] : '' ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" name="postalcode" class="form-control"
                    value="<?= isset($companyData['postalcode']) ? $companyData['postalcode'] : '' ?>">
            </div>
        </div>
    </div>

    <!-- Dropdown untuk Country, Province, City -->
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Country <span class="text-danger">*</span></label>
                <select id="countryid" name="countryid" class="form-select select2" required>
                    <option value="">Select Country</option>
                    <?php foreach ($listCountry as $country) { ?>
                        <option value="<?= $country['id'] ?>" <?= (isset($companyData['countryid']) && $companyData['countryid'] == $country['id']) ? 'selected' : '' ?>>
                            <?= $country['countryname'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Province <span class="text-danger">*</span></label>
                <select id="provinceid" name="provinceid" class="form-select select2" required>
                    <option value="">Select Province</option>
                    <!-- Options akan diisi via AJAX -->
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">City <span class="text-danger">*</span></label>
                <select id="cityid" name="cityid" class="form-select select2" required>
                    <option value="">Select City</option>
                    <!-- Options akan diisi via AJAX -->
                </select>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="isactive" class="form-select" required>
                    <option value="1" <?= (isset($companyData['isactive']) && $companyData['isactive'] == 1) ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= (isset($companyData['isactive']) && $companyData['isactive'] == 0) ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <div id="formErrors" class="alert alert-danger d-none mt-3"></div>
</form>

<script>
    (function ($) {
        $('body').on('shown.bs.modal', '#companyModal', function () {
            const $modal = $('#companyModal');
            $modal.find('.select2').each(function () {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
                $(this).select2({
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true,
                    dropdownParent: $modal
                });
            });
            $modal.off('change', '#countryid').on('change', '#countryid', function () {
                const countryId = $(this).val();
                resetProvinceAndCity($modal);

                if (countryId) {
                    loadProvinces(countryId, '', '', $modal);
                }
            });

            $modal.off('change', '#provinceid').on('change', '#provinceid', function () {
                const provinceId = $(this).val();
                resetCity($modal);

                if (provinceId) {
                    loadCities(provinceId, '', $modal);
                }
            });

            const initialCountry = $modal.find('#countryid').val();
            const initialProvince = '<?= isset($companyData['provinceid']) ? $companyData['provinceid'] : '' ?>';
            const initialCity = '<?= isset($companyData['cityid']) ? $companyData['cityid'] : '' ?>';

            if (initialCountry) {
                $modal.find('#countryid').prop('disabled', false).trigger('change.select2');
                loadProvinces(initialCountry, initialProvince, initialCity, $modal);
            } else {
                $modal.find('#provinceid').prop('disabled', true).html('<option value="">Select Province</option>').trigger('change.select2');
                $modal.find('#cityid').prop('disabled', true).html('<option value="">Select City</option>').trigger('change.select2');
            }
        });

        // Hapus modal dari DOM saat di-hide untuk mencegah duplikasi
        $('body').on('hidden.bs.modal', '#companyModal', function () {
            $(this).remove();
        });

        function resetProvinceAndCity($modal) {
            $modal.find('#provinceid').val('').prop('disabled', true).html('<option value="">Select Province</option>').trigger('change.select2');
            resetCity($modal);
        }

        function resetCity($modal) {
            $modal.find('#cityid').val('').prop('disabled', true).html('<option value="">Select City</option>').trigger('change.select2');
        }

        function loadProvinces(countryId, selectedProvinceId = '', selectedCityId = '', $modal) {
            console.log('loadProvinces -> countryId:', countryId);
            const $province = $modal.find('#provinceid');
            $province.prop('disabled', true).html('<option value="">Loading provinces...</option>').trigger('change.select2');

            $.ajax({
                url: '<?= base_url('ControllerCompany/getProvincesByCountry/') ?>' + countryId,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    console.log('Provinces response:', res);
                    let options = '<option value="">Select Province</option>';
                    if (res && res.success && Array.isArray(res.data) && res.data.length) {
                        res.data.forEach(function (p) {
                            const sel = (p.id == selectedProvinceId) ? 'selected' : '';
                            options += `<option value="${p.id}" ${sel}>${p.name}</option>`;
                        });
                        $province.html(options).prop('disabled', false).trigger('change.select2');

                        // jika ada selectedProvinceId, load cities untuk provinsi tersebut
                        if (selectedProvinceId) {
                            loadCities(selectedProvinceId, selectedCityId, $modal);
                        } else {
                            // reset city kalau nggak ada selected province
                            resetCity($modal);
                        }
                    } else {
                        $province.html('<option value="">No provinces found</option>').prop('disabled', true).trigger('change.select2');
                        resetCity($modal);
                    }
                },
                error: function (xhr, status, err) {
                    console.error('Error loading provinces:', err);
                    $province.html('<option value="">Error loading provinces</option>').prop('disabled', true).trigger('change.select2');
                    resetCity($modal);
                }
            });
        }

        function loadCities(provinceId, selectedCityId = '', $modal) {
            console.log('loadCities -> provinceId:', provinceId);
            const $city = $modal.find('#cityid');
            $city.prop('disabled', true).html('<option value="">Loading cities...</option>').trigger('change.select2');

            $.ajax({
                url: '<?= base_url('ControllerCompany/getCitiesByProvince/') ?>' + provinceId,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    console.log('Cities response:', res);
                    let options = '<option value="">Select City</option>';
                    if (res && res.success && Array.isArray(res.data) && res.data.length) {
                        res.data.forEach(function (c) {
                            const sel = (c.id == selectedCityId) ? 'selected' : '';
                            options += `<option value="${c.id}" ${sel}>${c.name}</option>`;
                        });
                        $city.html(options).prop('disabled', false).trigger('change.select2');
                    } else {
                        $city.html('<option value="">No cities found</option>').prop('disabled', true).trigger('change.select2');
                    }
                },
                error: function (xhr, status, err) {
                    console.error('Error loading cities:', err);
                    $city.html('<option value="">Error loading cities</option>').prop('disabled', true).trigger('change.select2');
                }
            });
        }

        // Save company — dipanggil dari tombol footer modal (onclick="saveCompany()")
        window.saveCompany = function () {
            const $modal = $('#companyModal');
            const form = $modal.find('#companyForm')[0];
            if (!form) {
                console.error('companyForm not found!');
                return;
            }

            const formData = new FormData(form);
            const id = formData.get('id');
            const url = id ? '<?= base_url('ControllerCompany/updateCompany') ?>' : '<?= base_url('ControllerCompany/createCompany') ?>';

            const $saveBtn = $modal.find('.btn-primary').first();
            const originalHtml = $saveBtn.html();
            $saveBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

            fetch(url, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            })
                .then(resp => resp.json())
                .then(json => {
                    console.log('save response:', json);
                    if (json.success) {
                        showToast(json.message || 'Data berhasil disimpan', 'success');
                        $modal.modal('hide');
                        if (typeof fetchData === 'function') {
                            fetchData();
                        }
                    } else {
                        if (json.errors && typeof json.errors === 'object') {
                            showFormErrors(json.errors);
                        } else {
                            showFormErrors({ general: json.message || 'Gagal menyimpan data' });
                        }
                    }
                })
                .catch(err => {
                    console.error('Save error:', err);
                    showFormErrors({ general: 'Terjadi kesalahan saat menyimpan data' });
                })
                .finally(() => {
                    $saveBtn.prop('disabled', false).html(originalHtml);
                });
        };

        function showFormErrors(errors) {
            const $modal = $('#companyModal');
            const $err = $modal.find('#formErrors');
            if (!errors || Object.keys(errors).length === 0) {
                $err.addClass('d-none').html('');
                return;
            }
            let html = '<ul class="mb-0">';
            Object.keys(errors).forEach(function (k) {
                html += `<li>${errors[k]}</li>`;
            });
            html += '</ul>';
            $err.removeClass('d-none').html(html);
        }

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

    })(jQuery);
</script>