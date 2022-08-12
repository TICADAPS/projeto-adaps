<?php
session_start();
require_once ("Class/CrudEscolha.php");

$idMedico = filter_input(INPUT_GET,"idMedico",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$codMunc = filter_input(INPUT_GET,"codMun",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idTutor = filter_input(INPUT_GET,"idTutor",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if (!empty($codMunc) || !empty($idMedico || !empty($idTutor))){
    //var_dump([$codMunc,$idMedico,$idTutor]);
    $crud = new CrudEscolha();
    $crud->CallRemanejar($idMedico,$codMunc,$idTutor);
    
    $_SESSION['msg'] = "<b style='color: green'>Bolsista registrado com sucesso!</b>";
    header("Location: bolsistasComTutoria.php");
}else{
    $_SESSION['msg'] = "<b style='color: red'>Erro ao registrar o bolsista!</b>";
}