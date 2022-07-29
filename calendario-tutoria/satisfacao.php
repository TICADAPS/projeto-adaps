<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Adaps Brasil</title>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="../css/estilo.css">
        <link rel="shortcut icon" href="../img/iconAdaps.png"/>
    </head>
    <body>

        <div class="container">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-3">
                        <img src="../img/adaps.gif" class="img-fluid"  alt=""/>
                    </div>
                    <div class="col-md-9 col-12 col-lg-6">
                        <?php
                        echo "<b class='text-success'>Seja bem vindo " . $_SESSION['nome'] . "</b><br><br>";
                        ?>
                        <h3 class="text-center">Sua avaliação é importante para nós!</h3>                       

                    </div>
                </div>
            </div>   
            <h1 class="text-center">Avalie nosso serviço</h1>

            <div class="row">
                <div class="col-md-3 col-1"></div>
                <div class="col-md-6 col-10">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'] . "<br><br>";
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="processa.php" enctype="multipart/form-data">
                        <div class="estrelas">
                            <input type="radio" id="vazio" name="estrela" value="" checked>

                            <label for="estrela_um"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_um" name="estrela" value="1">
                            <label for="estrela_dois"><i class="fa" style="font-size:48px;" ></i></label>
                            <input type="radio" id="estrela_dois" name="estrela" value="2">
                            <label for="estrela_tres"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_tres" name="estrela" value="3">
                            <label for="estrela_quatro"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_quatro" name="estrela" value="4">
                            <label for="estrela_cinco"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_cinco" name="estrela" value="5">
                            <label for="estrela_seis"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_seis" name="estrela" value="6">
                            <label for="estrela_sete"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_sete" name="estrela" value="7">
                            <label for="estrela_oito"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_oito" name="estrela" value="8">
                            <label for="estrela_nove"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_nove" name="estrela" value="9">
                            <label for="estrela_dez"><i class="fa" style="font-size:48px;"></i></label>
                            <input type="radio" id="estrela_dez" name="estrela" value="10"><br><br>

                            <input type="submit" class="btn btn-primary btn-block" value="Enviar">

                        </div>
                    </form>
                </div>
                <div class="col-md-3 col-1"></div>
            </div>

        </div>

    </body>
</html>