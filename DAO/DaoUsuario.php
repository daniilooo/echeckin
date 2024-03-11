<?php

include_once(__DIR__ . '/../model/usuario.php');
include_once(__DIR__ . '/DaoErro.php');

class DaoUsuario
{
    private $TBL_USUARIO = "TBL_USUARIO";
    private $conexao;
    private $idUsuarioSessao;

    function __construct($conexao, $idUsuarioSessao)
    {
        $this->conexao = $conexao;
        $this->idUsuarioSessao = $idUsuarioSessao;
    }

    private function inserirErro($erro, $localErro, $fkUsuario){
        $erro = new Erro(null, $erro, $localErro, (new DateTime())->format('Y-m-d H:i:s'), $fkUsuario);
        $daoErro = new DaoErro((new Conexao())->conectar());
        $daoErro->inserirErro($erro);
    }

    /**
     * @return $idUsuario
     * Tratamento de retorno:
     * -1 = Usuário não cadastrado;
     * -2 = Erro no sistema, verifique a TBL_ERROS
     * -3 = Já existe um usuário com essa matricula cadastrado no sistema.
     */
    function inserirUsuario(Usuario $usuario)
    {
        $nome = $usuario->getNome();
        $matricula = $usuario->getMatricula();
        $empresa = $usuario->getEmpresa();
        $cargo = $usuario->getCargo();
        $login = $usuario->getLogin();
        $senha = $usuario->getSenha();
        $status = $usuario->getStatusUsuario();

        $matricula = $usuario->getMatricula();

        try {

            $stmt = $this->conexao->prepare("SELECT * FROM {$this->TBL_USUARIO} WHERE MATRICULA = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();

            if ($stmt->fetch()) {
                return -3;
            } else {
                $stmt = $this->conexao->prepare("INSERT INTO {$this->TBL_USUARIO} (NOME, MATRICULA, EMPRESA, CARGO, LOGIN, SENHA, STATUS_USUARIO) VALUE (?,?,?,?,?,?,?)");
                $stmt->bind_param("ssiissi", $nome, $matricula, $empresa, $cargo, $login, $senha, $status);

                if ($stmt->execute()) {
                    return $stmt->insert_id;
                } else {
                    return -1;
                }
            }

        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.inserirUsuario", $this->idUsuarioSessao);
            return -2;
        }
    }

    function selecionarUsuario($idUsuario)
    {

        $nome = null;
        $matricula = null;
        $empresa = null;
        $cargo = null;
        $login = null;
        $senha = null;
        $status = null;

        try {
            $stmt = $this->conexao->prepare("SELECT NOME, MATRICULA, EMPRESA, CARGO, LOGIN, SENHA, STATUS_USUARIO FROM {$this->TBL_USUARIO} WHERE ID_USUARIO = ?");
            $stmt->bind_param("i", $idUsuario);

            $stmt->execute();
            $stmt->bind_result($nome, $matricula, $empresa, $cargo, $login, $senha, $status);

            if ($stmt->fetch()) {
                return new Usuario($idUsuario, $nome, $matricula, $empresa, $cargo, $login, $senha, $status);
            } else {
                return false;
            }

        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.selecionarUsuario", $this->idUsuarioSessao);
            return -2;
        }
    }

    function contarUsuarioPorEmpresa(){
        $qtdUserEmp = [];
        try {
            $stmt = $this->conexao->prepare("SELECT EMPRESA, COUNT(*) AS QTD_USUARIOS FROM {$this->TBL_USUARIO} GROUP BY EMPRESA");
            $stmt->execute();
    
            $result = $stmt->get_result();
    
            while ($row = $result->fetch_assoc()) {
                $qtdUserEmp[] = [
                    'empresa' => $row['EMPRESA'],
                    'quantUser' => $row['QTD_USUARIOS']
                ];
            };
    
            return $qtdUserEmp;
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.contarUsuarioPorEmpresa", $this->idUsuarioSessao);
            return -2;
        }
    }
    


    function contagemDeUsuarios()
    {
        try {
            $stmt = $this->conexao->prepare("SELECT COUNT(*) AS QUANTIDADE_USUARIOS FROM {$this->TBL_USUARIO}");
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row != null) {
                return $row['QUANTIDADE_USUARIOS'];
            }
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.contagemDeUsuarios", $this->idUsuarioSessao);
            return -2;
        }
    }

    function atualizarUsuario(Usuario $usuario)
    {
        $idUsuario = $usuario->getIdUsuario();
        $nome = $usuario->getNome();
        $matricula = $usuario->getMatricula();
        $empresa = $usuario->getEmpresa();
        $cargo = $usuario->getCargo();
        $login = $usuario->getLogin();
        $status = $usuario->getStatusUsuario();

        try{
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_USUARIO} SET NOME = ?, MATRICULA = ?, EMPRESA = ?, CARGO = ?, LOGIN = ?, STATUS_USUARIO = ? WHERE ID_USUARIO = ?");
            $stmt->bind_param("ssiisii", $nome, $matricula, $empresa, $cargo, $login, $status, $idUsuario);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -1;
            }

        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.atualizarUsuario", $this->idUsuarioSessao);
            return -2;
        }
    }

    function alterarStatus(Usuario $usuario)
    {
        $idUsuario = $usuario->getIdUsuario();
        $status = $usuario->getStatusUsuario();

        try {
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_USUARIO} SET STATUS_USUARIO = ? WHERE ID_USUARIO = ?");
            $stmt->bind_param("ii", $idUsuario, $status);

            if ($stmt->execute()) {
                return $stmt->affected_rows;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.alterarStatus", $this->idUsuarioSessao);
            return -2;
        }
    }

    function resetarSenha($idUsuario){
        try{
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_USUARIO} SET SENHA = ? WHERE ID_USUARIO = ?");
            $stmt->bind_param("si", password_hash("123456", PASSWORD_DEFAULT), $idUsuario);

            if($stmt->execute()){
                return $stmt->affected_rows;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.resetarSenha", $this->idUsuarioSessao);
            return -2;
        }
    }

    function alterarSenha(Usuario $usuario, $novaSenha)
    {
        $idUsuario = $usuario->getIdUsuario();
        $senhaUsuario = $usuario->getSenha();
        $senhaBd = null;

        try {
            $stmt = $this->conexao->prepare("SELECT SENHA FROM {$this->TBL_USUARIO} WHERE ID_USUARIO = ?");
            $stmt->bind_param("i", $idUsuario);
            $stmt->execute();
            $stmt->bind_result($senhaBd);
            $stmt->fetch();

            if ($senhaBd != null && password_verify($senhaBd, $senhaUsuario)) {

                $stmt = $this->conexao->prepare("UPDATE {$this->TBL_USUARIO} SET SENHA = ? WHERE ID_USUARIO = ?");
                $stmt->bind_param("si", password_hash($novaSenha, PASSWORD_DEFAULT), $idUsuario);

                if ($stmt->execute()) {
                    return $stmt->affected_rows;
                } else {
                    return -1;
                }

            } else {
                return -3;
            }

        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.alterarSenha", $this->idUsuarioSessao);
            return -2;
        }
    }

    function gerarListaUsuarios()
    {
        $listaDeUsuarios = [];
        $idUsuario = null;
        $nome = null;
        $matricula = null;
        $empresa = null;
        $cargo = null;
        $login = null;
        $senha = null;
        $status = null;

        try {
            $stmt = $this->conexao->prepare("SELECT ID_USUARIO, NOME, MATRICULA, EMPRESA, CARGO, LOGIN, SENHA, STATUS_USUARIO FROM {$this->TBL_USUARIO}");
            $stmt->execute();
            $stmt->bind_result($idUsuario, $nome, $matricula, $empresa, $cargo, $login, $senha, $status);

            while ($stmt->fetch()) {
                $usuario = new Usuario($idUsuario, $nome, $matricula, $empresa, $cargo, $login, $senha, $status);
                $listaDeUsuarios[] = $usuario;
            }

            return $listaDeUsuarios;

        } catch (Exception $e) {
            $this->inserirErro($e->getMessage(), "DaoUsuario.gerarListaUsuarios", $this->idUsuarioSessao);
            return -2;
        }
    }

    function gerarListaUsuarioPorEmpresa($idEmpresa){
        $listaUsuario = [];
        try{
            $stmt = $this->conexao->prepare("SELECT ID_USUARIO, NOME FROM {$this->TBL_USUARIO} WHERE EMPRESA = ?");
            $stmt->bind_param("i", $idEmpresa);

            $stmt->execute();
            $result = $stmt->get_result();

            while($row = $result->fetch_assoc()){
                $usuario = new Usuario($row['ID_USUARIO'], $row['NOME'], null, null, null, null, null, null);
                $listaUsuario[] = $usuario;
            }

            $result->close();
            return $listaUsuario;
        }catch (Exception $e){
            $this->inserirErro($e->getMessage(), "DaoUsuario.gerarListaUsuarioPorEmpresa", $this->idUsuarioSessao);
            return null;
        }
    }
}

?>