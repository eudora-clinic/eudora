<style>
    #loading-indicator {
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
$level = $this->session->userdata('level');

$talent_list = [];

if ($searchCustomer != "") {
    $talent_list = $db_oriskin->query("Exec spClinicFindCustomer '" . $searchCustomer . "' ")->result_array();
}

?>


<div class="mycontaine">
    <div>
        <div class="">
            <div class="card p-2 col-md-6">
                <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
                    <div class="row">
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
        </div>

        <div id="customerInformation">
            <div class="table-responsive">
                <table id="existingcustomer" class="table table-striped table-bordered" style="width:100%">
                    <thead class="bg-thead">
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">First Name</th>
                            <th style="text-align: center">Last Name</th>
                            <th style="text-align: center">customer by</th>
                            <th style="text-align: center">Member ID</th>
                            <th style="text-align: center">Origin</th>
                            <th style="text-align: center">HP</th>
                            <th style="text-align: center">First Visit</th>
                            <th style="text-align: center">Privilege</th>
                            <th style="text-align: center">Point</th>
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
                                <td><?= $row['CUSTOMERBY'] ?></td>
                                <td><?= $row['MEMBERID'] ?></td>
                                <td><?= $row['ORIGINCUSTOMER'] ?></td>
                                <td><?= $row['CELLPHONE'] ?></td>
                                <td><?= $row['FIRSTVISIT'] ?></td>
                                <td><?= $row['PRIVILEGE'] ?></td>
                                <td><?= number_format($row['TOTALPOINT'], 0, ',', ',') ?></td>
                                <td><button class="copy-btn-refferal"
                                        data-text="https://sys.eudoraclinic.com:84/customer/dashboard/<?= $row['IDFROMDB'] ?>">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </td>
                                <td>
                                    <?php if ($level == 5) { ?>
                                        <button class="btn btn-primary btn-sm use-btn-customer"
                                            style="background-color: #e0bfb2; color: black;">TRANSACTION</button>
                                    <?php } ?>
                                    <a class="btn btn-primary btn-sm"
                                        href="https://sys.eudoraclinic.com:84/customer/erm_ref/<?= $row['IDFROMDB'] ?>"
                                        target="_blank">DETAIL</a>
                                    <button class="btn-primary btn btn-sm"
                                        onclick="goToDetail(<?= $row['IDFROMDB'] ?>)">UPDATE</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($level == 5) { ?>
            <input type="text" name="customer-point" id="customer-point" hidden>
            <div class="mt-2" id="role-information">
                <div class="card p-4">
                    <div class="form-row">
                        <!-- Kolom Kiri (3 elemen) -->
                        <div class="form-column">
                            <label for="customer-name-treatment" class="form-label mt-2"><strong>Customer
                                    Name</strong></label>
                            <input type="text" name="customer-name-treatment" id="customer-name-treatment" disabled>
                            <input type="text" name="customer-id-treatment" id="customer-id-treatment" hidden>
                            <input type="text" name="downpayment-id-treatment" id="downpayment-id-treatment" hidden>

                            <label for="bcid-treatment" class="form-label mt-2 hidden"><strong>BEAUTY
                                    CONSULTANT:</strong></label>
                            <select id="bcid-treatment" name="bcid-treatment" class="hidden" required="true"
                                aria-required="true">
                                <option value="">Select a Beauty Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Kolom Kanan (2 elemen) -->
                        <div class="form-column">
                            <label for="assistenid-treatment" class="form-label mt-2"
                                hidden><strong>BEAUTICIAN:</strong></label>
                            <select id="assistenid-treatment" name="assistenid-treatment" class="hidden" required="true"
                                aria-required="true">
                                <option value="">Select a Beautician</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="frontdeskid-treatment" class="form-label mt-2 hidden"><strong>CSO:</strong></label>
                            <select id="frontdeskid-treatment" name="frontdeskid-treatment" class="hidden" required="true"
                                aria-required="true">
                                <option value="">Select a CSO</option>
                                <?php foreach ($frontdesk_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-column">
                            <label for="consultanid-treatment" class="form-label mt-2"
                                hidden><strong>CONSULTANT:</strong></label>
                            <select id="consultanid-treatment" name="consultanid-treatment" class="hidden" required="true"
                                aria-required="true">
                                <option value="">Select a Treatment Consultant:</option>
                                <?php foreach ($consultant_list as $j) { ?>
                                    <option value="<?= $j['id'] ?>" <?= (isset($input['cityid']) && $input['cityid'] == $j['id'] ? 'selected' : '') ?>><?= $j['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="mt-2" id="role-treatment">
                <div class="card">
                    <h5 class="text-secondary mb-2 mt-2 text-center" style="font-weight: bold;">
                        <i class="bi bi-wallet2"></i> LIST TREATMENT
                    </h5>
                    <div class="table-wrapper p-4">
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

            <div id="productTablesContainer" class="mt-2">
                <!-- Tabel dinamis akan ditambahkan di sini -->
            </div>
        <?php } ?>
    </div>
    <?php if ($level == 5) { ?>
        <button type="button" class="btn btn-primary mb-4" onclick="saveTreatmentTransaction()"
            style="background-color: #c49e8f; color: black;">Save Transaction</button>
    <?php } ?>
</div>

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

                            <form id="form-add-employee" action="<?= base_url() . 'App/insertTalentMarketing' ?>">
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
                                            <label class="form-label">Jenis Kelamin <span
                                                    class="text-danger">*</span></label>
                                            <select style="font-size: 12px !important;" id="sex" name="sex"
                                                class="form-select" required>
                                                <option value="F">FEMALE</option>
                                                <option value="M">MALE</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Cabang Eudora <span
                                                    class="text-danger">*</span></label>
                                            <select style="font-size: 12px !important;" id="locationId"
                                                name="locationId" class="form-select" required>
                                                <?php foreach ($location_list as $j) { ?>
                                                    <option value="<?= $j['id'] ?>" <?= (isset($input['locationId']) && $input['locationId'] == $j['id'] ? 'selected' : '') ?>>
                                                        <?= $j['name'] ?>
                                                    </option>
                                                <?php } ?>
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

                                    <input type="hidden" id="dateofbirth" name="dateofbirth" value="">
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


</div>

<script>
    $(document).ready(function () {
        let table = $('#existingcustomer').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 10, 15, 20, 25],
            select: true,
            "bAutoWidth": false,
            "dom": '<"row"<"col-sm-6"B><"col-sm-6"f>>rtip',
            "buttons": [{
                text: 'New Customer',
                className: 'btn btn-primary btn-sm',
                action: function () {
                    $('#newCustomerModal').modal('show');
                }
            }]
        });

        // Pastikan tombol muncul di bagian wrapper DataTable
        table.buttons().container().appendTo('#existingcustomer_wrapper .col-sm-6:eq(0)');


        $('#listproduct').DataTable({
            "pageLength": 2,
            "lengthMenu": [2, 8, 16, 32, 64],
            select: true,
            'bAutoWidth': false,

        });

        $('#tableDailySales').removeClass('display').addClass(
            'table table-striped table-hover table-compact');
    });
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

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let globalPointCustomer = 0;

        document.querySelectorAll('.use-btn-customer').forEach(button => {
            button.addEventListener('click', function () {
                const row = this.closest('tr'); // Mengambil baris yang berisi tombol yang diklik
                const customerName = row.cells[1].textContent + " " + row.cells[2].textContent; // Mengambil First Name + Last Name
                const customerId = row.cells[0].textContent; // Mengambil ID

                const pointCustomer = row.cells[8].textContent.replace(/,/g, '');
                const globalPointCustomer = parseInt(pointCustomer, 10);

                console.log(customerName, customerId, pointCustomer, globalPointCustomer);


                document.getElementById('customer-point').value = pointCustomer;

                document.getElementById('customer-name-treatment').value = customerName;
                document.getElementById('customer-id-treatment').value = customerId;
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
                        </div>
                    </div>
                `;

                const container = document.getElementById("productTablesContainer");
                container.insertAdjacentHTML("beforeend", newTableHtml);

                const newTable = container.lastElementChild;

                // Event listener untuk input jumlah dan diskon
                const updateTotal = () => {
                    const jumlah = parseFloat(newTable.querySelector(".jumlah-input").value) || 0;
                    const price = data.price;
                    const total = jumlah * price;


                    newTable.querySelector(".total-column").innerText = Number(total).toLocaleString('id-ID');
                };

                newTable.querySelector(".jumlah-input").addEventListener("input", updateTotal);


                // Event listener untuk tombol "Hapus"
                newTable.querySelector(".remove-btn").addEventListener("click", function () {
                    const wrapper = this.closest(".product-table-wrapper");
                    const productId = wrapper.getAttribute("data-id");

                    usedProductIds = usedProductIds.filter((id) => id !== productId);
                    wrapper.remove();
                });
            });
        });
    })

    function saveTreatmentTransaction() {
        const customerId = document.getElementById('customer-id-treatment').value;
        const consultantId = document.getElementById('consultanid-treatment').value;
        const frontDeskId = document.getElementById('frontdeskid-treatment').value;
        const assistantId = document.getElementById('assistenid-treatment').value;
        const bcId = document.getElementById('bcid-treatment').value;

        let hasError = false;
        if (!customerId) {
            alert('Silakan lengkapi informasi Invoice Header!');
            hasError = true;
        }

        const selectedProducts = [];
        const paymentMethods = [];
        document.querySelectorAll('.product-table-wrapper').forEach(wrapper => {
            const productId = wrapper.getAttribute('data-id');
            const jumlah = wrapper.querySelector('.jumlah-input').value;

            const total = parseInt(wrapper.querySelector('.total-column').textContent.replace(/\./g, ''), 10);
            const price = parseInt(wrapper.querySelector('.per-price').textContent.replace(/\./g, ''), 10);


            discReasonId = null;
            diskonReason = null;


            selectedProducts.push({
                productId,
                jumlah,
                diskon: 0,
                diskonReason: "",
                total,
                totalDiscount: 0,
                price,
                discReasonId,
                diskonValue: 0
            });

            paymentMethods.push({
                amount: total,
                producttreatmentid: productId,
                paymentid: 53,
                edcid: "",
                cardid: "",
                cardbankid: "",
                updateuserid: 1,
                installment: "",
            });
        });


        const transactionData = {
            customerId,
            consultantId: 1109,
            frontDeskId: 1109,
            assistantId,
            bcId,
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
                    var response = JSON.parse(responseText); // Konversi string ke JSON
                    console.log('Parsed Response:', response);
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

    function goToDetail(id) {
        let base_url = "<?= base_url('customerDetail'); ?>";
        let queryParams = new URLSearchParams({
            customerId: id,
        }).toString();

        window.location.href = base_url + "?" + queryParams;
    }
</script>