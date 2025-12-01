<style>
    .checkbox-container {
        display: inline-block;
        margin-right: 9px;
    }

    .checkbox-container19 {
        display: inline-block;
        margin-right: 18px;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    .btn-primary {
        background-color: #e0bfb2 !important;
        color: #666666 !important;
        border: none;
        transition: background-color 0.3s ease;
    }

    .bg-thead {
        background-color: #f5e0d8 !important;
        color: #666666 !important;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: bold !important;
    }



    @media only screen and (max-width: 768px) {
        .mb-3-mobile {
            margin-bottom: 1rem !important;
        }

        .mt-3-mobile {
            margin-top: 0.5rem !important;
        }
    }

    .datepicker-days {
        display: none !important;
    }

    .datepicker-months {
        display: block !important;
    }

    .mycontaine {
        font-size: 12px !important;
    }

    /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
    .mycontaine * {
        font-size: inherit !important;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 15px !important;
        margin-bottom: 10px !important;
    }
</style>

<?php
# Penambahan select option job dan location
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);


$period = $db_oriskin->query("select period from msabsen where period <> '2014-01' group by period order by period desc")->result_array();
?>
<div class="container-fluid mycontaine">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <form action="<?= base_url('search_absen') ?>" method="post">
                    <div class="card-body">
                        <div class="row gap-3" style="display: flex; align-items: center;">
                            <div class="col-md-4 mb-3-mobile">
                                <div class="form-group bmd-form-group">
                                    <label>START PERIOD</label>
                                    <input type="month" class="form-control" name="period_awal" id="period_awal" value="<?= $pwal ?>" placeholder="PERIOD" required>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3-mobile">
                                <div class="form-group bmd-form-group">
                                    <label>END PERIOD</label>
                                    <input type="month" class="form-control" name="period_akhir" id="period_akhir" value="<?= $phir ?>" placeholder="PERIOD" required>
                                </div>
                            </div>

                            <div class="col-md-4 mt-2-mobile d-flex align-items-end">
                                <div class="form-group">
                                    <button type="submit" class="btn w-100 btn-primary">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h4 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">ABSEN CLINIC</h4>

                    <?php

                    $locationid = $this->session->userdata('locationid');
                    $userid = $this->session->userdata('userid');
                    $emp_list = $db_oriskin->query("
                        SELECT
                            a.id AS EMPLOYEEID,
                            a.name AS EMPLOYEENAME,
                            b.locationid AS LOCATIONID,
                            c.id AS JOBID,
                            c.name AS JOBNAME
                        from msemployee a
                        inner join msemployeedetail b ON a.id = b.employeeid
                        inner join msjob c ON b.jobid = c.id
                        WHERE b.jobid IN (6,12,73,39,41) AND a.isactive = 1
                        AND b.locationid = '" . $locationid . "'
                    ")->result_array();
                    ?>
                    <div class="tab-content">
                        <!-- Large modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_tambah" data-whatever="@mdo">Tambah Data</button>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered text-center" id="tableAbsen">
                                <thead class="bg-thead">
                                    <tr>
                                        <th class="text-center">Employee Name</th>
                                        <th class="text-center">Job</th>
                                        <th class="text-center">Period</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($data_absen as $row) { ?>
                                        <tr style="font-weight: 400;">
                                            <td><?= $row['EMPLOYEENAME'] ?></td>
                                            <td><?= $row['JOBNAME'] ?></td>
                                            <td><?= $row['PERIOD'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#edit<?= $row['IDABSEN'] ?>" data-whatever="@mdo">Edit</button>
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

<!-- TAMBAH -->
<div class="col-md-12 mb-3">
    <div class="modal fade modal-transparent modal-fullscreen" id="modal_tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Data Absen (Employee)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-cari-invoice" method="post" action="<?= base_url('save-employee-absen') ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="period">Period:</label>
                            <input type="text" class="form-control datepicker" name="period" value="<?= date('Y-m'); ?>">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="locationid" value="<?= $locationid ?>">
                            <select name="employeeid" id="lib_select2_modal" class="form-control get_employeeid_insert" required>
                                <option value="">Choose Employee...</option>
                                <?php foreach ($emp_list as $employee) { ?>
                                    <option value="<?= $employee['EMPLOYEEID'] ?>"><?= $employee['EMPLOYEENAME'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <input type="hidden" name="jobid" class="form-control jobid_insert" readonly>

                        <div class="form-group">
                            <label for="tgl_absen">Absen Dates:</label><br>
                            <div id="checkboxContainer_insert"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <script>
                    $(document).ready(function() {
                        $('#lib_select2_modal').change(function() {
                            autofill_timestart_insert();
                        });
                        autofill_timestart_insert();
                        updateCheckbox_insert();
                    });

                    var selectedDate;

                    $(document).ready(function() {
                        $('.datepicker').datetimepicker({
                            format: 'YYYY-MM',
                            viewMode: 'months',
                        }).on('dp.change', function(e) {
                            selectedDate = moment(e.date).format('YYYY-MM');
                            updateCheckbox_insert();
                            autofill_timestart_insert()
                        });
                    });

                    function autofill_timestart_insert() {
                        var get_employeeid_insert = $('.get_employeeid_insert').val();

                        $.ajax({
                            type: "post",
                            url: "<?= base_url('App/pilih_waktu_checkbox'); ?>",
                            data: {
                                get_employeeid_post: get_employeeid_insert
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('.pilih_waktu_insert').empty();
                                $('.jobid_insert').val('');
                                console.log(data, 'inilah data');
                                if (data && data.length > 0) {
                                    $.each(data, function(index, item) {
                                        $('.pilih_waktu_insert').append($('<option>', {
                                            value: item.timestart,
                                            text: item.timestart
                                        }));

                                        $('.jobid_insert').val(item.jobid);
                                    });
                                } else {
                                    $('.pilih_waktu_insert').append($('<option>', {
                                        value: '00:00',
                                        text: '00:00'
                                    }));
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    }

                    function updateCheckbox_insert() {
                        var periodInput = $('input[name="period"]').val();

                        var currentDate = moment(periodInput).toDate();

                        var daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

                        var checkboxContainer_insert = $('#checkboxContainer_insert');

                        checkboxContainer_insert.empty();

                        for (var i = 1; i <= daysInMonth; i++) {
                            var checkboxDiv = $('<div>').addClass("checkbox-container");
                            if (i < 10) {
                                checkboxDiv.addClass("checkbox-container19");
                            }

                            var checkbox = $('<input>').attr({
                                type: "checkbox",
                                name: "tgl_absen[]",
                                value: i
                            }).click(function() {
                                toggleSelect_insert(this);
                            });

                            var span = $('<span>').text(i);

                            var select = $('<select>').addClass("custom-select pilih_waktu_insert").attr("name", "start[]").css("display", "none").html('<option value="">Pilih Waktu</option>');

                            checkboxDiv.append(checkbox);
                            checkboxDiv.append(span);
                            checkboxDiv.append(select);
                            checkboxContainer_insert.append(checkboxDiv);
                        }
                    }

                    function toggleSelect_insert(checkbox) {
                        var select = $(checkbox).parent().find('select');
                        select.css('display', checkbox.checked ? 'block' : 'none');
                        if (checkbox.checked) {
                            select.attr('required', 'required');
                        } else {
                            select.removeAttr('required');
                        }
                    }
                </script>

            </div>
        </div>
    </div>
</div>
<!-- END TAMBAH -->

<!-- EDIT -->


<?php foreach ($data_absen as $row) { ?>
    <div class="modal fade modal-transparent modal-fullscreen" id="edit<?= $row['IDABSEN'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="dialog" style="max-height: 500px; margin: auto; ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Absen (Employee)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-cari-invoice" data-spy="scroll" method="post" action="<?= base_url('edit-employee-absen') ?>">
                    <div class="modal-body">
                        <input type="hidden" name="id_absen" value="<?= $row['IDABSEN'] ?>">
                        <input type="hidden" name="locationid" value="<?= $locationid ?>">

                        <div class="form-group">
                            <label for="period">Period:</label>
                            <input type="text" class="form-control" name="period" value="<?= $row['PERIOD']; ?>" readonly>
                        </div>



                        <select name="employeeid" class="form-control get_employeeid_edit<?= $row['EMPLOYEEID'] ?>" onchange="return autofill_timestart_edit<?= $row['EMPLOYEEID'] ?>();" required>
                            <option value="">Choose Employee...</option>
                            <?php foreach ($emp_list as $el) {
                                echo '<option value="' . $el['EMPLOYEEID'] . '"';
                                echo $row['EMPLOYEEID'] == $el['EMPLOYEEID'] ? 'selected' : '';
                                echo '>' . $el['EMPLOYEENAME'] . '</option>';
                            } ?>
                        </select>



                        <input type="hidden" name="jobid" value="<?= $row['JOBID'] ?>" class="form-control jobid_edit" readonly>

                        <div class="form-group">
                            <label for="tgl_absen">Absen Dates:</label><br>

                            <?php
                            $data_checkbox = $db_oriskin->query("
                                    SELECT
                                        a.id AS IDABSEN,
                                        a.period AS PERIOD,
                                        a.tgl_absen as tgl_absen,
                                        a.start as start_absen,
                                        b.id as EMPLOYEEID,
                                        b.name AS EMPLOYEENAME,
                                        c.id as JOBID,
                                        c.name AS JOBNAME
                                    FROM msabsen AS a
                                    JOIN msemployee AS b ON a.employeeid = b.id
                                    JOIN msjob AS c ON a.jobid = c.id
                                    WHERE a.locationid = '" . $locationid . "'
                                    AND a.employeeid = '" . $row['EMPLOYEEID'] . "'
                                    AND a.period = '" . $row['PERIOD'] . "'
                                ")->result_array();

                            $checked_dates = [];
                            $data_start_absen = [];
                            $empid = isset($row['EMPLOYEEID']) ? $row['EMPLOYEEID'] : '';

                            foreach ($data_checkbox as $dc) {
                                echo '<input type="hidden" name="id_absen_array[]" value="' . $dc['IDABSEN'] . '">';

                                $tgl_absen_array = explode(',', $dc['tgl_absen']);
                                foreach ($tgl_absen_array as $tgl_absen_item) {
                                    if (!in_array($tgl_absen_item, $checked_dates)) {
                                        $checked_dates[] = $tgl_absen_item;
                                    }

                                    $data_start_absen[$tgl_absen_item] = '';
                                }

                                $start_absen_array = explode(',', $dc['start_absen']);
                                foreach ($start_absen_array as $start_absen_item) {
                                    $data_start_absen[$tgl_absen_item] = $start_absen_item;
                                }
                            }

                            $tanggal_terakhir = date('t', strtotime($row['PERIOD']));
                            ?>


                            <?php for ($i = 1; $i <= $tanggal_terakhir; $i++) { ?>
                                <div class="checkbox-container <?= ($i < 10) ? "checkbox-container19" : ""; ?>" id="checkbox-container<?= $i ?>">
                                    <input type="checkbox" name="tgl_absen[]" value="<?= $i ?>" <?= in_array($i, $checked_dates) ? 'checked' : '' ?> onclick="toggleSelect_edit<?= $empid ?>(this)">
                                    <span><?= $i ?></span>

                                    <?php
                                    $data_timestart = $db_oriskin->query("select timestart, id, jobid from msopsdoing where jobid = '" . $row['JOBID'] . "' and locationid = '" . $locationid . "' order by timestart asc")->result_array();
                                    // $data_timestart = $db_oriskin->query("select timestart, id, jobid from msopsdoing where jobid = '".$row['JOBID']."' and locationid = '3' order by timestart asc")->result_array();
                                    // echo $db_oriskin->last_query();
                                    if (in_array($i, $checked_dates)) { ?>
                                        <select name="start_edit[]" class="custom-select pilih_waktu_edit" style="display: block;">
                                            <option value="">Pilih Waktu</option>
                                            <?php if (!empty($data_timestart)) { ?>
                                                <?php foreach ($data_timestart as $dt) {
                                                    $dateTime_timestart = new DateTime($dt['timestart']);
                                                    $result_timestart = $dateTime_timestart->format("H:i");

                                                    echo '<option value="' . $result_timestart . '"';
                                                    echo $data_start_absen[$i] == $dt['timestart'] ? 'selected' : '';
                                                    echo '>' . $result_timestart . '</option>';
                                                } ?>
                                            <?php }; ?>
                                        </select>
                                    <?php } else { ?>
                                        <select name="start_edit[]" class="custom-select pilih_waktu_edit" id="start_edit<?= $empid ?>_<?= $i ?>" style="display:none !important;">
                                            <option value="">Pilih Waktu</option>
                                            <?php if (!empty($data_timestart)) { ?>
                                                <?php foreach ($data_timestart as $dt) {
                                                    $dateTime_timestart = new DateTime($dt['timestart']);
                                                    $result_timestart = $dateTime_timestart->format("H:i");
                                                ?>
                                                    <option value="<?= $result_timestart ?>">
                                                        <?= $result_timestart ?>
                                                    </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    <?php } ?>


                                </div>

                                <script>
                                    // AUTO SHOW SELECT KETIKA KLIK CHECKBOX
                                    function toggleSelect_edit<?= $empid ?>(checkbox) {
                                        var select = document.getElementById('start_edit<?= $empid ?>_' + checkbox.value);



                                        select.style.display = checkbox.checked ? 'block' : 'none';
                                        if (checkbox.checked) {
                                            select.setAttribute('required', 'required');
                                        } else {
                                            select.removeAttribute('required');
                                        }
                                    }
                                    // END AUTO SHOW SELECT KETIKA KLIK CHECKBOX

                                    // AUTOFILL TIME PILIH WAKTU PADA SAAT SELECT JOB
                                    function autofill_timestart_edit<?= $row['EMPLOYEEID'] ?>() {
                                        var get_employeeid_edit<?= $row['EMPLOYEEID'] ?> = $('.get_employeeid_edit<?= $row['EMPLOYEEID'] ?>').val();
                                        $.ajax({
                                            type: "post",
                                            url: "<?= base_url('App/pilih_waktu_checkbox'); ?>",
                                            data: {
                                                get_employeeid_post: get_employeeid_edit<?= $row['EMPLOYEEID'] ?>
                                            },
                                            dataType: 'json',
                                            success: function(data) {
                                                $('.pilih_waktu_edit').empty();
                                                $('.jobid_edit').val('');
                                                console.log(data, 'inilah data edit');

                                                if (data.length === 0) {
                                                    $('.pilih_waktu_edit').append($('<option>', {
                                                        value: '00:00',
                                                        text: '00:00'
                                                    }));
                                                } else {
                                                    $.each(data, function(index, item) {
                                                        $('.pilih_waktu_edit').append($('<option>', {
                                                            value: item.timestart,
                                                            text: item.timestart
                                                        }));

                                                        $('.jobid_edit').val(item.jobid);
                                                    });
                                                }


                                            }
                                        });

                                    }
                                    // END AUTOFILL TIME PILIH WAKTU PADA SAAT SELECT JOB
                                </script>
                            <?php } ?>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<!-- END EDIT -->

<script>
    $(document).ready(function() {
        $.fn.select2.defaults.set("theme", "bootstrap");
        $("#lib_select2_modal").select2({
            width: null,
            dropdownParent: $("#modal_tambah")
        });
    });
</script>

<script>
    function isYearMonth(event) {
        var inputValue = event.key;
        // Hanya izinkan angka (0-9) dan karakter '-' untuk dimasukkan
        if (/^\d$/.test(inputValue) || inputValue === '-') {
            return true;
        } else {
            event.preventDefault();
            return false;
        }
    }
</script>

<script>
    $(document).ready(function() {


        $('#tableAbsen').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,

        });
    });
</script>