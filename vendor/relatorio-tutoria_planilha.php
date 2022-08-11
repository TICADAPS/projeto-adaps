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
$arquivo = 'relatorioTutoriaPlanilha.xlsx';
$html = '<table border=1>';
$html .= '<tr>';
$html .= '<th colspan="5">Relatório de Tutoria</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Tutor</th>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Data inicial da tutoria</th>';
$html .= '<th>Data final da Tutoria</th>';
$html .= '<th>Chamada</th>';
$html .= '</tr>';


$result_transacoes = "select m2.NomeMedico as tutor ,med.NomeMedico as bolsista,ct.PeriodoInicial,ct.PeriodoFinal,med.Convocacao
	from medico med
        inner join ControleCalendario cc on med.idMedico = cc.idMedico
        inner join CalendarioTutoria ct on cc.idCalendario = ct.idCalendario
        inner join vaga_tutoria vt on vt.idMedico = cc.idMedico
        inner join medico m2 on m2.idMedico = vt.idTutor        
        order by m2.NomeMedico, med.NomeMedico;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['bolsista'] . "</td>";
    $html .= '<td>' . $row_transacoes['PeriodoInicial'] . "</td>";
    $html .= '<td>' . $row_transacoes['PeriodoFinal'] . "</td>";
    $html .= '<td>' . $row_transacoes['Convocacao'] . "</td>";    
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