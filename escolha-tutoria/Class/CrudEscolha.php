<?php

require_once "Conexao.php";

class CrudEscolha extends Conexao {

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

    public function CallProcedure($id, $opc1, $opc2, $opc3) {
        define('SERVER', 'localhost');
        define('DBNAME', 'medicosdataapresentacao');
        define('USER', 'root');
        define('PASSWORD', '');
        try {
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            $conexao = new PDO("mysql:host=" . SERVER . "; dbname=" . DBNAME, USER, PASSWORD, $opcoes);

            $sql = "CALL sp_EscolheTutor(:id,:opc1,:opc2,:opc3)";

            $stm = $conexao->prepare($sql);
            //$stm->bindValue(1,$nome);
            $stm->bindValue(':id', $id);
            $stm->bindValue(':opc1', $opc1);
            $stm->bindValue(':opc2', $opc2);
            $stm->bindValue(':opc3', $opc3);
            $stm->execute();

            $sql1 = "select idVaga, opcao_escolhida, munic_origem, uf_origem, munic_escolhido, uf_escolhida from vaga_tutoria where idMedico = :id limit 1";
            $stm1 = $conexao->prepare($sql1);
            $stm1->bindValue(':id', $id);
            if ($stm1->execute()) {
                while ($row = $stm1->fetch(PDO::FETCH_ASSOC)) {
                    $crud = new CrudEscolha();
                    $idVaga = $row['idVaga'];
                    $opEscolhida = "" . $row['opcao_escolhida'];
                    $munic_origem = $row['munic_origem'];
                    $uf_origem = $row['uf_origem'];
                    $munic_escolhido = $row['munic_escolhido'];
                    $uf_escolhida = $row['uf_escolhida'];

                    $origem = "$munic_origem $uf_origem";
                    $destino = "$munic_escolhido $uf_escolhida";
                    $distancia = 0.00;
                    if (strlen($opEscolhida) < 7) {
                        var_dump($origem, $destino);
                        $distancia = $crud->kilometragem($origem, $destino);
                        if (strpos($distancia, "k")) {
                            $distancia = str_replace(" ", "", $distancia);
                            $distancia = str_replace("k", "", $distancia);
                            $distancia = str_replace("m", "", $distancia);
                            $distancia = str_replace(".", "", $distancia);
                            $distancia = str_replace(",", ".", $distancia);
                        } else {
                            $distancia = 0.00;
                        }
                    }

                    $sql2 = "update vaga_tutoria set distancia = :distancia where idVaga = :idVaga";
                    $stm2 = $conexao->prepare($sql2);
                    $stm2->bindValue(':distancia', $distancia);
                    $stm2->bindValue(':idVaga', $idVaga);
                    $stm2->execute();
                }
            } else {
                echo "<script>alert('Não existe em vaga_tutoria')</script>";
            }
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
        }
    }

    public function CallRemanejar($id, $opc, $tutor) {
        define('SERVER', 'localhost');
        define('DBNAME', 'medicosdataapresentacao');
        define('USER', 'root');
        define('PASSWORD', '');
        try {
            $opcoes = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
            $conexao = new PDO("mysql:host=" . SERVER . "; dbname=" . DBNAME, USER, PASSWORD, $opcoes);

            $sql = "CALL sp_RemanejaBolsista (:id,:opc,:tutor)";

            $stm = $conexao->prepare($sql);
            //$stm->bindValue(1,$nome);
            $stm->bindValue(':id', $id);
            $stm->bindValue(':opc', $opc);
            $stm->bindValue(':tutor', $tutor);

            $stm->execute();

            $sql1 = "select idVaga, opcao_escolhida, munic_origem, uf_origem, munic_escolhido, uf_escolhida from vaga_tutoria where idMedico = :id limit 1";
            $stm1 = $conexao->prepare($sql1);
            $stm1->bindValue(':id', $id);
            if ($stm1->execute()) {
                while ($row = $stm1->fetch(PDO::FETCH_ASSOC)) {
                    $crud = new CrudEscolha();
                    $idVaga = $row['idVaga'];
                    $opEscolhida = "" . $row['opcao_escolhida'];
                    $munic_origem = $row['munic_origem'];
                    $uf_origem = $row['uf_origem'];
                    $munic_escolhido = $row['munic_escolhido'];
                    $uf_escolhida = $row['uf_escolhida'];

                    $origem = "$munic_origem $uf_origem";
                    $destino = "$munic_escolhido $uf_escolhida";
                    $distancia = 0.00;
                    if (strlen($opEscolhida) < 7) {
                        $distancia = $crud->kilometragem($origem, $destino);
                        if (strpos($distancia, "k")) {
                            $distancia = str_replace(" ", "", $distancia);
                            $distancia = str_replace("k", "", $distancia);
                            $distancia = str_replace("m", "", $distancia);
                            $distancia = str_replace(".", "", $distancia);
                            $distancia = str_replace(",", ".", $distancia);
                        } else {
                            $distancia = 0.00;
                        }
                    }

                    $sql2 = "update vaga_tutoria set distancia = :distancia where idVaga = :idVaga";
                    $stm2 = $conexao->prepare($sql2);
                    $stm2->bindValue(':distancia', $distancia);
                    $stm2->bindValue(':idVaga', $idVaga);
                    $stm2->execute();
                }
            } else {
                echo "<script>alert('Não existe em vaga_tutoria')</script>";
            }
        } catch (PDOException $erro) {
            echo 'Mensagem de erro: ' . $erro->getMessage() . "<br>";
            echo 'Nome do arquivo: ' . $erro->getFile() . "<br>";
            echo 'Linha: ' . $erro->getLine() . "<br>";
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
        if ($user == "011.792.350-88") {
            $_SESSION['cpfAdmin'] = "011.792.350-88";
            $_SESSION['nome'] = "Lucas Wollmann";
            header("Location:../AdminRelatorio.php");
        } else if ($user == "512.525.031-72" || $user == "022.623.089-93") {
            $_SESSION['cpfAdmin'] = $user;
            header("Location:../cadValorCombustivel.php");
            exit();
        } else {
            $this->userCpf = $user;
            $sql = "SELECT * FROM medico_bolsista WHERE cpf_medico = :userCpf LIMIT 1";
            $this->Crud = $this->conectaDB()->prepare($sql);
            $this->Crud->bindValue(":userCpf", $this->userCpf);
            $this->Crud->execute();
        }
        if ($this->Crud->rowCount() == 1) {
            while ($ln = $this->Crud->fetch(PDO::FETCH_ASSOC)) {
                $_SESSION['nome'] = $ln['nome_medico'];
                $_SESSION['cpf'] = $ln['cpf_medico'];
                $_SESSION['uf'] = $ln['cod_uf'];
                $_SESSION['id'] = $ln['idMedico'];

                header("Location:../index.php");
            }
        } else {
            $_SESSION['loginErro'] = "<b>CPF inválido ou não cadastrado</b>";
            header("Location:../login.php");
        }
    }

    public function kilometragem($o, $d) {

        try {
            $origem = str_replace(" ", "%20", $o);
            $destino = str_replace(" ", "%20", $d);
            $link = "https://maps.googleapis.com/maps/api/distancematrix/xml?origins=$origem&destinations=$destino&mode=driving&language=pt-BR&sensor=false&key=AIzaSyAK_RhiP5TiLfA3qK4mBCMGby2yjS_a4is";
            $novolink = curl_init();
            curl_setopt($novolink, CURLOPT_URL, "$link");
            curl_setopt($novolink, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($novolink, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($novolink, CURLOPT_MAXCONNECTS, 10);
            curl_setopt($novolink, CURLOPT_TIMEOUT, 5);
            $output = curl_exec($novolink);

            curl_close($novolink);

            $output = str_replace("\n", " ", $output);

            preg_match_all("/<origin_address>(.*?)<\/origin_address>/", $output, $a); //origem

            preg_match_all("/<destination_address>(.*?)<\/destination_address>/", $output, $b); //destino

            $verifica = preg_match_all("/<duration>(.*?)<\/duration>/", $output, $c0);
            if ($verifica == 0) {
                $distanc = 0;
            } else {
                preg_match_all("/<text>(.*?)<\/text>/", $c0[1][0], $c);  //duracao
                preg_match_all("/<distance>(.*?)<\/distance>/", $output, $d0);
                preg_match_all("/<text>(.*?)<\/text>/", $d0[1][0], $d);  //distancia
                $orig = $a[1][0];
                $destn = $b[1][0];
                $distanc = $d[1][0];
                $duracion = $c[1][0];
            }

            var_dump($verifica);
        } catch (Exception $ex) {
            $distanc = 0;
        }

        return $distanc;
    }

}
