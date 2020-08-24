<?php

session_start();
if ($_SESSION['log'] != "ativo") {
    session_destroy();
    header("location: pag_login.php");
}
$i = 1;
//while ($i <= $cont){
//    if($_SESSION['idContrato'.$i]){
//        
//    }
//
//}
//$aa  = $_SESSION['id_contrato_notif'];
echo $cont;