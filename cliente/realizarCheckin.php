<!DOCTYPE html>
<html>
<head>
    <title>QR Code Reader</title>
    <script src="https://cdn.jsdelivr.net/npm/quagga/dist/quagga.min.js"></script>
</head>
<body>
    <h1>QR Code Reader</h1>
    <div id="reader"></div>

    <script>
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#reader"),
                constraints: {
                    width: 480,
                    height: 320,
                    facingMode: "environment" // or "user" for front camera
                },
            },
            decoder: {
                readers: ["ean_reader"] // You can specify other types like "qrcode_reader"
            }
        }, function(err) {
            if (err) {
                console.error(err);
                return;
            }
            console.log("Initialization finished. Ready to start");
            Quagga.start();
        });
        
        Quagga.onDetected(function(result) {
            console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
        });
    </script>
</body>
</html>
