<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoLocal.php');
include_once(__DIR__ . '/../DAO/DaoCheckin.php');
include_once(__DIR__ . '/../DAO/DaoCargo.php');

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
    $daoCheckin = new DaoCheckin($conexao->conectar(), $idUsuario);
    $daoCargo = new DaoCargo($conexao->conectar(), $idUsuario);

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);

    if (isset($_GET['idEmpresa'])) {
        $empresa = $daoEmpresa->selecionarEmpresa($_GET['idEmpresa']);
    }

    $listaDeLocaisPorEmpresa = $daoLocal->gerarListaDeLocaisPorEmpresa($empresa->getIdEmpresa());
    $listaDeUsuariosPorEmpresa = $daoUsuario->gerarListaUsuarioPorEmpresa($empresa->getIdEmpresa());
    $listaDecheckinPorEmpresa = $daoCheckin->gerarListaCheckinPorEmpresa($empresa->getIdEmpresa());

    function tipoDoLocal($daoLocal, $idTipoLocal)
    {
        return $daoLocal->selecionarTipoLocal($idTipoLocal);
    }

    function status($flagStatus)
    {
        switch ($flagStatus) {
            case 0:
                return "Inativo";
            case 1:
                return "Ativo";
            default:
                return "Status desconhecido";
        }
    }

    function descLocal($daoLocal, $idLocal)
    {
        $local = $daoLocal->selecionarLocal($idLocal);
        return $local->getDescLocal();
    }

    function nomeUsuario($daoUsuario, $idUsuario)
    {
        $usuario = $daoUsuario->selecionarUsuario($idUsuario);
        return $usuario->getNome();
    }

    function cargo($daoCargo, $idCargo)
    {
        $cargo = $daoCargo->selecionarCargo($idCargo);
        return $cargo->descricaoCargo;
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
    <title>Relatório - <?php echo $empresa->getRazaoSocial() ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="../public/js/DataTables/datatables.css" rel="stylesheet">    
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
                        <h5 class="card-title">Locais cadastrados para <?php echo $empresa->getRazaoSocial()?></h5>
                        <table class="table">
                            <thead>
                                <th>Desc. Local</th>
                                <th>TIpo do local</th>
                                <th>Status do local</th>
                            </thead>
                            <tbody>
                                <?php foreach ($listaDeLocaisPorEmpresa as $local) { ?>
                                    <tr>
                                        <td><?php echo $local->getDescLocal() ?></td>
                                        <td><?php echo tipoDoLocal($daoLocal, $local->getFkTipoLocal()) ?></td>
                                        <td><?php echo status($local->getStatusLocal()) ?></td>
                                    </tr>
                                <?php } ?>                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuários cadatrados para <?php echo $empresa->getRazaoSocial()?></h5>
                        <table class="table">
                            <thead>
                                <th>Matricula</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>LOGIN</th>
                            </thead>
                            <tbody>
                                <?php foreach ($listaDeUsuariosPorEmpresa as $usuario) { ?>
                                    <tr>
                                        <td><?php echo $usuario->getMatricula() ?></td>
                                        <td><?php echo $usuario->getNome() ?></td>
                                        <td><?php echo cargo($daoCargo, $usuario->getCargo()) ?></td>
                                        <td><?php echo $usuario->getLogin() ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ultimos eventos de checkin em <?php echo $empresa->getRazaoSocial()?></h5>
                        <table class="table">
                            <thead>
                                <th>Local</th>
                                <th>Usuário</th>
                                <th>Data</th>
                                <th>Horário</th>
                            </thead>
                            <tbody>
                                <?php for ($cont = 0; $cont < count($listaDecheckinPorEmpresa); $cont++) { ?>
                                    <tr>
                                        <td><?php echo descLocal($daoLocal, $listaDecheckinPorEmpresa[$cont]['fkLocal']) ?></td>
                                        <td><?php echo nomeUsuario($daoUsuario, $listaDecheckinPorEmpresa[$cont]['fkUsuario']) ?></td>
                                        <td><?php echo (new DateTime($listaDecheckinPorEmpresa[$cont]['ocorrencia']))->format('d/m/Y') ?></td>
                                        <td><?php echo (new DateTime($listaDecheckinPorEmpresa[$cont]['ocorrencia']))->format('H:i:s') ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
