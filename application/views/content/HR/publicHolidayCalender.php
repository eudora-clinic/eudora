<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    PUBLIC HOLIDAY CALENDER
                                    <button class="btn btn-primary btn-sm btn-add">TAMBAH</button>
                                </h3>

                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p>Loading data...</p>
                                        </div>

                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">No</th>
                                                    <th style="text-align: center;">Name</th>
                                                    <th style="text-align: center;">Date</th>
                                                    <th style="text-align: center;">Location</th>
                                                    <th style="text-align: center;">Description</th>
                                                    <th style="text-align: center;">Status</th>
                                                    <th style="text-align: center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="report-body">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREATE PUBLIC HOLIDAY</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <input type="number" hidden id="locationid" name="locationid" required>
                        <input type="hidden" id="updateId">
                        <div class="modal-body">
                            <div class="form-column">
                                <label for="public_holiday_name" class="form-label mt-2"><strong>Name:</strong></label>
                                <input type="text" placeholder="Public Holiday Name" id="public_holiday_name"
                                    class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="public_holiday_date" class="form-label mt-2"><strong>Date:</strong></label>
                                <input type="date" id="public_holiday_date" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="locationid" class="form-label mt-2">Location</label>
                                <select id="locationSearch" required data-placeholder="Search Location"></select>
                            </div>
                            <div class="form-column">
                                <label for="description" class="form-label mt-2"><strong>Description:</strong></label>
                                <input type="text" placeholder="description" id="description" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="" class="form-label mt-2"><strong> STATUS:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="isactive" name="isactive" class="form-control" required="true"
                                    aria-required="true">
                                    <option value="0">Nonaktif</option>
                                    <option value="1">Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function () {
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            ordering: false,
            destroy: true,
        });

        function fetchData() {
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);
            const dataFormatted = [];

            $.ajax({
                url: "<?= base_url('ControllerHr/getListPublicHolidayCalender') ?>",
                method: "GET",
                dataType: "json",
                success: function (res) {
                    res.listJobs.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.public_holiday_name || '',
                            row.public_holiday_date || '',
                            row.locationname || '',
                            row.description || '',
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary"  style="cursor: pointer" data-id="${row.id}">Update</button>
                            </div>`
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();

                    $(document).on('click', '.btn-update', function () {
                        const id = $(this).data('id');
                        openEditModal(id);
                    });
                },
                error: function () {
                    $('#report-body').html(`
                        <tr><td colspan="13" class="text-center text-danger">Gagal memuat data.</td></tr>
                    `);
                },
                complete: function () {
                    $('#loadingIndicator').hide();
                }
            });
        }


        fetchData();

        $('.btn-add').click(function () {
            $('#createModal').modal('show');
        });

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerHr/getListPublicHolidayCalenderById/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        const data = response.data
                        $('#createModal').modal('show');
                        $('#updateId').val(data.id);
                        let option = new Option(data.locationname, true);
                        $("#locationSearch").append(option).trigger("change");
                        $('#public_holiday_name').val(data.public_holiday_name);
                        let public_holiday_date = data.public_holiday_date.split(" ")[0];
                        $('#public_holiday_date').val(public_holiday_date);
                        $('#locationid').val(data.locationid);

                        $('#description').val(data.description);
                        $('#isactive').val(data.isactive);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: "Terjadi kesalahan saat proses, coba lagi!",
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        $('#createForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                id: $('#updateId').val(),
                public_holiday_name: $('#public_holiday_name').val(),
                public_holiday_date: $('#public_holiday_date').val(),
                description: $('#description').val(),
                locationid: $('#locationid').val(),
                isactive: $('#isactive').val()
            };

            $.ajax({
                url: '<?= base_url('ControllerHr/createPublicHolidayCalender') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                        $('#createModal').modal('hide');
                        fetchData();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: "Terjadi kesalahan saat proses, coba lagi!",
                        confirmButtonText: 'OK'
                    });
                }

            });
        });

        $('#createModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        $("#locationSearch").select2({
            width: '100%',
            ajax: {
                url: "ControllerMaster/searchLocation",
                dataType: "json",
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });

        $("#locationSearch").on("select2:select", function (e) {
            let data = e.params.data;
            $("#locationid").val(data.id);
        });

        $('#createModal').on('hidden.bs.modal', function () {
            $('#createForm')[0].reset();

            $('#locationSearch').val(null).trigger('change');

            $('#locationid').val('');
        });

    });
</script>



</html>