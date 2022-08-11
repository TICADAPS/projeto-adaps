<?php

require_once dirname(__DIR__) . '/DAL/MunicipioDAO.php';

if(isset($_GET['cod_estado'])):
    $cod_estado = $_GET['cod_estado'];
    $municipio = new MunicipioDAO();
    $objMun = $municipio->Municipio($cod_estado);

    $html = "";

    $html .= '<label for="slMunicipio">Municipio:</label>';
    $html .= '<select id="municipio" name="slMunicipio" class="form-control form-control-lg" onchange="UfBolsista()">';
    foreach($objMun as $municip){
        $html .= '<option value="'.$municip['cod_munc'].'">'.$municip['Municipio'].'</option>';
    }
    $html .= '</select>';
    echo json_encode($html);
endif;