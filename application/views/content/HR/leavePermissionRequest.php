<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Create Shift</title>
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            /* background-color: #0056b3; */
        }

        .table-wrapper {
            margin-top: 20px;
            overflow-x: auto;
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
        }

        select.form-select {
            border-radius: 8px;
            padding: 10px;
        }

        .form-control {
            border-radius: 8px;
            padding: 8px;
            font-size: 13px;
        }

        .hidden {
            display: none;
        }

        .input-group-text {
            background-color: #e9ecef;
        }


        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
        }

        .jumlah-input {
            text-align: center;
        }

        .remove-btn {
            color: #fff !important;
            background-color: #dc3545 !important;
            border: none;
            transition: 0.3s ease;
        }

        .remove-btn:hover {
            background-color: #c82333 !important;
            box-shadow: 0px 2px 6px rgba(220, 53, 69, 0.5);
        }

        .use-btn {
            color: #fff;
            /* background-color: #007bff; */
            border: none;
            transition: 0.3s ease;
        }

        .use-btn:hover {
            /* background-color: #0056b3; */
            box-shadow: 0px 2px 6px rgba(0, 123, 255, 0.5);
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            color: #333;
        }

        /* Menambahkan efek fokus pada input dan dropdown */
        input[type="text"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Styling untuk dropdown */
        select {
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        select:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk option dalam dropdown */
        option {
            padding: 10px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
            /* Atur ukuran minimal kolom */
            box-sizing: border-box;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }


        /* Container utama Select2 */
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



        @media (min-width: 992px) {
            .mycontainer {
                width: 108.5vw;
                transform: scale(0.90);
            }

        }
    </style>
</head>

<div>
    <div class="mycontaine">
        <div>
            <ul class="nav nav-tabs active mt-3">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#pending-tab">Pending </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#approved-tab">Approved</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#rejected-tab">Rejected</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div class="panel-body tab-pane show active" id="pending-tab" role="tabpanel">
                        <div class="card">
                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                style="font-weight: bold; color: #666666;">
                                Leave Request Pending
                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#addLeavePermissionModal">
                                    + Add Leave Permission
                                </button>
                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="tableEmployeeLeavePermissionRequest"
                                        class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="text-align: center;">No.</th>
                                                <th style="text-align: center;">Name</th>
                                                <th style="text-align: center;">Leave Type</th>
                                                <th style="text-align: center;">Start Date</th>
                                                <th style="text-align: center;">End Date</th>
                                                <th style="text-align: center;">Duration</th>
                                                <th style="text-align: center;">Reason</th>
                                                <th style="text-align: center;">Lampiran</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="report-bodyPending">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body tab-pane" id="approved-tab" role="tabpanel">
                        <div class="card">
                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                style="font-weight: bold; color: #666666;">
                                Leave Request Approved
                                </a>
                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="tableEmployeeLeavePermissionApproved"
                                        class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="text-align: center;">No.</th>
                                                <th style="text-align: center;">Name</th>
                                                <th style="text-align: center;">Leave Type</th>
                                                <th style="text-align: center;">Start Date</th>
                                                <th style="text-align: center;">End Date</th>
                                                <th style="text-align: center;">Duration</th>
                                                <th style="text-align: center;">Reason</th>
                                                <th style="text-align: center;">Approved By</th>
                                                <th style="text-align: center;">Lampiran</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="report-bodyApproved">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body tab-pane" id="rejected-tab" role="tabpanel">
                        <div class="card">
                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                style="font-weight: bold; color: #666666;">
                                Leave Request Rejected
                                </a>
                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="tableEmployeeLeavePermissionRejected"
                                        class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-thead">
                                            <tr>
                                                <th style="text-align: center;">Name</th>
                                                <th style="text-align: center;">Leave Type</th>
                                                <th style="text-align: center;">Start Date</th>
                                                <th style="text-align: center;">End Date</th>
                                                <th style="text-align: center;">Duration</th>
                                                <th style="text-align: center;">Reason</th>
                                                <th style="text-align: center;">Rejected By</th>
                                            </tr>
                                        </thead>
                                        <tbody id="report-bodyRejected">
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

    <!-- Modal -->
    <div class="modal fade" id="addLeavePermissionModal" tabindex="-1" aria-labelledby="addLeavePermissionLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="leavePermissionForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLeavePermissionLabel">Add Leave Permission</h5>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="number" hidden id="employeeid" name="employeeid" required>
                            <div class="col-md-6">
                                <label for="employeeid" class="form-label mt-2">Employee</label>
                                <select id="employeeSearch" required data-placeholder="Search Employee"></select>
                            </div>
                            <div class="col-md-6">
                                <label for="leavetypeid" class="form-label mt-2">Leave Type</label>
                                <select id="leavetypeid" name="leavetypeid" required>
                                    <?php foreach ($listType as $j) { ?>
                                        <option value="<?= $j['id'] ?>">
                                            <?= $j['leavename'] ?> - <?= $j['leavecode'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="start_date" class="form-label mt-2">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label mt-2">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label mt-2">Status</label>
                                <select id="status" name="status" required="true" aria-required="true">
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="attachment" class="form-label mt-2">Attachment</label>
                                <input type="file" class="form-control" id="attachment" name="attachment" required>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label mt-2">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    let level = <?= $level ?>;

    $(document).ready(function () {
        const tablePending = $('#tableEmployeeLeavePermissionRequest').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        const tableApproved = $('#tableEmployeeLeavePermissionApproved').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        const tableRejected = $('#tableEmployeeLeavePermissionRejected').DataTable({
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
            const dataFormattedApproved = [];
            const dataFormattedRejected = [];

            $.ajax({
                url: "<?= base_url('ControllerHr/getListLeavePermissionPending') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    console.log(res);

                    res.listRequestPending?.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.employee_name || '',
                            row.leavename || '',
                            row.start_date || '',
                            row.end_date || '',
                            row.end_date || '',
                            row.description || '',
                            row.attachment || '',
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary approveBtn"  style="cursor: pointer" data-id="${row.id}">Approve</button>
                                <button class="btn-update btn-sm btn-primary rejectBtn"  style="cursor: pointer" data-id="${row.id}">Reject</button>
                            </div>`,
                        ]);
                    });
                    tablePending.clear().rows.add(dataFormatted).draw();

                    res.listRequestApproved?.forEach((row, i) => {
                        let buttonReject = level == 1 ? '-' : `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary rejectBtn"  style="cursor: pointer" data-id="${row.id}">Reject</button>
                            </div>`;
                        dataFormattedApproved.push([
                            i + 1,
                            row.employee_name || '',
                            row.leavename || '',
                            row.start_date || '',
                            row.end_date || '',
                            row.end_date || '',
                            row.description || '',
                            row.user_name || '',
                            row.attachment || '',
                            buttonReject,
                        ]);
                    });

                    tableApproved.clear().rows.add(dataFormattedApproved).draw();

                    res.listRequestRejected?.forEach((row, i) => {
                        dataFormattedRejected.push([
                            i + 1,
                            row.employee_name || '',
                            row.leavename || '',
                            row.start_date || '',
                            row.end_date || '',
                            row.end_date || '',
                            row.description || '',
                            row.attachment || ''
                        ]);
                    });
                    tableRejected.clear().rows.add(dataFormattedRejected).draw();
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
        });


        $('#leavePermissionForm').on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '<?= base_url("ControllerHr/addLeavePermission") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Success', 'Leave permission added successfully!', 'success');
                        $('#addLeavePermissionModal').modal('hide');
                        fetchData();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to save leave permission.', 'error');
                }
            });
        });
        function updateStatus(id, status) {
            $.ajax({
                url: '<?= base_url("ControllerHr/updateStatusLeavePermission") ?>',
                type: 'POST',
                data: { id: id, status: status },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        swal({
                            title: "Berhasil!",
                            text: "Status cuti berhasil diperbarui!",
                            icon: "success",
                            timer: 1500,
                            buttons: false
                        }).then(() => {
                            fetchData();
                        });
                    } else {
                        swal("Gagal", response.message || "Gagal memperbarui status", "error");
                    }
                },
                error: function (xhr, status, error) {
                    swal("Error", "Terjadi kesalahan koneksi ke server.", "error");
                    console.error(xhr.responseText);
                }
            });
        }

        // Ajax untuk Approve
        $(document).on('click', '.approveBtn', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin ingin menyetujui cuti ini?',
                text: 'Status akan diperbarui menjadi Disetujui.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    updateStatus(id, 1);
                }
            });
        });

        $(document).on('click', '.rejectBtn', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Tolak pengajuan cuti ini?',
                text: 'Status akan diperbarui menjadi Ditolak.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    updateStatus(id, 2);
                }
            });

        });
    });


</script>

</html>