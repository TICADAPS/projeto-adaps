<?php
require_once ("conexao.php");
//require_once './google-maps/rotas/DistanciaOrigemDestino.php';
$sql1 = "select idvaga, opcao_escolhida, medico_bolsista.idMedico as idMedicoBolsista, medico_bolsista.nome_medico "
        . "from vaga_tutoria inner join medico_bolsista on medico_bolsista.idMedico = vaga_tutoria.idMedico ";
$smtm1 = mysqli_query($conn, $sql1);
while ($row_query = mysqli_fetch_assoc($smtm1)) {
    $idvaga = $row_query['idvaga'];
    $fkMunic = $row_query['opcao_escolhida'];
    $idMedicoBolsista = $row_query['idMedicoBolsista'];
    $nome_medico = $row_query['nome_medico'];
    
    $sql = "select estado.UF as uf_escolhida, municipio.Municipio as munic_escolhido "
        . "from vaga_tutoria, estado, municipio WHERE vaga_tutoria.opcao_escolhida = municipio.cod_munc "
        . "and municipio.Estado_cod_uf = estado.cod_uf and vaga_tutoria.idvaga = '$idvaga'";
    $smtm = mysqli_query($conn, $sql);
    while ($row_quer = mysqli_fetch_assoc($smtm)) {
        $munic_escolhido = $row_quer['munic_escolhido'];
        $uf_escolhida = $row_quer['uf_escolhida'];
    }
    
    $sql2 = "select estado.UF as ufOrigem, municipio.Municipio as municipioOrigem "
        . "from medico, estado, municipio WHERE medico.Estado_idEstado = estado.cod_uf "
        . "and municipio.cod_munc = medico.Municipio_id and medico.idMedico = '$idMedicoBolsista'";
    $smtm2 = mysqli_query($conn, $sql2);
    $contador = 0;
    while ($row_query = mysqli_fetch_assoc($smtm2)) {
        $contador++;
        $ufOrigem = $row_query['ufOrigem'];
        $municipioOrigem = $row_query['municipioOrigem'];

        $sql3 = "insert into localidade_escolhida values (null, '$municipioOrigem', '$ufOrigem', "
                . "'$munic_escolhido', '$uf_escolhida', 0, '$idvaga')";
        mysqli_query($conn, $sql3);
    }
}