<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

session_start();

$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {

    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
    $daoLog = new DaoLog($conexao->conectar(), $idUsuario);

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);
    $listaDeLogs = $daoLog->gerarListaLog();

    function usuario($daoUsuario, $idUsuario)
    {
        $usuario = $daoUsuario->selecionarUsuario($idUsuario);

        if ($usuario != null) {
            $dadosUsuario = [
                'idUsuario' => $usuario->getIdUsuario(),
                'nome' => $usuario->getNome()
            ];

            return $dadosUsuario;
        }
    }


}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>eCheckin - Gerenciar Usuários</title>
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

        .user-box {
            border-radius: 5px;
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
                </ul>
            </div>
        </nav>

    <!-- Content -->
    <div class="container-fluid d-flex justify-content-center">
        <!-- Adicionado mx-auto para centralizar horizontalmente -->
        <div class="row">

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verificar Log do sistema</h5>

                        <div class="w-100 mb-3 d-flex"> <!-- Adicionado w-100 e d-flex -->
                                <form class="form-inline w-100"> <!-- Adicionado w-100 para ocupar 100% da largura -->
                                    <div class="form-group mr-2 flex-grow-1">                                        
                                        <select class="form-control w-100 mb-3">                                            
                                            <option value="00" selected disabled>Selecione o tipo de log</option>
                                            <option value="1">Inclusão de empresa</option>
                                            <option value="2">Inclusão de local</option>
                                            <option value="3">Inclusão de usuário</option>
                                            <option value="4">Inclusão de cargo</option>
                                            <option value="5">Alteração de empresa</option>
                                            <option value="6">Alteração de local</option>
                                            <option value="7">Alteração de usuário</option>
                                            <option value="8">Alteração de cargo</option>
                                            <option value="9">Alteração de status de empresa</option>
                                            <option value="10">Alteração de status de local</option>
                                            <option value="11">Alteração de status de usuário</option>
                                            <option value="12">Alteração de status de cargo</option>
                                            <option value="13">Geração de checkpoint</option>
                                        </select>  
                                    </div>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </form>
                            </div>
                        
                        <!-- Tabela de usuários -->
                        <div class="mx-auto"> <!-- Adicionado para centralizar horizontalmente -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID LOG</th>
                                        <th>LOG</th>
                                        <th>Data e Hora</th>
                                        <th>Usuário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listaDeLogs as $log) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $log->getIdLog() ?>
                                            </td>
                                            <td>
                                                <?php echo $log->getRegLog() ?>
                                            </td>
                                            <td>
                                                <?php echo (new DateTime($log->getDataHora()))->format('d/m/Y H:i:s') ?>
                                            </td>
                                            <td>
                                                <?php
                                                $dadosUsuario = usuario($daoUsuario, $usuario->getIdUsuario());
                                                if (count($dadosUsuario) > 0) {
                                                    echo "<a href='#' onClick='verificarUsuario(".$dadosUsuario['idUsuario'].")'>".$dadosUsuario['nome']."</a>";
                                                }
                                                ?>

                                            </td>
                                        <tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        by PRODEV - Desenvolvimento de sistemas.
    </footer>
    <script>
        function verificarUsuario(idUsuario){
            window.location.href = "cadastroDeUsuario.php?idUsuarioAlt=" +idUsuario;
        }
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>