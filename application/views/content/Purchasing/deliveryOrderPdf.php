<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Delivery Order</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
        }

        .header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .no-border td {
            border: none;
        }

        .notes {
            border: 1px solid #000;
            padding: 5px;
            margin-top: 10px;
        }

        .sign-table td {
            height: 50px;
            text-align: center;
        }

        .sign-table th {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="header-title" style="display: flex; align-items: center; gap: 8px;">
            <span>
                <img src="https://sys.eudoraclinic.com:84/app/uploads/logo/logo_eudora.jpg" alt=""
                    style="height: 40px;">
            </span>
            <span style="font-weight: bold; font-size: 18px;">DELIVERY ORDER FORM</span>
        </div>

    </div>

    <table class="no-border" style="margin-bottom:15px;text-align:left;">
        <tr>
            <td bgcolor="#d6a6c9"><b>DELIVER TO</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td><?= $purchase_order['companyname'] ?></td>
            <td><b>DO</b> : <?= $purchase_order['delivery_number'] ?? '' ?></td>
        </tr>
        <tr>
            <td>Outlet/Department</td>
            <td><?= $purchase_order['department_name'] ?? '' ?></td>
            <td><b>PO</b> : <?= $purchase_order['order_number'] ?? '' ?></td>
        </tr>
        <tr>
            <td>To</td>
            <td><?= $purchase_order['deliver_to'] ?? '' ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Address</td>
            <td> <?= $purchase_order['deliver_address'] ?? '' ?></td>
            <td></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><?= $purchase_order['deliver_phone'] ?? '' ?></td>
            <td></td>
        </tr>
        <tr>
            <td bgcolor="#d6a6c9"><b>VENDOR</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Company Name</td>
            <td><?= $purchase_order['supplier_name'] ?? '' ?></td>
            <td></td>
        </tr>

    </table>

    <table>
        <thead>
            <tr bgcolor="#d6a6c9">
                <th>No</th>
                <th>Kode Barang</th>
                <th>Item Barang</th>
                <th>Qty Order</th>
                <th>Qty Return</th>
                <th>Unit</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($purchase_order['items'] as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $item['item_code'] ?></td>
                    <td><?= $item['itemname'] ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td><?= $item['qty_return'] ?? $item['qty'] ?></td>
                    <?php if ($item['alternativeunitid'] != null) { ?>
                        <td><?= $item['alternativeunitname'] ?></td>
                    <?php } else { ?>
                        <td><?= $item['unit_name'] ?></td>
                    <?php } ?>
                    <td><?= $item['description'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="notes">
        <b>Notes:</b><br>
        <?= $purchase_order['notes'] ?? '' ?>
    </div>

    <br><br>

     <?php if ($purchase_order['status']=="2") { ?>
    <table class="sign-table">
        <tr bgcolor="#d6a6c9">
            <th bgcolor="#d6a6c9">Prepared By</th>
            <th bgcolor="#d6a6c9">Received By</th>
            <th bgcolor="#d6a6c9">Knowed By</th>
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
                <img src="<?= base_url('uploads/ttd/ttd_mas_bowo.jpg') ?>" alt="TTD 1"
                    style="height: 40px; width: 40px;">
                <br>
                <p class="medium-text"></p>
            </td>
            <td class="signature-box">
                <br><br>
                <img src="<?= base_url('uploads/ttd/ttd_mas_bowo.jpg') ?>" alt="TTD 1"
                    style="height: 40px; width: 40px;">
                <br>
                <p class="medium-text"></p>
            </td>
        </tr>
        <tr>
            <td><?= $purchase_order['orderer_name'] ?? '' ?></td>
            <td><?= $purchase_order['orderer_name'] ?? '' ?></td>
            <td><?= $purchase_order['orderer_name'] ?? '' ?></td>
        </tr>
    </table>
    <?php } ?>

</body>

</html>