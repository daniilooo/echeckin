<?php

class Conexao
{
    /* DADOS CONEXÃO COM O BD EM AMBIENTE DE HOMOLOGAÇÃO
    private $servername = "localhost";
    private $username = "f4fsis66_echeckin";
    private $password = "Klm3pt4af";
    private $dbname = "f4fsis66_echeckin";*/

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "echeckin";
    private $conn;

    function conectar()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $this->conn->connect_error);
        }

        return $this->conn;
    }

    function fecharConexao()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    function __toString()
    {
        return "<br>Servidor: " . $this->servername
            . "<br>Usuário: " . $this->username
            . "<br>Senha: " . $this->password
            . "<br>Banco de dados: " . $this->dbname . "<br>";
    }
}

?>