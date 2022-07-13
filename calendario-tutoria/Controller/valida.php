<?php
session_start();
include '../Class/Crud.php';
$crud = new Crud();

if((isset($_POST['userCpf']))){
    $cpf = filter_input(INPUT_POST, 'userCpf', FILTER_SANITIZE_SPECIAL_CHARS);
    if (strlen($cpf) == 14) {
        $crud->validaUser($cpf);        
    }else if($cpf == ""){
        $_SESSION['loginBranco'] = "<b>Impossível logar sem informar um CPF Válido!</b>";
        header("Location: ../login.php");
    }else{
        $_SESSION['loginErro'] = "<b>CPF Inválido!</b>";
        header("Location: ../login.php");
    }
}


