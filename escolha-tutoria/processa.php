<?php
session_start();
$user = $_SESSION['idMed'];
$cpfUser = $_SESSION['cpf'];
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "medicosdataapresentacao";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

if(!empty($_POST['estrela'])){
    $estrela = $_POST['estrela'];

    //Salvar no banco de dados
    $result_avaliacos = "INSERT INTO avaliacoes_medicos (idMedico, qntd_estrela, data_registro, cpfUser) "
        . "VALUES ($user,'$estrela', NOW(), '$cpfUser')";
    $resultado_avaliacos = mysqli_query($conn, $result_avaliacos);

    if(mysqli_insert_id($conn)){
        $_SESSION['msg'] = "<b style='color:green;'>Avaliação cadastrada com sucesso</b>";
        //unset($_SESSION['nomeGestor'], $_SESSION['cpf'],$_SESSION['funcao'],$_SESSION['id'],$_SESSION['codMun']);
        header("Location: index.php");
    }else{
        $_SESSION['msg'] = "<b style='color:red;'>Erro ao cadastrar a avaliação</b>";
        header("Location: index.php");
    }

}else{
    $_SESSION['msgErr'] = "<b style='color:red;'>Necessário selecionar pelo menos 1 estrela</b>";
    header("Location: index.php");
}