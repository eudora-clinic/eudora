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
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                    <i class="bi bi-wallet2"></i> General
                </h6>
                <div class="form-row">
                    <div class="form-column">
                        <label for="stockindate" class="form-label mt-2"><strong>DATE</strong><span class="text-danger">*</span></label>
                        <input type="date" name="stockindate" id="stockindate">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" placeholder="#AUTO" disabled>
                        <label for="issuedby" class="form-label mt-2"><strong>ISSUED BY:</strong></label>
                        <select id="issuedby" name="issuedby" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($employeeStockOut as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['issuedby']) && $input['issuedby'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-column">
                        <label for="stockmovement" class="form-label mt-2"><strong>STOCK MOVEMENT:</strong><span class="text-danger">*</span></label>
                        <select id="stockmovement" name="stockmovement" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <option value="3">Movement (In)</option>
                            <option value="4">Opening (In)</option>
                            <option value="5">Purchase (In)</option>
                        </select>
                        <label for="remarks" class="form-label mt-2"><strong>REMARKS:</strong></label>
                        <textarea name="remarks" id="remarks" rows="6" cols="50"></textarea>
                    </div>
                    <div class="form-column">
                        <label for="toLocationId" class="form-label mt-2"><strong>To Warehouse:</strong><span class="text-danger">*</span></label>
                        <select id="toLocationId" name="toLocationId" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($locationListEmployee as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['toLocationId']) && $input['toLocationId'] == $j['id'] ? 'selected' : '') ?>><?= $j['warehouse_name'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="fromLocationId" class="form-label mt-2"><strong>From Warehouse:</strong><span class="text-danger">*</span></label>
                        <select id="fromLocationId" name="fromLocationId" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($locationListEmployee as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['fromLocationId']) && $input['fromLocationId'] == $j['id'] ? 'selected' : '') ?>><?= $j['warehouse_name'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="supplierid" class="form-label mt-2"><strong>Supplier:</strong><span class="text-danger">*</span></label>
                        <select id="supplierid" name="supplierid" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($supplierlist as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['supplierid']) && $input['supplierid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="refferenceno" class="form-label mt-2"><strong>REFFERENCE NO:</strong></label>
                        <input type="text" name="refferenceno" id="refferenceno">
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

                    </tbody>
                </table>
                <button class="btn btn-primary btn-sm add-items">
                    <i class="bi bi-plus-circle"></i> + ITEMS
                </button>
            </div>
        </div>
    </div>
    <div class="row p-4 gap-4">
        <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(1)" style="background-color: #c49e8f; color: black;">SAVE AS DRAFT</button>
        <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(2)" style="background-color: #c49e8f; color: black;">APPROVE</button>
        <a href="<?= base_url('stockInList'); ?>" class="btn btn-primary mb-4">
            <i class="bi bi-plus-circle"></i> CANCEL
        </a>
    </div>

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
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
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

                lastItems.querySelector(".remove-items").addEventListener("click", function() {
                    lastItems.remove();
                });
            });
        });

        function saveStockOut(status) {
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
            if(!fromLocationId && !supplierid){
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            if(fromLocationId && supplierid){
                alert('Pilih hanya satu cabang atau supplier!');
                hasError = true;
            }

            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const itemid = method.querySelector('.itemsid').value;
                const qty = method.querySelector('.qty').value;

                itemList.push({
                    itemid,
                    qty,
                });
            });

            const transactionData = {
                stockindate,
                issuedby,
                stockmovement,
                remarks,
                toLocationId,
                refferenceno,
                itemLists: itemList,
                status,
                fromLocationId,
                supplierid
            };

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/saveStockIn' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    try {
                        console.log('Parsed Response:', response);
                        alert('berhasil menambahkan stock in');
                        if (response.status === 'success') {
                            setTimeout(function() {
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

                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }
    </script>
</body>

</html>