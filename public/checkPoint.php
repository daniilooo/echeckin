<?php
include_once (__DIR__ . '/../DAO/DaoLog.php');
include_once (__DIR__ . '/../DAO/DaoLocal.php');
include_once (__DIR__ . '/../DAO/DaoEmpresa.php');

session_start();
$sessionStatus = session_status();

function salvarLog($idUsuario, $local){
    $conexao = new Conexao();
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), $idUsuario);
    $daoLog = new DaoLog($conexao->conectar(), $idUsuario);
    $empresa = $daoEmpresa->selecionarEmpresa($local->getFkEmpresa());    
    $log = new Log(null, "Geração de placa de Checkpoint:\n".$empresa->getRazaoSocial()." - ".$local->getDescLocal(), (new DateTime())->format('Y-m-d H:i:s'), $idUsuario);    
    $daoLog->inserirLog($log);
}

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {

    if (isset($_GET['idLocal'])) {        
        $idUsuario = $_SESSION['idUsuario'];
        $idLocal = $_GET['idLocal'];

        $daoLocal = new DaoLocal((new Conexao())->conectar(), $idUsuario);
        $local = $daoLocal->selecionarLocal($idLocal);
        salvarLog($idUsuario, $local);
        $tipoEmpresa = (new DaoEmpresa((new Conexao())->conectar(), $_SESSION['idUsuario']))->tipoEmpresa($local->getFkEmpresa());        

        function descTipoLocal($tipoEmpresa)
        {
            switch ($tipoEmpresa) {
                case 1:
                    return "Ponto de ronda - ";
                case 2:
                    return "Ilha - ";
                default:
                    return "";
            }
        }
    }

} else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
        window.location.href = '../index.php';    
        </script>";
    return;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página para Impressão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="js/qrcodejs/qrcode.min.js"></script>
    <style>

        .logotipo {
            height: 70px;            
        }

        .titulo{
            font-size:14px;
        }

        #qrcode-container {
            display: flex;
            justify-content: center;
        }
        
        .impressao {
            border: 1px dashed #000;
            border-radius: 5px;
            padding: 10px;
            margin: 20px;
            display: inline-block;
        }

        .container-impressao {
            max-width: 264px; /* Defina a largura máxima que deseja para o conteúdo */
            margin: auto; /* Centraliza horizontalmente o contêiner */
        }
       
    </style>

</head>

<body class="bg-light" onload="generateQRCode(<?php echo $local->getIdLocal() ?>)">
    <div class="container text-center">
    <div class="container-impressao">
        <div class="row">
            <div class="col-md-8 impressao">               
            

        <div class="row align-items-center">
            <?php if ($tipoEmpresa == 1) { ?>
                    <div class="col-md-12 text-center">
                        <img src="img/udLog.png" alt="Logotipo 1" class="img-fluid logotipo">
                    </div>
            <?php } else { ?>    
                    <div class="col-md-6 text-center"> 
                        <img src="img/guiborLog.png" alt="Logotipo 2" class="img-fluid logotipo">
                    </div>
            <?php } ?>
        </div>
        <br>
        <br>
        <br>
        <div class="row mt-3">
            <div class="col-md-12 text-center">
                <div id="qrcode-container" class="mx-auto">
                    <div id="qrcode" class="qrcode"></div>
                </div>
            </div>
        </div>            
            <h1 class="titulo">
                    <?php echo descTipoLocal($tipoEmpresa) . $local->getDescLocal() ?>
                    <br><br><br><br>
            </h1>
        </div>
                
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function generateQRCode(idLocal) {

            const local = 3;
            var url = null;            

            switch (local) {
                case 1:
                    url = "localhost/echeckin/controllers/checkin.php?idLocal="
                    break;
                case 2:
                    url = "http://10.80.0.30/echeckin/controllers/checkin.php?idLocal="
                    break;
                case 3:
                    url = "https://sysdesk.com.br/echeckin/controllers/checkin.php?idLocal="
                default:
                    break;
            }

            let urlLocal = url + idLocal;

            let qrcodeContainer2 = document.getElementById("qrcode");
            qrcodeContainer2.innerHTML = "";
            new QRCode(qrcodeContainer2, {
                text: urlLocal,
                width: 169,
                height: 169,
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