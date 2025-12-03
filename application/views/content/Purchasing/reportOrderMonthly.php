<style>
.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 8px;
    font-weight: 600;
    color: #fff;
    font-size: 12px;
}

.status-approved {
    background-color: #007bff; /* biru */
}

.status-paid {
    background-color: #28a745; /* hijau */
}


</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0 bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-0 text-dark font-weight-bold">
                                <i class="fas fa-shopping-cart text-primary mr-2"></i>
                                Laporan Purchase Order
                            </h4>
                            <small class="text-muted">Monitoring dan analisis purchase order</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="input-group input-group-sm" style="width: 280px; margin-right: 10">
                                <select id="companyFilter" class="form-control">
                                    <option value="">Semua Company</option>
                                    <?php foreach ($companies as $company): ?>
                                        <option value="<?= $company['id'] ?>"><?= $company['text'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 280px; margin-right: 10">
                                <select id="statusPurchaseOrder" class="form-control">
                                    <option value="IN (4,7,6,10,2,3)">Approved</option>
                                    <option value="IN (3)">Paid</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm mr-10 gap-10" style="width: 280px;">
                                <input type="month" class="form-control border-left-0 pl-0" id="monthFilter"
                                    value="<?= date('Y-m') ?>">
                                <div class="input-group-append ml-2">
                                    <button class="btn btn-outline-primary px-3" id="btnFilter" type="button">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="btn-group ml-2">
                                <button class="btn btn-sm btn-danger px-3" id="btnExportPdf">
                                    <i class="fas fa-file-pdf mr-1"></i> PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="loading" class="text-center py-5">
                        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="text-muted">Memuat data purchase order...</p>
                    </div>
                    <div id="poContainer" style="display: none;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#companyFilter').select2({
            placeholder: "Pilih Company",
            allowClear: true,
            width: '100%'
        });


        loadData();

        // Event filter
        $('#btnFilter').click(function () {
            loadData();
        });

        $('#btnExportPdf').click(function () {
            const month = $('#monthFilter').val();
            const company = $('#companyFilter').val();
            const status = $('#statusPurchaseOrder').val();

            let url = '<?= site_url('ControllerPurchasing/getOrdersByMonth') ?>?export=pdf&month=' + month;

            if (company) {
                url += '&company=' + company;
            }

            if (status) {
                url += '&status=' + status;
            }

            window.location.href = url;
        });



        // Enter key untuk filter
        $('#monthFilter').keypress(function (e) {
            if (e.which === 13) {
                loadData();
            }
        });

        function loadData() {
            const month = $('#monthFilter').val();
            const companyId = $('#companyFilter').val();
            const status = $('#statusPurchaseOrder').val();

            $('#loading').show();
            $('#poContainer').hide().empty();

            $.ajax({
                url: '<?= site_url('ControllerPurchasing/getOrdersByMonth') ?>',
                type: 'GET',
                data: { month: month, company: companyId, status: status },
                dataType: 'json',
                success: function (response) {
                    $('#loading').hide();
                    if (response.status) {
                        renderPOData(response.data);
                    } else {
                        $('#poContainer').html(`
                            <div class="alert alert-danger alert-modern">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                                    <div>
                                        <h5 class="alert-heading mb-1">Terjadi Kesalahan</h5>
                                        <p class="mb-0">${response.message}</p>
                                    </div>
                                </div>
                            </div>
                        `).show();
                    }
                },
                error: function (xhr, status, error) {
                    $('#loading').hide();
                    $('#poContainer').html(`
                        <div class="alert alert-danger alert-modern">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Koneksi Error</h5>
                                    <p class="mb-0">Gagal memuat data. Silakan coba lagi.</p>
                                </div>
                            </div>
                        </div>
                    `).show();
                }
            });
        }

        function renderPOData(data) {
            if (data.length === 0) {
                $('#poContainer').html(`
                    <div class="alert alert-info alert-modern text-center py-4">
                        <i class="fas fa-info-circle fa-3x mb-3 text-info"></i>
                        <h5 class="text-info">Tidak Ada Data</h5>
                        <p class="text-muted mb-0">Tidak ditemukan purchase order untuk periode yang dipilih.</p>
                    </div>
                `).show();
                return;
            }

            let html = '';
            data.forEach(function (po, index) {
                html += `
                <div class="card mb-4 po-card">
                    <div class="card-header bg-gradient-light">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="icon-circle bg-primary mr-3">
                                        <i class="fas fa-file-invoice text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 font-weight-bold text-dark"> ${po.order_number}</h6>
                                        <div class="text-muted small">
                                            <span class="mr-3"><i class="fas fa-calendar mr-1"></i> Order Date: ${po.orderdate_formatted}</span>
                                            <span class="mr-3"><i class="fas fa-building mr-1"></i>Company : ${po.companyname}</span>
                                            <span class="mr-3"><i class="fas fa-store mr-1"></i>${po.outlet}</span>
                                            <span><i class="fas fa-truck mr-1"></i>${po.vendorname}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-4 text-right">
    <div class="total-badge">
        <span class="status-badge ${po.status == 3 ? 'status-paid' : 'status-approved'}">
            ${po.status == 3 ? "Paid" : "Approved"}
        </span>
    </div>

    <div class="total-badge">
        <span class="total-label">Total</span>
        <span class="total-amount">${formatCurrency(po.total_amount)}</span>
    </div>
</div>


                        </div>
                    </div>
                    
                    <!-- Items Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th width="25%">Nama Item</th>
                                        <th width="10%" class="text-right">Qty Order</th>
                                        <th width="12%" class="text-center">Satuan</th>
                                        <th width="12%" class="text-right">Qty Convert</th>
                                        <th width="12%" class="text-right">Harga</th>
                                        <th width="12%" class="text-right">Total</th>
                                        <th width="12%" class="text-right">Diskon</th>
                                    </tr>
                                </thead>
                                <tbody>
                `;

                // Items data
                if (po.items.length === 0) {
                    html += `
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-2x mb-2"></i>
                                    <p class="mb-0">Tidak ada items</p>
                                </div>
                            </td>
                        </tr>
                    `;
                } else {
                    po.items.forEach(function (item, itemIndex) {
                        html += `
                            <tr>
                                <td class="text-center">
                                    <span class="badge badge-light">${itemIndex + 1}</span>
                                </td>
                                <td>
                                    <div class="font-weight-semibold text-dark">${item.itemname || '-'}</div>
                                    ${item.name ? `<small class="text-muted">UOM : ${item.name}</small>` : ''}
                                </td>
                                <td class="text-right font-weight-semibold">${formatNumber(item.order_quantity)}</td>
                                <td class="text-center">
                                    <span class="badge badge-outline">${item.satuan_order || '-'} </span>
                                </td>
                                <td class="text-right font-weight-semibold">${formatNumber(item.quantity)}  ${item.name}</td>
                                <td class="text-right">${formatCurrency(item.itemprice)}</td>
                                <td class="text-right font-weight-bold text-primary">${formatCurrency(item.totalprice)}</td>
                                <td class="text-right text-danger">${formatCurrency(item.discount)}</td>
                            </tr>
                        `;
                    });
                }

                html += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Summary Footer -->
                    <div class="card-footer bg-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <span class="text-muted">
                                    <i class="fas fa-cube mr-1"></i> ${po.items.length} items
                                </span>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-totals">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Subtotal:</span>
                                        <span class="font-weight-semibold">${formatCurrency(po.total_item_amount)}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Ongkir:</span>
                                        <span class="font-weight-semibold">${formatCurrency(po.ongkir)}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Biaya Lain:</span>
                                        <span class="font-weight-semibold">${formatCurrency(po.other_cost)}</span>
                                    </div>
                                    <div class="d-flex justify-content-between border-top pt-2">
                                        <span class="font-weight-bold text-dark">Total:</span>
                                        <span class="font-weight-bold text-success">${formatCurrency(po.total_amount)}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });

            // Add summary card
            const totalPO = data.length;
            const grandTotal = data.reduce((sum, po) => sum + parseFloat(po.total_amount), 0);

            html += `
                <div class="card summary-card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-6 border-right">
                                <div class="summary-item">
                                    <div class="summary-icon bg-primary">
                                        <i class="fas fa-file-invoice text-white"></i>
                                    </div>
                                    <h3 class="summary-value text-primary">${totalPO}</h3>
                                    <p class="summary-label">Total PO</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-item">
                                    <div class="summary-icon bg-success">
                                        <i class="fas fa-money-bill-wave text-white"></i>
                                    </div>
                                    <h3 class="summary-value text-success">${formatCurrency(grandTotal)}</h3>
                                    <p class="summary-label">Grand Total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            $('#poContainer').html(html).show();
        }

        function formatCurrency(amount) {
            if (!amount) return 'Rp 0';
            return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
        }

        function formatNumber(num) {
            if (!num) return '0';
            return parseFloat(num).toLocaleString('id-ID');
        }
    });
</script>

<style>
    .text-right {
        text-align: right;
    }

    .font-weight-semibold {
        font-weight: 600;
    }

    /* Modern Card Header */
    .card-header.bg-gradient-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
    }

    /* Icon Circle */
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Total Badge */
    .total-badge {
        display: inline-block;
        background: white;
        padding: 8px 16px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .total-label {
        font-size: 0.75rem;
        color: #6c757d;
        margin-right: 8px;
    }

    .total-amount {
        font-weight: bold;
        color: #007bff;
    }

    /* PO Card Styling */
    .po-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .po-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }

    /* Table Styling */
    .po-card .table th {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 12px 8px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .po-card .table td {
        padding: 12px 8px;
        font-size: 0.85rem;
        vertical-align: middle;
        border-color: #f1f3f4;
    }

    /* Badge Styling */
    .badge-outline {
        background: transparent;
        border: 1px solid #dee2e6;
        color: #6c757d;
        font-weight: 500;
    }

    /* Summary Card */
    .summary-card {
        border: none;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .summary-item {
        padding: 20px 0;
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 1.5rem;
    }

    .summary-value {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .summary-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    /* Modern Alerts */
    .alert-modern {
        border: none;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    /* Input Group Styling */
    .input-group-sm .form-control {
        height: calc(1.8125rem + 2px);
        padding: 0.25rem 0.5rem;
    }

    .input-group-text {
        background: white;
        border: 1px solid #ced4da;
    }

    /* Button Styling */
    .btn-group .btn {
        border-radius: 6px;
        margin-left: 5px;
    }

    /* Loading Animation */
    #loading .spinner-border {
        width: 3rem;
        height: 3rem;
    }
</style>