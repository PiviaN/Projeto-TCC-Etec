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
        if ($_SESSION['log'] != "ativoTecnico") {
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
        $cpfTec = pegaCpfUsuarioLogado($conexao, $user);
        $div = 'divid';
        $cont = 1;
        $notificacoes = listarNotificacaoTec($conexao, $cpfTec, 'cpf_tecnico', 'outros', null);

        foreach ($notificacoes as $notificacao):
            ?>
        <center>

            <?php
            // 

            if (!empty($notificacao['datareg'])) {
                echo '<div id="' . $div . $cont . '" class="visualizado" onclick="visualizarNt(' . $cont . ')">';
            } else {
                echo '<div id="' . $div . $cont . '" class="naovisualizado" onclick="visualizarNt(' . $cont . ')">';
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
                    if (($notificacao['estadoContrato'] != 'Em analise') && ($notificacao['estadoContrato'] != 'ConfirmadoTecnico')) {
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
                            echo 'Confirmado!';
                        } else if ($notificacao['estadoContrato'] === 'Confirmado') {
                            echo 'Cliente confirmou contrato!';
                        }
                        ?></td>
                    <td><a href="pag_perfilAbertoCli.php">Visitar</a></td>
                    <td><a href="" onclick="cancelar(<?PHP echo $cont ?>); return false;">Cancelar</a></td>
                    <?php
                    if (($notificacao['estadoContrato'] != 'Em analise') && ($notificacao['estadoContrato'] != 'ConfirmadoTecnico')) {
                        echo '<td><a href="" onclick="atualizar(' . $cont . '); return false;">Confirmar</a></td>';
                    }
                    if (empty($notificacao['datareg'])) {
                        echo '<td>Não visualizado</td>';
                    } else {
                        echo '<td> ' . $notificacao['datareg'] . ' </td>';
                    }
                    $_SESSION['idContrato' . $cont] = $notificacao['id_contrato'];
                    $_SESSION['cpfCli' . $cont] = $notificacao['cpf_cliente'];
                    $cont++;
                    ?>
                </tr>
            </table>

            <?php
        endforeach;

        if (isset($_GET['estado'])) {
            $estadoContrato = $_GET['estado'];
            list($estadoContrato, $contId) = explode("/", $estadoContrato);
            if (!empty($estadoContrato)) {
                if ($estadoContrato == 'conf') {
                    atualizarEstadoContratoTec($conexao, $_SESSION['cpfCli' . $contId], $cpfTec, $estadoContrato);
                    echo '<script> var r = confirm("Comparecimento confirmado, fique atento a data confirmada!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                    unset($estadoContrato);
                    mysqli_close($conexao);
                } else if ($estadoContrato == 'cancel') {
                    atualizarEstadoContratoTec($conexao, $_SESSION['cpfCli' . $contId], $cpfTec, $estadoContrato, $_SESSION['idContrato' . $contId]);
                    echo '<script> var r = confirm("Cancelado!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                    unset($estadoContrato);
                    mysqli_close($conexao);
                } else if ($estadoContrato === 'visu') {
                    atualizarEstadoNot($conexao, $_SESSION['idContrato' . $contId], 'tec');
                    echo '<script> var r = confirm("Visualizado!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            } else {
                echo '<script>alert("Erro ao confirmar")</script>';
                unset($estadoContrato);
            }
        }
        ?>
        <script>
            function atualizar(id) {
                var estadoCont = "conf";
                window.location = "pag_notificacaoTec.php?estado=" + estadoCont + "/" + id;
                event.stopPropagation();
            }
            function cancelar(id) {
                var estadoCont = "cancel";
                window.location = "pag_notificacaoTec.php?estado=" + estadoCont + "/" + id;
                event.stopPropagation();
            }
            function visualizarNt(cont) {
                window.location = "pag_notificacaoTec.php?estado=visu" + "/" + cont;
                event.stopPropagation();
            }
        </script>
    </body>
</html>
