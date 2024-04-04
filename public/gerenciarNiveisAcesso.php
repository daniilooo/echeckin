
<?php

    include_once(__DIR__ . '/../DAO/DaoUsuario.php');
    include_once(__DIR__ . '/../DAO/DaoNivelAcesso.php');

    session_start();
    $sessionStatus = session_status();
    
    if(!isset($_SESSION['login'])){
        $_SESSION['login'] = false;
    }
    
    if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){
        $idUsuario = $_SESSION['idUsuario'];
        $conexao = new Conexao();
        $daoUsuario = new DaoUsuario($conexao->conectar(), $idUsuario);
        $daoNiveisAcesso = new DaoNivelAcesso($conexao->conectar(), $idUsuario);
        $usuario = $daoUsuario->selecionarUsuario($idUsuario);

        $listaNiveisAcesso = $daoNiveisAcesso->gerarListaNiveisAcesso();
        
        $quantNivelAcesso = $daoNiveisAcesso->contagemUsuarioNivelAcesso();

        function status($flagStatus){
            switch($flagStatus){
                case 0:
                    return "Configuração de nível de<br>acesso<span style='color: #FF0000;'> Inativa</span>";                    
                case 1:
                    return "Configuração de nível de<br>acesso<span style='color: #228B22;'> Ativa</span>";
                default:
                    return "<span style='color: #B8860B;'>Status desconhecido</span>";
            }
        }
 
    } else {
        return;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>eCheckin - Config / Niveis de acesso / Gerenciar niveis de acesso</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <!--
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
    -->
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
   <div class="container-fluid d-flex justify-content-center"> <!-- Adicionado mx-auto para centralizar horizontalmente -->
        <div class="row">
		
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerenciar os níveis de acesso cadastrados no sistema</h5>

                        <!-- Formulário de busca -->
                        <form class="form-inline mb-3">
                            <div class="form-group mr-2">
                                <input type="text" class="form-control" placeholder="Buscar por nome">
                            </div>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </form>

                        <!-- Tabela de usuários -->
                        <div class="mx-auto"> <!-- Adicionado para centralizar horizontalmente -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Descrição nível de acesso</th>
                                        <th>Usuários com esse nivel de acesso</th>
                                        <th>Status </th>
                                        <th>Ações</th>
                                        <!-- Adicione mais colunas conforme necessário -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($listaNiveisAcesso as $nivelAcesso){?>
                                    <tr>
										<td><?php echo $nivelAcesso->getIdNivelAcesso()?></td>
										<td><?php echo $nivelAcesso->getDescNivelAcesso()?></td>
										<td><?php 
                                            for($cont = 0; $cont < count($quantNivelAcesso); $cont++){
                                                if($quantNivelAcesso[$cont]['idNivelAcesso'] == $nivelAcesso->getIdNivelAcesso()){
                                                    echo $quantNivelAcesso[$cont]['quantUser'];
                                                }
                                            }
                                        ?></td>
										<td><?php echo status($nivelAcesso->getStatusNivelAcesso())?></td>
                                        <td><button class="btn btn-primary">Configurar privilégios</button></td>
									<tr>
                                    <?php }?>
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
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>