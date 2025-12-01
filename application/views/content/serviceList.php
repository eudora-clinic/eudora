<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Package List</title>

    <style>
        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 10px 0;
        }

        .filter-container select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }

        /* Agar select dropdown memiliki padding lebih baik */
        .filter-container select:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }

        .nav-tabs {
            border-bottom: 2px solid #e0bfb2;
        }

        .nav-tabs .nav-item {
            margin-right: 5px;
        }

        .nav-tabs .nav-link {
            background-color: #f5e5de;
            /* Warna latar belakang tab */
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            /* Warna teks */
            border-radius: 8px 8px 0 0;
            /* Membuat sudut atas membulat */
            padding: 10px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e0bfb2;
            color: white;
        }

        .nav-tabs .nav-link.active {
            background-color: #e0bfb2 !important;
            color: white;
            border-bottom: 2px solid #d1a89b;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        .tab-content {
            padding: 0 !important;
        }

        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }

        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 10px 0;
        }

        .filter-container select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;

        }

        /* Agar select dropdown memiliki padding lebih baik */
        .filter-container select:focus {
            outline: none;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class=" ">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    SERVICE LIST
                                    <a href="https://sys.eudoraclinic.com:84/app/addService"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="row p-4 filter-container">
                                    <div class="form-group" style="display: flex; flex-direction: column;">
                                        <label for="filterPublished" style="margin-bottom: 4px;">PUBLISHED:</label>
                                        <select id="filterPublished" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="Yes">PUBLISHED</option>
                                            <option value="No">UNPUBLISHED</option>
                                        </select>
                                    </div>

                                    <div class="form-group" style="display: flex; flex-direction: column;">
                                        <label for="filterSection" style="margin-bottom: 4px;">SECTION:</label>
                                        <select id="filterSection" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="DOKTER">DOKTER</option>
                                            <option value="THERAPIST">THERAPIST</option>
                                            <option value="GATAU">GATAU</option>
                                        </select>
                                    </div>

                                     <div class="form-group" style="display: flex; flex-direction: column;">
                                        <label for="filterCogs" style="margin-bottom: 4px;">COGS:</label>
                                        <select id="filterCogs" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="Tidak Ada COGS">BELUM</option>
                                            <option value="Ada COGS">UDAH ADA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySaless" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">ID</th>
                                                    <th style="text-align: center;">INGREDIENTSCATEGORYID</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">CATEGORY</th>
                                                    <th style="text-align: center;">SECTION</th>
                                                    <th style="text-align: center;">PRICE</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">SECTION</th>
                                                    <th style="text-align: center;">STATUS COGS</th>
                                                    <th style="text-align: center;">TREATMENT CHANGE TO</th>
                                                    <th style="text-align: center;">CODE CHANGE TO</th>
                                                    <th style="text-align: center;">ID CHANGE TO</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-transparent" id="voidModal" tabindex="-1" role="dialog"
        aria-labelledby="voidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="voidModalLabel">Konfirmasi Point Section</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    PILIH POINT SECTION !!
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-danger mx-2" id="confirmNot">NOT</button>
                    <button type="button" class="btn btn-danger mx-2" id="confirmMedis">MEDIS</button>
                    <button type="button" class="btn btn-info" id="confirmNonMedis">NON MEDIS</button>
                </div>
            </div>
        </div>
    </div>
</body>

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
    $(document).ready(function () {
        const table = $('#tableDailySaless').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: 'https://sys.eudoraclinic.com:84/app/App/getServiceListBackEnd',
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: null },
                { data: 'ID' },
                { data: 'ingredientscategoryid' },
                { data: 'CODE' },
                { data: 'NAME' },
                { data: 'category' },
                { data: 'SECTION' },
                { data: 'PRICE' },
                { data: 'PUBLISHED' },
                { data: 'POINTSECTION' },
                { data: 'COGS_STATUS' },
                { data: 'INGREDIENT_CATEGORY_NAME' },
                { data: 'CODECHANGETO' },
                { data: 'IDCHANGETO' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                        <button class="btn-primary btn btn-sm" onclick="goToDetail(${row.ID}, ${row.ingredientscategoryid})">DETAIL</button>
                        <button class="btn btn-primary btn-sm pointsection-btn" data-id="${row.ID}">Point Section</button>
                        <button class="btn btn-primary btn-sm btn-modal" data-id="${row.ID}">
                            COPY COGS FROM
                        </button>
                        `;
                    }
                }
            ],
            drawCallback: function (settings) {
                const api = this.api();
                const startIndex = api.page.info().start;
                api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1;
                });
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'Service List Export',
                    className: 'btn btn-success btn-sm'
                }
            ],
        });

        $('#filterPublished').on('change', function () {
            table.column(8).search(this.value).draw();
        });

        $('#filterSection').on('change', function () {
            table.column(6).search(this.value).draw();
        });

        var selectedId;

        // Ketika tombol Void diklik
        $(document).on("click", ".pointsection-btn", function () {
            selectedId = $(this).data("id"); // Ambil ID dari tombol
            $("#voidModal").modal("show"); // Tampilkan modal
        });

        $("#confirmMedis").click(function () {
            $.ajax({
                url: "<?= base_url() . 'App/pointSectionService' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 1
                },
                success: function (response) {
                    console.log(response);

                    if (response.status === 'success') {
                        alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                        table.ajax.reload();

                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });

        $("#confirmNonMedis").click(function () {
            $.ajax({
                url: "<?= base_url() . 'App/pointSectionService' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 2
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                        table.ajax.reload();

                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });

        $("#confirmNot").click(function () {
            $.ajax({
                url: "<?= base_url() . 'App/pointSectionService' ?>",
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 3
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Update berhasil!");
                        $("#voidModal").modal("hide");
                        table.ajax.reload();
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });



        var selectedServiceId;


        $(document).on("click", ".btn-modal", function () {
            selectedServiceId = $(this).data("id");
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
            let serviceid = selectedServiceId;
            let ingredientscategoryid = document.getElementById('serviceid').value;

            const copyCogsData = {
                id: serviceid,
                serviceid: ingredientscategoryid
            };


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
                        if (response.status === 'success') {
                            table.ajax.reload();
                            $("#copyCogs").modal("hide");
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


    function goToDetail(id, ingredientscategoryid) {
        let base_url = "<?= base_url('serviceDetail'); ?>";
        let queryParams = new URLSearchParams({
            serviceId: id,
            ingredientscategoryid: ingredientscategoryid
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }

</script>


</html>