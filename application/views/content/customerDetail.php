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
    $level = $this->session->userdata('level');
    $detail = isset($customerDetail[0]) ? $customerDetail[0] : [];
    ?>

    <div class="row p-3 row">
        <button type="button" class="btn btn-primary btn-sm"
            onclick="updateCustomer(<?= $detail['id'] ?>, <?= $level ?>)"
            style="background-color: #c49e8f; color: black;">UPDATE</button>
        <!-- <a href="https://sys.eudoraclinic.com:84/app/createTransaction" class="btn btn-primary btn-sm ml-2">
            <i class="bi bi-plus-circle"></i> BACK
        </a> -->
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i> DETAIL CUSTOMER
                </h6>
                <div class="form-row">
                    <div class="form-column">
                        <label for="firstname" class="form-label mt-2"><strong>FIRSTNAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="firstname" id="firstname"
                            value="<?= isset($detail['firstname']) ? $detail['firstname'] : '' ?>">

                        <label for="lastname" class="form-label mt-2"><strong>LASTNAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="lastname" id="lastname"
                            value="<?= isset($detail['lastname']) ? $detail['lastname'] : '' ?>">

                        <label for="cellphonenumber" class="form-label mt-2">
                            <strong>CELLPHONENUMBER:</strong><span class="text-danger">*</span>
                        </label>
                        <input type="text" name="cellphonenumber" id="cellphonenumber"
                            value="<?= isset($detail['cellphonenumber']) ? $detail['cellphonenumber'] : '' ?>"
                            <?= (isset($detail['cellphonenumber'])
                                && strtolower($detail['cellphonenumber']) !== 'nan'
                                && $detail['cellphonenumber'] !== ''
                                && $level != 4 
                            ) ? 'disabled' : '' ?> maxlength="14" placeholder="Masukkan nomor HP diawali 08"
                            onkeydown="validateKey(event)" oninput="validateInput(this)">
                        <small class="text-danger" id="error-message"></small>
                    </div>

                    <div class="form-column">
                        <label for="customercode" class="form-label mt-2"><strong>CUSTOMER CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="customercode" id="customercode"
                            value="<?= isset($detail['customercode']) ? $detail['customercode'] : '' ?>">

                        <label for="email" class="form-label mt-2"><strong>EMAIL:</strong></label>
                        <input type="text" name="email" id="email"
                            value="<?= isset($detail['email']) ? $detail['email'] : '' ?>">

                        <label for="googlename" class="form-label mt-2"><strong>GOOGLE ACCOUNT NAME:</strong></label>
                        <input type="text" name="googlename" id="googlename"
                            value="<?= isset($detail['googlename']) ? $detail['googlename'] : '' ?>">
                    </div>
                    <div class="form-column">
                        <label for="ssid" class="form-label mt-2"><strong>SSID:</strong></label>
                        <input type="number" name="ssid" id="ssid"
                            value="<?= isset($detail['ssid']) ? $detail['ssid'] : '' ?>">

                        <label for="dateofbirth" class="form-label mt-2"><strong>DATE OF BIRTH:</strong></label>
                        <input type="date" name="dateofbirth" id="dateofbirth"
                            value="<?= isset($detail['dateofbirth']) ? date('Y-m-d', strtotime($detail['dateofbirth'])) : '' ?>">

                        <label for="linkreview" class="form-label mt-2"><strong>LINK REVIEW:</strong></label>
                        <input type="text" name="linkreview" id="linkreview"
                            value="<?= isset($detail['linkreview']) ? $detail['linkreview'] : '' ?>">

                        <label for="employeeid" class="form-label mt-2"><strong>STAFF ADD LINK:</strong></label>
                        <select id="employeeid" name="employeeid" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($employeeDoing as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['employeeid']) && $detail['employeeid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCustomer(id, level) {
            const firstname = document.getElementById('firstname').value;
            const lastname = document.getElementById('lastname').value;
            const cellphonenumber = document.getElementById('cellphonenumber').value;
            const customercode = document.getElementById('customercode').value;
            const email = document.getElementById('email').value;
            const ssid = document.getElementById('ssid').value;
            const dateofbirth = document.getElementById('dateofbirth').value;
            const googlename = document.getElementById('googlename').value;
            const linkreview = document.getElementById('linkreview').value;
            const employeeid = document.getElementById('employeeid').value;

            console.log(level);



            let hasError = false;
            if (!firstname || !lastname || !cellphonenumber || !customercode) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            // if (level != 4) {
            //     if (!cellphonenumber.startsWith("08")) {
            //         alert('Periksa kembali nomor hp, harus diawali 08')
            //         hasError = true;
            //     }
            // }


            const transactionData = {
                firstname,
                lastname,
                cellphonenumber,
                customercode,
                email,
                ssid,
                dateofbirth,
                googlename,
                linkreview,
                id,
                employeeid
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'App/updateCustomer' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil update data customer');
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