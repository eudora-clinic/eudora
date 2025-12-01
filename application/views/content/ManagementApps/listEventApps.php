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

        #imagePreviewModal .modal-dialog {
            max-width: 100vw;
            max-height: 100vh;
            margin: 0;
            height: 100vh;
        }

        #imagePreviewModal .modal-content {
            height: 100vh;
            border-radius: 0;
        }

        #imagePreviewModal .modal-body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 56px);
            padding: 0;
        }

        #imagePreviewModal #modalImage {
            max-width: 95%;
            max-height: 95%;
            object-fit: contain;
            /* agar gambar proporsional */
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
                                    LIST EVENT APPS
                                    <a class="btn btn-primary btn-sm btn-add">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySaless" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">DESCRIPTION</th>
                                                    <th style="text-align: center;">IMAGE</th>
                                                       <th style="text-align: center;">LINK URL</th>
                                                    <th style="text-align: center;">CREATE AT</th>
                                                    <th style="text-align: center;">STATUS</th>
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

    <!-- Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <h5 class="modal-title">Image Preview</h5>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"
                        id="closePreviewModal">X</button>
                </div>

                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Preview" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="formLampiran" enctype="multipart/form-data">
                <input type="hidden" name="id" id="lampiranId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Event</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-column">
                            <label for="description" class="form-label mt-2"><strong>DESCRIPTION:</strong></label>
                            <input type="text" id="description" class="form-control" name="description">
                        </div>

                         <div class="form-column">
                            <label for="link_url" class="form-label mt-2"><strong>LINK URL:</strong></label>
                            <input type="text" id="link_url" class="form-control" name="link_url">
                        </div>

                        <div class="form-column">
                            <label for="" class="form-label mt-2"><strong> STATUS:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="isactive" name="isactive" class="form-control" required="true"
                                aria-required="true">
                                <option value="0">Nonaktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="lampiran" class="form-label mt-2"><strong>IMAGE:</strong></label>
                            <input type="file" name="lampiran" id="lampiran" accept="image/*" required
                                class="form-control" onchange="previewLampiran(event)" />
                        </div>
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
    const BASE_URL = "<?= base_url() ?>";

    let table;

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
        table = $('#tableDailySaless').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "<?= base_url('ControllerApiApps/getEventApps') ?>",
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: null },
                { data: 'description' },
                {
                    data: 'image',
                    render: function (data, type, row) {
                        return data
                            ? `<img src="${BASE_URL + data}"alt="Image" class="img-thumbnail preview-image" 
                            style="max-width: 80px; cursor: pointer;"
                            data-toggle="modal" data-target="#imagePreviewModal" data-img="${BASE_URL + data}"/>`
                            : '<span class="text-muted">No image</span>';
                    }
                },
                { data: 'link_url' },
                { data: 'createdat' },
                {
                    data: 'isactive',
                    render: function (data) {
                        return data == 1
                            ? '<span class="badge badge-success">Active</span>'
                            : '<span class="badge badge-danger">Nonactive</span>';
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        console.log(data);

                        return `
                            <button class="btn-primary btn btn-sm btn-update" data-id="${row.id}" data-description="${row.description}" data-isactive="${row.isactive}" data-link="${row.link_url}">Update</button>
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
            }
        });
    });

    $(document).on('click', '.btn-update', function () {
        const id = $(this).data('id');
        const description = $(this).data('description');
        const isactive = $(this).data('isactive');
        const link = $(this).data('link');

        $('#lampiranModal').modal('show');
        $('#lampiranId').val(id);
        $('#description').val(description);
        $('#isactive').val(isactive);
          $('#link_url').val(link);

        if (!id) {
            // Tambah data → wajib upload image
            $('#lampiran').attr('required', true);
        } else {
            // Edit data → tidak wajib upload image
            $('#lampiran').removeAttr('required');
        }
    });

    $('.btn-add').click(function () {
        $('#lampiranModal').modal('show');
    });

    $('#lampiranModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); // reset semua input di form
        $('#preview-lampiran').hide(); // sembunyikan preview kalau ada
    });


    $(document).on('click', '.preview-image', function () {
        const imageUrl = $(this).data('img');
        $('#modalImage').attr('src', imageUrl);
    });

    $('#formLampiran').submit(function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('ControllerApiApps/uploadEventImageApps') ?>",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    alert('Lampiran berhasil diupdate');
                    $('#lampiranModal').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    alert(res.message || 'Gagal update lampiran');
                }
            }
        });
    });

</script>

<script>
    document.getElementById('closePreviewModal').addEventListener('click', function () {
        const modalElement = document.getElementById('imagePreviewModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);

        if (modalInstance) {
            modalInstance.hide(); // kalau modal sudah aktif
        } else {
            const newModal = new bootstrap.Modal(modalElement);
            newModal.hide(); // fallback
        }
    });
</script>

</html>