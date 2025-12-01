<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eudora - Stock Out</title>
  <style>
    .mycontaine { font-size: 12px !important; }
    .mycontaine * { font-size: inherit !important; }
    .form-row { display: flex; flex-wrap: wrap; gap: 15px; }
    .form-column { flex: 1; min-width: 250px; }
    .form-label { font-size: 14px; font-weight: bold; color: #333; display: block; }
    input[type="text"], input[type="date"], textarea, select {
      width: 100%; padding: 8px; font-size: 14px;
      border: 1px solid #ccc; border-radius: 5px; margin-top: 5px;
      transition: all 0.3s;
    }
    input[type="text"]:focus, input[type="date"]:focus, textarea:focus, select:focus {
      border-color: #007bff; outline: none;
      box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
    }
    textarea { resize: vertical; min-height: 100px; }
    select { background: #fff; cursor: pointer; }
    input[disabled] { background: #f5f5f5; color: #777; }
    @media (max-width: 768px) { .form-row { flex-direction: column; } }
    <?php
    $companyId   = isset($user->companyid) ? $user->companyid : '';
    $companyName = isset($user->companyname) ? $user->companyname : '';
    $warehouseId   = isset($user->warehouseid) ? $user->warehouseid : '';
    $warehouseName = isset($user->warehouse_name) ? $user->warehouse_name : '';

    ?>
  </style>
</head>
<body>
<div class="mycontaine">
  <div class="hidden mt-2" id="role-information">
    <div class="card p-4">
      <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
        <i class="bi bi-wallet2"></i> General
      </h6>
      <div class="form-row">
        <div class="form-column">
          <label for="requestDate" class="form-label mt-2"><strong>DATE</strong><span class="text-danger">*</span></label>
          <input type="text" name="requestdate" id="requestdate" value="<?= date('Y-m-d') ?>">

          <label for="code" class="form-label mt-2"><strong>CODE:</strong><span class="text-danger">*</span></label>
          <input type="text" name="code" id="code" placeholder="#AUTO" disabled>

          <label for="issuedby" class="form-label mt-2"><strong>ISSUED BY:</strong></label>
          <select id="requesterid" name="requesterid" style="width: 300px;"></select>
        </div>
        <div class="form-column">
          <label for="warehouseid" class="form-label mt-2"><strong>WAREHOUSE:</strong></label>
          <select id="warehouseid" name="warehouseid" style="width: 300px;">
            <?php if ($warehouseName): ?>
              <option value="<?= $warehouseId?>" selected><?= $warehouseName ?></option>
            <?php endif; ?>
          </select>

          <label for="company" class="form-label mt-2"><strong>COMPANY:</strong><span class="text-danger">*</span></label>
          <select id="companyid" name="companyid" class="form-control select2" required>
            <?php if ($companyName): ?>
              <option value="<?= $companyId?>" selected><?= $companyName ?></option>
            <?php endif; ?>
          </select>

          <label for="remarks" class="form-label mt-2"><strong>NOTES:</strong></label>
          <textarea name="notes" id="notes" rows="6" cols="50"></textarea>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="table-wrapper product-table-wrapper card">
  <div class="p-4">
    <div class="items mt-2">
      <h6 class="text-secondary mb-2 mt-2"><i class="bi bi-wallet2"></i> ITEMS</h6>
      <div class="table-responsive">
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
      </div>
      <button class="btn btn-primary btn-sm add-items">
        <i class="bi bi-plus-circle"></i> + ITEMS
      </button>
    </div>
  </div>
</div>

<div id="ajaxModalContainer"></div>


<div class="row p-4 gap-4">
  <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(1)" style="background-color: #c49e8f; color: black;">SAVE AS DRAFT</button>
  <?php if ($level == 7): ?>
      <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(2)" style="background-color: #c49e8f; color: black;">
          APPROVE
      </button>
  <?php endif; ?>
  <a href="<?= base_url('purchaseRequestList') ?>" class="btn btn-primary mb-4">
    <i class="bi bi-plus-circle"></i> CANCEL
  </a>
</div>

<!-- <script>
  document.addEventListener("DOMContentLoaded", function () {
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
    initSelect2($("#companyid"), "SELECT COMPANY", "<?= base_url('ControllerPurchasing/getCompanies') ?>");
    initSelect2($("#warehouseid"), "SELECT WAREHOUSE", "<?= base_url('ControllerPurchasing/getWarehouses') ?>");
    initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");

    // --- Add Row handler
    const newTable = document.querySelector(".product-table-wrapper");
    newTable.querySelector(".add-items").addEventListener("click", function () {
      const itemList = newTable.querySelector("#tbl-items tbody");

      // const itemHtml = `
      //   <tr>
      //     <td class="text-center align-middle">
      //       <select class="form-control itemsid" style="width:100%"></select>
      //     </td>
      //     <td class="text-center align-middle">
      //       <select class="form-control unititemsid" style="width:100%">
      //         <optgroup label="Default"></optgroup>
      //         <optgroup label="Alternative"></optgroup>
      //       </select>
      //     </td>
      //     <td class="text-center align-middle" style="min-width:110px">
      //       <input type="number" class="form-control qty" value="1" min="1">
      //     </td>
      //     <td class="text-center align-middle" style="min-width:220px">
      //       <div class="input-group">
      //         <input type="number" class="form-control unitqtytouom" readonly>
      //         <span class="input-group-text unitname"></span>
      //       </div>
      //     </td>
      //     <td class="text-center align-middle" style="min-width:180px">
      //       <textarea class="form-control description" rows="1"></textarea>
      //     </td>
      //     <td class="text-center align-middle">
      //       <button class="btn btn-danger btn-sm remove-items">DELETE</button>
      //     </td>
      //   </tr>`;
      const itemHtml = `
            <tr>
              <td class="text-center align-middle">
                <select class="form-control itemsid" style="width:100%"></select>
              </td>
              <td class="text-center align-middle">
                <select class="form-control unititemsid" style="width:100%">
                  <optgroup label="Default"></optgroup>
                  <optgroup label="Alternative"></optgroup>
                </select>
              </td>
              <td class="text-center align-middle" style="min-width:110px">
                <input type="number" class="form-control qty" value="1" min="1">
              </td>
              <td class="text-center align-middle" style="min-width:220px">
                <div class="input-group">
                  <input type="number" class="form-control unitqtytouom" readonly>
                  <span class="input-group-text unitname"></span>
                </div>
              </td>
              <td class="text-center align-middle" style="min-width:180px">
                <textarea class="form-control description" rows="1"></textarea>
              </td>
              <td class="text-center align-middle" style="min-width:130px">
                <button type="button" class="btn btn-sm btn-info upload-images">
                  <i class="bi bi-image"></i> Images
                </button>
              </td>
              <td class="text-center align-middle">
                <button class="btn btn-danger btn-sm remove-items">DELETE</button>
              </td>
            </tr>`;

      itemList.insertAdjacentHTML("beforeend", itemHtml);

      const lastItems = itemList.lastElementChild;
      const $itemSelect = $(lastItems).find(".itemsid");

      // Select2 untuk item
      $itemSelect.select2({
        placeholder: "Pilih Item",
        allowClear: true,
        width: "100%",
        ajax: {
          url: "<?= base_url('App/searchItems') ?>",
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

      // Saat item dipilih → load unit default & alternatif
      $itemSelect.on("select2:select", function (e) {
        const itemId = e.params.data.id;
        const $unitSelect = $(lastItems).find(".unititemsid");
        const $unitqtytouom = $(lastItems).find(".unitqtytouom");
        const $qtyInput = $(lastItems).find(".qty");
        const $unitName = $(lastItems).find(".unitname");

        $unitSelect.find("optgroup[label='Default']").empty();
        $unitSelect.find("optgroup[label='Alternative']").empty();
        $unitSelect.removeData("default-unitid").removeData("default-unitname");
        $unitqtytouom.val('');
        $unitName.text('');

        $.ajax({
          url: "<?= base_url('ControllerPurchasing/getAlternativeUnit/') ?>" + itemId,
          type: "GET",
          dataType: "json",
          success: function (response) {
            const defaultUnit = Array.isArray(response) ? response.find(u => u.is_default) : null;

            if (defaultUnit) {
              $unitSelect
                .data("default-unitid", defaultUnit.unitid)
                .data("default-unitname", defaultUnit.unit_name);

              $unitSelect.find("optgroup[label='Default']").append(
                $('<option>', {
                  value: defaultUnit.unitid,
                  text: defaultUnit.unit_name + " (Default)",
                  'data-qty': 1,           // default dianggap 1
                  'data-type': 'default'
                }).prop("selected", true)
              );

              const q = forceNumber($qtyInput.val(), 1);
              $unitqtytouom.val(q); // default → qty * 1
              $unitName.text(defaultUnit.unit_name);
            } else {
              $unitSelect.find("optgroup[label='Default']").append('<option value="">[Default unit tidak ditemukan]</option>');
            }

            // Alternatif
            (Array.isArray(response) ? response.filter(u => !u.is_default) : []).forEach(function (unit) {
              $unitSelect.find("optgroup[label='Alternative']").append(
                $('<option>', {
                  value: unit.id,
                  text: unit.unit_name,
                  'data-qty': unit.quantity,
                  'data-type': 'alternative',
                  'data-unitid': unit.unitid
                })
              );
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
                $unitqtytouom.val(q); // default
                $unitName.text($unitSelect.data("default-unitname") || '');
              }
            });

            // Event saat qty berubah
            $qtyInput.off("input").on("input", function () {
              const $sel = $unitSelect.find(":selected");
              const q = forceNumber($(this).val(), 1);

              if ($sel.data("type") === "alternative") {
                const altQty = forceNumber($sel.data("qty"), 1);
                $unitqtytouom.val(q * altQty);
              } else {
                $unitqtytouom.val(q); // default
              }
            });
          },
          error: function () {
            $unitSelect.find("optgroup[label='Default']").append('<option value="">Gagal memuat unit</option>');
            $unitSelect.find("optgroup[label='Alternative']").empty();
            $unitqtytouom.val('');
            $unitName.text('');
          }
        });
      });

      // Hapus baris
      lastItems.querySelector(".remove-items").addEventListener("click", function () {
        lastItems.remove();
      });
    });

    $(document).on("click", ".upload-images", function () {
      const $row = $(this).closest("tr");
      const itemId = $row.find(".itemsid").val();

      if (!itemId) {
        swal("Peringatan", "Pilih item terlebih dahulu sebelum upload foto!", "warning");
        return;
      }

      $.ajax({
        url: "<?= base_url('ControllerPurchasing/showImageModal/') ?>" + itemId,
        type: "GET",
        success: function (response) {
          $("#ajaxModalContainer").html(response);
          $("#imageUploadModal").modal("show");
        },
        error: function () {
          swal("Error", "Gagal memuat modal upload gambar!", "error");
        }
      });
    });

    // --- SAVE
    window.saveStockOut = function (status) {
      const requestdate = document.getElementById("requestdate").value;
      const requesterid = $("#requesterid").val();
      const companyid = $("#companyid").val();
      const warehouseid = $("#warehouseid").val();
      const notes = document.getElementById("notes").value;

      if (!requestdate || !requesterid ) {
        swal("Peringatan", "Silakan lengkapi informasi General!", "warning");
        return false;
      }

      const itemList = [];
      $("#tbl-items tbody tr").each(function () {
        const $row = $(this);

        const itemid = $row.find(".itemsid").val();
        const $unitSelectEl = $row.find(".unititemsid");
        let $selectedOpt = $unitSelectEl.find("option:selected");

        if (!$selectedOpt.length && $unitSelectEl.find("optgroup[label='Default'] option").length) {
          $unitSelectEl.find("optgroup[label='Default'] option").first().prop("selected", true);
          $selectedOpt = $unitSelectEl.find("option:selected");
        }

        const qty          = $row.find(".qty").val();
        const description  = $row.find(".description").val();
        const unitqtytouom = $row.find(".unitqtytouom").val();

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

        if (itemid && unitid && qty) {
          itemList.push({
            itemid,
            unitid,
            qty,
            unitqtytouom,
            description,
            alternativeunitid
          });
        }
      });

      if (itemList.length === 0) {
        swal("Peringatan", "Silakan tambahkan minimal 1 item!", "warning");
        return false;
      }

      const transactionData = {
        requestdate,
        requesterid,
        companyid,
        warehouseid,
        notes,
        itemLists: itemList,
        status
      };
      console.log("Transaction Data:", transactionData);

      $.ajax({
        url: "<?= base_url('ControllerPurchasing/savePurchaseRequest') ?>",
        type: "POST",
        data: JSON.stringify(transactionData),
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          if (response && response.status === "success") {
            swal("Sukses", "Berhasil menambahkan purchase request", "success")
              .then(() => {
                window.location.href = response.redirect;
              });
          } else {
            console.error("Response tidak sesuai:", response);
            swal("Error", (response && response.message) ? response.message : "Terjadi kesalahan saat mengirim data.", "error");
          }
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error, xhr?.responseText);
          swal("Error", "Terjadi kesalahan saat mengirim data.", "error");
        }
      });
    };
  });
</script> -->

<!-- Tambahkan ini: Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

  // --- Helper fungsi umum
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
          return { results: data.map(item => ({ id: item.id, text: item.text })) };
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

  // --- Inisialisasi Select2 utama
  initSelect2($("#companyid"), "SELECT COMPANY", "<?= base_url('ControllerPurchasing/getCompanies') ?>");
  initSelect2($("#warehouseid"), "SELECT WAREHOUSE", "<?= base_url('ControllerPurchasing/getWarehouses') ?>");
  initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");

  // --- Tambah baris item
  const newTable = document.querySelector(".product-table-wrapper");
  newTable.querySelector(".add-items").addEventListener("click", function () {
    const itemList = newTable.querySelector("#tbl-items tbody");

    const itemHtml = `
      <tr>
        <td class="text-center align-middle">
          <select class="form-control itemsid" style="width:100%"></select>
        </td>
        <td class="text-center align-middle">
          <select class="form-control unititemsid" style="width:100%">
            <optgroup label="Default"></optgroup>
            <optgroup label="Alternative"></optgroup>
          </select>
        </td>
        <td class="text-center align-middle" style="min-width:110px">
          <input type="number" class="form-control qty" value="1" min="1">
        </td>
        <td class="text-center align-middle" style="min-width:220px">
          <div class="input-group">
            <input type="number" class="form-control unitqtytouom" readonly>
            <span class="input-group-text unitname"></span>
          </div>
        </td>
        <td class="text-center align-middle" style="min-width:180px">
          <textarea class="form-control description" rows="1"></textarea>
        </td>
        <td class="text-center align-middle" style="min-width:130px">
          <button type="button" class="btn btn-sm btn-info upload-images">
            <i class="bi bi-image"></i> Images
          </button>
        </td>
        <td class="text-center align-middle">
          <button class="btn btn-danger btn-sm remove-items">DELETE</button>
        </td>
      </tr>`;

    itemList.insertAdjacentHTML("beforeend", itemHtml);
    const lastItems = itemList.lastElementChild;
    const $itemSelect = $(lastItems).find(".itemsid");

    // Inisialisasi Select2 item
    $itemSelect.select2({
      placeholder: "Pilih Item",
      allowClear: true,
      width: "100%",
      ajax: {
        url: "<?= base_url('App/searchItems') ?>",
        dataType: "json",
        delay: 250,
        data: params => ({ search: params.term }),
        processResults: data => ({ results: data.map(item => ({ id: item.id, text: item.text })) }),
        cache: true
      },
      minimumInputLength: 2
    });

    // Hapus baris
    lastItems.querySelector(".remove-items").addEventListener("click", function () {
      lastItems.remove();
    });
  });

  // --- Modal upload image di satu halaman
  $(document).on("click", ".upload-images", function () {
    const $row = $(this).closest("tr");
    const itemId = $row.find(".itemsid").val();

    if (!itemId) {
      swal("Peringatan", "Pilih item terlebih dahulu sebelum upload foto!", "warning");
      return;
    }

    // Buat modal di halaman ini
    const modalHtml = `
      <div class="modal fade" id="imageUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Upload Images (Item ID: ${itemId})</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <form id="uploadForm" enctype="multipart/form-data">
                <input type="hidden" name="item_id" value="${itemId}">
                <div class="mb-3">
                  <label for="images" class="form-label">Select Images</label>
                  <input type="file" name="images[]" id="images" class="form-control" multiple>
                </div>
                <div class="d-flex flex-wrap gap-2" id="previewContainer"></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-success" id="saveImages">Upload</button>
            </div>
          </div>
        </div>
      </div>`;

    $("#ajaxModalContainer").html(modalHtml);
    const modal = new bootstrap.Modal(document.getElementById("imageUploadModal"));
    modal.show();

    // Preview sebelum upload
    $(document).off("change", "#images").on("change", "#images", function () {
      const previewContainer = $("#previewContainer");
      previewContainer.html("");
      Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          previewContainer.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
        };
        reader.readAsDataURL(file);
      });
    });

    // Upload ke server via AJAX
    $(document).off("click", "#saveImages").on("click", "#saveImages", function () {
      const formData = new FormData($("#uploadForm")[0]);

      $.ajax({
        url: "<?= base_url('ControllerPurchasing/uploadItemImages') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          swal("Sukses", "Gambar berhasil diupload!", "success");
          modal.hide();
        },
        error: function () {
          swal("Error", "Gagal upload gambar!", "error");
        }
      });
    });
  });

});
</script> -->

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

  // --- Helper fungsi umum
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
          return { results: data.map(item => ({ id: item.id, text: item.text })) };
        },
        cache: true
      },
      minimumInputLength: 2
    });
  }

  // --- Inisialisasi Select2 utama
  initSelect2($("#companyid"), "SELECT COMPANY", "<?= base_url('ControllerPurchasing/getCompanies') ?>");
  initSelect2($("#warehouseid"), "SELECT WAREHOUSE", "<?= base_url('ControllerPurchasing/getWarehouses') ?>");
  initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");

  // --- Variabel penyimpanan gambar sementara
  let imageData = {}; // { itemId: [File, File, ...] }

  // --- Tambah baris item
  const newTable = document.querySelector(".product-table-wrapper");
  newTable.querySelector(".add-items").addEventListener("click", function () {
    const itemList = newTable.querySelector("#tbl-items tbody");

    const itemHtml = `
      <tr>
        <td class="text-center align-middle">
          <select class="form-control itemsid" style="width:100%"></select>
        </td>
        <td class="text-center align-middle">
          <select class="form-control unititemsid" style="width:100%">
            <optgroup label="Default"></optgroup>
            <optgroup label="Alternative"></optgroup>
          </select>
        </td>
        <td class="text-center align-middle" style="min-width:110px">
          <input type="number" class="form-control qty" value="1" min="1">
        </td>
        <td class="text-center align-middle" style="min-width:220px">
          <div class="input-group">
            <input type="number" class="form-control unitqtytouom" readonly>
            <span class="input-group-text unitname"></span>
          </div>
        </td>
        <td class="text-center align-middle" style="min-width:180px">
          <textarea class="form-control description" rows="1"></textarea>
        </td>
        <td class="text-center align-middle" style="min-width:130px">
          <button type="button" class="btn btn-sm btn-info upload-images">
            <i class="bi bi-image"></i> Images
          </button>
        </td>
        <td class="text-center align-middle">
          <button class="btn btn-danger btn-sm remove-items">DELETE</button>
        </td>
      </tr>`;

    itemList.insertAdjacentHTML("beforeend", itemHtml);
    const lastItems = itemList.lastElementChild;
    const $itemSelect = $(lastItems).find(".itemsid");

    // Inisialisasi Select2 item
    $itemSelect.select2({
      placeholder: "Pilih Item",
      allowClear: true,
      width: "100%",
      ajax: {
        url: "<?= base_url('App/searchItems') ?>",
        dataType: "json",
        delay: 250,
        data: params => ({ search: params.term }),
        processResults: data => ({ results: data.map(item => ({ id: item.id, text: item.text })) }),
        cache: true
      },
      minimumInputLength: 2
    });

    // Hapus baris
    lastItems.querySelector(".remove-items").addEventListener("click", function () {
      const id = $(this).closest("tr").find(".itemsid").val();
      delete imageData[id];
      lastItems.remove();
    });
  });

  // --- Modal upload preview tanpa upload langsung
  $(document).on("click", ".upload-images", function () {
    const $row = $(this).closest("tr");
    const itemId = $row.find(".itemsid").val();

    if (!itemId) {
      swal("Peringatan", "Pilih item terlebih dahulu sebelum menambahkan gambar!", "warning");
      return;
    }

    // Simpan data baris aktif
    const modalHtml = `
      <div class="modal fade" id="imageUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Preview Images (Item ID: ${itemId})</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <input type="file" id="imagesInput" class="form-control mb-3" multiple>
              <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
            </div>
          </div>
        </div>
      </div>`;

    $("#ajaxModalContainer").html(modalHtml);
    const modal = new bootstrap.Modal(document.getElementById("imageUploadModal"));
    modal.show();

    // --- Tampilkan preview gambar sebelumnya (jika ada)
    const container = $("#previewContainer");
    container.html("");
    if (imageData[itemId]) {
      imageData[itemId].forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
          container.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
        };
        reader.readAsDataURL(file);
      });
    }

    // --- Tambah gambar baru (hanya simpan di memory JS)
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

      // ubah tombol jadi “Preview Images”
      $row.find(".upload-images")
          .removeClass("btn-info")
          .addClass("btn-secondary")
          .html('<i class="bi bi-eye"></i> Preview Images');
    });
  });

  // --- Simpan semua (termasuk gambar) saat windowStockOut
  window.saveStockOut = function() {
    const formData = new FormData();

    $("#tbl-items tbody tr").each(function (i, row) {
      const itemId = $(row).find(".itemsid").val();
      const qty = $(row).find(".qty").val();
      const desc = $(row).find(".description").val();

      formData.append(`items[${i}][id]`, itemId);
      formData.append(`items[${i}][qty]`, qty);
      formData.append(`items[${i}][description]`, desc);

      if (imageData[itemId]) {
        imageData[itemId].forEach((file, idx) => {
          formData.append(`images[${i}][]`, file);
        });
      }
    });

    $.ajax({
      url: "<?= base_url('ControllerPurchasing/saveStockOut') ?>",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: res => swal("Berhasil!", "Data dan gambar berhasil disimpan!", "success"),
      error: () => swal("Error", "Gagal menyimpan data!", "error")
    });
  };

});
</script> -->

<script>
  document.addEventListener("DOMContentLoaded", function () {

    // --- Helper umum
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
            return { results: data.map(item => ({ id: item.id, text: item.text })) };
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

    // --- Select2 Master Field
    initSelect2($("#companyid"), "SELECT COMPANY", "<?= base_url('ControllerPurchasing/getCompanies') ?>");
    initSelect2($("#warehouseid"), "SELECT WAREHOUSE", "<?= base_url('ControllerPurchasing/getWarehouses') ?>");
    initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");

    // --- Variabel penyimpanan gambar sementara
    let imageData = {}; // { itemId: [File, File, ...] }

    // --- Tambah baris item
    const newTable = document.querySelector(".product-table-wrapper");
    newTable.querySelector(".add-items").addEventListener("click", function () {
      const itemList = newTable.querySelector("#tbl-items tbody");

      const itemHtml = `
        <tr>
          <td class="text-center align-middle">
            <select class="form-control itemsid" style="width:100%"></select>
          </td>
          <td class="text-center align-middle">
            <select class="form-control unititemsid" style="width:100%">
              <optgroup label="Default"></optgroup>
              <optgroup label="Alternative"></optgroup>
            </select>
          </td>
          <td class="text-center align-middle" style="min-width:110px">
            <input type="number" class="form-control qty" value="1" min="1">
          </td>
          <td class="text-center align-middle" style="min-width:220px">
            <div class="input-group">
              <input type="number" class="form-control unitqtytouom" readonly>
              <span class="input-group-text unitname"></span>
            </div>
          </td>
          <td class="text-center align-middle" style="min-width:180px">
            <textarea class="form-control description" rows="1"></textarea>
          </td>
          <td class="text-center align-middle" style="min-width:130px">
            <button type="button" class="btn btn-sm btn-info upload-images">
              <i class="bi bi-image"></i> Images
            </button>
          </td>
          <td class="text-center align-middle">
            <button class="btn btn-danger btn-sm remove-items">DELETE</button>
          </td>
        </tr>`;

      itemList.insertAdjacentHTML("beforeend", itemHtml);
      const lastItems = itemList.lastElementChild;
      const $itemSelect = $(lastItems).find(".itemsid");

      // --- Select2 untuk Item
      $itemSelect.select2({
        placeholder: "Pilih Item",
        allowClear: true,
        width: "100%",
        ajax: {
          url: "<?= base_url('App/searchItems') ?>",
          dataType: "json",
          delay: 250,
          data: params => ({ search: params.term }),
          processResults: data => ({ results: data.map(item => ({ id: item.id, text: item.text })) }),
          cache: true
        },
        minimumInputLength: 2
      });

      // --- Saat item dipilih, tampilkan unit default & alternatif
      $itemSelect.off("select2:select").on("select2:select", function (e) {
        const itemId = e.params.data.id;
        const $unitSelect = $(lastItems).find(".unititemsid");
        const $qtyInput = $(lastItems).find(".qty");
        const $unitqtytouom = $(lastItems).find(".unitqtytouom");
        const $unitName = $(lastItems).find(".unitname");

        $unitSelect.find("optgroup[label='Default']").empty();
        $unitSelect.find("optgroup[label='Alternative']").empty();

        $.ajax({
          url: "<?= base_url('ControllerPurchasing/getAlternativeUnit/') ?>" + itemId,
          type: "GET",
          dataType: "json",
          success: function (response) {
            const defaultUnit = response.find(u => u.is_default);
            if (defaultUnit) {
              $unitSelect.data("default-unitid", defaultUnit.unitid)
                        .data("default-unitname", defaultUnit.unit_name);

              $unitSelect.find("optgroup[label='Default']").append(
                $('<option>', {
                  value: defaultUnit.unitid,
                  text: defaultUnit.unit_name + " (Default)",
                  'data-qty': 1,
                  'data-type': 'default'
                }).prop("selected", true)
              );

              $unitqtytouom.val($qtyInput.val());
              $unitName.text(defaultUnit.unit_name);
            }

            // Tambahkan alternatif unit
            response.filter(u => !u.is_default).forEach(u => {
              $unitSelect.find("optgroup[label='Alternative']").append(
                $('<option>', {
                  value: u.id,
                  text: u.unit_name,
                  'data-qty': u.quantity,
                  'data-type': 'alternative'
                })
              );
            });

            // --- Saat unit diganti
            $unitSelect.off("change").on("change", function () {
              const selected = $(this).find(":selected");
              const q = forceNumber($qtyInput.val(), 1);

              if (selected.data("type") === "alternative") {
                $unitqtytouom.val(q * forceNumber(selected.data("qty"), 1));
              } else {
                $unitqtytouom.val(q);
              }
            });

            // --- Saat qty diganti
            $qtyInput.off("input").on("input", function () {
              const selected = $unitSelect.find(":selected");
              const q = forceNumber($(this).val(), 1);
              if (selected.data("type") === "alternative") {
                $unitqtytouom.val(q * forceNumber(selected.data("qty"), 1));
              } else {
                $unitqtytouom.val(q);
              }
            });
          }
        });
      });

      // --- Hapus baris
      lastItems.querySelector(".remove-items").addEventListener("click", function () {
        const id = $(this).closest("tr").find(".itemsid").val();
        delete imageData[id];
        lastItems.remove();
      });
    });

    // --- Modal Upload Gambar & Preview
    $(document).on("click", ".upload-images", function () {
      const $row = $(this).closest("tr");
      const itemId = $row.find(".itemsid").val();

      if (!itemId) {
        swal("Peringatan", "Pilih item terlebih dahulu sebelum menambahkan gambar!", "warning");
        return;
      }

      const modalHtml = `
        <div class="modal fade" id="imageUploadModal" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Upload Images (Item ID: ${itemId})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="file" id="imagesInput" class="form-control mb-3" multiple>
                <div id="previewContainer" class="d-flex flex-wrap gap-2"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
              </div>
            </div>
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

        $row.find(".upload-images").removeClass("btn-info").addClass("btn-secondary").html('<i class="bi bi-eye"></i> Preview Images');
      });
    });

    // --- SAVE: Kirim semua data + gambar ke backend
    window.saveStockOut = function () {
      const formData = new FormData();

      // --- Ambil data header
      formData.append("requestdate", $("#requestdate").val());
      formData.append("code", $("#code").val());
      formData.append("requesterid", $("#requesterid").val());
      formData.append("warehouseid", $("#warehouseid").val());
      formData.append("companyid", $("#companyid").val());
      formData.append("notes", $("#notes").val());

      // --- Ambil data detail item
      $("#tbl-items tbody tr").each(function (i, row) {
        const itemId = $(row).find(".itemsid").val();
        const qty = $(row).find(".qty").val();
        const desc = $(row).find(".description").val();
        const unitid = $(row).find(".unititemsid").val();

        formData.append(`items[${i}][id]`, itemId);
        formData.append(`items[${i}][qty]`, qty);
        formData.append(`items[${i}][unitid]`, unitid);
        formData.append(`items[${i}][description]`, desc);

        if (imageData[itemId]) {
          imageData[itemId].forEach((file, idx) => {
            formData.append(`images[${i}][]`, file);
          });
        }
      });

      // --- Kirim ke backend
      $.ajax({
        url: "<?= base_url('ControllerPurchasing/savePurchaseRequest') ?>",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
          try {
            const data = typeof res === "string" ? JSON.parse(res) : res;

            if (data.status === "success") {
              swal("Berhasil!", data.message, "success").then(() => {
                window.location.href = data.redirect || "<?= base_url('ControllerPurchasing/purchaseRequestLists') ?>";
              });
            } else {
              swal("Gagal", data.message || "Terjadi kesalahan saat menyimpan data!", "error");
            }
          } catch (e) {
            console.error("Response parse error:", e, res);
            swal("Error", "Format response tidak valid!", "error");
          }
        },
        error: function () {
          swal("Error", "Gagal menyimpan data!", "error");
        }
      });
    };


  });
</script>



</body>
</html>
