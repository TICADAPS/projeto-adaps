<?php
require_once dirname(__DIR__) . '/DAL/MedicoBolsistaDAO.php';

if(isset($_GET['cod_tutor'])):
    $cod_tutor = $_GET['cod_tutor'];
    $medBolsista = new MedicoBolsistaDAO();
    $objBols = $medBolsista->MedicoBolsista2($cod_tutor);

    $html = "";
    $html .= "<p><h3>Médicos Bolsistas:</h3></p>";
    $html .= '<ol>';

    foreach($objBols as $medBol){
        $html .= '<li>'.$medBol['nome_medico'].'</li>';

    }
    $html .= '</ol>';
    echo json_encode($html);
endif;