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
        <i class="bi bi-wallet2"></i> ADD ASSET
      </h6>
      <div class="form-row" style="display: flex; gap: 20px;">

        <div class="form-column" style="flex: 1;">
            <label for="categoryid" class="form-label mt-2">
            <strong>CATEGORY:</strong><span class="text-danger">*</span>
            </label>
            <select id="categoryid" name="categoryid" class="form-control select2" required></select>

            <label for="code" class="form-label mt-2">
            <strong>CODE:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Enter Asset Code" required>

            <label for="type" class="form-label mt-2">
            <strong>TYPE:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="type" id="type" class="form-control" placeholder="Enter Type" required>

            <label for="type" class="form-label mt-2">
            <strong>STATUS:</strong><span class="text-danger">*</span>
            </label>
            <select name="status" id="status" required>
                <option value="">==== CHOOSE STATUS =====</option>
                <option value="0">BAIK</option>
                <option value="1">KURANG BAIK</option>
                <option value="2">TIDAK BERFUNGSI</option>
            </select>

            <label for="description" class="form-label mt-2">
            <strong>DESCRIPTION:</strong><span class="text-danger">*</span>
            </label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter Description" required></textarea>
        </div>

        <!-- Kolom Kanan -->
        <div class="form-column" style="flex: 1;">
            <label for="locationid" class="form-label mt-2">
            <label><strong>LOCATION:</strong><span class="text-danger">*</span></label>
            <select id="locationid" name="locationid" class="form-control select2" style="width: 100%;" required disabled>
                <?php if (!empty($location_id) && !empty($location_name)): ?>
                    <option value="<?= $location_id ?>" selected><?= $location_name ?></option>
                <?php else: ?>
                    <option value="">No Location Selected</option>
                <?php endif; ?>
            </select>
            <input type="hidden" name="locationid" id="locationids" value="<?= isset($location_id) ? $location_id : '' ?>">

            <label for="facility_name" class="form-label mt-2">
            <strong>ASSET NAME:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="facility_name" id="facility_name" class="form-control" placeholder="Enter Facility Name" required>

            <label for="merk" class="form-label mt-2">
            <strong>MERK:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="merk" id="merk" class="form-control" placeholder="Enter Merk" required>

            <label for="merk" class="form-label mt-2">
            <strong>QUANTITY:</strong><span class="text-danger">*</span>
            </label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter Quantity" value="1" min="1" required>

            <label for="image1" class="form-label mt-2">
            <strong>IMAGES 1:</strong><span class="text-danger">*</span>
            </label>
            <input type="file" name="image1" id="image1" class="form-control" accept="image/*" required>

            <label for="image2" class="form-label mt-2">
            <strong>IMAGES 2:</strong>
            </label>
            <input type="file" name="image2" id="image2" class="form-control" accept="image/*">
        </div>
        </div>
    </div>
  </div>
</div>

<div id="ajaxModalContainer"></div>


<div class="row p-4 gap-4">
  <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut()" style="background-color: #c49e8f; color: black;">SAVE AS DRAFT</button>
  <a href="<?= base_url('facilityReportList') ?>" class="btn btn-primary mb-4">
    <i class="bi bi-plus-circle"></i> CANCEL
  </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function () {
  const locationId = "<?= $location_id ?? '' ?>";
  let imageData = {}; 
  function initSelect2($el, placeholder, url) {
    $el.select2({
      placeholder: placeholder,
      allowClear: true,
      width: "100%",
      ajax: {
        url: url,
        type: "GET",
        dataType: "json",
        delay: 250,
        data: function (params) {
          return { search: params.term || "" };
        },
        processResults: function (response) {
          const data = response.data || response || [];
          return {
            results: Array.isArray(data)
              ? data.map(item => ({ id: item.id, text: item.text }))
              : []
          };
        },
        error: function (xhr, status, error) {
          console.error("Select2 AJAX Error:", error);
        },
        cache: true
      },
      minimumInputLength: 0
    });
  }

  // Inisialisasi dropdown
  initSelect2($("#categoryid"), "SELECT CATEGORY", "<?= base_url('ControllerReport/getFacilityCategory') ?>");
  initSelect2($("#locationid"), "SELECT LOCATION", "<?= base_url('ControllerPurchasing/getLocation') ?>");

  /* -----------------------------
     Tambah baris item
  ------------------------------ */
  const tableWrapper = document.querySelector(".product-table-wrapper");
  if (tableWrapper) {
    tableWrapper.querySelector(".add-items").addEventListener("click", function () {
      const tbody = tableWrapper.querySelector("#tbl-items tbody");
      const itemHtml = `
        <tr>
          <td class="text-center align-middle">
            <input type="text" class="form-control itemsid" placeholder="Item ID">
          </td>
          <td class="text-center align-middle">
            <textarea class="form-control description" rows="1" placeholder="Description"></textarea>
          </td>
          <td class="text-center align-middle">
            <button type="button" class="btn btn-sm btn-info upload-images">
              <i class="bi bi-image"></i> Upload
            </button>
          </td>
          <td class="text-center align-middle">
            <button class="btn btn-danger btn-sm remove-items">DELETE</button>
          </td>
        </tr>`;

      tbody.insertAdjacentHTML("beforeend", itemHtml);
      const $row = $(tbody.lastElementChild);

      // Hapus baris
      $row.find(".remove-items").off("click").on("click", function () {
        const id = $row.find(".itemsid").val();
        if (id) delete imageData[id];
        $row.remove();
      });

      // Upload gambar
      $row.find(".upload-images").off("click").on("click", function () {
        const $btn = $(this);
        const itemId = $row.find(".itemsid").val() || `row_${Date.now()}`;

        const modalId = "modal_" + itemId;
        const modalHtml = `
          <div class="modal fade" id="${modalId}" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Upload Images for Item</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="file" id="fileInput_${itemId}" class="form-control mb-3" multiple accept="image/*">
                  <div id="preview_${itemId}" class="d-flex flex-wrap gap-2"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
              </div>
            </div>
          </div>`;

        $("#ajaxModalContainer").html(modalHtml);
        const modal = new bootstrap.Modal(document.getElementById(modalId));
        modal.show();

        const $preview = $(`#preview_${itemId}`);
        $preview.html("");

        // tampilkan gambar lama
        if (imageData[itemId]) {
          imageData[itemId].forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
              $preview.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
            };
            reader.readAsDataURL(file);
          });
        }

        // upload baru
        $(document)
          .off("change", `#fileInput_${itemId}`)
          .on("change", `#fileInput_${itemId}`, function () {
            const files = Array.from(this.files);
            imageData[itemId] = files;

            $preview.html("");
            files.forEach(file => {
              const reader = new FileReader();
              reader.onload = e => {
                $preview.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;object-fit:cover;">`);
              };
              reader.readAsDataURL(file);
            });

            $btn.removeClass("btn-info").addClass("btn-secondary").html('<i class="bi bi-eye"></i> Preview');
          });
      });
    });
  }

  /* -----------------------------
     Simpan data — GLOBAL FUNCTION
  ------------------------------ */
  window.saveStockOut = function () {
    const formData = new FormData();

    formData.append("categoryid", $("#categoryid").val());
    formData.append("locationid", $("#locationids").val());
    formData.append("code", $("#code").val());
    formData.append("type", $("#type").val());
    formData.append("description", $("#description").val());
    formData.append("facility_name", $("#facility_name").val());
    formData.append("merk", $("#merk").val());
    formData.append("quantity", $("#quantity").val());
    formData.append("status", $("#status").val());
    formData.append("image1", $("#image1")[0].files[0]);
    formData.append("image2", $("#image2")[0].files[0]);

    $.ajax({
      url: "<?= base_url('ControllerReport/saveFacility') ?>",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (res) {
        try {
          const data = typeof res === "string" ? JSON.parse(res) : res;
          if (data.status === "success") {
            swal("Success", data.message, "success").then(() => {
              window.location.href = data.redirect || "<?= base_url('facilityReportList') ?>";
            });
          } else {
            swal("Failed", data.message || "Gagal menyimpan data!", "error");
          }
        } catch (e) {
          console.error("Parse error:", e, res);
          swal("Error", "Response tidak valid!", "error");
        }
      },
      error: function (xhr) {
        console.error("AJAX Error:", xhr.responseText);
        swal("Error", "Gagal mengirim data ke server!", "error");
      }
    });
  };
}); // DOMContentLoaded end
</script>


</body>
</html>
