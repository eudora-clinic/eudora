<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set('max_execution_time', -1);

$db_oriskin = $this->load->database('oriskin', true);
$thisMonth = date('Y-m');
$period = (isset($_GET['period']) ? $this->input->get('period') : $thisMonth);
$location_id = $this->session->userdata('locationid');

$report_summary = $db_oriskin->query("exec spReportCommissionKonsultasiDokter2024 '" . $period . "', " . $location_id . "")->result_array();

$report_detail = $db_oriskin->query("exec spReportCommissionKonsultasiDokterDetail2024 '" . $period . "', " . $location_id . "")->result_array();
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">Report Consultation Docter</h4>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                            <div class="form-row mt-2 md-2">
                                <div class="form-group col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label>Period</label>
                                        <input type="date" id="period" name="period" class="form-control"
                                            required="true" aria-required="true" placeholder="" value="<?= $period ?>">
                                    </div>
                                </div>
                                <button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-dark"
                                    value="true">
                                    Cari</button>
                            </div>
                        </form>
                    </div>

                    <ul class="nav nav-tabs active mt-3">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#summaryconsultation">Summary Consultation</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#detailconsultation">Detail Consultation</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Summary Consultation -->
                        <div class="card-body tab-pane active" id="summaryconsultation" style="overflow-x: auto;">
                            <table id="tablesummary" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" class="bg-info">LOCATION</th>
                                        <th style="text-align: center;" class="bg-info">RDM</th>
                                        <th style="text-align: center;" class="bg-info">ROM</th>
                                        <th style="text-align: center;" class="bg-info">STATUS</th>
                                        <th style="text-align: center;" class="bg-info">TOTAL</th>
                                    </tr>

                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="text-align: right"></th>
                                        <th style="text-align: right"></th>
                                        <th style="text-align: right"></th>
                                        <th style="text-align: right"></th>
                                        <th style="text-align: right"></th>
                                    </tr>
                                </tfoot>

                                <tbody>
                                    <?php foreach ($report_summary as $row) {

                                    ?>
                                        <tr role="">
                                            <td style="text-align: left;"><?= $row['LOCATIONNAME'] ?></td>
                                            <td style="text-align: left;"><?= $row['RDM'] ?></td>
                                            <td style="text-align: left;"><?= $row['ROM'] ?></td>
                                            <td style="text-align: left;"><?= $row['STATUS'] ?></td>
                                            <td style="text-align: right;"><?= number_format($row['TOTALMEMBERCONSULTATION'], 0, '.', ',') ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detail New -->
                        <div class="card-body tab-pane" id="detailconsultation" style="overflow-x: auto;">
                            <table id="tabledetail" class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th>No</th>
                                        <th>Lokasi</th>
                                        <th>Customer</th>
                                        <th>Treatment Date</th>
                                        <th>Treatment Name</th>
                                        <th>Employee Name</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php 
                                        $no = 1;
                                    foreach ($report_detail as $row) {

                                    ?>
                                        <tr role="">
                                            <td style="text-align: left;"><?= $no++ ?></td>
                                            <td style="text-align: left;"><?= $row['LOCATIONNAME'] ?></td>
                                            <td style="text-align: left;"><?= $row['CUSTOMERNAME'] ?></td>
                                            <td style="text-align: left;"><?= $row['TREATMENTDATE'] ?></td>
                                            <td style="text-align: left;"><?= $row['TREATMENTNAME'] ?></td>
                                            <td style="text-align: left;"><?= $row['EMPLOYEENAME'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var period = '<?= $period ?>';

        var table4 = $('#tablesummary').DataTable({
            order: [
                [0, 'asc']
            ],
            rowGroup: {
                startRender: null,
                dataSrc: 0
            },
            "bAutoWidth": false,
            dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'pdfHtml5',
                footer: true,
                header: true,
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A2',
                title: 'Summary Consultatiion' + '\n' + 'Period : ' + period ,
                filename: 'Summary Consultatiion Period : ' + period,
                customize: function(doc) {
                    var tblBody = doc.content[1].table.body;
                    // ***
                    //This section creates a grid border layout
                    // ***
                    doc.content[1].layout = {
                        hLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                    $('#tableID').find('tr').each(function(ix, row) {
                        var index = ix;
                        var rowElt = row;
                        $(row).find('td').each(function(ind, elt) {
                            if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
                                delete tblBody[index][ind].style;
                                tblBody[index][ind].fillColor = '#FFF9C4';
                            } else {
                                if (tblBody[index][2].text == '') {
                                    delete tblBody[index][ind].style;
                                    tblBody[index][ind].fillColor = '#FFFDE7';
                                }
                            }
                        });
                    });
                }
            }, 'excel'],
            'aoColumns': [{
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            } ],
            "footerCallback": function(row, data, start, end,
                display) {
                var api = this.api(),
                    data;
                var intVal = function(i) {
                    return typeof i === 'string' ? i.replace(
                            /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };
                // Total over this page
                pageTotal5 = api.column(4, {
                    page: 'current'
                }).data().reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var numFormat = $.fn.dataTable.render.number(
                    '\,', '.', 0, '').display;
                $(api.column(4).footer()).html(
                    numFormat(pageTotal5));


            }
        });

        var table5 = $('#tabledetail').DataTable({
            order: [
                [0, 'asc']
            ],
            rowGroup: {
                startRender: null,
                dataSrc: 0
            },
            "bAutoWidth": false,
            "drawCallback": function(settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
            dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'pdfHtml5',
                footer: true,
                header: true,
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A2',
                title: 'Detail Consultation' + '\n' + 'Period : ' + period,
                filename: 'Detail Consultation Period : ' + period ,
                customize: function(doc) {
                    var rowCount = 1;
                    doc.content[1].table.body.forEach(function(row, index) {
                        // Abaikan header dan footer
                        if (index > 0 && row[0].text !== '') { // Abaikan row dengan teks 'Total' (untuk footer)
                            row[0].text = rowCount; // Set kolom pertama (nomor urut)
                            rowCount++;
                        }
                    });

                    var tblBody = doc.content[1].table.body;
                    // ***
                    //This section creates a grid border layout
                    // ***
                    doc.content[1].layout = {
                        hLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 2 : 1;
                        },
                        vLineWidth: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 2 : 1;
                        },
                        hLineColor: function(i, node) {
                            return (i === 0 || i === node.table.body.length) ? 'black' : 'gray';
                        },
                        vLineColor: function(i, node) {
                            return (i === 0 || i === node.table.widths.length) ? 'black' : 'gray';
                        }
                    };
                    $('#tableID').find('tr').each(function(ix, row) {
                        var index = ix;
                        var rowElt = row;
                        $(row).find('td').each(function(ind, elt) {
                            if (tblBody[index][1].text == '' && tblBody[index][2].text == '') {
                                delete tblBody[index][ind].style;
                                tblBody[index][ind].fillColor = '#FFF9C4';
                            } else {
                                if (tblBody[index][2].text == '') {
                                    delete tblBody[index][ind].style;
                                    tblBody[index][ind].fillColor = '#FFFDE7';
                                }
                            }
                        });
                    });
                }
            }, 'excel'],
            'aoColumns': [{
                'sWidth': '3%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            }, {
                'sWidth': '10%'
            },{
                'sWidth': '10%'
            }, ],
        });



        $('#tablesummary tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                table.order([0, 'desc']).draw();
            } else {
                table.order([0, 'asc']).draw();
            }
        });

        $('#tabledetail tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                table.order([0, 'desc']).draw();
            } else {
                table.order([0, 'asc']).draw();
            }
        });

    });
</script>

<script type="text/javascript">
    $('#tablesummary').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#tabledetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>