<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eudora - Approved Purchase Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <style>
    .mycontaine {
      font-size: 12px !important;
    }
    .mycontaine * {
      font-size: inherit !important;
    }
    .form-label {
      font-size: 14px;
      font-weight: bold;
      color: #333;
      display: block;
    }
  </style>
</head>
<body>
<div class="mycontaine container-fluid">
  <div class="card">
    <div class="col-md-3 m-3">
      <label for="filterDate" class="form-label">Filter by Date</label>
      <input type="date" id="filterDate" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>
    <h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666;">
      Approved Purchase Orders
    </h3>

    <!-- Approved Table Only -->
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

  const tableApproved = $('#tableApproved').DataTable({
    columns: [
        { data: null, render: (d,t,r,m)=> m.row+1 },
        { data: 'orderdate' },
        { data: 'order_number' },
        { data: 'orderer_name' },
        { data: 'department_name' },
        { data: 'company_name' },
        { data: 'description' },
        { data: 'notes' },
        { 
        data: 'status', 
        render: function(d){
            if (d == 2) {
            return '<span class="badge bg-warning">Draft</span>';
            } else if (d == 3) {
            return '<span class="badge bg-success">Saved Stock</span>';
            } else {
            return '<span class="badge bg-secondary">Unknown</span>';
            }
        }
        },
        { 
        data: 'id', 
        render: function(id, type, row){
            // jika status = 3 → link langsung ke deliveryOrder
            if (row.status == 3) {
            return `
                <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="${baseUrl}/generatePurchaseOrderPDF/${id}" target="_blank">Cetak PDF</a></li>
                    <li><a class="dropdown-item" href="${baseUrl}/content/deliveryOrder/${id}">Detail</a></li>
                </ul>
                </div>
            `;
            } else {
            // default → tetap pakai modal detail
            return `
                <div class="btn-group">
                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="${baseUrl}/generatePurchaseOrderPDF/${id}" target="_blank">Cetak PDF</a></li>
                    <li><a class="dropdown-item btn-detail" href="https://sys.eudoraclinic.com:84/app/ControllerPurchasing/content/deliveryOrderChecked/${id}">Detail</a></li>
                </ul>
                </div>
            `;
            }
        }
        }
    ]
    });

  function loadData(date) {
    $.ajax({
      url: baseUrl + "/getAllDeliveryOrder",
      type: "GET",
      data: { date: date },
      dataType: "json",
      success: function(res){
        const data = res.data || res;
        tableApproved.clear().rows.add(
            data.filter(x => [1].includes(Number(x.status)))
        ).draw();

      },
      error: function(err){
        console.error(err);
        alert('Gagal memuat data.');
      }
    });
  }

  $('#filterDate').on('change', function() {
    loadData($(this).val());
  });

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

        $('#modalDetail').modal('show');
      },
      error: function(err) {
        console.error(err);
        alert("Gagal memuat detail purchase order.");
      }
    });
  });
});
</script>
</body>
</html>
