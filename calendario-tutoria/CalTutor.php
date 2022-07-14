<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Calendário Tutoria");
require __DIR__ . "/../source/autoload.php";

$idTutor = $_SESSION['idMed'];
//var_dump($idTutor);
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
            <div class="container-fluid">
                <?php
                $modelMedico = new \Source\Models\Medico();
                $modelControle = new \Source\Models\ControlCalendario();

                $user = $modelMedico->find("idMedico=:id", "id=$idTutor");

                $controle = $modelControle->joins($idTutor);
                //var_dump($controle);
                function Mask($mask,$str){
                    $str = str_replace("55","",$str);
                    for($i=0;$i<strlen($str);$i++){
                        $mask[strpos($mask,"#")] = $str[$i];
                    }
                    return $mask;
                    
                }
                ?>
                <h1 class="pb-5">Médico Tutor <?= $user->NomeMedico; ?></h1>

                <table class="table table-primary table-hover table-striped table-responsive-sm">
                    <thead class="thead-dark">
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Período Inicial</th>
                    <th>Período Fim</th>
                    <th>Realizou tutoria</th>
                    <th>Justificativa</th>
                    <th>Ação</th>
                    </thead>
                    <tbody>                            
                        <?php foreach ($controle as $calData): ?>    
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" autocomplete="off" novalidate>
                            <tr>
                            <input type="hidden" name="idControle" value="<?= $calData->idControle ?>">
                            
                            <td class="font-weight-bold"><?= $calData->NomeMedico ?></td>
                            <td class="font-weight-bold"><?= $calData->email ?></td>
                            <td class="font-weight-bold"><?php $fone = $calData->fone_zap; 
                                    $fone = str_replace("+", "", $fone);
                                    $fone = str_replace(" ", "", $fone);
                                    $fone = str_replace("(", "", $fone);
                                    $fone = str_replace(")", "", $fone);
                                    echo Mask("(##)#####-####",$fone);
                                    ?>
                            </td>
                            <td class="font-weight-bold"><?= $calData->PeriodoInicial ?></td>
                            <td class="font-weight-bold"><?= $calData->PeriodoFinal ?></td>
                            <?php if($calData->FlagRealizouTutoria == "" || $calData->JustificativaTutoria == ""): ?>
                            <td>
                                <div class="form-check font-weight-bold">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="sim" name="opcRadio">Sim
                                    </label>
                                </div>
                                <div class="form-check font-weight-bold">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="não" name="opcRadio">Não
                                    </label>
                                </div>
                            </td>                            
                            <td>
                                <div class="form-group">                                            
                                    <textarea class="form-control" rows="5" name="comment"></textarea>
                                </div>
                            </td>
                            <?php else: ?>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled value="<?= $calData->FlagRealizouTutoria ?>" name="opcRadio">Sim
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled value="<?= $calData->FlagRealizouTutoria ?>" name="opcRadio">Não
                                    </label>
                                </div>
                            </td>                            
                            <td>
                                <div class="form-group">                                            
                                    <textarea class="form-control" rows="5" disabled name="comment"><?= $calData->JustificativaTutoria ?></textarea>
                                </div>
                            </td>
                            
                            <?php endif;?>
                            <td><input type="submit" class="btn btn-primary" name="enviar"></td>
                            </tr>
                        </form>
                        <?php
                            endforeach;
                            $idControle = 0;
                            $opcao = $mensagem = "";
                            if(isset($_POST['enviar'])){
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $idControle = filter_input(INPUT_POST, 'idControle', FILTER_SANITIZE_SPECIAL_CHARS);
                                $opcao = filter_input(INPUT_POST, 'opcRadio', FILTER_SANITIZE_SPECIAL_CHARS);
                                $mensagem = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
                                var_dump($idControle);
                                $idControle = (int)$idControle;
                                 var_dump(gettype($idControle));                               
                            
                            
                            $controleCalend = (new \Source\Models\ControlCalendario())->findById($idControle);
                            $controleCalend->FlagRealizouTutoria = $opcao;
                            $controleCalend->JustificativaTutoria = $mensagem;
                            //var_dump($controleCalend);
//                           
                            $controleCalend->Atualizar($idControle);

                            var_dump($controleCalend);
                            }
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

   </body>
</html>
