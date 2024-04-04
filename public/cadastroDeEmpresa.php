<?php

include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){
    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), $idUsuario);


    $usuario = $daoUsuario->selecionarUsuario($idUsuario);

    function verificarAction(){
        if(isset($_GET['idEmpresa'])){
            return true;
        } else {
            return false;
        }
    }

    if(verificarAction()){
        $empresa = $daoEmpresa->selecionarEmpresa($_GET['idEmpresa']);
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/imask"></script>
    <link rel="stylesheet" href="css/estilo.css">
    
    <!--
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

        .user-box {
            border-radius: 5px;
        }
		
		footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #007bff;            
            color: white;           
            text-align: center;
            line-height: 20px;
        }
    </style>
    -->


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
                        <a href="cadastroDeUsuario.php?idUsuarioAlt=<?php echo $usuario->getIdUsuario()?>" class="nav-link user-box" style="background-color: #B0C4DE;">
                            <?php echo $usuario->getNome() ?><br>Gerenciar conta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link exit-box" href="../controllers/sairAdm.php"><strong>Sair do<br>eCheckin</strong></a>
                    </li>
                </ul>
            </div>
        </nav>

    <!-- Content -->
   <div class="container-fluid d-flex justify-content-center">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulário de cadastro de empresas</h5>

                        <!-- Formulário de cadastro -->
                        <form action="<?php echo verificarAction() ? "../controllers/alterarEmpresa.php" : "../controllers/cadastrarEmpresa.php"?>" method="POST">
                            <?php if(verificarAction()){?>
                                <input type="hidden" id="idEmpresa" name="idEmpresa" value="<?php echo $empresa->getIdEmpresa()?>">
                            <?php }?>
                            <div class="form-group">
                                <label for="razaoSocial">Nome:</label>
                                <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" placeholder="Digite a razão social" autocomplete="off" value="<?php echo verificarAction() ? $empresa->getRazaoSocial() : null ?>">
                            </div>
                            <div class="form-group">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite o cnpj da empresa" autocomplete="off" value="<?php echo verificarAction() ? $empresa->getCnpj() : null ?>">
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" id="ativo" value="1" <?php echo verificarAction() ? $empresa->getStatusEmpresa() == 1 ? "checked" : "" : ""?>>
                                <label for="ativo" class="form-check-label">Ativo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" id="inativo" value="0" <?php echo verificarAction() ? $empresa->getStatusEmpresa() == 0 ? "checked" : "" : ""?>>
                                <label for="inativo" class="form-check-label">Inativo</label>
                            </div>
                            <br>
                            <button type="submit" class="btn <?php echo verificarAction() ? "btn-warning" : "btn-primary"?>"><?php echo verificarAction() ? "Alterar empresa" : "Cadastrar empresa"?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        by PRODEV - Desenvolvimento de sistemas.
    </footer>    
    <script>
        const element = document.getElementById('cnpj');
        const maskOptions = {
            mask: '00.000.000/0000-00'
        };
        const mask = IMask(element, maskOptions);
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

    } else {
        echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
        window.location.href = '../index.php';    
    </script>";
    }

?>