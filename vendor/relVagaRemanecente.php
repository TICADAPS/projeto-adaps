<?php
include_once("../escolha-tutoria/conexao.php");
ini_set('memory_limit', '1024M');
set_time_limit(200);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>Tutor</th>';
$html .= '<th>Qntd de Vaga</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "SELECT UF, municipio, m.NomeMedico as Tutor, vaga_tutor as vaga 
FROM tutor_municipio tm 
    INNER JOIN estado e ON e.cod_uf = tm.codUf 
    INNER JOIN medico m ON m.idMedico = tm.idTutor 
WHERE vaga_tutor > 0 ORDER BY UF;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['vaga'] . "</td>";
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
$dompdf->setPaper('A4', 'landscape'); //Paisagem
// Carrega seu HTML
$dompdf->load_html('
			<h1 style="text-align: center;">ADAPS - Relatório de vagas remanescente</h1>
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