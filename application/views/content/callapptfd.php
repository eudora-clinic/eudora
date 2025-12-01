<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Eudora - List Call Member Active</title>

	<style>
		.filter-container {
			display: flex;
			gap: 15px;
			align-items: center;
			padding: 10px 0;
		}

		.filter-container select {
			width: 200px;
			padding: 8px;
			border: 1px solid #ccc;
			border-radius: 5px;
			font-size: 14px;
			background-color: #fff;
			cursor: pointer;
		}

		/* Agar select dropdown memiliki padding lebih baik */
		.filter-container select:focus {
			outline: none;
			border-color: #007bff;
		}

		.btn-primary {
			background-color: #e0bfb2 !important;
			color: #666666 !important;
			border: none;
			transition: background-color 0.3s ease;
		}

		.nav-tabs {
			border-bottom: 2px solid #e0bfb2;
		}

		.nav-tabs .nav-item {
			margin-right: 5px;
		}

		.nav-tabs .nav-link {
			background-color: #f5e5de;
			/* Warna latar belakang tab */
			border: 1px solid #e0bfb2;
			color: #8b5e4d;
			/* Warna teks */
			border-radius: 8px 8px 0 0;
			/* Membuat sudut atas membulat */
			padding: 10px 15px;
			font-weight: bold;
			transition: all 0.3s ease-in-out;
		}

		.nav-tabs .nav-link:hover {
			background-color: #e0bfb2;
			color: white;
		}

		.nav-tabs .nav-link.active {
			background-color: #e0bfb2 !important;
			color: white;
			border-bottom: 2px solid #d1a89b;
		}

		.card {
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			margin-top: 15px !important;
			margin-bottom: 10px !important;
		}

		.tab-content {
			padding: 0 !important;
		}

		.bg-thead {
			background-color: #f5e0d8 !important;
			color: #666666 !important;
			text-transform: uppercase;
			font-size: 12px;
			font-weight: 100 !important;
		}

		.mycontaine {
			font-size: 12px !important;
		}

		/* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
		.mycontaine * {
			font-size: inherit !important;
		}

		.card-header-info {
			background: #f5e0d8;
		}
	</style>
</head>

<body>
	<div>
		<div class="mycontaine">
			<div>
				<ul class="nav nav-tabs active mt-3">

					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#memberActive">MEMBER ACTIVE</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#lastDoing3Month">MEMBER LAST DOING OVER 3 MONTH</a>
					</li>
				</ul>
			</div>
			<div class="tab-content">
				<div class="row gx-4">
					<div class="col-md-12 mt-3">
						<div class="panel-body tab-pane show active" id="memberActive">
							<div class="card">
								<h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666666;">
									LIST CALL MEMBER ACTIVE
								</h3>
								<div class="table-wrapper p-4">
									<div class="table-responsive">
										<table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
											<thead class="bg-thead">
												<tr>
													<th style="text-align: center;">NO</th>
													<th style="text-align: center;">CUSTOMERID</th>
													<th style="text-align: center;">CUSTOMERNAME</th>
													<th style="text-align: center;">CELLPHONENUMBER</th>
													<th style="text-align: center;">WA</th>
													<th style="text-align: center;">LAST DOING</th>
													<th style="text-align: center;">LAST TREATMENT</th>
													<th style="text-align: center;">APPT</th>
													<th style="text-align: center;">ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($listCallAppt as $row) {

													if (empty($row['LASTDOING'])) continue;

													$lastDoingDate = new DateTime($row['LASTDOING']);
													$threeMonthsAgo = new DateTime();
													$threeMonthsAgo->modify('-3 months');

													if ($lastDoingDate < $threeMonthsAgo) continue;

													$cellphonenumber = preg_replace('/\D/', '', $row['CELLPHONENUMBER']);
													$country_code = '62';
													$new_number = substr_replace($cellphonenumber, '+' . $country_code, 0, ($cellphonenumber[0] == '0'));
												?>
													<tr role="" style="font-weight: 400;">
														<td style="text-align: center;"><?= $no++ ?></td>
														<td style="text-align: center;"><?= $row['CUSTOMERID'] ?></td>
														<td style="text-align: center;"><?= $row['LCNAME'] ?></td>
														<td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?></td>
														<td class="text-center"><a href="https://wa.me/<?= $new_number ?>"><i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i></a></td>
														<td style="text-align: center;"><?= $row['LASTDOING'] ?></td>
														<td style="text-align: center;"><?= $row['LASTTREATMENT'] ?></td>
														<td style="text-align: center;"><?= $row['APPTDATE'] ?></td>
														<td style="text-align: center;">
															<a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/customer/erm_ref/<?= $row['CUSTOMERID'] ?>" role="button">Detail</a>
															<a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/bookAppointment" role="button" target="_blank">Booking</a>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>

						<div class="panel-body tab-pane" id="lastDoing3Month">
							<div class="card">
								<h3 class="card-header card-header-info d-flex justify-content-between align-items-center" style="font-weight: bold; color: #666666;">
									CUSTOMER LAST DOING OVER 3 MONTH
								</h3>
								<div class="table-wrapper p-4">
									<div class="table-responsive">
										<table id="customerLastDoing" class="table table-striped table-bordered" style="width:100%">
											<thead class="bg-thead">
												<tr>
													<th style="text-align: center;">NO</th>
													<th style="text-align: center;">CUSTOMERID</th>
													<th style="text-align: center;">CUSTOMERNAME</th>
													<th style="text-align: center;">CELLPHONENUMBER</th>
													<th style="text-align: center;">WA</th>
													<th style="text-align: center;">LAST DOING</th>
													<th style="text-align: center;">LAST TREATMENT</th>
													<th style="text-align: center;">APPT</th>
													<th style="text-align: center;">ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($listCallAppt as $row) {
													if (empty($row['LASTDOING'])) continue;

													$lastDoingDate = new DateTime($row['LASTDOING']);
													$threeMonthsAgo = new DateTime();
													$threeMonthsAgo->modify('-3 months');

													if ($lastDoingDate > $threeMonthsAgo) continue;

													$cellphonenumber = preg_replace('/\D/', '', $row['CELLPHONENUMBER']);
													$country_code = '62';
													$new_number = substr_replace($cellphonenumber, '+' . $country_code, 0, ($cellphonenumber[0] == '0'));
												?>
													<tr role="" style="font-weight: 400;">
														<td style="text-align: center;"><?= $no++ ?></td>
														<td style="text-align: center;"><?= $row['CUSTOMERID'] ?></td>
														<td style="text-align: center;"><?= $row['LCNAME'] ?></td>
														<td style="text-align: center;"><?= $row['CELLPHONENUMBER'] ?></td>
														<td class="text-center"><a href="https://wa.me/<?= $new_number ?>"><i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i></a></td>
														<td style="text-align: center;"><?= $row['LASTDOING'] ?></td>
														<td style="text-align: center;"><?= $row['LASTTREATMENT'] ?></td>
														<td style="text-align: center;"><?= $row['APPTDATE'] ?></td>
														<td style="text-align: center;">
															<a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/customer/erm_ref/<?= $row['CUSTOMERID'] ?>" role="button">Detail</a>
															<a class="btn btn-primary btn-sm" href="https://sys.eudoraclinic.com:84/app/bookAppointment" role="button" target="_blank">Booking</a>
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
		</div>
	</div>
</body>
<script>
	$(document).ready(function() {
		$('#tableDailySales').DataTable({
			"pageLength": 100,
			"lengthMenu": [5, 10, 15, 20, 25, 100],
			select: true,
			'bAutoWidth': false,
			"drawCallback": function(settings) {
				var api = this.api();
				var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
				api.column(0, {
					page: 'current'
				}).nodes().each(function(cell, i) {
					cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
				});
			},
		});

		$('#customerLastDoing').DataTable({
			"pageLength": 100,
			"lengthMenu": [5, 10, 15, 20, 25, 100],
			select: true,
			'bAutoWidth': false,
			"drawCallback": function(settings) {
				var api = this.api();
				var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
				api.column(0, {
					page: 'current'
				}).nodes().each(function(cell, i) {
					cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
				});
			},
		});
	});

	$('#tableDailySales').removeClass('display').addClass(
		'table table-striped table-hover table-compact');

	$('#customerLastDoing').removeClass('display').addClass(
		'table table-striped table-hover table-compact');
</script>

</html>