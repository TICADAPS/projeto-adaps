<?php
session_start();
require_once ("conexao.php");
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Área do Administrador");
require __DIR__ . "/../source/autoload.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Área do médico</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/estilo.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="shortcut icon" href="img/iconAdaps.png"/>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6">
                    <img src="../img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
                </div>
                <div class="col-12 col-md-8 col-sm-6 mt-5 ">
                    <h3 class="mb-4">Cadastro do Valor de Combustível e Fator Multiplicador</h3>
                    <?php
                    if (isset($_POST['salvar'])) {
                        $vlr = $_POST['vlr'];
                        $fator = $_POST['fator'];
                        if ($vlr === "" || $vlr === 0.00 || $fator === "" || $fator == 0.00) {
                            $_SESSION['msg'] = "<h3 class='bg-danger p-4 text-white rounded'>Campos com preenchimento obrigatório.</h3>";
                            return;
                        }
                        try {
                            $sql = "update combustivel set valor = '$vlr', fator = '$fator'";
                            mysqli_query($conn, $sql);
                            $_SESSION['msg'] = "<h3 class='bg-success p-4 text-white rounded'>Dados armazenados com sucesso!</h3>";
                        } catch (Exception $e) {
                            $_SESSION['msg'] = "<h3 class='bg-warning p-4 text-white rounded'>Erro: $e</h3>";
                        }
                        echo  $_SESSION['msg'];
                        echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"2;
                    URL='cadValorCombustivel.php'\">";
                        unset($_SESSION['msg']);
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 mx-auto p-5 bg-light">
                    <form method="post" action="">
                        <div class="form-group">
                            <label class="font-weight-bold">Valor do Combustível por Litro (R$):</label>
                            <input type="number" step="0.01" min="0.01" id="vlr" max="999999" name="vlr" 
                                   class="form-control form-control-lg" required="true">
                            <label class="font-weight-bold mt-2">Fator Multiplicador:</label>
                            <input type="number" id="fator" step="0.0001" min="0.0001" max="999999" name="fator" 
                                   class="form-control form-control-lg" required="true">
                            <input type="submit" class="form-control mt-2 form-control-lg btn btn-success font-weight-bold" name="salvar" value="Salvar">
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="container-fluid">
                <p><a href="Admin.php" class="btn btn-outline-primary">Voltar</a></p>
            <div class="row">
                
                <div class="col-12 mt-5 mb-2">
                    <h3>Relatório dos médicos bolsistas e seus respectivos municípios</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                    $sql = "select * from combustivel";
                    $query = mysqli_query($conn, $sql);
                    while ($row_query = mysqli_fetch_assoc($query)) {
                        $vlrCombustivel = $row_query['valor'];
                        $fator = $row_query['fator'];
                    }
                    $vlrCombustivel = $vlrCombustivel * $fator;
                    $fatorString = "" . $fator;
                    ?>
                    <table class="table table-hover table-bordered table-striped table-responsive rounded">
                        <thead>
                            <tr class="text-light bg-dark font-weight-bold">
                                <td>Bolsista</td>
                                <td>Município de Origem</td>
                                <td>Local Tutoria</td>
                                <td>Código do Município da Tutoria</td>
                                <td>Distância em Km</td>
                                <td>Valor de Deslocamento<br>(Fator Multiplicador 
                                    <?php echo str_replace('.', ',', $fatorString); ?>)</td>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- estrutura do loop -->
                        <?php
                        $sql = "select medico_bolsista.idMedico as idMedico, medico_bolsista.nome_Medico, localidade_escolhida.munic_origem, 
                        localidade_escolhida.uf_origem, localidade_escolhida.munic_escolhido, localidade_escolhida.uf_escolhida, 
                        localidade_escolhida.distancia, vaga_tutoria.opcao_escolhida from 
                        medico_bolsista INNER JOIN vaga_tutoria ON medico_bolsista.idMedico = vaga_tutoria.idMedico INNER JOIN 
                        localidade_escolhida ON localidade_escolhida.fkvagatutoria = vaga_tutoria.idVaga";
                        $smtm = mysqli_query($conn, $sql);
                        while ($row_query = mysqli_fetch_assoc($smtm)) {
                            $munic_origem = $row_query['munic_origem'];
                            $uf_origem = $row_query['uf_origem'];
                            $munic_escolhido = $row_query['munic_escolhido'];
                            $uf_escolhida = $row_query['uf_escolhida'];
                            $idMedico = $row_query['idMedico'];
                            $distancia = $row_query['distancia'];
                            $opcao_escolhida = $row_query['opcao_escolhida'];
                            $nome_Medico = $row_query['nome_Medico'];

                        ?>
                        <tr>
                            <td><?php echo $nome_Medico; ?></td>
                            <td><?php echo "$munic_origem-$uf_origem"; ?></td>
                            <td><?php echo "$munic_escolhido-$uf_escolhida"; ?></td>
                            <td><?php echo "$opcao_escolhida"; ?></td>
                            <td><?php echo str_replace('.', ',',$distancia)." Km"; ?></td>
                            <td><?php echo "R$ " . str_replace('.', ',',number_format(calculaCusto($distancia, $vlrCombustivel), 2, '.', '')); ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>

        <?php

        function calculaCusto($dist, $vlrComb) {
            return ($dist * $vlrComb);
        }
        ?>
    </body>
</html>
