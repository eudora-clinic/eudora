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
                <div class="card-header card-header-info">
                    <h4 class="card-title">ELECTRONIC MEDICAL RECORD</h4>
                </div>
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
                                        <input type="date" id="dateend" name="dateend" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $dateend ?>">
                                    </div>
                                </div>
                                <button type="submit" id="btn-cari" name="submit" class="btn btn-sm btn-dark" value="true" onclick="if($('#dateend').val() < $('#datestart').val()) {alert('Date End tidak boleh lebih kecil dari Date Start');return false;}"><i></i> Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="row gx-4">
                        <div class="col-md-12 mt-3">
                        </div>
                        <div class="col-md-12 mt-3">

                            <!-- Tab panes -->
                            <div class="">
                                <table id="tbl-membership-treatment" class="table table-bordered table-responsive">
                                    <thead class="thead-danger">
                                        <tr role="" class="bg-info text-white">
                                            <th style="text-align: center;width:150px">Date</th>
                                            <th style="text-align: center;width:100px">Id Doing</th>
                                            <th style="text-align: center;width:110px">ID</th>
                                            <th style="text-align: center;width:100px">Name</th>
                                            <th style="text-align: center;width:100px">Treatment</th>
                                            <th style="text-align: center;width:100px">Qty</th>
                                            <th style="text-align: center;width:100px">Doing By</th>
                                            <th style="text-align: center;width:100px">Job</th>
                                            <th style="text-align: center;width:100px">Assist By</th>
                                            <th style="text-align: center;width:100px">JOB</th>
                                            <th style="text-align: center;width:100px">Start</th>
                                            <th style="text-align: center;width:100px">End</th>
                                            <th style="text-align: center;width:100px">Duration</th>
                                            <th style="text-align: center;width:150px !important">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($resultdata_new_menu as $row) {
                                            $data_absen                         = $db_oriskin->query("select * from resep_dokter where id_member = '" . $row['CUSTOMERID'] . "'")->row();
                                            $show_dokter = $db_oriskin->query("SELECT ISNULL(statusshowdokter, '') AS statusshowdokter FROM trdoingtreatment WHERE id = '" . $row['DOINGID'] . "'")->row()->statusshowdokter ?? 0;
                                            $show_dokter2 = $db_oriskin->query("SELECT ISNULL(statusshowdokter2, '') AS statusshowdokter2 FROM trdoingtreatment WHERE id = '" . $row['DOINGID'] . "'")->row()->statusshowdokter2 ?? 0;
                                        ?>
                                            <tr role="">

                                                <td style="text-align: center;width:150px"><?= $row['DATE'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['DOINGID'] ?></td>
                                                <td style="text-align: center;width:110px"><?= $row['CUSTOMERID'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['CUSTOMER'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['TREATMENT'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['QTY'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['DOINGBY'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['DOINGJOBS'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['ASSISTBY'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['ASSISTJOBS'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['STARTTREATMENT'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['ENDTREATMENT'] ?></td>
                                                <td style="text-align: center;width:100px"><?= $row['DURATION'] ?></td>



                                                <td style="text-align: center;width:150px !important">
                                                    <div class="btn-group">
                                                        <a href="https://app.oriskin.co.id:84/operationalclinic/erm_ref/<?= $row['CUSTOMERID'] ?>" class="btn btn-primary btn-sm">ERM</a>
                                                        <?php if (@$data_absen->id_member != null) { ?>
                                                            <a href="https://app.oriskin.co.id:84/operationalclinic/reprint/<?= $row['CUSTOMERID'] ?>" class="btn btn-sm" style="background-color: #95561e63;" target="_blank">Re-print</a>
                                                        <?php } else { ?>
                                                            <a href="https://app.oriskin.co.id:84/operationalclinic/resep_dokter/<?= $row['CUSTOMERID'] ?>" class="btn btn-info btn-sm">Resep Dokter</a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
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
</div>
<script>
    $(document).ready(function() {
        // untuk judul
        var customerId = '<?= $customerId ?>';

        $('#tbl-treatment-info').DataTable({
            paging: true,
            pageLength: 100,
            //scrollY: "300px",
            //scrollCollapse: true,
            order: [
                [0, 'asc']
            ],
        });

        $('#tbl-membership-treatment').DataTable({
            paging: true,
            pageLength: 10,
            //scrollY: "300px",
            //scrollCollapse: true,
            order: [
                [0, 'asc']
            ],
        });

        $('#tbl-history-doing').DataTable({
            paging: true,
            pageLength: 100,
            //scrollY: "300px",
            //scrollCollapse: true,
            order: [
                [0, 'desc']
            ],
            rowCallback: function(row, data) {
                let dateString = ((data[0]).substring(0, 10)).split('-');
                let reatmentdate = dateString[2] + '-' + dateString[1] + '-' + dateString[0];
                $('td:eq(0)', row).html('<b>' + reatmentdate + '</b>');
            }
        });
        $(".btn-edit").each(function(index) {
            $(this).on("click", function() {
                let id = $(this).data('id');
                //alert('edit '+id);
                $(this).hide();
                $(this).parent().find('.spn-note').hide();
                $(this).parent().find('.txt-note').show();
                $(this).parent().find('.btn-save').show();
            });
        });

        $(".btn-save").each(function(index) {
            $(this).on("click", function() {
                let id = $(this).data('id');
                //alert('save '+id);
                let note = $(this).parent().find('.txt-note').val();

                $.post("<?= base_url('save-note-history-doing') ?>", {
                    doingid: id,
                    note: note
                }, function(res) {
                    //
                }).done(function(res) {
                    console.log(res);
                }).fail(function() {
                    console.log("error");
                });

                $(this).parent().find('.spn-note').html(note);
                $(this).hide();
                $(this).parent().find('.txt-note').hide();
                $(this).parent().find('.spn-note').show();
                $(this).parent().find('.btn-edit').show();
            });
        });
    });
</script>

<script>
    function updateStatus(doingId, newStatus) {
        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            $.ajax({
                type: 'POST',
                url: _HOST + 'App/updateTrDoingTreatmentStatusV2',
                data: {
                    id: doingId,
                    status: newStatus
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
</script>