<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eudora - HR Set Location</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .mycontaine {
            font-size: 12px !important;
        }

        .mycontaine * {
            font-size: inherit !important;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-column {
            flex: 1;
            min-width: 250px;
        }

        .form-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
        }
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
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        select {
            background: #fff;
            cursor: pointer;
        }

        input[disabled] {
            background: #f5f5f5;
            color: #777;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
        #map { height: 500px; width: 100%; }
    </style>
</head>

<body>
    <div class="mycontaine">
        <div class="hidden mt-2" id="role-information">
            <div class="card">
                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center mt-2 mb-2" style="font-weight: bold; color: #666;">
                    SET LOCATION PIN <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pinModal">
                    <i class="mdi mdi-map-marker-plus"></i> Tambah Lokasi Manual
                </button>

                </h3>
                <div class="card-body p-4">
                    <input id="pac-input" class="form-control" type="text" placeholder="Cari lokasi..." style="margin:10px; width:300px;" />
                    <div id="map"></div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <p><img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png" alt="">Active Location</p>
                        </div>
                        <div class="col-md-6">
                            <p><img src="https://maps.google.com/mapfiles/ms/icons/ltblue-dot.png" alt="">Nonactive Location</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h3 class="card-header card-header-info d-flex justify-content-between align-items-center mb-2 mt-2" style="font-weight: bold; color: #666;">
                    LIST LOCATION PINS
                </h3>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-4" id="pinsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Location Name</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinModalLabel">Tambah Lokasi Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="pinForm">
                    <div class="mb-3">
                        <label for="location_name" class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control" id="location_name" name="location_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="lat" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="lng" required>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="savePinBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let map;
        let markers = [];
        let pinsTable; 
        let infoWindow;

        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");
            const { Marker } = await google.maps.importLibrary("marker");
            const { InfoWindow } = await google.maps.importLibrary("places");

            map = new Map(document.getElementById("map"), {
                center: { lat: -6.2, lng: 106.8 },
                zoom: 15,
            });

            infoWindow = new google.maps.InfoWindow();
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) return;

                // Hapus marker hasil search sebelumnya
                markers.forEach(m => m.setMap(null));
                markers = [];

                // Bound untuk zoom otomatis
                let bounds = new google.maps.LatLngBounds();

                places.forEach(place => {
                    if (!place.geometry || !place.geometry.location) return;

                    const marker = new google.maps.Marker({
                        map,
                        title: place.name,
                        position: place.geometry.location,
                    });

                    // Klik marker → tampilkan infoWindow
                    marker.addListener("click", () => {
                        infoWindow.setContent(
                            `<div>
                                <strong>${place.name}</strong><br>
                                ${place.formatted_address || ""}
                            </div>`
                        );
                        infoWindow.open(map, marker);
                    });

                    markers.push(marker);

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });

                map.fitBounds(bounds);
            });

            loadPins();

            map.addListener("click", (e) => {
                let lat = e.latLng.lat();
                let lng = e.latLng.lng();

                let marker = new Marker({
                    position: { lat: lat, lng: lng },
                    map: map
                });
                markers.push(marker);

                const locationName = prompt("Masukkan nama lokasi:");

                if (locationName) {
                    if (confirm("Yakin ingin menyimpan pin ini?")) {
                        fetch("<?= base_url('ControllerEmployeeApps/savePin') ?>", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({
                                lat: lat,
                                lng: lng,
                                location_name: locationName
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            alert(res.message);
                            loadPins();
                        })
                        .catch(err => alert("Error simpan pin!"));
                    }
                } else {
                    alert("Nama lokasi wajib diisi!");
                }
            });
        }

        function loadPins() {
            $.ajax({
                url: "<?= base_url('ControllerEmployeeApps/getPins') ?>",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    const data = response.data || [];

                    markers.forEach(m => m.setMap(null));
                    markers = [];

                    data.forEach(pin => {
                        const iconUrl = pin.isactive == 1
                            ? "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                            : "https://maps.google.com/mapfiles/ms/icons/ltblue-dot.png";

                        let marker = new google.maps.Marker({
                            position: { lat: parseFloat(pin.latitude), lng: parseFloat(pin.longitude) },
                            map: map,
                            title: pin.locationname || "-",
                            icon: iconUrl
                        });

                        markers.push(marker);
                    });

                    if ($.fn.DataTable.isDataTable("#pinsTable")) {
                        pinsTable.destroy();
                    }

                    let tbody = $("#pinsTable tbody");
                    tbody.empty();

                    data.forEach((pin, index) => {
                        let toggleButton = pin.isactive == 1
                            ? `<button class="btn btn-sm btn-warning" onclick="togglePin(${pin.id}, 1)">Nonaktifkan</button>`
                            : `<button class="btn btn-sm btn-success" onclick="togglePin(${pin.id}, 0)">Aktifkan</button>`;

                        let row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${pin.locationname || "-"}</td>
                                <td>${pin.latitude}</td>
                                <td>${pin.longitude}</td>
                                <td>${toggleButton}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="deletePin(${pin.id})">Hapus</button>
                                </td>
                            </tr>
                        `;
                        tbody.append(row);
                    });

                    
                    pinsTable = $("#pinsTable").DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        searching: true,
                        ordering: true
                    });
                },
                error: function(err) {
                    alert("Gagal memuat data pins!");
                    console.log(err);
                }
            });
        }

        function deletePin(id) {
            if (!confirm("Yakin ingin menghapus pin ini?")) return;
            $.ajax({
                url: "<?= base_url('ControllerEmployeeApps/deletePin') ?>/" + id,
                method: "DELETE",
                dataType: "json", 
                success: function(res) {
                    alert(res.message);
                    loadPins(); 
                },
                error: function(err) {
                    alert("Gagal menghapus pin!");
                    console.log(err);
                }
            });
        }

        function togglePin(id, isActive) {
            const url = isActive == 1
                ? "<?= base_url('ControllerEmployeeApps/disablePin') ?>/"
                : "<?= base_url('ControllerEmployeeApps/enablePin') ?>/";
            $.ajax({
                url: url + id,
                method: "POST",
                dataType: "json", 
                success: function(res) {
                    alert(res.message);
                    loadPins(); 
                },
                error: function(err) {
                    alert("Gagal mengubah status pin!");
                    console.log(err);
                }
            });
        }

        $(document).ready(function() {
            window.onload = initMap;
            $('#savePinBtn').on('click', function() {
            let postData = {
                location_name: $('#location_name').val(),
                lat: $('#latitude').val(),
                lng: $('#longitude').val()
            };
            if (!postData.location_name || !postData.lat || !postData.lng) {
                alert('Semua field wajib diisi!');
                return;
            }

            $.ajax({
                url: '<?= base_url("ControllerEmployeeApps/savePin") ?>', 
                type: 'POST',
                data: JSON.stringify(postData),
                contentType: 'application/json',
                success: function(response) {
                    try {
                        let res = JSON.parse(response);
                        if (res.status === 'success') {
                            alert(res.message);
                            $('#pinModal').modal('hide');
                            $('#pinForm')[0].reset();
                        } else {
                            alert(res.message);
                        }
                    } catch (e) {
                        console.error('Response error:', response);
                        alert('Terjadi kesalahan server.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Gagal menghubungi server.');
                }
            });
        });
        });
      
    </script>

    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",
        q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),
        r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{
        await (a=m.createElement("script"));e.set("libraries",[...r]+"");
        for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);
        e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;
        d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";
        m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):
        d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "AIzaSyA4AQW4OZSntfdpXcSGyJ4sehHu8s8jjYU",
        v: "weekly"
        });
    </script>

    <script>
        window.onload = initMap;
    </script>

</body>

</html>