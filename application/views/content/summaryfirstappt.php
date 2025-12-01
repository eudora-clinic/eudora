<style>
  /*sementara hanya berjalan di firefox*/
  .bootstrap-select>.dropdown-toggle.bs-placeholder,
  .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
  .bootstrap-select>.dropdown-toggle.bs-placeholder:focus,
  .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
    color: #fff;
  }

  .table-wrapper {
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
  }

  .table th,
  .table td {
    border: 1px solid #00BCD4;
    padding: 8px;
    text-align: center;
  }

  .table thead {
    background-color: #f2f2f2;
  }

  .table th {
    background-color: #00BCD4;
    color: white;
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
ini_set('memory_limit', '-1');
// Setting memory limit sql server to 512M
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288');
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288');
$q = (isset($_GET['q']) ? $this->input->get('q') : '');
# dibuat langsung di view untuk memudahkan
# tidak dibuat di model
# load database oriskin (lihat di config/database.php)
$db_oriskin = $this->load->database('oriskin', true);
$customerId = '';
$fullname = '';
$membercode = '';
$recurring = array();
$recurring_dtl = array();

$locationid = $this->session->userdata('locationid');
$appt = $db_oriskin->query("EXEC spReportApptCustomerClinicFrActivity '" . $locationid . "'")->result_array();



?>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-info">
          <h4 class="card-title">Detail H-1 Appt Clinic</h4>
        </div>
        <div class="card-body">
          <div class="row gx-4">
            <div class="col-md-12 mt-3">
                  <div class="table-wrapper">
                    <table id="tbl-appt" class="table table-bordered display highlight cell-border row-border"
                      style="width:100%">
                      <thead class="thead-danger">
                        <tr role="" class="bg-info text-white">
                          <th style="text-align: center;width:50px">RSM</th>
                          <th style="text-align: center;width:30px">PENGELOLA</th>
                          <th style="text-align: center;width:50px">CLINIC</th>
                          <th style="text-align: center;width:40px">ID</th>
                          <th style="text-align: center;width:100px">GUEST</th>
                          <th style="text-align: center;width:40px">TREATMENT NAME</th>
                          <th style="text-align: center;width:40px">WA</th>
                          <th style="text-align: center;width:70px">CELLPHONENUMBER</th>
                          <th style="text-align: center;width:40px">APPTDATE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        foreach ($appt as $h) {
                          $dateString = explode('-', substr($h['APPTDATE'], 0, 10));
                          $dateappt = $dateString[2] . '-' . $dateString[1] . '-' . $dateString[0];
                          $cellphonenumber = preg_replace('/\D/', '', $h['CELLPHONENUMBER']);
										$country_code = '62';
										$new_number = substr_replace($cellphonenumber, '+' . $country_code, 0, ($cellphonenumber[0] == '0'));
                          echo '<tr>
                                        <td class="text-left">' . $h['RSM'] . '</td>
                                        <td class="text-left">' . $h['PENGELOLA'] . '</td>
                                        <td class="text-left">' . $h['LOCATIONNAME'] . '</td>
                                        <td class="text-center">' . $h['CUSTOMERID'] . '</td>
                                        <td class="text-center">' . $h['CUSTOMERNAME'] . '</td>
									                      <td class="text-center">' . $h['TREATMENTNAME'] . '</td>
                                        <td class="text-center"><a href="https://wa.me/' . $new_number . '" ><i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i></a></td>
                                        <td class="text-center">' . $h['CELLPHONENUMBER'] . '</td>
                                        <td class="text-center">' . $dateappt . '</td>
                                </tr>';
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
  // fungsi untuk format angka jadi 999,999.00 atau 999.999,00
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

  $(document).ready(function () {

    // Tabel Data Show & Join
    $('#tbl-appt').DataTable({
      paging: true,
      pageLength: 10,
      order: [[0, 'desc']],
      dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
      buttons: [
        {
          extend: 'pdfHtml5',
          title: 'Report Data Appt',
          className: 'btn-danger',
          orientation: 'landscape',
          pageSize: 'A3',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Sesuaikan dengan kolom yang ingin diekspor
          },
          footer: true
        },
        {
          extend: 'excelHtml5',
          title: 'Report Data Appt',
          footer: true,
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Sesuaikan dengan kolom yang ingin diekspor
          }
        }
      ]
    });
  });
</script>
<script type="text/javascript">
  $('#tbl-appt').removeClass('display').addClass(
    'table table-striped table-hover table-compact');
</script>