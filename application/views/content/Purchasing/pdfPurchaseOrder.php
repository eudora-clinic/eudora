<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Purchase Order Form</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
            clear: both;
        }

        .col-md-4,
        .col-md-6,
        .col-md-8,
        .col-md-12 {
            float: left;
            padding-left: 15px;
            padding-right: 15px;
            box-sizing: border-box;
        }

        .col-md-4 {
            width: 33.3333%;
        }

        .col-md-6 {
            width: 50%;
        }

        .col-md-8 {
            width: 66.6667%;
        }

        .col-md-12 {
            width: 100%;
        }

        .row::after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table th {
            background-color: #754267;
            /* hanya 6 digit */
            text-align: center;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 20px;
            vertical-align: middle;
        }

        table tr td {
            font: size 5px;
        }

        table thead th {
            background-color: #754267ff;
            font-weight: bold;
        }

        .no-border td {
            border: none;
            padding: 2px 5px;
        }

        .signature-box {
            height: 30px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            padding: 10px;
        }

        .signature-label {
            text-align: center;
            font-size: 10pt;
            padding: 30px;
        }

        td.no-border-top,
        th.no-border-top {
            border-top: none !important;
        }

        td.no-border-bottom,
        th.no-border-bottom {
            border-bottom: none !important;
        }

        td.no-border-vertical,
        th.no-border-vertical {
            border-top: none !important;
            border-bottom: none !important;
        }

        p {
            margin: 2px 0;
        }

        .p-5 {
            padding: 5px !important;
        }

        .p-10 {
            padding: 10px !important;
        }

        .p-20 {
            padding: 20px !important;
        }

        .p-30 {
            padding: 30px !important;
        }

        .pv-5 {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .ph-10 {
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .small-text {
            font-size: 8px;
        }

        .medium-text {
            font-size: 10px;
        }
    </style>
</head>

<body>

    <table class="no-border" style="maargin-bottom:10px;">
        <tr>
            <td style="text-align: center; vertical-align: middle;">
                <img src="https://sys.eudoraclinic.com:84/app/uploads/logo/logo_eudora.jpg" alt="Eudora Logo"
                    style="height: 40px;">
            </td>
            <td><span style="font-weight: bold; font-size: 18px;">
                    PURCHASE ORDER FORM
                </span></td>
            <td></td>
        </tr>
    </table>

    <div class="table">
        <table class="no-border small-text" style="margin:20px;">
            <tr>
                <!-- <td><?= $purchase_order['orderer_name'] ?? '-' ?></td> -->
                <td></td>
                <td>
                    <table class="no-border">
                        <tr>
                            <td>PO No.</td>
                            <td colspan="2">: <?= $purchase_order['order_number'] ?? '-' ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><?= $purchase_order['companyname'] ?? '-' ?></td>
                <td></td>
                <td>
                    <table class="no-border">
                        <tr>
                            <td>Date</td>
                            <td colspan="2">: <?= strtr(date('j F Y', strtotime($purchase_order['orderdate'])), [
                                'January' => 'Januari',
                                'February' => 'Februari',
                                'March' => 'Maret',
                                'April' => 'April',
                                'May' => 'Mei',
                                'June' => 'Juni',
                                'July' => 'Juli',
                                'August' => 'Agustus',
                                'September' => 'September',
                                'October' => 'Oktober',
                                'November' => 'November',
                                'December' => 'Desember'
                            ]) ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td><?= $purchase_order['company_address'] ?? '-' ?>, <?= $purchase_order['city_name'] ?>,
                    <?= $purchase_order['province_name'] ?>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $purchase_order['company_phone'] ?? '-' ?></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>
    <!-- </div> -->

    <table class="no-border small-text" style="margin:20px;">
        <tr>
            <td>
                <table>
                    <tr bgcolor="#d6a6c9" style="text-align:center;">
                        <th>Vendor</th>
                    </tr>
                    <tr>
                        <td>
                            <table class="no-border">
                                <tr>
                                    <td>Company Name</td>
                                    <td>: <?= $purchase_order['supplier_name'] ?? $purchase_order['ecommerce_name'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sales Name</td>
                                    <td>: <?= $purchase_order['sales_name'] ?? '-' ?></td>
                                </tr>
                                <tr>
                                    <td>Payment</td>
                                    <td>:
                                        <?php
                                        echo isset($purchase_order['status_pembayaran'])
                                            ? ($purchase_order['status_pembayaran'] == 0 ? 'Cash'
                                                : ($purchase_order['status_pembayaran'] == 1 ? 'Tempo 15 Hari'
                                                    : ($purchase_order['status_pembayaran'] == 2 ? 'Tempo 30 Hari' : '-')))
                                            : '-';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:
                                        <?= $purchase_order['sales_address'] ?? $purchase_order['supplier_address'] ?? '-' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>: -</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td>
                <table>
                    <tr bgcolor="#d6a6c9" style="text-align:center;">
                        <th>SHIP TO</th>
                    </tr>
                    <tr>
                        <td>
                            <table class="no-border">
                                <tr>
                                    <td>Company Name</td>
                                    <td>: <?= $purchase_order['companyname'] ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>: <?= $purchase_order['company_address'] ?></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>: <?= $purchase_order['company_phone'] ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br><br>

    <!-- Items Table -->
    <table class="small-text" style="text-align:center;padding:2px;">

        <tr style="text-align:center;padding:2px;">
            <th style="width:3%;" bgcolor="#d6a6c9"><strong>No</strong></th>
            <th bgcolor="#d6a6c9" style="width:5%;"><strong>Code</strong></th>
            <th style="width:27%" bgcolor="#d6a6c9"><strong>Item</strong></th>
            <th style="width:8%;" bgcolor="#d6a6c9"><strong>Qty Per Pax</strong> </th>
            <th style="width:5%;" bgcolor="#d6a6c9"><strong>Qty</strong></th>

            <th style="width:7%;" bgcolor="#d6a6c9"><strong>Unit</strong></th>
            <th style="width:9%;" bgcolor="#d6a6c9"><strong>Unit Price</strong></th>
            <th style="width:9%;" bgcolor="#d6a6c9"><strong>Diskon</strong></th>
            <th style="width:10%;" bgcolor="#d6a6c9"><strong>Total Price</strong></th>
            <th style="width:17%;" bgcolor="#d6a6c9"><strong>Description</strong></th>
        </tr>

        <?php if (!empty($purchase_order['items'])): ?>
            <?php
            $total_price = 0;
            foreach ($purchase_order['items'] as $index => $item):
                $total_price += $item['total_price'] ?? 0;
                ?>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td style="text-align:center;padding:10px"><?= $index + 1 ?></td>
                    <td style="text-align:center;padding:10px"><?= $item['item_code'] ?? '-' ?></td>
                    <td style="text-align:center;padding:10px"><?= $item['itemname'] ?? '' ?></td>
                    <td style="text-align:center;padding:10px">
                        <?php
                        $val = !empty($item['alternativeunitid']) ? $item['qtytouom'] : ($item['qtypersatuan'] ?? '');
                        if (is_numeric($val)) {
                            // Hilangkan nol berlebih di belakang desimal
                            $val = rtrim(rtrim(number_format($val, 4, '.', ''), '0'), '.');
                        }
                        echo $val;
                        ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?php
                        $qty = $item['qty'] ?? '';
                        if (is_numeric($qty)) {
                            $qty = rtrim(rtrim(number_format($qty, 4, '.', ''), '0'), '.');
                        }
                        echo $qty;
                        ?>
                    </td>

                    <td style="text-align:center;padding:10px;">
                        <?= !empty($item['alternativeunitname']) ? $item['alternativeunitname'] : ($item['unit_name'] ?? '') ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?= "Rp " . number_format($item['fixed_price'] ?? 0, 2, ',', '.') ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?= "Rp " . number_format($item['discount_value'] ?? 0, 2, ',', '.') ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?= "Rp " . number_format($item['total_price'] ?? 0, 2, ',', '.') ?>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['description'] ?? '' ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="text-align:center;margin:10px 0 10px 0;">
                <td colspan="8" style="text-align:center;padding:10px" bgcolor="#d6a6c9">Ongkir</td>
                <td style="text-align:center;padding:10px">
                    <b><?= "Rp " . number_format($purchase_order['ongkir'], 2, ',', '.') ?></b>
                </td>
                <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
            </tr>
            <tr style="text-align:center;margin:10px 0 10px 0;">
                <td colspan="8" style="text-align:center;padding:10px" bgcolor="#d6a6c9">Biaya Lain-lain</td>
                <td style="text-align:center;padding:10px">
                    <b><?= "Rp " . number_format($purchase_order['other_cost'], 2, ',', '.') ?></b>
                </td>
                <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
            </tr>
            <tr style="text-align:center;margin:10px 0 10px 0;">
                <td colspan="8" style="text-align:center;padding:10px" bgcolor="#d6a6c9">Total</td>
                <td style="text-align:center;padding:10px">
                    <b><?= "Rp " . number_format($total_price + $purchase_order['other_cost'] + $purchase_order['ongkir'], 2, ',', '.') ?></b>
                </td>
                <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">No items available</td>
            </tr>
        <?php endif; ?>

    </table>

    <br><br>

    <table class="small-text">

        <tr bgcolor="#d3d3d3" class="signature-label">
            <th><strong>Comments or Special Instructions:</strong></th>
        </tr>

        <tr class="signature-box">
            <?php if (!empty($purchase_order['notes'])) { ?>
                <td style="padding:10px;"><?= $purchase_order['notes'] ?></td>
            <?php } else { ?>
                <td style="font-style:italic;color:grey;">Tidak ada catatan</td>
            <?php } ?>
        </tr>

    </table>

    <br><br>

    <?php if ($tes=="1") { ?>
            <table class="small-text">
        <tr bgcolor="#d3d3d3">
            <td class="signature-label">Order By</td>
            <td class="signature-label">Knowed By</td>
        </tr>
        <tr>
            <td class="signature-box">
                <br><br>
                <img src="<?= base_url('uploads/ttd/ttd_mas_bowo.jpg') ?>" alt="TTD 1"
                    style="height: 40px; width: 40px;">

                <br>
                <p class="medium-text"></p>
            </td>

            <td class="signature-box">
                <br><br>
                <?php if (!empty($ttd1)): ?>
                    <img src="<?= base_url('uploads/ttd/' . $ttd1) ?>" alt="TTD 1" style="height: 40px; width: 40px;">
                <?php endif; ?>
                <br>
                <p class="medium-text"></p>
            </td>
        </tr>
        <tr>
            <td class="signature-label"><?= $purchase_order['orderer_name'] ?? '' ?></td>
            <td class="signature-label"><?= $purchase_order['approved_by'] ?? 'Dessi Anita' ?></td>
        </tr>
    </table>
    <?php } else { ?>
                <table class="small-text">
        <tr bgcolor="#d3d3d3">
            <td class="signature-label">Order By</td>
            <td class="signature-label">Knowed By</td>
            <td class="signature-label">Approved By</td>
        </tr>
        <tr>
            <td class="signature-box">
                <br><br>
                <img src="<?= base_url('uploads/ttd/ttd_mas_bowo.jpg') ?>" alt="TTD 1"
                    style="height: 40px; width: 40px;">

                <br>
                <p class="medium-text"></p>
            </td>

            <td class="signature-box">
                <br><br>
                <?php if (!empty($ttd1)): ?>
                    <img src="<?= base_url('uploads/ttd/' . $ttd1) ?>" alt="TTD 1" style="height: 40px; width: 40px;">
                <?php endif; ?>
                <br>
                <p class="medium-text"></p>
            </td>

            <td class="signature-box">
                <br><br>
                <?php if (!empty($ttd2)): ?>
                    <img src="<?= base_url('uploads/ttd/' . $ttd2) ?>" alt="TTD 2"
                        style="height: 40px; width: 60px;padding:5px;">
                <?php endif; ?>
                <br>
                <p class="medium-text"></p>
            </td>
        </tr>
        <tr>
            <td class="signature-label"><?= $purchase_order['orderer_name'] ?? '' ?></td>
            <td class="signature-label"><?= $purchase_order['approved_by'] ?? 'Dessi Anita' ?></td>
            <td class="signature-label"><?= $purchase_order['final_approved_by'] ?? 'Sabrina Gouw' ?></td>
        </tr>
    </table>
    <?php } ?>
    

</body>

</html>