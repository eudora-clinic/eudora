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

    <table class="no-border" style="text-align:left;font-size:14px;">
        <tr style="text-align:left;">
            <td width="50%"><strong>PT PRO AESTHETIC ASIA</strong></td>
            <td width="50%" style="text-align:right"><strong>INVOICE</strong></td>
        </tr>
        <tr style="text-align:left;">
            <td width="50%"><strong></strong></td>
            <td width="50%" style="text-align:right;font-size:10px;">PTPAA-<?= $purchase_order['po_id']?>/<?= date('d-m-Y', strtotime($date))?></td>
        </tr>                
    </table>

    <table class="no-border" style="text-align:left;padding:1px;">
        <tr style="text-align:left;">
            <td width="25%"><strong>FROM</strong></td>
            <td width="25%"></td>
            <td width="30%"><strong>TO</strong></td>
        </tr>
        <tr>
            <td width="25%">PT Pro Aesthetic Asia</td>
            <td width="25%"></td>
            <td width="30%"><?= trim($purchase_order['companyname'] ?? '') ?></td>
        </tr>
        <tr>
            <td width="25%"></td>
            <td width="25%"></td>
            <td width="30%"><?= trim($purchase_order['company_phone'] ?? '') ?></td>
        </tr>
        <tr>
            <td width="25%"></td>
            <td width="25%"></td>
            <td width="30%"><?= trim($purchase_order['company_address'] ?? '') ?></td>
        </tr>
    </table>

    <br><br><br>
    <table class="small-text" style="text-align:center;padding:2px;">
        
            <tr style="text-align:center;padding:2px;">
                <th style="width:3%;" bgcolor="#f8c6d8"><strong>No</strong></th>
                <th style="width:25%" bgcolor="#f8c6d8"><strong>Item</strong></th>
                
                <th style="width:5%;" bgcolor="#f8c6d8"><strong>Qty</strong></th>
                <th style="width:8%;" bgcolor="#f8c6d8"><strong>Qty Per Pax</strong> </th>
                <th style="width:10%;" bgcolor="#f8c6d8"><strong>Unit</strong></th>
                <th style="width:15%;" bgcolor="#f8c6d8"><strong>Unit Price</strong></th>
                <th style="width:15%;" bgcolor="#f8c6d8"><strong>Total Price</strong></th>
                <th style="width:21%;" bgcolor="#f8c6d8"><strong>Description</strong></th>
            </tr>
    
            <?php if(!empty($purchase_order['items'])): ?>
            <?php 
                $total_price = 0;
                foreach($purchase_order['items'] as $index => $item): 
                    $total_price += $item['total_price'] ?? 0; 
                ?>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td style="text-align:center;padding:10px"><?= $index + 1 ?></td>
                    <td style="text-align:center;padding:10px"><?= $item['itemname'] ?? '' ?></td>
                    <td style="text-align:center;padding:10px">
                        <?= !empty($item['alternativeunitid']) ? $item['qtytouom'] : ($item['qtypersatuan'] ?? '') ?>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['qty'] ?? '' ?></td>
                    <td style="text-align:center;padding:10px;">
                        <?= !empty($item['alternativeunitname']) ? $item['alternativeunitname'] : ($item['unit_name'] ?? '') ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?= "Rp " . number_format($item['fixed_price'] ?? 0, 2, ',', '.') ?>
                    </td>
                    <td style="text-align:center;padding:10px">
                        <?= "Rp " . number_format($item['total_price'] ?? 0, 2, ',', '.') ?>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['description'] ?? '' ?></td>
                </tr>
            <?php endforeach; ?>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td colspan="6" style="text-align:center;padding:10px">Total Item</td>
                    <td style="text-align:center;padding:10px">
                        <b><?= "Rp " . number_format($total_price, 2, ',', '.') ?></b>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
                </tr>
                <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align:center;">No items available</td>
                </tr>
            <?php endif; ?>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td colspan="6" style="text-align:center;padding:10px">Ongkir</td>
                    <td style="text-align:center;padding:10px">
                        <b><?= "Rp " . number_format($purchase_order['ongkir'], 2, ',', '.') ?></b>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
                </tr>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td colspan="6" style="text-align:center;padding:10px" >Other Cost</td>
                    <td style="text-align:center;padding:10px">
                        <b><?= "Rp " . number_format($purchase_order['other_cost'], 2, ',', '.') ?></b>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
                </tr>
                <?php $grand_total = $total_price + $purchase_order['other_cost'] + $purchase_order['ongkir'] ?>
                <tr style="text-align:center;margin:10px 0 10px 0;">
                    <td colspan="6" style="text-align:center;padding:10px" bgcolor="#f8c6d8">TOTAL</td>
                    <td style="text-align:center;padding:10px">
                        <b><?= "Rp " . number_format($grand_total, 2, ',', '.') ?></b>
                    </td>
                    <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
                </tr>
                
    </table>
</body>
</html>