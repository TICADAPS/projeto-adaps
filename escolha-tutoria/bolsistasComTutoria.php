<?php
session_start();
require __DIR__ . '/../fullstackphp/fsphp.php';
fullStackPHPClassName("Escolha Tutoria");
require __DIR__ . "/../source/autoload.php";

# instanciando bolsista
$modelVagaTutor = new Source\Models\VagaTutoria();
$bolsistaTutor = $modelVagaTutor->bolsistaComTutor();

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
                    <h3 class="text-justify"><b>Área de relatório dos médicos bolsistas</b></h3>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo "<h2>" . $_SESSION['msg'] . "</h2>";
                        unset($_SESSION['msg']);
                    }
                    ?>
                </div>
            </div>
            <div class="container-fluid" id="container-central">
                <a href="AdminRelatorio.php" class="btn btn-primary btn-lg my-3 py-3">Área do Admin</a>

                <div class="row">
                    <div class="col-md-10">
                        <h2 class="my-4">Bolsista que já havia escolhido tutoria</h2>
                        <table class="table table-bordered">
                            <thead class="text-light">
                                <tr class="bg-primary">
                                    <td>Nome</td>
                                    <td>Estado</td>
                                    <td>Município</td>
                                    <td>Opção escolhida</td>
                                    <td>Estado</td>
                                    <td>Remanejar</td>
                                </tr>
                            </thead>
                            <!-- estrutura do loop -->
                            <?php
                            foreach ($bolsistaTutor as $value):
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $value->NomeMedico; ?></td>
                                        <td><?php echo $value->UF; ?></td>
                                        <td><?php echo $value->Municipio; ?></td>
                                        <td><?php echo $value->opcaoEscolhia; ?></td>
                                        <td><?php echo $value->destino; ?></td>
                                        <td><a href="<?php echo "remanejarBolsista.php?id={$value->idMedico}"; ?>"><img src="img/plus.png" width="32" alt="add"></a></td>
                                    </tr>
                                </tbody>
                                <?php
                            endforeach;
                            ?>
                        </table>
                    </div>

                </div>

            </div>
        </div>
        <script>
            function UfMunicipio() {
                var cod_estado = $('#slUf').val();
                //console.log(cod_estado);
                var obj = {
                    cod_estado
                };
                $.ajax({
                    url: 'ajax/select-municipio.php',
                    data: obj,
                    type: 'GET',
                    success: function (data) {
                        $('.form-group.col-md-9.municipio').html(data);
                    },
                    dataType: 'json',
                })
            }

            function UfBolsista() {
                var cod_municipio = $('#municipio').val();
                //console.log(cod_municipio);
                var obj = {
                    cod_municipio
                };
                $.ajax({
                    url: 'ajax/select-bolsista.php',
                    data: obj,
                    type: 'GET',
                    success: function (data) {
                        $('.form-group.col-md-6.tutores').html(data);
                    },
                    dataType: 'json',
                })
            }
        </script>
    </body>
</html>

