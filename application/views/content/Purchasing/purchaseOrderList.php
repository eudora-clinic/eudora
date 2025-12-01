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
                <button class="nav-link active" id="draft-tab" data-bs-toggle="tab" data-bs-target="#draftTab" type="button" role="tab" style="width:100%;">Draft</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="requested-tab" data-bs-toggle="tab" data-bs-target="#requestedTab" type="button" role="tab" style="width:100%;">Requested</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approvedTab" type="button" role="tab" style="width:100%;">Approved</button>
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
                                    <th>PR NUMBER</th>
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

            <!-- Requested Table -->
            <div class="tab-pane fade" id="requestedTab" role="tabpanel">
                <div class="table-wrapper p-4">   
                    <div class="table-responsive">
                        <table id="tableRequested" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PR NUMBER</th>
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
                                    <th>PR NUMBER</th>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

<!-- Modal Input VA -->
<div class="modal fade" id="modalVa" tabindex="-1" aria-labelledby="modalVaLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title" id="modalVaLabel">Input Virtual Account Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="formVa">
            <input type="hidden" id="va_purchaseorderid" name="purchaseorderid">
            <input type="hidden" id="va_bk_document" name="bk_document">
            <input type="hidden" id="va_vendor_invoice" name="vendor_invoice">
          <div class="mb-3">
            <label class="form-label">E-Commerce</label>
            <input type="text" class="form-control" id="va_ecommerce" name="ecommerce" placeholder="Masukkan nama E-Commerce">
        </div>
          
          <div class="mb-3">
            <label class="form-label">VA Number</label>
            <input type="text" class="form-control" id="va_number" name="va_number" required>
            <p>Format : Virtual Account Number - Bank Name</p>
          </div>

          <div class="mb-3">
            <label class="form-label">Ongkir</label>
            <input type="text" class="form-control" id="ongkir" name="ongkir">
          </div>

           <div class="mb-3">
            <label class="form-label">Biaya Lain-Lain</label>
            <input type="text" class="form-control" id="other_cost" name="other_cost">
          </div>
        </form>
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" form="formVa">Save</button>
      </div>
      
    </div>
  </div>
</div>


<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- <script>
$(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

    // Inisialisasi DataTables untuk 3 tab
    const tableDraft = $('#tableDraft').DataTable({ columns: generateColumns() });
    const tableRequested = $('#tableRequested').DataTable({ columns: generateColumns() });
    const tableApproved = $('#tableApproved').DataTable({ columns: generateColumns() });

    function generateColumns() {
        return [
            { data: null, render: (d,t,r,m)=> m.row+1 },
            { data: 'orderdate' },
            { data: 'order_number' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { data: 'status', render: function(d){
                if(d==0) return '<span class="badge bg-danger">Draft</span>';
                if(d==1) return '<span class="badge bg-warning">Requested</span>';
                if(d==2) return '<span class="badge bg-success">Approved</span>';
                return '';
            }},
            { data: 'id', render: function(data){
                return `
                <a href="${baseUrl}/generatePurchaseOrderPDF/${data}" target="_blank" class="btn btn-primary btn-sm">Cetak PDF</a>`;
            }}
        ];
    }

    // Load data sesuai tab & tanggal
    function loadData(date) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: "GET",
            data: { date: date },
            dataType: "json",
            success: function(res){
                const data = res.data || res;
                tableDraft.clear().rows.add(data.filter(x => Number(x.status)===0)).draw();
                tableRequested.clear().rows.add(data.filter(x => Number(x.status)===1)).draw();
                tableApproved.clear().rows.add(data.filter(x => Number(x.status)===2)).draw();
            },
            error: function(err){
                console.error(err);
                alert('Gagal memuat data.');
            }
        });
    }

    // Event: filter date berubah
    $('#filterDate').on('change', function() {
        loadData($(this).val());
    });

    // Event: pindah tab -> refresh tab aktif
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        loadData($('#filterDate').val());
    });

    // Load awal dengan default tanggal hari ini
    loadData($('#filterDate').val());
});
</script> -->
<!-- 
<script>
$(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerPurchasing') ?>";

    // Inisialisasi DataTables untuk 3 tab
    const tableDraft = $('#tableDraft').DataTable({ columns: generateColumns() });
    const tableRequested = $('#tableRequested').DataTable({ columns: generateColumns() });
    const tableApproved = $('#tableApproved').DataTable({ columns: generateColumns() });

    function generateColumns() {
        return [
            { data: null, render: (d,t,r,m)=> m.row+1 },
            { data: 'orderdate' },
            { data: 'order_number' },
            { data: 'orderer_name' },
            { data: 'department_name' },
            { data: 'company_name' },
            { data: 'description' },
            { data: 'notes' },
            { data: 'status', render: function(d){
                if(d==0) return '<span class="badge bg-danger">Draft</span>';
                if(d==1) return '<span class="badge bg-warning">Requested</span>';
                if(d==2) return '<span class="badge bg-success">Approved</span>';
                return '';
            }},
            { data: 'id', render: function(id, type, row){
                return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="${baseUrl}/generatePurchaseOrderPDF/${id}" target="_blank">Cetak PDF</a></li>
                            <li><a class="dropdown-item btn-detail" href="javascript:void(0)" data-id="${id}">Detail</a></li>
                            ${row.status == 0 ? `<li><a class="dropdown-item btn-request" href="javascript:void(0)" data-id="${id}">Request to Finance</a></li>` : ``}
                        </ul>
                    </div>
                `;
            }}
        ];
    }

    // Load data sesuai tab & tanggal
    function loadData(date) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: "GET",
            data: { date: date },
            dataType: "json",
            success: function(res){
                const data = res.data || res;
                tableDraft.clear().rows.add(data.filter(x => Number(x.status)===0)).draw();
                tableRequested.clear().rows.add(data.filter(x => Number(x.status)===1)).draw();
                tableApproved.clear().rows.add(data.filter(x => Number(x.status)===2)).draw();
            },
            error: function(err){
                console.error(err);
                alert('Gagal memuat data.');
            }
        });
    }

    // Event: filter date berubah
    $('#filterDate').on('change', function() {
        loadData($(this).val());
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

    // Event: Request to Finance
    $(document).on('click', '.btn-request, #btnRequestFinance', function(){
        const id = $(this).data('id');
        if(confirm("Yakin ingin request purchase order ini ke Finance?")) {
            $.ajax({
                url: baseUrl + "/requestToFinance/" + id,
                type: "POST",
                dataType: "json",
                success: function(res){
                    alert("Purchase Order berhasil direquest ke Finance.");
                    loadData($('#filterDate').val());
                    $('#modalDetail').modal('hide');
                },
                error: function(err){
                    console.error(err);
                    alert("Gagal request ke Finance.");
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

    // Inisialisasi DataTables untuk 3 tab
    const tableDraft = $('#tableDraft').DataTable({ columns: generateColumns() });
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
            { data: 'requestnumber' },
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
            {
                data: null,
                render: function (data, type, row) {
                    const orderNotes = row.order_notes ? row.order_notes.trim() : "";
                    const notes = row.notes ? row.notes.trim() : "";

                    if (orderNotes) {
                        return orderNotes; 
                    } else if (notes) {
                        return notes; 
                    } else {
                        return "-"; 
                    }
                }
            },
            { data: 'status', render: function(d){
                if(d==5) return '<span class="badge bg-danger">Rejected</span>';
                if(d==1) return '<span class="badge bg-warning">Requested to Approval Sr.Purchasing</span>';
                if(d==4) return '<span class="badge bg-warning">Requested to Make BK Finance</span>';
                if(d==7) return '<span class="badge bg-warning">Requested to CFO</span>';
                if(d==6) return '<span class="badge bg-warning">Requested to Payment</span>';
                if(d==10) return '<span class="badge bg-warning">Waiting fo Virtual Account Number</span>';
                if(d==2) return '<span class="badge bg-success">Payment at FInance</span>';
                if(d==3) return '<span class="badge bg-primary">Delivered</span>';
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


                if (row.status == 0 && level==7) {
                    actionMenu += `<li>
                        <button class="dropdown-item btn-request" data-id="${id}" 
                                data-bk="${row.bk_document}" 
                                data-invoice="${row.vendor_invoice}">
                            Request to Approve
                        </button>
                    </li>`;
                }

                if (row.status == 0 && level==7) {
                    actionMenu += `<li>
                        <a type="button" href="https://sys.eudoraclinic.com:84/app/editPurchaseOrder/${id}" class="dropdown-item">
                            Edit Purchase Order
                        </a>
                    </li>`;
                }

                if (level==7 && row.supplierid == 999) {
                    actionMenu += `<li>
                        <button class="dropdown-item btn-modalva" data-id="${id}" 
                                data-bk="${row.bk_document}" 
                                data-invoice="${row.vendor_invoice}">
                            Input Virtual Account Information
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
    function loadData(date,company) {
        $.ajax({
            url: baseUrl + "/getAllPurchaseOrderByDate",
            type: "GET",
            data: { 
                date: date,
                company:company
             },
            dataType: "json",
            success: function(res){
                const data = res.data || res;
                tableDraft.clear().rows.add(data.filter(x => Number(x.status)===0 || Number(x.status)===5)).draw();
                tableRequested.clear().rows.add(
                data.filter(x => [1,4,10,7,6].includes(Number(x.status)))
                ).draw();
                tableApproved.clear().rows.add(data.filter(x => Number(x.status)===2 || Number(x.status)===3)).draw();
            },
            error: function(err){
                console.error(err);
               
                // location.reload();
            }
        });
    }

    // Event: filter date berubah
     $("#filterDate, #filterCompany").on("change", function() {
            const date = $("#filterDate").val();
            const company = $("#filterCompany").val();
            loadData(date, company);
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
        const bk = $(this).data('bk');       // row.bk_document
        const invoice = $(this).data('invoice'); // row.vendor_invoice

        let message = '';
        if (!bk || !invoice) {
            message = "Dokumen belum lengkap. Yakin ingin request to approve?";
        } else {
            message = "Yakin ingin request approval purchase order ini?";
        }

        if (confirm(message)) {
            $.ajax({
                url: baseUrl + "/requestToApproval",
                type: "POST",
                data: { purchaseorderid: id },
                dataType: "json",
                success: function(res) {
                    if (res.success) {
                        alert(res.message);
                        loadData($('#filterDate').val());
                        $('#modalDetail').modal('hide');
                    } else {
                        alert("Gagal: " + res.message);
                    }
                },
                error: function(err) {
                    console.error(err);
                    alert("Gagal request");
                }
            });
        }
    });

    $(document).on("click", ".btn-modalva", function () {
        let id = $(this).data("id");
        let bk = $(this).data("bk");
        let invoice = $(this).data("invoice");

        // ✅ cek vendor_invoice kosong
        if (!invoice) {
            if (!confirm("Vendor invoice masih kosong. Yakin ingin menambahkan Virtual Account?")) {
                return; // stop proses
            }
        }

        // isi hidden input di form
        $("#va_purchaseorderid").val(id);
        $("#va_bk_document").val(bk);
        $("#va_vendor_invoice").val(invoice);

        $("#modalVa").modal("show");
    });

    $("#formVa").on("submit", function (e) {
        e.preventDefault();

        // ambil dari hidden input
        let id = $("#va_purchaseorderid").val(); 
        let formData = $(this).serialize();

        if (confirm("Yakin simpan Virtual Account Information?")) {
            $.ajax({
                url: "<?= base_url('ControllerPurchasing/saveVaInfo') ?>",
                type: "POST",
                data: formData, 
                success: function (res) {
                    Swal.fire("Success", "VA Information saved!", "success");
                    $("#modalVa").modal("hide");
                },
                error: function () {
                    Swal.fire("Error", "Failed to save VA Information", "error");
                }
            });
        }
    });
});
</script>


<!-- <script>
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
            render: function(data) {
                return Number(data) === 2 
                    ? `<button class="btn btn-sm btn-success" disabled>Approved</button>` 
                    : `<button class="btn btn-sm btn-warning" disabled>Draft</button>`;
            }
        },
        {
            data: 'id',
            render: function (data, type, row) {
                let approveBtn = '';
                if (Number(row.status) === 1) { 
                    approveBtn = `<li><a href="javascript:void(0)" class="approveBtn" data-id="${data}">Approve</a></li>`;
                }

                let editBtn = `
                    <li>
                        <a href="${Number(row.status) === 2 ? 'javascript:void(0)' : baseUrl + '/content/editPurchaseRequest/' + data}" 
                        class="edit-request ${Number(row.status) === 2 ? 'disabled' : ''}" 
                        ${Number(row.status) === 2 ? 'style="pointer-events:none; opacity:0.5;"' : ''}>
                        Edit</a>
                    </li>`;

                let poBtn = '';
                if (Number(row.status) === 2) {
                    poBtn = `<li><a href="${baseUrl + '/content/addPurchaseOrder/' + data}" class="po">Make Purchase Order</a></li>`;
                }

                let toggleBtn = `
                    <li>
                        <a href="javascript:void(0)" class="deleteBtn" data-id="${data}"
                        ${Number(row.status) === 2 ? 'style="pointer-events:none; opacity:0.5;"' : ''}>
                        ${Number(row.isactive) === 1 ? 'Nonaktifkan' : 'Aktifkan'}
                        </a>
                    </li>`;

                return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="javascript:void(0)" class="detailBtn" data-id="${data}">Detail</a></li>
                            ${editBtn}
                            <li><a href="${baseUrl}/generatePurchaseRequestPDF/${data}" target="_blank">Generate PDF</a></li>
                            ${approveBtn}
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
        ]
    });

    var tableApproved = $('#tableApproved').DataTable({
        columns: columns,
        columnDefs: [
            { targets: 0, render: (d,t,r,m)=> m.row+1, className:"text-center" },
            { targets: [1,2,3,4,5,6,7], className:"text-center" },
            { targets: [8,9], className:"text-center" }
        ]
    });

    function loadData() {
        $.ajax({
            url: '<?= base_url("ControllerPurchasing/getAllPurchaseRequest") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                var data = res.data || res; 
                tableDraft.clear().rows.add(data.filter(d => Number(d.status) === 1)).draw();
                tableApproved.clear().rows.add(data.filter(d => Number(d.status) === 2)).draw();
            },
            error: function(err) {
                console.error(err);
                Swal.fire('Error', 'Gagal memuat data.', 'error');
            }
        });
    }

    // Event Detail
    $(document).on('click', '.detailBtn', function() {
        var purchaseOrderId = $(this).data('id'); // Tombol harus punya data-id

        $.ajax({
            url: "<?= base_url('ControllerPurchasing/getPurchaseRequestById/') ?>" + purchaseOrderId,
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

                    // Kosongkan tabel items dulu
                    var $tbody = $('#detail-items-table tbody');
                    $tbody.empty();

                    // Loop items jika ada
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

    // Event Approve (SweetAlert2 dengan preConfirm -> AJAX)
    $(document).on('click', '.approveBtn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin ingin approve request ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Ya, Approve!',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                // preConfirm harus mengembalikan Promise. Kita bungkus AJAX.
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: baseUrl + "/approvePurchaseRequest/" + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            resolve(res);
                        },
                        error: function(xhr) {
                            reject(xhr);
                        }
                    });
                }).catch(xhr => {
                    // Tampilkan pesan validasi pada dialog (Swal2)
                    const text = xhr && xhr.responseText ? xhr.responseText : 'Server error';
                    Swal.showValidationMessage('Request failed: ' + text);
                    // lempar lagi supaya preConfirm dianggap gagal
                    throw xhr;
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const res = result.value;
                if (res && res.status === "success") {
                    Swal.fire('Sukses', 'Request berhasil di-approve!', 'success');
                    loadData();
                } else {
                    Swal.fire('Error', 'Gagal approve: ' + (res && res.message ? res.message : 'Unknown error'), 'error');
                }
            }
        });
    });

    loadData();
});
</script> -->


</body>
</html>
