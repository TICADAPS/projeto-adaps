<?php
include_once("../calendario-tutoria/conexao.php");
ini_set('memory_limit', '1024M');
set_time_limit(100);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>IBGE</th>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Data de início da tutoria</th>';
$html .= '<th>Data fim da tutoria</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

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