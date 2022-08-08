<?php
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Calendário Tutoria");
require __DIR__ . "/../source/autoload.php";

if (isset($_GET['id'])):
    $idMedico = $_GET['id'];
endif;

$medicoModel = new \Source\Models\Medico();
$modelControle = new \Source\Models\ControlCalendario();
$modelCalendario = new \Source\Models\CalendarioTutoria();
$bolsista = $medicoModel->find("idMedico=:id", "id=$idMedico");
$todoCalendario = $modelCalendario->all();
?>
<?php

function vemdata($qqdata) {
    $tempdata = substr($qqdata, 8, 2) . '/' .
            substr($qqdata, 5, 2) . '/' .
            substr($qqdata, 0, 4);
    return($tempdata);
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="container-fluid">
    <div class="jumbotron bg-light">
        <div class="row">
            <div class="col-md-3">
                <img src="../img/Logo_400x200.png" class="img-fluid"  alt=""/>
            </div>
            <div class="col-md-9 col-12 col-lg-6">
                <h1 class="text-center">Área do administrador</h1>
                <p><h3 class="text-center">Adicionar médico bolsista ao calendário de Tutoria</h3></p>
                <p><h4 class="text-center"><?php echo "Médico " . $bolsista->NomeMedico; ?></h4></p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h2 class="text-center p-3 bg-primary text-light">Escolha um novo período</h2>
    <form action="Controller/addDados.php" method="post">
        <input type="hidden" name="idMedico" value="<?= $idMedico ?>">        
        <label class="text-center bg-dark p-3 text-light">Período Inicial e Período Final</label>
        <select name="periodo" class="form-control">
            <option>Escolha o novo período</option>        
            <?php foreach ($todoCalendario as $calInicio): ?> 
                <option value="<?= $calInicio->idCalendario ?>"><?= vemdata($calInicio->PeriodoInicial) ?> a <?= vemdata($calInicio->PeriodoFinal) ?></option>
            <?php endforeach; ?> 
        </select>     

        <input type="submit" class="btn btn-success" value="Enviar">
    </form>
</div>





