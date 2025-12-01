<style>
    .bg-thead {
        background-color: #f5e0d8 !important;
        color: #666666 !important;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 100 !important;
    }

    .form-control {
        border-radius: 8px;
        padding: 8px;
        font-size: 13px;
    }
</style>
<?php
$db_oriskin = $this->load->database('oriskin', true);
$job_list = $db_oriskin->query("select id, name from msjob order by id")->result_array();
$location_list = $db_oriskin->query("select id, name from mslocation order by id")->result_array();
?>
<div class="container-fluid">
    <div class="card p-2 col-md-6">
        <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
            <div class="row g-3" style="display: flex; align-items: center;">
                <div class="col-md-9">
                    <div class="input-group">
                        <input type="text" id="name" name="name" class="form-control text-uppercase" required="true" aria-required="true" placeholder="ketik Nama yang akan dicari" value="<?= (isset($_GET['name']) ? $_GET['name'] : '') ?>">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn w-100 btn-primary" id="buttonSearch">Search</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-thead" style="display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
                    <h4 class="card-title">Data Employee Eudora</h4>
                </div>
                <div class="card-body">
                    <div id="result" style="display: <?= (isset($_GET['submit']) ? 'block;' : 'none;') ?>">
                        <?php
                        if (isset($_GET['submit'])) {
                            $name = $this->input->get('name');
                            $query = $db_oriskin->query("select TOP (100) id, name, cellphonenumber, isactive from msemployee where name like '%" . $name . "%' order by name");
                            $header = $query->result_array();
                        }
                        ?>
                        <div class="table-wrapper">
                            <div class="material-datatables">
                                <table id="dt-invoice-membership" class="table table-bordered" cellspacing="0" width="100%" role="grid">
                                    <thead>
                                        <tr role="">
                                            <th style="text-align: center;">Name</th>
                                            <th style="text-align: center;">Cellphone</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($header)) {
                                            foreach ($header as $v) {
                                                echo '<tr>
															<td class="text-center">
																<span id="sp-name-' . $v['id'] . '">' . $v['name'] . '</span>
																<input type="text" id="name-' . $v['id'] . '" value="' . $v['name'] . '" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-cellphonenumber-' . $v['id'] . '">' . $v['cellphonenumber'] . '</span>
																<input type="text" id="cellphonenumber-' . $v['id'] . '" value="' . $v['cellphonenumber'] . '" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<span id="sp-isactive-' . $v['id'] . '">' . $v['isactive'] . '</span>
																<input type="text" id="isactive-' . $v['id'] . '" value="' . $v['isactive'] . '" style="width: 100%; display: none;">
															</td>
															<td class="text-center">
																<button id="btn-edit-header-' . $v['id'] . '" class="btn btn-sm btn-info" onclick="editHeader(&apos;' . $v['id'] . '&apos;, event);"><i class="material-icons">edit</i> Edit Header</button>
																<button id="btn-save-header-' . $v['id'] . '" class="btn btn-sm btn-info" onclick="saveHeader(&apos;' . $v['id'] . '&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save Header</button>
																<button id="btn-show-detail-' . $v['id'] . '" class="btn btn-sm btn-success" onclick="showDetail(this, &apos;' . $v['id'] . '&apos;, event);"><i class="material-icons">download</i> Detail</button>
															</td>
														  </tr>';
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end content-->
            </div>
            <!--  end card  -->
        </div>
        <!-- end col-md-12 -->
    </div>
    <!-- end row -->
</div>
<script>
    //_mod dideklarasikan di initapp.js
    _mod = '<?= $mod ?>';
    var _joblist = <?php echo json_encode($job_list) ?>;
    var _locationlist = <?php echo json_encode($location_list) ?>;

    function editHeader(_id, e) {
        e.preventDefault();
        $('#sp-name-' + _id).hide();
        $('#sp-cellphonenumber-' + _id).hide();
        $('#sp-isactive-' + _id).hide();
        $('#btn-edit-header-' + _id).hide();

        $('#name-' + _id).val($('#sp-name-' + _id).html());
        $('#cellphonenumber-' + _id).val($('#sp-cellphonenumber-' + _id).html());
        $('#isactive-' + _id).val($('#sp-isactive-' + _id).html());

        $('#name-' + _id).show();
        $('#cellphonenumber-' + _id).show();
        $('#isactive-' + _id).show();
        $('#btn-save-header-' + _id).show();
    }

    function saveHeader(_id, e) {
        e.preventDefault();

        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {

            var _name = $('#name-' + _id).val();
            var _cellphonenumber = $('#cellphonenumber-' + _id).val();
            var _isactive = $('#isactive-' + _id).val();

            $.post(_HOST + 'App/updateMsemployee', {
                id: _id,
                name: _name,
                cellphonenumber: _cellphonenumber,
                isactive: _isactive
            }, function(result) {
                alert(result);
                location.reload();
            });
        } else {
            $('#sp-name-' + _id).show();
            $('#sp-cellphonenumber-' + _id).show();
            $('#sp-isactive-' + _id).show();
            $('#btn-edit-header-' + _id).show();


            $('#name-' + _id).hide();
            $('#cellphonenumber-' + _id).hide();
            $('#isactive-' + _id).hide();
            $('#btn-save-header-' + _id).hide();
        }
    }

    function showDetail(_obj, _employeeid, e) {
        e.preventDefault();
        var _tr = $(_obj).closest('tr');
        var _index = _tr.index();
        var _name = $('#name-' + _employeeid).val();
        var _html = '';
        var _res;

        console.log(_employeeid);

        $.post(_HOST + 'App/getJSON/list_msemployeedetail/' + _employeeid, {}, function(result) {
            _res = JSON.parse(result);
            console.log(_res, 'res')
        });

        _html = '<div class="row">' +
            '<div class="col-md-12">' +
            '<div class="card">' +
            '<div class="card-header card-header-icon card-header-rose">' +
            '<div class="card-icon">' +
            '<i class="material-icons">assignment</i>' +
            '</div>' +
            '<h4 class="card-title">Detail Employee No: <strong>' + _name + '</strong></h4>' +
            '</div>' +
            '<div class="card-body">' +
            '<div class="table-responsive">' +
            '<table class="table">' +
            '<thead class=" text-primary">' +
            '<tr>' +
            '<th style="width:5%;">ID</th>' +
            '<th style="width:20%;">Employeeid</th>' +
            '<th style="width:20%;">Job </th>' +
            '<th style="width:20%;">Location</th>' +
            '<th style="width:15%;">Aksi</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>';
        for (var i = 0; i < _res.length; i++) {
            _html += '<tr>' +
                '<td>' +
                '<span id="sp-id-' + _res[i]['id'] + '">' + _res[i]['id'] + '</span>' +
                '</td>' +
                '<td>' +
                '<span id="sp-employeeid-' + _res[i]['id'] + '">' + _res[i]['employeeid'] + '</span>' +
                '</td>' +
                '<td>' +
                '<span id="sp-jobid-' + _res[i]['id'] + '">' + _res[i]['jobname'] + '</span>' +
                '<input type="hidden" id="hd-jobid-' + _res[i]['id'] + '" value="' + _res[i]['jobid'] + '">' +
                '<input type="text" id="jobid-' + _res[i]['id'] + '" value="' + _res[i]['jobid'] + '" style="width: 100%; display: none;" list="list-job-' + _res[i]['id'] + '">' +
                '<datalist id="list-job-' + _res[i]['id'] + '">';

            for (var l = 0; l < _joblist.length; l++) {
                _html += '<option value="' + _joblist[l]['id'] + '">' + _joblist[l]['name'] + '</option>';
            }

            _html += ' 	</datalist>' +
                '</td>' +
                '<td>' +
                '<span id="sp-locationid-' + _res[i]['id'] + '">' + _res[i]['locationname'] + '</span>' +
                '<input type="hidden" id="hd-locationid-' + _res[i]['id'] + '" value="' + _res[i]['locationid'] + '">' +
                '<input type="text" id="locationid-' + _res[i]['id'] + '" value="' + _res[i]['locationid'] + '" style="width: 100%; display: none;" list="list-location-' + _res[i]['id'] + '">' +
                '<datalist id="list-location-' + _res[i]['id'] + '">';

            for (var l = 0; l < _locationlist.length; l++) {
                _html += '<option value="' + _locationlist[l]['id'] + '">' + _locationlist[l]['name'] + '</option>';
            }

            _html += ' 	</datalist>' +
                '</td>' +


                '<td class="text-center">' +
                '<button id="btn-edit-detail-' + _res[i]['id'] + '" class="btn btn-sm btn-info" onclick="editDetail(&apos;' + _res[i]['id'] + '&apos;, event);"><i class="material-icons">edit</i> Edit Detail</button>' +
                '<button id="btn-save-detail-' + _res[i]['id'] + '" class="btn btn-sm btn-info" onclick="saveDetail(&apos;' + _res[i]['id'] + '&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save Detail</button>' +
                '</td>' +
                '</tr>';
        }
        _html += '</tbody>' +
            '</table>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $('#dt-invoice-membership').find('.detail').remove();
        $(_tr).after('<tr class="detail"><td colspan="4">' + _html + '</td></tr>');
    }

    function editDetail(_id, e) {
        e.preventDefault();
        $('#sp-jobid-' + _id).hide();
        $('#sp-locationid-' + _id).hide();

        $('#btn-edit-detail-' + _id).hide();

        $('#jobid-' + _id).val($('#hd-jobid-' + _id).val());
        $('#locationid-' + _id).val($('#hd-locationid-' + _id).val());


        $('#jobid-' + _id).show();
        $('#locationid-' + _id).show();
        $('#btn-save-detail-' + _id).show();
    }

    function saveDetail(_id, e) {
        e.preventDefault();

        var _confirm = confirm('Anda Yakin?');

        if (_confirm) {
            var _jobid = $('#jobid-' + _id).val();
            var _locationid = $('#locationid-' + _id).val();

            $.post(_HOST + 'App/updateMsemployeedetail', {
                id: _id,
                jobid: _jobid,
                locationid: _locationid,
            }, function(result) {
                alert(result);
                //location.reload();
                $('#sp-jobid-' + _id).html($('#list-job-' + _id + ' option[value="' + $('#jobid-' + _id).val() + '"]').text());
                $('#hd-jobid-' + _id).val($('#jobid-' + _id).val());
                $('#sp-locationid-' + _id).html($('#list-location-' + _id + ' option[value="' + $('#locationid-' + _id).val() + '"]').text());
                $('#hd-locationid-' + _id).val($('#locationid-' + _id).val());

                $('#sp-jobid-' + _id).show();
                $('#sp-locationid-' + _id).show();
                $('#btn-edit-detail-' + _id).show();

                $('#jobid-' + _id).hide();
                $('#locationid-' + _id).hide();

                $('#btn-save-detail-' + _id).hide();
            });
        } else {
            $('#sp-jobid-' + _id).show();
            $('#sp-locationid-' + _id).show();


            $('#sp-enddate-' + _id).show();
            $('#btn-edit-detail-' + _id).show();
            $('#jobid-' + _id).hide();
            $('#locationid-' + _id).hide();

            $('#btn-save-detail-' + _id).hide();
        }
    }
</script>

<script>
    $(document).ready(function() {
        $('#dt-invoice-membership').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,
        });
    });


    $('#dt-invoice-membership').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>