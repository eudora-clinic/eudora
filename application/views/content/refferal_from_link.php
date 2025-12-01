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
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m'));
/* 	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date('Y-m')); */
?>

<div class="container-fluid">
  	<div class="row">
    	<div class="col-md-12">
      		<div class="card">
        		<div class="card-header card-header-danger">
            		<h4 class="card-title">Data Refferal From Link</h4>
        		</div>
				<div class="card-body">

					<div class="toolbar">
					</div>
					<div>
						<?php
							# dibuat langsung di view untuk memudahkan
							# tidak dibuat di model

							$clinicid = $this->session->userdata('locationid');
							# dipindahkan ke atas biar terbaca saat pertama load
							//$datestart = $this->input->get('datestart');
							//$dateend = $this->input->get('dateend');

							# load database oriskin (lihat di config/database.php)
							$db_oriskin = $this->load->database('oriskin', true);

							# query
						$query = $db_oriskin->query(" select a.visitdate, a.firstname + (CASE WHEN a.lastname IS NULL THEN '' ELSE ' ' + a.lastname END) AS guestName,a.cellphonenumber,
                        b.firstname + (CASE WHEN b.lastname IS NULL THEN '' ELSE ' ' + b.lastname END) AS Lcname, b.id as customerid
                        from slguestlog a inner join mscustomer b on a.refferalid = b.id where a.locationid='".$clinicid."'");
							$header = $query->result_array();
							//$detail = $db_oriskin->query("select * fssrom slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");
						?>
						<div class="table-wrapper">
						<table id="example" class="table table-bordered" style="width:100%">
									<thead class="thead-danger">
										<tr role="">
                                        <th width="30px" class="text-center">No</th>
                                        <th width="100px" class="text-center">Sign Date</th>
					<th width="170px" class="text-center">Guest Name</th>
					<th width="150px" class="text-center">Cellphone</th>
					<th width="150px" class="text-center">Refferal ID</th>
					<th width="170px" class="text-center">Refferal Name</th>
                    
                                        <th width="300px" class="text-center">Followup Link Refferal</th>
										</tr>
									</thead>
									<tbody>
									    <?php
									    if (isset($header)) {
									        $no = 0;
									        foreach ($header as $v) {
									            $datetime = $v['visitdate'];
									            $date = substr($datetime, 0, 10);
									            $dateString = explode('-', $date);
									            $datevisit = $dateString[2] . '-' . $dateString[1] . '-' . $dateString[0];
									            $note = $db_oriskin->query("SELECT ISNULL(note, '') AS note FROM historyfollowuprefferalfromlink WHERE customerid = '".$v['customerid']."'")->row()->note ?? '';
									            echo '<tr>
									                <td class="text-center">' . ++$no . '</td>
									                <td class="text-left">' . $datevisit . '</td>
									                <td class="text-left">' . $v['guestName'] . '</td>
									                <td class="text-center">' . $v['cellphonenumber'] . '</td>
											<td class="text-center">' . $v['customerid'] . '</td>
									                <td class="text-left">' . $v['Lcname'] . '</td>
									                <td class="text-center">
									                    <span data-id="' . $v['customerid'] . '" class="spn-note" style="display: block;">' . $note . '</span>
									                    <button data-id="' . $v['customerid'] . '" class="btn btn-sm btn-danger btn-edit px-0 py-0" title="edit" style="display: block;"><i class="fa fa-edit"></i></button>
									                    <textarea data-id="' . $v['customerid'] . '" class="txt-note" style="display: none;width:300px">' . $note . '</textarea>
									                    <button data-id="' . $v['customerid'] . '" class="btn btn-sm btn-danger btn-save px-0 py-0" title="save" style="display: none;"><i class="fa fa-save"></i></button>
									                </td>
									            </tr>';
									        }
									    }
									    ?>
									</tbody>

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
								var datestart = '<?= $datestart ?>';
								var datestart_split = datestart.split('-');
								var datestart_indo = datestart_split[2]+'-'+datestart_split[1]+'-'+datestart_split[0];

									$('#example').DataTable({
                                        paging: false,
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
                                        var pageTotals = [];

                                        // Perulangan untuk kolom 1 hingga 4
                                        for (var i = 1; i <= 5; i++) {
                                        var sumColFiltered = api
                                            .column(i, { page: 'current' })
                                            .data()
                                            .reduce(function (a, b) {
                                                return intVal(a) + intVal(b);
                                            }, 0);
                                        pageTotals.push(sumColFiltered);
                                        }

                                        // Total filtered rows on the selected column (code part added)
                                        const sumCol11Filtered = [];
                                        for (let i = 1; i <= 5; i++) {
                                            sumCol11Filtered[i] = display.map(el => intVal(data[el][i])).reduce((a, b) => a + b, 0);
                                        }

									},
									dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
									buttons: [
										{
											extend: 'pdfHtml5',
											title: 'Report Data Refferal From Link',
											className: 'btn-danger',
											orientation: 'landscape',
											pageSize: 'A3',
											exportOptions: {
												columns: [0, 1, 2, 3, 4, 5]
											},
											footer: true
										},
										{
											extend: 'print',
											title: 'Report Data Refferal From Link',
											exportOptions: {
												columns: [0, 1, 2, 3, 4, 5]
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
											title: 'Report Data Refferal From Link',
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
//_mod dideklarasikan di initapp.js
_mod = '<?=$mod?>';

function editHeader(_id, e) {
	e.preventDefault();
	$('#sp-call-'+_id).hide();
	$('#sp-appt-'+_id).hide();
	$('#sp-show-'+_id).hide();
	$('#sp-ro-'+_id).hide();
	$('#sp-remarks-'+_id).hide();
	$('#btn-edit-header-'+_id).hide();
	$('#call-'+_id).val($('#sp-call-'+_id).html());
	$('#appt-'+_id).val($('#sp-appt-'+_id).html());
	$('#show-'+_id).val($('#sp-show-'+_id).html());
	$('#ro-'+_id).val($('#sp-ro-'+_id).html());
	$('#remarks-'+_id).val($('#sp-remarks-'+_id).html());
	$('#call-'+_id).show();
	$('#appt-'+_id).show();
	$('#show-'+_id).show();
	$('#ro-'+_id).show();
	$('#remarks-'+_id).show();
	$('#btn-save-header-'+_id).show();
}

function saveHeader(_id, e) {
	e.preventDefault();

	var _confirm = confirm('Anda Yakin?');

	if (_confirm) {
		var _call = $('#call-'+_id).val();
		var _appt = $('#appt-'+_id).val();
		var _show = $('#show-'+_id).val();
		var _ro = $('#ro-'+_id).val();
		var _remarks = $('#remarks-'+_id).val();

		$.post(_HOST+'App/updateDetailOrder', {id:_id,call:_call,appt:_appt,show:_show,ro:_ro,remarks:_remarks}, function(result) {
			alert(result);
			location.reload();
		});
	} else {
		$('#sp-call-'+_id).show();
		$('#sp-appt-'+_id).show();
		$('#sp-show-'+_id).show();
		$('#sp-ro-'+_id).show();
		$('#sp-remarks-'+_id).show();
		$('#btn-edit-header-'+_id).show();

		$('#call-'+_id).hide();
		$('#appt-'+_id).hide();
		$('#show-'+_id).hide();
		$('#ro-'+_id).hide();
		$('#remarks-'+_id).hide();
		$('#btn-save-header-'+_id).hide();
	}
}
</script>
<script>
function changeSPJob(_value, e) {
	$('#sp-jobname').html($('#list-job option[value="' + _value + '"]').text());
}

function changeSPLocation(_value, e) {
	$('#sp-locationname').html($('#list-location option[value="' + _value + '"]').text());
}
</script>

<script>
	$(document).ready(function () {
		$(".btn-edit").each(function(index) {
			$(this).on("click", function(){
				let id = $(this).data('id');
				//alert('edit '+id);
				$(this).hide();
				$(this).parent().find('.spn-note').hide();
				$(this).parent().find('.txt-note').show();
				$(this).parent().find('.btn-save').show();
			});
		});

		$(".btn-save").each(function(index) {
			$(this).on("click", function(){
				let id = $(this).data('id');
				//alert('save '+id);
				let note = $(this).parent().find('.txt-note').val();

				$.post("<?= base_url('save-note-followup-refferal-from-link') ?>", {customerid: id, note: note}, function(res) {
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
