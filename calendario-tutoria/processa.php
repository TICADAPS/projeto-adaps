<?php

session_start();
$user = $_SESSION['idMed'];
$cpfUser = $_SESSION['cpf'];

include_once("conexao.php");

if (!empty($_POST['estrela'])) {
    $estrela = $_POST['estrela'];

    //Salvar no banco de dados
    $result_avaliacos = "INSERT INTO avaliacos (qnt_estrela, created, cod_usuario, cpfUser) "
            . "VALUES ('$estrela', NOW(),$user, '$cpfUser')";
    $resultado_avaliacos = mysqli_query($conn, $result_avaliacos);

    if (mysqli_insert_id($conn)) {
        $_SESSION['msg'] = "<b style='color:green;'>Avaliação cadastrada com sucesso</b>";
        session_unset();
        session_destroy();
        header("Location: login.php");
    } else {
        $_SESSION['msg'] = "<b style='color:red;'>Erro ao cadastrar a avaliação</b>";
        header("Location: satisfacao.php");
    }
} else {
    $_SESSION['msg'] = "<b style='color:red;'>Necessário selecionar pelo menos 1 estrela</b>";
    header("Location: satisfacao.php");
}