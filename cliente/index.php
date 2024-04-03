<?php

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){    
    header("Location: index2.php?Login=1");
}
    
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <!-- Link de importação do bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link de importação dos icones bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Link da folha de Estilo da tela de Login -->
    <link rel="stylesheet" href="css/main.css">
</head>
<style>
    @media (max-width: 767px) {
        .titulo {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
            color: white;
            font-size: 15px;
            font-weight: 300;
        }
    }

    #rodape{
        text-align: center;
    }
</style>

<body>
    <?php
        if(isset($_GET['isLogin'])){
            echo "<script>alert('Usuário ou senha incorretos.')</script>";
        }

        /*
        1 - guibor
        2 - udLog
        */

        $empresa = 1;
        function empresa($empresa){
            switch($empresa){
                case 1:
                    echo "../public/img/guiborLog.png";
                    break;
                case 2:
                    echo "../public/img/udLog.png";
                    break;
                default:
                    echo "Parametrize os dados da empresa.";
            }
        }
    ?>
    <div class="container mt-5 fluid">
        <div class="row justify-content-center col-6 mb-3"><img class="justify-content-center logo" src="<?php empresa(1) ?>"></div>
        <div class=" container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-container" style="border-color:#006BA6!important;">
                        
                        <div class="container titulo">
                            eCHECKin - Área do cliente
                        </div>
                        <form action="../controllers/login.php" method="POST">
                            <input type="hidden" id="cliente" name="cliente" value="true">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i> </span>
                                <input type="text" class="form-control" name="login" placeholder="Usuario" aria-label="Username" aria-describedby="basic-addon1" autocomplete="off" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i> </span> 
                                <input type="password" class="form-control" name="senha" placeholder="Senha" aria-label="Password" aria-describedby="basic-addon1" required>
                            </div>
                            <div class="col-md-12 controls">                                
                                <button type="submit" class="btn btn-success form-control">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<!-- Linha Que serara os conteudos -->
<hr style="border:1px solid gray;margin-top:3%;" width="100%">
<!-- Link de referencia a F4F Sistemas -->
<p id="rodape" class="fluid"><a href="https://prodevsistemas.com.br" style="text-decoration:none;" target="_blank">© 2024 1.0.0 - PRODEV Sistemas | prodevsistemas.com.br</a></p>

</html>