<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .container {
            /* width: 800px; */
            /* margin: 20px auto; */
            /* padding: 20px; */
            /* border: 1px solid #000; */
        }

        .header {
            /* text-align: center; */
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 0;
            font-size: 12px;
        }

        .section {
            margin-top: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .product-table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature .left {
            text-align: left;
        }

        .signature img {
            width: 150px;
            height: auto;
        }



        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            padding: 5px;
        }

        .bank-details {
            margin-top: 10px;
            text-align: left;
            background-color: grey;
            padding: 5px;
        }

        .terbilang {
            margin-top: 10px;
            /* font-style: italic; */
            /* display: flex; */
            /* flex-direction: row; */
        }

        .div-header {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<?php
//  echo $data_stock[0]['ingredientsName'];
// echo json_encode($data_company);

// echo $total['totalSum'];

// echo $terbilang;
?>

<script>
        window.print()
    </script>

<body>
    <div class="container">
        <!-- Header -->
        <div class="div-header">
            <div style="width: 80%;">
                <div class="header">
                    <h1 style="font-weight: bold; margin-bottom: 4px;">PT. Sejuk Pesona Alami</h1>
                    <p style="line-height: 1.2;">
                        Komplek Duta Square<br>
                        Jl. Pangeran Tubagus Angke Blok A No.9<br>
                        Kel. Wijaya Kusuma - Kec. Grogol Petamburan<br>
                        Jakarta Barat<br>
                        Kota Administrasi Jakarta Barat, DKI Jakarta 11460<br>
                        Indonesia
                    </p>

                </div>
                <div style="text-align: left; width: 300px; margin-top: 30px;">
                    <div style="border-top: 2px solid black; margin-bottom: 1px;"></div>
                    <span style="display: inline-block; margin: 0 0;">Kepada :</span>
                    <div style="border-bottom: 2px solid black; margin-top: 1px;"></div>
                    <strong style="display: inline-block; margin-top: 5px; font-weight: bold; text-transform: uppercase;"><?= $data_company[0]['companyname'] ?></strong>
                </div>

            </div>

            <div style="margin-top: 5%; width: 100%;">
                <h2 style="text-align: center; font-size: 20px; font-weight: 400;">Faktur Penjualan</h2>
                <div style="display: flex; flex-direction: row; justify-content: space-around;">
                    <div style="width: 100%;">
                    </div>
                    <div style=" width: 100%; font-family: Arial, sans-serif; margin-bottom: 10px;">
                        <span style="">Nomor:</span>
                        <div style=" font-weight: bold;"><?= $invoice ?></div>
                        <div style="border-bottom: 2px dashed black; margin-top: 5px;"></div>
                    </div>
                </div>


                <div style="border: 2px solid black; font-family: Arial, sans-serif; font-size: 14px;">
                    <div style="display: flex;">
                        <!-- Kolom Kiri -->
                        <div style="flex: 1; padding: 5px; border-right: 2px dashed black;">
                            <div style="">
                                <span style="font-size: 12px;">Tanggal</span><br>
                                <span style="font-size: 12px; font-weight: bold;"><?= date('d M Y', strtotime($data_stock[0]['dateSend'])); ?></span>
                                <div style="border-bottom: 2px dashed black; margin-top: 5px;"></div>
                            </div>
                            <div style="">
                                <span style="font-size: 12px;">Syarat Pembayaran</span><br>
                                <span style="font-size: 12px; font-weight: bold;">C.B.D</span>
                                <div style="border-bottom: 2px dashed black; margin-top: 5px;"></div>
                            </div>
                            <div style="">
                                <span style="font-size: 12px; margin-bottom: 14px;">Ekspedisi</span><br>
                                <p></p>
                                <div style="border-bottom: 2px dashed black; margin-top: 7px;"></div>
                            </div>
                            <div>
                                <span style="font-size: 12px;">PO No</span><br>
                                <p></p>

                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div style="flex: 1; padding: 5px;">
                            <div style="margin-bottom: 12px;">
                                <div style="border-bottom: 2px dashed black; margin-top: 5px;"></div>
                                <span style="font-size: 12px;">Tanggal Pengiriman</span><br>
                                <span style="font-size: 12px; font-weight: bold;"><?= date('d M Y', strtotime($data_stock[0]['dateSend'])); ?></span>

                            </div>
                            <div style="margin-bottom: 12px;">
                                <div style="border-bottom: 2px dashed black; margin-top: 5px;"></div>
                                <span
                                 style="font-size: 12px;">Mata Uang</span
                                ><br>
                                <span style="font-size: 12px; font-weight: bold;">Indonesian Rupiah</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <!-- Product Table -->
        <table class="product-table" style="font-size: 12px; font-weight: 200; border: 1px solid black;">
            <thead style="border: 1px solid black;">
                <tr style="border: 1px solid black;">
                    <th class="text-center" style="border: 1px solid black; text-align: center;">Kode Brg</th>
                    <th class="text-center" style="border: 1px solid black; text-align: center;">Nama Barang</th>
                    <th class="text-center" style="border: 1px solid black; text-align: center;">Kts.</th>
                    <th class="text-center" style="border: 1px solid black; text-align: center;">@Harga</th>
                    <th class="text-center" style="border: 1px solid black; text-align: center;">Diskon</th>
                    <th class="text-center" style="border: 1px solid black; text-align: center;">Total Harga</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                <?php
                $no = 1;
                foreach ($data_stock as $row) {
                ?>
                    <tr style="border: 1px solid black; ">
                        <td style="text-align: center; border: 1px solid black;"><?= $row['code'] ?></td>
                        <td style="border: 1px solid black;"><?= $row['ingredientsName'] ?></td>
                        <td style="border: 1px solid black;" class="text-center"><?= $row['qty'] ?></td>
                        <td style="border: 1px solid black;" class="text-right"><?= number_format($row['pricePerUnit'], 0, '.', ',') ?></td>
                        <td style="border: 1px solid black;" class="text-right">0</td>
                        <td style="border: 1px solid black;" class="text-right"><?= number_format($row['total'], 0, '.', ',') ?></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

        <!-- Terbilang -->
        <div style="border-bottom: 2px solid black; margin: 0; margin-top: 10px;"></div>
        <div style="display: flex; align-items: center; margin-top: 10px;">
            <p style="margin: 0; margin-right: 10px;">Terbilang:</p>
            <p style="border: 2px solid black; width: 100%; margin: 0; padding: 5px;"><?= $terbilang ?></p>
        </div>



        <!-- Signature Section -->
        <div style="display: flex; flex-direction: row; justify-content: space-between; margin-top: 20px;">
            <div style="width: 55%;">
                <div style="border: 2px solid black; width: 100%; box-sizing: border-box; position: relative; padding: 10px;">
                    <p style="margin: 0; position: absolute; top: -10px; left: 10px; background: #f2f2f2; padding: 0 5px;">Keterangan :</p>
                    <div style=" height: 90px; margin-top: 10px; width: 100%;"></div>
                </div>

                <div class="left" style="margin-top: 20px;">
                    <p>PT. SEJUK PESONA ALAMI</p>
                </div>
                <div class="right">
                    <div style="border-bottom: 2px solid black; margin: 0; margin-top: 80px;width: 50%;"></div>
                    <p style="">Tgl:</p>
                </div>
            </div>

            <div style="width: 35%;">
                <!-- Summary Section -->
                <div class="summary">
                    <table>
                        <tr>
                            <td class="text-left" style="border: 2px solid black;"><strong>Sub Total:</strong></td>
                            <td class="text-right" style="border: 2px solid black; width: 50%;"><?= number_format($total['totalSum'], 0, '.', ',') ?></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="border: 2px solid black;"><strong>Diskon:</strong></td>
                            <td class="text-right" style="border: 2px solid black; width: 50%;">0</td>
                        </tr>

                    </table>

                    <table style="margin-top: 5px; width: 100%; border-collapse: collapse;">
                        <tr>
                            <td class="text-left" style="border: 2px solid black; width: 50%;"><strong>Biaya Lain-lain</strong></td>
                            <td class="text-right" style="border: 2px solid black; width: 50%;">0</td>
                        </tr>
                    </table>
                    <table style="margin-top: 5px; width: 100%; border-collapse: collapse;">
                        <tr>
                            <td class="text-left" style="border: 2px solid black; width: 50%;"><strong>PPN (0%):</strong></td>
                            <td class="text-right" style="border: 2px solid black; width: 50%;">0</td>
                        </tr>
                    </table>


                    <table style="margin-top: 5px; width: 100%; border-collapse: collapse;font-weight: bold;">
                        <tr>
                            <td class="text-left" style="border: 3px solid black; width: 50%;"><strong>Total:</strong></td>
                            <td class="text-right" style="border: 3px solid black; width: 50%;"><?= number_format($total['totalSum'], 0, '.', ',') ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Bank Details -->
                <div style="margin-top: 10px;
            text-align: left;
            background-color: grey;
            padding: 5px; font-weight: bold; color: #000; border: 2px solid black;">
                    <span>Transfer ke<br></span>
                    <span>
                        Bank BCA<br>
                        PT SEJUK PESONA ALAMI<br>
                        a/c 407.039.8261</span>
                </div>
            </div>
        </div>



    </div>
</body>

</html>