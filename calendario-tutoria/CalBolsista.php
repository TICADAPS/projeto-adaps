<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Calendário Tutoria");
require __DIR__ . "/../source/autoload.php";

$idBolsista = $_SESSION['idMed'];
//var_dump($idBolsista);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <body>
        <div class="container-fluid">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-3">
                        <!--<img src="../img/Logo_400x200.png" class="img-fluid"  alt=""/>-->
                        <img src="../img/proj_giff.gif" class="img-fluid" width="70%" alt=""/>
                    </div>
                    <div class="col-md-9 col-12 col-lg-6">

                        <h1 class="text-center">Calendário de tutoria dos Médicos bolsistas</h1>
                        <p><h3 class="text-center"></h3></p>                    
                        <?php
                        echo "<p class='text-center'>Seja bem-vindo <b>" . $_SESSION['nome'] . "</b></p>";
                        ?>

                    </div>
                </div>
            </div>

        </div>

        <div class="form-1-container section-container">
            <div class="container">
                <?php
                $modelMedico = new \Source\Models\Medico();
                $modelControle = new \Source\Models\ControlCalendario();
                $modelCntrlEmail = new \Source\Models\ControlCalendario();                               
                $modeloMunicipio = new Source\Models\Municipio();
                
                $user = $modelMedico->find("idMedico=:id", "id=$idBolsista");
                $idMedBolsista = $modelControle->find("idMedico=:id", "id=$idBolsista");
                $idControleBolsista = $idMedBolsista->idControle;
                //var_dump($idControleBolsista);
                
                $controle = $modelControle->joinsBolsista($idBolsista);
                $ctrlEmail = $modelCntrlEmail->joinsEmailTutor($idBolsista);
                

                function Mask($mask, $str) {
                    $str = str_replace("55", "", $str);
                    for ($i = 0; $i < strlen($str); $i++) {
                        $mask[strpos($mask, "#")] = $str[$i];
                    }
                    return $mask;
                }
                ?>

                <h1 class="py-5 bg-dark text-center text-light">Médico Bolsista <?= $user->NomeMedico; ?></h1>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <h4 class="border border-dark">Dados do tutor para contato</h4>
                        <ul class="ml-3">
                            <?php

                            function vemdata($qqdata) {
                                $tempdata = substr($qqdata, 8, 2) . '/' .
                                        substr($qqdata, 5, 2) . '/' .
                                        substr($qqdata, 0, 4);
                                return($tempdata);
                            }
                            ?>

                            <?php foreach ($controle as $value): ?>                            
                                <?php foreach ($ctrlEmail as $mail): ?>
                                    <li class="font-weight-bold">Nome do Tutor:</li>
                                    <?= $mail->NomeMedico; ?>
                                    <li class="font-weight-bold">E-mail do Tutor:</li>
                                    <?= $mail->email; ?>
                                    <li class="font-weight-bold">Telefone do Tutor:</li>
                                    <?php
                                    $fone = $mail->fone_zap;
                                    $fone = str_replace("+", "", $fone);
                                    $fone = str_replace(" ", "", $fone);
                                    $fone = str_replace("(", "", $fone);
                                    $fone = str_replace(")", "", $fone);
                                    echo Mask("(##)#####-####", $fone);
                                    ?>
                                    <li class="font-weight-bold">Local de Tutoria:</li>
                                    <?= $mail->Municipio; ?> - <?= $mail->UF; ?>
                                </ul>
                            </div>
                            <div class="col-md-6 col-12">
                                <h4 class="border border-dark">Dados do médico</h4>
                                <ul class="ml-3">
                                <?php endforeach;
                                $distancia = 501; ?>
                                <li class="font-weight-bold">Local de Origem:</li>
                                <?= $value->Municipio; ?>
                                <li class="font-weight-bold">Período Inicial de tutoria:</li>
                                <?= vemdata($value->PeriodoInicial) ?>
                                <li class="font-weight-bold">Período Final de Tutoria:</li>
                                <?= vemdata($value->PeriodoFinal) ?>
                                <li class="font-weight-bold">Distância em KM:</li>
                                <?= $distancia ?>
                                <li class="font-weight-bold">Valor de deslocamento:</li>
                                <?= "R$" ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <h4 class="bg-dark py-3 text-light text-center">Itens a serem optados de acordo com a portaria que versa sobre deslocamento em tutorias</h4>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="hidden" name="idBolsista" value="<?= $idControleBolsista; ?>">
                    <div class="form-check border border-dark py-2">    
                        <label class="form-check-label" for="check1">
                            É de obrigação do médico bolsista  
                            confirmar a participação para que as providências relativas a custeio
                            de translado e hospedagem sejam providenciadas. 
                        </label>
                        <div class="row my-2">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="flagDisponibilidade" value="1">
                            </div>
                            <div class="col-10">
                                <b>Confirmo disponibilidade para a data informada acima</b>
                            </div>
                        </div>  
                        <p><i class="text-danger"><b>Observação:</b> Situações excepcionais nas quais não seja possível o comparecimento 
                                na data designada, deverão ser reportadas à ADAPS através do e-mail
                                <b>ensino@adapsbrasil.com.br</b></i>
                        </p>                

                    </div>
                    <?php if ($distancia > 500): ?>
                        <div class="form-check border border-dark py-2">    
                            <label class="form-check-label" for="check2">
                            <p><b>Art.  5º</b>  Nos casos em que a distância entre os municípios for superior a 500 km (quinhentos quilômetros), o médico bolsista poderá optar por:</p>
                            <p>I - receber o recurso financeiro de subsídio ao seu traslado, de acordo com os parâmetros desta Portaria;</p>
                            <p>II - receber as passagens de ida e volta, adquiridas pela ADAPS, desde que a agência contratada, consiga garantir a contratação dos serviços, de forma que  a escolha do meio de transporte venha de encontro  aos princípios  da vantajosidade e  economicidade.</p>
                            <p>§  1º O médico bolsista deverá informar a ADAPS, em sistema a ser disponibilizado pela Agência, apenas nos casos em que optar pela alternativa descrita no inciso II deste artigo.</p>
                            </label>
                            <div class="row my-2">
                                <div class="col-1">
                                    <input type="checkbox" class="form-check-input" name="flagSolicitaPassagem" value="1"> 
                                </div>
                                <div class="col-11">
                                    <b>DESEJO receber as passagens de ida e volta pela agência ao invés de receber o recurso financeiro de subsídio</b>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-check border border-dark py-2">  
                        <label class="form-check-label pb-5 ml-3" for="check3">     
                            <p><b>Art. 10</b> Caso o médico bolsista não necessite da contratação de local de hospedagem no município onde realiza a tutoria clínica, deverá informar a ADAPS em até 15 (quinze) dias antes da data prevista para o deslocamento, em sistema a ser disponibilizado pela Agência.</p>                          
                        </label>
                        <div class="row my-2">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="flagDispensaHospedagem" value="1"> 
                            </div>
                            <div class="col-11">
                                <b>NÃO NECESSITO de contratação de local de hospedagem</b>
                            </div>
                        </div>
                    </div>

                    <div class="form-check border border-dark py-2">                            
                        <label class="form-check-label pb-5 ml-3" for="check4">    
                            <p><b>Art. 15</b>  - Para os médicos que farão o deslocamento em carro próprio, deverão assinar um termo de responsabilidade  no sistema a ser disponibilizado.
                                <a href="#"> Clique aqui para acessar o termo.</a> 
                            </p>                            
                        </label>
                        <div class="row my-2">
                            <div class="col-1">
                                <input type="checkbox" class="form-check-input" name="flagTermoResponsabilidade" value="1"> 
                            </div>
                            <div class="col-11">
                                <b>Concordo com o conteúdo do termo de responsabilidade</b> 
                            </div>
                        </div>
                    </div>
                    <div class="form-check border border-dark py-2">    
                        <div class="form-check">    
                            <a href="#"> Link de acesso a Portaria que versa sobre translados e hospedagens.</a>
                        </div>
                        
                        <div class="row my-2">
                            <div class="col-1">                                                  
                                <input type="checkbox" class="form-check-input" name="flagCienciaPortaria" value="1"> 
                            </div>
                            <div class="col-11">
                                <b>Declaro que estou ciente dos termos da portaria xxx</b> <span class="text-danger"><b>(*)</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <input type="submit" class="btn btn-success btn-lg px-5">
                        <a href="logout.php" class="btn btn-danger btn-lg btn-block px-5">Cancelar</a>
                    </div>
                </form>
            </div>   
            <?php
            $flag1=$flag2=$flag3=$flag4=$flag5 = 0;
            $idControleCalendario = 0;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(!empty($_POST['flagDisponibilidade'])){
                    $flag1 = $_POST['flagDisponibilidade'];
                }else{
                    $flag1 = 0;
                }
                if(!empty($_POST['flagSolicitaPassagem'])){
                    $flag2 = $_POST['flagSolicitaPassagem'];
                }else{
                    $flag2 = 0;
                }
                if(!empty($_POST['flagDispensaHospedagem'])){
                    $flag3 = $_POST['flagDispensaHospedagem'];
                }else{
                    $flag3 = 0;
                }
                if(!empty($_POST['flagTermoResponsabilidade'])){
                    $flag4 = $_POST['flagTermoResponsabilidade'];
                }else{
                    $flag4 = 0;
                }
                if(!empty($_POST['flagCienciaPortaria'])){
                    $flag5 = $_POST['flagCienciaPortaria'];
                }else{
                    $flag5 = 0;
                }
                if(!empty($_POST['idBolsista'])){
                    $idControleCalendario = $_POST['idBolsista'];
                }else{
                    $idControleCalendario = 0;
                }
                $data = new DateTime();
                $hoje = $data->format("Y-m-d H:i:s");
                $controleCalend = (new \Source\Models\ControlCalendario())->findById($idControleCalendario);
                $controleCalend->flagDisponibilidade = $flag1;
                $controleCalend->flagSolicitaPassagem = $flag2;
                $controleCalend->flagDispensaHospedagem = $flag3;
                $controleCalend->flagTermoResponsabilidade = $flag4;
                $controleCalend->flagCienciaPortaria = $flag5;
                $controleCalend->DataCreate = $hoje;
                
                if($flag5 == 1){
                    $controleCalend->Atualizar($idControleCalendario);
                }else{
                     echo "<script>alert('Você deve marcar: \'Declaro que estou ciente dos termos da portaria xxx\') ')</script>";
                }
            }    
            
            ?>
        </div>
    </body>
</html>
