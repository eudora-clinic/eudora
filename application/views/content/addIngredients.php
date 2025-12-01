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

        /* Styling untuk form row dan column */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
            /* Biar responsif */
        }

        /* Label styling */
        .form-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        /* Input dan Select styling */
        input[type="text"],
        input[type="date"],
        input[type="number"],
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
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Styling untuk textarea */
        textarea {
            resize: vertical;
            /* Bisa diubah ukurannya */
            min-height: 100px;
        }

        /* Styling untuk select dropdown */
        select {
            background: #fff;
            cursor: pointer;
        }

        /* Untuk tombol disabled */
        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <div class="form-row">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="name" id="name">
                        <label for="code" class="form-label mt-2"><strong>CODE:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="code" id="code">
                        <label for="section" class="form-label mt-2"><strong>SECTION:</strong><span
                                class="text-danger">*</span></label>
                        <select id="section" name="section" class="" required="true" aria-required="true">
                            <option value="">-NONE-</option>
                            <option value="1">SALON</option>
                            <option value="2">DOKTER</option>
                            <option value="3">TOOLS</option>
                        </select>
                        <label for="qty" class="form-label mt-2"><strong>QTY TO UOM:</strong></label>
                        <input type="number" name="qty" id="qty"
                            >
                    </div>

                    <div class="form-column">
                        <label for="isactive" class="form-label mt-2"><strong>PUBLISHED:</strong><span
                                class="text-danger">*</span></label>
                        <select id="isactive" name="isactive" class="" required="true" aria-required="true">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        <label for="price" class="form-label mt-2"><strong>PRICE:</strong></label>
                        <input type="number" name="price" id="price" value="0">

                        <label for="uom" class="form-label mt-2"><strong>UOM:</strong><span
                                class="text-danger">*</span></label>
                        <select id="uom" name="uom" required="true" aria-required="true">
                            <?php foreach ($uomList as $j) { ?>
                                <option value="<?= $j['id'] ?>">
                                    <?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="unitprice" class="form-label mt-2"><strong>UNIT PRICE:</strong></label>
                        <input type="number" name="unitprice" id="unitprice" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <button type="button" class="btn btn-primary" onclick="addIngredients(0)"
            style="background-color: #c49e8f; color: black;">SAVE</button>
    </div>

    <script>
        function addIngredients(id) {
            const name = document.getElementById('name').value;
            const code = document.getElementById('code').value;
            const isactive = document.getElementById('isactive').value;
            const price = document.getElementById('price').value;
            const section = document.getElementById('section').value;

            const uom = document.getElementById('uom').value;
            const qty = document.getElementById('qty').value;
            const unitprice = document.getElementById('unitprice').value;

            let hasError = false;
            if (!name || !code || !isactive || !price || !section || !uom || !qty || !unitprice) {
                alert('Silakan lengkapi informasi General!');
                hasError = true;
            }

            const transactionData = {
                name,
                code,
                isactive,
                price,
                section,
                uom,
                qty,
                unitprice,
                id
            };

            if (hasError) {
                return false;
            }

            console.log(transactionData);

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/addIngredients' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    try {
                        alert('Berhasil menambah item');
                        if (response.status === 'success') {
                            setTimeout(function () {
                                location.reload();
                            }, 200);
                        } else {
                            console.error('Response tidak sesuai yang diharapkan:', response);
                            alert('Terjadi kesalahan saat mengirim data.');
                        }
                    } catch (e) {
                        console.error('JSON parsing error:', e, response);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }
         $(document).ready(function () {
            function calculateMdrPreview() {
                const price = parseFloat($('#price').val());
                const qty = parseFloat($('#qty').val());

                if (price > 0) {
                    const unitprice = (price / qty).toFixed(2);
                    $('#unitprice').val(unitprice);
                } else {
                    $('#unitprice').val(0);
                }
            }
            $('#price').on('input', calculateMdrPreview);
            $('#qty').on('input', calculateMdrPreview);
        });
    </script>
</body>

</html>