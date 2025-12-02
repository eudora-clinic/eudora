<style>
    th {
        font-weight: bold;
    }

    button {
        padding: 5px 10px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    button i {
        vertical-align: middle;
        margin-right: 3px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }


    input:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
    }

    .alert-danger {
        background-color: #dc3545;
        color: white;
    }

    .close {
        background: none;
        border: none;
        font-size: 18px;
        color: white;
        cursor: pointer;
    }

    /* Styling untuk judul */
    h5 {
        font-weight: bold;
        color: #333;
        margin-top: 20px;
    }

    /* Styling untuk responsif */
    @media screen and (max-width: 768px) {

        th,
        td {
            font-size: 14px;
            padding: 8px;
        }

        button {
            font-size: 14px;
        }

        h5 {
            font-size: 16px;
        }
    }


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

    /* Style pada select2 input (tampilan utama dropdown) */
    .select2-container--default .select2-selection--single {
        width: 100% !important;
        padding: 13px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 5px;
        transition: all 0.3s;
        height: auto;
        /* agar padding berfungsi dengan baik */
        display: flex;
        align-items: center;
    }

    /* Style pada teks yang ditampilkan di dropdown */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 14px;
        line-height: normal;
    }

    /* Style pada panah dropdown */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
    }

    #tbl-payment td:nth-child(1),
    #tbl-payment td:nth-child(2),
    #tbl-payment td:nth-child(3) {
        text-align: center;
    }

    #tbl-product td:nth-child(1),
    #tbl-product td:nth-child(2),
    #tbl-product td:nth-child(4),
    #tbl-product td:nth-child(3) {
        text-align: center;
    }


    /* Styling untuk Mobile */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
    }
</style>



<body>
    <div class="mycontaine">
        <div class="card p-2 col-md-4">
            <div class="row g-3" style="display: flex; align-items: center;">
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="text" id="no-invoice" name="no-invoice" class="form-control" required="true"
                            aria-required="true" placeholder="Invoice Down Payment Product">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" id="btn-cari" name="submit" class="btn btn-sm top-responsive  btn-primary"
                            value="true" onclick="searchInvoice()">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden">
            <button type="button" class="btn btn-sm btn-primary" onclick="updateInvoice()"
                style="background-color: #c49e8f; color: black;">UPDATE</button>

            <button id="btnStatusInvoiceVoid" type="button" class="btn btn-sm btn-primary"
                onclick="updateStatusInvoice(3)" style="background-color: #c49e8f; color: black;">VOID</button>

            <button id="btnStatusInvoiceActive" type="button" class="btn btn-sm btn-primary"
                onclick="updateStatusInvoice(10)" style="background-color: #c49e8f; color: black;">ACTIVE</button>

            <!-- <button type="button" class="btn btn-sm btn-primary" onclick="upgradeInvoice()"
                style="background-color: #c49e8f; color: black;">UPGRADE</button> -->
        </div>

        <div class="disabled" id="container-information">
            <div class="mt-2" id="role-information">
                <div class="card p-4">
                    <div class="form-row">
                        <div class="form-column">
                            <label for="name" class="form-label mt-2"><strong>CUSTOMER:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="customer-name" data-placeholder="--NONE--"></select>
                            <input hidden type="number" name="customerid" id="customerid">
                            <input hidden type="number" name="downpaymenthdrid" id="downpaymenthdrid">

                            <label for="downpaymentno" class="form-label mt-2"><strong>INVOICE:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="downpaymentno" id="downpaymentno">
                        </div>

                        <div class="form-column">
                            <label for="status" class="form-label mt-2"><strong>STATUS:</strong><span
                                    class="text-danger">*</span></label>
                            <select disabled id="status" name="status" class="" required="true" aria-required="true">
                                <option value="">--NONE--</option>
                                <option value="10">Active (Down Payment)</option>
                                <option value="3">Void</option>
                                <!-- <option value="9">Upgraded</option> -->
                            </select>

                            <label for="salesid" class="form-label mt-2"><strong>CONSULTANT:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="salesname" data-placeholder="--NONE--"></select>
                            <input hidden type="number" name="salesid" id="salesid">
                        </div>

                        <div class="form-column">
                            <label for="amount" class="form-label mt-2"><strong>AMOUNT:</strong></label>
                            <input type="number" name="amount" id="amount">
                            <label for="doctorid" class="form-label mt-2"><strong>DOCTER:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="doctorname" data-placeholder="--NONE--"></select>
                            <input hidden type="number" name="doctorid" id="doctorid">
                        </div>

                        <div class="form-column">
                            <label for="downpaymentdate" class="form-label mt-2"><strong>PURCHASEDATE:</strong></label>
                            <input type="date" name="downpaymentdate" id="downpaymentdate">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-wrapper card">
                <div class="p-4">
                    <div class="mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> ITEM PRODUCT
                        </h6>
                        <table id="tbl-product" class="table table-bordered product-list">
                            <thead class="bg-thead">
                                <tr>
                                    <th style="font-size: 12px; text-align: center;">ITEM</th>
                                    <th style="font-size: 12px; text-align: center;">QTY</th>
                                    <th style="font-size: 12px; text-align: center;">AMOUNT</th>
                                    <th style="font-size: 12px; text-align: center;">ACT</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-wrapper card">
                <div class="p-4">
                    <div class="mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> PAYMENT METHOD
                        </h6>
                        <table id="tbl-payment" class="table table-bordered payment-list">
                            <thead class="bg-thead">
                                <tr>
                                    <th style="font-size: 12px; text-align: center;">METHOD</th>
                                    <th style="font-size: 12px; text-align: center;">AMOUNT</th>
                                    <th style="font-size: 12px; text-align: center;">ACT</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="table-wrapper product-table-wrapper card">
                <div class="p-4">
                    <div class="items mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> + PAYMENT METHOD
                        </h6>
                        <table id="tbl-items" class="table table-bordered items-list">
                            <thead class="bg-thead">
                                <tr>
                                    <th style="font-size: 12px; text-align: center;">METHOD</th>
                                    <th style="font-size: 12px; text-align: center;">AMOUNT</th>
                                    <th style="font-size: 12px; text-align: center;">ACT</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <div class="row">
                            <button class="btn btn-primary btn-sm add-items">
                                <i class="bi bi-plus-circle"></i> + PAYMENT
                            </button>

                            <button class="btn btn-primary btn-sm" onclick="addPaymentMethod()">
                                <i class="bi bi-plus-circle"></i> SIMPAN
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">UPDATE PAYMENT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="updateForm">
                        <div class="form-group row">
                            <label for="paymentMethodUpdate" class="col-sm-4 col-form-label">PAYMENTMENTOD</label>
                            <div class="col-sm-8">
                                <select id="paymentMethodUpdate" name="paymentMethodUpdate" class="form-control"
                                    required>
                                    <option value="">-NONE-</option>
                                    <?php foreach ($payment_list as $j) { ?>
                                        <option value="<?= $j['id'] ?>"><?= $j['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="amountupdate">AMOUNT</label>
                            </div>

                            <div class="col-sm-8">
                                <input type="number" name="amountupdate" id="amountupdate" class="form-control"
                                    style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                    placeholder="Amount">
                            </div>
                        </div>
                        <input type="hidden" id="updateId" name="updateId">
                        <input type="number" hidden id="type" name="type" value="3">

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="updateModalProduct" tabindex="-1" role="dialog"
        aria-labelledby="updateModalProductLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalProductLabel">UPDATE DETAIL PRODUCT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="updateProductForm">
                        <div class="form-group row">
                            <label for="paymentMethodUpdate" class="col-sm-4 col-form-label">PRODUCT</label>
                            <div class="col-sm-8">
                                <select id="product-name-update" data-placeholder="--NONE--"></select>
                                <input type="number" name="idupdateProduct" id="idupdateProduct" hidden>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="amountupdateProduct">AMOUNT</label>
                            </div>

                            <div class="col-sm-8">
                                <input type="number" name="amountupdateProduct" id="amountupdateProduct"
                                    class="form-control"
                                    style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                    placeholder="Amount">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="qtyupdateProduct">QTY</label>
                            </div>

                            <div class="col-sm-8">
                                <input type="number" name="qtyupdateProduct" id="qtyupdateProduct" class="form-control"
                                    style="border: 1px solid #ced4da; border-radius: 6px; padding: 10px 12px; font-size: 16px; box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1); transition: border-color 0.3s, box-shadow 0.3s;"
                                    placeholder="Amount">
                            </div>
                        </div>

                        <input type="hidden" id="updateIdProduct" name="updateIdProduct">
                        <input type="number" hidden id="typeProduct" name="typeProduct" value="3">

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const newTable = document.querySelector(".product-table-wrapper");
        newTable.querySelector(".add-items").addEventListener("click", function () {
            const itemList = newTable.querySelector("#tbl-items tbody");
            const itemHtml = `
                            <tr>
                                <td style="text-align: center;">
                                    <select class="form-control itemsid">
                                    </select>
                                </td>
                                <td style="text-align: center;">
                                    <input value="0" type="number" class="form-control price">
                                </td>
                                <td style="text-align: center;">
                                    <button class="btn btn-danger btn-sm remove-items">DELETE</button>
                                </td>
                            </tr>
                            `;

            itemList.insertAdjacentHTML("beforeend", itemHtml);
            const lastItems = itemList.lastElementChild;
            const selectElement = $(lastItems).find(".itemsid");

            selectElement.select2({
                placeholder: "Pilih Item",
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "App/searchPaymentMethod",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(item => ({
                                id: item.id,
                                text: item.text,
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            selectElement.on("select2:select", function (e) {
                const selectedData = e.params.data;
            });

            lastItems.querySelector(".remove-items").addEventListener("click", function () {
                lastItems.remove();
            });
        });
    });

    $(document).ready(function () {
        $("#customer-name").select2({
            width: '100%',
            ajax: {
                url: "App/searchCustomer",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#customer-name").on("select2:select", function (e) {
            let data = e.params.data;
            $("#customerid").val(data.id);
        });


        $("#paymentnameupdate").select2({
            width: '100%',
            ajax: {
                url: "App/searchPaymentMethod", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    }; // Kirimkan keyword pencarian
                },
                processResults: function (data) {
                    console.log(data);

                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#paymentnameupdate").on("select2:select", function (e) {
            let data = e.params.data;
            $("#paymentidupdate").val(data.id);
        });


        $("#itemname").select2({
            width: '100%',
            ajax: {
                url: "App/searchServices", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#itemname").on("select2:select", function (e) {
            let data = e.params.data;
            $("#itempurchaseid").val(data.id);
        });

        $("#salesname").select2({
            width: '100%',
            ajax: {
                url: "App/searchConsultant", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#salesname").on("select2:select", function (e) {
            let data = e.params.data;
            $("#salesid").val(data.id);
        });


        $("#doctorname").select2({
            width: '100%',
            ajax: {
                url: "App/searchDocter", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#doctorname").on("select2:select", function (e) {
            let data = e.params.data;
            $("#doctorid").val(data.id);
        });

        $(document).on('click', '.update-btn', function () {
            let id = $(this).data('id');
            let paymentamount = $(this).data('payment-amount');
            let paymentid = $(this).data('payment-id');

            $('#updateId').val(id);
            $('#paymentMethodUpdate').val(paymentid);
            $('#amountupdate').val(paymentamount);

            // Tampilkan modal
            $('#updateModal').modal('show');
        });

        $('#updateForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Ambil data form


            console.log(formData);


            $.ajax({
                url: "<?= base_url('App/updatePaymentMethodDownPayment'); ?>",
                type: "POST",
                data: formData,
                dataType: "json", // pastikan ini "json" supaya response otomatis diparse
                success: function (response) {
                    if (response.status === 'success') {
                        $('#updateModal').modal('hide');
                        searchInvoice()
                    } else {
                        alert(response.message || 'Error updating data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error updating data:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });


        $('#tbl-payment tbody').on('click', '.delete-btn', function () {
            let invoicepaymentid = $(this).data("id");
            if (confirm("Yakin menghapus payment method?")) {
                $.ajax({
                    url: "<?= base_url('App/deletePaymentMethodDownPayment'); ?>", // Sesuaikan dengan URL
                    type: "POST",
                    data: {
                        id: invoicepaymentid,
                        type: 3
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            // showToast("Treatment Used berhasil diperbarui!", "success");
                            // location.reload();
                            searchInvoice()
                        } else {
                            // showToast("Treatment Used gagal diperbarui!", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Gagal menghapus data!");
                    }
                });
            }
        });


        $(document).on('click', '.update-btn-detail', function () {
            let id = $(this).data('id');
            let productamount = $(this).data('product-amount');
            let productid = $(this).data('product-id');
            let productname = $(this).data('product-name');
            let productqty = $(this).data('product-qty');

            // console.log(id, productamount, productid, productname);


            $('#updateIdProduct').val(id);
            $('#qtyupdateProduct').val(productqty);
            $('#amountupdateProduct').val(productamount);
            $('#product-name-update').append(
                new Option(productname, productid, true, true)
            ).trigger('change');

            $("#idupdateProduct").val(productid);

            $('#updateModalProduct').modal('show');
        });

        $("#product-name-update").select2({
            width: '100%',
            ajax: {
                url: "App/searchRetail", // Panggil controller Customer
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    console.log(data);

                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#product-name-update").on("select2:select", function (e) {
            let data = e.params.data;

            console.log(data);

            $("#idupdateProduct").val(data.id);
        });

        $('#updateProductForm').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Ambil data form


            console.log(formData);


            $.ajax({
                url: "<?= base_url('App/updateProductDownPayment'); ?>",
                type: "POST",
                data: formData,
                dataType: "json", // pastikan ini "json" supaya response otomatis diparse
                success: function (response) {
                    console.log(response);

                    if (response.status === 'success') {
                        $('#updateModalProduct').modal('hide');
                        searchInvoice()
                    } else {
                        alert(response.message || 'Error updating data');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error updating data:", error);
                    alert("Terjadi kesalahan saat menyimpan data.");
                }
            });
        });
    });

    let table = $('#tbl-payment').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": false,
        "bAutoWidth": false
    });

    let tableProduct = $('#tbl-product').DataTable({
        "paging": false,
        "searching": false,
        "info": false,
        "ordering": false,
        "bAutoWidth": false
    });

    function searchInvoice() {
        let invoice = $('#no-invoice').val();

        if (!invoice) {
            alert('Nomor invoice tidak boleh kosong!');
            return;
        }

        const data = {
            invoice,
            type: 6
        }

        $.ajax({
            url: "<?= base_url('App/search_invoice') ?>",
            method: 'GET',
            data: data,
            dataType: 'json',
            beforeSend: function () {
                $('#btn-cari').prop('disabled', true).text('Searching...');
            },
            success: function (response) {
                if (response.success) {
                    $('#container-information').removeClass('disabled');
                    $('#customer-name').append(
                        new Option(response.data.customername, response.data.customerid, true, true)
                    ).trigger('change');

                    $('#salesname').append(
                        new Option(response.data.consultantname, response.data.consultantid, true, true)
                    ).trigger('change')

                    if (response.data.doctorid) {
                        $('#doctorname').append(
                            new Option(response.data.doctorname, response.data.doctorid, true, true)
                        ).trigger('change')
                        $('#doctorid').val(response.data.doctorid);

                    }

                    if (response.data.status == 10) {
                        $('#btnStatusInvoiceActive').hide(); // atau .addClass('d-none') jika pakai Bootstrap
                        $('#btnStatusInvoiceVoid').show();
                    } else {
                        $('#btnStatusInvoiceActive').show(); // kalau status bukan 2, pastikan tombol tetap tampil
                        $('#btnStatusInvoiceVoid').hide();
                    }

                    $('#customerid').val(response.data.customerid);

                    $('#salesid').val(response.data.consultantid);

                    $('#downpaymentno').val(response.data.downpaymentno);
                    $('#downpaymentdate').val(response.data.downpaymentdate);

                    $('#status').val(response.data.status);
                    $('#amount').val(response.data.amounttotal);
                    $('#downpaymenthdrid').val(response.data.downpaymenthdrid);

                    table.clear();
                    let dataSet = [];
                    response.dataPayment.forEach(function (row) {

                        editBtn = `<button class="btn btn-primary btn-sm update-btn text-center" data-payment-amount="${row.amount}" data-id="${row.paymentid}" data-payment-id="${row.paymenttypeid}">EDIT</button>`;
                        deleteBtn = `<button class="btn btn-danger btn-sm delete-btn text-center" data-id="${row.paymentid}">DELETE</button>`;

                        dataSet.push([
                            `<td style="text-align: center" class="text-center">${row.paymentname}</td>`,
                            `<td style="text-align: center" class="text-center">${row.amount}</td>`,
                            `<td style="text-align: center" class="text-center">${editBtn} ${deleteBtn}</td>`,
                        ]);
                    });

                    table.rows.add(dataSet).draw();

                    if (response.length > 0) {
                        $("#tbl-payment").removeClass("hidden-save");
                    } else {
                        $("#tbl-payment").addClass("hidden-save");
                    }

                    tableProduct.clear();
                    let dataSetProduct = [];
                    response.dataDetail.forEach(function (row) {

                        editBtn = `<button class="btn btn-primary btn-sm update-btn-detail text-center" data-product-amount="${row.TOTAL}" data-id="${row.DTLID}" data-product-id="${row.ITEMID}" data-product-name="${row.ITEMNAME}" data-product-qty="${row.QTY}">EDIT</button>`;


                        dataSetProduct.push([
                            `<td style="text-align: center" class="text-center">${row.ITEMNAME}</td>`,
                            `<td style="text-align: center" class="text-center">${row.QTY}</td>`,
                            `<td style="text-align: center" class="text-center">${row.TOTAL}</td>`,
                            `<td style="text-align: center" class="text-center">${editBtn}</td>`,
                        ]);
                    });

                    tableProduct.rows.add(dataSetProduct).draw();

                    if (response.length > 0) {
                        $("#tbl-product").removeClass("hidden-save");
                    } else {
                        $("#tbl-product").addClass("hidden-save");
                    }
                } else {
                    alert('Invoice tidak ditemukan.');
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat mengambil data invoice.');
            },
            complete: function () {
                $('#btn-cari').prop('disabled', false).text('Search');
            }
        });
    };


    function addPaymentMethod() {
        const downpaymenthdrid = document.getElementById('downpaymenthdrid').value;
        let hasError = false;
        if (!downpaymenthdrid) {
            alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
            return false;
        }

        const selectedPrepaid = [];
        document.querySelectorAll('.product-table-wrapper').forEach(wrapper => {
            const itemsid = wrapper.querySelector('.itemsid').value;
            const price = wrapper.querySelector('.price').value;


            if (!itemsid || !price) {
                alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
                return false;
            }

            selectedPrepaid.push({
                itemsid,
                price
            });
        });

        if (selectedPrepaid.length === 0) {
            alert('Payment method dan harus diisi!');
            hasError = true;
        }

        const transactionData = {
            downpaymenthdrid,
            type: 3,
            prepaid: selectedPrepaid
        };

        if (hasError) {
            return false;
        }

        if (confirm("Yakin menambah metode?!")) {
            $.ajax({
                url: "<?= base_url() . 'App/saveAddPaymentMethodDownPayment' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    searchInvoice()
                    const itemList = document.querySelector("#tbl-items tbody");
                    itemList.innerHTML = "";
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            })
        };
    }



    function updateStatusInvoice(status) {
        const downpaymenthdrid = document.getElementById('downpaymenthdrid').value;
        let hasError = false;
        if (!downpaymenthdrid) {
            alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
            return false;
        }

        const transactionData = {
            downpaymenthdrid,
            type: 3,
            status
        };

        if (hasError) {
            return false;
        }

        if (confirm("Yakin menambah metode?!")) {
            $.ajax({
                url: "<?= base_url() . 'App/updateStatusInvoiceDownPayment' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    searchInvoice()
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            })
        };
    }

    function updateInvoice() {
        const downpaymenthdrid = document.getElementById('downpaymenthdrid').value;
        const customerid = document.getElementById('customerid').value;
        const downpaymentno = document.getElementById('downpaymentno').value;
        const salesid = document.getElementById('salesid').value;

        const downpaymentdate = document.getElementById('downpaymentdate').value;
        const doctorid = document.getElementById('doctorid').value;


        let hasError = false;
        if (!downpaymenthdrid || !customerid || !downpaymentno || !salesid || !downpaymentdate) {
            alert('Terjadi kesalahan silahkan di refresh atau login ulang!');
            return false;
        }

        const transactionData = {
            downpaymenthdrid,
            type: 3,
            customerid,
            downpaymentno,
            salesid,
            downpaymentdate,
            doctorid
        };

        if (hasError) {
            return false;
        }

        console.log(transactionData);




        if (confirm("Yakin update invoice?!")) {
            $.ajax({
                url: "<?= base_url() . 'App/updateDownpaymentInvoice' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    searchInvoice()
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            })
        };
    }
</script>

<script>
    window.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const invoiceNo = urlParams.get('invoice');

        if (invoiceNo) {
            document.getElementById('no-invoice').value = invoiceNo;

            document.getElementById('btn-cari').click();
        }
    });
</script>