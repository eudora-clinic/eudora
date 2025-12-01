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
                                    LIST SUPPLIER
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">+ ADD SUPPLIER</button>
                                </h3>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <!-- <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p>Loading data...</p>
                                        </div> -->

                                        <table id="supplierTable" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">SUPPLIER CODE</th>
                                                    <th style="text-align: center;">SUPLIER NAME</th>
                                                    <th style="text-align: center;">ADDRESS</th>
                                                    <th style="text-align: center;">PROVINCE</th>
                                                    <th style="text-align: center;">CITY</th>
                                                    <th style="text-align: center;">ZIPCODE</th>
                                                    <th style="text-align: center;">PHONE</th>
                                                    <th style="text-align: center;">EMAIL</th>
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
                        <h5 class="modal-title">ADD SUPPLIER</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="supplierForm">
                        <div class="modal-body">
                            <div class="hidden mt-2" id="role-information">
                                <div class="p-2">
                                    <div class="form-row">
                                        <div class="form-column">
                                            <label for="warehouse_name"  class="form-label mt-2"><strong>
                                                    SUPPLIER NAME:</strong></label>
                                            <input type="text" name="name" id="name" class="form-control">

                                            <label for="warehouse_code" class="form-label mt-2"><strong>SUPPLIER CODE:</strong></label>
                                            <input type="text" name="suppliercode"  id="suppliercode" class="form-control" required>
                                            <label for="cityid" class="form-label mt-2"><strong>PROVINCE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="provinceid" name="provinceid" class="form-control select2" required></select>
                                            <label for="address" class="form-label mt-2"><strong>ADDRESS:</strong></label>
                                            <textarea type="text" name="address" id="address" class="form-control" required></textarea>
                                        </div>

                                        <div class="form-column">
                                            <label for="phone" class="form-label mt-2"><strong>PHONE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="phone"  id="phone" class="form-control" required>

                                            <label for="email" class="form-label mt-2"><strong>EMAIL:</strong></label>
                                            <input type="email" name="email" id="email" class="form-control">

                                             <label for="cityid" class="form-label mt-2"><strong>CITY:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="cityid" name="cityid" class="form-control" required></select>
                                            <label for="zipcode"  class="form-label mt-2"><strong>ZIPCODE:</strong></label>
                                            <input type="text" name="zipcode" id="zipcode" class="form-control" >
                                            <label for="zipcode"  class="form-label mt-2"><strong>BANK NAME:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" >
                                            <label for="zipcode"  class="form-label mt-2"><strong>ACCOUNT NUMBER:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="account" id="account" class="form-control" >
                                        </div>
                                    </div>

                                    <hr>
                                        <h5 class="mt-3">Sales Supplier</h5>
                                        <table class="table table-bordered table-sm" id="salesTable">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="items[0][nama]" class="form-control form-control-sm" required></td>
                                                    <td><input type="email" name="items[0][email]" class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="items[0][phone]" class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="items[0][address]" class="form-control form-control-sm"></td>
                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-success btn-sm" id="addRow">+ Add Sales</button>
                                </div>
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

        <!-- Modal Detail Supplier -->
         <div class="modal fade" id="modalDetail" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Detail Supplier</h5></div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Code:</strong>
                        </div>
                        <div class="col-md-6">
                            <span id="detailSupplierCode"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Name:</strong> 
                        </div>
                        <div class="col-md-6">
                            <span id="detailSupplierName"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Address:</strong>
                        </div>
                        <div class="col-md-6">
                            <span id="detailAddress"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Province:</strong>
                        </div>
                        <div class="col-md-6">
                            <span id="detailProvince"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>City:</strong> 
                        </div>
                        <div class="col-md-6">
                            <span id="detailCity"></span>
                        </div>
                    </div>
                
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ZipCode:</strong>
                        </div>
                        <div class="col-md-6">
                            <span id="detailZipcode"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Phone:</strong> 
                        </div>
                        <div class="col-md-6">
                            <span id="detailPhone"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-md-6">
                            <span id="detailEmail">
                        </div>
                    </div>
                </div>
                <h5 class="mt-3">Sales Supplier</h5>
                                        <table class="table table-bordered table-sm" id="salesTable">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="items[0][nama]" class="form-control form-control-sm" required></td>
                                                    <td><input type="email" name="items[0][email]" class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="items[0][phone]" class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="items[0][address]" class="form-control form-control-sm"></td>
                                                    <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-trash"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
        <!-- End of Modal Detail Supplier -->


        <!-- Modal Edit Supplier -->
        <div class="modal fade" id="modalEdit" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <form id="editSupplierForm">
                <div class="modal-content ">
                    <div class="modal-header"><h5 class="modal-title">Edit Supplier</h5></div>
                    <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-row">
                        <div class="form-column">
                            <label>Supplier Code</label>
                            <input type="text" id="editSupplierCode" name="suppliercode" class="form-control">
                    
                            <label>Name</label>
                            <input type="text" id="editName" name="name" class="form-control">
                        
                            <label>Address</label>
                            <textarea id="editAddress" name="address" class="form-control"></textarea>
                        
                            <label>Province</label>
                            <select id="editProvince" name="provinceid" class="form-control select2"></select>
                        </div>
                        <div class="form-column">
                            <label>City</label>
                            <select id="editCity" name="cityid" class="form-control select2"></select>
                        
                        
                            <label>Zipcode</label>
                            <input type="text" id="editZipcode" name="zipcode" class="form-control">
                    
                    
                            <label>Phone</label>
                            <input type="text" id="editPhone" name="phone" class="form-control">
                    
                            <label>Email</label>
                            <input type="text" id="editEmail" name="email" class="form-control">

                            <label for="zipcode"  class="form-label mt-2"><strong>BANK NAME:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="bank_name" id="editbank_name" class="form-control" >
                                            <label for="zipcode"  class="form-label mt-2"><strong>ACCOUNT NUMBER:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="account" id="editaccount" class="form-control" >
                        
                        </div>
                    </div>

                    <hr>
                                        <h5 class="mt-3">Sales Supplier</h5>
                                        <table class="table table-bordered table-sm" id="detailSalesTable">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th style="width:50px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" class="btn btn-success btn-sm" id="addRow">+ Add Sales</button>
                        
                    
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
                </form>
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
            url: '<?= base_url("ControllerPurchasing/getSuppliers") ?>',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { data: null, className: 'text-center', render: (data, type, row, meta) => meta.row + 1 },
            { data: 'suppliercode', defaultContent: '-' },
            { data: 'name', defaultContent: '-' },
            { data: 'address', defaultContent: '-' },
            { data: 'province_name', defaultContent: '-' },
            { data: 'city_name', defaultContent: '-' },
            { data: 'zipcode', defaultContent: '-' },
            { data: 'phone', defaultContent: '-' },
            { data: 'email', defaultContent: '-' },
            { data: 'isactive', className: 'text-center', render: data => `
                <button class="btn btn-sm ${Number(data) === 1 ? 'btn-success' : 'btn-danger'}" disabled>
                    ${Number(data) === 1 ? 'Aktif' : 'Nonaktif'}
                </button>
            `},
            { data: 'id', className: 'text-center', render: (id, type, row) => `
                <button class="btn btn-sm btn-info detailBtn" data-id="${id}">Detail</button>
                <button class="btn btn-sm btn-warning editBtn" data-id="${id}">Edit</button>
                <button class="btn btn-sm ${Number(row.isactive) === 0 ? 'btn-success' : 'btn-danger'} deleteBtn" data-id="${id}">
                    ${Number(row.isactive) === 0 ? 'Aktifkan' : 'Nonaktifkan'}
                </button>
            `}
        ]
    });

    function loadSuppliers() {
        supplierTable.ajax.reload(null, false);
    }

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

    $('#provinceid').select2({
        dropdownParent: $('#createModal'),
        placeholder: 'SELECT PROVINCE',
        width: '100%',
        minimumInputLength: 2,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/listProvince') ?>",
            dataType: 'json',
            delay: 250,
            processResults: data => ({ results: data })
        }
    });

    $('#cityid').select2({
        dropdownParent: $('#createModal'),
        placeholder: 'SELECT CITY',
        width: '100%',
        ajax: {
            transport: function (params, success, failure) {
                const provId = $('#provinceid').val();
                if (!provId) { success([]); return; }
                params.url = "<?= base_url('ControllerPurchasing/listCityByProvince') ?>?provinceid=" + provId;
                return $.ajax(params).then(success).catch(failure);
            },
            dataType: 'json',
            delay: 250,
            processResults: data => ({ results: data })
        }
    });

    $('#provinceid').on('change', function () {
        $('#cityid').val(null).trigger('change');
    });

    $('#createModal').on('show.bs.modal', function () {
        $('#supplierForm')[0].reset();
        $('#provinceid, #cityid').val(null).trigger('change');
    });

    $('#supplierForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url("ControllerPurchasing/saveSupplier") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#createModal').modal('hide');
                    loadSuppliers();
                    Swal.fire("Berhasil!", "Supplier berhasil disimpan.", "success");
                } else {
                    Swal.fire("Gagal!", res.db_error || "Gagal menyimpan data!", "error");
                }
            },
            error: function () {
                Swal.fire("Error!", "Terjadi kesalahan saat menyimpan data!", "error");
            }
        });
    });

    $('#editProvince').select2({
        dropdownParent: $('#modalEdit'),
        placeholder: 'SELECT PROVINCE',
        width: '100%',
        minimumInputLength: 0,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/listProvince') ?>",
            dataType: 'json',
            delay: 250,
            processResults: data => ({ results: data || [] })
        }
    });

    $('#editCity').select2({
        dropdownParent: $('#modalEdit'),
        placeholder: 'SELECT CITY',
        width: '100%',
        minimumInputLength: 0,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/listCityByProvince') ?>",
            dataType: 'json',
            delay: 250,
            data: params => ({
                provinceid: $('#editProvince').val(),
                q: params.term
            }),
            processResults: data => ({ results: data || [] })
        }
    });

    $('#editProvince').on('change', function () {
        $('#editCity').val(null).trigger('change');
    });

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