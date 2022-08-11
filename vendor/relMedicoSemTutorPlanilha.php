<?php
include_once("../conexao.php");
ini_set('memory_limit', '4096M');
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
$arquivo = 'RelatorioMedicoSemTutor.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="9">ADAPS - Relatorio de Medico Sem Tutor</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th>CPF</th>';
$html .= '<th>UF</th>';
$html .= '<th>Código</th>';
$html .= '<th>1 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>2 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>3 Opção</th>';
$html .= '</tr>';

$result_transacoes = "SELECT nome_medico,cpf_medico,est.UF as UF, lv.primeira_opc as 'opcao1',m1.Municipio as 'op1',
lv.segunda_opc as 'opcao2', m2.Municipio as 'op2',lv.terceira_opc as 'opcao3', m3.Municipio as 'op3' 
FROM medico_bolsista mb 
    INNER JOIN log_vaga as lv on lv.idMedico = mb.idMedico 
    INNER JOIN municipio as m1 on m1.cod_munc = lv.primeira_opc 
    INNER JOIN municipio as m2 on m2.cod_munc = lv.segunda_opc 
    INNER JOIN municipio as m3 on m3.cod_munc = lv.terceira_opc 
    INNER JOIN estado as est on est.cod_uf = m1.Estado_cod_uf 
    LEFT JOIN vaga_tutoria vt on lv.idMedico = vt.idMedico 
WHERE vt.opcao_escolhida is null order by est.UF, m1.municipio, nome_medico;";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['nome_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['cpf_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao1'] . "</td>";
    $html .= '<td>' . $row_transacoes['op1'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao2'] . "</td>";
    $html .= '<td>' . $row_transacoes['op2'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao3'] . "</td>";
    $html .= '<td>' . $row_transacoes['op3'] . "</td>";

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