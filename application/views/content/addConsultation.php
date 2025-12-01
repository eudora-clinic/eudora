<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* .mycontaine {
            font-size: 12px !important;
        }

        .mycontaine * {
            font-size: inherit !important;
        } */

        /* Styling untuk form row dan column */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
            /* Biar responsif */
        }

        /* Label styling */
        .form-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        /* Input dan Select styling */
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Styling untuk textarea */
        textarea {
            resize: vertical;
            /* Bisa diubah ukurannya */
            min-height: 100px;
        }

        /* Styling untuk select dropdown */
        select {
            background: #fff;
            cursor: pointer;
        }

        /* Untuk tombol disabled */
        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        .form-check-label {
            font-weight: normal;
        }

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="mycontaine">

        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <label for="consulted_employee_id" class="form-label mt-2"><strong>
                        Konsultasi Oleh / Consultation By:</strong><span class="text-danger">*</span></label>
                <select id="consulted_employee_id" name="consulted_employee_id" required="true" aria-required="true">
                    <?php foreach ($doctor as $j) { ?>
                        <option value="<?= $j['id'] ?>">
                            <?= $j['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <p style="font-size: 20px !important; font-weight: bold; text-transform: uppercase">Informasi Pasien /
                    Patient Information</p>
                <hr>
                <div class="form-group">
                    <label for="name" class="form-label mt-2"><strong>Nama / Name:</strong><span
                            class="text-danger">*</span></label>
                    <select id="customerIdConsultation" class="customerIdConsultation" required
                        data-placeholder="Cari nama pasien"></select>
                </div>
                <div class="form-row mb-3">
                    <div class="form-column">
                        <label for="birthdate" class="form-label mt-2"><strong>Tempat, Tanggal Lahir/
                                Place, Date of Birth:</strong><span class="text-danger">*</span></label>
                        <input type="date" name="birthdate" id="birthdate">

                        <label for="nettIncome" class="form-label mt-2"><strong>
                                Pendapatan / Nett Income:</strong><span class="text-danger">*</span></label>
                        <!-- <input type="text" name="nettIncome" id="nettIncome"> -->
                        <select id="nettIncome" name="nettIncome" required="true" aria-required="true">
                            <option value="">-- Pilih Nett income --</option>
                            <?php foreach ($nettincome as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="ssid" class="form-label mt-2"><strong>
                                No. KTP/ ID Number:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="ssid" id="ssid">
                    </div>

                    <div class="form-column">
                        <label for="address" class="form-label mt-2"><strong>Alamat/ Address:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="address" id="address">

                        <label for="occupation" class="form-label mt-2"><strong>Pekerjaan/ Occupied
                                :</strong><span class="text-danger">*</span></label>

                        <select id="occupation" name="occupation" required="true" aria-required="true">
                            <option value="">-- Pilih pekerjaan --</option>
                            <?php foreach ($occupied as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="gender" class="form-label mt-2"><strong>Jenis kelamin/ Gender:</strong><span
                                class="text-danger">*</span></label>
                        <select id="gender" name="gender" class="" required="true" aria-required="true">
                            <option value="F">Wanita / Female</option>
                            <option value="M">Pria / Male</option>
                        </select>
                    </div>
                </div>
                <label for="advertising" class="form-label mt-2"><strong>Dari mana anda mengetahui Eudora Aesthetic
                        Clinic?/ How did you know about Eudora Aesthetic Clinic?
                        :</strong><span class="text-danger">*</span></label>
                <div class="row mx-5">
                    <?php foreach ($advtracking as $item): ?>
                        <div class="col-md-2">
                            <label>
                                <input class="form-check-input disabled" type="radio" name="advertising"
                                    value="<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>


                <label for="skincare_used" class="form-label mt-2"><strong>Skincare apa yang anda gunakan saat ini?/
                        What skincare products are you currently using?
                        :</strong><span class="text-danger">*</span></label>
                <div class="row mx-5">
                    <?php foreach ($skincare as $item): ?>
                        <div class="col-md-2">
                            <label>
                                <input class="form-check-input skincare-check" type="checkbox" name="skincare_used[]"
                                    value="<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <label for="brandskincare" class="form-label mt-2"><strong>Merk/Brand
                        :</strong><span class="text-danger">*</span></label>
                <input type="text" name="brandskincare" id="brandskincare" disabled>

                <label for="discussion_expectation" class="form-label mt-2"><strong>Apa yang anda harapkan dan
                        diskusikan dengan Dokter kami?What do you hope and discuss with our Doctor?
                        :</strong><span class="text-danger">*</span></label>
                <textarea name="discussion_expectation" id="discussion_expectation" rows="4"
                    class="form-control"></textarea>
            </div>
        </div>

        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <p style="font-size: 20px !important; font-weight: bold;">RIWAYAT PASIEN / PATIENT HISTORY</p>
                <hr>
                <label for="has_done_treatment" class="form-label mt-2"><strong>1. Apakah anda pernah melakukan
                        treatment?/ Have you ever done treatment?</strong><span class="text-danger">*</span></label>
                <select id="has_done_treatment" name="has_done_treatment" class="" required="true" aria-required="true">
                    <option value="0">Tidak / No</option>
                    <option value="1">Ya / Yes</option>
                </select>

                <div id="pastTreatmentContainer" class="mt-3" style="display: none;">
                    <label for="pasttreatmentid" class="form-label mt-2">
                        <strong>Jika YA. perawatan apa yang anda lakukan?/ If Yes, what kind of treatment?</strong>
                        <span class="text-danger">*</span>
                    </label>
                    <div class="row mx-5">
                        <?php foreach ($pasttreatment as $item): ?>
                            <div class="col-md-2">
                                <label>
                                    <input type="checkbox" name="pasttreatmentid[]" value="<?= $item['id'] ?>">
                                    <?= htmlspecialchars($item['name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <label for="is_pregnant" class="form-label mt-2"><strong>2. Apakah anda dalam keadaan hamil? / Are you
                        pregnant?</strong><span class="text-danger">*</span></label>
                <select id="is_pregnant" name="is_pregnant" class="" required="true" aria-required="true">
                    <option value="0">Tidak / No</option>
                    <option value="1">Ya / Yes</option>
                </select>
                <label for="is_allergic" class="form-label mt-2"><strong>3. Apakah anda memiliki alergi terhadap produk
                        atau obat apapun? / Do you have allergic
                        to any product or medication? Jika Ya, tolong sebutkan/If, yes please detail</strong><span
                        class="text-danger">*</span></label>
                <select id="is_allergic" name="is_allergic" class="" required="true" aria-required="true">
                    <option value="0">Tidak / No</option>
                    <option value="1">Ya / Yes</option>
                </select>

                <div id="is_allergic_detail_wrapper" style="display:none;">
                    <label for="detail_is_allergic" class="form-label mt-2"><strong>Detail point 3.
                        </strong><span class="text-danger">*</span></label>
                    <textarea name="detail_is_allergic" id="detail_is_allergic" rows="2"
                        class="form-control"></textarea>
                </div>

                <label for="is_under_medical_treatment" class="form-label mt-2"><strong>4. Apakah saat ini anda dalam
                        perawatan medis?
                        / Are you currently under medical
                        treatment? Jika Ya, tolong sebutkan/ If yes, please detail</strong><span
                        class="text-danger">*</span></label>
                <select id="is_under_medical_treatment" name="is_under_medical_treatment" class="" required="true"
                    aria-required="true">
                    <option value="0">Tidak / No</option>
                    <option value="1">Ya / Yes</option>
                </select>

                <div id="is_under_medical_treatment_wrapper" style="display:none;">
                    <label for="detail_is_under_medical_treatment" class="form-label mt-2"><strong>Detail point 4.
                        </strong><span class="text-danger">*</span></label>
                    <textarea name="detail_is_under_medical_treatment" id="detail_is_under_medical_treatment" rows="2"
                        class="form-control"></textarea>
                </div>
            </div>
        </div>


        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <p style="font-size: 20px !important; font-weight: bold;">KONDISI KULIT/SKIN CONDITION</p>
                <hr>
                <div class="row mx-5">
                    <?php foreach ($skincondition as $item): ?>
                        <div class="col-md-2">
                            <label>
                                <input type="checkbox" name="skincondition[]" value="<?= $item['id'] ?>">
                                <?= htmlspecialchars($item['name']) ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <label for="note" class="form-label mt-2"><strong>CATATAN/ NOTES</strong><span
                        class="text-danger">*</span></label>
                <textarea name="note" id="note" rows="2" class="form-control"></textarea>

                <button type="button" id="submitFormConsultation" class="btn btn-primary mt-4">Simpan</button>

            </div>
        </div>

    </div>
    <script>

        $(document).ready(function () {
            $("#customerIdConsultation").select2({
                width: '100%',
                ajax: {
                    url: "App/searchCustomerConsultation",
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

            $("#customerIdConsultation").on("select2:select", function (e) {
                let data = e.params.data;

                console.log(data.data);


                const dateofbirth = new Date(data?.data.dateofbirth);
                const formatteddateofbirth = dateofbirth.toISOString().split('T')[0];

                const address = data.data.address ? data.data.address : '-'

                $("#birthdate").val(formatteddateofbirth);
                $("#address").val(address);
                $("#gender").val(data.data.sex);
                $("#ssid").val(data.data.ssid);
                $('input[name="advertising"][value="' + data.data.guestlogadvtrackingid + '"]').prop('checked', true);
                $("#nettIncome").val(data.data.nettincomeid);
                $("#occupation").val(data.data.occupiedid);
            });
        });
    </script>

    <script>
        const checkboxes = document.querySelectorAll('.skincare-check');
        const brandInput = document.getElementById('brandskincare');

        function updateBrandField() {
            let anyChecked = false;
            checkboxes.forEach(cb => {
                if (cb.checked) anyChecked = true;
            });

            if (anyChecked) {
                brandInput.disabled = false;
                brandInput.setAttribute('required', true);
            } else {
                brandInput.disabled = true;
                brandInput.removeAttribute('required');
                brandInput.value = '';
            }
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateBrandField));

        document.addEventListener('DOMContentLoaded', function () {
            const selectElement = document.getElementById('has_done_treatment');
            const treatmentBox = document.getElementById('pastTreatmentContainer');

            function toggleTreatmentBox() {
                if (selectElement.value === '1') {
                    treatmentBox.style.display = 'block';
                } else {
                    treatmentBox.style.display = 'none';

                    // Uncheck all checkboxes if 'No' selected
                    treatmentBox.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                }
            }

            // Initial check in case form is repopulated
            toggleTreatmentBox();

            // Bind change event
            selectElement.addEventListener('change', toggleTreatmentBox);
        });

        $(document).ready(function () {
            $('#is_allergic').on('change', function () {
                if ($(this).val() == '1') {
                    $('#is_allergic_detail_wrapper').slideDown();
                } else {
                    $('#is_allergic_detail_wrapper').slideUp();
                    $('#detail_is_allergic').val('');
                }
            });

            $('#is_under_medical_treatment').on('change', function () {
                if ($(this).val() == '1') {
                    $('#is_under_medical_treatment_wrapper').slideDown();
                } else {
                    $('#is_under_medical_treatment_wrapper').slideUp();
                    $('#detail_is_under_medical_treatment').val('');
                }
            });
        });

    </script>

    <script>
        $("#submitFormConsultation").on("click", function (e) {
            e.preventDefault();

            // Ambil semua data dari form
            const formData = {
                customer_id: $("#customerIdConsultation").val(),
                birthdate: $("#birthdate").val(),
                nettIncome: $("#nettIncome").val(),
                ssid: $("#ssid").val(),
                address: $("#address").val(),
                consulted_employee_id: $("#consulted_employee_id").val(),
                occupation: $("#occupation").val(),
                gender: $("#gender").val(),
                advertising: $("input[name='advertising']:checked").val(),
                skincare_used: $("input[name='skincare_used[]']:checked").map(function () {
                    return this.value;
                }).get(),
                brandskincare: $("#brandskincare").val(),
                discussion_expectation: $("#discussion_expectation").val(),

                has_done_treatment: $("#has_done_treatment").val(),
                pasttreatmentid: $("input[name='pasttreatmentid[]']:checked").map(function () {
                    return this.value;
                }).get(),

                is_pregnant: $("#is_pregnant").val(),
                is_allergic: $("#is_allergic").val(),
                detail_is_allergic: $("#detail_is_allergic").val(),
                is_under_medical_treatment: $("#is_under_medical_treatment").val(),
                detail_is_under_medical_treatment: $("#detail_is_under_medical_treatment").val(),

                skincondition: $("input[name='skincondition[]']:checked").map(function () {
                    return this.value;
                }).get(),
                note: $("#note").val()
            };

            if (!formData.customer_id || formData.customer_id.trim() === "") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Customer wajib dipilih terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!formData.skincondition || formData.skincondition.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Harap pilih minimal satu kondisi kulit (skin condition).',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (formData.has_done_treatment == "1") {
                if (!formData.pasttreatmentid || formData.pasttreatmentid.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Karena Anda pernah melakukan treatment, harap pilih minimal satu jenis treatment.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            if (formData.is_allergic == "1") {
                if (!formData.detail_is_allergic || formData.detail_is_allergic === "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Jelaskan allergi anda.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            if (formData.is_under_medical_treatment == "1") {
                if (!formData.detail_is_under_medical_treatment || formData.detail_is_under_medical_treatment === "") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Jelaskan perawatan medis anda.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            }

            console.log(formData);





            $.ajax({
                url: "<?= base_url('App/saveConsultation') ?>", // Ganti dengan URL controller-mu
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data konsultasi berhasil disimpan.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result) {
                                window.open("<?= base_url('app/printConsultationResult/') ?>" + response.id, '_blank');
                                location.reload();
                            }
                        });
                    } else {
                        alert("Gagal menyimpan: " + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan saat mengirim data.");
                }
            });
        });
    </script>

</body>

</html>