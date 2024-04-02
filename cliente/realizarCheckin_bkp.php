<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de QR Code</title>
    <script type="text/javascript" src="instascan.min.js"></script>
</head>
<body>
    <h1>Leitor de QR Code</h1>
    <button onclick="startScanner()">Iniciar Scanner</button>
    <video id="preview" style="display:none;"></video>

    <script>
        function startScanner() {
            // Verifica se o navegador suporta a API de câmera
            if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                // Verifica se é um dispositivo Android
                if (/Android/i.test(navigator.userAgent)) {
                    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

                    scanner.addListener('scan', function(content) {
                        alert('QR code detectado: ' + content);
                        // Aqui você pode fazer o que quiser com o conteúdo do QR code
                    });

                    Instascan.Camera.getCameras().then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            console.error('Nenhuma câmera encontrada.');
                        }
                    }).catch(function(e) {
                        console.error(e);
                    });

                    // Exibe o vídeo
                    document.getElementById('preview').style.display = 'block';
                } else {
                    alert('Este aplicativo só funciona em dispositivos móveis.');
                }
            } else {
                alert('Seu navegador não suporta a API de câmera.');
            }
        }
    </script>
</body>
</html>
