<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Área do médico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="shortcut icon" href="img/iconAdaps.png"/>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <style>
        #container-central{
            background: #F8F9FA;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <img src="../img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
        </div>
        <div class="col-md-8 col-sm-6 mt-5 ">
            <?php echo "SEJA BEM-VINDO(A) DR(A) <b>{$_SESSION['nome']}</b>"; ?>
        </div>
    </div>
    <div class="container p-3 my-3 bg-primary text-white">
        <img src="img/alert.png" width="128" alt="">
        <h1>Página em Manutenção!</h1>
        <p>Aguarde alguns instantes...</p>
         
    </div>

</body>
</html>
