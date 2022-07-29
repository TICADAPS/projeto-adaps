<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpfAdmin'])) {
    header("Location: login.php");
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Área do Administrador");
//require __DIR__ . "/../source/autoload.php";
require __DIR__ . "/../vendor/autoload.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-3">
                        <img src="../img/Logo_400x200.png" class="img-fluid"  alt=""/>
                    </div>
                    <div class="col-md-9 col-12 col-lg-6">
                        <h1 class="text-center">Área do administrador</h1>
                        <p><h3 class="text-center">Alteração de data do calendário Tutoria</h3></p>
                    </div>
                </div>
            </div>
            <p>
                <a href="logout.php" class="btn btn-outline-danger">Sair</a>
                <!--<a href="cadValorCombustivel.php" class="btn btn-outline-success">Calcular valor de deslocamento</a>-->
            </p>
        </div>
        <?php
        $modelControle = new \Source\Models\ControlCalendario();
        $controle = $modelControle->joinsCalendarioTutoria();
        ?>
        <div class="container">
            <table class="border border-primary table table-hover table-striped table-responsive-sm">
                <thead class="thead-dark border border-primary">                    
                <th>Nome médico</th>
                <th>Período Inicial</th>
                <th>Período Final</th>
                <th>Alterar</th>            
                </thead
                <tbody>
                    <?php

                    function vemdata($qqdata) {
                        $tempdata = substr($qqdata, 8, 2) . '/' .
                                substr($qqdata, 5, 2) . '/' .
                                substr($qqdata, 0, 4);
                        return($tempdata);
                    }
                    ?>

<?php foreach ($controle as $value): ?> 
                        <tr>
                            <td class="font-weight-bold"><?= $value->nome_medico ?></td>
                            <td class="font-weight-bold"><?= vemdata($value->PeriodoInicial) ?></td>
                            <td class="font-weight-bold"><?= vemdata($value->PeriodoFinal) ?></td>
                            <td><a href="editarData.php?id=<?= $value->idMedico ?>"><i class="fas fa-edit fa-lg"></i></a></td>
                        </tr>        
<?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </body>
</html>
