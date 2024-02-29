<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - gerenciamento de usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoUsuario.php');

$conexao = new Conexao();
$daoUsuario = new DaoUsuario($conexao->conectar(), 1);

$listaDecolaboradores = $daoUsuario->gerarListaUsuarios();

if(isset($_GET['addSucces'])){
    if($_GET['addSucces'] == 1){
        echo "<script> alert('Usuário cadastrado com sucesso !')</script>";
    } 
}

?>

<body>
<?php
include_once(__DIR__ .'/header.php');
?>
    <div class="container mt-4">
        <h2>Gerenciamento de Usuários</h2>

        <!-- Campo de Busca -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Digite sua busca" aria-label="Digite sua busca" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="button-addon2">Pesquisar</button>
            </div>
        </div>

        <!-- Tabela de Resultados -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Matricula</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Login</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($listaDecolaboradores as $usuario){
                ?>
                <tr>
                    <th scope="row"><?php echo $usuario->getMatricula()?></th>
                    <td><?php echo $usuario->getNome() ?></td>
                    <td><?php echo $usuario->getEmpresa() ?></td>
                    <td><?php echo $usuario->getCargo() ?></td>
                    <td><?php echo $usuario->getLogin() ?></td>
                    <td><?php echo $usuario->getStatusUsuario()?></td>
                    <td>
                        <button class="btn btn-danger">Inativar usuário</button>
                        <button class="btn btn-primary">Alterar usuário</button>
                    </td>
                </tr>   
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
