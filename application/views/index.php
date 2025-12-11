<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Operational Activity Eudora</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
		name='viewport' />
	<!-- Fonts and icons -->
	<link rel="stylesheet" type="text/css"
		href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
		integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- CSS Files -->
	<link href="<?= base_url() ?>assets/css/material-dashboard.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/datatables.min.css"
		rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/timepicker.min.js"></script>
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" />
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/select2-bootstrap.css">
	<!-- Toastr CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- scrip toast -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
	<style>
		/* Untuk menyembunyikan scrollbar browser */
		/* ::-webkit-scrollbar {
			width: 0px;
			background: transparent;
		} */

		/* Header dan judul pada modal */
		.modal-header,
		.modal-header h4 {
			background: #884f47;
			color: white !important;
			text-align: center;
		}

		/* Padding untuk header modal */
		.modal-dialog .modal-header {
			padding: 1rem;
		}

		/* Tombol close pada header modal */
		.modal-header .close {
			color: white !important;
		}

		/* Footer modal */
		.modal-footer {
			background-color: #f9f9f9;
		}

		/* Status loading */
		#loading-status {
			position: fixed;
			top: 40%;
			right: 40%;
			background-color: #FFF;
			border: 3px solid #000;
			padding: 5px 7px;
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			z-index: 10000000 !important;
			display: none;
		}

		/* Kolom rata kanan */
		.rata-kanan,
		table td.rata-kanan {
			text-align: right;
		}

		/* Kolom default */
		.kolom-default,
		table td.kolom-default {
			background-color: #999;
		}

		/* Kolom biru */
		.kolom-biru,
		table td.kolom-biru {
			background-color: #884f47;
		}

		/* Navbar Dropdown */
		.navbar-nav .dropdown-menu {
			background-color: #faf2ef;
			border: 1px solid #ddd;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}

		.navbar-nav .dropdown-item {
			color: #333;
			padding: 10px 20px;
		}

		.navbar-nav .dropdown-item:hover {
			background-color: #8c5e4e;
			color: white;
		}

		.navbar-nav .nav-link {
			color: #333;
			font-weight: bold;
			margin: 0 3px;
		}

		.navbar-nav .nav-link:hover {
			color: #8c5e4e;
		}

		/* Warna aktif untuk menu */
		.sidebar[data-color="gold"] li.active>a {
			background-color: #8c5e4e;
			box-shadow: 0 4px 20px 0 rgba(0, 0, 0, .14), 0 7px 10px -5px rgba(212, 175, 55, .4);
		}

		/* Hanya tampilkan elemen dengan kelas mobile-only pada layar dengan lebar maksimum 991px (mobile) */
		@media (min-width: 992px) {
			.mobile-only {
				display: none !important;
			}
		}

		.form-control {
			border-radius: 8px;
			padding: 8px;
			font-size: 13px;
		}


		.btn-primary {
			background-color: #e0bfb2 !important;
			color: #666666 !important;
			border: none;
			transition: background-color 0.3s ease;
		}

		.mycontaine {
			font-size: 12px !important;
		}

		.mycontaine * {
			font-size: inherit !important;
		}

		.card-header-info {
			background: #f5e0d8;
		}

		.bg-thead {
			background-color: #f5e0d8 !important;
			color: #666666 !important;
			text-transform: uppercase;
			font-size: 12px !important;
			font-weight: 100 !important;
		}

		#notifBadge {
			animation: blink 1s infinite alternate;
			font-size: 14px;
			padding: 6px 8px;
			border-radius: 50%;

		}

		@keyframes blink {
			0% {
				opacity: 1;
			}

			100% {
				opacity: 0.5;
			}
		}
	</style>
	<script>
		var _HOST = "<?= base_url() ?>";
	</script>
</head>

<?php
$level = $this->session->userdata('level');

?>

<body class="sidebar-mini" style="background-color: #faf2ef;">
	<div class="wrapper">
		<div class="sidebar mobile-only" data-color="purple" data-background-color="white"
			data-image="<?= base_url() ?>assets/img/OXYGEN.jpg">
			<div class="sidebar-wrapper">
				<!--S: Menu-->
				<?php include('menu.php'); ?>
				<!--E: Menu-->
			</div>
		</div>

		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-absolute fixed-top">
			<div class="container-fluid" style="background-color: #faf2ef;">
				<div class="navbar-wrapper">
					<div class="navbar-minimize">
						<!-- <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
							<i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
							<i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
							<div class="ripple-container"></div>
						</button> -->
					</div>
					<!-- <a class="navbar-brand" href="javascript:void(0);"
						style="font-size: 12px; text-transform: uppercase; font-weight: bold;"><?= $title ?></a> -->
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
					aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Toggle navigation</span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
					<span class="navbar-toggler-icon icon-bar"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
					<ul class="navbar-nav">
						<?php if ($level == 3): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('listEmployee') ?>">MANAGEMENT EMPLOYEE</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('customerByLastDoing') ?>">CUSTOMER BY LAST DOING</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportAppointmentDoingByClinic') ?>">REPORT APPT DOING BY CLINIC</a>
							</li>
							<!-- <li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('doingTodayFinish') ?>">DOING FINISH TODAY</a>
							</li> -->

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									LIST TRANSACTION TODAY
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 4): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('saleTicketList') ?>">SALE
									TICKET LIST</a>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu5" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									DATA
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu5">
									<a class="dropdown-item" href="<?= base_url('listTarget') ?>">LIST TARGET</a>
									<a class="dropdown-item" href="<?= base_url('listEmployee') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('balancePrepaidWess') ?>">BALANCE PREPAID
										WESS</a>
									<a class="dropdown-item" href="<?= base_url('reportKPIBeautyConsultant') ?>">KPI BC</a>
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridientsIncludeCost') ?>">COST
										COGS</a>
									<a class="dropdown-item" href="<?= base_url('listExpend') ?>">EXPEND COST</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">INGREDIENTS LIST</a>
									<a class="dropdown-item" href="<?= base_url('serviceList') ?>">SERVICES LIST</a>
									<a class="dropdown-item" href="<?= base_url('packageList') ?>">PACKAGES LIST</a>

								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu10" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu10">
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridients') ?>">REPORT USED
										INGEREDIENTS</a>
									<a class="dropdown-item" href="<?= base_url('reportProfitAndLoss') ?>">REPORT PNL</a>

									<a class="dropdown-item" href="<?= base_url('reportRevenueByCustomer') ?>">REPORT
										REVENUE By CUSTOMER</a>
										<a class="dropdown-item" href="<?= base_url('reportCustomerDoingAndSpending') ?>">REPORT
										CUSTOMER DOING AND SPENDING</a>
								</div>
							</li>



							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<!-- <a class="dropdown-item"
										href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">COMMISSION HAND
										WORK DOKTER, BTC DAN NURSE</a> -->
									<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
										COMMISSION (PER MEY)</a>
									<a class="dropdown-item"
										href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO AND BTC</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">COMMISSION
										PRESCRIPTION DOKTER</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdmin') ?>">COMMISSION
										FIRST VISIT (MARKETING)</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionConsultant') ?>">COMMISSION
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionOM') ?>">COMMISSION OM</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">COMMISSION SALES AND
										MANGER EVENT ROADSHOW</a>

									<a class="dropdown-item"
										href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION SUBSCRIPTION / TOP
										UP</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
										COMMISSION AFFILIATE</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionPerInvoice') ?>">COMMISSION
										PER INVOICE</a>
									<a class="dropdown-item"
										href="<?= base_url('reportGuestCustomerServiceOnline') ?>">REPORT COMMISSION
										TRILOGY</a>

									<a class="dropdown-item"
										href="<?= base_url('reportInvoiceLifeTimePackage') ?>">REPORT COMMISSION INVOICE LIFETIME PACKAGE</a>

									<a class="dropdown-item"
										href="<?= base_url('reportCommissionInvoiceProductTherapist') ?>">REPORT COMMISSION INVOICE PRODUCT THERAPIST</a>

								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReconciliation') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('saleTicketDetail') ?>">SALES
										DETAIL</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									INVOICE MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('invoiceMembership') ?>">INVOICE PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceTreatment') ?>">INVOICE
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceRetail') ?>">INVOICE PRODUCT</a>

									<a class="dropdown-item" href="<?= base_url('invoiceDownMembership') ?>">INVOICE DP
										PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownTreatment') ?>">INVOICE DP
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownProduct') ?>">INVOICE DP
										PRODUCT</a>
									<!-- <a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a> -->
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT EMPLOYEE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
									<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
									<a class="dropdown-item" href="<?= base_url('summaryPresensiEmployee') ?>">ATTANDANCE
										SUMMARY</a>
									<a class="dropdown-item" href="<?= base_url('listEmployee') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
										REQUEST</a>
									<div class="dropdown-divider"></div>

									<a class="dropdown-item" href="<?= base_url('hrSetLocationPin') ?>">SET LOCATION PIN</a>
									<a class="dropdown-item" href="<?= base_url('employeeAccountList') ?>">EMPLOYEE ACCOUNT
										LIST</a>
									<a class="dropdown-item" href="<?= base_url('employeeAttendanceList') ?>">EMPLOYEE APPS
										ATTENDANCE</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listShift') ?>">LIST SHIFT</a>
									<a class="dropdown-item" href="<?= base_url('listLeaveType') ?>">LIST LEAVE TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listAllowanceType') ?>">LIST ALLOWANCE
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listDeductionType') ?>">LIST DEDUCTION
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listCompany') ?>">LIST COMPANY</a>
								</div>

							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									FINANCE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listCustomerWithdraw') ?>">CUSTOMER
										WITHDRAW</a>
									<a class="dropdown-item" href="<?= base_url('listSubAccountXendit') ?>">LIST SUBACCOUNT
										XENDIT</a>

								</div>

							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu0" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<!-- <a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a> -->
									<!-- <a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a> -->
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu700" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PAYROLL
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu700">
									<a class="dropdown-item" href="<?= base_url('generateEmployeePayroll') ?>">GENERATE
										PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('approvedEmployeePayroll') ?>">PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('allowanceUncertain') ?>">ALLOWANCE
										UNCERTAIN</a>
									<a class="dropdown-item" href="<?= base_url('deductionUncertain') ?>">DEDUCTION
										UNCERTAIN</a>
								</div>
							</li>

						<?php endif; ?>

						<?php if ($level == 8): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<!-- <a class="dropdown-item" href="<?= base_url('stock') ?>">MANAGEMENT STOCK</a> -->
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridients') ?>">REPORT USED
										INGEREDIENTS</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
								</div>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('saleTicketList') ?>">SALE
									TICKET LIST</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu5" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PRODUCT AND SERVICE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu5">
									<a class="dropdown-item" href="<?= base_url('serviceList') ?>">SERVICE</a>
									<a class="dropdown-item" href="<?= base_url('packageList') ?>">PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('retailList') ?>">RETAIL</a>
								</div>
							</li>
							<!-- <li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND WORK</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT COMMISSION APPT SHOW</a>
							</li> -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item"
										href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND
										WORK</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT
										COMMISSION APPT SHOW</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT
										PRESCRIPTION DOCTER</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									LIST TRANSACTION TODAY
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReconciliation') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<a class="dropdown-item" href="<?= base_url('reportTransactionsByProduct') ?>">REPORT
										TRANSACTION BY PRODUCT</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									INVOICE MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('invoiceMembership') ?>">INVOICE PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceTreatment') ?>">INVOICE
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceRetail') ?>">INVOICE PRODUCT</a>

									<a class="dropdown-item" href="<?= base_url('invoiceDownMembership') ?>">INVOICE DP
										PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownTreatment') ?>">INVOICE DP
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownProduct') ?>">INVOICE DP
										PRODUCT</a>
									<!-- <a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a> -->
								</div>

							</li>
						<?php endif; ?>


						<?php if ($level == 2): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('detailCustomer') ?>">DETAIL CUSTOMER</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestOnlineAdmin') ?>">REPORT FIRST VISIT</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestOnlineAdminNotShow') ?>">REPORT GUEST NOT SHOW</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

						<?php endif; ?>

						<?php if ($level == 6): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('detailCustomer') ?>">DETAIL CUSTOMER</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">APPOINTMENT</a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestShow') ?>">REPORT FIRST
										VISIT</a>
									<!-- <a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdminNotShow') ?>">REPORT
										GUEST NOT SHOW</a> -->
									<a class="dropdown-item" href="<?= base_url('serviceSales') ?>">SERVICE SALES</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">PRODUCT
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">PACKAGE
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('saleTicketDetail') ?>">SALE TICKET
										DETAIL</a>

									<a class="dropdown-item" href="<?= base_url('reportFilledLinkReview') ?>">REVIEW
										GOOGLE</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridientsIncludeCost') ?>">COST
										COGS</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<!-- <a class="dropdown-item" href="<?= base_url('stock') ?>">MANAGEMENT STOCK</a> -->
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu11" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu11">
									<a class="dropdown-item" href="<?= base_url('listLocation') ?>">OUTLET</a>

									<a class="dropdown-item" href="<?= base_url('listPromoBroadcast') ?>">BROADCAST
										PROMO APPS</a>

									<a class="dropdown-item" href="<?= base_url('listEventApps') ?>">EVENT
										APPS</a>
									<a class="dropdown-item" href="<?= base_url('listVideoContentApps') ?>">CONTENT VIDEO
										APPS</a>
									<a class="dropdown-item" href="<?= base_url('listAdsApps') ?>">ADS
										APPS</a>
									<a class="dropdown-item" href="<?= base_url('listEmployeeApps') ?>">EMPLOYEE
										APPS</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">INGREDIENTS LIST</a>

									<a class="dropdown-item" href="<?= base_url('listTreatmentClaimFreeApps') ?>">TREATMENT
										FREE CLAIM APPS</a>

									<a class="dropdown-item" href="<?= base_url('listCategory') ?>">LIST CATEGORY</a>

									<a class="dropdown-item" href="<?= base_url('listCategoryByProductType') ?>">LIST
										PRODUCT BY CATEGORY</a>
								</div>
							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PRODUCT AND SERVICE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('serviceList') ?>">SERVICE</a>
									<a class="dropdown-item" href="<?= base_url('packageList') ?>">PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('retailList') ?>">RETAIL</a>
								</div>
							</li>

						<?php endif; ?>


						<?php if ($level == 7): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">ITEM LIST</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu8" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu8">
									<a class="dropdown-item" href="<?= base_url('listCompany') ?>">COMPANY</a>
									<a class="dropdown-item" href="<?= base_url('listSupplier') ?>">SUPPLIER</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestList') ?>">PURCHASE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('purchaseOrderList') ?>">PURCHASE
										ORDER</a>
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY
										ORDER</a>
								</div>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportOrderMonthly') ?>">REPORT PEMBELIAN</a>
							</li>
						<?php endif; ?>

						<?php if ($level == 5): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('detailCustomer') ?>">DATA
									ENTRY</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestMarketing') ?>">REPORT GUEST</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('linkAffiliate') ?>">LINK
									AFILIATE</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('addAffiliate') ?>">ADD
									AFILIATE</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>
						<?php endif; ?>

						<?php if ($level == 1): ?>
							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('createTransaction') ?>">DATA ENTRY</a>
							</li>

							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('listPrepaidFinished') ?>">DOING YESTERDAY</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestMarketing') ?>">GUEST AFFILIATE</a>
							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT EMPLOYEE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
									<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
									<a class="dropdown-item"
										href="<?= base_url('summaryPresensiEmployeeClinic') ?>">ATTANDANCE
										SUMMARY</a>
									<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
										REQUEST</a>
								</div>
							</li>

							<!-- Menu 1 dengan Dropdown -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									DATA
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<!-- <a class="dropdown-item" href="<?= base_url('listEmployee') ?>">STAFF EMPLOYEE </a> -->
									<a class="dropdown-item" href="<?= base_url('saleTicketList') ?>">SALE TICKET LIST</a>
									<a class="dropdown-item" href="<?= base_url('balancePrepaidWess') ?>">BALANCE PREPAID
										WESS</a>
									<a class="dropdown-item"
										href="<?= base_url('reportDoingNotInInvoiceLocation') ?>">PREPAID NOT IN INVOICE
										LOCATION</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">TARGET
										CSO AND THERAPIST</a>
									<a class="dropdown-item" href="<?= base_url('guestfromlink') ?>">GUEST LINK CUSTOMER</a>
									<a class="dropdown-item" href="<?= base_url('reportAppointmentDoingByClinic') ?>">APPT
										DOING BY CLINIC</a>
									<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
										COMMISSION</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionConsultant') ?>">COMMISSION
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('callapptfd') ?>">CALL MEMBER ACTIVE</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestShow') ?>">REPORT GUEST SHOW
										JOIN AND TOP SPENDER</a>
									<a class="dropdown-item" href="<?= base_url('linkDocter') ?>">LINK DOKTER</a>
									<a class="dropdown-item" href="<?= base_url('refferal') ?>">LINK REFFERAL CUSTOMER</a>
									<a class="dropdown-item" href="<?= base_url('reportCustomerTrial') ?>">DATA CUSTOMER
										TRIAL</a>
									<a class="dropdown-item" href="<?= base_url('reportFilledLinkReview') ?>">REVIEW
										GOOGLE</a>

									<a class="dropdown-item" href="<?= base_url('reportNewGuestNoAppointment') ?>">REPORT
										GUEST NO
										APPOINTMENT</a>
									<a class="dropdown-item" href="<?= base_url('reportCustomerDoingAndSpending') ?>">REPORT
										CUSTOMER DOING AND SPENDING</a>
								</div>
							</li>
							<!-- Menu 2 dengan Dropdown -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<!-- <a class="dropdown-item" href="<?= base_url('report_consultation_docter') ?>">REPORT CONSULTATION DOCTER</a> -->
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT
										PRESCRIPTION DOCTER</a>
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('reportTransactionsByProduct') ?>">REPORT
										TRANSACTION BY PRODUCT</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									CONSULTATION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('addConsultation') ?>">ADD CONSULTATION</a>
									<a class="dropdown-item" href="<?= base_url('consultationHistory') ?>">HISTORY</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestLists') ?>">PURCHASE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY ORDER</a>
								</div>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('facilityReportList') ?>">ASET</a>
							</li>

							<li class="nav-item">
								<a id="chat-link" style="font-weight: bold;" class="nav-link"
									href="<?= base_url('consultationList') ?>">
									CHAT <span id="chat-badge" class="badge bg-danger" style="display:none;">●</span>
								</a>
							</li>

							<?php if ($userId == 50 || $userId == 51 || $userId == 56): ?>
								<li class="nav-item dropdown">
									<select name="locationid" class="form-control form-select text-center" id="locationSelect">
										<?php foreach ($locationList as $loc): ?>
											<option value="<?= $loc['id'] ?>" <?= ($locationId == $loc['id'] ? 'selected' : '') ?>>
												<?= strtoupper($loc['name']) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</li>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ($level == 9): ?>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item"
										href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND
										WORK</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT
										COMMISSION APPT SHOW</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT
										PRESCRIPTION DOCTER</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									FINANCE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listCustomerWithdraw') ?>">CUSTOMER
										WITHDRAW</a>
									<a class="dropdown-item" href="<?= base_url('listSubAccountXendit') ?>">LIST SUBACCOUNT
										XENDIT</a>

								</div>

							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									LIST TRANSACTION TODAY
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
								</div>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('financeApproval') ?>">PURCHASE
									APPROVAL</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('deliveryOrderList') ?>">DELIVERY
									ORDER</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportOrderMonthly') ?>">REPORT PEMBELIAN</a>
							</li>
						<?php endif; ?>
						<?php if ($level == 10): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>
						<?php endif; ?>

						<?php if ($level == 11): ?>
							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('createTransaction') ?>">DATA
									ENTRY</a>
							</li>

							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('listLinkRegistrasiConsultant') ?>">LINK
									CONSULTANT</a>
							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu8" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu8">
									<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">REPORT GUEST
										EVENT</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestEventNotShow') ?>">REPORT GUEST
										NOT SHOW</a>
									<a class="dropdown-item"
										href="<?= base_url('reportTransactionCustomerEventRoadshow') ?>">REPORT TRANSACTION
										EVENT ROADSHOW</a>
								</div>
							</li>




							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									DATA
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu7">
									<a class="dropdown-item" href="<?= base_url('listNewCustomer') ?>">NEW CUSTOMER</a>

								</div>
							</li>


							<!-- Menu 2 dengan Dropdown -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									LIST TRANSACTION TODAY
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestLists') ?>">PURCHASE
										REQUEST</a>
									<!-- <a class="dropdown-item" href="<?= base_url('purchaseOrderList') ?>">PURCHASE ORDER</a> -->
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY ORDER</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 12): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('detailCustomer') ?>">DETAIL
									CUSTOMER</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('listLinkRegistrasiConsultant') ?>">LINK
									REGISTRASI</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestCustomerServiceOnline') ?>">REPORT SHOW JOIN</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportGuestCustomerServiceOnlineNotShow') ?>">REPORT GUEST NOT
									SHOW</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportNewGuestNoAppointment') ?>">REPORT GUEST NO
									APPOINTMENT</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

						<?php endif; ?>

						<?php if ($level == 13): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('call_appt_not_active_21days') ?>">REPORT CUSTOMER 21 DAYS</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportAppointmentCustomerCareOnline') ?>">REPORT APPOINTMENT</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('detailCustomer') ?>">DETAIL
									CUSTOMER</a>
							</li>

						<?php endif; ?>

						<?php if ($level == 20 || $level == 21): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('purchaseOrderApproval') ?>">PURCHASE ORDER APPROVAL</a>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">ITEM LIST</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('reportOrderMonthly') ?>">RERPORT PEMBELIAN</a>
							</li>


						<?php endif; ?>

						<?php if ($level == 22): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('deliveryOrderList') ?>">STOCK IN
									APPROVAL</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('saleTicketList') ?>">SALE
									TICKET LIST</a>
							</li>

							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('facilityReportList') ?>">ASET</a>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									INVOICE MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('invoiceMembership') ?>">INVOICE PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceTreatment') ?>">INVOICE
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceRetail') ?>">INVOICE PRODUCT</a>

									<a class="dropdown-item" href="<?= base_url('invoiceDownMembership') ?>">INVOICE DP
										PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownTreatment') ?>">INVOICE DP
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownProduct') ?>">INVOICE DP
										PRODUCT</a>
									<!-- <a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a> -->
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">ITEM LIST</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestList') ?>">PURCHASE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('purchaseOrderList') ?>">PURCHASE
										ORDER</a>
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY
										ORDER</a>
								</div>
							</li>


						<?php endif; ?>

						<?php if ($level == 14): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('consultationList') ?>">
									CHAT CONSULTATION</a>
							</li>
						<?php endif; ?>

						<?php if ($level == 15): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
										COMMISSION (PER MEY)</a>
									<a class="dropdown-item"
										href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO
										AND BTC</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">COMMISSION
										PRESCRIPTION DOKTER</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdmin') ?>">COMMISSION
										FIRST VISIT (MARKETING)</a>
									<a class="dropdown-item" href="<?= base_url('reportAchievementConsultant') ?>">REPORT KPI CONSULTANT</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionOM') ?>">COMMISSION OM</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">COMMISSION SALES AND
										MANGER EVENT ROADSHOW</a>

									<a class="dropdown-item"
										href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION
										SUBSCRIPTION / TOP
										UP</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
										COMMISSION AFFILIATE</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT EMPLOYEE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
									<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
									<a class="dropdown-item" href="<?= base_url('summaryPresensiEmployee') ?>">ATTANDANCE
										SUMMARY</a>
									<a class="dropdown-item" href="<?= base_url('listEmployeeCompany') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('publicHolidayCalender') ?>">PUBLIC HOLIDAY
										CALENDER</a>
									<a class="dropdown-item" href="<?= base_url('createAttandanceLogManual') ?>">MANUAL
										ATTANDANCE</a>
									<div class="dropdown-divider"></div>

									<a class="dropdown-item" href="<?= base_url('hrSetLocationPin') ?>">SET LOCATION PIN</a>
									<a class="dropdown-item" href="<?= base_url('employeeAccountList') ?>">EMPLOYEE ACCOUNT
										LIST</a>
									<a class="dropdown-item" href="<?= base_url('employeeAttendanceList') ?>">EMPLOYEE APPS
										ATTENDANCE</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listShift') ?>">LIST SHIFT</a>
									<a class="dropdown-item" href="<?= base_url('listLeaveType') ?>">LIST LEAVE TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listAllowanceType') ?>">LIST ALLOWANCE
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listDeductionType') ?>">LIST DEDUCTION
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listCompanyCompany') ?>">LIST COMPANY</a>
									<a class="dropdown-item" href="<?= base_url('listJob') ?>">LIST JOB</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu700" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PAYROLL
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu700">
									<a class="dropdown-item" href="<?= base_url('generateEmployeePayroll') ?>">GENERATE
										PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('approvedEmployeePayroll') ?>">PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('allowanceUncertain') ?>">ALLOWANCE
										UNCERTAIN</a>
									<a class="dropdown-item" href="<?= base_url('deductionUncertain') ?>">DEDUCTION
										UNCERTAIN</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 16): ?>
							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('createTransaction') ?>">DATA
									ENTRY</a>
							</li>

							<!-- Menu 3 tanpa Dropdown -->
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<!-- Menu 2 dengan Dropdown -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<!-- <a class="dropdown-item" href="<?= base_url('report_consultation_docter') ?>">REPORT CONSULTATION DOCTER</a> -->
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT
										PRESCRIPTION DOCTER</a>
								</div>
							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									TRANSACTION TODAY
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 23): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">ITEM LIST</a>
									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestList') ?>">PURCHASE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY
										ORDER</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 100): ?>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link"
									href="<?= base_url('bookAppointment') ?>">BOOKING</a>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
										COMMISSION (PER MEY)</a>
									<a class="dropdown-item"
										href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO
										AND BTC</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">COMMISSION
										PRESCRIPTION DOKTER</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdmin') ?>">COMMISSION
										FIRST VISIT (MARKETING)</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionConsultant') ?>">COMMISSION
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionOM') ?>">COMMISSION OM</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">COMMISSION SALES AND
										MANGER EVENT ROADSHOW</a>

									<a class="dropdown-item"
										href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION
										SUBSCRIPTION / TOP
										UP</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
										COMMISSION AFFILIATE</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT EMPLOYEE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
									<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
									<a class="dropdown-item" href="<?= base_url('summaryPresensiEmployee') ?>">ATTANDANCE
										SUMMARY</a>
									<a class="dropdown-item" href="<?= base_url('listEmployee') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('publicHolidayCalender') ?>">PUBLIC HOLIDAY
										CALENDER</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listShift') ?>">LIST SHIFT</a>
									<a class="dropdown-item" href="<?= base_url('listLeaveType') ?>">LIST LEAVE TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listAllowanceType') ?>">LIST ALLOWANCE
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listDeductionType') ?>">LIST DEDUCTION
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listCompany') ?>">LIST COMPANY</a>
									<a class="dropdown-item" href="<?= base_url('listJob') ?>">LIST JOB</a>
								</div>
							</li>
						<?php endif; ?>

						<?php if ($level == 99): ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu5" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									DATA
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu5">
									<a class="dropdown-item" href="<?= base_url('listTarget') ?>">LIST TARGET</a>
									<a class="dropdown-item" href="<?= base_url('listEmployee') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('balancePrepaidWess') ?>">BALANCE PREPAID
										WESS</a>
									<a class="dropdown-item" href="<?= base_url('reportKPIBeautyConsultant') ?>">KPI BC</a>
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridientsIncludeCost') ?>">COST
										COGS</a>
									<a class="dropdown-item" href="<?= base_url('listExpend') ?>">EXPEND COST</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">INGREDIENTS LIST</a>
									<a class="dropdown-item" href="<?= base_url('serviceList') ?>">SERVICES LIST</a>
									<a class="dropdown-item" href="<?= base_url('packageList') ?>">PACKAGES LIST</a>
									<a style="font-weight: bold;" class="nav-link"
										href="<?= base_url('saleTicketList') ?>">SALE
										TICKET LIST</a>
									<a style="font-weight: bold;" class="nav-link"
										href="<?= base_url('bookAppointment') ?>">BOOKING</a>

								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu10" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu10">
									<a class="dropdown-item" href="<?= base_url('reportUsedIngridients') ?>">REPORT USED
										INGEREDIENTS</a>
									<a class="dropdown-item" href="<?= base_url('reportProfitAndLoss') ?>">REPORT PNL</a>

									<a class="dropdown-item" href="<?= base_url('reportRevenueByCustomer') ?>">REPORT
										REVENUE By CUSTOMER</a>
								</div>
							</li>



							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT COMMISSION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<!-- <a class="dropdown-item"
										href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">COMMISSION HAND
										WORK DOKTER, BTC DAN NURSE</a> -->
									<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
										COMMISSION (PER MEY)</a>
									<a class="dropdown-item"
										href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO AND BTC</a>
									<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">COMMISSION
										PRESCRIPTION DOKTER</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdmin') ?>">COMMISSION
										FIRST VISIT (MARKETING)</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionConsultant') ?>">COMMISSION
										SALES</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionOM') ?>">COMMISSION OM</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">COMMISSION SALES AND
										MANGER EVENT ROADSHOW</a>

									<a class="dropdown-item"
										href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION SUBSCRIPTION / TOP
										UP</a>
									<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
										COMMISSION AFFILIATE</a>
									<a class="dropdown-item" href="<?= base_url('reportCommissionPerInvoice') ?>">COMMISSION
										PER INVOICE</a>
									<a class="dropdown-item"
										href="<?= base_url('reportGuestCustomerServiceOnline') ?>">REPORT COMMISSION
										TRILOGY</a>

								</div>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									REPORT TRANSACTION
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
									<a class="dropdown-item" href="<?= base_url('dailySalesReconciliation') ?>">DAILY SALES
										REPORT</a>
									<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE
										PER DAY</a>
									<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE
										BY SALES</a>
									<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION
										TREATMENT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION
										PACKAGE TODAY</a>
									<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION
										PRODUCT TODAY</a>
									<a class="dropdown-item" href="<?= base_url('saleTicketDetail') ?>">SALES
										DETAIL</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									INVOICE MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
									<a class="dropdown-item" href="<?= base_url('invoiceMembership') ?>">INVOICE PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceTreatment') ?>">INVOICE
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceRetail') ?>">INVOICE PRODUCT</a>

									<a class="dropdown-item" href="<?= base_url('invoiceDownMembership') ?>">INVOICE DP
										PACKAGE</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownTreatment') ?>">INVOICE DP
										TREATMENT</a>
									<a class="dropdown-item" href="<?= base_url('invoiceDownProduct') ?>">INVOICE DP
										PRODUCT</a>
									<!-- <a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a> -->
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MANAGEMENT EMPLOYEE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
									<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
									<a class="dropdown-item" href="<?= base_url('summaryPresensiEmployee') ?>">ATTANDANCE
										SUMMARY</a>
									<a class="dropdown-item" href="<?= base_url('listEmployee') ?>">LIST EMPLOYEE</a>
									<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
										REQUEST</a>
									<div class="dropdown-divider"></div>

									<a class="dropdown-item" href="<?= base_url('hrSetLocationPin') ?>">SET LOCATION PIN</a>
									<a class="dropdown-item" href="<?= base_url('employeeAccountList') ?>">EMPLOYEE ACCOUNT
										LIST</a>
									<a class="dropdown-item" href="<?= base_url('employeeAttendanceList') ?>">EMPLOYEE APPS
										ATTENDANCE</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									MASTER
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listShift') ?>">LIST SHIFT</a>
									<a class="dropdown-item" href="<?= base_url('listLeaveType') ?>">LIST LEAVE TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listAllowanceType') ?>">LIST ALLOWANCE
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listDeductionType') ?>">LIST DEDUCTION
										TYPE</a>
									<a class="dropdown-item" href="<?= base_url('listCompany') ?>">LIST COMPANY</a>
								</div>

							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									FINANCE
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
									<a class="dropdown-item" href="<?= base_url('listCustomerWithdraw') ?>">CUSTOMER
										WITHDRAW</a>
									<a class="dropdown-item" href="<?= base_url('listSubAccountXendit') ?>">LIST SUBACCOUNT
										XENDIT</a>

								</div>

							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PURCHASING
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
									<a class="dropdown-item" href="<?= base_url('purchaseRequestList') ?>">PURCHASE
										REQUEST</a>
									<a class="dropdown-item" href="<?= base_url('purchaseOrderList') ?>">PURCHASE
										ORDER</a>
									<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY
										ORDER</a>
								</div>
							</li>


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu0" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									STOCK
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">

									<a class="dropdown-item" href="<?= base_url('reportStockOpname') ?>">STOCK OPNAME</a>
									<!-- <a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a> -->
									<!-- <a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a> -->
									<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
									<a class="dropdown-item" href="<?= base_url('ingredientsList') ?>">ITEM LIST</a>

									<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
									<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
								</div>
							</li>

							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu700" role="button"
									data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									PAYROLL
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu700">
									<a class="dropdown-item" href="<?= base_url('generateEmployeePayroll') ?>">GENERATE
										PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('approvedEmployeePayroll') ?>">PAYROLL</a>
									<a class="dropdown-item" href="<?= base_url('allowanceUncertain') ?>">ALLOWANCE
										UNCERTAIN</a>
									<a class="dropdown-item" href="<?= base_url('deductionUncertain') ?>">DEDUCTION
										UNCERTAIN</a>
								</div>
							</li>

						<?php endif; ?>
					</ul>
				</div>



				<?php if ($level != null): ?>
					<div class="justify-content-end d-none d-md-flex">
						<div class="d-flex align-items-center">
							<div class="" style="font-weight: bold; font-size: 12px;">
								<?= $this->session->userdata('name'); ?>
							</div>
							<div class="m-2">
								<a href="<?= base_url() ?>logout" class="nav-link">
									<div class="d-flex align-items-center">
										<div>
											<i class="material-icons">exit_to_app</i>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</nav>
		<!-- End Navbar -->

		<!-- Main Content -->
		<div class="main-panel" style="background-color: #faf2ef;">
			<div class="content">
				<?php $this->load->view('content/' . $content) ?>
			</div>
		</div>
	</div>

	<!-- Core JS Files -->
	<script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
	<script src="<?= base_url() ?>assets/js/core/bootstrap-material-design.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/moment.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/sweetalert2.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/jquery.validate.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/jquery.bootstrap-wizard.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/bootstrap-selectpicker.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/bootstrap-tagsinput.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/jasny-bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/fullcalendar.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/jquery-jvectormap.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/nouislider.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/arrive.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/chartist.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugins/bootstrap-notify.js"></script>
	<script src="<?= base_url() ?>assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
	<script src="<?= base_url() ?>assets/js/initapp.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script> -->
	<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>



	<script>
		$('#tbl-treatment-info<?= $row['ID'] ?>').DataTable({
			"pageLength": 2,
			"lengthMenu": [2, 10, 15, 20, 25],
			select: true,
			'bAutoWidth': false,
		});

		$('#tbl-membership-treatment<?= $row['ID'] ?>').DataTable({
			"pageLength": 2,
			"lengthMenu": [2, 10, 15, 20, 25],
			select: true,
			'bAutoWidth': false,
		});

		$('#tbl-history-doing<?= $row['ID'] ?>').DataTable({
			"pageLength": 2,
			"lengthMenu": [2, 10, 15, 20, 25],
			select: true,
			'bAutoWidth': false
		});
	</script>

	<script>

		function showBrowserNotification(title, body, url) {
			// cek apakah browser mendukung Notification
			if (!("Notification" in window)) return;

			// cek permission
			if (Notification.permission === "granted") {
				const notification = new Notification(title, {
					body: body,
					icon: "/favicon.ico", // bisa ganti icon sesuai
				});

				notification.onclick = () => {
					window.focus();
					if (url) window.location.href = url;
				};
			} else if (Notification.permission !== "denied") {
				Notification.requestPermission().then((permission) => {
					if (permission === "granted") {
						showBrowserNotification(title, body, url);
					}
				});
			}
		}

		const userid = "<?= $userId ?>";
		const BASE_URL = "<?= base_url() ?>";

		async function loadChatList() {
			try {
				const response = await fetch(`${BASE_URL}/ControllerApiApps/getUnreadChat`);
				const res = await response.json();
				if (res.status === 'success') {
					const unreadCount = res.data?.length || 0;
					const chatLink = document.querySelector('.nav-link[href="<?= base_url('consultationList') ?>"]');

					if (chatLink) {
						if (unreadCount > 0) {
							chatLink.innerHTML = `CHAT (${unreadCount})`;
						} else {
							chatLink.innerHTML = `CHAT`;
						}
					}
				} else {
					console.log('gasukses');
				}
			} catch (error) {
				console.error("Failed to load chat list", error);
			}
		}

		function setupWebSocket() {
			loadChatList()
			const socket = io("https://sys.eudoraclinic.com:3001", {
				transports: ["websocket", "polling"]
			});

			socket.on("connect", () => {
				console.log("✅ Connected to WebSocket Server");
				socket.emit("joinRoom", `employee_${userid}`);
			});

			socket.on("newMessage", (data) => {
				if (data.receiver_id == userid && data.receiver_type == "employee") {
					loadChatList()

					if (document.visibilityState === "visible") {
						Swal.fire({
							toast: false,
							position: 'top-end',
							icon: 'info',
							title: 'Ada pesan baru masuk',
							showConfirmButton: true,
							confirmButtonText: 'Lihat Pesan',
							showCancelButton: true,
							cancelButtonText: 'Tutup',
							timer: 0,
						}).then((result) => {
							if (result.value) {
								window.location.href = "https://sys.eudoraclinic.com:84/app/consultationList";
							}
						});
					} else {
						// notifikasi browser untuk tab lain atau minimized
						showBrowserNotification(
							"Ada pesan baru masuk",
							`Klik untuk membuka chat`,
							"https://sys.eudoraclinic.com:84/app/consultationList"
						);
					}
				}
			});

			socket.on("disconnect", () => {
				console.log("🔴 Disconnected from WebSocket Server");
			});
		}
		document.addEventListener('DOMContentLoaded', setupWebSocket);

		document.getElementById('locationSelect').addEventListener('change', function () {
			const locationId = this.value;

			console.log('locationId');


			fetch('<?= base_url('App/set_ajax') ?>', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: 'locationid=' + encodeURIComponent(locationId)
			})
				.then(response => {
					if (response.ok) {
						location.reload();
					} else {
						alert('Gagal mengubah lokasi.');
					}
				});
		});
	</script>
</body>

</html>