<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Purchase Order</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->

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
                    <label class="form-label">Pembayaran</label>
                    <select class="form-control" id="status_pembayaran" id="">
                        <option value="">===== PILIH METODE PEMBAYARAN =====</option>
                        <option value="0">Cash</option>
                        <option value="1">Tempo 15 Hari</option>
                        <option value="2">Tempo 30 Hari</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Notes</label>
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
                                <th>Request Number</th>
                                <td id="pr_requestnumber">-</td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td id="pr_company">-</td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td id="pr_department">-</td>
                            </tr>
                            <tr>
                                <th>Warehouse</th>
                                <td id="pr_warehouse">-</td>
                            </tr>
                            <tr>
                                <th>Requester</th>
                                <td id="pr_requester">-</td>
                            </tr>
                            <tr>
                                <th>Request Date</th>
                                <td id="pr_requestdate">-</td>
                            </tr>
                            <tr>
                                <th>Notes</th>
                                <td id="pr_notes">-</td>
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

        <!-- <div class="card p-4">
    <h6 class="text-secondary text-left mb-4" style="font-weight:bold;text-transform:uppercase;">
      <i class="bi bi-wallet2"></i> Notes
      
      
    </h6>
    <div class="form-group">
        <textarea name="" id="purchasingNotes" class="form-control" row="20"></textarea>
      </div>
    <span>* if reject a purchase request</span>
  </div> -->

        <div class="mt-4">
            <button class="btn btn-primary" onclick="savePurchaseOrder()">Create Purchase Order</button>
            <!-- <button class="btn btn-primary" onclick="rejectPurchaseRequest()">Rejected</button> -->
        </div>

        <div id="groupedPOContainer" class="mt-4"></div>

    </div>

    <script>
        $(document).ready(function () {

            $('#employeeid').select2({
                placeholder: "Select Employee",
                minimumInputLength: 2,
                ajax: {
                    url: "<?= base_url('ControllerPurchasing/getEmployees') ?>",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(e => ({ id: e.id, text: e.text }))
                        };
                    }
                }
            });

            // langsung set default ID 1863
            let option = new Option("Agus Tri Sarbowo", 1863, true, true);
            // 👆 ganti "Employee 1863" dengan nama sebenarnya dari DB
            $('#employeeid').append(option).trigger('change');

            $('#supplierid').select2({
                placeholder: "Select Supplier",
                minimumInputLength: 2,
                ajax: {
                    url: "<?= base_url('ControllerPurchasing/searchSalesSuppliers') ?>",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        let results = data.map(s => ({ id: s.id, text: s.name }));
                        results.unshift({ id: 999, text: "E-COMMERCE" });
                        return { results };
                    }
                }
            });

            $('#supplierid').val(null).trigger('change.select2');


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
            }).on("select2:select", function (e) {
                loadRequestItems(e.params.data.id);
            });

            const purchaseRequestId = "<?= isset($id) ? $id : '' ?>";
            if (purchaseRequestId) {
                $.getJSON("<?= base_url('ControllerPurchasing/getPurchaseRequestById/') ?>" + purchaseRequestId, function (data) {
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
                    success: function (data) {
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

                        const totalItems = data.items.length;
                        const allDisabled = totalItems === 0; // ✅ jika hanya 1 item, semua kolom disabled

                        data.items.forEach(item => {
                            const isDisabled = item.status == 1 || allDisabled;

                            // unit default
                            let unitName = item.unit_name || "-";
                            let unitQtyToUom = item.qtytouom || 1;
                            let unitAlternativeName = item.alternativeunitid && item.alternativeunitname
                                ? item.alternativeunitname
                                : unitName;

                            // checkbox attr
                            let checkboxAttr = isDisabled ? "checked disabled" : "";

                            const row = $(`
                    <tr data-itemid="${item.itemid}" 
                        data-qty="${item.qty}" 
                        data-desc="${item.description || ''}" 
                        data-name="${item.itemname}" 
                        data-pri_id="${item.pri_id}"
                        class="${isDisabled ? 'table-secondary' : ''}">
                    
                        <td class="text-center">
                            <input type="checkbox" class="chk-item" ${checkboxAttr}>
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
                                value="${((item.qty * item.item_unit_price * unitQtyToUom) - (item.discount_value || 0)).toFixed(2)}" 
                                readonly>
                        </td>

                        <td>
                            <textarea class="form-control description" ${isDisabled ? 'disabled' : ''}>${item.description || ''}</textarea>
                        </td>
                    </tr>
                `);

                            tbody.append(row);

                            // initialize select2
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
                                // tetap tampilkan nama item
                                itemSelect.append(new Option(item.itemname, item.itemid, true, true));
                            }

                            const qtyInput = row.find(".qty");
                            const priceInput = row.find(".item_price");
                            const discountInput = row.find(".discount_value");
                            const discountTypeSelect = row.find(".discount");
                            const totalInput = row.find(".total");
                            const unitQtyInput = row.find(".unitqtytouom");

                            function updateTotal() {
                                let qty = parseFloat(qtyInput.val()) || 0;
                                let price = parseFloat(priceInput.val()) || 0;
                                let discountValue = parseFloat(discountInput.val()) || 0;
                                let discountType = discountTypeSelect.val(); // ambil jenis diskon

                                // Hitung konversi satuan (jika ada alternative unit)
                                let qtyToUom = (item.alternativeunitid && item.qtytouom) ? qty * item.qtytouom : qty;
                                unitQtyInput.val(qtyToUom); // update nilai qty terkonversi

                                // Hitung subtotal
                                let subtotal = price * qtyToUom;

                                // Hitung total berdasarkan jenis diskon
                                let total;
                                if (discountType === "persen") {
                                    total = subtotal - (subtotal * (discountValue / 100));
                                } else {
                                    total = subtotal - discountValue;
                                }

                                // Pastikan total tidak negatif
                                if (total < 0) total = 0;

                                // Format total ke Rupiah
                                let formattedTotal = total.toLocaleString("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 20
                                });
                                totalInput.val(formattedTotal);
                            }

                            // Event listeners
                            qtyInput.on("input", updateTotal);
                            priceInput.on("input", updateTotal);
                            discountInput.on("input", updateTotal);
                            discountTypeSelect.on("change", updateTotal); // tambah event untuk ubah jenis diskon

                            // Jalankan update pertama kali supaya nilai langsung sesuai
                            updateTotal();
                        });

                        bindRowCalculations();
                    },

                    error: function (err) {
                        console.error(err);
                        Swal.fire("Error", "Gagal load Purchase Request.", "error");
                    }
                });
            }

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function parseNumber(num) {
                return parseFloat(num.replace(/\./g, "")) || 0;
            }

            function parseRupiah(str) {
                if (!str) return 0;
                str = str.replace(/\s| |\u00A0/g, "");
                str = str.replace(/[^0-9.,]/g, "");
                if (str.includes(",") && str.includes(".")) {
                    str = str.replace(/\./g, "").replace(",", ".");
                } else if (str.includes(",") && !str.includes(".")) {
                    str = str.replace(",", ".");
                } else if (str.includes(".") && !str.includes(",")) {
                    const parts = str.split(".");
                    if (parts[parts.length - 1].length === 3) {
                        str = str.replace(/\./g, "");
                    }
                }
                return parseFloat(str) || 0;
            }

            window.savePurchaseOrder = function () {
                const orderdate = $("#orderdate").val();
                const ordererid = $("#employeeid").val();
                const purchaserequestid = $("#purchaserequestid").val();
                const notes = $("#notes").val();
                const supplierid = $("#supplierid").val();
                const status_pembayaran = $("#status_pembayaran").val();

                const items = [];
                $("#tbl-items tbody tr").each(function () {
                    if ($(this).find(".chk-item").is(":checked")) {
                        // ambil nilai input
                        let qty = parseFloat($(this).find(".qty").val()) || 0;
                        let totalStr = $(this).find(".total").val() || "0";
                        let fixedPriceStr = $(this).find(".item_price").val() || "0";

                        console.log(totalStr, fixedPriceStr);

                        let totalNumeric = parseRupiah(totalStr);
                        let fixedPriceNumeric = parseRupiah(fixedPriceStr);
                        let discountValue = parseFloat($(this).find(".discount_value").val()) || 0;
                        let discountType = $(this).find(".discount").val();

                        console.log(totalNumeric, fixedPriceNumeric);

                        items.push({
                            itemid: $(this).attr("data-itemid"),
                            itemname: $(this).attr("data-name"),
                            createdby: $(this).attr("data-name"),
                            qty: qty,
                            total_price: totalNumeric,
                            fixed_price: fixedPriceNumeric,
                            discount_type: discountType,
                            discount_value: discountValue,
                            description: $(this).find(".description").val(),
                            purchaserequestitemid: $(this).attr("data-pri_id")
                        });
                    }
                });

                if (!orderdate || !ordererid || !purchaserequestid || !supplierid) {
                    alert("⚠️ Lengkapi semua data header (Tanggal, Employee, Supplier, Request)!");
                    return;
                }

                if (items.length === 0) {
                    alert("⚠️ Pilih minimal 1 item untuk membuat Purchase Order!");
                    return;
                }

                const poData = {
                    orderdate,
                    ordererid,
                    purchaserequestid,
                    supplierid,
                    status_pembayaran,
                    notes,
                    items
                };

                console.log(poData);


                if (confirm("Apakah Anda yakin ingin menyimpan Purchase Order ini?")) {
                    $.ajax({
                        url: "<?= base_url('ControllerPurchasing/savePurchaseOrder') ?>",
                        type: "POST",
                        data: JSON.stringify(poData),
                        contentType: "application/json",
                        dataType: "json",
                        success: function (res) {
                            if (res.status) {
                                alert("✅ Berhasil! " + res.msg);
                                window.location.href = "https://sys.eudoraclinic.com:84/app/purchaseOrderList";
                            } else {
                                alert("Gagal! " + (res.msg ? res.msg : "Gagal simpan PO"));
                            }
                        },
                        error: function (xhr) {
                            console.error("Save PO Error:", xhr.responseText);
                            alert("🚨 Error: Terjadi kesalahan saat simpan PO.\n" + xhr.responseText);
                        }
                    });
                }
            };


            function renderGroupedPO(po_ids) {
                $.ajax({
                    url: "<?= base_url('ControllerPurchasing/grouppedPurchaseOrder') ?>",
                    type: "POST",
                    data: { po_ids: po_ids },
                    dataType: "json",
                    success: function (data) {
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

            window.generatePDF = function (poid) {
                window.open("<?= base_url('ControllerPurchasing/generatePurchaseOrderPDF/') ?>" + poid, "_blank");
            };
        });
    </script>


</body>

</html>