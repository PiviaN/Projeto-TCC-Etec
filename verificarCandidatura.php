<?php
require_once 'banco-chamado.php';
require_once 'conexao.php';

session_start();
if ($_SESSION['log'] != "ativoTecnico") {
    session_destroy();
    header("location: pag_login.php");
}

$user = $_SESSION['nome'];
$idContrato = $_SESSION['id_contrato'];
$cpf = pegaCpfUsuarioLogado($conexao, $user);
if (verificaCandidatura($conexao, $cpf)) {
    ?>
    <script>
        var r = confirm("Você já esta em um chamado, cancele-o antes de entrar em outro");
        if (r === true) {
            window.location.assign("pag_menuTecnico.php");
        } else {
            window.location.assign("pag_menuTecnico.php");
        }
    </script>
    <?php
} else {

    candidatarSe($conexao, $cpf, $idContrato);
    mysqli_close($conexao);
    echo '<script> 
    var r = confirm("Candidatura feita com sucesso, espere pela aprovação do cliente.");
        if (r === true) {
            window.location.assign("pag_listar_chamados.php");
        } else {
            window.location.assign("pag_listar_chamados.php");
        }</script>';
}
?>
<script>
    function deuBom() {
        var r = confirm("Candidatura feita com sucesso, espere pela aprovação do cliente.");
        if (r === true) {
            window.location.assign("pag_menuTecnico.php");
        } else {
            window.location.assign("pag_menuTecnico.php");
        }
        function mouseClick(id) {
            var data = document.getElementById(id).value;
            window.location = "verificarCandidatura.php?data=" + data;
        }
    }
</script>





