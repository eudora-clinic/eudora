<?php
$current_url = current_url();
$base_url = base_url();
$uri = str_replace($base_url, '', $current_url);
$level = $this->session->userdata('level');
?>
<style>
	.sidebar .nav li .dropdown-menu a,
	.sidebar .nav li a {
		text-transform: uppercase;
	}

	.sidebar .nav li a p {
		font-size: 12px;
		font-weight: bold;
	}
</style>
<ul id="menu" class="nav">
	<?php if ($level == 4): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('saleTicketList') ?>">SALE
				TICKET LIST</a>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu5" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu10" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT COMMISSION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<!-- <a class="dropdown-item"
										href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">COMMISSION HAND
										WORK DOKTER, BTC DAN NURSE</a> -->
				<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
					COMMISSION (PER MEY)</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO AND BTC</a>
				<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">COMMISSION
					PRESCRIPTION DOKTER</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestOnlineAdmin') ?>">COMMISSION
					FIRST VISIT (MARKETING)</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionConsultant') ?>">COMMISSION
					SALES</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionOM') ?>">COMMISSION OM</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">COMMISSION SALES AND
					MANGER EVENT ROADSHOW</a>

				<a class="dropdown-item" href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION SUBSCRIPTION /
					TOP
					UP</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
					COMMISSION AFFILIATE</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionPerInvoice') ?>">COMMISSION
					PER INVOICE</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestCustomerServiceOnline') ?>">REPORT COMMISSION
					TRILOGY</a>

			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu0" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu700" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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

	<?php if ($level == 15): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT COMMISSION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<a class="dropdown-item" href="<?= base_url('reportDoingCommission') ?>">REPORT DOING
					COMMISSION (PER MEY)</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">COMMISSION CSO
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

				<a class="dropdown-item" href="<?= base_url('reportCommissionSubscription') ?>">COMMISSION
					SUBSCRIPTION / TOP
					UP</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestMarketing') ?>">REPORT
					COMMISSION AFFILIATE</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
				<a class="dropdown-item" href="<?= base_url('createAttandanceLogManual') ?>">MANUAL
					ATTANDANCE</a>
				<div class="dropdown-divider"></div>

				<a class="dropdown-item" href="<?= base_url('hrSetLocationPin') ?>">SET LOCATION PIN</a>
				<a class="dropdown-item" href="<?= base_url('employeeAccountList') ?>">EMPLOYEE ACCOUNT LIST</a>
				<a class="dropdown-item" href="<?= base_url('employeeAttendanceList') ?>">EMPLOYEE APPS ATTENDANCE</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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

	<?php if ($level == 23): ?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu8" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				MASTER
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu8">
				<a class="dropdown-item" href="<?= base_url('listCompany') ?>">COMPANY</a>
				<a class="dropdown-item" href="<?= base_url('listSupplier') ?>">SUPPLIER</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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


	<?php if ($level == 9): ?>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT COMMISSION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<a class="dropdown-item" href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND
					WORK</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT
					COMMISSION APPT SHOW</a>
				<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT
					PRESCRIPTION DOCTER</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				FINANCE
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu0">
				<a class="dropdown-item" href="<?= base_url('listCustomerWithdraw') ?>">CUSTOMER WITHDRAW</a>
				<a class="dropdown-item" href="<?= base_url('listSubAccountXendit') ?>">LIST SUBACCOUNT XENDIT</a>

			</div>

		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('financeApproval') ?>">PURCHASE APPROVAL</a>
		</li>
	<?php endif; ?>

	<?php if ($level == 20 || $level == 21): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('purchaseOrderApproval') ?>">PURCHASE ORDER
				APPROVAL</a>
		</li>

	<?php endif; ?>

	<?php if ($level == 16): ?>
		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('createTransaction') ?>">DATA
				ENTRY</a>
		</li>

		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

		<!-- Menu 2 dengan Dropdown -->
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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

	<?php if ($level == 22): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('deliveryOrderList') ?>">STOCK IN APPROVAL</a>
		</li>

	<?php endif; ?>


	<?php if ($level == 7): ?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu8" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				MASTER
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu8">
				<a class="dropdown-item" href="<?= base_url('listCompany') ?>">COMPANY</a>
				<a class="dropdown-item" href="<?= base_url('listSupplier') ?>">SUPPLIER</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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


	<?php if ($level == 6): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('detailCustomer') ?>">DETAIL CUSTOMER</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">APPOINTMENT</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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

				<a class="dropdown-item" href="<?= base_url('reportFilledLinkReview') ?>">REVIEW GOOGLE</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				PRODUCT AND SERVICE
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
				<a class="dropdown-item" href="<?= base_url('serviceList') ?>">SERVICE</a>
				<a class="dropdown-item" href="<?= base_url('packageList') ?>">PACKAGE</a>
				<a class="dropdown-item" href="<?= base_url('retailList') ?>">RETAIL</a>
			</div>
		</li>

	<?php endif; ?>

	<?php if ($level == 2): ?>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('detailCustomer') ?>">DETAIL CUSTOMER</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportGuestOnlineAdmin') ?>">REPORT FIRST
				VISIT</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportGuestOnlineAdminNotShow') ?>">REPORT
				GUEST NOT SHOW</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>
	<?php endif; ?>

	<?php if ($level == 8): ?>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				MANAGEMENT STOCK
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
				<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
				<!-- <a class="dropdown-item" href="<?= base_url('stock') ?>">MANAGEMENT STOCK</a> -->
				<a class="dropdown-item" href="<?= base_url('stockInList') ?>">STOCK IN LIST</a>
				<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
			</div>
		</li>
		<!-- <li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND WORK</a>
							</li>
							<li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT COMMISSION APPT SHOW</a>
							</li> -->
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT COMMISSION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<a class="dropdown-item" href="<?= base_url('reportHandWorkCommissionDokterTherapist') ?>">REPORT HAND
					WORK</a>
				<a class="dropdown-item" href="<?= base_url('reportCommissionAppointmentCSO') ?>">REPORT COMMISSION APPT
					SHOW</a>
				<a class="dropdown-item" href="<?= base_url('reportPrescriptionDoctor') ?>">REPORT PRESCRIPTION DOCTER</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				LIST TRANSACTION TODAY
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
				<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION TREATMENT TODAY</a>
				<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION PACKAGE TODAY</a>
				<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION PRODUCT TODAY</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT TRANSACTION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
				<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES REPORT</a>
				<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a>
				<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE BY SALES</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				INVOICE MASTER
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
				<a class="dropdown-item" href="<?= base_url('invoiceMembership') ?>">INVOICE PACKAGE</a>
				<a class="dropdown-item" href="<?= base_url('invoiceTreatment') ?>">INVOICE TREATMENT</a>
				<a class="dropdown-item" href="<?= base_url('invoiceRetail') ?>">INVOICE PRODUCT</a>

				<a class="dropdown-item" href="<?= base_url('invoiceDownMembership') ?>">INVOICE DP PACKAGE</a>
				<a class="dropdown-item" href="<?= base_url('invoiceDownTreatment') ?>">INVOICE DP TREATMENT</a>
				<a class="dropdown-item" href="<?= base_url('invoiceDownProduct') ?>">INVOICE DP PRODUCT</a>
				<!-- <a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a> -->
			</div>

		</li>
	<?php endif; ?>

	<?php if ($level == 3): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('listEmployee') ?>">MANAGEMENT EMPLOYEE</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportAppointmentDoingByClinic') ?>">REPORT
				APPT DOING BY CLINIC</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('customerByLastDoing') ?>">CUSTOMER BY LAST
				DOING</a>
		</li>
		<!-- <li class="nav-item">
								<a style="font-weight: bold;" class="nav-link" href="<?= base_url('doingTodayFinish') ?>">DOING FINISH TODAY</a>
							</li> -->

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				LIST TRANSACTION TODAY
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
				<a class="dropdown-item" href="<?= base_url('transactionTreatmentToday') ?>">TRANSACTION TREATMENT TODAY</a>
				<a class="dropdown-item" href="<?= base_url('transactionTodayPaket') ?>">TRANSACTION PACKAGE TODAY</a>
				<a class="dropdown-item" href="<?= base_url('transactionTodayRetail') ?>">TRANSACTION PRODUCT TODAY</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT TRANSACTION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
				<a class="dropdown-item" href="<?= base_url('dailySalesReport') ?>">DAILY SALES REPORT</a>
				<a class="dropdown-item" href="<?= base_url('summaryRevenuePerDay') ?>">SUMMARY REVENUE PER DAY</a>
				<a class="dropdown-item" href="<?= base_url('reportRevenueBySales') ?>">REPORT REVENUE BY SALES</a>
			</div>
		</li>
	<?php endif; ?>

	<?php if ($level == 10): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>
	<?php endif; ?>

	<?php if ($level == 1): ?>
		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('createTransaction') ?>">DATA ENTRY</a>
		</li>

		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('listPrepaidFinished') ?>">DOING YESTERDAY</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportGuestMarketing') ?>">GUEST
				AFFILIATE</a>
		</li>


		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu100" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				MANAGEMENT EMPLOYEE
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu100">
				<a class="dropdown-item" href="<?= base_url('presensiEmployee') ?>">ATTANDANCE DAILY</a>
				<a class="dropdown-item" href="<?= base_url('summaryPresensiEmployeeClinic') ?>">ATTANDANCE
					SUMMARY</a>
				<a class="dropdown-item" href="<?= base_url('leavePermissionRequest') ?>">LEAVE
					REQUEST</a>
			</div>
		</li>

		<!-- Menu 1 dengan Dropdown -->
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				DATA
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
				<!-- <a class="dropdown-item" href="<?= base_url('listEmployee') ?>">STAFF EMPLOYEE </a> -->
				<a class="dropdown-item" href="<?= base_url('saleTicketList') ?>">SALE TICKET LIST</a>
				<a class="dropdown-item" href="<?= base_url('balancePrepaidWess') ?>">BALANCE PREPAID
					WESS</a>
				<a class="dropdown-item" href="<?= base_url('reportDoingNotInInvoiceLocation') ?>">PREPAID NOT IN INVOICE
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				MANAGEMENT STOCK
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
				<a class="dropdown-item" href="<?= base_url('report_ingredients') ?>">STOCK BALANCE</a>
				<a class="dropdown-item" href="<?= base_url('stockOutList') ?>">STOCK OUT LIST</a>
			</div>
		</li>
		<!-- 
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
							</li> -->

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				CONSULTATION
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
				<a class="dropdown-item" href="<?= base_url('addConsultation') ?>">ADD CONSULTATION</a>
				<a class="dropdown-item" href="<?= base_url('consultationHistory') ?>">HISTORY</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				PURCHASING
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<a class="dropdown-item" href="<?= base_url('purchaseRequestLists') ?>">PURCHASE
					REQUEST</a>
				<!-- <a class="dropdown-item" href="<?= base_url('purchaseOrderList') ?>">PURCHASE ORDER</a> -->
				<a class="dropdown-item" href="<?= base_url('deliveryOrderList') ?>">DELIVERY ORDER</a>
			</div>
		</li>

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				ASSET
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
				<a class="dropdown-item" href="<?= base_url('facilityReportList') ?>">INPUT ASSET</a>
			</div>
		</li>

		<li class="nav-item">
			<a id="chat-link" style="font-weight: bold;" class="nav-link" href="<?= base_url('consultationList') ?>">
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

	<?php if ($level == 11): ?>
		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('createTransaction') ?>">DATA ENTRY</a>
		</li>

		<!-- Menu 3 tanpa Dropdown -->
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('listLinkRegistrasiConsultant') ?>">LINK
				CONSULTANT</a>
		</li>


		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu8" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				REPORT
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu8">
				<a class="dropdown-item" href="<?= base_url('reportGuestEvent') ?>">REPORT GUEST EVENT</a>
				<a class="dropdown-item" href="<?= base_url('reportGuestEventNotShow') ?>">REPORT GUEST NOT SHOW</a>
			</div>



		</li>




		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu7" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
				DATA
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenu7">
				<a class="dropdown-item" href="<?= base_url('listNewCustomer') ?>">NEW CUSTOMER</a>

			</div>
		</li>


		<!-- Menu 2 dengan Dropdown -->
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown"
				aria-haspopup="true" aria-expanded="false">
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
	<?php endif; ?>

	<?php if ($level == 12): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('detailCustomer') ?>">DETAIL CUSTOMER</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('listLinkRegistrasiConsultant') ?>">LINK
				REGISTRASI</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportGuestCustomerServiceOnline') ?>">REPORT
				SHOW JOIN</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link"
				href="<?= base_url('reportGuestCustomerServiceOnlineNotShow') ?>">REPORT GUEST NOT SHOW</a>
		</li>

		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('reportNewGuestNoAppointment') ?>">REPORT
				GUEST NO
				APPOINTMENT</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

	<?php endif; ?>

	<?php if ($level == 13): ?>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('call_appt_not_active_21days') ?>">REPORT
				CUSTOMER 21 DAYS</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link"
				href="<?= base_url('reportAppointmentCustomerCareOnline') ?>">REPORT APPOINTMENT</a>
		</li>
		<li class="nav-item">
			<a style="font-weight: bold;" class="nav-link" href="<?= base_url('bookAppointment') ?>">BOOKING</a>
		</li>

	<?php endif; ?>

	<li class="nav-item">
		<a href="<?= base_url() ?>logout" class="nav-link">
			<div class="d-flex align-items-center">
				<div>
					<i class="material-icons">exit_to_app</i>
					LOGOUT
				</div>
			</div>
		</a>
	</li>

</ul>