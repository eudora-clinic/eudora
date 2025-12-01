<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Package Detail</title>

    <style>
        .mycontaine {
            font-size: 12px !important;
        }

        .mycontaine * {
            font-size: inherit !important;
        }

        /* Styling untuk form row dan column */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
            /* Biar responsif */
        }

        /* Label styling */
        .form-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
        }

        /* Input dan Select styling */
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Styling untuk textarea */
        textarea {
            resize: vertical;
            /* Bisa diubah ukurannya */
            min-height: 100px;
        }

        /* Styling untuk select dropdown */
        select {
            background: #fff;
            cursor: pointer;
        }

        /* Untuk tombol disabled */
        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        /* Styling untuk Mobile */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <form id="formAccount">
                <h6 class="text-secondary text-center mb-4" style="font-weight:bold;text-transform:uppercase;">
                <i class="bi bi-wallet2"></i> ADD EMPLOYEE ACCOUNT
                </h6>
                <div class="form-row">
                    <label for="name" class="form-label mt-2"><strong>NAME:</strong><span class="text-danger">*</span></label>
                    <select id="employeeid" name="employeeid" class="form-control" style="width:100%"></select>
                </div>
                <div id="employee-detail"></div>
            </div>
        </div>
        <div class="">
            <button type="submit" class="btn btn-primary" style="background-color: #c49e8f; color: black;">SAVE</button>
            <a href="https://sys.eudoraclinic.com:84/app/employeeAccountList" type="button" class="btn btn-primary" style="background-color: #c49e8f; color: black;">BACK</a>
            </form>
        </div>
        
    </div>
    

   <script>
    $(document).ready(function () {
        // Select2 untuk pilih karyawan
        $('#employeeid').select2({
            ajax: {
                url: "<?= base_url('ControllerEmployeeApps/getEmployees') ?>",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { search: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            },
            placeholder: 'Pilih Karyawan',
            minimumInputLength: 2,
        });

        // Tampilkan detail employee ketika dipilih
        $('#employeeid').on('change', function () {
            let employeeId = $(this).val();

            if (employeeId) {
                $.ajax({
                    url: "<?= base_url('ControllerEmployeeApps/getEmployeeDetail/') ?>" + employeeId,
                    type: "GET",
                    dataType: "json",
                    success: function (res) {
                        if (res.status) {
                            let emp = res.data;
                            let html = `
                                <div class="card mt-3 p-3">
                                    <p><strong>NIP:</strong> ${emp.nip}</p>
                                    <p><strong>Name:</strong> ${emp.name}</p>
                                    <p><strong>Job:</strong> ${emp.jobname ?? '-'}</p>
                                    <p><strong>Location:</strong> ${emp.locationname ?? '-'}</p>
                                </div>
                            `;
                            $('#employee-detail').html(html);
                        } else {
                            $('#employee-detail').html('<p class="text-danger">Data tidak ditemukan</p>');
                        }
                    }
                });
            } else {
                $('#employee-detail').html('');
            }
        });

        // Submit form pakai FormData
        $('#formAccount').on('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            if (!formData.get('employeeid')) {
                alert("Silahkan pilih employee terlebih dahulu!");
                return;
            }

            $.ajax({
                url: "<?= base_url('ControllerEmployeeApps/accountRegistration') ?>",
                type: "POST",
                data: formData,
                processData: false, // biar FormData tidak diubah jadi query string
                contentType: false, // biar browser otomatis set header multipart/form-data
                success: function (response) {
                    let res = typeof response === "string" ? JSON.parse(response) : response;
                    if (res.status) {
                        alert(res.message);
                        $('#formAccount')[0].reset();
                        $('#employeeid').val(null).trigger('change');
                        $('#employee-detail').html('');
                    } else {
                        alert("Error: " + res.message);
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan saat menyimpan account.");
                }
            });
        });
    });
</script>

</body>

</html>