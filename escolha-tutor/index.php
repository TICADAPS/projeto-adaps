<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
if (!isset($_SESSION['cpf'])) {
    header("Location: login.php");
}
//require __DIR__ . '/../fullstackphp/fsphp.php';
//fullStackPHPClassName("Escolha Tutoria");
require __DIR__ . "/../source/autoload.php";
# obtendo o id e o estado do medico logado pela sessão
$codUf = $_SESSION['uf'];
$idMedico = $_SESSION['idMed'];

# instanciando um objeto da classe estado
//var_dump($codUf);
$Modelouf = new Source\Models\Estado();
$uf = $Modelouf->load($codUf);
$estado = $uf->UF;
//var_dump($estado);

# instanciando um objeto da classe tutorMunicipio
$modelTutor = new \Source\Models\TutorMunicipio();
$tutorMun = $modelTutor->selectMunicipio($codUf);
foreach ($tutorMun as $value) {
    $munEscolhido = ($value->Municipio);
}

# instanciando um objeto da vagaTutoria
$modelVagaTutor = new Source\Models\VagaTutoria();
$vagaTutoria = $modelVagaTutor->find("idMedico=:id", "id={$idMedico}");
$idVagaMedico = $vagaTutoria->idMedico;
$opcao1 = $vagaTutoria->opcao1;
$opcao2 = $vagaTutoria->opcao2;
$opcao3 = $vagaTutoria->opcao3;

//var_dump([$idVagaMedico,$opcao1,$opcao2,$opcao3]);

# instanciando objeto da classe município
$modeloMunicipio = new Source\Models\Municipio();
$municipio1 = $modeloMunicipio->find("cod_munc=:id", "id={$opcao1}");
$municipio2 = $modeloMunicipio->find("cod_munc=:id", "id={$opcao2}");
$municipio3 = $modeloMunicipio->find("cod_munc=:id", "id={$opcao3}");

#definindo as variáveis
$opc1 = $opc2 = $opc3 = $idMed = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($_POST['opc1'])){
        $opc1 = $_POST['opc1'];
    }
    if(!empty($_POST['opc2'])){
        $opc2 = $_POST['opc2'];
    }
    if(!empty($_POST['opc3'])){
        $opc3 = $_POST['opc3'];
    }

    $crudProcedure->CallProcedure($idMedico,$opc1,$opc2,$opc3);
    header("Location:index.php");
}
//var_dump($idMedico,$idMedVaga);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Escolha de tutoria</title>
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
    <style>
        #container-central{
            background: #F8F9FA;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
        </div>
        <div class="col-md-8 col-sm-6 mt-5 ">
            <?php echo "SEJA BEM-VINDO(A) DR(A) <b>{$_SESSION['nome']}</b>"; ?>
            <p>Você deve escolher 3 opções de cidades para receber tutoria</p>
            <p><b>Obs: Cada tutor pode receber no máximo 10 médicos bolsistas</b></p>
        </div>
    </div>
    <div class="container-fluid" id="container-central">
        <h1 class="text-center mb-5">
            <?php
            switch ($estado){
                case 11:
                    echo "Rondônia";
                    break;
                case 12:
                    echo "Acre";
                    break;
                case 13:
                    echo "Amazonas";
                    break;
                case 14:
                    echo "Roraima";
                    break;
                case 15:
                    echo "Pará";
                    break;
                case 16:
                    echo "Amapá";
                    break;
                case 17:
                    echo "Tocantins";
                    break;
                case 21:
                    echo "Maranhão";
                    break;
                case 22:
                    echo "Piauí";
                    break;
                case 23:
                    echo "Ceará";
                    break;
                case 24:
                    echo "Rio Grande do Norte";
                    break;
                case 25:
                    echo "Paraíba";
                    break;
                case 26:
                    echo "Pernambuco";
                    break;
                case 27:
                    echo "Alagoas";
                    break;
                case 28:
                    echo "Sergipe";
                    break;
                case 29:
                    echo "Bahia";
                    break;
                case 31:
                    echo "Minas Gerais";
                    break;
                case 32:
                    echo "Espirito Santo";
                    break;
                case 33:
                    echo "Rio de Janeiro";
                    break;
                case 35:
                    echo "São Paulo";
                    break;
                case 41:
                    echo "Paraná";
                    break;
                case 42:
                    echo "Santa Catarina";
                    break;
                case 43:
                    echo "Rio Grande do Sul";
                    break;
                case 50:
                    echo "Mato Grosso do Sul";
                    break;
                case 51:
                    echo "Mato Grosso";
                    break;
                case 52:
                    echo "Goiás";
                    break;
                case 53:
                    echo "Distrito Federal";
                    break;
            }

            ?>
        </h1>

        <div class="row">
            <?php

            if(!isset($idVagaMedico)): ?>
                <div class="col-md-6">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="primeira"><b>Primeira Opção:</b></label>
                            </div>
                            <select class="col-md-7 form-control mb-4" name="opc1" id="opc1">
                                <?php
                                    foreach ($tutorMun as $value):                                    
                                    ?>
                                    <option value="<?= $value->cod_munc; ?>"><?= $value->Municipio; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="segunda"><b>Segunda Opção:</b></label>
                            </div>
                            <select class="col-md-7 form-control mb-4" name="opc2" id="opc2">
                                <?php
                                    foreach ($tutorMun as $value):                                    
                                    ?>
                                    <option value="<?= $value->cod_munc; ?>"><?= $value->Municipio; ?></option>
                                <?php endforeach; ?>
                            </select>  
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="terceira"><b>Terceira Opção:</b></label>
                            </div>
                            <select class="col-md-7 form-control mb-4" name="opc3" id="opc3">
                                <?php
                                    foreach ($tutorMun as $value):                                    
                                    ?>
                                    <option value="<?= $value->cod_munc; ?>"><?= $value->Municipio; ?></option>
                                <?php endforeach; ?>
                            </select>                            
                        </div>
                        <div class="row">
                            <input type="submit" class="col-md-11 btn btn-primary btn-lg btn-block">
                        </div>
                        <div class="row">
                            <div class="col-md-11 text-light mt-4 bg-secondary p-4">
                                <p><b>Caso exista somente um município de vaga para tutoria, este município estará disponível nas três opções!</b></p>
                                <p>Você deve escolher, em ordem de preferência, três cidades onde gostaria de realizar a atividade de tutoria. As cidades devem ser do mesmo estado onde você está trabalhando.</p>
                                <p>A cidade onde você vai realizar a tutoria clínica é importante pois você deverá se deslocar do município onde está alocado para o município onde está o seu tutor e passar uma semana, a cada 2 meses, realizando as atividades de tutoria clínica na equipe do seu tutor.</p>
                                <p>Os municípios indicados por você servirão de referência para a vinculação com um tutor. A ADAPS buscará atender as preferências indicadas pelos médicos, mas é possível que você seja vinculado a um tutor que não esteja nas cidades que você indicou.</p>
                            </div>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="primeira"><b>Primeira Opção:</b></label>
                        </div>

                        <select class="col-md-7 form-control mb-4" name="opc1" id="opc1" disabled>
                            <option value=""><?= $municipio1->Municipio; ?></option>
                        </select>

                    </div><div class="row">
                        <div class="col-md-4">
                            <label for="segunda"><b>Segunda Opção:</b></label>
                        </div>

                        <select class="col-md-7 form-control mb-4" name="opc2" id="opc2" disabled>
                            <option value=""><?= $municipio2->Municipio; ?></option>
                        </select>

                    </div><div class="row">
                        <div class="col-md-4">
                            <label for="terceira"><b>Terceira Opção:</b></label>
                        </div>

                        <select class="col-md-7 form-control mb-4" name="opc3" id="opc3" disabled>
                            <option value=""><?= $municipio3->Municipio; ?></option>
                        </select>
                    </div>

                    <div class="row">
                        <form method="POST" action="processa.php" enctype="multipart/form-data">
                            <div class="col-md-12 text-light mt-4 bg-success p-4">
                                <p><b>Caso exista somente um município de vaga para tutoria, este município estará disponível nas três opções!</b></p>
                                <p><h3>Suas opções de município de tutoria foram coletadas com sucesso.</h3> </p>
                                <p><h3>Seu pedido encontra-se em análise pela ADAPS</h3></p>
                            </div>
                            <div>
                                <h3 class="text-center mt-3">Sua avaliação é importante para nós.</h3>
                                <h1 class="text-center">Avalie nosso serviço!</h1>
                                <div class="estrelas text-center">
                                    <input type="radio" id="vazio" name="estrela" value="" checked>
                                    <label for="estrela_um"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_um" name="estrela" value="1">
                                    <label for="estrela_dois"><i class="fa" style="font-size:48px;" ></i></label>
                                    <input type="radio" id="estrela_dois" name="estrela" value="2">
                                    <label for="estrela_tres"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_tres" name="estrela" value="3">
                                    <label for="estrela_quatro"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_quatro" name="estrela" value="4">
                                    <label for="estrela_cinco"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_cinco" name="estrela" value="5">
                                    <label for="estrela_seis"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_seis" name="estrela" value="6">
                                    <label for="estrela_sete"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_sete" name="estrela" value="7">
                                    <label for="estrela_oito"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_oito" name="estrela" value="8">
                                    <label for="estrela_nove"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_nove" name="estrela" value="9">
                                    <label for="estrela_dez"><i class="fa" style="font-size:48px;"></i></label>
                                    <input type="radio" id="estrela_dez" name="estrela" value="10"><br><br>
                                    <?php
                                    if (isset($_SESSION['msg'])) {
                                        echo "<h2 class='text-center mt-2'>".$_SESSION['msg'] . "</h2>";
                                        echo "<a href='logout.php' class='btn btn-danger btn-lg btn-block'>SAIR</a>";
                                        unset($_SESSION['msg']);
                                    }elseif(isset($_SESSION['msgErr'])) {
                                        echo "<h2 class='text-center mt-2'>".$_SESSION['msgErr'] . "</h2>";
                                        unset($_SESSION['msg']);
                                        ?>
                                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar">
                                        <?php
                                    }else{
                                        ?>
                                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Enviar">
                                    <?php } ?>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-md-6 embed-responsive embed-responsive-4by3">
                <?php
                switch ($estado){
                    case 11:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4012922.7161376956!2d-65.53624246254651!3d-10.821271500497888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x92325cd96f516b57%3A0x733763d5340621dd!2zUm9uZMO0bmlh!5e0!3m2!1spt-BR!2sbr!4v1652732617174!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 12:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2016929.6010772388!2d-71.42455718827648!3d-9.125937936648489!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x917f8daa4e9106b9%3A0x25ec0ac5083607c1!2sAcre!5e0!3m2!1spt-BR!2sbr!4v1652732643152!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 13:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8153463.971496626!2d-69.44376286841259!3d-3.7701972423106196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x92183f5c8b1d6ed1%3A0x176d6af66b3c2efa!2sAmazonas!5e0!3m2!1spt-BR!2sbr!4v1652732670800!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 14:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4083445.2180595296!2d-64.10420030611515!3d1.8496581150663065!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8d930671dfccf45b%3A0x695f00f29e9c7a14!2sRoraima!5e0!3m2!1spt-BR!2sbr!4v1652732708234!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 15:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8155163.681988435!2d-56.9759934225945!3d-3.5843704282354634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9288f999ac2c0997%3A0x315ec83ee755f30a!2zUGFyw6E!5e0!3m2!1spt-BR!2sbr!4v1652732749987!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 16:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4083976.5110882875!2d-54.62004927191804!3d1.6022811987457644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8d653d73cd997b21%3A0x911a614576f6bcd4!2zQW1hcMOh!5e0!3m2!1spt-BR!2sbr!4v1652732783060!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 17:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4031804.803408017!2d-50.46463347757633!3d-9.305830983128757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9323501f52b13997%3A0xe3d4866245cc396c!2sTocantins!5e0!3m2!1spt-BR!2sbr!4v1652732809773!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 21:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4065755.4029637324!2d-47.5196402076405!3d-5.645765330883474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7edd77a9bcc1ce5%3A0x6276aba3d96c2934!2zTWFyYW5ow6Nv!5e0!3m2!1spt-BR!2sbr!4v1652732836595!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 22:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4056592.0518351593!2d-45.44337131634488!3d-6.828599544995833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x782e57c7080b28f%3A0x5ae7715404f694a5!2zUGlhdcOt!5e0!3m2!1spt-BR!2sbr!4v1652732890457!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 23:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4068029.614896264!2d-41.582123055321404!3d-5.311720423945951!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7bdb31827e686c5%3A0x3bb435e0af957842!2zQ2VhcsOh!5e0!3m2!1spt-BR!2sbr!4v1652732478378!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 24:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1015986.8286508787!2d-37.335728655946625!3d-5.897900385848615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b04df549e8eaad%3A0xa92509ac1c4d9ec4!2sRio%20Grande%20do%20Norte!5e0!3m2!1spt-BR!2sbr!4v1652732923430!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 25:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2026855.6899929326!2d-37.90058032085811!3d-7.16034938634047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7a54cb6ee98c8cf%3A0x1f289b24323c01b4!2zUGFyYcOtYmE!5e0!3m2!1spt-BR!2sbr!4v1652733206175!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 26:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4058224.7220834875!2d-39.1120680874697!3d-6.633248570800715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7007c9d931c86c5%3A0x1de0196a93401726!2sPernambuco!5e0!3m2!1spt-BR!2sbr!4v1652733246721!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 27:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1006926.0187228713!2d-37.25519069087493!3d-9.65497973965311!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x700fd232f520d9b%3A0x7e2d39e57f3df62d!2sAlagoas!5e0!3m2!1spt-BR!2sbr!4v1652733282641!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 28:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2008321.010502505!2d-38.44183896666494!3d-10.539836071966477!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x705bd3f16601621%3A0xaccaca6b66fef1d9!2sSergipe!5e0!3m2!1spt-BR!2sbr!4v1658405693337!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 29:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7949021.571613901!2d-46.454256961708715!3d-13.390133374933695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x716037ca23ca5b3%3A0x7e926f5fb491ed05!2sBahia!5e0!3m2!1spt-BR!2sbr!4v1652733610431!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 31:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3873098.34904156!2d-47.69517156983708!3d-18.559488950431543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa690a165324289%3A0x112170c9379de7b3!2sMinas%20Gerais!5e0!3m2!1spt-BR!2sbr!4v1652784564086!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 32:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3849376.0723870695!2d-37.607398060371835!3d-19.57780249220182!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xb7069579646359%3A0x4e1bd5243c50f799!2sEsp%C3%ADrito%20Santo!5e0!3m2!1spt-BR!2sbr!4v1652784600932!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 33:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1893240.6873541032!2d-44.04478817779487!3d-22.059702883849923!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x981894cae28ac3%3A0x349c31ac10583d0!2sRio%20de%20Janeiro!5e0!3m2!1spt-BR!2sbr!4v1652784639592!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 35:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3773262.0243551745!2d-50.87930543950356!3d-22.548182578940626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce597d462f58ad%3A0x1e5241e2e17b7c17!2sS%C3%A3o%20Paulo!5e0!3m2!1spt-BR!2sbr!4v1652786180339!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 41:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1857226.3996627647!2d-52.442559364689686!3d-24.610056527152285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94db0b9430b8629d%3A0xe893fd5063cef061!2zUGFyYW7DoQ!5e0!3m2!1spt-BR!2sbr!4v1652786139680!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 42:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1809523.1863629508!2d-52.20398695852285!3d-27.64851042929894!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94d94d25c052fff9%3A0x2b277580ed7fab2b!2sSanta%20Catarina!5e0!3m2!1spt-BR!2sbr!4v1652786263557!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 43:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3524054.7598727033!2d-55.913128399416536!3d-30.394695987854032!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9504720c40b45803%3A0xad9fb3dbaf9f73de!2sRio%20Grande%20do%20Sul!5e0!3m2!1spt-BR!2sbr!4v1652786308508!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 50:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3824407.4914319213!2d-56.78935340213691!3d-20.5973282231512!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x947e91dbe29f7383%3A0x351cd8e9695410ac!2sMato%20Grosso%20do%20Sul!5e0!3m2!1spt-BR!2sbr!4v1652786518830!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 51:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7972902.191063068!2d-60.42425356145976!3d-12.646781201399536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x939db1e748370319%3A0xc66268e27d2181fb!2sMato%20Grosso!5e0!3m2!1spt-BR!2sbr!4v1652786567077!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                    case 52:
                        ?>
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928683.049189991!2d-51.82166064334889!3d-15.929775627345176!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935db96386b920f5%3A0x8c6d8f8cd8cf0d3!2zR29pw6Fz!5e0!3m2!1spt-BR!2sbr!4v1652723366629!5m2!1spt-BR!2sbr" width="300" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        <?php
                        break;
                    case 53:
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d491462.06470348843!2d-48.07730260461793!3d-15.775065597234457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a3f0ec64dafad%3A0x6787067ba9d0b5c2!2sDistrito%20Federal%2C%20Bras%C3%ADlia%20-%20DF!5e0!3m2!1spt-BR!2sbr!4v1652786632909!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <?php
                        break;
                }

                ?>
            </div>
        </div>


    </div>

</body>
</html>
