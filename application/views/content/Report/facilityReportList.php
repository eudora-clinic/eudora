<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - List Supplier</title>

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
        textarea,
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
        textarea:focus,
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

    <?php
    $level = $this->session->userdata('level');
    
    ?>
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
                                    LIST ASSET
                                    <a href="https://sys.eudoraclinic.com:84/app/addFacilityByLocation" type="button" class="btn btn-primary">+ ADD DATA</a>
                                </h3>

                                <div class="card-body">
                                   <div class="row mb-3">
  
                                        <div class="col-md-3">
                                            <label for="filterLocation" class="form-label">CHOOSE LOCATION</label>
                                           <select id="filterLocation" class="form-control" 
                                                <?= ($level == 1 ? 'disabled' : '') ?>>
                                                <?php if ($level == 1): ?>
                                                    <?php 
                                                        $user_location = $this->session->userdata('locationid'); 
                                                        $locName = '';
                                                        foreach ($location as $c) {
                                                            if ($c['id'] == $user_location) {
                                                                $locName = $c['text'];
                                                                break;
                                                            }
                                                        }
                                                    ?>
                                                    <option value="<?= $user_location ?>" selected><?= $locName ?></option>
                                                <?php else: ?>
                                                    <option value="">-- ALL LOCATION --</option>
                                                    <?php foreach($location as $c): ?>
                                                        <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="filterCategory" class="form-label">CHOOSE CATEGORY</label>
                                            <select id="filterCategory" class="form-control">
                                            <option value="">-- ALL CATEGORY --</option>
                                            <?php foreach($category as $c): ?>
                                                <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="filterStatus" class="form-label">CHOOSE STATUS</label>
                                            <select name="filterStatus" id="filterStatus" class="form-control" required>
                                                <option value="">==== ALL STATUS =====</option>
                                                <option value="0">BAIK</option>
                                                <option value="1">KURANG BAIK</option>
                                                <option value="2">TIDAK BERFUNGSI</option>
                                            </select>
                                        </div>
                                    </div>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="supplierTable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CATEGORY</th>
                                                    <th style="text-align: center;">ASSET CODE</th>
                                                    <th style="text-align: center;">ASSET NAME</th>
                                                    <th style="text-align: center;">TYPE</th>
                                                    <th style="text-align: center;">MERK</th>
                                                    <th style="text-align: center;">DESCRIPTION</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">CONDITION</th>
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
    </div>
</body>


<script>
$(function () {

    let supplierTable = $('#supplierTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '<?= base_url("ControllerReport/getAllFacility") ?>',
            type: 'GET',
            data: function (d) {
                d.locationid = $('#filterLocation').val();
                d.categoryid = $('#filterCategory').val();
                d.status = $('#filterStatus').val();
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, className: 'text-center', render: (data, type, row, meta) => meta.row + 1 },
            { data: 'category_name', defaultContent: '-' },
            { data: 'facility_code', defaultContent: '-' },
            { data: 'facility_name', defaultContent: '-' },
            { data: 'type', defaultContent: '-' },
            { data: 'merk', defaultContent: '-' },
            { data: 'description', defaultContent: '-' },
            { data: 'location_name', defaultContent: '-' },
            { 
                data: 'status',
                className: 'text-center',
                render: function (data) {
                    const status = parseInt(data);
                    switch (status) {
                        case 0: return '<span class="badge bg-success">Baik</span>';
                        case 1: return '<span class="badge bg-warning text-dark">Kurang Baik</span>';
                        case 2: return '<span class="badge bg-danger">Tidak Berfungsi</span>';
                        default: return '-';
                    }
                }
            },
            { 
                data: 'id',
                className: 'text-center',
                render: id => `
                    <a href="https://sys.eudoraclinic.com:84/app/conditionReport/${id}" 
                    class="btn btn-sm btn-primary">
                    Detail
                    </a>
                `
            }
        ]
    });

    function loadSuppliers() {
        supplierTable.ajax.reload(null, false);
    }

    $('#filterLocation, #filterCategory, #filterStatus').on('change', function () {
        loadSuppliers();
    });

    $(document).on('click', '.detailBtn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '<?= base_url("ControllerPurchasing/getSupplierById/") ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#detailSupplierCode').text(data.suppliercode || '-');
                $('#detailSupplierName').text(data.name || '-');
                $('#detailAddress').text(data.address || '-');
                $('#detailProvince').text(data.province_name || '-');
                $('#detailCity').text(data.city_name || '-');
                $('#detailZipcode').text(data.zipcode || '-');
                $('#detailPhone').text(data.phone || '-');
                $('#detailEmail').text(data.email || '-');
                $('#modalDetail').modal('show');

                let tbody = $('#detailSalesTable tbody');
                tbody.empty();

                if (data.sales && data.sales.length > 0) {
                    data.sales.forEach(function(s, index) {
                        tbody.append(`
                            <tr>
                                <td>${s.nama}</td>
                                <td>${s.email ?? ''}</td>
                                <td>${s.phonenumber ?? ''}</td>
                                <td>${s.address ?? ''}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    // jika belum ada sales
                    tbody.append(`
                        <tr>
                            <td><input type="text" name="items[0][nama]" class="form-control form-control-sm" required></td>
                            <td><input type="email" name="items[0][email]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="items[0][phone]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="items[0][address]" class="form-control form-control-sm"></td>
                            <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button></td>
                        </tr>
                    `);
                }
            },
            error: function () {
                Swal.fire("Error", "Gagal memuat data supplier!", "error");
            }

        });
    });

    function initSelect2($el, placeholder, url) {
        $el.select2({
            placeholder: placeholder,
            allowClear: true,
            width: "100%",
            ajax: {
                url: url,
                type: "GET",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return { search: params.term || "" };
                },
                processResults: function (response) {
                    const data = response.data || response || [];
                    return {
                        results: Array.isArray(data)
                            ? data.map(item => ({ id: item.id, text: item.text }))
                            : []
                    };
                },
                cache: true
            },
            minimumInputLength: 0
        });
    }

    function forceNumber(v, fallback = 0) {
        const n = Number(v);
        return Number.isFinite(n) ? n : fallback;
    }

    initSelect2($("#locationid"), "SELECT LOCATION", "<?= base_url('ControllerReport/getAllLocation') ?>");
    initSelect2($("#categoryid"), "SELECT CATEGORY", "<?= base_url('ControllerReport/getFacilityCategory') ?>");

    $(document).on('click', '.editBtn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: '<?= base_url("ControllerPurchasing/getSupplierById/") ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#editId').val(data.id);
                $('#editName').val(data.name);
                $('#editSupplierCode').val(data.suppliercode);
                $('#editAddress').val(data.address);
                $('#editZipcode').val(data.zipcode);
                $('#editPhone').val(data.phone);
                $('#editEmail').val(data.email);
                $('#editbank_name').val(data.bank_name);
                $('#editaccount').val(data.account);

                if (data.provinceid && data.province_name) {
                    const provOption = new Option(data.province_name, data.provinceid, true, true);
                    $('#editProvince').append(provOption).trigger('change');
                } else {
                    $('#editProvince').val(null).trigger('change');
                }

                if (data.cityid && data.city_name) {
                    $('#editCity').empty();
                    const cityOption = new Option(data.city_name, data.cityid, true, true);
                    $('#editCity').append(cityOption).trigger('change');
                } else {
                    $('#editCity').val(null).trigger('change');
                }

                $('#modalEdit').modal('show');
            },
            error: function () {
                Swal.fire("Error", "Gagal memuat data supplier!", "error");
            }
        });
    });

    $('#editSupplierForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("ControllerPurchasing/updateSupplier") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#modalEdit').modal('hide');
                    loadSuppliers();
                    Swal.fire("Berhasil!", "Data supplier berhasil diperbarui.", "success");
                } else {
                    Swal.fire("Gagal!", res.db_error || "Gagal memperbarui data.", "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Terjadi kesalahan saat update data!", "error");
            }
        });
    });

    // === SALES SUPPLIER DYNAMIC FORM ===
    let salesIndex = 1; // index row sales

    $('#addRow').on('click', function () {
        let newRow = `
            <tr>
                <td><input type="text" name="items[${salesIndex}][nama]" class="form-control form-control-sm" required></td>
                <td><input type="email" name="items[${salesIndex}][email]" class="form-control form-control-sm"></td>
                <td><input type="text" name="items[${salesIndex}][phone]" class="form-control form-control-sm"></td>
                <td><input type="text" name="items[${salesIndex}][address]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRow">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#salesTable tbody').append(newRow);
        salesIndex++;
    });

    // Hapus row sales
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });

    // Reset form supplier + sales ketika modal dibuka
    $('#createModal').on('show.bs.modal', function () {
        $('#supplierForm')[0].reset();
        $('#provinceid, #cityid').val(null).trigger('change');
        $('#salesTable tbody').html(`
            <tr>
                <td><input type="text" name="items[0][nama]" class="form-control form-control-sm" required></td>
                <td><input type="email" name="items[0][email]" class="form-control form-control-sm"></td>
                <td><input type="text" name="items[0][phone]" class="form-control form-control-sm"></td>
                <td><input type="text" name="items[0][address]" class="form-control form-control-sm"></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button></td>
            </tr>
        `);
        salesIndex = 1;
    });

    $(document).on('click', '.deleteBtn', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Ubah status supplier ini?',
            text: "Status keaktifan supplier akan diubah.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // kompatibel untuk SweetAlert2 lama & baru
            if (result.isConfirmed || result.value) {
                $.ajax({
                    url: '<?= base_url("ControllerPurchasing/deleteSupplier") ?>',
                    type: 'POST',
                    data: { 
                        id: id,
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res.status === 'success') {
                            loadSuppliers();
                            Swal.fire('Berhasil!', 'Status supplier berhasil diubah.', 'success');
                        } else {
                            Swal.fire('Gagal!', res.message || 'Gagal mengubah status supplier.', 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // debug error server
                        Swal.fire('Error!', 'Terjadi kesalahan saat request.', 'error');
                    }
                });
            }
        });
    });


});
</script>



</html>