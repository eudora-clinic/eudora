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

$isAllIngredientsExist = true;

$resultdata_new_menu = $db_oriskin->query("EXEC spReportUsingIngredientsAllClinicWeekly_Dev '" . $datestart . "','" . $dateend . "', '" . $locationid . "' ")->result_array();

foreach ($resultdata_new_menu as $row) {
    $checkQuery = $db_oriskin->query("
        SELECT 1
        FROM msdeliveryingredientsstock 
        WHERE ingredientsid = '" . $row['INGREDIENTSID'] . "'
        AND locationid = '" . $locationid . "'
        AND datestart = '" . $datestart . "'
        AND dateend = '" . $dateend . "'
        AND approve_receiver = 1
        AND stock_send = stock_receive
    ")->row_array();

    if (!$checkQuery) {
        $isAllIngredientsExist = false;
        break;
    }
}


$lastSend = $db_oriskin->query("
    SELECT TOP 1 datestart, dateend 
    FROM msdeliveryingredientsstock 
    WHERE locationid = '" . $locationid . "' 
    ORDER BY datestart DESC
")->row_array();




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
                            <button style="padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;"

                                onclick="generateInvoice('<?php echo $locationid; ?>', '<?php echo $datestart; ?>', '<?php echo $dateend; ?>')"
                                <?php echo $isAllIngredientsExist ? '' : 'disabled'; ?>>
                                GENERATE INVOICE
                            </button>
                        </div>
                        <div class="col-md-12 mt-3">

                            <!-- Tab panes -->

                            <h4 class="card-title mt-3 mb-3" style="font-size: 16px; font-weight: bold; color: #333;">
                                Rentang pengiriman stock terakhir :
                                <?php
                                if (!empty($lastSend['datestart'])) {
                                    echo $lastSend['datestart'] . ' hingga ' . $lastSend['dateend'];
                                } else {
                                    echo 'belum ada pengiriman';
                                }
                                ?>
                            </h4>

                            <div class="" style="overflow-x: auto;">
                                <table id="tbl-membership-treatment" class="table table-bordered">
                                    <thead class="thead-danger">
                                        <tr role="" class="bg-info text-white">
                                            <th rowspan="2" style="text-align: center;width:70px">RDM</th>
                                            <th rowspan="2" style="text-align: center;width:70px">CLINIC</th>
                                            <th rowspan="2" style="text-align: center;width:90px">PRODUCT</th>
                                            <th colspan="2" style="text-align: center;width:150px">REQUIREMENT</th>
                                            <th colspan="2" style="text-align: center;width:120px">GUDANG</th>
                                            <th colspan="1" style="text-align: center;width:120px">KLINIK</th>
                                            <th rowspan="2" style="text-align: center;width:50px">ACTION</th>
                                            <th rowspan="2" style="text-align: center;width:50px">STATUS</th>
                                           
                                        </tr>
                                        <tr role="" class="bg-info text-white">
                                            <th width="150px" class="text-center">QTY</th>
                                            <th width="150px" class="text-center">UNIT</th>

                                            <th width="60px" class="text-center">QTY DIKIRIM</th>
                                            <th width="60px" class="text-center">REASON</th>

                                            <th width="60px" class="text-center">QTY DITERIMA</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        if (isset($resultdata_new_menu)) {
                                            $no = 1; // Inisialisasi nomor urut
                                            foreach ($resultdata_new_menu as $row) {
                                                $checkQuery = $db_oriskin->query("
                                                    SELECT *
                                                    FROM msdeliveryingredientsstock 
                                                    WHERE ingredientsid = '" . $row['INGREDIENTSID'] . "'
                                                    AND locationid = '" . $locationid . "'
                                                    AND datestart = '" . $datestart . "'
                                                    AND dateend = '" . $dateend . "'
                                                ")->row_array();

                                                if ($checkQuery) {
                                                    echo '<tr role="">';
                                                    echo '<td style="text-align: center;width:50px">' . $row['RDM'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['LOCATIONNAME'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['INGREDIENTS'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['CLINIC_STOCK_REQUIREMENT'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['UNIT_STOCK_REQUIREMENT'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $checkQuery['stock_send'] . ' </td>';
                                                    echo '<td style="text-align: center;width:100px">' . $checkQuery['reason'] . ' </td>';
                                                    echo '<td style="text-align: center;width:100px">' . $checkQuery['stock_receive'] . ' </td>';
                                                    echo '<td style="text-align: center; width: 100px;">
                                                            <button style="padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;" 
                                                                data-toggle="modal" 
                                                                data-target="#updateModal" 
                                                                onclick=\'updateModal(' . json_encode(['row' => $row, 'checkQuery' => $checkQuery]) . ')\'>
                                                               ' . ($checkQuery['approve_receiver'] == 1 ? 'UPDATE' : 'RECEIVE') . '
                                                            </button>
                                                        </td>';
                                                    if ($checkQuery['approve_receiver'] == 1) {
                                                        if ($checkQuery['stock_receive'] == $checkQuery['stock_send']) {
                                                            echo '<td style="text-align: center; width: 100px; background-color: green; color: white;">SESUAI</td>';
                                                        } else {
                                                            echo '<td style="text-align: center; width: 100px; background-color: red; color: white;">TIDAK SESUAI</td>';
                                                        }
                                                    } else {
                                                        echo '<td style="text-align: center; width: 100px; background-color: blue; color: white;">BELUM DITERIMA</td>';
                                                    }
                                                   
                                                    echo '</tr>';
                                                } else {
                                                    echo '<tr role="">';
                                                    echo '<td style="text-align: center;width:50px">' . $row['RDM'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['LOCATIONNAME'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['INGREDIENTS'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['CLINIC_STOCK_REQUIREMENT'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px">' . $row['UNIT_STOCK_REQUIREMENT'] . '</td>';
                                                    echo '<td style="text-align: center;width:100px"> - </td>';
                                                    echo '<td style="text-align: center;width:100px"> - </td>';
                                                    echo '<td style="text-align: center;width:100px"> - </td>';
                                                    echo '<td style="text-align: center;width:100px"> BELUM DIKIRIM </td>';
                                                    echo '<td style="text-align: center;width:100px"> BELUM DIKIRIM </td>';
                                                
                                                    echo '</tr>';
                                                }
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

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Ingredients Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <div class="mb-3">
                        <label for="ingredientNameUpdate" class="form-label">Ingredient</label>
                        <input type="text" class="form-control" id="ingredientNameUpdate" name="ingredientNameUpdate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="locationNameUpdate" class="form-label">Location</label>
                        <input type="text" class="form-control" id="locationNameUpdate" name="locationNameUpdate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stockSend" class="form-label">Stock dikirim</label>
                        <input type="number" class="form-control" id="stockSend" name="stockSend" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="stockReceive" class="form-label">Stock diterima</label>
                        <input type="number" class="form-control" id="stockReceive" name="stockReceive" required>
                    </div>
                    <input hidden id="updateId" name="updateId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateForm()">Save</button>
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


<script>
    function updateModal(row) {
        document.getElementById('ingredientNameUpdate').value = row.row.INGREDIENTS;
        document.getElementById('locationNameUpdate').value = row.row.LOCATIONNAME;
        document.getElementById('stockSend').value = row.checkQuery.stock_send;

        document.getElementById('stockReceive').value = row.checkQuery.stock_receive;
        document.getElementById('updateId').value = row.checkQuery.id;

    }

    function updateForm() {
        const formData = new FormData(document.getElementById('updateForm'));
        const data = Object.fromEntries(formData.entries());

        console.log(data?.stockReceive, data?.updateId);


        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            $.post(_HOST + 'App/updateReceiver', {
                stock_receive: data?.stockReceive,
                id: data?.updateId
            }, function(result) {
                alert(result);
                location.reload();
            }).catch(error => {
                console.error('Error:', error);
                alert('Gagal menambahkan data.');
            });
        } else {

        }
    }
</script>

<script>
    function generateInvoice(locationId, dateStart, dateEnd) {
        var _confirm = confirm('Create faktur penjualan?');

        if (_confirm) {
            const baseUrl = 'https://app.oriskin.co.id:84/operationalclinic/faktur_penjualan';
            const targetUrl = `${baseUrl}/${locationId}/${dateStart}/${dateEnd}`;

            window.open(targetUrl, '_blank');

        }
    }
</script>