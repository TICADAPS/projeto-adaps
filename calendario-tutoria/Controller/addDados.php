<?php

require __DIR__ . '/../../fullstackphp/fsphp.php';
fullStackPHPClassName("Área do Administrador");
require __DIR__ . "/../../source/autoload.php";

$idCalendario = filter_input(INPUT_POST, 'periodo', FILTER_SANITIZE_NUMBER_INT);
$idMedico = filter_input(INPUT_POST, 'idMedico', FILTER_SANITIZE_NUMBER_INT);
$edicao = 1;

$ControleCalendario = new \Source\Models\ControlCalendario();
$ControleCalendario->bootstrap($edicao, $idCalendario, $idMedico);
$ControleCalendario->Cadastrar();
//var_dump($ControleCalendario);
echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0; URL='../Admin.php'\">";


