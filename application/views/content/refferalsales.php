<style>
		/*sementara hanya berjalan di firefox*/
		.bootstrap-select>.dropdown-toggle.bs-placeholder, .bootstrap-select>.dropdown-toggle.bs-placeholder:active, .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
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
		background-color: rgba(0,0,0,.5);
		-webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
	}
	@page {
		size: auto;
	}
</style>

<?php
	# Penambahan select option job dan location
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	$month_list = $db_oriskin->query("select id, name from msmonth order by id")->result_array();
	$period = (isset($_GET['period']) ? $this->input->get('period') : date('Y-m'));
	$dob = (isset($_GET['dob']) ? $this->input->get('dob') : date('m'));
  $locationid = $this->session->userdata('locationid');

?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Refferal By Sales</h4>
        		</div>
				<div class="card-body">

					<div class="toolbar">
					</div>
					<div>
					<?php
							# dibuat langsung di view untuk memudahkan
							# tidak dibuat di model

							$no_invoice = $this->session->userdata('locationid');
							# dipindahkan ke atas biar terbaca saat pertama load
							//$datestart = $this->input->get('datestart');
							//$dateend = $this->input->get('dateend');

							# load database oriskin (lihat di config/database.php)
							$db_oriskin = $this->load->database('oriskin', true);

              $employeeid 	= $db_oriskin->query("select a.* from msemployee a
              INNER JOIN msemployeedetail b ON a.id = b.employeeid
              WHERE a.isactive = 1 AND b.jobid = 4 AND b.locationid = '".$locationid."' AND a.id NOT IN(6029)")->result_array();
							# query
							$query = $db_oriskin->query(" SELECT
                    	a.id,
              			ISNULL (a.employeeid, 0) AS employeeid,
              			ISNULL (b.name, 0) AS name,
              			a.customerid AS CUSTOMERID,
              			c.firstname + (CASE WHEN c.lastname IS NULL THEN '' ELSE ' ' + c.lastname END) AS CUSTOMERNAME,
              			c.cellphonenumber AS CELLPHONENUMBER,
              			c.locationid AS C_LOCATIONID,
										e.locationid AS E_LOCATIONID,
              			d.name AS CLINIC
              			FROM msreferalsales a LEFT JOIN msemployee b ON a.employeeid = b.id
										INNER JOIN msemployeedetail e ON b.id = e.employeeid
              			LEFT JOIN mscustomer c ON a.customerid = c.id
              			INNER JOIN mslocation d ON c.locationid = d.id
              			WHERE b.isactive = 1 AND b.id NOT IN (6029) AND c.locationid = '".$locationid."'
										AND ISNULL (a.employeeid, 0) >= 0
                    ORDER BY b.name ASC");

								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");



						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="60px" class="text-center">No</th>
										<th width="60px" class="text-center">Sales ID</th>
										<th width="180px" class="text-left">Sales Name</th>
										<th width="100px" class="text-center">ID</th>
										<th width="90px" class="text-center">Name</th>
										<th width="200px" class="text-center">Cellphonenumber</th>
										<th width="150px" class="text-center">Clinic</th>
                    <th width="60px" class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($header)) {

												$no = 0;
												foreach ($header as $v)
													 {
														 $showEditButton = $v['E_LOCATIONID'] == $v['C_LOCATIONID'];
													echo '<tr>


												<td class="text-center">'.++$no.'</td>
												<td class="text-center">'.$v['employeeid'].'</td>
                        <td class="text-left">
                            <span id="sp-employeeid-'.$v['CUSTOMERID'].'">'.$v['name'].'</span>
                            <select id="employeeid-'.$v['CUSTOMERID'].'" class="form-control form-select" required="true" aria-required="true" style="width: 100%; display: none;">
                              ';
                              foreach($employeeid as $e) {
                                                            echo '<option value="'.$e['id'].'"';
                                                            echo $v['employeeid'] == $e['id'] ? 'selected' : '';
                                                            echo '>'.$e['name'].'</option>';
                                                        } echo'
                            </select>
                        </td>
												<td class="text-center">
                          <span id="sp-customerid-'.$v['CUSTOMERID'].'">'.$v['CUSTOMERID'].'</span>
                          <input type="text" id="customerid-'.$v['CUSTOMERID'].'" value="'.$v['CUSTOMERID'].'" style="width: 100%; display: none;">
                        </td>
												<td class="first-col sticky-col">
                          <span id="sp-customername-'.$v['CUSTOMERID'].'">'.$v['CUSTOMERNAME'].'</span>
                          <input type="text" id="customername-'.$v['CUSTOMERID'].'" value="'.$v['CUSTOMERNAME'].'" style="width: 100%; display: none;">
                        </td>
												<td class="text-center">
                          <span id="sp-cellphonenumber-'.$v['CUSTOMERID'].'">'.$v['CELLPHONENUMBER'].'</span>
                          <input type="text" id="cellphonenumber-'.$v['CUSTOMERID'].'" value="'.$v['CELLPHONENUMBER'].'" style="width: 100%; display: none;">
                        </td>
												<td class="text-center">
                          <span id="sp-clinic-'.$v['CUSTOMERID'].'">'.$v['CLINIC'].'</span>
                          <input type="text" id="clinic-'.$v['CUSTOMERID'].'" value="'.$v['CLINIC'].'" style="width: 100%; display: none;">
                        </td>
												<td class="text-center">';
				                     // Display the edit button only if e.locationid is equal to c.locationid
				                     if ($showEditButton) {
				                         echo '<button id="btn-edit-header-'.$v['CUSTOMERID'].'" class="btn btn-sm btn-info" onclick="editHeader(&apos;'.$v['CUSTOMERID'].'&apos;, event);"><i class="material-icons">edit</i> Edit Header</button>
				                               <button id="btn-save-header-'.$v['CUSTOMERID'].'" class="btn btn-sm btn-info" onclick="saveHeader(&apos;'.$v['CUSTOMERID'].'&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save Header</button>';
				                     }
				                 echo '</td>
				             </tr>';
												}
											}
										?>
										</tbody>

									<tfoot>
									</tfoot>
								</table>
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
										toFixedFix = function(n, prec) {
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
									  // untuk judul


  									  $('#example').DataTable({
										paging: true,
										//scrollY: "300px",
									    //scrollCollapse: true,

										"footerCallback": function ( row, data, start, end, display ) {

										},
										dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
										buttons: [
											/*{
												extend: 'excel',
												className: 'btn-success',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
												},
												title: 'Data Guest Online Oriskin',
												customize: function (xlsx) {
													var sheet1 = xlsx.xl.worksheets['sheet1.xml'];
												},
												exportOptions: {
													orthogonal: 'export',
													format: {
														body: function (data, row, column) {
															if (column == 0)
																return row+1; // no urut
															else if (column == 6)
																return data.replace(/(&nbsp;|<([^>]+)>)/ig, '').replace(/[0-9]/g, '').replace('%', ''); // menghilangkan persentase
															else
																return data.replace(/(&nbsp;|<([^>]+)>)/ig, '');
														}
													}
												}
											},*/
											{
												extend: 'pdfHtml5',
												title: 'Data Refferal By Sales',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'a3',
												exportOptions: {
													columns: [0, 1, 2, 3,4,5]
												},
												footer: true
											},
											{
												extend: 'print',
												title: 'Data Refferal By Sales',
												exportOptions: {
													columns: [0, 1, 2, 3,4,5]
												},
												footer: true,
												customize: function (win) {
													$(win.document.body).find('h1').css('font-size', '15pt');
													$(win.document.body).find('h1').css('text-align', 'center');
													/*$(win.document.body).find('tr').each(function(index) {
														$(this).find('td:first').html(index); // no urut
													});*/
												}
											},
											{
												extend: 'excelHtml5',
												title: 'Data Refferal By Sales',
												footer: true
											},


										]
									  });

									});
								</script>
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
function editHeader(CUSTOMERID) {
    $('#sp-employeeid-' + CUSTOMERID).hide();
    $('#btn-edit-header-' + CUSTOMERID).hide();

    $('#employeeid-' + CUSTOMERID).show();
    $('#btn-save-header-' + CUSTOMERID).show();
}

function saveHeader(_CUSTOMERID, e) {
    e.preventDefault();

    var _confirm = confirm('Anda Yakin?');

    if (_confirm) {
        var _employeeid = $('#employeeid-'+_CUSTOMERID).val();

        $.ajax({
            type: 'POST',
            url: _HOST + 'App/updateEmployeeAsm',
            data: {
                CUSTOMERID: _CUSTOMERID,
                employeeid: _employeeid
            },
            success: function(result) {
                alert(result);
                // Jika pembaruan berhasil, perbarui tampilan tanpa perlu reload halaman
                $('#sp-employeeid-'+_CUSTOMERID).text($('#employeeid-'+_CUSTOMERID+' option:selected').text()); // Perbarui teks dengan nama employee
                $('#sp-employeeid-'+_CUSTOMERID).show();
                $('#btn-edit-header-'+_CUSTOMERID).show();
                $('#employeeid-'+_CUSTOMERID).hide();
                $('#btn-save-header-'+_CUSTOMERID).hide();
            },
            error: function() {
                // Handle error jika terjadi kesalahan pada AJAX request
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    } else {
        // Jika pengguna membatalkan, kembalikan tampilan ke kondisi semula
        $('#sp-employeeid-'+_CUSTOMERID).show();
        $('#btn-edit-header-'+_CUSTOMERID).show();
        $('#employeeid-'+_CUSTOMERID).hide();
        $('#btn-save-header-'+_CUSTOMERID).hide();
    }
}


</script>

<script>
	function changeSPMonth(_value, e) {
		$('#sp-month').html($('#list-month option[value="' + _value + '"]').text());
	}

	function changeSPLocation(_value, e) {
		$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
	}
</script>
