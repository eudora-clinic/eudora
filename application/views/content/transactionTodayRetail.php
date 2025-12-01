<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Transaction Retail Today</title>

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
    </style>



    <?php

    $db_oriskin = $this->load->database('oriskin', true);
    $userid = $this->session->userdata('userid');
    $locationIdFromUserdata = $this->session->userdata('locationid');
    $level = $this->session->userdata('level');



    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

    $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

    $dateSearch = (isset($_GET['dateSearch']) ? $this->input->get('dateSearch') : date('Y-m-d'));

    $dateEnd = (isset($_GET['dateEnd']) ? $this->input->get('dateEnd') : date('Y-m-d'));

    $locationId = (isset($_GET['locationId']) ? $this->input->get('locationId') :  $locationIdFromUserdata);

    $listTransactionTreatment = $db_oriskin->query("SELECT 
                                a.customerid as CUSTOMERID, a.id as ID, a.invoiceno as INVOICENO , CAST(a.invoicedate AS DATE) AS INVOICEDATE , c.firstname as FIRSTNAME , b.total as TOTAL, d.name  as DIINPUT, e.name as SALES, f.name as TREATMENT
                                from slinvoicehdr a 
                                inner join slinvoicedtl b on a.id = b.invoicehdrid  
                                inner join mscustomer c on a.customerid = c.id 
                                inner join msemployee d on a.frontdeskid = d.id 
                                inner join msemployee e on a.salesid = e.id
                                inner join msproduct f on b.productid = f.id
                                where a.locationid = $locationId  and CONVERT(varchar(10), a.invoicedate, 120)  between '" . $dateSearch  . "' and  '" . $dateEnd  . "' and status <> 3")->result_array();


    $listTransactionDownPaymentTreatment = $db_oriskin->query("SELECT 
                                a.customerid as CUSTOMERID,a.id as ID, a.downpaymentno as INVOICENO , CAST(a.downpaymentdate AS DATE) as INVOICEDATE , c.firstname as FIRSTNAME , b.total as TOTAL, d.name  as DIINPUT, e.name as SALES, f.name as TREATMENT
                                from sldownpaymentproducthdr a 
                                inner join sldownpaymentproductdtl b on a.id = b.downpaymenthdrid  
                                inner join mscustomer c on a.customerid = c.id 
                                inner join msemployee d on a.frontdeskid = d.id 
                                inner join msemployee e on a.salesid = e.id
                                inner join msproduct f on b.productid = f.id
                                where a.locationid = $locationId  and CONVERT(varchar(10), a.downpaymentdate, 120)  between '" . $dateSearch  . "' and  '" . $dateEnd  . "'   and status <> 3")->result_array();
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <?php if ($level == 4 || $level == 6 || $level == 8) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>START DATE</label>
                                    <input type="date" class="form-control text-uppercase" name="dateSearch" id="dateSearch" value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>ENDATE</label>
                                    <input type="date" class="form-control text-uppercase" name="dateEnd" id="dateEnd" value="<?= $dateEnd ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="">
                                    <!-- <label class="form-label mt-2">Location</label> -->
                                    <select id="locationId" name="locationId" class="form-control text-uppercase" required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm top-responsive  btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <?php if ($level == 1 || $level == 11) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>START DATE</label>
                                    <input type="date" class="form-control text-uppercase" name="dateSearch" id="dateSearch" value="<?= $dateSearch ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>ENDATE</label>
                                    <input type="date" class="form-control text-uppercase" name="dateEnd" id="dateEnd" value="<?= $dateEnd ?>" placeholder="DATE SEARCH" required>
                                </div>
                            </div>
                     
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm top-responsive  btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <?php if ($level == 3) { ?>
                <div class="card p-2 col-md-7">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3">
                            <div class="col-md-9">
                                <div class="">
                                    <!-- <label class="form-label mt-2">Location</label> -->
                                    <select id="locationId" name="locationId" class="form-control text-uppercase" required="true" aria-required="true">
                                        <option value="">Select Branch</option>
                                        <?php foreach ($locationList as $j) { ?>
                                            <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm top-responsive  btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>

            <div>
                <ul class="nav nav-tabs active mt-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#dailySales">FULL PAYMENT</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#detailPayment">DOWN PAYMENT</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class="panel-body tab-pane show active" id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    TRANSACTION PRODUCT TODAY: <?= $dateSearch ?> - <?= $dateEnd ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">INVOICEDATE</th>
                                                    <th style="text-align: center;">INVOICENO</th>
                                                    <th style="text-align: center;">CUSTOMER</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">TOTAL</th>
                                                    <th style="text-align: center;">FRONTDESK</th>
                                                    <th style="text-align: center;">SALES</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>


                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($listTransactionTreatment as $row) {
                                                ?>
                                                    <tr role="" style="font-weight: 400;">
                                                        <td style="text-align: center;"><?= $no++ ?></td>
                                                        <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                        <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FIRSTNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENT'] ?></td>
                                                        <td style="text-align: right;"><?= number_format($row['TOTAL'], 0, '.', ',') ?></td>
                                                        <td style="text-align: center;"><?= $row['DIINPUT'] ?></td>
                                                        <td style="text-align: center;"><?= $row['SALES'] ?></td>
                                                        <td style="text-align: center;">
                                                            <a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/printinvoice/5/<?= $row['ID'] ?>">print</a>
                                                            <a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/printinvoiceSummary/<?= $row['INVOICEDATE'] ?>/<?= $row['CUSTOMERID'] ?>">print all</a>
                                                            <?php if ($level == 3 || $level == 4) { ?>
                                                                <button class="btn btn-primary btn-sm void-btn" data-id="<?= $row['ID'] ?>" data-rev="5">void</button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body tab-pane" id="detailPayment">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    TRANSACTION  DOWNPAYMENT PRODUCT TODAY :  <?= $dateSearch ?> - <?= $dateEnd ?>
                                    </h4>
                                    <div class="table-wrapper p-4">
                                        <div class="table-responsive">
                                            <table id="tableDetailPayment" class="table table-striped table-bordered" style="width:100%">
                                                <thead class="bg-thead">
                                                    <tr>
                                                        <th style="text-align: center;">NO</th>
                                                        <th style="text-align: center;">INVOICEDATE</th>
                                                        <th style="text-align: center;">INVOICENO</th>
                                                        <th style="text-align: center;">CUSTOMER</th>
                                                        <th style="text-align: center;">TREATMENT</th>
                                                        <th style="text-align: center;">TOTAL</th>
                                                        <th style="text-align: center;">FRONTDESK</th>
                                                        <th style="text-align: center;">SALES</th>
                                                        <th style="text-align: center;">ACTION</th>
                                                    </tr>
                                                </thead>


                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($listTransactionDownPaymentTreatment as $row) {
                                                    ?>
                                                        <tr role="" style="font-weight: 400;">
                                                            <td style="text-align: center;"><?= $no++ ?></td>
                                                            <td style="text-align: center;"><?= $row['INVOICEDATE'] ?></td>
                                                            <td style="text-align: center;"><?= $row['INVOICENO'] ?></td>
                                                            <td style="text-align: center;"><?= $row['FIRSTNAME'] ?></td>
                                                            <td style="text-align: center;"><?= $row['TREATMENT'] ?></td>
                                                            <td style="text-align: right;"><?= number_format($row['TOTAL'], 0, '.', ',') ?></td>
                                                            <td style="text-align: center;"><?= $row['DIINPUT'] ?></td>
                                                            <td style="text-align: center;"><?= $row['SALES'] ?></td>
                                                            <td style="text-align: center;">
                                                                <a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/printinvoice/6/<?= $row['ID'] ?>">print</a>
                                                                <a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/printinvoiceSummaryDownPayment/<?= $row['INVOICEDATE'] ?>/<?= $row['CUSTOMERID'] ?>">print all</a>
                                                                <?php if ($level == 3 || $level == 4) { ?>
                                                                    <button class="btn btn-primary btn-sm void-btn" data-id="<?= $row['ID'] ?>" data-rev="6">void</button>
                                                                <?php } ?>
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

            <div class="modal fade modal-transparent" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="voidModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="voidModalLabel">Konfirmasi Void</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin melakukan void pada item ini?
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-danger" id="confirmVoid">Ya, Void</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#tableDailySales').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
        });



        $('#tableDetailPayment').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
        });

    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tableDetailPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

<script>
    $(document).ready(function() {
        var selectedId;

        // Ketika tombol Void diklik
        $(document).on("click", ".void-btn", function() {
            selectedId = $(this).data("id"); // Ambil ID dari tombol
            $("#voidModal").modal("show"); // Tampilkan modal
            selectedRev = $(this).data("rev");
        });

        // Konfirmasi Void
        $("#confirmVoid").click(function() {

            $.ajax({
                url: "<?= base_url() . 'App/voidController' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    id: selectedId,
                    rev: selectedRev
                },
                success: function(response) {
                    console.log(response);

                    if (response.status === 'success') {
                        alert("Void berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                        location.reload(); // Reload halaman untuk update data
                    } else {
                        alert("Terjadi kesalahan saat memproses void.");
                    }


                },
                error: function() {
                    alert("Terjadi kesalahan saat memproses void.");
                }
            });
        });
    });
</script>

</html>