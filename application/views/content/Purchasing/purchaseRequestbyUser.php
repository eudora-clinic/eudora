<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
<div class="mycontaine container-fluid mt-3">
    
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filterDate" class="form-label">Pilih Tanggal</label>
                    <input type="date" id="filterDate" class="form-control">
                </div>
            </div>
        </div>
        <h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666;">
                            Purchase Request 
                            <a href="<?= base_url('ControllerPurchasing/content/purchaseRequest') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> TAMBAH
                            </a>
                        </h3>


        
        <ul class="nav nav-tabs mt-3" id="purchaseTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active btn btn-primary" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draftTab" type="button" role="tab" style="width:100%">Draft</button>
            </li>
            <li class="nav-item">
                <button class="nav-link btn btn-primary" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approvedTab" type="button" role="tab" style="width:100%">Approved</button>
            </li>
             <li class="nav-item">
                <button class="nav-link btn btn-primary" id="nonactive-tab" data-bs-toggle="tab" data-bs-target="#nonactiveTab" type="button" role="tab" style="width:100%">Nonactive</button>
            </li>
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content p-3 border border-top-0" id="purchaseTabsContent">
            <!-- Draft Table -->
            <div class="tab-pane fade show active" id="draftTab" role="tabpanel">
                <div class="table-wrapper p-4">    
                    <div class="table-responsive">
                            <table id="tableDraft" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>REQUEST DATE</th>
                                    <th>REQUEST NUMBER</th>
                                    <th>REQUEST BY</th>
                                    <th>DEPARTMENT</th>
                                    <th>COMPANY</th>
                                    <th>DESCRIPTION</th>
                                    <th>NOTES</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Approved Table -->
            <div class="tab-pane fade" id="approvedTab" role="tabpanel">
                <div class="table-wrapper p-4">   
                    <div class="table-responsive">
                        <table id="tableApproved" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>REQUEST DATE</th>
                                    <th>REQUEST NUMBER</th>
                                    <th>REQUEST BY</th>
                                    <th>DEPARTMENT</th>
                                    <th>COMPANY</th>
                                    <th>DESCRIPTION</th>
                                    <th>NOTES</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
            
                </div>
            </div>

            <!-- Noncative Table -->
            <div class="tab-pane fade" id="nonactiveTab" role="tabpanel">
                <div class="table-wrapper p-4">   
                    <div class="table-responsive">
                        <table id="tableNonactive" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>REQUEST DATE</th>
                                    <th>REQUEST NUMBER</th>
                                    <th>REQUEST BY</th>
                                    <th>DEPARTMENT</th>
                                    <th>COMPANY</th>
                                    <th>DESCRIPTION</th>
                                    <th>NOTES</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
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

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail Purchase Request</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
            <tbody>
                <tr><th>Request Date</th><td id="detail-requestdate"></td></tr>
                <tr><th>Request Number</th><td id="detail-requestnumber"></td></tr>
                <tr><th>Request By</th><td id="detail-requester_name"></td></tr>
                <tr><th>Department</th><td id="detail-department_name"></td></tr>
                <tr><th>Company</th><td id="detail-company_name"></td></tr>
                <tr><th>Description</th><td id="detail-description"></td></tr>
                <tr><th>Notes</th><td id="detail-notes"></td></tr>
                <tr><th>Status</th><td id="detail-status"></td></tr>
                <tr>
                    <th>Items</th>
                    <td>
                        <table class="table table-sm table-bordered mb-0" id="detail-items-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </td>
                </tr>
            </tbody>

            </table>
            <br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
$(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

    // Reusable column settings
    const columns = [
        { data: null },
        { data: 'requestdate' },
        { data: 'requestnumber' },
        { data: 'requester_name' },
        { data: 'department_name' },
        { data: 'company_name' },
        { data: 'description' },
        { data: 'notes' },
        {
            data: 'status',
            render: function(data, type, row) { // row berisi seluruh data baris
                if(row.isactive == 0){
                    return `<button class="btn btn-sm btn-secondary" disabled>Nonactive</button>`;
                }

                let statusMap = {
                    1: `<button class="btn btn-sm btn-warning" disabled>Draft</button>`,
                    2: `<button class="btn btn-sm btn-success" disabled>Approved to Purchase Order</button>`,
                    5: `<button class="btn btn-sm btn-danger" disabled>Rejected</button>`
                };

                return statusMap[data] || `<button class="btn btn-sm btn-secondary" disabled>Unknown</button>`;
            }
        },

        {
            data: 'id',
            render: function (data, type, row) {
                let editBtn = `
                    <li>
                        <a href="${Number(row.status) === 2 ? 'javascript:void(0)' : baseUrl + '/content/editPurchaseRequest/' + data}" 
                        class="edit-request ${Number(row.status) === 2 ? 'disabled' : ''}" 
                        ${Number(row.status) === 2 ? 'style="pointer-events:none; opacity:0.5;"' : ''}>
                        Edit</a>
                    </li>`;


                let toggleBtn = '';

                if (Number(row.status) !== 2) {
                    toggleBtn = `
                        <li>
                            <a href="javascript:void(0)" class="toggleActiveBtn" data-id="${data}">
                                ${Number(row.isactive) === 1 ? 'Nonaktifkan' : 'Aktifkan'}
                            </a>
                        </li>`;
                }

                return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0)" class="detailBtn" data-id="${data}">Detail</a></li>
                            ${editBtn}
                            <li><a href="${baseUrl}/generatePurchaseRequestPDF/${data}" target="_blank">Generate PDF</a></li>
                            <li class="dropdown-divider"></li>
                            ${toggleBtn}
                        </ul>
                    </div>`;
            }
        }
    ];

    // DataTable untuk Draft & Approved
    var tableDraft = $('#tableDraft').DataTable({
        columns: columns,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    var tableApproved = $('#tableApproved').DataTable({
        columns: columns,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    var tableNonactive = $('#tableNonactive').DataTable({
        columns: columns,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    // --- function load data by date ---
    function loadDataByDate(date) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseRequestByUser",
            type: 'GET',
            data: { date: date },
            dataType: 'json',
            success: function(res) {
                var data = res.data || res; 
                tableDraft.clear().rows.add(data.filter(d => Number(d.status) === 1 && Number(d.isactive) === 1 || Number(d.status) === 5 && Number(d.isactive) === 1)).draw();
                tableApproved.clear().rows.add(data.filter(d => Number(d.status) === 2 && Number(d.isactive) === 1)).draw();
                tableNonactive.clear().rows.add(data.filter(d => Number(d.isactive) === 0)).draw();
            },
            error: function(err) {
                console.error(err);
                Swal.fire('Error', 'Gagal memuat data.', 'error');
                location.reload();
            }
        });
    }

    // --- Event pilih tanggal ---
    $('#filterDate').on('change', function() {
        let selectedDate = $(this).val();
        if(selectedDate){
            loadDataByDate(selectedDate);
        }
    });

    // --- Event Detail ---
    $(document).on('click', '.detailBtn', function() {
        var purchaseOrderId = $(this).data('id');

        $.ajax({
            url: baseUrl + "/getPurchaseRequestById/" + purchaseOrderId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                if(data){
                    $('#detail-requestdate').text(data.requestdate || '-');
                    $('#detail-requestnumber').text(data.requestnumber || '-');
                    $('#detail-requester_name').text(data.requester_name || '-');
                    $('#detail-department_name').text(data.department_name || '-');
                    $('#detail-company_name').text(data.company_name || '-');
                    $('#detail-description').text(data.description || '-');
                    $('#detail-notes').text(data.notes || '-');
                    $('#detail-status').html(
                        Number(data.status) === 2
                        ? '<span class="badge bg-success">Approved</span>'
                        : '<span class="badge bg-warning">Draft</span>'
                    );

                    var $tbody = $('#detail-items-table tbody');
                    $tbody.empty();

                    if(data.items && data.items.length){
                        data.items.forEach((item, index) => {
                            $tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.itemname || '-'}</td>
                                    <td>${item.qty || '-'}</td>
                                    <td>${item.item_code || '-'}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append('<tr><td colspan="4" class="text-center">No items</td></tr>');
                    }

                    $('#detailModal').modal('show');
                }
            },
            error: function(xhr){
                console.error(xhr);
                Swal.fire('Error', 'Gagal mengambil detail purchase request.', 'error');
            }
        });
    });

    $(document).on('click', '.toggleActiveBtn', function() {
        let id = $(this).data('id');
        let confirmChange = confirm("Yakin ingin mengubah status aktif purchase request ini?");
        if (confirmChange) {
            $.post(baseUrl + "/toggleActive/" + id, function(response) {
                alert("Status berhasil diubah!");
                const date = $("#filterDate").val();
                loadDataByDate(date);
            }).fail(function() {
                alert("Gagal mengubah status!");
            });
        }
    });

    // --- Default load: hari ini ---
    let today = new Date().toISOString().split('T')[0];
    $('#filterDate').val(today);
    loadDataByDate(today);
});
</script>



</body>
</html>
