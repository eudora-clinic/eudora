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
    </style>
</head>

<?php
$db_oriskin = $this->load->database('oriskin', TRUE);

$user = $db_oriskin->get_where('usersApps', ['phone' => '085715985505'])->row();

echo json_encode(!$user->token);
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
                                    <button class="btn btn-primary btn-sm btn-add">TAMBAH</button>
                                </h3>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
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
                                                    <th style="text-align: center;">ICON</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREATE CATEGORY</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <input type="hidden" id="updateId">
                        <div class="modal-body">
                            <div class="form-column">
                                <label for="name" class="form-label mt-2"><strong>CATEGORY:</strong></label>
                                <input type="text" id="name" class="form-control">
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

                            <!-- <div class="form-column">
                                <label for="icon" class="form-label mt-2"><strong>ICON:</strong></label>
                                <input type="text" id="icon" class="form-control">
                            </div> -->

                            <div class="form-column">
                                <label for="icon_image">Icon Image</label>
                                <input type="file" id="icon_image" class="form-control" accept="image/*" />
                                <small id="iconPreviewText" style="display:none;color:green;">Gambar siap
                                    diupload</small>
                                <img id="iconPreview" src=""
                                    style="display:none;width:100px;margin-top:8px;border-radius:8px;" />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>

    const iconInput = document.getElementById('icon_image');
    const iconPreview = document.getElementById('iconPreview');
    const iconPreviewText = document.getElementById('iconPreviewText');

    iconInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                iconPreview.src = e.target.result; // base64 image
                iconPreview.style.display = 'block';
                iconPreviewText.style.display = 'inline';
            }
            reader.readAsDataURL(file);
        } else {
            iconPreview.src = '';
            iconPreview.style.display = 'none';
            iconPreviewText.style.display = 'none';
        }
    });

    $(document).ready(function () {
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        function fetchData() {
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);
            const dataFormatted = [];

            $.ajax({
                url: "<?= base_url('ControllerApiApps/getListCategory') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res);

                    res.listJobs.forEach((row, i) => {

                        let iconDisplay = row.icon_image
                            ? `<img src="${row.icon_image}" style="width:50px;height:50px;border-radius:5px;" />`
                            : '';

                        dataFormatted.push([
                            i + 1,
                            row.name || '',
                            iconDisplay,
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary"  style="cursor: pointer" data-id="${row.id}">Update</button>
                            </div>`
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();

                    $(document).on('click', '.btn-update', function () {
                        const id = $(this).data('id');
                        openEditModal(id);
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

        $('.btn-add').click(function () {
            $('#createModal').modal('show');
        });

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerApiApps/getCategoryById/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data
                        $('#createModal').modal('show');
                        $('#updateId').val(data.id);
                        $('#name').val(data.name);
                        $('#isactive').val(data.isactive);
                        $('#icon_image').val(data.icon_image);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: "Terjadi kesalahan saat proses, coba lagi!",
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        $('#createForm').submit(async function (e) {
            e.preventDefault();

            const fileInput = document.getElementById("icon_image");

            let base64Icon = "";
            if (fileInput.files && fileInput.files[0]) {
                base64Icon = await toBase64(fileInput.files[0]); // ✅ pakai await
            }

            const formData = {
                id: $('#updateId').val(),
                name: $('#name').val(),
                isactive: $('#isactive').val(),
                icon_image: base64Icon, // ✅ ini sudah string base64
            };

            console.log(formData);

            $.ajax({
                url: '<?= base_url('ControllerApiApps/createCategory') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#createModal').modal('hide');
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: "Terjadi kesalahan saat proses, coba lagi!",
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Tambahkan fungsi toBase64 di luar submit
        function toBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = (error) => reject(error);
            });
        }



        $('#createModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    });
</script>



</html>