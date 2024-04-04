<?php
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');
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
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), $idUsuario);
    $daoLocal = new DaoLocal($conexao->conectar(), $idUsuario);

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);
    
    $listaDeTipos = $daoLocal->gerarListaDeTIpos();
 
    function verificarAction(){
        if(isset($_GET['idLocal'])){
            return true;
        } else {
            return false;
        }
    }

    if(isset($_GET['idEmpresa'])){
        $empresa = $daoEmpresa->selecionarEmpresa($_GET['idEmpresa']);
        $listaDeEmpresas[] = $empresa;        
    } else {
        $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();
    }

    if(isset($_GET['idLocal'])){
        $localAlt = $daoLocal->selecionarLocal($_GET['idLocal']);
    }


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>eCheckin - Cadastro de locais</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                        <h5 class="card-title">Formulário de Cadastro de locais</h5>
                        
                        <!-- Formulário de cadastro -->
                        <form action="<?php echo verificarAction() ? "../controllers/alterarLocal.php" : "../controllers/cadastrarLocais.php"?>" method="POST">
                            <?php if(verificarAction()){?>
                                <input type="hidden" id="idLocal" name="idLocal" value="<?php echo $localAlt->getIdLocal()?>">
                            <?php } ?>
                            <div class="form-group">
                                <label for="nome">Empresa:</label>
                                <select name="empresa" id="empresa" class="form-control">
                                    <option value="0" selected disabled>Selecione a empresa</option>
                                    <?php foreach($listaDeEmpresas as $empresa){
                                        if($empresa->getStatusEmpresa() == 1){?>                                    
                                            <option value="<?php echo $empresa->getIdEmpresa()?>" <?php echo verificarAction() ? $empresa->getIdEmpresa() == $localAlt->getIdLocal() ? "selected" : "" : "" ?>><?php echo $empresa->getRazaoSocial()?></option>
                                        <?php }}?>                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Tipo do local:</label>
                                <select name="tipoLocal" id="tipoLocal" class="form-control">
                                    <option value="0" selected disabled>Selecione o tipo do local</option>
                                    <?php foreach($listaDeTipos as $tipoLocal){
                                        if($tipoLocal->statusLocal == 1){?>                                    
                                        <option value="<?php echo $tipoLocal->idTipoLocal?>" <?php echo verificarAction() ? $localAlt->getFkTipoLocal() == $tipoLocal->idTipoLocal ? "selected" : "" : ""?>><?php echo $tipoLocal->descLocal?></option>
                                        <?php }}?>                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="descLocal">Descrição do local:</label>
                                <input type="text" class="form-control" id="descLocal" name="descLocal" placeholder="Digite a descrição do novo local" required autocomplete="off" value="<?php echo verificarAction() ? $localAlt->getDescLocal() : null?>">
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" id="ativo" value="1" <?php echo verificarAction() ? $localAlt->getStatusLocal() == 1 ? "checked" : "": ""?>>
                                <label for="ativo">Ativo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="status" id="inativo" value="0" <?php echo verificarAction() ? $localAlt->getStatusLocal() == 0 ? "checked" : "": ""?>>
                                <label for="inativo">Inativo</label>
                            </div>
                            <button type="submit" class="btn <?php echo verificarAction() ? "btn-warning" : "btn-primary"?>"><?php echo verificarAction() ? "Alterar local" : "Cadastrar Local"?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        by PRODEV - Desenvolvimento de sistemas.
    </footer>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php } else {

    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
        window.location.href = '../index.php';    
        </script>";
} ?>