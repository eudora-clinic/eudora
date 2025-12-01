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
                                    LIST VIDEO CONTENT APPS
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
                                                    <th style="text-align: center;">TITLE</th>
                                                    <th style="text-align: center;">THUMBNAIL</th>
                                                    <th style="text-align: center;">VIDEO LINK URL</th>
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
                            <label for="title" class="form-label mt-2"><strong>TITLE:</strong></label>
                            <input type="text" id="title" class="form-control" name="title">
                        </div>

                        <input type="file" name="video_url" accept="video/*" class="form-control"
                            onchange="previewLampiran(event)">
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
                            <label for="thumbnail" class="form-label mt-2"><strong>IMAGE:</strong></label>
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="form-control"
                                onchange="previewLampiran(event)" />
                        </div>
                    </div>
                    <div id="preview-lampiran" class="mt-3 text-center" style="display: none;">
                        <img id="lampiran-img-preview" src="#" alt="Preview"
                            style="max-width: 100%; max-height: 300px; border: 1px solid #ccc; border-radius: 6px;">
                    </div>
                    <div id="preview-video" class="mt-3 text-center" style="display:none;">
                        <video id="video-preview" controls
                            style="max-width:100%; max-height:300px; border:1px solid #ccc; border-radius:6px;">
                            <source src="" type="video/mp4">
                            Browser kamu tidak mendukung video tag.
                        </video>
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

    $('input[name="video_url"]').on('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            $('#video-preview source').attr('src', url);
            $('#video-preview')[0].load();
            $('#preview-video').show();
        }
    });

    let table;

    function previewLampiran(event) {
        const input = event.target;

        if (input.name === "thumbnail") {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#preview-lampiran").show();
                $("#lampiran-img-preview").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }

        if (input.name === "video_url") {
            const file = input.files[0];
            if (!file) return;

            const url = URL.createObjectURL(file);
            $("#preview-video").show();
            $("#video-preview source").attr("src", url);
            $("#video-preview")[0].load();
        }
    }

    $(document).ready(function () {
        table = $('#tableDailySaless').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "<?= base_url('ControllerApiApps/getVideoContentAppsManagement') ?>",
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: null },
                { data: 'title' },
                {
                    data: 'thumbnail',
                    render: function (data, type, row) {
                        return data
                            ? `<img src="${data}"alt="Image" class="img-thumbnail preview-image" 
                            style="max-width: 80px; cursor: pointer;"
                            data-toggle="modal" data-target="#imagePreviewModal" data-img="${data}"/>`
                            : '<span class="text-muted">No image</span>';
                    }
                },
                { data: 'video_url' },
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


                        return `
                            <button class="btn-primary btn btn-sm btn-update" data-id="${row.id}" data-title="${row.title}" data-isactive="${row.isactive}" data-link="${row.video_url}">Update</button>
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
        const title = $(this).data('title');
        const isactive = $(this).data('isactive');
        // const link = $(this).data('link');

        $('#lampiranModal').modal('show');
        $('#lampiranId').val(id);
        $('#title').val(title);
        $('#isactive').val(isactive);
        // $('#video_url').val(link);

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

        const form = $('#formLampiran')[0];
        const formData = new FormData(form);

        $.ajax({
            url: "<?= base_url('ControllerApiApps/uploadVideoContentApps') ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $('button[type=submit]').prop('disabled', true).text('Uploading...');
            },
            success: function (res) {
                console.log(res);
                if (res.success) {
                    alert('✅ Lampiran berhasil diupload');
                    $('#lampiranModal').modal('hide');
                    if (typeof table !== 'undefined') {
                        table.ajax.reload(null, false);
                    }
                } else {
                    alert('❌ ' + (res.message || 'Gagal upload lampiran'));
                }
            },
            error: function (xhr, status, error) {
                console.error('Error upload:', xhr.responseText);
                alert('❌ Terjadi kesalahan saat upload. Cek console.');
            },
            complete: function () {
                $('button[type=submit]').prop('disabled', false).text('Upload');
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