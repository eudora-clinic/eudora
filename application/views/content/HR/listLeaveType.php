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
                                    LIST LEAVE TYPE PERMISSION
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
                                                    <th style="text-align: center;">LEAVECODE</th>
                                                    <th style="text-align: center;">SHIFTNAME</th>
                                                    <th style="text-align: center;">DESCRIPTION</th>
                                                    <th style="text-align: center;">ISDEDUCTED QUOTA</th>
                                                    <th style="text-align: center;">ISDEDUCTED SALLARY</th>
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
                        <h5 class="modal-title">CREATE LEAVE TYPE</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <div class="modal-body">
                            <div class="form-column">
                                <label for="leavename" class="form-label mt-2"><strong>LEAVE NAME:</strong></label>
                                <input type="text" id="leavename" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="leavecode" class="form-label mt-2"><strong>LEAVE CODE:</strong></label>
                                <input type="text" id="leavecode" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="leavedescription"
                                    class="form-label mt-2"><strong>DESCRIPTION:</strong></label>
                                <input type="text" id="leavedescription" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong> IS DEDUCTED QUOTA:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isdeductedquota" name="isdeductedquota" class="form-control" required="true"
                                    aria-required="true">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong>IS DEDUCTED SALLARY:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isdeductedsallary" name="isdeductedsallary" class="form-control"
                                    required="true" aria-required="true">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">UPDATE LEAVE TYPE</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="updateForm">
                        <div class="modal-body">
                            <input type="hidden" id="updateId">
                            <div class="form-column">
                                <label for="leavenameUpdate" class="form-label mt-2"><strong>LEAVE NAME:</strong></label>
                                <input type="text" id="leavenameUpdate" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="leavecodeUpdate" class="form-label mt-2"><strong>LEAVE CODE:</strong></label>
                                <input type="text" id="leavecodeUpdate" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="leavedescriptionUpdate"
                                    class="form-label mt-2"><strong>DESCRIPTION:</strong></label>
                                <input type="text" id="leavedescriptionUpdate" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong> IS DEDUCTED QUOTA:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isdeductedquotaUpdate" name="isdeductedquotaUpdate" class="form-control" required="true"
                                    aria-required="true">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong>IS DEDUCTED SALLARY:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isdeductedsallaryUpdate" name="isdeductedsallaryUpdate" class="form-control"
                                    required="true" aria-required="true">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong> STATUS:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isactiveUpdate" name="isactiveUpdate" class="form-control" required="true"
                                    aria-required="true">
                                    <option value="0">Nonaktif</option>
                                    <option value="1">Aktif</option>
                                </select>
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
                url: "<?= base_url('ControllerHr/getListLeaveType') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res);

                    res.listLeaveType.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.leavecode || '',
                            row.leavename || '',
                            row.leavedescription || '',
                            (row.isdeductedquota == 1 ? 'Yes' : (row.isdeductedquota == 0 ? 'No' : '')),
                            (row.isdeductedsallary == 1 ? 'Yes' : (row.isdeductedsallary == 0 ? 'No' : '')),
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
                url: '<?= base_url('ControllerHr/getDetailLeaveType/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data
                        $('#updateModal').modal('show');
                        $('#updateId').val(data.id);
                        $('#leavenameUpdate').val(data.leavename);
                        $('#leavecodeUpdate').val(data.leavecode);
                        $('#leavedescriptionUpdate').val(data.leavedescription);
                        $('#isdeductedquotaUpdate').val(data.isdeductedquota);
                        $('#isdeductedsallaryUpdate').val(data.isdeductedsallary);
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
                leavename: $('#leavename').val(),
                leavecode: $('#leavecode').val(),
                leavedescription: $('#leavedescription').val(),
                isdeductedquota: $('#isdeductedquota').val(),
                isdeductedsallary: $('#isdeductedsallary').val(),
            };

            $.ajax({
                url: '<?= base_url('ControllerHr/createLeaveType') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    console.log(response);

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
                leavename: $('#leavenameUpdate').val(),
                leavecode: $('#leavecodeUpdate').val(),
                leavedescription: $('#leavedescriptionUpdate').val(),
                isdeductedquota: $('#isdeductedquotaUpdate').val(),
                isdeductedsallary: $('#isdeductedsallaryUpdate').val(),
                isactive: $('#isactiveUpdate').val(),
            };
            $.ajax({
                url: '<?= base_url('ControllerHr/updateLeaveTypeMaster') ?>',
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

    });
</script>



</html>