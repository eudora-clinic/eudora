<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Service Detail</title>

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

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        .servicename {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .servicename:focus {
            border-color: #3f51b5;
            outline: none;
            background-color: #fff;
        }

        input:invalid {
            border-color: red !important;
        }


        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="submitLocationForm()"
            style="background-color: #c49e8f; color: black;">CREATE</button>
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" maxlength="3">
                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="cityid" class="form-label mt-2"><strong>CITY:</strong><span
                                class="text-danger">*</span></label>
                        <select id="city" class="form-control city" required>


                        </select>
                        <input type="text" name="cityid" id="cityid" hidden>

                        <input type="text" name="userid" id="userid" value="<?= $userid ?>" hidden>

                        <label for="address" class="form-label mt-2"><strong>ADDRESS:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="address" id="address">
                    </div>

                    <div class="form-column">
                        <label for="companyname" class="form-label mt-2"><strong>COMPANY NAME:</strong></label>
                        <input type="text" name="companyname" id="companyname">

                        <label for="mobilephone" class="form-label mt-2"><strong>MOBILEPHONE:</strong></label>
                        <input type="text" name="mobilephone" id="mobilephone">

                        <label for="shortname" class="form-label mt-2"><strong>SHORTNAME:</strong></label>
                        <input type="text" name="shortname" id="shortname">

                        <label for="operationalTime" class="form-label mt-2"><strong>OPERATIONAL TIME:</strong></label>
                        <input type="text" name="operationalTime" id="operationalTime" placeholder="ex 10:00 - 22:00">

                        <label for="image" class="form-label mt-2">
                            <strong>OUTLET IMAGES:</strong>
                        </label>

                        <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple
                            onchange="appendMultipleFiles(event)" />

                        <div id="preview-container"
                            style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px;"></div>


                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        let selectedFiles = [];

        function appendMultipleFiles(event) {
            const newFiles = Array.from(event.target.files);
            selectedFiles = [...selectedFiles, ...newFiles]; // Gabungkan file baru

            console.log(selectedFiles);
            

            renderPreview();
        }

        function renderPreview() {
            const previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '120px';
                    img.style.maxHeight = '120px';
                    img.style.border = '1px solid #ccc';
                    img.style.padding = '4px';
                    img.style.borderRadius = '6px';
                    img.style.marginRight = '10px';

                    const btn = document.createElement('button');
                    btn.innerHTML = '✖';
                    btn.type = 'button';
                    btn.style.position = 'absolute';
                    btn.style.top = '0';
                    btn.style.right = '0';
                    btn.style.background = 'rgba(0,0,0,0.6)';
                    btn.style.color = '#fff';
                    btn.style.border = 'none';
                    btn.style.borderRadius = '0 6px 0 6px';
                    btn.style.cursor = 'pointer';
                    btn.onclick = function () {
                        removeImage(index);
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    previewContainer.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1); // Hapus dari array
            renderPreview(); // Tampilkan ulang preview
        }

        // Jika kamu ingin mengakses selectedFiles saat submit form:
        // const formData = new FormData();
        // selectedFiles.forEach(file => formData.append('images[]', file));
    </script>




    <script>
        function submitLocationForm() {
            const requiredFields = [
                'name', 'code', 'isactive', 'cityid', 'address',
                'companyname', 'mobilephone', 'shortname', 'operationalTime', 'userid'
            ];

            let hasError = false;

            requiredFields.forEach((field) => {
                const value = document.getElementById(field)?.value?.trim();
                if (!value) {
                    hasError = true;
                    document.getElementById(field).style.borderColor = 'red';
                } else {
                    document.getElementById(field).style.borderColor = '#ccc';
                }
            });

            // Validasi gambar
            // const imageInput = document.getElementById('image');
            // if (!imageInput.files || imageInput.files.length === 0) {
            //     hasError = true;
            //     alert('Wajib upload gambar outlet!');
            //     return;
            // }

            if (hasError) {
                alert('Semua kolom wajib diisi!');
                return;
            }

            const formData = new FormData();
            requiredFields.forEach((field) => {
                formData.append(field, document.getElementById(field).value);
            });
            // formData.append('image', imageInput.files[0]);

            console.log(formData);


            $.ajax({
                url: "<?= base_url() . 'ControllerApiApps/insertLocation' ?>",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);

                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert('Berhasil menambahkan lokasi');
                            location.reload();
                        } else {
                            alert('Gagal: ' + res.message);
                        }
                    } catch (err) {
                        alert('Kesalahan saat parsing respons dari server');
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat menyimpan data');
                }
            });
        }
    </script>



    <script>
        $(document).ready(function () {

            $("#city").select2({
                width: '100%',
                ajax: {
                    url: "App/searchCity", // Panggil controller Customer
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

            $("#city").on("select2:select", function (e) {
                let data = e.params.data;
                $("#cityid").val(data.id);
            });
        });
    </script>
</body>

</html>