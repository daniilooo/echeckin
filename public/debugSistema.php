<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');

session_start();

$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {
    $idUsuario = $_SESSION['idUsuario'];
    $conexao = new Conexao();
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
    $daoErro = new DaoErro($conexao->conectar());

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);
    $listaDeErro = $daoErro->gerarListaErros();


    function nomeUsuario($daoUsuario, $idUsuario){
        $usuario = $daoUsuario->selecionarUsuario($idUsuario);
        return $usuario->getNome();
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
    <link rel="stylesheet" href="css/estilo.css">
    <link href="../public/js/DataTables/datatables.css" rel="stylesheet">   

</head>

<body onload="aviso()">
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
        <!-- Adicionado mx-auto para centralizar horizontalmente -->
        <div class="row">

            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">DEBUB do sistema</h5>

                        <form class="form-inline mb-3 w-100">
                            <div class="form-group mr-2 flex-grow-1">
                                <input type="text" class="form-control w-100" placeholder="Buscar por LOG de erro">
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>
                        
                        <!-- Tabela de usuários -->
                        <div class="mx-auto"> <!-- Adicionado para centralizar horizontalmente -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID ERRO</th>
                                        <th>DESCRIÇÃO ERRO</th>
                                        <th>LOCAL</th>
                                        <th>DATA</th>
                                        <th>USUARIO</th>
                                        <!-- Adicione mais colunas conforme necessário -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($listaDeErro as $erro) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $erro->getIdErro() ?>
                                            </td>
                                            <td>
                                                <?php echo $erro->getErro() ?>
                                            </td>
                                            <td>
                                                <?php echo $erro->getLocal() ?>
                                            </td>
                                            <td>
                                                <?php echo $erro->getData() ?>
                                            </td>
                                            <td>
                                                <?php echo nomeUsuario($daoUsuario, $erro->getUsuario()) ?>
                                            </td>
                                        </tr>
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
        function aviso() {
            alert("Essa área é destina apenas ao desenvolvedor e ao administadores do sistema.");
        }
    </script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>                
                <script src="../public/js/DataTables/datatables.js"></script>

                <script>
                    $(document).ready(function() {
                        // Aplicar DataTables às tabelas com classe "table"
                        $('.table').DataTable({
                            paging: true,
                            pageLength: 10,
                            lengthChange: false,
                            info: false,
                            searching: false,                            
                        });
                    });
                    
                </script>
</body>

</html>