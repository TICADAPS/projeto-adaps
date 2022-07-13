<?php

require_once "Conexao.php";

class Crud extends Conexao
{
    private $userCpf;
    private $crud;
    private $contador;

    #Preparação das declarativas

    private function preparedStatements($Query, $Parametros) {
        $this->countParametros($Parametros);
        $this->Crud = $this->conectaDB()->prepare($Query);
        if ($this->Contador > 0) {
            for ($i = 1; $i <= $this->Contador; $i++) {
                $this->Crud->bindValue($i, $Parametros[$i - 1]);
            }
        }
        $this->Crud->execute();
    }

    #Contador de parâmetros

    private function countParametros($Parametros) {
        $this->Contador = count($Parametros);
    }

    #Inserção no Banco de Dados

    public function insertDB($Tabela, $Condicao, $Parametros) {
        $this->preparedStatements("INSERT INTO {$Tabela} VALUES ({$Condicao})", $Parametros);
        return $this->Crud;
    }

    #Chama procedimentos armazenados
    public  function  CallProcedure($id,$opc1,$opc2,$opc3){
        define('SERVER','localhost');
        define('DBNAME','medicosdataapresentacao');
        define('USER','root');
        define('PASSWORD','');
        try {
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            $conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME,USER,PASSWORD,$opcoes);

            $sql = "CALL sp_EscolheTutor (:id,:opc1,:opc2,:opc3)";

            $stm = $conexao->prepare($sql);
            //$stm->bindValue(1,$nome);
            $stm->bindValue(':id',$id);
            $stm->bindValue(':opc1',$opc1);
            $stm->bindValue(':opc2',$opc2);
            $stm->bindValue(':opc3',$opc3);
            $stm->execute();

        }catch (PDOException $erro){
            echo 'Mensagem de erro: '.$erro->getMessage()."<br>";
            echo 'Nome do arquivo: '.$erro->getFile()."<br>";
            echo 'Linha: '.$erro->getLine()."<br>";
        }

    }
    public  function  CallRemanejar($id,$opc){
        define('SERVER','localhost');
        define('DBNAME','medicosdataapresentacao');
        define('USER','root');
        define('PASSWORD','');
        try {
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            $conexao = new PDO("mysql:host=".SERVER."; dbname=".DBNAME,USER,PASSWORD,$opcoes);

            $sql = "CALL sp_RemanejaBolsista (:id,:opc)";

            $stm = $conexao->prepare($sql);
            //$stm->bindValue(1,$nome);
            $stm->bindValue(':id',$id);
            $stm->bindValue(':opc',$opc);

            $stm->execute();

        }catch (PDOException $erro){
            echo 'Mensagem de erro: '.$erro->getMessage()."<br>";
            echo 'Nome do arquivo: '.$erro->getFile()."<br>";
            echo 'Linha: '.$erro->getLine()."<br>";
        }

    }
    #Seleção no Banco de Dados

    public function selectDB($Campos, $Tabela, $Condicao, $Parametros) {
        $this->preparedStatements("select {$Campos} from {$Tabela} {$Condicao}", $Parametros);
        return $this->Crud;
    }

    #Deletar dados no DB

    public function deleteDB($Tabela, $Condicao, $Parametros) {
        $this->preparedStatements("delete from {$Tabela} where {$Condicao}", $Parametros);
        return $this->Crud;
    }

    #Atualização no banco de dados

    public function updateDB($Tabela, $Set, $Condicao, $Parametros) {
        $this->preparedStatements("update {$Tabela} set {$Set} where {$Condicao}", $Parametros);
        return $this->Crud;
    }

    #validar usuário

    public function validaUser($user) {
        if ($user == "050.574.797-92") {
            $_SESSION['cpfAdmin'] = "050.574.797-92";
            header("Location:../AreaAdmin.php");
        } else {
            $this->userCpf = $user;
            $sql = "SELECT * FROM medico WHERE CpfMedico = :userCpf LIMIT 1";
            $this->Crud = $this->conectaDB()->prepare($sql);
            $this->Crud->bindValue(":userCpf", $this->userCpf);
            $this->Crud->execute();
        }
        if ($this->Crud->rowCount() == 1) {
            while ($ln = $this->Crud->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['nome'] = $ln['NomeMedico'];
                $_SESSION['cpf'] = $ln['CpfMedico'];
                $_SESSION['uf'] = $ln['Estado_idEstado'];
                $_SESSION['idMed'] = $ln['idMedico'];
                $_SESSION['idCargo'] = $ln['idCargo'];
                if ($_SESSION['idCargo'] == 1) {
                    header("Location:../CalBolsista.php");
                }else{
                    header("Location:../CalTutor.php");
                }
                
            }
        } else {
            $_SESSION['loginErro'] = "<b>CPF inválido ou não cadastrado</b>";
            header("Location:../login.php");
        }
    }
}