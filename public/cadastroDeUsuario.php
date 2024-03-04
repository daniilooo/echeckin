<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
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
    $daoCargo = new DaoCargo($conexao->conectar(), $idUsuario);

    $usuario = $daoUsuario->selecionarUsuario($idUsuario);

    $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();
    $listaDeCargos = $daoCargo->gerarListaCargo();

    function verificarAction(){
        if(isset($_GET['idUsuarioAlt'])){
            return true;
        } else {
            return false;
        }
    }

    if(isset($_GET['idUsuarioAlt'])){
        $usuarioAlt = $daoUsuario->selecionarUsuario($_GET['idUsuarioAlt']);       
    }


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>e-Checkin - Cadatro de usuaários</title>
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
            color: white;
            text-align: center;
            line-height: 20px;
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
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulário de Cadastro de usuários</h5>

                        <!-- Formulário de cadastro -->
                        <form method="POST" action=<?php echo !verificarAction() ? "../controllers/cadastrarUsuario.php" : "../controllers/alterarUsuario.php"?> onsubmit="return validarSenha()">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome do colaborador" autocomplete="off" required value="<?php echo verificarAction() ? $usuarioAlt->getNome() : null ?>">
                            </div>
                            <div class="form-group">
                                <label for="empresa">Empresa:</label>
                                <select name="empresa" id="empresa" class="form-control">
                                    <option value="--" selected disabled>Selecione a empresa</option>                               
                                        <?php foreach($listaDeEmpresas as $empresa){?>
                                            <option value="<?php echo $empresa->getIdEmpresa()?>" <?php echo verificarAction() ? $empresa->getIdEmpresa() == $usuarioAlt->getEmpresa() ? "selected" : "" : ""?>><?php echo $empresa->getRazaoSocial()?></option>
                                        <?php }?>                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cargo">Cargo:</label>
                                <select name="cargo" id="cargo" class="form-control">
                                    <option value="--" selected disabled>Selecione o cargo</option>
                                    <?php foreach($listaDeCargos as $cargo){?>
                                        <option value="<?php echo $cargo->idCargo?>" <?php echo  verificarAction() ? $cargo->idCargo == $usuarioAlt->getCargo() ? "selected" : "" : "" ?>><?php echo $cargo->descricaoCargo?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="matricula">Matricula:</label>
                                <input type="text" class="form-control" id="matricula" name="matricula" placeholder="Digite a matricula do usuário" autocomplete="off" required value="<?php echo verificarAction() ? $usuarioAlt->getMatricula() : null ?>">
                            </div>
                            <div class="form-group">
                                <label for="login">Login</label>
                                <input type="text" class="form-control" id="login" name="login" placeholder="Digite o login do usuário" autocomplete="off" required value="<?php echo verificarAction() ? $usuarioAlt->getLogin() : null ?>">
                            </div>
                            <?php if(!verificarAction()){?>
                            <div class="form-group">
                                <label for="senha">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
                            </div>
                            <div class="form-group">
                                <label for="confirmSenha">Confirmação de senha:</label>
                                <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="Confirmação de senha">
                            </div>
                            <?php } else {?>
                                <div class="form-group">
                                    <a class="btn btn-danger" <?php echo verificarAction() ? "onClick = resetarSenha(".$usuarioAlt->getIdUsuario().")" : null?>>Resetar a senha do usuário</a>
                                </div>
                            <?php }?>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="ativo" name="status" value="1" <?php echo verificarAction() ? $usuarioAlt->getStatusUsuario() == 1 ? "checked" : "" : ""?>>
                                <label for="ativo" class="form-check-label">Ativo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="inativo" name="status" value="0" <?php echo verificarAction() ? $usuarioAlt->getStatusUsuario() == 0 ? "checked" : "" : ""?>>
                                <label for="inativo">Inativo</label>
                            </div>
                            <?php if(verificarAction()){?>
                                <input type="hidden" id="idUsuarioAlt" name="idUsuarioAlt" value="<?php echo $usuarioAlt->getIdUsuario()?>">
                            <?php }?>                            
                            <button type="submit" class="btn <?php echo verificarAction() ? "btn-warning" : "btn-primary"?>"><?php echo verificarAction() ? "Alterar cadastro" : "Cadastrar usuário"?></button>
                        </form>
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
    <script>

        function validarSenha() {
            var senha = document.getElementById('senha').value;
            var confirmarSenha = document.getElementById('confirmarSenha').value;

            if (senha != confirmarSenha) {
                alert("As senhas digitadas devem ser iguais");
                return false;
            } else {
                return true;
            }
        }

        function resetarSenha(idUsuario){
            window.location.href = "../controllers/resetarSenhaUsuario.php?idUsuario="+idUsuario
        }

    </script>
</body>

</html>

<?php } else {
    echo "<script>alert('Para utilizar o sistema eCheckin é necessário fazer login.');
    window.location.href = '../index.php';    
    </script>";
}?>