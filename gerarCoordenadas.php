<?php

//$coord = gerarCoordenadas("Rua azulão, Cotia - SP");
//echo $coord[0]."<br>";
//echo $coord[1];

require_once './banco-chamado.php';

function gerarCoordenadas($addr) {
    // $geo = array();
    // $addr = "Rua Paulo Guimarães, São Paulo - SP"; // Pega parâmetro
    $addr = str_replace(" ", "+", $addr); // Substitui os espaços por + "Rua+Paulo+Guimarães,+São+Paulo+-+SP" conforme padrão 'maps.google.com'
    $address = utf8_encode($addr); // Codifica para UTF-8 para não dar 'pau' no envio do parâmetro
    // Daqui em diante é o seu código original
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
    $output = json_decode($geocode);
    $lat = $output->results[0]->geometry->location->lat; // latitude
    $long = $output->results[0]->geometry->location->lng; // longitude

    return $coordenadas = array($lat, $long);
}

//$geo['lat'] = $lat;
//$geo['long'] = $long;
//echo "<pre> Latitude: ";
//print_r($geo['lat']);
//echo "<br /> Longitude: ";
//print_r($geo['long']);
// echo "<br /><br /> Resultado completo JSON: <br /><br />";
// print_r($output);
//POINT(-23.5990514 -46.912299)'

function calcularDistancia($conexao, $cpf) {
    // busca a coord do usuário logado
    $sql1 = "select ST_AsText(coordenadas) as coord from tbl_endereco where cpf_usuario = $cpf";
    $resultado1 = mysqli_query($conexao, $sql1);
    $coordLog = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
    // lista todas as coordenadas
    $tecnicos = listarTecnico($conexao, $cpf);
    // limpa a coordenada do usuário logado
    $coordLog = limparCoordenada($coordLog['coord']);

    foreach ($tecnicos as $tecnico):
        // limpa a coord que veio do tecnico
        $coordProc = limparCoordenada($tecnico['coord']);
        $distancia = calcDistancia($coordLog[0], $coordLog[1], $coordProc[0], $coordProc[1], "k");
        $_SESSION['d' . $tecnico['cpf']] = $distancia;
    endforeach;
    return $tecnicos;
}

function limparCoordenada($addr) {
    $itemsLimpar = array("POINT(", ")");
    $addr = str_replace($itemsLimpar, "", $addr);
    $coordLimpa = explode(" ", $addr);
    return $coordLimpa;
}

function calcDistancia($lat1, $lon1, $lat2, $lon2, $unidade) {

    if ($lat1 && $lon1 && $lat2 && $lon2) {
        $distancia = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1 - $lon2));
        $distancia = acos($distancia);
        $distancia = rad2deg($distancia);
        $milhas = $distancia * 60 * 1.1515;
        $unidade = strtoupper($unidade);

        if ($unidade == "K") {
            $dist = number_format($milhas * 1.609344, 1);
            $dist = str_replace(".", ",", $dist);
            // echo $dist."/";
            return $dist;
        } else if ($unidade == "N") {
            return ($milhas * 0.8684);
        } else {
            return $milhas;
        }
    } else {
        return 'Não foi possível calcular!';
    }
    // echo calcDistancia(32.9697, -96.80322, 29.46786, -98.53506, "k")." quilômetros";
}

function listarTecnico($conexao, $cpf) {
    $tecnicos = array();
    $sql2 = "select * from listarTecnico where cpf <> $cpf and id_tp_usuario = 1";
    $resultado2 = mysqli_query($conexao, $sql2);
    while ($tecnico = mysqli_fetch_assoc($resultado2)) {
        array_push($tecnicos, $tecnico);
    }
    return $tecnicos;
}

function listarPorCidade($conexao, $cpf) {
    $sql1 = "select cidade from tbl_endereco where cpf = $cpf";
    $resultado1 = mysqli_query($conexao, $sql1);
    $row = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
    $cidade = $row['cidade'];

    $tecnicos = array();
    $sql2 = "select * from listarTecnico where cpf <> $cpf and id_tp_usuario = 1 and cidade = $cidade";
    $resultado2 = mysqli_query($conexao, $sql2);
    while ($tecnico = mysqli_fetch_assoc($resultado2)) {
        array_push($tecnicos, $tecnico);
    }
    return $tecnicos;
}

function puxarCoordUserLog($conexao, $cpf, $coord) {
    $sql = "select ST_AsText(coordenadas) as coord from tbl_endereco where cpf_usuario = $cpf";
    $resultado1 = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
    $minhaCoord = $row['coord'];
    $minhaCoord = limparCoordenada($minhaCoord);
    $coord = limparCoordenada($coord);
    $distanciaFinal = calcDistancia($minhaCoord[0], $minhaCoord[1], $coord[0], $coord[1], 'k');
    return $distanciaFinal;
}

function calcularDistanciaChamadoLugar($conexao, $cpf) {
    // busca a coord do usuário logado
    $sql1 = "select ST_AsText(coordenadas) as coord from tbl_endereco where cpf_usuario = $cpf";
    $resultado1 = mysqli_query($conexao, $sql1);
    $coordLog = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
    // lista todas as coordenadas
    $chamados = listarChamadosDistancia($conexao);
    // limpa a coordenada do usuário logado
    $coordLog = limparCoordenada($coordLog['coord']);

    foreach ($chamados as $chamado):
        // limpa a coord que veio do tecnico
        $coordProc = limparCoordenada($chamado['coord']);
        $distancia = calcDistancia($coordLog[0], $coordLog[1], $coordProc[0], $coordProc[1], "k");
        $_SESSION['d'.$chamado['cpf_cli']] = $distancia;
    endforeach;
    return $chamados;
}