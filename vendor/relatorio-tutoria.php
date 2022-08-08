<?php
include_once("../calendario-tutoria/conexao.php");
ini_set('memory_limit', '1024M');
set_time_limit(100);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Tutor</th>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Data inicial da tutoria</th>';
$html .= '<th>Data final da Tutoria</th>';
$html .= '<th>Nº da convocação do médico bolsista</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

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

$html .= '</tbody>';
$html .= '</table';

//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
require_once("./autoload.php");

//Criando a Instancia
$dompdf = new DOMPDF();
$dompdf->setPaper('A3', 'landscape'); //Paisagem
// Carrega seu HTML
$dompdf->load_html('
			<h1 style="text-align: center;">ADAPS - Relatório Calendário de tutoria</h1>
			' . $html . '
		');

//Renderizar o html
$dompdf->render();

//Exibibir a página
$dompdf->stream(
    "relatorio_adaps.pdf", array(
        "Attachment" => false //Para realizar o download somente alterar para true
    )
);
?>