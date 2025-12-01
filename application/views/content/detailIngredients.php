<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - ADD SERVICE</title>

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
        input[type="number"],
        select,
        textarea {
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
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background: #f5f5f5;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-update {
            background-color: #c49e8f;
            color: black;
        }
    </style>

    <?php
    $detail = isset($detailIngredients[0]) ? $detailIngredients[0] : [];
    ?>
</head>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label class="form-label mt-2">NAME:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="<?= $detail['name'] ?? '' ?>">

                        <label class="form-label mt-2">CODE:<span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code" value="<?= $detail['code'] ?? '' ?>">

                        <label class="form-label mt-2">SECTION:<span class="text-danger">*</span></label>
                        <select id="section" name="section" required>
                            <option value="1" <?= ($detail['section'] ?? '') == 1 ? 'selected' : '' ?>>SALON</option>
                            <option value="2" <?= ($detail['section'] ?? '') == 2 ? 'selected' : '' ?>>DOKTER</option>
                            <option value="3" <?= ($detail['section'] ?? '') == 3 ? 'selected' : '' ?>>TOOLS</option>
                        </select>

                        <label class="form-label mt-2">QTY TO UOM:</label>
                        <input type="number" name="qty" id="qty" value="<?= $detail['qty'] ?? '' ?>">
                    </div>

                    <div class="form-column">
                        <label class="form-label mt-2">PUBLISHED:<span class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" required>
                            <option value="1" <?= ($detail['isactive'] ?? '') == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= ($detail['isactive'] ?? '') == 0 ? 'selected' : '' ?>>No</option>
                        </select>

                        <label class="form-label mt-2">PRICE:</label>
                        <input type="number" name="price" id="price" value="<?= $detail['price'] ?? '' ?>">

                        <label class="form-label mt-2">UOM:<span class="text-danger">*</span></label>
                        <select id="uom" name="uom" required>
                            <?php foreach ($uomList as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= ($detail['unitid'] ?? '') == $j['id'] ? 'selected' : '' ?>>
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label class="form-label mt-2">UNIT PRICE:</label>
                        <input type="number" name="unitprice" id="unitprice" value="<?= $detail['unitprice'] ?? '' ?>" disabled>
                    </div>
                </div>
            </div>

            <!-- Alternative Units -->
            <div class="card p-4">
                <h4>Alternative Units</h4>
                <button type="button" class="btn btn-add" id="btnAddRow">+ Tambah Row</button>
                <table class="table table-bordered" id="alternativeTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Qty to UOM</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="alternativeBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <button type="button" class="btn btn-update" onclick="addIngredients(<?= $detail['id'] ?>)">UPDATE</button>
    </div>

<!--     
<script>
const ingredientId = "<?= $detail['id'] ?>";

// Ambil data alternatif dari server
function loadAlternatives() {
    $.getJSON("<?= base_url('ControllerPurchasing/getAlternatives/') ?>" + ingredientId, function(data) {
        renderAlternatives(data);
    });
}

// Render baris alternatif
function renderAlternatives(data) {
    const tbody = $("#alternativeBody");
    tbody.empty();

    if (!data || data.length === 0) {
        addAltRow();
        return;
    }

    data.forEach((alt, index) => {
        const row = $(`
            <tr data-id="${alt.id || ''}">
                <td class="alt-no">${index + 1}</td>
                <td>
                    <select class="form-control alt-unitid select2">
                        <?php foreach ($uomList as $j) { ?>
                            <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input type="number" step="0.01" class="form-control alt-qty" value="${alt.quantity ?? ''}"></td>
                <td><input type="number" step="0.01" class="form-control alt-qtytouom" value="${alt.qtytouom ?? ''}"></td>
                <td><input type="number" step="0.01" class="form-control alt-amount" value="${alt.amount ?? ''}"></td>
                <td><input type="text" class="form-control alt-description" value="${alt.description ?? ''}"></td>
                <td>
                    ${alt.id 
                        ? `<button type="button" class="btn btn-danger btn-sm" onclick="deleteAltRow(this, ${alt.id})">Hapus</button>`
                        : `<button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove(); reindexAlt()">Hapus</button>`}
                </td>
            </tr>
        `);

        // Set unit terpilih
        row.find(".alt-unitid").val(alt.unitid);
        tbody.append(row);
    });

    // Aktifkan select2 untuk dropdown unit
    $(".select2").select2();
}

// Tambah baris baru kosong
function addAltRow() {
    const tbody = $("#alternativeBody");
    const rowCount = tbody.find("tr").length + 1;

    const row = $(`
        <tr>
            <td class="alt-no">${rowCount}</td>
            <td>
                <select class="form-control alt-unitid select2">
                    <?php foreach ($uomList as $j) { ?>
                        <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control alt-qty"></td>
            <td><input type="number" step="0.01" class="form-control alt-qtytouom"></td>
            <td><input type="number" step="0.01" class="form-control alt-amount"></td>
            <td><input type="text" class="form-control alt-description"></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove(); reindexAlt()">Hapus</button>
            </td>
        </tr>
    `);

    tbody.append(row);
    $(".select2").select2();
}

// Hapus alternative yang ada di DB (ubah isactive=0 di backend)
function deleteAltRow(btn, id) {
    if (!confirm("Yakin hapus alternative ini?")) return;

    $.post("<?= base_url('ControllerPurchasing/deleteAlternative/') ?>" + id, function(res) {
        if (res.status) {
            $(btn).closest("tr").remove();
            reindexAlt();
        } else {
            alert("Gagal hapus: " + res.message);
        }
    }, "json");
}

// Reindex nomor (No kolom)
function reindexAlt() {
    $("#alternativeBody .alt-no").each(function(i) {
        $(this).text(i + 1);
    });
}

// Load awal saat page dibuka
$(document).ready(function() {
    loadAlternatives();
});
</script> -->

<script>
const ingredientId = "<?= $detail['id'] ?? 0 ?>";

// Ambil data alternatif dari server
function loadAlternatives() {
    $.getJSON("<?= base_url('ControllerPurchasing/getAlternatives/') ?>" + ingredientId, function(data) {
        renderAlternatives(data);
    });
}

// Render baris alternatif
function renderAlternatives(data) {
    const tbody = $("#alternativeBody");
    tbody.empty();

    if (!data || data.length === 0) {
        addAltRow();
        return;
    }

    data.forEach((alt, index) => {
        const row = createAltRow(index + 1, alt);
        tbody.append(row);
    });

    $(".select2").select2();
}

// Buat row alternatif
function createAltRow(no, alt = {}) {
    const row = $(`
        <tr data-id="${alt.id || ''}">
            <td class="alt-no">${no}</td>
            <td>
                <select class="form-control alt-unitid select2">
                    <?php foreach ($uomList as $j) { ?>
                        <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                    <?php } ?>
                </select>
            </td>
            <td><input type="number" step="0.01" class="form-control alt-qty" value="${alt.quantity ?? ''}"></td>
            <td>
                <input type="number" step="0.01" class="form-control alt-qtytouom" style="display:inline-block; width:auto; vertical-align:middle;" value="${alt.qtytouom ?? ''}">
                <span style="margin-left:5px; vertical-align:middle;"><?= $detail['uom'] ?? '' ?></span>
            </td>
            <td><input type="number" step="0.01" class="form-control alt-amount" value="${alt.amount ?? ''}"></td>
            <td><input type="text" class="form-control alt-description" value="${alt.description ?? ''}"></td>
            <td>
                ${alt.id 
                    ? `<button type="button" class="btn btn-danger btn-sm" onclick="deleteAltRow(this, ${alt.id})">Hapus</button>`
                    : `<button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('tr').remove(); reindexAlt()">Hapus</button>`}
            </td>
        </tr>
    `);

    row.find(".alt-unitid").val(alt.unitid ?? "");
    return row;
}

// Tambah baris baru
function addAltRow() {
    const tbody = $("#alternativeBody");
    const rowCount = tbody.find("tr").length + 1;
    tbody.append(createAltRow(rowCount));
    $(".select2").select2();
}

// Hapus alternative dari DB
function deleteAltRow(btn, id) {
    if (!confirm("Yakin hapus alternative ini?")) return;

    $.post("<?= base_url('ControllerPurchasing/deleteAlternative/') ?>" + id, function(res) {
        if (res.status) {
            $(btn).closest("tr").remove();
            reindexAlt();
        } else {
            alert("Gagal hapus: " + res.message);
        }
    }, "json");
}

// Reindex nomor kolom
function reindexAlt() {
    $("#alternativeBody .alt-no").each(function(i) {
        $(this).text(i + 1);
    });
}

// UPDATE header + alternatives
function addIngredients(id) {
    // Header
    const headerData = {
        id,
        name: $('#name').val(),
        code: $('#code').val(),
        isactive: $('#isactive').val(),
        price: $('#price').val(),
        section: $('#section').val(),
        uom: $('#uom').val(),
        qty: $('#qty').val(),
        unitprice: $('#unitprice').val()
    };

    // Alternatives
    const alternatives = [];
    $("#alternativeBody tr").each(function() {
        const tr = $(this);
        alternatives.push({
            id: tr.attr("data-id") || null,
            unitid: tr.find(".alt-unitid").val(),
            quantity: tr.find(".alt-qty").val(),
            qtytouom: tr.find(".alt-qtytouom").val(),
            amount: tr.find(".alt-amount").val(),
            description: tr.find(".alt-description").val()
        });
    });

    // Kirim header dulu
    $.ajax({
        url: "<?= base_url('App/addIngredients') ?>",
        type: "POST",
        data: JSON.stringify(headerData),
        success: function(res) {
            // Jika header sukses, lanjut update alternatives
            $.ajax({
                url: "<?= base_url('ControllerPurchasing/saveAlternatives') ?>",
                type: "POST",
                data: { ingredientId: id, alternatives: alternatives },
                success: function(r) {
                    alert("Update berhasil!");
                    location.reload();
                },
                error: function() {
                    alert("Gagal update alternatives");
                }
            });
        },
        error: function() {
            alert("Gagal update header");
        }
    });
}

// Hitung unitprice otomatis
$(document).ready(function () {
    function calculateUnitPrice() {
        const price = parseFloat($('#price').val());
        const qty = parseFloat($('#qty').val());
        if (price > 0 && qty > 0) {
            $('#unitprice').val((price / qty).toFixed(2));
        } else {
            $('#unitprice').val(0);
        }
    }
    $('#price, #qty').on('input', calculateUnitPrice);

    // Load awal
    loadAlternatives();

    // Event tambah row
    $("#btnAddRow").on("click", addAltRow);
});
</script>



</body>

</html>
