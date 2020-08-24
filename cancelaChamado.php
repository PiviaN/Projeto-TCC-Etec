<?php

        include("banco-chamado.php");
        include("conexao.php");
        $nome = $_SESSION['nome'];
        $opcao = $_POST['rb'];
        $cpf = pegaCpfUsuarioLogado($conexao, $nome);
        
    if($_SESSION['tipodeUsuario'] == 2){
            
        if($opcao == "sim"){
            cancelaChamadoCliente($conexao, $cpf);
            mysqli_close(); 
            header("Location: pag_contratosCli.php");
            $_session['msgChamado'] = "Chamado cancelado!";
        } else {
            mysqli_close(); 
            header("Location: pag_contratosCli.php");
        }
        
    } else {
            
        if($opcao == "sim"){
            cancelaChamadoTecnico($conexao, $cpf);
            mysqli_close(); 
            header("Location: pag_contratosTec.php");
            $_session['msgChamado'] = "Chamado cancelado!";
        } else {
            mysqli_close(); 
            header("Location: pag_contratosTec.php");
        }
        
    }
        ?>