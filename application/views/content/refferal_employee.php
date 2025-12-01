
<style>
	.hidden-input {
      position: absolute;
      top: -9999px;
      left: -9999px;
	  border: none;
      padding: 0;
      background: transparent;
    }

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
		
      		<div class="card">
        		<div class="card-header card-header-primary">
            		<h4 class="card-title">Data Link Employee</h4>
        		</div>
				<div class="card-body">
						<?php
							# dibuat langsung di view untuk memudahkan 
							# tidak dibuat di model
							
								$name = $this->session->userdata('locationid');
								# load database oriskin (lihat di config/database.php)msguestonline
								//$db_oriskin = $this->load->database('oriskin', true); # sudah diload di atas
								# query
								$query = $db_oriskin->query("select a.* from msemployee a inner join msemployeedetail b on a.id = b.employeeid where b.locationid='".$name."' and a.isactive='true'");
								if ($query->num_rows() <= 0) {
									echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>Clinic ID <strong>'.$name.'</strong> tidak ada data</span>
											</div>';
								} else { 
									$header = $query->result_array();
									//$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
								} 
							
						?>
						<div class="table-responsive">
								<!--<table id="dt-realisasi" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid">-->
								<table id="table1" class="table text-center table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
											<th style="width: 5%;">No</th>
											<th>ID</th>
											<th>Name</th>
											<th>Aksi</th>
										</tr>  
									</thead>
									
									<tbody>
										<?php $no=1; foreach($header as $row){ ?>
											<tr role="">
												<td><?= $no++ ?></td>
												<td><?= $row['id'] ?></td>
												<td><?= $row['name'] ?></td>
												<td>
													<!-- <input type="text" class="hidden-input" id="copyLinkRef<?= $row['id'] ?>" value="http://app.oriskin.co.id:84/registration/add-guest-ref/<?= $row['id'] ?>"> -->
													<input type="text" class="hidden-input" id="copyLinkRef<?= $row['id'] ?>" value="https://app.oriskin.co.id:84/registr/referal-code/<?= $row['id'] ?>">
													<button class="btn btn-primary" onclick="copyToClipboard<?= $row['id'] ?>()">Get Link Employee</button>
												</td>
											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										
										
									</tfoot>
								</table>
								<script>
                                    $(document).ready(function(){
                                        $('#table1').DataTable();
                                    });

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
													columns: [0, 1, 2, 3, 4]
												},
												footer: true 
											},
											{
												extend: 'print',
												title: 'Data Guest Online Oriskin',
												exportOptions: {
													columns: [0, 1, 2, 3, 4]
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
		$('#sp-dateappt-'+_id).hide();
		$('#sp-donedeal-'+_id).hide();
		$('#sp-show-'+_id).hide();
		$('#sp-newjoin-'+_id).hide();
		$('#sp-amount-'+_id).hide();
		$('#sp-nojoin-'+_id).hide();
		$('#sp-remarks-'+_id).hide();
		$('#btn-edit-header-'+_id).hide();
		$('#dateappt-'+_id).val($('#sp-dateappt-'+_id).html());
		$('#donedeal-'+_id).val($('#sp-donedeal-'+_id).html());
		$('#show-'+_id).val($('#sp-show-'+_id).html());
		$('#newjoin-'+_id).val($('#sp-newjoin-'+_id).html());
		$('#amount-'+_id).val($('#sp-amount-'+_id).html());
		$('#nojoin-'+_id).val($('#sp-nojoin-'+_id).html());
		$('#remarks-'+_id).val($('#sp-remarks-'+_id).html());
		$('#dateappt-'+_id).show();
		$('#donedeal-'+_id).show();
		$('#show-'+_id).show();
		$('#newjoin-'+_id).show();
		$('#amount-'+_id).show();
		$('#nojoin-'+_id).show();
		$('#remarks-'+_id).show();
		$('#btn-save-header-'+_id).show();
	}									

	function saveHeader(_id, e) {
		e.preventDefault();

		var _confirm = confirm('Anda Yakin?');
		
		if (_confirm) {
			var _dateappt = $('#dateappt-'+_id).val();
			var _donedeal = $('#donedeal-'+_id).val();
			var _show = $('#show-'+_id).val();
			var _newjoin = $('#newjoin-'+_id).val();
			var _amount = $('#amount-'+_id).val();
			var _nojoin = $('#nojoin-'+_id).val();
			var _remarks = $('#remarks-'+_id).val();
			
			
			

			$.post(_HOST+'App/updateRefferal', {id:_id,dateappt:_dateappt,donedeal:_donedeal,show:_show,newjoin:_newjoin,amount:_amount,nojoin:_nojoin,remarks:_remarks}, function(result) {
				alert(result);
				location.reload();
			});
		} else {
			$('#sp-dateappt-'+_id).show();
			$('#sp-donedeal-'+_id).show();
			$('#sp-show-'+_id).show();
			$('#sp-newjoin-'+_id).show();
			$('#sp-amount-'+_id).show();
			$('#sp-nojoin-'+_id).show();
			$('#sp-remarks-'+_id).show();
			$('#btn-edit-header-'+_id).show();
			
			$('#dateappt-'+_id).hide();
			$('#donedeal-'+_id).hide();
			$('#show-'+_id).hide();
			$('#newjoin-'+_id).hide();
			$('#amount-'+_id).hide();
			$('#nojoin-'+_id).hide();
			$('#remarks-'+_id).hide();
			
			$('#btn-save-header-'+_id).hide();
		}
	}	


</script>

<script>
	function showNotification(from, align){
		$.notify({
			icon: "add_alert",
			message: "link copied"

		},{
			type: 'success',
			timer: 4000,
			placement: {
				from: from,
				align: align
			}
		});
	}

	<?php foreach($header as $row){ ?>
            function copyToClipboard<?= $row['id'] ?>() {
                const copyLinkRef<?= $row['id'] ?> = document.getElementById('copyLinkRef<?= $row['id'] ?>');

                // Pilih teks di dalam input
                copyLinkRef<?= $row['id'] ?>.select();

                try {
                    // Salin teks ke clipboard
                    const successful = document.execCommand('copy');
                    const message = successful ? 'Berhasil disalin ke clipboard!' : 'Gagal menyalin teks.';
                    // alert(message);
                    showNotification();
                } catch (err) {
                    console.error('Gagal menyalin teks: ', err);
                }
            }
        <?php } ?>
</script>