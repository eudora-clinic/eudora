<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Customer Detail</title>

    <style>
        .mycontaine {
            font-size: 12px !important;
        }

        .mycontaine * {
            font-size: inherit !important;
        }

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
        textarea,
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
        textarea:focus,
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

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <?php
    $detail = isset($employeeDetail[0]) ? $employeeDetail[0] : [];
    $db_oriskin = $this->load->database('oriskin', true);
    $listShift = $db_oriskin->query("select * from msshift order by id")->result_array();
    $listCompany = $db_oriskin->query("select * from mscompany order by id")->result_array();

    $level = $this->session->userdata('level');
    ?>

    <div class="row p-3 row">
        <button type="button" class="btn btn-primary btn-sm" onclick="updateEmployee()"
            style="background-color: #c49e8f; color: black;">ADD</button>
        <a href="https://sys.eudoraclinic.com:84/app/listEmployee" class="btn btn-primary btn-sm ml-2">
            <i class="bi bi-plus-circle"></i> BACK
        </a>
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i> ADD EMPLOYEE
                </h6>
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name">

                        <label for="cellphonenumber" class="form-label mt-2">
                            <strong>CELLPHONENUMBER:</strong><span class="text-danger">*</span>
                        </label>
                        <input type="number" name="cellphonenumber" id="cellphonenumber">


                        <label for="nik" class="form-label mt-2">
                            <strong>ID CARD:</strong><span class="text-danger">*</span>
                        </label>
                        <input type="number" name="nik" id="nik">


                        <label for="religionid" class="form-label mt-2"><strong>RELIGION:</strong><span
                                class="text-danger">*</span></label>
                        <select id="religionid" name="religionid" class="" required="true" aria-required="true">
                            <option value="">Select Religion</option>
                            <?php foreach ($religionList as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="address" class="form-label mt-2">
                            <strong>ADDRESS:</strong><span class="text-danger">*</span>
                        </label>
                        <input type="number" name="address" id="address">
                    </div>

                    <div class="form-column">
                        <label for="employeecode" class="form-label mt-2"><strong>EMPLOYEE CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="employeecode" id="employeecode">

                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>

                        <label for="nip" class="form-label mt-2"><strong>NIP:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="nip" id="nip">

                        <label for="startdate" class="form-label mt-2"><strong>JOIN DATE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="startdate" id="startdate">

                        <label for="defaultshiftid" class="form-label mt-2"><strong>DEFAULTSHIFT:</strong><span
                                class="text-danger">*</span></label>
                        <select id="defaultshiftid" name="defaultshiftid" class="" required="true" aria-required="true">
                            <option value="">Select Default Shift</option>
                            <?php foreach ($listShift as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['shiftname'] ?> - <?= $j['shiftcode'] ?> (<?= $j['timein'] ?> -
                                    <?= $j['timeout'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-column">
                        <label for="locationid" class="form-label mt-2"><strong>OUTLET:</strong><span
                                class="text-danger">*</span></label>
                        <select id="locationid" name="locationid" class="" required="true" aria-required="true">
                            <option value="">Select Outlet</option>
                            <?php foreach ($locationListt as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="jobid" class="form-label mt-2"><strong>JOB:</strong><span
                                class="text-danger">*</span></label>
                        <select id="jobid" name="jobid" class="" required="true" aria-required="true" <?= $level == 1 ? 'disabled' : '' ?>>
                            <option value="">Select Job</option>
                            <?php foreach ($jobList as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="placeofbirth" class="form-label mt-2"><strong>PLACE OF BIRTH:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="placeofbirth" id="placeofbirth">

                        <label for="enddate" class="form-label mt-2"><strong>END CONTRACT:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="enddate" id="enddate">

                        <label for="isneedpresensi" class="form-label mt-2"><strong>IS NEED PRESENSI:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isneedpresensi" name="isneedpresensi" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>

                    </div>

                    <div class="form-column">
                        <label for="sallary" class="form-label mt-2"><strong>SALARY:</strong><span
                                class="text-danger">*</span></label>
                        <input type="number" id="sallary" name="sallary" required>

                        <label for="sex" class="form-label mt-2"><strong>GENDER:</strong><span
                                class="text-danger">*</span></label>

                        <select id="sex" name="sex" class="" required="true" aria-required="true">
                            <option value="">Select Gender</option>
                            <option value="F">
                                Female</option>
                            <option value="M">
                                Male</option>
                        </select>

                        <label for="dateofbirth" class="form-label mt-2"><strong>DATE OF BIRTH:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="dateofbirth" id="dateofbirth">


                        <label for="accountnumber" class="form-label mt-2"><strong>ACCOUNT NUMBER:</strong><span
                                class="text-danger">*</span></label>
                        <input type="number" id="accountnumber" name="accountnumber" required>

                        <label for="companyId" class="form-label mt-2"><strong>COMPANY:</strong><span
                                class="text-danger">*</span></label>
                        <select id="companyId" name="companyId" class="" required="true" aria-required="true">
                            <option value="">Select Company</option>
                            <?php foreach ($listCompany as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['companyname'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateEmployee(id) {
            const locationid = document.getElementById('locationid').value;
            const jobid = document.getElementById('jobid').value;
            const isactive = document.getElementById('isactive').value;
            const cellphonenumber = document.getElementById('cellphonenumber').value;
            const name = document.getElementById('name').value;
            const employeecode = document.getElementById('employeecode').value;

            const nik = document.getElementById('nik').value;
            const religionid = document.getElementById('religionid').value;
            const nip = document.getElementById('nip').value;
            const startdate = document.getElementById('startdate').value;
            const placeofbirth = document.getElementById('placeofbirth').value;
            const enddate = document.getElementById('enddate').value;
            const sex = document.getElementById('sex').value;
            const dateofbirth = document.getElementById('dateofbirth').value;
            const accountnumber = document.getElementById('accountnumber').value;
            const sallary = document.getElementById('sallary').value;
            const defaultshiftid = document.getElementById('defaultshiftid').value;
            const address = document.getElementById('address').value;
            const isneedpresensi = document.getElementById('isneedpresensi').value;
            const companyId = document.getElementById('companyId').value;



            let hasError = false;
            if (!locationid || !jobid || !name || !defaultshiftid || !isneedpresensi || !companyId) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            const transactionData = {
                locationid,
                jobid,
                isactive,
                startdate,
                name,
                employeecode,
                nik,
                religionid,
                nip,
                startdate,
                placeofbirth,
                enddate,
                sex,
                dateofbirth,
                accountnumber,
                sallary,
                defaultshiftid,
                address,
                isneedpresensi,
                companyId,
                cellphonenumber
            };

            if (hasError) {
                return false;
            }

            console.log(transactionData);
            

            $.ajax({
                url: "<?= base_url() . 'ControllerHr/addEmployee' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                console.log(response);
                
                    try {
                        alert('Berhasil tambah data employee');
                        if (response.status === 'success') {
                            setTimeout(function () {
                                location.reload();
                            }, 200);
                        } else {
                            console.error('Response tidak sesuai yang diharapkan:', response);
                            alert('Terjadi kesalahan saat mengirim data.');
                        }
                    } catch (e) {
                        console.error('JSON parsing error:', e, response);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                },

                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }

        function validateKey(event) {
            let input = event.target;
            let key = event.key;

            // Hanya angka yang diizinkan (kecuali tombol navigasi)
            if (!/^\d$/.test(key) && !["Backspace", "ArrowLeft", "ArrowRight", "Delete"].includes(key)) {
                event.preventDefault();
            }

            // Pastikan input selalu diawali dengan "08"
            if (input.value.length === 0 && key !== "0") {
                event.preventDefault();
            } else if (input.value.length === 1 && key !== "8") {
                event.preventDefault();
            }
        }

        function validateInput(input) {
            let errorMessage = document.getElementById("error-message");

            // Pastikan input selalu mulai dengan "08"
            if (!input.value.startsWith("08")) {
                input.value = "08";
            }

            // Pastikan hanya angka yang diinputkan
            input.value = input.value.replace(/[^0-9]/g, "");

            // Batasi panjang nomor (10-14 digit)
            if (input.value.length > 14) {
                input.value = input.value.slice(0, 14);
            }

            // Tampilkan pesan error jika panjang tidak sesuai
            if (input.value.length < 10) {
                errorMessage.innerText = "Nomor HP minimal 10 digit.";
            } else {
                errorMessage.innerText = "";
            }
        }
    </script>
</body>

</html>