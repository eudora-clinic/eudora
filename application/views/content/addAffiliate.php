<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD AFFILIATE</title>

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
            <i class="bi bi-wallet2"></i> ADD AFFILIATE
        </h4>
        <form id="affiliateForm">
            <label for="affiliateName">Name</label>
            <input type="text" id="affiliateName" name="affiliateName" placeholder="ENTER NAME" required>

            <label for="affiliateCellphoneNumber">Cellphone Number</label>
            <input type="number" id="affiliateCellphoneNumber" name="affiliateCellphoneNumber" placeholder="ENTER CELLPHONE NUMBER" required>

            <label for="fromemployeeid">AFFILIATOR FROM</label>
            <select id="fromemployeeid" name="fromemployeeid" class="form-control" required>
                <option value="">PILIH EMPLOYEE</option>
                <?php foreach ($employeeMarketing as $e) { ?>
                    <option value="<?= $e['ID'] ?>"><?= $e['NAME'] ?> - <?= $e['LOCATIONNAME'] ?></option>
                <?php } ?>
            </select>


            <label for="accountNumber">Account Number</label>
            <input type="text" id="accountNumber" name="accountNumber" placeholder="XXXXXX (BANK an Nama)" required>

            <label for="startDate">DATE JOIN</label>
            <input type="date" id="startDate" name="startDate" required>

            <button type="submit" class="submit-btn btn-sm">SUBMIT</button>
        </form>
        <div id="message" class="mt-3 text-center"></div>
    </div>


    <script>
        $(document).ready(function() {
            $("#affiliateForm").submit(function(e) {
                e.preventDefault();

                console.log($(this).serialize());

                $.ajax({
                    url: "<?= base_url('App/add_affiliate') ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        if (response.success) {
                            $("#message").html('<span class="text-success">Affiliate added successfully!</span>');
                            $("#affiliateForm")[0].reset();
                        } else {
                            $("#message").html('<span class="text-danger">Failed to add affiliate.</span>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        $("#message").html('<span class="text-danger">Error occurred.</span>');
                    }
                });
            });
        });
    </script>

</body>

</html>