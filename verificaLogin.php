<?php

include ("conexao.php");
include ("banco-login.php");
include ("banco-chamado.php");

if ($_POST) {
    $user = $_POST['txtu'];
    $senha = $_POST['txts'];
    session_start();

    if (efetuarLogin($conexao, $user, $senha)) {
        session_start();
        $_SESSION['nome'] = $user;
        $cpf = pegaCpfUsuarioLogado($conexao, $user);
        $_SESSION['tipoUsuario'] = pegaTipoUsuario($conexao, $cpf);
        mysqli_close($conexao);
        if ($_SESSION['tipoUsuario'] == 2) {
            $_SESSION['log'] = 'ativo';
            header("location: pag_contratosCli.php");
        } else {
            $_SESSION['log'] = 'ativoTecnico';
            header("location: pag_contratosTec.php");
        }
    } else {
        echo '<script> var r = confirm("Senha ou usuário incorreto!")
                            if (r === true) {
                                window.location.assign("index.php");                   
                            } else {
                                window.location.assign("index.php");
                            }
                            </script>';
    }
}

//if ($_POST["palavra"] == $_SESSION["palavra"]) {
//} else {
//        echo '<script>alert("Captcha errado!");'
//        . 'window.location = "index.html"</script> ';
//    }