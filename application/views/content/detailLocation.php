<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - Service Detail</title>

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

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        .servicename {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .servicename:focus {
            border-color: #3f51b5;
            outline: none;
            background-color: #fff;
        }

        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 6px 12px !important;
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
            display: flex !important;
            align-items: center !important;
            margin-top: 5px;
        }

        /* Teks di dalam Select2 */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px !important;
            font-size: 14px;
        }

        /* Panah di sebelah kanan */
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px !important;
            /* top: 10px !important; */
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>

    <?php

    $detail = isset($detailLocation) ? $detailLocation : [];
    $city = isset($dataCity) ? $dataCity : [];
    $companyId = isset($detail->companyid) ? $detail->companyid : '';
    $companyName = isset($detail->companyname) ? $detail->companyname : '';
    $warehouseId = isset($detail->warehouseid) ? $detail->warehouseid : '';
    $warehouseName = isset($detail->warehousename) ? $detail->warehousename : '';
    $cityId = isset($detail->cityid) ? $detail->cityid : '';
    $cityName = isset($detail->cityname) ? $detail->cityname : '';
    $provinceName = isset($detail->provincename) ? $detail->provincename : '';
    $provinceId = isset($detail->provinceid) ? $detail->provinceid : '';
    ?>
</head>

<body>
    <div class="">
        <?php if ($detail->id) { ?>
            <button type="button" class="btn btn-primary" onclick="submitUpdateLocation(<?= $detail->id ?>)"
                style="background-color: #c49e8f; color: black;">UPDATE</button>
        <?php } else { ?>
            <button type="button" class="btn btn-primary" onclick="submitAddLocation()"
                style="background-color: #c49e8f; color: black;">ADD</button>
        <?php } ?>
        <a href="https://sys.eudoraclinic.com:84/app/listLocation" type="button" class="btn btn-primary"
            style="background-color: #c49e8f; color: black;">BACK</a>
    </div>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card p-4">
                <form id="formDetail">
                    <div class="form-row">
                        <div class="form-column">
                            <input type="hidden" name="id" value="<?= $detail->id ?>">
                            <label for="name" class="form-label mt-2"><strong>NAME:</strong><span
                                    class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                value="<?= isset($detail->name) ? $detail->name : '' ?>">

                            <label for="shortcode" class="form-label mt-2">
                                <strong>CODE:</strong><span class="text-danger">*</span>
                            </label>
                            <input type="text" name="shortcode" id="shortcode"
                                value="<?= isset($detail->shortcode) ? $detail->shortcode : '' ?>" <?= isset($detail->id) && $detail->id ? 'readonly' : '' ?>>

                            <label for="cityid" class="form-label mt-2"><strong>PROVINCE:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="provinceid" name="provinceid" class="form-control select2" required>
                                <?php if ($provinceName): ?>
                                    <option value="<?= $provinceId ?>" selected><?= $provinceName ?></option>
                                <?php endif; ?>
                            </select>
                            <label for="address" class="form-label mt-2"><strong>ADDRESS:</strong></label>
                            <input type="text" name="address" id="address"
                                value=" <?= isset($detail->address) ? $detail->address : '' ?>">
                            <label for="address" class="form-label mt-2"><strong>MOBILE PHONE:</strong></label>
                            <input type="text" name="mobilephone" id="mobilephone"
                                value=" <?= isset($detail->mobilephone) ? $detail->mobilephone : '' ?>">

                            <label for="address" class="form-label mt-2"><strong>LOCAL PHONE:</strong></label>
                            <input type="text" name="localphone" id="localphone"
                                value=" <?= isset($detail->localphone) ? $detail->localphone : '' ?>">
                            <label for="address" class="form-label mt-2"><strong>OPERATIONAL START
                                    TIME:</strong></label>
                            <input type="text" name="starttimeoperational" id="starttimeoperational"
                                value=" <?= isset($detail->starttimeoperational) ? $detail->starttimeoperational : '' ?>">
                            <label for="address" class="form-label mt-2"><strong>GOOGLE MAPS NAME:</strong></label>
                            <input type="text" name="placeid" id="placeid"
                                value=" <?= isset($detail->placeid) ? $detail->placeid : '' ?>">
                        </div>

                        <div class="form-column">
                            <label for="company" class="form-label mt-2"><strong>COMPANY:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="companyid" name="companyid" class="form-control select2" required>
                                <?php if ($companyId): ?>
                                    <option value="<?= $companyId ?>" selected><?= $companyName ?></option>
                                <?php endif; ?>
                            </select>

                            <label for="shortname" class="form-label mt-2"><strong>SHORTNAME:</strong></label>
                            <input type="text" name="shortname" id="shortname"
                                value="<?= isset($detail->shortname) ? $detail->shortname : '' ?>">
                            <label for="cityid" class="form-label mt-2"><strong>CITY:</strong><span
                                    class="text-danger">*</span></label>
                            <select id="cityid" name="cityid" class="form-control select2" required>
                                <?php if ($cityName): ?>
                                    <option value="<?= $cityId ?>" selected><?= $cityName ?></option>
                                <?php endif; ?>
                            </select>

                            <label for="warehouseid" class="form-label mt-2"><strong>WAREHOUSE:</strong></label>
                            <select id="warehouseid" name="warehouseid" class="form-control select2" required>
                                <?php if ($warehouseId): ?>
                                    <option value="<?= $warehouseId ?>" selected><?= $warehouseName ?></option>
                                <?php endif; ?>
                            </select>

                            <label for="longitude" class="form-label mt-2"><strong>LONGITUDE:</strong></label>
                            <input type="text" name="longitude" id="longitude"
                                value="<?= isset($detail->longitude) ? $detail->longitude : '' ?>">

                            <label for="latitude" class="form-label mt-2"><strong>LATITUDE:</strong></label>
                            <input type="text" name="latitude" id="latitude"
                                value="<?= isset($detail->latitude) ? $detail->latitude : '' ?>">
                            <label for="address" class="form-label mt-2"><strong>XENDIT ID:</strong></label>
                            <input type="text" name="xendit_id" id="xendit_id"
                                value=" <?= isset($detail->xendit_id) ? $detail->xendit_id : '' ?>">
                            <label for="address" class="form-label mt-2"><strong>OPERATIONAL TIME:</strong></label>
                            <input type="text" name="operationalTime" id="operationalTime"
                                value=" <?= isset($detail->operationalTime) ? $detail->operationalTime : '' ?>">
                        </div>

                    </div>

                </form>
                <br>
                <p><strong>Note: Untuk mengubah pin lokasi (Latitude dan Longitude) gerakan marker atau search pada
                        kolom cari lokasi</strong></p>
            </div>
            <div class="card p-4">
                <input id="pac-input" class="form-control" type="text" placeholder="Cari lokasi..."
                    style="margin:10px; width:300px;" />

                <div id="map"></div>
            </div>
        </div>
    </div>
    </div>

    <script>
        let map, marker, infoWindow;

        async function initMap() {
            const lat = parseFloat(document.getElementById("latitude").value) || -6.2;
            const lng = parseFloat(document.getElementById("longitude").value) || 106.8;
            const position = { lat: lat, lng: lng };

            const { Map, InfoWindow } = await google.maps.importLibrary("maps");
            const { Marker } = await google.maps.importLibrary("marker");
            const { places } = await google.maps.importLibrary("places");

            map = new Map(document.getElementById("map"), {
                zoom: 14,
                center: position,
            });
            marker = new Marker({
                map: map,
                position: position,
                draggable: true,
                title: "Geser untuk ubah lokasi",
            });

            infoWindow = new InfoWindow();
            marker.addListener("click", () => {
                const lat = marker.getPosition().lat().toFixed(6);
                const lng = marker.getPosition().lng().toFixed(6);
                infoWindow.setContent(`<div><b>Koordinat</b><br>Lat: ${lat}<br>Lng: ${lng}</div>`);
                infoWindow.open(map, marker);
            });

            marker.addListener("dragend", function (e) {
                updateLatLngInputs(e.latLng.lat(), e.latLng.lng());
            });

            map.addListener("click", function (e) {
                marker.setPosition(e.latLng);
                updateLatLngInputs(e.latLng.lat(), e.latLng.lng());
            });

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                if (places.length === 0) return;

                const place = places[0];
                if (!place.geometry || !place.geometry.location) return;

                marker.setPosition(place.geometry.location);
                map.setCenter(place.geometry.location);
                map.setZoom(16);

                updateLatLngInputs(place.geometry.location.lat(), place.geometry.location.lng());
                infoWindow.setContent(`<div><b>${place.name}</b><br>${place.formatted_address || ""}</div>`);
                infoWindow.open(map, marker);
            });
        }

        function updateLatLngInputs(lat, lng) {
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;
            console.log("Updated coords:", lat, lng);
        }

        function updateLocation(id) {
            const lat = document.getElementById("latitude").value;
            const lng = document.getElementById("longitude").value;

            $.ajax({
                url: "<?= base_url('App/updateLocation') ?>/" + id,
                type: "POST",
                data: { latitude: lat, longitude: lng },
                dataType: "json",
                success: function (res) {
                    alert(res.message);
                    if (res.status === "success") location.reload();
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Terjadi kesalahan saat update lokasi.");
                }
            });
        }

        const $companyid = $('#company');

        $(document).ready(function () {

            $("#companyid").select2({
                placeholder: "SELECT COMPANY",
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "<?= base_url('ControllerPurchasing/getCompanies') ?>",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return { search: params.term || "" };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return { id: item.id, text: item.text };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            $("#warehouseid").select2({
                placeholder: "SELECT WAREHOUSE",
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "<?= base_url('ControllerPurchasing/getWarehouses') ?>",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return { search: params.term || "" };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return { id: item.id, text: item.text };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2
            });

            $('#provinceid').select2({
                placeholder: 'SELECT PROVINCE',
                width: '100%',
                minimumInputLength: 2,
                ajax: {
                    url: "<?= base_url('ControllerPurchasing/listProvince') ?>",
                    dataType: 'json',
                    delay: 250,
                    processResults: data => ({ results: data })
                }
            });

            $('#cityid').select2({
                placeholder: 'SELECT CITY',
                width: '100%',
                ajax: {
                    transport: function (params, success, failure) {
                        const provId = $('#provinceid').val();
                        if (!provId) { success([]); return; }
                        params.url = "<?= base_url('ControllerPurchasing/listCityByProvince') ?>?provinceid=" + provId;
                        return $.ajax(params).then(success).catch(failure);
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: data => ({ results: data })
                }
            });

            const cityId = "<?= isset($detail->cityid) ? $detail->cityid : '' ?>";
            if (cityId) {
                $.ajax({
                    url: "<?= base_url('ControllerPurchasing/getCityById') ?>/" + cityId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data && data.id) {
                            const option = new Option(data.text, data.id, true, true);
                            $cityid.append(option).trigger('change');
                        }
                    },
                    error: function (err) {
                        console.error("Gagal load city default", err);
                    }
                });
            }

        });


        $(document).ready(function () {
            initMap();
        });

        function submitUpdateLocation(id) {
            let formData = $("#formDetail").serialize();

            $.ajax({
                url: "<?= base_url('ControllerPurchasing/updateLocation') ?>/" + id,
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert("Gagal update location: " + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Terjadi kesalahan saat update lokasi.");
                }
            });
        }

        function submitAddLocation() {
            let formData = $("#formDetail").serialize();

            console.log(formData);


            $.ajax({
                url: "<?= base_url('ControllerPurchasing/addLocation') ?>",
                type: "POST",
                data: formData,
                dataType: "text",
                success: function (res) {
                    console.log(res);
                    
                    if (res.status === "success") {
                        alert(res.message);
                        location.reload();
                    } else {
                        alert("Gagal tambah location: " + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert("Terjadi kesalahan saat update lokasi.");
                }
            });
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCUQu4oNuj856ndXkBxpmb71zwE4bPHE9I&callback=initMap">
        </script>



</body>

</html>