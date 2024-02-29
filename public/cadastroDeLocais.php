<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - Cadastro de Locais</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
        include_once(__DIR__ . '/header.php');
        include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
        include_once(__DIR__ . '/../DAO/DaoLocal.php');
               
        $conexao = new Conexao();
        $daoEmpresa = new DaoEmpresa($conexao->conectar(), 1);
        $daoLocal = new DaoLocal($conexao->conectar(), 1);

        $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();
        $listaDeTipos = $daoLocal->gerarListaDeTIpos();
    
    ?>
    <div class="container mt-5">
        <h2>Cadastro de Locais</h2>
        <form action="../controllers/cadastrarLocais.php" method="POST">
            <div class="form-group">
                <select name="empresa" id="empresa" class="form-control">
                    <option value="--">Selecione a empresa</option>
                    <?php foreach($listaDeEmpresas as $empresa){ ?>
                        <option value="<?php echo $empresa->getIdEmpresa() ?>"><?php echo $empresa->getRazaoSocial() ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="tipoLocal">Tipo do local</label>
                <select name="tipoLocal" id="tipoLocal" class="form-control">
                    <option value="--">Selecione o tipo do local</option>
                    <?php foreach($listaDeTipos as $tipoLocal){?>
                        <option value="<?php echo $tipoLocal->idTipoLocal?>"><?php echo $tipoLocal->descLocal ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
                <label for="descLocal">Descrição do local</label>
                <input type="text" class="form-control" id="descLocal" name="descLocal" required autocomplete="off">
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="status" id="ativo" value="1">
                <label for="ativo" class="form-check-label">Ativo</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="status" id="inativo" value="0">
                <label for="inativo" class="form-check-label">Inativo</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Castrar Local</button>
        </form>
    </div>
</body>

</html>