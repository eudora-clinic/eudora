<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>List Kota & Update UMK</title>

    <style>
        body {
            background: #f8f9fc;
        }

        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 20px 20px;
        }

        .btn-update {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            border-radius: 6px;
            color: white;
            transition: 0.3s;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .modal-header {
            background: #007bff;
            color: white;
            border-bottom: none;
        }

        .modal-footer {
            border-top: none;
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
            min-width: 300px;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-6 fw-bold mb-2">
                        <i class="fas fa-city me-3"></i>Manajemen Data Kota
                    </h1>
                    <p class="lead mb-0">Kelola dan update nilai UMK tiap kota dengan mudah</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="card bg-light text-dark">
                        <div class="card-body py-2">
                            <small class="text-muted">Total Kota</small>
                            <h4 class="mb-0 fw-bold"><?= count($cities) ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Kota -->
    <div class=" mb-5">
        <div class="card">
            <div class="card-body">
                <table id="citiesTable" class="table table-hover table-bordered w-100">
                    <thead class="thead-light">
                        <tr>
                            <th>Provinsi</th>
                            <th>Nama Kota</th>
                            <th>UMK</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cities as $city): ?>
                            <tr>
                                <td><?= $city['provincename'] ?></td>
                                <td><?= $city['cityname'] ?></td>
                                <td>Rp <?= number_format($city['umk'], 0, ',', '.') ?></td>
                                <td>
                                    <button class="btn btn-update btn-sm btn-edit" data-id="<?= $city['id'] ?>"
                                        data-name="<?= $city['cityname'] ?>" data-province="<?= $city['provincename'] ?>"
                                        data-umk="<?= $city['umk'] ?>">
                                        <i class="fas fa-pen me-1"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Edit UMK -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit"></i> Edit Nilai UMK</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditUmk">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="cityId">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" id="provinceName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Kota</label>
                            <input type="text" id="cityName" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nilai UMK (Rp)</label>
                            <input type="number" id="cityUmk" name="umk" class="form-control" required min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable
            var table = $('#citiesTable').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: { next: "Berikutnya", previous: "Sebelumnya" }
                },
                responsive: true,
                pageLength: 10
            });

            // Event untuk tombol edit (pakai event delegation agar tetap berfungsi di pagination)
            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const province = $(this).data('province');
                const umk = $(this).data('umk');

                $('#cityId').val(id);
                $('#cityName').val(name);
                $('#provinceName').val(province);
                $('#cityUmk').val(umk);

                $('#editModal').modal('show');
            });

            // Submit form edit UMK
            $('#formEditUmk').on('submit', function (e) {
                e.preventDefault();
                const id = $('#cityId').val();
                const umk = $('#cityUmk').val();

                if (!umk || umk < 0) {
                    showNotification('Nilai UMK tidak valid', 'danger');
                    return;
                }

                $.ajax({
                    url: '<?= site_url("ControllerCompany/updateUmkCity") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: id, umk: umk },
                    beforeSend: function () {
                        $('#formEditUmk button[type="submit"]').prop('disabled', true).text('Menyimpan...');
                    },
                    success: function (res) {
                        if (res.status) {
                            showNotification('Data UMK berhasil diperbarui!', 'success');
                            $('#editModal').modal('hide');
                            const row = $('button[data-id="' + id + '"]').closest('tr');
                            row.find('td:eq(2)').html('Rp ' + parseInt(umk).toLocaleString('id-ID'));
                        } else {
                            showNotification('Gagal memperbarui data: ' + res.message, 'danger');
                        }
                    },
                    error: function () {
                        showNotification('Terjadi kesalahan pada server.', 'danger');
                    },
                    complete: function () {
                        $('#formEditUmk button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Simpan Perubahan');
                    }
                });
            });

            function showNotification(message, type) {
                const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                $('body').append(alertHtml);
                setTimeout(() => { $('.alert').alert('close'); }, 4000);
            }
        });
    </script>
</body>

</html>