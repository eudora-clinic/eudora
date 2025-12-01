<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
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
            /* position: fixed; */
            /* left: 0;
            top: 80px;
            z-index: 1000; */
            margin-bottom: 10px;
        }

        .location {
            /* position: fixed; */
            /* left: 0;
            top: 370px;
            z-index: 1000; */
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



        tr:nth-child(even) {
            background: #fcfcfc;
        }

        tr:nth-child(2n) .schedule-cell {
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
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
            /* height: 45px; */
            /* padding: 10px; */
            /* font-size: 16px; */
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
    </style>
</head>

<div class="">
    <div class="">
        <div class="row">
            <div>
                <div class="calendar">
                    <div id="calendar"></div>
                </div>
                <div class="location">
                    <select id="locationId" name="locationId" class="form-control custom-dropdown text-uppercase"
                        required="true" aria-required="true">
                        <?php foreach ($locationListAppointment as $j) { ?>
                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>>
                                <?= $j['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="schedule">
                <div class="table-container">
                    <table class="table-striped table-bordered" style="width:100%">
                        <thead id="employee-header" class="bg-thead" style="">
                        </thead>
                        <tbody id="employee-list"></tbody>
                    </table>
                </div>
            </div>

            <input type="text" id="appointmentdate" hidden>
        </div>
    </div>
</div>



<div id="toast" class="toast">
    <div id="toast-message"></div>
</div>

<!-- Modal Pilih Shift -->
<div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shiftModalLabel">Pilih Shift</h5>
            </div>
            <form id="createForm">
                <div class="modal-body">
                    <p id="selectedEmployeeName"></p>
                    <div class="form-column">
                        <label for="shiftDate" class="form-label mt-2"><strong> DATE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="date" id="shiftDate" class="form-control" required disabled>
                        <input type="hidden" id="employeeId" class="form-control" required>
                    </div>
                    <div class="form-column">
                        <label for="shiftId" class="form-label mt-2"><strong>SHIFT:</strong><span
                                class="text-danger">*</span></label>
                        <select id="shiftId" name="shiftId" class="form-control" required="true" aria-required="true">
                            <?php foreach ($shiftList as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['shiftname'] ?> - <?= $j['shiftcode'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalShift">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        $('.employee-name-btn').click(function () {
            $('#shiftModal').modal('show');
        });
        var level = '<?= $level ?>';

        let startHour = 9;
        let endHour = 22;
        let employees = [];
        let employeesForIndex = [];

        function loadSchedule(date) {
            const locationId = $("#locationId").val();
            $.ajax({
                url: "ControllerHr/getPresensiLog",
                method: "GET",
                data: {
                    date: date,
                    locationId: locationId,
                },
                dataType: "json",
                success: function (response) {
                    console.log(response);

                    const presensiData = response.presensiEmployees;
                    $("#employee-header").html(`
                        <tr style="text-align: center; background: linear-gradient(135deg, #884f47, #a85b4e);
                                    color: white; font-weight: bold;" >
                            <th></th>
                            <th>Shift</th>
                            <th>Shift Start</th>
                            <th>Shift End</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Work Hours</th>
                        </tr>
                    `);
                    $("#employee-list").empty();

                    console.log(presensiData);
                    

                    presensiData.forEach(emp => {
                        
                        const isOffCutiMC = emp.isoff == 1 || emp.isleave == 1;

                        $("#employee-list").append(`
                        <tr style="font-size: 13px">
                            <td style="text-align: center; cursor: pointer; background: linear-gradient(135deg, #884f47, #a85b4e);
                                    color: white; font-weight: bold;" class="employee-name-btn" 
                                    data-name="${emp.name}"
                                    data-employeeid="${emp.employeeid}"
                                    data-shiftid="${emp.shiftid}">
                                    ${emp.name ?? '-'}
                            </td>
                            
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.shiftcode + '( ' + emp.shiftname + ' )' ?? '-')}</td>
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.shiftstart ? emp.shiftstart.slice(0, 5) : '-')}</td>
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.shiftend ? emp.shiftend.slice(0, 5) : '-')}</td>
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.checkin_time ? emp.checkin_time.slice(0, 5) : '-')}</td>
                            
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.checkout_time ? emp.checkout_time.slice(0, 5) : '-')}</td>
                         
                            <td>${isOffCutiMC ? emp.shiftcode : (emp.work_hours ?? '0') + ' Hours'}</td>
                        </tr>
                    `);
                    });

                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data: " + error);
                }
            });
        }

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
                $('#shiftDate').val(date);
                loadSchedule(date);
            }
        });

        let today = formatDate(new Date());
        $("#selected-date").text(today);
        $("#appointmentdate").val(today);
        $('#shiftDate').val(today);

        loadSchedule(today);

        $(document).ready(function () {
            $("#locationId").on("change", function () {
                const selectedLocationId = $(this).val();

                const selectedDate = $("#appointmentdate").val();
                $('#shiftDate').val(selectedDate);

                if (selectedDate) {
                    loadSchedule(selectedDate);
                } else {
                    console.error("Tanggal tidak ditemukan!");
                }
            });
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

        $(document).on('click', '.employee-name-btn', function () {
            const name = $(this).data('name');
            const employeeid = $(this).data('employeeid');
            const shiftid = $(this).data('shiftid');

            $('#selectedEmployeeName').text(`Pilih shift untuk: ${name}`);
            $('#shiftId').val(shiftid);
            $('#employeeId').val(employeeid);
            $('#shiftModal').modal('show');
        });

        $(document).on('click', '#closeModalShift', function () {

            $('#shiftModal').modal('hide');
        });

        $('#createForm').submit(function (e) {
            e.preventDefault();

            const formData = {
                employeeId: $('#employeeId').val(),
                shiftId: $('#shiftId').val(),
                shiftDate: $('#shiftDate').val(),
            };
            $.ajax({
                url: '<?= base_url('ControllerHr/createShiftEmployee') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#shiftModal').modal('hide');
                        loadSchedule(formData.shiftDate);
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