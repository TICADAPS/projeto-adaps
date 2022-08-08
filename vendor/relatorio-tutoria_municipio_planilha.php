<?php
include_once("../calendario-tutoria/conexao.php");
ini_set('memory_limit', '1024M');
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
$arquivo = 'relatorioTutoriaMunicipioPlanilha.xlsx';

$html = '<table border=1>';
$html .= '<tr>';
$html .= '<th colspan="6">Relatório de Tutoria de Municípios</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>IBGE</th>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Data de início da tutoria</th>';
$html .= '<th>Data fim da tutoria</th>';
$html .= '</tr>';

$result_transacoes = "select e.UF,mu.Municipio, mu.cod_munc as IBGE, mb.nome_medico, 
    ct.PeriodoInicial, ct.PeriodoFinal from municipio mu
inner join estado e on e.cod_uf = mu.Estado_cod_uf
inner join medico med on mu.cod_munc = med.Municipio_id
inner join medico_bolsista mb on mb.idMedico = med.idMedico
inner join ControleCalendario cc on cc.idMedico = mb.idMedico
inner join CalendarioTutoria ct on ct.idCalendario = cc.idCalendario
order by e.UF, mu.Municipio;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['IBGE'] . "</td>";
    $html .= '<td>' . $row_transacoes['nome_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['PeriodoInicial'] . "</td>";
    $html .= '<td>' . $row_transacoes['PeriodoFinal'] . "</td>";  
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