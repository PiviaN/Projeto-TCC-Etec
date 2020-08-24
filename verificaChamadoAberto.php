<?php

include("conexao.php");
include("verificaLogin.php");
require_once 'banco-chamado.php';

$nome = $_SESSION['nome'];
$cpf = pegaCpfUsuarioLogado($conexao, $nome);

if ($_SESSION['tipoUsuario'] == 2){
    
    $chamadoAberto = verificaChamadoAbertoCliente($conexao,$cpf);
    if($chamadoAberto>0){               
        header("Location: pag_cancelar_chamado.php");     
    } else {
        header("Location: pag_cadastrar_chamado.php");
    }           
} else {
    
    $chamadoAberto = verificaChamadoAbertoTecnico($conexao, $cpf);
    if($chamadoAberto>0){               
        header("Location: pag_cancelar_chamado.php");     
    } else {
        header("Location: pag_listar_chamados.php");
    }
}