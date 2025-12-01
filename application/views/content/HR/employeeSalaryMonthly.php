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

        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
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
    $deduction_types = $db_oriskin->query("select * from mssalarydeductiontype order by id")->result_array();
    $companies = $db_oriskin->query("select * from mscompany order by id")->result_array();
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class="row">
                <form method="get" action="<?= current_url() ?>" class="w-100">
                    <div class="card col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <label for="companyFilter">Company</label>
                                        <select id="companyFilter" class="form-control">
                                            <option value="">-- All Company --</option>
                                            <?php foreach ($companies as $c): ?>
                                                <option value="<?= $c['id'] ?>"><?= $c['companyname'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="periodFilter">PERIOD (Sort by Apply Date)</label>
                                        <input type="month" id="periodFilter" name="period" class="form-control"
                                            value="<?= htmlspecialchars($this->input->get('period') ?? date('Y-m')) ?>"
                                            required>
                                    </div>
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
                                            <h5 class="mb-0">Employee Salary by Month</h5>
                                        </div>
                                        <div class="text-end">
                                            <a href="<?= base_url('employeeAllowanceMonthly'); ?>"
                                                class="btn btn-primary me-2">
                                                + Add Allowance Salary Monthly
                                            </a>
                                            <a href="<?= base_url('employeeDeductionMonthly'); ?>"
                                                class="btn btn-primary me-2">
                                                + Add Deduction Salary Monthly
                                            </a>
                                        </div>
                                    </div>

                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm align-middle"
                                            id="employeeSalaryTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th rowspan="2" class="text-center">No</th>
                                                    <th rowspan="2" class="text-center">NAMA</th>
                                                    <th rowspan="2" class="text-center">JABATAN</th>
                                                    <th rowspan="2" class="text-center">COMPANY</th>
                                                    <th rowspan="2" class="text-center">SISA HUTANG SEBELUM</th>
                                                    <th rowspan="2" class="text-center">PINJAMAN</th>
                                                    <th rowspan="2" class="text-center">GAJI</th>
                                                    <th colspan="<?= count($allowance_types) + 1 ?>"
                                                        class="text-center">TUNJANGAN</th>
                                                    <th colspan="<?= count($deduction_types) + 1 ?>"
                                                        class="text-center">POTONGAN</th>
                                                    <th rowspan="2" class="text-center">NO REKENING</th>
                                                    <th rowspan="2" class="text-center">BANK</th>
                                                    <th rowspan="2" class="text-center">NAMA REKENING</th>
                                                    <th rowspan="2" class="text-center">TOTAL GAJI</th>
                                                    <th rowspan="2" class="text-center">POT PINJAMAN</th>
                                                    <th rowspan="2" class="text-center">SISA HUTANG</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">SALARY</th>
                                                    <?php foreach ($allowance_types as $a): ?>
                                                        <th class="text-center"><?= strtoupper($a['allowance_name']) ?></th>
                                                    <?php endforeach; ?>
                                                    <th class="text-center">TOTAL TUNJANGAN</th>
                                                    <?php foreach ($deduction_types as $d): ?>
                                                        <th class="text-center"><?= strtoupper($d['deduction_name']) ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                            <!-- Employee -->
                            <div class="col-md-6 mb-3">
                                <label>Employee</label>
                                <select id="employeeSelect" name="employeeid" class="form-control select2" required>
                                    <option value="">-- Select Employee --</option>
                                    <?php foreach ($employees as $emp): ?>
                                        <option value="<?= $emp['id'] ?>"><?= $emp['name'] . ' (' . $emp['nip'] . ')' ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Period -->
                            <div class="col-md-6 mb-3">
                                <label>Period</label>
                                <input type="month" id="periodSelect" name="period" class="form-control" required>
                            </div>
                        </div>

                        <!-- Allowance Table -->
                        <h5>Allowance</h5>
                        <table class="table table-bordered" id="allowanceTable">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th id="totalAllowance">0</th>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Deduction Table -->
                        <h5>Deduction</h5>
                        <table class="table table-bordered" id="deductionTable">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th id="totalDeduction">0</th>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Final Salary -->
                        <div class="mb-3">
                            <label>Final Salary</label>
                            <input type="number" id="finalSalary" name="final_salary" class="form-control" step="0.01">
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
                                <input type="text" class="form-control" id="editEmployeeName" name="employee_name"
                                    disabled>
                                <input type="hidden" class="form-control" id="editEmployeeName" name="employeeid"
                                    required>
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
            let table = $("#employeeSalaryTable").DataTable({
                pageLength: 10,
                responsive: true,
                data: [],
                columns: [
                    { title: "No" },
                    { title: "Nama Karyawan" },
                    { title: "Jabatan" },
                    { title: "Perusahaan" },
                    { title: "Sisa Hutang" },
                    { title: "Pinjaman" },
                    { title: "Gaji Pokok" },
                    <?php foreach ($allowance_types as $a): ?>
                                { title: "<?= $a['allowance_name'] ?>" },
                    <?php endforeach; ?>
                    { title: "Total Tunjangan" },
                    <?php foreach ($deduction_types as $d): ?>
                                { title: "<?= $d['deduction_name'] ?>" },
                    <?php endforeach; ?>
                    { title: "Total Potongan" },
                    { title: "No Rekening" },
                    { title: "Bank" },
                    { title: "Nama Rekening" },
                    { title: "Total Gaji" },
                    { title: "Pot Pinjaman" },
                    { title: "Sisa Hutang" }
                ]
            });

            function loadSalaryTable() {
                let period = $("#periodFilter").val();
                let companyId = $("#companyFilter").val();

                $.ajax({
                    url: "<?= base_url('ControllerHr/getDataSalary'); ?>",
                    type: "GET",
                    data: {
                        period: period,
                        companyid: companyId
                    },
                    dataType: "json",
                    success: function (res) {
                        console.log(res);
                        
                        table.clear();

                        if (res.employees && res.employees.length > 0) {
                            let no = 1;

                            res.employees.forEach(emp => {
                                let row = [
                                    no++,
                                    emp.employee_name,
                                    emp.job_name || "-",
                                    emp.company_name || "-",
                                    "0", // Sisa hutang
                                    "0", // Pinjaman
                                    parseFloat(emp.salary || 0).toLocaleString('id-ID')
                                ];

                                // Allowance
                                let totalAllowance = 0;
                                <?php foreach ($allowance_types as $a): ?>
                                    if (emp.allowancetypeid == <?= $a['id'] ?>) {
                                        totalAllowance += parseFloat(emp.allowance_amount || 0);
                                        row.push(parseFloat(emp.allowance_amount || 0).toLocaleString('id-ID'));
                                    } else {
                                        row.push("0");
                                    }
                                <?php endforeach; ?>
                                row.push(totalAllowance.toLocaleString('id-ID'));
                                let totalDeduction = 0;
                                <?php foreach ($deduction_types as $d): ?>
                                    if (emp.deductiontypeid == <?= $d['id'] ?>) {
                                        totalDeduction += parseFloat(emp.deduction_amount || 0);
                                        row.push(parseFloat(emp.deduction_amount || 0).toLocaleString('id-ID'));
                                    } else {
                                        row.push("0");
                                    }
                                <?php endforeach; ?>
                                row.push(totalDeduction.toLocaleString('id-ID'));

                                row.push(emp.account || "-");
                                row.push(emp.bank_name || "-");
                                row.push(emp.account_name || "-");

                                let totalGaji = (parseFloat(emp.salary || 0) + totalAllowance - totalDeduction);
                                row.push(totalGaji.toLocaleString('id-ID'));
                                row.push("0");
                                row.push("0");

                                table.row.add(row);
                            });
                        }

                        table.draw();
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }

            // Load awal
            loadSalaryTable();

            // Reload ketika period / company berubah
            $("#periodFilter, #companyFilter").change(function () {
                loadSalaryTable();
            });
        });
    </script>

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
            $("#customerIdConsultation").on("select2:select", function (e) {
                const selectedCustomer = e.params.data;

                // Kalau belum ada hidden input, buat
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
            $('.select2').select2();

            function loadData() {
                let empId = $('#employeeSelect').val();
                let period = $('#periodSelect').val();

                if (empId && period) {
                    $.ajax({
                        url: "<?= base_url('ControllerHr/get_salary_data') ?>",
                        method: "POST",
                        data: { employeeid: empId, period: period },
                        dataType: "json",
                        success: function (res) {
                            // Allowance
                            let allowanceHTML = '';
                            let totalAllowance = 0;
                            res.allowance.forEach(function (row) {
                                allowanceHTML += `<tr>
                                    <td>${row.allowance_type}</td>
                                    <td>${Number(row.amount).toLocaleString('id-ID')}</td>
                                </tr>`;
                                totalAllowance += parseFloat(row.amount);
                            });
                            $('#allowanceTable tbody').html(allowanceHTML);
                            $('#totalAllowance').text(totalAllowance.toLocaleString('id-ID'));

                            // Deduction
                            let deductionHTML = '';
                            let totalDeduction = 0;
                            res.deduction.forEach(function (row) {
                                deductionHTML += `<tr>
                                    <td>${row.deduction_name}</td>
                                    <td>${Number(row.amount).toLocaleString('id-ID')}</td>
                                </tr>`;
                                totalDeduction += parseFloat(row.amount);
                            });
                            $('#deductionTable tbody').html(deductionHTML);
                            $('#totalDeduction').text(totalDeduction.toLocaleString('id-ID'));

                            // Final Salary
                            let finalSalary = parseFloat(res.salary) + totalAllowance - totalDeduction;
                            $('#finalSalary').val(finalSalary.toFixed(2));
                        }
                    });
                }
            }

            $('#employeeSelect, #periodSelect').change(loadData);
        });

    </script>
</body>

</html>