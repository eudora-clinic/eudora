<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <!-- Toastr CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    <!-- Toastr JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
    <style>
        .appointment {
            background: #3498db;
            color: white;
            padding: 2px;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s;
            font-size: 0.9em;
            display: flex;
            flex-direction: row;
        }

        .appointment:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .blocked {
            background: #ff6b6b !important;
            color: white;
            position: relative;
        }

        .blocked:after {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
        }

        .appointment-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 320px;
        }

        .appointment-form h4 {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 1.5em;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 5px;
        }



        /* Styling untuk Select2 */
        /* .customer-search {
            width: 100% !important;
        } */

        /* Container Select2 */
        /* .select2-container {
            width: 100% !important;
            font-size: 12px !important;
        } */

        /* Input Select2 */
        .select2-selection--single {
            height: 40px !important;
            /* Sesuaikan tinggi dengan input lainnya */
            border: 1px solid #ddd !important;
            border-radius: 4px !important;
            background-color: #f9f9f9 !important;
            transition: border-color 0.3s ease !important;
        }

        /* Teks di dalam Select2 */
        .select2-selection__rendered {
            line-height: 40px !important;
            /* Sesuaikan tinggi dengan input lainnya */
            padding-left: 10px !important;
        }

        /* Panah dropdown Select2 */
        .select2-selection__arrow {
            height: 38px !important;
        }

        /* Efek hover dan focus pada Select2 */
        .select2-selection--single:hover,
        .select2-selection--single:focus {
            border-color: #28a745 !important;
        }


        .form-group label {
            display: block;
            /* margin-bottom: 5px; */
            font-weight: bold;
            color: #555;
            font-size: 12px;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
            color: #333;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group select:focus {
            border-color: #28a745;
            outline: none;
            background-color: #fff;
        }

        .form-actions {
            text-align: right;
            margin-top: 20px;
        }

        .btn-primary,
        .btn-secondary {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #28a745;
            color: #fff;
            margin-left: 10px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }






        .ui-datepicker {
            font-size: 13px;
        }

        .ui-datepicker-header {
            padding: 5px 0;
        }

        .ui-datepicker th {
            padding: 3px;
            font-size: 11px;
        }

        .ui-datepicker td {
            padding: 2px;
        }

        .ui-datepicker td span,
        .ui-datepicker td a {
            padding: 3px;
            font-size: 11px;
        }

        .ui-datepicker .ui-datepicker-title {
            font-size: 12px;
        }

        .calendar {
            position: fixed;
            left: 0;
            top: 80px;
            z-index: 1000;
        }

        .location {
            position: fixed;
            left: 0;
            top: 370px;
            z-index: 1000;
        }


        .schedule {
            margin-left: 225px;
            width: calc(100% - 225px);
            position: fixed;
            left: 0;
            top: 80px;
            z-index: 1000;

        }

        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 89vh;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        #employee-header {
            position: sticky;
            top: 0;
            background: linear-gradient(135deg, #884f47, #a85b4e);
            color: white;
            z-index: 100;
            text-align: center;
            height: 10px;
            line-height: 20px;
            font-size: 12px;
        }

        .time-column {
            position: sticky;
            left: 0;
            background: linear-gradient(135deg, #884f47, #a85b4e);
            color: white;
            z-index: 50;
            text-align: center;

            width: 70px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        .schedule-cell {
            min-width: 120px;
            height: 50px;
            border-right: 1px dashed rgba(0, 0, 0, 0.2);
            background: #fff;
            transition: all 0.2s ease-in-out;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .schedule-cell:hover {
            /* background: #f5f5f5; */
            cursor: pointer;
            /* transform: scale(1.02); */
        }

        tr:nth-child(even) {
            background: #fcfcfc;
        }

        tr:nth-child(2n) .schedule-cell {
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
        }

        .schedule-cell span {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .appointment-box {
            background: rgba(52, 152, 219, 0.9);
            color: white;
            position: absolute;
            top: 0;
            left: 0;
            width: 60%;
            /* Ikuti lebar cell */
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            border-radius: 5px;
            padding: 8px;
            z-index: 10;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Mencegah teks keluar */
            white-space: nowrap;
            /* Agar teks tetap dalam satu baris */
            text-overflow: ellipsis;
        }

        .toast {
            visibility: hidden;
            /* Sembunyikan secara default */
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 9999;
            right: 40%;
            top: 20px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .toast.show {
            visibility: visible;
            opacity: 1;
        }

        .toast.success {
            background-color: #28a745;
            /* Warna hijau untuk sukses */
        }

        .toast.error {
            background-color: #dc3545;
            /* Warna merah untuk error */
        }

        .custom-dropdown {
            height: 45px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .custom-dropdown:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
        }

        .appointment-content {
            width: 100%;
            display: flex;
            flex-direction: column;
            /* Jarak antar item */
            overflow: hidden;
            margin-left: 10px;
            color: black;
            text-transform: uppercase;
        }

        .icon-text {
            display: flex;
            align-items: center;
            gap: 2px;
            font-size: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Tambahkan "..." jika teks melebihi div */
            width: 100%;

            /* Mencegah teks terpotong */
        }

        .icon-text i {
            font-size: 8px;
            color: #f1c40f;
            /* Warna ikon */
            flex-shrink: 0;
        }

        @media screen and (max-width: 768px) {
            .schedule {
                width: 100%;
                margin-left: 0;
            }

            .time-column {
                width: 60px;
                font-size: 12px;
            }

            .schedule-cell {
                min-width: 100px;
                font-size: 12px;
            }

            .appointment-form {
                padding: 15px;
            }

            .form-group input[type="text"],
            .form-group select {
                padding: 8px;
                font-size: 12px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 8px 16px;
                font-size: 12px;
            }

            .calendar {
                position: relative;
                left: 0;
                top: 0px;
                z-index: 1000;
                width: 100%;
            }

            .location {
                position: relative;
                left: 0;
                top: 5px;
                z-index: 1000;
                width: 100%;
                text-align: center;
            }

            .schedule {
                /* margin-left: 225px; */
                width: calc(100%);
                position: relative;
                left: 0;
                top: 10px;
                z-index: 1000;
            }

            .ui-datepicker {
                font-size: 13px;
                width: 100%;
            }

            .ui-datepicker-header {
                padding: 5px 0;
            }

            .ui-datepicker th {
                padding: 3px;
                font-size: 11px;
            }

            .ui-datepicker td {
                padding: 2px;
            }

            .ui-datepicker td span,
            .ui-datepicker td a {
                padding: 0px;
                font-size: 11px;
            }

            .ui-datepicker .ui-datepicker-title {
                font-size: 12px;
            }
        }

        .drag-label {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #4CAF50;
            color: white;
            padding: 4px 6px;
            font-size: 10px;
            border-radius: 4px;
            font-weight: bold;
            z-index: 1001;
        }
         #prePaid .modal-content {
            border-radius: 12px;
            padding: 10px 15px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            border: none;
        }

        #prePaid .modal-header {
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 10px;
        }

        #prePaid .modal-title {
            font-weight: 600;
            font-size: 20px;
        }

        #prePaid .form-group label {
            font-weight: 600;
        }

        /* Card style tabel */
        #tableBlockTime {
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        #tableBlockTime thead {
            background: #f5f6fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
        }

        #tableBlockTime tbody tr td {
            vertical-align: middle;
        }

        .btn-delete {
            padding: 3px 10px !important;
        }
    </style>
</head>

<div class="">
    <div class="">
        <div class="row">
            <div class="calendar">
                <div id="calendar"></div>
            </div>
            <?php if ($level == 2 || $level == 3 || $level == 5 || $level == 6 || $level == 4 || $level == 11 || $level == 12 || $level == 13 || $level == 15 || $level == 16) { ?>
                <div class="location">
                    <select id="locationId" name="locationId" class="form-control custom-dropdown text-uppercase"
                        required="true" aria-required="true">
                        <?php foreach ($locationListAppointment as $j) { ?>
                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <?php if ($level == 1 || $level == 10) { ?>
                <div class="location">
                    <input type="number" id="locationId" value="<?= $locationId ?>" hidden>
                    </select>
                </div>
            <?php } ?>
            <div class="schedule">
                <div class="table-container">
                    <table>
                        <thead id="employee-header">
                        </thead>
                        <tbody id="schedule-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="appointment-form" class="appointment-form">
    <div class="form-group">
        <label for="customer-name">Nama Pasien:</label>
        <select id="customer-name" class="customer-search" data-placeholder="Cari nama pasien"></select>
    </div>
    <div class="form-group">
        <input type="text" id="cellphonenumber" placeholder="Cellphonenumber" disabled>
    </div>
    <div class="form-group">
        <label for="employeeBooking">Booking By:</label>
        <select id="employeeBooking">
            <option value="0">--NONE--</option>
            <?php foreach ($employeeBooking as $j) { ?>
                <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="remarks">Remarks:</label>
        <input type="text" id="remarks" placeholder="Remarks">
    </div>
    <input type="number" id="appointmentid" hidden>
    <input type="text" id="appointmentdate" hidden>
    <input type="text" id="starttreatment" hidden>
    <input type="number" id="employeeid" hidden>
    <input type="number" id="customerid" hidden>
    <div class="form-group">
        <label for="duration">Durasi (menit):</label>
        <select id="duration">
            <option value="30">30 Menit</option>
            <option value="60">60 Menit</option>
            <option value="90">90 Menit</option>
            <option value="120">120 Menit</option>
            <option value="150">150 Menit</option>
            <option value="180">180 Menit</option>
            <option value="210">210 Menit</option>
            <option value="240">240 Menit</option>
        </select>
    </div>
    <div class="form-group">
        <label for="status">Status Appointment:</label>
        <select id="status">
            <option value="1">Waiting Confirmation</option>
            <option value="2">Confirmed</option>
            <option value="6">Checkin</option>
            <option value="3">Last Minute Cancel</option>
            <option value="4">Not Show</option>
            <option value="5" hidden>Finished</option>
        </select>
    </div>
    <div class="form-actions">
        <?php if ($level != 5) { ?>
            <button id="detail-appointment" class="btn-secondary">Detail</button>
        <?php } ?>
        <?php if ($level != 4 && $level != 10) { ?>
            <button id="save-appointment" class="btn-primary">Simpan</button>
        <?php } ?>
        <button id="cancel-appointment" class="btn-secondary">Batal</button>
    </div>
</div>

<div id="toast" class="toast">
    <div id="toast-message"></div>
</div>

<div class="modal fade modal-transparent" id="prePaid" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">🕒 Block Time</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Employee</strong></label>
                    <input type="text" id="employeeNameBlock" class="form-control" readonly>
                </div>

                <!-- Remarks -->
                <div class="form-group">
                    <label><strong>Remarks</strong></label>
                    <input type="text" id="remarksBlock" class="form-control" placeholder="ex: BREAK, LUNCH, MEETING">
                </div>

                <!-- Wrapper grid agar lebih rapi -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Start Time</strong></label>
                            <select id="timeBlockStart" class="form-control">
                                <?php
                                for ($hour = 9; $hour <= 23; $hour++) {
                                    foreach (["00", "30"] as $minute) {
                                        $time = str_pad($hour, 2, "0", STR_PAD_LEFT) . ":" . $minute;
                                        echo "<option value='$time'>$time</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>End Time</strong></label>
                            <select id="timeBlockEnd" class="form-control">
                                <?php
                                for ($hour = 9; $hour <= 23; $hour++) {
                                    foreach (["00", "30"] as $minute) {
                                        $time = str_pad($hour, 2, "0", STR_PAD_LEFT) . ":" . $minute;
                                        echo "<option value='$time'>$time</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <input type="number" id="absenId" hidden>
                <input type="number" id="employeeIdBlock" hidden>

                <!-- Table -->
                <div class="mt-3">
                    <h6 class="mb-2"><strong>Current Block Time</strong></h6>
                    <table class="table table-bordered" id="tableBlockTime">
                        <thead>
                            <tr>
                                <th>Start</th>
                                <th>End</th>
                                <th>Remarks</th>
                                <th style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-light" data-dismiss="modal">Close</button>
                <button class="btn btn-primary btn-sm" id="saveBlockTime">Simpan</button>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var level = '<?= $level ?>';

        let startHour = 9;
        let endHour = 22;
        let employees = [];
        let employeesForIndex = [];

        function loadSchedule(date) {
            const locationId = $("#locationId").val();
            $.ajax({
                url: "App/getEmployeeBookingList", // Ganti dengan URL controller-mu
                type: "POST",
                dataType: "json",
                data: {
                    locationId: locationId
                },
                success: function (response) {
                    const $select = $("#employeeBooking");
                    $select.empty();
                    $select.append('<option value="0">--NONE--</option>');
                    response.forEach(function (emp) {
                        $select.append(`<option value="${emp.id}">${emp.name}</option>`);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Gagal memuat employee booking:", error);
                }
            });
            $.ajax({
                url: "App/get_schedule",
                method: "GET",
                data: {
                    date: date,
                    locationId: locationId,
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.error) {
                        console.error(response.error);
                        $("#schedule-body").html("<tr><td colspan='10'>Data tidak ditemukan</td></tr>");
                        return;
                    }

                     let blockGrouped = {};

                    response.blockEmployee.forEach(block => {
                        if (!blockGrouped[block.employeeid]) {
                            blockGrouped[block.employeeid] = [];
                        }

                        blockGrouped[block.employeeid].push({
                            start: block.timeblockstart,
                            end: block.timeblockend,
                            remarks: block.remarks
                        });
                    });

                    employees = response.employees.map(emp => ({
                        id: emp.EMPLOYEEID,
                        name: emp.EMPLOYEENAME,
                        start: parseInt(emp.START.split(':')[0]),
                        timeBlockEnd: emp.timeBlockEnd,
                        timeBlockStart: emp.timeBlockStart,
                        absenId: emp.absenId,
                        remarks: emp.REMARKS,
                        jobname: emp.JOBNAME,
                         blocks: blockGrouped[emp.EMPLOYEEID] || []
                    }));

                    employeesForIndex = response.employees;
                    updateEmployeeHeader();
                    generateTable();
                    fillSchedule(response.treatments);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data: " + error);
                }
            });
        }


        function updateEmployeeHeader() {
            let headerHTML = `<tr><th class="time-column"></th>`;
            employees.forEach(emp => {
                if (emp.id == 0) {
                    headerHTML += `<th style="border-right: 1px solid #ddd; cursor: pointer" data-employeeid="${emp.id}" data-absenid="${emp.absenId}" data-employeename="${emp.name}">${emp.name} (${emp.jobname})</th>`;
                } else {
                    if (level == 1) {
                        headerHTML += `<th class='employee' style="border-right: 1px solid #ddd; cursor: pointer" data-employeeid="${emp.id}" data-absenid="${emp.absenId}" data-employeename="${emp.name}">${emp.name} (${emp.jobname})</th>`;
                    } else {
                        headerHTML += `<th style="border-right: 1px solid #ddd;" data-employeeid="${emp.id}" data-absenid="${emp.absenId}" data-employeename="${emp.name}">${emp.name} (${emp.jobname})</th>`;
                    }

                }

            });
            headerHTML += `</tr>`;
            $("#employee-header").html(headerHTML);
        }

        function generateTable() {
            let tbody = "";
            for (let hour = startHour; hour <= endHour; hour++) {
                ["00", "30"].forEach((minute) => {
                    let displayTime = `${hour.toString().padStart(2, '0')}:${minute}`;
                    let currentTime = `${hour.toString().padStart(2, '0')}:${minute}`;
                    tbody += `<tr><td style="border-bottom: 1px solid #ddd;" class='time-column'>${displayTime}</td>`;
                    employees.forEach((emp, index) => {
                        let isBreakTime = false;
                        let breakRemarks = "";

                        emp.blocks.forEach(block => {
                            if (currentTime >= block.start && currentTime <= block.end) {
                                isBreakTime = true;
                                breakRemarks = block.remarks;
                            }
                        });
                        if (isBreakTime) {
                            tbody += `<td class='disabled schedule-cell' 
                            style="background-color: #f5f5f5; font-weight: bold" 
                            data-time='${hour}:${minute}' data-employeeid='${emp.id}'>
                            ${breakRemarks}
                            </td>`;
                        }else if (hour >= emp.start) {
                            if (emp.id == 0) {
                                tbody += `<td style="background-color: #fbeee8 " class='schedule-cell' data-time='${hour}:${minute}' data-employeeid='${emp.id}'></td>`;
                            } else {
                                tbody += `<td style="background-color: #f5e0d8" class='schedule-cell' data-time='${hour}:${minute}' data-employeeid='${emp.id}'></td>`;
                            }
                        } else if (hour < emp.start) {
                            tbody += `<td style="background-color: grey" class='schedule-cell disabled' data-time='${hour}:${minute}' data-employeeid='${emp.id}'></td>`;
                        }
                    });
                    tbody += "</tr>";
                });
            }
            $("#schedule-body").html(tbody);

            $(".schedule-cell:not(.disabled)").droppable({
                accept: ".appointment-box",
                hoverClass: "drop-hover",
                drop: function (event, ui) {
                    let droppedElement = ui.helper.clone();
                    droppedElement.css({
                        top: "0px",
                        left: "0px",
                        position: "relative"
                    });

                    let appointmentId = droppedElement.data("appointmentid");
                    let newEmployeeId = $(this).data("employeeid");
                    let newStartTime = $(this).data("time");
                    droppedElement.data("employeeid", newEmployeeId);
                    droppedElement.data("start", newStartTime);
                    $(this).append(droppedElement);
                    ui.helper.remove();
                    updateAppointmentAfterDrop(appointmentId, newEmployeeId, newStartTime);
                }
            });
        }

        function fillSchedule(treatments) {
            let scheduleMap = {};
            treatments.forEach(treatment => {
                let key = `${treatment.EMPLOYEEID}`;
                if (!scheduleMap[key]) scheduleMap[key] = [];

                let startTime = treatment.START;
                let duration = parseInt(treatment.DURATION);
                let endTime = addMinutesToTime(startTime, duration);

                scheduleMap[key].push({
                    ...treatment,
                    startTime,
                    endTime,
                });
            });

            Object.keys(scheduleMap).forEach(employeeKey => {
                let appointments = scheduleMap[employeeKey];

                appointments.forEach((currentAppointment, index) => {
                    console.log(currentAppointment);

                    let start = currentAppointment.START;
                    let duration = currentAppointment.DURATION;
                    let employeeIndex = employeesForIndex.findIndex(emp => emp.EMPLOYEEID == currentAppointment.EMPLOYEEID);

                    if (employeeIndex !== -1) {
                        let firstCell = $(`td.schedule-cell[data-time='${start}']`).eq(employeeIndex);
                        if (firstCell.length > 0) {
                            firstCell.css("position", "relative");

                            let overlappingCount = 1;
                            let overlappingIndex = 0;

                            appointments.forEach((otherAppointment, otherIndex) => {
                                if (otherIndex !== index) {
                                    if (isOverlapping(currentAppointment, otherAppointment)) {
                                        overlappingCount++;
                                        if (otherIndex < index) {
                                            overlappingIndex++;
                                        }
                                    }
                                }
                            });

                            let gapWidth = 2;
                            let boxWidth = (80 - (gapWidth * (overlappingCount - 1))) / overlappingCount;
                            let leftPosition = overlappingIndex * (boxWidth + gapWidth);

                            let appointmentDiv = $(`
                                <div class="appointment-box"
                                    data-employeeid="${currentAppointment.EMPLOYEEID}" 
                                    data-start="${start}" 
                                    data-duration="${duration}"
                                    data-customername="${currentAppointment.CUSTOMERNAME}"
                                    data-appointmentid="${currentAppointment.TREATMENTID}"
                                    data-remarks="${currentAppointment.REMARKS}"
                                    data-customerid="${currentAppointment.CUSTOMERID}"
                                    data-cellphonenumber="${currentAppointment.CELLPHONENUMBER ? currentAppointment.CELLPHONENUMBER : '-'}"
                                    data-status="${currentAppointment.STATUS}"
                                    data-employeebooking="${currentAppointment.EMPLOYEEBOOKING}"
                                    data-level="${level}">
                                        <div class="appointment-content">
                                            <div class="icon-text">
                                                <i class="fas fa-user"></i>${currentAppointment.CUSTOMERNAME} &nbsp;
                                                <i class="fas fa-id-badge"></i> ${currentAppointment.CUSTOMERCODE} &nbsp;
                                                <i class="fas fa-phone"></i>${currentAppointment.CELLPHONENUMBER ? currentAppointment.CELLPHONENUMBER : '-'} &nbsp;
                                            </div>
                                            <div class="icon-text">
                                                <i class="fas fa-comment"></i>${currentAppointment.REMARKS}
                                            </div>
                                        </div>
                                </div>
                            `);

                            let cellHeight = firstCell.outerHeight();
                            let totalHeight = Math.ceil(duration / 30) * cellHeight;

                            appointmentDiv.css({
                                "height": totalHeight + "px",
                                "width": `${boxWidth}%`,
                                "position": "absolute",
                                "top": "0",
                                "left": `${leftPosition}%`,
                                "background": "linear-gradient(to right, rgba(52, 152, 219, 0.9) 10px, white 10px)",
                                "border-radius": "5px",
                                "padding": "5px",
                                "color": "#fff",
                                "display": "flex",
                                "flex-direction": "column",
                                "align-items": "flex-start",
                                "font-size": "10px",
                                "cursor": "pointer",
                                "z-index": 10,
                                "box-shadow": "0px 4px 6px rgba(0, 0, 0, 0.1)"
                            });

                            firstCell.append(appointmentDiv);

                            if (currentAppointment.STATUS != "5" && level != 4 && level != 10) {
                                let dragTimeout;
                                let isDragging = false;
                                let touchStartX, touchStartY;

                                $(".appointment-box").on("touchstart mousedown", function (e) {
                                    const $this = $(this);
                                    const status = $this.data("status");
                                    const level = parseInt($this.data("level"));

                                    if (status == "5" || level == 4 || level == 10) {
                                        return;
                                    }

                                    // Cegah scroll dengan mencatat posisi awal
                                    if (e.type === "touchstart") {
                                        const touch = e.originalEvent.touches[0];
                                        touchStartX = touch.clientX;
                                        touchStartY = touch.clientY;
                                    }

                                    dragTimeout = setTimeout(() => {
                                        isDragging = true;
                                        $this.addClass("drag-ready");
                                        if (!$this.find(".drag-label").length) {
                                            $this.append(`<div class="drag-label">↕️ Drag</div>`);
                                        }

                                        $this.draggable({
                                            revert: "invalid",
                                            containment: "#schedule-body",
                                            helper: "clone",
                                            opacity: 0.8,
                                            zIndex: 1000,
                                            start: function () {
                                                $this.find(".drag-label").remove();
                                            },
                                            stop: function () {
                                                isDragging = false;
                                                $this.removeClass("drag-ready");
                                                $this.draggable("destroy");
                                            }
                                        });

                                        // Trigger mousedown secara manual untuk mobile
                                        if (e.type === "touchstart") {
                                            const simulatedEvent = new MouseEvent("mousedown", {
                                                view: window,
                                                bubbles: true,
                                                cancelable: true,
                                                clientX: touchStartX,
                                                clientY: touchStartY,
                                            });
                                            e.target.dispatchEvent(simulatedEvent);
                                        }
                                    }, 500); // tahan 3 detik
                                });

                                $(".appointment-box").on("touchmove", function (e) {
                                    const touch = e.originalEvent.touches[0];
                                    const dx = Math.abs(touch.clientX - touchStartX);
                                    const dy = Math.abs(touch.clientY - touchStartY);

                                    if (dx > 10 || dy > 10) {
                                        clearTimeout(dragTimeout);
                                    }
                                });

                                $(".appointment-box").on("touchend touchcancel mouseup mouseleave", function () {
                                    clearTimeout(dragTimeout);
                                    if (!isDragging) {
                                        $(this).removeClass("drag-ready").find(".drag-label").remove();
                                    }
                                });
                            } else {
                                appointmentDiv.css("background", "linear-gradient(to right, rgba(169, 169, 169, 0.9) 10px, white 10px)");
                            }



                            if (currentAppointment.ISDOWNLOAD == 1) {
                                const downloadedBadge = $('<div></div>').css({
                                    "position": "absolute",
                                    "top": "2px",
                                    "right": "2px",
                                    "width": "12px",
                                    "height": "12px",
                                    "background-color": "#2ecc71",
                                    "border-radius": "50%",
                                    "border": "1px solid #fff",
                                    "z-index": 20
                                });
                                appointmentDiv.append(downloadedBadge);
                                downloadedBadge.attr("title", "Customer sudah download aplikasi");
                            }

                            if (currentAppointment.ISDOWNLOAD == 0) {
                                const downloadedBadge = $('<div></div>').css({
                                    "position": "absolute",
                                    "top": "2px",
                                    "right": "2px",
                                    "width": "12px",
                                    "height": "12px",
                                    "background-color": "red",
                                    "border-radius": "50%",
                                    "border": "1px solid #fff",
                                    "z-index": 20
                                });
                                appointmentDiv.append(downloadedBadge);
                                downloadedBadge.attr("title", "Customer belum download aplikasi");
                            }

                            if (currentAppointment.STATUS == 1 && currentAppointment.TYPE == 0 && currentAppointment.LEVELUSER == 2) {
                                appointmentDiv.css("background", "linear-gradient(to right, yellow 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 1 && currentAppointment.TYPE == 0 && currentAppointment.LEVELUSER == 11) {
                                appointmentDiv.css("background", "linear-gradient(to right, #BF00FF 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 1 && currentAppointment.TYPE == 0 && currentAppointment.LEVELUSER == 12) {
                                appointmentDiv.css("background", "linear-gradient(to right, #FFC0CB 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 1 && currentAppointment.LEVELUSER == 13) {
                                appointmentDiv.css("background", "linear-gradient(to right, #ADD8E6 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 1 && !currentAppointment.LEVELUSER) {
                                appointmentDiv.css("background", "linear-gradient(to right, #884f47 10px, white 10px)");
                            }


                            if (currentAppointment.STATUS == 2) {
                                appointmentDiv.css("background", "linear-gradient(to right, green 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 6) {
                                appointmentDiv.css("background", "linear-gradient(to right, rgba(231, 76, 60, 1) 10px, white 10px)");
                            }

                            if (currentAppointment.STATUS == 4) {
                                appointmentDiv.css("background", "linear-gradient(to right, rgba(0, 0, 0, 1) 10px, white 10px)");
                            }
                        }
                    }
                });
            });
        }

        function addMinutesToTime(time, minutesToAdd) {
            let [hours, minutes] = time.split(":").map(Number);
            minutes += minutesToAdd;
            while (minutes >= 60) {
                minutes -= 60;
                hours++;
            }
            return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`;
        }

        function isOverlapping(appointment1, appointment2) {
            return (
                appointment1.startTime < appointment2.endTime &&
                appointment2.startTime < appointment1.endTime
            );
        }


        $(document).on("click", ".schedule-cell", function (e) {
            let appointmentBox = $(this).find(".appointment-box");
            let startTime = $(this).data("time");
            let employeeid = $(this).data("employeeid");

            const statusSelect = document.getElementById("status");

            if ($(e.target).closest(".appointment-box").length > 0) {
                console.log('data ada di proses ditempat lain');
            } else {
                $("#customer-name").val("").trigger("change");
                $("#cellphonenumber").val("");
                $("#remarks").val("");
                $("#duration").val("30");
                $("#appointmentid").val("");
                $("#starttreatment").val(startTime);
                $("#employeeid").val(employeeid);
                $("#customerid").val("");
                $("#status").val(1);
                $("#customer-name").prop("disabled", false);
                $("#remarks").prop("disabled", false);
                $("#duration").prop("disabled", false);
                $("#starttreatment").prop("disabled", false);
                $("#detail-appointment").hide();
                $("#employeeid").prop("disabled", false);
                $("#save-appointment").show();
                $("#employeeBooking").val("");
                $("#employeeBooking").prop("disabled", false);

                if (level == 2 || level == 12 || level == 13) {
                    $("#status").html(`
                            <option value="1">Waiting Confirmation</option>
                            <option value="2">Confirmed</option>
                            <option value="6" hidden>Checkin</option>
                            <option value="3">Last Minute Cancel</option>
                            <option value="4">Not Show</option>
                            <option value="5" hidden>Finished</option>
                        `);
                }

            }

            $("#appointment-form").fadeIn();
        });

        $(document).on("click", ".appointment-box", function (e) {
            e.stopPropagation();

            let customerName = $(this).data("customername");
            let employeeid = $(this).data("employeeid");
            let duration = $(this).data("duration");
            let appointmentid = $(this).data("appointmentid");
            let startTime = $(this).data("start");
            let remarks = $(this).data("remarks");
            let customerid = $(this).data("customerid");
            let status = $(this).data("status");
            let cellphonenumber = $(this).data("cellphonenumber");
            let employeebooking = $(this).data("employeebooking");

            const statusSelect = document.getElementById("status");

            if (status == "5") {
                statusSelect.disabled = true;
                $("#customer-name").prop("disabled", true);
                $("#remarks").prop("disabled", true);
                $("#duration").prop("disabled", true);
                $("#starttreatment").prop("disabled", true);
                $("#employeeid").prop("disabled", true);
                $("#detail-appointment").show();
                $("#save-appointment").hide();
                $("#employeeBooking").prop("disabled", true);
            } else {
                $("#customer-name").prop("disabled", false);
                $("#remarks").prop("disabled", false);
                $("#duration").prop("disabled", false);
                $("#starttreatment").prop("disabled", false);
                $("#employeeid").prop("disabled", false);
                $("#detail-appointment").show();
                $("#save-appointment").show();
                statusSelect.disabled = false;
                $("#employeeBooking").prop("disabled", false);
                if (level == 2 || level == 12 || level == 13) {
                    $("#status").html(`
                            <option value="1">Waiting Confirmation</option>
                            <option value="2">Confirmed</option>
                            <option value="6" hidden>Checkin</option>
                            <option value="3">Last Minute Cancel</option>
                            <option value="4">Not Show</option>
                            <option value="5" hidden>Finished</option>
                        `);
                }
            }

            if (!customerName) {
                console.error("Data appointment tidak ditemukan");
                return;
            }

            if ($("#customer-name option[value='" + customerid + "']").length === 0) {
                let newOption = new Option(customerName, customerid, true, true);
                $("#customer-name").append(newOption).trigger("change");
            } else {
                $("#customer-name").val(customerid).trigger("change");
            }

            $("#duration").val(duration);
            $("#appointmentid").val(appointmentid);
            $("#starttreatment").val(startTime);
            $("#employeeid").val(employeeid);
            $("#remarks").val(remarks);
            $("#customerid").val(customerid);
            $("#status").val(status);
            $("#cellphonenumber").val(cellphonenumber);
            $("#employeeBooking").val(employeebooking);

            $("#appointment-form").fadeIn();
        });

        $(document).on("click", ".employee", function (e) {
            let absenId = $(this).data("absenid");
            let employeeName = $(this).data("employeename");
            let employeeId = $(this).data("employeeid");

            $("#absenId").val(null);
            $("#employeeNameBlock").val(employeeName);
            $("#employeeIdBlock").val(employeeId);
            openEmployeeBlockTIme(employeeId)


            $("#prePaid").modal("show");
        });


        $("#cancel-appointment").on("click", function () {
            $("#appointment-form").fadeOut(200);
        });

        $("#save-appointment").on("click", function () {
            let customerName = $("#customer-name").val();
            let remarks = $("#remarks").val();
            let duration = $("#duration").val();
            let appointmentId = $("#appointmentid").val();
            let appointmentdate = $("#appointmentdate").val();
            let employeeid = $("#employeeid").val();
            let customerid = $("#customerid").val();
            let starttreatment = $("#starttreatment").val();
            let locationId = $("#locationId").val();
            let status = $("#status").val();

            let employeeBooking = $("#employeeBooking").val();
            if (level == 2) {
                employeeBooking = 1040;
            }


            if (!customerName || !employeeBooking) {
                alert("Nama pasien dan Booking By harus diisi!");
                return;
            }

            let today = new Date();
            let yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 2);

            let todayStr = today.toISOString().split('T')[0];
            let yesterdayStr = yesterday.toISOString().split('T')[0];


            if (appointmentdate < yesterdayStr && locationId != 13 && appointmentId == '') {
                alert("Tidak dapat menyimpan karena melewati batas hari (maks. kemarin)!");
                return;
            }


            $.ajax({
                url: "App/saveBookAppointement",
                type: "POST",
                dataType: 'json',
                data: {
                    id: appointmentId,
                    customer_name: customerName,
                    remarks: remarks,
                    duration: duration,
                    appointmentdate: appointmentdate,
                    employeeid: employeeid,
                    customerid: customerid,
                    starttreatment: starttreatment,
                    locationId: locationId,
                    status: status,
                    employeeBooking: employeeBooking,
                },
                success: function (response) {
                    if (response.status === "duplicate") {
                        const existingTime = response.booktime || "-";
                        if (confirm(`Customer sudah memiliki appointment pada tanggal ini pukul ${existingTime}. Lanjutkan membuat appointment baru?`)) {
                            $.ajax({
                                url: "App/saveBookAppointement",
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    id: appointmentId,
                                    remarks: remarks,
                                    duration: duration,
                                    appointmentdate: appointmentdate,
                                    employeeid: employeeid,
                                    customerid: customerid,
                                    starttreatment: starttreatment,
                                    locationId: locationId,
                                    status: status,
                                    employeeBooking: employeeBooking,
                                    override: true 
                                },
                                success: function (response2) {
                                    if (response2.status === "success") {
                                        showToast("Appointment berhasil disimpan!", "success");
                                        loadSchedule(appointmentdate);
                                        $("#appointment-form").fadeOut(200);
                                    }
                                }
                            });
                        }
                    } else if (response.status === "success") {
                        showToast("Appointment berhasil diperbarui!", "success");
                        loadSchedule(appointmentdate);
                        $("#appointment-form").fadeOut(200);
                    } else {
                        alert("Gagal menyimpan data!");
                        $("#appointment-form").fadeOut(200);
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat menyimpan data!");
                }
            });
        });

        $("#detail-appointment").on("click", function () {
            let customerName = $("#customer-name").val();
            let remarks = $("#remarks").val();
            let duration = $("#duration").val();
            let appointmentId = $("#appointmentid").val();
            let appointmentdate = $("#appointmentdate").val();
            let employeeid = $("#employeeid").val();
            let customerid = $("#customerid").val();
            let starttreatment = $("#starttreatment").val();
            let locationId = $("#locationId").val();
            let status = $("#status").val();

            // Redirect dengan parameter ke controller
            let base_url = "<?= base_url('prepaidConsumption'); ?>"; // Sesuaikan dengan route di CI3
            let queryParams = new URLSearchParams({
                customerName: customerName,
                remarks: remarks,
                duration: duration,
                appointmentId: appointmentId,
                appointmentdate: appointmentdate,
                employeeid: employeeid,
                customerid: customerid,
                starttreatment: starttreatment,
                locationId: locationId,
                status: status
            }).toString();

            window.location.href = base_url + "?" + queryParams;
        });

        function updateAppointmentAfterDrop(appointmentId, newEmployeeId, newStartTime) {
            $.ajax({
                url: "App/updateAppointmentAfterDrop",
                type: "POST",
                dataType: "json",
                data: {
                    id: appointmentId,
                    employeeid: newEmployeeId,
                    starttreatment: newStartTime
                },
                success: function (response) {

                    if (response.status === "success") {
                        showToast("Appointment berhasil diperbarui!", "success");
                        loadSchedule($("#appointmentdate").val());
                    } else {
                        alert("Gagal memperbarui appointment: " + response.message);
                        loadSchedule($("#appointmentdate").val());
                    }
                },
                error: function (xhr, status, error) {
                    alert("Terjadi kesalahan saat memperbarui appointment!");
                    loadSchedule($("#appointmentdate").val());
                }
            });
        }

        $("#cancel-appointment").click(function () {
            $("#appointment-form").fadeOut();
        });

        function formatDate(date) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            return new Date(date).toISOString().split('T')[0];
        }

        $('#calendar').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: new Date(),
            onSelect: function (date) {
                $("#selected-date").text(date);
                $("#appointmentdate").val(date);
                loadSchedule(date);
            }
        });

        let today = formatDate(new Date());
        $("#selected-date").text(today);
        $("#appointmentdate").val(today);
        loadSchedule(today);

        $(document).ready(function () {
            $("#locationId").on("change", function () {
                const selectedLocationId = $(this).val();

                const selectedDate = $("#appointmentdate").val();

                if (selectedDate) {
                    loadSchedule(selectedDate);
                } else {
                    console.error("Tanggal tidak ditemukan!");
                }
            });
        });

        $("#customer-name").select2({
            width: '100%',
            ajax: {
                url: "App/searchCustomer", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    }; // Kirimkan keyword pencarian
                },
                processResults: function (data) {
                    console.log(data);

                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#customer-name").on("select2:select", function (e) {
            let data = e.params.data;
            $("#customerid").val(data.id);
        });

        function showToast(message, type = "success") {
            const toast = document.getElementById("toast");
            const toastMessage = document.getElementById("toast-message");

            toastMessage.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        $('#saveBlockTime').on('click', function () {
            let blockId = $('#absenId').val();
            let startTime = $('#timeBlockStart').val();
            let endTime = $('#timeBlockEnd').val();
            let blockDate = $("#appointmentdate").val();
            let locationId = $("#locationId").val();
            let employeeIdBlock = $("#employeeIdBlock").val();
            let remarksBlock = $("#remarksBlock").val();

            if (!blockDate || !startTime || !endTime || !locationId || !employeeIdBlock || !remarksBlock) {
                alert('Remarks harus di isi!');
                return;
            }

            $.ajax({
                url: "App/updateTimeBlock",
                type: "POST",
                dataType: 'text',
                data: {
                    blockId: blockId,
                    startTime: startTime,
                    endTime: endTime,
                    blockDate: blockDate,
                    locationId: locationId,
                    employeeIdBlock: employeeIdBlock,
                    remarksBlock: remarksBlock
                },
                success: function (response) {
                    showToast("Block berhasil diperbarui!", "success");
                    loadSchedule(blockDate);
                    $('#prePaid').modal('hide');
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('Gagal menyimpan data!');
                }
            });
        });


        $(document).on("click", ".btn-delete-block", function () {
            const id = $(this).data("id");
            const date = $("#appointmentdate").val();
            Swal.fire({
                title: "Hapus block time?",
                text: "Data tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus",
                cancelButtonText: "Batal"
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        url: '<?= base_url('App/deleteEmployeeBlockTime') ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: { id: id },
                        success: function (res) {
                            console.log(res);

                            if (res.success) {
                                showToast("Block berhasil diperbarui!", "success");
                                loadSchedule(date);
                                $('#prePaid').modal('hide');
                            } else {
                                Swal.fire("Gagal", res.message, "error");
                            }
                        }
                    });

                }
            });
        });

    });


    function openEmployeeBlockTIme(id) {
        const date = $("#appointmentdate").val();
        $.ajax({
            url: '<?= base_url('App/getEmployeeBlockTime') ?>',
            type: 'GET',
            dataType: 'json',
            data: {
                date: date,
                employeeid: id,
            },
            success: function (response) {
                if (response.success) {

                    const tableBody = $("#tableBlockTime tbody");
                    tableBody.empty(); // reset table

                    response.blockEmployee.forEach(block => {
                        let row = `
                        <tr data-id="${block.id}">
                            <td>${block.timeblockstart}</td>
                            <td>${block.timeblockend}</td>
                            <td>${block.remarks ?? "-"}</td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete-block" data-id="${block.id}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    `;

                        tableBody.append(row);
                    });

                    // buka modal
                    $("#prePaid").modal("show");

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: "Terjadi kesalahan saat proses, coba lagi!",
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    }

</script>

<script>
    document.getElementById("timeBlockStart").addEventListener("change", function () {
        const startTime = this.value;
        const endSelect = document.getElementById("timeBlockEnd");

        // Hapus semua option dari end time
        while (endSelect.firstChild) {
            endSelect.removeChild(endSelect.firstChild);
        }

        // Buat ulang option end time yang >= start time
        const times = [];
        for (let hour = 9; hour <= 23; hour++) {
            ["00", "30"].forEach(minute => {
                times.push(`${hour.toString().padStart(2, '0')}:${minute}`);
            });
        }

        times.forEach(time => {
            if (time >= startTime) {
                const option = document.createElement("option");
                option.value = time;
                option.text = time;
                endSelect.appendChild(option);
            }
        });
    });
</script>

</html>