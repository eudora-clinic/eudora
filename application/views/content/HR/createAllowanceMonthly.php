<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Create Shift</title>
    <style>
        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 10px !important;
            margin-bottom: 10px !important;
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


        @media (min-width: 992px) {
            .mycontainer {
                width: 108.5vw;
                transform: scale(0.90);
            }

        }
    </style>

    <?php
    $db_oriskin = $this->load->database('oriskin', TRUE);

    $selected_period = $this->input->get('period'); // hasilnya 2025-08
    
    $employees = $db_oriskin->query("select * from msemployee order by name")->result_array();
    $allowance_types = $db_oriskin->query("select * from msallowancetype order by id")->result_array();
    ?>
</head>


<div>
    <div class="mycontaine">
        <div class="card p-2 col-md-6">
            <form method="get" action="<?= current_url() ?>" class="w-100">
                <div class="card col-12">
                    <div class="row">
                        <!-- Input Period -->
                        <div class="col-md-12">
                            <div class="form-group p-2">
                                <label for="period">PERIOD (Sort by Apply Date)</label>
                                <input type="month" id="periodFilter" name="period" class="form-control filter_period"
                                    value="<?= htmlspecialchars($this->input->get('period') ?? date('Y-m')) ?>"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <div class="">
            <div class="row gx-4">
                <div class="col-md-12 mt-3">
                    <div class="panel-body tab-pane show active" id="outlet">
                        <div class="card">
                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-right"
                                style="font-weight: bold; color: #666666;">
                                <div class="d-flex justify-content-between align-items-center mb-3 w-100">
                                    <div class="text-start">
                                        <h5 class="mb-0" id="titleEmployeeAllowance">Employe Allowance by Month : </h5>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary me-2" data-toggle="modal"
                                            data-target="#allowanceModal">
                                            + Add Employee Allowance
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#infoModal">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                    </div>
                                </div>

                            </h3>
                            <div class="table-wrapper p-4">
                                <div class="table-responsive">
                                    <table id="allowanceTable" class="table table-striped table-bordered"
                                        style="width:100%">
                                        <thead class="bg-thead">
                                            <tr class="align-center">
                                                <th>No.</th>
                                                <th>Employee Nama</th>
                                                <th>Allowance Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Period</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diinject AJAX -->
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


<!-- Modal Information Aloowance Monthly -->
<div class="modal fade" id="allowanceModal" tabindex="-1" role="dialog" aria-labelledby="allowanceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allowanceModalLabel">
                    Add Employee Allowance
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="addAllowanceForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Employee</label>
                            <select name="employeeid" class="form-control select2" required>
                                <option value="">-- Select Employee --</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?= $emp['id'] ?>"><?= $emp['name'] . ' (' . $emp['nip'] . ')' ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Allowance Type</label>
                            <select name="allowancetypeid" class="form-control" required>
                                <option value="">-- Select Allowance Type --</option>
                                <?php foreach ($allowance_types as $type): ?>
                                    <option value="<?= $type['id'] ?>"><?= $type['allowance_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Date Start</label>
                            <input type="date" name="datestart" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Date End</label>
                            <input type="date" name="dateend" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Period</label>
                            <input type="month" name="period" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Amount</label>
                            <input type="number" name="amount" step="0.01" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="detailModalLabel">Detail Allowance</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Allowance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id" />
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editEmployeeName" class="form-label">Employee Name</label>
                            <input type="text" class="form-control" id="editEmployeeName" name="employee_name" disabled>
                            <input type="hidden" class="form-control" id="editEmployeeName" name="employeeid" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editAllowanceType" class="form-label">Allowance Type</label>
                            <input type="text" class="form-control" id="editAllowanceType" name="allowance_type"
                                disabled>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editStartDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="editStartDate" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editEndDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="editEndDate" name="end_date">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editPeriod" class="form-label">Period</label>
                            <input type="month" class="form-control" id="editPeriod" name="period" required>
                        </div>
                        <div class="col-md-6">
                            <label for="editAmount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="editAmount" name="amount" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function () {
        // Inisialisasi Select2 pada select employee dalam modal allowanceModal
        $('#allowanceModal').on('shown.bs.modal', function () {
            $(this).find('select.select2').select2({
                dropdownParent: $('#allowanceModal'),
                minimumInputLength: 2  // Minimal input 2 karakter
            });
        });

        // Jika modal ditutup dan dibuka ulang, agar select2 tidak duplikat
        $('#allowanceModal').on('hidden.bs.modal', function () {
            $(this).find('select.select2').select2('destroy');
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select an Employee",
            allowClear: true,
            minimumInputLength: 2
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#customerIdConsultation").select2({
            width: '100%',
            placeholder: "Search employee name",
            ajax: {
                url: "<?= base_url('ControllerHr/searchEmployee') ?>",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        // Simpan ID employee ke hidden input agar ikut terkirim di form
        $("#customerIdConsultation").on("select2:select", function (e) {
            const selectedCustomer = e.params.data;
            if ($("#employee_id_hidden").length === 0) {
                $("<input>").attr({
                    type: "hidden",
                    id: "employee_id_hidden",
                    name: "customer_id",
                    value: selectedCustomer.id
                }).appendTo("form");
            } else {
                $("#employee_id_hidden").val(selectedCustomer.id);
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#addAllowanceForm').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: '<?= base_url('saveAllowanceMonthly') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Allowance saved successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            $('#allowanceModal').modal('hide');
                            $('#addAllowanceForm')[0].reset();
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    alert('AJAX error: ' + error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        function formatDateToDMY(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            if (isNaN(d)) return dateStr; // fallback jika bukan tanggal valid
            const day = ("0" + d.getDate()).slice(-2);
            const month = ("0" + (d.getMonth() + 1)).slice(-2);
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;
        }
        const table = $('#allowanceTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 15, 20, 25, 50, 100],
            autoWidth: false,
            ordering: true,
            destroy: true,
        });

        function fetchAllowanceData(period = null) {
            $.ajax({
                url: "<?= base_url('ControllerHr/get_allowance_all') ?>",
                method: "GET",
                dataType: "json",
                data: { period: period },
                success: function (res) {
                    let titleText = "Employee Allowance by Month";
                    if (period) {
                        titleText += " : " + period;
                    }
                    $("#titleEmployeeAllowance").text(titleText);

                    let dataFormatted = [];
                    res.forEach((row, i) => {

                        let actionButtons = `<button class="btn btn-info detailBtn" data-id="${row.id}">Detail</button> `;
                        actionButtons += `<button class="btn btn-warning editBtn" data-id="${row.id}">Edit</button> `;
                        actionButtons += `<button class="btn btn-danger deleteBtn" data-id="${row.id}">Delete</button>`;

                        dataFormatted.push([
                            i + 1,
                            row.employee_name || '',
                            row.allowance_type || '',
                            formatDateToDMY(row.datestart) || '-',
                            formatDateToDMY(row.dateend) || '',
                            row.period || '',
                            new Intl.NumberFormat('id-ID').format(row.amount || 0),
                            actionButtons
                        ]);
                    });

                    table.clear();
                    table.rows.add(dataFormatted);
                    table.draw();
                },
                error: function () {
                    alert('Gagal memuat data allowance.');
                }
            });
        }

        fetchAllowanceData($('#periodFilter').val());

        $('#periodFilter').on('change', function () {
            fetchAllowanceData($(this).val());
        });

        // Detail button click
        $(document).on('click', '.detailBtn', function () {
            let id = $(this).data('id');
            $('#detailContent').html('Loading...');
            $('#detailModal').modal('show');

            $.ajax({
                url: "<?= base_url('ControllerHr/get_allowance_detail') ?>",
                method: "GET",
                data: { id: id },
                dataType: "json",
                success: function (res) {
                    if (res) {
                        let html = `
                               <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Employee Name:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        ${res.employee_name}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Allowance Type:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        ${res.allowance_type}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Start Date:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        ${res.datestart}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>End Date:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        ${res.dateend}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Period:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        ${res.period}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Amount:</strong> </p>
                                    </div>
                                    <div class="col-md-6">
                                        Rp ${new Intl.NumberFormat('id-ID').format(res.amount)}
                                    </div>
                                </div>
                            `;
                        $('#detailContent').html(html);
                    } else {
                        $('#detailContent').html('Data tidak ditemukan.');
                    }
                },
                error: function () {
                    $('#detailContent').html('Gagal mengambil data.');
                }
            });
        });

        // Edit button click
        $(document).on('click', '.editBtn', function () {
            let id = $(this).data('id');
            // Reset form
            $('#editForm')[0].reset();
            $('#editId').val(id);

            $.ajax({
                url: "<?= base_url('ControllerHr/get_allowance_detail') ?>",
                method: "GET",
                data: { id: id },
                dataType: "json",
                success: function (res) {
                    if (res) {
                        $('#editEmployeeName').val(res.employee_name);
                        $('#editAllowanceType').val(res.allowance_type);
                        $('#editStartDate').val(res.datestart);
                        $('#editEndDate').val(res.dateend);
                        $('#editPeriod').val(res.period);
                        $('#editAmount').val(res.amount);
                        $('#editModal').modal('show');
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                },
                error: function () {
                    alert('Gagal mengambil data.');
                }
            });
        });

        // Submit edit form
        $('#editForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('ControllerHr/update_allowance') ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (res) {
                    if (res.status == 'success') {
                        $('#editModal').modal('hide');
                        fetchAllowanceData($('#periodFilter').val());
                        alert('Data berhasil diperbarui.');
                    } else {
                        alert('Gagal memperbarui data.');
                    }
                },
                error: function () {
                    alert('Error saat memperbarui data.');
                }
            });
        });

        // Delete button with SweetAlert
        $(document).on('click', '.deleteBtn', function () {
            let id = $(this).data('id');

            swal({
                title: "Apakah Anda yakin?",
                text: "Data akan dihapus permanen!",
                icon: "warning",
                buttons: ["Batal", "Ya, hapus!"], // tombol cancel dan confirm
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "<?= base_url('ControllerHr/delete_allowance') ?>",
                            method: "POST",
                            data: { id: id },
                            dataType: "json",
                            success: function (res) {
                                if (res.status == 'success') {
                                    fetchAllowanceData($('#periodFilter').val());
                                    swal("Terhapus!", "Data berhasil dihapus.", "success");
                                } else {
                                    swal("Gagal!", "Data gagal dihapus.", "error");
                                }
                            },
                            error: function () {
                                swal("Error!", "Gagal menghapus data.", "error");
                            }
                        });
                    } else {
                        console.log('Penghapusan dibatalkan user');
                    }
                });
        });

    });
</script>

</html>