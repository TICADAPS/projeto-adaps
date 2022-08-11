<?php
include_once("../escolha-tutoria/conexao.php");
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
$arquivo = 'RelatorioPedidoTutoria.xlsx';

$html = '<table border="1">';
$html .= '<tr>';
$html .= '<th colspan="13">ADAPS - Relatório de Pedido de Tutoria</th>';
$html .= '</tr>';
$html .= '<tr>';
$html .= '<th>Médico Bolsista</th>';
$html .= '<th>CPF</th>';
$html .= '<th>UF</th>';
$html .= '<th>Código</th>';
$html .= '<th>Opção Escolhida</th>';
$html .= '<th>Código</th>';
$html .= '<th>1 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>2 Opção</th>';
$html .= '<th>Código</th>';
$html .= '<th>3 Opção</th>';
$html .= '<th>Tutor</th>';
$html .= '<th>Qntd Vaga</th>';
$html .= '</tr>';

$result_transacoes = "SELECT 
    distinct nome_medico,
    cpf_medico,
    est.UF, 
    opcao_escolhida,
    tm.municipio as 'escolhida', 
    opcao1, m1.Municipio as 'op1',
    opcao2, m2.Municipio as 'op2',
    opcao3, m3.Municipio as 'op3',
    NomeMedico,vaga_tutor 
FROM vaga_tutoria vt
	INNER JOIN medico_bolsista mb 
    	on mb.idMedico = vt.idMedico
	INNER JOIN tutor_municipio tm 
    	on tm.idTutor = vt.idTutor
	INNER JOIN medico m 
    	on m.idMedico = tm.idTutor
    INNER JOIN municipio as m1
    	on m1.cod_munc = vt.opcao1
     INNER JOIN municipio as m2
    	on m2.cod_munc = vt.opcao2
      INNER JOIN municipio as m3
    	on m3.cod_munc = vt.opcao3
      INNER JOIN estado as est
      	on est.cod_uf = tm.codUf
order by est.UF, tm.municipio, nome_medico";

$resultado_trasacoes = mysqli_query($conn, $result_transacoes);
while ($row_transacoes = mysqli_fetch_assoc($resultado_trasacoes)) {
    $html .= '<tr>';
    $html .= '<td>' . $row_transacoes['nome_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['cpf_medico'] . "</td>";
    $html .= '<td>' . $row_transacoes['UF'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao_escolhida'] . "</td>";
    $html .= '<td>' . $row_transacoes['escolhida'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao1'] . "</td>";
    $html .= '<td>' . $row_transacoes['op1'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao2'] . "</td>";
    $html .= '<td>' . $row_transacoes['op2'] . "</td>";
    $html .= '<td>' . $row_transacoes['opcao3'] . "</td>";
    $html .= '<td>' . $row_transacoes['op3'] . "</td>";
    $html .= '<td>' . $row_transacoes['NomeMedico'] . "</td>";
    $html .= '<td>' . $row_transacoes['vaga_tutor'] . "</td>";
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