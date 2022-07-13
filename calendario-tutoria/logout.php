<?php

session_start();
unset($_SESSION['nomeGestor'], 
        $_SESSION['cpf'],
        $_SESSION['funcao'],
        $_SESSION['id'],
        $_SESSION['codMun'],
        $_SESSION['cpfAdmin']);
header('Location: login.php');


