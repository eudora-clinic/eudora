<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    .form-group {
        position: relative;
        margin: 20px 0;
        width: 50%;
        margin-bottom: 10px;
    }

    .form-group i {
        position: absolute;
        top: 40%;
        left: 10px;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .form-group input {
        width: 100%;
        padding: 10px 10px 10px 40px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
    }

    .btn-redeem {
        display: block;
        width: 50%;
        padding: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-redeem:hover {
        background-color: #218838;
    }

    .redeem {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 50px;
        gap: 10px;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title">Redeem Voucher</h4>
                    </div>
                    <form action="">
                        <div class="redeem">
                            <div class="form-group">
                                <i class="material-icons">card_giftcard</i>
                                <input type="text" id="voucherCode" placeholder="Enter Voucher Code">
                            </div>
                            <div id="isVoucher" style="display: none;">
                                <p style="color: #28a745;">Voucher berhasil diredeem, silahkan lakukan pembayaran.</p>
                            </div>
                            <div id="isNoVoucher" style="display: none;">
                                <p style="color: red;">Voucher tidak ditemukan atau sudah digunakan.</p>
                            </div>
                            <button type="button" class="btn-redeem btn btn-primary" onclick="saveChanges()">Redeem</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    function saveChanges() {
        var voucherCode = $('#voucherCode').val();
        $.ajax({
            url: "<?= base_url() . 'App/redeemVoucher' ?>",
            type: 'POST',
            data: {
                voucherCode: voucherCode,
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data?.status == 1) {
                    $('#isNoVoucher').css('display', 'block');
                    $('#isVoucher').css('display', 'none');
                    alert("Voucher tidak ditemukan atau sudah digunakan")

                } else if (data?.status == 0) {
                    $('#isVoucher').css('display', 'block');
                    $('#isNoVoucher').css('display', 'none');
                    alert("Voucher berhasil diaktifkan, silahkan lakukan pembayaran")
                }
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        })
    }
</script>