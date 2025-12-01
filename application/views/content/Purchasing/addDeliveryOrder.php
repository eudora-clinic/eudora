<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eudora - Purchase Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <style>
    .mycontaine { 
        font-size: 12px !important; 
    }
    .mycontaine * { 
        font-size: inherit !important; 
    }
    .form-label { 
        font-size: 14px; 
        font-weight: bold; 
        display: block; 
    }
    .select2-container { 
        width: 100% !important; 
    }
    #collapse { 
        text-decoration: none !important; 
        background: #fff;
    }

  </style>
</head>
<body>
<div class="mycontaine p-4">
  <div class="card p-4">
    <h6 class="text-secondary text-center mb-4" style="font-weight:bold;text-transform:uppercase;">
      <i class="bi bi-wallet2"></i> PURCHASE ORDER
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
      <div class="col-md-6">
        <label class="form-label">Notes</label>
        <textarea id="notes" class="form-control"></textarea>
      </div>
      <div class="col-md-12">
        <label class="form-label">Attachment</label>
        <textarea id="notes" class="form-control"></textarea>
      </div>

      
    </div>
  </div>

  <div class="card mt-4" id="prDetailsCard" style="display:none;">
  <div class="p-3">
    <h6 class="text-secondary mb-3"><i class="bi bi-info-circle"></i> Purchase Request Details</h6>
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="tbl-pr-details">
        <tbody>
          <tr>
            <th>Request Number</th><td id="pr_requestnumber">-</td>
          </tr>
          <tr>
            <th>Company</th><td id="pr_company">-</td>
          </tr>
          <tr>
            <th>Department</th><td id="pr_department">-</td>
          </tr>
          <tr>
            <th>Warehouse</th><td id="pr_warehouse">-</td>
          </tr>
          <tr>
            <th>Requester</th><td id="pr_requester">-</td>
          </tr>
          <tr>
            <th>Request Date</th><td id="pr_requestdate">-</td>
          </tr>
          <tr>
            <th>Notes</th><td id="pr_notes">-</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Table Item (sembunyi dulu) -->
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
    <button class="btn btn-primary" onclick="savePurchaseOrder()">Create Purchase Order</button>
  </div>

  <div id="groupedPOContainer" class="mt-4"></div>

</div>

<script>
$(document).ready(function() {
    $('#employeeid').select2({
        placeholder: "Select Employee",
        minimumInputLength: 2,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/getEmployees') ?>",
            dataType: "json",
            delay: 250,
            processResults: data => ({
                results: data.map(e => ({ id: e.id, text: e.text }))
            })
        }
    });

    $('#supplierid').select2({
        placeholder: "Select Supplier",
        minimumInputLength: 2,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/searchSalesSuppliers') ?>",
            dataType: "json",
            delay: 250,
            data: params => ({
                q: params.term // ini penting agar input pencarian dikirim sebagai `q`
            }),
            processResults: data => ({
                results: data.map(s => ({ id: s.id, text: s.name }))
            })
        }
    });

    const $prSelect = $('#purchaserequestid');

    $prSelect.select2({
        placeholder: "Select Purchase Request",
        minimumInputLength: 2,
        ajax: {
            url: "<?= base_url('ControllerPurchasing/getAllPurchaseRequest') ?>",
            dataType: "json",
            delay: 250,
            processResults: data => ({
                results: data.map(r => ({ id: r.id, text: r.requestnumber }))
            })
        }
    }).on("select2:select", function(e) {
        loadRequestItems(e.params.data.id);
    });

    const purchaseRequestId = "<?= isset($id) ? $id : '' ?>";
    if (purchaseRequestId) {
        $.getJSON("<?= base_url('ControllerPurchasing/getPurchaseRequestById/') ?>" + purchaseRequestId, function(data) {
            if (data) {
                const opt = new Option(data.requestnumber, data.id, true, true);
                $prSelect.append(opt).trigger("change");
                loadRequestItems(data.id);
            }
        });
    }
  
function loadRequestItems(requestId) {
    $.ajax({
        url: "<?= base_url('ControllerPurchasing/getPurchaseRequestById/') ?>" + requestId,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (!data) return;

            // ---- Update PR Details ----
            $("#pr_requestnumber").text(data.requestnumber || "-");
            $("#pr_company").text(data.company_name || "-");
            $("#pr_department").text(data.department_name || "-");
            $("#pr_warehouse").text(data.warehouse_name || "-");
            $("#pr_requester").text(data.requester_name || "-");
            $("#pr_requestdate").text(data.requestdate || "-");
            $("#pr_notes").text(data.notes || "-");

            // ---- Show cards ----
            $("#prDetailsCard").show();
            $("#itemsCard").show();

            // ---- Load items ----
            const tbody = $("#tbl-items tbody");
            tbody.empty();

            data.items.forEach(item => {
                // cek status item
                const isDisabled = item.status == 2; // jika 1 -> disable

                const row = $(`
                    <tr data-itemid="${item.itemid}" 
                        data-qty="${item.qty}" 
                        data-desc="${item.description || ''}" 
                        data-name="${item.itemname}" 
                        data-pri_id="${item.pri_id}"
                        class="${isDisabled ? 'table-secondary' : ''}">
                
                        <td class="text-center">
                            <input type="checkbox" class="chk-item" ${isDisabled ? 'disabled' : ''}>
                        </td>

                        <td>
                            <select class="form-control item-select" ${isDisabled ? 'disabled' : ''}></select>
                        </td>

                        <td>
                            <input type="number" class="form-control qty" value="${item.qty}" ${isDisabled ? 'disabled' : ''}>
                        </td>

                        <td>
                            <input type="number" class="form-control item_price" value="${item.item_unit_price}" ${isDisabled ? 'disabled' : ''}>
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
                            <input type="text" 
                                class="form-control total" 
                                value="${((item.qty * item.item_unit_price) - (item.discount_value || 0)).toFixed(2)}" 
                                readonly>
                        </td>

                        <td>
                            <textarea class="form-control description" ${isDisabled ? 'disabled' : ''}>${item.description || ''}</textarea>
                        </td>
                    </tr>
                `);

                tbody.append(row);

                // inisialisasi select2 hanya kalau tidak disable
                if (!isDisabled) {
                    const itemSelect = row.find(".item-select");
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
                    // kalau disable tapi ada nama item, langsung tampilkan tanpa select2
                    const itemSelect = row.find(".item-select");
                    itemSelect.append(new Option(item.itemname, item.itemid, true, true));
                }
            });

            bindRowCalculations();
        },
        error: function(err) {
            console.error(err);
            swal("Error", "Gagal load Purchase Request.", "error");
        }
    });
}


    function bindRowCalculations() {
        $("#tbl-items tbody tr").each(function() {
            const qtyInput       = $(this).find('.qty')[0];
            const priceInput     = $(this).find('.item_price')[0];
            const totalInput     = $(this).find('.total')[0];
            const discountType   = $(this).find('.discount')[0];
            const discountValue  = $(this).find('.discount_value')[0];

            const updateTotal = () => {
                const qty   = parseFloat(qtyInput.value)   || 0;
                const price = parseFloat(priceInput.value) || 0;
                const subtotal = qty * price;

                let discount = 0;
                if (discountType && discountValue) {
                    const val = parseFloat(discountValue.value) || 0;
                    if (discountType.value === "persen") {
                        discount = subtotal * (val / 100);
                    } else if (discountType.value === "nominal") {
                        discount = val;
                    }
                }

                let total = subtotal - discount;
                if (total < 0) total = 0;
                totalInput.value = total.toFixed(2);
            };

            qtyInput.addEventListener('input', updateTotal);
            priceInput.addEventListener('input', updateTotal);
            if (discountType)  discountType.addEventListener('change', updateTotal);
            if (discountValue) discountValue.addEventListener('input', updateTotal);

            updateTotal();
        });
    }
    window.savePurchaseOrder = function() {
        const orderdate = $("#orderdate").val();
        const ordererid = $("#employeeid").val();
        const purchaserequestid = $("#purchaserequestid").val();
        const notes = $("#notes").val();
        const supplierid = $("#supplierid").val();
        const status_pembayaran = $("#status_pembayaran").val();

        const items = [];
        $("#tbl-items tbody tr").each(function() {
            if ($(this).find(".chk-item").is(":checked")) {
                items.push({
                    itemid: $(this).attr("data-itemid"),
                    itemname: $(this).attr("data-name"),
                    createdby: $(this).attr("data-name"),
                    qty: $(this).find(".qty").val(),
                    item_price: $(this).find(".item_price").val(),
                    description: $(this).find(".description").val(),
                    purchaserequestitemid: $(this).attr("data-pri_id")
                });
            }
        });

        if (!orderdate || !ordererid || !purchaserequestid || !supplierid || items.length === 0) {
            swal("Peringatan", "Lengkapi semua data header (Tanggal, Employee, Supplier, Request) dan pilih minimal 1 item!", "warning");
            return;
        }

        const poData = { orderdate, ordererid, purchaserequestid, supplierid, status_pembayaran, notes, items };

        swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menyimpan Purchase Order ini?",
            icon: "warning",
            buttons: {
                cancel: { text: "Batal", visible: true, className: "btn btn-danger", closeModal: true },
                confirm: { text: "Ya, Simpan", value: true, visible: true, className: "btn btn-success", closeModal: false }
            }
        }).then((isConfirm) => {
            if (isConfirm) {
                $.ajax({
                    url: "<?= base_url('ControllerPurchasing/savePurchaseOrder') ?>",
                    type: "POST",
                    data: JSON.stringify(poData),
                    contentType: "application/json",
                    dataType: "json",
                    success: function(res) {
                        if (res.status) {
                            swal("Berhasil!", res.msg, "success").then(() => generatePurchaseOrderPDF(res.po_ids));
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

    function renderGroupedPO(po_ids) {
        $.ajax({
            url: "<?= base_url('ControllerPurchasing/grouppedPurchaseOrder') ?>",
            type: "POST",
            data: { po_ids: po_ids },
            dataType: "json",
            success: function(data) {
                let html = `<div class="panel-group" id="accordionPO">`;

                data.forEach((po, index) => {
                    html += `
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordionPO" href="#collapse${index}" style="text-decoration:none;">
                                        PO #${po.poid} - ${po.requestnumber}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse${index}" class="panel-collapse collapse ${index === 0 ? 'in' : ''}">
                                <div class="panel-body">
                                    <p><strong>Company:</strong> ${po.company_name}</p>
                                    <p><strong>Requester:</strong> ${po.requester_name}</p>
                                    <p><strong>Request Date:</strong> ${po.requesterdate}</p>
                                    <p><strong>Status:</strong> ${po.status}</p>
                                    <table class="table table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Qty</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;
                        po.items.forEach(item => {
                            html += `
                                                <tr>
                                                <td>${item.item_code}</td>
                                                <td>${item.itemname}</td>
                                                <td>${item.qty}</td>
                                                <td>${item.description}</td>
                                            </tr>`;
                    });
                    html += `
                                        </tbody>
                                    </table>
                                    <button class="btn btn-danger btn-xs" onclick="generatePDF(${po.poid})">Generate PDF</button>
                                </div>
                            </div>
                        </div>`;
                });

                html += `</div>`;
                $("#groupedPOContainer").html(html);
            }
        });
    }

    window.generatePDF = function(poid) {
        window.open("<?= base_url('ControllerPurchasing/generatePurchaseOrderPDF/') ?>" + poid, "_blank");
    };
});
</script>



</body>
</html>
