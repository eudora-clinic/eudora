<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Package Detail</title>

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

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>

    <?php
        $detail = isset($retailDetail[0]) ? $retailDetail[0] : [];
    ?>

</head>

<body>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="updateRetail(<?= $detail['id'] ?>)" style="background-color: #c49e8f; color: black;">UPDATE</button>
        <a href="https://sys.eudoraclinic.com:84/app/retailList" type="button" class="btn btn-primary" style="background-color: #c49e8f; color: black;">BACK</a>
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="<?= isset($detail['name']) ? $detail['name'] : '' ?>">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" value="<?= isset($detail['code']) ? $detail['code'] : '' ?>">

                         <label for="description" class="form-label mt-2"><strong>DESCRIPTION:</strong><span
                                class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4"
                            placeholder="Masukkan deskripsi"><?= isset($detail['description']) ? $detail['description'] : '' ?></textarea>

                    </div>

                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>APPS NAME:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="apps_name" id="apps_name" value="<?= isset($detail['apps_name']) ? $detail['apps_name'] : '' ?>">
                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1" <?= isset($detail['isactive']) && $detail['isactive'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= isset($detail['isactive']) && $detail['isactive'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                        <label for="price1" class="form-label mt-2"><strong>PRICE:</strong></label>
                        <input type="number" name="price1" id="price1" value="<?= isset($detail['price1']) ? $detail['price1'] : '' ?>">
                    </div>
                </div>
                <div class="row m-2">
                    <label for="image" class="form-label mt-2"><strong>IMAGE:</strong><span class="text-danger">*</span></label>
                    <div class="col-md-12 text-center">
                        <img id="previewImage" src="<?= isset($detail['image']) ? $detail['image'] : '' ?>" alt="Preview" class="img-fluid rounded border mb-2" style="max-height:250px; object-fit:contain;"> 
                        <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        function updateRetail(id) {
            console.log(id);
            
            const name = document.getElementById('name').value;
            const code = document.getElementById('code').value;
            const apps_name = document.getElementById('apps_name').value;
            const isactive = document.getElementById('isactive').value;
            const price1 = document.getElementById('price1').value;
            const description = document.getElementById('description').value;
            const imageFile = document.getElementById('imageInput').files[0];

            let hasError = false;
            if (!name || !code || !isactive || !price1) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            const transactionData = {
                name,
                code,
                isactive,
                price1,
                description,
                id
            };

            let formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append("apps_name", apps_name);
            formData.append("code", code);
            formData.append("description", description);
            formData.append("isactive", isactive);
            formData.append("price1", price1);
            if (imageFile) {
                formData.append("image", imageFile); // hanya dikirim kalau ada file
            }

            // console.log(formData);

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'App/updateRetail' ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",   
                success: function(res) {
                    if (res.status === 'success') {
                        alert(res.message || 'Berhasil menyimpan perubahan');
                        setTimeout(function() {
                            location.reload();
                        }, 200);
                    } else {
                        console.error('Response tidak sesuai:', res);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }
    </script>
</body>

</html>