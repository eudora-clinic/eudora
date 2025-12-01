<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Purchase Order List</title>


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
<div class="mycontaine container-fluid mt-3 ">
    <div class="card">
        <div class="row mb-3 m-3">
            <div class="col-md-3">
            <label for="filterDate" class="form-label">Filter by Date</label>
            <input type="date" id="filterDate" class="form-control" value="">
        </div>
        <div class="col-md-3">
                <label for="filterCompany" class="form-label">Choose a Company</label>
                    <select id="filterCompany" class="form-control">
                        <option value="">-- All Companies --</option>
                        <?php foreach($companies as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                        <?php endforeach; ?>
                    </select>
        </div>
        </div>
        
        <h3 class="card-header card-header-info d-flex justify-content-between align-items-center mt-2" style="font-weight: bold; color: #666;">
                            PURCHASE ORDER 
                            <!-- <a href="<?= base_url('addPurchaseOrder') ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> TAMBAH
                            </a> -->
                        </h3>


        
        <ul class="nav nav-tabs mt-3" id="purchaseTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="requested-tab" data-bs-toggle="tab" data-bs-target="#requestedTab" type="button" role="tab" style="width:100%;">Requested</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approvedTab" type="button" role="tab" style="width:100%;">Approved</button>
            </li>
        </ul>

        <!-- TAB CONTENT -->
        <div class="tab-content p-3 border border-top-0" id="purchaseTabsContent">
            <!-- Requested Table -->
            <div class="tab-pane fade show active" id="requestedTab" role="tabpanel">
                <div class="table-wrapper p-4">   
                    <div class="table-responsive">
                        <table id="tableRequested" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>ORDER DATE</th>
                                    <th>ORDER NUMBER</th>
                                    <th>ORDER BY</th>
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
                                    <th>ORDER DATE</th>
                                    <th>ORDER NUMBER</th>
                                    <th>ORDER BY</th>
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

<!-- Modal Detail Purchase Order -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Purchase Order</h5>
        <button type="button" class="btn-close" data-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr><th>Order Number</th><td id="detailOrderNumber"></td></tr>
          <tr><th>Order Date</th><td id="detailOrderDate"></td></tr>
          <tr><th>Orderer</th><td id="detailOrderer"></td></tr>
          <tr><th>Company</th><td id="detailCompany"></td></tr>
          <tr><th>Department</th><td id="detailDepartment"></td></tr>
          <tr><th>Description</th><td id="detailDescription"></td></tr>
          <tr><th>Notes</th><td id="detailNotes"></td></tr>
        </table>

        <h6>Items</h6>
        <table class="table table-bordered" id="detailItems">
          <thead>
            <tr>
              <th>No</th>
              <th>Item Name</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Total Price</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnRequestFinance" class="btn btn-warning">Request to Finance</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script>
$(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";
    const level = "<?= $this->session->userdata('level') ?>";

    const tableRequested = $('#tableRequested').DataTable({ columns: generateColumns() });
    const tableApproved = $('#tableApproved').DataTable({ columns: generateColumns() });
   
    function formatTanggalIndonesia(tanggal) {
        const hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        const bulan = ["Januari","Februari","Maret","April","Mei","Juni",
                    "Juli","Agustus","September","Oktober","November","Desember"];

        let date = new Date(tanggal); // format input: YYYY-MM-DD
        let namaHari = hari[date.getDay()];
        let tgl = date.getDate();
        let namaBulan = bulan[date.getMonth()];
        let tahun = date.getFullYear();

        return `${namaHari}, ${tgl} ${namaBulan} ${tahun}`;
    }

    function formatDate(dateString) {
        const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        const months = ["January","February","March","April","May","June",
                        "July","August","September","October","November","December"];

        let date = new Date(dateString); // format input: YYYY-MM-DD
        let dayName = days[date.getDay()];
        let day = date.getDate();
        let monthName = months[date.getMonth()];
        let year = date.getFullYear();

        return `${dayName}, ${day} ${monthName} ${year}`;
    }

    function generateColumns() {
        return [
            { data: null, render: (d,t,r,m)=> m.row+1 },
            { 
                data: 'orderdate',
                render: function(data, type, row) {
                    return formatDate(data);
                }
            },
            { data: 'order_number' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { data: 'status', render: function(d){
                if(d==5) return '<span class="badge bg-primary">Draft</span>';
                if(d==5) return '<span class="badge bg-danger">Rejected</span>';
                if(d==1) return '<span class="badge bg-warning">Requested to 1</span>';
                if(d==4) return '<span class="badge bg-warning">Requested to 2</span>';
                if(d==6) return '<span class="badge bg-success">Approved </span>';
                if(d==3) return '<span class="badge bg-success">Delivered</span>';
                return '';
            }},
            { data: 'id', render: function(id, type, row){
                let actionMenu = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="${baseUrl}/generatePurchaseOrderPDF/${id}" target="_blank">Cetak PDF</a></li>
                            <li><a class="dropdown-item" href="detailPurchaseOrder/${id}" target="_blank">Detail</a></li>
                `;


                if (row.status == 1 && level == 20) {
                    actionMenu += `<li>
                        <button class="dropdown-item btn-request" data-id="${id}" data-status="${row.status}">
                            Approve
                        </button>
                    </li>`;
                    actionMenu += `<li>
                        <button class="dropdown-item btn-reject" data-id="${id}" data-status="${row.status}">
                            Reject
                        </button>
                    </li>`;
                }

                if (row.status == 4 && level == 21) {
                    actionMenu += `<li>
                        <button class="dropdown-item btn-request" data-id="${id}" data-status="${row.status}">
                            Approve
                        </button>
                    </li>`;
                    actionMenu += `<li>
                        <button class="dropdown-item btn-reject" data-id="${id}" data-status="${row.status}">
                            Reject
                        </button>
                    </li>`;
                }
                
                actionMenu += `
                        </ul>
                    </div>
                `;

                return actionMenu;
            }}
        ];
    }

    // Load data sesuai tab & tanggal
    function loadData(date, company, level) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: "GET",
            data: { 
                date: date,
                company: company
            },
            dataType: "json",
            success: function(res){
                const data = res.data || res;

                let requestedData = [];
                let approvedData = [];

                if(level == 20){
                    requestedData = data.filter(x => Number(x.status) === 1);
                    approvedData = data.filter(x => Number(x.status) === 3 );
                } 
                else if(level == 21){
                    requestedData = data.filter(x => Number(x.status) === 4);
                    approvedData = data.filter(x => Number(x.status) === 3);
                } 
                tableRequested.clear().rows.add(requestedData).draw();
                tableApproved.clear().rows.add(approvedData).draw();
            },
            error: function(err){
                console.error(err);
            }
        });
    }

    // Event: filter date berubah
     $("#filterDate, #filterCompany").on("change", function() {
            const date = $("#filterDate").val();
            const company = $("#filterCompany").val();
            const level = "<?= $this->session->userdata('level') ?>";
            loadData(date,company,level);
        });


    // Event: pindah tab -> refresh tab aktif
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        loadData($('#filterDate').val());
    });

    // Load awal dengan default tanggal hari ini
    loadData($('#filterDate').val());

    // Event: Detail
    $(document).on('click', '.btn-detail', function(){
        const id = $(this).data('id');
        $.ajax({
            url: baseUrl + "/getPurchaseOrderById/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                const order = res.order || {};
                const items = res.items || [];

                $('#detailOrderNumber').text(order.order_number);
                $('#detailOrderDate').text(order.orderdate);
                $('#detailOrderer').text(order.orderer_name);
                $('#detailCompany').text(order.company_name);
                $('#detailDepartment').text(order.department_name);
                $('#detailDescription').text(order.description);
                $('#detailNotes').text(order.notes);

                // isi table item
                let rows = "";
                items.forEach((item, i) => {
                    rows += `<tr>
                        <td>${i+1}</td>
                        <td>${item.item_name}</td>
                        <td>${item.qty}</td>
                        <td>${item.unit_price}</td>
                        <td>${item.total_price}</td>
                    </tr>`;
                });
                $('#detailItems tbody').html(rows);

                // simpan id untuk request
                $('#btnRequestFinance').data('id', id);

                $('#modalDetail').modal('show');
            },
            error: function(err) {
                console.error(err);
                alert("Gagal memuat detail purchase order.");
            }
        });
    });
  
    $(document).on('click', '.btn-request', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        let actionUrl = "";

        if(level == 20 && status == 1){
            actionUrl = baseUrl + "/approvePurchaseOrder1";
        } else if(level == 21 && status == 4){
            actionUrl = baseUrl + "/approvePurchaseOrder2";
        } else {
            alert("Anda tidak punya akses approve di status ini");
            return;
        }

        if(confirm("Yakin ingin approve purchase order ini?")) {
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: { purchaseorderid: id },
                dataType: "json",
                success: function(res){
                    if(res.success){
                        alert(res.message);
                        loadData($('#filterDate').val(), $('#filterCompany').val(), level);
                        $('#modalDetail').modal('hide');
                    } else {
                        alert("Gagal: " + res.message);
                    }
                },
                error: function(){
                    alert("Gagal request ke server.");
                }
            });
        }
    });

    $(document).on('click', '.btn-reject', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        let actionUrl = "";

        if(level == 20 && status == 1){
            actionUrl = baseUrl + "/rejectPurchaseOrder1";
        } else if(level == 21 && status == 4){
            actionUrl = baseUrl + "/rejectPurchaseOrder2";
        } else {
            alert("Anda tidak punya akses reject di status ini");
            return;
        }

        if(confirm("Yakin ingin reject purchase order ini?")) {
            $.ajax({
                url: actionUrl,
                type: "POST",
                data: { purchaseorderid: id },
                dataType: "json",
                success: function(res){
                    if(res.success){
                        alert(res.message);
                        loadData($('#filterDate').val(), $('#filterCompany').val(), level);
                        $('#modalDetail').modal('hide');
                    } else {
                        alert("Gagal: " + res.message);
                    }
                },
                error: function(){
                    alert("Gagal request ke server.");
                }
            });
        }
    });
});
</script> -->

<script>
$(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";
    const level = "<?= $this->session->userdata('level') ?>";

    // Inisialisasi DataTables
    const tableRequested = $('#tableRequested').DataTable({ columns: generateColumns() });
    const tableApproved = $('#tableApproved').DataTable({ columns: generateColumns() });
   
    function formatTanggalIndonesia(tanggal) {
        const hari = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
        const bulan = ["Januari","Februari","Maret","April","Mei","Juni",
                    "Juli","Agustus","September","Oktober","November","Desember"];
        let date = new Date(tanggal);
        return `${hari[date.getDay()]}, ${date.getDate()} ${bulan[date.getMonth()]} ${date.getFullYear()}`;
    }

    function formatDate(dateString) {
        const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        const months = ["January","February","March","April","May","June",
                        "July","August","September","October","November","December"];
        let date = new Date(dateString);
        return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
    }

    function generateColumns() {
        return [
            { data: null, render: (d,t,r,m)=> m.row+1 },
            { 
                data: 'orderdate',
                render: function(data) { return formatDate(data); }
            },
            { data: 'order_number' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { 
                data: 'status', 
                render: function(d){
                    if(d==7) return '<span class="badge bg-warning">Waiting for Approval</span>';
                    if(d==5) return '<span class="badge bg-danger">Rejected</span>';
                    if(d==1) return '<span class="badge bg-warning">Requested to Approve</span>';
                    if(d==4) return '<span class="badge bg-warning">Requested to BK Finance</span>';
                    if(d==2) return '<span class="badge bg-warning">Waiting to Invoice</span>';
                    if(d==6) return '<span class="badge bg-success">Approved</span>';
                    if(d==3) return '<span class="badge bg-success">Delivered</span>';
                    return '';
                }
            },
            { 
                data: 'id', 
                render: function(id, type, row){
                    let actionMenu = `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Action
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="${baseUrl}/generatePurchaseOrderPDF/${id}" target="_blank">Cetak PDF</a></li>
                                <li><a class="dropdown-item" href="detailPurchaseOrder/${id}" target="_blank">Detail</a></li>
                    `;
                    if (row.status == 1 && level == 20) {
                        actionMenu += `<li><button class="dropdown-item btn-request" data-id="${id}" data-status="${row.status}">Approve</button></li>`;
                        actionMenu += `<li><button class="dropdown-item btn-reject" data-id="${id}" data-status="${row.status}">Reject</button></li>`;
                    }
                    if (row.status == 7 && level == 21) {
                        actionMenu += `<li><button class="dropdown-item btn-request" data-id="${id}" data-status="${row.status}">Approve</button></li>`;
                        actionMenu += `<li><button class="dropdown-item btn-reject" data-id="${id}" data-status="${row.status}">Reject</button></li>`;
                    }

                    if (row.status == 2 && level == 24) {
                        actionMenu += `<li><button class="dropdown-item btn-request" data-id="${id}" data-status="${row.status}">Mark as authorized</button></li>`;
                    }
                    actionMenu += `</ul></div>`;
                    return actionMenu;
                }
            }
        ];
    }

    console.log(level);

    function loadData(date=null, company, level) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: "GET",
            data: { date: date, company: company },
            dataType: "json",
            success: function(res){
                const data = res.data || res;
                let requestedData = [];
                let approvedData = [];

                if(level == 20){
                    requestedData = data.filter(x => Number(x.status) === 1);
                    approvedData = data.filter(x => [2,3,4,6].includes(Number(x.status)));
                } else if(level == 21){
                    requestedData = data.filter(x => Number(x.status) === 7);
                    approvedData = data.filter(x => [2,3,6,11].includes(Number(x.status)));
                } else if (level == 24){
                    requestedData = data.filter(x => Number(x.status) === 2);
                    approvedData = data.filter(x => [3,11].includes(Number(x.status)));
                }
                else  {
                    requestedData = data.filter(x => Number(x.status) === 1);
                    approvedData = data.filter(x => [2,3].includes(Number(x.status)));
                }

                tableRequested.clear().rows.add(requestedData).draw();
                tableApproved.clear().rows.add(approvedData).draw();
            },
            error: function(err){
                console.error(err);
                alert("Gagal mengambil data dari server.");
            }
        });
    }

    // Filter event
    $("#filterDate, #filterCompany").on("change", function() {
        loadData($("#filterDate").val(), $("#filterCompany").val(), level);
    });

    // Pindah tab
    $('button[data-toggle="tab"]').on('shown.bs.tab', function() {
        loadData($('#filterDate').val(), $("#filterCompany").val(), level);
    });

    // Load awal
    loadData($('#filterDate').val(), $("#filterCompany").val(), level);

    // Detail
    $(document).on('click', '.btn-detail', function(){
        const id = $(this).data('id');
        $.ajax({
            url: baseUrl + "/getPurchaseOrderById/" + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                const order = res.order || {};
                const items = res.items || [];
                $('#detailOrderNumber').text(order.order_number);
                $('#detailOrderDate').text(order.orderdate);
                $('#detailOrderer').text(order.orderer_name);
                $('#detailCompany').text(order.company_name);
                $('#detailDepartment').text(order.department_name);
                $('#detailDescription').text(order.description);
                $('#detailNotes').text(order.notes);

                let rows = "";
                items.forEach((item, i) => {
                    rows += `<tr>
                        <td>${i+1}</td>
                        <td>${item.item_name}</td>
                        <td>${item.qty}</td>
                        <td>${item.unit_price}</td>
                        <td>${item.total_price}</td>
                    </tr>`;
                });
                $('#detailItems tbody').html(rows);
                $('#btnRequestFinance').data('id', id);
                $('#modalDetail').modal('show');
            },
            error: function() {
                alert("Gagal memuat detail purchase order.");
            }
        });
    });

    // Approve
    $(document).on('click', '.btn-request', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        let actionUrl = "";

        if(level == 20 && status == 1){
            actionUrl = baseUrl + "/approvePurchaseOrder1";
        } else if(level == 21 && status == 7){
            actionUrl = baseUrl + "/approvePurchaseOrder2";
        } else if(level == 24 && status == 2){
            actionUrl = baseUrl + "/approvePurchaseOrder3";
        } else {
            alert("Anda tidak punya akses approve di status ini");
            return;
        }

        if(confirm("Yakin ingin approve purchase order ini?")) {
            $.post(actionUrl, { purchaseorderid: id }, function(res){
                if(res.success){
                    alert(res.message);
                    loadData($('#filterDate').val(), $('#filterCompany').val(), level);
                    $('#modalDetail').modal('hide');
                } else {
                    alert("Gagal: " + res.message);
                }
            }, "json").fail(function(){
                alert("Gagal request ke server.");
            });
        }
    });

    // Reject
    $(document).on('click', '.btn-reject', function() {
        const id = $(this).data('id');
        const status = $(this).data('status');
        let actionUrl = "";

        if(level == 20 && status == 1){
            actionUrl = baseUrl + "/rejectPurchaseOrder1";
        } else if(level == 21 && status == 4){
            actionUrl = baseUrl + "/rejectPurchaseOrder2";
        } else {
            alert("Anda tidak punya akses reject di status ini");
            return;
        }

        if(confirm("Yakin ingin reject purchase order ini?")) {
            $.post(actionUrl, { purchaseorderid: id }, function(res){
                if(res.success){
                    alert(res.message);
                    loadData($('#filterDate').val(), $('#filterCompany').val(), level);
                    $('#modalDetail').modal('hide');
                } else {
                    alert("Gagal: " + res.message);
                }
            }, "json").fail(function(){
                alert("Gagal request ke server.");
            });
        }
    });
});
</script>



</body>
</html>
