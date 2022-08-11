<?php

require_once dirname(__DIR__) . '/DAL/MedicoBolsistaDAO.php';

if(isset($_GET['cod_municipio'])):
    $cod_municipio = $_GET['cod_municipio'];
    $medBolsista = new MedicoBolsistaDAO();
    $objBols = $medBolsista->MedicoBolsista($cod_municipio);

    $html = "";
    $html .= "<p><h3>Médicos por ordem de escolha:</h3></p>";
    $html .= '<ol>';

    foreach($objBols as $medBol){

        $html .= '<li>'.$medBol['nome_medico'].'</li>';

    }
    $html .= '</ol>';
    echo json_encode($html);
endif;

