<?php

session_start();
$sessionStatus = session_status();

if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if($sessionStatus == PHP_SESSION_ACTIVE && $_SESSION['login']){    
    header("Location: public/index2.php?Login=1");
}

if(isset($_GET['isLogin'])){
    echo "<script>alert('Usuário ou senha incorretos.')</script>";
}

/*
1 - guibor
2 - udLog
*/

$empresa = 1;
function empresa($empresa){
    switch($empresa){
        case 1:
            echo "public/img/guiborLog.png";
            break;
        case 2:
            echo "public/img/udLog.png";
            break;
        default:
            echo "Parametrize os dados da empresa.";
    }
}
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<hr>
<div class="container-fluid">  
  <div class="row justify-content-center">
    <div class="col-md-4">      
      <img src="<?php empresa($empresa)?>" class="img-fluid" alt="logotipo">
      <div class="card mt-5">        
        <div class="card-header text-center">
          <h3>eCheckin</h3>
        </div>
        <div class="card-body">
          <form form action="controllers/login.php" method="POST">
            <div class="form-group">
              <label for="login">Nome de usuário:</label>
              <input type="text" class="form-control" id="email" name="login" placeholder="Nome de usuário" required autocomplete="off">
            </div>
            <div class="form-group">
              <label for="senha">Senha:</label>
              <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn <?php echo ($empresa == 1) ? "btn-danger" : "btn-primary"?> btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<hr>

<blockquote class="blockquote text-center">
  <footer class="blockquote-footer">Prodev<cite title="Título da fonte"> Desenvolvimento de sistemas</cite></footer>
</blockquote>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
