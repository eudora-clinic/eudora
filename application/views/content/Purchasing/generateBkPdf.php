<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: helvetica, sans-serif; font-size: 8px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #000; padding: 4px; }
        .no-border td { border: none; }
    </style>
</head>
<body>
    <h3 style="text-align:left;"><?= $purchase_order['companyname']?><br>BUKTI PENGELUARAN KAS</h3>
    <p style="text-align:right;"><?= $purchase_order['city_name']?>, , <?= date('d-m-Y', strtotime($purchase_order['orderdate']))?><br>Posting No.: <?= $no_bk?></p>

    <table class="no-border" style="text-align:left;">
        <tr style="text-align:left;">
            <td width="25%">DIBAYAR KEPADA</td>
            <td width="25%"><?= $purchase_order['supplier_name']?></td>
            <td width="25%">NO WHATSAPP/TELEPON</td>
            <td width="25%"><?= $purchase_order['supplier_phone']?></td>
        </tr>
        <tr>
            <td width="25%">UANG SEJUMLAH</td>
            <td width="25%">Rp <?= number_format($subtotal,0,',','.') ?></td>
            <td width="25%">TERBILANG</td>
            <td width="25%"><b><?= strtoupper($this->numbertowords->convert_number($subtotal)) ?> RUPIAH</b></td>
        </tr>    
        <tr>
            <?php if (($purchase_order['supplierid'] ?? null) == 999): ?>
                <td>E-COMMERCE (VA)</td>
                <td><?= $purchase_order['ecommerce_name'] ?? '' ?> (<?= $purchase_order['va_number'] ?? '' ?>)</td>
                <!-- <td>NAMA PEMILIK BILLING</td>
                <td><?= $purchase_order['supplier_name'] ?? '' ?></td> -->
            <?php else: ?>
                <td>BANK (No.)</td>
                <td><?= $purchase_order['supplier_bank'] ?? '' ?> (<?= $purchase_order['supplier_account'] ?? '' ?>)</td>
                <td>NAMA PEMILIK BILLING</td>
                <td><?= $purchase_order['supplier_name'] ?? '' ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td>UNTUK PEMBAYARAN DIVISI</td>
            <td><?= $purchase_order['companycode']?></td>
            <td>UNTUK</td>
            <td>Pembelian Barang</td>
        </tr>
    </table>

    <br>
    <table style="text-align: center;margin-top:20px;">
        <tr>
            <th width="25%">NO. ACC</th>
            <th width="25%">ACCOUNT DESCRIPTION</th>
            <th width="25%">DEBET</th>
            <th width="25%">KREDIT</th>
        </tr>
        <tr>
            <td></td>
            <td>ITEM</td>
            <td>Rp <?= number_format($grand_total,0,',','.') ?></td>
            <td></td>
        </tr>

        <tr>
            <td></td>
            <td>Biaya Lain-Lain</td>
            <td>Rp <?= number_format($purchase_order['other_cost'],0,',','.') ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Ongkir</td>
            <td>Rp <?= number_format($purchase_order['ongkir'],0,',','.') ?></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">TOTAL</td>
            <td>Rp <?= number_format($subtotal,0,',','.') ?></td>
            <td></td>
        </tr>
    </table>

    <br><br>
    <hr>
    <table style="text-align:center;margin-top:20px;">
        <tr>
            <th>DIAJUKAN OLEH</th>
            <th>DIPERIKSA OLEH</th>
            <th>DISETUJUI OLEH</th>
            <th>DIPROSES OLEH</th>
            <th>DITERIMA OLEH</th>
        </tr>
        <tr style="height:200px;">
            <td>
                <br><br>
                <img src="<?= base_url('uploads/ttd/ttd_mas_bowo.jpg') ?>" alt="TTD 1" style="height: 40px; width: 40px;">
                <br>
            </td>
            <td>
                <br><br>
                <?php if (!empty($ttd1)): ?>
                    <img src="<?= base_url('uploads/ttd/' . $ttd1) ?>" alt="TTD 1"
                         style="height: 40px; width: 40px;">
                <?php endif; ?>
                <br>
            </td>
            <?php if ($purchase_order['companyid']!=15): ?>
            <td>
                <?php if (!empty($ttd2)): ?>
                <img src="<?= base_url('uploads/ttd/' . $ttd2) ?>" alt="TTD 2" style="height: 40px; width: 60px;padding:5px;">
                <?php endif; ?>
            </td>
            <?php endif; ?>
            <?php if ($purchase_order['companyid']==15): ?>
            <td></td>
            <?php endif; ?>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>(<?= $purchase_order['orderer_name']?>)<br><br>PIC DIVISI</td>
            <td>(Dessi Anita)<br><br></td>
            <?php if ($purchase_order['companyid']!=15): ?>
            <td>
                (SABRINA GOUW)<br><br>CFO
            </td>
            <?php endif; ?>
            <?php if ($purchase_order['companyid']==15): ?>
            <td>
                (SOK KIAU)<br><br>FINANCE
            </td>
            <?php endif; ?>
            <td>(EDY)<br><br>GENERAL CASHIER</td>
            <td>TTD & NAMA JELAS</td>
        </tr>
    </table>
</body>
</html>