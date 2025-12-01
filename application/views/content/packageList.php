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
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666666;">
                                    PACKAGE LIST
                                    <a href="https://sys.eudoraclinic.com:84/app/addPackage" class="btn btn-primary btn-sm">
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
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">ID</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">PRICE</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">POINT SECTION</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($packageList as $row) {
                                                ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['ID'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CODE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['NAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PRICE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PUBLISHED'] ?></td>
                                                        <td style="text-align: center;"><?= $row['POINTSECTION'] ?></td>
                                                        <td style="text-align: center;">
                                                            <button class="btn-primary btn btn-sm" onclick="goToDetail(<?= $row['ID'] ?>, <?= $row['PRODUCTBENEFITID'] ?>)">DETAIL</button>
                                                            <button class="btn btn-sm <?= ($row['PUBLISHED'] == 'Yes') ? 'btn-danger' : 'btn-success' ?>"
                                                                onclick="updatePublished(<?= $row['ID'] ?>, '<?= $row['PUBLISHED'] ?>')">
                                                                <?= ($row['PUBLISHED'] == 'Yes') ? 'UNPUBLISHED' : 'PUBLISHED' ?>
                                                            </button>
                                                            <button class="btn btn-primary btn-sm pointsection-btn" data-id="<?= $row['ID'] ?>">Point Section</button>
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

    <div class="modal fade modal-transparent" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="voidModalLabel" aria-hidden="true">
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
<script>
    $(document).ready(function() {
       var table = $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "drawCallback": function(settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
        });

        $('#filterPublished').on('change', function() {
            table.column(5).search(this.value).draw(); // Kolom ke-8 (Branch)
        });

        var selectedId;

        // Ketika tombol Void diklik
        $(document).on("click", ".pointsection-btn", function() {
            selectedId = $(this).data("id"); // Ambil ID dari tombol
            $("#voidModal").modal("show"); // Tampilkan modal
        });

        $("#confirmMedis").click(function() {
            $.ajax({
                url: "<?= base_url() . 'App/pointSection' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 1
                },
                success: function(response) {
                    console.log(response);

                    if (response.status === 'success') {
                        alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });

        $("#confirmNonMedis").click(function() {
            $.ajax({
                url: "<?= base_url() . 'App/pointSection' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 2
                },
                success: function(response) {

                    if (response.status === 'success') {
                        alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                      
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });

        $("#confirmNot").click(function() {
            $.ajax({
                url: "<?= base_url() . 'App/pointSection' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: 3
                },
                success: function(response) {
                    console.log(response);

                    if (response.status === 'success') {
                        alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                       
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });
    });

    function goToDetail(id, productbenefitid) {
        let base_url = "<?= base_url('packageDetail'); ?>";
        let queryParams = new URLSearchParams({
            packageId: id,
            productbenefitid: productbenefitid
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }

    function updatePublished(id, published) {
        let data;
        if (published == 'Yes') {
            data = {
                id: id,
                isactive: 0
            }
        } else {
            data = {
                id: id,
                isactive: 1
            }
        }

        console.log(data);

        if (confirm("Apakah Anda yakin ingin mengupdate data ini?")) {
            $.ajax({
                url: "<?= base_url() . 'App/updatePackagePublished' ?>",
                type: "POST",
                dataType: 'json',
                data: data,
                success: function(response) {
                    if (response.status === 'success') {
                        alert("Berhasil di update!");
                    } else {
                        alert("Terjadi kesalahan saat memproses update.");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan saat memproses update.");
                }
            });
        }
    }


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>