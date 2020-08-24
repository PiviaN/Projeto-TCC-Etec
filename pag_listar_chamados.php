<!DOCTYPE html>

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
        <title>TecFind - Chamados</title>
        <title></title>
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

                <a href="index.html"><img class="navbar-brand" src="Images/computer.png"></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-principal">

                <ul class="nav navbar-nav navbar-right">
                    <li class="p-small"><a href="pag_contratosTec.php">Contratos</a>
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
                    <li class="active p-small"><a href="pag_listar_chamados.php">Chamados</a>
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <!--<form class="form-signin" action="#" method="post" >-->  

                    <h1 class="h1-large">Procurar Chamados</h1>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-centered">
                            <p class="p-large">Os clientes que precisam de sua ajuda serão listados aqui.</p>
                            <br>
                            <br>
                        </div>
                    </div>

                    <p>
                    <form action="" method="POST">

                        <select class=" p-small txtmensagens" name="filtro">
                            <option class="p-small" value="">Filtro</option>
                            <option class="p-small" value="3">Até 3Km de mim</option>
                            <option class="p-small" value="5">Até 5Km de mim</option>
                            <option class="p-small" value="10">Até 10Km de mim</option>
                            <option class="p-small" value="15">Até 15Km de mim</option>
                        </select
                    </form>
                    <input class="btn btn-lg btn-primary p-small botao" type="submit" value="Pesquisar" />
                    </p>
                    <?php
                    session_start();
                    if ($_SESSION['log'] != "ativoTecnico") {
                        session_destroy();
                        header("location: index.html");
                    }
                    require_once 'conexao.php';
                    require_once 'banco-chamado.php';
                    require_once './gerarCoordenadas.php';
                    mysqli_query($conexao, "SET NAMES 'utf8'");
                    mysqli_query($conexao, 'SET character_set_connection=utf8');
                    mysqli_query($conexao, 'SET character_set_client=utf8');
                    mysqli_query($conexao, 'SET character_set_results=utf8');
                    ?>
                  <!--  <table class="rounded" border = "1"> -->
                    <?php
                    if ((isset($_POST['filtro'])) && (!empty($_POST['filtro']))) {

                        $user = $_SESSION['nome'];
                        $cpf = pegaCpfUsuarioLogado($conexao, $user);

                        if (is_numeric($_POST['filtro'])) {
                            $distanciaMax = $_POST['filtro'];
                            //$lugar = $_POST['filtro'];
                            // $nomeLugar = pegaLugardoUsuario($conexao, $lugar, $cpf);
                            $chamados = calcularDistanciaChamadoLugar($conexao, $cpf);
                        }


                        $cont = 0;
                        foreach ($chamados as $chamado):
                            $distanciaFinal = str_replace("d", "", $_SESSION['d'.$chamado['cpf_cli']]); // $_SESSION['d' . $chamado['cpf_cli']]
                            if ($distanciaFinal < $distanciaMax) {
                                ?>
                                <div class="row col-centered">
                                    <div class="col-md-5 col-centered">
                                        <div class="well">
                                            <h1 class="text-center"><img class="rounded" width="35%" height="35%" src="<?php echo $chamado['foto'] ?>"></h1>
                                            <p class="p-large"><?php echo $chamado['nome'] ?> <?php echo $chamado['sobrenome'] ?>
                                            <p class="p-small">Descrição do Problema: <?php echo $chamado['detalhes'] ?></p>
                                            <p class="p-small">Data para visita técnica: <?php echo $chamado['data_acertada'] ?></p>
                                            <p class="p-small">Endereço: <?php echo $chamado['logradouro'] ?></p>
                                            <p class="p-small">Número de Contato: <?php echo $chamado['ddd'] . ' ' . $chamado['numero'] ?></p>
                                            <p class="p-small">Distância: <?php echo  $distanciaFinal . ' Km' ?></p>
                                            <input class="btn btn-lg btn-primary p-small botao" type="button" onclick="abrirPerfilCli(<?php echo $cont; ?>)" value="Ver Perfil" />
                                            <br>
                                            <br>
                                            <input class="btn btn-lg btn-primary p-small botao" type="button" onclick="verificaAlistamento()" value="Candidatar-se" />
                                            <?php
                                            $_SESSION['cpfCli' . $cont] = $chamado['cpf_cli'];
                                            // onclick="abrirPerfilCli(<?php echo $cont; )"
                                            $_SESSION['abrirPerfilCliente'] = 'chamado';
                                            $_SESSION['id_contrato'] = $chamado['id_contrato'];
                                            $cont++;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        endforeach;
                    }
                    ?>

                    <!--   </table> -->
                    <!--                    </form>-->
                </div>
            </div>
        </div>
    </body>
    <script>
        function verificaAlistamento() {
            var r = confirm("Você realmente deseja candidatar-se a este chamado?");
            if (r === true) {
                window.location.assign("verificarCandidatura.php");
            }
        }
        function abrirPerfilCli(id) {
            window.location = "pag_perfilAbertoCli.php?id=" + id;
        }
    </script>
</html>
