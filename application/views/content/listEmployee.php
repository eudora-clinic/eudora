<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Package List</title>

    <style>
        .form-group label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-control {
            padding: 6px 10px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 15px;
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
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            border-radius: 8px 8px 0 0;
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

        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }
    </style>
</head>

<?php
$detail = isset($employeeDetail[0]) ? $employeeDetail[0] : [];

// echo json_encode($detail);
$level = $this->session->userdata('level');
?>

<body>
    <div>
        <div class="mycontaine">
            <div>
                <ul class="nav nav-tabs active mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#employee">EMPLOYEE LIST</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#employeeAppointment">EMPLOYEE APPOINTMENT</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#employeeInvoice">EMPLOYEE INVOICE</a>
                    </li>
                </ul>
            </div>
            <div class="">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="employee">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    EMPLOYEE LIST
                                    <?php if ($level != 1): ?>
                                        <a href="https://sys.eudoraclinic.com:84/app/addEmployee"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-circle"></i> TAMBAH
                                        </a>
                                    <?php endif; ?>

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
                                    <?php if ($level != 1) { ?>
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="filterBranch">OUTLET:</label>
                                            <select id="filterBranch" multiple="multiple">
                                                <option value="">ALL</option>
                                                <?php foreach ($locationListt as $location) { ?>
                                                    <option value="<?= htmlspecialchars($location['name']) ?>">
                                                        <?= htmlspecialchars($location['name']) ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    <?php } ?>

                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">NIP</th>
                                                    <th style="text-align: center;">CELLPHONENUMBER</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">COMPANY</th>
                                                    <th style="text-align: center;">END OF CONTRACT</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane" id="employeeAppointment">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    EMPLOYEE APPOINTMENT
                                    <a href="https://sys.eudoraclinic.com:84/app/addEmployeeAppointment"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="row p-4 filter-container">
                                    <div class="form-group" style="display: flex; flex-direction: column;">
                                        <label for="filterPublishedEmpAppt"
                                            style="margin-bottom: 4px;">PUBLISHED:</label>
                                        <select id="filterPublishedEmpAppt" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="Yes">PUBLISHED</option>
                                            <option value="No">UNPUBLISHED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableEmployeeAppointment" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">OUTLET</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listEmployeeAppointment as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEECODE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['NAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['JOBNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PUBLISHED'] ?></td>
                                                        <td style="text-align: center;">
                                                            <button
                                                                class="btn btn-sm <?= ($row['PUBLISHED'] == 'Yes') ? 'btn-danger' : 'btn-success' ?>"
                                                                onclick="updatePublished(<?= $row['EMPAPPTID'] ?>, '<?= $row['PUBLISHED'] ?>')">
                                                                <?= ($row['PUBLISHED'] == 'Yes') ? 'UNPUBLISHED' : 'PUBLISHED' ?>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane" id="employeeInvoice">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    EMPLOYEE INVOICE
                                    <a href="https://sys.eudoraclinic.com:84/app/addEmployeeInvoice"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="row p-4 filter-container">
                                    <div class="form-group" style="display: flex; flex-direction: column;">
                                        <label for="filterPublishedEmpInvoice"
                                            style="margin-bottom: 4px;">PUBLISHED:</label>
                                        <select id="filterPublishedEmpInvoice" class="form-control">
                                            <option value="">ALL</option>
                                            <option value="Yes">PUBLISHED</option>
                                            <option value="No">UNPUBLISHED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableEmployeeInvoice" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">OUTLET</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listEmployeeInvoice as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['EMPLOYEECODE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['NAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['JOBNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PUBLISHED'] ?></td>
                                                        <td style="text-align: center;">
                                                            <button
                                                                class="btn btn-sm <?= ($row['PUBLISHED'] == 'Yes') ? 'btn-danger' : 'btn-success' ?>"
                                                                onclick="updatePublishedEmpInvoice(<?= $row['EMPAPPTID'] ?>, '<?= $row['PUBLISHED'] ?>')">
                                                                <?= ($row['PUBLISHED'] == 'Yes') ? 'UNPUBLISHED' : 'PUBLISHED' ?>
                                                            </button>
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

    <div class="modal fade modal-transparent modal-fullscreen" id="updateModal" tabindex="-1" role="dialog"
        aria-labelledby="updateModalLabel">
        <div class="modal-dialog modal-lg" role="dialog" style="margin: auto; ">
            <div class="modal-content">
                <form id="formUpdateEmployee">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Karyawan</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="updateId" name="id">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" id="updateName" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" id="updateNIP" name="nip" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input type="text" id="updatePhone" name="phone" class="form-control">
                        </div>

                        <div class="form-column">
                            <label for="updateLocation">Lokasi</label>
                            <select id="updateLocation" name="updateLocation" class="form-control" required>
                                <?php foreach ($locationListt as $j) { ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="updateJob">Jabatan</label>
                            <select id="updateJob" name="updateJob" class="form-control" required <?= $level == 1 ? 'disabled' : '' ?>>
                                <?php foreach ($jobList as $j) { ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="updateIsactive">Status Aktif</label>
                            <select id="updateIsactive" name="updateIsactive" class="form-control" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>




                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    $(document).ready(function () {

        const table = $('#tableDailySales').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: 'https://sys.eudoraclinic.com:84/app/App/getListEmployee',
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [
                { data: null },
                { data: 'EMPLOYEECODE' },
                { data: 'NAME' },
                { data: 'NIP' },
                { data: 'CELLPHONENUMBER' },
                { data: 'LOCATIONNAME' },
                { data: 'companyname' },
                { data: 'enddate' },
                { data: 'JOBNAME' },
                { data: 'PUBLISHED' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                        <button class="btn-primary btn btn-sm" onclick="goToDetail(${row.HDRID})">DETAIL</button>
                        <button class="btn btn-sm btn-warning" onclick='openUpdateModal(${JSON.stringify(row)})'>UPDATE</button>
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
            },
            select: true,
        });

        $('#filterPublished').on('change', function () {
            table.column(9).search(this.value).draw();
        });

        $('#filterBranch').select2({
            width: '200px'
        });

        $('#filterBranch').on('change', function () {
            var values = $(this).val().join('|');
            table.column(5).search(values, true, false).draw();
        })

        var tableAppt = $('#tableEmployeeAppointment').DataTable({
            "pageLength": 5,
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
        $('#filterPublishedEmpAppt').on('change', function () {
            tableAppt.column(5).search(this.value).draw();
        });

        var tableInvoice = $('#tableEmployeeInvoice').DataTable({
            "pageLength": 5,
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
        $('#filterPublishedEmpInvoice').on('change', function () {
            tableInvoice.column(5).search(this.value).draw(); // Kolom ke-8 (Branch)
        });
    });

    $('#formUpdateEmployee').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: '<?= base_url('App/updateEmployeeBackOffice') ?>',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#updateModal').modal('hide');
                    $('#tableDailySales').DataTable().ajax.reload();
                    Swal.fire('Berhasil!', 'Data berhasil diperbarui.', 'success');
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            }
        });
    });


    function openUpdateModal(row) {
        // Isi field form di modal dengan data dari row
        $('#updateId').val(row.HDRID);
        $('#updateName').val(row.NAME);
        $('#updateNIP').val(row.NIP);
        $('#updatePhone').val(row.CELLPHONENUMBER);
        $('#updateLocation').val(row.LOCATIONID);
        $('#updateJob').val(row.JOBID);
        $('#updateIsactive').val(row.ISACTIVE);

        console.log(row);


        // Tampilkan modal
        $('#updateModal').modal('show');
    }

    function goToDetail(id) {
        let base_url = "<?= base_url('employeeDetail'); ?>";
        let queryParams = new URLSearchParams({
            employeeId: id,
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
                url: "<?= base_url() . 'App/updateEmpAppt' ?>",
                type: "POST",
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Berhasil di update!");
                        location.reload();
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        }
    }

    function updatePublishedEmpInvoice(id, published) {
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

        if (confirm("Apakah Anda yakin ingin mengupdate data ini?")) {
            $.ajax({
                url: "<?= base_url() . 'App/updateEmpInvoice' ?>",
                type: "POST",
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Berhasil di update!");
                        location.reload();
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        }
    }


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableEmployeeAppointment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableEmployeeInvoice').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>