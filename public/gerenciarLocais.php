<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');

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

    $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();
    $listaDeLocais = $daoLocal->gerarlistaDeLocais();
}

function status($flagStatus){
    switch($flagStatus){
        case 0:
            return "Inativo";
        case 1:
            return "Ativo";
        default:
            return "Falha";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>iCloud-like Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #007bff;
            /* Cor de fundo da faixa */
            color: white;
            /* Cor do texto */
            text-align: center;
            line-height: 20px;
            /* Altura da faixa */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">eCheckin</a>
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
                    <a class="nav-link" href="#" onclick="aviso()">Gerenciar<br>Locais cadastrados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Relatórios<br>disponíveis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manual do<br>sistema</a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link user-box" style="background-color: #B0C4DE;">
                        <?php echo $usuario->getNome() ?><br>Gerenciar conta
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="container-fluid">
        <div class="row">
            <?php 
                foreach ($listaDeEmpresas as $empresa) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo $empresa->getRazaoSocial() ?>
                            </h5>
                            <p class="card-text">
                                Quantidade de locais cadastrados:
                                <?php echo $empresa->getQtdLocais() ?><br>
                                Quantidade de usuarios cadastrados:
                                <?php echo "000" ?>
                            </p>
                            <?php if($empresa->getQtdLocais() > 0){?>
                            <table class="table">
                                <thead>
                                    <td>Tipo</td>
                                    <td>Descrição</td>
                                    <td>Status</td>
                                    <td>CheckPoint</td>
                                </thead>
                                <tbody>
                                    <?php 
                                        $listaDeLocais = $daoLocal->gerarListaDeLocaisPorEmpresa($empresa->getIdEmpresa());
                                        foreach($listaDeLocais as $local){                                            
                                    ?>
                                    <tr>
                                        <td><?php echo $local->getFkTipoLocal()?></td>
                                        <td><?php echo $local->getDescLocal()?></td>
                                        <td><?php echo status($local->getStatusLocal())?></td>
                                        <td>
                                            <button class="btn btn-primary">Gerar</button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <?php } else {?>
                                <p class="card-text" >Não existem locais cadastrados para essa empresa</p>
                                <?php }?>
                            <a href="#" class="btn btn-primary">View Documents</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <footer>
                by PRODEV - Desenvolvimento de sistemas.
            </footer>
            <!-- Bootstrap JS and dependencies -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>