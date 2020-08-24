
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

            </div>
            <div class="collapse navbar-collapse" id="navbar-principal">
                <ul class="nav navbar-nav navbar-left">
                    <li class="p-small"><a href="pag_pesquisarTec.php">Voltar</a>
                    </li>
                </ul>
            </div>


        </nav>
        <?php
        header('Content-Type: text/html; charset=utf-8');
        session_start();
        if ($_SESSION['log'] != 'ativo') {
            session_destroy();
            header("location: index.php");
        }
        include('conexao.php');
        include('banco-usuario.php');
        require_once 'banco-chamado.php';
        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');
        $user = $_SESSION['nome'];
        $cpf = pegaCpfUsuarioLogado($conexao, $user);
        if (is_numeric($_POST['cbEstado'])) {
            $op = $_POST['cbEstado'];
            $tecnicos = listarTecnicoOpcao($conexao, $cpf, $op);
        } else if ($_POST['txtnome']) {
            $nome = $_POST['txtnome'];
            $sobrenome = $_POST['txtsobre'];
            $tecnicos = pegaInformacoesTecnico($conexao, $nome, $sobrenome);
        } else {
            $tecnicos = null;
        }
        if ($tecnicos != null) {
            ?>

            <?php
            $cont = 0;
            foreach ($tecnicos as $tecnico):
                // echo $_SESSION['d' . $tecnico['cpf']];

                if (isset($op)) {
                    $distanciaFinal = str_replace("d", "", $_SESSION['d' . $tecnico['cpf']]);
                    if ((is_numeric($op)) && ($distanciaFinal <= $op)) {
                        ?>
                        <div class="row col-centered">
                            <div class="col-md-5 col-centered">
                                <div class="well">
                                    <h1 class="text-center"><img class="rounded" width="42%" height="20%" src="<?php echo $tecnico['foto'] ?>"></h1>
                                    <p class="p-large text-center"><?php echo $tecnico['nome'] ?> <?php echo $tecnico['sobrenome'] ?>
                                    <p class="p-small">Data de Nascimento: <?php echo $tecnico['data_nascimento'] ?></p>
                                    <p class="p-small">Número de Contato: <?php echo $tecnico['ddd'] . ' ' . $tecnico['numero'] ?></p>
                                    <p class="p-small">Tipo de Contato: <?php echo $tecnico['tipo_telefone'] ?></p>
                                    <p class="p-small">Instituição: <?php echo $tecnico['instituicao'] ?></p>
                                    <p class="p-small">Curso: <?php echo $tecnico['curso'] ?></p>
                                    <p class="p-small">Distância: <?php echo $distanciaFinal . " Km" ?></p>
                                    <a href="pag_perfilAbertoTec.php?idTec=<?php echo $cont ?>"><input class="btn btn-lg btn-primary p-small botao center-block" type="button"  value="Ver Perfil"/></a>
                                    <?php
                                    $_SESSION['cpfTecProcurado' . $cont] = $tecnico['cpf'];
                                    ?>
                                </div>
                            </div>
                        </div>  
                        <?php
                    }
                } else {
                    $distanciaFinal = puxarCoordUserLog($conexao, $cpf, $tecnico['coord']);
                    ?>    
            <!--<center>-->
                    <div class="row col-centered">
                        <div class="col-md-5 col-centered">
                            <div class="well">
                                <h1 class="text-center"><img class="rounded" width="35%" height="30%" src="<?php echo $tecnico['foto'] ?>"></h1>
                                <p class="p-large text-center"><?php echo $tecnico['nome'] ?> <?php echo $tecnico['sobrenome'] ?>
                                <p class="p-small">Data de Nascimento: <?php echo $tecnico['data_nascimento'] ?></p>
                                <p class="p-small">Número de Contato: <?php echo $tecnico['ddd'] . ' ' . $tecnico['numero'] ?></p>
                                <p class="p-small">Tipo de Contato: <?php echo $tecnico['tipo_telefone'] ?></p>
                                <p class="p-small">Instituição: <?php echo $tecnico['instituicao'] ?></p>
                                <p class="p-small">Curso: <?php echo $tecnico['curso'] ?></p>
                                <p class="p-small">Distância: <?php echo $distanciaFinal . " Km" ?></p>
                                <a class="text-center" href="pag_perfilAbertoTec.php?idTec=<?php echo $cont ?>"><input class="btn btn-lg btn-primary p-small botao center-block" type="button"  value="Ver Perfil"/></a>
                                    <?php
                                    $_SESSION['cpfTecProcurado' . $cont] = $tecnico['cpf'];
                                    ?>
                            </div>
                        </div>
                    </div>  
                    <!--</center>-->
                    <?php
                }
                $cont++;
            endforeach;
            echo '</table>';
            mysqli_close($conexao);
        } else {
            echo '<br><br><br><br><br><br><br><br><br>
            <div class="col-md-8 col-centered text-center">
                <h1 class="h1-large">Nenhum técnico encontrado :(</h1>
                <p class="p-large">Não esqueça de utilizar o filtro!</p>
                <a href="pag_pesquisarTec.php"><input class="btn btn-lg btn-primary p-large botao" type="submit" value="Pesquisar novamente"/></a>
              </div>';
            mysqli_close($conexao);
        }
        ?>
    </body>
</html>