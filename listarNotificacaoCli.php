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

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $_SESSION['id'] = $id;
            if (empty($_SESSION['idDados' . $id][0])) {
                $cont = $_SESSION['idContrato'];
                $_SESSION['cpfTecProcurado'] = $_SESSION['cpfTec'];
            } else {
                $cont = $id;
                $_SESSION['idContrato'] = $_SESSION['idDados' . $id][0];
                $_SESSION['cpfTec'] = $_SESSION['idDados' . $id][1];
                $_SESSION['cpfTecProcurado'] = $_SESSION['cpfTec'];
            }
        }

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
        $notificacoes = listarNotificacaoCli($conexao, $cpfCli, 'cpf_cliente', $_SESSION['idContrato'], 'id');
        foreach ($notificacoes as $notificacao):
            ?>    

        <center>

            <?php
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
                    <td>Estado do contrato</td>
                    <td>Perfil</td>
                    <td>Cancelar</td>
                    <?php
                    if ($notificacao['estadoContrato'] != 'ConfirmadoTecnico') {
                        echo '<td>Atualizar</td>';
                    }
                    ?>
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
                    <td><a href="" onclick="cancelar(); return false;">Cancelar</a></td>
                    <?php
                    if ($notificacao['estadoContrato'] != 'ConfirmadoTecnico') {
                        echo '<td><a href="" onclick="atualizar(); return false;">Confirmar</a></td>';
                    }
                    $_SESSION['cpfTec' . $cont] = $notificacao['cpf_tecnico'];
                    $_SESSION['idContrato' . $cont] = $notificacao['id_contrato'];
                    ?>
                </tr>
            </table>
            <?php
            $cont++;
            echo '</div>'
            ?></center>
        <?php
    endforeach;

    if (isset($_GET['estado'])) {
        $estadoContrato = $_GET['estado'];
        if (!empty($estadoContrato)) {
            if ($estadoContrato === 'conf') {
                if (atualizarEstadoContratoCli($conexao, $cpfCli, $_SESSION['cpfTec'], $estadoContrato)) {
                    echo '<script> var r = confirm("Aguarde pela confirmação do técnico!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                } else {
                    echo '<script> var r = confirm("Erro ao confirmar!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            } else if ($estadoContrato === 'cancel') {
                if (atualizarEstadoContratoCli($conexao, $cpfCli, $_SESSION['cpfTec'], $estadoContrato, $_SESSION['idContrato'])) {
                    echo '<script> var r = confirm("Cancelado! Aguarde outro técnico candidatar-se!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                } else {
                    echo '<script> var r = confirm("Falha ao cancelar!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            } else {
                if (atualizarEstadoNot($conexao, $_SESSION['idContrato'], null)) {
                    echo '<script> var r = confirm("Visualizado!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                } else {
                    echo '<script> var r = confirm("Erro!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                    unset($_SESSION['idContrato']);
                    unset($_SESSION['cpfTec']);
                    unset($id);
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            }
        } else {
            echo '<script>alert("Erro")</script>';
            unset($valorVoto);
        }
    }
    ?>
    <script>
        function atualizar() {
            var estadoCont = "conf";
            window.location = "listarNotificacaoCli.php?id=" +<?php echo $_SESSION['id']; ?> + "&estado=" + estadoCont;
            event.stopPropagation();
        }
        function cancelar() {
            var estadoCont = "cancel";
            window.location = "listarNotificacaoCli.php?id=" +<?php echo $_SESSION['id'];; ?> + "&estado=" + estadoCont;
            event.stopPropagation();
        }
        function visualizarNt(cont) {
            window.location = "listarNotificacaoCli.php?id=" +<?php echo $_SESSION['id']; ?> + "&estado=" + cont;

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
            background-color: blue;               
        }

    </style>
</body>
</html>

