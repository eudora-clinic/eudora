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
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Potensial RO</h4>
        		</div>
				<div class="card-body">
					<div class="toolbar">
					</div>
					<div>
						<?php
							# dibuat langsung di view untuk memudahkan 
							# tidak dibuat di model
							
								$no_invoice = $this->session->userdata('locationid');
								# load database oriskin (lihat di config/database.php)
								$db_oriskin = $this->load->database('oriskin', true);
								# query
								$query = $db_oriskin->query("select  * from msdetailrepeatorder where locationid = '".$no_invoice."' and period='2023-08' and about like '%POTENTIAL%'");
								if ($query->num_rows() <= 0) {
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>No. Invoice <strong>'.$no_invoice.'</strong> tidak ditemukan</span>
											</div>';
								} else { 
									$header = $query->result_array();
									//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
								} 
						?>
					<div class="table-wrapper">
								<!--<table id="dt-realisasi" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid">-->
								<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
											<th width="30px" >No</th>
											<th width="80px" class="text-center">ID</th>
											<th width="200px" class="first-col sticky-col">Name</th>
											<th width="130px" class="text-center">Cellphone</th>
											<th width="120px" class="text-center">Type</th>
											<th width="200px"class="text-center">Treatment/Membership</th>
											<th width="70px" class="text-center">EXP</th>
											<th width="100px" class="text-center">Call Date</th>
											<th width="70px" class="text-center">Appt</th>
											<th width="100px" class="text-center">Date</th>
											<th width="120px" class="text-center">Done Deal</th>
											<th width="100px" class="text-center">Amount</th>
											<th width="70px" class="text-center">Show</th>
											<th width="70px" class="text-center">RO</th>
											<th width="100px" class="text-center">Amount</th>
											<th width="200px" class="text-center">Remark</th>
											<th width="70px" class="text-center">No RO</th>
											<th width="200px" class="text-center">Solution</th>
											<th width="70px" class="text-center">Aksi</th>
										</tr>  
									</thead>
									<tbody>
										<?php
											if (isset($header)) {
												$no = 0;
												foreach ($header as $v) {
													echo '<tr>
												
												<td >
													<span id="no-'.$v['id'].'">'.++$no.'</span>
												</td>
												<td class="text-center">
													<span id="sp-customerid-'.$v['id'].'">'.$v['customerid'].'</span>
													<input type="text" id="customerid-'.$v['id'].'" value="'.$v['customerid'].'" style="width: 30px; display: none;">
												</td>
												<td class="first-col sticky-col">
													<span id="sp-lcname-'.$v['id'].'">'.$v['lcname'].'</span>
													<input type="text" id="lcname-'.$v['id'].'" value="'.$v['lcname'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-cellphonenumber-'.$v['id'].'">'.$v['cellphonenumber'].'</span>
													<input type="text" id="cellphonenumber-'.$v['id'].'" value="'.$v['cellphonenumber'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-lctype-'.$v['id'].'">'.$v['lctype'].'</span>
													<input type="text" id="lctype-'.$v['id'].'" value="'.$v['lctype'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-membershipname-'.$v['id'].'">'.$v['membershipname'].'</span>
													<input type="text" id="membershipname-'.$v['id'].'" value="'.$v['membershipname'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-expiredate-'.$v['id'].'">'.$v['expiredate'].'</span>
													<input type="text" id="expiredate-'.$v['id'].'" value="'.$v['expiredate'].'" style="width: 100px; display: none;">
												</td>
												
												<td class="text-center">
													<span id="sp-calldate-'.$v['id'].'">'.$v['calldate'].'</span>
													<input type="date" id="calldate-'.$v['id'].'" value="'.$v['calldate'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-appt-'.$v['id'].'">'.$v['appt'].'</span>
													<input type="number" id="appt-'.$v['id'].'" value="'.$v['appt'].'" style="width: 50px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-dateappt-'.$v['id'].'">'.$v['dateappt'].'</span>
													<input type="date" id="dateappt-'.$v['id'].'" value="'.$v['dateappt'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-donedealdate-'.$v['id'].'">'.$v['donedealdate'].'</span>
													<input type="date" id="donedealdate-'.$v['id'].'" value="'.$v['donedealdate'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-amountdonedeal-'.$v['id'].'">'.$v['amountdonedeal'].'</span>
													<input type="number" id="amountdonedeal-'.$v['id'].'" value="'.$v['amountdonedeal'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-show-'.$v['id'].'">'.$v['show'].'</span>
													<input type="number" id="show-'.$v['id'].'" value="'.$v['show'].'" style="width: 50px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-ro-'.$v['id'].'">'.$v['ro'].'</span>
													<input type="number" id="ro-'.$v['id'].'" value="'.$v['ro'].'" style="width: 50px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-amount-'.$v['id'].'">'.$v['amount'].'</span>
													<input type="number" id="amount-'.$v['id'].'" value="'.$v['amount'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-remarks-'.$v['id'].'">'.$v['remarks'].'</span>
													<input type="text" id="remarks-'.$v['id'].'" value="'.$v['remarks'].'" style="width: 200px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-noro-'.$v['id'].'">'.$v['noro'].'</span>
													<input type="number" id="noro-'.$v['id'].'" value="'.$v['noro'].'" style="width: 50px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-solusi-'.$v['id'].'">'.$v['solusi'].'</span>
													<input type="text" id="solusi-'.$v['id'].'" value="'.$v['solusi'].'" style="width: 200px; display: none;">
												</td>
												
												<td class="text-center">
													<button id="btn-edit-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="editHeader(&apos;'.$v['id'].'&apos;, event);"><i class="material-icons" >edit</i></button>
													<button id="btn-save-header-'.$v['id'].'" class="btn btn-sm btn-info" onclick="saveHeader(&apos;'.$v['id'].'&apos;, event);" style="display: none;"><i class="material-icons">save</i> Save</button>
												</td>
														  </tr>';
												}
											}
										?>
									</tbody>
									<tfoot></tfoot>
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
												.column( 13 )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
								
											// Total over this page
											pageTotal = api
												.column( 13, { page: 'current'} )
												.data()
												.reduce( function (a, b) {
													return intVal(a) + intVal(b);
												}, 0 );
										

											// Total filtered rows on the selected column (code part added)
											var sumCol13Filtered = display.map(el => data[el][13]).reduce((a, b) => intVal(a) + intVal(b), 0 );
										
											// Update footer
											$( api.column( 13 ).footer() ).html(
												'Rp. '+pageTotal +' ( Rp. '+ total +' total) (Rp. ' + sumCol13Filtered +' filtered)'
											);
										},
									
										dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
										buttons: [
											/*{
												extend: 'excel',
												className: 'btn-success',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15]
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
												title: 'Data Repeat Order Oriskin',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'LEGAL',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Data Repeat Order Oriskin',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,15]
												},
												footer: true,
												title: 'Data Repeat Order Oriskin',
												customize: function (win) {
													$(win.document.body).find('h1').css('font-size', '15pt');
													$(win.document.body).find('h1').css('text-align', 'center'); 
													/*$(win.document.body).find('tr').each(function(index) {
														$(this).find('td:first').html(index); // no urut
													});*/
												}
											},
											{ extend: 'excelHtml5',title: 'Data Guest Online Oriskin', footer: true },
																				
										]
									  });
									  /*$('#example_filter input[type=search]').on('focusout', function() {
										var filtered = table.rows({search:'applied'});
										var jml = filtered.count();
										var total_amount = 0;
										var total_buy = 0;

										for (i = 0; i < jml; i++) {
											//alert(table.rows(i).data()[0]['']);
											//alert(filtered.row(i).index());
											alert(filtered.row(i).index().);
										}

									  });*/
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
	//_mod dideklarasikan di initapp.js
	_mod = '<?=$mod?>';
  
	function editHeader(_id, e) {
		e.preventDefault();
		$('#sp-calldate-'+_id).hide();
		$('#sp-appt-'+_id).hide();
		$('#sp-dateappt-'+_id).hide();
		$('#sp-donedealdate-'+_id).hide();
		$('#sp-amountdonedeal-'+_id).hide();
		$('#sp-show-'+_id).hide();
		$('#sp-ro-'+_id).hide();
		$('#sp-amount-'+_id).hide();
		$('#sp-remarks-'+_id).hide();
		$('#sp-noro-'+_id).hide();
		$('#sp-solusi-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#calldate-'+_id).val($('#sp-calldate-'+_id).html());
		$('#appt-'+_id).val($('#sp-appt-'+_id).html());
		$('#dateappt-'+_id).val($('#sp-dateappt-'+_id).html());
		$('#donedealdate-'+_id).val($('#sp-donedealdate-'+_id).html());
		$('#amountdonedeal-'+_id).val($('#sp-amountdonedeal-'+_id).html());
		$('#show-'+_id).val($('#sp-show-'+_id).html());
		$('#ro-'+_id).val($('#sp-ro-'+_id).html());
		$('#amount-'+_id).val($('#sp-amount-'+_id).html());
		$('#remarks-'+_id).val($('#sp-remarks-'+_id).html());
		$('#noro-'+_id).val($('#sp-noro-'+_id).html());
		$('#solusi-'+_id).val($('#sp-solusi-'+_id).html());
		$('#calldate-'+_id).show();
		$('#appt-'+_id).show();
		$('#dateappt-'+_id).show();
		$('#donedealdate-'+_id).show();
		$('#amountdonedeal-'+_id).show();
		$('#show-'+_id).show();
		$('#ro-'+_id).show();
		$('#amount-'+_id).show();
		$('#remarks-'+_id).show();
		$('#noro-'+_id).show();
		$('#solusi-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _calldate = $('#calldate-'+_id).val();
			var _appt = $('#appt-'+_id).val();
			var _dateappt = $('#dateappt-'+_id).val();
			var _donedealdate = $('#donedealdate-'+_id).val();
			var _amountdonedeal = $('#amountdonedeal-'+_id).val();
			var _show = $('#show-'+_id).val();
			var _ro = $('#ro-'+_id).val();
			var _amount = $('#amount-'+_id).val();
			var _remarks = $('#remarks-'+_id).val();
			var _noro = $('#noro-'+_id).val();
			var _solusi = $('#solusi-'+_id).val();
			

			$.post(_HOST+'App/updateDetailOrder', {id:_id,calldate:_calldate,appt:_appt,dateappt:_dateappt,donedealdate:_donedealdate,amountdonedeal:_amountdonedeal,show:_show,ro:_ro,amount:_amount,remarks:_remarks,noro:_noro,solusi:_solusi}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-calldate-'+_id).show();
			$('#sp-appt-'+_id).show();
			$('#sp-dateappt-'+_id).show();
			$('#sp-donedealdate-'+_id).show();
			$('#sp-amountdonedeal-'+_id).show();
			$('#sp-show-'+_id).show();
			$('#sp-ro-'+_id).show();
			$('#sp-amount-'+_id).show();
			$('#sp-remarks-'+_id).show();
			$('#sp-noro-'+_id).show();
			$('#sp-solusi-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#calldate-'+_id).hide();
			$('#appt-'+_id).hide();
			$('#dateappt-'+_id).hide();
			$('#donedealdate-'+_id).hide();
			$('#amountdonedeal-'+_id).hide();
			$('#show-'+_id).hide();
			$('#ro-'+_id).hide();
			$('#amount-'+_id).hide();
			$('#remarks-'+_id).hide();
			$('#noro-'+_id).hide();
			$('#solusi-'+_id).hide();

			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>
