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

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }
    </style>

    <?php
    $level = $this->session->userdata('level');

    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class="card p-2 col-md-9">
                <?php
                $today = date('Y-m-d');               // tanggal hari ini
                $firstOfMonth = date('Y-m-01');       // tanggal 1 di bulan ini
                $dateStartVal = !empty($dateStart) ? $dateStart : $firstOfMonth;
                $dateEndVal = !empty($dateEnd) ? $dateEnd : $today;
                ?>
                <form id="form-cari-invoice">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date Start</label>
                                <input type="date" name="dateStart" class="form-control filter_period"
                                    value="<?= $dateStartVal ?>" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Date End</label>
                                <input type="date" name="dateEnd" class="form-control filter_period"
                                    value="<?= $dateEndVal ?>" required>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <div class="form-group">
                                <button type="submit" name="submit"
                                    class="btn btn-sm top-responsive search_list_booking btn-primary"><i></i>
                                    Search</button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>

            <div class=" ">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    STOCK OPNAME: <?= $dateStartVal ?> - <?= $dateEndVal ?>

                                    <button class="btn btn-primary btn-sm btn-add">TAMBAH</button>
                                </h3>

                                <div class="row p-4 filter-container">
                                    <?php if ($level != 1) { ?>
                                        <label for="filterBranch">BRANCH:</label>
                                        <select id="filterBranch" multiple="multiple">
                                            <option value="">ALL</option>
                                            <?php foreach ($locationList as $location) { ?>
                                                <option value="<?= htmlspecialchars($location['name']) ?>">
                                                    <?= htmlspecialchars($location['name']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>
                                </div>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <div id="loadingIndicator" style=" text-align:center; margin-top: 20px;">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <p>Loading data...</p>
                                        </div>

                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%;font-family: 'Roboto', sans-serif; font-weight:900;">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">OUTLET</th>
                                                    <th style="text-align: center;">DATE</th>
                                                    <th style="text-align: center;">REMARKS</th>
                                                    <th style="text-align: center;">STATUS</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                    <th style="text-align: center;">LAMPIRAN</th>
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
                        <h5 class="modal-title">CREATE STOCK OPNAME</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <input type="" id="id">
                        <div class="modal-body">
                            <div class="form-column">
                                <label for="stockopnamedate" class="form-label mt-2"><strong> STOCK OPNAME
                                        DATE:</strong><span class="text-danger">*</span></label>
                                <input type="date" id="stockopnamedate" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="locationid" class="form-label mt-2"><strong>WAREHOUSE:</strong><span
                                        class="text-danger">*</span></label>
                                <select id="locationid" name="locationid" class="form-control" required="true"
                                    aria-required="true">
                                    <?php foreach ($locationList as $j) { ?>
                                        <option value="<?= $j['id'] ?>">
                                            <?= $j['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
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

                            <div class="form-column">
                                <label for="remarks" class="form-label mt-2"><strong>REMARKS:</strong></label>
                                <input type="text" id="remarks" class="form-control">
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
        <div class="modal fade" id="lampiranModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="formLampiran" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="lampiranId">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Lampiran</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="lampiran" accept="application/pdf" required class="form-control" />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    var numberFormat = function (number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };

        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');

        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }

        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        return s.join(dec);
    }

</script>

<script>
    $(document).ready(function () {
        const table = $('#tableDailySales').DataTable({
            pageLength: 100,
            lengthMenu: [5, 10, 15, 20, 25, 100],
            select: true,
            autoWidth: false,
            // ordering: false,
            destroy: true,
            dom: 'Bfrtip',
            buttons: ['excel']
        });

        $('#filterBranch').select2({
            width: '200px'
        });

        $('#filterBranch').on('change', function () {
            var values = $(this).val().join('|');
            table.column(1).search(values, true, false).draw();
            const totalFiltered = table.column(4, { filter: 'applied' }).data().reduce((sum, val) => {
                const num = typeof val === 'string' ? parseFloat(val.replace(/,/g, '')) : val;
                return sum + (isNaN(num) ? 0 : num);
            }, 0);
            $(table.column(4).footer()).html(totalFiltered.toLocaleString());
        });


        function fetchData() {
            const formData = $('#form-cari-invoice').serialize();
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('ControllerReport/getStockOpnameList') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rows = res.data || [];
                    const dataFormatted = [];

                    console.log(rows);


                    const formData = $('#form-cari-invoice').serializeArray();
                    const start = formData.find(item => item.name === 'dateStart')?.value;
                    const end = formData.find(item => item.name === 'dateEnd')?.value;
                    function formatDate(dateStr) {
                        const options = { month: 'short', year: 'numeric' };
                        return new Date(dateStr).toLocaleDateString('en-GB', options);
                    }

                    $('#reportTitle').text(`REPORT STOCK OPNAME: ${formatDate(start)} - ${formatDate(end)}`);
                    rows.forEach((row, i) => {

                        dataFormatted.push([
                            i + 1,
                            row.locationname || '',
                            row.stockopnamedate || '',
                            row.remarks || '',
                            (row.isactive == 1 ? 'Aktif' : (row.isactive == 0 ? 'Nonaktif' : '')),
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary"  style="cursor: pointer" data-id="${row.id}">Update</button>
                                <button class="btn-void btn-sm btn-primary"  style="cursor: pointer" data-id="${row.id}">Detail</button>
                            </div>`,
                            `
                            <td class="row justify-content-center align-items-center">
                            ${row.lampiran ? `
                            <div class="dropdown">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                                    Lampiran
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btn-view-lampiran" href="#" data-id="${row.id}" data-file="${row.lampiran}">Lihat</a>
                                    <a class="dropdown-item btn-edit-lampiran" href="#" data-id="${row.id}">Update</a>
                                </div>
                            </div>` : `
                            <button class="btn btn-sm btn-success btn-add-lampiran" data-id="${row.id}">Tambah Lampiran</button>`}
                        </td>`
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();

                    $(document).on('click', '.btn-update', function () {
                        const id = $(this).data('id');
                        openEditModal(id);
                    });

                    $(document).on('click', '.btn-void', function () {
                        const id = $(this).data('id');
                        let base_url = "<?= base_url('stockOpnameDetail'); ?>";
                        let queryParams = new URLSearchParams({
                            stock_opname_id: id
                        }).toString();
                        window.location.href = base_url + "?" + queryParams;
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

        $('#form-cari-invoice').on('submit', function (e) {
            e.preventDefault();
            fetchData();
        });
        $('.btn-add').click(function () {
            $('#createModal').modal('show');
        });

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerReport/getDetailStockOpname/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        const data = response.data
                        $('#createModal').modal('show');
                        $('#id').val(data.id);
                        $('#locationid').val(data.locationid);
                        $('#remarks').val(data.remarks);
                        let opnameDate = data.stockopnamedate.split(" ")[0];
                        $('#stockopnamedate').val(opnameDate);
                        $('#isactive').val(data.isactive);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        $('#createForm').submit(function (e) {
            e.preventDefault();
            const formData = {
                id: $('#id').val(),
                stockopnamedate: $('#stockopnamedate').val(),
                locationid: $('#locationid').val(),
                isactive: $('#isactive').val(),
                remarks: $('#remarks').val(),
            };

            $.ajax({
                url: '<?= base_url('ControllerReport/createStockOpname') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Data berhasil diperbarui');
                        $('#createModal').modal('hide');
                        fetchData();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('gatau error apa');
                }

            });
        });

        $(document).on('click', '.btn-add-lampiran, .btn-edit-lampiran', function () {
            const id = $(this).data('id');
            $('#lampiranId').val(id);
            $('#lampiranModal').modal('show');
        });

        $('#formLampiran').submit(function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            // $.ajax({
            //     url: "<?= base_url('App/uploadLampiranExpend') ?>",
            //     method: "POST",
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     dataType: 'json',
            //     success: function (res) {
            //         console.log(res);

            //         if (res.success) {
            //             alert('Lampiran berhasil diupdate');
            //             $('#lampiranModal').modal('hide');
            //             fetchData();
            //         } else {
            //             alert(res.message || 'Gagal update lampiran');
            //         }
            //     }
            // });
        });

        $(document).on('click', '.btn-view-lampiran', function () {
            const file = $(this).data('file');
            const url = "<?= base_url() ?>" + file;
            window.open(url, '_blank');
        });

        $('#createModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        function goToDetail(id, ingredientscategoryid) {
            let base_url = "<?= base_url('serviceDetail'); ?>";
            let queryParams = new URLSearchParams({
                serviceId: id,
                ingredientscategoryid: ingredientscategoryid
            }).toString();

            window.location.href = base_url + "?" + queryParams;
        }

    });
</script>



</html>