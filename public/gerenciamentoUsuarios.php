<?php

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
include_once(__DIR__ . '/../DAO/DaoCargo.php');

session_start();
$sessionStatus = session_status();

if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
}

if ($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']) {

    $idUsuarioSessao = $_SESSION['idUsuario'];

    $conexao = new Conexao();
    $daoEmpresa = new DaoEmpresa($conexao->conectar(), $idUsuarioSessao);
    $daoCargo = new DaoCargo($conexao->conectar(), $idUsuarioSessao);
    $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuarioSessao);
    $usuario = $daoUsuario->selecionarUsuario($idUsuarioSessao);

    $_SESSION['nomeUsuario'] = $usuario->getNome();
    $_SESSION['matriculaUsuario'] = $usuario->getMatricula();
    $_SESSION['empresaUsuario'] = $usuario->getEmpresa();
    $_SESSION['cargoUsuario'] = $usuario->getCargo();
    $_SESSION['loginUsuario'] = $usuario->getLogin();
    $_SESSION['statusUsuario'] = $usuario->getStatusUsuario();   
    
    $listaDeEmpresas = (new DaoEmpresa($conexao->conectar(), $_SESSION['idUsuario']))->gerarListaEmpresas();
    $listaDeUsuarios = $daoUsuario->gerarListaUsuarios();

    if(isset($_GET['addSucces'])){

        switch($_GET['addSucces']){
            case 0:
                echo "<script>alert('Falha ao cadastra usuário, contate do administrador do sistema')</script>";
                break; 
            case 1:
                echo "<script>alert('Usuário cadastrado com sucesso')</script>";
                break;
            default:
                echo "<script>alert('Status desconhecido, contate o administrador do sistema')</script>";        
        }
    }
    
    if(isset($_GET['altSucces'])){
        switch($_GET['altSucces']){
            case 0:
                echo "<scrip>alert('Falha na atualização do cadastro do usuário')</script>";
                break;
            case 1:
                echo "<script>alert('Cadastro alterado com sucesso')</script>";
                break;
            default:
                echo "<script>alert('Status desconhecido, contate o administrador do sistema')</script>";
        }
    }

    if(isset($_GET['resSucces'])){
        switch($_GET['resSucces']){
            case 0:
                echo "<script>alert('Não foi posspivel resetar a senha do usuário, contate o administrador do sistema')</script>";
                break;
            case 1:
                echo "<script>alert('Senha redefinida com sucesso, será solicitado que o usuário altere a senha na próxima vez que ele logar no sistema.')</script>";
                break;
            default:
                echo "<script>alert('Status desconhecido, contate o administrado do sistema.')</script>";
        }
    }

       
    function empresa($daoEmpresa, $idEmpresa){
        $empresa = $daoEmpresa->selecionarEmpresa($idEmpresa);

        if($empresa != null){
            return $empresa->getRazaoSocial();
        } else {
            return "Empresa não encontrada";
        }
    }

    function cargo($daoCargo, $idCargo){
        $cargo = $daoCargo->selecionarCargo($idCargo);

        if($cargo != null){
            return $cargo->descricaoCargo;
        } else {
            return "Cargo não encontrado";
        }
    }

    function status($flagStatus){
        switch($flagStatus){
            case 0:
                return "Inativo";
            case 1:
                return "Ativo";
            default:
                return "Status invalido";            
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
                        <a class="nav-link" href="#">Gerenciar<br>usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gerenciar<br>empresas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Gerenciar<br>Locais cadastrados</a>
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
        <div class="container-fluid d-flex justify-content-center">
            <!-- Adicionado mx-auto para centralizar horizontalmente -->
            <div class="row">

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Gerenciar Usuários</h5>

                            <!-- Formulário de busca -->
                            <div class="w-100 mb-3 d-flex"> <!-- Adicionado w-100 e d-flex -->
                                <form class="form-inline w-100"> <!-- Adicionado w-100 para ocupar 100% da largura -->
                                    <div class="form-group mr-2 flex-grow-1">
                                        
                                        <select class="form-control w-100 mb-3">                                            
                                            <option value="0">Selecione a empresa para consulta do usuarios</option>
                                            <?php foreach($listaDeEmpresas as $empresa){?>
                                            <option value="<?php echo $empresa->getIdEmpresa()?>"><?php echo $empresa->getRazaoSocial() ?></option>
                                            <?php }?>
                                        </select>
                                        <input type="text" class="form-control w-100" placeholder="Buscar por nome">
                                        
                                    </div>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </form>
                            </div>



                            <!-- Tabela de usuários -->
                            <div class="mx-auto"> <!-- Adicionado para centralizar horizontalmente -->
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Matricula</th>
                                            <th>Nome</th>
                                            <th>Empresa</th>
                                            <th>Cargo</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($listaDeUsuarios as $usuario){
                                            if($usuario->getStatusUsuario() == 1){?>
                                        <tr>
                                            <th><a href="cadastroDeUsuario.php?idUsuarioAlt=<?php echo $usuario->getIdUsuario()?>"><?php echo $usuario->getMatricula() ?></a></th>
                                            <th><?php echo $usuario->getNome() ?></th>
                                            <th><?php echo empresa($daoEmpresa, $usuario->getEmpresa()) ?></th>
                                            <th><?php echo cargo($daoCargo, $usuario->getCargo()) ?></th>
                                            <th><?php echo status($usuario->getStatusUsuario() )?></th>
                                            <th>
                                                <button class="btn btn-primary mb-2">Alterar status</button>
                                                <button class="btn btn-secondary mb-2" onclick="resetarSenha(<?php echo $usuario->getIdUsuario()?>)">Resetar senha</button>
                                                <button class="btn btn-danger mb-2">Bloquear acesso</button>
                                            </th>
                                        <tr>
                                        <?php }
                                    }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function resetarSenha(idUsuario){
                window.location.href= "../controllers/resetarSenhaUsuario.php?idUsuario="+idUsuario;
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