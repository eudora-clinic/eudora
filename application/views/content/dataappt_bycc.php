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
		left: 112px;
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
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m-d'));
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Appt By Customer Care</h4>
        		</div>
				<div class="card-body">
				<div class="toolbar">
					</div>

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

							# query
							$query = $db_oriskin->query("SELECT
                b.name AS CC_NAME,
                CONVERT(VARCHAR(10),a.treatmentdate,120) AS APPTDATE,
                c.name AS CLINIC,
                a.customerid AS CUSTOMERID,
                d.firstname + (CASE WHEN d.lastname IS NULL THEN '' ELSE ' ' + d.lastname END) AS MEMBERNAME,
                e.name AS TREATMENTNAME
                FROM trdoingtreatment a INNER JOIN msemployee b ON a.frontdeskid = b.id
                INNER JOIN mslocation c ON a.locationid = c.id
                INNER JOIN mscustomer d ON a.customerid = d.id
                INNER JOIN mstreatment e ON a.producttreatmentid = e.id
                INNER JOIN msstatus f ON a.status = f.id
                WHERE
                a.frontdeskid BETWEEN 6191 AND 6220
                ORDER BY b.name");

								$header = $query->result_array();
								//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");



						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
										<th width="170px" class="first-col sticky-col">CC</th>
											<th width="200px" class="text-center">APPTDATE</th>
											<th width="100px" class="text-center">CLINIC</th>
                      <th width="100px" class="text-center">MEMBERID</th>
											<th width="150px" class="text-center">MEMBERNAME</th>
                      <th width="150px" class="text-center">TREATMENTNAME</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												foreach ($header as $v)
													 {
													echo '<tr>
												<td class="first-col sticky-col">'.$v['CC_NAME'].'</td>
												<td class="text-center">'.$v['APPTDATE'].'</td>
												<td class="text-center">'.$v['CLINIC'].'</td>
												<td class="text-center">'.$v['CUSTOMERID'].'</td>
												<td class="text-center">'.$v['MEMBERNAME'].'</td>
												<td class="text-center">'.$v['TREATMENTNAME'].'</td>





														  </tr>';
												}
											}
										?>
										</tbody>

									<tfoot>
										<tr>

											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>
											<th style="text-align:center"></th>

										</tr>
									</tfoot>
								</table>
								<script>
									$(document).ready(function () {
  									  $('#example').DataTable({
										"footerCallback": function ( row, data, start, end, display ) {
											var api = this.api(), data;

											// Remove the formatting to get integer data for summation
											var intVal = function ( i ) {
												return typeof i === 'string' ?
													i.replace(/\./g, '')*1 :
													typeof i === 'number' ?
														i : 0;
											};

											// Total over all pages
											total = api
												.column( 5 )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );

											// Total over this page
											pageTotal = api
												.column( 5, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );

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
												title: 'Data Appt By Customer Care',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'a3',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5]
												},
												footer: true
											},
											{
												extend: 'print',
												title: 'Data Appt By Customer Care',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5]
												},
												footer: true,
												title: 'Data Appt By Customer Care',
												customize: function (win) {
													$(win.document.body).find('h1').css('font-size', '15pt');
													$(win.document.body).find('h1').css('text-align', 'center');
													/*$(win.document.body).find('tr').each(function(index) {
														$(this).find('td:first').html(index); // no urut
													});*/
												}
											},
											{ extend: 'excelHtml5',title: 'Data Member Not Doing More than 14 days', footer: true },

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
