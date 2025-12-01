<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Eudora - Report Guest Online Admin</title>

	<style>
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

		.copy-btn-report {
			background-color: #4CAF50;
			/* Warna hijau */
			color: white;
			border: none;
			padding: 4px 9px;
			font-size: 14px;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			/* display: flex;
            align-items: center; */
			gap: 5px;
		}

		.copy-btn-report:hover {
			background-color: #45a049;
			/* Warna hijau lebih gelap */
		}

		.copy-btn-report i {
			font-size: 16px;
		}

		.copy-btn-refferal {
			background-color: #4CAF50;
			/* Warna hijau */
			color: white;
			border: none;
			padding: 4px 9px;
			font-size: 14px;
			border-radius: 5px;
			cursor: pointer;
			transition: background-color 0.3s ease;
			/* display: flex;
            align-items: center; */
			gap: 5px;
		}

		.copy-btn-refferal:hover {
			background-color: #45a049;
			/* Warna hijau lebih gelap */
		}

		.copy-btn-refferal i {
			font-size: 16px;
		}
	</style>
</head>

<body>
	<div>
		<div class="mycontaine">
			<div class=" ">
				<div class="row gx-4">
					<div class="col-md-12 mt-3">
						<div class=" " id="dailySales">
							<div class="card">
								<h3 class="card-header card-header-info" style=" font-weight: bold; color: #666666;">
									LIST LINK REGISTRASI CONSULTANT
								</h3>
								<div class="table-wrapper p-4">
									<div class="table-responsive">
										<table id="tableDailySales" class="table table-striped table-bordered" style="width:100%">
											<thead class="bg-thead">
												<tr>
													<th style="text-align: center;">NO</th>
													 <th style="text-align: center;">EMPID</th>
                                                    <th style="text-align: center;">CODE</th>
													<th style="text-align: center;">EMPLOYEE NAME</th>
													<th style="text-align: center;">LINK REGISTRASI</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no = 1;
												foreach ($listDocter as $row) {
												?>
													<tr role="" style="font-weight: 400;">
														<td style="text-align: center;"><?= $no++ ?></td>
														<td style="text-align: center;"><?= $row['id'] ?></td>
														<td style="text-align: center;"><?= $row['code'] ?></td>
														<td style="text-align: center;"><?= $row['fullname'] ?></td>
														<td style="text-align: center;">
															<button class="copy-btn-refferal" data-text="https://sys.eudoraclinic.com:84/registr/referal-code/<?= $row['id'] ?>">
																<i class="fas fa-copy"></i>
															</button>
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
			// select: true,
			'bAutoWidth': false,
		});


	});

	$('#tableDailySales').removeClass('display').addClass(
		'table table-striped table-hover table-compact');
</script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.querySelectorAll(".copy-btn-refferal").forEach(button => {
			button.addEventListener("click", function() {
				let textToCopy = this.getAttribute("data-text"); // Ambil teks dari atribut data-text

				navigator.clipboard.writeText(textToCopy).then(() => {
					alert("Teks berhasil disalin!");
				}).catch(err => {
					console.error("Gagal menyalin teks", err);
				});
			});
		});
	});
</script>

</html>