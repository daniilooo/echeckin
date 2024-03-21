<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Leitor de QR Code</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
</head>
<body>
<button id="scanButton">Escanear QR Code</button>

<script>
document.getElementById('scanButton').addEventListener('click', function() {
    // Cria uma instância do leitor de QR Code
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    // Adiciona um evento de detecção de QR Code
    scanner.addListener('scan', function(content) {
        // Redireciona para o URL do QR Code
        window.location.href = content;
        
        // Para o leitor após detectar o QR Code
        scanner.stop();
    });

    // Inicia o leitor de QR Code
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]); // Usa a primeira câmera encontrada
        } else {
            console.error('Nenhuma câmera encontrada.');
        }
    }).catch(function(error) {
        console.error(error);
    });
});
</script>

<video id="preview"></video>

</body>
</html>
