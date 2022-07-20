<?php
function kilometragem($o, $d){
    $origem = str_replace(" ", "%20", $o);
    $destino = str_replace(" ", "%20", $d);
    $link = "https://maps.googleapis.com/maps/api/distancematrix/xml?origins=$origem&destinations=$destino&mode=driving&language=pt-BR&sensor=false&key=AIzaSyAK_RhiP5TiLfA3qK4mBCMGby2yjS_a4is";
    $novolink = curl_init();
    curl_setopt($novolink, CURLOPT_URL, "$link");
    curl_setopt($novolink, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($novolink, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($novolink, CURLOPT_MAXCONNECTS, 10);
    curl_setopt($novolink, CURLOPT_TIMEOUT, 5);
    $output = curl_exec($novolink);
    //var_dump($output);
    curl_close($novolink);

    $output = str_replace("\n", " ", $output);

    preg_match_all("/<origin_address>(.*?)<\/origin_address>/", $output, $a); //origem

    preg_match_all("/<destination_address>(.*?)<\/destination_address>/", $output, $b); //destino

    preg_match_all("/<duration>(.*?)<\/duration>/", $output, $c0);
    preg_match_all("/<text>(.*?)<\/text>/", $c0[1][0], $c);  //duracao

    preg_match_all("/<distance>(.*?)<\/distance>/", $output, $d0);
    preg_match_all("/<text>(.*?)<\/text>/", $d0[1][0], $d);  //distancia
    $orig = $a[1][0];
    $destn = $b[1][0];
    $distanc = $d[1][0];
    $duracion = $c[1][0];
    if(str_contains($distanc, "k")){
        $distanc = str_replace(" ", "", $distanc);
        $distanc = str_replace("km", "", $distanc);
        $distanc = str_replace(",", ".", $distanc);
    }else{
        $distanc = 0.00;
    }
    
    return $distanc;
}
