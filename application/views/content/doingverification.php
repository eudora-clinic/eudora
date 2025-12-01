<?php
	# Penambahan select option job dan location
	# load database oriskin (lihat di config/database.php)
	$db_oriskin = $this->load->database('oriskin', true);
	$job_list = $db_oriskin->query("select id, name from msguestonlitype order by id")->result_array();
	$datestart = (isset($_GET['datestart']) ? $this->input->get('datestart') : date('Y-m-d'));
	$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($datestart . " +1 day")));
?>

<div class="card shadow mb-4" style="margin-left:20px; margin-right:20px;">
                <div class="card-body">
                    <h4 class="card-title mb-3">Doing Verification</h4>


            <?php
	# display error
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);
	# unlimited time
	ini_set('max_execution_time', -1);
	ini_set('memory_limit', '-1');
	 // Setting memory limit sql server to 512M
	ini_set('sqlsrv.ClientBufferMaxKBSize','524288');
	ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288');
				# dibuat langsung di view untuk memudahkan
				# tidak dibuat di model
				$no_invoice = $this->session->userdata('locationid');
				$userid = $this->session->userdata('userid');
				$date = $datestart;
				$dateend = (isset($_GET['dateend']) ? $this->input->get('dateend') : date("Y-m-d", strtotime($date . " +1 day")));



				# dipindahkan ke atas biar terbaca saat pertama load
				//$datestart = $this->input->get('datestart');
				//$dateend = $this->input->get('dateend');
				# load database oriskin (lihat di config/database.php)
				$db_oriskin = $this->load->database('oriskin', true);
				# query
				$query = $db_oriskin->query("SELECT
				b.name AS CLINIC,
				CONVERT(DATE, a.treatmentdate) AS TREATMENTDATE,
				a.id AS DOINGID,
				c.id AS CUSTOMERID,
				c.firstname + (CASE WHEN c.lastname IS NULL THEN '' ELSE ' ' + c.lastname END) AS CUSTOMERNAME,
				c.cellphonenumber AS CELLPHONENUMBER,
				d.name AS TREATMENTNAME,
				a.qty AS QTY,
				f.name AS DOINGBY,
				a.starttreatment AS STARTTREATMENT,
				a.endtreatment AS ENDTREATMENT,
				a.duration AS DURATION,
				a.vstatus AS VSTATUS,
				COALESCE(e.status, 0) AS STATUS,
				a.remarks AS REMARKS
			FROM trdoingtreatment a LEFT JOIN slconfirmdoing e ON a.id=e.trdoingtreatment_id
				INNER JOIN mslocation b ON a.locationid = b.id
				INNER JOIN mscustomer c ON a.customerid = c.id
				INNER JOIN mstreatment d ON a.producttreatmentid = d.id
				INNER JOIN msemployee f ON a.treatmentdoingbyid = f.id
				
			WHERE DATEDIFF(DAY,CONVERT (VARCHAR(10),a.updatedate,120),CONVERT (VARCHAR(10),GETDATE() ,120)) > 0 AND
			CONVERT(VARCHAR(10), a.treatmentdate, 120)='".$dateend."' AND a.locationid = ".$no_invoice." AND a.customerid not in (159711)
			AND isnull(e.status,0) = 0 AND a.status NOT IN (3,17) AND a.vstatus = 0
			ORDER BY c.id");
				$header = $query->result_array();
			?>


			<form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
							<div class="form-row mt-9">
								<div class="form-group col-md-3">
									<div class="form-group bmd-form-group">
										<label >Date Start</label>
										<input type="date" id="datestart" name="datestart" class="form-control" required="true" aria-required="true" placeholder="" value="<?= $date ?>">
									</div>
								</div>
							</div>
							<button type="submit" name="submit" class="btn-sm btn-outline-primary" style="width: 150px; height:100%;" value="true">Cari</button>
					</form>

            <div class="tab-content">
					<div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-bordered table-responsive-xl" id="example" width="200%" cellspacing="0">
                                    <thead class="thead-dark">
                    <tr>
                        <th width="60px" class="text-center">No</th>
						<th width="150px" class="text-center">CLINIC</th>
						<th width="150px" class="text-center">DATE</th>
						<th width="150px" class="first-col text-center sticky-col">DOINGID</th>
						<th width="150px" class="text-center">CUSTOMER</th>
						<th width="150px" class="text-center">CELLPHONE</th>
						<th width="150px" class="text-center">WHATSAPP</th>
						<th width="90px" class="text-center">TREATMENT</th>
						<th width="90px" class="text-center">QTY</th>
						<th width="260px" class="text-center">DOINGBY</th>
						<th width="250px" class="text-center">START</th>
						<th width="90px" class="text-center">END</th>
						<th width="90px" class="text-center">DURATION</th>
						<th width="90px" class="text-center">STATUS</th>
						<th width="90px" class="text-center">VSTATUS</th>
						<th width="250px" class="text-center">REMARKS</th>
						<th width="90px" class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($header)) {
						$no = 0;
                        foreach ($header as $v)
                            {
															$cellphonenumber = preg_replace('/\D/', '',  $v['CELLPHONENUMBER']);
															$country_code = '62';
															$new_number = substr_replace($cellphonenumber, '+'.$country_code, 0, ($cellphonenumber[0] == '0'));
                            echo
                                '<tr>
                                <td class="text-center">
									<span id="no-'.$v['DOINGID'].'">'.++$no.'</span>
								</td>
                                <td class="text-center">'.$v['CLINIC'].'</td>

                                <td class="text-center">
                                    <span id="sp-treatmentdate-'.$v['DOINGID'].'">'.$v['TREATMENTDATE'].'</span>
                                    <input type="date" id="edit-treatmentdate-'.$v['DOINGID'].'" value="'.$v['TREATMENTDATE'].'" style="width: 100px; display: none;">
                                </td>

                                <td class="text-center">'.$v['DOINGID'].'</td>
                                <td class="text-center">'.$v['CUSTOMERNAME'].'</td>
                                <td class="text-center">'.$v['CELLPHONENUMBER'].'</td>
																<td><a href="https://wa.me/'.$new_number.'">WA Link</a></td>
                                <td class="text-center">'.$v['TREATMENTNAME'].'</td>
                                <td class="text-center">'.$v['QTY'].'</td>
                                <td class="text-center">'.$v['DOINGBY'].'</td>

								<td class="text-center">
    							<span id="sp-starttreatment-'.$v['DOINGID'].'">'.$v['STARTTREATMENT'].'</span>
    							<input type="time" id="edit-starttreatment-'.$v['DOINGID'].'" value="'.$v['STARTTREATMENT'].'" style="display: none;">
								</td>

                                <td class="text-center">
                                    <span id="sp-endtreatment-'.$v['DOINGID'].'">'.$v['ENDTREATMENT'].'</span>
                                    <input type="number" id="edit-endtreatment-'.$v['DOINGID'].'" value="'.$v['ENDTREATMENT'].'" style="display: none;">
                                </td>

                                <td class="text-center">
                                    <span id="sp-duration-'.$v['DOINGID'].'">'.$v['DURATION'].'</span>
                                    <input type="number" id="edit-duration-'.$v['DOINGID'].'" value="'.$v['DURATION'].'" style="display: none;">
                                </td>

                                <td class="text-center">'.$v['STATUS'].'</td>
                                <td class="text-center">'.$v['VSTATUS'].'</td>

                                <td class="text-center">
                                    <span id="sp-remarks-'.$v['DOINGID'].'">'.$v['REMARKS'].'</span>
                                    <input type="text" id="edit-remarks-'.$v['DOINGID'].'" value="'.$v['REMARKS'].'" style="display: none;">
                                </td>

								<td class="text-center">
								<div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" onclick="updateStatus(&apos;'.$v['DOINGID'].'&apos;, 2);">CONFIRM</button>
									<button class="btn btn-sm btn-outline-info" onclick="updateStatus(&apos;'.$v['DOINGID'].'&apos;, 4);">RESCHEDULE</button>
									<button class="btn btn-sm btn-outline-danger" onclick="updateStatus(&apos;'.$v['DOINGID'].'&apos;, 3);">CANCEL</button>
									<button class="btn btn-sm btn-info" id="btn-edit-header-' . $v['DOINGID'] . '" onclick="editRow(' . $v['DOINGID'] . ');">Edit</button>
								<button class="btn btn-sm btn-info" id="btn-save-header-' . $v['DOINGID'] . '" style="display: none;" onclick="saveRow(' . $v['DOINGID'] . ');">Save</button>
								</div>

                                </td>
                                </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
			</div>
                        </div>
                    </div>
				</div> <!-- end card-body-->
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
								</script>


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: "r<'row align-items-center'<'col-md-3'l><'col-md-7'f><'col-md-2 text-right'B>><'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>",
        buttons: [
            {
				extend: 'pdfHtml5',
				title: 'Data Doing Verification',
				className: 'btn-danger',
				orientation: 'landscape',
                pageSize: 'LEGAL',
				exportOptions: {
				columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14]
				},

			}, 'excel'
        ]
    } );
} );
</script>

<script>
function editRow(doingId) {
    $('#sp-starttreatment-' + doingId).hide();
    $('#sp-treatmentdate-' + doingId).hide();
    $('#sp-duration-' + doingId).hide();
    $('#sp-remarks-' + doingId).hide();
    $('#btn-edit-header-' + doingId).hide();

    $('#edit-starttreatment-' + doingId).show();
    $('#edit-treatmentdate-' + doingId).show();
    $('#edit-duration-' + doingId).show();
    $('#edit-remarks-' + doingId).show();
    $('#btn-save-header-' + doingId).show();
}


function saveRow(doingId) {
    const startTreatment = $('#edit-starttreatment-' + doingId).val();
    const treatmentDate = $('#edit-treatmentdate-' + doingId).val();
    const duration = parseFloat($('#edit-duration-' + doingId).val());
    const remarks = $('#edit-remarks-' + doingId).val();
    const endTreatment = $('#edit-endtreatment-' + doingId).val();

    if (startTreatment && !isNaN(duration)) {
        // Hitung endTreatment berdasarkan startTreatment dan duration
        const startTime = new Date('2023-10-26 ' + startTreatment);
        const endTime = new Date(startTime.getTime() + duration * 60000);
        const endTreatment = endTime.toTimeString().slice(0, 5);

        // Perbarui data pada tabel trdoingtreatment
        $.ajax({
            type: 'POST',
            url: "<?= base_url('save-doing-treatment') ?>", // Gantilah URL ke yang sesuai
            data: {
                doingId: doingId,
				treatmentDate: treatmentDate,
                startTreatment: startTreatment,
                duration: duration,
                endTreatment: endTreatment, // Sertakan endTreatment yang sudah dihitung
                remarks: remarks
            },
            success: function(response) {
                if (response === 'Success') {
                    // Jika pembaruan berhasil, perbarui tampilan di halaman
					$('#sp-treatmentdate-' + doingId).text(treatmentDate);
                    $('#sp-starttreatment-' + doingId).text(startTreatment);
                    $('#sp-endtreatment-' + doingId).text(endTreatment); // Perbarui endTreatment
                    $('#sp-duration-' + doingId).text(duration);
                    $('#sp-remarks-' + doingId).text(remarks);

                    $('#sp-treatmentdate-' + doingId).show();
                    $('#sp-starttreatment-' + doingId).show();
                    $('#sp-endtreatment-' + doingId).show();
                    $('#sp-duration-' + doingId).show();
                    $('#sp-remarks-' + doingId).show();
                    $('#btn-edit-header-' + doingId).show();

                    $('#edit-treatmentdate-' + doingId).hide();
                    $('#edit-starttreatment-' + doingId).hide();
                    $('#edit-duration-' + doingId).hide();
                    $('#edit-remarks-' + doingId).hide();
                    $('#btn-save-header-' + doingId).hide();
                } else {
                    // Handle error jika pembaruan gagal
                    alert('Gagal menyimpan data. Silakan coba lagi.');
                }
            }
        });
    } else {
        // Handle error jika input tidak valid
        alert('Input tidak valid. Pastikan Anda telah mengisi kolom "starttreatment" dan "duration" dengan benar.');
    }
}
</script>

<script>
function updateStatus(doingId, newStatus) {
    var _confirm = confirm('Anda Yakin?');

    if (_confirm) {
        // Mengirim data vstatus sebagai parameter POST
        $.post(_HOST + 'App/updateStatusDoing', { id: doingId, vstatus: newStatus}, function(result) {
            alert(result);
            location.reload(); // Reload halaman setelah pembaruan
        });
    }
}

</script>
