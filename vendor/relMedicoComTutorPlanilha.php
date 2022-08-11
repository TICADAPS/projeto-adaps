<?php
include_once("../conexao.php");
ini_set('memory_limit', '256M');
set_time_limit(100);
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Área do médico</title>
        
    </head>
    <body>
<?php
// nome do arquivo que será exportado
$arquivo = 'RelatorioPedidoTutoria.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="4">ADAPS - Relatório de Bolsistas com Tutor</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Estado</th>';
$html .= '<th>Município</th>';
$html .= '<th>Local Tutoria</th>';
$html .= '</tr>';

$result_transacoes = "select 
    NomeMedico, 
    UF, 
    mun.Municipio as Municipio, 
    m1.Municipio as Tutoria 
    from medico me inner join estado est on me.Estado_idEstado = est.cod_uf
    inner join municipio mun on me.Municipio_id = mun.cod_munc
    inner join vaga_tutoria vt on vt.idMedico = me.idMedico
    inner join municipio m1 on m1.cod_munc = vt.opcao_escolhida
where me.idCargo = 1 and me.Convocacao <= 3 order by UF;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Tutoria'] . "</td>";
    $html .= '</tr>';
}

$html .= '</table>';

    // configurações header para forçar o download
    header("Expires: Mon, 30 Out 2099 10:00:00 GMT");
    header("Last-Modified: ". gmdate("D,d M YH:i:s")." GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Content-type: application/x-msexcel");
    header("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header("Content-Description: PHP Generated Data" );
      
    // envia o conteúdo do arquivo
    echo $html;
    exit;
?>
    </body>
</html>