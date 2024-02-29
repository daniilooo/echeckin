<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página para Impressão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Inclua a biblioteca qrcode.js (substitua pelo caminho correto) -->
    <script src="js/qrcodejs/qrcode.min.js"></script>
    <style>
        .logotipo {
            height: 100px;
        }

        #qrcode-container {
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<?php
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');

if (isset($_GET['idLocal'])) {
    $idLocal = $_GET['idLocal'];

    $daoLocal = new DaoLocal((new Conexao())->conectar(), 1);
    $local = $daoLocal->selecionarLocal($idLocal);
}

?>

<body class="bg-light" onload="generateQRCode(<?php echo $local->getIdLocal() ?>)">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>
                    <?php echo $local->getDescLocal() ?>
                </h1>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="img/udLog.png" alt="Logotipo 1" class="img-fluid logotipo">
            </div>

            <div class="col-md-6 text-right">
                <img src="img/guiborLog.png" alt="Logotipo 2" class="img-fluid logotipo">
            </div>
        </div>


        <div class="row mt-3">
            <div class="col-md-12 text-center">                
                <p>Ponto de verificação de ronda.<br>Para fazer a verificação é necessário estar logado no sistema.</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <div id="qrcode-container" class="mx-auto">
                    <div id="qrcode" class="qrcode"></div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        function generateQRCode(idLocal) {
            let urlLocal = "http://10.80.0.30/echeckin/controllers/checkin.php?idLocal="+idLocal;

            let qrcodeContainer2 = document.getElementById("qrcode");
            qrcodeContainer2.innerHTML = "";
            new QRCode(qrcodeContainer2, {
                text: urlLocal,
                width: 300,
                height: 300,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });            
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>