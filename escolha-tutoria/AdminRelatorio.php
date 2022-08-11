<?php
session_start();
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Escolha Tutoria");
require __DIR__ . "/../source/autoload.php";

# instanciando tutor
$modelTutor = new Source\Models\TutorMunicipio();
$tutorMuncipio = $modelTutor->selectTutor();

# instanciando bolsista
$modelVagaTutor = new Source\Models\VagaTutoria();

# instanciando bolsista sem tutoria
$modelRemanejar = new Source\Models\MedicoBolsista();
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
                    <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
                </div>
                <div class="col-md-8 col-sm-6 mt-5 ">
                    <h3><b>Área de relatório dos médicos bolsistas</b></h3>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo "<h2>" . $_SESSION['msg'] . "</h2>";
                        unset($_SESSION['msg']);
                    }
                    ?>
                </div>
            </div>
            <div class="container-fluid" id="container-central">
                <a href="../vendor/relatorio.php" class="btn btn-warning btn-lg m-2" target="_blank">Rel. Pedido de tutoria (PDF)</a>
                <a href="../vendor/relatorioPlanilha.php" class="btn btn-success btn-lg m-2" target="_blank">Rel. Pedido de tutoria (Planilha)</a>
                <a href="../vendor/relMedicoSemTutor.php" class="btn btn-warning btn-lg m-2" target="_blank">Rel. de Bolsista sem tutor (PDF)</a>
                <a href="../vendor/relMedicoSemTutorPlanilha.php" class="btn btn-success btn-lg m-2" target="_blank">Rel. de Bolsista sem tutor (Planilha)</a>
                <a href="../vendor/relMedicoComTutor.php" class="btn btn-warning btn-lg m-2" target="_blank">Rel. de Bolsista com tutor (PDF)</a>
                <a href="../vendor/relMedicoComTutorPlanilha.php" class="btn btn-success btn-lg m-2" target="_blank">Rel. de Bolsista com tutor (Planilha)</a>
                <a href="../vendor/relVagaRemanecente.php" class="btn btn-warning btn-lg m-2" target="_blank">Rel. de Vaga remanescente (PDF)</a>
                <a href="../vendor/relVagaRemanecentePlanilha.php" class="btn btn-success btn-lg m-2" target="_blank">Rel. de Vaga remanescente (Planilha)</a>
                <div class="row py-3">
                    <div class="form-group col-md-6">
                        <h4>Tutores</h4>
                        <form action="" method="post">
                            <select name="tutores" id="tutores" class="form-control form-control-lg" onchange="RelTutores()">
                                <!--                            <option value="" selected disabled>Escolha um tutor...</option>                            -->
                                <?php foreach ($tutorMuncipio as $value): ?>
                                    <option value="<?= $value->idTutor; ?>"><?= $value->NomeMedico; ?></option>
                                <?php endforeach; ?>
                            </select> 
                            <input type="submit" value="pesquisar">
                        </form>
                    </div>
                    <div class="form-group col-md-6 bolsistas">
                        <h4>Bolsistas vinculados</h4>
                        <?php if (!empty($_POST['tutores'])): ?>                        
                            <ol>
                                <?php
                                $idTutor = "";
                                if (isset($_POST['tutores'])) {
                                    $idTutor = $_POST['tutores'];
                                    $bolsista = $modelVagaTutor->bolsistas($idTutor);
                                }
                                foreach ($bolsista as $value):
                                    ?>  
                                    <li><?= $value->nome_medico; ?></li>
                                <?php endforeach; ?>
                            </ol>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">

                </div>
                <a href="bolsistasComTutoria.php" class="btn btn-primary btn-lg my-5 py-3" >Remanejar Bolsista para outro tutor</a>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        fullStackPHPClassSession("<h4>Remanejar bolsistas sem tutoria ou não informou</h4>", __LINE__);
                        ?>

                        <table class="table table-bordered">
                            <thead class="text-success">
                                <tr class="bg-primary text-light">
                                    <td>Nome</td>
                                    <td>Estado</td>
                                    <td>Município</td>
                                    <td>Remanejar</td>
                                </tr>
                            </thead>
                            <!-- estrutura do loop -->
                            <?php
                            $remanejar = $modelRemanejar->remanejar();
                            foreach ($remanejar as $value):
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $value->nome_medico; ?></td>
                                        <td><?php echo $value->UF; ?></td>
                                        <td><?php echo $value->Municipio; ?></td>
                                        <td>
                                            <a href="<?php echo "remanejar.php?id={$value->idMedico}"; ?>">
                                                <img src="img/plus.png" width="32" alt="add">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php
                            endforeach;
                            ?>
                        </table>
                    </div>            
                </div>

            </div>
        </div>  
        <script>
            document.getElementById("tutores").onchange = function () {
                var campo_select = document.getElementById("tutores");
                var indice_selecionado = campo_select.options.selectedIndex;
                var valor_selecionado = campo_select.options[indice_selecionado].value;
                console.log(valor_selecionado);
                //document.getElementById("escolaridade_selecionada").innerHTML = valor_selecionado;
            }
        </script>
    </body>
</html>

