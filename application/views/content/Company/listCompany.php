<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>

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
                                    LIST COMPANY
                                    <button class="btn btn-primary btn-sm btn-add">ADD</button>
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
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">ADRESS</th>
                                                    <th style="text-align: center;">UMK</th>
                                                    <th style="text-align: center;">CITY</th>
                                                    <th style="text-align: center;">PROVINCE</th>
                                                    <th style="text-align: center;">COUNTRY</th>
                                                    <th style="text-align: center;">POST CODE</th>
                                                    <th style="text-align: center;">PHONE</th>
                                                    <th style="text-align: center;">EMAIL</th>
                                                    <th style="text-align: center;">WEBSITE</th>
                                                    <th style="text-align: center;">ISACTIVE</th>
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
            <div class="modal-dialog modal-lg" role="document" style="max-width: 1200px;">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREATE COMPANY</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <div class="modal-body">
                            <div class="hidden mt-2" id="role-information">
                                <div class="card p-4">
                                    <div class="form-row">
                                        <div class="form-column">
                                            <label for="companyname" class="form-label mt-2"><strong>COMPANY
                                                    NAME:</strong></label>
                                            <input type="text" id="companyname" class="form-control">

                                            <label for="companycode" class="form-label mt-2"><strong>COMPANY
                                                    CODE:</strong></label>
                                            <input type="text" id="companycode" class="form-control"><label
                                                for="address" class="form-label mt-2"><strong>ADDRESS:</strong></label>
                                            <input type="text" id="address" class="form-control">
                                        </div>

                                        <div class="form-column">

                                            <label for="phone" class="form-label mt-2"><strong>PHONE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="phone" class="form-control">

                                            <label for="email" class="form-label mt-2"><strong>EMAIL:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="email" class="form-control">
                                            <label for="postalcode" class="form-label mt-2"><strong>POST
                                                    CODE:</strong><span class="text-danger">*</span></label>
                                            <input type="text" id="postalcode" class="form-control">
                                        </div>


                                        <div class="form-column">
                                            <label for="website" class="form-label mt-2"><strong>WEBSITE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="website" class="form-control">

                                            <label for="cityid" class="form-label mt-2"><strong>CITY:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="cityid" name="cityid" class="form-control">
                                                <option value="">SELECT CITY</option>
                                                <?php foreach ($listCity as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select><label for="provinceid"
                                                class="form-label mt-2"><strong>PROVINCE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="provinceid" name="provinceid" class="form-control">
                                                <option value="">SELECT PROVINCE</option>
                                                <?php foreach ($listProvince as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-column">
                                            <label for="countryid"
                                                class="form-label mt-2"><strong>COUNTRY:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="countryid" name="countryid" class="form-control">
                                                <option value="">SELECT CONTRY</option>
                                                <?php foreach ($listCountry as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['countryname'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
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

        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document" style="max-width: 1200px;">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPDATE COMPANY</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="updateForm">
                        <div class="modal-body">
                            <input type="hidden" id="updateId">
                            <div class="hidden mt-2" id="role-information">
                                <div class="card p-4">
                                    <div class="form-row">
                                        <div class="form-column">
                                            <label for="companynameUpdate" class="form-label mt-2"><strong>COMPANY
                                                    NAME:</strong></label>
                                            <input type="text" id="companynameUpdate" class="form-control">

                                            <label for="companycodeUpdate" class="form-label mt-2"><strong>COMPANY
                                                    CODE:</strong></label>
                                            <input type="text" id="companycodeUpdate" class="form-control"><label
                                                for="addressUpdate"
                                                class="form-label mt-2"><strong>ADDRESS:</strong></label>
                                            <input type="text" id="addressUpdate" class="form-control">
                                        </div>

                                        <div class="form-column">
                                            <label for="phoneUpdate"
                                                class="form-label mt-2"><strong>PHONE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="phoneUpdate" class="form-control">

                                            <label for="emailUpdate"
                                                class="form-label mt-2"><strong>EMAIL:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="emailUpdate" class="form-control">
                                            <label for="postalcodeUpdate" class="form-label mt-2"><strong>POST
                                                    CODE:</strong><span class="text-danger">*</span></label>
                                            <input type="text" id="postalcodeUpdate" class="form-control">
                                        </div>


                                        <div class="form-column">
                                            <label for="websiteUpdate"
                                                class="form-label mt-2"><strong>WEBSITE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="websiteUpdate" class="form-control">

                                            <label for="cityidUpdate"
                                                class="form-label mt-2"><strong>CITY:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="cityidUpdate" name="cityidUpdate" class="form-control">
                                                <option value="">SELECT CITY</option>
                                                <?php foreach ($listCity as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select><label for="provinceidUpdate"
                                                class="form-label mt-2"><strong>PROVINCE:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="provinceidUpdate" name="provinceidUpdate" class="form-control">
                                                <option value="">SELECT PROVINCE</option>
                                                <?php foreach ($listProvince as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-column">
                                            <label for="countryidUpdate"
                                                class="form-label mt-2"><strong>COUNTRY:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="countryidUpdate" name="countryidUpdate" class="form-control">
                                                <option value="">SELECT CONTRY</option>
                                                <?php foreach ($listCountry as $j) { ?>
                                                    <option value="<?= $j['id'] ?>">
                                                        <?= $j['countryname'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>


                                            <label for="" class="form-label mt-2"><strong> STATUS:</strong><span
                                                    class="text-danger">*</span></label>
                                            <select id="isactiveUpdate" name="isactiveUpdate" class="form-control"
                                                required="true" aria-required="true">
                                                <option value="0">Nonaktif</option>
                                                <option value="1">Aktif</option>
                                            </select>


                                        </div>
                                    </div>
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

        function fetchData() {
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);
            const dataFormatted = [];

            $.ajax({
                url: "<?= base_url('ControllerCompany/getCompanyMaster') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    res.listCompany?.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.companycode || '',
                            row.companyname || '',
                            row.address || '',
                            row.umk || '',
                            row.cityname || '',
                            row.provincename || '',
                            row.countryname || '',
                            row.postalcode || '',
                            row.phone || '',
                            row.email || '',
                            row.website || '',
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary"  style="cursor: pointer" data-id="${row.id}">Update</button>
                            </div>`
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();

                    $(document).on('click', '.btn-update', function () {
                        const id = $(this).data('id');
                        editCompany(id);
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


        window.fetchData = fetchData;

        fetchData();

        $('.btn-add').click(function () {
            $.ajax({
                url: '<?= base_url('ControllerCompany/getCompanyById/') ?>' + '0',
                type: 'GET',
                success: function (response) {
                    $('#companyModal').remove();
                    $('body').append(response);
                    $('#companyModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Terjadi kesalahan:", error);
                }
            });
        });

        function formatTimeHM(datetimeStr) {
            const date = new Date(datetimeStr);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerCompany/getCompanyMasterById/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data
                        $('#updateModal').modal('show');
                        $('#updateId').val(data.id);
                        $('#companynameUpdate').val(data.companyname);
                        $('#companycodeUpdate').val(data.companycode);
                        $('#addressUpdate').val(data.address);
                        $('#phoneUpdate').val(data.phone);
                        $('#emailUpdate').val(data.email);
                        $('#postalcodeUpdate').val(data.postalcode);
                        $('#websiteUpdate').val(data.website);
                        $('#cityidUpdate').val(data.cityid);
                        $('#provinceidUpdate').val(data.provinceid);
                        $('#countryidUpdate').val(data.countryid);
                        $('#isactiveUpdate').val(data.isactive);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        $('#createForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                companyname: $('#companyname').val(),
                companycode: $('#companycode').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                postalcode: $('#postalcode').val(),
                website: $('#website').val(),
                cityid: $('#cityid').val(),
                provinceid: $('#provinceid').val(),
                countryid: $('#countryid').val(),
                address: $('#address').val(),
            };

            $.ajax({
                url: '<?= base_url('ControllerCompany/createCompanyMaster') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil ditambahkan.',
                            confirmButtonText: 'OK'
                        });

                        $('#createModal').modal('hide');
                        fetchData();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('gatau error apa');
                }

            });
        });

        $('#updateForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                id: $('#updateId').val(),
                companyname: $('#companynameUpdate').val(),
                companycode: $('#companycodeUpdate').val(),
                phone: $('#phoneUpdate').val(),
                email: $('#emailUpdate').val(),
                postalcode: $('#postalcodeUpdate').val(),
                website: $('#websiteUpdate').val(),
                cityid: $('#cityidUpdate').val(),
                provinceid: $('#provinceidUpdate').val(),
                countryid: $('#countryidUpdate').val(),
                address: $('#addressUpdate').val(),
                isactive: $('#isactiveUpdate').val(),
            };
            $.ajax({
                url: '<?= base_url('ControllerCompany/updateCompanyMaster') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil diperbarui.',
                            confirmButtonText: 'OK'
                        });
                        $('#updateModal').modal('hide');
                        fetchData();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('gatau error apa');
                }

            });
        });


        function editCompany(id) {
            $.ajax({
                url: '<?= base_url('ControllerCompany/getCompanyById/') ?>' + id,
                type: 'GET',
                success: function (response) {
                    $('#companyModal').remove();
                    $('body').append(response);
                    $('#companyModal').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error("Terjadi kesalahan:", error);
                }
            });
        }



    });
</script>



</html>