<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD EMPLOYEE INVOICE</title>

    <!-- Tambahkan Bootstrap untuk styling yang lebih baik -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> -->

    <style>
        label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .submit-btn {
            background-color: #e0bfb2;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #f5e0d8;
        }
    </style>
</head>

<body>

    <div class="card p-4">
        <h4 class="text-secondary text-center">
            <i class="bi bi-wallet2"></i> ADD EMPLOYEE INVOICE
        </h4>
        <form id="affiliateForm">
            <label for="employeeId">EMPLOYEE NAME</label>
            <select id="employeeId" class="form-control employeeId" required>
            </select>


            <label for="locationIdSelect">LOCATION</label>
            <select id="locationIdSelect" class="form-control locationIdSelect" required>
            </select>

            <label for="jobSelect">JOB</label>
            <select id="jobSelect" class="form-control jobSelect" required></select>


            <input type="number" name="locationId" id="locationId" hidden>
            <input type="number" name="jobId" id="jobId" hidden>
            <input type="number" name="employeeId" id="employeeIdInsert" hidden>
            <button type="submit" class="submit-btn btn-sm">SUBMIT</button>
        </form>
        <div id="message" class="mt-3 text-center"></div>
    </div>


    <script>

        $(document).ready(function () {
            $("#affiliateForm").submit(function (e) {
                e.preventDefault();

                console.log($(this).serialize());

                $.ajax({
                    url: "<?= base_url('App/addEmployeeInvoice') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        console.log(response);

                        if (response.success) {
                            $("#message").html('<span class="text-success">Employee added successfully!</span>');
                            $("#affiliateForm")[0].reset();
                        } else {
                            $("#message").html('<span class="text-danger">Failed to add employee.</span>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                        $("#message").html('<span class="text-danger">Error occurred.</span>');
                    }
                });
            });

            $("#employeeId").select2({
                width: '100%',
                ajax: {
                    url: "App/searchEmployeeAppointment", // Panggil controller Customer
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            $("#employeeId").on("select2:select", function (e) {
                let data = e.params.data;
                $("#employeeIdInsert").val(data.id);
                $("#locationId").val(data.locationid);
            });

            

            $("#locationIdSelect").select2({
                width: '100%',
                ajax: {
                    url: "ControllerMaster/searchLocationEmployeeAppointment",
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

            $("#locationIdSelect").on("select2:select", function (e) {
                let data = e.params.data;
                $("#locationId").val(data.id);
            });


            $("#jobSelect").select2({
                width: '100%',
                ajax: {
                    url: "ControllerMaster/searchJobEmployeeAppointment",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });
            $("#jobSelect").on("select2:select", function (e) {
                let data = e.params.data;
                $("#jobId").val(data.id);
            });
        });
    </script>

</body>

</html>