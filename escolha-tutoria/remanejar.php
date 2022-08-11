<?php
require_once ("conexao.php");
require_once ("Class/CrudEscolha.php");
$idMedico = filter_input(INPUT_GET,"id",FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$queryMun = "SELECT idTutor,md.NomeMedico,UF,cod_munc,municipio,vaga_tutor as vaga 
FROM tutor_municipio tm  
    INNER JOIN medico md ON md.idMedico = tm.idTutor
    INNER JOIN estado e ON e.cod_uf = tm.codUf    
WHERE vaga_tutor > 0 ORDER BY UF";

$resultado_trasacoes = mysqli_query($conn, $queryMun);
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="css/estilo.css">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <img src="img/Logo_400x200.png" class="img-fluid" alt="logoAdaps" title="Logo Adaps">
        </div>
        <div class="col-md-8 col-sm-6 mt-5 ">
            <p><b>Área de relatório dos médicos bolsistas</b></p>
        </div>
    </div>
    <form action="" method="post">
        <table class="table table-bordered">
            <thead>
                <tr class="table-primary font-weight-bold">
                    <td>Opção</td>
                    <td>Nome Tutor</td>
                    <td>UF</td>
                    <td>Município</td>
                    <td>Vaga</td>
                </tr>
            </thead>
<?php
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)){
    ?>
            <tbody>
                <tr>
                    <td><a href="cadMedTutoria.php?idTutor=<?php echo $row_transacoes['idTutor'];?>&codMun=<?php echo $row_transacoes['cod_munc'];?>&idMed=<?php echo $idMedico ?>">
                            <img src="img/plus.png" width="32" alt="add">
                        </a>
                    </td>
                    <td><?php echo $row_transacoes['NomeMedico']; ?></td>
                    <td><?php echo $row_transacoes['UF']; ?></td>
                    <td><?php echo $row_transacoes['municipio']; ?></td>
                    <td><?php echo $row_transacoes['vaga']; ?></td>
                </tr>
            </tbody>
<?php } ?>
        </table>
    </form>
</div>
