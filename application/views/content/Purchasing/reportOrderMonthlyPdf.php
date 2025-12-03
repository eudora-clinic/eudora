<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #333;
            background: #fff;
        }

        /* Header Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid #007bff;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .report-subtitle {
            font-size: 11px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .report-period {
            font-size: 10px;
            color: #007bff;
            font-weight: 600;
        }

        /* PO Card Styling */
        .po-card {
            margin-bottom: 15px;
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            background: #fff;
            page-break-inside: avoid;
        }

        .po-header {
            background: #f8f9fa;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            border-radius: 6px 6px 0 0;
        }

        .po-number {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 3px;
        }

        .po-meta {
            font-size: 9px;
            color: #6c757d;
        }

        .po-meta span {
            margin-right: 12px;
        }

        .po-total {
            text-align: right;
            font-weight: bold;
            color: #007bff;
        }

        /* Table Styling */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 8px;
        }

        .items-table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            font-size: 8px;
            padding: 6px 4px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 5px 4px;
            font-size: 8px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: top;
            text-align: left;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-center {
            text-align: center;
        }

        /* Item Details */
        .item-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 8px;
        }

        .item-unit {
            color: #6c757d;
            font-size: 7px;
        }

        /* Summary Footer */
        .po-footer {
            background: #f8f9fc;
            padding: 10px 15px;
            border-top: 1px solid #e3e6f0;
            border-radius: 0 0 6px 6px;
        }

        .summary-totals {
            width: 100%;
            max-width: 200px;
            margin-left: auto;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            padding: 1px 0;
            font-size: 8px;
        }

        .summary-label {
            color: #6c757d;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .summary-total {
            border-top: 1px solid #dee2e6;
            padding-top: 4px;
            margin-top: 4px;
            font-weight: bold;
            color: #28a745;
        }

        .summary-total .summary-value {
            font-size: 9px;
            color: #28a745;
        }

        /* No Items State */
        .no-items {
            text-align: center;
            padding: 20px 15px;
            color: #6c757d;
            font-style: italic;
            font-size: 9px;
        }

        /* Grand Summary */
        .grand-summary {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-align: center;
        }

        .summary-stats {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .stat-label {
            font-size: 9px;
            color: #6c757d;
        }

        /* Page Break Handling */
        .page-break {
            page-break-after: always;
        }

        /* Utility Classes */
        .text-primary {
            color: #007bff;
        }

        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d;
        }

        .font-weight-bold {
            font-weight: bold;
        }

        .font-weight-semibold {
            font-weight: 600;
        }

        .items-table td.text-center {
            vertical-align: middle;
            /* pastikan badge berada di tengah */
        }

        .badge {
            display: inline-block;
            min-width: 18px;
            /* agar kotak badge cukup besar */
            height: 18px;
            line-height: 18px;
            /* vertikal align teks */
            text-align: center;
            font-size: 7px;
            border-radius: 50%;
        }

        /* Row Layout untuk Header PO */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -8px;
        }

        .col-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 0 8px;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 0 8px;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 8px;
        }

        /* Summary Section */
        .total-summary {
            margin-top: 15px;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 6px;
            color: white;
        }

        .total-summary .row {
            margin: 0 -10px;
        }

        .total-summary .col-6 {
            padding: 0 10px;
        }

        .summary-box {
            text-align: center;
            padding: 8px;
        }

        .summary-box .value {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .summary-box .label {
            font-size: 9px;
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <!-- Header Laporan -->
    <div class="report-header">
        <div class="report-title">LAPORAN PURCHASE ORDER</div>
        <div class="report-subtitle">Monitoring dan Analisis Purchase Order</div>
        <div class="report-period">Periode: <?= date('F Y', strtotime($month . '-01')) ?></div>
    </div>

    <?php
    // Hitung total keseluruhan
    $total_po = count($data);
    $total_amount_all = array_sum(array_column($data, 'total_amount'));
    $total_items_all = array_sum(array_map(function ($po) {
        return count($po['items']);
    }, $data));
    ?>

    <?php if (empty($data)): ?>
        <div class="no-items">
            Tidak ada data purchase order untuk periode ini
        </div>
    <?php else: ?>
        <!-- Summary Info -->
        <div style="margin-bottom: 15px; padding: 8px; background: #e9ecef; border-radius: 4px; font-size: 9px;">
            <strong>Summary:</strong>
            <?= $total_po ?> PO |
            <?= $total_items_all ?> Items |
            Total: Rp <?= number_format($total_amount_all, 0, ',', '.') ?>
        </div>

        <?php foreach ($data as $index => $po): ?>
            <!-- PO Card -->
            <div class="po-card">
                <!-- PO Header -->
                <div class="po-header">
                    <div class="row">
                        <div class="col-8">
                            <div class="po-number">
                                <?= $po['order_number'] ?>
                            </div>
                            <div class="po-meta">
                                <span>Order date: <?= $po['orderdate_formatted'] ?></span>
                                <span>Company name :<?= $po['companyname'] ?></span>
                                <span>Outlet :<?= $po['outlet'] ?></span>
                                <span>Vendor :<?= $po['vendorname'] ?></span>   

                                 <span>Status :<?= $po['status'] == 3 ? "Paid" : "Approved" ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th width="4%" class="text-center">#</th>
                            <th width="23%" class="text-center">Nama Item</th>
                            <th width="9%" class="text-center">Qty Order</th>
                            <th width="10%" class="text-center">Satuan</th>
                            <th width="10%" class="text-center">Qty Convert</th>
                            <th width="12%" class="text-center">Harga</th>
                            <th width="12%" class="text-center">Total</th>
                            <th width="10%" class="text-center">Diskon</th>
                            <th width="10%" class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($po['items'])): ?>
                            <tr>
                                <td colspan="9" class="no-items">
                                    Tidak ada items
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $subtotal_po = 0;
                            foreach ($po['items'] as $itemIndex => $item):
                                $item_subtotal = ($item['totalprice'] ?? 0) - ($item['discount'] ?? 0);
                                $subtotal_po += $item_subtotal;
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge"><?= $itemIndex + 1 ?></span>
                                    </td>
                                    <td class="text-center">
                                        <div class="item-name"><?= htmlspecialchars($item['itemname'] ?? '-') ?></div>
                                    </td>

                                    <td class="text-center font-weight-semibold">
                                        <?= number_format($item['order_quantity'] ?? 0, 0) ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge"><?= htmlspecialchars($item['satuan_order'] ?? '-') ?></span>
                                    </td>
                                    <td class="text-center font-weight-semibold">
                                        <?= number_format($item['quantity'] ?? 0, 0) ?>                 <?= htmlspecialchars($item['name'] ?? '-') ?>
                                    </td>
                                    <td class="text-center">
                                        Rp <?= number_format($item['itemprice'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center font-weight-bold">
                                        Rp <?= number_format($item['totalprice'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center text-danger">
                                        Rp <?= number_format($item['discount'] ?? 0, 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center font-weight-bold text-success">
                                        Rp <?= number_format($item_subtotal, 0, ',', '.') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- PO Footer -->
                <div class="po-footer">
                    <div class="row">
                        <div class="col-6">
                            <div class="summary-totals">
                                <div class="summary-row">
                                    <span class="summary-label">Subtotal Items:</span>
                                    <span class="summary-value">Rp
                                        <?= number_format($po['total_item_amount'], 0, ',', '.') ?></span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Ongkir:</span>
                                    <span class="summary-value">Rp <?= number_format($po['ongkir'], 0, ',', '.') ?></span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-label">Biaya Lain:</span>
                                    <span class="summary-value">Rp <?= number_format($po['other_cost'], 0, ',', '.') ?></span>
                                </div>
                                <div class="summary-row summary-total">
                                    <span class="summary-label">Total PO:</span>
                                    <span class="summary-value">Rp <?= number_format($po['total_amount'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Grand Summary -->
        <div class="total-summary">
            <div class="row">
                <div class="col-6">
                    <div class="summary-box">
                        <div class="value"><?= $total_po ?></div>
                        <div class="label">TOTAL PURCHASE ORDER</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="summary-box">
                        <div class="value">Rp <?= number_format($total_amount_all, 0, ',', '.') ?></div>
                        <div class="label">GRAND TOTAL</div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div
        style="margin-top: 15px; padding-top: 8px; border-top: 1px solid #dee2e6; text-align: center; color: #6c757d; font-size: 8px;">
        <div>Dicetak pada: <?= date('d/m/Y H:i:s') ?> | Halaman: <span class="page-number"></span></div>
        <div>Laporan Purchase Order - Sistem Purchasing</div>
    </div>
</body>

</html>