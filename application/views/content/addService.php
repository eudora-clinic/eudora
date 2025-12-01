<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - ADD SERVICE</title>

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
</head>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code">
                        <label for="section" class="form-label mt-2"><strong>SECTION:</strong><span class="text-danger">*</span></label>
                        <select id="section" name="section" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <option value="2">DOCTER</option>
                            <option value="1">BEAUTICIAN</option>
                        </select>

                        <label for="description" class="form-label mt-2"><strong>DESCRIPTION:</strong><span
                                class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4"
                            placeholder="Masukkan deskripsi"></textarea>

                    </div>

                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>APPS NAME:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="apps_name" id="apps_name">
                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="price" class="form-label mt-2"><strong>PRICE:</strong></label>
                        <input type="number" name="price" id="price">
                        <label for="section" class="form-label mt-2"><strong>GROUP:</strong><span class="text-danger">*</span></label>
                        <select id="group" name="group" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($serviceGroup as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['group']) && $input['group'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>

                        <label for="iscanfree" class="form-label mt-2"><strong>ISCANFREE:</strong><span class="text-danger">*</span></label>
                        <select id="iscanfree" name="iscanfree" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="row m-2">
                    <label for="image" class="form-label mt-2"><strong>IMAGE:</strong><span class="text-danger">*</span></label>
                    <div class="col-md-12 text-center">
                        <img id="previewImage" src="" alt="Preview" class="img-fluid rounded border mb-2" style="max-height:250px; object-fit:contain;"> 
                        <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-wrapper product-table-wrapper card">
        <div class="p-4">
            <div class="items mt-2">
                <h6 class="text-secondary mb-2 mt-2">
                    <i class="bi bi-wallet2"></i> + COGS
                </h6>
                <table id="tbl-items" class="table table-bordered items-list">
                    <thead class="bg-thead">
                        <tr>
                            <th style="font-size: 12px; text-align: center;">SALON</th>
                            <th style="font-size: 12px; text-align: center;">PRICE</th>
                            <th style="font-size: 12px; text-align: center;">QTY</th>
                            <th style="font-size: 12px; text-align: center;">ACT</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="row">
                    <button class="btn btn-primary btn-sm add-items">
                        <i class="bi bi-plus-circle"></i> + COGS
                    </button>

                    <button class="btn btn-primary btn-sm" onclick="addCogs()">
                        <i class="bi bi-plus-circle"></i> SIMPAN
                    </button>
                    
                </div>

            </div>
        </div>
    </div>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="addService()" style="background-color: #c49e8f; color: black;">SAVE</button>
        <a href="https://sys.eudoraclinic.com:84/app/serviceList" type="button" class="btn btn-primary" style="background-color: #c49e8f; color: black;">BACK</a>
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
        document.addEventListener("DOMContentLoaded", function() {
            const newTable = document.querySelector(".product-table-wrapper");
            newTable.querySelector(".add-items").addEventListener("click", function() {
                const itemList = newTable.querySelector("#tbl-items tbody");
                const itemHtml = `
                                        <tr>
                                            <td style="text-align: center;">
                                                <select class="form-control itemsid">
                                                </select>
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="number" class="form-control price">
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="number" class="form-control qty" value="1" min="1">
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger btn-sm remove-items">DELETE</button>
                                            </td>
                                        </tr>
                                    `;

                itemList.insertAdjacentHTML("beforeend", itemHtml);
                const lastItems = itemList.lastElementChild;
                const selectElement = $(lastItems).find(".itemsid");

                selectElement.select2({
                    placeholder: "Pilih Item",
                    allowClear: true,
                    width: "100%",
                    ajax: {
                        url: "App/searchSalon",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.text,
                                }))
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });

                selectElement.on("select2:select", function(e) {
                    const selectedData = e.params.data;
                });

                lastItems.querySelector(".remove-items").addEventListener("click", function() {
                    lastItems.remove();
                });
            });
        });

        function addService() {
            const name = document.getElementById('name').value;
            const apps_name = document.getElementById('apps_name').value;
            const code = document.getElementById('code').value;
            const isactive = document.getElementById('isactive').value;
            const price = document.getElementById('price').value;
            const section = document.getElementById('section').value;
            const group = document.getElementById('group').value;
            const iscanfree = document.getElementById('iscanfree').value;
            const imageFile = document.getElementById('imageInput').files[0];

            let hasError = false;
            if (!name || !code || !isactive || !price || !section || !group || !iscanfree) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const itemid = method.querySelector('.itemsid').value;
                const qty = method.querySelector('.qty').value;
                const price = method.querySelector('.price').value;

                if (!itemid || !qty || !price) {
                    alert('Silakan lengkapi informasi benefit!');
                    hasError = true;
                }

                itemList.push({
                    itemid,
                    qty,
                    price
                });
            });

            let formData = new FormData();
            formData.append("name", name);
            formData.append("apps_name", apps_name);
            formData.append("code", code);
            formData.append("isactive", isactive);
            formData.append("price", price);
            formData.append("section", section);
            formData.append("group", group);
            formData.append("iscanfree", iscanfree);
            formData.append("description", description);
            formData.append("itemList", JSON.stringify(itemList));
            if (imageFile) {
                formData.append("image", imageFile); // hanya dikirim kalau ada file
            }

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/addService' ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false, 
                    success: function(response) {
                    try {
                        const res = JSON.parse(response); 
                        if (res.status === 'success') {
                            alert(res.message || 'Berhasil menambahkan service!');
                            setTimeout(function() {
                                location.reload();
                            }, 200);
                        } else {
                            console.error('Response tidak sesuai:', res);
                            alert('Terjadi kesalahan saat mengirim data.');
                        }
                    } catch (e) {
                        console.error('JSON parsing error:', e, response);
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