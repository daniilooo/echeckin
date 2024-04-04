<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $_SESSION['idUsuario']);
    $usuario = $daoUsuario->selecionarUsuario($_SESSION['idUsuario']);

    $_SESSION['nomeUsuario'] = $usuario->getNome();
    $_SESSION['matriculaUsuario'] = $usuario->getMatricula();
    $_SESSION['empresaUsuario'] = $usuario->getEmpresa();
    $_SESSION['cargoUsuario'] = $usuario->getCargo();
    $_SESSION['loginUsuario'] = $usuario->getLogin();
    $_SESSION['statusUsuario'] = $usuario->getStatusUsuario();

    $contagemColab = $daoUsuario->contagemDeUsuarios();

    $ultimoLog = (new DaoLog($conexao->conectar(), $_SESSION['idUsuario']))->recuperarUltimoLog();

    if(isset($_GET['Login'])){
        if($_GET['Login'] == 1){
            $nomeUsuario = $_SESSION['nomeUsuario'];
            echo "<script>alert('Você ja está logado como ".$nomeUsuario.".')</script>";
        }
    }


    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>eCheckin - by Guibor Log</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/estilo.css">
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuários</h5>
                            <p class="card-text">Hoje existem
                                <?php echo $contagemColab ?> usuários cadastrados na base.
                            </p>
                            <a href="gerenciamentoUsuarios.php" class="btn btn-primary">Gerenciar usuários</a>
                            <a href="cadastroDeUsuario.php" class="btn btn-primary">Cadastrar novo usuário</a>
                            <a href="gerenciarCargos.php" class="btn btn-primary">Gerenciar cargos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Empresas</h5>
                            <p class="card-text">Veja e gerencie todas as empresas cadastradas no sistema.</p>
                            <a href="gerenciamentoEmpresas.php" class="btn btn-primary">Gerenciar empresa</a>
                            <a href="cadastroDeEmpresa.php" class="btn btn-primary">Cadastrar nova empresa</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Locais</h5>
                            <p class="card-text">Inclusão e gerenciamento de locais cadastrados por empresa.</p>
                            <a href="gerenciarLocais.php" class="btn btn-primary">Gerenciar locais</a>
                            <a href="cadastroDeLocais.php" class="btn btn-primary">Cadastrar locais</a>
                            <a href="#" class="btn btn-primary">Gerar placas de checkpoint</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Log de Atividas</h5>
                            <p class="card-text">
                                <?php echo $ultimoLog->getRegLog() ?><br>
                                <?php echo $ultimoLog->getDataHora() ?>
                            </p>

                            <a href="verificarLogAtividade.php" class="btn btn-primary">Verificar log completo</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Relatórios</h5>
                            <p class="card-text">Gerar relatórios de checkins.</p>
                            <a href="gerarRelatorios.php" class="btn btn-primary">Relátórios disponíveis</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Configurações</h5>
                            <p class="card-text">Condigurações de funcionamento do sistema.</p>
                            <a href="configuracaoDoSistema.php" class="btn btn-danger">Configurações do sistema</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">DEBUG</h5>
                            <p class="card-text">Ferramenta direciona apenas para o desenvolvedor.</p>
                            <a href="debugSistema.php" class="btn btn-danger">DEBUG</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reparo e alteração</h5>
                            <p class="card-text">Canal de solicitação de alteração e reparo no siste</p>
                            <a href="#" class="btn btn-danger">Enviar solicitação</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>            
            by PRODEV - Desenvolvimento de sistemas                         
        </footer>
        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function aviso() {
                alert("Função em fase de implementação, para mais informações, contate o desenvolvedor.")
            }
        </script>

    </body>

    </html>

    <?php
} else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
        window.location.href = '../index.php';    
    </script>";
}
?>