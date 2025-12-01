<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eudora - Edit Purchase Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .mycontaine { font-size: 12px !important; }
    .mycontaine * { font-size: inherit !important; }
    .form-label { font-size: 14px; font-weight: bold; display: block; }
    .select2-container { width: 100% !important; }
    #collapse { text-decoration: none !important; background: #fff; }
  </style>
</head>
<body>
<div class="mycontaine p-4">
  <div class="card p-4">
    <h6 class="text-secondary text-center mb-4" style="font-weight:bold;text-transform:uppercase;">
      <i class="bi bi-wallet2"></i> EDIT PURCHASE ORDER
    </h6>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Date</label>
        <input type="text" class="form-control" id="orderdate" value="<?= date('Y-m-d') ?>" readonly>
      </div>
      <div class="col-md-6">
        <label class="form-label">Name (Employee)</label>
        <select id="employeeid" class="form-control"></select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Purchase Request</label>
        <select id="purchaserequestid" class="form-control"></select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Supplier</label>
        <select id="supplierid" class="form-control"></select>
      </div>
      <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea id="notes" class="form-control" readonly></textarea>
      </div>
    </div>
  </div>

  <!-- PR Details Card -->
  <div class="card mt-4" id="prDetailsCard" style="display:none;">
    <div class="p-3">
      <h6 class="text-secondary mb-3"><i class="bi bi-info-circle"></i> Purchase Request Details</h6>
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="tbl-pr-details">
          <tbody>
            <tr><th>Request Number</th><td id="pr_requestnumber">-</td></tr>
            <tr><th>Company</th><td id="pr_company">-</td></tr>
            <tr><th>Department</th><td id="pr_department">-</td></tr>
            <tr><th>Requester</th><td id="pr_requester">-</td></tr>
            <tr><th>Request Date</th><td id="pr_requestdate">-</td></tr>
            <tr><th>Notes</th><td id="pr_notes">-</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Items Table -->
  <div class="card mt-4" id="itemsCard" style="display:none;">
    <div class="p-3">
      <h6 class="text-secondary mb-3"><i class="bi bi-box"></i> Request Items</h6>
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="tbl-items">
          <thead>
            <tr>
               <th>Checklist</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit</th> <!-- kolom baru -->
                <th>Unit*UOM</th> <!-- kolom baru -->
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Description</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <button class="btn btn-primary" onclick="savePurchaseOrder()">Update Purchase Order</button>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
$(document).ready(function() {
    const purchaseOrderId = "<?= isset($id) ? $id : '' ?>";

    // === Fungsi format & parse angka ===
    function formatRupiah(value) {
      if (isNaN(value) || value === null) return "Rp 0";
      
      // Hilangkan nol di belakang koma, tapi tetap tampilkan desimal jika ada
      let cleaned = parseFloat(value).toString();
      
      // Format angka dengan pemisah ribuan, tetap mempertahankan desimal (kalau ada)
      let parts = cleaned.split(".");
      let integerPart = parts[0];
      let decimalPart = parts[1] ? parts[1].replace(/0+$/, "") : "";

      let formatted = parseInt(integerPart).toLocaleString("id-ID");

      if (decimalPart && decimalPart.length > 0) {
          formatted += "," + decimalPart;
      }

      return "Rp " + formatted;
  }

    function parseRupiah(str) {
        if (!str) return 0;
        return parseFloat(str.replace(/[^0-9,-]+/g, "").replace(",", ".")) || 0;
    }

    function initSelect2(selector, placeholder, url, mapFn) {
        return $(selector).select2({
            placeholder: placeholder,
            minimumInputLength: 2,
            ajax: {
                url: url,
                dataType: "json",
                delay: 250,
                processResults: data => ({ results: data.map(mapFn) })
            }
        });
    }

    const $employeeSelect = initSelect2(
        '#employeeid',
        "Select Employee (Orderer)",
        "<?= base_url('ControllerPurchasing/getPurchaseOrderOrderers') ?>",
        e => ({ id: e.ordererid, text: e.orderer_name })
    );

    const $supplierSelect = initSelect2(
        '#supplierid',
        "Select Supplier",
        "<?= base_url('ControllerPurchasing/searchSuppliers') ?>",
        s => ({ id: s.id, text: s.name })
    );

    const $prSelect = initSelect2(
        '#purchaserequestid',
        "Select Purchase Request",
        "<?= base_url('ControllerPurchasing/getAllPurchaseRequest') ?>",
        r => ({ id: r.id, text: r.requestnumber })
    );

    // === Load PO jika ada ID ===
    if (purchaseOrderId) {
        $.getJSON("<?= base_url('ControllerPurchasing/getPurchaseOrderById/') ?>" + purchaseOrderId, function(data) {
            if (!data) return;

            if (data.purchaserequestid && data.requestnumber) {
                const opt = new Option(data.requestnumber, data.purchaserequestid, true, true);
                $prSelect.append(opt).trigger('change');
            }
            if (data.ordererid && data.orderer_name) {
                const opt = new Option(data.orderer_name, data.ordererid, true, true);
                $employeeSelect.append(opt).trigger('change');
            }
            if (data.supplierid && data.supplier_name) {
                const opt = new Option(data.supplier_name, data.supplierid, true, true);
                $supplierSelect.append(opt).trigger('change');
            }

            $("#orderdate").val(data.orderdate);
            $("#notes").val(data.notes || "");
            loadItems(data.items || []);

            $("#pr_requestnumber").text(data.requestnumber || "-");
            $("#pr_company").text(data.companyname || "-");
            $("#pr_department").text(data.department_name || "-");
            $("#pr_requester").text(data.requester_name || "-");
            $("#pr_requestdate").text(data.requestdate || "-");
            $("#pr_notes").text(data.notes || "-");
            $("#prDetailsCard, #itemsCard").show();
        });
    }

    // === Load Items ===
    function loadItems(items) {
        const tbody = $("#tbl-items tbody").empty();

        items.forEach(item => {
            const isDisabled = item.isDisabled || false;
            const checkboxAttr = isDisabled ? "disabled" : "";
            const unitName = item.unit_name || "-";
            const unitAlternativeName = item.alternativeunitid && item.alternativeunitname
                ? item.alternativeunitname
                : unitName;

            const row = $(`
                <tr data-itemid="${item.itemid}" 
                    data-qty="${item.qty}" 
                    data-desc="${item.description || ''}" 
                    data-name="${item.itemname}" 
                    data-pri_id="${item.pri_id}"
                    data-poi_id="${item.poi_id}"
                    class="${isDisabled ? 'table-secondary' : ''}">
                
                    <td class="text-center">
                        <input type="checkbox" class="chk-item" ${checkboxAttr} checked>
                    </td>

                    <td>
                        <select class="form-control item-select" ${isDisabled ? 'disabled' : ''}></select>
                    </td>

                    <td>
                        <input type="number" class="form-control qty" value="${item.qty}" ${isDisabled ? 'disabled' : ''}>
                    </td>

                    <td>
                        <input type="text" class="form-control unitname" value="${unitAlternativeName}" readonly disabled>
                    </td>

                    <td style="text-align:center; display:flex; gap:5px; align-items:center;">
                        <input type="number" class="form-control unitqtytouom" value="${item.alternativeunitid ? item.qty * item.qtytouom : 1}" readonly>
                        <input type="hidden" class="form-control unitqtytouom2" value="${item.qtytouom || 1}">
                        <span>${unitName}</span>
                    </td>

                    <td>
                        <input type="text" class="form-control item_price" value="${formatRupiah(item.fixed_price)}" ${isDisabled ? 'disabled' : ''}>
                    </td>

                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control discount" ${isDisabled ? 'disabled' : ''}>
                                    <option value="persen" ${item.discount_type === 'persen' ? 'selected' : ''}>%</option>
                                    <option value="nominal" ${item.discount_type === 'nominal' ? 'selected' : ''}>Rp</option> 
                                </select>
                            </div>
                            <div class="col-md-8">
                                <input type="number" class="form-control discount_value" value="${item.discount_value || 0}" ${isDisabled ? 'disabled' : ''}>
                            </div>
                        </div>
                    </td>

                    <td>
                        <input type="text" class="form-control total" value="${formatRupiah(item.total_price)}" readonly>
                    </td>

                    <td>
                        <textarea class="form-control description" ${isDisabled ? 'disabled' : ''}>${item.description || ''}</textarea>
                    </td>
                </tr>
            `);

            tbody.append(row);

            // Inisialisasi select2 item
            const itemSelect = row.find(".item-select");
            if (!isDisabled) {
                itemSelect.select2({
                    placeholder: "Select Item",
                    ajax: {
                        url: "<?= base_url('ControllerPurchasing/searchItems') ?>",
                        dataType: "json",
                        delay: 250,
                        data: params => ({ search: params.term }),
                        processResults: data => ({ results: data }),
                        cache: true
                    }
                });

                if (item.itemid) {
                    const option = new Option(item.itemname, item.itemid, true, true);
                    itemSelect.append(option).trigger('change');
                }
            } else {
                itemSelect.append(new Option(item.itemname, item.itemid, true, true));
            }

            const qtyInput = row.find(".qty");
            const priceInput = row.find(".item_price");
            const discountInput = row.find(".discount_value");
            const discountTypeSelect = row.find(".discount");
            const totalInput = row.find(".total");

            function updateTotal() {
                const qty = parseFloat(qtyInput.val()) || 0;
                const price = parseRupiah(priceInput.val());
                const discount = parseFloat(discountInput.val()) || 0;
                const discountType = discountTypeSelect.val();

                let subtotal = qty * price;
                let total = subtotal;

                if (discountType === "persen") {
                    total -= subtotal * (discount / 100);
                } else {
                    total -= discount;
                }

                if (total < 0) total = 0;

                totalInput.val(formatRupiah(total));
            }

            // Format input price saat user mengetik
            priceInput.on("input", function() {
                const raw = parseRupiah($(this).val());
                $(this).val(formatRupiah(raw));
                updateTotal();
            });

            qtyInput.on("input", updateTotal);
            discountInput.on("input", updateTotal);
            discountTypeSelect.on("change", updateTotal);

            updateTotal();
        });
    }

    // === Simpan Purchase Order ===
    window.savePurchaseOrder = function() {
        const poData = {
            purchaseorderid: purchaseOrderId,
            orderdate: $("#orderdate").val(),
            employeeid: $("#employeeid").val(),
            requestid: $("#purchaserequestid").val(),
            supplierid: $("#supplierid").val(),
            notes: $("#notes").val(),
            items: []
        };

        $("#tbl-items tbody tr").each(function() {
            const $row = $(this);
            if ($row.find(".chk-item").is(":checked")) {
                poData.items.push({
                    poi_id: $row.attr("data-poi_id") || null,
                    itemid: $row.attr("data-itemid"),
                    itemname: $row.attr("data-name"),
                    qty: parseFloat($row.find(".qty").val()) || 0,
                    fixed_price: parseRupiah($row.find(".item_price").val()),
                    discount_amount: parseFloat($row.find(".discount_value").val()) || 0,
                    discount_type: $row.find(".discount").val(),
                    description: $row.find(".description").val(),
                    total_price: parseRupiah($row.find(".total").val()),
                    purchaserequestitemid: $row.attr("data-pri_id")
                });
            }
        });

        if (poData.items.length === 0) {
            swal("Peringatan", "Lengkapi form dan pilih minimal 1 item!", "warning");
            return;
        }

        swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menyimpan Purchase Order ini?",
            icon: "warning",
            buttons: {
                cancel: { text: "Batal", visible: true, className: "btn btn-danger", closeModal: true },
                confirm: { text: "Ya, Simpan", value: true, visible: true, className: "btn btn-success", closeModal: false }
            }
        }).then(isConfirm => {
            if (isConfirm) {
                $.ajax({
                    url: "<?= base_url('ControllerPurchasing/updatePurchaseOrder') ?>",
                    type: "POST",
                    data: JSON.stringify(poData),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(res) {
                        if (res.status) {
                            swal("Berhasil!", res.msg, "success");
                            location.reload();
                        } else {
                            swal("Gagal!", "Gagal simpan PO: " + (res.db_error ? JSON.stringify(res.db_error) : res.msg), "error");
                        }
                    },
                    error: function(xhr) {
                        console.error("Save PO Error:", xhr.responseText);
                        swal("Error", "Terjadi kesalahan saat simpan PO.\n" + xhr.responseText, "error");
                    }
                });
            }
        });
    };

    // === Generate PDF ===
    window.generatePurchaseOrderPDF = function(po_ids) {
        if (Array.isArray(po_ids)) {
            po_ids.forEach(poid => window.open("<?= base_url('ControllerPurchasing/generatePurchaseOrderPDF/') ?>"+poid, "_blank"));
        } else {
            window.open("<?= base_url('ControllerPurchasing/generatePurchaseOrderPDF/') ?>"+po_ids, "_blank");
        }
    };
});
</script>

</body>
</html>
