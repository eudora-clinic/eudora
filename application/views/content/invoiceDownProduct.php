<style>
    th {
        font-weight: bold;
    }

    /* Styling untuk tombol */
    button {
        padding: 5px 10px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    button i {
        vertical-align: middle;
        margin-right: 3px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }


    input:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
    }

    .alert {
        padding: 10px;
        border-radius: 5px;
        margin: 10px 0;
    }

    .alert-danger {
        background-color: #dc3545;
        color: white;
    }

    .close {
        background: none;
        border: none;
        font-size: 18px;
        color: white;
        cursor: pointer;
    }

    /* Styling untuk judul */
    h5 {
        font-weight: bold;
        color: #333;
        margin-top: 20px;
    }

    /* Styling untuk responsif */
    @media screen and (max-width: 768px) {

        th,
        td {
            font-size: 14px;
            padding: 8px;
        }

        button {
            font-size: 14px;
        }

        h5 {
            font-size: 16px;
        }
    }
</style>
<div class="">
    <div class="card p-2 col-md-6">
        <form id="form-cari-invoice" method="get" action="<?= current_url() ?>">
            <div class="row g-3" style="display: flex; align-items: center;">
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="text" id="nodownpayment" name="nodownpayment" class="form-control" required="true" aria-required="true" placeholder="Masukkan Invoice DP Retail" value="<?= (isset($_GET['nodownpayment']) ? $_GET['nodownpayment'] : '') ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" id="btn-cari" name="submit" class="btn btn-sm top-responsive  btn-primary" value="true">Search</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h5 class="card-header card-header-info" style=" font-weight: bold; color: #666666; font-size: 14px !important; text-transform: uppercase;">Edit Data Invoice Down Payment Product</h5>
                </div>
                <div class="card-body">
                    <div id="result" style="display: <?= (isset($_GET['submit']) ? 'block;' : 'none;') ?>">
                        <?php
                        # dibuat langsung di view untuk memudahkan 
                        # tidak dibuat di model
                        if (isset($_GET['submit'])) {
                            $nodownpayment = $this->input->get('nodownpayment');
                            # load database oriskin (lihat di config/database.php)
                            $db_oriskin = $this->load->database('oriskin', true);
                            # query
                            $query = $db_oriskin->query("SELECT a.locationid as LOCATIONID,  a.id, a.downpaymentno as INVOICENO, a.downpaymentdate as INVOICEDATE, 
                                                        a.status as STATUS, e.id as CONSULTANTID, e.name as CNAME,  
                                                        b.id as DTLID, b.total as TOTAL, b.qty as QTY
                                                from sldownpaymentproducthdr a 
                                                inner join sldownpaymentproductdtl b on a.id = b.downpaymenthdrid 
                                                inner join msemployee e on a.salesid = e.id
                                                where downpaymentno = '" . $nodownpayment . "' order by downpaymentno");
                                                
                            $queryPayment = $db_oriskin->query("SELECT 
                                    c.id as INVPAYID, c.paymentid as PAYMENTID, c.amount as AMOUNT, d.name as PAYMENTNAME, a.downpaymentno as INVOICENO
                                    from sldownpaymentproducthdr a 
                                    left join sldownpaymentproductpayment c on a.id = c.downpaymenthdrid 
                                    left join mspaymenttype d on c.paymentid = d.id
                                    where downpaymentno = '" . $nodownpayment . "' order by downpaymentno");

                            if ($query->num_rows() <= 0) {
                                echo '<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="material-icons">close</i>
												</button>
												<span>No. Invoice <strong>' . $nodownpayment . '</strong> tidak ditemukan</span>
											</div>';
                            } else {
                                $header = $query->result_array();
                                $headerPayment = $queryPayment->result_array();
                                //$detail = $db_oriskin->query("select * from slinvoicemembershiphdr where invoiceno like '%".$no_invoice."%'");

                                $employee = $db_oriskin->query("SELECT a.id as ID, a.name as NAME
                                from msemployee a inner join msemployeedetail b on a.id = b.employeeid
                                where b.locationid = '" . $header[0]['LOCATIONID'] . "' and a.isactive = 1 order by a.id")->result_array();
                            }
                        }
                        ?>
                        <h5>HEADER</h5>
                        <div class="table-wrapper">
                            <div class="material-datatables">
                                <table id="dt-invoice-membership" class="table table-bordered" cellspacing="0" width="100%" role="grid">
                                    <thead class="bg-thead">
                                        <tr role="" style="text-align: center;">
                                            <th style="text-align: center;">downpayment No</th>
                                            <th style="text-align: center;">TOTAL</th>
                                            <th style="text-align: center;">Invoice Date</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">consultant</th>
                                            <th style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($header)) {
                                            foreach ($header as $v) { ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <span id="sp-invoiceno-<?= $v['id'] ?>"><?= $v['INVOICENO'] ?></span>
                                                        <input type="text" id="invoiceno-<?= $v['id'] ?>" value="<?= $v['INVOICENO'] ?>" style="width: 100%; display: none;">
                                                    </td>
                                                    <td class="text-center">
                                                        <span><?= $v['TOTAL'] ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span id="sp-invoicedate-<?= $v['id'] ?>"><?= $v['INVOICEDATE'] ?></span>
                                                        <input type="date" id="invoicedate-<?= $v['id'] ?>" value="<?= date('Y-m-d', strtotime($v['INVOICEDATE'])) ?>" style="width: 100%; display: none;">
                                                    </td>
                                                    <td class="text-center">
                                                        <span id="sp-status-<?= $v['id'] ?>"><?= $v['STATUS'] ?></span>
                                                        <input type="text" id="status-<?= $v['id'] ?>" value="<?= $v['STATUS'] ?>" style="width: 100%; display: none;">
                                                    </td>
                                                    <td class="text-center">
                                                        <span id="sp-consultant-<?= $v['id'] ?>"><?= $v['CNAME'] ?></span>
                                                        <select id="consultant-<?= $v['id'] ?>" class="form-control" style="display: none;">
                                                            <option value="">Pilih Consultant</option>
                                                            <?php foreach ($employee as $e) { ?>
                                                                <option value="<?= $e['ID'] ?>" <?= ($e['ID'] == $v['CONSULTANTID']) ? 'selected' : '' ?>><?= $e['NAME'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                             
                                                    <td class="text-center">
                                                        <button id="btn-edit-header-<?= $v['id'] ?>" class="btn btn-sm btn-primary" onclick="editHeader('<?= $v['id'] ?>');"><i class="material-icons">edit</i> Edit</button>
                                                        <button id="btn-save-header-<?= $v['id'] ?>" class="btn btn-sm btn-success" onclick="saveHeader('<?= $v['id'] ?>');" style="display: none;"><i class="material-icons">save</i> Save</button>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <?php if ($headerPayment[0]['INVPAYID'] != NULL) { ?>
                            <h5>PAYMENT</h5>
                            <div class="table-wrapper">
                                <div class="material-datatables">
                                    <!--<table id="dt-realisasi" class="table table-striped table-no-bordered table-hover dataTable dtr-inline" cellspacing="0" width="100%" role="grid">-->
                                    <table id="payment-invoice-membership" class="table table-bordered" cellspacing="0" width="100%" role="grid">
                                        <thead class="bg-thead">
                                            <tr role="">
                                                <th style="text-align: center;">ID</th>
                                                <th style="text-align: center;">downpayment No</th>
                                                <th style="text-align: center;">payment</th>
                                                <th style="text-align: center;">amount</th>
                                                <th style="text-align: center;">action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($headerPayment)) : ?>
                                                <?php foreach ($headerPayment as $v) : ?>
                                                    <tr>
                                                        <td class="text-center">
                                                            <span id="SP-INVOICENO-ID<?= $v['INVPAYID'] ?>"><?= $v['INVPAYID'] ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span id="SP-INVOICENO-PAYMENT<?= $v['INVPAYID'] ?>"><?= $v['INVOICENO'] ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span id="SP-PAYMENTID-PAYMENT<?= $v['INVPAYID'] ?>"><?= $v['PAYMENTNAME'] ?></span>
                                                            <span id="SP-PAYMENTID-PAYMENT<?= $v['INVPAYID'] ?>" style="width: 100%; display: none;"><?= $v['PAYMENTID'] ?></span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span id="SP-AMOUNT-PAYMENT<?= $v['INVPAYID'] ?>"><?= $v['AMOUNT'] ?></span>
                                                            <input type="number" id="AMOUNT-PAYMENT<?= $v['INVPAYID'] ?>" value="<?= $v['AMOUNT'] ?>" style="width: 100%; display: none;">
                                                        </td>
                                                        <td class="text-center">
                                                            <button id="BTN-EDIT-HEADER-PAYMENT<?= $v['INVPAYID'] ?>" class="btn btn-sm btn-primary" onclick="editHeaderPayment('<?= $v['INVPAYID'] ?>', '<?= $v['PAYMENTID'] ?>');">
                                                                <i class="material-icons">edit</i> Edit Header
                                                            </button>
                                                            <button id="BTN-SAVE-HEADER-PAYMENT<?= $v['INVPAYID'] ?>" class="btn btn-sm btn-success" onclick="saveHeaderPayment('<?= $v['INVPAYID'] ?>');" style="display: none;">
                                                                <i class="material-icons">save</i> Save Header
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
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
    _mod = '<?= $mod ?>';

    function editHeader(id) {
        console.log(id);

        document.getElementById('sp-invoicedate-' + id).style.display = 'none';
        document.getElementById('invoicedate-' + id).style.display = 'block';

        document.getElementById('sp-status-' + id).style.display = 'none';
        document.getElementById('status-' + id).style.display = 'block';

        document.getElementById('sp-consultant-' + id).style.display = 'none';
        document.getElementById('consultant-' + id).style.display = 'block';

        document.getElementById('btn-edit-header-' + id).style.display = 'none';
        document.getElementById('btn-save-header-' + id).style.display = 'inline-block';
    }

    function saveHeader(id) {
        let salesid = document.getElementById('consultant-' + id).value;
        let status = document.getElementById('status-' + id).value;
        let invoicedate = document.getElementById('invoicedate-' + id).value;

        $.ajax({
            url: "<?= base_url('App/updateInvoiceHdr') ?>", // Sesuaikan dengan route Anda
            type: "POST",
            data: {
                id: id,
                salesid: salesid,
                status: status,
                invoicedate: invoicedate,
                type: 6
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                if (response.success) {
                    alert("Data berhasil diperbarui!");
                    location.reload();
                } else {
                    alert("Gagal memperbarui data!");
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert("Terjadi kesalahan saat memperbarui data.");
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#dt-invoice-membership').DataTable({
            "paging": false, // Menghilangkan pagination
            "searching": false, // Menghilangkan fitur pencarian
            "info": false, // Menghilangkan informasi jumlah data
            "ordering": false,
            "bAutoWidth": false
        });

        $('#payment-invoice-membership').DataTable({
            "paging": false, // Menghilangkan pagination
            "searching": false, // Menghilangkan fitur pencarian
            "info": false, // Menghilangkan informasi jumlah data
            "ordering": false,
            "bAutoWidth": false
        });
    });
</script>


<script>
    function editHeaderPayment(id, selectedPaymentId) {
        $("#SP-PAYMENTID-PAYMENT" + id).hide();
        $("#SP-AMOUNT-PAYMENT" + id).hide();
        $("#BTN-EDIT-HEADER-PAYMENT" + id).hide();
        $("#BTN-SAVE-HEADER-PAYMENT" + id).show();

        // Ambil daftar payment type dari mspaymenttype
        $.ajax({
            url: "<?= base_url('App/getPaymentTypes') ?>",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let selectHtml = '<select id="PAYMENTID-PAYMENT' + id + '" class="form-control">';
                response.forEach(function(payment) {
                    let selected = (payment.id == selectedPaymentId) ? 'selected' : '';
                    selectHtml += '<option value="' + payment.id + '" ' + selected + '>' + payment.name + '</option>';
                });
                selectHtml += '</select>';
                $("#SP-PAYMENTID-PAYMENT" + id).after(selectHtml);
            }
        });

        $("#AMOUNT-PAYMENT" + id).show();
    }

    function saveHeaderPayment(id) {
        let paymentType = $("#PAYMENTID-PAYMENT" + id).val();
        let amount = $("#AMOUNT-PAYMENT" + id).val();

        console.log(paymentType, id, amount);


        $.ajax({
            url: "<?= base_url('App/updatePayment') ?>",
            type: "POST",
            data: {
                id: id,
                paymentType: paymentType,
                amount: amount,
                type: 6
            },
            success: function(response) {
                console.log(response);
                
                alert("Data berhasil diperbarui!");
                location.reload();
            }
        });
    }
</script>

<script>
  window.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const invoiceNo = urlParams.get('invoice');

    if (invoiceNo) {
      document.getElementById('nodownpayment').value = invoiceNo;
      
      document.getElementById('btn-cari').click();
    }
  });
</script>