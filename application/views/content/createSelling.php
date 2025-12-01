<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Create Transaction</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 10px;
            padding: 0;

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


        @media (min-width: 992px) {
            .mycontainer {
                width: 108.5vw;
                transform: scale(0.90);
            }

        }
    </style>

    <?php

    $db_oriskin = $this->load->database('oriskin', true);
    $location_id = $this->session->userdata('locationid');
    $type_list = $db_oriskin->query("select id, name from mstalenttype order by id")->result_array();
    $location_list = $db_oriskin->query("select id, name from mslocationonline where isactive='true' and name not like '%NEW TRIX%' and name NOT LIKE'%ON PROGRESS'
	AND id not in(1) order by id")->result_array();
    $gender_list = $db_oriskin->query("select id, name from msgender  order by id")->result_array();
    $city_list = $db_oriskin->query("select id, name from msguestlogadvtracking where isactive='true'  order by id")->result_array();
    $province_list = $db_oriskin->query("select id, name from msprovince  order by id")->result_array();

    $searchCustomer = $this->input->get('searchString');
    $talent_list = [];

    if ($searchCustomer != "") {
        $talent_list = $db_oriskin->query("Exec spClinicFindCustomer '" . $searchCustomer . "' ")->result_array();
    }

    $product_membership_list = $db_oriskin->query("select a.id, a.name, b.subscriptionmonth, b.bonusmonth, b.totalmonth, b.registrationfee, b.termprice, b.totalprice, b.monthlyfee, b.firstmonthfee, b.lastmonthfee from msproductmembershiphdr a inner join msproductmembershipdtl b on a.id = b.id where a.isactive = 1 order by a.id")->result_array();

    $product_treatment_list = $db_oriskin->query("select * from mstreatment where isactive = 1 order by id")->result_array();

    $product_retail_list = $db_oriskin->query("select * from msproduct where isactive = 1 order by id")->result_array();

    $city_list = $db_oriskin->query("select id, name from msguestlogadvtracking where isactive='true'  order by id")->result_array();

    $payment_list = $db_oriskin->query("select id, name from  mspaymenttype where isactive  = 1 order by id")->result_array();

    $card_list = $db_oriskin->query("select id, name from  mscard where isactive  = 1 order by id")->result_array();

    $bank_list = $db_oriskin->query("select id, name from  msbank order by id")->result_array();

    $installment_list = $db_oriskin->query("select id, name from  msinstallment where isactive  = 1 order by id")->result_array();

    $edc_list = $db_oriskin->query("select id, name from  msedc where isactive  = 1 and locationid = $location_id order by name")->result_array();

    $consultant_list = $db_oriskin->query("select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid inner join msjob c on b.jobid = c.id where b.locationid  = $location_id and a.isactive  = 1 and c.name like '%CONSULTANT%' order by a.name")->result_array();

    $frontdesk_list = $db_oriskin->query("select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid inner join msjob c on b.jobid = c.id where b.locationid  = $location_id and a.isactive  = 1 and c.name like '%FRONT DESK%' order by a.name")->result_array();

    $doctor_list = $db_oriskin->query("select a.id, a.name from msemployee a inner join msemployeedetail b on a.id = b.employeeid inner join msjob c on b.jobid = c.id where b.locationid  = $location_id and a.isactive  = 1 and c.name = 'DOKTER' order by a.name")->result_array();

    $discount_reason_list = $db_oriskin->query("select * from msdiscountreason where isactive = 1")->result_array();



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
    ?>
</head>

<body>
    <div class="mycontaine">
        <div>
            <!-- Search Form -->
            <div class="row" style="justify-content: space-around;">
                <div class="card p-2 col-md-6">
                    <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                        <div class="row g-3" style="display: flex; align-items: center;">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control text-uppercase" name="searchString" id="searchString" placeholder="Name / HP / SSID / Customer Code / Member Code" required>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn w-100 btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Transaction Type -->
                <div class="card p-2 col-md-5">
                    <div class="">
                        <select id="transactionType" name="transactionType" class="form-select text-center" required onchange="changeSPJob(this.value)" style="font-size: 14px !important; font-weight: 500;">
                            <option value="0">TRANSACTION TYPE</option>
                            <option value="1">TREATMENT</option>
                            <option value="2">MEMBERSHIP</option>
                            <option value="3">PRODUCT</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div>
                <div class="table-wrapper card p-4">
                    <table id="existingcustomer" class="table table-striped table-bordered">
                        <thead class="bg-thead">
                            <tr>
                                <th style="text-align: center">ID</th>
                                <th style="text-align: center">First Name</th>
                                <th style="text-align: center">Last Name</th>
                                <th style="text-align: center">Member ID</th>
                                <th style="text-align: center">Origin</th>
                                <th style="text-align: center">HP</th>
                                <th style="text-align: center">Privilege</th>
                                <th style="text-align: center">Point</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($talent_list as $row) { ?>
                                <tr>
                                    <td><?= $row['IDFROMDB'] ?></td>
                                    <td><?= $row['FIRSTNAME'] ?></td>
                                    <td><?= $row['LASTNAME'] ?></td>
                                    <td><?= $row['MEMBERID'] ?></td>
                                    <td><?= $row['ORIGINCUSTOMER'] ?></td>
                                    <td><?= $row['CELLPHONE'] ?></td>
                                    <td><?= $row['PRIVILEGE'] ?></td>
                                    <td><?= number_format($row['TOTALPOINT'], 0, ',', ',') ?></td>

                                    <td>
                                        <button class="btn btn-primary btn-sm use-btn-customer" style="background-color: #e0bfb2; color: black;">TRANSACTION</button>
                                        <a class="btn btn-primary btn-sm" href="https://103.31.233.78:84/historymember/erm_ref/<?= $row['IDFROMDB'] ?>">DETAIL</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>





            <!-- INVOICE HEADER -->
            <input type="text" name="customer-point" id="customer-point" hidden>
            <div class="row hidden mt-2" id="role-information">
                <div class="card p-4">
                    <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                        <i class="bi bi-wallet2"></i> Invoice Treatment Header
                    </h6>
                    <div class="form-row">
                        <!-- Kolom Kiri (3 elemen) -->
                        <div class="form-column">
                            <label for="customer-name-treatment" class="form-label mt-2"><strong>Customer Name</strong></label>
                            <input type="text" name="customer-name-treatment" id="customer-name-treatment" disabled>
                            <input type="text" name="customer-id-treatment" id="customer-id-treatment" hidden>

                            <label for="bcid-treatment" class="form-label mt-2"><strong>BC:</strong></label>
                            <select id="bcid-treatment" name="bcid-treatment" class="" required="true" aria-required="true">
                                <option value="">Select a Consultant:</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Kolom Kanan (2 elemen) -->
                        <div class="form-column">
                            <label for="assistenid-treatment" class="form-label mt-2"><strong>Assisted By Beautician:</strong></label>
                            <select id="assistenid-treatment" name="assistenid-treatment" class="" required="true" aria-required="true">
                                <option value="">Select a Beautician</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="frontdeskid-treatment" class="form-label mt-2"><strong>Front Desk:</strong></label>
                            <select id="frontdeskid-treatment" name="frontdeskid-treatment" class="" required="true" aria-required="true">
                                <option value="">Select a Front Desk</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-column">
                            <label for="consultanid-treatment" class="form-label mt-2"><strong>Treatment Consultant:</strong></label>
                            <select id="consultanid-treatment" name="consultanid-treatment" class="" required="true" aria-required="true">
                                <option value="">Select a Treatment Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hidden mt-2" id="role-information-membership">
                <div class="card p-4">

                    <h6 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold; text-transform: uppercase;">
                        <i class="bi bi-wallet2"></i> Invoice Membership Header
                    </h6>
                    <div class="form-row">
                        <!-- Kolom Kiri (3 elemen) -->
                        <div class="form-column">
                            <label for="customer-name-membership" class="form-label mt-2"><strong>Customer Name</strong></label>
                            <input type="text" name="customer-name-membership" id="customer-name-membership" disabled>
                            <input type="text" name="customer-id-membership" id="customer-id-membership" hidden>

                            <label for="assistent-docter-membership" class="form-label mt-2"><strong>Assisten Docter:</strong></label>
                            <select id="assistent-docter-membership" name="assistent-docter-membership" class="" required="true" aria-required="true">
                                <option value="">Select a Assistant Docter:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>


                        </div>

                        <!-- Kolom Kanan (2 elemen) -->
                        <div class="form-column">
                            <label for="assistandbybeautician-membership" class="form-label mt-2 "><strong>Assisted By Beautician:</strong></label>
                            <select id="assistandbybeautician-membership" name="assistandbybeautician-membership" class="" required="true" aria-required="true">
                                <option value="">Select a Beautician</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>

                            <label for="frontdeskid-membership" class="form-label mt-2"><strong>Front Desk:</strong></label>
                            <select id="frontdeskid-membership" name="frontdeskid-membership" class="" required="true" aria-required="true">
                                <option value="">Front Desk</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>

                            <label for="saleslocation-membership" class="form-label mt-2 hidden"><strong>Sales Location:</strong></label>
                            <select id="saleslocation-membership" name="saleslocation-membership" class=" hidden" required="true" aria-required="true">
                                <option value="">Sales Location</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="activatedlocation-membership" class="form-label mt-2"><strong>Activated Location:</strong></label>
                            <select id="activatedlocation-membership" name="activatedlocation-membership" class="" required="true" aria-required="true">
                                <option value="">Select For Activated Location</option>
                                <?php foreach ($location_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>


                            <label for="docter-membership" class="form-label mt-2 "><strong>Docter:</strong></label>
                            <select id="docter-membership" name="docter-membership" class="" required="true" aria-required="true">
                                <option value="">Select a Docter</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row hidden mt-2" id="role-information-retail">
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

                            <label for="consultanid-retail" class="form-label mt-2"><strong>Treatment Consultant:</strong></label>
                            <select id="consultanid-retail" name="consultanid-retail" class="" required="true" aria-required="true">
                                <option value="">Select A Beauty Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Kolom Kanan (2 elemen) -->
                        <div class="form-column">
                            <label for="prescriptionid-retail" class="form-label mt-2"><strong>Prescription By:</strong></label>
                            <select id="prescriptionid-retail" name="prescriptionid-retail" class="" required="true" aria-required="true">
                                <option value="">Select A Docter</option>
                                <?php foreach ($doctor_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>

                            <label for="bcid-retail" class="form-label mt-2"><strong>BC:</strong></label>
                            <select id="bcid-retail" name="bcid-retail" class="" required="true" aria-required="true">
                                <option value="">Select A Consultant:</option>
                                <?php foreach ($city_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-column">
                            <label for="frontdeskid-retail" class="form-label mt-2"><strong>Front Desk:</strong></label>
                            <select id="frontdeskid-retail" name="frontdeskid-retail" class="" required="true" aria-required="true">
                                <option value="">Select A Front Desk</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END INVOICE HEADER -->

            <!-- PILIHAN TREATMENT/RETAIL/MEMBERSHIP -->
            <div class="row hidden mt-2" id="role-container">
                <div class="card">
                    <h5 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold;">
                        <i class="bi bi-wallet2"></i> LIST MEMBERSHIP
                    </h5>
                    <div class="table-wrapper card p-4">
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
                                        <td>
                                            <button class="btn btn-primary btn-sm use-btn-membership">USE</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row hidden mt-2" id="role-treatment">
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

            <div class="row hidden mt-2" id="role-product">
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



        </div>
        <button type="button" class="btn btn-primary mb-4" onclick="saveTransaction()" style="background-color: #c49e8f; color: black;">Save Transaction</button>
    </div>

    <!-- untuk table dan jenis transaksi -->
    <script>
        $(document).ready(function() {
            $('#talentid').select2({
                placeholder: "Pilih Customer",
                allowClear: true
            });

            $('#existingcustomer').DataTable({
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

            });

            $('#listproduct').DataTable({
                "pageLength": 2,
                "lengthMenu": [2],
                select: true,
                'bAutoWidth': false,

            });


            $('#listproductretail').DataTable({
                "pageLength": 3,
                "lengthMenu": [3],
                select: true,
                'bAutoWidth': false,
            });
        });
    </script>

    <script>
        $('#existingcustomer').removeClass('display').addClass(
            'table table-striped table-hover table-compact');

        $('#existingproduct').removeClass('display').addClass(
            'table table-striped table-hover table-compact');


        $('#listproduct').removeClass('display').addClass(
            'table table-striped table-hover table-compact');

        $('#listproductretail').removeClass('display').addClass(
            'table table-striped table-hover table-compact');
    </script>

    <!-- untuk tombol use di treatment -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let globalPointCustomer = 0;

            document.querySelectorAll('.use-btn-customer').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr'); // Mengambil baris yang berisi tombol yang diklik
                    const customerName = row.cells[1].textContent + " " + row.cells[2].textContent; // Mengambil First Name + Last Name
                    const customerId = row.cells[0].textContent; // Mengambil ID

                    const pointCustomer = row.cells[7].textContent.replace(/,/g, '');
                    const globalPointCustomer = parseInt(pointCustomer, 10);

                    // Mengisi input dengan ID dan nama customer
                    document.getElementById('customer-point').value = pointCustomer;

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
                button.addEventListener("click", function() {
                    const row = this.closest("tr");
                    const data = {
                        id: row.cells[0].innerText.trim(),
                        code: row.cells[1].innerText.trim(),
                        name: row.cells[2].innerText.trim(),
                        price: parseInt(row.cells[3].innerText.trim().replace(/,/g, ''), 10)
                    };

                    if (usedProductIds.includes(data.id)) {
                        alert("This product has already been used!");
                        return;
                    }

                    usedProductIds.push(data.id);

                    const newTableHtml = `
                    <div class="table-wrapper product-table-wrapper card" data-id="${data.id}">
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
                                        <th style="display: none">PID</th>
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
                    const updateTotal = () => {
                        const jumlah = parseFloat(newTable.querySelector(".jumlah-input").value) || 0;
                        const diskon = parseFloat(newTable.querySelector(".diskon-input").value) || 0;

                        const diskonValue = parseFloat(newTable.querySelector(".diskon-value").value) || 0;
                        const price = data.price;

                        const diskonAmount = (diskon / 100) * (jumlah * price) + diskonValue;
                        const total = jumlah * price - diskonAmount;


                        newTable.querySelector(".total-column").innerText = Number(total).toLocaleString('id-ID');
                        newTable.querySelector(".total-discount").innerText = Number(diskonAmount).toLocaleString('id-ID');
                    };

                    newTable.querySelector(".jumlah-input").addEventListener("input", updateTotal);
                    newTable.querySelector(".diskon-input").addEventListener("input", updateTotal);
                    newTable.querySelector(".diskon-value").addEventListener("input", updateTotal);

                    // Event listener untuk tombol "Hapus"
                    newTable.querySelector(".remove-btn").addEventListener("click", function() {
                        const wrapper = this.closest(".product-table-wrapper");
                        const productId = wrapper.getAttribute("data-id");

                        usedProductIds = usedProductIds.filter((id) => id !== productId);
                        wrapper.remove();
                    });


                    newTable.querySelector(".add-payment-method").addEventListener("click", function() {
                        const paymentList = newTable.querySelector(".payment-method-list tbody");

                        const wrapper = this.closest(".product-table-wrapper");
                        const productId = wrapper.getAttribute("data-id");

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

                        paymentTypeSelect.addEventListener("change", function() {
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
                        lastPayment.querySelector(".remove-payment-method").addEventListener("click", function() {
                            lastPayment.remove();
                        });
                    });

                    // console.log(usedProductIds);
                });

                // console.log(usedProductIds);


            });

            //END FOR TREATMENTS


            //FOR MEMBERSHIP
            let usedMembershipIds = [];

            const buttonsMembership = document.querySelectorAll(".use-btn-membership");
            buttonsMembership.forEach((button) => {
                button.addEventListener("click", function() {
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
                    };

                    if (usedMembershipIds.includes(data.id)) {
                        alert("This product has already been used!");
                        return;
                    }

                    usedMembershipIds.push(data.id);

                    const newTableHtmlMembership = `
                    <div class="table-wrapper product-table-wrapper-membership card" data-id-membership="${data.id}">
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
                                        <th style="text-align: center;">Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">${data.id}</td>
                                        <td style="text-align: center;">${data.name}</td>
                                        <td style="text-align: center;" class="total-sm hidden" >${data.sm}</td>
                                        <td style="text-align: center;" class="total-bm hidden" >${data.bm}</td>
                                        <td style="text-align: center;" class="total-tm">${data.tm}</td>
                                        <td style="text-align: center;" class="total-admin hidden">${data.admin}</td>
                                        <td style="text-align: center;" class="total-term hidden" >${data.term}</td>
                                        <td style="text-align: center;" class="total-column">${Number(data.total).toLocaleString('id-ID')}</td>
                                        <td style="text-align: center;" class="total-monthly hidden" >${data.monthly.toFixed(2)}</td>
                                        <td style="text-align: center;" class="total-firstmonth hidden" >${data.firstmonth.toFixed(2)}</td>
                                        <td style="text-align: center;" class="total-lastmonth hidden" >${data.lastmonth.toFixed(2)}</td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-danger btn-sm remove-btn-membership">
                                                <i class="bi bi-trash"></i> Hapus
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

                    // Event listener untuk tombol "Hapus"
                    newTableMembership.querySelector(".remove-btn-membership").addEventListener("click", function() {
                        const wrapperMembership = this.closest(".product-table-wrapper-membership");
                        const productIdMembership = wrapperMembership.getAttribute("data-id-membership");

                        usedMembershipIds = usedMembershipIds.filter((id) => id !== productIdMembership);
                        wrapperMembership.remove();
                    });


                    newTableMembership.querySelector(".add-payment-method-membership").addEventListener("click", function() {
                        const paymentListMembership = newTableMembership.querySelector(".payment-method-list-membership");

                        const wrapperMembership = this.closest(".product-table-wrapper-membership");
                        const productIdMembership = wrapperMembership.getAttribute("data-id-membership");

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

                        paymentTypeSelect.addEventListener("change", function() {
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

                        lastPaymentMembership.querySelector(".remove-payment-method-membership").addEventListener("click", function() {
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
                button.addEventListener("click", function() {
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
                    newRowElement.querySelector(".remove-btn").addEventListener("click", function() {
                        const rowId = newRowElement.getAttribute("data-id");
                        selectedProducts = selectedProducts.filter((item) => item.id !== rowId);
                        newRowElement.remove();
                        updateGrandTotal();
                        togglePaymentButtonVisibility();
                    });

                    if (!selectedTableFoot.querySelector(".grand-total-row")) {
                        const totalRow = `
                            <tr class="grand-total-row">
                                <td colspan="8" style="text-align: right; font-weight: bold;">Grand Total:</td>
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
            document.querySelector(".add-payment-method-retail").addEventListener("click", function() {
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

                paymentTypeSelect.addEventListener("change", function() {
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

                lastPaymentRetail.querySelector(".remove-payment-method-retail").addEventListener("click", function() {
                    lastPaymentRetail.remove();
                });
            });


            //END FOR PAYMENT METHOD




            //FOR TRANSACTION TYPE
            window.changeSPJob = function(value) {
                usedProductIds = [];
                usedMembershipIds = [];
                selectedProducts = [];
                paymentMethods = [];

                console.log(globalPointCustomer);

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

                // let usedProductIds = [];

                const roleChoiceProduct = document.getElementById("role-choice-product");

                if (value == "2") {
                    roleContainer.classList.remove("hidden");
                    roleInvoiceHeaderMembership.classList.remove("hidden");
                } else {
                    roleContainer.classList.add("hidden");
                    roleInvoiceHeaderMembership.classList.add("hidden");
                }

                if (value == "1") {
                    roleTreatment.classList.remove("hidden");
                    roleInvoiceHeaderTreatment.classList.remove("hidden");
                } else {
                    roleTreatment.classList.add("hidden");
                    roleInvoiceHeaderTreatment.classList.add("hidden");
                }

                if (value == "3") {
                    roleProduct.classList.remove("hidden");
                    roleInvoiceHeaderRetail.classList.remove("hidden");
                    roleChoiceProduct.classList.remove("hidden");
                } else {
                    roleProduct.classList.add("hidden");
                    roleInvoiceHeaderRetail.classList.add("hidden");
                    roleChoiceProduct.classList.add("hidden");
                }

                console.log(usedProductIds);
            };
            //END FOR TRANSACTION TYPE

        });

        function saveTransaction() {
            const transactionType = document.getElementById('transactionType').value;

            switch (transactionType) {
                case '1': // Treatment
                    saveTreatmentTransaction();
                    break;
                case '2': // Membership
                    saveMembershipTransaction();
                    break;
                case '3': // Retail
                    saveRetailTransaction();
                    break;
                default:
                    alert('Pilih jenis transaksi terlebih dahulu!');
                    break;
            }
        }

        function saveTreatmentTransaction() {
            const customerId = document.getElementById('customer-id-treatment').value;
            const consultantId = document.getElementById('consultanid-treatment').value;
            const frontDeskId = document.getElementById('frontdeskid-treatment').value;
            const assistantId = document.getElementById('assistenid-treatment').value;
            const bcId = document.getElementById('bcid-treatment').value;

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
                    diskonValue
                });
            });

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

            // cek apabila point yang dimasukkan melebihi point customer
            const globalPointCustomer = $('#customer-point').val();
            const totalPointNeeded = paymentMethods.reduce((acc, method) => {
                if (method.paymentid == 40) {
                    return acc + parseInt(method.amount);
                }
                return acc;
            }, 0);

            if (totalPointNeeded > globalPointCustomer) {
                alert('Jumlah point tidak mencukupi!');
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
                locationId: 1,
                updateuserId: 1,
                products: selectedProducts,
                payments: paymentMethods
            };

            console.log(transactionData);

            if (hasError) {
                return false; // Menghentikan fungsi jika ada error
            }


            $.ajax({
                url: "<?= base_url() . 'App/saveInvoiceTransaction' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'text',
                success: function(responseText) {
                    try {
                        var response = JSON.parse(responseText); // Konversi string ke JSON
                        console.log('Parsed Response:', response);
                        alert('berhasil menambahkan transaksi');


                        if (response.status === 'success' && response.invoicehdrids) {
                            response.invoicehdrids.forEach(function(id) {
                                window.open("https://103.31.233.78:84/operational/printinvoice/" + id, "_blank");
                            });

                            setTimeout(function() {
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

                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }

        function saveMembershipTransaction() {
            // console.log('m');

            const customerId = document.getElementById('customer-id-membership').value;
            const assistantDoctorId = document.getElementById('assistent-docter-membership').value;
            const frontDeskId = document.getElementById('frontdeskid-membership').value;
            const doctorId = document.getElementById('docter-membership').value;
            const beauticianId = document.getElementById('assistandbybeautician-membership').value;
            const salesLocationId = document.getElementById('saleslocation-membership').value;
            const activatedLocationId = document.getElementById('activatedlocation-membership').value;

            if (!customerId || !assistantDoctorId || !frontDeskId || !activatedLocationId) {
                alert('Silakan lengkapi informasi Invoice Header!');
                return false;
            }

            const selectedMemberships = [];
            document.querySelectorAll('.product-table-wrapper-membership').forEach(wrapper => {
                const membershipId = wrapper.getAttribute('data-id-membership');
                const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
                const sm = wrapper.querySelector('.total-sm').textContent;
                const bm = wrapper.querySelector('.total-bm').textContent;
                const tm = wrapper.querySelector('.total-tm').textContent;
                const admin = wrapper.querySelector('.total-admin').textContent;

                const term = wrapper.querySelector('.total-term').textContent;
                const monthly = wrapper.querySelector('.total-monthly').textContent;
                const firstmonth = wrapper.querySelector('.total-firstmonth').textContent;
                const lastmonth = wrapper.querySelector('.total-lastmonth').textContent;
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
                });
            });



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
                        return false;
                    }
                }

                if (type == 3) {
                    if (!amount || !edc || !cardType) {
                        alert('Lengkapi data payment!');
                        return false;
                    }
                }

                if (type == 8) {
                    if (!amount || !edc) {
                        alert('Lengkapi data payment!');
                        return false;
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


            // cek apabila point yang dimasukkan melebihi point customer
            const globalPointCustomer = $('#customer-point').val();
            const totalPointNeeded = paymentMethods.reduce((acc, method) => {
                if (method.paymentid == 40) {
                    return acc + parseInt(method.amount);
                }
                return acc;
            }, 0);

            if (totalPointNeeded > globalPointCustomer) {
                alert('Jumlah point tidak mencukupi!');
                return false;
            }

            selectedMemberships.forEach(product => {
                const productAmounts = paymentMethods.filter(payment => payment.producttreatmentid == product.membershipId);
                const totalAmount = productAmounts.reduce((acc, payment) => acc + parseInt(payment.amount), 0);

                if (totalAmount != parseInt(product.total)) {
                    alert(`Total amount untuk produk ID ${product.membershipId} tidak balance!`);
                    return false;
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
                payments: paymentMethods
            };

            console.log(transactionData);

            $.ajax({
                url: "<?= base_url() . 'App/saveInvoiceMembershipTransaction' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'response');
                    alert('berhasil menambahkan transaksi');

                    if (response.status === 'success' && response.invoicehdrids) {
                        response.invoicehdrids.forEach(function(id) {
                            window.open("https://103.31.233.78:84/operational/printinvoice/" + id, "_blank");
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 200);
                    }

                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }

        function saveRetailTransaction() {
            const customerId = document.getElementById('customer-id-retail').value;
            const consultantId = document.getElementById('consultanid-retail').value;
            const frontDeskId = document.getElementById('frontdeskid-retail').value;
            const prescriptionId = document.getElementById('prescriptionid-retail').value;
            const bcId = document.getElementById('bcid-retail').value;
            let hasError = false;
            if (!customerId || !consultantId || !frontDeskId || !prescriptionId) {
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
                });
            });

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

            const globalPointCustomer = $('#customer-point').val();
            const totalPointNeeded = paymentMethods.reduce((acc, method) => {
                if (method.paymentid == 40) {
                    return acc + parseInt(method.amount);
                }
                return acc;
            }, 0);

            if (totalPointNeeded > globalPointCustomer) {
                alert('Jumlah point tidak mencukupi!');
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
                payments: paymentMethods
            };

            console.log(transactionData);

            if (hasError) {
                return false; // Menghentikan fungsi jika ada error
            }


            // Kirim data ke server
            $.ajax({
                url: "<?= base_url() . 'App/saveInvoiceRetailTransaction' ?>",
                type: 'POST',
                data: JSON.stringify(transactionData),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    console.log(response, 'response');
                    alert('berhasil menambahkan transaksi');

                    if (response.status === 'success' && response.invoicehdrids) {

                        window.open("https://103.31.233.78:84/operational/printinvoice/" + response.invoicehdrids, "_blank");


                        setTimeout(function() {
                            location.reload();
                        }, 200);
                    }

                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Terjadi kesalahan saat mengirim data.');
                }
            });
        }
    </script>

    <script>
        function validateNumberInput(input) {
            input.value = input.value
                .replace(/[^0-9]/g, '')
        }
    </script>
</body>

</html>