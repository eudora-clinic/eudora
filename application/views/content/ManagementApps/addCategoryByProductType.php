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
</head>

<?php
$db_oriskin = $this->load->database('oriskin', TRUE);
$category = $db_oriskin->query("select * from mscategory order by name")->result_array();
?>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="categoryid" class="form-label mt-2"><strong>CATEGORY</strong><span
                                class="text-danger">*</span></label>
                        <select id="categoryid" name="categoryid" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <?php foreach ($category as $j) { ?>
                                <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="producttypeid" class="form-label mt-2"><strong>PRODUCT TYPE:</strong><span
                                class="text-danger">*</span></label>
                        <select id="producttypeid" name="producttypeid" class="" required="true" aria-required="true">
                            <option value="0">SELECT PRODUCT TYPE</option>
                            <option value="1">TREATMENT</option>
                            <option value="2">PACKAGE</option>
                            <option value="3">RETAIL</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-wrapper product-table-wrapper card">
        <div class="p-4">
            <div class="items mt-2">
                <h6 class="text-secondary mb-2 mt-2">
                    <i class="bi bi-wallet2"></i> + SERVICES
                </h6>
                <table id="tbl-items" class="table table-bordered items-list">
                    <thead class="bg-thead">
                        <tr>
                            <th style="font-size: 12px; text-align: center;">PRODUCT</th>
                            <th style="font-size: 12px; text-align: center;">ACT</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="row">
                    <button class="btn btn-primary btn-sm add-items">
                        <i class="bi bi-plus-circle"></i> + ITEMS
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="addPackage()"
            style="background-color: #c49e8f; color: black;">SAVE</button>
    </div>

    <script>

        $(document).ready(function () {
            $('#producttypeid').on('change', function () {
                $('#tbl-items tbody').empty();
            });
        });
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
                                                <button class="btn btn-danger btn-sm remove-items">DELETE</button>
                                            </td>
                                        </tr>
                                    `;

                itemList.insertAdjacentHTML("beforeend", itemHtml);
                const lastItems = itemList.lastElementChild;
                const selectElement = $(lastItems).find(".itemsid");

                const productTypeId = document.getElementById("producttypeid").value;

                selectElement.select2({
                    placeholder: "Pilih Item",
                    allowClear: true,
                    width: "100%",
                    ajax: {
                         url: "ControllerApiApps/searchServices/" + productTypeId,
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
                                    text: item.text
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

        function addPackage() {
            const categoryid = document.getElementById('categoryid').value;
            const producttypeid = document.getElementById('producttypeid').value;

            let hasError = false;
            if (!categoryid || !producttypeid) {
                alert('Silakan lengkapi informasi lokasi dan customer!');
                hasError = true;
            }

            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const itemid = method.querySelector('.itemsid').value;

                if (!itemid) {
                    alert('Silakan lengkapi informasi item!');
                    hasError = true;
                }

                itemList.push({
                    itemid
                });
            });

            if (itemList.length === 0) {
                alert('Silakan tambah item adjusment!');
                hasError = true;
            }

            const transactionData = {
                categoryid,
                producttypeid,
                itemList
            };

            console.log(transactionData);

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'ControllerApiApps/addCategoryByProductType' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    
                    try {
                        alert('Berhasil menambah category product');
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