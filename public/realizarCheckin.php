<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de QR Code</title>
    <script src="../public/js/instaScan/instascan.min.js"></script>
</head>
<body>

<button onclick="startQRScanner()">Abrir Leitor de QR Code</button>

<script>
function startQRScanner() {
    // Cria uma instância do scanner
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    // Adiciona um ouvinte para quando um QR code for escaneado
    scanner.addListener('scan', function (content) {
        alert('QR Code escaneado! Conteúdo: ' + content);
    });

    // Inicia o scanner
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('Nenhuma câmera encontrada.');
        }
    }).catch(function (error) {
        console.error(error);
    });
}
</script>

</body>
</html>
