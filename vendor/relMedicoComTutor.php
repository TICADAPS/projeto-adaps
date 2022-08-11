<?php
include_once("../escolha-tutoria/conexao.php");
ini_set('memory_limit', '1024M');
set_time_limit(200);

$html = '<table border=1>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>Bolsista</th>';
$html .= '<th>Estado</th>';
$html .= '<th>Município</th>';
$html .= '<th>Local Tutoria</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$result_transacoes = "select NomeMedico, UF, mun.Municipio as Municipio, m1.Municipio as Tutoria from medico me
	inner join estado est on me.Estado_idEstado = est.cod_uf
    inner join municipio mun on me.Municipio_id = mun.cod_munc
    inner join vaga_tutoria vt on vt.idMedico = me.idMedico
    inner join municipio m1 on m1.cod_munc = vt.opcao_escolhida
where me.idCargo = 1 and me.Convocacao <> 3 order by UF;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['Municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Tutoria'] . "</td>";
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
			<h1 style="text-align: center;">ADAPS - Relatório de bolsista com tutor</h1>
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