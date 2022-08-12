<?php
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Escolha Tutoria");
require __DIR__ . "/../source/autoload.php";

# instanciando tutor
$modelTutor = new Source\Models\TutorMunicipio();
$tutorMuncipio = $modelTutor->selectTutorUf();

$idMedico = filter_input(INPUT_GET,"id",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="css/estilo.css">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
        </div>
        <div class="col-md-8 col-sm-6 mt-5 ">
            <h1><b>Área de relatório dos médicos bolsistas</b></h1>
        </div>
    </div>
    <form action="" method="post">
        <table class="table table-bordered">
            <thead>
                <tr class="table-primary font-weight-bold">
                    <td>Selecionar</td>
                    <td>Nome Tutor</td>
                    <td>UF</td>
                    <td>Município</td>
                    <td>Vaga</td>
                </tr>
            </thead>
            <?php foreach($tutorMuncipio as $value):   ?>
            <tbody>
                <tr>
                    <td><a href="cadMedTutoria.php?codMun=<?php echo $value->cod_munc;?>&idMed=<?php echo $idMedico ?>">
                            <img src="img/plus.png" width="32" alt="add">
                        </a>
                    </td>
                    <td><?php echo $value->NomeMedico; ?></td>
                    <td><?php echo $value->UF; ?></td>
                    <td><?php echo $value->municipio; ?></td>
                    <td><?php echo $value->vaga; ?></td>
                </tr>
            </tbody>
        <?php endforeach; ?>
        </table>
    </form>
</div>
