<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link  href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/main-page.css">
        <script src="dist/js/jquery.min.js"></script>
        <script src="dist/js/bootstrap.min.js"></script>
        <link rel="icon" href="Images/logo.png" type="image/x-icon" />
        <title>TecFind - Contratos</title>
    </head>
    <body>
        <nav class="navbar navbar-default fundo">

            <div class="navbar-header">

                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-principal" aria-expanded="false">

                    <span class="sr-only">Alternar Navegação</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <img class="navbar-brand" src="Images/computer.png">
            </div>
            <div class="collapse navbar-collapse" id="navbar-principal">

                <ul class="nav navbar-nav navbar-right">
                    <li class="active p-small"><a href="pag_contratosTec.php">Contratos</a>
                        <?php
                        //Esse código cria uma sessão chamada verifica com o valor ativo
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_perfilTec.php">Meu Perfil</a>
                        <?php
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_listar_chamados.php">Chamados</a>
                        <?php
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_mensagens.php">Conversas</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    <li class="p-small"><a href="logout.php">Sair

                        </a>

                    </li>
                </ul>

            </div>

        </nav>
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
        $cpfCli = pegaCpfUsuarioLogado($conexao, $user);
        $div = 'divid';
        $cont = 1;
        $notificacoes = listarNotificacaoTec($conexao, $cpfCli, 'cpf_tecnico', 'outros', null);
        
        $aux = 0;
        
        foreach ($notificacoes as $notificacao):
            if ($notificacao['estadoContrato'] == 'Apagado'){
                $aux++;
            }
        endforeach;
        
        if ( (!empty($notificacoes)) && ($aux == 0) ) {
            foreach ($notificacoes as $notificacao):
                ?>    

                <?php
                if (($notificacao['estadoContrato'] != 'Apagado') && ($notificacao['estadoContrato'] != null)) {
                    echo '<div id="' . $div . $cont . '" >';
                    ?>       
                    <div class="row col-centered">
                        <div class="col-md-5 col-centered">
                            <div class="well">
                                <h1 class="text-center"><img class="rounded" width="50%" height="22%" src="<?php echo $notificacao['foto'] ?>"></h1>
                                <p class="h1-small text-center"><?php echo $notificacao['nome'] ?> <?php echo $notificacao['sobrenome'] ?></p>
                                <div class="well" style="background-color: white">
                                    <p class="p-small">Detalhes do Problema: <?php echo $notificacao['detalhes'] ?></p>
                                    <p class="p-small">Data esperada: <?php echo $notificacao['data_acertada'] ?></p>
                                    <p class="p-small">Estado: <?php
                                        if ($notificacao['estadoContrato'] === 'Em analise') {
                                            echo 'Esperando aprovação';
                                        } else if ($notificacao['estadoContrato'] === 'ConfirmadoTecnico') {
                                            echo 'Confirmado!';
                                        } else if ($notificacao['estadoContrato'] === 'Confirmado') {
                                            echo 'Confirmado!';
                                        } else if ($notificacao['estadoContrato'] === 'Finalizado') {
                                            echo 'Finalizado!';
                                        }
                                        ?>
                                </div>
                                <div class="text-center">
                                    <a href="pag_perfilAbertoCli.php"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="Ver Perfil" /></a>
                                    <?php
                                        if( ($notificacao['estadoContrato'] == 'Confirmado') || ($notificacao['estadoContrato'] == 'ConfirmadoTecnico') ){
                                            $vlrBtn = NULL;
                                            if($notificacao['estadoContrato'] == 'Confirmado'){
                                                $vlrBtn = 'Confirmar';
                                            } else {
                                                $vlrBtn = 'Finalizar';
                                            }
                                            echo '<a href="" onclick="atualizarContrato('. $cont .'); return false;"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="'. $vlrBtn .'" /></a>';
                                        }
                                    ?>
                                    <a href="" onclick="apagarContrato(<?PHP echo $cont ?>); return false;"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="Excluir" /></a>
                                </div>
                                <?php
                                $_SESSION['cpf_tec' . $cont] = $notificacao['cpf_tecnico'];
                                $_SESSION['cpf_perfilCliente'] = $notificacao['cpf_cliente'];
                                $_SESSION['idContrato' . $cont] = $notificacao['id_contrato'];
                                $_SESSION['abrirPerfilCliente'] = 'contratos';
                                ?>

                                <?php $cont++; ?>
                            </div>
                        </div>

                        <?php
                    }
                endforeach;
            } else {
                echo '<br><br><br><br><br><br><br><br><br>
                      <div class="col-md-8 col-centered text-center">
                      <h1 class="h1-large">Você ainda não possui nenhum contrato :(</h1>
                      <p class="p-large">O que está esperando? Seus clientes esperam por você!</p>
                      <a href="pag_listar_chamados.php"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="Procurar Chamados"/></a>
                      </div>';
            }

            if (isset($_GET['estado'])) {
                $estadoContrato = $_GET['estado'];
                list($estadoContrato, $contId) = explode("/", $estadoContrato);
                if ($estadoContrato == 'apagar') {

                    if (atualizarEstadoContratoTec($conexao, null, $cpfCli, 'apagar', $_SESSION['idContrato' . $contId])) {
                        echo '<script> var r = confirm("Contrato apagado!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                        unset($estadoContrato);
                        mysqli_close($conexao);
                    } else {
                        echo '<script> var r = confirm("Erro!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                        unset($estadoContrato);
                        mysqli_close($conexao);
                    }
                } else if ($estadoContrato == 'atualizar'){
                    if (atualizarEstadoContratoTec($conexao, null, null, 'finalizar', $_SESSION['idContrato' . $contId])) {
                        echo '<script> var r = confirm("Atualizado!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                        unset($estadoContrato);
                        mysqli_close($conexao);
                    } else {
                        echo '<script> var r = confirm("Erro!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                        unset($estadoContrato);
                        mysqli_close($conexao);
                    }
                }else {
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            }
            ?>
            <script>
                function apagarContrato(cont) {
                    window.location = "pag_contratosTec.php?estado=apagar" + "/" + cont;
                    event.stopPropagation();
                }
                function atualizarContrato(cont) {
                    window.location = "pag_contratosTec.php?estado=atualizar" + "/" + cont;
                    event.stopPropagation();
                }
            </script>

    </body>
</html>