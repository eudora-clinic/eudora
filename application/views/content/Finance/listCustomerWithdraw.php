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
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card p-4">
                                <!-- <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    SUBACCOUNT XENDIT
                                </h3> -->
                                <ul class="nav nav-tabs mt-3" id="purchaseTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draftTab" type="button" role="tab" style="width:100%">CUSTOMER TRANSACTION APPROVEMENT</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejectedTab" type="button" role="tab" style="width:100%">CUSTOMER TRANSACTION HISTORY</button>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 border border-top-0" id="purchaseTabsContent">

                               
                                <div class="tab-pane fade show active" id="draftTab" role="tabpanel">
                                    <div class="row">
                                        <div class="col">
                                            <h3 class="card-header card-header-info d-flex justify-content-between align-items-center m-3"
                                                style="font-weight: bold; color: #666666;">
                                                CUSTOMER TRANSACTION REPORT
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
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="25%">Account Balance</th>
                                                    <td id="balance"></td>
                                                </tr>
                                                <tr>
                                                    <th width="25%">Withdraw Pending Total</th>
                                                    <td id="totalPending"></td>
                                                </tr>
                                        </table>       
                                    </div>

                                    <div class="table-wrapper p-4">   
                                        <div class="table-responsive">
                                            <table id="tableTransaction" class="table table-bordered table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Reference ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Withdraw Amount</th>
                                                        <th>Channel Code</th>
                                                        <th>Account Number</th>
                                                        <th>Account Holder Name</th>
                                                        <th>Description</th>
                                                        <th>Withdraw Status</th>
                                                        <th>Request Date</th>
                                                        <th>Approve Date</th>
                                                        <th>Action</th>
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
                                                CUSTOMER HISTORY TRANSACTION REPORT
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
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th width="25%">Account Balance</th>
                                                    <td id="balance2"></td>
                                                </tr>
                                                <tr>
                                                    <th width="25%">Withdraw Canceled Total</th>
                                                    <td id="totalCanceled"></td>
                                                </tr>
                                                <tr>
                                                    <th width="25%">Withdraw Success Total</th>
                                                    <td id="totalSucceeded"></td>
                                                </tr>
                                        </table>       
                                    </div>
                                    <div class="table-wrapper p-4">   
                                        <div class="table-responsive">
                                            <table id="tableHistory" class="table table-bordered table-striped table-hover" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Reference ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Withdraw Amount</th>
                                                        <th>Net Amount</th>
                                                        <th>Channel Code</th>
                                                        <th>Account Number</th>
                                                        <th>Account Holder Name</th>
                                                        <th>Description</th>
                                                        <th>Withdraw Status</th>
                                                        <th>Request Date</th>
                                                        <th>Approve Date</th>
                                                        <th>Action</th>
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

    const columnsTransaction = [
        { data: "id" },
        { data: "refference_id" },
        { data: "customername" },
        { data: "withdraw_amount",render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
        { data: "channel_code" },
        { data: "account_number" },
        { data: "account_holder_name" },
        { data: "description" },
        { 
            data: "withdraw_status",
            render: function (data, type, row) {
                let badgeClass = '';
                let label = data ? data.toUpperCase() : '';

                switch (data) {
                case 'PENDING':
                    badgeClass = 'badge bg-warning text-dark';
                    break;
                case 'SUCCEEDED':
                    badgeClass = 'badge bg-success';
                    break;
                case 'CANCELED':
                    badgeClass = 'badge bg-danger';
                    break;
                default:
                    badgeClass = 'badge bg-secondary';
                }

                return `<span class="${badgeClass}">${label}</span>`;
            }
        },
        { data: "request_date"},
        { data: "updatedat" },
        {
            data: null,
                render: function (data, type, row) {
                    let actionBtn = '';
                    let cancelBtn = '';

                    if (row.withdraw_status == "PENDING") {
                        actionBtn = `<button class="btn btn-sm btn-success approveBtn" data-id="${row.id}">Approve</button>`;
                        cancelBtn = `<button class="btn btn-sm btn-danger cancelBtn" data-id="${row.id}">Cancel</button>`;
                    } else if (row.withdraw_status == "ACCEPTED") {
                        actionBtn = `<button class="btn btn-sm btn-danger cancelBtn" data-id="${row.id}">Cancel</button>`;
                    } else if (row.withdraw_status == "SUCCEEDED") {
                        actionBtn = `<button class="btn btn-sm btn-success" data-id="${row.id}" disabled>SUCCESS</button>`;
                    }
                    return `
                        ${actionBtn}${cancelBtn}
                    `;
            }
        }
    ];

    const columnsHistory = [
        { data: "id" },
        { data: "refference_id" },
        { data: "customername" },
        { data: "net_amount",render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
        { data: "withdraw_amount",render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
        { data: "channel_code" },
        { data: "account_number" },
        { data: "account_holder_name" },
        { data: "description" },
        { 
            data: "withdraw_status",
            render: function (data, type, row) {
                let badgeClass = '';
                let label = data ? data.toUpperCase() : '';

                switch (data) {
                case 'PENDING':
                    badgeClass = 'badge bg-warning text-dark';
                    break;
                case 'SUCCEEDED':
                    badgeClass = 'badge bg-success';
                    break;
                case 'CANCELED':
                    badgeClass = 'badge bg-danger';
                    break;
                default:
                    badgeClass = 'badge bg-secondary';
                }

                return `<span class="${badgeClass}">${label}</span>`;
            }
        },
        { data: "request_date"},
        { data: "updatedat" },
        {
            data: null,
                render: function (data, type, row) {
                    let actionBtn = '';

                    if (row.withdraw_status == "PENDING") {
                        actionBtn = `<button class="btn btn-sm btn-success approveBtn" data-id="${row.id}">Approve</button>`;
                    } else if (row.withdraw_status == "ACCEPTED") {
                        actionBtn = `<button class="btn btn-sm btn-danger cancelBtn" data-id="${row.id}">Cancel</button>`;
                    } else if (row.withdraw_status == "SUCCEEDED") {
                        actionBtn = `<button class="btn btn-sm btn-success" data-id="${row.id}" disabled>SUCCESS</button>`;
                    } else if (row.withdraw_status == "CANCELED") {
                        actionBtn = `<button class="btn btn-sm btn-danger" data-id="${row.id}" disabled>CANCELED</button>`;
                    }
                    return `
                        ${actionBtn}
                    `;
            }
        }
    ];

    var tableTransaction = $('#tableTransaction').DataTable({
        columns: columnsTransaction,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: "_all", className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    var tableHistory = $('#tableHistory').DataTable({
        columns: columnsHistory,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: "_all", className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    function loadData(date = null) {
        $.ajax({
            url: "https://sys.eudoraclinic.com:84/app/ControllerPaymentApps/getPayoutCustomer",
            type: "GET",
            data: { date },
            dataType: "json",
            beforeSend: function() {
                $('#tableTransaction, #tableHistory').addClass('opacity-50');
            },
            success: function(res) {
                var data = res.data || res;
                var pendingAccepted = data.filter(item => 
                    item.withdraw_status === "PENDING" || item.withdraw_status === "ACCEPTED"
                );
                var succeeded = data.filter(item => 
                    item.withdraw_status === "SUCCEEDED" || item.withdraw_status === "CANCELED"
                );

                var success = data.filter(item => 
                    item.withdraw_status === "SUCCEEDED"
                );

                var pending = data.filter(item => 
                    item.withdraw_status === "PENDING"
                );

                var cancel = data.filter(item => 
                    item.withdraw_status === "CANCELED"
                );

                var totalWithdraw = data.reduce((sum, item) => {
                    var amount = parseFloat(item.withdraw_amount || 0);
                        return sum + amount;
                }, 0);

                var totalPendingAccepted = pending.reduce((sum, item) => sum + parseFloat(item.withdraw_amount || 0), 0);
                var totalSucceeded = success.reduce((sum, item) => sum + parseFloat(item.withdraw_amount || 0), 0);
                var totalCanceled = cancel.reduce((sum, item) => sum + parseFloat(item.withdraw_amount || 0), 0);

                tableTransaction.clear().rows.add(pendingAccepted).draw();
                tableHistory.clear().rows.add(succeeded).draw();

                $("#totalPending").text("Rp " + totalPendingAccepted.toLocaleString('id-ID'));
                $("#totalSucceeded").text("Rp " + totalSucceeded.toLocaleString('id-ID'));
                $("#totalCanceled").text("Rp " + totalCanceled.toLocaleString('id-ID'));
            },
            complete: function() {
                $('#tableTransaction, #tableHistory').removeClass('opacity-50');
            },
            error: function(err) {
                console.error("ERROR loadData:", err);
                Swal.fire("Error", "Gagal memuat data transaksi!", "error");
            }
        });
    }

    loadData();

     $("#filterDate").on("change", function() {
        const date = $("#filterDate").val();
        loadData(date);
    });


    $(document).on('click', '.approveBtn', function() {
        let id = $(this).data('id');
        let confirmActive = confirm("Yakin ingin approve payout customer ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "api/transactions/approvePayoutCustomer/"+id, 
                type: "POST",
                data: { id: id }, 
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadData(); 
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    });


    $.ajax({
        url: baseUrl + "api/transactions/getBalanceXenditMain",
        method: "GET",
        dataType: "json",
        success: function (res) {
            const balance = Number(res.balance) || 0;
            let balanceFormatted = new Intl.NumberFormat('id-ID', { 
                    style: 'currency', 
                    currency: 'IDR' 
                }).format(res.balance);
            
            $("#balance").text(balanceFormatted);
            $("#balance2").text(balanceFormatted);
        },
        error: function () {
            console.error("Gagal mengambil saldo dari API Xendit.");
        }
    });

    $(document).on('click', '.cancelBtn', function() {
        let id = $(this).data('id');
        let confirmActive = confirm("Yakin ingin cancel payout request customer ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "api/transactions/cancelPayoutCustomer/"+id, 
                type: "POST",
                data: { id: id }, 
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadData(); 
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    });
    
});
</script>

</html>