<style>
    /*sementara hanya berjalan di firefox*/
    .bootstrap-select>.dropdown-toggle.bs-placeholder,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
    .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
        color: #fff;
    }

    .table {
        table-layout: fixed;
        min-width: auto;

    }

    .table-wrapper {
        overflow-x: scroll;
        overflow-y: scroll;
        width: 100%;
        height: 100%;
        max-height: 100%;
        margin-top: 20px;
    }

    .table-wrapper table thead {
        position: -webkit-sticky;
        position: sticky;
        background-color: #f5f5f5;
        top: 0;
        z-index: 90;
    }

    .first-col {
        left: 0;
    }

    .second-col {
        left: 0;
    }

    .sticky-col {
        position: -webkit-sticky;
        position: sticky;
        background-color: #f5f5f5;
    }

    .table-wrapper::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0, 0, 0, .5);
        -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
    }

    @page {
        size: auto;
    }

    .nav-tabs {
        border-bottom: 1px solid #dee2e6;
    }

    .nav-tabs .nav-item .nav-link,
    .nav-tabs .nav-item .nav-link:hover {
        color: #333 !important;
    }

    .nav-tabs .nav-item .nav-link {
        border: 1px solid transparent !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-item .nav-link:focus {
        border: 1px solid transparent !important;
        border-color: #dee2e6 #dee2e6 #fafafa !important;
        color: #333 !important;
    }
</style>

<?php
# display error
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
# unlimited time
ini_set('max_execution_time', -1);
$q = (isset($_GET['q']) ? $this->input->get('q') : '');
# dibuat langsung di view untuk memudahkan
# tidak dibuat di model
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);
$customerId = '';
$fullname = '';
$membercode = '';
$data_new_menu = array();
$history_doing = array();
$treatment_info = array();

$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m-d'));
$period = (isset($_GET['period']) ? $this->input->get('period') : date('Y-m'));
$locationid = $this->session->userdata('locationid');
$userid = $this->session->userdata('userid');
$user = (isset($_GET['user']) ? $this->input->get('user') : '');




//echo $customerId; die();
# query tab membership treatment



?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title">STOCK REQUIREMENT</h4>
                </div>
                <div class="card-body">
                <div class="toolbar">
                        <form id="form-rdm" method="get" action="<?= current_url() ?>">
                        <div class="form-row mt-2">
                            <div class="form-group col-md-3">
                            <div class="form-group bmd-form-group">
                                <label>Date Start</label>
                                <input type="date" id="datestart" name="datestart" class="form-control" required="true"
                                aria-required="true" placeholder="" value="<?= $datestart ?>">
                            </div>
                            </div>
                            <div class="form-group col-md-3">
                            <div class="form-group bmd-form-group">
                                <label>Date End</label>
                                <input type="date" id="dateend" name="dateend" class="form-control" required="true"
                                aria-required="true" placeholder="" value="<?= $dateend ?>">
                            </div>
                            </div>
                            <button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-info" value="true"
                            onclick="if($('#dateend').val() < $('#datestart').val()) {alert('Date End must more than Date Start');return false;}"><i></i>
                            Search</button>
                        </div>
                        </form>
                    </div>
                    <div class="row gx-4">
                        <div class="col-md-12 mt-3">
                        </div>
                        <div class="col-md-12 mt-3">

                            <!-- Tab panes -->
                            <div class="" style="overflow-x: auto;">
                                <table id="tbl-membership-treatment" class="table table-bordered">
                                    <thead class="thead-danger">
                                        <tr role="" class="bg-info text-white">
                                            <th rowspan="2" style="text-align: center;width:70px">RDM</th>
                                            <th rowspan="2" style="text-align: center;width:70px">CLINIC</th>
                                            <th rowspan="2" style="text-align: center;width:90px">PRODUCT</th>
                                            <th colspan="2" style="text-align: center;width:150px">REQUIREMENT</th>
                                        </tr>
                                        <tr role="" class="bg-info text-white">
                                            <th width="150px" class="text-center">QTY</th>
                                            <th width="150px" class="text-center">UNIT</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $resultdata_new_menu = $db_oriskin->query("EXEC spReportUsingIngredientsAllClinicWeekly '" . $datestart . "','" . $dateend . "', '".$locationid."' ")->result_array();
                                        //echo "User parameter: " . $user;
                                        if (isset($resultdata_new_menu)) {
                                            $no = 1; // Inisialisasi nomor urut
                                            foreach ($resultdata_new_menu as $row) {
                                                echo '<tr role="">';
                                                echo '<td style="text-align: center;width:50px">' . $row['RDM'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['LOCATIONNAME'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['INGREDIENTS'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['CLINIC_STOCK_REQUIREMENT'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['UNIT_STOCK_REQUIREMENT'] . '</td>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
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

<script>
    $(document).ready(function() {
        // untuk judul
        var customerId = '<?= $customerId ?>';

        $('#tbl-treatment-info').DataTable({
            paging: true,
            pageLength: 10,
            //scrollY: "300px",
            //scrollCollapse: true,
            order: [
                [0, 'asc']
            ],
        });

        $('#tbl-membership-treatment').DataTable({
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ? i.replace(
                            /[\,]/g, '') * 1 :
                        typeof i === 'number' ? i : 0;
                };
            },
            dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Electronic Medical Report',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function(doc) {
                    // Layout for borders
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

                    // Handling header colspan and rowspan
                    let headerRows = [];
                    let noOfColumn = 5;
                    let rowSpansOfColumns = [];
                    for (let i = 0; i < noOfColumn; i++) {
                        rowSpansOfColumns.push([]);
                    }
                    let noOfExtraHeaderRow = 1;
                    doc.content[1].table.headerRows = noOfExtraHeaderRow + 1;
                    for (let i = 1; i <= noOfExtraHeaderRow; i++) {
                        let headerRow = [];
                        let colIdx = 0;
                        while (colIdx < rowSpansOfColumns.length && rowSpansOfColumns[colIdx].includes(i)) {
                            headerRow.push({});
                            colIdx++
                        }

                        $('#tbl-membership-treatment').find("thead>tr:nth-child(" + i + ")>th").each(
                            function(index, element) {
                                let colSpan = parseInt(element.getAttribute("colSpan"));
                                let rowSpan = parseInt(element.getAttribute("rowSpan"));
                                if (rowSpan > 1) {
                                    for (let col = colIdx; col < colIdx + colSpan; col++) {
                                        if (!rowSpansOfColumns[col]) {
                                            rowSpansOfColumns[col] = [];
                                        }
                                        for (let row = i + 1; row < i + rowSpan; row++) {
                                            rowSpansOfColumns[col].push(row);
                                        }
                                    }
                                }

                                headerRow.push({
                                    text: element.innerHTML,
                                    style: "tableHeader",
                                    colSpan: colSpan,
                                    rowSpan: rowSpan
                                });
                                colIdx++
                                for (let j = 0; j < colSpan - 1; j++) {
                                    headerRow.push({});
                                    colIdx++
                                }
                                while (colIdx < rowSpansOfColumns.length && rowSpansOfColumns[colIdx].includes(i)) {
                                    headerRow.push({});
                                    colIdx++
                                }
                            });

                        headerRows.push(headerRow);
                    }
                    for (let i = 0; i < headerRows.length; i++) {
                        doc.content[1].table.body.unshift(headerRows[headerRows.length - 1 - i]);
                    }
                },
                footer: true,
                header: true
            }, 'excel']
        });


        $('#tbl-history-doing').DataTable({
            paging: true,
            pageLength: 10,
            //scrollY: "300px",
            //scrollCollapse: true,
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data) {
                let dateString = ((data[0]).substring(0, 10)).split('-');
                let treatmentdate = dateString[2] + '-' + dateString[1] + '-' + dateString[0];
                $('td:eq(0)', row).html('<b>' + treatmentdate + '</b>');
            }
        });

        // Event delegation untuk tombol edit
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data('id');
            $(this).hide();
            $(this).parent().find('.spn-remarksconsultation').hide();
            $(this).parent().find('.txt-remarksconsultation').show();
            $(this).parent().find('.btn-save').show();
        });

        $(document).on("click", ".btn-save", function() {
            let id = $(this).data('id');
            let remarksconsultation = $(this).parent().find('.txt-remarksconsultation').val();

            console.log('Sending data:', {
                doingid: id,
                remarksconsultation: remarksconsultation
            });

            $.post("<?= base_url('save-note-history-doing') ?>", {
                doingid: id,
                remarksconsultation: remarksconsultation
            }, function(res) {
                console.log('Response:', res);
            }).fail(function(xhr, status, error) {
                console.log('Request failed:', status, error);
            });

            $(this).parent().find('.spn-remarksconsultation').html(remarksconsultation);
            $(this).hide();
            $(this).parent().find('.txt-remarksconsultation').hide();
            $(this).parent().find('.spn-remarksconsultation').show();
            $(this).parent().find('.btn-edit').show();
        });

    });
</script>


<!--
<script>
    // Set DATEEND to have the same value as DATESTART whenever DATESTART changes
    $('#datestart').on('change', function() {
        $('#dateend').val($(this).val());
    });

    // Ensure DATEEND is set to the initial value of DATESTART
    $(document).ready(function() {
        $('#dateend').val($('#datestart').val());
    });
</script>
-->