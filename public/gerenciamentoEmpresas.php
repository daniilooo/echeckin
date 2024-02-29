<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - gerenciamento de empresas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<?php

include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

if(isset($_GET['altSucces'])){
    if($_GET['altSucces'] == 1){
        echo "<script>alert('Empresa alterada com sucesso.')</script>";
    } else {
        echo "<script>alert('Não foi possível alterar o cadastro da empresa.')</script>";
    }
}

$conexao = new Conexao();
$daoEmpresa = new DaoEmpresa($conexao->conectar(), 1);

$listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();

?>

<body>
    <?php
    include_once(__DIR__ . '/header.php');
    ?>
    <div class="container mt-4">
        <h2>Gerenciamento de Empresas</h2>

        <!-- Campo de Busca -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Digite sua busca" aria-label="Digite sua busca"
                aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="button-addon2">Pesquisar</button>
            </div>
        </div>

        <!-- Tabela de Resultados -->
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Razão social</th>
                    <th scope="col">CNPJ</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">Qtd. Locais cadastrados</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($listaDeEmpresas as $empresa) {
                    ?>
                    <tr>
                        <th scope="row">
                            <a href="cadastroDeEmpresa.php?idEmpresa=<?php echo $empresa->getIdEmpresa() ?>"><?php echo $empresa->getRazaoSocial() ?></a>
                        </th>
                        <th>
                            <?php echo $empresa->getCnpj() ?>
                        </th>
                        <th>
                            <?php echo $empresa->getStatusEmpresa() ?>
                        </th>
                        <th>
                            <?php echo $empresa->getQtdLocais() ?>
                        </th>
                        <th>
                            <button class="btn btn-primary" onclick="verLocais(<?php echo $empresa->getIdEmpresa()?>)">Ver locais</button>
                            <!--<button class="btn btn-danger">Alterar empresa</button>-->
                            <button class="btn btn-secondary" onclick="cadatrarLocal()">Cadastrar local</button>
                        </th>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function verLocais(idEmpresa) {
            window.location.href = "http://localhost/echeckin/public/verLocaisPorEmpresa.php?idEmpresa=" + idEmpresa;
        }

        function cadatrarLocal(){
            window.location.href = "cadastroDeLocais.php";
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>