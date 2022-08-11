<?php
include_once("../calendario-tutoria/conexao.php");
ini_set('memory_limit', '2048M');
set_time_limit(300);
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
$arquivo = 'relatorioDisponibilidadePlanilha.xlsx';
$html = '<table border=1>';
$html .= '<tr>';
$html .= '<th colspan="9">Relatório de Disponibilidade</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>CPF Bolsista</th>';
$html .= '<th>Solicita passagem</th>';
$html .= '<th>Solicita hospedagem</th>';
$html .= '<th>Aceita os termos</th>';
$html .= '<th>Ciente da portaria</th>';
$html .= '<th>Registrado em</th>';
$html .= '<th>Inicio em</th>';
$html .= '<th>Fim em</th>';
$html .= '</tr>';


$result_transacoes = "select m.NomeMedico, m.CpfMedico, 
case when cc.FlagSolicitaPassagem = 0 then 'Não' 
when cc.FlagSolicitaPassagem = 1 then 'sim' end as SolicitaPas, 
case when cc.FlagDispensaHospedagem = 0 then 'Não' 
when cc.FlagDispensaHospedagem = 1 then 'sim' end as Solicitahospe,
case when cc.FlagTermoResponsabilidade = 0 then 'Não' 
when cc.FlagTermoResponsabilidade = 1 then 'sim' end as Aceitatermos,
case when cc.FlagCienciaPortaria = 0 then 'Não' 
when cc.FlagCienciaPortaria = 1 then 'sim' end as Cienteportaria,
cc.DataCreate as Registrado, ct.PeriodoInicial, ct.PeriodoFinal
from ControleCalendario cc 
inner join medico m on cc.idMedico = m.idMedico
inner join CalendarioTutoria ct on ct.idCalendario = cc.idCalendario
order by cc.DataCreate desc;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['CpfMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['SolicitaPas'] . "</td>";
    $html .= '<td>' . $row_transacoes['Solicitahospe'] . "</td>";
    $html .= '<td>' . $row_transacoes['Aceitatermos'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Cienteportaria'] . "</td>";    
    $html .= '<td>' . $row_transacoes['Registrado'] . "</td>";    
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