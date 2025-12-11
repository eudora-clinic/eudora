<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'App';
$route['404_override'] = 'App/page_not_found';
$route['translate_uri_dashes'] = FALSE;
$route['app'] = 'App';
$route['login'] = 'App/doLogin';
$route['logout'] = 'App/doLogout';
$route['ubah-password'] = 'App/content/ubah_password';
$route['set-password'] = 'App/content/setPassword';
$route['summarydetailorder'] = 'App/content/summarydetailorder';
$route['summaryreport_RoDaily'] = 'App/content/summaryreport_RoDaily';
$route['guest'] = 'App/content/guest';
$route['add-guest'] = 'App/content/guest_add';
$route['summaryreportguestonline'] = 'App/content/summaryreportguestonline';
$route['datarolessthan14days'] = 'App/content/datarolessthan14days';
$route['bookingtreatment'] = 'App/content/bookingtreatment';
$route['add-booking'] = 'App/content/booking_add';
$route['summaryreportdonedeal'] = 'App/content/summaryreportdonedeal';
$route['refferal'] = 'App/content/refferal';
$route['refferal_add'] = 'App/content/refferal_add';
$route['detaildonedealdaily'] = 'App/content/detaildonedealdaily';
$route['detaildonedealdailyallclinic'] = 'App/content/detaildonedealdailyallclinic';
$route['databookingtreatment'] = 'App/content/databookingtreatment';
$route['save-note-followup-doing'] = 'App/saveNoteFollowUpDoing';
$route['save-note-followup-doing-potential'] = 'App/saveNoteFollowUpDoingPotential';
$route['save-note-followup-doing-retention'] = 'App/saveNoteFollowUpDoingRetention';
$route['save-note-followup-doing-notactive'] = 'App/saveNoteFollowUpDoingNotActive';
$route['save-note-followup-doing-potential-leaver'] = 'App/saveNoteFollowUpDoingPotentialLeaver';
$route['save-note-followup-doing-potential-notactive'] = 'App/saveNoteFollowUpDoingPotentialNotActive';
$route['save-note-followup-Missguest'] = 'App/saveNoteFollowUpMissGuest';
$route['save-note-followup-potentialnewlc'] = 'App/saveNoteFollowUpPotentialNew';
$route['datamissguest'] = 'App/content/datamissguest';
$route['datapotentialnew'] = 'App/content/datapotentialnew';
$route['reportdailyactivitynew'] = 'App/content/reportdailyactivitynew';
$route['databodrangeclinic'] = 'App/content/databodrangeclinic';
$route['save-note-followup-bod'] = 'App/saveNoteFollowUpBod';
$route['save-note-followup-customer-point'] = 'App/saveNoteFollowUpCustomerPoint';
$route['customerPoint'] = 'App/content/customerPoint';
$route['refferal_from_link'] = 'App/content/refferal_from_link';
$route['save-note-followup-refferal-from-link'] = 'App/saveNoteFollowUpRefferalFromLink';
$route['refferal_employee'] = 'App/content/refferal_employee';
$route['datarecurring'] = 'App/content/datarecurring';
$route['guestfromlink'] = 'App/content/guestfromlink';
$route['guestfromlinkemplo'] = 'App/content/guestfromlinkemplo';
$route['linkforpromo'] = 'App/content/linkforpromo';
$route['doingverification'] = 'App/content/doingverification';
$route['save-doing-treatment'] = 'App/updateDoingTreatment';
$route['update-doing-status'] = 'App/updateDoingStatus';
$route['erm'] = 'App/content/erm';
$route['erm_ref/(:any)'] = 'App/erm_ref/$1';
$route['resep_dokter/(:any)'] = 'App/resep_dokter/$1';
$route['new_menu'] = 'App/content/new_menu';
$route['new_menu_dev'] = 'App/content/new_menu_dev';
$route['data_new_menu'] = 'App/content/data_new_menu';
$route['save-note-history-doing'] = 'App/saveNoteHistoryDoing';
$route['reprint/(:any)'] = 'App/reprint/$1';
$route['getemployeedoingby'] = 'App/getEmployeeDoingBy';
$route['dataapptbycc'] = 'App/content/dataappt_bycc';
$route['reportdetailnewlc'] = 'App/content/reportdetailnewlc';
$route['reportbooking'] = 'App/content/reportbookingtreatment';
$route['reportsummaryguestappt14days'] = 'App/content/reportsummaryguestappt14days';
$route['lcwithonemembershipactive'] = 'App/content/lcwithonemembershipactive';
$route['stock'] = 'App/content/stock';
$route['redeem_voucher'] = 'App/content/redeem_voucher';
$route['callapptfd'] = 'App/content/callapptfd';
$route['datanew6month'] = 'App/content/datanew6month';
$route['call_appt_new_member_21days'] = 'App/content/call_appt_new_member_21days';
$route['call_appt_retention_21days'] = 'App/content/call_appt_retention_21days';
$route['call_appt_potential_21days'] = 'App/content/call_appt_potential_21days';
$route['call_appt_not_active_21days'] = 'App/content/call_appt_not_active_21days';
$route['call_appt_potential'] = 'App/content/call_appt_potential';
$route['call_appt_potential_notactive'] = 'App/content/call_appt_potential_notactive';
$route['savedoingtreatmentDev'] = 'App/saveDoingTreatmentDev';
$route['save-remarks-one-membership-active'] = 'App/updateRemarksOneMembershipActive';
$route['report_ingredients'] = 'App/content/report_ingredients';
$route['updateemail'] = 'App/content/updateemail';
$route['refferalsales'] = 'App/content/refferalsales';
$route['summaryfirstappt'] = 'App/content/summaryfirstappt';
$route['report_consultation_docter'] = 'App/content/report_consultation_docter';
$route['stock_weekly'] = 'App/content/stock_weekly';
$route['stock_weekly_dev'] = 'App/content/stock_weekly_dev';
$route['reportdetailnewlc'] = 'App/content/reportdetailnewlc';
$route['faktur_penjualan/(:any)/(:any)/(:any)'] = 'App/createFakturPenjualan/$1/$2/$3';
$route['qtyBotox'] = 'App/content/qtyBotox';



//MAYBE NOT USED ANYMORE UPTHERE
$route['linkDocter'] = 'App/content/linkDocter';
$route['listLinkRegistrasiConsultant'] = 'App/content/listLinkRegistrasiConsultant';
$route['callforappt'] = 'App/content/callforappt';
$route['reportAppointmentCustomerCareOnline'] = 'App/content/reportAppointmentCustomerCareOnline';
$route['dailySalesReconciliation'] = 'App/content/dailySalesReconciliation';
$route['createTransaction'] = 'App/content/createDownPayment';
$route['dailySalesReport'] = 'App/content/dailySalesReport';
$route['reportDoingCommission'] = 'App/content/reportDoingCommission';
$route['summaryRevenuePerDay'] = 'App/content/summaryRevenuePerDay';
$route['integrationLocation'] = 'App/integrationLocation';
$route['printinvoice/(:any)/(:any)'] = 'App/print_invoice/$1/$2';
$route['transactionTreatmentToday'] = 'App/content/transactionTreatmentToday';
$route['transactionTodayPaket'] = 'App/content/transactionTodayPaket';
$route['transactionTodayRetail'] = 'App/content/transactionTodayRetail';
$route['doingTodayFinish'] = 'App/content/doingTodayFinish';
$route['managementEmployee'] = 'App/content/managementEmployee';
$route['reportGuestOnlineAdmin'] = 'App/content/reportGuestOnlineAdminCso';
$route['reportGuestOnlineAdminNotShow'] = 'App/content/reportGuestOnlineAdminCsoNotShow';
$route['reportGuestCustomerServiceOnline'] = 'App/content/reportGuestCustomerServiceOnline';
$route['reportGuestCustomerServiceOnlineNotShow'] = 'App/content/reportGuestCustomerServiceOnlineNotShow';
$route['printinvoiceSummary/(:any)/(:any)'] = 'App/print_invoiceSummary/$1/$2';
$route['printinvoiceSummaryDownPayment/(:any)/(:any)'] = 'App/print_invoiceSummaryDownPayment/$1/$2';
$route['reportGuestShow'] = 'App/content/reportGuestShow';
$route['reportUsedIngridients'] = 'App/content/reportUsedIngridients';
$route['reportGuestEvent'] = 'App/content/reportGuestEvent';
$route['reportGuestEventNotShow'] = 'App/content/reportGuestEventNotShow';
$route['invoiceMembership'] = 'App/content/invoiceMembership';
$route['invoiceTreatment'] = 'App/content/invoiceTreatment';
$route['invoiceRetail'] = 'App/content/invoiceRetail';
$route['listNewCustomer'] = 'App/content/listNewCustomer';
$route['invoiceDownMembership'] = 'App/content/invoiceDownMembership';
$route['invoiceDownTreatment'] = 'App/content/invoiceDownTreatment';
$route['invoiceDownProduct'] = 'App/content/invoiceDownProduct';
$route['bookAppointment'] = 'App/content/bookAppointment';
$route['prepaidConsumption'] = 'App/prepaidConsumption';
$route['detailCustomer'] = 'App/content/detailCustomer';
$route['reportGuestMarketing'] = 'App/content/reportGuestMarketing';
$route['reportGuestAffiliate/(:any)'] = 'App/reportGuestAffiliate/$1';
$route['linkAffiliate'] = 'App/content/linkAffiliate';
$route['addAffiliate'] = 'App/content/addAffiliate';
$route['addEmployeeAppointment'] = 'App/content/addEmployeeAppointment';
$route['addEmployeeInvoice'] = 'App/content/addEmployeeInvoice';
$route['stockOut'] = 'App/content/stockOut';
$route['stockIn'] = 'App/content/stockIn';
$route['stockOutDetail'] = 'App/content/stockOutDetail';
$route['stockInDetail'] = 'App/content/stockInDetail';
$route['stockOutList'] = 'App/content/stockOutList';
$route['stockInList'] = 'App/content/stockInList';
$route['packageList'] = 'App/content/packageList';
$route['packageDetail'] = 'App/content/packageDetail';
$route['addPackage'] = 'App/content/addPackage';
$route['addRetail'] = 'App/content/addRetail';
$route['serviceList'] = 'App/content/serviceList';
$route['listPrepaidFinished'] = 'App/content/listPrepaidFinished';
$route['retailList'] = 'App/content/retailList';
$route['serviceDetail'] = 'App/content/serviceDetail';
$route['detailIngredients'] = 'App/content/detailIngredients';
$route['addService'] = 'App/content/addService';
$route['retailDetail'] = 'App/content/retailDetail';
$route['addDetail'] = 'App/content/addDetail';
$route['addIngredients'] = 'App/content/addIngredients';
$route['serviceSales'] = 'App/content/serviceSales';
$route['ingredientsList'] = 'App/content/ingredientsList';
$route['customerDetail'] = 'App/content/customerDetail';
$route['listEmployee'] = 'App/content/listEmployee';
$route['listTarget'] = 'App/content/listTarget';
$route['employeeDetail'] = 'App/content/employeeDetail';
$route['reportRevenueBySales'] = 'App/content/reportRevenueBySales';
$route['reportDoingNotInInvoiceLocation'] = 'App/content/reportDoingNotInInvoiceLocation';
$route['reportAppointmentDoingByClinic'] = 'App/content/reportAppointmentDoingByClinic';
$route['reportHandWorkCommissionDokterTherapist'] = 'App/content/reportHandWorkCommissionDokterTherapist';
$route['reportCommissionAppointmentCSO'] = 'App/content/reportCommissionAppointmentCSO';
$route['reportPrescriptionDoctor'] = 'App/content/reportPrescriptionDoctor';
$route['adjusmentTreatmentWess'] = 'App/content/adjusmentTreatmentWess';
$route['changeTreatmentMixMax'] = 'App/content/changeTreatmentMixMax';
$route['addTargetOutlet'] = 'App/content/addTargetOutlet';
$route['addTargetConsultant'] = 'App/content/addTargetConsultant';
$route['customerByLastDoing'] = 'App/content/customerByLastDoing';
$route['addInitialStock'] = 'App/content/addInitialStock';
$route['saleTicketDetail'] = 'App/content/saleTicketDetail';
$route['detailPrepaidInvoiceCustomer/(:any)'] = 'App/detailPrepaidInvoiceCustomer/$1';
$route['saleTicketList'] = 'App/content/saleTicketList';
$route['balancePrepaidWess'] = 'App/content/balancePrepaidWess';
$route['reportCommissionConsultant'] = 'App/content/reportCommissionConsultant';
$route['reportCommissionOM'] = 'App/content/reportCommissionOM';
$route['authenticationErp'] = 'App/authenticationErp';
$route['syncCogsErp'] = 'App/syncCogsErp';
$route['syncCogsErpTreatmentExcel'] = 'App/syncCogsErpTreatmentExcel';
$route['reportCustomerTrial'] = 'App/content/reportCustomerTrial';
$route['reportFilledLinkReview'] = 'App/content/reportFilledLinkReview';
$route['listLocation'] = 'App/content/listLocation';
$route['detailLocation'] = 'App/content/detailLocation';
$route['reportKPIBeautyConsultant'] = 'App/content/reportKPIBeautyConsultant';
$route['addEmployee'] = 'App/content/addEmployee';
$route['addLocation'] = 'App/content/addLocation';
$route['reportNewGuestNoAppointment'] = 'App/content/reportNewGuestNoAppointment';
$route['reportUsedIngridientsIncludeCost'] = 'App/content/reportUsedIngridientsIncludeCost';
$route['listExpend'] = 'App/content/listExpend';
$route['presensiByPhoto'] = 'App/content/presensiByPhoto';
$route['reportProfitAndLoss'] = 'App/content/reportProfitAndLoss';
$route['addConsultation'] = 'App/content/addConsultation';
$route['printConsultationResult/(:any)'] = 'App/printConsultationResult/$1';
$route['consultationHistory'] = 'App/content/consultationHistory';
$route['consultationHistories'] = 'App/consultationHistory';

// COMMISSION ROUTE
$route['reportCommissionSubscription'] = 'ControllerCommission/content/reportCommissionSubscription';
$route['reportCommissionPerInvoice'] = 'ControllerCommission/content/reportCommissionPerInvoice';


// COMPANY ROUTE
$route['listCompany'] = 'ControllerCompany/content/listCompany';
$route['listWarehouse'] = 'ControllerCompany/content/listWarehouse';
$route['listUser'] = 'ControllerCompany/content/listUser';
$route['listAccessLocationUser'] = 'ControllerCompany/content/listAccessLocationUser';
$route['listAccessCompanyUser'] = 'ControllerCompany/content/listAccessCompanyUser';
$route['listAccessWarehouseUser'] = 'ControllerCompany/content/listAccessWarehouseUser';


// ROUTE API APPS
$route['getClinic'] = 'ControllerApiApps/getClinic';
$route['getClinicTransactions'] = 'ControllerApiApps/getClinicTransactions';
$route['getServiceList'] = 'ControllerApiApps/getServiceList';
$route['getClinicById/(:any)'] = 'ControllerApiApps/getClinicById/$1';
$route['getTimeAvailable/(:any)/(:any)'] = 'ControllerApiApps/getTimeAvailable/$1/$2';
$route['getListBooking/(:any)/(:any)'] = 'ControllerApiApps/getListBooking/$1/$2';
$route['insertBookingByCustomer'] = 'ControllerApiApps/insertBookingByCustomer';
$route['insertBookingByCustomerDev'] = 'ControllerApiApps/insertBookingByCustomerDev';
$route['canceledBooking'] = 'ControllerApiApps/canceledBooking';
$route['getDetailCustomer/(:any)'] = 'ControllerApiApps/getDetailCustomer/$1';
$route['send_otp'] = 'ControllerApiApps/send_otp';
$route['send_otpRegister'] = 'ControllerApiApps/send_otpRegister';
$route['verify_otp'] = 'ControllerApiApps/verify_otp';
$route['verify_otpRegistration'] = 'ControllerApiApps/verify_otpRegistration';
$route['verify_otpRegistration2'] = 'ControllerApiApps/verify_otpRegistration2';
$route['set_pin'] = 'ControllerApiApps/set_pin';
$route['set_pinRequest'] = 'ControllerApiApps/set_pinRequest';
$route['verify_pin'] = 'ControllerApiApps/verify_pin';
$route['getDetailTransactionTreatment/(:any)'] = 'ControllerApiApps/getDetailTransactionTreatment/$1';
$route['getDetailTransactionMembership/(:any)'] = 'ControllerApiApps/getDetailTransactionMembership/$1';
$route['getMessages'] = 'ControllerApiApps/getMessages';
$route['sendMessages'] = 'ControllerApiApps/sendMessages';
$route['sendMessagesByCustomerApps'] = 'ControllerApiApps/sendMessagesByCustomerApps';
$route['detailConsultationChat'] = 'ControllerApiApps/detailConsultationChat';
$route['sendMessagesImagesByEmployee'] = 'ControllerApiApps/sendMessagesImagesByEmployee';
$route['getChatList'] = 'ControllerApiApps/getChatList';
$route['sendMessagesEmployee'] = 'ControllerApiApps/sendMessagesEmployee';
$route['save_push_token'] = 'ControllerApiApps/save_push_token';
$route['getLocationList'] = 'ControllerApiApps/getLocationList';
$route['getDetailLocation'] = 'ControllerApiApps/getDetailLocation';
$route['getDetailPointGeneral/(:any)'] = 'ControllerApiApps/getDetailPointGeneral/$1';
$route['getDetailPointMedis/(:any)'] = 'ControllerApiApps/getDetailPointMedis/$1';
$route['getDetailPointNonMedis/(:any)'] = 'ControllerApiApps/getDetailPointNonMedis/$1';
$route['getDoctorByLocationId/(:any)'] = 'ControllerApiApps/getDoctorByLocationId/$1';
$route['insertLocation'] = 'ControllerApiApps/insertLocation';
$route['getStaffByLocationId/(:any)'] = 'ControllerApiApps/getStaffByLocationId/$1';
$route['send_broadcast_notification_to_user'] = 'ControllerApiApps/send_broadcast_notification_to_user';
$route['get_user_notification/(:any)'] = 'ControllerApiApps/get_user_notification/$1';
$route['get_user_notification_not_read/(:any)'] = 'ControllerApiApps/get_user_notification_not_read/$1';
$route['update_notification_read_status'] = 'ControllerApiApps/update_notification_read_status';
$route['update_notification_deleted_status'] = 'ControllerApiApps/update_notification_deleted_status';
$route['insertPromoBroadcast'] = 'ControllerApiApps/insertPromoBroadcast';
$route['get_broadCastList'] = 'ControllerApiApps/get_broadCastList';
$route['get_broadCastListById/(:any)'] = 'ControllerApiApps/get_broadCastListById/$1';
$route['get_listTargetPromo/(:any)'] = 'ControllerApiApps/get_listTargetPromo/$1';
$route['insert_target_customer'] = 'ControllerApiApps/insert_target_customer';
$route['updatePromoBroadcast'] = 'ControllerApiApps/updatePromoBroadcast';
$route['sync'] = 'ControllerApiApps/sync';
$route['listEmployeeApps'] = 'ControllerApiApps/content/listEmployeeApps';
$route['addPromoBroadcast'] = 'ControllerApiApps/content/addPromoBroadcast';
$route['listPromoBroadcast'] = 'ControllerApiApps/content/listPromoBroadcast';
$route['detailPromoBroadcast'] = 'ControllerApiApps/content/detailPromoBroadcast';
$route['listTreatmentClaimFreeApps'] = 'ControllerApiApps/content/listTreatmentClaimFreeApps';
$route['listEventApps'] = 'ControllerApiApps/content/listEventApps';
$route['listVideoContentApps'] = 'ControllerApiApps/content/listVideoContentApps';
$route['listAdsApps'] = 'ControllerApiApps/content/listAdsApps';
$route['getListAds'] = 'ControllerApiApps/getAdsApps';
$route['getListEvent'] = 'ControllerApiApps/getEventApps';
$route['getVideoContentApps'] = 'ControllerApiApps/getVideoContentApps';
$route['insertFreeClaimInstallApps'] = 'ControllerApiApps/insertFreeClaimInstallApps';
$route['getListTreatmentClaimFreeActive'] = 'ControllerApiApps/getListTreatmentClaimFreeActive';
$route['getIsClaim/(:any)'] = 'ControllerApiApps/getIsClaim/$1';
$route['consultationList'] = 'ControllerApiApps/content/consultationList';
$route['getListOutletAccess'] = 'ControllerApiApps/getListOutletAccess';
$route['getListRefferalFriend/(:any)'] = 'ControllerApiApps/getListRefferalFriend/$1';
$route['getServiceListCustomer/(:any)'] = 'ControllerApiApps/getServiceListCustomer/$1';
$route['getTimeAvailableDuration/(:any)/(:any)/(:any)'] = 'ControllerApiApps/getTimeAvailableDuration/$1/$2/$3';
$route['listCategory'] = 'ControllerApiApps/content/listCategory';
$route['addCategoryByProductType'] = 'ControllerApiApps/content/addCategoryByProductType';
$route['listCategoryByProductType'] = 'ControllerApiApps/content/listCategoryByProductType';
$route['getListCategoryApps'] = 'ControllerApiApps/getListCategoryApps';
$route['getListCategoryByProductByIdApps/(:any)'] = 'ControllerApiApps/getListCategoryByProductByIdApps/$1';
$route['getListCategoyByProductId/(:any)/(:any)'] = 'ControllerApiApps/getListCategoyByProductId/$1/$2';
$route['getDetailTreatment/(:any)/(:any)'] = 'ControllerApiApps/getDetailTreatment/$1/$2';
$route['getCustomerCart/(:any)'] = 'ControllerApiApps/getCustomerCart/$1';
$route['insertCustomerCart'] = 'ControllerApiApps/insertCustomerCart';
$route['getCustomerCartList/(:any)/(:any)'] = 'ControllerApiApps/getCustomerCartList/$1/$2';
$route['updateQtyAndStatusCart'] = 'ControllerApiApps/updateQtyAndStatusCart';
$route['getCustomerCartOnPaymentList/(:any)/(:any)'] = 'ControllerApiApps/getCustomerCartOnPaymentList/$1/$2';
$route['getChatListCustomer'] = 'ControllerApiApps/getChatListCustomer';
$route['getConsultantRecomendation/(:any)'] = 'ControllerApiApps/getConsultantRecomendation/$1';

// hR
$route['employeeAllowanceMonthly'] = 'ControllerHr/content/employeeAllowanceMonthly';
$route['employeeDeductionMonthly'] = 'ControllerHr/content/employeeDeductionMonthly';
$route['saveAllowanceMonthly'] = 'ControllerHr/saveAllowanceMonthly';
$route['employeeSalaryMonthly'] = 'ControllerHr/content/employeeSalaryMonthly';
$route['saveDeductionMonthly'] = 'ControllerHr/saveDeductionMonthly';
$route['ControllerHr/get_allowance_data'] = 'ControllerHr/get_allowance_data';
$route['ControllerHr/get_deduction_data'] = 'ControllerHr/get_deduction_data';
$route['presensiEmployee'] = 'ControllerHr/content/presensiEmployee';
$route['summaryPresensiEmployee'] = 'ControllerHr/content/summaryPresensiEmployee';
$route['summaryPresensiEmployeeClinic'] = 'ControllerHr/content/summaryPresensiEmployeeClinic';
$route['listShift'] = 'ControllerHr/content/listShift';
$route['listLeaveType'] = 'ControllerHr/content/listLeaveType';
$route['leavePermissionRequest'] = 'ControllerHr/content/leavePermissionRequest';
$route['listAllowanceType'] = 'ControllerHr/content/listAllowanceType';
$route['listDeductionType'] = 'ControllerHr/content/listDeductionType';
$route['listJob'] = 'ControllerHr/content/listJob';
$route['publicHolidayCalender'] = 'ControllerHr/content/publicHolidayCalender';
$route['createAttandanceLogManual'] = 'ControllerHr/content/createAttandanceLogManual';

$route['listEmployeeCompany'] = 'ControllerHr/content/listEmployeeCompany';
$route['generateEmployeePayroll'] = 'ControllerHr/content/generateEmployeePayroll';
$route['approvedEmployeePayroll'] = 'ControllerHr/content/approvedEmployeePayroll';
$route['allowanceUncertain'] = 'ControllerHr/content/allowanceUncertain';
$route['deductionUncertain'] = 'ControllerHr/content/deductionUncertain';


// Route Purchase Request
$route['purchaseRequest'] = 'ControllerPurchasing/content/purchaseRequest';
$route['purchaseRequestList'] = 'ControllerPurchasing/content/purchaseRequestList';
$route['addPurchaseOrder/(:any)'] = 'ControllerPurchasing/content/addPurchaseOrder/$1';
$route['purchaseRequestLists'] = 'ControllerPurchasing/content/purchaseRequestByUser';
$route['purchaseOrderList'] = 'ControllerPurchasing/content/purchaseOrder';
$route['purchaseOrderLists'] = 'ControllerPurchasing/content/purchaseOrderByUser';
$route['deliveryOrderList'] = 'ControllerPurchasing/content/deliveryOrderList';
$route['financeApproval'] = 'ControllerPurchasing/content/financeApproval';
$route['deliveryOrderLists'] = 'ControllerPurchasing/content/deliveryOrderByUser';
$route['addPurchaseOrder'] = 'ControllerPurchasing/content/addPurchaseOrder';
$route['addPurchaseOrder/(:any)'] = 'ControllerPurchasing/content/addPurchaseOrder/$1';
$route['editPurchaseOrder/(:any)'] = 'ControllerPurchasing/content/editPurchaseOrder/$1';
$route['listSupplier'] = 'ControllerPurchasing/content/listSupplier';
$route['detailPurchaseOrder/(:any)'] = 'ControllerPurchasing/content/detailPurchaseOrder/$1';
$route['deliveryOrderList/(:any)'] = 'ControllerPurchasing/content/deliveryOrderList';
$route['purchaseOrderApproval'] = 'ControllerPurchasing/content/purchaseOrderApproval';
$route['deliveryOrderChecked/(:any)'] = 'ControllerPurchasing/content/deliveryOrderChecked/$1';
$route['deliveryOrder/(:any)'] = 'ControllerPurchasing/content/deliveryOrder/$1';
$route['generateBarcode'] = 'ControllerPurchasing/content/generateBarcode';
$route['reportOrderMonthly'] = 'ControllerPurchasing/content/reportOrderMonthly';


//payment apps
$route['api/payment/create_invoice'] = 'ControllerPaymentApps/create_invoice';
$route['api/payment/webhook'] = 'ControllerPaymentApps/webhook';
$route['api/transactions/getTransactionsCustomer'] = 'ControllerPaymentApps/getTransactionsCustomer';
$route['api/transactions/insertProductDirectBuy'] = 'ControllerPaymentApps/insertProductDirectBuy';
$route['api/transactions/getProductDirectBuy'] = 'ControllerPaymentApps/getProductDirectBuy';
$route['api/transactions/getTransactionsCustomerById/(:any)'] = 'ControllerPaymentApps/getTransactionsCustomerById/$1';
$route['api/transactions/canceledPayment'] = 'ControllerPaymentApps/canceledPayment';
$route['api/transactions/getCustomerSaldoHistory'] = 'ControllerPaymentApps/getCustomerSaldoHistory';
$route['api/transactions/getCustomerSaldo'] = 'ControllerPaymentApps/getCustomerSaldo';
$route['api/transactions/getCustomerWithdrawHistory'] = 'ControllerPaymentApps/getCustomerWithdrawHistory';

$route['api/transactions/getPaymentChannel'] = 'ControllerPaymentApps/getPaymentChannel';
$route['api/transactions/getBalanceXendit/(:any)'] = 'ControllerPaymentApps/getBalanceXendit/$1';
$route['api/transactions/getBalanceXenditMain'] = 'ControllerPaymentApps/getBalanceXenditMain';
$route['api/transactions/getListSubAccountXendit'] = 'ControllerPaymentApps/getListSubAccountXendit';
$route['api/transactions/getListSubAccountXenditById/(:any)'] = 'ControllerPaymentApps/getListSubAccountXenditById/$1';
$route['api/transactions/getTransactionXendit/(:any)'] = 'ControllerPaymentApps/getTransactionXendit/$1';
$route['api/transactions/getPayoutChannel'] = 'ControllerPaymentApps/getPayoutChannel';
$route['api/transactions/getAccountByAccountId/(:any)'] = 'ControllerPaymentApps/getAccountByAccountId/$1';
$route['api/transactions/payoutWebhook'] = 'ControllerPaymentApps/payoutWebhook/';
$route['api/transactions/saveBankAccount'] = 'ControllerPaymentApps/saveBankAccount/';
$route['api/transactions/getBankAccountByCustomerId/(:any)'] = 'ControllerPaymentApps/getBankAccountByCustomerId/$1';
$route['api/transactions/getAllBankAccount'] = 'ControllerPaymentApps/getAllBankAccount';
$route['api/transactions/getPayoutHistory/(:any)'] = 'ControllerPaymentApps/getPayoutHistory/$1';
$route['api/transactions/approvePayoutCustomer/(:any)'] = 'ControllerPaymentApps/approvePayoutCustomer/$1';
$route['api/transactions/cancelPayoutCustomer/(:any)'] = 'ControllerPaymentApps/cancelPayoutCustomer/$1';


$route['api/transactions/createPayoutCustomer'] = 'ControllerPaymentApps/createPayoutCustomer';

//finance route
$route['listSubAccountXendit'] = 'ControllerPaymentApps/content/listSubAccountXendit';
$route['payoutSubAccountXendit/(:any)'] = 'ControllerPaymentApps/content/payoutSubAccountXendit/$1';
$route['listCustomerWithdraw'] = 'ControllerPaymentApps/content/listCustomerWithdraw';


// ROUTE REPORT
$route['reportRevenueByCustomer'] = 'ControllerReport/content/reportRevenueByCustomer';
$route['reportStockOpname'] = 'ControllerReport/content/reportStockOpname';
$route['stockOpnameDetail'] = 'ControllerReport/content/stockOpnameDetail';
$route['reportTransactionsByProduct'] = 'ControllerReport/content/reportTransactionsByProduct';
$route['reportCustomerDoingAndSpending'] = 'ControllerReport/content/reportCustomerDoingAndSpending';
$route['reportLastCustomerSpendingAndPrepaidLeft'] = 'ControllerReport/content/reportLastCustomerSpendingAndPrepaidLeft';
$route['reportTransactionCustomerEventRoadshow'] = 'ControllerReport/content/reportTransactionCustomerEventRoadshow';

$route['addFacilityByLocation'] = 'ControllerReport/content/addFacilityByLocation';
$route['facilityReportList'] = 'ControllerReport/content/facilityReportList';
$route['conditionReport/(:any)'] = 'ControllerReport/content/conditionReport/$1';
$route['reportAchievementConsultant'] = 'ControllerReport/content/reportAchievementConsultant';
$route['reportInvoiceLifeTimePackage'] = 'ControllerReport/content/reportInvoiceLifeTimePackage';
$route['reportCommissionInvoiceProductTherapist'] = 'ControllerReport/content/reportCommissionInvoiceProductTherapist';



//ROUTE TEST
$route['api/payment/create_payment'] = 'ControllerPaymentApps/create_payment';

// ROUTE EMPLOYE APPS
$route['api/employee/employeeAttendances'] = 'ControllerEmployeeApps/employeeAttendances'; // post attendance
$route['api/employee/getEmployeeAttendances'] = 'ControllerEmployeeApps/getAllEmployeeAttendances'; // get attendance
$route['api/employee/getEmployeeAttendanceById'] = 'ControlllerEmployeeApps/getEmployeeAttendanceById'; // get attendance by employee account id
$route['api/employee/getEmployeeDetail/(:any)'] = 'ControllerEmployeeApps/get_employee_detail/$1'; // get attendance by employee account id
$route['api/employee/getEmployeeAttendanceByIdAndDate/(:any)/(:any)'] = 'ControllerEmployeeApps/getEmployeeAttendanceByIdAndDate/$1/$2'; // get attendance by employee account id
$route['api/employee/login'] = 'ControllerEmployeeApps/login'; // employee account login
$route['api/employee/getLocation'] = 'ControllerEmployeeApps/getPins'; // get location
$route['api/employee/getNearestLocation'] = 'ControllerEmployeeApps/getNearestLocation';


// Employee Apps Management
$route['addEmployeeAccount'] = 'ControllerEmployeeApps/content/addEmployeeAccount';
$route['employeeAttendanceList'] = 'ControllerEmployeeApps/content/employeeAttendanceList';
$route['employeeAccountList'] = 'ControllerEmployeeApps/content/employeeAccountList';
$route['employeeAttendanceHistory/(:any)'] = 'ControllerEmployeeApps/content/employeeAttendanceHistory/$1';
$route['hrSetLocationPin'] = 'ControllerEmployeeApps/content/hrSetLocationPin';
$route['getEmployeeDetail/(:any)'] = 'ControllerEmployeeApps/getEmployeeDetail/$1';

// magic login
$route['magic_login'] = 'ControllerPurchasing/magic_login';



//route finger customer
$route['api/fingerprint/register'] = 'ControllerFingerPrintCustomer/register';
$route['api/fingerprint/verify'] = 'ControllerFingerPrintCustomer/verify';
$route['api/fingerprint/log_match'] = 'ControllerFingerPrintCustomer/log_match';
$route['api/fingerprint/get_all'] = 'ControllerFingerPrintCustomer/get_all';
$route['api/fingerprint/searchCustomer'] = 'ControllerFingerPrintCustomer/searchCustomer';