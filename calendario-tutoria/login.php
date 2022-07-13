<?php
session_start();
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Login de acesso");
?>
<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Login de acesso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="shortcut icon" href="img/iconAdaps.png"/>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../js/script.js" type="text/javascript"></script>
</head>
<body>
<div class="container h-100 mt-5">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="../img/Logo_400x200.png" class="brand_logo img-fluid" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form action="Controller/valida.php" method="post">
                    <div class="input-group mb-3">
                        <div class="input-group-append bg-primary">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="userCpf" class="form-control input_user" id="txtCpf" value="" placeholder="Informe seu CPF">
                    </div>
                    <div class="input-group mb-2">
                        <p class="text-light"><i>Entre com seu CPF para ter acesso ao calendário de tutoria</i></p>
                    </div>

                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="logar" class="btn login_btn">Login</button>
                    </div>

                    <div class="d-flex justify-content-center mt-3 login_container">
                        <div class="text-center text-light">
                            <?php
                            if (isset($_SESSION['loginErro'])):
                                echo $_SESSION['loginErro'];
                                unset($_SESSION['loginErro']);
                            endif;
                            if(isset($_SESSION['loginBranco'])):
                                echo $_SESSION['loginBranco'];
                                unset($_SESSION['loginBranco']);
                            endif;
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script src="../js/mask.js" type="text/javascript"></script>
<script>
    $('#txtCpf').mask('000.000.000-00'); //CPF
    
</script>
</body>
</html>
