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
$locationid = $this->session->userdata('locationid');

//echo $customerId; die();
# query tab membership treatment


$resultdata_new_menu = $db_oriskin->query("EXEC spDoingTreatmentRangeDate '" . $datestart . "', '" . $dateend . "', '" . $locationid . "' ")->result_array();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <h5 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
                        ELEKTRONIK MEDICAL RECORD
                    </h5>
                <div class="card-body">

                    <div class="toolbar">
                        <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                            <div class="form-row mt-2 md-2">
                                <div class="form-group col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label>Date Start</label>
                                        <input type="date" id="datestart" name="datestart" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $datestart ?>">
                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <div class="form-group bmd-form-group">
                                        <label>Date End</label>
                                        <input type="date" id="dateend" name="dateend" class="form-control" value="<?= $dateend ?>">
                                    </div>
                                </div>

                                <button type="submit" id="btn-cari" name="submit" class="btn btn-primary" value="true" onclick="if($('#dateend').val() < $('#datestart').val()) {alert('Date End tidak boleh lebih kecil dari Date Start');return false;}"><i></i> Cari</button>
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
                                    <thead class="bg-thead">
                                        <tr>
                                            <th rowspan="2" style="text-align: center;width:50px">No</th>
                                            <th rowspan="2" style="text-align: center;width:150px">TreatmentDate</th>
                                            <th rowspan="2" style="text-align: center;width:100px">DoingID</th>
                                            <th rowspan="2" style="text-align: center;width:110px">ID</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Name</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Type</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Treatment</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Qty</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Doing By</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Assist By</th>
                                            <th rowspan="2" style="text-align: center;width:100px">JOB</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Start</th>
                                            <th rowspan="2" style="text-align: center;width:100px">End</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Duration</th>
                                            <th colspan="2" style="text-align: center;width:230px">Consultation</th>
                                            <th rowspan="2" style="text-align: center;width:200px; ">Remarks</th>
                                            <th rowspan="2" style="text-align: center;width:200px">Next Appointment</th>
						<th rowspan="2" style="text-align: center;width:200px">Last Consultation</th>
                                            <th rowspan="2" style="text-align: center;width:100px">Amount</th>
                                            <th rowspan="2" style="text-align: center;width:400px">Action</th>
                                        </tr>
                                        <tr class="bg-thead">
                                            <th width="150px" class="text-center">FR FD</th>
                                            <th width="150px" class="text-center">Dokter</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (isset($resultdata_new_menu)) {
                                            $no = 1; // Inisialisasi nomor urut
                                            foreach ($resultdata_new_menu as $row) {
                                                $data_absen = $db_oriskin->query("SELECT * FROM resep_dokter WHERE id_member = '" . $row['CUSTOMERID'] . "'")->row();
                                                $show_dokter = $db_oriskin->query("SELECT ISNULL(statusshowdokter, '') AS statusshowdokter FROM trdoingtreatment WHERE id = '" . $row['DOINGID'] . "'")->row()->statusshowdokter ?? 0;
                                                $show_dokter2 = $db_oriskin->query("SELECT ISNULL(statusshowdokter2, '') AS statusshowdokter2 FROM trdoingtreatment WHERE id = '" . $row['DOINGID'] . "'")->row()->statusshowdokter2 ?? 0;
                                                $remarksconsultation = $db_oriskin->query("SELECT ISNULL(remarksconsultation, '') AS remarksconsultation FROM trdoingtreatment WHERE id = '" . $row['DOINGID'] . "'")->row()->remarksconsultation ?? '';

                                                echo '<tr role="">';
                                                echo '<td style="text-align: center;width:50px">' . $no++ . '</td>';
                                                echo '<td style="text-align: center;width:150px">' . $row['DATE'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['DOINGID'] . '</td>';
                                                echo '<td style="text-align: center;width:110px">' . $row['CUSTOMERID'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['CUSTOMER'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['TYPE'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['TREATMENT'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['QTY'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['DOINGBY'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['ASSISTBY'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['DOINGJOBS'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['STARTTREATMENT'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['ENDTREATMENT'] . '</td>';
                                                echo '<td style="text-align: center;width:100px">' . $row['DURATION'] . '</td>';


                                                echo '<td style="text-align: center;width:120px">';
                                                if ($row['STATUSSHOW1'] == 1) {
                                                    echo '<span style="color: green;">CONSULTATION</span>';
                                                } else {
                                                    echo '<span style="color: red;">NOT CONSULTATION</span>';
                                                }
                                                echo '</td>';

                                                echo '<td style="text-align: center;width:100px">';
                                                if ($row['STATUSSHOW2'] == 1) {
                                                    echo '<span style="color: green;">CONSULTATION</span>';
                                                } else {
                                                    echo '<span style="color: red;">NOT CONSULTATION</span>';
                                                }
                                                echo '</td>';


                                                echo '<td class="text-center">';
                                                echo '<span data-id="' . $row['DOINGID'] . '" class="spn-remarksconsultation" style="display: block;">' . $remarksconsultation . '</span>';
                                                echo '<button data-id="' . $row['DOINGID'] . '" class="btn btn-sm btn-danger btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>';
                                                echo '<textarea data-id="' . $row['DOINGID'] . '" class="txt-remarksconsultation" style="display: none;width:250px">' . $remarksconsultation . '</textarea>';
                                                echo '<button data-id="' . $row['DOINGID'] . '" class="btn btn-sm btn-danger btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>';
                                                echo '</td>';
                                                echo '<td style="text-align: center;width:100px">' . (!empty($row['NEXTAPPT']) ? $row['NEXTAPPT'] : 'N/A') . '</td>';
						echo '<td style="text-align: center;width:100px">' . (!empty($row['LASTCONSULTATION']) ? $row['LASTCONSULTATION'] : 'N/A') . '</td>';

                                                echo '<td style="text-align: center;width:100px">' . $row['AMOUNT'] . '</td>';
                                                echo '<td style="text-align: center;">';
                                                
                                                if ($show_dokter2 == 0) {
                                                    echo '<button type="button" class="btn btn-warning ml-3 btn-sm btn-action" style="font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onclick="updateStatus(\'' . $row['DOINGID'] . '\', 5,\''   . $row['DATE'] .'\',\''   . $row['CUSTOMERID'] .'\')">KONSULTASI DOKTER</button>';
                                                } elseif ($show_dokter2 == 1) {
                                                    echo '<button type="button" class="btn btn-secondary ml-3 btn-sm btn-action" style="font-weight: bold; background-color: #6c757d; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" disabled>SUDAH KONSULTASI</button>';
                                                }

                                                echo '<a href="https://app.oriskin.co.id:84/dokterclinic/erm_ref/' . $row['CUSTOMERID'] . '" class="btn btn-primary btn-sm" style="font-weight: bold; background-color: #007bff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">ERM</a>';

                                                if (@$data_absen->id_member != null) {
                                                    echo '<a href="https://app.oriskin.co.id:84/dokterclinic/reprint/' . $row['CUSTOMERID'] . '" class="btn btn-sm" style="background-color: #95561e63; color: #ffffff; font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" target="_blank">Re-print</a>';
                                                } else {
                                                    echo '<a href="https://app.oriskin.co.id:84/dokterclinic/resep_dokter/' . $row['CUSTOMERID'] . '/' . $row['DOINGID'] . '" class="btn btn-info btn-sm" style="font-weight: bold; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">Resep Dokter</a>';
                                                }

                                                echo '<a class="btn btn-primary btn-sm" style="font-weight: bold; background-color: #28a745; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); color: white; cursor: pointer;" data-toggle="modal" data-target="#booking" data-customerid="' . $row['CUSTOMERID'] . '" data-customername="' . $row['CUSTOMER'] . '">Booking</a>';

                                               
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th style="text-align:center" colspan="14">Total</th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        <th style="text-align:center"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="booking" tabindex="-1" role="dialog" aria-labelledby="bookingLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingLabel">Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookingForm" action="<?= base_url('search_list_bookingdokter') ?>" method="POST">
                    <input type="hidden" id="bookingCustomerId" name="bookingCustomerId">
                    <label for="bookingDate" class="col-form-label">Customer Name</label>
                    <div class="form-group">
                        <label></label>
                        <input id="bookingCustomerName" class="form-control" type="text" disabled>
                    </div>
                    <label for="bookingDate" class="col-form-label">Date</label>
                    <div class="form-group">
                        <label></label>
                        <input id="bookingDate" class="form-control" type="date" name="period">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="nextBooking()">Lanjut</button>
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
                pageTotal = api
                    .column(18, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                 // Fungsi untuk menghitung total CONSULTATION
                 var countConsultation = function(columnIndex) {
                    return api
                        .column(columnIndex)
                        .data()
                        .filter(function(value, index) {
                            // Pastikan value diubah menjadi string, dan cari apakah mengandung kata "CONSULTATION"
                            return String(value).toUpperCase().includes("CONSULTATION") && !String(value).toUpperCase().includes("NOT");
                        }).length;
                };



                var totalFRFDConsultation = countConsultation(14);
                var totalFRDoctorConsultation = countConsultation(15);
                var sumCol11Filtered19 = display.map(el => data[el][19]).reduce((a, b) => intVal(a) + intVal(b), 0);

                $(api.column(14).footer()).html(
                    totalFRFDConsultation
                );

                $(api.column(15).footer()).html(
                    totalFRDoctorConsultation
                );

                $(api.column(19).footer()).html(
                    numberFormat(sumCol11Filtered19, 0)
                );

            },
            dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
            buttons: [{
                extend: 'pdfHtml5',
                title: 'Report Electronic Medical Report',
                className: 'btn-danger',
                orientation: 'landscape',
                pageSize: 'A2',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17,18,19,20]
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
                    let noOfColumn = 20;
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
    function updateStatus(doingId, newStatus, dateDoing, customerId) {
        console.log(dateDoing, customerId);
        
        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            $.ajax({
                type: 'POST',
                url: _HOST + 'App/updateConsultation',
                data: {
                    id: doingId,
                    status: newStatus,
                    dateDoing: dateDoing,
                    customerId: customerId
                },
                success: function(response) {
                    alert(response);
                    $('#status_' + doingId).text(response.remarks);
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses permintaan.');
                }
            });
        }
    }

    $(document).ready(function() {
        $('#booking').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var customerid = button.data('customerid');
            var customername = button.data('customername');
            $('#bookingCustomerId').val(customerid);
            $('#bookingCustomerName').val(customername);
        });
    });

    function nextBooking() {
        var customerId = $('#bookingCustomerId').val();
        var bookingDate = $('#bookingDate').val();
        $('#bookingForm').submit();
    }
</script>

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
