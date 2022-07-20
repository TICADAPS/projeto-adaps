<?php
require_once ("conexao.php");
require_once './google-maps/rotas/DistanciaOrigemDestino.php';

$sql2 = "select vaga_tutoria.opcao_escolhida, localidade_escolhida.idle, localidade_escolhida.munic_escolhido, localidade_escolhida.uf_escolhida, "
        . "localidade_escolhida.munic_origem, localidade_escolhida.uf_origem from localidade_escolhida inner join "
        . "vaga_tutoria on localidade_escolhida.fkvagatutoria = vaga_tutoria.idvaga where localidade_escolhida.idle > 962";
$smtm2 = mysqli_query($conn, $sql2);
while ($row_query = mysqli_fetch_assoc($smtm2)) {
    $munic_escolhido = $row_query['munic_escolhido'];
    $uf_escolhida = $row_query['uf_escolhida'];
    $munic_origem = $row_query['munic_origem'];
    $uf_origem = $row_query['uf_origem'];
    $opEscolhida = "".$row_query['opcao_escolhida'];
    
    $idle = $row_query['idle'];
    
    $origem = "$munic_origem $uf_origem";
    $destino = "$munic_escolhido $uf_escolhida";
    
    if(strlen($opEscolhida) < 7){
       $distancia = kilometragem($origem, $destino);
       echo "$idle - $origem / $destino - Opção escolhida: $opEscolhida <br>";
    }else{
        echo "<br>$origem / $destino - Opção escolhida: $opEscolhida <br>";
    }
    
    $sql3 = "update localidade_escolhida set distancia = '$distancia' where idle = '$idle'";
    mysqli_query($conn, $sql3);
}