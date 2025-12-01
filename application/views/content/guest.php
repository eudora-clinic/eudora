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
	
?>
<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
		<a class="btn btn-danger" href="<?=base_url('add-guest')?>" role="button">Input New Guest Online</a>
      		<div class="card">
        		<div class="card-header card-header-primary">
            		<h4 class="card-title">Data Guest Online Oriskin</h4>
        		</div>
				<div class="card-body">
						<?php
							# dibuat langsung di view untuk memudahkan 
							# tidak dibuat di model
							
								$name = $this->session->userdata('locationid');
								# load database oriskin (lihat di config/database.php)msguestonline
								//$db_oriskin = $this->load->database('oriskin', true); # sudah diload di atas
								# query
								$query = $db_oriskin->query("select  a.* ,b.name as Promo from msguestonline a inner join msguestonlitype b on a. guesttypeid = b.id where a.locationid = '".$name."' order by a.updatedate DESC");
								if ($query->num_rows() <= 0) {
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>No. Invoice <strong>'.$name.'</strong> tidak ditemukan</span>
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
											<th width="50px">No</th>
											<th width="150px" class="text-center">Name</th>
											<th width="130px" class="text-center">Cellphone</th>
											<th width="70px" class="text-center" >Date</th>
											<th width="200px" class="text-center" >Promo</th>
											<th width="70px" class="text-center">Call</th>
											<th width="70px" class="text-center">Appt</th>
											<th width="70px" class="text-center">Date</th>
											<th width="70px" class="text-center">Try</th>
											<th width="70px" class="text-center">Date</th>
											<th width="100px" class="text-center">Not Join</th>
											<th width="70px" class="text-center">Join</th>
											<th width="90px" class="text-center">Id-ORI</th>
											<th width="100px" class="text-center">Amount</th>
											<th width="150px" class="text-center">Remark</th>
											<th width="90px" class="text-center">Aksi</th>
										</tr>  
									</thead>
									<tbody>
										<?php
										 
											if (isset($header)) {
												$no = 0;
											

												foreach ($header as $v)
													 {
														

													echo '<tr>
												
												<td class="first-col sticky-col">
													<span id="no-'.$v['id'].'">'.++$no.'</span>
												</td>
												<td class="first-col sticky-col">
													<span id="sp-name-'.$v['id'].'">'.$v['name'].'</span>
													<input type="text" id="name-'.$v['id'].'" value="'.$v['name'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-cellphonenumber-'.$v['id'].'">'.$v['cellphonenumber'].'</span>
													<input type="text" id="cellphonenumber-'.$v['id'].'" value="'.$v['cellphonenumber'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-updatedate-'.$v['id'].'">'.$v['updatedate'].'</span>
													<input type="text" id="updatedate-'.$v['id'].'" value= "'.$v['updatedate'].'" style="width: 120px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-promo-'.$v['id'].'">'.$v['Promo'].'</span>
													<input type="text" id="promo-'.$v['id'].'" value= "'.$v['Promo'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-call-'.$v['id'].'">'.$v['call'].'</span>
													<input type="text" id="call-'.$v['id'].'" value="'.$v['call'].'" style="width: 30px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-appt-'.$v['id'].'">'.$v['appt'].'</span>
													<input type="text" id="appt-'.$v['id'].'" value="'.$v['appt'].'" style="width: 30px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-dateappt-'.$v['id'].'">'.$v['dateappt'].'</span>
													<input type="date" id="dateappt-'.$v['id'].'" value="'.$v['dateappt'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-try-'.$v['id'].'">'.$v['try'].'</span>
													<input type="text" id="try-'.$v['id'].'" value="'.$v['try'].'" style="width: 30px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-datetry-'.$v['id'].'">'.$v['datetry'].'</span>
													<input type="date" id="datetry-'.$v['id'].'" value="'.$v['datetry'].'" style="width: 100px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-notjoin-'.$v['id'].'">'.$v['notjoin'].'</span>
													<input type="text" id="notjoin-'.$v['id'].'" value="'.$v['notjoin'].'" style="width: 30px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-buy-'.$v['id'].'">'.$v['buy'].'</span>
													<input type="text" id="buy-'.$v['id'].'" value="'.$v['buy'].'" style="width: 30px; display: none;">
												</td>
												
												<td class="text-center">
													<span id="sp-customerid-'.$v['id'].'">'.$v['customerid'].'</span>
													<input type="number" id="customerid-'.$v['id'].'" value="'.$v['customerid'].'" style="width: 50px; display: none;">
												</td>
												<td class="text-right">
													<span id="sp-amount-'.$v['id'].'">'.number_format($v['amount'], 0, ',', '.').'</span>
													<input type="number" id="amount-'.$v['id'].'" value="'.$v['amount'].'" style="width: 70px; display: none;">
												</td>
												<td class="text-center">
													<span id="sp-remarks-'.$v['id'].'">'.$v['remarks'].'</span>
													<input type="text" id="remarks-'.$v['id'].'" value="'.$v['remarks'].'" style="width: 200px; display: none;">
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
									<tfoot>
										
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
												title: 'Data Guest Online Oriskin',
												className: 'btn-danger',
												orientation: 'landscape',
                								pageSize: 'LEGAL',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Data Guest Online Oriskin',
												exportOptions: {
													columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
												},
												footer: true,
												title: 'Data Guest Online Oriskin',
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
		$('#sp-call-'+_id).hide();
		$('#sp-appt-'+_id).hide();
		$('#sp-dateappt-'+_id).hide();
		$('#sp-try-'+_id).hide();
		$('#sp-datetry-'+_id).hide();
		$('#sp-buy-'+_id).hide();
		$('#sp-customerid-'+_id).hide();
		$('#sp-amount-'+_id).hide();
		$('#sp-notjoin-'+_id).hide();
		$('#sp-remarks-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#call-'+_id).val($('#sp-call-'+_id).html());
		$('#appt-'+_id).val($('#sp-appt-'+_id).html());
		$('#dateappt-'+_id).val($('#sp-dateappt-'+_id).html());
		$('#try-'+_id).val($('#sp-try-'+_id).html());
		$('#datetry-'+_id).val($('#sp-datetry-'+_id).html());
		$('#buy-'+_id).val($('#sp-buy-'+_id).html());
		$('#amount-'+_id).val($('#sp-amount-'+_id).html());
		$('#customerid-'+_id).val($('#sp-customerid-'+_id).html());
		$('#notjoin-'+_id).val($('#sp-notjoin-'+_id).html());
		$('#remarks-'+_id).val($('#sp-remarks-'+_id).html());
		$('#call-'+_id).show();
		$('#appt-'+_id).show();
		$('#dateappt-'+_id).show();
		$('#try-'+_id).show();
		$('#datetry-'+_id).show();
		$('#buy-'+_id).show();
		$('#amount-'+_id).show();
		$('#customerid-'+_id).show();
		$('#notjoin-'+_id).show();
		$('#remarks-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _call = $('#call-'+_id).val();
			var _appt = $('#appt-'+_id).val();
			var _dateappt = $('#dateappt-'+_id).val();
			var _try = $('#try-'+_id).val();
			var _datetry = $('#datetry-'+_id).val();
			var _remarks = $('#remarks-'+_id).val();
			var _buy = $('#buy-'+_id).val();
			var _customerid = $('#customerid-'+_id).val();
			var _amount = $('#amount-'+_id).val();
			var _notjoin = $('#notjoin-'+_id).val();
			
			

			$.post(_HOST+'App/updateMsemployee', {id:_id,call:_call,appt:_appt,dateappt:_dateappt,try:_try,datetry:_datetry,remarks:_remarks,buy:_buy,customerid:_customerid,amount:_amount,notjoin:_notjoin}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-call-'+_id).show();
			$('#sp-appt-'+_id).show();
			$('#sp-dateappt-'+_id).show();
			$('#sp-try-'+_id).show();
			$('#sp-datetry-'+_id).show();
			$('#sp-remarks-'+_id).show();
			$('#sp-buy-'+_id).show();
			$('#sp-customerid-'+_id).show();
			$('#sp-amount-'+_id).show();
			$('#sp-notjoin-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#call-'+_id).hide();
			$('#appt-'+_id).hide();
			$('#dateappt-'+_id).hide();
			$('#try-'+_id).hide();
			$('#datetry-'+_id).hide();
			$('#remarks-'+_id).hide();
			$('#buy-'+_id).hide();
			$('#customerid-'+_id).hide();
			$('#amount-'+_id).hide();
			$('#notjoin-'+_id).hide();
			
			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>