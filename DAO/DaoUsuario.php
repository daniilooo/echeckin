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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.inserirUsuario", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.selecionarUsuario", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.contarUsuarioPorEmpresa", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.contagemDeUsuarios", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }

    function atualizarUsuario(Usuario $usuario)
    {
        $idUsuario = $usuario->getIdUsuario();
        $nome = $usuario->getNome();
        $matricula = $usuario->getMatricula();
        $login = $usuario->getLogin();
        $senha = $usuario->getSenha();
        $status = $usuario->getStatusUsuario();

        try {
            $stmt = $this->conexao->prepare("UPDATE {$this->TBL_USUARIO} SET NOME = ?, LOGIN = ?, SENHA = ?, STATUS_USUARIO = ? WHERE ID_USUARIO = ?");
            $stmt->bind_param("sssii", $nome, $login, $senha, $status, $idUsuario);

            if ($stmt->execute()) {
                return $stmt->affected_rows;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.atualizarUsuario", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.alterarStatus", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.alterarStatus", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
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
            $dataHoraFormatada = new DateTime();
            $erro = new Erro(0, $e->getMessage(), "DaoUsuario.gerarListaUsuarios", $dataHoraFormatada->format('Y-m-d H:i:s'), $this->idUsuarioSessao);
            $conexaoTblErro = new Conexao();
            $daoErro = new DaoErro($conexaoTblErro->conectar());
            $daoErro->inserirErro($erro);
            return -2;
        }
    }
}

?>