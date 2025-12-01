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

        .dataTables_empty {
    display: none;
}

#tbl-items {
        width: 100%;
        border-collapse: collapse;
    }

    @media screen and (max-width: 768px) {
        .items-list {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .items-list th, .items-list td {
            font-size: 11px;
            padding: 6px;
        }
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
    <div class="table-wrapper product-table-wrapper card">
        <div class="p-4">
            <div class="items mt-2">
                <h6 class="text-secondary mb-2 mt-2">
                    <i class="bi bi-wallet2"></i> + TARGET
                </h6>
                <table id="tbl-items" class="table table-bordered items-list">
                    <thead class="bg-thead">
                        <tr>
                            <th style="font-size: 12px; text-align: center;">PERIOD</th>
                            <th style="font-size: 12px; text-align: center;">CONSULTANT</th>
                            <th style="font-size: 12px; text-align: center; min-width: 160px;">TARGET</th>
                            <th style="font-size: 12px; text-align: center; min-width: 160px;">UNIT</th>
                             <th style="font-size: 12px; text-align: center;">LOCATION</th>
                              <th style="font-size: 12px; text-align: center;">GRADE</th>
                              <th style="font-size: 12px; text-align: center;">JOB</th>
                            <th style="font-size: 12px; text-align: center;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <div class="row">
                    <button class="btn btn-primary btn-sm add-items">
                        <i class="bi bi-plus-circle"></i> + TARGET
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="addPackage()" style="background-color: #c49e8f; color: black;">SAVE</button>
    </div>

    <script>
        const $locationList = <?= json_encode($locationList); ?>;
        document.addEventListener("DOMContentLoaded", function() {
            const newTable = document.querySelector(".product-table-wrapper");
            newTable.querySelector(".add-items").addEventListener("click", function() {
                const itemList = newTable.querySelector("#tbl-items tbody");
                const itemHtml = `
                                        <tr>
                                            <td style="text-align: center;">
                                                <input type="month" class="form-control period">
                                            </td>
                                            <td style="text-align: center;">
                                                <select class="form-control employeeid">
                                                </select>
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="number" class="form-control target" value="1" min="1">
                                            </td>
                                            <td style="text-align: center;">
                                                <input type="number" class="form-control targetunit" value="1" min="1">
                                            </td>

                                            <td style="text-align: center;">
                                                <select class="form-control locationid">
                                                    ${$locationList.map(loc => `<option value="${loc.id}">${loc.name}</option>`).join('')}
                                                </select>
                                            </td>

                                            <td style="text-align: center;">
                                                <select class="form-control statusConsultant">
                                                    <option value="SENIOR">SENIOR</option>
                                                    <option value="JUNIOR">JUNIOR</option>
                                                </select>
                                            </td>

                                            <td style="text-align: center;">
                                                <select class="form-control job">
                                                    <option value="">PILIH JOB</option>
                                                    <option value="ASDOK">ASDOK</option>
                                                    <option value="BC">BC</option>
                                                </select>
                                            </td>

                                            <td style="text-align: center;">
                                                <button class="btn btn-danger btn-sm remove-items">DEL</button>
                                            </td>
                                        </tr>
                                    `;

                itemList.insertAdjacentHTML("beforeend", itemHtml);
                const lastItems = itemList.lastElementChild;
                const selectElement = $(lastItems).find(".employeeid");

                selectElement.select2({
                    placeholder: "Pilih Item",
                    allowClear: true,
                    width: "100%",
                    ajax: {
                        url: "App/searchConsultant",
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

                selectElement.on("select2:select", function(e) {
                    const selectedData = e.params.data;
                });

                lastItems.querySelector(".remove-items").addEventListener("click", function() {
                    lastItems.remove();
                });
            });
        });

        function addPackage() {

            let hasError = false;
            const itemList = [];
            document.querySelectorAll('.items-list tbody tr').forEach(method => {
                const employeeid = method.querySelector('.employeeid').value;
                const target = method.querySelector('.target').value;
                const targetunit = method.querySelector('.targetunit').value;
                const period = method.querySelector('.period').value;
                const locationid = method.querySelector('.locationid').value;
                const statusConsultant = method.querySelector('.statusConsultant').value;
                const job = method.querySelector('.job').value;

                if (!employeeid || !target || !period || !targetunit || !locationid || !statusConsultant) {
                    alert('Silakan lengkapi informasi item!');
                    hasError = true;
                }

                itemList.push({
                    employeeid,
                    target,
                    period,
                    locationid,
                    statusConsultant,
                    targetunit,
                    job
                });
            });

            if (itemList.length === 0) {
                alert('Silakan tambah item adjusment!');
                hasError = true;
            }

            const transactionData = {
                itemList
            };

            console.log(transactionData);

            if (hasError) {
                return false;
            }

            $.ajax({
                url: "<?= base_url() . 'App/addTargetConsultant' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    try {
                        alert('Berhasil menambah target');
                        if (response.status === 'success') {
                            window.open(`https://sys.eudoraclinic.com:84/app/listTarget`);
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