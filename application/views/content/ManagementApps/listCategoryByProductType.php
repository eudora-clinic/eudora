<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>

    <style>
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

        /* .filter-container {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        } */

        .filter-container label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }

        .filter-container select {
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 14px;
        }
    </style>
</head>

<?php
$db_oriskin = $this->load->database('oriskin', TRUE);
$category = $db_oriskin->query("select * from mscategory order by name")->result_array();
?>


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
                                    LIST CATEGORY TREATMENT APPS
                                    <a href="<?= base_url('addCategoryByProductType') ?>"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>

                                <div>
                                    <ul class="nav nav-tabs active mt-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#treatment">TREATMENT</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#package">PACKAGE</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#retail">RETAIL</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="panel-body tab-pane show active" id="treatment">
                                        <div class="row p-4 filter-container align-items-end" style="gap: 20px;">

                                            <!-- Filter Published -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="filterPublished" class="fw-bold mb-2">Published:</label>
                                                    <select id="filterPublished" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="Aktif (1)">Aktif</option>
                                                        <option value="Nonaktif (0)">Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Filter Category -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="categoryFilter" class="fw-bold mb-2">Category:</label>
                                                    <select id="categoryFilter" class="form-control" multiple="multiple"
                                                        style="height: 100px;">
                                                        <option value="">All</option>
                                                        <?php foreach ($category as $c) { ?>
                                                            <option value="<?= htmlspecialchars($c['name']) ?>">
                                                                <?= htmlspecialchars($c['name']) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="table-wrapper p-4">
                                            <div class="table-responsive">
                                                <div id="loadingIndicator"
                                                    style=" text-align:center; margin-top: 20px;">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <p>Loading data...</p>
                                                </div>

                                                <table id="tableDailySales" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead class="bg-thead">
                                                        <tr>
                                                            <th style="text-align: center;">NO</th>
                                                            <th style="text-align: center;">CATEGORY</th>
                                                            <th style="text-align: center;">PRODUCT</th>
                                                            <th style="text-align: center;">TYPE</th>
                                                            <th style="text-align: center;">STATUS</th>
                                                            <th style="text-align: center;">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="report-body">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body tab-pane" id="package">
                                        <div class="row p-4 filter-container align-items-end" style="gap: 20px;">

                                            <!-- Filter Published -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="filterPublishedPackage"
                                                        class="fw-bold mb-2">Published:</label>
                                                    <select id="filterPublishedPackage" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Nonaktif">Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Filter Category -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="categoryFilterPackage"
                                                        class="fw-bold mb-2">Category:</label>
                                                    <select id="categoryFilterPackage" class="form-control"
                                                        multiple="multiple" style="height: 100px;">
                                                        <option value="">All</option>
                                                        <?php foreach ($category as $c) { ?>
                                                            <option value="<?= htmlspecialchars($c['name']) ?>">
                                                                <?= htmlspecialchars($c['name']) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table-wrapper p-4">
                                            <div class="table-responsive">
                                                <table id="tablePackage" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead class="bg-thead">
                                                        <tr>
                                                            <th style="text-align: center;">NO</th>
                                                            <th style="text-align: center;">CATEGORY</th>
                                                            <th style="text-align: center;">PRODUCT</th>
                                                            <th style="text-align: center;">TYPE</th>
                                                            <th style="text-align: center;">STATUS</th>
                                                            <th style="text-align: center;">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="report-bodypackage">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-body tab-pane" id="retail">
                                        <div class="row p-4 filter-container align-items-end" style="gap: 20px;">

                                            <!-- Filter Published -->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="filterPublishedRetail"
                                                        class="fw-bold mb-2">Published:</label>
                                                    <select id="filterPublishedRetail" class="form-control">
                                                        <option value="">All</option>
                                                        <option value="Aktif">Aktif</option>
                                                        <option value="Nonaktif">Nonaktif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Filter Category -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="categoryFilterRetail"
                                                        class="fw-bold mb-2">Category:</label>
                                                    <select id="categoryFilterRetail" class="form-control"
                                                        multiple="multiple" style="height: 100px;">
                                                        <option value="">All</option>
                                                        <?php foreach ($category as $c) { ?>
                                                            <option value="<?= htmlspecialchars($c['name']) ?>">
                                                                <?= htmlspecialchars($c['name']) ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="table-wrapper p-4">
                                            <div class="table-responsive">
                                                <table id="tableRetail" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead class="bg-thead">
                                                        <tr>
                                                            <th style="text-align: center;">NO</th>
                                                            <th style="text-align: center;">CATEGORY</th>
                                                            <th style="text-align: center;">PRODUCT</th>
                                                            <th style="text-align: center;">TYPE</th>
                                                            <th style="text-align: center;">STATUS</th>
                                                            <th style="text-align: center;">ACTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="report-bodyretail">
                                                    </tbody>
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
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        const tablePackage = $('#tablePackage').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        const tableRetail = $('#tableRetail').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        $('#categoryFilter').select2({
            width: '200px'
        });

        $('#categoryFilter').on('change', function () {
            var valuesss = $(this).val().join('|');
            table.column(1).search(valuesss, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterPublished').on('change', function () {
            table.column(4).search(this.value).draw();
        });

        $('#categoryFilterPackage').select2({
            width: '200px'
        });

        $('#categoryFilterPackage').on('change', function () {
            var valuesssp = $(this).val().join('|');
            tablePackage.column(1).search(valuesssp, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterPublishedPackage').on('change', function () {
            tablePackage.column(4).search(this.value).draw();
        });

        $('#categoryFilterRetail').select2({
            width: '200px'
        });

        $('#categoryFilterRetail').on('change', function () {
            var valuessst = $(this).val().join('|');
            tableRetail.column(1).search(valuessst, true, false).draw(); // Kolom ke-8 (Branch)
        });

        $('#filterPublishedRetail').on('change', function () {
            tableRetail.column(4).search(this.value).draw();
        });

        function fetchData() {
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);
            const dataFormatted = [];
            const dataFormattedPackage = [];
            const dataFormattedRetail = [];

            $.ajax({
                url: "<?= base_url('ControllerApiApps/getListCategoryByProductType') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    res.listCategoryByTreatment.forEach((row, i) => {
                        const statusText = row.isactive == 0 ? "Activated" : "Unactivated";
                        dataFormatted.push([
                            i + 1,
                            row.categoryname || '',
                            row.productname || '',
                            row.type || '',
                            (row.isactive == 1 ? 'Aktif (1)' : (row.isactive == 0 ? 'Nonaktif (0)' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-updatetreatment btn-sm btn-primary" style="cursor: pointer" data-id="${row.id}" data-isactive="${row.isactive}">
                                    ${statusText}
                                </button>
                            </div>`
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();


                    res.listCategoryByPackage.forEach((row, i) => {
                        const statusText = row.isactive == 0 ? "Activated" : "Unactivated";
                        dataFormattedPackage.push([
                            i + 1,
                            row.categoryname || '',
                            row.productname || '',
                            row.type || '',
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-updatepackage btn-sm btn-primary" style="cursor: pointer" data-id="${row.id}" data-isactive="${row.isactive}">
                                    ${statusText}
                                </button>
                            </div>`
                        ]);
                    });
                    tablePackage.clear().rows.add(dataFormattedPackage).draw();

                    res.listCategoryByRetail.forEach((row, i) => {
                        const statusText = row.isactive == 0 ? "Activated" : "Unactivated";
                        dataFormattedRetail.push([
                            i + 1,
                            row.categoryname || '',
                            row.productname || '',
                            row.type || '',
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-updateretail btn-sm btn-primary" style="cursor: pointer" data-id="${row.id}" data-isactive="${row.isactive}">
                                    ${statusText}
                                </button>
                            </div>`
                        ]);
                    });
                    tableRetail.clear().rows.add(dataFormattedRetail).draw();

                    $(document).on('click', '.btn-updatetreatment', function () {
                        const id = $(this).data('id');
                        const isactive = $(this).data('isactive');
                        openEditModal(id, isactive)
                    });

                    $(document).on('click', '.btn-updatepackage', function () {
                        const id = $(this).data('id');
                        const isactive = $(this).data('isactive');
                        openEditModal(id, isactive)
                    });

                    $(document).on('click', '.btn-updateretail', function () {
                        const id = $(this).data('id');
                        const isactive = $(this).data('isactive');
                        openEditModal(id, isactive)
                    });
                },
                error: function () {
                    $('#report-body').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                },
                complete: function () {
                    $('#loadingIndicator').hide();
                }
            });
        }
        fetchData();

        function openEditModal(id, isactive) {
            const isactiveupdate = isactive == 1 ? 0 : 1
            const formData = {
                id: id,
                isactive: isactiveupdate
            };

            Swal.fire({
                title: 'Sedang memproses...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '<?= base_url('ControllerApiApps/updateStatusCategoryByType') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    Swal.close();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        
                        fetchData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: "Terjadi kesalahan saat proses, coba lagi!",
                        confirmButtonText: 'OK'
                    });
                }

            });
        }
    });
</script>



</html>