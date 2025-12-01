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
   
  </style>
</head>
<body>
<div class="mycontaine">
  <div class="hidden mt-2" id="role-information">
    <div class="card p-4">
      <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
        <i class="bi bi-wallet2"></i> DETAIL REPORT <?= $facility['facility_code']?>
      </h6>
      <div class="form-row" style="display: flex; gap: 20px;">

    <!-- Kolom Kiri -->
        <div class="form-column" style="flex: 1;">
            <label for="categoryid" class="form-label mt-2">
                <strong>CATEGORY:</strong><span class="text-danger">*</span>
            </label>
            <select id="categoryid" name="categoryid" class="form-control select2" required>
                <?php if (!empty($facility['categoryid']) && !empty($facility['category_name'])): ?>
                    <option value="<?= $facility['categoryid'] ?>" selected>
                        <?= $facility['category_name'] ?>
                    </option>
                <?php else: ?>
                    <option value="">Select Category</option>
                <?php endif; ?>
            </select>
            <input type="hidden" name="categoryid" id="categoryid" class="form-control" placeholder="Enter Type" 
                  value="<?= isset($facility['categoryid']) ? $facility['categoryid'] : '' ?>" required>

            <label for="code" class="form-label mt-2">
                <strong>CODE:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Enter Facility Code" 
                  value="<?= isset($facility['facility_code']) ? $facility['facility_code'] : '' ?>" required>

            <label for="type" class="form-label mt-2">
                <strong>TYPE:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="type" id="type" class="form-control" placeholder="Enter Type" 
                  value="<?= isset($facility['type']) ? $facility['type'] : '' ?>" required>

            <label for="status" class="form-label mt-2">
                <strong>STATUS:</strong><span class="text-danger">*</span>
            </label>
            <select name="status" id="status" class="form-control" required>
                <option value="">==== CHOOSE STATUS =====</option>
                <option value="0" <?= (isset($facility['status']) && $facility['status'] == 0) ? 'selected' : '' ?>>BAIK</option>
                <option value="1" <?= (isset($facility['status']) && $facility['status'] == 1) ? 'selected' : '' ?>>KURANG BAIK</option>
                <option value="2" <?= (isset($facility['status']) && $facility['status'] == 2) ? 'selected' : '' ?>>TIDAK BERFUNGSI</option>
            </select>

            <label for="description" class="form-label mt-2">
                <strong>DESCRIPTION:</strong><span class="text-danger">*</span>
            </label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter Description" required><?= isset($facility['description']) ? $facility['description'] : '' ?></textarea>
        </div>

        <!-- Kolom Kanan -->
        <div class="form-column" style="flex: 1;">
            <label for="locationid" class="form-label mt-2">
                <strong>LOCATION:</strong><span class="text-danger">*</span>
            </label>
            <select id="locationid" name="locationid" class="form-control select2" required>
                <?php if (!empty($facility['locationid']) && !empty($facility['location_name'])): ?>
                    <option value="<?= $facility['locationid'] ?>" selected>
                        <?= $facility['location_name'] ?>
                    </option>
                <?php else: ?>
                    <option value="">Select Category</option>
                <?php endif; ?>
            </select>
            <input type="hidden" name="locationid" id="locationids" value="<?= isset($location_id) ? $location_id : '' ?>">

            <label for="facility_name" class="form-label mt-2">
                <strong>NAME:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="facility_name" id="facility_name" class="form-control" 
                  placeholder="Enter Facility Name" value="<?= isset($facility['facility_name']) ? $facility['facility_name'] : '' ?>" required>

            <label for="merk" class="form-label mt-2">
                <strong>MERK:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="merk" id="merk" class="form-control" 
                  placeholder="Enter Merk" value="<?= isset($facility['merk']) ? $facility['merk'] : '' ?>" required>

            <label for="merk" class="form-label mt-2">
                <strong>QUANTITY:</strong><span class="text-danger">*</span>
            </label>
            <input type="text" name="merk" id="merk" class="form-control" 
                  placeholder="Enter Merk" value="<?= isset($facility['quantity']) ? $facility['quantity'] : '' ?>" required>

            <label for="image1" class="form-label mt-2">
                <strong>IMAGES 1:</strong><span class="text-danger">*</span>
            </label>
            <input type="file" name="image1" id="image1" class="form-control" accept="image/*" <?= isset($facility['image1']) ? '' : 'required' ?>>

            <label for="image2" class="form-label mt-2">
                <strong>IMAGES 2:</strong>
            </label>
            <input type="file" name="image2" id="image2" class="form-control" accept="image/*">
        </div>

    </div>
  </div>
</div>

<div class="table-wrapper product-table-wrapper card">
  <div class="p-4">
    <div class="items mt-2">
      <h6 class="text-secondary mb-4 text-center "><i class="bi bi-wallet2"></i> HISTORY</h6>
      <div class="table-responsive">
        <table id="tbl-history" class="table table-bordered items-list">
        <thead class="bg-thead">
          <tr>
            <th style="font-size: 12px; text-align: center;">REPORT</th>
            <th style="font-size: 12px; text-align: center;">DESCRIPTION</th>
            <th style="font-size: 12px; text-align: center;">IMAGES</th>
            <th style="font-size: 12px; text-align: center;">DEADLINE</th>
            <th style="font-size: 12px; text-align: center;">PROGRESS</th>
            <th style="font-size: 12px; text-align: center;">ACTION TAKEn</th>
            <th style="font-size: 12px; text-align: center;">UPDATE</th>
            <th style="font-size: 12px; text-align: center;">STATUS</th>
            <th style="font-size: 12px; text-align: center;">ACTION</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      </div>
    </div>
  </div>
</div>

<div class="table-wrapper product-table-wrappers card">
  <div class="p-4">
    <div class="items mt-2">
      <h6 class="text-secondary mb-4 text-center "><i class="bi bi-wallet2"></i> ADD CONDITION REPORT</h6>
      <div class="table-responsive">
        <table id="tbl-items" class="table table-bordered items-list">
        <thead class="bg-thead">
          <tr>
            <th style="font-size: 12px; text-align: center;">REPORT</th>
            <th style="font-size: 12px; text-align: center;">DESCRIPTION</th>
            <th style="font-size: 12px; text-align: center;">IMAGES</th>
            <th style="font-size: 12px; text-align: center;">DEADLINE</th>
            <th style="font-size: 12px; text-align: center;">ACTION</th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      </div>
      <button class="btn btn-primary btn-sm add-items">
        <i class="bi bi-plus-circle"></i> + REPORT
      </button>
    </div>
  </div>
</div>

<div class="modal fade" id="editConditionModal" tabindex="-1" aria-labelledby="editConditionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editConditionForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editConditionLabel">Update Condition Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="condition_id">

          <div class="mb-3">
            <label class="form-label">Progress</label>
            <textarea name="progress" id="progress" class="form-control" placeholder="Enter progress"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Action</label>
            <textarea name="action" id="action" class="form-control" placeholder="Enter action taken"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="0">Waiting</option>
              <option value="1">On Progress</option>
              <option value="2">Selesai</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<div id="ajaxModalContainer"></div>

<div class="modal fade" id="imagePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img id="imagePreview" src="" style="width: 100%; height: auto;">
      </div>
      <div class="modal-footer p-2">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="row p-4 gap-4">
  <button type="button" class="btn btn-primary mb-4" onclick="saveStockOut(1)" style="background-color: #c49e8f; color: black;">SAVE AS DRAFT</button>
  <a href="<?= base_url('facilityReportList') ?>" class="btn btn-primary mb-4">
    <i class="bi bi-plus-circle"></i> CANCEL
  </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<!-- <script>
    
  document.addEventListener("DOMContentLoaded", function () {

    const facilityId = "<?= isset($id) ? $id : '' ?>"; 
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
    function forceNumber(v, fallback = 0) {
      const n = Number(v);
      return Number.isFinite(n) ? n : fallback;
    }

    // --- Select2 Master Field
    initSelect2($("#locationid"), "SELECT LOCATION", "<?= base_url('ControllerReport/getAllLocation') ?>");
    initSelect2($("#facilityid"), "SELECT FACILITY", "<?= base_url('ControllerReport/getFacilityByLocation') ?>");
    initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");
    initSelect2($("#categoryid"), "SELECT CATEGORY", "<?= base_url('ControllerReport/getFacilityCategory') ?>");

    // --- Variabel penyimpanan gambar sementara
    let imageData = {}; // { itemId: [File, File, ...] }

    // --- Tambah baris item
    const newTable = document.querySelector(".product-table-wrapper");
    newTable.querySelector(".add-items").addEventListener("click", function () {
      const itemList = newTable.querySelector("#tbl-items tbody");

      const itemHtml = `
        <tr>
          <td class="text-center align-middle">
            <input type="text" class="form-control report">
          </td>
          <td class="text-center align-middle" style="min-width:180px">
            <textarea class="form-control description" rows="1"></textarea>
          </td>
          <td class="text-center align-middle" style="min-width:130px">
            <button type="button" class="btn btn-sm btn-info upload-images">
              <i class="bi bi-image"></i> Images
            </button>
          </td>
          <td class="text-center align-middle" style="min-width:130px">
            <input type="date" class="form-control deadline">
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

      if (facilityId) {
        $.ajax({
            url: "<?= base_url('ControllerReport/getFacilityById/') ?>" + facilityId,
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.success && res.data) {
                    const f = res.data;

                    $("#requestdate").val(f.createdat ? f.createdat.split(' ')[0] : "<?= date('Y-m-d') ?>");
                    $("#code").val(f.facility_code || '');
                    
                    if (f.locationid) {
                        const option = new Option(f.location_name, f.locationid, true, true);
                        $("#locationid").append(option).trigger('change');
                    }

                    // Set select2 untuk facility
                    if (f.id) {
                        const option = new Option(f.facility_name, f.id, true, true);
                        $("#facilityid").append(option).trigger('change');
                    }

                    // Tampilkan card
                    $("#role-information").removeClass('hidden');
                }
            },
            error: function(err) {
                console.error("Failed to load facility data:", err);
            }
        });
    }

    

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

      const modalHtml = `
        <div class="modal fade" id="imageUploadModal" tabindex="-1">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Upload Images</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="file" id="imagesInput" class="form-control mb-3">
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

    function populateFacilityForm(facility) {
        if (!facility) return;

        // Isi input text dan textarea
        $('#facility_name').val(facility.facility_name);
        $('#type').val(facility.type);
        $('#code').val(facility.facility_code);
        $('#description').val(facility.description);
        $('#merk').val(facility.merk);
        $('#quantity').val(facility.quantity);

        // Set status select
        $('#status').val(facility.status);

        // Set location (readonly/select disabled)
        $('#locationid').val(facility.locationid);
        $('#locationids').val(facility.locationid);

        // Set category jika ada
        if(facility.categoryid){
            $('#categoryid').val(facility.categoryid);
        }

        // Preview images jika ada
        if(facility.images && facility.images.length > 0){
            // misal cuma untuk image1 dan image2
            if(facility.images[0]) {
                $('#image1_preview').remove(); // hapus jika ada sebelumnya
                $('#image1').after('<img id="image1_preview" src="<?= base_url() ?>'+facility.images[0].images+'" style="max-width:100px;margin-top:10px;" />');
            }
            if(facility.images[1]) {
                $('#image2_preview').remove();
                $('#image2').after('<img id="image2_preview" src="<?= base_url() ?>'+facility.images[1].images+'" style="max-width:100px;margin-top:10px;" />');
            }
        }
    }

    $.ajax({
        url: '<?= base_url("ControllerReport/getFacilityById") ?>/' + facilityId,
        type: 'GET',
        dataType: 'json',
        success: function(res){
            if(res.success){
                populateFacilityForm(res.data);
            } else {
                alert(res.message);
            }
        }
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
</script> -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const facilityId = "<?= isset($id) ? $id : '' ?>"; 
    let imageData = {}; // simpan data gambar per item

    // ===========================
    // 🔹 Inisialisasi Select2
    // ===========================
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
                cache: true
            },
            minimumInputLength: 0
        });
    }

    initSelect2($("#locationid"), "SELECT LOCATION", "<?= base_url('ControllerReport/getAllLocation') ?>");
    initSelect2($("#facilityid"), "SELECT FACILITY", "<?= base_url('ControllerReport/getFacilityByLocation') ?>");
    initSelect2($("#requesterid"), "SELECT EMPLOYEE", "<?= base_url('ControllerPurchasing/getEmployees') ?>");
    initSelect2($("#categoryid"), "SELECT CATEGORY", "<?= base_url('ControllerReport/getFacilityCategory') ?>");

    // ===========================
    // 🔹 Populate Data Facility
    // ===========================
    function populateFacilityForm(facility) {

      console.log(facility);
      
        if (!facility) return;
        $('#facility_name').val(facility.facility_name);
        $('#type').val(facility.type);
        $('#code').val(facility.facility_code);
        $('#description').val(facility.description);
        $('#merk').val(facility.merk);
        $('#quantity').val(facility.quantity || 1);
        $('#status').val(facility.status);
        $('#locationid').val(facility.locationid).trigger('change');
        $('#categoryid').val(facility.categoryid).trigger('change');

       
        if (facility.images && facility.images.length > 0) {
            facility.images.forEach((img, i) => {
                const previewId = `#image${i + 1}_preview`;
                $(previewId).remove();
                $(`#image${i + 1}`).after(
                    `<img id="image${i + 1}_preview" 
                          src="<?= base_url() ?>${img.images}" 
                          class="img-preview" 
                          data-src="<?= base_url() ?>${img.images}" 
                          data-bs-toggle="modal" 
                          data-bs-target="#imagePreviewModal"
                          style="max-width:100px; cursor:pointer; margin-top:10px;" />`
                );
            });

            
            $('.img-preview').off('click').on('click', function() {
                const src = $(this).data('src');
                $('#imagePreview').attr('src', src);
            });
        }
    }

    // ===========================
    // 🔹 Load History Facility
    // ===========================
    function loadFacilityHistory(facilityId) {
        const endpoint = "<?= base_url('ControllerReport/getFacilityConditionById/') ?>" + facilityId;
        $.ajax({
            url: endpoint,
            type: "GET",
            dataType: "json",
            success: function(response) {
                const data = response.data || [];
                let tbody = '';

                if (data.length > 0) {
                    data.forEach(item => {
                        let statusBadge = '';
                        if (item.status == "0") {
                            statusBadge = '<span class="badge bg-secondary">Waiting</span>';
                        } else if (item.status == "1") {
                            statusBadge = '<span class="badge bg-warning text-dark">On Progress</span>';
                        } else if (item.status == "2") {
                            statusBadge = '<span class="badge bg-success">Selesai</span>';
                        } else {
                            statusBadge = '<span class="badge bg-dark">Unknown</span>';
                        }
                        tbody += `
                            <tr>
                                <td>${item.report || '-'}</td>
                                <td>${item.description || '-'}</td>
                                <td class="text-center">
                                  ${item.images ? `<img src="<?= base_url() ?>${item.images}" style="max-width:80px; height:auto; cursor:pointer;" class="img-preview" data-bs-toggle="modal" data-bs-target="#imagePreviewModal" data-src="<?= base_url() ?>${item.images}" />` : '-'}
                                </td>
                                <td>${item.deadline || '-'}</td>
                                <td>${item.progress || '-'}</td>
                                <td>${item.action || '-'}</td>
                                <td>${item.updatedat || '-'}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editReport(${item.id})">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteReport(${item.id})">Delete</button>
                                </td>
                            </tr>`;
                    });
                } else {
                    tbody = `<tr><td colspan="9" class="text-center">No history found</td></tr>`;
                }

                $('#tbl-history tbody').html(tbody);
            },
            error: function() {
                $('#tbl-history tbody').html(`<tr><td colspan="7" class="text-center text-danger">Failed to load history</td></tr>`);
            }
        });
    }

    $(document).on('click', '.img-preview', function() {
        const src = $(this).data('src');
        $('#imagePreview').attr('src', src);
    });
    
    if (facilityId) {
        $.ajax({
            url: '<?= base_url("ControllerReport/getFacilityById") ?>/' + facilityId,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    populateFacilityForm(res.data);
                    loadFacilityHistory(facilityId);
                } else {
                    alert(res.message || "Data tidak ditemukan");
                }
            },
            error: function() {
                alert("Gagal mengambil data facility!");
            }
        });
    }

    // ===========================
    // 🔹 Tambah Item Report
    // ===========================
    $(document).on("click", ".add-items", function () {
        const tbody = $("#tbl-items tbody");
        if (tbody.length === 0) return;

        const itemHtml = `
            <tr>
                <td class="text-center"><input type="text" class="form-control report" placeholder="Report"></td>
                <td><textarea class="form-control description" rows="1" placeholder="Description"></textarea></td>
                <td class="text-center">
                    <input type="file" class="form-control images" placeholder="Report">
                </td>
                <td><input type="date" class="form-control deadline"></td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm remove-items">DELETE</button>
                </td>
            </tr>`;
        tbody.append(itemHtml);
    });

    // 🔹 Hapus item baris
    $(document).on("click", ".remove-items", function () {
        $(this).closest("tr").remove();
    });

    // ===========================
    // 🔹 Upload & Preview Images
    // ===========================
    $(document).on("click", ".upload-images", function () {
        const $row = $(this).closest("tr");
        const itemId = Date.now(); 
        if (!imageData[itemId]) imageData[itemId] = [];

        const modalHtml = `
            <div class="modal fade" id="imageUploadModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Images</h5>
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

        $(document).off("change", "#imagesInput").on("change", "#imagesInput", function () {
            const files = Array.from(this.files);
            imageData[itemId].push(...files);
            container.html("");
            imageData[itemId].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    container.append(`<img src="${e.target.result}" class="img-thumbnail" style="width:100px;height:100px;">`);
                };
                reader.readAsDataURL(file);
            });
            $row.find(".upload-images").data('uploaded-images', imageData[itemId]);
        });
    });

    // ===========================
    // 🔹 Edit Condition Report
    // ===========================
    window.editReport = function(id) {
        $('#condition_id').val(id);
        $('#progress').val('');
        $('#action').val('');
        $('#condition_status').val('0'); // pastikan id select di modal = condition_status
        $('#editConditionModal').modal('show');
    };

    $('#editConditionForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= site_url("ControllerReport/updateCondition") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status === 'success' || res.success) {
                    alert('Condition updated successfully!');
                    $('#editConditionModal').modal('hide');
                    loadFacilityHistory(facilityId);
                } else {
                    alert(res.message || 'Failed to update condition!');
                }
            },
            error: function() {
                alert('Error occurred while updating condition!');
            }
        });
    });

    // ===========================
    // 🔹 Save Stock Out
    // ===========================
    window.saveStockOut = function () {
        const formData = new FormData();

        formData.append("facility_id", facilityId);
        formData.append("categoryid", $("#categoryid").val());
        formData.append("code", $("#code").val());
        formData.append("type", $("#type").val());
        formData.append("status", $("#status").val());
        formData.append("description", $("#description").val());
        formData.append("locationid", $("#locationid").val());
        formData.append("facility_name", $("#facility_name").val());
        formData.append("merk", $("#merk").val());
        formData.append("quantity", $("#quantity").val());

        const image1 = $("#image1")[0]?.files[0];
        const image2 = $("#image2")[0]?.files[0];
        if (image1) formData.append("image1", image1);
        if (image2) formData.append("image2", image2);

        $("#tbl-items tbody tr").each(function (i, row) {
            const report = $(row).find(".report").val();
            const description = $(row).find(".description").val();
            const deadline = $(row).find(".deadline").val();
            const imageInput = $(row).find(".images")[0];
            const file = imageInput && imageInput.files.length > 0 ? imageInput.files[0] : null;

            formData.append(`items[${i}][report]`, report);
            formData.append(`items[${i}][description]`, description);
            formData.append(`items[${i}][deadline]`, deadline);

            if (file) {
                formData.append(`items[${i}][images]`, file);
            }
        });

        $.ajax({
            url: "<?= base_url('ControllerReport/saveCondition') ?>",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const data = typeof res === "string" ? JSON.parse(res) : res;
                if (data.status === "success") {
                    swal("Berhasil!", data.message, "success").then(() => {
                        window.location.href = data.redirect || "<?= base_url('ControllerReport/conditionReport') ?>";
                    });
                } else {
                    swal("Gagal", data.message || "Terjadi kesalahan!", "error");
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
