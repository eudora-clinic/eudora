<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Package List</title>

    <style>
        .toast {
            visibility: hidden;
            /* Sembunyikan secara default */
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 9999;
            right: 40%;
            top: 20px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .toast.show {
            visibility: visible;
            opacity: 1;
        }

        .toast.success {
            background-color: #28a745;
            /* Warna hijau untuk sukses */
        }

        .toast.error {
            background-color: #dc3545;
            /* Warna merah untuk error */
        }

        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 10px 0;
        }

        .filter-container select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }

        /* Agar select dropdown memiliki padding lebih baik */
        .filter-container select:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn-primary {
            background-color: #e0bfb2 !important;
            color: #666666 !important;
            border: none;
            transition: background-color 0.3s ease;
        }

        .nav-tabs {
            border-bottom: 2px solid #e0bfb2;
        }

        .nav-tabs .nav-item {
            margin-right: 5px;
        }

        .nav-tabs .nav-link {
            background-color: #f5e5de;
            /* Warna latar belakang tab */
            border: 1px solid #e0bfb2;
            color: #8b5e4d;
            /* Warna teks */
            border-radius: 8px 8px 0 0;
            /* Membuat sudut atas membulat */
            padding: 10px 15px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e0bfb2;
            color: white;
        }

        .nav-tabs .nav-link.active {
            background-color: #e0bfb2 !important;
            color: white;
            border-bottom: 2px solid #d1a89b;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 15px !important;
            margin-bottom: 10px !important;
        }

        .tab-content {
            padding: 0 !important;
        }

        .bg-thead {
            background-color: #f5e0d8 !important;
            color: #666666 !important;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 100 !important;
        }

        .mycontaine {
            font-size: 12px !important;
        }

        /* Jika diperlukan, pastikan semua elemen di dalamnya mewarisi ukuran font tersebut */
        .mycontaine * {
            font-size: inherit !important;
        }

        .card-header-info {
            background: #f5e0d8;
        }

        .filter-container {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 10px 0;
        }

        .filter-container select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;

        }

        /* Agar select dropdown memiliki padding lebih baik */
        .filter-container select:focus {
            outline: none;
            border-color: #007bff;
        }
    </style>

    <?php
    // echo $loc;
    ?>
</head>

<body>
    <div>
        <div class="mycontaine">
            <div class=" ">
                <div class="row gx-4">
                    <div class="col-md-12 mt-3">
                        <div class=" " id="dailySales">
                            <div class="card">
                                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center"
                                    style="font-weight: bold; color: #666666;">
                                    DOING YESTERDAY
                                </h3>
                                <div class="table-wrapper p-4">
                                    <div class="table-responsive">
                                        <table id="tableDailySales" class="table table-striped table-bordered"
                                            style="width:100%">
                                            <thead class="bg-thead">
                                                <tr>
                                                    <th style="text-align: center;">NO</th>
                                                    <th style="text-align: center;">CUSTOMER</th>
                                                    <th style="text-align: center;">CELLPHONENUMBER</th>
                                                    <th style="text-align: center;">WA</th>
                                                    <th style="text-align: center;">STAFF</th>
                                                    <th style="text-align: center;">TREATMENT</th>
                                                    <th style="text-align: center;">NEXT APPT</th>
                                                    <th style="text-align: center;">REMARKS</th>
                                                    <th style="text-align: center;">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-transparent" id="voidModal" tabindex="-1" role="dialog"
        aria-labelledby="voidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="voidModalLabel">ADD REMARKS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea id="remarks" name="remarks" rows="4" cols="50" style="
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    font-family: Arial, sans-serif;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
                    resize: vertical;
                    text-transform: uppercase;
                "></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm" id="saveRemarks">SAVE</button>
                </div>
            </div>
        </div>
    </div>
    <div id="toast" class="toast">
        <div id="toast-message"></div>
    </div>
</body>
<script>
    $(document).ready(function () {
        var table = $('#tableDailySales').DataTable({
            "pageLength": 100,
            "lengthMenu": [5, 10, 15, 20, 25, 100],
            select: true,
            'bAutoWidth': false,
            "drawCallback": function (settings) {
                var api = this.api();
                var startIndex = api.page.info().start; // Mendapatkan nomor awal di halaman saat ini
                api.column(0, {
                    page: 'current'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = startIndex + i + 1; // Nomor urut dinamis
                });
            },
        });

        $('#filterPublished').on('change', function () {
            table.column(4).search(this.value).draw(); // Kolom ke-8 (Branch)
        });

        var doingId;
        var customerId;

        $(document).on("click", ".update-btn", function () {
            doingId = $(this).data("id"); // Ambil ID dari tombol
            customerId = $(this).data("customerid");
            remarks = $(this).data("remarks");

            $("#remarks").val(remarks);

            $("#voidModal").modal("show"); // Tampilkan modal
        });

        function showToast(message, type = "success") {
            const toast = document.getElementById("toast");
            const toastMessage = document.getElementById("toast-message");

            toastMessage.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        $("#saveRemarks").click(function () {
            let remarks = $("#remarks").val();

            $.ajax({
                url: "<?= base_url() . 'ControllerPOS/addRemarksPrepaidYesterday' ?>", // Ganti dengan file PHP untuk memproses void
                type: "POST",
                dataType: 'json',
                data: {
                    doingid: doingId,
                    customerid: customerId,
                    remarks: remarks
                },
                success: function (response) {
                    if (response.status === 'success') {
                        // alert("Update berhasil!"); // Bisa diganti dengan Swal atau notifikasi lain
                        $("#voidModal").modal("hide"); // Tutup modal
                        showToast("Berhasil mengupdate remarks!", "success");
                        loadAppointmentDetails()

                    } else {
                        alert("Terjadi kesalahan.");
                    }
                },
                error: function () {
                    alert("Terjadi kesalahan.");
                }
            });
        });


        function loadAppointmentDetails() {
            $.ajax({
                url: "<?= base_url('ControllerPOS/prepaidFinished'); ?>",
                type: "GET",
                dataType: "json",
                success: function (response) {

                    console.log(response);

                    table.clear().draw();

                    let no = 1;
                    let dataSet = [];

                    response.forEach(function (row) {
                        editBtn = `<button class="btn btn-primary btn-sm update-btn text-center" data-remarks="${row.REMARKS}" data-customerid="${row.CUSTOMERID}" data-id="${row.IDDOING}">ADD REMARKS</button>`;

                        let cellphonenumber = row.CELLPHONENUMBER;

                        let new_number = null;

                        if (cellphonenumber) {
                            cellphonenumber = cellphonenumber.replace(/\D/g, ''); // Hapus semua non-digit
                            let country_code = '62';

                            new_number = cellphonenumber.startsWith('0')
                                ? '+' + country_code + cellphonenumber.slice(1)
                                : '+' + cellphonenumber;
                        } else {
                            cellphonenumber = '-'; // biarkan tetap null
                        }

                        // console.log(new_number);


                        dataSet.push([
                            `<td class="text-center">${no++}</td>`,
                            `<td class="text-center">${row.CUSTOMERNAME}</td>`,
                            `<td class="text-center">${cellphonenumber}</td>`,
                            `<td class="text-center"><a href="https://wa.me/${new_number}"><i class="fa-brands fa-whatsapp fa-fade fa-2xl"></i></a></td>`,
                            `<td class="text-center">${row.EMPLOYEENAME}</td>`,
                            `<td class="text-center">${row.TREATMENTS}</td>`,
                            `<td class="text-center">${!row.NEXTAPPT || row.NEXTAPPT === 'null' ? '-' : row.NEXTAPPT}</td>`,
                            `<td class="text-center">${!row.REMARKS || row.REMARKS === 'null' ? '-' : row.REMARKS}</td>`,
                            `<td class="text-center">${editBtn}</td>`,

                        ]);

                    });

                    table.rows.add(dataSet).draw();

                    if (response.length > 0) {
                        $("#tableDailySales").removeClass("hidden-save");
                    } else {
                        $("#tableDailySales").addClass("hidden-save");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }


        loadAppointmentDetails()


    });

    $('#tableDailySales').removeClass('display').addClass(
        'table table-striped table-hover table-compact');
</script>

</html>