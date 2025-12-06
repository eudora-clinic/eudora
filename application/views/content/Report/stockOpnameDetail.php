<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Service Detail</title>

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
        input[type="number"],
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
        input[type="number"]:focus,
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

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        .servicename {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .servicename:focus {
            border-color: #3f51b5;
            outline: none;
            background-color: #fff;
        }

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>

    <?php
    $rawDate = $data['stockopnamedate'];
    $dateObj = new DateTime($rawDate);

    $formattedDate = $dateObj->format('Y-m-d');

    $formattedDateWithDay = strftime("%A, %d %B %Y", $dateObj->getTimestamp());
    ?>
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
                                    STOCK OPNAME: <?= $data['locationname'], ' - ', $formattedDateWithDay ?>
                                    <?php if ($this->session->userdata('userid') == 69): ?>
                                        <button class="btn btn-primary btn-sm btn-adjust" id="btn-adjust">
                                            ADJUST ALL
                                        </button>
                                    <?php endif; ?>

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
                                            style="width:100%;font-family: 'Roboto', sans-serif; font-weight:900;">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">ITEM</th>
                                                    <th style="text-align: center;">CODE</th>
                                                    <th style="text-align: center;">UNIT</th>
                                                    <th style="text-align: center;">CURRENT STOCK</th>
                                                    <th style="text-align: center;">STOCK REAL</th>
                                                    <th style="text-align: center;">DIFFERENCE</th>
                                                    <th style="text-align: center;">NOTE</th>
                                                    <th style="text-align: center;">EXP.DATE</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                    <th style="text-align: center;">ADJUST IN BEFORE SO</th>
                                                    <th style="text-align: center;">ADJUST OUT BEFORE SO</th>
                                                    <th style="text-align: center;">ADJUSTIN THIS SO</th>
                                                    <th style="text-align: center;">ADJUSTOUT THIS SO</th>
                                                    <th style="text-align: center;">STATUS</th>
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
        <!-- <div class="modal fade" id="createModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CREATE STOCK OPNAME</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="createForm">
                        <input type="hidden" id="ingredientid">
                        <input type="hidden" id="stock_opname_id">
                        <div class="modal-body">
                            <div class="form-column">
                                <label for="ingredientname" class="form-label mt-2"><strong>INGREDIENT
                                        NAME:</strong><span class="text-danger">*</span></label>
                                <input disabled type="text" id="ingredientname" class="form-control" required>
                            </div>
                            <div class="form-column">
                                <label for="ingredientcode" class="form-label mt-2"><strong>INGREDIENT
                                        CODE:</strong><span class="text-danger">*</span></label>
                                <input disabled type="text" id="ingredientcode" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="last_stock" class="form-label mt-2"><strong>STOCK SISTEM:</strong><span
                                        class="text-danger">*</span></label>
                                <input disabled type="text" id="last_stock" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="stock" class="form-label mt-2"><strong>STOCK REAL:</strong><span
                                        class="text-danger">*</span></label>
                                <input type="text" id="stock" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="note" class="form-label mt-2"><strong>EXP DATE:</strong></label>
                                <input type="date" id="exp_date" class="form-control">
                            </div>

                            <div class="form-column">
                                <label for="note" class="form-label mt-2"><strong>NOTE:</strong></label>
                                <input type="text" id="note" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
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
                        <input type="hidden" id="ingredientid">
                        <input type="hidden" id="stock_opname_id">

                        <div class="modal-body">
                            <div class="form-column">
                                <label for="ingredientname" class="form-label mt-2"><strong>INGREDIENT NAME:</strong>
                                    <span class="text-danger">*</span></label>
                                <input disabled type="text" id="ingredientname" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="ingredientcode" class="form-label mt-2"><strong>INGREDIENT CODE:</strong>
                                    <span class="text-danger">*</span></label>
                                <input disabled type="text" id="ingredientcode" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="last_stock" class="form-label mt-2"><strong>STOCK SISTEM:</strong>
                                    <span class="text-danger">*</span></label>
                                <input disabled type="text" id="last_stock" class="form-control" required>
                            </div>

                            <div class="form-column">
                                <label for="stock" class="form-label mt-2"><strong>STOCK REAL:</strong>
                                    <span class="text-danger">*</span></label>
                                <input type="text" id="stock" class="form-control" required>
                            </div>

                            <!-- Area Exp Date Dinamis -->
                            <div class="form-column mt-3">
                                <label class="form-label"><strong>EXP DATE & QUANTITY:</strong></label>
                                <div id="expDateContainer">
                                    <div class="row mb-2 exp-row">
                                        <div class="col-md-5">
                                            <input type="date" name="exp_date[]" class="form-control" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" name="quantity[]" class="form-control"
                                                placeholder="Quantity" step="0.0001" required>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="addExpDate" class="btn btn-success btn-sm mt-2">
                                    <i class="fa fa-plus"></i> Tambah Exp Date
                                </button>
                            </div>

                            <div class="form-column">
                                <label for="note" class="form-label mt-3"><strong>NOTE:</strong></label>
                                <input type="text" id="note" class="form-control">
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
        <div class="modal fade" id="expDateModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="expDateModalLabel">Daftar Exp Date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 10%">#</th>
                                    <th class="text-center" style="width: 45%">Exp Date</th>
                                    <th class="text-center" style="width: 45%">Quantity</th>
                                    <th class="text-center" style="width: 45%">Action</th>
                                </tr>
                            </thead>
                            <tbody id="expDateTableBody">
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                // Tambah baris Exp Date baru
                $('#addExpDate').on('click', function () {
                    let newRow = `
            <div class="row mb-2 exp-row">
                <div class="col-md-5">
                    <input type="date" name="exp_date[]" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <input type="number" name="quantity[]" class="form-control"
                        placeholder="Quantity" step="0.0001" required>
                </div>
                <div class="col-md-2 text-right">
                    <button type="button" class="btn btn-danger btn-sm removeRow">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>`;
                    $('#expDateContainer').append(newRow);
                });

                // Hapus baris Exp Date
                $(document).on('click', '.removeRow', function () {
                    $(this).closest('.exp-row').remove();
                });
            });
        </script>

    </div>
</body>
<script>
    document.addEventListener('input', function (e) {
        if (e.target.name === 'quantity[]') {
            let val = e.target.value;
            if (val.includes('.')) {
                const [intPart, decPart] = val.split('.');
                if (decPart.length > 4) {
                    e.target.value = parseFloat(val).toFixed(4);
                }
            }
        }
    });
</script>
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
    const locationid = "<?= $data['locationid'] ?>";
    const stock_opname_id = "<?= isset($data['id']) ? $data['id'] : '' ?>";
    const date = "<?= $formattedDate ?>";

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



        function fetchData() {
            const formData = {
                locationid: locationid,
                date: date
            }
            $('#loadingIndicator').show();
            $('#report-body').html(`
                <tr><td colspan="11" class="text-center">Loading...</td></tr>
            `);

            $.ajax({
                url: "<?= base_url('ControllerReport/getDetailStockOpnameAdjustment') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    const rows = res.data || [];
                    const dataFormatted = [];

                    rows.forEach((row, i) => {
                        dataFormatted.push([
                            i + 1,
                            row.INGREDIENTSNAME || '',
                            row.INGREDIENTSCODE || '',
                            row.unitname || '',
                            row.CURRENT_STOCK || '',
                            row.STOCKREAL || '',
                            row.DIFFERENCE || '',
                            row.NOTE || '',
                            row.exp_date || '',
                            `<div style="display: flex; gap: 4px; justify-content: center;">
                                <button class="btn-update btn-sm btn-primary"  style="cursor: pointer" 
                                data-ingredientname="${row.INGREDIENTSNAME}"
                                data-ingredientcode="${row.INGREDIENTSCODE}"
                                data-ingredientid="${row.INGREDIENTSID}"
                                data-currentstock="${row.CURRENT_STOCK}"
                                data-stockreal="${row.STOCKREAL}"
                                data-note="${row.NOTE}"
                                data-exp_date="${row.exp_date}"
                                data-stock_opname_id="${stock_opname_id}"
                                >Update</button>
                                <button 
                                    class="btn btn-primary btn-sm btn-expdate"
                                    data-ingredientid="${row.INGREDIENTSID}"
                                    data-stock_opname_id="${stock_opname_id}">
                                    <i class="fa fa-eye"></i> View Exp Dates
                                </button>
                            </div>`,
                            row.ADJUSTMENTIN || '',
                            row.ADJUSTMENTOUT || '',
                            row.ADJUSTMENTINTHISSO || '',
                            row.ADJUSTMENTOUTTHISSO || '',
                            (row.ISNEEDADJUSTMENT == 1 ? 'Butuh Adjust' : (row.ISNEEDADJUSTMENT == 0 ? 'Ok' : '')),
                            row.INGREDIENTSID || '',
                        ]);
                    });
                    table.clear().rows.add(dataFormatted).draw();

                    $(document).on('click', '.btn-update', function () {
                        const ingredientname = $(this).data('ingredientname');
                        const ingredientcode = $(this).data('ingredientcode');
                        const ingredientid = $(this).data('ingredientid');
                        const currentstock = $(this).data('currentstock');
                        const stockreal = $(this).data('stockreal');
                        const exp_date = $(this).data('exp_date');
                        const note = $(this).data('note');
                        const stock_opname_id = $(this).data('stock_opname_id');
                        // buka modal
                        $('#createModal').modal('show');

                        // isi data utama
                        $('#ingredientid').val(ingredientid);
                        $('#ingredientname').val(ingredientname);
                        $('#ingredientcode').val(ingredientcode);
                        $('#last_stock').val(currentstock);
                        $('#note').val(note);
                        $('#stock_opname_id').val(stock_opname_id);

                        if (exp_date && exp_date !== 'null' && exp_date !== '') {

                            let formattedDate = exp_date.split(' ')[0];
                            $('#exp_date').val(formattedDate);
                        } else {
                            $('#exp_date').val('');
                        }

                        if (stockreal && !isNaN(stockreal)) {
                            $('#stock').val(stockreal);
                        } else {
                            $('#stock').val('');
                        }
                    });

                    $(document).on('click', '.btn-expdate', function () {
                        const ingredientid = $(this).data('ingredientid');
                        const stock_opname_id = $(this).data('stock_opname_id');

                        loadExpDates(ingredientid, stock_opname_id);
                    });


                    $(document).on('click', '.btn-void', function () {
                        const id = $(this).data('id');
                        let base_url = "<?= base_url('ControllerReport/content/stockOpnameDetail'); ?>";
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

        // function openEditModal(id) {
        //     $.ajax({
        //         url: '<?= base_url('ControllerReport/getDetailStockOpname/') ?>' + id,
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function (response) {
        //             console.log(response);

        //             if (response.success) {
        //                 const data = response.data
        //                 $('#createModal').modal('show');
        //                 $('#id').val(data.id);
        //                 $('#locationid').val(data.locationid);
        //                 $('#remarks').val(data.remarks);
        //                 let opnameDate = data.stockopnamedate.split(" ")[0];
        //                 $('#stockopnamedate').val(opnameDate);
        //                 $('#isactive').val(data.isactive);
        //             } else {
        //                 alert(response.message);
        //             }
        //         }
        //     });
        // }
        // function openEditModal(id) {
        //     $.ajax({
        //         url: '<?= base_url('ControllerReport/getStockOpnameDetail/') ?>' + id,
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function (response) {
        //             console.log(response);

        //             if (response.success) {
        //                 const data = response.data;
        //                 const expdates = response.expdates || [];


        //                 $('#createModal').modal('show');
        //                 $('#id').val(data.id);
        //                 $('#locationid').val(data.locationid);
        //                 $('#remarks').val(data.remarks);
        //                 let opnameDate = data.stockopnamedate.split(" ")[0];
        //                 $('#stockopnamedate').val(opnameDate);
        //                 $('#isactive').val(data.isactive);

        //                 const container = $('#expDateContainer'); 

        //                 container.empty();

        //                 if (expdates.length > 0) {
        //                     expdates.forEach((item, index) => {
        //                         const expRow = `
        //                             <div class="row mb-2 exp-row" data-id="${item.id}">
        //                                 <div class="col-md-5">
        //                                     <input type="date" name="exp_date[]" class="form-control" value="${item.exp_date}" required>
        //                                 </div>
        //                                 <div class="col-md-5">
        //                                     <input type="number" name="quantity[]" class="form-control" value="${item.quantity}" placeholder="Quantity" required>
        //                                 </div>
        //                                 <div class="col-md-2 text-right">
        //                                     <button type="button" class="btn btn-danger btn-sm removeRow">
        //                                         <i class="fa fa-trash"></i> Delete
        //                                     </button>
        //                                 </div>
        //                             </div>`;
        //                         container.append(expRow);
        //                     });
        //                 } else {
        //                     container.append(`
        //                        <div class="row mb-2 exp-row">
        //                             <div class="col-md-5">
        //                                 <input type="date" name="exp_date[]" class="form-control" required>
        //                             </div>
        //                             <div class="col-md-5">
        //                                 <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>
        //                             </div>
        //                             <div class="col-md-2 text-right">
        //                                 <button type="button" class="btn btn-danger btn-sm removeRow">
        //                                     <i class="fa fa-trash"></i> Delete
        //                                 </button>
        //                             </div>
        //                         </div>
        //                     `);
        //                 };
        //             } else {
        //                 alert(response.message);
        //             }
        //         }
        //     });
        // }

        function loadExpDates(ingredientid, stock_opname_id) {
            const url = `https://sys.eudoraclinic.com:84/app/ControllerReport/getStockOpnameDetail/${ingredientid}/${stock_opname_id}`;
            const tbody = $('#expDateTableBody');

            // tampilkan modal dulu agar user tahu proses berjalan
            $('#expDateModal').modal('show');

            // tampilkan loading
            tbody.html(`
                <tr>
                    <td colspan="3" class="text-center text-muted">
                        <i class="fa fa-spinner fa-spin"></i> Memuat data...
                    </td>
                </tr>
            `);

            // panggil API
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log("ExpDate Detail:", response);
                    tbody.empty();

                    if (response.success && response.expdates && response.expdates.length > 0) {
                        response.expdates.forEach((item, index) => {
                            const formattedDate = item.exp_date
                                ? new Date(item.exp_date).toLocaleDateString('id-ID')
                                : '-';
                            const quantity = Number(item.quantity).toString().replace(/\./g, ',').replace(/,?0+$/, '');

                            const row = `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td class="text-center">${formattedDate}</td>
                                    <td class="text-center">${quantity}</td>
                                     <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-row" data-id="${item.id}">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.append(row);
                        });
                    } else {
                        tbody.html(`
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Tidak ada data exp date
                                </td>
                            </tr>
                        `);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching expdates:", error);
                    tbody.html(`
                        <tr>
                            <td colspan="3" class="text-center text-danger">
                                Gagal memuat data (${error})
                            </td>
                        </tr>
                    `);
                }
            });
        }

        function openEditModal(id) {
            $.ajax({
                url: '<?= base_url('ControllerReport/getStockOpnameDetail/') ?>' + id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response);

                    if (response.success) {
                        const data = response.data;
                        const expdates = response.expdates || [];

                        // Tampilkan modal
                        $('#createModal').modal('show');

                        // Isi field umum
                        $('#stock_opname_id').val(data.id || '');
                        $('#ingredientid').val(data.ingredientid || '');
                        $('#ingredientname').val(data.ingredientname || '');
                        $('#ingredientcode').val(data.ingredientcode || '');
                        $('#last_stock').val(data.last_stock || '');
                        $('#stock').val(data.stock || '');
                        $('#note').val(data.note || '');

                        // Isi Exp Date Container
                        const container = $('#expDateContainer');
                        container.empty(); // kosongkan dulu

                        if (expdates.length > 0) {
                            expdates.forEach((item) => {
                                const expRow = `
                                    <div class="row mb-2 exp-row" data-id="${item.id}">
                                        <div class="col-md-5">
                                            <input type="date" name="exp_date[]" class="form-control" value="${item.exp_date}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <input type="number" name="quantity[]" class="form-control" value="${item.quantity}" placeholder="Quantity" required>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>`;
                                container.append(expRow);
                            });
                        } else {
                            // Jika belum ada expdate, tampilkan 1 baris kosong
                            container.append(`
                                <div class="row mb-2 exp-row">
                                    <div class="col-md-5">
                                        <input type="date" name="exp_date[]" class="form-control" required>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            `);
                        }

                    } else {
                        Swal.fire("Error", response.message || "Gagal memuat data stok opname", "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    Swal.fire("Error", "Terjadi kesalahan saat mengambil data stok opname", "error");
                }
            });
        }

        // $(document).on('click', '.btn-expdate', function () {
        //     const stock_opname_id = $(this).data('stock_opname_id');
        //     const locationid = $(this).data('locationid');
        //     const ingredientid = $(this).data('ingredientid');
        //     const url = `https://sys.eudoraclinic.com:84/app/ControllerReport/getStockOpnameDetail/${locationid}/${ingredientid}/${stock_opname_id}`;

        //     // buka modal
        //     $('#expDateModal').modal('show');

        //     // kosongkan isi tabel dulu
        //     const tbody = $('#expDateTableBody');
        //     tbody.html(`<tr><td colspan="3" class="text-center text-muted">Memuat data...</td></tr>`);

        //     // ambil data dari API
        //     $.ajax({
        //         url: url,
        //         type: 'GET',
        //         dataType: 'json',
        //         success: function (response) {
        //             console.log("ExpDate Detail:", response);
        //             const expdates = response.expdates || [];

        //             if (expdates.length > 0) {
        //                 tbody.empty();
        //                 expdates.forEach((item, index) => {
        //                     const formattedDate = item.exp_date ? item.exp_date.split(' ')[0] : '-';
        //                     const row = `
        //                         <tr>
        //                             <td class="text-center">${index + 1}</td>
        //                             <td class="text-center">${formattedDate}</td>
        //                             <td class="text-center">${item.quantity ?? 0}</td>
        //                         </tr>
        //                     `;
        //                     tbody.append(row);
        //                 });
        //             } else {
        //                 tbody.html(`<tr><td colspan="3" class="text-center text-muted">Tidak ada data exp date</td></tr>`);
        //             }
        //         },
        //         error: function (xhr, status, error) {
        //             console.error("Error fetching expdates:", error);
        //             tbody.html(`<tr><td colspan="3" class="text-center text-danger">Gagal memuat data</td></tr>`);
        //         }
        //     });
        // });

        $(document).on('click', '.btn-delete-row', function () {
            const row = $(this).closest('tr');
            const expDateId = $(this).data('id');

            if (!expDateId) {
                alert('ID exp date tidak ditemukan.');
                return;
            }

            if (confirm('Apakah kamu yakin ingin menghapus data exp date ini?')) {
                $.ajax({
                    url: `https://sys.eudoraclinic.com:84/app/ControllerReport/deleteStockOpnameExpDate/${expDateId}`,
                    type: 'POST', // bisa diganti 'DELETE' kalau API-mu mendukung
                    dataType: 'json',
                    success: function (response) {
                        console.log("Delete response:", response);
                        if (response.success) {
                            row.remove();
                            alert('Data exp date berhasil dihapus.');
                        } else {
                            alert('Gagal menghapus data exp date: ' + (response.message || 'Unknown error'));
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error deleting exp date:", error);
                        alert('Terjadi kesalahan saat menghapus data exp date.');
                    }
                });
            }
        });


        $('#createForm').submit(function (e) {
            e.preventDefault();

            const exp_dates = [];
            const quantities = [];

            // ambil semua input exp_date[] dan quantity[]
            $('input[name="exp_date[]"]').each(function () {
                exp_dates.push($(this).val());
            });
            $('input[name="quantity[]"]').each(function () {
                quantities.push($(this).val());
            });

            const formData = {
                ingredientid: $('#ingredientid').val(),
                stock_opname_id: $('#stock_opname_id').val(),
                last_stock: $('#last_stock').val(),
                stock: $('#stock').val(),
                note: $('#note').val(),
                exp_dates: exp_dates,
                quantities: quantities
            };

            $.ajax({
                url: '<?= base_url('ControllerReport/createStockOpnameAdjustment') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert('Data berhasil disimpan');
                        $('#createModal').modal('hide');
                        fetchData();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Terjadi error:', error);
                }
            });
        });

        $('#createModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });

        $(document).on('click', '#btn-adjust', function () {
            const allData = table.rows().data().toArray();
            const payload = allData
                .map(row => {
                    const diff = parseFloat(row[6]);
                    const adjInSoThisMonth = parseFloat(row[12]);
                    const adjOutSoThisMonth = parseFloat(row[13]);

                    console.log(diff, adjInSoThisMonth, adjOutSoThisMonth);

                    if ((diff === 0 || isNaN(diff)) && (adjInSoThisMonth === 0 || isNaN(adjInSoThisMonth)) && (adjOutSoThisMonth === 0 || isNaN(adjOutSoThisMonth))) {
                        return null;
                    }

                    return {
                        ingredientid: row[15],
                        currentstock: row[4],
                        stockreal: row[5],
                        note: row[7],
                        difference: diff,
                        type: diff > 0 ? 'IN' : 'OUT', // tentukan IN/OUT
                        stock_opname_id: stock_opname_id
                    };
                })
                .filter(item => item !== null); // buang yang null

            if (payload.length === 0) {
                alert("Tidak ada data yang perlu di-adjust.");
                return;
            }
            $.ajax({
                url: "<?= base_url('ControllerReport/saveStockOpnameBulk') ?>",
                method: "POST",
                data: JSON.stringify({ items: payload }),
                contentType: "application/json",
                dataType: "json",
                success: function (res) {
                    console.log(res);

                    if (res.success) {
                        alert("Data berhasil disimpan!");
                        fetchData();
                    } else {
                        alert("Gagal simpan data: " + res.message);
                    }
                },
                error: function () {
                    alert("Terjadi error saat simpan data.");
                }
            });
        });
    });
</script>


</html>