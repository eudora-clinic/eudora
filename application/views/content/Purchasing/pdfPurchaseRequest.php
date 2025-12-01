<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Purchase Requisition Form</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 12pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            font-size: 12pt;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;

        }

        table th {
            width: 100%;
            background-color: #754267ff;
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

        p {
            margin: 2px 0;
        }
    </style>
</head>

<body>

    <div class="header-title"><span>
        <img src="https://sys.eudoraclinic.com:84/app/uploads/logo/logo_eudora.jpg" 
             alt="" style="height: 40px;">
    </span>PURCHASE REQUISITION FORM</div>
    <br>

    <!-- Info Section tanpa garis -->
    <table class="no-border" style="font-size:11pt;margin:0 0 40px 0;">
        <tr>
            <td><strong>To</strong> </td>
            <td>: <?= $purchase_request['to'] ?? 'Warehouse / Purchasing' ?></td>
            <td><strong>Date</strong> </td>
            <td>: <?= date('j F Y', strtotime($purchase_request['requestdate'])) ?? '' ?></td>
        </tr>
        <tr>
            <td><strong>From</strong> </td>
            <td>: <?= $purchase_request['from'] ?? '-' ?></td>
            <td><strong>Memo#</strong> </td>
            <td>: <?= $purchase_request['memo_number'] ?? '-' ?></td>
        </tr>
        <tr bgcolor="#d6a6c9">
            <td colspan="2"><strong>SUBJECT</strong></td>
            <td colspan="2"><strong>REQUEST FOR</strong></td>
        </tr>
        <tr>
            <td><strong>Description</strong> </td>
            <td>: <?= $purchase_request['description'] ?? '-' ?></td>
            <td><strong>Company</strong> </td>
            <td style="font-size:10pt;">: <?= $purchase_request['company_name'] ?? '-' ?></td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> </td>
            <td>: <?= $purchase_request['requester_phone'] ?? '-' ?></td>
            <td><strong>Name:</strong> </td>
            <td>: <?= $purchase_request['requester_name'] ?? '-' ?></td>
        </tr>
        <tr>
            <td><strong>Department:</strong> </td>
            <td>: <?= $purchase_request['department'] ?? '-' ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <br><br>

    <!-- Items Table -->
    <table>
        
            <tr style="text-align:center">
                <th bgcolor="#d6a6c9" style="width:5%;"><strong>No</strong></th>
                <th bgcolor="#d6a6c9"><strong>Code</strong></th>
                <th bgcolor="#d6a6c9" style="width:21%;"><strong>Description</strong></th>
                <th bgcolor="#d6a6c9"><strong>Qty Per Pax</strong> </th>
                <th bgcolor="#d6a6c9"><strong>Qty</strong></th>
                <th bgcolor="#d6a6c9"><strong>Unit</strong></th>
                <th bgcolor="#d6a6c9"><strong>Specification</strong></th>
            </tr>
    
            <?php if(!empty($purchase_request['items'])): ?>
                <?php foreach($purchase_request['items'] as $index => $item): ?>
                    <tr style="font-size:10px;">
                        <td style="width:5%;"><?= $index + 1 ?></td>
                        <td><?= $item['item_code'] ?? '-' ?></td>
                        <td style="width:21%;"><?= $item['itemname'] ?? '' ?></td>
                        <td><?= $item['qtypersatuan'] ?? '' ?></td>
                        <td><?= $item['qty'] ?? '' ?></td>
                        <td><?= $item['unit_name'] ?? '' ?></td>
                        <td><?= $item['specification'] ?? '' ?></td>
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
                <td><?= $purchase_request['notes'] ?? '' ?> </td>
            </tr>

    </table>

    <br><br>

    <table>
        <tr bgcolor="#d3d3d3">
            <td class="signature-label">Request By</td>
            <td class="signature-label">Knowed By</td>
            <td class="signature-label">Approved By</td>
        </tr>
        <tr>
            <td class="signature-box"></td>
            <td class="signature-box"></td>
            <td class="signature-box"></td>
        </tr>
        <tr>
            <td class="signature-label"><?= $purchase_request['requester_name'] ?? '' ?></td>
            <td class="signature-label"><?= $purchase_request['approved_by'] ?? 'Purchasing' ?></td>
            <td class="signature-label"><?= $purchase_request['final_approved_by'] ?? '' ?></td>
        </tr>
    </table>

</body>
</html>
