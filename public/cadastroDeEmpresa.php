<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - Cadastro de empresa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://unpkg.com/imask"></script>
</head>

<body>
    <?php
        include_once(__DIR__ . '/header.php');
        include_once(__DIR__ . '/../DAO/DaoEmpresa.php');

        $empresa = null;

        if(isset($_GET['idEmpresa'])){
            $daoEmpresa = new DaoEmpresa((new Conexao())->conectar(), 1);
            $empresa = $daoEmpresa->selecionarEmpresa($_GET['idEmpresa']);                        
        }

        function verificarAction(){
            if(!isset($_GET['idEmpresa'])){
                echo "../controllers/cadastrarEmpresa.php";
            } else {
                echo "../controllers/alterarEmpresa.php";
            }
        }

    ?>
    <div class="container mt-5">
        <h2>Cadastro de empresa</h2>
        <form action="<?php verificarAction()?>" method="POST">
        <?php if(isset($_GET['idEmpresa'])){?>
            <input type="hidden" id="idEmpresa" name="idEmpresa" value="<?php echo $empresa->getIdEmpresa() ?>">
        <?php }?>
            <div class="form-group">
                <label for="razaoSocial">Razão Social:</label>
                <input type="text" class="form-control" id="razaoSocial" name="razaoSocial" required autocomplete="off" value="<?php echo isset($_GET['idEmpresa']) ? $empresa->getRazaoSocial (): " "?>">
            </div>
            <div class="form-group">
                <label for="cnpj">CNPJ:</label>
                <input type="text" class="form-control" id="cnpj" name="cnpj" required autocomplete="off" value="<?php echo isset($_GET['idEmpresa']) ? $empresa->getCnpj() : " "?>">
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="status" id="ativo" value="1" <?php echo isset($_GET['idEmpresa']) ? ($empresa->getStatusEmpresa() == 1 ? "checked" : "") : "";?> >
                <label for="ativo" class="form-check-label">Ativo</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="status" id="inativo" value="0" <?php echo isset($_GET['idEmpresa']) ? ($empresa->getStatusEmpresa() == 0 ? "checked" : "") : "";?>>
                <label for="inativo" class="form-check-label">Inativo</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Cadatrar empresa</button>
        </form>
    </div>

    <script>
        const element = document.getElementById('cnpj');
        const maskOptions = {
            mask: '00.000.000/0000-00'
        };
        const mask = IMask(element, maskOptions);
    </script>
</body>

</html>