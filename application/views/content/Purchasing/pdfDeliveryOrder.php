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
        .header-title {
            font-size: 18pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background-color: #754267; /* hanya 6 digit */
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
            height: 60px;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            padding:30px;
        }

        .signature-label {
            text-align: center;
            font-size: 10pt;
            padding:30px;
        }

        td.no-border-top, th.no-border-top {
            border-top: none !important;
        }

        /* Hilangkan border bawah */
        td.no-border-bottom, th.no-border-bottom {
            border-bottom: none !important;
        }

        /* Hilangkan atas & bawah sekaligus */
        td.no-border-vertical, th.no-border-vertical {
            border-top: none !important;
            border-bottom: none !important;
        }

        p {
            margin: 2px 0;
        }
        .p-5   { 
            padding: 5px !important; 
        }
        .p-10  { 
            padding: 10px !important; 
        }
        .p-20  { 
            padding: 20px !important; 
        }
        .p-30  { 
            padding: 30px !important; 
        }
        .pv-5  { 
            padding-top: 5px !important; 
            padding-bottom: 5px !important;
        }
        .ph-10 { 
            padding-left: 10px !important; 
            padding-right: 10px !important; 
        }

        .small-text { 
            font-size:8px; 
        }

        .medium-text { 
            font-size:10px; 
        }
    </style>
</head>

<body>

    <div class="header-title" style="display: flex; align-items: center; gap: 8px;">
    <span>
        <img src="https://sys.eudoraclinic.com:84/app/uploads/logo/logo_eudora.jpg" 
             alt="" style="height: 40px;">
    </span>
    <span style="font-weight: bold; font-size: 18px;">PURCHASE ORDER FORM</span>
</div>
    <br>
    

    <div class="row">
        <div class="col-md-12 medium-text">
            <table class="no-border">
                <tr>
                    <td><?= $purchase_order['orderer_name'] ?? '-' ?></td>
                    <td></td>
                    <td>
                        <table class="no-border">
                            <tr>
                                <td>PO No.</td>
                                <td>: <?= $purchase_order['order_number'] ?? '-' ?></td>
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
                                <td>:  <?= strtr(date('j F Y', strtotime($purchase_order['orderdate'])), [
                                    'January'=>'Januari','February'=>'Februari','March'=>'Maret','April'=>'April',
                                    'May'=>'Mei','June'=>'Juni','July'=>'Juli','August'=>'Agustus',
                                    'September'=>'September','October'=>'Oktober','November'=>'November','December'=>'Desember'
                                    ]) ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><?= $purchase_order['company_address'] ?? '-' ?>, <?= $purchase_order['city_name']?>, <?= $purchase_order['province_name']?></td>
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
    </div>

    <table class="no-border small-text">
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
                                    <td>: <?= $purchase_order['supplier_name']?></td>
                                </tr>
                                <tr>
                                    <td>Sales Name</td>
                                    <td>: <?= $purchase_order['sales_name']?></td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td>: </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>: <?= $purchase_order['sales_address']?></td>
                                </tr>
                                <tr>
                                    <td>Type</td>
                                    <td>: </td>
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
                                    <td>: <?= $purchase_order['companyname']?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>: <?= $purchase_order['company_address']?></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>: <?= $purchase_order['company_phone']?></td>
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
    <table class="small-text">
        
            <tr style="text-align:center;">
                <th style="width:5%;" bgcolor="#d6a6c9"><strong>No</strong></th>
                <th bgcolor="#d6a6c9"><strong>Code</strong></th>
                <th style="width:25%" bgcolor="#d6a6c9"><strong>Description</strong></th>
                <th style="width:5%;" bgcolor="#d6a6c9"><strong>Qty Per Pax</strong> </th>
                <th style="width:5%;" bgcolor="#d6a6c9"><strong>Qty</strong></th>
                <th bgcolor="#d6a6c9"><strong>Unit</strong></th>
                <th style="width:5%;" bgcolor="#d6a6c9"><strong>Unit Price</strong></th>
                <th style="width:5%;" bgcolor="#d6a6c9"><strong>Total Price</strong></th>
                <th style="width:28%;" bgcolor="#d6a6c9"><strong>Specification</strong></th>
            </tr>
    
            <?php if(!empty($purchase_order['items'])): ?>
                <?php foreach($purchase_order['items'] as $index => $item): ?>
                    <tr style="text-align:center;margin:10px 0 10px 0;">
                        <td style="text-align:center;padding:10px"><?= $index + 1 ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['item_code'] ?? '-' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['itemname'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['qtypersatuan'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['qty'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['unit_name'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['qty'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['unit_name'] ?? '' ?></td>
                        <td style="text-align:center;padding:10px"><?= $item['specification'] ?? '' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No items available</td>
                </tr>
            <?php endif; ?>
  
    </table>

    <br><br>

    <table>
      
            <tr bgcolor="#d3d3d3" class="signature-label">
                <th><strong>Comments or Special Instructions:</strong></th>
            </tr>
     
           <tr class="signature-box">
                <?php if(!empty($purchase_order['notes'])){ ?>
                    <td><?= $purchase_order['notes'] ?></td>
                <?php } else { ?>
                    <td style="font-style:italic;color:grey;">Tidak ada catatan</td>
                <?php } ?>
            </tr>

    </table>

    <br><br>

    <table>
        <tr bgcolor="#d3d3d3">
            <td class="signature-label">Order By</td>
            <td class="signature-label">Knowed By</td>
            <td class="signature-label">Approved By</td>
        </tr>
        <tr>
            <td class="signature-box"></td>
            <td class="signature-box"></td>
            <td class="signature-box"></td>
        </tr>
        <tr>
            <td class="signature-label"><?= $purchase_order['orderer_name'] ?? '' ?></td>
            <td class="signature-label"><?= $purchase_order['approved_by'] ?? 'Purchasing' ?></td>
            <td class="signature-label"><?= $purchase_order['final_approved_by'] ?? '' ?></td>
        </tr>
        <!-- <tr rowspan="3" bgcolor="#d3d3d3">
            <td colspan="3" class="signature-label">Vendor</td>
        </tr>
        <tr rowspan="3">
            <td colspan="3" class="signature-box"></td>
        </tr>
        <tr rowspan="3">
            <td colspan="3" class="signature-label"><?= $purchase_order['requester_name'] ?? '' ?></td>
        </tr> -->
    </table>

</body>
</html>
