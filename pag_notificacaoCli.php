<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        if ($_SESSION['log'] != "ativo") {
            session_destroy();
            header("location: index.php");
        }
        require_once 'banco-usuario.php';
        require_once 'banco-chamado.php';
        require_once 'conexao.php';
        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');
        $user = $_SESSION['nome'];
        $cpfCli = pegaCpfUsuarioLogado($conexao, $user);
        $div = 'divid';
        $cont = 1;
        $notificacoes = listarNotificacaoCli($conexao, $cpfCli, 'cpf_cliente', 'outros', null);
        foreach ($notificacoes as $notificacao):
            ?>    

        <center>

            <?php
                if (!empty($notificacao['datareg'])) {
                    echo '<div id="' . $div . $cont . '" class="visualizado" onclick="visualizarNt(' . $cont . ')">';
                } else {
                    echo '<div id="' . $div . $cont . '" class="naovisualizado" onclick="visualizarNt(' . $cont . ')" >';
                }
                ?>       
                <table border = "1">

                    <tr>
                        <td>Foto</td>
                        <td>Nome</td>
                        <td>Sobrenome</td>
                        <td>Detalhes</td>
                        <td>Data esperada</td>
                        <td>Estado</td>
                        <td>Perfil</td>
                        <td>Cancelar</td>
                        <?php
                        if (($notificacao['estadoContrato'] != 'ConfirmadoTecnico') && ($notificacao['estadoContrato'] != 'Confirmado')) {
                            echo '<td>Atualizar</td>';
                        }
                        ?>
                        <td>Visualizado em:</td>
                    </tr>   
                    <tr>
                        <td><img src="<?php echo $notificacao['foto'] ?>" width="40px" height="40px"</td>
                        <td><?php echo $notificacao['nome'] ?></td>
                        <td><?php echo $notificacao['sobrenome'] ?></td>
                        <td><?php echo $notificacao['detalhes'] ?></td>                    
                        <td><?php echo $notificacao['data_acertada'] ?></td>
                        <td><?php
                            if ($notificacao['estadoContrato'] === 'Em analise') {
                                echo 'Esperando aprovação';
                            } else if ($notificacao['estadoContrato'] === 'ConfirmadoTecnico') {
                                echo 'Presença do Técnico confirmada!';
                            } else if ($notificacao['estadoContrato'] === 'Confirmado') {
                                echo 'Confirmado!';
                            }
                            ?></td>
                        <td><a href="pag_perfilAbertoTec.php">Visitar</a></td>
                        <td><a href="" onclick="cancelar(<?PHP echo $cont ?>); return false;">Cancelar</a></td>
                        <?php
                        if (($notificacao['estadoContrato'] != 'ConfirmadoTecnico') && ($notificacao['estadoContrato'] != 'Confirmado')) {
                            echo '<td><a href="" onclick="atualizar('.$cont.'); return false;">Confirmar</a></td>';
                        }
                        if (empty($notificacao['datareg'])){
                            echo '<td>Não visualizado</td>';
                        } else {
                            echo '<td> '.$notificacao['datareg'].' </td>';
                        }
                        $_SESSION['cpf_tec' . $cont] = $notificacao['cpf_tecnico'];
                        $_SESSION['cpfTecProcurado'] = $notificacao['cpf_tecnico'];
                        $_SESSION['idContrato' . $cont] = $notificacao['id_contrato'];
                        ?>

                    </tr>
                </table>
                <?php $cont++; ?>
            </div></center>
        <?php
    
endforeach;

if (isset($_GET['estado'])) {
    $estadoContrato = $_GET['estado'];
    list($estadoContrato, $contId) = explode("/", $estadoContrato);
    if (!empty($estadoContrato)) {
        if ($estadoContrato == 'conf') {
            atualizarEstadoContratoCli($conexao, $cpfCli, $_SESSION['cpf_tec'.$contId], $estadoContrato);
            echo '<script> var r = confirm("Aguarde pela confirmação do técnico!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
            unset($estadoContrato);
            mysqli_close($conexao);
        } else if ($estadoContrato === 'cancel') {
            atualizarEstadoContratoCli($conexao, $cpfCli, $_SESSION['cpf_tec'.$contId], $estadoContrato, $_SESSION['idContrato'.$contId]);           
            echo '<script> var r = confirm("Cancelado! Aguarde outro técnico candidatar-se!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
            unset($estadoContrato);
            mysqli_close($conexao);
        } else if ($estadoContrato === 'visu'){
            atualizarEstadoNot($conexao, $_SESSION['idContrato'.$contId], null);
            echo '<script> var r = confirm("Visualizado!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
            unset($estadoContrato);
            mysqli_close($conexao);
        }
    } else {
        echo '<script>alert("Erro")</script>';
        unset($valorVoto);
    }
}
?>
<script>
    function atualizar(id) {
        var estadoCont = "conf";
        window.location = "pag_notificacaoCli.php?estado=" + estadoCont + "/" + id;
        event.stopPropagation();
    }

    function cancelar(id) {
        var estadoCont = "cancel";
        window.location = "pag_notificacaoCli.php?estado=" + estadoCont + "/" + id;
        event.stopPropagation();
    }
    function visualizarNt(cont) {
        window.location = "pag_notificacaoCli.php?estado=visu" + "/"+ cont;
        event.stopPropagation();
    }
</script>

<style type="text/css"> 
    .visualizado
    {
        width: 800px; 
        height: 100px;
        background-color: white;               
    }
    .naovisualizado
    {
        width: 800px; 
        height: 100px;
        background-color: lightgrey;               
    }

</style>
</body>
</html>
