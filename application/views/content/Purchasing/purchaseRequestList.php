<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Report Guest Online Admin</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->

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
    <?php 
    $level = $this->session->userdata('level');
    ?>
<div class="mycontaine container-fluid mt-3">
    
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="filterDate" class="form-label">Choose a Date</label>
                    <input type="date" id="filterDate" class="form-control" value="">
                </div>
               <div class="col-md-3">
                <label for="filterCompany" class="form-label">Choose a Company</label>
                    <select id="filterCompany" class="form-control">
                        <option value="">-- All Companies --</option selected>
                        <?php foreach($companies as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        
    
        <h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666;">
                            Purchase Request 
                            <a href="<?= base_url('ControllerPurchasing/content/purchaseRequest') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> TAMBAH
                            </a>
                        </h3>

        <input type="hidden" name="level" id="level" value="<?= $level?>">
        
        <ul class="nav nav-tabs mt-3" id="purchaseTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draftTab" type="button" role="tab" style="width:100%">Draft</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejectedTab" type="button" role="tab" style="width:100%">Rejected</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approvedTab" type="button" role="tab" style="width:100%">Approved</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="nonactive-tab" data-bs-toggle="tab" data-bs-target="#nonactiveTab" type="button" role="tab" style="width:100%">Nonactive</button>
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
                                    <th>UPDATED DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIVE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

             <!-- Rejected Table -->
            <div class="tab-pane fade" id="rejectedTab" role="tabpanel">
                <div class="table-wrapper p-4">   
                    <div class="table-responsive">
                        <table id="tableRejected" class="table table-striped table-bordered" style="width:100%">
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
                                    <th>REJECTED DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIVE</th>
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
                                    <th>APPROVED DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIVE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
            
                </div>
            </div>

             <!-- Nonactive Table -->
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
                                    <th>UPDATED DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIVE</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
            
                </div>
            </div>
        </div>
        <!-- Fullscreen Image Modal -->
        <div id="imageFullscreenModal" 
            style="
                display:none;
                position:fixed;
                top:0;
                left:0;
                width:100%;
                height:100%;
                background:rgba(0,0,0,0.85);
                justify-content:center;
                align-items:center;
                z-index:9999;
            ">
            
            <span id="closeImageModal" 
                style="
                    position:absolute;
                    top:20px;
                    right:40px;
                    color:white;
                    font-size:40px;
                    cursor:pointer;
                    font-weight:bold;
                ">&times;</span>
            
            <img id="fullscreenImage" 
                src="" 
                style="
                    max-width:90%;
                    max-height:90%;
                    border-radius:10px;
                    box-shadow:0 0 25px rgba(255,255,255,0.3);
                    display:block;
                " 
                alt="Fullscreen Image">
        </div>

    </div>        
</div>

<!-- MODAL DETAIL -->
<!-- <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
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
</div> -->

<!-- Modal Detail Purchase Request -->
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
                        <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0" id="detail-items-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        </div>
                    </td>
                </tr>
                <!-- Tambah Notes untuk Reject -->
                <tr>
                    <th>Purchasing Notes</th>
                    <td>
                        <textarea id="purchasingNotes" class="form-control" rows="3" placeholder="Tambahkan catatan reject..."></textarea>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <input type="hidden" id="purchaseRequestId">
            <button type="button" class="btn btn-success approveBtn" id="approveBtn" data-id="">
                Approve
            </button>
            <button type="button" class="btn btn-danger rejectBtn" id="rejectBtn" data-id="">
                Reject
            </button>
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
    const level = $("#level").val();

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
            data: 'updatedat',
            render: function(data, type, row) {
                return data ? data : "-";
            }
        },
        {
            data: 'status',
            render: function(data) {
                let statusMap = {
                    1: `<button class="btn btn-sm btn-warning" disabled>Draft</button>`,
                    2: `<button class="btn btn-sm btn-success" disabled>Approved</button>`,
                    5: `<button class="btn btn-sm btn-danger" disabled>Rejected</button>`
                };
                return statusMap[data] || `<button class="btn btn-sm btn-secondary" disabled>Unknown</button>`;
            }
        },
        {
            data: 'isactive',
            render: function(data) {
                return Number(data) === 1
                    ? `<span class="badge bg-success">Aktif</span>`
                    : `<span class="badge bg-secondary">Nonaktif</span>`;
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

                let poBtn = '';
                if (Number(row.status) === 2 && level == 7) {
                    poBtn = `<li><a href="https://sys.eudoraclinic.com:84/app/addPurchaseOrder/${data}" class="po">Make Purchase Order</a></li>`;
                }

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
                            ${poBtn}
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

    var tableRejected = $('#tableRejected').DataTable({
        columns: columns,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ],
        order: [[1, "desc"]]
    });

    // --- function load data by date & company ---
    function loadDataByDateAndCompany(date, company) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseRequestByDate",
            type: 'GET',
            data: { date, company },
            dataType: 'json',
            success: function(res) {
                var data = res.data || res; 
                tableDraft.clear().rows.add(data.filter(d => Number(d.status) === 1 && Number(d.isactive) === 1)).draw();
                tableApproved.clear().rows.add(data.filter(d => Number(d.status) === 2 && Number(d.isactive) === 1)).draw();
                tableNonactive.clear().rows.add(data.filter(d => Number(d.isactive) === 0)).draw();
                tableRejected.clear().rows.add(data.filter(d => Number(d.status) === 5 && Number(d.isactive) === 1)).draw();
            },
            error: function(err) {
                console.error(err);
            }
        });
    }

    // Filter listener
    $("#filterDate, #filterCompany").on("change", function() {
        const date = $("#filterDate").val();
        const company = $("#filterCompany").val();
        loadDataByDateAndCompany(date, company);
    });

    // --- Event Detail ---
    $(document).on('click', '.detailBtn', function() {
        var purchaseOrderId = $(this).data('id');

        $.ajax({
            url: baseUrl + "/getPurchaseRequestById/" + purchaseOrderId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                if (data) {
                    // --- Isi Detail Info ---
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
                            : (Number(data.status) === 5
                                ? '<span class="badge bg-danger">Rejected</span>'
                                : '<span class="badge bg-warning">Draft</span>')
                    );

                    // --- Isi Tabel Items ---
                    var $tbody = $('#detail-items-table tbody');
                    $tbody.empty();

                    if (data.items && data.items.length) {
                        data.items.forEach((item, index) => {
                            let unitDisplay = (!item.alternativeunitid || item.alternativeunitid === "0")
                                ? (item.unit_name || '-')
                                : (item.alternativeunitname || '-');

                            // Tampilkan gambar per item
                            let imagesHtml = "";
                            if (item.images && item.images.length > 0) {
                                imagesHtml = item.images.map((img) => `
                                    <img src="${img.image_path}"
                                        class="img-thumbnail item-image"
                                        data-img="https://sys.eudoraclinic.com:84/app/${img.image_path}"
                                        style="width:60px; height:60px; object-fit:cover; cursor:pointer; margin-right:5px;">
                                `).join('');
                            } else {
                                imagesHtml = `<span class="text-muted">No Image</span>`;
                            }

                            $tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.itemname || '-'}</td>
                                    <td>${item.qty || '-'}</td>
                                    <td>${unitDisplay}</td>
                                    <td>${item.description || '-'}</td>
                                    <td>${imagesHtml}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append('<tr><td colspan="6" class="text-center">No items</td></tr>');
                    }

                    // --- Simpan ID ke Hidden Field ---
                    $("#purchaseRequestId").val(data.id);
                    $("#approveBtn").data("id", data.id);
                    $("#rejectBtn").data("id", data.id);

                    // --- Reset Notes ---
                    $("#purchasingNotes").val(""); 

                    // --- Tampilkan tombol sesuai status ---
                    if (Number(data.status) === 1 && level == 7 && Number(data.isactive) === 1) {
                        $("#approveBtn").show();
                        $("#rejectBtn").show();
                    } else {
                        $("#approveBtn").hide();
                        $("#rejectBtn").hide();
                    }

                    // --- Tampilkan Modal Detail ---
                    $('#detailModal').modal('show');
                }
            },
            error: function(xhr) {
                console.error(xhr);
                Swal.fire('Error', 'Gagal mengambil detail purchase request.', 'error');
            }
        });
    });


    $(document).on('click', '.item-image', function() {
        const imgSrc = $(this).data('img');
        $('#fullscreenImage').attr('src', imgSrc);
        $('#imageFullscreenModal').fadeIn(200);
    });

    $(document).on('click', '#closeImageModal, #imageFullscreenModal', function(e) {
        if (e.target.id === 'imageFullscreenModal' || e.target.id === 'closeImageModal') {
            $('#imageFullscreenModal').fadeOut(200);
        }
    });


    
    $(document).on('click', '#approveBtn', function() {
        let id = $(this).data('id');

        if (confirm("Yakin ingin approve request ini?")) {
            $.ajax({
                url: baseUrl + "/approvePurchaseRequest/" + id,
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res && res.status === "success") {
                        alert("Request berhasil di-approve!");
                        $("#detailModal").modal("hide");
                        const date = $("#filterDate").val();
                        const company = $("#filterCompany").val();
                        loadDataByDateAndCompany(date, company);
                    } else {
                        alert("Gagal approve: " + (res && res.message ? res.message : "Unknown error"));
                    }
                },
                error: function(xhr) {
                    const text = xhr && xhr.responseText ? xhr.responseText : "Server error";
                    alert("Request failed: " + text);
                }
            });
        }
    });


    // --- Event Toggle Active ---
    $(document).on('click', '.toggleActiveBtn', function() {
        let id = $(this).data('id');
        let confirmChange = confirm("Yakin ingin mengubah status aktif purchase request ini?");
        if (confirmChange) {
            $.post(baseUrl + "/toggleActive/" + id, function(response) {
                alert("Status berhasil diubah!");
                const date = $("#filterDate").val();
                const company = $("#filterCompany").val();
                loadDataByDateAndCompany(date, company);
            }).fail(function() {
                alert("Gagal mengubah status!");
            });
        }
    });
    // --- Event Reject ---
    // $(document).on('click', '.rejectBtn', function() {
    //     let id = $(this).data('id');
    //     let notes = $("#purchasingNotes").val();
    //     if (!notes) {
    //         Swal.fire("Peringatan", "Tambahkan catatan pada Notes!", "warning");
    //         return;
    //     }
    //     const data = { purchasingnotes: notes, purchaserequestid: id };
    //     Swal.fire({
    //         title: "Konfirmasi",
    //         text: "Yakin ingin menolak purchase request ini?",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#dc3545",
    //         confirmButtonText: "Ya, Reject!",
    //         cancelButtonText: "Batal",
    //         showLoaderOnConfirm: true,
    //         allowOutsideClick: () => !Swal.isLoading(),
    //         preConfirm: () => {
    //             return new Promise((resolve, reject) => {
    //                 $.ajax({
    //                     url: baseUrl + "/rejectPurchaseRequest",
    //                     type: "POST",
    //                     data: JSON.stringify(data),
    //                     contentType: "application/json",
    //                     dataType: "json",
    //                     success: function(res) { resolve(res); },
    //                     error: function(xhr) { reject(xhr); }
    //                 });
    //             }).catch(xhr => {
    //                 const text = xhr && xhr.responseText ? xhr.responseText : "Server error";
    //                 Swal.showValidationMessage("Request failed: " + text);
    //                 throw xhr;
    //             });
    //         }
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             const res = result.value;
    //             if (res && res.status) {
    //                 Swal.fire({
    //                     title: "Berhasil",
    //                     text: res.msg || "Purchase request berhasil di-reject!",
    //                     icon: "success",
    //                     confirmButtonText: "OK"
    //                 }).then(() => {
    //                     $("#detailModal").modal("hide");
    //                     const date = $("#filterDate").val();
    //                     const company = $("#filterCompany").val();
    //                     loadDataByDateAndCompany(date, company);
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     title: "Gagal",
    //                     text: "Gagal reject purchase request: " + (res && res.msg ? res.msg : "Unknown error"),
    //                     icon: "error"
    //                 });
    //             }
    //         }
    //     });
    // });

    $(document).on('click', '.rejectBtn', function() {
        let id = $(this).data('id');
        let notes = $("#purchasingNotes").val();
        if (!notes) {
            alert("Tambahkan catatan pada Notes!");
            return;
        }

        if (confirm("Yakin ingin menolak purchase request ini?")) {
            const data = { purchasingnotes: notes, purchaserequestid: id };

            $.ajax({
                url: baseUrl + "/rejectPurchaseRequest",
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                dataType: "json",
                success: function(res) {
                    if (res && res.status) {
                        alert(res.msg || "Purchase request berhasil di-reject!");
                        $("#detailModal").modal("hide");
                        const date = $("#filterDate").val();
                        const company = $("#filterCompany").val();
                        loadDataByDateAndCompany(date, company);
                    } else {
                        alert("Gagal reject purchase request: " + (res && res.msg ? res.msg : "Unknown error"));
                    }
                },
                error: function(xhr) {
                    const text = xhr && xhr.responseText ? xhr.responseText : "Server error";
                    alert("Request failed: " + text);
                }
            });
        }
    });

    // --- Default load: hari ini ---
    
    loadDataByDateAndCompany($('#filterDate').val(), $("#filterCompany").val());
});
</script>




</body>
</html>
