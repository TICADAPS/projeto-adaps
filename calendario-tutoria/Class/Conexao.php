<?php

abstract class Conexao
{
    #Realizará a conexão com o banco de dados
    protected function conectaDB() {
        try {
            $Con = new PDO("mysql:host=localhost;dbname=medicosdataapresentacao", "root", "");
            return $Con;
        } catch (PDOException $Erro) {
            return $Erro->getMessage();
        }
    }
}