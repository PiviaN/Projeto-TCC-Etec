<!DOCTYPE html>

<!--
1- Essa página  se a sessão log é diferente  do valor ativo;
2- Se nã estiver diferente de ativo o if vai direcionar para a tela de login;
3- Se não ele manda uma mensagem de bem vindo junto com a pagina logout;
-->
<?php
session_cache_expire(30);
//Código para iniciar sessão
session_start();
if ($_SESSION['log'] != "ativoTecnico") {
    session_destroy();
    header("location: index.php");
}

// Caso o usuário cancele o chamado, vai vir uma msg.
if (isset($_SESSION['msgChamado'])) {
    if (!empty($_SESSION['msgChamado'])) {
        $msg = $_SESSION['msgChamado'];
        echo "<script>alert('$msg')</script>";
        $_SESSION['msgChamado'] = "";
    }
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link  href="dist/css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" href="dist/css/main-page.css">
        <script src="dist/js/jquery.min.js"></script>
        <script src="dist/js/bootstrap.min.js"></script>
        <link rel="icon" href="Images/icon.png" type="image/x-icon" />
        <title>TecFind - Menu do Técnico</title>
    </head>
    <?php
    require_once 'banco-chamado.php';
    require_once 'banco-usuario.php';
    require_once 'conexao.php';
    mysqli_query($conexao, "SET NAMES 'utf8'");
    mysqli_query($conexao, 'SET character_set_connection=utf8');
    mysqli_query($conexao, 'SET character_set_client=utf8');
    mysqli_query($conexao, 'SET character_set_results=utf8');
    $user = $_SESSION['nome'];
    $cpf = pegaCpfUsuarioLogado($conexao, $user);
    $not = carregarNotificacao($conexao, $cpf, 'cpf_tecnico', null, null);
    $notificacoes = listarNotificacaoTec($conexao, $cpf, 'cpf_tecnico', null, null);
    $foto = puxarFoto($conexao, $cpf);
    if (empty($not)) {
        $not = 0;
    }
    $cont = 1;
    ?>
    <body>

        <nav class="navbar navbar-default">

            <div class="navbar-header">

                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-principal" aria-expanded="false">

                    <span class="sr-only">Alternar Navegação</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <a href="pag_menuCliente.php" class="navbar-brand p-small">TecFind</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-principal">

                <ul class="nav navbar-nav">
                    <li class="p-small"><a href="pag_contratosTec.php">Contratos</a>
                        <?php
                        //Esse código cria uma sessão chamada verifica com o valor ativo
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_perfilTec.php">Meu Perfil</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    <li class="p-small"><a href="verificaChamadoAberto.php">Procurar chamados</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    </li>
                    <li class="p-small"><a href="logout.php">Sair

                        </a>

                    </li>
                </ul>

            </div>


        </nav>

        <div class="container" id="container">

            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $not ?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-menu">
                    <?php
                    foreach ($notificacoes as $notificacao):
                        $_SESSION['idDados' . $cont] = array($notificacao['id_contrato'], $notificacao['cpf_cliente'], null);
                        echo '<li><a href="listarNotificacaoTec.php?id=' . $cont . '"' .
                        '<img src="' . $notificacao['foto'] . '" width="40px" height="40px">';
                        echo ' ' . $notificacao['nome'] . ' ' . $notificacao['sobrenome'] . "<br>";
                        echo $notificacao['detalhes'] . '</a></li>';
                        $cont++;
                    endforeach;
                    mysqli_close($conexao);
                    ?>        
                    <li class="divider"></li>
                    <li><a href="pag_notificacaoTec.php">Notificações</a></li>
                </ul>
            </div>

        <div class="row">


            <div class="col-md-12">

                <!--<div class="well">-->

                <div class="row vcenter">
                    <div class="col-md-7 col-centered">

                        <div class="well">
                            <?php 
                                echo '<img src="' . $foto . '" class="img-responsive"> ';
                            ?>
                            <center>
                                <h1>Bem vindo ao Sistema!</h1>
                                <br>
    <!--                        <img src="fotos/2a88fc379de81104ee1131104f343ea2.jpg" class="img-responsive rouded">-->
                                <br>

                                <br>
                                <br>
                                <h1 class="h1-large">Página em Desenvolvimento</h1>
                                <br>
                            </center>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        
</body>
</html>
