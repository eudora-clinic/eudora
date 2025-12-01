<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>

  <style>
    .filter-container {
      display: flex;
      gap: 15px;
      align-items: center;
      padding: 10px 0;
    }

    .filter-container select {
      width: 200px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
      background-color: #fff;
      cursor: pointer;
    }

    .filter-container select:focus {
      outline: none;
      border-color: #007bff;
    }

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
      border: 1px solid #e0bfb2;
      color: #8b5e4d;
      border-radius: 8px 8px 0 0;
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
      <div class="">
        <div class="row gx-4">
          <div class="col-md-12 mt-3">
            <div id="dailySales">

              <!-- Filter -->
              <div class="card mb-4">
                <div class="row m-3">
                  <div class="col-md-3 mb-3 mt-3">
                      <label for="filterDate" class="form-label">Filter by Date</label>
                      <input type="month" id="filterDate" class="form-control" value="<?= date('Y-m') ?>">
                  </div>
              </div>
            </div>

            <div class="card">
              <div id="employeeDetail" class="card-body border-bottom pb-3">
                <h5 class="mb-1 fw-bold" id="empName"><strong>Nama: -</strong></h5>
                <p class="mb-2" id="empNip"><strong>NIP: -</strong></p>
                <hr>
                <h6 class="fw-bold">📍 Attendance Location Summary</h6>
                <ul id="locationSummary" class="list-group mt-2"></ul>
              </div>
            </div>
                

              <!-- Card utama -->
              <div class="card">
                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                  style="font-weight: bold; color: #666666;">
                  Employee Attendance History - 
                  <!-- <a href="https://sys.eudoraclinic.com:84/app/ControllerEmployeeApps/content/addEmployeeAccount"
                    class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> TAMBAH
                  </a> -->
                </h3>

                <!-- Tabs -->
                <ul class="nav nav-tabs mt-4" id="poTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tabCheckIn" data-bs-toggle="tab" data-bs-target="#paneCheckIn"
                      type="button" role="tab" style="width:100%">CHECK IN</button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tabCheckOut" data-bs-toggle="tab" data-bs-target="#paneCheckOut"
                      type="button" role="tab" style="width:100%">CHECK OUT</button>
                  </li>
                </ul>

                 <!-- Tab Content -->
                <div class="tab-content mt-3">
                  <!-- Check In -->
                  <div class="tab-pane fade show active" id="paneCheckIn" role="tabpanel">
                    <h6 id="summaryCheckIn" class="mb-3"></h6>
                    <div class="table-responsive">
                      <table id="tableCheckIn" class="table table-bordered table-striped"></table>
                    </div>
                  </div>

                  <!-- Check Out -->
                  <div class="tab-pane fade" id="paneCheckOut" role="tabpanel">
                    <h6 id="summaryCheckOut" class="mb-3"></h6>
                    <div class="table-responsive">
                      <table id="tableCheckOut" class="table table-bordered table-striped"></table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <!-- Modal Foto -->
            <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h5 class="modal-title">Photo Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body text-center">
                    <img id="photoPreview" src="" class="img-fluid rounded shadow" style="max-height:80vh;">
                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

<!-- <script>
  $(document).ready(function () {
    const baseUrl = "<?= base_url('ControllerEmployeeApps') ?>";
    const employeeId = "<?= $id ?>";

    let tableCheckIn, tableCheckOut;

    function generateColumns(month) {
      const [year, monthNum] = month.split("-");
      const lastDay = new Date(year, monthNum, 0).getDate();

      let cols = [
        { data: 'nip', title: 'NIP' },
        { data: 'name', title: 'Name' }
      ];

      for (let d = 1; d <= lastDay; d++) {
        cols.push({
          data: d,
          title: d.toString(),
          render: (data) => {
            if (!data) return `<div class="bg-absent text-danger">❌</div>`;
            
            if (data.attendance_time && data.photo) {
              return `
                <div class="text-center">
                  <small>${data.attendance_time}</small><br>
                  <button class="btn btn-sm btn-info viewPhotoBtn" 
                    data-photo="https://sys.eudoraclinic.com:84/app/${data.photo}">
                    Foto
                  </button>
                </div>
              `;
            }

            if (data.attendance_time) {
              return `<div class="bg-present text-success">✔ <small>${data.attendance_time}</small></div>`;
            }

            return `<div class="bg-present text-success">✔</div>`;
          }
        });
      }
      return cols;
    }

    // Update detail employee
    $("#empName").text("Nama: " + (res.data[0]?.name ?? "-"));
    $("#empNip").text("NIP: " + (res.data[0]?.nip ?? "-"));
    $("#totalCheckIn").text(hadirIn);
    $("#totalCheckOut").text(hadirOut);

    // Ambil summary lokasi
    $.ajax({
      url: baseUrl + "/getMonthlyAttendanceSummary",
      type: "GET",
      data: { employeeaccountid: employeeId, date: month },
      dataType: "json",
      success: function (resSum) {
        const list = $("#locationSummary");
        list.empty();

        if (resSum.status === "success" && Object.keys(resSum.summary).length > 0) {
          Object.entries(resSum.summary).forEach(([loc, count]) => {
            list.append(`
              <li class="list-group-item d-flex justify-content-between align-items-center">
                ${loc}
                <span class="badge bg-secondary rounded-pill">${count}</span>
              </li>
            `);
          });
        } else {
          list.html(`<li class="list-group-item text-muted text-center">Tidak ada data lokasi</li>`);
        }
      },
      error: function () {
        $("#locationSummary").html(`<li class="list-group-item text-muted text-center">Gagal memuat summary lokasi</li>`);
      }
    });


    function createEmptyRow(month, name = '-', nip = '-') {
      const [year, monthNum] = month.split("-");
      const lastDay = new Date(year, monthNum, 0).getDate();

      let row = { name, nip };
      for (let d = 1; d <= lastDay; d++) row[d] = null;
      return row;
    }

    function renderTables(rowIn, rowOut, month) {
      const columns = generateColumns(month);

      if ($.fn.DataTable.isDataTable("#tableCheckIn")) {
        tableCheckIn.clear().rows.add([rowIn]).draw();
      } else {
        tableCheckIn = $('#tableCheckIn').DataTable({
          data: [rowIn],
          columns,
          searching: false,
          paging: false,
          info: false,
          ordering: false,
          destroy: true
        });
      }

      if ($.fn.DataTable.isDataTable("#tableCheckOut")) {
        tableCheckOut.clear().rows.add([rowOut]).draw();
      } else {
        tableCheckOut = $('#tableCheckOut').DataTable({
          data: [rowOut],
          columns,
          searching: false,
          paging: false,
          info: false,
          ordering: false,
          destroy: true
        });
      }
    }

    function loadData(month) {
      $.ajax({
        url: baseUrl + "/getEmployeeAttendanceByIdByMonth",
        type: "GET",
        data: { employeeaccountid: employeeId, date: month },
        dataType: "json",
        success: function (res) {
          const [year, monthNum] = month.split("-");
          const lastDay = new Date(year, monthNum, 0).getDate();

          let rowIn = createEmptyRow(month);
          let rowOut = createEmptyRow(month);

          if (res.status === 'success' && res.data.length > 0) {
            const { nip, name } = res.data[0];
            rowIn.nip = rowOut.nip = nip;
            rowIn.name = rowOut.name = name;

            res.data.forEach(x => {
              const day = new Date(x.attendance_date).getDate();
              const dataObj = { status: x.status, photo: x.images, attendance_time: x.attendance_time };

              if (x.attendance_type === 'checkin') rowIn[day] = dataObj;
              if (x.attendance_type === 'checkout') rowOut[day] = dataObj;
            });
          }

          renderTables(rowIn, rowOut, month);

          const hadirIn = Object.values(rowIn).filter(v => v && v.status == 1).length;
          const hadirOut = Object.values(rowOut).filter(v => v && v.status == 1).length;
          $("#summaryCheckIn").text("Total Check In bulan ini: " + hadirIn);
          $("#summaryCheckOut").text("Total Check Out bulan ini: " + hadirOut);
        },
        error: function () {
          // Jika error, tetap render tabel kosong
          renderTables(createEmptyRow(month), createEmptyRow(month), month);
        }
      });
    }

    // Event filter bulan
    $("#filterDate").on("change", function () {
      loadData($(this).val());
    });

    // Show photo
    $(document).on("click", ".viewPhotoBtn", function () {
      const photo = $(this).data("photo");
      $("#photoPreview").attr("src", photo);
      $("#photoModal").modal("show");
    });

    // Initial load
    loadData($("#filterDate").val());
  });
</script> -->
<script>
  $(document).ready(function () {
    const baseUrl = "<?= base_url('ControllerEmployeeApps') ?>";
    const employeeId = "<?= $id ?>";

    let tableCheckIn, tableCheckOut;

    function generateColumns(month) {
      const [year, monthNum] = month.split("-");
      const lastDay = new Date(year, monthNum, 0).getDate();

      let cols = [
        { data: 'nip', title: 'NIP' },
        { data: 'name', title: 'Name' }
      ];

      for (let d = 1; d <= lastDay; d++) {
        cols.push({
          data: d,
          title: d.toString(),
          render: (data) => {
            if (!data) return `<div class="bg-absent text-danger">❌</div>`;
            
            if (data.attendance_time && data.photo) {
              return `
                <div class="text-center">
                  <small>${data.attendance_time}</small><br>
                  <button class="btn btn-sm btn-info viewPhotoBtn" 
                    data-photo="https://sys.eudoraclinic.com:84/app/${data.photo}">
                    Foto
                  </button>
                </div>
              `;
            }

            if (data.attendance_time) {
              return `<div class="bg-present text-success">✔ <small>${data.attendance_time}</small></div>`;
            }

            return `<div class="bg-present text-success">✔</div>`;
          }
        });
      }
      return cols;
    }

    function createEmptyRow(month, name = '-', nip = '-') {
      const [year, monthNum] = month.split("-");
      const lastDay = new Date(year, monthNum, 0).getDate();

      let row = { name, nip };
      for (let d = 1; d <= lastDay; d++) row[d] = null;
      return row;
    }

    function renderTables(rowIn, rowOut, month) {
      const columns = generateColumns(month);

      if ($.fn.DataTable.isDataTable("#tableCheckIn")) {
        tableCheckIn.clear().rows.add([rowIn]).draw();
      } else {
        tableCheckIn = $('#tableCheckIn').DataTable({
          data: [rowIn],
          columns,
          searching: false,
          paging: false,
          info: false,
          ordering: false,
          destroy: true
        });
      }

      if ($.fn.DataTable.isDataTable("#tableCheckOut")) {
        tableCheckOut.clear().rows.add([rowOut]).draw();
      } else {
        tableCheckOut = $('#tableCheckOut').DataTable({
          data: [rowOut],
          columns,
          searching: false,
          paging: false,
          info: false,
          ordering: false,
          destroy: true
        });
      }
    }

    function loadData(month) {
      $.ajax({
        url: baseUrl + "/getEmployeeAttendanceByIdByMonth",
        type: "GET",
        data: { employeeaccountid: employeeId, date: month },
        dataType: "json",
        success: function (res) {
          const [year, monthNum] = month.split("-");
          const lastDay = new Date(year, monthNum, 0).getDate();

          let rowIn = createEmptyRow(month);
          let rowOut = createEmptyRow(month);
          let hadirIn = 0, hadirOut = 0;

          if (res.status === 'success' && res.data.length > 0) {
            const { nip, name } = res.data[0];
            rowIn.nip = rowOut.nip = nip;
            rowIn.name = rowOut.name = name;

            res.data.forEach(x => {
              const day = new Date(x.attendance_date).getDate();
              const dataObj = { status: x.status, photo: x.images, attendance_time: x.attendance_time };

              if (x.attendance_type === 'checkin') {
                rowIn[day] = dataObj;
                if (x.status == 1) hadirIn++;
              }
              if (x.attendance_type === 'checkout') {
                rowOut[day] = dataObj;
                if (x.status == 1) hadirOut++;
              }
            });

            $("#empName").text("Nama: " + name);
            $("#empNip").text("NIP: " + nip);
            getLocationSummary(month);
          }

          renderTables(rowIn, rowOut, month);
        },
        error: function () {
          renderTables(createEmptyRow(month), createEmptyRow(month), month);
        }
      });
    }

    function getLocationSummary(month) {
      $.ajax({
        url: baseUrl + "/getMonthlyAttendanceSummary",
        type: "GET",
        data: { employeeaccountid: employeeId, date: month },
        dataType: "json",
        success: function (resSum) {
          const list = $("#locationSummary");
          list.empty();

          if (resSum.status === "success" && Object.keys(resSum.summary).length > 0) {
            Object.entries(resSum.summary).forEach(([loc, count]) => {
              list.append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  ${loc}
                  <span class="badge bg-secondary rounded-pill">${count}</span>
                </li>
              `);
            });
          } else {
            list.html(`<li class="list-group-item text-muted text-center">No location data</li>`);
          }
        },
        error: function () {
          $("#locationSummary").html(`<li class="list-group-item text-muted text-center">Gagal memuat summary lokasi</li>`);
        }
      });
    }

    // Event filter bulan
    $("#filterDate").on("change", function () {
      loadData($(this).val());
    });

    // Show photo modal
    $(document).on("click", ".viewPhotoBtn", function () {
      const photo = $(this).data("photo");
      $("#photoPreview").attr("src", photo);
      $("#photoModal").modal("show");
    });

    // Initial load
    loadData($("#filterDate").val());
  });
</script>

</html>
