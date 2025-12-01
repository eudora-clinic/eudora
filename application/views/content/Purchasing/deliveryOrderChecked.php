<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Detail Delivery Order' ?></title>
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
        <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3" style="font-weight: bold; color: #666;">
            Detail Delivery Order
        </h3>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr><th width="25%">DO Number</th><td id="po_delivery_number">-</td></tr>
                <tr><th width="25%">PO Number</th><td id="po_order_number">-</td></tr>
                <tr><th>Order Date</th><td id="po_orderdate">-</td></tr>
                <tr><th>Purchase Request</th><td id="po_requestnumber">-</td></tr>
                <tr><th>Company</th><td id="po_company">-</td></tr>
                <tr><th>Department</th><td id="po_department">-</td></tr>
                <tr><th>Warehouse</th><td id="po_warehouse">-</td></tr>
                <tr><th>Supplier</th><td id="po_supplier">-</td></tr>
                <tr><th>Sales</th><td id="po_sales">-</td></tr>
                <tr><th>Order By</th><td id="po_orderer">-</td></tr>
                <tr><th>Requester</th><td id="po_requester">-</td></tr>
                <tr><th>Notes</th><td id="po_notes">-</td></tr>
                </tbody>
            </table>
        </div>
        <div class="form-group mt-3">
            <label for="po_additional_notes"><strong>Notes Tambahan PO:</strong></label>
            <textarea id="po_additional_notes" name="po_additional_notes" class="form-control" rows="3"><?= isset($po_notes) ? $po_notes : '' ?></textarea>
        </div>
    </div>

    <!-- Card Detail Items with Checklist -->
    <div class="card mt-3">
        <div class="card-header">Select Items to Stock In</div>
        <div class="card-body">
            <form id="formStockIn" action="<?= site_url('ControllerPurchasing/saveStockInDummy') ?>" method="post">
                <input type="hidden" name="purchaseorderid" value="<?= $id ?>">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="tbl-po-items">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>No</th>
                            <th>Item Code</th>
                            <th>Item Name</th>
                            <th>Order Qty</th>
                            <th>Actual Qty</th>
                            <th>Qty to UOM</th>
                            <th>Photo</th>
                            <th>Description</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td colspan="7" class="text-center">Loading...</td></tr>
                    </tbody>
                </table>

                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Save Selected to StockIn</button>
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
    var poId = "<?= isset($id) ? $id : 0 ?>";
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

    if(poId > 0){
        loadPODetails(poId);
    }

    function loadPODetails(id){
        $.ajax({
            url: baseUrl + "/getDeliveryOrderById/" + id,
            type: "GET",
            dataType: "json",
            success: function(res){
                if(!res){
                    Swal.fire('Error','Data Purchase Order tidak ditemukan','error');
                    return;
                }

                $("#purchaseorderid").val(res.purchaseorderid || '');

                // Header PO
                $("#po_delivery_number").text(res.delivery_number || '-');
                $("#po_order_number").text(res.order_number || '-');
                $("#po_orderdate").text(res.orderdate || '-');
                $("#po_requestnumber").text(res.requestnumber || '-');
                $("#po_company").text(res.companyname || '-');
                $("#po_department").text(res.department_name || '-');
                $("#po_warehouse").text(res.warehouse_name || '-');
                $("#po_supplier").text(res.supplier_name || '-');
                $("#po_sales").text(res.sales_name || '-');
                $("#po_orderer").text(res.orderer_name || '-');
                $("#po_requester").text(res.requester_name || '-');
                $("#po_notes").text(res.notes || '-');
                if(res.additional_notes !== undefined){
                    $("#po_additional_notes").val(res.additional_notes);
                }

                // Items
                var tbody = $("#tbl-po-items tbody");
                tbody.empty();
                if(res.items && res.items.length > 0){
                    $.each(res.items, function(i,item){
                        let qtyToUomDisplay = item.alternativeunitid && item.alternativeunitid !== "0"
                            ? `${item.qtytouom || 1} ${item.unit_name || ''}`
                            : `1 ${item.unit_name || ''}`;

                        let isChecked = item.status == 1 ? 'checked disabled' : '';

                        // ✅ kalau sudah selesai → actualqty = order qty & disable
                        let actualQtyValue = item.status == 1 ? (item.qty || 0) : 0;
                        let actualQtyDisabled = item.status == 1 ? 'readonly' : '';

                        // ✅ kalau ada photo → buat tombol modal
                        let photoHtml = item.photo 
                            ? `<button type="button" class="btn btn-sm btn-info" 
                                    data-toggle="modal" 
                                    data-target="#photoModal" 
                                    data-src="https://sys.eudoraclinic.com:84/app/uploads/purchase_order/delivery_order_items/${item.photo}">
                                    Lihat Foto
                            </button>`
                            : '-';

                        tbody.append(`
                            <tr>
                                <td><input type="checkbox" name="items[${i}][checked]" value="1" ${isChecked}></td>
                                <td>${i+1}</td>
                                <td>${item.item_code || '-'}</td>
                                <td>
                                    ${item.itemname || '-'}
                                    <input type="hidden" name="items[${i}][ingredientsid]" value="${item.itemid}">
                                    <input type="hidden" name="items[${i}][doitemid]" value="${item.id}">
                                </td>
                                <td>
                                    <input type="number" name="items[${i}][qty]" value="${item.qty || 0}" 
                                        class="form-control form-control-sm" style="width:80px;" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[${i}][actualqty]" 
                                        value="${item.qty || 0}" 
                                        class="form-control form-control-sm" style="width:80px;" ${actualQtyDisabled}>
                                </td>
                                <td>${qtyToUomDisplay}
                                    <input type="hidden" name="items[${i}][stockinqty]" value="${item.qtytouom || item.qty}">
                                </td>
                                <td>${photoHtml}</td>
                                <td>${item.description || '-'}</td>
                                <td>
                                    <input type="text" name="items[${i}][notes]" class="form-control form-control-sm" 
                                        value="${item.notes || ''}" ${item.status == 1 ? 'disabled' : ''}>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    tbody.append(`<tr><td colspan="10" class="text-center">No items found</td></tr>`);
                }

                $("body").append(`
                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Foto Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="photoPreview" src="" class="img-fluid" alt="Item Photo">
                        </div>
                        </div>
                    </div>
                    </div>
                    `);

                // Upload / view documents
                if(res.status == 0) $("#uploadDocumentsSection").show();
                if(res.bk_attachment && res.vendor_invoice){
                    $("#viewDocumentsSection").show();
                    $("#docFrames").html(`
                        <h5>BK Document</h5>
                        <iframe src="<?= base_url('app/uploads/purchase_order/') ?>${res.bk_attachment}"></iframe>
                        <h5>Vendor Invoice</h5>
                        <iframe src="<?= base_url('app/uploads/purchase_order/') ?>${res.vendor_invoice}"></iframe>
                    `);
                    if(res.status == 1) $("#requestFinanceSection").show();
                }

                // Disable jika semua item checked atau status = 1
                disableFormIfCompleted(res);
            },
            error: function(xhr){
                console.error(xhr.responseText);
                Swal.fire('Error','Gagal load data PO','error');
                location.reload();
            }
        });
    }

    // function disableFormIfCompleted(res){
    //     var allChecked = res.items.every(item => item.status == 1);
    //     if(allChecked || res.status == 1){
    //         $("#formStockIn button[type=submit]").prop("disabled", true);
    //         $("#tbl-po-items input[type=checkbox]").prop("disabled", true);
    //         $("#tbl-po-items input[name*='notes']").prop("disabled", true);
    //         $("#tbl-po-items input[name*='[qty]']").prop("disabled", true); 
    //         $("#po_additional_notes").prop("disabled", true);
    //     }
    // }

    $(document).on("click", "[data-target='#photoModal']", function(){
        let src = $(this).data("src");
        $("#photoPreview").attr("src", src);
    });
    
    function disableFormIfCompleted(res){
        var allChecked = res.items.every(item => item.status == 1);

        if(allChecked || res.status == 0){
            $("#formStockIn button[type=submit]").prop("disabled", true);
            $("#btnStockInAll").prop("disabled", true);
            $("#tbl-po-items input[type=checkbox]").prop("disabled", true);
            $("#tbl-po-items input[name*='notes']").prop("disabled", true);
            $("#tbl-po-items input[name*='[qty]']").prop("disabled", true);
            $("#po_additional_notes").prop("disabled", true);

            // Jangan disable tombol foto
            $("#tbl-po-items button[data-target='#photoModal']").prop("disabled", false);

            // Override kalau masih ada item pending
            var hasPendingItem = res.items.some(item => item.status == 0);
            if(hasPendingItem){
                $("#formStockIn button[type=submit]").prop("disabled", false);
                $("#btnStockInAll").prop("disabled", false);
            }
        }
    }

    // Submit StockIn pakai FormData
    $("#formStockIn").off("submit").on("submit", function(e){
    e.preventDefault();

    let checkedItems = $("#tbl-po-items input[type=checkbox]:checked:not(:disabled)");
    if(checkedItems.length === 0){
        Swal.fire('Peringatan','Pilih minimal 1 item untuk disimpan','warning');
        return;
    }

    let valid = true;
    let message = "";

    checkedItems.each(function(){
        let row = $(this).closest("tr");
        let orderQty = parseFloat(row.find("input[name*='[qty]']").val()) || 0;
        let actualQty = parseFloat(row.find("input[name*='[actualqty]']").val()) || 0;

        if(actualQty <= 0){
            valid = false;
            message = "Input Actual Qty belum terisi";
            return false; // stop loop
        }
        if(orderQty !== actualQty){
            valid = false;
            message = "Order Qty dan Actual Qty belum sesuai";
            return false; // stop loop
        }
    });

    if(!valid){
        Swal.fire('Peringatan', message, 'warning');
        return;
    }

    // kalau lolos validasi → kirim
    let formData = new FormData(this);
    $.ajax({
        url: "<?= site_url('ControllerPurchasing/saveStockInDummy') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(){
                $("#formStockIn button[type=submit], #btnStockInAll").prop("disabled", true);
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire('Sukses', res.message, 'success').then(()=>{
                        window.location.href = res.redirect_url || "<?= base_url('ControllerPurchasing') ?>";
                    });
                } else {
                    Swal.fire('Error', res.message || 'Gagal menyimpan', 'error');
                }
            },
            error: function(err){
                console.error(err);
                Swal.fire('Error','Terjadi kesalahan saat menyimpan StockIn Dummy','error');
            }
        });
    });


    // Upload documents
    $("form[action*='uploadDocumentsPurchaseOrder']").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: this.action,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res){
                if(res.status){
                    Swal.fire('Sukses', res.message, 'success').then(()=> location.reload());
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function(xhr){
                console.error(xhr.responseText);
                Swal.fire('Error','Terjadi kesalahan saat upload file','error');
            }
        });
    });

});
</script>



</body>
</html>
