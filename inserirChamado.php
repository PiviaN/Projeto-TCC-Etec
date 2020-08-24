<?php

include("conexao.php");
include("banco-usuario.php");
require_once './banco-chamado.php';
header('Content-Type: text/html; charset=utf-8');

session_start();

$nomeUser = $_SESSION['nome'];
$cpf_cliente = pegaCpfUsuarioLogado($conexao, $nomeUser);

$detalhes = "";

if ($_POST['cbProblema'] != 0) {
    $op = $_POST['cbProblema'];
    $detalhes = pegarProblema($op);
    $data_acertada = ($_POST['txtDat']);
} else if ($_POST['cbProblema']) {
    $detalhes = ($_POST['txtDesc']);
    $data_acertada = ($_POST['txtDat']);
}



if (InserirChamadoCliente($conexao, $data_acertada, $detalhes, $cpf_cliente)) {
    $_SESSION['log'] = 'ativo';
    echo '<script> var r = confirm("Chamado realizado com sucesso, aguarde um técnico!");
          if (r == true){
            window.location = "pag_contratosCli.php"
          } else {
            window.location = "pag_contratosCli.php"
          }</script>';
} else {
    $msg = mysqli_errno($conexao);
    echo '<script> var r = confirm("Cadastro de chamado inválido! Não inseriu algo errado?");
          if (r == true){
            window.location = "pag_cadastrar_chamado.php"
          } else {
            window.location = "pag_cadastrar_chamado.php"
          }</script>';
}

//function calcularData($dataescolhida, $dataatual) {
//    $diacom30 = array(null, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30);
//    $diacom31 = array(null, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30);
//    $diacom28 = array(null, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28);
//    $aux = 0;
//    $aux2 = 1;
//    list($anoe, $mese, $diae) = explode("-", $dataescolhida);
//    list($anoa, $mesa, $diaa) = explode("-", $dataatual);
//
//    if ($mese == 02) {
//        $dia = $diacom28;
//    } else if ($mese % 2 == 0) {
//        $dia = $diacom30;
//    } else {
//        $dia = $diacom31;
//    }
//
//    if ($anoe == $anoa) {
//        // while ($aux != 1) {
//            if ($diae ) {
//                
//                $aux++;
//            }
//            $aux2++;
//        }
////        if($diae < $diae){
////            echo 'Data inválida';
////        }
//    } else {
//        echo 'Data inválida!';
//    }
//}
