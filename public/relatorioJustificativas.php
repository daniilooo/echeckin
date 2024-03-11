<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoJustificativa.php');
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
    $daoJustificativa = new DaoJustificativa($conexao->conectar(), $idUsuario);
    $usuario = $daoUsuario->selecionarUsuario($idUsuario);

    if(isset($_GET['idEmpresa'])){        
        $empresa = $daoEmpresa->selecionarEmpresa($_GET['idEmpresa']);
    }
        
    $listaDeLocais = $daoLocal->gerarListaDeLocaisPorEmpresa($empresa->getIdEmpresa());
    $listaDeJustificativas = $daoJustificativa->gerarListaJustificativasPorEmpresa($empresa->getIdEmpresa());
    $listaDeUsuarios = $daoUsuario->gerarListaUsuarioPorEmpresa($empresa->getIdEmpresa());
    
    
    function nomeDoUsuario($daoUsuario, $idUsuario){
        $usuario = $daoUsuario->selecionarUsuario($idUsuario);
        return $usuario->getNome();
    }

    function descLocal($daoLocal, $idLocal){
        $local = $daoLocal->selecionarLocal($idLocal);
        return $local->getDescLocal();
    }


} else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
    window.location.href = '../index.php';    
    </script>";
    return;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Relatório</title>
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
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
                <div class="container-fluid d-flex justify-content-center">
            <!-- Adicionado mx-auto para centralizar horizontalmente -->
            <div class="row">

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Relatório de justificaticas</h5>

                            <!-- Formulário de busca -->
                            <div class="w-100 mb-3 d-flex"> <!-- Adicionado w-100 e d-flex -->
                                <form class="form-inline w-100"> <!-- Adicionado w-100 para ocupar 100% da largura -->
                                    <div class="form-group mr-2 flex-grow-1">
                                        
                                        <select class="form-control w-100 mb-3">                                            
                                            <option value="0" selected disabled>Selecione o local</option>
                                            <?php foreach($listaDeLocais as $local){?>
                                                <option value="<?php echo $local->getIdLocal()?>"><?php echo $local->getDescLocal()?></option>
                                            <?php }?>
                                        </select>
                                        <select name="usuario" id="usuario" class="form-control w-100 mb-3">
                                            <option value="0" selected disabled> Selecione o usuário</option>
                                            <?php foreach($listaDeUsuarios as $usuario){?>
                                                <option value="<?php echo $usuario->getIdUsuario()?>"><?php echo $usuario->getNome()?></option>
                                            <?php }?>
                                        </select>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </form>
                            </div>

    <!-- Content -->
    <div class="container-fluid d-flex justify-content-center">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Relatório</h5>

                        <!-- Tabela do relatório -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Local</th>
                                    <th>Justificativa</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listaDeJustificativas as $justificativa){?>
                                <tr>
                                    <td><?php echo nomeDoUsuario($daoUsuario, $justificativa->getIdUsuario())?></td>
                                    <td><?php echo descLocal($daoLocal, $justificativa->getIdLocal())?></td>
                                    <td><?php echo $justificativa->getJustificativa()?></td>
                                    <td><?php echo (new DateTime($justificativa->getDataHora()))->format('d/m/Y')?></td>
                                    <td><?php echo (new DateTime($justificativa->getDataHora()))->format('H:i:s')?></td>
                                </tr>
                                <?php }?>
                                <!-- Adicione mais linhas conforme necessário -->
                            </tbody>
                        </table>
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
