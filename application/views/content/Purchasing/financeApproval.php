<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order List</title>

    <!-- Existing styles kept -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- ADD: Bootstrap 4 (agar modal('show') dan .nav tabs jQuery-plugin bekerja dengan kode Anda saat ini) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        .mycontaine {
            font-size: 12px !important;
        }

        .mycontaine * {
            font-size: inherit !important;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
        }

        .form-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        select {
            background: #fff;
            cursor: pointer;
        }

        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }

        /* 🔥 Nav Button Full Width (requested) */
        .nav-tabs .nav-link {
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="mycontaine">
        <div class="row-gx-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="row-gx-4 mb-3">
                        <div class="col-md-3 m-3">
                            <label for="filterDate" class="form-label">Filter by Date</label>
                            <input type="date" id="filterDate" class="form-control" value="">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row-gx-4 mb-3">
                        <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                            style="font-weight: bold; color: #666;">
                            Purchase Order Approval
                        </h3>

                        <ul class="nav nav-tabs" id="poTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <!-- keep original attributes (data-bs-*) but we will wire them with JS so you don't lose markup -->
                                <button class="nav-link active" id="status4-tab" data-bs-toggle="tab"
                                    data-bs-target="#status4" type="button" role="tab">Waiting for BK</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="status6-tab" data-bs-toggle="tab" data-bs-target="#status6"
                                    type="button" role="tab">Waiting for Transfer Slip</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="status4" role="tabpanel">
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="poTableStatus4" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Order Number</th>
                                                    <th>Order Date</th>
                                                    <th>Order By</th>
                                                    <th>Department</th>
                                                    <th>Company</th>
                                                    <th>Description</th>
                                                    <th>Notes</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Approved Table -->
                            <div class="tab-pane fade" id="status6" role="tabpanel">
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="poTableStatus6" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Order Number</th>
                                                    <th>Order Date</th>
                                                    <th>Order By</th>
                                                    <th>Department</th>
                                                    <th>Company</th>
                                                    <th>Description</th>
                                                    <th>Notes</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal (poModal kept) -->
                        <div id="poModal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Purchase Order Detail</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body" id="poDetail">
                                        <!-- Detail PO akan dimuat di sini -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Order Detail</h5>
                   
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="detailItems">
                    <thead>
                        <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    </table>
                    <div class="mt-3 text-end">
                    <p id="ongkirText"></p>
                    <h5 id="grandTotalText"></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="approveBtn" class="btn btn-success">Approve</button>
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div> -->

                        <div class="modal fade" id="detailModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Purchase Order Detail</h5>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered" id="detailItems">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Qty</th>
                                                    <th>Harga</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                        <div class="mt-3 text-end">
                                            <p id="ongkirText"></p>
                                            <h5 id="grandTotalText"></h5>
                                        </div>

                                        <div id="approveSupplierInfo" class="mb-3 p-2 border rounded bg-light">
                                            <p><b>Bank:</b> <span id="approveBank">-</span></p>
                                            <p><b>Account:</b> <span id="approveAccount">-</span><span
                                                    id="approveName">-</span></p>
                                        </div>

                                        <!-- Dokumen Section -->
                                        <hr>
                                        <h6><i class="fa fa-file-invoice"></i> Dokumen Purchase Order</h6>
                                        <div id="poDoc" class="mb-3">
                                            <p class="text-muted">Tidak ada dokumen</p>
                                        </div>

                                        <h6><i class="fa fa-file-invoice"></i> Dokumen Vendor Invoice</h6>
                                        <div id="vendorInvoiceDoc" class="mb-3">
                                            <p class="text-muted">Tidak ada dokumen</p>
                                        </div>

                                        <h6><i class="fa fa-file"></i> Dokumen Bukti Keluar (BK)</h6>
                                        <div id="bkDoc">
                                            <p class="text-muted">Tidak ada dokumen</p>
                                        </div>

                                        <h6><i class="fa fa-file"></i> Dokumen Bukti Transfer</h6>
                                        <div id="btDoc">
                                            <p class="text-muted">Tidak ada dokumen</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="approveBtn" class="btn btn-success">Approve</button>
                                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="approveModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form id="approveForm" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve Purchase Order</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="po_id" id="approve_po_id">
                                            
                                            <div id="approveSupplierInfo" class="mb-3 p-2 border rounded bg-light">
                                                <p><b>Bank:</b> <span id="approveBank2">-</span></p>
                                                <p><b>Account:</b> <span id="approveAccount2">-</span><span
                                                        id="approveName2">-</span></p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="bukti_transfer" class="form-label">Upload Bukti
                                                    Transfer</label>
                                                <input type="file" class="form-control" name="bukti_transfer"
                                                    id="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required>
                                                <div class="invalid-feedback">Bukti transfer wajib diupload.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="approveBtnModal" class="btn btn-success"
                                                disabled>Approve</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS includes (added) -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <!-- 
<script>
$(document).ready(function(){

    function formatRupiah(angka){
        if (angka === null || angka === undefined) return "Rp 0";
        // ensure numeric string
        let n = Number(angka) || 0;
        return "Rp " + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

    // make data-bs-toggle tabs work even without bootstrap5 by wiring manually
    $(document).on('click', 'button[data-bs-toggle="tab"]', function(e){
        e.preventDefault();
        const target = $(this).attr('data-bs-target') || $(this).attr('data-target') || $(this).attr('href');
        if(!target) return;
        // toggle nav active
        $(this).closest('.nav').find('.nav-link').removeClass('active');
        $(this).addClass('active');
        // toggle content
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
    });

    // Set default tanggal hari ini
    let today = new Date().toISOString().split('T')[0];
    $('#filterDate').val(today);

    // DataTables: add date parameter and robust dataSrc
    function dataSrcFilterByStatus(json, status){
        let arr = [];
        if (Array.isArray(json)) arr = json;
        else if (json && Array.isArray(json.data)) arr = json.data;
        else arr = [];
        return arr.filter(item => Number(item.status) === Number(status));
    }

    let tableStatus4 = $('#poTableStatus4').DataTable({
        ajax: {
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: 'GET',
            data: function(d){ d.date = $('#filterDate').val(); },
            dataSrc: function(json){ return dataSrcFilterByStatus(json, 4); }
        },
        columns: [
            { data: null, render:(d,t,r,m)=>m.row+1 },
            { data: 'order_number' },
            { data: 'orderdate' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { data: 'status', render:()=>`<span class="badge badge-success">Status 4</span>` },
            { data: 'id', render: d=> `<button class="detailBtn btn btn-info btn-sm" data-id="${d}">Detail</button>` }
        ]
    });

    let tableStatus6 = $('#poTableStatus6').DataTable({
        ajax: {
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: 'GET',
            data: function(d){ d.date = $('#filterDate').val(); },
            dataSrc: function(json){ return dataSrcFilterByStatus(json, 6); }
        },
        columns: [
            { data: null, render:(d,t,r,m)=>m.row+1 },
            { data: 'order_number' },
            { data: 'orderdate' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { data: 'status', render:()=>`<span class="badge badge-warning">Waiting</span>` },
            { data: 'id', render: d=> `<button class="detailBtn btn btn-info btn-sm" data-id="${d}">Detail</button>` }
        ]
    });

    $('#filterDate').on('change', function(){
        tableStatus4.ajax.reload();
        tableStatus6.ajax.reload();
    });

    // helper to safely read item props (item name / qty / price)
    function getItemField(item, candidates){
        for(let k of candidates) if(item[k] !== undefined && item[k] !== null) return item[k];
        return "";
    }

    // Detail modal (works for both tables)
    $(document).on("click", ".detailBtn", function(){
        let id = $(this).data("id");

        $.ajax({
            url: baseUrl + "/getPurchaseOrderById/" + id,
            type: "GET",
            dataType: "json",
            success: function(res){
                if(!res){ Swal.fire("Error","Data kosong","error"); return; }

                let tbody = "";
                let totalBarang = 0;

                // flexible field names for compatibility
                let items = res.items || res.purchase_order_items || res.items_detail || [];

                if(!Array.isArray(items)) items = [];

                if(items.length === 0){
                    tbody = `<tr><td colspan="4" class="text-center">No items found</td></tr>`;
                } else {
                    items.forEach(item => {
                        let nama = getItemField(item, ['nama_item','itemname','item_name','item_name_display']);
                        let qty  = Number(getItemField(item, ['qty','quantity','jumlah'])) || 0;
                        let price= Number(getItemField(item, ['harga','fixed_price','unit_price','price'])) || 0;
                        let total= Number(getItemField(item, ['total_price'])) || (qty * price);
                        totalBarang += total;
                        tbody += `
                            <tr>
                                <td>${nama || JSON.stringify(item)}</td>
                                <td class="text-right">${qty}</td>
                                <td class="text-right">${formatRupiah(price)}</td>
                                <td class="text-right">${formatRupiah(total)}</td>
                            </tr>
                        `;
                    });
                    tbody += `<tr><td colspan="3" class="text-center"><b>Subtotal Items</b></td><td class="text-right"><b>${formatRupiah(totalBarang)}</b></td></tr>`;
                }

                $("#detailItems tbody").html(tbody);

                // read ongkir from response (support different names)
                let ongkir = Number(res.ongkir || res.jml_keluar || res.shipping_cost || 0) || 0;
                let grandTotal = totalBarang + ongkir;

                $("#ongkirText").text("Ongkir: " + formatRupiah(ongkir));
                $("#grandTotalText").text("Grand Total: " + formatRupiah(grandTotal));

                // store PO id and status on approve button for later actions
                $("#approveBtn").data("poId", id);
                $("#approveBtn").data("poStatus", Number(res.status));

                // if status is 6, show instruction that upload bukti_transfer is required -> we will open upload modal on Approve click
                if(Number(res.status) === 6){
                    $("#approveBtn").text("Approve (Upload Bukti)");
                } else if(Number(res.status) === 4){
                    $("#approveBtn").text("Approve & Generate BK");
                } else {
                    $("#approveBtn").text("Approve");
                }

                $("#detailModal").modal('show');
            },
            error: function(xhr,st,err){
                Swal.fire("Error","Gagal ambil detail: "+err,"error");
            }
        });
    });

    // Approve button in detail modal: behavior depends on poStatus
    $("#approveBtn").on("click", function(){
        let poId = $(this).data("poid") || $(this).data("poId");
        let poStatus = $(this).data("postatus") || $(this).data("poStatus");

        if(!poId) { Swal.fire("Error","ID PO tidak tersedia","error"); return; }

        if(Number(poStatus) === 4){
            // For status 4: call create_bk_ajax to generate BK and set status = 7.
            Swal.fire({
                title: "Konfirmasi",
                text: "Generate BK dan ubah status PO menjadi 7?",
                icon: "question",
                showCancelButton: true
            }).then(result => {
                if(!result.isConfirmed) return;
                $.ajax({
                    url: baseUrl + "/create_bk_ajax/" + poId,
                    type: "POST",
                    dataType: "json",
                    success: function(resp){
                        if(resp?.status === "success"){
                            Swal.fire("Berhasil", resp.message || "BK dibuat & status diperbarui","success");
                            $("#detailModal").modal('hide');
                            tableStatus4.ajax.reload();
                            tableStatus6.ajax.reload();
                        } else {
                            Swal.fire("Gagal", resp?.message || "Gagal membuat BK","error");
                        }
                    },
                    error: function(){ Swal.fire("Error","Gagal proses create_bk","error"); }
                });
            });
        } else if(Number(poStatus) === 6){
            // For status 6: open upload modal (approveModal) to upload bukti_transfer and then call approvePurchaseOrder
            $('#approve_po_id').val(poId);
            $('#bukti_transfer').val('');
            $('#approveBtnModal').prop('disabled', true);
            $('#approveModal').modal('show');
        } else {
            // fallback approve (call approve endpoint)
            $.ajax({
                url: baseUrl + "/approvePurchaseOrder/" + poId,
                type: "POST",
                dataType: "json",
                success: function(resp){
                    if(resp?.status === "success"){
                        Swal.fire("Berhasil","PO berhasil diapprove","success");
                        $("#detailModal").modal('hide');
                        tableStatus4.ajax.reload();
                        tableStatus6.ajax.reload();
                    } else Swal.fire("Gagal", resp?.message || "Gagal approve","error");
                },
                error: function(){ Swal.fire("Error","Gagal approve PO","error"); }
            });
        }
    });

    // enable/disable approve submit when file selected
    $(document).on('change', '#bukti_transfer', function(){
        $('#approveBtnModal').prop('disabled', !$(this).val());
    });

    // Submit bukti_transfer (approve status 6 -> set status = 2)
    $('#approveForm').on('submit', function(e){
        e.preventDefault();
        let poId = $('#approve_po_id').val();
        let fd = new FormData(this);
        $.ajax({
            url: baseUrl + "/approvePurchaseOrder/" + poId,
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(resp){
                if(resp?.status === "success"){
                    Swal.fire("Berhasil", resp.message || "PO diapprove", "success");
                    $('#approveModal').modal('hide');
                    tableStatus4.ajax.reload();
                    tableStatus6.ajax.reload();
                } else {
                    Swal.fire("Gagal", resp?.message || "Gagal approve", "error");
                }
            },
            error: function(){ Swal.fire("Error","Terjadi kesalahan saat proses approve.","error"); }
        });
    });

});
</script> -->

        <script>
            $(document).ready(function () {

                function formatRupiah(angka) {
                    if (angka === null || angka === undefined) return "Rp 0";
                    let n = Number(angka) || 0;
                    return "Rp " + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
                const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

                $(document).on('click', 'button[data-bs-toggle="tab"]', function (e) {
                    e.preventDefault();
                    const target = $(this).attr('data-bs-target') || $(this).attr('data-target') || $(this).attr('href');
                    if (!target) return;
                    $(this).closest('.nav').find('.nav-link').removeClass('active');
                    $(this).addClass('active');
                    $('.tab-pane').removeClass('show active');
                    $(target).addClass('show active');
                });

                $('#filterDate').val();

                function dataSrcFilterByStatus(json, status) {
                    let arr = [];
                    if (Array.isArray(json)) arr = json;
                    else if (json && Array.isArray(json.data)) arr = json.data;
                    else arr = [];

                    // Pastikan bisa handle array maupun single status
                    if (Array.isArray(status)) {
                        return arr.filter(item => status.includes(Number(item.status)));
                    } else {
                        return arr.filter(item => Number(item.status) === Number(status));
                    }
                }

                let tableStatus4 = $('#poTableStatus4').DataTable({
                    ajax: {
                        url: baseUrl + "/getAllPurchaseOrderByDate",
                        type: 'GET',
                        data: function (d) { d.date = $('#filterDate').val(); },
                        dataSrc: function (json) { return dataSrcFilterByStatus(json, 4); }
                    },
                    columns: [
                        { data: null, render: (d, t, r, m) => m.row + 1 },
                        { data: 'order_number' },
                        { data: 'orderdate' },
                        { data: 'orderer_name' },
                        { data: 'department_name' },
                        { data: 'company_name' },
                        { data: 'description' },
                        {
                            data: function (row) {
                                return row.notes && row.notes.trim() !== '' ? row.notes : row.order_notes;
                            }
                        },
                        { data: 'status', render: () => `<span class="badge badge-warning">Waiting</span>` },
                        { data: 'id', render: d => `<button class="detailBtn btn btn-info btn-sm" data-id="${d}">Detail</button>` }
                    ]
                });

                let tableStatus6 = $('#poTableStatus6').DataTable({
                    ajax: {
                        url: baseUrl + "/getAllPurchaseOrderByDate",
                        type: 'GET',
                        data: function (d) { d.date = $('#filterDate').val(); },
                        dataSrc: function (json) {
                            return dataSrcFilterByStatus(json, [6, 11]);
                        }
                    },
                    columns: [
                        { data: null, render: (d, t, r, m) => m.row + 1 },
                        { data: 'order_number' },
                        { data: 'orderdate' },
                        { data: 'orderer_name' },
                        { data: 'department_name' },
                        { data: 'company_name' },
                        { data: 'description' },
                        {
                            data: function (row) {
                                return row.notes && row.notes.trim() !== '' ? row.notes : row.order_notes;
                            }
                        },
                        { data: 'status', render: () => `<span class="badge badge-warning">Waiting</span>` },
                        { data: 'id', render: d => `<button class="detailBtn btn btn-info btn-sm" data-id="${d}">Detail</button>` }
                    ]
                });

                $('#filterDate').on('change', function () {
                    tableStatus4.ajax.reload();
                    tableStatus6.ajax.reload();
                });

                function getItemField(item, candidates) {
                    for (let k of candidates) if (item[k] !== undefined && item[k] !== null) return item[k];
                    return "";
                }

                $(document).on("click", ".detailBtn", function () {
                    let id = $(this).data("id");

                    $.ajax({
                        url: baseUrl + "/getPurchaseOrderById/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function (res) {
                            if (!res) { alert("Data kosong"); return; }

                            let tbody = "";
                            let totalBarang = 0;

                            let supplierBank = res.supplier_bank || res.ecommerce_name || "-";
                            let supplierAcc = res.supplier_account || res.va_number || "-";
                            let supplierName = res.supplier_name || "-";


                            $("#approveBank").text(supplierBank);
                            $("#approveAccount").text(supplierAcc);
                            $("#approveName").text(supplierName);

                            $("#approveBank2").text(supplierBank);
                            $("#approveAccount2").text(supplierAcc);
                            $("#approveName2").text(supplierName);


                            let items = res.items || res.purchase_order_items || res.items_detail || [];
                            if (!Array.isArray(items)) items = [];

                            if (items.length === 0) {
                                tbody = `<tr><td colspan="4" class="text-center">No items found</td></tr>`;
                            } else {
                                items.forEach(item => {
                                    let nama = getItemField(item, ['nama_item', 'itemname', 'item_name', 'item_name_display']);
                                    let qty = Number(getItemField(item, ['qty', 'quantity', 'jumlah'])) || 0;
                                    let price = Number(getItemField(item, ['harga', 'fixed_price', 'unit_price', 'price'])) || 0;
                                    let total = Number(getItemField(item, ['total_price'])) || (qty * price);
                                    totalBarang += total;
                                    tbody += `
                            <tr>
                                <td>${nama || JSON.stringify(item)}</td>
                                <td class="text-right">${qty}</td>
                                <td class="text-right">${formatRupiah(price)}</td>
                                <td class="text-right">${formatRupiah(total)}</td>
                            </tr>
                        `;
                                });
                            }

                            // ambil ongkir & other cost
                            let ongkir = Number(res.ongkir || res.jml_keluar || res.shipping_cost || 0) || 0;
                            let otherCost = Number(res.other_cost || 0) || 0;
                            let grandTotal = totalBarang + ongkir + otherCost;

                            // tambahkan ringkasan ke tabel
                            tbody += `
                    <tr>
                        <td colspan="3" class="text-center"><b>Subtotal Items</b></td>
                        <td class="text-right"><b>${formatRupiah(totalBarang)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><b>Ongkir</b></td>
                        <td class="text-right"><b>${formatRupiah(ongkir)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><b>Other Cost</b></td>
                        <td class="text-right"><b>${formatRupiah(otherCost)}</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><b>Grand Total</b></td>
                        <td class="text-right"><b>${formatRupiah(grandTotal)}</b></td>
                    </tr>
                `;

                            $("#detailItems tbody").html(tbody);

                            // === Dokumen Section ===
                            let vendorInvoice = res.vendor_invoice || res.invoice_doc || res.invoice_file || null;
                            let bkDocument = res.bk_attachment || res.bukti_keluar || res.bk_file || null;
                            let buktiTransfer = res.bukti_transfer || null;
                            let poDoc = res.po_id || null;

                            if (poDoc) {
                                let fileUrl = "https://sys.eudoraclinic.com:84/app/ControllerPurchasing/generatePurchaseOrderPDF/" + poDoc;
                                $("#poDoc").html(`
                        <a href="${fileUrl}" target="_blank" class="btn btn-outline-warning btn-sm">
                            <i class="fa fa-eye"></i> Lihat Dokumen Purchase Order
                        </a>
                    `);
                            } else {
                                $("#vendorInvoiceDoc").html(`<p class="text-muted">Tidak ada dokumen vendor invoice</p>`);
                            }

                            if (vendorInvoice) {
                                let fileUrl = "https://sys.eudoraclinic.com:84/app/uploads/purchase_order/" + vendorInvoice;
                                $("#vendorInvoiceDoc").html(`
                        <a href="${fileUrl}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-eye"></i> Lihat Vendor Invoice
                        </a>
                    `);
                            } else {
                                $("#vendorInvoiceDoc").html(`<p class="text-muted">Tidak ada dokumen vendor invoice</p>`);
                            }

                            // bukti keluar (BK)
                            if (bkDocument) {
                                let fileUrl = "https://sys.eudoraclinic.com:84/app/uploads/purchase_order/" + bkDocument;
                                $("#bkDoc").html(`
                        <a href="${fileUrl}" target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="fa fa-eye"></i> Lihat Dokumen BK
                        </a>
                    `);
                            } else {
                                $("#bkDoc").html(`<p class="text-muted">Tidak ada dokumen BK</p>`);
                            }

                            if (buktiTransfer) {
                                let fileUrl = "https://sys.eudoraclinic.com:84/app/uploads/purchase_order/" + bukti_transfer;
                                $("#btDoc").html(`
                        <a href="${fileUrl}" target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="fa fa-eye"></i> Lihat Upload Bukti Transfer
                        </a>
                    `);
                            } else {
                                $("#btDoc").html(`<p class="text-muted">Tidak ada dokumen Bukti Transfer</p>`);
                            }

                            $("#approveBtn").data("poId", id);
                            $("#approveBtn").data("poStatus", Number(res.status));

                            if (Number(res.status) === 6) {
                                $("#approveBtn").text("Approve (Upload Bukti)");
                            } else if (Number(res.status) === 4) {
                                $("#approveBtn").text("Approve & Generate BK");
                            } else if (Number(res.status) === 11) {
                                $("#approveBtn").text("Approve (Upload Bukti Sukses)");
                            } else {
                                $("#approveBtn").text("Approve");
                            }

                            $("#detailModal").modal('show');
                        },
                        error: function (xhr, st, err) {
                            alert("Gagal ambil detail: " + err);
                        }
                    });
                });

                $("#approveBtn").on("click", function () {
                    let poId = $(this).data("poid") || $(this).data("poId");
                    let poStatus = $(this).data("postatus") || $(this).data("poStatus");

                    if (!poId) {
                        alert("ID PO tidak tersedia");
                        return;
                    }

                    if (Number(poStatus) === 4) {
                        if (confirm("Generate BK dan ubah status PO menjadi 7?")) {
                            $.ajax({
                                url: baseUrl + "/create_bk_ajax/" + poId,
                                type: "POST",
                                dataType: "json",
                                success: function (resp) {
                                    if (resp?.status === "success") {
                                        alert(resp.message || "BK dibuat & status diperbarui");
                                        $("#detailModal").modal('hide');
                                        tableStatus4.ajax.reload();
                                        tableStatus6.ajax.reload();
                                    } else {
                                        alert(resp?.message || "Gagal membuat BK");
                                    }
                                },
                                error: function () {
                                    alert("Gagal proses create_bk");
                                }
                            });
                        }
                    }
                    // === Revisi Bagian Ini ===
                    else if (Number(poStatus) === 6 || Number(poStatus) === 7 || Number(poStatus) === 11) {
                        $('#approve_po_id').val(poId);
                        $('#bukti_transfer').val('');
                        $('#approveBtnModal').prop('disabled', false);
                        $('#approveModalLabel').text('Upload / Update Bukti Transfer'); // Ubah judul modal agar jelas
                        $('#approveModal').modal('show');
                    }
                });

                // $(document).on('change', '#bukti_transfer', function(){
                //     $('#approveBtnModal').prop('disabled', !$(this).val());
                // });



                $('#approveForm').on('submit', function (e) {
                    e.preventDefault();
                    let poId = $('#approve_po_id').val();
                    let fd = new FormData(this);

                    $.ajax({
                        url: baseUrl + "/approvePurchaseOrder/" + poId,
                        type: "POST",
                        data: fd,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function (resp) {
                            if (resp?.status === "success") {
                                alert(resp.message || "Bukti transfer berhasil diupload / diperbarui");
                                $('#detailModal').modal('hide');
                                $('#approveModal').modal('hide');
                                tableStatus4.ajax.reload();
                                tableStatus6.ajax.reload();
                            } else {
                                alert(resp?.message || "Gagal mengupload / memperbarui bukti transfer");
                            }
                        },
                        error: function () {
                            alert("Terjadi kesalahan saat proses upload/update bukti transfer.");
                        }
                    });
                });


            });
        </script>
</body>

</html>