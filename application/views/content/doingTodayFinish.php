<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Doing Finish Today</title>

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

    $level = $this->session->userdata('level');


    $query = $db_oriskin->query('SELECT locationaccsesid FROM msuser WHERE id = ' . $userid . '')->row_array();
    $locationAccsesIds = isset($query['locationaccsesid']) ? preg_replace('/[^0-9,]/', '', $query['locationaccsesid']) : '';

    $locationList = $db_oriskin->query("SELECT DISTINCT id, name FROM mslocation WHERE id IN ($locationAccsesIds)")->result_array();

    $dateSearch = date('Y-m-d');

    $locationId = (isset($_GET['locationId']) ? $this->input->get('locationId') :  $locationList[0]['id']);


    $locationIdInt = intval($locationId);

    $listTransactionTreatment = $db_oriskin->query("SELECT 
                               a.id as ID, a.treatmentdate as DATETREATMENT, a.starttreatment as STARTTIME , a.endtreatment as ENDTIME, e.name as FRONTDESK, c.name as TREATMENTNAME,  b.firstname  as CUSTOMERNAME, d.name as DOINGBY, a.qty as JUMLAH
                                from trdoingtreatment a 
                                inner join mscustomer b on a.customerid = b.id
                                INNER JOIN mstreatment c on a.producttreatmentid = c.id 
                                INNER JOIN msemployee d on a.treatmentdoingbyid = d.id 
                                INNER JOIN msemployee e on a.frontdeskid = e.id
                                where a.locationid =  ? and a.status = 17 and CONVERT(varchar(10), a.treatmentdate, 120) = '" .$dateSearch. "' ", [$locationIdInt])->result_array();
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
        <?php if ($level == 3) { ?>
            <div class="card p-2 col-md-6">
                <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-9">
                            <div class="">
                                <!-- <label class="form-label mt-2">Location</label> -->
                                <select id="locationId" name="locationId" class="form-control text-uppercase " required="true" aria-required="true">
                                    <option value="">Select Branch</option>
                                    <?php foreach ($locationList as $j) { ?>
                                        <option value="<?= $j['id'] ?>" <?= ($locationId == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn w-100 btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php } ?>

            <div class=" ">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                                    DOING FINISH TODAY: <?= $dateSearch ?>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">ID</th>
                                                    <th style="text-align: center;">DATE</th>
                                                    <th style="text-align: center;">START</th>
                                                    <th style="text-align: center;">END</th>
                                                    <th style="text-align: center;">QTY</th>
                                                    <th style="text-align: center;">CUSTOMER</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">FRONTDESK</th>
                                                    <th style="text-align: center;">DOINGBY</th>
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
                                                        <td style="text-align: center;"><?= $row['ID'] ?></td>
                                                        <td style="text-align: center;"><?= $row['DATETREATMENT'] ?></td>
                                                        <td style="text-align: center;"><?= $row['STARTTIME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['ENDTIME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['JUMLAH'] ?></td>
                                                      
                                                        <td style="text-align: center;"><?= $row['CUSTOMERNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['TREATMENTNAME'] ?></td>
                                                        <td style="text-align: center;"><?= $row['FRONTDESK'] ?></td>
                                                        <td style="text-align: center;"><?= $row['DOINGBY'] ?></td>
                                                        <td style="text-align: center;">
                                                         
                                                            <?php if ($level == 3) { ?>
                                                            <button class="btn btn-primary btn-sm void-btn" data-id="<?= $row['ID'] ?>" data-rev="7">void</button>
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
    var numberFormat = function(number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
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

    $(document).ready(function() {
        $('#tableDailySales').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
        });


    });


    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

</script>

<script>
    $(document).ready(function() {
        var selectedId;

        // Ketika tombol Void diklik
        $(".void-btn").click(function() {
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