<!DOCTYPE html>
<html>
<head>
    <title>Generate QR Code PNG</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Generate QR Code PNG</h2>

    <div class="mb-3">
        <label for="qr_text" class="form-label">Text</label>
        <input type="text" id="qr_text" class="form-control" placeholder="Masukkan text untuk QR Code">
    </div>

    <button class="btn btn-primary" onclick="generateQRCode()">Generate</button>
    <button class="btn btn-success" onclick="downloadQRCode()">Download PNG</button>

    <div class="mt-3" id="qrcode"></div>
</div>

<script>
let qrcode = null;

function generateQRCode() {
    const text = document.getElementById('qr_text').value;
    if (!text) return alert("Masukkan text terlebih dahulu!");

    // Hapus QR Code sebelumnya
    document.getElementById("qrcode").innerHTML = "";

    // Generate QR Code
    qrcode = new QRCode(document.getElementById("qrcode"), {
        text: text,
        width: 200,
        height: 200,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
}

function downloadQRCode() {
    if (!qrcode) return alert("Generate QR Code terlebih dahulu!");

    // QRCode.js membuat canvas atau img, ambil canvas
    const canvas = document.querySelector("#qrcode canvas");
    if (!canvas) return alert("QR Code belum tersedia.");

    const pngUrl = canvas.toDataURL("image/png");
    const a = document.createElement("a");
    a.href = pngUrl;
    a.download = "qrcode.png";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
</script>
</body>
</html>
