<?php

session_start();
$sessionStatus = session_status();

if ($sessionStatus == PHP_SESSION_ACTIVE) {
    //echo $_SESSION['idUsuario'];
} else {
    echo "Não estamos logados";
}

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
                                Menu 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Menu 2
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
                                Menu 3
                            </a>
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
                    <!-- Seu Conteúdo Aqui -->
                    <h2>Bem-vindo ao Sistema de Ronda e Checkin</h2>
                    <p>Conteúdo da página...</p>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
