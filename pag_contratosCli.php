<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <nav class="navbar navbar-inverse fundo">

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

                    <li class="active p-small"><a href="pag_contratosCli.php">Contratos</a>
                        <?php
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_pesquisarTec.php">Pesquisar Técnicos</a>
                        <?php
                        //Esse código cria uma sessão chamada verifica com o valor ativo
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_perfil.php">Meu Perfil</a>
                        <?php
                        $_SESSION['log'] = 'ativo';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_cadastrar_chamado.php">Fazer um Chamado</a>
                        <?php
                        $_SESSION['log'] = 'ativo';
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
        $aux = 0;
        $notificacoes = listarNotificacaoCli($conexao, $cpfCli, 'cpf_cliente', 'outros', null);
        // var_dump($notificacoes);

        foreach ($notificacoes as $notificacao):
            if ($notificacao['estadoContrato'] != 'Apagado') {
                $aux++;
            }
        endforeach;

        if ((!empty($notificacoes)) && ($aux != 0)) {

            foreach ($notificacoes as $notificacao):
                ?>    

            <center>
                <?php
                if ($notificacao['estadoContrato'] != 'Apagado') {
                    echo '<div id="' . $div . $cont . '" >';
                    ?>       
                    <div class="row col-centered">
                        <div class="col-md-5 col-centered">
                            <div class="well">
                                <?php
                                if ($notificacao['estadoContrato'] != 'Em espera') {
                                    echo '<h1 class="text-center"><img class="rounded" width="35%" height="35%" src="' . $notificacao['foto'] . '"></h1>
                                <p class="h1-small">' . $notificacao['nome'] . ' ' . $notificacao['sobrenome'] . '</p>';
                                }
                                ?>
                                <div class="well text-left" style="background-color: white">
                                    <p class="p-small">Detalhes do Problema: <?php echo $notificacao['detalhes'] ?></p>
                                    <p class="p-small">Data esperada: <?php echo $notificacao['data_acertada'] ?></p>
                                    <p class="p-small">Estado: <?php
                                        if ($notificacao['estadoContrato'] === 'Em analise') {
                                            echo 'Esperando aprovação';
                                        } else if ($notificacao['estadoContrato'] === 'ConfirmadoTecnico') {
                                            echo 'Presença do Técnico confirmada!';
                                        } else if ($notificacao['estadoContrato'] === 'Confirmado') {
                                            echo 'Confirmado!';
                                        } else if ($notificacao['estadoContrato'] === 'Em espera') {
                                            echo 'Esperando técnicos';
                                        } else if ($notificacao['estadoContrato'] === 'Finalizado') {
                                            echo 'Finalizado';
                                        }
                                        ?>
                                </div>
                                <?php
                                if ($notificacao['estadoContrato'] != 'Em espera') {
                                    echo '<a href="pag_perfilAbertoTec.php?idTec=' . $cont . '"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="Ver Perfil de ' . $notificacao['nome'] . '" /></a>';
                                }
                                if (($notificacao['estadoContrato'] != 'Em espera') && ($notificacao['estadoContrato'] != 'Finalizado') && ($notificacao['estadoContrato'] != 'Confirmado')) {
                                    $vltBtn = null;
                                    switch ($notificacao['estadoContrato']){
                                        case 'Em analise':
                                                $vlrBtn = 'Confirmar';
                                            break;
                                        case 'ConfirmadoTecnico':
                                                $vlrBtn = 'Finalizar';
                                            break;
                                    }
                                    echo '<a href="" onclick="atualizarEstado(' . $cont . '); return false;"> <input class="btn btn-lg btn-primary p-small botao" type="submit" value="'. $vlrBtn .'" /></a>';
                                }
                                ?>
                                <a href="" onclick="apagarContrato(<?PHP echo $cont ?>); return false;"><input class="btn btn-lg btn-primary p-small botao" type="submit" value="Excluir Contrato" /></a>
                                <?php
                                $_SESSION['cpf_tec' . $cont] = $notificacao['cpf_tecnico'];
                                $_SESSION['cpfTecProcurado' . $cont] = $notificacao['cpf_tecnico'];
                                $_SESSION['idContrato' . $cont] = $notificacao['id_contrato'];
                                ?>
                                <?php $cont++; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            endforeach;
        } else {
            echo '<br><br><br><br><br><br><br><br><br>
            <div class="col-md-8 col-centered text-center">
                <h1 class="h1-large">Você ainda não fez nenhum contrato :(</h1>
                <p class="p-large">Vamos lá, não seja tímido!</p>
                <a href="pag_cadastrar_chamado.php"><input class="btn btn-lg btn-primary p-large botao" type="submit" value="Criar Chamados"/></a>
              </div>';
        }

        if (isset($_GET['estado'])) {
            $estadoContrato = $_GET['estado'];
            list($estadoContrato, $contId) = explode("/", $estadoContrato);
            // apagar o contrato
            if ($estadoContrato == 'apagar') {
                if (apagarContrato($conexao, $_SESSION['idContrato' . $contId])) {
                    echo '<script> var r = confirm("Contrato apagado!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
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
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            // atualizar o contrato
            } else if ($estadoContrato == 'atualizar') {
                
                if (atualizarEstadoContratoCli($conexao, $cpfCli, $_SESSION['cpfTecProcurado'. $contId], 'finalizar', $_SESSION['idContrato' . $contId]) ) {
                    echo '<script> var r = confirm("Atualizado!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
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
                    unset($estadoContrato);
                    mysqli_close($conexao);
                }
            } else {
                unset($estadoContrato);
                mysqli_close($conexao);
            }
        }
        ?>
        <script>
            function apagarContrato(cont) {
                window.location = "pag_contratosCli.php?estado=apagar" + "/" + cont;
                event.stopPropagation();
            }
            function atualizarEstado(cont) {
                window.location = "pag_contratosCli.php?estado=atualizar" + "/" + cont;
            }
        </script>

        <style type="text/css"> 
            

        </style>
    </body>
</html>
