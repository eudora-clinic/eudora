<style>
    #loading-indicator {
        /* position: fixed; */
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }


    .bg-thead {
        background-color: #f5e0d8 !important;
        color: #666666 !important;
        text-transform: uppercase;
        font-size: 12px;
        font-weight: 100 !important;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }

    .btn-primary {
        background-color: #e0bfb2 !important;
        color: #666666 !important;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        /* background-color: #0056b3; */
    }

    .table-wrapper {
        margin-top: 20px;
        overflow-x: auto;
    }

    th,
    td {
        text-align: center;
        vertical-align: middle;
    }

    select.form-select {
        border-radius: 8px;
        padding: 10px;
    }

    .form-control {
        border-radius: 8px;
        padding: 8px;
        font-size: 13px;
    }

    .hidden {
        display: none;
    }

    .input-group-text {
        background-color: #e9ecef;
    }


    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }

    .jumlah-input {
        text-align: center;
    }

    .remove-btn {
        color: #fff !important;
        background-color: #dc3545 !important;
        border: none;
        transition: 0.3s ease;
    }

    .remove-btn:hover {
        background-color: #c82333 !important;
        box-shadow: 0px 2px 6px rgba(220, 53, 69, 0.5);
    }

    .use-btn {
        color: #fff;
        /* background-color: #007bff; */
        border: none;
        transition: 0.3s ease;
    }

    .use-btn:hover {
        /* background-color: #0056b3; */
        box-shadow: 0px 2px 6px rgba(0, 123, 255, 0.5);
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 1rem;
        color: #333;
        text-transform: uppercase;
    }

    /* Menambahkan efek fokus pada input dan dropdown */
    input[type="text"]:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Styling untuk dropdown */
    select {
        background-color: #f9f9f9;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    select:hover {
        background-color: #f1f1f1;
    }

    /* Styling untuk option dalam dropdown */
    option {
        padding: 10px;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-column {
        flex: 1;
        min-width: 250px;
        /* Atur ukuran minimal kolom */
        box-sizing: border-box;
    }

    .mycontaine {
        font-size: 12px !important;
    }

    /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
    .mycontaine * {
        font-size: inherit !important;
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


    @media (min-width: 992px) {
        .mycontainer {
            width: 108.5vw;
            transform: scale(0.90);
        }

    }
</style>

<?php

$db_oriskin = $this->load->database('oriskin', true);


$searchCustomer = $this->input->get('searchString');

$talent_list = [];

if ($searchCustomer != "") {
    $talent_list = $db_oriskin->query("Exec spClinicFindCustomer '" . $searchCustomer . "' ")->result_array();
}

$paymentOptions = "";
foreach ($payment_list as $payment) {
    $paymentOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$cardOptions = "";
foreach ($card_list as $payment) {
    $cardOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$bankOptions = "";
foreach ($bank_list as $payment) {
    $bankOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$intallmentOptions = "";
foreach ($installment_list as $payment) {
    $intallmentOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$edcOptions = "";
foreach ($edc_list as $payment) {
    $edcOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$discOptions = "";
foreach ($discount_reason_list as $payment) {
    $discOptions .= "<option value='{$payment['id']}'>{$payment['name']}</option>";
}

$input = $this->session->flashdata('input');
$error = $this->session->flashdata('error');
$success = $this->session->flashdata('success');
?>


<div class="mycontaine">
    <div>
        <div class="row" style="justify-content: space-around;">
            <div class="card p-2 col-md-6">
                <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                    <div class="row g-3" style="display: flex; align-items: center;">
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" class="form-control text-uppercase" name="searchString"
                                    id="searchString" placeholder="Name / HP / SSID / Customer Code / Member Code"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn w-100 btn-primary" id="buttonSearch">Search</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card p-2 col-md-2">
                <div class="">
                    <select id="paymentType" name="paymentType" class="form-select text-center" required
                        onchange="changeSPPayment(this.value)" style="font-size: 14px !important; font-weight: 500;">
                        <!-- <option value="0">PAYMENT TYPE</option> -->
                        <option value="1">FULL PAYMENT</option>
                        <option value="2">DOWN PAYMENT</option>
                        <option value="3">SETTLEMENT DP</option>
                    </select>
                </div>
            </div>
            <!-- Transaction Type -->
            <div class="card p-2 col-md-3">
                <div class="">
                    <select id="transactionType" name="transactionType" class="form-select text-center" required
                        onchange="changeSPJob(this.value)" style="font-size: 14px !important; font-weight: 500;">
                        <option value="0">TRANSACTION TYPE</option>
                        <option value="1">TREATMENT</option>
                        <option value="2">MEMBERSHIP</option>
                        <option value="3">PRODUCT</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div id="customerInformation">
            <div class="table-wrapper card p-4">
                <table id="existingcustomer" class="table table-striped table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>
                            <th style="text-align: center">CUSTOMER CODE</th>
                            <th style="text-align: center">Origin</th>
                            <th style="text-align: center">HP</th>
                            <th style="text-align: center">Privilege</th>
                            <th style="text-align: center">Point</th>
                            <th style="text-align: center">Point Medis</th>
                            <th style="text-align: center">Point Non Medis</th>
                            <th style="text-align: center">Dashboard</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($talent_list as $row) { ?>
                            <tr>
                                <td><?= $row['IDFROMDB'] ?></td>
                                <td><?= $row['FIRSTNAME'] ?></td>
                                <td><?= $row['LASTNAME'] ?></td>
                                <td><?= $row['CUSTOMERCODE'] ?></td>
                                <td><?= $row['ORIGINCUSTOMER'] ?></td>
                                <td><?= $row['CELLPHONE'] ?></td>
                                <td><?= $row['PRIVILEGE'] ?></td>
                                <td><?= number_format($row['TOTALPOINT'], 0, ',', ',') ?></td>
                                <td><?= number_format($row['POINTMEDIS'], 0, ',', ',') ?></td>
                                <td><?= number_format($row['POINTNONMEDIS'], 0, ',', ',') ?></td>
                                <td><button class="copy-btn-refferal"
                                        data-text="https://sys.eudoraclinic.com:84/customer/dashboard/<?= $row['IDFROMDB'] ?>">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm use-btn-customer"
                                        style="background-color: #e0bfb2; color: black;">TRANSACTION</button>
                                    <a target="_blank" class="btn btn-primary btn-sm"
                                        href="https://sys.eudoraclinic.com:84/app/detailPrepaidInvoiceCustomer/<?= $row['IDFROMDB'] ?>">DETAIL</a>
                                    <button class="btn-primary btn btn-sm"
                                        onclick="goToDetail(<?= $row['IDFROMDB'] ?>)">UPDATE</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- customer if settlement down payment -->
        <div id="settlementDownPaymentTreatment" class="hidden">
            <div class="table-wrapper card p-4">
                <table id="existingCustomerDownPaymentTreatment" class="table table-striped table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">DP No</th>
                            <th style="text-align: center">DP Date</th>
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>

                            <th style="text-align: center">Amount Total</th>
                            <th style="text-align: center">Amount Dp</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($treatmentDp_list as $row) { ?>
                            <tr>
                                <td><?= $row['ID'] ?></td>
                                <td><?= $row['DPNO'] ?></td>
                                <td><?= $row['DPDATE'] ?></td>
                                <td><?= $row['FIRSTNAME'] ?></td>
                                <td><?= $row['LASTNAME'] ?></td>
                                <td><?= number_format($row['TOTALAMOUNT'], 0, ',', ',') ?></td>
                                <td><?= number_format($row['AMOUNT'], 0, ',', ',') ?></td>

                                <td>
                                    <button class="btn btn-primary btn-sm use-btn-settlementRetail"
                                        style="background-color: #e0bfb2; color: black;" data-id="<?= $row['ID'] ?>"
                                        data-prev="1">USE</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="settlementDownPaymentMembership" class="hidden">
            <div class="table-wrapper card p-4">
                <table id="existingCustomerDownPaymentMembership" class="table table-striped table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">DP No</th>
                            <th style="text-align: center">DP Date</th>
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>

                            <th style="text-align: center">Amount Total</th>
                            <th style="text-align: center">Amount Dp</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membershipDp_list as $row) { ?>
                            <tr>
                                <td><?= $row['ID'] ?></td>
                                <td><?= $row['DPNO'] ?></td>
                                <td><?= $row['DPDATE'] ?></td>
                                <td><?= $row['FIRSTNAME'] ?></td>
                                <td><?= $row['LASTNAME'] ?></td>
                                <td><?= number_format($row['TOTALAMOUNT'], 0, ',', ',') ?></td>
                                <td><?= number_format($row['AMOUNT'], 0, ',', ',') ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm use-btn-settlementRetail"
                                        style="background-color: #e0bfb2; color: black;" data-id="<?= $row['ID'] ?>"
                                        data-prev="2">USE</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="settlementDownPaymentRetail" class="hidden">
            <div class="table-wrapper card p-4">
                <table id="existingCustomerDownPaymentRetail" class="table table-striped table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">DP No</th>
                            <th style="text-align: center">DP Date</th>
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>

                            <th style="text-align: center">Amount Total</th>
                            <th style="text-align: center">Amount Dp</th>
                            <th style="text-align: center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($retailDp_list as $row) { ?>
                            <tr>
                                <td><?= $row['ID'] ?></td>
                                <td><?= $row['DPNO'] ?></td>
                                <td><?= $row['DPDATE'] ?></td>
                                <td><?= $row['FIRSTNAME'] ?></td>
                                <td><?= $row['LASTNAME'] ?></td>
                                <td><?= number_format($row['TOTALAMOUNT'], 0, ',', ',') ?></td>
                                <td><?= number_format($row['AMOUNT'], 0, ',', ',') ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm use-btn-settlementRetail"
                                        style="background-color: #e0bfb2; color: black;" data-id="<?= $row['ID'] ?>"
                                        data-prev="3">USE</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end customer if settlement down payment -->

        <!-- INVOICE HEADER -->
        <input type="text" name="customer-point" id="customer-point" hidden>
        <input type="text" name="customer-pointmedis" id="customer-pointmedis" hidden>
        <input type="text" name="customer-pointnonmedis" id="customer-pointnonmedis" hidden>

        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                    <i class="bi bi-wallet2"></i> Invoice Treatment Header
                </h6>
                <div class="form-row">
                    <!-- Kolom Kiri (3 elemen) -->
                    <div class="form-column">
                        <label for="customer-name-treatment" class="form-label mt-2"><strong>Customer
                                Name</strong></label>
                        <input type="text" name="customer-name-treatment" id="customer-name-treatment" disabled>
                        <input type="text" name="customer-id-treatment" id="customer-id-treatment" hidden>
                        <input type="text" name="downpayment-id-treatment" id="downpayment-id-treatment" hidden>

                        <div>
                            <label for="doctor-treatment" class="form-label mt-2"><strong>PRECEPTION
                                    BY:</strong></label>
                            <select id="doctor-treatment" name="doctor-treatment" class="" required="true"
                                aria-required="true">
                                <option value="">SELECT A DOCTER:</option>
                                <?php foreach ($doctor_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['doctor-treatment']) && $input['doctor-treatment'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan (2 elemen) -->
                    <div class="form-column">
                        <div hidden>
                            <label for="assistenid-treatment"
                                class="form-label mt-2"><strong>BEAUTICIAN:</strong></label>
                            <select id="assistenid-treatment" name="assistenid-treatment" class="" required="true"
                                aria-required="true">
                                <option value="">Select a Beautician</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['assistenid-treatment']) && $input['assistenid-treatment'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <label for="frontdeskid-treatment" class="form-label mt-2"><strong>CSO:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select id="frontdeskid-treatment" name="frontdeskid-treatment" class="" required="true"
                            aria-required="true">
                            <option value="">SELECT A CSO</option>
                            <?php foreach ($frontdesk_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['frontdeskid-treatment']) && $input['frontdeskid-treatment'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-column">
                        <label for="consultanid-treatment" class="form-label mt-2"><strong>CONSULTANT:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select style="text-transform: uppercase;" id="consultanid-treatment"
                            name="consultanid-treatment" class="" required="true" aria-required="true">
                            <option value="">Select a Consultant</option>
                            <?php foreach ($consultant_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['consultanid-treatment']) && $input['consultanid-treatment'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <div hidden>
                            <label for="bcid-treatment" class="form-label mt-2"><strong>BEAUTY
                                    CONSULTANT:</strong></label>
                            <select id="bcid-treatment" name="bcid-treatment" class="" required="true"
                                aria-required="true">
                                <option value="">Select a Beauty Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['bcid-treatment']) && $input['bcid-treatment'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden mt-2" id="role-information-membership">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                    <i class="bi bi-wallet2"></i> Invoice Membership Header
                </h6>

                <div class="form-row">
                    <!-- Kolom Kiri (3 elemen) -->
                    <div class="form-column">
                        <label for="customer-name-membership" class="form-label mt-2"><strong>Customer
                                Name</strong></label>
                        <input type="text" name="customer-name-membership" id="customer-name-membership" disabled>
                        <input type="text" name="customer-id-membership" id="customer-id-membership" hidden>
                        <input type="text" name="downpayment-id-membership" id="downpayment-id-membership" hidden>

                        <div>
                            <label for="doctor-membership" class="form-label mt-2 "><strong>PRECEPTION
                                    BY:</strong></label>
                            <select style="text-transform: uppercase;" id="doctor-membership" name="doctor-membership"
                                class="" required="true" aria-required="true">
                                <option value="">Select a Docter</option>
                                <?php foreach ($doctor_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['doctor-membership']) && $input['doctor-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Kolom Kanan (2 elemen) -->
                    <div class="form-column">
                        <div hidden>
                            <label for="assistandbybeautician-membership"
                                class="form-label mt-2 "><strong>BEAUTICIAN:</strong></label>
                            <select id="assistandbybeautician-membership" name="assistandbybeautician-membership"
                                class="" required="true" aria-required="true">
                                <option value="">Select a Beautician</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['assistandbybeautician-membership']) && $input['assistandbybeautician-membership'] == $j['id'] ? 'selected' : '') ?>>
                                        <?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>


                        <label for="frontdeskid-membership" class="form-label mt-2"><strong>CSO:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select id="frontdeskid-membership" name="frontdeskid-membership" class="" required="true"
                            aria-required="true">
                            <option value="">SELECT A CSO</option>
                            <?php foreach ($frontdesk_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['frontdeskid-membership']) && $input['frontdeskid-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <label for="saleslocation-membership" class="form-label mt-2 hidden"><strong>Sales
                                Location:</strong></label>
                        <select id="saleslocation-membership" name="saleslocation-membership" class=" hidden"
                            required="true" aria-required="true">
                            <option value="">Sales Location</option>
                            <?php foreach ($location_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['saleslocation-membership']) && $input['saleslocation-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-column">
                        <label for="activatedlocation-membership" class="form-label mt-2 hidden"><strong>Activated
                                Location:</strong></label>
                        <select id="activatedlocation-membership" name="activatedlocation-membership" class="hidden"
                            required="true" aria-required="true">
                            <option value="">Select For Activated Location</option>
                            <?php foreach ($location_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['activatedlocation-membership']) && $input['activatedlocation-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>


                        <label for="assistent-docter-membership"
                            class="form-label mt-2"><strong>CONSULTANT:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select id="assistent-docter-membership" name="assistent-docter-membership" class=""
                            required="true" aria-required="true">
                            <option value="">SELECT A CONSULTANT</option>
                            <?php foreach ($consultant_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['assistent-docter-membership']) && $input['assistent-docter-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <div hidden>
                            <label for="docter-membership" class="form-label mt-2 "><strong>BEAUTY
                                    CONSULTANT:</strong></label>
                            <select style="text-transform: uppercase;" id="docter-membership" name="docter-membership"
                                class="" required="true" aria-required="true">
                                <option value="">Select a Beauty Consultant</option>
                                <?php foreach ($doctor_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['docter-membership']) && $input['docter-membership'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <button id="buttonListMembership" type="button" class="btn btn-primary btn-sm"
                style="background-color: #c49e8f; color: black;" data-toggle="modal" data-target="#listMembershipModal">
                Add New Membership
            </button>
        </div>

        <div class="hidden mt-2" id="role-information-retail">
            <div class="card p-4">
                <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                    <i class="bi bi-wallet2"></i> Invoice Retail Header
                </h6>
                <div class="form-row">
                    <!-- Kolom Kiri (3 elemen) -->
                    <div class="form-column">
                        <label for="customer-name-retail" class="form-label mt-2"><strong>Customer Name</strong></label>
                        <input type="text" name="customer-name-retail" id="customer-name-retail" disabled>
                        <input type="text" name="customer-id-retail" id="customer-id-retail" hidden>
                        <input type="text" name="downpayment-id-retail" id="downpayment-id-retail" hidden>

                        <label for="consultanid-retail" class="form-label mt-2"><strong>CONSULTANT:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select style="text-transform: uppercase;" id="consultanid-retail" name="consultanid-retail"
                            class="" required="true" aria-required="true">
                            <option value="">Select A Consultant:</option>
                            <?php foreach ($consultant_list_retail as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['consultanid-retail']) && $input['consultanid-retail'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Kolom Kanan (2 elemen) -->
                    <div class="form-column">
                        <label for="prescriptionid-retail" class="form-label mt-2"><strong>PRESCIPTION
                                BY:</strong></label>
                        <select id="prescriptionid-retail" name="prescriptionid-retail" class="" required="true"
                            aria-required="true">
                            <option value="">SELECT A DOCTER</option>
                            <?php foreach ($doctor_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['prescriptionid-retail']) && $input['prescriptionid-retail'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        <div hidden>
                            <label for="bcid-retail" class="form-label mt-2"><strong>BEAUTY CONSULTANT:</strong></label>
                            <select id="bcid-retail" name="bcid-retail" class="" required="true" aria-required="true">
                                <option value="">Select A Beauty Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['bcid-retail']) && $input['bcid-retail'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-column">
                        <label for="frontdeskid-retail" class="form-label mt-2"><strong>CSO:</strong><span
                                class="text-danger">*Wajib*</span></label>
                        <select id="frontdeskid-retail" name="frontdeskid-retail" class="" required="true"
                            aria-required="true">
                            <option value="">SELECT A CSO</option>
                            <?php foreach ($frontdesk_list as $j) { ?>
                                <option value="<?= $j['id'] ?>" <?= (isset($input['frontdeskid-retail']) && $input['frontdeskid-retail'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- END INVOICE HEADER -->
        <div class="hidden mt-2" id="role-treatment">
            <div class="card">
                <h5 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold;">
                    <i class="bi bi-wallet2"></i> LIST TREATMENT
                </h5>
                <div class="table-wrapper p-4 card">
                    <table id="listproduct" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Price</th>
                                <th style="text-align: center;" hidden></th>
                                <th style="text-align: center;" hidden></th>
                                <th style="text-align: center;">Category</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product_treatment_list as $row) { ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['code'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= number_format($row['price'], 0, ',', ',') ?></td>
                                    <td hidden><?= $row['pointsection'] ?></td>
                                    <td hidden><?= $row['iscanfree'] ?></td>
                                    <td><?= ($row['pointsection'] == 1) ? 'MEDIS' : (($row['pointsection'] == 2) ? 'NON MEDIS' : 'NOT') ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm use-btn">USE</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="hidden mt-2" id="role-product">
            <div class="card">
                <h5 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold;">
                    <i class="bi bi-wallet2"></i> LIST PRODUK RETAIL
                </h5>
                <div class="table-wrapper card p-4">
                    <table id="listproductretail" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Price</th>
                                <th style="text-align: center;">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($product_retail_list as $row) { ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['code'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= number_format($row['price1'], 0, ',', ',') ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm use-btn-retail">USE</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END PILIHAN TREATMENT/RETAIL/MEMBERSHIP -->

        <div>
            <div class="table-wrapper card p-4 mb-4 hidden" id='role-choice-product'>
                <table id="selectedProducts" class="table table-striped table-bordered">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center;">ID</th>
                            <th style="text-align: center;">Code</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Price</th>
                            <th style="text-align: center;">Jumlah</th>
                            <th style="text-align: center;">Disc (%)</th>
                            <th style="text-align: center;">Disc (Rp)</th>
                            <th style="text-align: center;">Disc Reason </th>
                            <th style="text-align: center;">Remarks</th>
                            <th style="text-align: center;">Total Disc</th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: center;">Act</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>


                <div class="payment-methods-retail mt-2">
                    <h6 class="text-secondary mb-2 mt-2">
                        <i class="bi bi-wallet2"></i> Metode Pembayaran
                    </h6>
                    <table class="table table-bordered payment-method-list-retail">
                        <thead class="bg-thead">
                            <tr>
                                <th>Metode</th>
                                <th>EDC</th>
                                <th>Card Type</th>
                                <th>Bank Name</th>
                                <th>Installment</th>
                                <th>Amount</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data metode pembayaran akan ditambahkan di sini -->
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm add-payment-method-retail" style="display: none;">
                        <i class="bi bi-plus-circle"></i> Tambah Metode Pembayaran
                    </button>
                </div>
            </div>

            <div id="productTablesContainer" class="mt-2">
                <!-- Tabel dinamis akan ditambahkan di sini -->
            </div>

            <div id="membershipTablesContainer" class="mt-2">
                <!-- Tabel dinamis akan ditambahkan di sini -->
            </div>
        </div>

        <div>
            <div class="table-wrapper card p-4 mb-4 hidden" id='role-choice-forSettlement'>
                <div id="settlementDpForRetail" class="hidden">
                    <h6 class="text-secondary mb-2 mt-2">
                        <i class="bi bi-wallet2"></i> LIST PEMBELIAN PRODUCT
                    </h6>
                    <table id="selectedRetailSettlement" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Price</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th style="text-align: center;">Disc (%)</th>
                                <th style="text-align: center;">Disc (Rp)</th>
                                <th style="text-align: center;">Disc Reason </th>
                                <th style="text-align: center;">Remarks</th>
                                <th style="text-align: center;">Total Disc</th>
                                <th style="text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="10" style="text-align: right; font-weight: bold;">Grand Total:</td>
                                <td id="grandTotalRetailSettlement">0</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="payment-methods-retailSettlement mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> DETAIL DOWN PAYMENT
                        </h6>
                        <table class="table table-bordered payment-method-list-retailSettlement"
                            id="payment-method-list-retailSettlement">
                            <thead class="bg-thead">
                                <tr>
                                    <th>Metode</th>
                                    <th>EDC</th>
                                    <th>Card Type</th>
                                    <th>Bank Name</th>
                                    <th>Installment</th>
                                    <th>Amount</th>
                                    <th>Total Remain</th>
                                    <th class="hidden">EDCID</th>
                                    <th class="hidden">CARDID</th>
                                    <th class="hidden">BANKID</th>
                                    <th class="hidden">INSTID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data metode pembayaran akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="settlementDpForTreatment" class="hidden treatment-table-wrapper-settlement">
                    <h6 class="text-secondary mb-2 mt-2">
                        <i class="bi bi-wallet2"></i> LIST PEMBELIAN TREATMENT
                    </h6>
                    <table id="selectedTreatmentSettlement" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Code</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Price</th>
                                <th style="text-align: center;">Jumlah</th>
                                <th style="text-align: center;">Disc (%)</th>
                                <th style="text-align: center;">Disc (Rp)</th>
                                <th style="text-align: center;">Disc Reason </th>
                                <th style="text-align: center;">Remarks </th>
                                <th style="text-align: center;">Total Disc</th>
                                <th style="text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="10" style="text-align: right; font-weight: bold;">Grand Total:</td>
                                <td id="grandTotalTreatmentSettlement">0</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="payment-methods-treatmentSettlement mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> DETAIL DOWN PAYMENT
                        </h6>
                        <table class="table table-bordered payment-method-list-treatmentSettlement"
                            id="payment-method-list-treatmentSettlement">
                            <thead class="bg-thead">
                                <tr>
                                    <th>Metode</th>
                                    <th>EDC</th>
                                    <th>Card Type</th>
                                    <th>Bank Name</th>
                                    <th>Installment</th>
                                    <th>Amount</th>
                                    <th>Total Remain</th>
                                    <th class="hidden">EDCID</th>
                                    <th class="hidden">CARDID</th>
                                    <th class="hidden">BANKID</th>
                                    <th class="hidden">INSTID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data metode pembayaran akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="settlementDpForMembership" class="hidden membership-table-wrapper-settlement">
                    <h6 class="text-secondary mb-2 mt-2">
                        <i class="bi bi-wallet2"></i> LIST PEMBELIAN MEMBERSHIP
                    </h6>
                    <table id="selectedMembershipSettlement" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center;">ID</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">REMARKS </th>
                                <th style="text-align: center;">TM</th>
                                <th style="text-align: center;">TOTAL</th>

                                <th style="text-align: center;" class="hidden">SM</th>
                                <th style="text-align: center;" class="hidden">BM</th>
                                <th style="text-align: center;" class="hidden">ADMIN</th>
                                <th style="text-align: center;" class="hidden">TERMPRICE</th>
                                <th style="text-align: center;" class="hidden">MONTHLYFEE</th>
                                <th style="text-align: center;" class="hidden">FIRSTMONTHFEE</th>
                                <th style="text-align: center;" class="hidden">LASTMONTHFEE</th>

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align: right; font-weight: bold;">Grand Total:</td>
                                <td id="grandTotalMembershipSettlement">0</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="payment-methods-membershipSettlement mt-2">
                        <h6 class="text-secondary mb-2 mt-2">
                            <i class="bi bi-wallet2"></i> DETAIL DOWN PAYMENT
                        </h6>
                        <table class="table table-bordered payment-method-list-membershipSettlement"
                            id="payment-method-list-membershipSettlement">
                            <thead class="bg-thead">
                                <tr>
                                    <th>Metode</th>
                                    <th>EDC</th>
                                    <th>Card Type</th>
                                    <th>Bank Name</th>
                                    <th>Installment</th>
                                    <th>Amount</th>
                                    <th>Total Remain</th>
                                    <th class="hidden">EDCID</th>
                                    <th class="hidden">CARDID</th>
                                    <th class="hidden">BANKID</th>
                                    <th class="hidden">INSTID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data metode pembayaran akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="payment-methods-retailSettlementPelunasan mt-2 hidden"
                    id="payment-methods-retailSettlementPelunasan">
                    <h6 class="text-secondary mb-2 mt-2">
                        <i class="bi bi-wallet2"></i> METODE PELUNASAN
                    </h6>
                    <table class="table table-bordered payment-method-list-retailSettlementPelunasan"
                        id="payment-method-list-retailSettlementPelunasan">
                        <thead class="bg-thead">
                            <tr>
                                <th>Metode</th>
                                <th>EDC</th>
                                <th>Card Type</th>
                                <th>Bank Name</th>
                                <th>Installment</th>
                                <th>Amount</th>
                                <th>Act</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data metode pembayaran akan ditambahkan di sini -->
                        </tbody>
                    </table>
                    <button class="btn btn-primary btn-sm add-payment-method-retailSettlementPelunasan">
                        <i class="bi bi-plus-circle"></i> Tambah Metode Pembayaran
                    </button>
                </div>
            </div>
        </div>

    </div>
    <button type="button" class="btn btn-primary mb-4" onclick="saveTransaction()"
        style="background-color: #c49e8f; color: black;">Save Transaction</button>
</div>

<!-- Modal New Customer -->
<div class="modal fade modal-transparent" id="newCustomerModal" tabindex="-1" role="dialog"
    aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog" style="margin: auto; ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">Registrasi Guest Eudora</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div id="alert-container"></div>

                            <form id="form-add-employee" action="<?= base_url() . 'App/insertTalent' ?>">
                                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                                <input type="hidden" name="id_ref" value="<?= $id_ref ?>" />

                                <div class="card p-4">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Depan <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="firstname" name="firstname" class="form-control"
                                                value="<?= $input['firstname'] ?? '' ?>" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Nama Belakang <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="lastname" name="lastname" class="form-control"
                                                value="<?= $input['lastname'] ?? '' ?>" required>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor WA <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" id="cellphonenumber" name="cellphonenumber"
                                                class="form-control" value="<?= $input['cellphonenumber'] ?? '' ?>"
                                                required>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor ID/KTP</label>
                                            <input type="number" id="ssid" name="ssid" class="form-control"
                                                value="<?= $input['ssid'] ?? '' ?>">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="<?= $input['email'] ?? '' ?>">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" id="dateofbirth" name="dateofbirth" class="form-control"
                                                value="<?= $input['dateofbirth'] ?? '' ?>">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Jenis Kelamin <span
                                                    class="text-danger">*</span></label>
                                            <select style="font-size: 12px !important;" id="sex" name="sex"
                                                class="form-select" required>
                                                <option value="F">FEMALE</option>
                                                <option value="M">MALE</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Informasi Tentang Eudora <span
                                                    class="text-danger">*</span></label>
                                            <select style="font-size: 12px !important;" id="guestlogadvtrackingid"
                                                name="guestlogadvtrackingid" class="form-select" required>
                                                <option value="7">--Pilih adv--</option>
                                                <?php foreach ($adv_list as $j) { ?>
                                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>>
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" id="guestlogtypeid" name="guestlogtypeid" value="11">
                                    <input type="hidden" id="consultantid" name="consultantid" value="6038">
                                    <input type="hidden" id="touredid" name="touredid" value="6038">
                                    <input type="hidden" id="updateuserid" name="updateuserid" value="1">

                                    <div>
                                        <button type="submit" id="btn-simpan" class="btn btn-primary btn-sm">
                                            SUBMIT
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Registrasi Berhasil -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">Registrasi Berhasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success" style="font-size: 50px;"></i>
                <p class="mt-3">Registrasi customer telah berhasil!.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-transparent" id="listMembershipModal" tabindex="-1" role="dialog"
    aria-labelledby="newCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog" style="margin: auto; ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">LIST MEMBERSHIP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="hidden" id="role-container">
                    <div class="card">
                        <div class="table-wrapper p-2">
                            <table id="existingproduct" class="table table-striped table-bordered">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;" class="hidden">SM</th>
                                        <th style="text-align: center;" class="hidden">BM</th>
                                        <th style="text-align: center;">TM</th>
                                        <th style="text-align: center;" class="hidden">Admin</th>
                                        <th style="text-align: center;" class="hidden">Term</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;" class="hidden">Monthly</th>
                                        <th style="text-align: center;" class="hidden">1st Month</th>
                                        <th style="text-align: center;" class="hidden">Last Month</th>
                                        <th style="text-align: center;" class="hidden"></th>
                                        <th style="text-align: center;">Category</th>
                                        <th style="text-align: center;">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($product_membership_list as $row) { ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td class="hidden"><?= $row['subscriptionmonth'] ?></td>
                                            <td class="hidden"><?= $row['bonusmonth'] ?></td>
                                            <td><?= $row['totalmonth'] ?></td>
                                            <td class="hidden"><?= $row['registrationfee'] ?></td>
                                            <td class="hidden"><?= $row['termprice'] ?></td>
                                            <td><?= number_format($row['totalprice'], 0, ',', ',') ?></td>
                                            <td class="hidden"><?= $row['monthlyfee'] ?></td>
                                            <td class="hidden"><?= $row['firstmonthfee'] ?></td>
                                            <td class="hidden"><?= $row['lastmonthfee'] ?></td>
                                            <td class="hidden"><?= $row['pointsection'] ?></td>
                                            <td><?= ($row['pointsection'] == 1) ? 'MEDIS' : (($row['pointsection'] == 2) ? 'NON MEDIS' : 'NOT') ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm use-btn-membership"
                                                    data-dismiss="modal">USE</button>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-transparent" id="detailPaket" tabindex="-1" role="dialog"
    aria-labelledby="detailPaketLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="dialog" style="margin: auto; ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newCustomerModalLabel">DETAIL PAKET</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                <div class="" id="role-container">
                    <div class="card">
                        <div class="table-wrapper p-2">
                            <table id="tbl-detailpaket" class="table table-striped table-bordered">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">TREATMENT</th>
                                        <th style="text-align: center;">TREATMENT PER QTY</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- end row -->
            </div>
        </div>
    </div>
</div>


</div>


<!-- untuk table dan jenis transaksi -->
<script>
    $(document).ready(function () {
        let table = $('#existingcustomer').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 10, 15, 20, 25],
            select: true,
            "bAutoWidth": false,
            "dom": '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip', // Posisi tombol di kiri dan search di kanan
            "buttons": [<?php if ($level != 11): ?> {
                    text: 'New Customer',
                    className: 'btn btn-primary btn-sm',
                    action: function () {
                        $('#newCustomerModal').modal('show');
                    }
                }
                <?php endif; ?>
            ]
        });

        // Pastikan tombol muncul di bagian wrapper DataTable
        table.buttons().container().appendTo('#existingcustomer_wrapper .col-sm-6:eq(0)');

        $('#existingCustomerDownPayment').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 10, 15, 20, 25],
            select: true,
            'bAutoWidth': false,

        });

        $('#existingproduct').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,
            "info": false,
        });

        $('#listproduct').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,

        });


        $('#listproductretail').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,
        });

        $('#existingCustomerDownPaymentTreatment').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,

        });

        $('#existingCustomerDownPaymentMembership').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,

        });


        $('#existingCustomerDownPaymentRetail').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,
        });
    });
</script>

<script>
    $('#existingcustomer').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#existingCustomerDownPayment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#existingproduct').removeClass('display').addClass(
        'table table-striped table-hover table-compact');


    $('#listproduct').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#listproductretail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#existingCustomerDownPaymentTreatment').removeClass('display').addClass(
        'table table-striped table-hover table-compact');


    $('#existingCustomerDownPaymentMembership').removeClass('display').addClass(
        'table table-striped table-hover table-compact');

    $('#existingCustomerDownPaymentRetail').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

<!-- untuk tombol use di treatment -->
<script>
    var locationIdInvoice = '<?= $location_id ?>';

    document.addEventListener("DOMContentLoaded", function () {
        let globalPointCustomer = 0;
        let globalPointMedis = 0;
        let globalPointNonMedis = 0;

        document.querySelectorAll('.use-btn-customer').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr'); // Mengambil baris yang berisi tombol yang diklik
                const customerName = row.cells[1].textContent + " " + row.cells[2].textContent; // Mengambil First Name + Last Name
                const customerId = row.cells[0].textContent; // Mengambil ID

                const pointCustomer = row.cells[7].textContent.replace(/,/g, '');
                const pointMedis = row.cells[8].textContent.replace(/,/g, '');
                const pointNonMedis = row.cells[9].textContent.replace(/,/g, '');

                const globalPointCustomer = parseInt(pointCustomer, 10);
                const globalPointMedis = parseInt(pointCustomer, 10);
                const globalPointNonMedis = parseInt(pointCustomer, 10);

                // Mengisi input dengan ID dan nama customer
                document.getElementById('customer-point').value = pointCustomer;
                document.getElementById('customer-pointmedis').value = pointMedis;
                document.getElementById('customer-pointnonmedis').value = pointNonMedis;

                document.getElementById('customer-name-treatment').value = customerName;
                document.getElementById('customer-id-treatment').value = customerId;


                document.getElementById('customer-name-retail').value = customerName;
                document.getElementById('customer-id-retail').value = customerId;

                document.getElementById('customer-name-membership').value = customerName;
                document.getElementById('customer-id-membership').value = customerId;
            });
        });



        //FOR TREATMENTS
        let usedProductIds = [];

        const buttons = document.querySelectorAll(".use-btn");
        buttons.forEach((button) => {
            button.addEventListener("click", function () {
                const row = this.closest("tr");
                const data = {
                    id: row.cells[0].innerText.trim(),
                    code: row.cells[1].innerText.trim(),
                    name: row.cells[2].innerText.trim(),
                    price: parseInt(row.cells[3].innerText.trim().replace(/,/g, ''), 10),
                    pointsection: row.cells[4].innerText.trim(),
                    iscanfree: row.cells[5].innerText.trim()
                };

                console.log(data);


                if (usedProductIds.includes(data.id)) {
                    alert("This product has already been used!");
                    return;
                }

                usedProductIds.push(data.id);

                const newTableHtml = `
                    <div class="table-wrapper product-table-wrapper card" data-id="${data.id}" data-pointsection="${data.pointsection}" data-iscanfree="${data.iscanfree}">
                        <div class="p-4">
                            <h6 class="text-secondary mb-2 mt-2">
                                <i class="bi bi-wallet2"></i> Treatment Dipilih
                            </h6>
                            <table class="table table-striped table-bordered">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Code</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Price</th>
                                        <th style="text-align: center;">Jumlah</th>
                                        <th style="text-align: center;">Diskon (%)</th>
                                        <th style="text-align: center;">Diskon (Rp)</th>
                                        <th style="text-align: center;">Diskon Reason</th>
                                        <th style="text-align: center;">Remarks</th>
                                        <th style="text-align: center;">Total Diskon</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">${data.id}</td>
                                        <td style="text-align: center;">${data.code}</td>
                                        <td style="text-align: center;">${data.name}</td>
                                        <td style="text-align: center;" class="per-price">${Number(data.price).toLocaleString('id-ID')}</td>
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control jumlah-input" value="1" min="1" style="width: 70px;">
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control diskon-input" value="0" min="0" max="100" style="width: 70px;">
                                        </td>

                                        <td style="text-align: center;">
                                            <input type="number" class="form-control diskon-value" value="0" min="0">
                                        </td>

                                        <td style="text-align: center;">
                                            <select name="discountReason" class="form-control discount-reason">
                                                <option value="">Disc Reason</option>
                                                <?= $discOptions ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center;">
                                            <input type="text" class="form-control remarks" placeholder="Remarks">
                                        </td>
                                        <td style="text-align: center;" class="total-discount">
                                            0
                                        </td>
                                        <td style="text-align: center;" class="total-column">
                                        ${Number(data.price).toLocaleString('id-ID')}
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-sm remove-btn">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                       <div class="payment-methods mt-2">
                            <h6 class="text-secondary mb-2 mt-2">
                                <i class="bi bi-wallet2"></i> Metode Pembayaran
                            </h6>
                            <table class="table table-bordered payment-method-list">
                                <thead class="bg-thead">
                                    <tr>
                                        <th>Metode</th>
                                        <th>EDC</th>
                                        <th>Card Type</th>
                                        <th>Bank Name</th>
                                    
                                        <th>Installment</th>
                                        <th>Amount</th>
                                        <th>Aksi</th>
                                        <th style="display: none" hidden>PID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data metode pembayaran akan ditambahkan di sini -->
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-sm add-payment-method">
                                <i class="bi bi-plus-circle"></i> Tambah Metode Pembayaran
                            </button>
                        </div>
                        </div>
                   
                        </div>
                `;

                const container = document.getElementById("productTablesContainer");
                container.insertAdjacentHTML("beforeend", newTableHtml);

                const newTable = container.lastElementChild;

                // Event listener untuk input jumlah dan diskon
                const updateTotal = (event) => {
                    const inputElement = event.target;
                    const wrapperToUpdateDiscount = inputElement.closest(".product-table-wrapper");
                    const iscanfreeToUpdateDiscount = wrapperToUpdateDiscount.getAttribute("data-iscanfree");

                    const jumlahInput = newTable.querySelector(".jumlah-input");
                    const diskonInput = newTable.querySelector(".diskon-input");
                    const diskonValueInput = newTable.querySelector(".diskon-value");

                    const jumlah = parseFloat(jumlahInput.value) || 0;
                    let diskon = parseFloat(diskonInput.value) || 0;
                    let diskonValue = parseFloat(diskonValueInput.value) || 0;
                    const price = data.price;

                    const subtotal = jumlah * price;
                    let diskonAmount = (diskon / 100) * subtotal + diskonValue;
                    const maxDiskon = 0.30 * subtotal;

                    console.log(diskonAmount);


                    if (diskonAmount > maxDiskon && iscanfreeToUpdateDiscount == 0) {
                        diskon = 0;
                        diskonValue = 0;
                        diskonInput.value = 0;
                        diskonValueInput.value = 0;
                        diskonAmount = 0;
                        alert("Total diskon melebihi 30% dari harga. Diskon telah direset ke 0.");
                    }

                    const total = subtotal - diskonAmount;

                    newTable.querySelector(".total-column").innerText = Number(total).toLocaleString('id-ID');
                    newTable.querySelector(".total-discount").innerText = Number(diskonAmount).toLocaleString('id-ID');
                };

                newTable.querySelector(".jumlah-input").addEventListener("input", updateTotal);
                newTable.querySelector(".diskon-input").addEventListener("input", updateTotal);
                newTable.querySelector(".diskon-value").addEventListener("input", updateTotal);

                // Event listener untuk tombol "Hapus"
                newTable.querySelector(".remove-btn").addEventListener("click", function () {
                    const wrapper = this.closest(".product-table-wrapper");
                    const productId = wrapper.getAttribute("data-id");

                    usedProductIds = usedProductIds.filter((id) => id !== productId);
                    wrapper.remove();
                });


                newTable.querySelector(".add-payment-method").addEventListener("click", function () {
                    const paymentList = newTable.querySelector(".payment-method-list tbody");

                    const wrapper = this.closest(".product-table-wrapper");
                    const productId = wrapper.getAttribute("data-id");

                    const pointSection = wrapper.getAttribute("data-pointsection");

                    const paymentHtml = `
                                <tr>
                                    <td>
                                        <select class="form-control payment-type">
                                            <option value="">PAYMENT TYPE</option>
                                            <?= $paymentOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control edc" disabled>
                                            <option value="">SELECT EDC</option>
                                            <?= $edcOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control card-type" disabled>
                                            <option value="">CARD TYPE</option>
                                            <?= $cardOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control bank-name" disabled>
                                            <option value="">BANK NAME</option>
                                            <?= $bankOptions ?>
                                        </select>
                                    </td>
                                  
                                    <td>
                                        <select class="form-control installment" disabled>
                                            <option value="">SELECT INSTALLMENT</option>
                                            <?= $intallmentOptions ?>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control payment-amount" placeholder="AMOUNT" oninput="validateNumberInput(this)"></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-payment-method">DELETE</button>
                                    </td>
                                    <td><input type="text" class="hidden product-treatment-id" value="${productId}" style="display: none"></td?>
                                </tr>
                                `;


                    paymentList.insertAdjacentHTML("beforeend", paymentHtml);

                    // Event listener untuk tombol "Hapus Metode Pembayaran"
                    const lastPayment = paymentList.lastElementChild;
                    const paymentTypeSelect = lastPayment.querySelector(".payment-type");
                    const edcSelect = lastPayment.querySelector(".edc");
                    const cardTypeSelect = lastPayment.querySelector(".card-type");
                    const bankNameSelect = lastPayment.querySelector(".bank-name");

                    const installmentSelect = lastPayment.querySelector(".installment");

                    paymentTypeSelect.addEventListener("change", function () {
                        if (this.value == 2) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = false;
                            bankNameSelect.disabled = false;

                            installmentSelect.disabled = false;
                        } else if (this.value == 3) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = false;
                            bankNameSelect.disabled = false;

                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        } else if (this.value == 8) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = true;
                            cardTypeSelect.selectedIndex = 0;
                            bankNameSelect.disabled = true;
                            bankNameSelect.selectedIndex = 0;

                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        } else {
                            edcSelect.disabled = true;
                            edcSelect.selectedIndex = 0;
                            cardTypeSelect.disabled = true;
                            cardTypeSelect.selectedIndex = 0;
                            bankNameSelect.disabled = true;
                            bankNameSelect.selectedIndex = 0;
                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        }

                        if (this.value == 73) {
                            if (pointSection == 0) {
                                alert('tidak bisa memilih metode ini')
                                this.value = "";
                            }
                        }

                        if (this.value == 74) {
                            if (pointSection != 2) {
                                alert('tidak bisa memilih metode ini')
                                this.value = "";
                            }
                        }
                    });
                    lastPayment.querySelector(".remove-payment-method").addEventListener("click", function () {
                        lastPayment.remove();
                    });
                });
            });
        });

        //END FOR TREATMENTS


        //FOR MEMBERSHIP
        let usedMembershipIds = [];

        const buttonsMembership = document.querySelectorAll(".use-btn-membership");
        buttonsMembership.forEach((button) => {
            button.addEventListener("click", function () {
                const row = this.closest("tr");
                const data = {
                    id: row.cells[0].innerText.trim(),
                    name: row.cells[1].innerText.trim(),
                    sm: row.cells[2].innerText.trim(),
                    bm: row.cells[3].innerText.trim(),
                    tm: row.cells[4].innerText.trim(),
                    admin: row.cells[5].innerText.trim(),
                    term: row.cells[6].innerText.trim(),
                    total: parseInt(row.cells[7].innerText.trim().replace(/,/g, ''), 10),
                    monthly: parseFloat(row.cells[8].innerText.trim()),
                    firstmonth: parseFloat(row.cells[9].innerText.trim()),
                    lastmonth: parseFloat(row.cells[10].innerText.trim()),
                    pointsection: parseFloat(row.cells[11].innerText.trim())
                };

                if (usedMembershipIds.includes(data.id)) {
                    alert("This product has already been used!");
                    return;
                }

                usedMembershipIds.push(data.id);

                const newTableHtmlMembership = `
                    <div class="table-wrapper product-table-wrapper-membership card" data-id-membership="${data.id}" data-pointsection="${data.pointsection}">
                        <div class="p-4">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-thead">
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;" class="hidden">SM</th>
                                        <th style="text-align: center;" class="hidden">BM</th>
                                        <th style="text-align: center;">TM</th>
                                        <th style="text-align: center;" class="hidden">Admin</th>
                                        <th style="text-align: center;" class="hidden">Term</th>
                                        <th style="text-align: center;">Total</th>
                                        <th style="text-align: center;" class="hidden">Monthly</th>
                                        <th style="text-align: center;" class="hidden">1st Month</th>
                                        <th style="text-align: center;" class="hidden">Last Month</th>
                                        <th style="text-align: center;">Remarks</th>
                                        <th style="text-align: center;">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">${data.id}</td>
                                        <td style="text-align: center;">${data.name}</td>
                                        <td style="text-align: center;" class="total-sm hidden" >${data.sm}</td>
                                        <td style="text-align: center;" class="total-bm hidden" >${data.bm}</td>
                                        <td style="text-align: center;">
                                            <input type="number" class="form-control total-tm" value="${data.tm}" min="1" style="width: 70px;">
                                        </td>

                                        <td style="text-align: center;" class="total-admin hidden">${data.admin}</td>
                                        <td style="text-align: center;" class="total-term hidden" >${data.term}</td>
                                        <td style="text-align: center;" class="total-column">${Number(data.total).toLocaleString('id-ID')}</td>
                                        <td style="text-align: center;" class="total-monthly hidden" >${data.monthly.toFixed(2)}</td>
                                        <td style="text-align: center;" class="total-firstmonth hidden" >${data.firstmonth.toFixed(2)}</td>
                                        <td style="text-align: center;" class="total-lastmonth hidden" >${data.lastmonth.toFixed(2)}</td>
                                        <td style="text-align: center;">
                                            <input type="text" class="form-control remarks" placeholder="Remarks">
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-sm remove-btn-membership">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                            <button class="btn btn-info btn-sm detail-btn-membership" data-id="${data.id}">
                                                <i class="bi bi-trash"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="payment-methods-membership mt-2">
                            <h6 class="text-secondary mb-2 mt-2">
                                <i class="bi bi-wallet2"></i> Metode Pembayaran
                            </h6>
                            <table class="table table-bordered payment-method-list-membership">
                                <thead class="bg-thead">
                                    <tr>
                                        <th>Metode</th>
                                        <th>EDC</th>
                                        <th>Card Type</th>
                                        <th>Bank Name</th>
                                       
                                        <th>Installment</th>
                                        <th>Amount</th>
                                        <th>Aksi</th>
                                        <th style="display: none">PID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data metode pembayaran akan ditambahkan di sini -->
                                </tbody>
                            </table>
                            <button class="btn btn-primary btn-sm add-payment-method-membership">
                                <i class="bi bi-plus-circle"></i> Tambah Metode Pembayaran
                            </button>
                        </div>
                        </div>
                    </div>
                `;

                const containerMembership = document.getElementById("membershipTablesContainer");
                containerMembership.insertAdjacentHTML("beforeend", newTableHtmlMembership);

                const newTableMembership = containerMembership.lastElementChild;

                const updateTotal = () => {
                    const jumlah = parseFloat(newTableMembership.querySelector(".total-tm").value) || 0;
                    const sm = data.sm;
                    const price = data.total;

                    const pricePerOne = price / sm;

                    console.log(pricePerOne);


                    const total = jumlah * pricePerOne;

                    newTableMembership.querySelector(".total-column").innerText = Number(total).toLocaleString('id-ID');
                };

                newTableMembership.querySelector(".total-tm").addEventListener("input", updateTotal);


                // Event listener untuk tombol "Hapus"
                newTableMembership.querySelector(".remove-btn-membership").addEventListener("click", function () {
                    const wrapperMembership = this.closest(".product-table-wrapper-membership");
                    const productIdMembership = wrapperMembership.getAttribute("data-id-membership");

                    usedMembershipIds = usedMembershipIds.filter((id) => id !== productIdMembership);
                    wrapperMembership.remove();
                });


                newTableMembership.querySelector(".add-payment-method-membership").addEventListener("click", function () {
                    const paymentListMembership = newTableMembership.querySelector(".payment-method-list-membership");

                    const wrapperMembership = this.closest(".product-table-wrapper-membership");
                    const productIdMembership = wrapperMembership.getAttribute("data-id-membership");

                    const pointSection = wrapperMembership.getAttribute("data-pointsection");

                    const paymentHtmlMembership = `
                       

                        <tr>
                                    <td>
                                        <select class="form-control payment-type">
                                            <option value="">PAYMENT TYPE</option>
                                            <?= $paymentOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control edc" disabled>
                                            <option value="">SELECT EDC</option>
                                            <?= $edcOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control card-type" disabled>
                                            <option value="">CARD TYPE</option>
                                            <?= $cardOptions ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control bank-name" disabled>
                                            <option value="">BANK NAME</option>
                                            <?= $bankOptions ?>
                                        </select>
                                    </td>
                                  
                                    <td>
                                        <select class="form-control installment" disabled>
                                            <option value="">SELECT INSTALLMENT</option>
                                            <?= $intallmentOptions ?>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control payment-amount-membership" placeholder="AMOUNT" oninput="validateNumberInput(this)"></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-payment-method-membership">DELETE</button>
                                    </td>
                                    <td><input type="text" class="hidden product-membership-id" value="${productIdMembership}" style="display: none"></td?>
                                </tr>
                    `;

                    paymentListMembership.insertAdjacentHTML("beforeend", paymentHtmlMembership);

                    // Event listener untuk tombol "Hapus Metode Pembayaran"
                    const lastPaymentMembership = paymentListMembership.lastElementChild;
                    const paymentTypeSelect = lastPaymentMembership.querySelector(".payment-type");
                    const edcSelect = lastPaymentMembership.querySelector(".edc");
                    const cardTypeSelect = lastPaymentMembership.querySelector(".card-type");
                    const bankNameSelect = lastPaymentMembership.querySelector(".bank-name");

                    const installmentSelect = lastPaymentMembership.querySelector(".installment");

                    paymentTypeSelect.addEventListener("change", function () {
                        if (this.value == 2) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = false;
                            bankNameSelect.disabled = false;

                            installmentSelect.disabled = false;
                        } else if (this.value == 3) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = false;
                            bankNameSelect.disabled = false;

                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        } else if (this.value == 8) {
                            edcSelect.disabled = false;
                            cardTypeSelect.disabled = true;
                            cardTypeSelect.selectedIndex = 0;
                            bankNameSelect.disabled = true;
                            bankNameSelect.selectedIndex = 0;

                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        } else {
                            edcSelect.disabled = true;
                            edcSelect.selectedIndex = 0;
                            cardTypeSelect.disabled = true;
                            cardTypeSelect.selectedIndex = 0;
                            bankNameSelect.disabled = true;
                            bankNameSelect.selectedIndex = 0;

                            installmentSelect.disabled = true;
                            installmentSelect.selectedIndex = 0;
                        }

                        if (this.value == 73) {
                            if (pointSection == 0) {
                                alert('tidak bisa memilih metode ini')
                                this.value = "";
                            }
                        }

                        if (this.value == 74) {
                            if (pointSection != 2) {
                                alert('tidak bisa memilih metode ini')
                                this.value = "";
                            }
                        }

                        if (this.value == 39) {
                            if (productIdMembership == 2028 || productIdMembership == 2029 || productIdMembership == 2030) {
                                alert('tidak bisa memilih metode ini')
                                this.value = "";
                            }
                        }
                    });

                    lastPaymentMembership.querySelector(".remove-payment-method-membership").addEventListener("click", function () {
                        lastPaymentMembership.remove();
                    });
                });
            });
        });

        //END FOR MEMBERSHIP


        //FOR RETAIL
        let selectedProducts = [];

        function togglePaymentButtonVisibility() {
            const paymentButton = document.querySelector(".add-payment-method-retail"); // Selector tombol "Tambah Metode Pembayaran"
            if (selectedProducts.length > 0) {
                paymentButton.style.display = "inline-block"; // Tampilkan tombol jika ada produk yang dipilih
            } else {
                paymentButton.style.display = "none";
                document.querySelector(".payment-method-list-retail tbody").innerHTML = "";

            }
        }

        const buttonsRetail = document.querySelectorAll(".use-btn-retail");
        buttonsRetail.forEach((button) => {
            button.addEventListener("click", function () {
                const row = this.closest("tr"); // Ambil baris terkait tombol
                const data = {
                    id: row.cells[0].innerText.trim(),
                    code: row.cells[1].innerText.trim(),
                    name: row.cells[2].innerText.trim(),
                    price: parseInt(row.cells[3].innerText.trim().replace(/,/g, ''), 10),
                    jumlah: 1, // Default jumlah
                    total: parseInt(row.cells[3].innerText.trim().replace(/,/g, ''), 10),
                };

                // Cek apakah data sudah ada di array
                const alreadyAdded = selectedProducts.some((item) => item.id === data.id);
                if (alreadyAdded) {
                    alert("Product already selected!");
                    return;
                }

                // Tambahkan data ke array
                selectedProducts.push(data);

                // Tambahkan data ke tabel "Selected Products"
                const selectedTableBody = document.querySelector("#selectedProducts tbody");
                const selectedTableFoot = document.querySelector("#selectedProducts tfoot");
                const newRow = `
                                <tr data-id="${data.id}">
                                    <td style="text-align: center;">${data.id}</td>
                                    <td style="text-align: center;">${data.code}</td>
                                    <td style="text-align: center;">${data.name}</td>
                                    <td style="text-align: center;" class="per-price">${Number(data.price).toLocaleString('id-ID')}</td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control jumlah-input" value="1" min="1" style="width: 70px;">
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="number" class="form-control diskon-input" value="0" min="0" max="100" style="width: 70px;">
                                    </td>

                                     <td style="text-align: center;">
                                        <input type="number" class="form-control diskon-value" value="0" min="0">
                                    </td>

                                    <td style="text-align: center;">
                                        <select name="discountReason" class="form-control discount-reason">
                                            <option value="">Disc Reason</option>
                                            <?= $discOptions ?>
                                        </select>
                                    </td>
                                    <td style="text-align: center;">
                                            <input type="text" class="form-control remarks" placeholder="Remarks">
                                    </td>
                                    <td style="text-align: center;" class="total-discount">
                                        0
                                    </td>
                                    <td style="text-align: center;" class="total-column">
                                       ${Number(data.price).toLocaleString('id-ID')}
                                    </td>
                                    <td style="text-align: center;">
                                        <button class="btn btn-danger btn-sm remove-btn">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                `;
                selectedTableBody.insertAdjacentHTML("beforeend", newRow);

                const newRowElement = selectedTableBody.querySelector(`tr[data-id="${data.id}"]`);

                const jumlahInput = newRowElement.querySelector(".jumlah-input");
                const diskonInput = newRowElement.querySelector(".diskon-input");
                const totalColumn = newRowElement.querySelector(".total-column");
                const totalDiscount = newRowElement.querySelector(".total-discount");

                const diskonValueInput = newRowElement.querySelector(".diskon-value");

                // Fungsi untuk menghitung total
                const updateTotal = () => {
                    const jumlah = parseFloat(jumlahInput.value) || 1;
                    const diskon = parseFloat(diskonInput.value) || 0;
                    const price = data.price;
                    const diskonValue = parseFloat(diskonValueInput.value) || 0;

                    // Hitung total diskon dan total harga
                    const diskonAmount = (diskon / 100) * (jumlah * price) + diskonValue;
                    const total = jumlah * price - diskonAmount;

                    // Update tampilan total diskon dan total harga
                    totalDiscount.textContent = Number(diskonAmount).toLocaleString('id-ID');
                    totalColumn.textContent = Number(total).toLocaleString('id-ID');

                    updateGrandTotal();

                };

                // Event listener untuk input jumlah dan diskon
                jumlahInput.addEventListener("input", updateTotal);
                diskonInput.addEventListener("input", updateTotal);
                diskonValueInput.addEventListener("input", updateTotal);

                // Event listener untuk tombol "Hapus"
                newRowElement.querySelector(".remove-btn").addEventListener("click", function () {
                    const rowId = newRowElement.getAttribute("data-id");
                    selectedProducts = selectedProducts.filter((item) => item.id !== rowId);
                    newRowElement.remove();
                    updateGrandTotal();
                    togglePaymentButtonVisibility();
                });

                if (!selectedTableFoot.querySelector(".grand-total-row")) {
                    const totalRow = `
                            <tr class="grand-total-row">
                                <td colspan="10" style="text-align: right; font-weight: bold;">Grand Total:</td>
                                <td style="text-align: center; font-weight: bold;" id="grandTotal">0.00</td>
                                <td></td>
                            </tr>
                        `;
                    selectedTableFoot.insertAdjacentHTML("beforeend", totalRow);
                }

                // Update grand total setelah produk ditambahkan
                updateGrandTotal();
                togglePaymentButtonVisibility();
            });
        });

        function updateGrandTotal() {
            const totalColumns = document.querySelectorAll("#selectedProducts .total-column");
            let grandTotal = 0;

            totalColumns.forEach((total) => {
                grandTotal += parseInt(total.textContent.replace(/\./g, ''), 10) || 0;
            });

            const grandTotalElement = document.querySelector("#grandTotal");
            if (grandTotalElement) {
                grandTotalElement.textContent = Number(grandTotal).toLocaleString('id-ID');
            }
        }
        //END FOR RETAIL


        //FOR PAYMENT METHOD
        document.querySelector(".add-payment-method-retail").addEventListener("click", function () {
            const paymentListRetail = document.querySelector(".payment-method-list-retail tbody");

            // const wrapperRetail = this.closest(".payment-methods-retail");
            // const productIdRetail = wrapperRetail.getAttribute("data-id-retail");

            const paymentHtmlRetail = `
                    <tr>
                        <td>
                            <select class="form-control payment-type">
                                <option value="">PAYMENT TYPE</option>
                                <?= $paymentOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control edc" disabled>
                                <option value="">SELECT EDC</option>
                                <?= $edcOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control card-type" disabled>
                                <option value="">CARD TYPE</option>
                                <?= $cardOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control bank-name" disabled>
                                <option value="">BANK NAME</option>
                                <?= $bankOptions ?>
                            </select>
                        </td>
                       
                        <td>
                            <select class="form-control installment" disabled>
                                <option value="">SELECT INSTALLMENT</option>
                                <?= $intallmentOptions ?>
                            </select>
                        </td>
                        <td><input type="number" class="form-control payment-amount-retail" placeholder="AMOUNT" oninput="validateNumberInput(this)"></td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-payment-method-retail">DELETE</button>
                        </td>
                    </tr>
                `;

            // Insert the new payment row into the table body
            paymentListRetail.insertAdjacentHTML("beforeend", paymentHtmlRetail);

            // Add event listeners for the new row's functionality
            const lastPaymentRetail = paymentListRetail.lastElementChild;
            const paymentTypeSelect = lastPaymentRetail.querySelector(".payment-type");
            const edcSelect = lastPaymentRetail.querySelector(".edc");
            const cardTypeSelect = lastPaymentRetail.querySelector(".card-type");
            const bankNameSelect = lastPaymentRetail.querySelector(".bank-name");

            const installmentSelect = lastPaymentRetail.querySelector(".installment");

            paymentTypeSelect.addEventListener("change", function () {
                if (this.value == 2) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = false;
                    bankNameSelect.disabled = false;

                    installmentSelect.disabled = false;
                } else if (this.value == 3) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = false;
                    bankNameSelect.disabled = false;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                } else if (this.value == 8) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = true;
                    cardTypeSelect.selectedIndex = 0;
                    bankNameSelect.disabled = true;
                    bankNameSelect.selectedIndex = 0;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                } else {
                    edcSelect.disabled = true;
                    edcSelect.selectedIndex = 0;
                    cardTypeSelect.disabled = true;
                    cardTypeSelect.selectedIndex = 0;
                    bankNameSelect.disabled = true;
                    bankNameSelect.selectedIndex = 0;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                }
            });

            lastPaymentRetail.querySelector(".remove-payment-method-retail").addEventListener("click", function () {
                lastPaymentRetail.remove();
            });
        });
        //END FOR PAYMENT METHOD

        //FOR PAYMENT METHOD  SETTLEMETN
        document.querySelector(".add-payment-method-retailSettlementPelunasan").addEventListener("click", function () {
            const paymentListRetail = document.querySelector(".payment-method-list-retailSettlementPelunasan tbody");

            // const wrapperRetail = this.closest(".payment-methods-retail");
            // const productIdRetail = wrapperRetail.getAttribute("data-id-retail");

            const paymentHtmlRetail = `
                    <tr>
                        <td>
                            <select class="form-control payment-type">
                                <option value="">PAYMENT TYPE</option>
                                <?= $paymentOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control edc" disabled>
                                <option value="">SELECT EDC</option>
                                <?= $edcOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control card-type" disabled>
                                <option value="">CARD TYPE</option>
                                <?= $cardOptions ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control bank-name" disabled>
                                <option value="">BANK NAME</option>
                                <?= $bankOptions ?>
                            </select>
                        </td>

                        <td>
                            <select class="form-control installment" disabled>
                                <option value="">SELECT INSTALLMENT</option>
                                <?= $intallmentOptions ?>
                            </select>
                        </td>
                        <td><input type="number" class="form-control payment-amount" placeholder="AMOUNT" oninput="validateNumberInput(this)"></td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-payment-method-retailSettlementPelunasan">DELETE</button>
                        </td>
                    </tr>
                `;

            // Insert the new payment row into the table body
            paymentListRetail.insertAdjacentHTML("beforeend", paymentHtmlRetail);

            // Add event listeners for the new row's functionality
            const lastPaymentRetail = paymentListRetail.lastElementChild;
            const paymentTypeSelect = lastPaymentRetail.querySelector(".payment-type");
            const edcSelect = lastPaymentRetail.querySelector(".edc");
            const cardTypeSelect = lastPaymentRetail.querySelector(".card-type");
            const bankNameSelect = lastPaymentRetail.querySelector(".bank-name");

            const installmentSelect = lastPaymentRetail.querySelector(".installment");

            paymentTypeSelect.addEventListener("change", function () {
                if (this.value == 2) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = false;
                    bankNameSelect.disabled = false;

                    installmentSelect.disabled = false;
                } else if (this.value == 3) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = false;
                    bankNameSelect.disabled = false;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                } else if (this.value == 8) {
                    edcSelect.disabled = false;
                    cardTypeSelect.disabled = true;
                    cardTypeSelect.selectedIndex = 0;
                    bankNameSelect.disabled = true;
                    bankNameSelect.selectedIndex = 0;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                } else {
                    edcSelect.disabled = true;
                    edcSelect.selectedIndex = 0;
                    cardTypeSelect.disabled = true;
                    cardTypeSelect.selectedIndex = 0;
                    bankNameSelect.disabled = true;
                    bankNameSelect.selectedIndex = 0;

                    installmentSelect.disabled = true;
                    installmentSelect.selectedIndex = 0;
                }
            });

            lastPaymentRetail.querySelector(".remove-payment-method-retailSettlementPelunasan").addEventListener("click", function () {
                lastPaymentRetail.remove();
            });
        });
        //END FOR PAYMENT METHOD SETTLEMETN




        //FOR TRANSACTION TYPE
        window.changeSPJob = function (value) {
            usedProductIds = [];
            usedMembershipIds = [];
            selectedProducts = [];
            paymentMethods = [];

            const container = document.getElementById("productTablesContainer");
            container.innerHTML = "";

            const containerMembership = document.getElementById("membershipTablesContainer");
            containerMembership.innerHTML = "";


            const containerRetailBody = document.querySelector("#selectedProducts tbody");
            containerRetailBody.innerHTML = "";

            document.querySelector("#selectedProducts tfoot").innerHTML = "";

            document.querySelector(".payment-method-list-retail tbody").innerHTML = "";


            const roleContainer = document.getElementById("role-container");
            const roleTreatment = document.getElementById("role-treatment");
            const roleProduct = document.getElementById("role-product");


            const roleInvoiceHeaderTreatment = document.getElementById("role-information");
            const roleInvoiceHeaderMembership = document.getElementById("role-information-membership");
            const roleInvoiceHeaderRetail = document.getElementById("role-information-retail");

            const roleChoiceProduct = document.getElementById("role-choice-product");

            const paymentType = document.getElementById('paymentType').value;
            const treatmentDp_list = document.getElementById("settlementDownPaymentTreatment");
            const membershipDp_list = document.getElementById("settlementDownPaymentMembership");
            const retailDp_list = document.getElementById("settlementDownPaymentRetail");

            const divForSettlement = document.getElementById("role-choice-forSettlement");
            const divSettlementDpForRetail = document.getElementById("settlementDpForRetail");
            const divSettlementDpForTreatment = document.getElementById("settlementDpForTreatment");
            const divSettlementDpForMembership = document.getElementById("settlementDpForMembership");
            const divRetailSettlementPelunasan = document.getElementById("payment-methods-retailSettlementPelunasan");



            if (value == "2") {
                roleInvoiceHeaderMembership.classList.remove("hidden");
                if (paymentType == "3") {
                    membershipDp_list.classList.remove("hidden");
                    roleContainer.classList.add("hidden");

                    divForSettlement.classList.remove("hidden");
                    divSettlementDpForMembership.classList.remove("hidden");
                    divRetailSettlementPelunasan.classList.remove("hidden");

                    divSettlementDpForRetail.classList.add("hidden")
                    divSettlementDpForTreatment.classList.add("hidden")
                } else {
                    roleContainer.classList.remove("hidden");

                    divForSettlement.classList.add("hidden");
                    divSettlementDpForMembership.classList.add("hidden");
                    divRetailSettlementPelunasan.classList.add("hidden");
                }

            } else {
                roleContainer.classList.add("hidden");
                roleInvoiceHeaderMembership.classList.add("hidden");
                membershipDp_list.classList.add("hidden");
            }

            if (value == "1") {
                roleInvoiceHeaderTreatment.classList.remove("hidden");
                if (paymentType == "3") {
                    treatmentDp_list.classList.remove("hidden");
                    roleTreatment.classList.add("hidden");

                    divForSettlement.classList.remove("hidden");
                    divSettlementDpForTreatment.classList.remove("hidden");
                    divRetailSettlementPelunasan.classList.remove("hidden");

                    divSettlementDpForRetail.classList.add("hidden")
                    divSettlementDpForMembership.classList.add("hidden")
                } else {
                    roleTreatment.classList.remove("hidden");

                    divForSettlement.classList.add("hidden");
                    divSettlementDpForTreatment.classList.add("hidden");
                    divRetailSettlementPelunasan.classList.add("hidden");
                }
            } else {
                roleTreatment.classList.add("hidden");
                roleInvoiceHeaderTreatment.classList.add("hidden");
                treatmentDp_list.classList.add("hidden");
            }

            if (value == "3") {
                roleInvoiceHeaderRetail.classList.remove("hidden");
                if (paymentType == "3") {
                    retailDp_list.classList.remove("hidden");
                    roleProduct.classList.add("hidden");
                    roleChoiceProduct.classList.add("hidden");

                    divForSettlement.classList.remove("hidden");
                    divSettlementDpForRetail.classList.remove("hidden");
                    divSettlementDpForTreatment.classList.add("hidden")
                    divSettlementDpForMembership.classList.add("hidden")
                    divRetailSettlementPelunasan.classList.remove("hidden");
                } else {
                    roleProduct.classList.remove("hidden");
                    roleChoiceProduct.classList.remove("hidden");

                    divForSettlement.classList.add("hidden");
                    divSettlementDpForRetail.classList.add("hidden");
                    divRetailSettlementPelunasan.classList.add("hidden");
                }

            } else {
                roleProduct.classList.add("hidden");
                roleInvoiceHeaderRetail.classList.add("hidden");
                roleChoiceProduct.classList.add("hidden");
                retailDp_list.classList.add("hidden");
            }

            // console.log(usedProductIds);
        };
        //END FOR TRANSACTION TYPE

        //FOR PAYMENT TYPE
        window.changeSPPayment = function (value) {
            usedProductIds = [];
            usedMembershipIds = [];
            selectedProducts = [];
            paymentMethods = [];

            console.log(value, 'ini value payment');


            const container = document.getElementById("productTablesContainer");
            container.innerHTML = "";

            const containerMembership = document.getElementById("membershipTablesContainer");
            containerMembership.innerHTML = "";


            const containerRetailBody = document.querySelector("#selectedProducts tbody");
            containerRetailBody.innerHTML = "";

            document.querySelector("#selectedProducts tfoot").innerHTML = "";

            document.querySelector(".payment-method-list-retail tbody").innerHTML = "";

            const roleContainer = document.getElementById("role-container");
            const roleTreatment = document.getElementById("role-treatment");
            const roleProduct = document.getElementById("role-product");


            const roleInvoiceHeaderTreatment = document.getElementById("role-information");
            const roleInvoiceHeaderMembership = document.getElementById("role-information-membership");
            const roleInvoiceHeaderRetail = document.getElementById("role-information-retail");

            const roleChoiceProduct = document.getElementById("role-choice-product");


            const searchString = document.getElementById("searchString");
            const buttonSearch = document.getElementById("buttonSearch");

            const customerInformation = document.getElementById("customerInformation");
            const transactionType = document.getElementById('transactionType').value;

            const treatmentDp_list = document.getElementById("settlementDownPaymentTreatment");
            const membershipDp_list = document.getElementById("settlementDownPaymentMembership");
            const retailDp_list = document.getElementById("settlementDownPaymentRetail");


            const divForSettlement = document.getElementById("role-choice-forSettlement");
            const divSettlementDpForRetail = document.getElementById("settlementDpForRetail");
            const divSettlementDpForTreatment = document.getElementById("settlementDpForTreatment");
            const divSettlementDpForMembership = document.getElementById("settlementDpForMembership");
            const divRetailSettlementPelunasan = document.getElementById("payment-methods-retailSettlementPelunasan");

            const buttonListMembership = document.getElementById("buttonListMembership");


            if (value == "3") {
                searchString.classList.add("disabled");
                buttonSearch.classList.add("disabled");
                customerInformation.classList.add("hidden");
                roleProduct.classList.add("hidden");
                roleTreatment.classList.add("hidden");
                roleContainer.classList.add("hidden");
                roleChoiceProduct.classList.add("hidden");
                buttonListMembership.classList.add("hidden");

                divForSettlement.classList.remove("hidden");
                divRetailSettlementPelunasan.classList.remove("hidden");

                if (transactionType == "1") {
                    treatmentDp_list.classList.remove("hidden");
                    membershipDp_list.classList.add("hidden");
                    retailDp_list.classList.add("hidden");

                    divSettlementDpForTreatment.classList.remove("hidden");
                    divSettlementDpForMembership.classList.add("hidden");
                    divSettlementDpForRetail.classList.add("hidden");


                } else if (transactionType == "2") {
                    membershipDp_list.classList.remove("hidden");
                    treatmentDp_list.classList.add("hidden");
                    retailDp_list.classList.add("hidden");

                    divSettlementDpForMembership.classList.remove("hidden");
                    divSettlementDpForTreatment.classList.add("hidden");
                    divSettlementDpForRetail.classList.add("hidden");


                } else if (transactionType == "3") {
                    retailDp_list.classList.remove("hidden");
                    treatmentDp_list.classList.add("hidden");
                    membershipDp_list.classList.add("hidden");

                    divSettlementDpForRetail.classList.remove("hidden");
                    divSettlementDpForMembership.classList.add("hidden");
                    divSettlementDpForTreatment.classList.add("hidden");



                } else {
                    divForSettlement.classList.add("hidden");
                    divRetailSettlementPelunasan.classList.add("hidden");
                }
            } else {
                customerInformation.classList.remove("hidden");
                treatmentDp_list.classList.add("hidden");
                membershipDp_list.classList.add("hidden");
                retailDp_list.classList.add("hidden");
                searchString.disabled = false;
                buttonSearch.disabled = false;
                searchString.classList.remove("disabled");
                buttonSearch.classList.remove("disabled");

                divForSettlement.classList.add("hidden");
                divRetailSettlementPelunasan.classList.add("hidden");
                buttonListMembership.classList.remove("hidden");

                if (transactionType == "1") {
                    roleTreatment.classList.remove("hidden");
                    roleContainer.classList.add("hidden");
                    roleProduct.classList.add("hidden");
                    roleChoiceProduct.classList.add("hidden");
                } else if (transactionType == "2") {
                    roleContainer.classList.remove("hidden");
                    roleProduct.classList.add("hidden");
                    roleTreatment.classList.add("hidden");
                    roleChoiceProduct.classList.add("hidden");
                } else if (transactionType == "3") {
                    roleProduct.classList.remove("hidden");
                    roleTreatment.classList.add("hidden");
                    roleContainer.classList.add("hidden");
                    roleChoiceProduct.classList.remove("hidden");
                }
            }

            console.log(usedProductIds);
        };
        //END FOR PAYMENT TYPE


        $(document).ready(function () {
            $(document).on("click", ".use-btn-settlementRetail", function () {
                var downpaymentId = $(this).data("id");
                var prev = $(this).data("prev");
                loadProductSettlement(downpaymentId, prev);
            });

            // Fungsi untuk mengambil dan menampilkan data produk
            function loadProductSettlement(downpaymentId, prev) {
                console.log(downpaymentId, prev);

                $.ajax({
                    url: "App/settlementDownPayment", // Sesuaikan dengan controller
                    type: "POST",
                    data: {
                        id: downpaymentId,
                        prev: prev,
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            if (response.prev == 1) {
                                document.getElementById('customer-name-treatment').value = response.dataHeader[0].FIRSTNAME + " " + response.dataHeader[0].LASTNAME;
                                document.getElementById('customer-id-treatment').value = response.dataHeader[0].customerid;
                                document.getElementById('downpayment-id-treatment').value = response.dataHeader[0].DPID;


                                if (response.dataHeader[0].frontdeskid) {
                                    $("#frontdeskid-treatment").val(response.dataHeader[0].frontdeskid).trigger("change");
                                }
                                if (response.dataHeader[0].doctorid) {
                                    $("#doctor-treatment").val(response.dataHeader[0].doctorid).trigger("change");
                                }
                                if (response.dataHeader[0].salesid) {
                                    $("#consultanid-treatment").val(response.dataHeader[0].salesid).trigger("change");
                                }

                                $("#forSettlement").removeClass("hidden");
                                var tbody = $("#selectedTreatmentSettlement tbody");
                                tbody.empty();

                                $.each(response.dataDetailProduct, function (index, item) {
                                    tbody.append(`
                                        <tr>
                                            <td class="productId">${item.PRODUCTID}</td>
                                            <td class="">${item.PRODUCTCODE}</td>
                                            <td class="">${item.PRODUCTNAME}</td>
                                            <td class="price">${Number(item.PRODUCTPRICE).toLocaleString('id-ID')}</td>
                                            <td class="productJumlah">${item.PRODUCTJUMLAH}</td>
                                            <td class="discountPercent">${item.DISCOUNTPERCENT}</td>
                                            <td class="discountValue">${Number(item.DISCOUNTVALUE).toLocaleString('id-ID')}</td>
                                            <td class="discountReason">${item.DISCOUNTREASON != null ? item.DISCOUNTREASON : ""}</td>
                                            <td style="text-align: center;">
                                                <input type="text" class="form-control remarks" placeholder="Remarks">
                                            </td>
                                            <td class="totalDiscount">${Number(item.TOTALDISCOUNT).toLocaleString('id-ID')}</td>
                                            <td class="total">${Number(item.TOTAL).toLocaleString('id-ID')}</td>
                                        </tr>
                                    `);
                                });

                                let grandTotal = 0;
                                response.dataDetailProduct.forEach(item => {
                                    grandTotal += parseFloat(item.TOTAL);
                                });

                                let remaining = grandTotal - response.dataPayment[0].AMOUNT;
                                document.getElementById("grandTotalTreatmentSettlement").textContent = grandTotal.toLocaleString('id-ID');

                                var tbodyPayment = $("#payment-method-list-treatmentSettlement tbody");
                                tbodyPayment.empty();

                                $.each(response.dataPayment, function (index, item) {
                                    tbodyPayment.append(`
                                        <tr>
                                            <td>DOWN PAYMENT</td>
                                            <td>${item.EDCNAME != null ? item.EDCNAME : ""}</td>
                                            <td>${item.CARDNAME != null ? item.CARDNAME : ""}</td>
                                            <td>${item.BANKNAME != null ? item.BANKNAME : ""}</td>
                                            <td>${item.INSTALLMENTNAME != null ? item.INSTALLMENTNAME : ""}</td>
                                            <td class="payment-amount">${Number(item.AMOUNT).toLocaleString('id-ID')}</td>
                                            <td class="remaining">${Number(remaining).toLocaleString('id-ID')}</td>
                                            <td class="hidden edc">${item.EDCID != null ? item.EDCID : ""}</td>
                                            <td class="hidden card-type">${item.CARDID != null ? item.CARDID : ""}</td>
                                            <td class="hidden bank-name">${item.CARDBANKID != null ? item.CARDBANKID : ""}</td>
                                            <td class="hidden installment">${item.INSTALLMENTID != null ? item.INSTALLMENTID : ""}</td>
                                        </tr>
                                    `);
                                });
                            } else if (prev == 3) {
                                document.getElementById('customer-name-retail').value = response.dataHeader[0].FIRSTNAME + " " + response.dataHeader[0].LASTNAME;
                                document.getElementById('customer-id-retail').value = response.dataHeader[0].customerid;
                                document.getElementById('downpayment-id-retail').value = response.dataHeader[0].DPID;


                                if (response.dataHeader[0].frontdeskid) {
                                    $("#frontdeskid-retail").val(response.dataHeader[0].frontdeskid).trigger("change");
                                }

                                if (response.dataHeader[0].doctorid) {
                                    $("#prescriptionid-retail").val(response.dataHeader[0].doctorid).trigger("change");
                                }

                                if (response.dataHeader[0].salesid) {
                                    $("#consultanid-retail").val(response.dataHeader[0].salesid).trigger("change");
                                }


                                $("#forSettlement").removeClass("hidden");
                                var tbody = $("#selectedRetailSettlement tbody");
                                tbody.empty();

                                $.each(response.dataDetailProduct, function (index, item) {
                                    tbody.append(`
                                        <tr>
                                            <td class="data-id">${item.PRODUCTID}</td>
                                            <td class="">${item.PRODUCTCODE}</td>
                                            <td class="">${item.PRODUCTNAME}</td>
                                            <td class="per-price">${Number(item.PRODUCTPRICE).toLocaleString('id-ID')}</td>
                                            <td class="jumlah-input">${item.PRODUCTJUMLAH}</td>
                                            <td class="diskon-input">${item.DISCOUNTPERCENT}</td>
                                            <td class="diskon-value">${Number(item.DISCOUNTVALUE).toLocaleString('id-ID')}</td>
                                            <td class="discount-reason">${item.DISCOUNTREASON != null ? item.DISCOUNTREASON : ""}</td>
                                            <td style="text-align: center;">
                                                <input type="text" class="form-control remarks" placeholder="Remarks">
                                            </td>
                                            <td class="total-discount">${Number(item.TOTALDISCOUNT).toLocaleString('id-ID')}</td>
                                            <td class="total-column">${Number(item.TOTAL).toLocaleString('id-ID')}</td>
                                        </tr>
                                    `);
                                });

                                let grandTotal = 0;
                                response.dataDetailProduct.forEach(item => {
                                    grandTotal += parseFloat(item.TOTAL);
                                });

                                let remaining = grandTotal - response.dataPayment[0].AMOUNT;
                                document.getElementById("grandTotalRetailSettlement").textContent = grandTotal.toLocaleString('id-ID');

                                var tbodyPayment = $("#payment-method-list-retailSettlement tbody");
                                tbodyPayment.empty();

                                $.each(response.dataPayment, function (index, item) {
                                    tbodyPayment.append(`
                                        <tr>
                                            <td>DOWN PAYMENT</td>
                                            <td>${item.EDCNAME != null ? item.EDCNAME : ""}</td>
                                            <td>${item.CARDNAME != null ? item.CARDNAME : ""}</td>
                                            <td>${item.BANKNAME != null ? item.BANKNAME : ""}</td>
                                            <td>${item.INSTALLMENTNAME != null ? item.INSTALLMENTNAME : ""}</td>
                                            <td class="payment-amount">${Number(item.AMOUNT).toLocaleString('id-ID')}</td>
                                            <td class="remaining">${Number(remaining).toLocaleString('id-ID')}</td>
                                            <td class="hidden edc">${item.EDCID != null ? item.EDCID : ""}</td>
                                            <td class="hidden card-type">${item.CARDID != null ? item.CARDID : ""}</td>
                                            <td class="hidden bank-name">${item.CARDBANKID != null ? item.CARDBANKID : ""}</td>
                                            <td class="hidden installment">${item.INSTALLMENTID != null ? item.INSTALLMENTID : ""}</td>
                                        </tr>
                                    `);
                                });
                            } else {
                                document.getElementById('customer-name-membership').value = response.dataHeader[0].FIRSTNAME + " " + response.dataHeader[0].LASTNAME;
                                document.getElementById('customer-id-membership').value = response.dataHeader[0].customerid;

                                document.getElementById('downpayment-id-membership').value = response.dataHeader[0].DPID;

                                if (response.dataHeader[0].frontdeskid) {
                                    $("#frontdeskid-membership").val(response.dataHeader[0].frontdeskid).trigger("change");
                                }
                                if (response.dataHeader[0].doctorid) {
                                    $("#doctor-membership").val(response.dataHeader[0].doctorid).trigger("change");
                                }

                                if (response.dataHeader[0].salesid) {
                                    $("#assistent-docter-membership").val(response.dataHeader[0].salesid).trigger("change");
                                }

                                $("#forSettlement").removeClass("hidden");
                                var tbody = $("#selectedMembershipSettlement tbody");
                                tbody.empty();

                                $.each(response.dataDetailProduct, function (index, item) {
                                    tbody.append(`
                                        <tr>
                                            <td class="data-id-membership">${item.PRODUCTID}</td>
                                            <td>${item.PRODUCTNAME}</td>
                                            <td style="text-align: center;">
                                                <input type="text" class="form-control remarks" placeholder="Remarks">
                                            </td>
                                            <td class="total-tm">${item.TM}</td>
                                            
                                            <td class="total-column">${Number(item.TOTALAMOUNT).toLocaleString('id-ID')}</td>
                                            
                                            <td class="hidden total-sm">${item.SM}</td>
                                            <td class="hidden total-bm">${item.BM}</td>
                                            <td class="hidden total-admin">${item.ADMIN}</td>
                                            <td class="hidden total-term">${item.TERMPRICE}</td>
                                            <td class="hidden total-monthly">${item.MONTHLYFEE}</td>
                                            <td class="hidden total-firstmonth">${item.FIRSTMONTHFEE}</td>
                                            <td class="hidden total-lastmonth">${item.LASTMONTHFEE}</td>
                                        </tr>
                                    `);
                                });

                                let grandTotal = 0;
                                response.dataDetailProduct.forEach(item => {
                                    grandTotal += parseFloat(item.TOTALAMOUNT);
                                });

                                let remaining = grandTotal - response.dataPayment[0].AMOUNT;
                                document.getElementById("grandTotalMembershipSettlement").textContent = grandTotal.toLocaleString('id-ID');

                                var tbodyPayment = $("#payment-method-list-membershipSettlement tbody");
                                tbodyPayment.empty();

                                $.each(response.dataPayment, function (index, item) {
                                    tbodyPayment.append(`
                                        <tr>
                                            <td>DOWN PAYMENT</td>
                                            <td>${item.EDCNAME != null ? item.EDCNAME : ""}</td>
                                            <td>${item.CARDNAME != null ? item.CARDNAME : ""}</td>
                                            <td>${item.BANKNAME != null ? item.BANKNAME : ""}</td>
                                            <td>${item.INSTALLMENTNAME != null ? item.INSTALLMENTNAME : ""}</td>
                                            <td class="payment-amount">${Number(item.AMOUNT).toLocaleString('id-ID')}</td>
                                            <td class="remaining">${Number(remaining).toLocaleString('id-ID')}</td>
                                            <td class="hidden edc">${item.EDCID != null ? item.EDCID : ""}</td>
                                            <td class="hidden card-type">${item.CARDID != null ? item.CARDID : ""}</td>
                                            <td class="hidden bank-name">${item.CARDBANKID != null ? item.CARDBANKID : ""}</td>
                                            <td class="hidden installment">${item.INSTALLMENTID != null ? item.INSTALLMENTID : ""}</td>
                                        </tr>
                                    `);
                                });
                            }

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        s
                        alert("Terjadi kesalahan saat mengambil data.");

                    },
                });
            }
        });
    });

    function saveTransaction() {
        const transactionType = document.getElementById('transactionType').value;
        const paymentType = document.getElementById('paymentType').value;

        if (paymentType === '0') {
            alert('Pilih payment type terlebih dahulu!');
            return;
        }

        switch (transactionType) {
            case '1': // Treatment
                if (paymentType === '1') {
                    saveTreatmentTransaction();
                } else if (paymentType === '2') {
                    saveTreatmentTransactionDownPayment();
                } else {
                    saveTreatmentTransactionSettlement();
                }
                break;
            case '2': // Membership
                if (paymentType === '1') {
                    saveMembershipTransaction();
                } else if (paymentType === '2') {
                    saveMembershipTransactionDownPayment();
                } else {
                    saveMembershipTransactionSettlement();
                }
                break;
            case '3': // Retail
                if (paymentType === '1') {
                    saveRetailTransaction();
                } else if (paymentType === '2') {
                    saveRetailTransactionDownPayment();
                } else {
                    saveRetailTransactionSettlement();
                }
                break;
            default:
                alert('Pilih jenis transaksi terlebih dahulu!');
                break;
        }
    }


    // TRANSAKSI DP/FULL/SETTLEMENT TREATMENT
    function saveTreatmentTransaction() {
        const customerId = document.getElementById('customer-id-treatment').value;
        const consultantId = document.getElementById('consultanid-treatment').value;
        const frontDeskId = document.getElementById('frontdeskid-treatment').value;
        const assistantId = document.getElementById('assistenid-treatment').value;
        const bcId = document.getElementById('bcid-treatment').value;
        const doctorid = document.getElementById('doctor-treatment').value;

        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        document.querySelectorAll('.product-table-wrapper').forEach(wrapper => {
            const productId = wrapper.getAttribute('data-id');
            const jumlah = wrapper.querySelector('.jumlah-input').value;
            const diskon = wrapper.querySelector('.diskon-input').value;

            const totalDiscount = parseInt(wrapper.querySelector('.total-discount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(wrapper.querySelector('.per-price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(wrapper.querySelector('.diskon-value').value.replace(/\./g, ''), 10);

            const remarks = wrapper.querySelector('.remarks').value;

            let discReasonId, diskonReason;

            if (totalDiscount > 0) {
                const discReasonSelect = wrapper.querySelector('.discount-reason');
                discReasonId = discReasonSelect.value;
                diskonReason = discReasonSelect.options[discReasonSelect.selectedIndex].text;

                // Misalnya, option default yang tidak valid memiliki value kosong atau teks "Disc Reason"
                if (discReasonId === "" || diskonReason === "" || diskonReason === "Disc Reason") {
                    alert("Silahkan pilih alasan diskon!");
                    hasError = true;
                    // Bisa ditambahkan logic untuk menghentikan submit form atau proses selanjutnya
                }
            } else {
                // Jika totalDiscount nol, meskipun ada pilihan, kita tetapkan sebagai null
                discReasonId = null;
                diskonReason = null;
            }

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                totalDiscount,
                price,
                discReasonId,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product treatment belum ditambahkan!');
            hasError = true;
        }

        // Ambil metode pembayaran globalPointCustomer
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount').value;
            const producttreatmentid = method.querySelector('.product-treatment-id').value;


            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            paymentMethods.push({
                amount,
                producttreatmentid,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        // cek apabila point yang dimasukkan melebihi point customer
        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }

        selectedProducts.forEach(product => {
            const productAmounts = paymentMethods.filter(payment => payment.producttreatmentid == product.productId);
            const totalAmount = productAmounts.reduce((acc, payment) => acc + parseInt(payment.amount), 0);

            if (totalAmount != parseInt(product.total)) {
                alert(`Total amount untuk produk ID ${product.productId} tidak balance!`);
                hasError = true;
            }
        });

        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            assistantId,
            bcId,
            doctorid,
            locationId: 1,
            updateuserId: 1,
            products: selectedProducts,
            payments: paymentMethods,
            downPaymentId: null
        };

        console.log(transactionData);

        if (hasError) {
            return false; 
        }
        const today = new Date().toISOString().split('T')[0];
        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'text',
            success: function (responseText) {
                try {
                    var response = JSON.parse(responseText);
                    alert('berhasil menambahkan transaksi');

                    if (response.status === 'success' && response.invoicehdrids) {
                        response.invoicehdrids.forEach(function (id) {
                            window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        console.error('Response tidak sesuai yang diharapkan:', response);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e, responseText);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    function saveTreatmentTransactionDownPayment() {
        const customerId = document.getElementById('customer-id-treatment').value;
        const consultantId = document.getElementById('consultanid-treatment').value;
        const frontDeskId = document.getElementById('frontdeskid-treatment').value;
        const assistantId = document.getElementById('assistenid-treatment').value;
        const bcId = document.getElementById('bcid-treatment').value;
        const doctorid = document.getElementById('doctor-treatment').value;

        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        document.querySelectorAll('.product-table-wrapper').forEach(wrapper => {
            const productId = wrapper.getAttribute('data-id');
            const jumlah = wrapper.querySelector('.jumlah-input').value;
            const diskon = wrapper.querySelector('.diskon-input').value;

            const totalDiscount = parseInt(wrapper.querySelector('.total-discount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(wrapper.querySelector('.per-price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(wrapper.querySelector('.diskon-value').value.replace(/\./g, ''), 10);

            const remarks = wrapper.querySelector('.remarks').value;

            let discReasonId, diskonReason;

            if (totalDiscount > 0) {
                const discReasonSelect = wrapper.querySelector('.discount-reason');
                discReasonId = discReasonSelect.value;
                diskonReason = discReasonSelect.options[discReasonSelect.selectedIndex].text;

                // Misalnya, option default yang tidak valid memiliki value kosong atau teks "Disc Reason"
                if (discReasonId === "" || diskonReason === "" || diskonReason === "Disc Reason") {
                    alert("Silahkan pilih alasan diskon!");
                    hasError = true;
                    // Bisa ditambahkan logic untuk menghentikan submit form atau proses selanjutnya
                }
            } else {
                // Jika totalDiscount nol, meskipun ada pilihan, kita tetapkan sebagai null
                discReasonId = null;
                diskonReason = null;
            }

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                totalDiscount,
                price,
                discReasonId,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product treatment belum ditambahkan!');
            hasError = true;
        }

        // Ambil metode pembayaran globalPointCustomer
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount').value;
            const producttreatmentid = method.querySelector('.product-treatment-id').value;


            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            paymentMethods.push({
                amount,
                producttreatmentid,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }

        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            assistantId,
            bcId,
            doctorid,
            locationId: 1,
            updateuserId: 1,
            products: selectedProducts,
            payments: paymentMethods
        };

        console.log(transactionData);

        if (hasError) {
            return false;
        }

        const today = new Date().toISOString().split('T')[0];


        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceTransactionTreatmentDownPayment' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'text',
            success: function (responseText) {
                try {
                    var response = JSON.parse(responseText); // Konversi string ke JSON
                    console.log('Parsed Response:', response);
                    alert('berhasil menambahkan transaksi');
                    if (response.status === 'success' && response.invoicehdrids) {
                        response.invoicehdrids.forEach(function (id) {
                            // if (locationIdInvoice == 12) {
                            //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/2/" + id, "_blank");
                            // } else {
                            window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummaryDownPayment/${today}/${customerId}`, "_blank");
                            // }
                        });

                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        console.error('Response tidak sesuai yang diharapkan:', response);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e, responseText);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }


    function saveTreatmentTransactionSettlement() {
        const customerId = document.getElementById('customer-id-treatment').value;
        const downPaymentId = document.getElementById('downpayment-id-treatment').value;
        const consultantId = document.getElementById('consultanid-treatment').value;
        const frontDeskId = document.getElementById('frontdeskid-treatment').value;
        const assistantId = document.getElementById('assistenid-treatment').value;
        const bcId = document.getElementById('bcid-treatment').value;
        const doctorid = document.getElementById('doctor-treatment').value;


        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        let productId = 0;
        document.querySelectorAll('.treatment-table-wrapper-settlement').forEach(wrapper => {

            productId = parseInt(wrapper.querySelector('.productId').textContent);
            const jumlah = parseInt(wrapper.querySelector('.productJumlah').textContent);
            const diskon = parseInt(wrapper.querySelector('.discountPercent').textContent.replace(/\./g, ''), 10);

            const totalDiscount = parseInt(wrapper.querySelector('.totalDiscount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(wrapper.querySelector('.total').textContent.replace(/\./g, ''), 10);
            const price = parseInt(wrapper.querySelector('.price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(wrapper.querySelector('.discountValue').textContent.replace(/\./g, ''), 10);
            const diskonReason = wrapper.querySelector('.discountReason').textContent

            const remarks = wrapper.querySelector('.remarks').value;

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                totalDiscount,
                price,
                discReasonId: null,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product treatment belum ditambahkan!');
            hasError = true;
        }

        // Ambil metode pembayaran globalPointCustomer
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-retailSettlementPelunasan tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = parseInt(method.querySelector('.payment-amount').value);

            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
                producttreatmentid: productId
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }


        let remaining = 0;
        document.querySelectorAll('.payment-method-list-treatmentSettlement tbody tr').forEach(method => {
            const type = 6;
            const edc = method.querySelector('.edc').textContent;
            const cardType = method.querySelector('.card-type').textContent;
            const bankName = method.querySelector('.bank-name').textContent;

            const installment = method.querySelector('.installment').textContent;
            const amount = parseInt(method.querySelector('.payment-amount').textContent.replace(/\./g, ''), 10);

            remaining = parseInt(method.querySelector('.remaining').textContent.replace(/\./g, ''), 10);


            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
                producttreatmentid: productId
            });
        });

        const totalAmount = paymentMethods
            .filter(item => item.paymentid !== 6) // Filter data dengan paymentid bukan 6
            .reduce((sum, item) => sum + item.amount, 0); // Menjumlahkan amount

        console.log(totalAmount);

        if (totalAmount != remaining) {
            alert(`Total amount tidak balance!`);
            hasError = true;
        }


        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            assistantId,
            doctorid,
            bcId,
            locationId: 1,
            updateuserId: 1,
            products: selectedProducts,
            payments: paymentMethods,
            downPaymentId
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];


        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'text',
            success: function (responseText) {
                try {
                    var response = JSON.parse(responseText); // Konversi string ke JSON
                    console.log('Parsed Response:', response);
                    alert('berhasil menambahkan transaksi');


                    if (response.status === 'success' && response.invoicehdrids) {
                        response.invoicehdrids.forEach(function (id) {
                            // if (locationIdInvoice == 12) {
                            //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/1/" + id, "_blank");
                            // } else {
                            window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                            // }
                            // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/1/" + id, "_blank");

                        });

                        setTimeout(function () {
                            location.reload();
                        }, 200);
                    } else {
                        console.error('Response tidak sesuai yang diharapkan:', response);
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e, responseText);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            },

            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }
    // END TRANSAKSI DP/FULL/SETTLEMENT TREATMENT

    // TRANSAKSI DP/FULL/SETTLEMENT MEMBERSHIP
    function saveMembershipTransaction() {
        const customerId = document.getElementById('customer-id-membership').value;
        const assistantDoctorId = document.getElementById('assistent-docter-membership').value;
        const frontDeskId = document.getElementById('frontdeskid-membership').value;
        const doctorId = document.getElementById('docter-membership').value;
        const beauticianId = document.getElementById('assistandbybeautician-membership').value;
        const salesLocationId = document.getElementById('saleslocation-membership').value;
        const activatedLocationId = document.getElementById('activatedlocation-membership').value;

        const prescreptionid = document.getElementById('doctor-membership').value;


        let hasError = false;
        if (!customerId || !assistantDoctorId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        const selectedMemberships = [];
        document.querySelectorAll('.product-table-wrapper-membership').forEach(wrapper => {
            const membershipId = wrapper.getAttribute('data-id-membership');
            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const sm = wrapper.querySelector('.total-tm').value;
            const bm = wrapper.querySelector('.total-bm').textContent;
            const tm = wrapper.querySelector('.total-tm').value;
            const admin = wrapper.querySelector('.total-admin').textContent;

            const term = wrapper.querySelector('.total-term').textContent;
            const monthly = parseInt(wrapper.querySelector('.total-monthly').textContent.replace(/\./g, ''), 10);
            const firstmonth = parseInt(wrapper.querySelector('.total-firstmonth').textContent.replace(/\./g, ''), 10);
            const lastmonth = parseInt(wrapper.querySelector('.total-lastmonth').textContent.replace(/\./g, ''), 10);

            const remarks = wrapper.querySelector('.remarks').value;

            selectedMemberships.push({
                membershipId,
                total,
                updateuserId: 1,
                sm,
                bm,
                tm,
                admin,
                term,
                monthly,
                firstmonth,
                lastmonth,
                remarks
            });
        });

        if (selectedMemberships.length === 0) {
            alert('Product package belum ditambahkan!');
            hasError = true;
        }



        // Ambil metode pembayaran
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-membership tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount-membership').value;
            const producttreatmentid = method.querySelector('.product-membership-id').value;


            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                producttreatmentid,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }


        // cek apabila point yang dimasukkan melebihi point customer
        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }

        selectedMemberships.forEach(product => {
            const productAmounts = paymentMethods.filter(payment => payment.producttreatmentid == product.membershipId);
            const totalAmount = productAmounts.reduce((acc, payment) => acc + parseInt(payment.amount), 0);

            if (totalAmount != parseInt(product.total)) {
                alert(`Total amount untuk produk ID ${product.membershipId} tidak balance!`);
                hasError = true;
            }
        });

        const transactionData = {
            customerId,
            assistantDoctorId,
            frontDeskId,
            doctorId,
            beauticianId,
            salesLocationId,
            activatedLocationId,
            updateuserId: 1,
            memberships: selectedMemberships,
            payments: paymentMethods,
            downPaymentId: null,
            prescreptionid
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];

        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceMembershipTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    response.invoicehdrids.forEach(function (id) {
                        // if (locationIdInvoice == 12) {
                        //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/3/" + id, "_blank");
                        // } else {
                        window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                        // }


                    });

                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    function saveMembershipTransactionDownPayment() {
        const customerId = document.getElementById('customer-id-membership').value;
        const assistantDoctorId = document.getElementById('assistent-docter-membership').value;
        const frontDeskId = document.getElementById('frontdeskid-membership').value;
        const doctorId = document.getElementById('docter-membership').value;
        const beauticianId = document.getElementById('assistandbybeautician-membership').value;
        const salesLocationId = document.getElementById('saleslocation-membership').value;
        const activatedLocationId = document.getElementById('activatedlocation-membership').value;
        const prescreptionid = document.getElementById('doctor-membership').value;

        let hasError = false;
        if (!customerId || !assistantDoctorId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            hasError = true;
        }

        const selectedMemberships = [];
        document.querySelectorAll('.product-table-wrapper-membership').forEach(wrapper => {
            const membershipId = wrapper.getAttribute('data-id-membership');
            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const sm = wrapper.querySelector('.total-tm').value;
            const bm = wrapper.querySelector('.total-bm').textContent;
            const tm = wrapper.querySelector('.total-tm').value;
            const admin = wrapper.querySelector('.total-admin').textContent;

            const term = wrapper.querySelector('.total-term').textContent;
            const monthly = wrapper.querySelector('.total-monthly').textContent;
            const firstmonth = wrapper.querySelector('.total-firstmonth').textContent;
            const lastmonth = wrapper.querySelector('.total-lastmonth').textContent;

            const remarks = wrapper.querySelector('.remarks').value;

            selectedMemberships.push({
                membershipId,
                total,
                updateuserId: 1,
                sm,
                bm,
                tm,
                admin,
                term,
                monthly,
                firstmonth,
                lastmonth,
                remarks
            });
        });

        if (selectedMemberships.length === 0) {
            alert('Product package belum ditambahkan!');
            hasError = true;
        }



        // Ambil metode pembayaran
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-membership tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount-membership').value;
            const producttreatmentid = method.querySelector('.product-membership-id').value;

            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                producttreatmentid,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }


        // cek apabila point yang dimasukkan melebihi point customer
        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }

        const transactionData = {
            customerId,
            assistantDoctorId,
            frontDeskId,
            doctorId,
            beauticianId,
            prescreptionid,
            salesLocationId,
            activatedLocationId,
            updateuserId: 1,
            memberships: selectedMemberships,
            payments: paymentMethods
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];

        $.ajax({
            url: "<?= base_url() . 'App/saveMembershipTransactionDownPayment' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    response.invoicehdrids.forEach(function (id) {
                        // if (locationIdInvoice == 12) {
                        //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/4/" + id, "_blank");
                        // } else {
                        window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummaryDownPayment/${today}/${customerId}`, "_blank");
                        // }
                        // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/4/" + id, "_blank");

                    });

                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    function saveMembershipTransactionSettlement() {
        const customerId = document.getElementById('customer-id-membership').value;
        const assistantDoctorId = document.getElementById('assistent-docter-membership').value;
        const frontDeskId = document.getElementById('frontdeskid-membership').value;
        const doctorId = document.getElementById('docter-membership').value;
        const beauticianId = document.getElementById('assistandbybeautician-membership').value;
        const salesLocationId = document.getElementById('saleslocation-membership').value;
        const activatedLocationId = document.getElementById('activatedlocation-membership').value;
        const prescreptionid = document.getElementById('doctor-membership').value;



        const downPaymentId = document.getElementById('downpayment-id-membership').value;

        let hasError = false;
        if (!customerId || !assistantDoctorId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }


        let membershipId = 0;
        const selectedMemberships = [];
        document.querySelectorAll('.membership-table-wrapper-settlement').forEach(wrapper => {
            membershipId = wrapper.querySelector('.data-id-membership').textContent;
            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const sm = wrapper.querySelector('.total-sm').textContent;
            const bm = wrapper.querySelector('.total-bm').textContent;
            const tm = wrapper.querySelector('.total-tm').textContent;
            const admin = wrapper.querySelector('.total-admin').textContent;

            const term = wrapper.querySelector('.total-term').textContent;
            const monthly = wrapper.querySelector('.total-monthly').textContent;
            const firstmonth = wrapper.querySelector('.total-firstmonth').textContent;
            const lastmonth = wrapper.querySelector('.total-lastmonth').textContent;
            const remarks = wrapper.querySelector('.remarks').value;
            selectedMemberships.push({
                membershipId,
                total,
                updateuserId: 1,
                sm,
                bm,
                tm,
                admin,
                term,
                monthly,
                firstmonth,
                lastmonth,
                remarks
            });
        });

        if (selectedMemberships.length === 0) {
            alert('Product package belum ditambahkan!');
            hasError = true;
        }



        // Ambil metode pembayaran
        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-retailSettlementPelunasan tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = parseInt(method.querySelector('.payment-amount').value);

            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
                producttreatmentid: membershipId
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        let remaining = 0;
        document.querySelectorAll('.payment-method-list-membershipSettlement tbody tr').forEach(method => {
            const type = 6;
            const edc = method.querySelector('.edc').textContent;
            const cardType = method.querySelector('.card-type').textContent;
            const bankName = method.querySelector('.bank-name').textContent;

            const installment = method.querySelector('.installment').textContent;
            const amount = parseInt(method.querySelector('.payment-amount').textContent.replace(/\./g, ''), 10);

            remaining = parseInt(method.querySelector('.remaining').textContent.replace(/\./g, ''), 10);


            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
                producttreatmentid: membershipId
            });
        });


        const totalAmount = paymentMethods
            .filter(item => item.paymentid !== 6) // Filter data dengan paymentid bukan 6
            .reduce((sum, item) => sum + item.amount, 0); // Menjumlahkan amount

        console.log(totalAmount, 'and', remaining);

        if (totalAmount != remaining) {
            alert(`Total amount tidak balance!`);
            hasError = true;
        }

        const transactionData = {
            customerId,
            assistantDoctorId,
            frontDeskId,
            doctorId,
            beauticianId,
            prescreptionid,
            salesLocationId,
            activatedLocationId,
            updateuserId: 1,
            memberships: selectedMemberships,
            payments: paymentMethods,
            downPaymentId
        };

        console.log(transactionData);
        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];

        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceMembershipTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    response.invoicehdrids.forEach(function (id) {
                        // if (locationIdInvoice == 12) {
                        //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/3/" + id, "_blank");
                        // } else {
                        window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                        // }
                        // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/3/" + id, "_blank");
                        // window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }
    // TRANSAKSI DP/FULL/SETTLEMENT MEMBERSHIP

    // TRANSAKSI DP/FULL/SETTLEMENT RETAIL
    function saveRetailTransaction() {
        const customerId = document.getElementById('customer-id-retail').value;
        const consultantId = document.getElementById('consultanid-retail').value;
        const frontDeskId = document.getElementById('frontdeskid-retail').value;
        const prescriptionId = document.getElementById('prescriptionid-retail').value;
        const bcId = document.getElementById('bcid-retail').value;
        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        let totalSum = 0
        document.querySelectorAll('#selectedProducts tbody tr').forEach(row => {
            const productId = row.getAttribute('data-id');
            const jumlah = row.querySelector('.jumlah-input').value;
            const diskon = row.querySelector('.diskon-input').value;
            const totalDiscount = parseInt(row.querySelector('.total-discount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(row.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(row.querySelector('.per-price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(row.querySelector('.diskon-value').value.replace(/\./g, ''), 10);

            const remarks = row.querySelector('.remarks').value;

            let discReasonId, diskonReason;

            if (totalDiscount > 0) {
                const discReasonSelect = row.querySelector('.discount-reason');
                discReasonId = discReasonSelect.value;
                diskonReason = discReasonSelect.options[discReasonSelect.selectedIndex].text;

                // Misalnya, option default yang tidak valid memiliki value kosong atau teks "Disc Reason"
                if (discReasonId === "" || diskonReason === "" || diskonReason === "Disc Reason") {
                    alert("Silahkan pilih alasan diskon!");
                    hasError = true;
                    // Bisa ditambahkan logic untuk menghentikan submit form atau proses selanjutnya
                }
            } else {
                // Jika totalDiscount nol, meskipun ada pilihan, kita tetapkan sebagai null
                discReasonId = null;
                diskonReason = null;
            }

            totalSum += total;

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                price,
                totalDiscount,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product retail belum ditambahkan!');
            hasError = true;
        }

        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-retail tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount-retail').value;


            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }


        let totalPaymentAmount = paymentMethods.reduce((acc, payment) => acc + parseInt(payment.amount), 0);
        let totalProductAmount = selectedProducts.reduce((acc, product) => acc + parseInt(product.total), 0);

        if (totalPaymentAmount !== totalProductAmount) {
            alert('Total pembayaran tidak seimbang dengan total produk!');
            hasError = true;
        }

        // Data yang akan dikirim ke server
        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            prescriptionId,
            bcId,
            totalAmount: totalSum,
            locationId: 1,
            updateuserid: 1,
            products: selectedProducts,
            payments: paymentMethods,
            downPaymentId: null
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];


        // Kirim data ke server
        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceRetailTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    // if (locationIdInvoice == 12) {
                    // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/5/" + response.invoicehdrids, "_blank");
                    // } else {
                    window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                    // }

                    // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/5/" + response.invoicehdrids, "_blank");
                    // window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");

                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    function saveRetailTransactionDownPayment() {
        const customerId = document.getElementById('customer-id-retail').value;
        const consultantId = document.getElementById('consultanid-retail').value;
        const frontDeskId = document.getElementById('frontdeskid-retail').value;
        const prescriptionId = document.getElementById('prescriptionid-retail').value;
        const bcId = document.getElementById('bcid-retail').value;
        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        let totalSum = 0
        document.querySelectorAll('#selectedProducts tbody tr').forEach(row => {
            const productId = row.getAttribute('data-id');
            const jumlah = row.querySelector('.jumlah-input').value;
            const diskon = row.querySelector('.diskon-input').value;
            const totalDiscount = parseInt(row.querySelector('.total-discount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(row.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(row.querySelector('.per-price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(row.querySelector('.diskon-value').value.replace(/\./g, ''), 10);

            const remarks = row.querySelector('.remarks').value;

            let discReasonId, diskonReason;

            if (totalDiscount > 0) {
                const discReasonSelect = row.querySelector('.discount-reason');
                discReasonId = discReasonSelect.value;
                diskonReason = discReasonSelect.options[discReasonSelect.selectedIndex].text;

                // Misalnya, option default yang tidak valid memiliki value kosong atau teks "Disc Reason"
                if (discReasonId === "" || diskonReason === "" || diskonReason === "Disc Reason") {
                    alert("Silahkan pilih alasan diskon!");
                    hasError = true;
                    // Bisa ditambahkan logic untuk menghentikan submit form atau proses selanjutnya
                }
            } else {
                // Jika totalDiscount nol, meskipun ada pilihan, kita tetapkan sebagai null
                discReasonId = null;
                diskonReason = null;
            }

            totalSum += total;

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                price,
                totalDiscount,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product retail belum ditambahkan!');
            hasError = true;
        }

        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-retail tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = method.querySelector('.payment-amount-retail').value;


            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        const globalPointCustomer = $('#customer-point').val();
        const globalPointCustomerMedis = $('#customer-pointmedis').val();
        const globalPointCustomerNonMedis = $('#customer-pointnonmedis').val();

        const totalPointNeeded = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 39) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 73) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        const totalPointNeededNonMedis = paymentMethods.reduce((acc, method) => {
            if (method.paymentid == 74) {
                return acc + parseInt(method.amount);
            }
            return acc;
        }, 0);

        if (totalPointNeeded > globalPointCustomer) {
            alert('Jumlah point tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededMedis > globalPointCustomerMedis) {
            alert('Jumlah point medis tidak mencukupi!');
            hasError = true;
        }

        if (totalPointNeededNonMedis > globalPointCustomerNonMedis) {
            alert('Jumlah point non medis tidak mencukupi!');
            hasError = true;
        }
        // Data yang akan dikirim ke server
        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            prescriptionId,
            bcId,
            totalAmount: totalSum,
            locationId: 1,
            updateuserid: 1,
            products: selectedProducts,
            payments: paymentMethods
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];


        // Kirim data ke server
        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceRetailTransactionDownPayment' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    // if (locationIdInvoice == 12) {
                    //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/6/" + response.invoicehdrids, "_blank");
                    // } else {
                    window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummaryDownPayment/${today}/${customerId}`, "_blank");
                    // }
                    // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/6/" + response.invoicehdrids, "_blank");
                    // window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummaryDownPayment/${today}/${customerId}`, "_blank");
                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }

    function saveRetailTransactionSettlement() {
        const customerId = document.getElementById('customer-id-retail').value;
        const consultantId = document.getElementById('consultanid-retail').value;
        const frontDeskId = document.getElementById('frontdeskid-retail').value;
        const prescriptionId = document.getElementById('prescriptionid-retail').value;
        const bcId = document.getElementById('bcid-retail').value;

        const downPaymentId = document.getElementById('downpayment-id-retail').value;

        let hasError = false;
        if (!customerId || !consultantId || !frontDeskId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            return false;
        }

        // Ambil data produk yang dipilih
        const selectedProducts = [];
        let totalSum = 0
        document.querySelectorAll('#selectedRetailSettlement tbody tr').forEach(row => {
            const productId = row.querySelector('.data-id').textContent;
            const jumlah = row.querySelector('.jumlah-input').textContent;
            const diskon = row.querySelector('.diskon-input').textContent;
            const totalDiscount = parseInt(row.querySelector('.total-discount').textContent.replace(/\./g, ''), 10);
            const total = parseInt(row.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(row.querySelector('.per-price').textContent.replace(/\./g, ''), 10);

            const diskonValue = parseInt(row.querySelector('.diskon-value').textContent.replace(/\./g, ''), 10);

            const diskonReason = row.querySelector('.discount-reason').textContent;
            const remarks = row.querySelector('.remarks').value;

            totalSum += total;

            selectedProducts.push({
                productId,
                jumlah,
                diskon,
                diskonReason,
                total,
                price,
                totalDiscount,
                diskonValue,
                remarks
            });
        });

        if (selectedProducts.length === 0) {
            alert('Product retail belum ditambahkan!');
            hasError = true;
        }

        const paymentMethods = [];
        document.querySelectorAll('.payment-method-list-retailSettlementPelunasan tbody tr').forEach(method => {
            const type = method.querySelector('.payment-type').value;
            const edc = method.querySelector('.edc').value;
            const cardType = method.querySelector('.card-type').value;
            const bankName = method.querySelector('.bank-name').value;

            const installment = method.querySelector('.installment').value;
            const amount = parseInt(method.querySelector('.payment-amount').value);

            if (type == 2) {
                if (!amount || !edc || !cardType || !bankName || !installment) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 3) {
                if (!amount || !edc || !cardType) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == 8) {
                if (!amount || !edc) {
                    alert('Lengkapi data payment!');
                    hasError = true;
                }
            }

            if (type == "") {
                alert('Lengkapi data payment!');
                hasError = true;

            }

            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        if (paymentMethods.length === 0) {
            alert('Silakan lengkapi metode pembayaran!');
            hasError = true;
        }

        let remaining = 0;
        document.querySelectorAll('.payment-method-list-retailSettlement tbody tr').forEach(method => {
            const type = 6;
            const edc = method.querySelector('.edc').textContent;
            const cardType = method.querySelector('.card-type').textContent;
            const bankName = method.querySelector('.bank-name').textContent;

            const installment = method.querySelector('.installment').textContent;
            const amount = parseInt(method.querySelector('.payment-amount').textContent.replace(/\./g, ''), 10);

            remaining = parseInt(method.querySelector('.remaining').textContent.replace(/\./g, ''), 10);


            paymentMethods.push({
                amount,
                paymentid: type,
                edcid: edc,
                cardid: cardType,
                cardbankid: bankName,
                updateuserid: 1,
                installment,
            });
        });

        const totalAmount = paymentMethods
            .filter(item => item.paymentid !== 6) // Filter data dengan paymentid bukan 6
            .reduce((sum, item) => sum + item.amount, 0); // Menjumlahkan amount

        console.log(totalAmount, 'dan', remaining);

        if (totalAmount != remaining) {
            alert(`Total amount tidak balance!`);
            hasError = true;
        }

        // Data yang akan dikirim ke server
        const transactionData = {
            customerId,
            consultantId,
            frontDeskId,
            prescriptionId,
            bcId,
            totalAmount: totalSum,
            locationId: 1,
            updateuserid: 1,
            products: selectedProducts,
            payments: paymentMethods,
            downPaymentId
        };

        console.log(transactionData);

        if (hasError) {
            return false; // Menghentikan fungsi jika ada error
        }

        const today = new Date().toISOString().split('T')[0];


        // Kirim data ke server
        $.ajax({
            url: "<?= base_url() . 'App/saveInvoiceRetailTransaction' ?>",
            type: 'POST',
            data: JSON.stringify(transactionData),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                console.log(response, 'response');
                alert('berhasil menambahkan transaksi');

                if (response.status === 'success' && response.invoicehdrids) {
                    // if (locationIdInvoice == 12) {
                    //     window.open("https://sys.eudoraclinic.com:84/app/printinvoice/5/" + response.invoicehdrids, "_blank");
                    // } else {
                    window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                    // }
                    // window.open("https://sys.eudoraclinic.com:84/app/printinvoice/5/" + response.invoicehdrids, "_blank");
                    // window.open(`https://sys.eudoraclinic.com:84/app/printinvoiceSummary/${today}/${customerId}`, "_blank");
                    setTimeout(function () {
                        location.reload();
                    }, 200);
                }

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Terjadi kesalahan saat mengirim data.');
            }
        });
    }
    // TRANSAKSI DP/FULL/SETTLEMENT RETAIL
</script>

<script>
    function validateNumberInput(input) {
        input.value = input.value
            .replace(/[^0-9]/g, '')
    }
</script>

<script>
    $(document).ready(function () {
        $("#form-add-employee").submit(function (e) {
            e.preventDefault(); // Mencegah form submit secara normal

            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr("action"),
                type: "POST",
                data: formData,
                dataType: "json", // Respons dari server harus JSON
                beforeSend: function () {
                    $("#btn-simpan").prop("disabled", true).text("Menyimpan...");
                    $("#alert-container").html(""); // Bersihkan pesan lama
                },
                success: function (response) {
                    console.log(response);

                    var alertClass = "alert-danger";
                    if (!response.success) {
                        $("#alert-container").html(
                            '<div class="alert ' + alertClass + ' text-center">' + response.message + "</div>"
                        );
                    }
                    if (response.success) {
                        $("#form-add-employee")[0].reset(); // Reset form jika berhasil
                        $("#newCustomerModal").modal("hide");
                        $("#successModal").modal("show");
                    }
                },
                error: function () {
                    $("#alert-container").html(
                        '<div class="alert alert-danger text-center">Terjadi kesalahan pada server</div>'
                    );
                },
                complete: function () {
                    $("#btn-simpan").prop("disabled", false).text("SUBMIT");
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        let tableR = $('#tbl-detailpaket').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
            "ordering": false,
            "bAutoWidth": false
        });

        $(document).on("click", ".detail-btn-membership", function () {
            var packageid = $(this).data("id");

            $.ajax({
                url: "<?= base_url('App/getDetailPackage'); ?>", // Sesuaikan dengan URL Controller
                type: "GET",
                data: {
                    packageid: packageid
                },
                dataType: "json",
                success: function (response) {
                    tableR.clear().draw();

                    let dataSet = [];

                    response.forEach(function (row) {
                        dataSet.push([
                            `<td class="text-center">${row.TRNAME}</td>`,
                            `<td class="text-center">${row.TTPM}</td>`
                        ]);
                    });

                    tableR.rows.add(dataSet).draw();

                    $("#detailPaket").modal("show");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: ", error);
                    alert("Terjadi kesalahan saat mengambil data.");
                }
            });
        });
    });

    function goToDetail(id) {
        let base_url = "<?= base_url('customerDetail'); ?>";
        let queryParams = new URLSearchParams({
            customerId: id,
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".copy-btn-refferal").forEach(button => {
            button.addEventListener("click", function () {
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