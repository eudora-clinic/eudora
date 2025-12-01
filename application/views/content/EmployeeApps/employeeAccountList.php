<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>

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

        /* Agar select dropdown memiliki padding lebih baik */
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
                            <div class="card">
                                <div class="col-md-3 mb-3 mt-4">
                                        <label for="filterLocation" class="form-label">Choose a Location</label>
                                            <select id="filterLocation" class="form-control">
                                                <option value="">-- All Location --</option>
                                                <?php foreach($locations as $c): ?>
                                                    <option value="<?= $c['id'] ?>"><?= $c['text'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                </div>
                                
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center mt-3" style="font-weight: bold; color: #666666;">
                                    Employee Account List
                                    <a href="https://sys.eudoraclinic.com:84/app/ControllerEmployeeApps/content/addEmployeeAccount" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> TAMBAH
                                    </a>
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableEmployeeAccount" class="table table-striped table-bordered text-center" style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">NIP</th>
                                                    <th style="text-align: center;">NAME</th>
                                                    <th style="text-align: center;">PHONE NUMBER</th>
                                                    <th style="text-align: center;">LOCATION</th>
                                                    <th style="text-align: center;">PUBLISHED</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
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
</body>
<script>
    $(document).ready(function() {
    const baseUrl = "<?= base_url('ControllerEmployeeApps') ?>";
    const level = "<?= $this->session->userdata('level') ?>";

    const tableApproved = $('#tableEmployeeAccount').DataTable({
        columns: [
            { data: null, render: (d,t,r,m)=> m.row+1 },
            { data: 'nip' },
            { data: 'name' },
            { data: 'cellphonenumber' },
            { data: 'location_name' },
            { 
                data: 'isactive', 
                render: function(d){
                    if (d == 1) {
                    return '<span class="badge bg-success">Active</span>';
                    } else if (d == 0) {
                    return '<span class="badge bg-danger">Nonactive</span>';
                    }
                }
            },
            { 
                data: 'id',
                render: function (data,row) {
                    const isActive = Number(row.isactive) === 1;
                    const btnClass = isActive ? 'btn-danger' : 'btn-success';
                    const btnText = isActive ? 'Nonaktifkan' : 'Aktifkan';

                    return `
                        <a href="javascript:void(0)" type="button" 
                            class="btn ${btnClass} btn-sm toggleActiveBtn" 
                            data-id="${data}">
                            ${btnText}
                        </a>
                        <button class="btn btn-danger btn-sm resetPasswordBtn" data-id="${data}">
                            Reset Password
                        </button>
                        <a href="https://sys.eudoraclinic.com:84/app/employeeAttendanceHistory/${data}" class="btn btn-primary btn-sm attendanceHistoryBtn">
                            Attendance History
                        </a>`;
                }
            }
        ]
    });

    $(document).on('click', '.resetPasswordBtn', function() {
        let id = $(this).data('id');
        let confirmReset = confirm("Yakin ingin mereset password akun ini?");
        if (confirmReset) {
            $.ajax({
                url: baseUrl + "/resetPassword", 
                type: "POST",
                data: { id: id },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        loadData(); 
                    } else {
                        alert("Gagal mengubah status keaktifan");
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan pada server.");
                }
            });
        }
    });

    $(document).on('click', '.toggleActiveBtn', function() {
        let id = $(this).data('id');
        let confirmActive = confirm("Yakin ingin mengubah status keaktifan akun ini?");
        if (confirmActive) {
            $.ajax({
                url: baseUrl + "/toggleActive", 
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

   $(document).ready(function () {
        function loadData(location = "") {
            $.ajax({
                url: baseUrl + "/getAllEmployeeAccount",
                type: "GET",
                data: { location: location }, 
                dataType: "json",
                success: function (res) {
                    if (res.status !== "success" || !res.data) {
                        console.warn("Data kosong atau error:", res.message);
                        tableApproved.clear().draw();
                        return;
                    }

                    // filter hanya yang aktif / tidak aktif (0 & 1)
                    const data = res.data.filter(x => [0, 1].includes(Number(x.isactive)));

                    tableApproved.clear().rows.add(data).draw();
                },
                error: function (err) {
                    console.error("Gagal memuat data:", err);
                    alert("Gagal memuat data dari server.");
                }
            });
        }

        // Event listener filter lokasi
        $("#filterLocation").on("change", function () {
            const selected = $(this).val();
            loadData(selected);
        });

        // Load awal tanpa filter
        loadData();
    });
    });
</script>


</html>