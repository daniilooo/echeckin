<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {
    $idUsuario = $_SESSION['idUsuario'];

    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
    $usuario = $daoUsuario->selecionarUsuario($idUsuario);

    if(isset($_GET['checkin'])){
        $checkin = $_GET['checkin'];
        if($checkin){
            echo " <script>
                        Swal.fire({
                        title: 'eCheckin',
                        text: 'Checkin realizado com sucesso',
                        icon: 'warning', // Ícone do alerta (opcional)
                        confirmButtonText: 'OK' // Texto do botão de confirmação (opcional)
                        });
                    </script>";            
        } else {
            echo " <script>
                        Swal.fire({
                        title: 'eCheckin',
                        text: 'Não foi possível realizar o checkin.',
                        icon: 'warning', // Ícone do alerta (opcional)
                        confirmButtonText: 'OK' // Texto do botão de confirmação (opcional)
                        });
                    </script>";
        }
    }
} else {
    echo 
    "<script>
        alert('É necessário fazer login para usar o sistema.');
        window.location.href = '../cliente/index.php';
    </script>";
    
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>eCheckin - Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body {
            background-color: #f0f0f0;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }

        .container-fluid {
            padding-top: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="index2.php">eCheckin</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index2.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerenciamentoUsuarios.php">Gerenciar<br>usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerenciamentoEmpresas.php">Gerenciar<br>empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerenciarLocais.php">Gerenciar<br>Locais cadastrados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gerarRelatorios.php">Relatórios<br>disponíveis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manualDoSistema.php">Manual do<br>sistema</a>
                    </li>
                    <li class="nav-item">
                        <a href="cadastroDeUsuario.php?idUsuarioAlt=<?php echo $usuario->getIdUsuario() ?>" class="nav-link user-box" style="background-color: #B0C4DE;">
                            <?php echo $usuario->getNome() ?><br>Gerenciar conta
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

    <!-- Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Checkin</h5>
                        <p class="card-text">Realizar checkin em local</p>                        
                        <button id="btnRealizarCheckin" class="btn btn-primary">Realizar Checkin</button>                        
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Justificativas</h5>
                        <p class="card-text">Quando não for possível realizar o checkin no local, o formulário de justificativa deve ser preenchido em enviado justamente com a evidência.</p>                        
                        <a href="realizarjustificativa.php"class="btn btn-warning">Formulário de justificativa</a>                        
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerenciar acesso</h5>
                        <p class="card-text">Alteração da senha de acesso do usuário</p>                        
                        <a href="gerenciarAcesso.php" class="btn btn-danger">Gerenciar acesso</a>                        
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sair do sistema</h5>
                        <p class="card-text">Sair do sistema</p>                        
                        <button class="btn btn-danger" onClick ="sair()">Sair</button>                        
                    </div>
                </div>
            </div>

    <script>
        function sair(){
            window.location.href = "../controllers/sair.php";
        }
    </script>




    <script>
        document.getElementById("btnRealizarCheckin").addEventListener("click", function() {
            // Enviar um sinal para o aplicativo Android para abrir o leitor de QR code
            window.android.openQRCodeScanner();
        });
    </script>

    <script>

    function abrirLeitorQRCode() {
        // Verificar se o dispositivo é um dispositivo Android
        const isAndroid = /Android/i.test(navigator.userAgent);

        // Verificar se o navegador é o Chrome ou o WebView do Android
        const isChromeOrWebView = /Chrome|WebView/i.test(navigator.userAgent);

        if (isAndroid && isChromeOrWebView) {
            // Abrir o leitor de QR code nativo do Android usando um intent
            window.location.href = 'intent://scan/#Intent;scheme=zxing;package=com.google.zxing.client.android;end;';
        } else {
            // Informar ao usuário que a funcionalidade não está disponível
            alert('Esta funcionalidade só está disponível em dispositivos Android utilizando o navegador Chrome ou WebView do Android.');
        }
    }

    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
