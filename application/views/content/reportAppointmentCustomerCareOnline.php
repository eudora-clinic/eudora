<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>

    <style>
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

        /* Agar select dropdown memiliki padding lebih baik */
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
            <div class="card p-2 col-md-9">
                <form id="form-cari-invoice" method="post"
                    action="<?= base_url('reportAppointmentCustomerCareOnline') ?>">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                <input type="date" name="dateStart" class="form-control filter_period"
                                    value="<?= $dateStart ?>" required>

                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date End</label>
                                <input type="date" name="dateEnd" class="form-control filter_period"
                                    value="<?= $dateEnd ?>" required>

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
            <div>
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div>
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    REPORT APPOINTMENT: <?= $dateStart ?> - <?= $dateEnd ?>
                                </h3>

                                <div class="row p-4 filter-container">
                                    <label for="filterBranch">OUTLET:</label>
                                    <select id="filterBranch" multiple="multiple">
                                        <option value="">ALL</option>
                                        <?php foreach ($location_list as $location) { ?>
                                            <option value="<?= htmlspecialchars($location['name']) ?>">
                                                <?= htmlspecialchars($location['name']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>

                                    <label for="filterPromotion">STATUS:</label>
                                    <select id="filterPromotion" multiple="multiple">
                                        <option value="">ALL</option>
                                        <option value="Waiting Confirmation">Waiting Confirmation</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Checkin">Checkin</option>
                                        <option value="Last Minute Cancel">Last Minute Cancel</option>
                                        <option value="Not Show">Not Show</option>
                                        <option value="Finished">Finished</option>
                                    </select>
                                </div>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CUSTOMER NAME</th>
                                                    <th style="text-align: center;">CELLPHONENUMBER</th>
                                                    <th style="text-align: center;">CREATEDATE</th>
                                                    <th style="text-align: center;">APPOINTMENTDATE</th>
                                                    <th style="text-align: center;">STATUS</th>
                                                    <th style="text-align: center;">BRANCH</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($appointmentList as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CREATEDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['APPOINTMENTDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['STATUS'] ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
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
</body>
<script>
    $(document).ready(function () {
        var table = $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
             dom: 'Bfrtip',
            buttons: [{
                extend: 'pdfHtml5',
                title: 'SUMMARY REVENUE BY SALES',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A3',
                footer: true,
                // exportOptions: {
                //     columns: [0, 1, 2, 3, 4]
                // },
                customize: function (doc) {

                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function (row, index) {
                        if (index > 0 && row[0].text !== '') {
                            row[0].text = rowCount;
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;

                    doc.content[1].layout = {
                        hLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function (i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function (i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                }
            }, 'excel']
        });

        $('#filterBranch, #filterPromotion').select2({
            width: '200px'
        });

        $('#filterBranch').on('change', function () {
            var values = $(this).val().join('|');
            table.column(6).search(values, true, false).draw();
        });

        $('#filterPromotion').on('change', function () {
            var valuesStatus = $(this).val().join('|');
            table.column(5).search(valuesStatus, true, false).draw();
        });
    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>