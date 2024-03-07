<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus = PHP_SESSION_ACTIVE && $_SESSION['login']) {

    $idUsuario = $_SESSION['idUsuario'];

    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), $idUsuario);

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);
    $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();



    ?>
    <!DOCTYPE html>
    <html lang="en">

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
        <div class="container-fluid">
            <div class="row">
                <?php
                foreach ($listaDeEmpresas as $empresa) {
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $empresa->getRazaoSocial() ?>
                                </h5>
                                <p class="card-text">Relatórios disponíveis para empresa</p>
                                <table class="table">
                                    <thead>
                                        <th>relatórios</th>
                                        <th>Ação</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Eventos de checkin</td>
                                            <td><button class="btn btn-primary"
                                                    onclick="relatorioDeCheckin(<?php echo $empresa->getIdEmpresa() ?>)">Gerar
                                                    relatórios</button></td>
                                        </tr>
                                        <tr>
                                            <td>Checkin por local</td>
                                            <td><button class="btn btn-primary" onclick="checkInPorLocal()">Gerar
                                                    relatórios</button></td>
                                        </tr>
                                        <tr>
                                            <td>Justificativas</td>
                                            <td><button class="btn btn-primary" onclick="relJustificativas()">Gerar
                                                    relatórios</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>

            function relatorioDeCheckin(idEmpresa) {
                window.location.href = "eventosDeCheckin.php?idEmpresa=" + idEmpresa;
            }

            function checkInPorLocal() {
                window.location.href = "checkInPorLocal.php";
            }

            function relJustificativas() {
                window.location.href = "relatorioJustificativas.php";
            }

        </script>

        <footer>
            by PRODEV - Desenvolvimento de sistemas.
        </footer>
    </body>

    </html>
    <?php

} else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
        window.location.href = '../index.php';    
    </script>";
}

?>