<?php
// Inicia a sessão
session_start();

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Encerra a sessão
session_destroy();

// Redireciona para a página de login ou outra página
header("Location: ../index.php");
exit; // Certifique-se de sair após redirecionar
?>
