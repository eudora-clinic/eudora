<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Detail Purchase Order' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.bootstrap.min.css') ?>">

    <style>
        .mycontaine {
            font-size: 13px !important;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-top: 15px;
            background: #fff;
        }

        .card-header {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            background: #f8f8f8;
        }

        .card-body {
            padding: 15px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: 1px solid #ccc;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="mycontaine">
        <!-- Card Detail Header -->
        <div class="card" id="poDetailsCard">
            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                style="font-weight: bold; color: #666;">
                Detail Purchase Order
            </h3>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th width="25%">PO Number</th>
                            <td id="po_order_number">-</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td id="po_orderdate">-</td>
                        </tr>
                        <tr>
                            <th>Purchase Request</th>
                            <td id="po_requestnumber">-</td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <td id="po_company">-</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td id="po_department">-</td>
                        </tr>
                        <tr>
                            <th>Warehouse</th>
                            <td id="po_warehouse">-</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td id="po_supplier">-</td>
                        </tr>
                        <tr>
                            <th>Sales</th>
                            <td id="po_sales">-</td>
                        </tr>
                        <tr>
                            <th>Order By</th>
                            <td id="po_orderer">-</td>
                        </tr>
                        <tr>
                            <th>Requester</th>
                            <td id="po_requester">-</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td id="po_notes">-</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Detail Items -->

        <div class="card">
            <div class="card-header">Purchase Order Items</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tbl-po-items">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Qty to UOM</th>

                                <th>Unit Price</th>
                                <th>Diskon</th>
                                <th>Total Price</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card p-3" id="uploadDocumentsSection" style="display:none;">
            <div class="panel panel-default">
                <div class="panel-heading text-center">Upload Documents</div>
                <div class="panel-body">
                    <form action="<?= site_url('ControllerPurchasing/uploadDocumentsPurchaseOrder') ?>" method="post"
                        enctype="multipart/form-data">
                        <input type="hidden" id="purchaseorderid" name="purchaseorderid"
                            value="<?= isset($id) ? $id : '' ?>">

                        <div class="row">
                            <div class="col-md-6">
                                <label>Vendor Invoice (max 3 files)</label>
                                <input type="file" name="vendor_invoice[]" class="form-control" multiple required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Upload Documents</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ongkirModal" tabindex="-1" role="dialog" aria-labelledby="ongkirModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Ongkos Kirim</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="ongkir">Masukkan Ongkos Kirim (opsional)</label>
                        <input type="number" id="ongkir" name="ongkir" class="form-control" placeholder="Contoh: 50000">
                        <small class="text-muted">Biarkan kosong jika tidak ada ongkos kirim</small>
                    </div>

                    <div class="modal-body">
                        <label for="ongkir">Biaya Lain-Lain (opsional)</label>
                        <input type="number" id="other_cost" name="other_cost" class="form-control"
                            placeholder="Contoh: 50000">
                        <small class="text-muted">Biarkan kosong jika tidak ada biaya lain-lain</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmUploadBtn">Lanjut Upload</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editPriceModal" tabindex="-1" role="dialog" aria-labelledby="editPriceLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <form id="editPriceForm">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editPriceLabel">Edit Harga & Diskon</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" id="poi_id" name="poi_id">

                            <div class="form-group">
                                <label>Nama Item</label>
                                <input type="text" id="itemname" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity" class="form-control" readonly>
                            </div>

                            <div class="form-group">
                                <label>Harga per Quantity</label>
                                <input type="text" id="fixed_price" name="fixed_price"
                                    class="form-control rupiah-input">
                            </div>

                            <div class="form-group mb-3" style="position: relative; overflow: visible;">
                                <label for="discount_type"
                                    style="display: block; position: relative; top: 0; left: 0; z-index: 1; background: white; padding-right: 5px;">
                                    Jenis Diskon
                                </label>
                                <select id="discount_type" name="discount_type" class="form-control"
                                    style="position: relative; z-index: 0;">
                                    <option value="">Tidak Ada</option>
                                    <option value="persen">Persen (%)</option>
                                    <option value="nominal">Nominal (Rp)</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Nilai Diskon</label>
                                <input type="text" id="discount_value" name="discount_value"
                                    class="form-control rupiah-input">
                            </div>

                            <div class="form-group">
                                <label>Total Harga Setelah Diskon</label>
                                <input type="text" id="total_price" class="form-control rupiah-input" readonly>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let selectedPO = null;

            function showOngkirModal(po_id, ongkir_existing = null, other_cost_existing = null) {
                selectedPO = po_id;

                // Cek apakah ongkir atau other_cost sudah ada
                if ((ongkir_existing && ongkir_existing > 0) || (other_cost_existing && other_cost_existing > 0)) {
                    // Langsung buka PDF tanpa modal
                    const url = `https://sys.eudoraclinic.com:84/app/ControllerPurchasing/generateInvoicePDF/${selectedPO}?ongkir=${ongkir_existing || 0}&other_cost=${other_cost_existing || 0}`;
                    window.open(url, '_blank');
                    return;
                }

                // Reset modal input
                $('#ongkir').val('');
                $('#other_cost').val('');
                $('#ongkirModal').modal('show');
            }

            // Event listener tombol konfirmasi modal
            $('#confirmUploadBtn').on('click', function () {
                const ongkir = $('#ongkir').val() || 0;
                const other_cost = $('#other_cost').val() || 0;

                // Tutup modal
                $('#ongkirModal').modal('hide');

                // Buka PDF di tab baru
                const url = `https://sys.eudoraclinic.com:84/app/ControllerPurchasing/generateInvoicePDF/${selectedPO}?ongkir=${ongkir}&other_cost=${other_cost}`;
                window.open(url, '_blank');
            });
        </script>
        <?php if ($po['supplierid'] == 25): ?>
            <button class="btn btn-primary btn-block" onclick="showOngkirModal(<?= $po['po_id'] ?>)">
                Generate Vendor Invoice (PT PAA)
            </button>
        <?php endif; ?>

        <script>
            function openInvoicePDF(po_id) {
                const url = "https://sys.eudoraclinic.com:84/app/ControllerPurchasing/generateInvoicePDF/" + po_id;
                window.open(url, '_blank'); // buka di tab baru
            }
        </script>

        <!-- View Documents Section -->
        <div class="card p-3" id="viewDocumentsSection" style="display:none;">

            <div class="panel panel-default">
                <!-- <button>delete vendor invoice</button> -->
                <div class="card-header text-center"><b>Documents</b></div>
                <div class="panel-body" id="docFrames">
                    <!-- iframe will be appended here -->
                </div>
            </div>
        </div>

        <?php if ($this->session->userdata('level') == 20 && isset($po['status']) && $po['status'] == 1): ?>
            <div class="row mt-3">
                <div class="col-md-6 text-center">
                    <button type="button" class="btn btn-success btn-lg" id="btnApprove">Approve</button>
                </div>
                <div class="col-md-6 text-center">
                    <button type="button" class="btn btn-danger btn-lg" id="btnReject">Reject</button>
                </div>
            </div>


            <script>
                $(document).ready(function () {
                    var purchaseorderid = "<?= $id ?>";

                    // approve
                    $("#btnApprove").on("click", function () {
                        if (confirm("Yakin ingin approve Purchase Order ini?")) {
                            $.ajax({
                                url: "<?= site_url('ControllerPurchasing/approvePurchaseOrder1') ?>",
                                type: "POST",
                                data: { purchaseorderid: purchaseorderid },
                                dataType: "json",
                                success: function (res) {
                                    if (res.success) {
                                        alert(res.message || "Purchase Order berhasil di-approve");
                                        location.reload(); // refresh halaman
                                    } else {
                                        alert(res.message || "Gagal approve Purchase Order");
                                    }
                                },
                                error: function () {
                                    alert("Terjadi kesalahan saat menghubungi server");
                                }
                            });
                        }
                    });

                    // reject
                    $("#btnReject").on("click", function () {
                        if (confirm("Yakin ingin reject Purchase Order ini?")) {
                            $.ajax({
                                url: "<?= site_url('ControllerPurchasing/rejectPurchaseOrder1') ?>",
                                type: "POST",
                                data: { purchaseorderid: purchaseorderid },
                                dataType: "json",
                                success: function (res) {
                                    if (res.success) {
                                        alert(res.message || "Purchase Order berhasil di-reject");
                                        location.reload();
                                    } else {
                                        alert(res.message || "Gagal reject Purchase Order");
                                    }
                                },
                                error: function () {
                                    alert("Terjadi kesalahan saat menghubungi server");
                                }
                            });
                        }
                    });
                });
            </script>
        <?php endif; ?>

        <?php if ($this->session->userdata('level') == 21 && isset($po['status']) && $po['status'] == 7): ?>
            <div class="row mt-3">
                <div class="col-md-6 text-center">
                    <button type="button" class="btn btn-success btn-lg" id="btnApprove">Approve</button>
                </div>
                <div class="col-md-6 text-center">
                    <button type="button" class="btn btn-danger btn-lg" id="btnReject">Reject</button>
                </div>
            </div>

            <script>
                $(document).ready(function () {
                    var purchaseorderid = "<?= $id ?>";

                    // approve
                    $("#btnApprove").on("click", function () {
                        if (confirm("Yakin ingin approve Purchase Order ini?")) {
                            $.ajax({
                                url: "<?= site_url('ControllerPurchasing/approvePurchaseOrder2') ?>",
                                type: "POST",
                                data: { purchaseorderid: purchaseorderid },
                                dataType: "json",
                                success: function (res) {
                                    if (res.success) {
                                        alert(res.message || "Purchase Order berhasil di-approve");
                                        location.reload(); // refresh halaman
                                    } else {
                                        alert(res.message || "Gagal approve Purchase Order");
                                    }
                                },
                                error: function () {
                                    alert("Terjadi kesalahan saat menghubungi server");
                                }
                            });
                        }
                    });

                    // reject
                    $("#btnReject").on("click", function () {
                        if (confirm("Yakin ingin reject Purchase Order ini?")) {
                            $.ajax({
                                url: "<?= site_url('ControllerPurchasing/rejectPurchaseOrder2') ?>",
                                type: "POST",
                                data: { purchaseorderid: purchaseorderid },
                                dataType: "json",
                                success: function (res) {
                                    if (res.success) {
                                        alert(res.message || "Purchase Order berhasil di-reject");
                                        location.reload();
                                    } else {
                                        alert(res.message || "Gagal reject Purchase Order");
                                    }
                                },
                                error: function () {
                                    alert("Terjadi kesalahan saat menghubungi server");
                                }
                            });
                        }
                    });
                });
            </script>


        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <?php
        $level = $this->session->userdata('level');
        if ($level == 20 || $level == 21) {
            $backUrl = "https://sys.eudoraclinic.com:84/app/purchaseOrderApproval";
        } else {
            $backUrl = "https://sys.eudoraclinic.com:84/app/purchaseOrderList";
        }
        ?>
        <a type="button" class="btn btn-primary" href="<?= $backUrl ?>">Back</a>


    </div>

    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables.bootstrap.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function () {
            // toggle field Jumlah Keluar

            $('#jenis_bk').on('change', function () {
                if ($(this).val() === 'ongkir') {
                    $('#jml_keluar_group').show();
                    $('#jml_keluar').attr('required', true);
                } else {
                    $('#jml_keluar_group').hide();
                    $('#jml_keluar').removeAttr('required').val('');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            var poId = "<?= isset($id) ? $id : 0 ?>";
            const baseUrl = "<?= base_url('ControllerPurchasing') ?>";
            let level = <?= json_encode($this->session->userdata('level') ?? null) ?>;
            console.log("Level user:", level);

            if (poId > 0) {
                loadPODetails(poId);
            }

            // Fungsi format Rupiah
            function formatRupiah(number) {
                if (!number && number !== 0) return '-';
                return 'Rp ' + parseFloat(number).toLocaleString('id-ID');
            }

            function formatNumber(num) {
                if (num == null || num === "") return "0";
                num = parseFloat(num);
                if (isNaN(num)) return "0";

                // Batasi 4 desimal, lalu hapus nol berlebih
                let str = num.toFixed(4).replace(/\.?0+$/, "");
                return str;
            }

            // Load Detail PO
            function loadPODetails(id) {
                $.ajax({
                    url: baseUrl + "/getPurchaseOrderById/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function (res) {
                        if (!res) {
                            Swal.fire('Error', 'Data Purchase Order tidak ditemukan', 'error');
                            return;
                        }

                        // Set hidden input purchaseorderid
                        if (res.purchaseorderid) {
                            $("#purchaseorderid").val(res.purchaseorderid);
                        }

                        // Header PO
                        $("#po_order_number").text(res.order_number || '-');
                        $("#po_orderdate").text(res.orderdate || '-');
                        $("#po_requestnumber").text(res.requestnumber || '-');
                        $("#po_company").text(res.companyname || '-');
                        $("#po_department").text(res.department_name || '-');
                        $("#po_warehouse").text(res.warehouse_name || '-');
                        $("#po_supplier").text(res.supplier_name || res.ecommerce_name);
                        $("#po_sales").text(res.sales_name || '-');
                        $("#po_orderer").text(res.orderer_name || '-');
                        $("#po_requester").text(res.requester_name || '-');
                        $("#po_notes").text(res.notes || '-');

                        // Items PO
                        var tbody = $("#tbl-po-items tbody");
                        tbody.empty();
                        if (res.items && res.items.length > 0) {
                            let grandTotal = 0;
                            // Loop semua item
                            $.each(res.items, function (i, item) {
                                let qtyDisplay = (item.alternativeunitid && item.alternativeunitid !== "0")
                                    ? `${formatNumber(item.qty)} ${item.alternativeunitname || ''}`
                                    : `${formatNumber(item.qty)} ${item.unit_name || ''}`;

                                let qtyToUomDisplay = (item.alternativeunitid && item.alternativeunitid !== "0")
                                    ? `${formatNumber(item.qtytouom * item.qty)} ${item.unit_name || ''}`
                                    : `${formatNumber(item.qty)} ${item.unit_name || ''}`;

                                grandTotal += parseFloat(item.total_price) || 0;

                                let editButton = "";
                                if (typeof level !== "undefined" && level == 7) {
                                    editButton = `
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="editPurchaseOrderItems(${item.poi_id})">
                                        <i class="fa fa-edit"></i>
                                    </button>`;
                                }

                                tbody.append(`
                                <tr>
                                    <td>${i + 1} ${editButton}</td>
                                    <td>${item.item_code || '-'}</td>
                                    <td>${item.itemname || '-'}</td>
                                    <td>${qtyDisplay}</td>
                                    <td>${qtyToUomDisplay}</td>
                                    <td>${formatRupiah(item.fixed_price)}</td>
                                    <td>${formatRupiah(item.discount_value) || '-'}</td>
                                    <td>${formatRupiah(item.total_price)}</td>
                                    <td>${item.description || '-'}</td>
                                </tr>
                            `);
                            });

                            // Tambahkan ongkir
                            let ongkir = parseFloat(res.ongkir) || 0;
                            tbody.append(`
                            <tr>
                                <td colspan="7" class="text-right"><b>Ongkir</b></td>
                                <td>${formatRupiah(ongkir)}</td>
                                <td>-</td>
                            </tr>
                        `);

                            let other_cost = parseFloat(res.other_cost) || 0;
                            tbody.append(`
                            <tr>
                                <td colspan="7" class="text-right"><b>Biaya Lain-Lain</b></td>
                                <td>${formatRupiah(other_cost)}</td>
                                <td>-</td>
                            </tr>
                        `);

                            // Hitung total akhir (items + ongkir)
                            let totalAkhir = grandTotal + ongkir + other_cost;
                            tbody.append(`
                            <tr>
                                <td colspan="7" class="text-right"><b>Total Akhir</b></td>
                                <td><b>${formatRupiah(totalAkhir)}</b></td>
                                <td>-</td>
                            </tr>
                        `);
                        } else {
                            tbody.append(`<tr><td colspan="8" class="text-center">No items found</td></tr>`);
                        }

                        // === LOGIC UPLOAD / VIEW DOCUMENTS ===
                        $("#uploadDocumentsSection").hide();
                        $("#viewDocumentsSection").hide();
                        $("#requestFinanceSection").hide();
                        $("#docFrames").empty();

                        // Upload section jika status 0
                        if (level == 7) {
                            $("#uploadDocumentsSection").show();
                        } else {
                            $("#uploadDocumentsSection").hide();
                        }

                        // // BK attachment
                        // if(res.bk_attachment){
                        //     $("#viewDocumentsSection").show();
                        //     $("#docFrames").append(`
                        //         <h5><b>BK Document</b></h5>
                        //         <iframe src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/${res.bk_attachment}" width="100%" height="400"></iframe>
                        //     `);
                        // }

                        // // Vendor Invoice
                        // if (res.vendor_invoice) {
                        //     $("#viewDocumentsSection").show();
                        //     $("#docFrames").empty(); // bersihkan dulu

                        //     const files = res.vendor_invoice.split(',');
                        //     files.forEach(file => {
                        //         $("#docFrames").append(`
                        //             <h5><b>Vendor Invoice</b></h5>
                        //             <iframe src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/${file.trim()}" 
                        //                     width="100%" height="400" class="mb-3"></iframe>
                        //         `);
                        //     });
                        // }

                        // BK attachment
                        if (res.bk_attachment) {
                            $("#viewDocumentsSection").show();
                            $("#docFrames").append(`
                            <h5><b>BK Document</b></h5>
                            <iframe src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/${encodeURIComponent(res.bk_attachment)}" width="100%" height="400"></iframe>
                        `);
                        }

                        // Vendor Invoice
                        if (res.vendor_invoice) {
                            $("#viewDocumentsSection").show();
                            const files = res.vendor_invoice.split(',');
                            files.forEach(file => {
                                $("#docFrames").append(`
                                <h5><b>Vendor Invoice</b></h5>
                                <iframe src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/${encodeURIComponent(file.trim())}" width="100%" height="400" class="mb-3"></iframe>
                            `);
                            });
                        }

                        // Dokumen DO
                        if (res.po_id) {
                            $("#viewDocumentsSection").show();
                            $("#docFrames").append(`
                            <a href="https://sys.eudoraclinic.com:84/app/ControllerPurchasing/generateDeliveryOrderByPOPDF/${res.po_id}" target="_blank">Dokumen DO</a>
                        `);
                        }

                        // Finance request section jika status 1
                        if (res.status == 1) {
                            $("#requestFinanceSection").show();
                        }

                        // Bukti transfer finance
                        if (res.bukti_transfer) {
                            $("#viewDocumentsSection").show();
                            $("#docFrames").append(`
                            <h5><b>Bukti Transfer Finance</b></h5>
                            <iframe src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/bukti_transfer/${res.bukti_transfer}" width="100%" height="400"></iframe>
                        `);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX ERROR:", error, xhr.responseText);
                        Swal.fire('Error', 'Gagal load data PO', 'error');
                    }
                });
            }

            // Hapus BK
            $(document).on('click', '.deleteBKBtn', function () {
                const bkId = $(this).data('id');
                const filePath = $(this).data('file');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Yakin ingin menghapus BK ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: baseUrl + '/deleteBK',
                            type: 'POST',
                            data: { id: bkId, file_path: filePath },
                            dataType: 'json',
                            success: function (res) {
                                if (res.status) {
                                    Swal.fire('Berhasil', 'BK berhasil dihapus', 'success');
                                    $(`#bkItem-${bkId}`).remove();
                                } else {
                                    Swal.fire('Gagal', 'Gagal hapus BK', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                            }
                        });
                    }
                });
            });

            // Handle upload form
            // $("form[action*='uploadDocumentsPurchaseOrder']").on("submit", function(e){
            //     e.preventDefault();
            //     var formData = new FormData(this);

            //     $.ajax({
            //         url: this.action,
            //         type: "POST",
            //         data: formData,
            //         processData: false,
            //         contentType: false,
            //         dataType: "json",
            //         success: function(res){
            //             if(res.status){
            //                 Swal.fire('Sukses', res.message, 'success').then(()=> location.reload());
            //             } else {
            //                 Swal.fire('Error', res.message, 'error');
            //             }
            //         },
            //         error: function(){
            //             Swal.fire('Error','Terjadi kesalahan saat upload file','error');
            //         }
            //     });
            // });

            $("form[action*='uploadDocumentsPurchaseOrder']").on("submit", function (e) {
                e.preventDefault();
                var form = this; // simpan form ref

                // Tampilkan modal ongkir dulu
                $("#ongkirModal").modal("show");

                // Handle tombol konfirmasi upload di modal
                $("#confirmUploadBtn").off("click").on("click", function () {
                    var formData = new FormData(form);
                    var ongkir = $("#ongkir").val();
                    var other_cost = $("#other_cost").val();

                    if (ongkir && ongkir !== "") {
                        formData.append("ongkir", ongkir);
                        formData.append("other_cost", other_cost);
                    }

                    $.ajax({
                        url: form.action,
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (res) {
                            $("#ongkirModal").modal("hide");
                            if (res.status) {
                                Swal.fire('Sukses', res.message, 'success').then(() => location.reload());
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        error: function () {
                            $("#ongkirModal").modal("hide");
                            Swal.fire('Error', 'Terjadi kesalahan saat upload file', 'error');
                        }
                    });
                });
            });


            window.loadPODetails = loadPODetails;
        });

        function editPurchaseOrderItems(poi_id) {
            $.ajax({
                url: '<?= base_url('ControllerPurchasing/getPurchaseOrderItem/') ?>' + poi_id,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.status === 'success') {
                        const item = res.data;
                        $('#poi_id').val(item.poi_id);
                        $('#itemname').val(item.itemname);
                        $('#quantity').val(parseFloat(item.quantity));
                        $('#fixed_price').val(formatRupiah(parseFloat(item.fixed_price) || 0));
                        $('#discount_type').val(item.discount_type || 'persen');
                        $('#discount_value').val(formatRupiah(parseFloat(item.discount_amount) || 0));

                        calculateTotalPrice();

                        $('#editPriceModal').modal('show');
                    } else {
                        Swal.fire('Error', res.message || 'Data item tidak ditemukan', 'error');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal mengambil data item.', 'error');
                }
            });
        }

        function formatRupiah(angka) {
            if (angka === '' || angka === null || angka === undefined || isNaN(angka)) return '';

            // Pastikan angka berupa integer (bulat)
            angka = parseInt(angka);

            let numberString = angka.toString();

            let sisa = numberString.length % 3;
            let rupiah = numberString.substr(0, sisa);
            let ribuan = numberString.substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return rupiah;
        }


        // function formatRupiah(angka) {
        //     if (angka === '' || angka === null || angka === undefined || isNaN(angka)) return '';

        //     // Pastikan angka berupa float
        //     angka = parseFloat(angka);

        //     // Format menjadi 2 angka di belakang koma
        //     let numberString = angka.toFixed(2).replace('.', ','); // ubah titik desimal jadi koma

        //     let split = numberString.split(',');
        //     let sisa = split[0].length % 3;
        //     let rupiah = split[0].substr(0, sisa);
        //     let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        //     if (ribuan) {
        //         let separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }
        //     rupiah = rupiah + ',' + split[1];

        //     return rupiah;
        // }


        function unformatRupiah(str) {
            return parseFloat(str.replace(/[^\d,-]/g, '').replace(',', '.')) || 0;
        }

        $(document).on('input', '.rupiah-input', function () {
            const caret = this.selectionStart;
            const value = unformatRupiah(this.value);
            this.value = formatRupiah(value);
            this.setSelectionRange(caret, caret);
            calculateTotalPrice();
        });

        function calculateTotalPrice() {
            const qty = parseFloat($('#quantity').val()) || 0;
            const price = unformatRupiah($('#fixed_price').val());
            const discountType = $('#discount_type').val();
            const discountValue = unformatRupiah($('#discount_value').val());

            let total = price * qty;
            let discount = 0;

            if (discountType === 'persen') {
                discount = (discountValue / 100) * total;
            } else if (discountType === 'nominal') {
                discount = discountValue;
            }

            const totalAfter = total - discount;
            $('#total_price').val(formatRupiah(totalAfter));
        }
        $('#discount_type').on('change', calculateTotalPrice);


        $('#editPriceForm').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('ControllerPurchasing/updatePurchaseOrderItem') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    
                    if (res.status === 'success') {
                        Swal.fire('Berhasil', res.message, 'success');
                        // setTimeout(function () {
                        //     location.reload();
                        // }, 1500);

                        $('#editPriceModal').modal('hide');
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire('Error', 'Terjadi kesalahan saat update data.', 'error');
                    console.error(error);
                }
            });
        });

    </script>


</body>

</html>