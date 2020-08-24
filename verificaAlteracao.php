
<script>
    function deuBom() {
        alert("Dados alterados com sucesso");
    }
    function deuRuim() {
        alert("Falha ao atualizar");
    }

</script>
<?php

require_once 'conexao.php';
require_once 'banco-usuario.php';
require_once 'banco-chamado.php';

session_start();

mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');

$cpf = pegaCpfUsuarioLogado($conexao, $_SESSION['nome']);
$tipoUsuario = pegaTipoUsuario($conexao, $cpf);
$logradouro = ($_POST['txtlogra']);
$tel = ($_POST['txttel']);
$email = ($_POST['txtemail']);
$tipoTel = ($_POST['txttipo']);
$senha = ($_POST['txtsenha']);
$ddd = ($_POST['txtddd']);
$estado = ($_POST['txtestado']);
$bairro = ($_POST['txtbairro']);
$cep = ($_POST['txtcep']);
$cidade = ($_POST['txtcidade']);
$numCasa = ($_POST['txtnumCasa']);
$complemento = ($_POST['txtcomplemento']);
$nomeFoto = geraNovoNomeFoto();

if ($tipoUsuario == 1) {
    $instituicao = ($_POST['txtinst']);
    $curso = ($_POST['txtcurso']);
}

if ($tipoUsuario == 2) {
    if (alteraClienteUsuario($conexao, $cpf, $logradouro, $cep, $bairro, $cidade, $estado, $numCasa, $tel, $ddd, $complemento, $email, $senha, $tipoTel, $nomeFoto)) {
        echo '<script> deuBom() 
        window.location.href = "pag_perfil.php"; </script>';
        mysqli_close($conexao);
    } else {
//        echo '<script> deuRuim() 
//        window.location.href = "pag_perfil.php"</script>';
        mysqli_close($conexao);
    }
} else {
    if (alteraTecnicoUsuario($conexao, $cpf, $logradouro, $cep, $bairro, $cidade, $estado, $numCasa, $tel, $ddd, $complemento, $email, $senha, $tipoTel, $instituicao, $curso, $nomeFoto)) {


        echo '<script> deuBom() 
        window.location.href = "pag_perfilTec.php"; </script>';
        mysqli_close($conexao);
    } else {
//        echo '<script> deuRuim()
//        window.location.href = "pag_perfilTec.php"; </script>';
        mysqli_close($conexao);
    }
}
            
       
