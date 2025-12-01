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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

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
            position: fixed;
            left: 2%;
            top: 220px;
            z-index: 1000;
            width: 96%;
            align-items: center;
        }

        .summary {
            position: fixed;
            left: 2%;
            top: 220px;
            z-index: 100;
            width: 96%;
            align-items: center;
        }

        .table-container {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 65vh;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        #employee-header {
            position: sticky;
            top: 0;
        }

        #employee-headersummary {
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

        /* .schedule {
            position: fixed;
            left: 0;
            top: 200px;
            z-index: 1000;
        } */

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

        select.form-select {
            border-radius: 8px;
            padding: 10px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            color: #333;
            text-transform: uppercase;
        }

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

<body>
    <div>
        <div class="mycontaine">
            <div class="row" style="justify-content: space-around;">
                <div class="card p-2 col-md-9">
                    <?php
                    $today = date('Y-m-d');               // tanggal hari ini
                    $firstOfMonth = date('Y-m-01');       // tanggal 1 di bulan ini
                    $dateStartVal = !empty($dateStart) ? $dateStart : $firstOfMonth;
                    $dateEndVal = !empty($dateEnd) ? $dateEnd : $today;
                    ?>
                    <form id="form-cari-invoice">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date Start</label>
                                    <input type="date" name="dateStart" id="dateStart"
                                        class="form-control filter_period" value="<?= $dateStartVal ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Date End</label>
                                    <input type="date" name="dateEnd" id="dateEnd" class="form-control filter_period"
                                        value="<?= $dateEndVal ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="locationId" name="locationId" class="form-control text-uppercase "
                                        required="true" aria-required="true">
                                        <option value="">Select Outlet</option>
                                        <?php foreach ($locationListPresensi as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>>
                                                <?= $j['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" name="submit"
                                        class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card p-2 col-md-2">
                    <div class="">
                        <select id="summaryType" name="summaryType" class="form-select text-center" required
                            onchange="changeSPPayment(this.value)"
                            style="font-size: 14px !important; font-weight: 500;">
                            <option value="1">DETAIL</option>
                            <option value="2">SUMMARY</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="schedule">
                <div class="table-container">
                    <button id="exportExcelPresensi" class="btn btn-success">Export Presensi</button>

                    <table id="table-presensi" class="table-striped table-bordered" style="width:100%">
                        <thead id="employee-header" class="bg-thead" style="">
                        </thead>
                        <tbody id="employee-list"></tbody>
                    </table>
                </div>
            </div>

            <div class="summary">
                <div class="table-container">
                    <button id="exportExcelSummary" class="btn btn-success">Export Summary</button>
                    <table id="table-summary" class="table-striped table-bordered" style="width:100%">
                        <thead id="employee-headersummary" class="bg-thead" style="">
                        </thead>
                        <tbody id="employee-listsummary"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>



<div id="toast" class="toast">
    <div id="toast-message"></div>
</div>


<script>

    function formatRupiah(angka) {
        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    $(document).ready(function () {

        let employees = [];
        let employeesForIndex = [];

        function loadSchedule() {
            const locationId = $("#locationId").val();
            const dateStart = $("#dateStart").val();
            const dateEnd = $("#dateEnd").val();

            $.ajax({
                url: "ControllerHr/getSummaryPresensiEmployee",
                method: "GET",
                data: {
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                    locationId: locationId,
                },
                dataType: "json",
                success: function (response) {
                    const presensiEmployee = response.employee;
                    const presensiData = response.presensiEmployees;
                    const presensiDataSummary = response.summaryTotal;

                    const allowanceSummary = response.allowance;
                    const deductionSummary = response.deduction;


                    // for detail
                    const days = response.day;
                    let html = `<tr style="text-align: center; background: linear-gradient(135deg, #884f47, #a85b4e); color: white; font-weight: bold;" >
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Jabatan</th>`;

                    days.forEach(function (day) {
                        html += `<th>${day.DATE}</th>`;
                    });

                    html += `</tr>`;

                    $("#employee-header").html(html);


                    // for summary

                    const type = response.type;
                    const deductionType = response.deductionType;
                    const allowanceType = response.allowanceType;

                    // baris pertama header
                    let htmlsummary = `<tr style="text-align: center; background: linear-gradient(135deg, #884f47, #a85b4e); color: white; font-weight: bold;">
                        <th rowspan="2">Nama</th>
                        <th rowspan="2">NIP</th>
                        <th rowspan="2">Jabatan</th>
                        <th rowspan="2">Sallary</th>
                        <th colspan="${type.length}">Status</th>
                        <th colspan="${deductionType.length}">Deduction</th>
                        <th colspan="${allowanceType.length}">Allowance</th>
                    </tr>`;

                    // baris kedua header
                    htmlsummary += `<tr style="text-align: center; background: linear-gradient(135deg, #884f47, #a85b4e); color: white; font-weight: bold;">`;

                    type.forEach(function (t) {
                        htmlsummary += `<th>${t.STATUS}</th>`;
                    });

                    deductionType.forEach(function (d) {
                        htmlsummary += `<th>${d.DEDUCTIONNAME}</th>`;
                    });

                    allowanceType.forEach(function (a) {
                        htmlsummary += `<th>${a.ALLOWANCENAME}</th>`;
                    });

                    htmlsummary += `</tr>`;

                    // inject ke tabel
                    $("#employee-headersummary").html(htmlsummary);


                    $("#employee-list").empty();
                    presensiEmployee.forEach(emp => {
                        let row = `<tr style="font-size: 13px">
                            <td style="text-align: center; font-weight: 600;">
                                ${emp.EMPLOYEENAME ?? '-'}
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                ${emp.NIP ?? '-'}
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                ${emp.JABATAN ?? '-'}
                            </td>
                            `;

                        days.forEach(day => {
                            const presensi = presensiData.find(p =>
                                p.EMPLOYEEID == emp.EMPLOYEEID && p.DATE == day.DATE
                            );

                            let checkIn = presensi?.CHECKINTIME ?? "-";
                            let checkOut = presensi?.CHECKOUTTIME ?? "-";
                            let status = presensi?.STATUS ?? "-";

                            let color = '';
                            let fontColor = 'black'
                            switch (status.toLowerCase()) {
                                case 'on':
                                    color = '#90EE90'; // hijau muda
                                    break;
                                case 'alpha':
                                    color = 'red'; // kuning muda
                                    fontColor = 'white'
                                    break;
                                case 'off':
                                    color = '#f8d7da'; // kuning muda
                                    break;
                                case 'ph':
                                    color = '#FFFF00'; // biru muda
                                    break;
                                default:
                                    color = '#FFFF00'; // abu netral
                            }

                            row += `
                                <td style="text-align: center; background-color: ${color};">
                                    <div style="font-weight: bold; color: ${fontColor}">${status}</div>
                                </td>
                            `;

                        });

                        row += `</tr>`;
                        $("#employee-list").append(row);
                    });

                    $("#employee-listsummary").empty();
                    presensiEmployee.forEach(emp => {
                        const sallary = emp?.SALLARY ?? "0";
                        let rowsummary = `<tr style="font-size: 13px">
                            <td style="text-align: center; font-weight: 600;">
                                ${emp.EMPLOYEENAME ?? '-'}
                            </td>
                             <td style="text-align: center; font-weight: 600;">
                                ${emp.NIP ?? '-'}
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                ${emp.JABATAN ?? '-'}
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                ${formatRupiah(sallary)}
                            </td>`;

                        type.forEach(type => {
                            const presensi = presensiDataSummary.find(p =>
                                p.EMPLOYEEID == emp.EMPLOYEEID && p.STATUS == type.STATUS
                            );

                            let total = presensi?.TOTAL ?? "0";
                            
                            rowsummary += `
                                <td style="text-align: center;">
                                    <div style="font-weight: bold;">${total}</div>
                                </td>
                            `;

                        });

                        deductionType.forEach(type => {
                            const presensi = deductionSummary.find(p =>
                                p.EMPLOYEEID == emp.EMPLOYEEID && p.DEDUCTIONNAME == type.DEDUCTIONNAME
                            );

                            let total = presensi?.AMOUNT ?? "0";
                            

                            rowsummary += `
                                <td style="text-align: center;">
                                    <div style="font-weight: bold;">${formatRupiah(total)}</div>
                                </td>
                            `;
                        });

                        allowanceType.forEach(type => {
                            const presensi = allowanceSummary.find(p =>
                                p.EMPLOYEEID == emp.EMPLOYEEID && p.ALLOWANCENAME == type.ALLOWANCENAME
                            );

                            let total = presensi?.AMOUNT ?? "0";

                            rowsummary += `
                                <td style="text-align: center;">
                                    <div style="font-weight: bold;">${formatRupiah(total)}</div>
                                </td>
                            `;
                        });
                        rowsummary += `</tr>`;
                        $("#employee-listsummary").append(rowsummary);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data: " + error);
                }
            });
        }
        loadSchedule();

        $('#form-cari-invoice').on('submit', function (e) {
            e.preventDefault();
            loadSchedule();
        });

        window.changeSPPayment = function (value) {
            var scheduleElement = document.querySelector('.schedule');
            if (value == "2") {
                scheduleElement.style.display = "none";
            } else {
                scheduleElement.style.display = "block";
            }
        }
        $("#exportExcelPresensi").on("click", function () {
            let wb = XLSX.utils.book_new();
            let ws = XLSX.utils.table_to_sheet(document.getElementById("table-presensi"));
            XLSX.utils.book_append_sheet(wb, ws, "Presensi");
            XLSX.writeFile(wb, "PresensiEmployee.xlsx");
        });

        // Export tabel summary
        $("#exportExcelSummary").on("click", function () {
            let wb = XLSX.utils.book_new();
            let ws = XLSX.utils.table_to_sheet(document.getElementById("table-summary"));
            XLSX.utils.book_append_sheet(wb, ws, "Summary");
            XLSX.writeFile(wb, "SummaryEmployee.xlsx");
        });
    });
</script>


</html>