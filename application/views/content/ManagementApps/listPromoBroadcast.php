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
                                    PROMO BROADCAST LIST
                                    <a href="<?= base_url('addPromoBroadcast') ?>" class="btn btn-primary btn-sm">
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
                                                    <th style="text-align: center;">DESCRIPTION</th>
                                                    <th style="text-align: center;">IMAGE</th>
                                                    <th style="text-align: center;">CREATE AT</th>
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
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="closePreviewModal">X</button>
                </div>

                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Preview" />
                </div>
            </div>
        </div>
    </div>

</body>


<script>
    const BASE_URL = "<?= base_url() ?>";
    $(document).ready(function () {
        const table = $('#tableDailySaless').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "<?= base_url('get_broadCastList') ?>",
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: null },
                { data: 'title' },
                { data: 'message' },
                { data: 'created_at' },
                {
                    data: 'image_url',
                    render: function (data, type, row) {
                        return data
                            ? `<img src="${BASE_URL + data}"alt="Image" class="img-thumbnail preview-image" 
                            style="max-width: 80px; cursor: pointer;"
                            data-toggle="modal" data-target="#imagePreviewModal" data-img="${BASE_URL + data}"/>`
                            : '<span class="text-muted">No image</span>';
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                        <button class="btn-primary btn btn-sm" onclick="goToDetail(${row.id})">DETAIL</button>
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


    function goToDetail(id) {
        let base_url = "<?= base_url('detailPromoBroadcast'); ?>";
        let queryParams = new URLSearchParams({
            broadcastid: id,
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }

    $(document).on('click', '.preview-image', function () {
        const imageUrl = $(this).data('img');
        $('#modalImage').attr('src', imageUrl);
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