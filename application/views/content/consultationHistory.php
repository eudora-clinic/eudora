<!DOCTYPE html>
<html>
<head>
    <title>Form Consultation Result</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
   <?php
    $db_oriskin = $this->load->database('oriskin', TRUE);

    // Ambil parameter customer_id dari GET
    $customerId = $this->input->get('customer_id');

    $db_oriskin->select('
        formconsultationresult.*, 
        mscustomer.firstname AS customer_firstname, 
        mscustomer.lastname AS customer_lastname, 
        msemployee.name AS employee_name,
        mscustomer.cellphonenumber AS customer_number,
        mscustomer.membercode AS member_code
    ')
    ->from('formconsultationresult')
    ->join('mscustomer', 'mscustomer.id = formconsultationresult.customerid', 'left')
    ->join('msemployeedetail', 'msemployeedetail.employeeid = formconsultationresult.consulted_employee_id', 'left')
    ->join('msemployee', 'msemployee.id = formconsultationresult.consulted_employee_id', 'left');

    if (!empty($customerId)) {
        $db_oriskin->where('mscustomer.id', $customerId);
    }

    $data = $db_oriskin->get()->result_array();
    ?>

<div class="container-fluid mycontaine mt-4">
    <div class="row gx-4">
        <div class="col-md-12">
            <div class="card p-2 col-md-6">
                <form method="get" action="<?= current_url() ?>">
                    <label for="name" class="form-label mt-2"><strong>SEARCH CUSTOMER NAME / MEMBER CODE:</strong><span
                            class="text-danger">*</span></label>
                    <select id="customerIdConsultation" class="customerIdConsultation" required data-placeholder="SEARCH CUSTOMER"></select>
                </form>
            </div>
            <div class="card m-2">
                <h3 class="card-header card-header-info d-flex justify-content-between align-items-right" style="font-weight: bold; color: #666666;">
                                    <div class="d-flex justify-content-between align-items-center mb-3 w-100">
                                        <div class="text-start">
                                            <h5 class="mb-0"><strong>Consultation History</strong></h5>
                                        </div>
                                        <div class="text-end">
                                            <a href="<?= base_url('addConsultation') ?>" class="btn btn-primary me-2">
                                                + Add Consultation
                                            </a>
                                        </div>
                                    </div>

                                </h3>
                
                <div class="card-body p-4">
                    <table id="consultationTable" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Member Code</th>
                                <th>Customer Name</th>
                                <th>Customer Cellphone Number</th>
                                <th>Consulted Employee</th>
                                <th>Consultation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php if (count($data) > 0): ?>
                            <?php foreach ($data as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $row['member_code']?></td>
                                    <td><?= $row['customer_firstname'] . ' ' . $row['customer_lastname'] ?></td>
                                    <td><?= $row['customer_number'] ?></td>
                                    <td><?= $row['employee_name'] ?></td>
                                    <td><?= date('l, d F Y (H:i)', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('printConsultationResult/' . $row['id']) ?>" class="btn btn-sm btn-success" target="_blank">View PDF</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No Data Found</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>            
</div>
<!-- Pastikan Anda include jQuery dan DataTables di layout Anda -->
<script>
    $(document).ready(function () {
        $('#consultationTable').DataTable({
            
            scrollX: true
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#customerIdConsultation").on("select2:select", function (e) {
        let data = e.params.data;

        // Redirect ke halaman saat ini + customer_id
        const baseUrl = "<?= current_url() ?>";
        window.location.href = baseUrl + "?customer_id=" + data.id;
    });
</script>
    <script>

        $(document).ready(function () {
            $("#customerIdConsultation").select2({
                width: '100%',
                placeholder: "Cari nama pasien",
                ajax: {
                    url: "<?= base_url('App/searchCustomerHistory') ?>",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            $("#customerIdConsultation").on("select2:select", function (e) {
                const selectedCustomer = e.params.data;
                const baseUrl = "<?= current_url() ?>";
                window.location.href = baseUrl + "?customer_id=" + selectedCustomer.id;
            });
        });
    </script>
</body>
</html>