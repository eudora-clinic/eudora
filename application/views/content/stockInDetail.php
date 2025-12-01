<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Stock Out</title>

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
    $detail = isset($detailGeneral[0]) ? $detailGeneral[0] : [];

    ?>
    <?php if ($detail['status'] == 2): ?>
        <div class="">
            <button type="button" class="btn btn-primary" onclick="updateStockInDetail(<?= $detail['id'] ?>)"
                style="background-color: #c49e8f; color: black;">UPDATE</button>
        </div>
    <?php endif; ?>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 text-center"
                    style="font-weight: bold; text-transform: uppercase; font-size: 16px !important;">
                    <i class="bi bi-wallet2"></i> <?php if ($detail['status'] == 1): ?> DRAFT <?php endif; ?>
                    <?php if ($detail['status'] == 2): ?> APPROVE <?php endif; ?>
                    <?php if ($detail['status'] == 3): ?> VOID <?php endif; ?>
                </h6>
                <div class="form-row">
                    <div class="form-column">
                        <label for="stockindate" class="form-label mt-2"><strong>DATE</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" name="stockindate" id="stockindate"
                            value="<?= isset($detail['stockindate']) ? date('Y-m-d', strtotime($detail['stockindate'])) : '' ?>">


                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="code" id="code"
                            value="<?= isset($detail['code']) ? $detail['code'] : '' ?>" disabled>

                        <label for="issuedby" class="form-label mt-2"><strong>ISSUED BY:</strong></label>
                        <select id="issuedby" name="issuedby" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($employeeStockOut as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['issuedby']) && $detail['issuedby'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-column">
                        <label for="stockmovement" class="form-label mt-2"><strong>STOCK MOVEMENT:</strong><span
                                class="text-danger">*</span></label>
                        <select id="stockmovement" name="stockmovement" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <option value="3" <?= isset($detail['stockmovement']) && $detail['stockmovement'] == 3 ? 'selected' : '' ?>>Movement (In)</option>
                            <option value="4" <?= isset($detail['stockmovement']) && $detail['stockmovement'] == 4 ? 'selected' : '' ?>>Opening (In)</option>
                            <option value="5" <?= isset($detail['stockmovement']) && $detail['stockmovement'] == 5 ? 'selected' : '' ?>>Purchase (In)</option>
                        </select>

                        <label for="remarks" class="form-label mt-2"><strong>REMARKS:</strong></label>
                        <textarea name="remarks" id="remarks" rows="6"
                            cols="50"><?= isset($detail['remarks']) ? $detail['remarks'] : '' ?></textarea>
                    </div>

                    <div class="form-column">
                        <label for="toLocationId" class="form-label mt-2"><strong>To Branch:</strong><span
                                class="text-danger">*</span></label>
                        <select id="toLocationId" name="toLocationId" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($locationListEmployee as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['tolocationid']) && $detail['tolocationid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['warehouse_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="fromLocationId" class="form-label mt-2"><strong>From Branch:</strong><span
                                class="text-danger">*</span></label>
                        <select id="fromLocationId" name="fromLocationId" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($locationListEmployee as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['fromlocationid']) && $detail['fromlocationid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['warehouse_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="supplierid" class="form-label mt-2"><strong>Supplier:</strong><span
                                class="text-danger">*</span></label>
                        <select id="supplierid" name="supplierid" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($supplierlist as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($detail['supplierid']) && $detail['supplierid'] == $j['id'] ? 'selected' : '') ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="refferenceno" class="form-label mt-2"><strong>REFFERENCE NO:</strong></label>
                        <input type="text" name="refferenceno" id="refferenceno"
                            value="<?= isset($detail['refferenceno']) ? $detail['refferenceno'] : '' ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-wrapper product-table-wrapper card">
        <div class="p-4">
            <div class="items mt-2">
                <h6 class="text-secondary mb-2 mt-2">
                    <i class="bi bi-wallet2"></i> ITEMS
                </h6>
                <table id="tbl-items" class="table table-bordered items-list">
                    <thead class="bg-thead">
                        <tr>
                            <th style="font-size: 12px; text-align: center;">ITEM</th>
                            <th style="font-size: 12px; text-align: center;">QTY</th>
                            <th style="font-size: 12px; text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detailStockIn)): ?>
                            <?php foreach ($detailStockIn as $item): ?>
                                <tr>
                                    <td style="font-size: 12px; text-align: center;">
                                        <?= htmlspecialchars($item['INGREDIENTSNAME']) ?>
                                    </td>

                                    <td style="font-size: 12px; text-align: center;">
                                        <span
                                            id="sp-stockinqty-<?= $item['id'] ?>"><?= htmlspecialchars($item['stockinqty']) ?></span>
                                        <input class="form-control" type="text" id="stockinqty-<?= $item['id'] ?>"
                                            value="<?= $item['stockinqty'] ?>" style="width: 100%; display: none;">
                                    </td>
                                    <td style="text-align: center;">
                                        <button id="btn-edit-header-<?= $item['id'] ?>" class="btn btn-sm btn-primary"
                                            onclick="editHeader('<?= $item['id'] ?>');"><i class="material-icons">edit</i>
                                            Edit</button>
                                        <button id="btn-save-header-<?= $item['id'] ?>" class="btn btn-sm btn-success"
                                            onclick="saveHeader('<?= $item['id'] ?>');" style="display: none;"><i
                                                class="material-icons">save</i> Save</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center;">No items found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row p-4 gap-4">
        <?php if ($detail['status'] == 1): ?>
            <button type="button" class="btn btn-primary mb-4" onclick="updateStockOut(<?= $detail['id'] ?>, 1)"
                style="background-color: #c49e8f; color: black;">SAVE AS DRAFT</button>
            <button type="button" class="btn btn-primary mb-4" onclick="updateStockOut(<?= $detail['id'] ?>, 2)"
                style="background-color: #c49e8f; color: black;">APPROVE</button>
        <?php endif; ?>
        <?php if ($detail['status'] == 2): ?>
            <button type="button" class="btn btn-primary mb-4" onclick="updateStockOut(<?= $detail['id'] ?>, 3)"
                style="background-color: #c49e8f; color: black;">VOID</button>
        <?php endif; ?>
        <a href="https://sys.eudoraclinic.com:84/app/stockInList" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle"></i> BACK
        </a>
    </div>

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
                                                <input type="number" class="form-control qty" value="1" min="1">
                                            </td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-danger btn-sm remove-items">DELETE</button>
                                            </td>
                                        </tr>
                                    `;

                itemList.insertAdjacentHTML("beforeend", itemHtml);
                const lastItems = itemList.lastElementChild;

                $(lastItems).find(".itemsid").select2({
                    placeholder: "Pilih Item",
                    allowClear: true,
                    width: "100%",
                    ajax: {
                        url: "App/searchItems",
                        dataType: "json",
                        delay: 250,
                        data: function (params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function (data) {
                            console.log(data);

                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.text
                                }))
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2
                });

                lastItems.querySelector(".remove-items").addEventListener("click", function () {
                    lastItems.remove();
                });
            });
        });

        function updateStockOut(id, status) {
            const stockoutdate = document.getElementById('stockindate').value;
            const issuedby = document.getElementById('issuedby').value;
            const stockmovement = document.getElementById('stockmovement').value;
            const remarks = document.getElementById('remarks').value;
            const toLocationId = document.getElementById('toLocationId').value;
            const refferenceno = document.getElementById('refferenceno').value;
            const fromLocationId = document.getElementById('fromLocationId').value;
            const supplierid = document.getElementById('supplierid').value;

            let hasError = false;
            if (!stockoutdate || !stockmovement || !toLocationId) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }
            if (!fromLocationId && !supplierid) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            if (fromLocationId && supplierid) {
                alert('Pilih hanya satu cabang atau supplier!');
                hasError = true;
            }

            const transactionData = {
                stockoutdate,
                issuedby,
                stockmovement,
                remarks,
                toLocationId,
                refferenceno,
                status,
                fromLocationId,
                id,
                status: status,
                type: 1,
                supplierid: supplierid
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/updateStockOut' ?>",
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
    </script>

    <script>
        _mod = '<?= $mod ?>';

        function editHeader(id) {
            document.getElementById('sp-stockinqty-' + id).style.display = 'none';
            document.getElementById('stockinqty-' + id).style.display = 'block';


            document.getElementById('btn-edit-header-' + id).style.display = 'none';
            document.getElementById('btn-save-header-' + id).style.display = 'inline-block';
        }

        function saveHeader(id) {
            let stockinqty = document.getElementById('stockinqty-' + id).value;
            $.ajax({
                url: "<?= base_url('App/updateStockIn') ?>", // Sesuaikan dengan route Anda
                type: "POST",
                data: {
                    id: id,
                    stockinqty: stockinqty,
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        alert("Data berhasil diperbarui!");
                        location.reload();
                    } else {
                        alert("Gagal memperbarui data!");
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    alert("Terjadi kesalahan saat memperbarui data.");
                }
            });
        }

        function updateStockInDetail(id) {
            const stockindate = document.getElementById('stockindate').value;
            const issuedby = document.getElementById('issuedby').value;
            const stockmovement = document.getElementById('stockmovement').value;
            const remarks = document.getElementById('remarks').value;
            const toLocationId = document.getElementById('toLocationId').value;
            const refferenceno = document.getElementById('refferenceno').value;
            const fromLocationId = document.getElementById('fromLocationId').value;
            const supplierid = document.getElementById('supplierid').value;

            let hasError = false;
            if (!stockindate || !stockmovement || !toLocationId) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }
            if (!fromLocationId && !supplierid) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            if (fromLocationId && supplierid) {
                alert('Pilih hanya satu cabang atau supplier!');
                hasError = true;
            }

            const transactionData = {
                stockindate,
                issuedby,
                stockmovement,
                remarks,
                toLocationId,
                refferenceno,
                fromLocationId,
                supplierid,
                id
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/updateStockInDetail' ?>",
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
    </script>
</body>

</html>