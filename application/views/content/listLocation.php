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
                                    LIST OUTLET
                                    <a href="https://sys.eudoraclinic.com:84/app/detailLocation" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">SHORTCODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">SHORTNAME</th>
                                                    <th style="text-align: center;">COMPANYNAME</th>
                                                    <th style="text-align: center;">WHATSAPP</th>
                                                    <th style="text-align: center;">ADDRESS</th>`
                                                    <th style="text-align: center;">IMAGE</th>
                                                    <th style="text-align: center;">IMAGE 2</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listLocation as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['shortcode'] ?></td>
                                                        <td style="text-align: center;"><?= $row['name'] ?></td>
                                                        <td style="text-align: center;"><?= $row['shortname'] ?></td>
                                                        <td style="text-align: center;"><?= $row['companyname'] ?></td>
                                                        <td style="text-align: center;"><?= $row['mobilephone'] ?></td>
                                                        <td style="text-align: center;"><?= $row['address'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?php if (!empty($row['image'])): ?>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                        type="button" data-toggle="dropdown">
                                                                        IMAGE
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="previewImage('<?= base_url($row['image']) ?>')">Lihat</a>
                                                                        <a class="dropdown-item btn-edit-lampiran" href="#"
                                                                            data-id="<?= $row['id'] ?>" data-type="1">Update</a>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-success btn-add-lampiran"
                                                                    data-id="<?= $row['id'] ?>" data-type="1"></button>Tambah Image</button>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <?php if (!empty($row['image2'])): ?>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                        type="button" data-toggle="dropdown">
                                                                        IMAGE 2
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="previewImage('<?= base_url($row['image2']) ?>')">Lihat</a>
                                                                        <a class="dropdown-item btn-edit-lampiran" href="#"
                                                                            data-id="<?= $row['id'] ?>" data-type="2">Update</a>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-success btn-add-lampiran"
                                                                    data-id="<?= $row['id'] ?>" data-type="2">Tambah Image</button>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <button class="btn-primary btn btn-sm"
                                                                onclick="goToDetail(<?= $row['id'] ?>)">DETAIL</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
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

    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Preview">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="formLampiran" enctype="multipart/form-data">
                <input type="hidden" name="id" id="lampiranId">
                <input type="hidden" name="type" id="lampiranType">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Lampiran</h5>
                        <button id="closePreviewModal" type="button" class="btn btn-danger btn-sm"
                            data-dismiss="modal">X</button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="lampiran" id="lampiran" accept="image/*" required class="form-control"
                            onchange="previewLampiran(event)" />
                    </div>

                    <div id="preview-lampiran" class="mt-3 text-center" style="display: none;">
                        <img id="lampiran-img-preview" src="#" alt="Preview"
                            style="max-width: 100%; max-height: 300px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script>

    function previewLampiran(event) {
        const input = event.target;
        const preview = document.getElementById('lampiran-img-preview');
        const container = document.getElementById('preview-lampiran');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
            preview.src = '#';
        }
    }
    $(document).ready(function () {
        var table = $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
        });
    });

    $(document).on('click', '.btn-add-lampiran, .btn-edit-lampiran', function () {
        const id = $(this).data('id');
        const type = $(this).data('type');
        $('#lampiranId').val(id);
        $('#lampiranType').val(type);
        $('#lampiranModal').modal('show');
    });

    function previewImage(url) {
        document.getElementById('modalImage').src = url;
        $('#imagePreviewModal').modal('show');
    }

    function goToDetail(id, ingredientscategoryid) {
        let base_url = "<?= base_url('detailLocation'); ?>";
        let queryParams = new URLSearchParams({
            locationid: id
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }

    $('#formLampiran').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('ControllerApiApps/uploadLocationImage') ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                console.log(res);

                if (res.success) {
                    alert('Lampiran berhasil diupdate');
                    $('#lampiranModal').modal('hide');
                    // fetchData();
                    location.reload();
                } else {
                    alert(res.message || 'Gagal update lampiran');
                }
            }
        });
    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

<script>
    $('#lampiranModal').on('hidden.bs.modal', function () {
        // Reset seluruh input di form
        $('#formLampiran')[0].reset();

        // Sembunyikan preview gambar
        $('#preview-lampiran').hide();
        $('#lampiran-img-preview').attr('src', '#');
    });

</script>

</html>