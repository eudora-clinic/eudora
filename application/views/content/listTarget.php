<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - List Target</title>

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

<body>
    <div>
        <div class="mycontaine">
            <div class="card p-2 col-md-6">
                <form id="form-cari-invoice" method="post" action="<?= base_url('listTarget') ?>">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="period">PERIOD</label>
                                <input type="month" name="period" class="form-control filter_period"
                                    value="<?= $period ?>" required>

                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
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
                <ul class="nav nav-tabs active mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#outlet">TARGET OUTLET</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#consultant">TARGET CONSULTANT</a>
                    </li>
                </ul>
            </div>
            <div class="">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="outlet">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    TARGET OUTLET <?= $period ?>
                                    <a href="https://sys.eudoraclinic.com:84/app/addTargetOutlet"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">PERIOD</th>
                                                    <th style="text-align: center;">TARGET OMSET</th>
                                                    <th style="text-align: center;">TARGET NEW MEMBER</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>

                                                    <th style="text-align: left;"></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listTargetOutlet as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PERIOD'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['TARGET'], 0, ',', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $row['TARGETUNIT'] ?></td>
                                                        <td style="text-align: center;">
                                                            <button class="btn-primary btn btn-sm btn-update"
                                                                onclick='openUpdateModal(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)'>UPDATE</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-body tab-pane" id="consultant">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    TARGET CONSULTANT <?= $period ?>
                                    <a href="https://sys.eudoraclinic.com:84/app/addTargetConsultant"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableEmployeeAppointment" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CONSULTANT</th>
                                                    <th style="text-align: center;">GRADE</th>
                                                    <th style="text-align: center;">JOB</th>
                                                    <th style="text-align: center;">PERIOD</th>
                                                    <th style="text-align: center;">TARGET</th>
                                                    <th style="text-align: center;">UNIT</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="text-align: right;"></th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listTargetConsultant as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['CONSULTANTNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['statusConsultant'] ?></td>
                                                        <td style="text-align: center;"><?= $row['job'] ?></td>
                                                        <td style="text-align: center;"><?= $row['PERIOD'] ?></td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['TARGET'], 0, ',', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <?= number_format($row['TARGETUNIT'], 0, ',', ',') ?>
                                                        </td>
                                                        <td style="text-align: center;"><?= $row['LOCATION'] ?></td>
                                                          <td style="text-align: center;">
                                                            <button class="btn-primary btn btn-sm btn-update"
                                                                onclick='openUpdateModalConsultant(<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>)'>UPDATE</button>
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

    <!-- Modal Update Target -->
    <div class="modal fade" id="updateTargetModal" tabindex="-1" role="dialog" aria-labelledby="updateTargetModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formUpdateTarget">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateTargetModalLabel">Update Target Outlet</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Hidden fields -->
                        <input type="hidden" id="updateId" name="updateId">

                        <div class="form-group">
                            <label for="locationNameView">Outlet</label>
                            <input type="text" id="locationNameView" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="updatePeriod">Period</label>
                            <input type="text" id="updatePeriod" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="targetValue">Target Revenue (Rp)</label>
                            <input type="number" class="form-control" id="targetValue" name="targetValue" required>
                        </div>

                        <div class="form-group">
                            <label for="targetUnit">Target Unit</label>
                            <input type="number" class="form-control" id="targetUnit" name="targetUnit" required>
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


    <!-- Modal Update Target -->
    <div class="modal fade" id="updateTargetModalConsultant" tabindex="-1" role="dialog"
        aria-labelledby="updateTargetConsultantModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formUpdateTargetConsultant">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateTargetConsultantModalLabel">Update Target Consultant</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="updateIdConsultant" name="updateIdConsultant">
                         <div class="form-group">
                            <label for="consultantUpdate">Consultant</label>
                            <input type="text" id="consultantUpdate" class="form-control" readonly>
                        </div>

                        <div class="form-column">
                            <label for="updateLocationidConsultant" class="form-label mt-2"><strong>Outlet:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="updateLocationidConsultant" name="updateLocationidConsultant" class="form-control" required="true"
                                aria-required="true">
                                <?php foreach ($locationList as $j) { ?>
                                    <option value="<?= $j['id'] ?>">
                                        <?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="updateStatusConsultant">Grade</label>
                            <select id="updateStatusConsultant" name="updateStatusConsultant" class="form-control" required>
                                <option value="SENIOR">SENIOR</option>
                                <option value="JUNIOR">JUNIOR</option>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="updateJob">Job</label>
                            <select id="updateJob" name="updateJob" class="form-control">
                                <option value="">PILIH JOB</option>
                                <option value="ASDOK">ASDOK</option>
                                <option value="BC">BC</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="updatePeriodConsultant">Period</label>
                            <input type="text" id="updatePeriodConsultant" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label for="targetValueConsultant">Target Revenue (Rp)</label>
                            <input type="number" class="form-control" id="targetValueConsultant" name="targetValueConsultant" required>
                        </div>

                        <div class="form-group">
                            <label for="targetUnitConsultant">Target Unit</label>
                            <input type="number" class="form-control" id="targetUnitConsultant" name="targetUnitConsultant" required>
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
    var numberFormat = function (number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };

        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }

        return s.join(dec);
    }
    $(document).ready(function () {
        var table = $('#tableDailySales').DataTable({
            "pageLength": 20,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered7 = display.map(el => data[el][3]).reduce((a, b) => intVal(a) + intVal(b), 0);


                $(api.column(3).footer()).html(
                    numberFormat(sumCol11Filtered7,)
                );


            },
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

        var tableAppt = $('#tableEmployeeAppointment').DataTable({
            "pageLength": 20,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(
                        /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };

                var sumCol11Filtered13 = display.map(el => data[el][5]).reduce((a, b) => intVal(a) + intVal(b), 0);



                $(api.column(5).footer()).html(
                    numberFormat(sumCol11Filtered13,)
                );


            },
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
    });

    function openUpdateModal(row) {
        $('#updateId').val(row.ID);
        $('#locationNameView').val(row.LOCATIONNAME);
        $('#updatePeriod').val(row.PERIOD);
        $('#targetValue').val(row.TARGET);
        $('#targetUnit').val(row.TARGETUNIT);

        $('#updateTargetModal').modal('show');
    }

    function openUpdateModalConsultant(row) {
        console.log(row);
        
        $('#updateIdConsultant').val(row.ID);
        $('#consultantUpdate').val(row.CONSULTANTNAME);
        $('#updateLocationidConsultant').val(row.LOCATIONID);
        $('#updateStatusConsultant').val(row.statusConsultant);
        $('#updatePeriodConsultant').val(row.PERIOD);
        $('#targetValueConsultant').val(row.TARGET);
         $('#targetUnitConsultant').val(row.TARGETUNIT);
         $('#updateJob').val(row.job);

        $('#updateTargetModalConsultant').modal('show');
    }


    $('#formUpdateTarget').on('submit', function (e) {
        e.preventDefault();

        console.log($(this).serialize());


        $.ajax({
            url: '<?= base_url('App/updateTargetOutlet') ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                console.log(response);

                if (response.success) {
                    $('#updateTargetModal').modal('hide');
                    location.reload();

                    Swal.fire('Berhasil!', response.message, 'success');
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            }
        });
    });

    $('#formUpdateTargetConsultant').on('submit', function (e) {
        e.preventDefault();

        console.log($(this).serialize());


        $.ajax({
            url: '<?= base_url('App/updateTargetConsultant') ?>',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                console.log(response);

                if (response.success) {
                    $('#updateTargetModalConsultant').modal('hide');
                    location.reload();

                    Swal.fire('Berhasil!', response.message, 'success');
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            }
        });
    });




    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableEmployeeAppointment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>