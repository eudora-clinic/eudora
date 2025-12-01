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
                  <input type="date" id="filterDate" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3 mb-3 mt-3">
                        <label for="filterLocation" class="form-label">Choose a Location</label>
                            <select id="filterLocation" class="form-control">
                                <option value="">-- All Location --</option>
                                <?php foreach($locations as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                                <?php endforeach; ?>
                            </select>
                </div>
                </div>
                

              <!-- Card utama -->
              <div class="card">
                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                  style="font-weight: bold; color: #666666;">
                  Employee Account List
                  <a href="https://sys.eudoraclinic.com:84/app/ControllerEmployeeApps/content/addEmployeeAccount"
                    class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> TAMBAH
                  </a>
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
                <div class="tab-content">
                  <!-- Check In -->
                  <div class="tab-pane fade show active" id="paneCheckIn" role="tabpanel">
                    <div class="table-wrapper p-4">
                      <div class="table-responsive">
                        <table id="tableCheckIn" class="table table-striped table-bordered" style="width:100%">
                          <thead class="bg-thead">
                            <tr>
                              <th style="text-align:center;">NO</th>
                              <th style="text-align:center;">NIP</th>
                              <th style="text-align:center;">NAME</th>
                              <th style="text-align:center;">CHECK IN TIME</th>
                              <th style="text-align:center;">CHECK IN PHOTO</th>
                              <th style="text-align:center;">CHECK IN LOCATION</th>
                              <th style="text-align:center;">STATUS</th>
                              <th style="text-align:center;">ACTION</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>

                  <!-- Check Out -->
                  <div class="tab-pane fade" id="paneCheckOut" role="tabpanel">
                    <div class="table-wrapper p-4">
                      <div class="table-responsive">
                        <table id="tableCheckOut" class="table table-striped table-bordered" style="width:100%">
                          <thead class="bg-thead">
                            <tr>
                              <th style="text-align:center;">NO</th>
                              <th style="text-align:center;">NIP</th>
                              <th style="text-align:center;">NAME</th>
                              <th style="text-align:center;">CHECK OUT TIME</th>
                              <th style="text-align:center;">CHECK OUT PHOTO</th>
                              <th style="text-align:center;">CHECK OUT LOCATION</th>
                              <th style="text-align:center;">STATUS</th>
                              <th style="text-align:center;">ACTION</th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Tab Content -->
              </div>
            </div>

            <!-- Modal Foto -->
            <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="photoModalLabel">Foto Check In/Out</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body text-center">
                    <img id="photoPreview" src="" alt="Foto" style="width:400px;height:600px" class="img-fluid rounded shadow">
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
    const baseUrl = "<?= base_url('ControllerEmployeeApps') ?>";

    // Table Check In
    const tableCheckIn = $('#tableCheckIn').DataTable({
      columns: [
        { data: null, render: (d, t, r, m) => m.row + 1 },
        { data: 'nip' },
        {
          data: 'name',
          render: function (data, type, row) {
            const url = `https://sys.eudoraclinic.com:84/app/employeeAttendanceHistory/${row.employeeaccount_id}`;
            return `<a href="${url}" 
                      style="text-decoration:none;" 
                      class="text-dark" 
                      target="_blank" 
                      title="Lihat riwayat absensi ${data}">
                      ${data}
                    </a>`;
          }
        },
        { data: 'attendance_time' },
        {
          data: null,
          render: row => {
            const base64 = row.imagebase64;
            const imagePath = row.images;
            const imgSrc = base64
              ? (base64.startsWith('data:image') ? base64 : `data:image/jpeg;base64,${base64}`)
              : (imagePath ? imagePath : null);

            return imgSrc
              ? `<button class="btn btn-info btn-sm viewPhotoBtn" data-photo="${imgSrc}">Lihat Foto</button>`
              : `<span class="text-muted">Tidak ada</span>`;
          }
        },
        { data: 'locationname' },
        {
          data: 'status',
          render: d => {
            if (Number(d) === 1) return '<span class="badge bg-success">Approved</span>';
            if (Number(d) === 0) return '<span class="badge bg-danger">Rejected</span>';
            return '<span class="badge bg-secondary">Unknown</span>';
          }
        },
        {
          data: 'id',
          render: (data, type, row) => {
            return Number(row.status) === 1
              ? `<button class="btn btn-danger btn-sm rejectBtn" data-id="${data}">Reject</button>`
              : `<button class="btn btn-success btn-sm rejectBtn" data-id="${data}">Approve</button>`;
          }
        }
      ]
    });

    const tableCheckOut = $('#tableCheckOut').DataTable({
      columns: [
        { data: null, render: (d, t, r, m) => m.row + 1 },
        { data: 'nip' },
        { data: 'name' },
        { data: 'attendance_time' },
        {
          data: null,
          render: row => {
            const base64 = row.imagebase64;
            const imagePath = row.images;
            const imgSrc = base64
              ? (base64.startsWith('data:image') ? base64 : `data:image/jpeg;base64,${base64}`)
              : (imagePath ? imagePath : null);

            return imgSrc
              ? `<button class="btn btn-info btn-sm viewPhotoBtn" data-photo="${imgSrc}">Lihat Foto</button>`
              : `<span class="text-muted">Tidak ada</span>`;
          }
        },
        { data: 'locationname' },
        {
          data: 'status',
          render: d => {
            if (Number(d) === 1) return '<span class="badge bg-success">Approved</span>';
            if (Number(d) === 0) return '<span class="badge bg-danger">Rejected</span>';
            return '<span class="badge bg-secondary">Unknown</span>';
          }
        },
        {
          data: 'id',
          render: (data, type, row) => {
            return Number(row.status) === 1
              ? `<button class="btn btn-danger btn-sm rejectBtn" data-id="${data}">Reject</button>`
              : `<button class="btn btn-success btn-sm rejectBtn" data-id="${data}">Approve</button>`;
          }
        }
      ]
    });

    $(document).on('click', '.viewPhotoBtn', function () {
      const photo = $(this).data('photo');
      if (photo) {
        $('#photoPreview').attr('src', photo);
        $('#photoModal').modal('show');
      } else {
        alert('Foto tidak tersedia.');
      }
    });

    $(document).on('click', '.rejectBtn', function () {
      const id = $(this).data('id');
      if (confirm('Yakin ingin menolak kehadiran ini?')) {
        $.post(baseUrl + '/updateStatus', { id: id }, function () {
          alert('Status diubah menjadi Rejected!');
          reloadData();
        }).fail(() => alert('Gagal mengubah status!'));
      }
    });

    $(document).on('click', '.activateBtn', function () {
      const id = $(this).data('id');
      if (confirm('Yakin ingin mengaktifkan akun ini?')) {
        $.post(baseUrl + '/updateStatus', { id: id, status: 1 }, function () {
          alert('Status diubah menjadi Active!');
          reloadData();
        }).fail(() => alert('Gagal mengubah status!'));
      }
    });

    // Load data
    function loadData(date, location) {
      $.ajax({
        url: baseUrl + "/getAllEmployeeAttendance",
        type: "GET",
        data: { date: date, location: location },
        dataType: "json",
        success: function (res) {
          const data = res.data || res;
          const filtered = data.filter(x => [0, 1].includes(Number(x.isactive)));

          const checkInData = filtered.filter(x => x.attendance_type === "checkin");
          const checkOutData = filtered.filter(x => x.attendance_type === "checkout");

          tableCheckIn.clear().rows.add(checkInData).draw();
          tableCheckOut.clear().rows.add(checkOutData).draw();
        },
        error: function () {
          alert("Gagal memuat data.");
        }
      });
    }

    function reloadData() {
      const date = $("#filterDate").val();
      const location = $("#filterLocation").val();
      loadData(date, location);
    }

    $("#filterDate, #filterLocation").on("change", function () {
      reloadData();
    });

    reloadData();
  });
</script>

</html>
