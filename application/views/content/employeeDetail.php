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
    $allowance_type = $db_oriskin->query("select * from msallowancetype order by id")->result_array();
    $listShift = $db_oriskin->query("select * from msshift order by id")->result_array();
    $deduction_type = $db_oriskin->query("select * from mssalarydeductiontype order by id")->result_array();
    $allowance = $db_oriskin->query("select a.id, b.allowance_name, a.amount from msallowance a inner join msallowancetype b ON a.allowancetypeid = b.id 
    where employeeid= ? AND a.isactive = 1", $detail['HDRID'])->result_array();
    $level = $this->session->userdata('level');
    $listCompany = $db_oriskin->query("select * from mscompany order by id")->result_array();
    ?>

    <div class="row p-3">
        <button type="button" class="btn btn-primary btn-md"
            onclick="updateEmployee(<?= $detail['HDRID'] ?>)">UPDATE</button>
        <a href="https://sys.eudoraclinic.com:84/app/listEmployee" class="btn btn-primary btn-md">
            <i class="bi bi-plus-circle"></i> BACK
        </a>
    </div>

    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i>Data Pribadi
                </h6>
                <div class="form-row">
                    <input type="text" name="employeeid" id="employeeid" value="<?= $detail['HDRID'] ?>" hidden>
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            value="<?= isset($detail['NAME']) ? $detail['NAME'] : '' ?>">

                        <label for="cellphonenumber" class="form-label mt-2">
                            <strong>CELLPHONENUMBER:</strong><span class="text-danger">*</span>
                        </label>
                        <input value="<?= isset($detail['CELLPHONENUMBER']) ? $detail['CELLPHONENUMBER'] : '' ?>"
                            type="number" name="cellphonenumber" id="cellphonenumber">
                        <small class="text-danger" id="error-message"></small>

                        <label for="nik" class="form-label mt-2">
                            <strong>ID CARD:</strong><span class="text-danger">*</span>
                        </label>
                        <input value="<?= isset($detail['nik']) ? $detail['nik'] : '' ?>" type="number" name="nik"
                            id="nik">
                        <label for="religionid" class="form-label mt-2"><strong>RELIGION:</strong><span
                                class="text-danger">*</span></label>
                        <select id="religionid" name="religionid" class="" required="true" aria-required="true">
                            <option value="">Select Religion</option>
                            <?php foreach ($religionList as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['religionid']) && $detail['religionid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-column">
                        <label for="sex" class="form-label mt-2"><strong>GENDER:</strong><span
                                class="text-danger">*</span></label>

                        <select id="sex" name="sex" class="" required="true" aria-required="true">
                            <option value="">Select Gender</option>
                            <option value="F" <?= isset($detail['sex']) && $detail['sex'] == 'F' ? 'selected' : '' ?>>
                                Female</option>
                            <option value="M" <?= isset($detail['sex']) && $detail['sex'] == 'M' ? 'selected' : '' ?>>
                                Male</option>
                        </select>

                        <label for="placeofbirth" class="form-label mt-2"><strong>PLACE OF BIRTH:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="placeofbirth" id="placeofbirth"
                            value="<?= isset($detail['placeofbirth']) ? $detail['placeofbirth'] : '' ?>">

                        <label for="dateofbirth" class="form-label mt-2"><strong>DATE OF BIRTH:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="dateofbirth" id="dateofbirth"
                            value="<?= isset($detail['dateofbirth']) ? $detail['dateofbirth'] : '' ?>">

                        <label for="accountnumber" class="form-label mt-2"><strong>ACCOUNT NUMBER:</strong><span
                                class="text-danger">*</span></label>
                        <input type="number" id="accountnumber" name="accountnumber"
                            value="<?= isset($detail['accountnumber']) ? $detail['accountnumber'] : '' ?>" required>

                    </div>

                    <div class="form-column">
                        <label for="startdate" class="form-label mt-2"><strong>JOIN DATE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="startdate" id="startdate"
                            value="<?= isset($detail['startdate']) ? $detail['startdate'] : '' ?>">

                        <label for="defaultshiftid" class="form-label mt-2"><strong>DEFAULTSHIFT:</strong><span
                                class="text-danger">*</span></label>
                        <select id="defaultshiftid" name="defaultshiftid" class="" required="true" aria-required="true">
                            <option value="">Select Default Shift</option>
                            <?php foreach ($listShift as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['defaultshiftid']) && $detail['defaultshiftid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['shiftname'] ?> - <?= $j['shiftcode'] ?> (<?= $j['timein'] ?> -
                                    <?= $j['timeout'] ?>)
                                </option>
                            <?php } ?>
                        </select>

                        <label for="address" class="form-label mt-2">
                            <strong>ADDRESS:</strong><span class="text-danger">*</span>
                        </label>
                        <input value="<?= isset($detail['address']) ? $detail['address'] : '' ?>" type="text"
                            name="address" id="address">
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i>Data Kontrak
                </h6>
                <div class="form-row">
                    <div class="form-column">
                        <label for="nip" class="form-label mt-2"><strong>NIP:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="nip" id="nip"
                            value="<?= isset($detail['nip']) ? $detail['nip'] : '' ?>">

                        <label for="startdate" class="form-label mt-2"><strong>JOIN DATE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="startdate" id="startdate"
                            value="<?= isset($detail['startdate']) ? $detail['startdate'] : '' ?>">

                        <label for="defaultshiftid" class="form-label mt-2"><strong>DEFAULTSHIFT:</strong><span
                                class="text-danger">*</span></label>
                        <select id="defaultshiftid" name="defaultshiftid" class="" required="true" aria-required="true">
                            <option value="">Select Default Shift</option>
                            <?php foreach ($listShift as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['defaultshiftid']) && $detail['defaultshiftid'] == $j['id'] ? 'selected' : '') ?>>
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
                            <?php foreach ($locationListt as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['LOCATIONID']) && $detail['LOCATIONID'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="jobid" class="form-label mt-2"><strong>JOB:</strong><span
                                class="text-danger">*</span></label>
                        <select id="jobid" name="jobid" class="" required="true" aria-required="true" <?= $level == 1 ? 'disabled' : '' ?>>
                            <?php foreach ($jobList as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['JOBID']) && $detail['JOBID'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="enddate" class="form-label mt-2"><strong>END CONTRACT:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="enddate" id="enddate"
                            value="<?= isset($detail['enddate']) ? date('Y-m-d', strtotime($detail['enddate'])) : '' ?>">
                    </div>
                    <div class="form-column">
                        <label for="sallary" class="form-label mt-2"><strong>SALARY:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" id="sallary" name="sallary"
                            value="<?= isset($detail['sallary']) ? number_format($detail['sallary'], 0, ',', '.') : '' ?>"
                            required oninput="formatRupiah(this)">

                        <label for="companyId" class="form-label mt-2"><strong>COMPANY:</strong><span
                                class="text-danger">*</span></label>
                        <select id="companyId" name="companyId" class="" required="true" aria-required="true">
                            <option value="">Select Company</option>
                            <?php foreach ($listCompany as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['companyid']) && $detail['companyid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['companyname'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="isneedpresensi" class="form-label mt-2"><strong>IS NEED PRESENSI:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isneedpresensi" name="isneedpresensi" class="" required="true" aria-required="true">
                            <option value="1" <?= isset($detail['isneedpresensi']) && $detail['isneedpresensi'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= isset($detail['isneedpresensi']) && $detail['isneedpresensi'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i> Tunjangan
                </h6>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-2">
                            <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="font-size: 12px; text-align: center;">Tunjangan</th>
                                        <th style="font-size: 12px; text-align: center;">Amount</th>
                                        <th style="font-size: 12px; text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($allowance)): ?>
                                        <?php foreach ($allowance as $item): ?>
                                            <tr>
                                                <td style="font-size: 12px; text-align: center;">
                                                    <?= htmlspecialchars($item['allowance_name']) ?>
                                                </td>
                                                <td style="font-size: 12px; text-align: center;">
                                                    <?= number_format($item['amount'], 0, ',', '.') ?>
                                                </td>
                                                <td style="font-size: 12px; text-align: center;">
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="deleteTunjangan(<?= $item['id'] ?>)">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center;">No items found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-wrapper product-table-wrapper card">
                            <div class="p-4">
                                <div class="items mt-2">
                                    <h6 class="text-secondary mb-2 mt-2">
                                        <i class="bi bi-wallet2"></i> + Tunjangan
                                    </h6>
                                    <table id="tbl-items" class="table table-bordered items-list">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="font-size: 12px; text-align: center;">Tunjangan</th>
                                                <th style="font-size: 12px; text-align: center;">Amount</th>
                                                <th style="font-size: 12px; text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <button class="btn btn-primary btn-sm add-items">
                                            <i class="bi bi-plus-circle"></i> + Tunjangan
                                        </button>

                                        <button class="btn btn-primary btn-sm" onclick="addAllowanceEmployee()">
                                            <i class="bi bi-plus-circle"></i> Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
        function updateEmployee(id) {
            const locationid = document.getElementById('locationid').value;
            const jobid = document.getElementById('jobid').value;
            const name = document.getElementById('name').value;
            const cellphonenumber = document.getElementById('cellphonenumber').value;
            const nik = document.getElementById('nik').value;
            const religionid = document.getElementById('religionid').value;
            const nip = document.getElementById('nip').value;
            const startdate = document.getElementById('startdate').value;
            const placeofbirth = document.getElementById('placeofbirth').value;
            const enddate = document.getElementById('enddate').value;
            const sex = document.getElementById('sex').value;
            const dateofbirth = document.getElementById('dateofbirth').value;
            const accountnumber = document.getElementById('accountnumber').value;
            const sallary = document.getElementById('sallary').value.replace(/[^0-9]/g, "");
            const defaultshiftid = document.getElementById('defaultshiftid').value;
            const address = document.getElementById('address').value;
            const isneedpresensi = document.getElementById('isneedpresensi').value;
            const companyId = document.getElementById('companyId').value;

            let hasError = false;
            if (!locationid || !jobid || !defaultshiftid || !isneedpresensi || !companyId) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            const transactionData = {
                locationid,
                jobid,
                id,
                name, cellphonenumber,
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
                companyId
            };

            console.log(transactionData);


            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerHr/updateEmployee' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil update data employee');
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const newTable = document.querySelector(".product-table-wrapper");
            newTable.querySelector(".add-items").addEventListener("click", function () {
                const itemList = newTable.querySelector("#tbl-items tbody");
                const itemHtml = `
                                        <tr>
                                            <td style="text-align: center;">
                                                <select class="form-control allowanceid">
                                                </select>
                                            </td>
                                            <td style="text-align: center;">
                                                <input value="0" type="text" class="form-control amountallowance" oninput="formatRupiah(this)">
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger btn-sm remove-items">Delete</button>
                                            </td>
                                        </tr>
                                    `;

                itemList.insertAdjacentHTML("beforeend", itemHtml);
                const lastItems = itemList.lastElementChild;
                const selectElement = $(lastItems).find(".allowanceid");

                selectElement.select2({
                    placeholder: "Pilih Allowance",
                    allowClear: true,
                    width: "100%",
                    ajax: {
                        url: "ControllerMaster/searchAllowance",
                        dataType: "json",
                        delay: 250,
                        data: function (params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name,
                                }))
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });

                selectElement.on("select2:select", function (e) {
                    const selectedData = e.params.data;
                });

                lastItems.querySelector(".remove-items").addEventListener("click", function () {
                    lastItems.remove();
                });
            });
        });


        function deleteTunjangan(id) {

            let hasError = false;
            if (!id) {
                alert('Id tidak ditemukan!');
                hasError = true;
            }

            const transactionData = {
                id,
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerHr/deleteTunjangan' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil menyimpan perubahan');
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


        function addAllowanceEmployee() {
            const employeeid = document.getElementById('employeeid').value;
            let hasError = false;

            if (!employeeid) {
                alert('Id tidak ditemukan!');
                hasError = true;
            }

            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const allowanceid = method.querySelector('.allowanceid').value;
                const amountallowance = method.querySelector('.amountallowance').value.replace(/[^0-9]/g, "");

                if (!allowanceid || !amountallowance) {
                    alert('Silakan lengkapi informasi benefit!');
                    hasError = true;
                }

                itemList.push({
                    allowanceid,
                    amountallowance
                });
            });

            if (itemList.length === 0) {
                alert('Silakan tambah tunjangan!');
                hasError = true;
            }

            const transactionData = {
                employeeid,
                itemList
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerHr/addAllowanceEmployee' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil menyimpan perubahan');
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
        $(document).ready(function () {
            const table = $('#tableDailySales').DataTable({
                pageLength: 100,
                lengthMenu: [5, 10, 15, 20, 25, 100],
                select: true,
                autoWidth: false,
                ordering: false,
                destroy: true,
            });
        });
    </script>

</body>

</html>