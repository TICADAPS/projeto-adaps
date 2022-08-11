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
$arquivo = 'RelatorioVagaRemanescente.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="4">ADAPS - Relatório de Vagas Remanescentes</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>UF</th>';
$html .= '<th>Município</th>';
$html .= '<th>Tutor</th>';
$html .= '<th>Qntd de Vaga</th>';
$html .= '</tr>';

$result_transacoes = "SELECT UF, municipio, m.NomeMedico as Tutor, vaga_tutor as vaga 
FROM tutor_municipio tm 
    INNER JOIN estado e ON e.cod_uf = tm.codUf 
    INNER JOIN medico m ON m.idMedico = tm.idTutor 
WHERE m.idCargo = 2 AND vaga_tutor > 0 ORDER BY UF;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['municipio'] . "</td>";
    $html .= '<td>' . $row_transacoes['Tutor'] . "</td>";
    $html .= '<td>' . $row_transacoes['vaga'] . "</td>";
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