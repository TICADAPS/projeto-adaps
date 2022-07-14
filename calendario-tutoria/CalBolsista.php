<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Calendário Tutoria");
require __DIR__ . "/../source/autoload.php";

$idBolsista = $_SESSION['idMed'];
//var_dump($idBolsista);
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

    </head>
    <body>
        <div class="container-fluid">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-3">
                        <img src="../img/Logo_400x200.png" class="img-fluid"  alt=""/>
                    </div>
                    <div class="col-md-9 col-12 col-lg-6">
                        <h1 class="text-center">Calendário de tutoria dos Médicos bolsistas</h1>
                        <p><h3 class="text-center"></h3></p>
                        <?php
                        echo "<p class='text-center'>Seja bem-vindo <b>" . $_SESSION['nome'] . "</b></p>";
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="form-1-container section-container">
            <div class="container">
                <?php
                $modelMedico = new \Source\Models\Medico();
                $modelControle = new \Source\Models\ControlCalendario();
                $modelCntrlEmail = new \Source\Models\ControlCalendario();
                
                $user = $modelMedico->find("idMedico=:id", "id=$idBolsista");

                $controle = $modelControle->joinsBolsista($idBolsista);
                $ctrlEmail = $modelCntrlEmail->joinsEmailTutor($idBolsista);
                function Mask($mask,$str){
                    $str = str_replace("55","",$str);
                    for($i=0;$i<strlen($str);$i++){
                        $mask[strpos($mask,"#")] = $str[$i];
                    }
                    return $mask;}
                ?>
                <h1 class="pb-5 border border-primary text-center">Médico Bolsista <?= $user->NomeMedico; ?></h1>
                <table class="border border-primary table table-primary table-hover table-striped table-responsive-sm">
                    <thead class="thead-dark border border-primary">                    
                    <th>E-mail do Tutor</th>
                    <th>Telefone do Tutor</th>
                    <th>Período Inicial</th>
                    <th>Período Fim</th>
                    </thead
                    <tbody>
                        <tr>
                        <?php foreach ($controle as $value): ?>                            
                            <?php foreach ($ctrlEmail as $mail): ?>
                                <td class="font-weight-bold"><?= $mail->email; ?></td>
                                <td class="font-weight-bold"><?php $fone = $mail->fone_zap;
                                    $fone = str_replace("+", "", $fone);
                                    $fone = str_replace(" ", "", $fone);
                                    $fone = str_replace("(", "", $fone);
                                    $fone = str_replace(")", "", $fone);
                                  echo Mask("(##)#####-####",$fone);
                                ?></td>
                            <?php endforeach; ?>
                                <td class="font-weight-bold"><?= $value->PeriodoInicial; ?></td>
                                <td class="font-weight-bold"><?= $value->PeriodoFinal; ?></td>
                        <?php endforeach; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
