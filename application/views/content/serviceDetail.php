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

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>

    <?php
    $detail = isset($serviceDetail[0]) ? $serviceDetail[0] : [];

    // echo json_decode($detail);
    ?>
</head>

<body>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="updateCogs(<?= $detail['ID'] ?>)"
            style="background-color: #c49e8f; color: black;">UPDATE</button>
        <a href="https://sys.eudoraclinic.com:84/app/serviceList" type="button" class="btn btn-primary"
            style="background-color: #c49e8f; color: black;">BACK</a>
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            value="<?= isset($detail['NAME']) ? $detail['NAME'] : '' ?>">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="code" id="code"
                            value="<?= isset($detail['CODE']) ? $detail['CODE'] : '' ?>">
                        <input type="number" name="ingredientscategoryid" id="ingredientscategoryid"
                            value="<?= $detail['ID'] ?>" hidden>
                        <label for="section" class="form-label mt-2"><strong>SERVICE:</strong><span
                                class="text-danger">*</span></label>
                        <select id="section" name="section" class="" required="true" aria-required="true">
                            <option value="2" <?= isset($detail['section']) && $detail['section'] == 2 ? 'selected' : '' ?>>DOCTER</option>
                            <option value="1" <?= isset($detail['section']) && $detail['section'] == 1 ? 'selected' : '' ?>>BEAUTICIAN</option>
                        </select>

                        <label for="description" class="form-label mt-2"><strong>DESCRIPTION:</strong><span
                                class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" rows="4"
                            placeholder="Masukkan deskripsi"><?= isset($detail['description']) ? $detail['description'] : '' ?></textarea>

                    </div>

                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>APPS NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="apps_name" id="apps_name"
                            value="<?= isset($detail['apps_name']) ? $detail['apps_name'] : '' ?>">
                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1" <?= isset($detail['ISACTIVE']) && $detail['ISACTIVE'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= isset($detail['ISACTIVE']) && $detail['ISACTIVE'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                        <label for="price" class="form-label mt-2"><strong>PRICE:</strong></label>
                        <input type="number" name="price" id="price"
                            value="<?= isset($detail['PRICE']) ? $detail['PRICE'] : '' ?>">
                        <label for="group" class="form-label mt-2"><strong>GROUP:</strong></label>
                        <select id="group" name="group" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($serviceGroup as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['treatmentgroupid']) && $detail['treatmentgroupid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="iscanfree" class="form-label mt-2"><strong>ISCANFREE:</strong><span
                                class="text-danger">*</span></label>
                        <select id="iscanfree" name="iscanfree" class="" required="true" aria-required="true">
                            <option value="1" <?= isset($detail['iscanfree']) && $detail['iscanfree'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= isset($detail['iscanfree']) && $detail['iscanfree'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>

                <div class="row m-2">
                    <label for="image" class="form-label mt-2"><strong>IMAGE:</strong><span
                            class="text-danger">*</span></label>
                    <div class="col-md-12 text-center">
                        <img id="previewImage" src="<?= isset($detail['image']) ? $detail['image'] : '' ?>"
                            alt="Preview" class="img-fluid rounded border mb-2"
                            style="max-height:250px; object-fit:contain;">
                        <input type="file" class="form-control" name="image" id="imageInput" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-wrapper card">
        <div class="p-4">
            <div class="mt-2">
                <button class="btn btn-primary btn-sm btn-modal" data-bs-toggle="modal" data-bs-target="#copyCogs">
                    <i class="bi bi-plus-circle"></i> COPY COGS FROM
                </button>
                <h6 class="text-secondary mb-2 mt-2">
                    <i class="bi bi-wallet2"></i> COGS
                </h6>
                <table class="table table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="font-size: 12px; text-align: center;">CODE</th>
                            <th style="font-size: 12px; text-align: center;">SALON</th>
                            <th style="font-size: 12px; text-align: center;">QTY</th>
                            <th style="font-size: 12px; text-align: center;">PRICE</th>
                            <th style="font-size: 12px; text-align: center;">ACT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cogsService)): ?>
                            <?php foreach ($cogsService as $item): ?>
                                <tr>
                                    <td style="font-size: 12px; text-align: center;">
                                        <?= htmlspecialchars($item['CODE']) ?>
                                    </td>
                                    <td style="font-size: 12px; text-align: center;">
                                        <?= htmlspecialchars($item['NAME']) ?>
                                    </td>

                                    <td style="font-size: 12px; text-align: center;">
                                        <?= htmlspecialchars($item['QTY']) ?>
                                    </td>
                                    <td style="font-size: 12px; text-align: center;">
                                        <?= htmlspecialchars($item['PRICE']) ?>
                                    </td>
                                    <td style="font-size: 12px; text-align: center;">
                                        <button class="btn btn-sm <?= $item['isactive'] ? 'btn-danger' : 'btn-success' ?>"
                                            onclick="deleteCogs(<?= $item['ID'] ?>, <?= $item['isactive'] ?>)">
                                            <?= $item['isactive'] ? 'Nonaktifkan' : 'Aktifkan' ?>
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

    <div class="modal fade modal-transparent" id="copyCogs" tabindex="-1" role="dialog" aria-labelledby="copyCogsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog" style="margin: auto; ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="copyCogsLabel">COPY COGS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                    <div class="" id="role-container">
                        <div class="card">
                            <div class="form-group">
                                <label for="servicename">SERVICE TO COPY COGS:</label>
                                <select id="servicename" class="servicename" data-placeholder="CARI SERVICE"></select>
                            </div>
                            <input type="number" id="serviceid" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <input id="saveCopyCogs" type="submit" class="btn btn-primary pull-right" value="Save">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('previewImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const newTable = document.querySelector(".product-table-wrapper");
            newTable.querySelector(".add-items").addEventListener("click", function () {
                const itemList = newTable.querySelector("#tbl-items tbody");
                const itemHtml = `
                                        <tr>
                                            <td style="text-align: center;">
                                                <select class="form-control itemsid">
                                                </select>
                                            </td>
                                            <td style="text-align: center;">
                                                <input value="0" type="number" class="form-control price">
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
                        data: function (params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function (data) {
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

                selectElement.on("select2:select", function (e) {
                    const selectedData = e.params.data;
                });

                lastItems.querySelector(".remove-items").addEventListener("click", function () {
                    lastItems.remove();
                });
            });
        });

        function updateCogs(id) {
            const name = document.getElementById('name').value;
            const apps_name = document.getElementById('apps_name').value;
            const code = document.getElementById('code').value;
            const isactive = document.getElementById('isactive').value;
            const price = document.getElementById('price').value;
            const section = document.getElementById('section').value;
            const group = document.getElementById('group').value;
            const iscanfree = document.getElementById('iscanfree').value;
            const description = document.getElementById('description').value;
            const imageFile = document.getElementById('imageInput').files[0];

            let hasError = false;
            if (!name || !code || !isactive || !price || !section || !group || !iscanfree) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            let formData = new FormData();
            formData.append("id", id);
            formData.append("name", name);
            formData.append("apps_name", apps_name);
            formData.append("code", code);
            formData.append("isactive", isactive);
            formData.append("price", price);
            formData.append("section", section);
            formData.append("group", group);
            formData.append("iscanfree", iscanfree);
            formData.append("description", description);
            if (imageFile) {
                formData.append("image", imageFile); // hanya dikirim kalau ada file
            }

            console.log(formData);

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/updateCogs' ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message || 'Berhasil menyimpan perubahan');
                            setTimeout(function () {
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

                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }

        function deleteCogs(id, isactive) {

            console.log(id, isactive);
            

            let hasError = false;
            if (!id) {
                alert('Id tidak ditemukan!');
                hasError = true;
            }

            const newStatus = isactive ? 0 : 1;

            const transactionData = {
                id,
                isactive: newStatus
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'App/deleteCogs' ?>",
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

        function addCogs() {
            const ingredientscategoryid = document.getElementById('ingredientscategoryid').value;
            let hasError = false;
            if (!ingredientscategoryid) {
                alert('Id tidak ditemukan!');
                hasError = true;
            }

            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const itemid = method.querySelector('.itemsid').value;
                const qty = method.querySelector('.qty').value;
                const price = method.querySelector('.price').value;

                if (!itemid || !qty) {
                    alert('Silakan lengkapi informasi benefit!');
                    hasError = true;
                }

                itemList.push({
                    itemid,
                    qty,
                    price
                });
            });

            if (itemList.length === 0) {
                alert('Silakan tambah service benefit!');
                hasError = true;
            }

            const transactionData = {
                ingredientscategoryid,
                itemList
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'App/addCogs' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil menyimpan perubahan');
                        console.log(response);

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
            $(".btn-modal").on("click", function () {
                $("#copyCogs").modal("show");
            });

            $("#servicename").select2({
                width: '100%',
                ajax: {
                    url: "App/searchServicesCogs",
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

            $("#servicename").on("select2:select", function (e) {
                let data = e.params.data;
                console.log(data);
                $("#serviceid").val(data.ingredientscategoryid);
            });

            $("#saveCopyCogs").on("click", function () {
                let serviceid = $("#serviceid").val();
                let ingredientscategoryid = document.getElementById('ingredientscategoryid').value;

                const copyCogsData = {
                    id: ingredientscategoryid,
                    serviceid: serviceid
                };

                console.log(copyCogsData);

                if (!serviceid || !ingredientscategoryid) {
                    alert("Pilih cogs yang ingin di copy!");
                    return;
                }

                $.ajax({
                    url: "<?= base_url() . 'App/copyCogs' ?>",
                    type: 'POST',
                    data: JSON.stringify(copyCogsData),
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
                    error: function () {
                        alert("Terjadi kesalahan saat menyimpan data!");
                    }
                });
            });
        });
    </script>
</body>

</html>