<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {
    $daoUsuario = new DaoUsuario((new Conexao())->conectar(), $_SESSION['idUsuario']);
    $usuario = $daoUsuario->selecionarUsuario($_SESSION['idUsuario']);

    $_SESSION['nomeUsuario'] = $usuario->getNome();
    $_SESSION['matriculaUsuario'] = $usuario->getMatricula();
    $_SESSION['empresaUsuario'] = $usuario->getEmpresa();
    $_SESSION['cargoUsuario'] = $usuario->getCargo();
    $_SESSION['loginUsuario'] = $usuario->getLogin();
    $_SESSION['statusUsuario'] = $usuario->getStatusUsuario();

    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Ronda e Checkin</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <style>
            body {
                background-color: #f8f9fa;
            }

            #sidebar {
                background-color: #007bff;
                color: #fff;
            }

            #content {
                margin-top: 20px;
            }

            a {
                color: #FFFFFF;
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">
                <!-- Menu Lateral -->
                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    Empresas
                                </a>
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Cadastrar empresas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Gerenciar empresas</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Locais
                                </a>
                                <!-- Subitens para o Menu 2 -->
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Cadastrar locais</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">gerenciar locais</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Usuarios
                                </a>
                                <!-- Subitens para o Menu 2 -->
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Submenu 2.1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Submenu 2.2</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Configurações
                                </a>
                                <!-- Subitens para o Menu 2 -->
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Submenu 2.1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Submenu 2.2</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Conteúdo -->
                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4" id="content">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Cabeçalho</h1>
                    </div>

                    <!-- Conteúdo da Página -->
                    <div class="container">
                        <div class="content" id="dynamic-content"></div>
                        <!-- Seu Conteúdo Aqui -->
                        <h2>Bem-vindo ao Sistema de Ronda e Checkin</h2>

                    </div>
                </main>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            // Função para carregar conteúdo na div #dynamic-content
            function loadContent(page) {
                // Aqui você pode adicionar lógica para mapear os links do menu para as páginas correspondentes
                var contentUrl = '';

                switch (page) {
                    case 'cadastrar-empresas':
                        contentUrl = 'cadastroDeEmpresa.php';
                        break;
                    case 'gerenciar-empresas':
                        contentUrl = 'gerenciarEmpresas.php';
                        break;
                    case 'cadastrar-locais':
                        contentUrl = 'cadastrarLocais.php';
                        break;
                    case 'gerenciar-locais':
                        contentUrl = 'gerenciarLocais.php';
                        break;
                    case 'submenu-2-1':
                        contentUrl = 'submenu21.php';
                        break;
                    case 'submenu-2-2':
                        contentUrl = 'submenu22.php';
                        break;
                    default:
                        contentUrl = 'bemVindo.php';
                        break;
                }

                // Carrega o conteúdo usando jQuery
                $.get(contentUrl, function (data) {
                    $('#dynamic-content').html(data);
                });
            }

            // Evento de clique nos links do menu
            $(document).ready(function () {
                $('.nav-link').on('click', function (e) {
                    e.preventDefault();
                    var page = $(this).text().toLowerCase().replace(/\s+/g, '-');
                    loadContent(page);
                });

                // Carrega o conteúdo inicial
                loadContent('bem-vindo');
            });
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