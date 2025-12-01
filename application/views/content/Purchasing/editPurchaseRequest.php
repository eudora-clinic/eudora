<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Purchase Request</title>

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
  </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<body>
  <div class="mycontaine">
    <div class="mt-2" id="role-information">
      <div class="card p-4">
        <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
          <i class="bi bi-wallet2"></i> Edit Purchase Request
        </h6>
        <div class="form-row">
          <div class="form-column">
            <label class="form-label mt-2"><strong>DATE</strong><span class="text-danger">*</span></label>
            <input type="date" name="requestdate" id="requestdate">
            <label class="form-label mt-2"><strong>CODE:</strong><span class="text-danger">*</span></label>
            <input type="text" name="code" id="code" placeholder="#AUTO" disabled>
            <label class="form-label mt-2"><strong>ISSUED BY:</strong></label>
            <select id="requesterid" name="requesterid" class="form-control"></select>
          </div>
          <div class="form-column">
            <label class="form-label mt-2"><strong>WAREHOUSE:</strong></label>
            <select id="warehouseid" name="warehouseid" class="form-control"></select>

            <label class="form-label mt-2"><strong>COMPANY:</strong><span class="text-danger">*</span></label>
            <select id="companyid" name="companyid" class="form-control" required></select>

            <label class="form-label mt-2"><strong>NOTES:</strong></label>
            <textarea name="notes" id="notes" rows="6" cols="50"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card p-4">
    <div class="form-column">
      <label for="form-label mt-2"><strong>PURCHASING NOTES</strong></label>
      <div id="extraNotes"></div>
    </div>
  </div>

  <!-- Items Table -->
  <div class="table-wrapper product-table-wrapper card">
    <div class="p-4">
      <div class="items mt-2">
        <h6 class="text-secondary mb-2 mt-2"><i class="bi bi-wallet2"></i> ITEMS</h6>
        <table id="tbl-items" class="table table-bordered items-list">
          <thead class="bg-thead">
            <tr>
              <th style="font-size: 12px; text-align: center;">ITEM</th>
              <th style="font-size: 12px; text-align: center;">UNIT</th>
              <th style="font-size: 12px; text-align: center;">QTY</th>
              <th style="font-size: 12px; text-align: center;">UNIT UOM * QTY</th>
              <th style="font-size: 12px; text-align: center;">DESCRIPTION</th>
              <th style="font-size: 12px; text-align: center;">IMAGES</th>
              <th style="font-size: 12px; text-align: center;">ACTION</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <button class="btn btn-primary btn-sm add-items">
          <i class="bi bi-plus-circle"></i> + ITEMS
        </button>
      </div>
    </div>
  </div>

  <div id="ajaxModalContainer"></div>

  <div class="modal fade" id="previewImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Preview Images</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body d-flex flex-wrap gap-2 justify-content-start" id="previewImageContainer"></div>
      </div>
    </div>
  </div>



  <!-- Buttons -->
  <div class="row p-4 gap-4">
    <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(1)">SAVE AS DRAFT</button>
    <!-- <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(2)">APPROVE</button> -->
    <a href="<?= base_url('purchaseRequestList') ?>" class="btn btn-secondary mb-4">CANCEL</a>
  </div>


  <!-- <script>
const baseUrl = "<?= base_url(); ?>";
const urlParts = window.location.pathname.split("/");
const id = urlParts[urlParts.length - 1];
let requestStatus = 0; // simpan status request dari API

$(document).ready(function () {

    function initSelect2(selector, url, placeholder) {
        $(selector).select2({
            placeholder: placeholder,
            minimumInputLength: 2,
            ajax: {
                url: url,
                dataType: "json",
                delay: 250,
                processResults: data => ({
                    results: data.map(e => ({ id: e.id, text: e.text }))
                })
            }
        });
    }

    initSelect2('#companyid', baseUrl + "ControllerPurchasing/getCompanies", "Select Company");
    initSelect2('#warehouseid', baseUrl + "ControllerPurchasing/getWarehouses", "Select Warehouse");
    initSelect2('#requesterid', baseUrl + "ControllerPurchasing/getEmployees", "Select Employee");

    $.ajax({
        url: baseUrl + "ControllerPurchasing/getPurchaseRequestById/" + id,
        type: "GET",
        dataType: "json",
        success: function (res) {
            if (!res) return;

            requestStatus = Number(res.status) || 0;

            $('#requestdate').val(res.requestdate);
            $('#code').val(res.requestnumber);
            $('#notes').val(res.notes);
            $('#requesterid').val(res.requesterid);

            if (res.companyid && res.company_name) {
                let option = new Option(res.company_name, res.companyid, true, true);
                $('#companyid').append(option).trigger('change');
            }

            if (res.warehouseid && res.warehouse_name) {
                let option = new Option(res.warehouse_name, res.warehouseid, true, true);
                $('#warehouseid').append(option).trigger('change');
            }

            if (res.requesterid && res.requester_name) {
                let option = new Option(res.requester_name, res.requesterid, true, true);
                $('#requesterid').append(option).trigger('change');
            }

            let rows = "";
            if (res.items && res.items.length > 0) {
                res.items.forEach(item => {
                    rows += `
                        <tr>
                            <td>
                                <select class="form-control item-select" style="width:250px;" ${requestStatus === 5 ? "disabled" : ""}>
                                    <option value="${item.itemid}" selected>${item.itemname}</option>
                                </select>
                            </td>
                            <td class="text-center align-middle">
                                <select class="form-control unititemsid" style="width:100%">
                                <optgroup label="Default"></optgroup>
                                <optgroup label="Alternative"></optgroup>
                                </select>
                            </td>
                            <input type="hidden" class="form-control pri_id" value="${item.pri_id}">
                            <td><input type="number" class="form-control qty" value="${item.qty}" min="1"></td>
                            <td><input type="text" class="form-control description" value="${item.description}" ${requestStatus === 5 ? "disabled" : ""}></td>
                            <td><button class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    `;
                });
            }
            $('#tbl-items tbody').html(rows);

            $('.item-select').select2({
                placeholder: "Select Item",
                minimumInputLength: 2,
                ajax: {
                    url: baseUrl + "ControllerPurchasing/searchItems",
                    dataType: "json",
                    delay: 250,
                    processResults: data => ({
                        results: data.map(e => ({ id: e.id, text: e.text }))
                    })
                }
            });

            if (requestStatus === 5) {
                $('#requestdate').prop('disabled', true);
                $('#companyid').prop('disabled', true);
                $('#warehouseid').prop('disabled', true);
                $('#requesterid').prop('disabled', true);
                $('#notes').prop('disabled', true);
            }
        }
    });

    $('.add-items').on('click', function (e) {
        e.preventDefault();
        let newRow = `
            <tr>
                <td>
                    <select class="form-control item-select" style="width:250px;" ${requestStatus === 5 ? "disabled" : ""}></select>
                </td>
                <td><input type="number" class="form-control qty" value="1" min="1"></td>
                <td><input type="text" class="form-control description" placeholder="Description" ${requestStatus === 5 ? "disabled" : ""}></td>
                <td><button class="btn btn-danger btn-sm delete-row">Delete</button></td>
            </tr>
        `;
        $('#tbl-items tbody').append(newRow);

        $('#tbl-items tbody tr:last .item-select').select2({
            placeholder: "Select Item",
            minimumInputLength: 2,
            ajax: {
                url: baseUrl + "ControllerPurchasing/searchItems",
                dataType: "json",
                delay: 250,
                processResults: data => ({
                    results: data.map(e => ({ id: e.id, text: e.text }))
                })
            }
        });
    });

    $(document).on('click', '.delete-row', function () {
        $(this).closest('tr').remove();
    });

});

function saveStockOut(status) {
    let items = [];
    $('#tbl-items tbody tr').each(function () {
        const itemid = $(this).find('.item-select').val();
        if (!itemid) return; 
        items.push({
            pri_id :$(this).find('.pri_id').val(),
            itemid: itemid,
            qty: $(this).find('.qty').val() || 0,
            description: $(this).find('.description').val() || ''
        });
    });

    const data = {
        id: id,
        requestdate: $('#requestdate').val(),
        requesterid: $('#requesterid').val(),
        warehouseid: $('#warehouseid').val(),
        companyid: $('#companyid').val(),
        notes: $('#notes').val(),
        status: status,
        items: items
    };

    $.ajax({
        url: baseUrl + "ControllerPurchasing/updatePurchaseRequest",
        type: "POST",
        data: JSON.stringify(data),
        contentType: "application/json",
        dataType: "json",
        success: function (res) {
            if (res.status === "success") {
                swal("Success!", "Purchase Request updated successfully!", "success");
                location.reload();
            } else {
                alert("Update failed: " + res.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            alert("Error updating data!");
        }
    });
}
</script> -->

  <!-- <script>
  document.addEventListener("DOMContentLoaded", function () {
    const baseUrl = "<?= base_url(); ?>";
    const urlParts = window.location.pathname.split("/");
    const id = urlParts[urlParts.length - 1];

    // --- Helpers
    function initSelect2($el, placeholder, url) {
      $el.select2({
        placeholder: placeholder,
        allowClear: true,
        width: "100%",
        ajax: {
          url: url,
          dataType: "json",
          delay: 250,
          data: function (params) { return { search: params.term || "" }; },
          processResults: function (data) {
            return {
              results: data.map(function (item) {
                return { id: item.id, text: item.text };
              })
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });
    }

    function forceNumber(v, fallback = 0) {
      const n = Number(v);
      return Number.isFinite(n) ? n : fallback;
    }

    // --- Init Select2 master fields
    initSelect2($("#companyid"), "SELECT COMPANY", baseUrl + "ControllerPurchasing/getCompanies");
    initSelect2($("#warehouseid"), "SELECT WAREHOUSE", baseUrl + "ControllerPurchasing/getWarehouses");
    initSelect2($("#requesterid"), "SELECT EMPLOYEE", baseUrl + "ControllerPurchasing/getEmployees");

    // --- Function render row item
    function renderItemRow(item = {}) {
      const { itemid = "", itemname = "", pri_id = "", qty = 1, description = "", unitid = "", alternativeunitid = "" } = item;

      const rowHtml = `
        <tr>
          <td class="text-center align-middle">
            <select class="form-control itemsid" style="width:100%">
              ${itemid ? `<option value="${itemid}" selected>${itemname}</option>` : ""}
            </select>
          </td>
          <td class="text-center align-middle">
            <select class="form-control unititemsid" style="width:100%">
              <optgroup label="Default"></optgroup>
              <optgroup label="Alternative"></optgroup>
            </select>
          </td>
          <td class="text-center align-middle" style="min-width:110px">
            <input type="number" class="form-control qty" value="${qty}" min="1">
          </td>
          <td class="text-center align-middle" style="min-width:220px">
            <div class="input-group">
              <input type="number" class="form-control unitqtytouom" readonly>
              <span class="input-group-text unitname"></span>
            </div>
          </td>
          <td class="text-center align-middle" style="min-width:180px">
            <textarea class="form-control description" rows="1">${description}</textarea>
          </td>
          <td class="text-center align-middle">
            <button class="btn btn-danger btn-sm remove-items">DELETE</button>
          </td>
          <input type="hidden" class="pri_id" value="${pri_id}">
        </tr>
      `;
      $("#tbl-items tbody").append(rowHtml);

      const $lastRow = $("#tbl-items tbody tr:last");
      const $itemSelect = $lastRow.find(".itemsid");
      const $unitSelect = $lastRow.find(".unititemsid");
      const $qtyInput = $lastRow.find(".qty");
      const $unitqtytouom = $lastRow.find(".unitqtytouom");
      const $unitName = $lastRow.find(".unitname");

      // Init select2 item
      $itemSelect.select2({
        placeholder: "Pilih Item",
        allowClear: true,
        width: "100%",
        ajax: {
          url: baseUrl + "ControllerPurchasing/searchItems",
          dataType: "json",
          delay: 250,
          data: function (params) { return { search: params.term }; },
          processResults: function (data) {
            return {
              results: data.map(item => ({ id: item.id, text: item.text }))
            };
          },
          cache: true
        },
        minimumInputLength: 2
      });

      // kalau ada itemid dari edit, langsung load unitnya
      if (itemid) {
        loadUnits(itemid, $unitSelect, $qtyInput, $unitqtytouom, $unitName, unitid, alternativeunitid);
      }

      // Event item select → load unit
      $itemSelect.on("select2:select", function (e) {
        const itemId = e.params.data.id;
        loadUnits(itemId, $unitSelect, $qtyInput, $unitqtytouom, $unitName);
      });

      // Delete row
      $lastRow.find(".remove-items").on("click", function () {
      const pri_id = $lastRow.find(".pri_id").val();

      if (pri_id) {
        if (confirm("Yakin ingin menghapus item ini?")) {
          $.ajax({
            url: <?= base_url('ControllerPurchasing/deletePurchaseRequestItem/') ?> + pri_id,
            type: "POST",
            dataType: "json",
            success: function(res) {
              if (res.status === "success") {
                alert("Item berhasil dihapus!");
                $lastRow.remove();
              } else {
                alert(res.message || "Gagal menghapus item!");
              }
            },
            error: function() {
              alert("Terjadi kesalahan server!");
            }
          });
        }
      } else {
        // kalau item baru (belum ada pri_id), cukup hapus row di UI saja
        if (confirm("Yakin ingin menghapus item ini?")) {
          $lastRow.remove();
        }
      }
    });
    }

    // --- Load units for item
    function loadUnits(itemId, $unitSelect, $qtyInput, $unitqtytouom, $unitName, selectedUnitid = null, selectedAlternativeid = null) {
      $unitSelect.find("optgroup[label='Default']").empty();
      $unitSelect.find("optgroup[label='Alternative']").empty();
      $unitSelect.removeData("default-unitid").removeData("default-unitname");
      $unitqtytouom.val('');
      $unitName.text('');

      $.ajax({
        url: baseUrl + "ControllerPurchasing/getAlternativeUnit/" + itemId,
        type: "GET",
        dataType: "json",
        success: function (response) {
          const q = forceNumber($qtyInput.val(), 1);
          const defaultUnit = Array.isArray(response) ? response.find(u => u.is_default) : null;

          if (defaultUnit) {
            $unitSelect
              .data("default-unitid", defaultUnit.unitid)
              .data("default-unitname", defaultUnit.unit_name);

            const $defaultOpt = $('<option>', {
              value: defaultUnit.unitid,
              text: defaultUnit.unit_name + " (Default)",
              'data-qty': 1,
              'data-type': 'default'
            });

            if (!selectedAlternativeid && selectedUnitid === defaultUnit.unitid) {
              $defaultOpt.prop("selected", true);
              $unitqtytouom.val(q);
              $unitName.text(defaultUnit.unit_name);
            }

            $unitSelect.find("optgroup[label='Default']").append($defaultOpt);
          }

          // Alternatif
          (Array.isArray(response) ? response.filter(u => !u.is_default) : []).forEach(function (unit) {
            const $altOpt = $('<option>', {
              value: unit.id,
              text: unit.unit_name,
              'data-qty': unit.quantity,
              'data-type': 'alternative',
              'data-unitid': unit.unitid
            });

            if (selectedAlternativeid && selectedAlternativeid == unit.id) {
              $altOpt.prop("selected", true);
              $unitqtytouom.val(q * unit.quantity);
              $unitName.text(defaultUnit ? defaultUnit.unit_name : '');
            }

            $unitSelect.find("optgroup[label='Alternative']").append($altOpt);
          });

          // Event saat ganti unit
          $unitSelect.off("change").on("change", function () {
            const $sel = $(this).find(":selected");
            const q = forceNumber($qtyInput.val(), 1);

            if ($sel.data("type") === "alternative") {
              const altQty = forceNumber($sel.data("qty"), 1);
              $unitqtytouom.val(q * altQty);
              $unitName.text($unitSelect.data("default-unitname") || '');
            } else {
              $unitqtytouom.val(q);
              $unitName.text($unitSelect.data("default-unitname") || '');
            }
          });
          $qtyInput.off("input").on("input", function () {
            const $sel = $unitSelect.find(":selected");
            const q = forceNumber($(this).val(), 1);

            if ($sel.data("type") === "alternative") {
              const altQty = forceNumber($sel.data("qty"), 1);
              $unitqtytouom.val(q * altQty);
            } else {
              $unitqtytouom.val(q);
            }
          });
        }
      });
    }

    if (!isNaN(id) && id > 0) {
      $.ajax({
        url: baseUrl + "ControllerPurchasing/getPurchaseRequestById/" + id,
        type: "GET",
        dataType: "json",
        success: function (res) {
          if (!res) return;

          $("#requestdate").val(res.requestdate);
          $("#code").val(res.requestnumber);
          $("#notes").val(res.notes);

          if (res.companyid && res.company_name) {
            let option = new Option(res.company_name, res.companyid, true, true);
            $("#companyid").append(option).trigger("change");
          }
          if (res.warehouseid && res.warehouse_name) {
            let option = new Option(res.warehouse_name, res.warehouseid, true, true);
            $("#warehouseid").append(option).trigger("change");
          }
          if (res.requesterid && res.requester_name) {
            let option = new Option(res.requester_name, res.requesterid, true, true);
            $("#requesterid").append(option).trigger("change");
          }

          // render items
          if (res.items && res.items.length > 0) {
            res.items.forEach(it => {
              renderItemRow(it);
            });
          }
          if (res.status == 5) {
              const noteHtml = `
              <div class="form-group mt-3" id="purchasingNotesWrapper">
                  <textarea class="form-control" id="purchasing_notes" rows="3" readonly>${res.purchasing_notes || ''}</textarea>
              </div>
              `;
              $("#extraNotes").html(noteHtml);
          }
        }
      });
    }

    $(".add-items").on("click", function () {
      renderItemRow();
    });

    window.saveStockOut = function (status) {
      const requestdate = $("#requestdate").val();
      const requesterid = $("#requesterid").val();
      const companyid = $("#companyid").val();
      const warehouseid = $("#warehouseid").val();
      const notes = $("#notes").val();

      if (!requestdate || !requesterid || !companyid) {
        swal("Peringatan", "Silakan lengkapi informasi General!", "warning");
        return false;
      }

      const itemList = [];
      $("#tbl-items tbody tr").each(function () {
        const $row = $(this);
        const itemid = $row.find(".itemsid").val();
        const $unitSelectEl = $row.find(".unititemsid");
        const $selectedOpt = $unitSelectEl.find("option:selected");
        const qty = $row.find(".qty").val();
        const description = $row.find(".description").val();
        const unitqtytouom = $row.find(".unitqtytouom").val();
        const pri_id = $row.find(".pri_id").val();

        if (!itemid) return;

        const unitType = $selectedOpt.data("type") || "default";
        const defaultUnitId = $unitSelectEl.data("default-unitid") || null;

        let unitid = null;
        let alternativeunitid = null;

        if (unitType === "alternative") {
          unitid = defaultUnitId;
          alternativeunitid = $selectedOpt.val();
        } else {
          unitid = $selectedOpt.val();
          alternativeunitid = null;
        }

        itemList.push({ pri_id, itemid, unitid, qty, unitqtytouom, description, alternativeunitid });
      });

      if (itemList.length === 0) {
        swal("Peringatan", "Silakan tambahkan minimal 1 item!", "warning");
        return false;
      }

      const payload = {
        id: id > 0 ? id : null,
        requestdate,
        requesterid,
        companyid,
        warehouseid,
        notes,
        items: itemList
      };

      const endpoint = id > 0
        ? baseUrl + "ControllerPurchasing/updatePurchaseRequest"
        : baseUrl + "ControllerPurchasing/savePurchaseRequest";

      $.ajax({
        url: endpoint,
        type: "POST",
        data: JSON.stringify(payload),
        contentType: "application/json",
        dataType: "json",
        success: function (res) {
          if (res.status === "success") {
            swal("Sukses", "Data berhasil disimpan!", "success").then(() => {
              window.location.href = baseUrl + "purchaseRequestList";
            });
          } else {
            swal("Error", res.message || "Gagal menyimpan data", "error");
          }
        },
        error: function () {
          swal("Error", "Terjadi kesalahan server!", "error");
        }
      });
    };
  });
</script> -->

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const baseUrl = "<?= base_url(); ?>";
      const urlParts = window.location.pathname.split("/");
      const id = parseInt(urlParts[urlParts.length - 1]) || 0;

      // --- Helpers
      function initSelect2($el, placeholder, url) {
        $el.select2({
          placeholder: placeholder,
          allowClear: true,
          width: "100%",
          ajax: {
            url: url,
            dataType: "json",
            delay: 250,
            data: params => ({ search: params.term || "" }),
            processResults: data => ({
              results: data.map(item => ({ id: item.id, text: item.text }))
            }),
            cache: true
          },
          minimumInputLength: 2
        });
      }

      function forceNumber(v, fallback = 0) {
        const n = Number(v);
        return Number.isFinite(n) ? n : fallback;
      }

      // --- Init Select2 master fields
      initSelect2($("#companyid"), "SELECT COMPANY", baseUrl + "ControllerPurchasing/getCompanies");
      initSelect2($("#warehouseid"), "SELECT WAREHOUSE", baseUrl + "ControllerPurchasing/getWarehouses");
      initSelect2($("#requesterid"), "SELECT EMPLOYEE", baseUrl + "ControllerPurchasing/getEmployees");

      let imageData = {};

      // --- Function render row item
      function renderItemRow(item = {}) {
        const {
          itemid = "",
          itemname = "",
          pri_id = "",
          qty = 1,
          description = "",
          unitid = "",
          alternativeunitid = "",
          images = [],
        } = item;

        // --- Kondisi tombol
        let imageButtons = "";
        if (pri_id) {
          // Jika ada pri_id
          imageButtons = `
            <button type="button" class="btn btn-sm btn-info upload-images me-1" data-priid="${pri_id}">
              <i class="bi bi-image"></i> Images
            </button>
          `;

          // Jika sudah ada images
          if (images.length > 0) {
            imageButtons += `
            <button type="button" class="btn btn-secondary btn-sm preview-images-only" data-images='${JSON.stringify(images)}'>
              <i class="bi bi-eye"></i> Preview (${images.length})
            </button>
          `;
          }
        }

        const rowHtml = `
    <tr>
      <td class="text-center align-middle">
        <select class="form-control itemsid" style="width:100%">
          ${itemid ? `<option value="${itemid}" selected>${itemname}</option>` : ""}
        </select>
      </td>
      <td class="text-center align-middle">
        <select class="form-control unititemsid" style="width:100%">
          <optgroup label="Default"></optgroup>
          <optgroup label="Alternative"></optgroup>
        </select>
      </td>
      <td class="text-center align-middle" style="min-width:110px">
        <input type="number" class="form-control qty" value="${qty}" min="1">
      </td>
      <td class="text-center align-middle" style="min-width:220px">
        <div class="input-group">
          <input type="number" class="form-control unitqtytouom" readonly>
          <span class="input-group-text unitname"></span>
        </div>
      </td>
      <td class="text-center align-middle" style="min-width:180px">
        <textarea class="form-control description" rows="1">${description}</textarea>
      </td>
      <td class="text-center align-middle" style="min-width:200px">
        ${imageButtons || ""}
      </td>
      <td class="text-center align-middle">
        <button class="btn btn-danger btn-sm remove-items">DELETE</button>
      </td>
      <input type="hidden" class="pri_id" value="${pri_id}">
    </tr>
  `;

        $("#tbl-items tbody").append(rowHtml);

        const $lastRow = $("#tbl-items tbody tr:last");
        const $itemSelect = $lastRow.find(".itemsid");
        const $unitSelect = $lastRow.find(".unititemsid");
        const $qtyInput = $lastRow.find(".qty");
        const $unitqtytouom = $lastRow.find(".unitqtytouom");
        const $unitName = $lastRow.find(".unitname");

        // --- Init Select2 untuk item
        $itemSelect.select2({
          placeholder: "Pilih Item",
          allowClear: true,
          width: "100%",
          ajax: {
            url: baseUrl + "ControllerPurchasing/searchItems",
            dataType: "json",
            delay: 250,
            data: params => ({ search: params.term }),
            processResults: data => ({
              results: data.map(item => ({ id: item.id, text: item.text })),
            }),
            cache: true,
          },
          minimumInputLength: 2,
        });

        // --- Jika item sudah ada, load unit-nya
        if (itemid) {
          loadUnits(itemid, $unitSelect, $qtyInput, $unitqtytouom, $unitName, unitid, alternativeunitid);
        }

        $itemSelect.on("select2:select", function (e) {
          loadUnits(e.params.data.id, $unitSelect, $qtyInput, $unitqtytouom, $unitName);
        });

        // --- Event delete row
        $lastRow.find(".remove-items").on("click", function () {
          const pri_id = $lastRow.find(".pri_id").val();

          if (pri_id) {
            if (confirm("Yakin ingin menghapus item ini?")) {
              $.ajax({
                url: baseUrl + "ControllerPurchasing/deletePurchaseRequestItem/" + pri_id,
                type: "POST",
                dataType: "json",
                success: function (res) {
                  if (res.status === "success") {
                    alert("Item berhasil dihapus!");
                    $lastRow.remove();
                  } else {
                    alert(res.message || "Gagal menghapus item!");
                  }
                },
                error: function () {
                  alert("Terjadi kesalahan server!");
                },
              });
            }
          } else {
            if (confirm("Yakin ingin menghapus item ini?")) {
              $lastRow.remove();
            }
          }
        });

        // --- Event preview images
        $lastRow.find(".preview-images").on("click", function () {
          const pri_id = $(this).data("priid");

          $.ajax({
            url: baseUrl + "PurchaseRequestItemImages/getImagesByItem/" + pri_id,
            type: "GET",
            dataType: "json",
            success: function (res) {
              if (res.status && res.images.length) {
                let imgHtml = "";
                res.images.forEach(img => {
                  imgHtml += `<img src="${baseUrl + img.image_path}" class="img-thumbnail m-1" style="width:120px;height:120px;object-fit:cover;">`;
                });

                const modalHtml = `
            <div class="modal fade" id="previewModal" tabindex="-1">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Preview Images</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body d-flex flex-wrap justify-content-start">
                    ${imgHtml}
                  </div>
                </div>
              </div>
            </div>
          `;

                $("#ajaxModalContainer").html(modalHtml);
                const modal = new bootstrap.Modal(document.getElementById("previewModal"));
                modal.show();
              } else {
                swal("Info", "Tidak ada gambar untuk item ini", "info");
              }
            },
            error: function () {
              swal("Error", "Gagal mengambil gambar dari server", "error");
            },
          });
        });
      }


      $(document).on("click", ".upload-images", function () {
        const $row = $(this).closest("tr");
        const itemId = $row.find(".itemsid").val();
        const priid = $(this).data("priid");

        if (!itemId) {
          swal("Peringatan", "Pilih item terlebih dahulu sebelum menambahkan gambar!", "warning");
          return;
        }

        const modalHtml = `
    <div class="modal fade" id="imageUploadModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <form id="formLampiran" enctype="multipart/form-data">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Upload Images</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="priid_update" value="${priid}">
              <input type="file" id="imagesInput" class="form-control mb-3" multiple>
              <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>`;

        $("#ajaxModalContainer").html(modalHtml);
        const modal = new bootstrap.Modal(document.getElementById("imageUploadModal"));
        modal.show();

        const container = $("#previewContainer");
        container.html("");

        // tampilkan gambar sebelumnya
        if (imageData[itemId]) {
          imageData[itemId].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
              container.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
            };
            reader.readAsDataURL(file);
          });
        }

        $(document).off("change", "#imagesInput").on("change", "#imagesInput", function () {
          const files = Array.from(this.files);
          if (!imageData[itemId]) imageData[itemId] = [];
          imageData[itemId].push(...files);

          container.html("");
          imageData[itemId].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
              container.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
            };
            reader.readAsDataURL(file);
          });

          $row.find(".upload-images")
            .removeClass("btn-info")
            .addClass("btn-secondary")
            .html('<i class="bi bi-eye"></i> Preview Images');
        });

        $(document).off("submit", "#formLampiran").on("submit", "#formLampiran", function (e) {
          e.preventDefault();

          const formData = new FormData(this);
          const files = imageData[itemId] || [];
          files.forEach((file, idx) => {
            formData.append('images[]', file);
          });

          $.ajax({
            url: '<?= base_url("ControllerPurchasing/uploadPrItemImageUpdate") ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (res) {
              if (res.status) {
                swal("Berhasil", "Gambar berhasil diupload!", "success");
                modal.hide();
              } else {
                swal("Gagal", res.message, "error");
              }
            },
            error: function (err) {
              swal("Gagal", "Terjadi kesalahan server", "error");
            }
          });
        });

      });

      // --- Load units
      // function loadUnits(itemId, $unitSelect, $qtyInput, $unitqtytouom, $unitName, selectedUnitid = null, selectedAlternativeid = null) {
      //   $unitSelect.find("optgroup[label='Default']").empty();
      //   $unitSelect.find("optgroup[label='Alternative']").empty();
      //   $unitSelect.removeData("default-unitid").removeData("default-unitname");
      //   $unitqtytouom.val('');
      //   $unitName.text('');

      //   $.ajax({
      //     url: baseUrl + "ControllerPurchasing/getAlternativeUnit/" + itemId,
      //     type: "GET",
      //     dataType: "json",
      //     success: function (response) {
      //       const q = forceNumber($qtyInput.val(), 1);
      //       const defaultUnit = Array.isArray(response) ? response.find(u => u.is_default) : null;

      //       if (defaultUnit) {
      //         $unitSelect
      //           .data("default-unitid", defaultUnit.unitid)
      //           .data("default-unitname", defaultUnit.unit_name);

      //         const $defaultOpt = $('<option>', {
      //           value: defaultUnit.unitid,
      //           text: defaultUnit.unit_name + " (Default)",
      //           'data-qty': 1,
      //           'data-type': 'default'
      //         });

      //         if (!selectedAlternativeid && selectedUnitid === defaultUnit.unitid) {
      //           $defaultOpt.prop("selected", true);
      //           $unitqtytouom.val(q);
      //           $unitName.text(defaultUnit.unit_name);
      //         }

      //         $unitSelect.find("optgroup[label='Default']").append($defaultOpt);
      //       }

      //       (Array.isArray(response) ? response.filter(u => !u.is_default) : []).forEach(function (unit) {
      //         const $altOpt = $('<option>', {
      //           value: unit.id,
      //           text: unit.unit_name,
      //           'data-qty': unit.quantity,
      //           'data-type': 'alternative',
      //           'data-unitid': unit.unitid
      //         });

      //         if (selectedAlternativeid && selectedAlternativeid == unit.id) {
      //           $altOpt.prop("selected", true);
      //           $unitqtytouom.val(q * unit.quantity);
      //           $unitName.text(defaultUnit ? defaultUnit.unit_name : '');
      //         }

      //         $unitSelect.find("optgroup[label='Alternative']").append($altOpt);
      //       });

      //       $unitSelect.off("change").on("change", function () {
      //         const $sel = $(this).find(":selected");
      //         const q = forceNumber($qtyInput.val(), 1);

      //         if ($sel.data("type") === "alternative") {
      //           $unitqtytouom.val(q * forceNumber($sel.data("qty"), 1));
      //           $unitName.text($unitSelect.data("default-unitname") || '');
      //         } else {
      //           $unitqtytouom.val(q);
      //           $unitName.text($unitSelect.data("default-unitname") || '');
      //         }
      //       });

      //       $qtyInput.off("input").on("input", function () {
      //         const $sel = $unitSelect.find(":selected");
      //         const q = forceNumber($(this).val(), 1);

      //         if ($sel.data("type") === "alternative") {
      //           $unitqtytouom.val(q * forceNumber($sel.data("qty"), 1));
      //         } else {
      //           $unitqtytouom.val(q);
      //         }
      //       });
      //     }
      //   });
      // }

      function loadUnits(itemId, $unitSelect, $qtyInput, $unitqtytouom, $unitName, selectedUnitid = null, selectedAlternativeid = null) {
        $unitSelect.find("optgroup[label='Default']").empty();
        $unitSelect.find("optgroup[label='Alternative']").empty();
        $unitSelect.removeData("default-unitid").removeData("default-unitname");
        $unitqtytouom.val('');
        $unitName.text('');

        $.ajax({
          url: baseUrl + "ControllerPurchasing/getAlternativeUnit/" + itemId,
          type: "GET",
          dataType: "json",
          success: function (response) {
            const q = forceNumber($qtyInput.val(), 1);
            const defaultUnit = Array.isArray(response) ? response.find(u => u.is_default) : null;

            if (defaultUnit) {
              $unitSelect
                .data("default-unitid", defaultUnit.unitid)
                .data("default-unitname", defaultUnit.unit_name);

              const $defaultOpt = $('<option>', {
                value: defaultUnit.unitid,
                text: defaultUnit.unit_name + " (Default)",
                'data-qty': 1,
                'data-type': 'default'
              });

              if (!selectedAlternativeid && selectedUnitid === defaultUnit.unitid) {
                $defaultOpt.prop("selected", true);
                $unitqtytouom.val(q);
                $unitName.text(defaultUnit.unit_name);
              }

              $unitSelect.find("optgroup[label='Default']").append($defaultOpt);
            }

            (Array.isArray(response) ? response.filter(u => !u.is_default) : []).forEach(function (unit) {
              const $altOpt = $('<option>', {
                value: unit.id,
                text: unit.unit_name,
                'data-qty': unit.quantity,
                'data-type': 'alternative',
                'data-unitid': unit.unitid
              });

              if (selectedAlternativeid && selectedAlternativeid == unit.id) {
                $altOpt.prop("selected", true);
                $unitqtytouom.val(q * unit.quantity);
                $unitName.text(defaultUnit ? defaultUnit.unit_name : '');
              }

              $unitSelect.find("optgroup[label='Alternative']").append($altOpt);
            });

            // simpan pilihan awal
            const selectedOpt = $unitSelect.find(":selected");
            if (selectedOpt.length > 0) {
              if (selectedOpt.data("type") === "alternative") {
                $unitSelect.attr("data-current-unitid", selectedOpt.data("unitid"));
                $unitSelect.attr("data-current-alternativeid", selectedOpt.val());
              } else {
                $unitSelect.attr("data-current-unitid", selectedOpt.val());
                $unitSelect.attr("data-current-alternativeid", "");
              }
            }

            // saat user ganti unit
            $unitSelect.off("change").on("change", function () {
              const $sel = $(this).find(":selected");
              const q = forceNumber($qtyInput.val(), 1);

              if ($sel.data("type") === "alternative") {
                $unitqtytouom.val(q * forceNumber($sel.data("qty"), 1));
                $unitName.text($unitSelect.data("default-unitname") || '');
                $(this).attr("data-current-unitid", $sel.data("unitid"));
                $(this).attr("data-current-alternativeid", $sel.val());
              } else {
                $unitqtytouom.val(q);
                $unitName.text($unitSelect.data("default-unitname") || '');
                $(this).attr("data-current-unitid", $sel.val());
                $(this).attr("data-current-alternativeid", "");
              }
            });

            $qtyInput.off("input").on("input", function () {
              const $sel = $unitSelect.find(":selected");
              const q = forceNumber($(this).val(), 1);

              if ($sel.data("type") === "alternative") {
                $unitqtytouom.val(q * forceNumber($sel.data("qty"), 1));
              } else {
                $unitqtytouom.val(q);
              }
            });
          }
        });
      }


      // --- Load data kalau edit
      if (id > 0) {
        $.ajax({
          url: baseUrl + "ControllerPurchasing/getPurchaseRequestById/" + id,
          type: "GET",
          dataType: "json",
          success: function (res) {
            if (!res) return;

            $("#requestdate").val(res.requestdate);
            $("#code").val(res.requestnumber);
            $("#notes").val(res.notes);

            if (res.companyid && res.company_name) {
              let option = new Option(res.company_name, res.companyid, true, true);
              $("#companyid").append(option).trigger("change");
            }
            if (res.warehouseid && res.warehouse_name) {
              let option = new Option(res.warehouse_name, res.warehouseid, true, true);
              $("#warehouseid").append(option).trigger("change");
            }
            if (res.requesterid && res.requester_name) {
              let option = new Option(res.requester_name, res.requesterid, true, true);
              $("#requesterid").append(option).trigger("change");
            }

            if (res.items && res.items.length > 0) {
              res.items.forEach(it => renderItemRow(it));
            }

            if (res.status == 5) {
              $("#extraNotes").html(`
              <div class="form-group mt-3" id="purchasingNotesWrapper">
                <textarea class="form-control" id="purchasing_notes" rows="3" readonly>${res.purchasing_notes || ''}</textarea>
              </div>
            `);
            }
          }
        });
      }

      $(".add-items").on("click", function () {
        renderItemRow();
      });

      // --- Save
      window.saveStockOut = function (status) {
        const requestdate = $("#requestdate").val();
        const requesterid = $("#requesterid").val();
        const companyid = $("#companyid").val();
        const warehouseid = $("#warehouseid").val();
        const notes = $("#notes").val();

        if (!requestdate || !requesterid || !companyid) {
          swal("Peringatan", "Silakan lengkapi informasi General!", "warning");
          return false;
        }

        const itemList = [];
        $("#tbl-items tbody tr").each(function () {
          const $row = $(this);
          const itemid = $row.find(".itemsid").val();
          const $unitSelectEl = $row.find(".unititemsid");
          const qty = $row.find(".qty").val();
          const description = $row.find(".description").val();
          const unitqtytouom = $row.find(".unitqtytouom").val();
          const pri_id = $row.find(".pri_id").val();

          if (!itemid) return;

          const unitid = $unitSelectEl.attr("data-current-unitid") || null;
          const alternativeunitid = $unitSelectEl.attr("data-current-alternativeid") || null;

          itemList.push({ pri_id, itemid, unitid, qty, unitqtytouom, description, alternativeunitid });
        });

        if (itemList.length === 0) {
          swal("Peringatan", "Silakan tambahkan minimal 1 item!", "warning");
          return false;
        }

        const payload = {
          id: id > 0 ? id : null,
          requestdate,
          requesterid,
          companyid,
          warehouseid,
          notes,
          items: itemList
        };

        const endpoint = id > 0
          ? baseUrl + "ControllerPurchasing/updatePurchaseRequest"
          : baseUrl + "ControllerPurchasing/savePurchaseRequest";

        $.ajax({
          url: endpoint,
          type: "POST",
          data: JSON.stringify(payload),
          contentType: "application/json",
          dataType: "json",
          success: function (res) {
            if (res.status === "success") {
              swal("Sukses", "Data berhasil disimpan!", "success").then(() => {
                window.location.href = res.redirect;
              });
            } else {
              swal("Error", res.message || "Gagal menyimpan data", "error");
            }
          },
          error: function () {
            swal("Error", "Terjadi kesalahan server!", "error");
          }
        });
      };

      $(document).on("click", ".preview-images-only", function () {
        const images = $(this).data("images");
        const base_url = "https://sys.eudoraclinic.com:84/app/";

        const container = $("#previewImageContainer");
        container.empty();

        if (!images || images.length === 0) {
          container.html("<p class='text-center w-100 text-muted'>Tidak ada gambar.</p>");
        } else {
          images.forEach(img => {
            container.append(`
        <img src="${base_url}${img.image_path}" 
     class="img-thumbnail" 
     style="width:140px; height:140px; object-fit:cover;">

      `);
          });
        }

        const modal = new bootstrap.Modal(document.getElementById("previewImageModal"));
        modal.show();
      });

    });
  </script>


</body>

</html>