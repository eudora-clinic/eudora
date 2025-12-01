<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>

    <style>
        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }


        .nav-tabs {
            border-bottom: 2px solid #e0bfb2;
        }

        .nav-tabs .nav-item {
            margin-right: 5px;
        }

        .nav-tabs .nav-link {
            background-color: #f5e5de;
            /* Warna latar belakang tab */
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            /* Warna teks */
            border-radius: 8px 8px 0 0;
            /* Membuat sudut atas membulat */
            padding: 10px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e0bfb2;
            color: white;
        }

        .nav-tabs .nav-link.active {
            background-color: #e0bfb2 !important;
            color: white;
            border-bottom: 2px solid #d1a89b;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        .tab-content {
            padding: 0 !important;
        }

        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }
    </style>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class=" ">
                <div class="row gx-4">
                    <a href="https://sys.eudoraclinic.com:84/app/listSubAccountXendit" type="button" class="btn btn-primary m-3">BACK</a>
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card p-4">
                                <!-- <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    SUBACCOUNT XENDIT
                                </h3> -->
                                <ul class="nav nav-tabs mt-3" id="purchaseTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approvedTab" type="button" role="tab" style="width:100%">ACCOUNT INFORMATION</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draftTab" type="button" role="tab" style="width:100%">TRANSACTION REPORT</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejectedTab" type="button" role="tab" style="width:100%">WITHDRAW</button>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 border border-top-0" id="purchaseTabsContent">
                                <!-- Draft Table -->
                                <div class="tab-pane fade show active" id="approvedTab" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                                                style="font-weight: bold; color: #666666;">
                                                DETAIL SUBACCOUNT XENDIT
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="table-wrapper p-4">    
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr><th width="25%">ID Subaccount</th><td id="po_id">-</td></tr>
                                                <tr><th>Email</th><td id="po_email">-</td></tr>
                                                <tr><th>Business Name</th><td id="po_businessname">-</td></tr>
                                                <tr><th>Type</th><td id="po_TYPE">-</td></tr>
                                                <tr><th>Country</th><td id="po_country">-</td></tr>
                                                <tr><th>Status</th><td id="po_status">-</td></tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                                                style="font-weight: bold; color: #666666;">
                                                DETAIL SUBACCOUNT XENDIT - BANK ACCOUNT<button class="btn btn-primary btn-sm text-right" data-bs-toggle="modal" data-bs-target="#modalAccount">
                                                <i class="bi bi-plus-circle"></i>ADD ACCOUNT
                                                </button>
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="table-wrapper p-4">    
                                        <div class="table-responsive">
                                             <table id="tableListAccount"class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Account Holder Name</th>
                                                    <th>Account Number</th>
                                                    <th>Channel Name</th>
                                                    <th>Channel Type</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rejected Table -->
                                <div class="tab-pane fade" id="draftTab" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                                                style="font-weight: bold; color: #666666;">
                                                TRANSACTION REPORT
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3 m-3">
                                        <div class="col-md-3">
                                            <label for="filterDate" class="form-label">Filter by Date</label>
                                            <input type="date" id="filterDate" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="table-wrapper p-4">   
                                        <div class="table-responsive">
                                            <table id="tableTransaction" class="table table-bordered table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Reference</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Cashflow</th>
                                                        <th>Channel</th>
                                                        <th>Amount</th>
                                                        <th>Net Amount</th>
                                                        <th>Settlement</th>
                                                        <th>Created</th>
                                                        <th>Updated</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approved Table -->
                                <div class="tab-pane fade" id="rejectedTab" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                                                style="font-weight: bold; color: #666666;">
                                                WITHDRAW FROM SUBACCOUNT XENDIT<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransaction">
                                                    WITHDRAW
                                                </button>
                                            </h3>
                                        </div>
                                    </div>
                                    
                                    <div class="table-wrapper p-4">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="25%">Account Balance</th>
                                                    <td id="account_balance">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Money Out Accumalated</th>
                                                    <td id="money_out">-</td>
                                                </tr>
                                            </tbody>
                                        </table>       
                                    </div>

                                    <div class="table-wrapper p-4">   
                                        <div class="table-responsive">
                                            <table id="tablePayoutHistory" class="table table-bordered table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Reference</th>
                                                        <th>Status</th>
                                                        <th>Channel</th>
                                                        <th>Amount</th>
                                                        <th>Description</th>
                                                        <th>Created</th>
                                                        <th>Updated</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Add Transaction -->
                    <div class="modal fade" id="modalTransaction" tabindex="-1" aria-labelledby="modalTransactionLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTransactionLabel">Request a Withdraw</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="formTransaction">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="reference_id" class="form-label"><strong>Reference ID</strong></label>
                                    <input type="text" class="form-control" id="reference_id" name="reference_id" value="MYREF-<?= date('YmdHis') ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="channel_code" class="form-label"><strong>Choose Account</strong></label>
                                    <select id="accountSelect" style="width:100%"></select>
                                </div>
                                <small id="amountInfo" class="form-text text-muted" style="display:none;"></small>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label"><strong>Withdraw Maximum</strong></label>
                                        <input type="text" class="form-control" id="balance" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label"><strong>Estimated Transfer Fee</strong></label>
                                        <input type="number" class="form-control" id="estFee" required>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="amount" class="form-label"><strong>Amount</strong></label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                    <small id="amountError" class="text-danger d-none">Amount tidak boleh melebihi batas maksimum.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="channel_code" class="form-label"><strong>Description</strong></label>
                                    <input type="text" class="form-control" id="description" name="description">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Request Withdraw</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>


                    <!-- Modal Add Account -->
                    <div class="modal fade" id="modalAccount" tabindex="-1" aria-labelledby="modalAccountLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="modalAccountLabel">Add Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form id="formAccount">
                                <div class="modal-body">
                                    <input type="hidden" name="subaccountid" value="<?= $id ?>">
                                    <div class="mb-3">
                                        <label for="account_holder_name" class="form-label">Account Holder Name</label>
                                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="account_holder_name" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="channel_name" class="form-label">Channel</label><br>
                                        <select class="form-control" id="payoutChannel" width="100%" name="channel_code"></select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Account</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEditAccount" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <form id="formEditAccount">
                                <div class="modal-header">
                                <h5 class="modal-title">Edit Account</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                <input type="hidden" id="edit_id" name="id">

                                <div class="mb-3">
                                    <label class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" id="edit_account_holder_name" name="account_holder_name" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="edit_account_number" name="account_number" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Channel Code</label>
                                    <input type="text" class="form-control" id="edit_channel_code" name="channel_code" required>
                                </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    const accountid = "<?= isset($id) ? $id : '' ?>";
    const baseUrl = "<?= base_url('') ?>";

    $('#accountSelect').select2({
        placeholder: '-- Pilih Account --',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#modalTransaction'),
        ajax: {
            url: baseUrl + "api/transactions/getAccountByAccountId/" + accountid,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                if (data.status === "success") {
                    return {
                        results: data.data.map(function(acc) {
                            return {
                                id: acc.subaccountid,
                                text: acc.account_holder_name + " (" + acc.channel_code + " - " + acc.account_number + ")",
                                raw: acc,
                                disabled: acc.isactive == 0 // ✅ Nonaktifkan opsi jika isactive = 0
                            };
                        })
                    };
                } else {
                    return { results: [] };
                }
            },
            cache: true
        }
    });

    $('#accountSelect').on('select2:select', function (e) {
        const data = e.params.data.raw; // object hasil dari processResults

        if (data && data.channel_code) {
            // Panggil API getPayoutChannel
            $.ajax({
                url: "https://sys.eudoraclinic.com:84/app/api/transactions/getPayoutChannel",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    if (res && Array.isArray(res)) {
                        // cari channel berdasarkan channel_code
                        const channel = res.find(c => c.channel_code === data.channel_code);

                        if (channel && channel.amount_limits) {
                            const min = channel.amount_limits.minimum;
                            const max = channel.amount_limits.maximum;
                            const inc = channel.amount_limits.minimum_increment;

                            // tampilkan info
                            $("#modalTransaction #amountInfo")
                            .html(`
                                <span class="badge bg-success">Mininal Withdraw: Rp ${min.toLocaleString()}</span>
                                <span class="badge bg-danger">Maximum Withdraw: Rp ${max.toLocaleString()}</span>
                                <span class="badge bg-primary">Minimum Increment: Rp ${inc.toLocaleString()}</span>
                            `)
                            .show();


                            // set batas di input amount
                            $("#modalTransaction #amount").attr({
                                "min": min,
                                "max": max,
                                "step": inc
                            });
                        } else {
                            $("#modalTransaction #amountInfo").hide();
                            $("#modalTransaction #amount").removeAttr("min max step");
                        }
                    } else {
                        console.warn("API payout channel kosong atau tidak sesuai format");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Gagal ambil payout channel:", error);
                }
            });
        }
    });

    $.ajax({
        url: baseUrl + "api/transactions/getTransactionXendit/" + accountid,
        method: "GET",
        dataType: "json",
        success: function(response) {
            let money_in = 0;
            let money_out = 0;

            if (Array.isArray(response.data)) {
                response.data.forEach(item => {
                    if (item.settlement_status === 'SETTLED') {
                        if (item.cashflow === 'MONEY_IN') {
                            money_in += Number(item.net_amount);
                        } else if (item.cashflow === 'MONEY_OUT') {
                            money_out += Number(item.amount);
                        }
                    }
                });
            }

            const cash_flow = money_in - money_out;

            // Format angka ke rupiah
            const formatRupiah = (angka) => {
                return "Rp " + angka.toLocaleString('id-ID');
            };
            $('#money_in').text(formatRupiah(money_in));
            $('#money_out').text(formatRupiah(money_out));
            $('#cash_flow').text(formatRupiah(cash_flow));

        },
        error: function(xhr, status, error) {
            console.error("Error fetching data:", error);
            $('#money_in, #money_out, #cash_flow').text("Error");
        }
    });

        
    // Event ketika pilih account
    $('#accountSelect').on('select2:select', function (e) {
        let data = e.params.data.raw;
        console.log("Account ID:", data.subaccountid);
        console.log("Account Holder:", data.account_holder_name);
        console.log("Location:", data.locationid);
    });

    $('#payoutChannel').select2({
        placeholder: '-- Pilih Payout Channel --',
        allowClear: true,
        width: '100%',
        dropdownParent: $('#modalAccount'),
        minimumInputLength: 2,
        ajax: {
            url: baseUrl + "api/transactions/getPayoutChannel",
            dataType: 'json',
            delay: 250, 
            processResults: function (data) {
                return {
                    results: $.map(data, function (v) {
                        return {
                            id: v.channel_code, 
                            text: `[${v.channel_category}] ${v.channel_name}`, 
                            category: v.channel_category,
                            currency: v.currency
                        };
                    })
                };
            },
            cache: true
        }
    });

    $('#payoutChannel').on('select2:select', function (e) {
        let data = e.params.data;
        console.log("Kode:", data.id);
        console.log("Kategori:", data.category);
        console.log("Currency:", data.currency);
    });

    let table = $("#tableListAccount").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: baseUrl + "api/transactions/getAccountByAccountId/" + accountid,
            type: "GET",
            dataSrc: function (json) {
                if (json.status === "success") {
                    return json.data;
                } else {
                    return [];
                }
            }
        },
        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; // nomor urut
                }
            },
            { data: "account_holder_name" },
            { data: "account_number" },
            { 
                data: "channel_name",
                render: function (data, type, row) {
                    return data ? data : row.channel_code;
                }
            },
            { data: "channel_code" },
            { 
                data: "isactive",
                render: function (data) {
                    if (data == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    let actionBtn = '';

                    if (row.isactive == 1) {
                        actionBtn = `<button class="btn btn-sm btn-danger toggleactive" data-id="${row.id}">Nonaktifkan</button>`;
                    } else {
                        actionBtn = `<button class="btn btn-sm btn-success toggleactive" data-id="${row.id}">Aktifkan</button>`;
                    }

                    return `
                        <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}">Edit</button>
                        ${actionBtn}
                    `;
                }
            }
        ]
    });

    let tablePayoutHistory = $("#tablePayoutHistory").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: baseUrl + "api/transactions/getPayoutHistory/" + accountid,
            type: "GET",
            dataSrc: function (json) {
                if (json.status === "success") {
                    return json.data;
                } else {
                    return [];
                }
            }
        },
        columns: [
            { data: "payout_id" },
            { data: "reference_id" },
            {
                data: "status",
                render: function(data) {
                    let badgeClass = "secondary";
                    if (data === "SUCCEEDED") badgeClass = "success";
                    else if (data === "ACCEPTED") badgeClass = "warning";
                    else if (data === "PENDING") badgeClass = "warning";
                    return `<span class="badge bg-${badgeClass}">${data}</span>`;
                }
            },
            { data: "channel_code" },
            { data: "amount", render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
            { data: "description" ?? "-" },
            { 
                data: "created",
                render: function(data) {
                    return new Date(data).toLocaleString("id-ID");
                }
            },
            { 
                data: "updated",
                render: function(data) {
                    return new Date(data).toLocaleString("id-ID");
                }
            }

        ]
    });

    $(document).on('click', '.toggleactive', function() {
        let id = $(this).data('id');
        let confirmActive = confirm("Yakin ingin mengubah status keaktifan akun ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "ControllerPaymentApps/toggleActive", 
                type: "POST",
                data: { id: id }, 
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadData(); 
                    } else {
                        alert("Gagal mengubah status!");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    });
    

    $(document).on("click", ".btn-edit", function () {
        const id = $(this).data("id");

        $.ajax({
            url: baseUrl + "ControllerPaymentApps/getAccountById/" + id,
            type: "GET",
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    let data = res.data;

                    // isi form berdasarkan data
                    $("#formEditAccount #id").val(data.id);
                    $("#formEditAccount #edit_account_holder_name").val(data.account_holder_name);
                    $("#formEditAccount #edit_account_number").val(data.account_number);
                    $("#formEditAccount #channel_code").val(data.channel_code);

                    // tampilkan modal
                    $("#modalEditAccount").modal("show");
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire("Error", "Server error", "error");
            }
        });
    });



    // submit form edit
    $("#formEditAccount").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: baseUrl + "api/transactions/updateAccount",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (res) {
                if (res.success) {
                    Swal.fire("Success", res.message, "success");
                    $("#modalEditAccount").modal("hide");
                    table.ajax.reload();
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire("Error", "Server error", "error");
            }
        });
    });

    const columnsTransaction = [
        { data: "id" },
        { data: "reference_id" },
        { data: "type" },
        {
            data: "status",
            render: function(data) {
                let badgeClass = "secondary";
                if (data === "SUCCESS") badgeClass = "success";
                else if (data === "FAILED") badgeClass = "danger";
                else if (data === "PENDING") badgeClass = "warning";
                return `<span class="badge bg-${badgeClass}">${data}</span>`;
            }
        },
        { data: "cashflow" },
        { data: "channel_code" },
        { data: "amount", render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
        { data: "net_amount", render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
        { data: "settlement_status" },
        { data: "created" },
        { data: "updated" }
    ];

    var tableTransaction = $('#tableTransaction').DataTable({
        columns: columnsTransaction,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    // --- Load Data Transaksi ---
    function loadData(date = null) {
        $.ajax({
            url: baseUrl + "api/transactions/getTransactionXendit/" + accountid,
            type: "GET",
            data: { date },
            dataType: "json",
            success: function(res) {
                var data = res.data || res; 
                tableTransaction.clear().rows.add(data).draw();
            },
            error: function(err) {
                console.error("ERROR loadData:", err);
                Swal.fire("Error", "Gagal load transaksi", "error");
            }
        });
    }

     $("#filterDate").on("change", function() {
        const date = $("#filterDate").val();
        loadData(date);
    });

    // --- Load Detail Sub Account ---
    function loadDetails(accountid){
        $.ajax({
            url: baseUrl + "api/transactions/getListSubAccountXenditById/" + accountid,
            type: "GET",
            dataType: "json",
            success: function(res){
                console.log("DEBUG RES:", res);

                if(!res || Object.keys(res).length === 0){
                    Swal.fire('Error','Data Sub Account tidak ditemukan','error');
                    return;
                }

                const account = res; // langsung pakai object

                $("#po_id").text(account.id || '-'); 
                $("#po_email").text(account.email || '-');
                $("#po_businessname").text(account.public_profile?.business_name || '-');
                $("#po_type").text(account.type || '-');
                $("#po_country").text(account.country || '-');
                $("#po_status").text(account.status || '-');
            },
            error: function(xhr, status, error){
                console.error("AJAX ERROR loadDetails:", error, xhr.responseText);
                Swal.fire('Error','Gagal load data Sub Account','error');
            }
        });
    }



    function loadBalance(accountid){
        $.ajax({
            url: baseUrl + "api/transactions/getBalanceXendit/" + accountid,
            type: "GET",
            dataType: "json",
            success: function(res){
                console.log("DEBUG RES:", res);

                if(!res || res.balance === null || res.balance === undefined){
                    Swal.fire('Error','Data Balance tidak ditemukan','error');
                    return;
                }

                let balanceFormatted = new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR' 
                }).format(res.balance);

                $("#account_balance").text(balanceFormatted);
            },
            error: function(xhr, status, error){
                console.error("AJAX ERROR loadBalance:", error, xhr.responseText);
                Swal.fire('Error','Gagal load data Balance','error');
            }
        });
    }

    if (accountid) {
        loadData();       
        loadDetails(accountid); 
        loadBalance(accountid);
    }
    $("#formAccount").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('ControllerPaymentApps/saveAccount') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                $("#formAccount button[type=submit]").prop("disabled", true).text("Saving...");
            },
            success: function (res) {
                if (res.status==="success") {
                    Swal.fire("Success", res.message, "success");
                    $("#modalAccount").modal("hide");
                    $("#formAccount")[0].reset();
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX ERROR:", error, xhr.responseText);
                Swal.fire("Error", "Terjadi kesalahan server!", "error");
            },
            complete: function () {
                $("#formAccount button[type=submit]").prop("disabled", false).text("Save Account");
            }
        });
    });

   let limitAmount = 0; 

    $.ajax({
        url: baseUrl + "api/transactions/getBalanceXendit/" + accountid,
        method: "GET",
        dataType: "json",
        success: function (res) {
            const balance = Number(res.balance) || 0;
            const fee = 2775;
            limitAmount = balance - fee;

            const formattedBalance = limitAmount.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
            });

            console.log("Saldo Xendit:", balance);
            console.log("Batas maksimum amount:", limitAmount);

            // tampilkan di input form
            $('#balance').val(formattedBalance);
            $('#estFee').val(fee);
        },
        error: function () {
            console.error("Gagal mengambil saldo dari API Xendit.");
        }
    });

   
    $("#amount").on("input", function () {
        const value = parseFloat($(this).val()) || 0;
        const errorMsg = $("#amountError");

        if (limitAmount && value > limitAmount) {
            errorMsg.removeClass("d-none").text(`Amount tidak boleh melebihi Rp ${limitAmount.toLocaleString("id-ID")}`);
            $(this).addClass("is-invalid");
        } else {
            errorMsg.addClass("d-none");
            $(this).removeClass("is-invalid");
        }
    });

   
    $("#formTransaction").on("submit", function (e) {
        e.preventDefault();

        const amount = parseFloat($("#amount").val()) || 0;

        if (limitAmount && amount > limitAmount) {
            Swal.fire(
                "Peringatan",
                `Amount tidak boleh melebihi Rp ${limitAmount.toLocaleString("id-ID")}`,
                "warning"
            );
            return;
        }

        $.ajax({
            url: "<?= base_url('ControllerPaymentApps/createPayout/') ?>" + accountid,
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                $("#formTransaction button[type=submit]").prop("disabled", true).text("Saving...");
            },
            success: function (res) {
                if (res.status === "success") {
                    let estTime = res.data && res.data.estimated_arrival_time
                        ? new Date(res.data.estimated_arrival_time).toLocaleString("id-ID", { timeZone: "Asia/Jakarta" })
                        : "-";

                    Swal.fire(
                        "Success",
                        `Berhasil melakukan withdraw. Estimasi diterima pada ${estTime}`,
                        "success"
                    );

                    $("#modalTransaction").modal("hide");
                    $("#formTransaction")[0].reset();
                    $("#amount").removeClass("is-invalid");
                    $("#amountError").addClass("d-none");
                } else {
                    Swal.fire("Error", res.message || "Terjadi kesalahan!", "error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX ERROR:", error, xhr.responseText);
                Swal.fire("Error", "Terjadi kesalahan server!", "error");
            },
            complete: function () {
                $("#formTransaction button[type=submit]").prop("disabled", false).text("Save Transaction");
            }
        });
    });

    // $("#formTransaction").on("submit", function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         url: "<?= base_url('ControllerPaymentApps/createPayout/') ?>"+accountid,
    //         type: "POST",
    //         data: $(this).serialize(),
    //         dataType: "json",
    //         beforeSend: function () {
    //             $("#formTransaction button[type=submit]").prop("disabled", true).text("Saving...");
    //         },
    //         success: function (res) {
    //             if (res.status === "success") {
    //                 let estTime = res.data && res.data.estimated_arrival_time 
    //                     ? new Date(res.data.estimated_arrival_time).toLocaleString("id-ID", { timeZone: "Asia/Jakarta" }) 
    //                     : "-";

    //                 Swal.fire(
    //                     "Success", 
    //                     `Berhasil melakukan withdraw. Estimasi diterima pada ${estTime}`, 
    //                     "success"
    //                 );

    //                 $("#modalTransaction").modal("hide");
    //                 $("#formTransaction")[0].reset();
    //             } else {
    //                 Swal.fire("Error", res.message || "Terjadi kesalahan!", "error");
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             console.error("AJAX ERROR:", error, xhr.responseText);
    //             Swal.fire("Error", "Terjadi kesalahan server!", "error");
    //         },
    //         complete: function () {
    //             $("#formTransaction button[type=submit]").prop("disabled", false).text("Save Transaction");
    //         }
    //     });
    // });
});
</script>

</html>