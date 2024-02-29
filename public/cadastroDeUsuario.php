<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eCheckin - Cadastro de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php
        include_once(__DIR__ . '/header.php');
        include_once(__DIR__ . '/../DAO/DaoEmpresa.php');
        include_once(__DIR__ . '/../DAO/DaoCargo.php');

        $daoEmpresa = new DaoEmpresa((new Conexao())->conectar(), 1);
        $daoCargo = new DaoCargo((new Conexao)->conectar(), 1);

        $listaDeEmpresas = $daoEmpresa->gerarListaEmpresas();
        $listaDeCargos = $daoCargo->gerarListaCargo();


    ?>

    <div class="container mt-3">
        <h2>Cadastro de Usuário</h2>
        <form method="POST" action="../controllers/cadastrarUsuario.php" onsubmit="return validarSenha()">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required
                    autocomplete="off">
            </div>
            <div class="form-group">
                <label for="matricula">Matricula:</label>
                <input type="matricula" class="form-control" id="matricula" name="matricula"
                    placeholder="Digite seu e-mail" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="empresa">Empresa:</label>
                <select name="empresa" id="empresa" class="form-control">
                    <option value="0">Selecione a empresa</option>
                    <?php
                        foreach($listaDeEmpresas as $empresa){
                    ?>
                    <option value="<?php echo $empresa->getIdEmpresa() ?>"><?php echo $empresa->getRazaoSocial()?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <label for="cargo">Cargo:</label>
            <div class="form-group">
                <select name="cargo" id="cargo" class="form-control">
                    <option value="0">Selecione o cargo</option>
                    <?php
                        foreach($listaDeCargos as $cargo){
                    ?>
                    <option value="<?php echo $cargo->idCargo ?>"><?php echo $cargo->descricaoCargo ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="senha">Login:</label>
                <input type="text" class="form-control" id="login" name="login" placeholder="Digite sua senha" required
                    autocomplete="off">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Confirme sua senha"
                    required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="confirmarSenha">Confirmar senha:</label>
                <input type="password" class="form-control" id="confirmarSenha" placeholder="Confirme sua senha"
                    required autocomplete="off">
            </div>
            <br>
            <div class="custom-file">
                <label for="foto" class="custom-file-label">Foto do usuário</label>
                <input type="file" class="custom-file-input" id="fotografia" name="foto" required>
            </div>
            <div class="form-check">
                <br>
                <input type="radio" class="form-check-input" name="status" id="ativo" value="1">
                <label for="ativo" class="form-check-label">Ativo</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="status" id="inativo" value="0">
                <label for="inativo" class="form-check-label">Inativo</label>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
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

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>