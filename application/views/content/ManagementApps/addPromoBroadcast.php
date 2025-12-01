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

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <form id="formPromoBroadcast" enctype="multipart/form-data">
                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>Title:</strong><span
                                class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required />
                    </div>

                    <div class="form-column">
                        <label for="name" class="form-label mt-2"><strong>Description:</strong><span
                                class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-column">
                        <label for="image_url" class="form-label mt-2">
                            <strong>Image (optional):</strong> <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="image_url" id="image_url" accept="image/*" class="form-control-file" />
                        <div id="preview-container" class="mt-2">
                            <img id="image-preview" src="#" alt="Preview"
                                style="display: none; max-width: 200px; max-height: 200px; border: 1px solid #ccc; padding: 4px;" />
                        </div>
                    </div>


                    <input type="hidden" name="type" value="PROMO" />
                    <input type="hidden" name="created_by" value="<?= $this->session->userdata('userid') ?>" />

                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
                <div id="notifPromo"></div>
            </div>
        </div>
    </div>

</body>



<script>
    $('#formPromoBroadcast').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('ControllerApiApps/insertPromoBroadcast') ?>",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#notifPromo').html('<small>Uploading...</small>');
            },
            success: function (res) {
                if (res.status === 200) {
                    $('#notifPromo').html('<span class="text-success">Berhasil disimpan</span>');
                    $('#formPromoBroadcast')[0].reset();
                } else {
                    $('#notifPromo').html('<span class="text-danger">' + res.message + '</span>');
                }
            },
            error: function (xhr) {
                $('#notifPromo').html('<span class="text-danger">Gagal mengirim promo</span>');
            }
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
