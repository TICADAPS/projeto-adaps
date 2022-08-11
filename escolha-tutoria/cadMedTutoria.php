<?php
session_start();
require_once ("Class/CrudEscolha.php");

$idMedico = filter_input(INPUT_GET,"idMed",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$codMunc = filter_input(INPUT_GET,"codMun",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idTutor = filter_input(INPUT_GET,"idTutor",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//var_dump($idMedico,$codMunc,$idTutor);

if (!empty($idTutor) || !empty($codMunc) || !empty($idMedico)){
    $crud = new CrudEscolha();
    $crud->CallRemanejar($idMedico,$codMunc,$idTutor);
    $_SESSION['msg'] = "<b style='color: green'>Bolsista registrado com sucesso!</b>";
    header("Location: AdminRelatorio.php");
}else{
    $_SESSION['msg'] = "<b style='color: red'>Erro ao registrar o bolsista!</b>";
}