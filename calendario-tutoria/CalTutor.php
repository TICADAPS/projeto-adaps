<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Calendário Tutoria");
require __DIR__ . "/../source/autoload.php";

$idTutor = $_SESSION['idMed'];
//var_dump($idTutor);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    </head>
    <body>
        <div class="container-fluid">
            <div class="jumbotron bg-light">
                <div class="row">
                    <div class="col-md-3">
                        <img src="../img/Logo_400x200.png" class="img-fluid"  alt=""/>
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
            <div class="container-fluid">
                <?php
                $modelMedico = new \Source\Models\Medico();
                $modelControle = new \Source\Models\ControlCalendario();

                $user = $modelMedico->find("idMedico=:id", "id=$idTutor");

                $controle = $modelControle->joins($idTutor);
                //var_dump($controle);
                function Mask($mask,$str){
                    $str = str_replace("55","",$str);
                    for($i=0;$i<strlen($str);$i++){
                        $mask[strpos($mask,"#")] = $str[$i];
                    }
                    return $mask;
                    
                }
                ?>
                <h1 class="pb-5">Médico Tutor <?= $user->NomeMedico; ?></h1>

                <table class="table table-hover table-striped table-responsive-sm">
                    <thead class="thead-dark">
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Período Inicial</th>
                    <th>Período Fim</th>
                    <th>Justificativa</th>
                    <th colspan="2">Realizou tutoria?</th>
                    </thead>
                    <tbody> 
                        <?php 
                        function vemdata($qqdata){
                            $tempdata=substr($qqdata,8,2).'/'.
                                      substr($qqdata,5,2).'/'.
                                      substr($qqdata,0,4);
                            return($tempdata);
                        } 
                        ?>
                        <?php foreach ($controle as $calData):?>    
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" autocomplete="off" novalidate>
                            <tr>
                            <input type="hidden" name="idControle" value="<?= $calData->idControle ?>">
                            
                            <td class="font-weight-bold"><?= $calData->NomeMedico ?></td>
                            <td class="font-weight-bold"><?= $calData->email ?></td>
                            <td class="font-weight-bold"><?php $fone = $calData->fone_zap; 
                                    $fone = str_replace("+", "", $fone);
                                    $fone = str_replace(" ", "", $fone);
                                    $fone = str_replace("(", "", $fone);
                                    $fone = str_replace(")", "", $fone);
                                    echo Mask("(##)#####-####",$fone);
                                    ?>
                            </td>
                            <td class="font-weight-bold"><?= $calData->PeriodoInicial ?></td>
                            <td class="font-weight-bold"><?= $calData->PeriodoFinal ?></td>

                            <td>
                                <div class="form-group">                                            
                                    <label><?= $calData->JustificativaTutoria ?></label>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success"
                                        data-toggle="modal" data-target=".modalOprSim<?= $calData->idControle ?>">Sim</button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning"
                                        data-toggle="modal" data-target=".modalOprNao<?= $calData->idControle ?>" >Não</button>
                            </td>
                            <!-- modal de confirmação de apresentação do médico -->
                            <div class="modal fade modalOprSim<?= $calData->idControle ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirmação de Tutoria</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <label for="date-apresentacao" class="text-justify">Confirmar tutoria realizada?</label><br>
                                      <!--<input type="hidden" value="sim" name="opcRadio">-->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary enviar" id="btnSim" onclick="pegarOpcSim()" name="enviar" value="Confirmar">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <!-- fim do modal de confirmação de apresentação do médico -->
                            <input type="hidden" id="opcRadioSim" value="sim">
                            <!-- modalOprNao de confirmação de apresentação do médico -->
                            <div class="modal fade modalOprNao<?= $calData->idControle ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Justificativa</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="date-apresentacao" class="text-justify">Justifique a tutoria não realizada.</label><br>
                                        <div class="col-12">
                                            <textarea id="id" class="form-control" name="comment"></textarea>
                                            <!--<input type="hidden" value="não" name="opcRadio">-->
                                            <input type="hidden" id="opcRadioNao" value="não">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary enviar" id="btnNao" onclick="pegarOpcNao()" name="enviar" value="Enviar">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <!-- fim do modalOprNao de confirmação de apresentação do médico -->
                            </tr>
                        </form>
                        <?php
                            endforeach;
                            $idControle = 0;
                            $opcao = $mensagem = "";
                            if(isset($_POST['enviar'])){
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $idControle = filter_input(INPUT_POST, 'idControle', FILTER_SANITIZE_SPECIAL_CHARS);                          
                                $opcao = filter_input(INPUT_POST, 'opcRadio', FILTER_SANITIZE_SPECIAL_CHARS);
                                $mensagem = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);
                                var_dump($opcao);
                                $idControle = (int)$idControle;
                                //var_dump(gettype($idControle));                             
                                $controleCalend = (new \Source\Models\ControlCalendario())->findById($idControle);
                                $controleCalend->FlagRealizouTutoria = $opcao;
                                $controleCalend->JustificativaTutoria = $mensagem;
                                //var_dump($controleCalend);                          
                                $controleCalend->Atualizar($idControle);
                                //var_dump($controleCalend);
                                }
                                //echo "<META HTTP-EQUIV='REFRESH' CONTENT=\"0;URL='CalTutor.php'\">";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script language="javascript">
            function pegarOpcSim(){
                var btnSim = document.getElementById('opcRadioSim').value;  
                
                //document.getElementById("opcRadioSim").setAttribute("name", "opcRadio");                 
                console.log(btnSim);
            }
            function pegarOpcNao(){
                //var btnNao = document.getElementById('btnNao').value;
                document.getElementById("opcRadioNao").setAttribute("name", "opcRadio");
            }
        </script>
   </body>
</html>
