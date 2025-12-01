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

        .select2-container .select2-selection--single {
            height: 45px !important;
            padding: 6px 12px !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
            display: flex !important;
            align-items: center !important;
            margin-top: 10px;
        }

        /* Teks di dalam Select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px !important;
            font-size: 14px;
        }

        /* Panah di sebelah kanan */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px !important;
            top: 10px !important;
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
                                    LIST EMPLOYEE APPS
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
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">EXPERTISE</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">IMAGE</th>
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
                        <h5 class="modal-title">ADD EMPLOYEE APPS</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <div class="modal-body">
                            <input type="number" hidden id="employeeid" name="employeeid" required>
                            <input type="number" hidden id="jobid" name="jobid" required>
                            <div class="form-column">
                                <label for="employeeid">EMPLOYEE</label>
                                <select id="employeeSearch" required data-placeholder="Search Employee"></select>
                            </div>

                            <div class="form-column" hidden>
                                <label for="expertise" class="form-label mt-2"><strong>EXPERTISE:</strong></label>
                                <input type="text" id="expertise" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="locationid">LOCATION</label>
                                <select id="locationid" name="locationid" class="form-control" required>
                                    <?php foreach ($locationList as $j) { ?>
                                        <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                    <?php } ?>
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
                        <h5 class="modal-title">UPDATE EMPLOYEE APPS</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="updateForm">
                        <div class="modal-body">
                            <input type="hidden" id="updateId">
                            <div class="col-md-6">
                                <label for="employeeid" class="form-label mt-2">EMPLOYEE</label>
                                <input readonly type="text" id="employeeameUpdate" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="expertiseUpdate" class="form-label mt-2"><strong>EXPERTISE:</strong></label>
                                <input type="text" id="expertiseUpdate" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="locationidUpdate">LOCATION</label>
                                <select id="locationidUpdate" name="locationidUpdate" class="form-control" required>
                                    <?php foreach ($locationList as $j) { ?>
                                        <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                    <?php } ?>
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


        <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="formLampiran" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="lampiranId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Lampiran</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="lampiran" id="lampiran" accept="image/*" required class="form-control" onchange="previewLampiran(event)"/>
                        </div>

                        <div id="preview-lampiran" class="mt-3 text-center" style="display: none;">
                            <img id="lampiran-img-preview" src="#" alt="Preview"
                                style="max-width: 100%; max-height: 300px; border: 1px solid #ccc; border-radius: 6px;">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>

    function previewLampiran(event) {
        const input = event.target;
        const preview = document.getElementById('lampiran-img-preview');
        const container = document.getElementById('preview-lampiran');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                container.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            container.style.display = 'none';
            preview.src = '#';
        }
    }
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
                url: "<?= base_url('ControllerApiApps/getListEmployeeApps') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res);

                    res.listEmployeeApps.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.employeename || '',
                            row.expertise || '',
                            row.jobname || '',
                            row.locationname || '',
                            `
                            <td class="row justify-content-center align-items-center">
                            ${row.image ? `
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                    Lampiran
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btn-view-lampiran" href="#" data-id="${row.id}" data-file="${row.image}">Lihat</a>
                                    <a class="dropdown-item btn-edit-lampiran" href="#" data-id="${row.id}">Update</a>
                                </div>
                            </div>` : `
                            <button class="btn btn-sm btn-success btn-add-lampiran" data-id="${row.id}">Tambah Lampiran</button>`}
                        </td>`,
                            (row.status == 1 ? 'Aktif' : (row.status == 0 ? 'Nonaktif' : '')),
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


        $(document).on('click', '.btn-add-lampiran, .btn-edit-lampiran', function () {
            const id = $(this).data('id');
            $('#lampiranId').val(id);
            $('#lampiranModal').modal('show');
        });


        $('#formLampiran').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('ControllerApiApps/uploadEmployeeAppsPhoto') ?>",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (res) {
                    console.log(res);

                    if (res.success) {
                        alert('Lampiran berhasil diupdate');
                        $('#lampiranModal').modal('hide');
                        fetchData();
                    } else {
                        alert(res.message || 'Gagal update lampiran');
                    }
                }
            });
        });

        $(document).on('click', '.btn-view-lampiran', function () {
            const file = $(this).data('file');
            const url = "<?= base_url('uploads/doctor/') ?>" + file;
            window.open(url, '_blank');
        });

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerApiApps/getEmployeeAppsById/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data
                        $('#updateModal').modal('show');
                        $('#updateId').val(data.id);
                        $('#employeeameUpdate').val(data.employeename);
                        $('#expertiseUpdate').val(data.expertise);
                        $('#locationidUpdate').val(data.locationid);
                        $('#isactiveUpdate').val(data.status);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        $('#createForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                employeeid: $('#employeeid').val(),
                jobid: $('#jobid').val(),
                expertise: $('#expertise').val(),
                locationid: $('#locationid').val(),
            };

            $.ajax({
                url: '<?= base_url('ControllerApiApps/addEmployeeApps') ?>',
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
                expertise: $('#expertiseUpdate').val(),
                locationid: $('#locationidUpdate').val(),
                status: $('#isactiveUpdate').val(),
            };

            console.log(formData);

            $.ajax({
                url: '<?= base_url('ControllerApiApps/updateCompanyMaster') ?>',
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


        $("#employeeSearch").select2({
            width: '100%',
            ajax: {
                url: "ControllerHr/searchEmployee",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#employeeSearch").on("select2:select", function (e) {
            let data = e.params.data;
            $("#employeeid").val(data.data.id);
            $("#locationid").val(data.data.locationid);
            $("#jobid").val(data.data.jobid);

            if (data.data.jobid == 12) {
                $("#expertise").closest(".form-column").removeAttr("hidden");
            } else {
                $("#expertise").closest(".form-column").attr("hidden", true);
                $("#expertise").val("");
            }
        });

    });
</script>



</html>