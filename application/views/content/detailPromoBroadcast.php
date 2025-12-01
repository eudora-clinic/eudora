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
</style>

<div class="mycontaine">
    <button type="button" id="btnUpdatePromo" class="btn btn-primary mt-3">Update Promo</button>
    <div id="notifUpdatePromo" class="mt-2"></div>

    <div class="hidden mt-2" id="role-information">
        <div class="card p-4">
            <h5 class="mb-3"><i class="fas fa-bullhorn me-2"></i>Detail Promo Broadcast</h5>

            <div class="form-column">
                <label class="form-label">Judul Promo:</label>
                <input type="text" id="title" class="form-control"  />
            </div>

            <div class="form-column">
                <label class="form-label">Deskripsi:</label>
                <textarea id="message" class="form-control" ></textarea>
            </div>

            <div class="form-column">   
                <label class="form-label">Tanggal Dibuat:</label>
                <input type="text" id="created_at" class="form-control" readonly />
            </div>

            <div class="form-column">
                <label class="form-label">Gambar Promo:</label>
                <img id="image-preview" src="#" alt="Gambar Promo"
                    style="display: none; max-width: 200px; max-height: 200px; border: 1px solid #ccc; padding: 4px;" />
                <input type="file" id="image_url" name="image_url" accept="image/*" class="form-control-file mt-2" />

            </div>
        </div>
        <div class="card p-4">
            <div class="row center" style="gap: 30px">
                <div>
                    <button style="cursor: pointer" class="btn-sm btn-primary" id="btnAddTarget"
                        data-broadcastid="<?= $broadcastid ?>">ADD
                        TARGET
                        CUSTOMER</button>
                    <div id="notifAddTarget" class="mt-2"></div>
                </div>

                <div>
                    <button style="cursor: pointer" class="btn-sm btn-primary" id="btnSendNotification"
                        data-broadcastid="<?= $broadcastid ?>">SEND
                        NOTIFICATION
                    </button>
                    <div id="notifSendNotification" class="mt-2"></div>
                </div>

            </div>
        </div>



        <div class="card p-4 mt-4">
            <h5 class="mb-3"><i class="fas fa-users me-2"></i>Broadcast Dikirim ke:</h5>
            <table id="tableTargetPromo" class="table table-striped" style="width:100%">
                <thead></thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('broadcastid');

        if (id) {
            $.ajax({
                url: `https://sys.eudoraclinic.com:84/apieudora/get_broadCastListById/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.status === 200 && res.data) {
                        const data = res.data[0];



                        $('#title').val(data.title);
                        $('#message').val(data.message);
                        $('#created_at').val(data.created_at);

                        if (data.image_url) {
                            $('#image-preview').attr('src', `https://sys.eudoraclinic.com:84/apieudora/${data.image_url}`).show();
                        } else {
                            $('#image-preview').hide();
                        }
                    } else {
                        alert('Data tidak ditemukan');
                    }
                },
                error: function () {
                    alert('Gagal mengambil data dari server');
                }
            });

            $('#tableTargetPromo').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `https://sys.eudoraclinic.com:84/apieudora/get_listTargetPromo/${id}`,
                    type: 'GET'
                },
                columns: [
                    { data: null, title: 'No' },  // Nanti diisi manual di drawCallback
                    { data: 'customer_name', title: 'Nama Customer' },
                    { data: 'cellphonenumber', title: 'No HP' },
                    { data: 'customercode', title: 'Kode Customer' },
                    { data: 'sent_at', title: 'Tanggal Kirim' },
                    {
                        data: 'is_read',
                        title: 'Status Baca',
                        render: function (data) {
                            return data == 1
                                ? '<span class="text-success">Dibaca</span>'
                                : '<span class="text-danger">Belum Dibaca</span>';
                        }
                    }
                ],
                drawCallback: function (settings) {
                    const api = this.api();
                    api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                        cell.innerHTML = api.page.info().start + i + 1;
                    });
                }
            });

        } else {
            alert('ID promo tidak ditemukan di URL');
        }


    });




</script>


<script>
    $(document).ready(function () {
        $('#btnAddTarget').on('click', function () {
            const broadcastId = $(this).data('broadcastid');

            if (!broadcastId) {
                alert('Broadcast ID tidak ditemukan');
                return;
            }

            if (!confirm('Yakin ingin menambahkan semua customer ke target broadcast ini?')) {
                return;
            }

            $.ajax({
                url: 'https://sys.eudoraclinic.com:84/apieudora/insert_target_customer',
                method: 'POST',
                data: { broadcast_id: broadcastId },
                dataType: 'json',
                beforeSend: function () {
                    $('#notifAddTarget').html('<span class="text-warning">Proses menyimpan...</span>');
                },
                success: function (res) {
                    if (res.status === 200) {
                        $('#notifAddTarget').html('<span class="text-success">' + res.message + '</span>');
                    } else {
                        $('#notifAddTarget').html('<span class="text-danger">' + res.message + '</span>');
                    }
                },
                error: function () {
                    $('#notifAddTarget').html('<span class="text-danger">Gagal menambahkan target customer</span>');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#btnSendNotification').on('click', function () {
            const broadcastId = $(this).data('broadcastid');

            if (!broadcastId) {
                alert('Broadcast ID tidak ditemukan');
                return;
            }

            if (!confirm('Yakin ingin mengirim notifikasi  ke target broadcast ini?')) {
                return;
            }

            $.ajax({
                url: 'https://sys.eudoraclinic.com:84/apieudora/send_broadcast_notification_to_user',
                method: 'POST',
                data: { broadcast_id: broadcastId },
                dataType: 'json',
                beforeSend: function () {
                    $('#notifSendNotification').html('<span class="text-warning">Proses menyimpan...</span>');
                },
                success: function (res) {
                    if (res.status === 200) {
                        $('#notifSendNotification').html('<span class="text-success">' + res.message + '</span>');
                    } else {
                        $('#notifSendNotification').html('<span class="text-danger">Gagal mengirim notifikasi</span>');
                    }
                },

                error: function () {
                    $('#notifSendNotification').html('<span class="text-danger">Gagal mengirim notifikasi ke customer</span>');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const broadcastId = urlParams.get('broadcastid');

        $('#btnUpdatePromo').on('click', function () {
            const formData = new FormData();
            const title = $('#title').val();
            const message = $('#message').val();
            const createdAt = $('#created_at').val();
            const imageFile = $('#image_url')[0]?.files[0]; // Input file optional

            if (!title || !message) {
                $('#notifUpdatePromo').html('<span class="text-danger">Judul dan Deskripsi wajib diisi.</span>');
                return;
            }

            formData.append('broadcast_id', broadcastId);
            formData.append('title', title);
            formData.append('message', message);
            formData.append('created_at', createdAt);
            if (imageFile) {
                formData.append('image_url', imageFile);
            }



            $.ajax({
                url: 'https://sys.eudoraclinic.com:84/apieudora/updatePromoBroadcast',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function () {
                    $('#notifUpdatePromo').html('<span class="text-warning">Memproses update...</span>');
                },
                success: function (res) {
                    console.log(res.status);
                    
                    if (res.status === 200) {
                        $('#notifUpdatePromo').html('<span class="text-success">Promo berhasil diupdate.</span>');
                    } else {
                        $('#notifUpdatePromo').html('<span class="text-danger">' + res.message + '</span>');
                    }
                },
                error: function () {
                    $('#notifUpdatePromo').html('<span class="text-danger">Gagal mengupdate promo.</span>');
                }
            });
        });
    });
</script>

<script>
    document.getElementById('image_url').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const file = input.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>
