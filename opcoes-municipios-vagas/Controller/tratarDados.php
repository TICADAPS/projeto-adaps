<?php
require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("Área do Administrador");
require __DIR__ . "/../../source/autoload.php";

$opcaoPeriodo = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_NUMBER_INT);
$idMed = filter_input(INPUT_POST, 'idMedico',FILTER_SANITIZE_NUMBER_INT);
$idCal = filter_input(INPUT_POST, 'idCalendario', FILTER_SANITIZE_NUMBER_INT);

//var_dump([$opcaoPeriodo, $idMed, $idCal]);

$model = new \Source\Models\ControlCalendario();
$Controle = $model->find("idMedico=:id", "id=$idMed");
$idControle = ($Controle->idControle);

$controleCalend = (new \Source\Models\ControlCalendario())->findById($idControle);
$controleCalend->idCalendario = $opcaoPeriodo;

$controleCalend->Atualizar($idControle);

echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL='../Admin.php'\">";


