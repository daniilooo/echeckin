<?

include_once(__DIR__ . '/../DAO/DaoUsuario.php');
include_once(__DIR__ . '/../DAO/DaoErro.php');
include_once(__DIR__ . '/../DAO/DaoLog.php');

session_start();
$sessionStatus = session_status();

if(isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}



?>