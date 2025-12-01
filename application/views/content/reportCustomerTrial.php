<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Hand Work Dokter</title>

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
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="post"
                        action="<?= base_url('reportCustomerTrial') ?>">
                        <div class="row g-3">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select id="locationId" name="locationId" class="form-control text-uppercase "
                                        required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>>
                                                <?= $j['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
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
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div>
                            <div class="card">
                                <h3 class="card-header card-header-info" style="font-weight: bold; color: #666666;">
                                    REPORT CUSTOMER TRIAL
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CLINIC</th>
                                                    <th style="text-align: center;">CUSTOMERNAME</th>
                                                    <th style="text-align: center;">CELLPHONENUMBER</th>
                                                    <th style="text-align: center;">CUSTOMERCODE</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                           
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($reportCustomerTrial as $row) {
                                                    ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['LOCATIONNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?></td>
                                                        <td style="text-align: center;"><?= $row['CUSTOMERCODE'] ?></td>
                                                        <td style="text-align: center;">
                                                             <a target="_blank" class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/detailPrepaidInvoiceCustomer/<?= $row['CUSTOMERID'] ?>">DETAIL</a>
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
</body>
<script>
    $(document).ready(function () {
        var table = $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: 'Bfrtip',
            buttons: ['excel']
        });
    });

    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>