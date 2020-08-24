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
        <title>TecFind - Fazer um Chamado</title>
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
                    <li class="p-small"><a href="pag_listar_chamados.php">Chamados</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    <li class="active p-small"><a href="pag_mensagens.php">Conversas</a>
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
            <div class="row col-centered">
                <div class="col-md-5 col-centered text-center">
                    <div class="well">
                        <h1 class="h1-large text-center">Conversas</h1><br>
                        <?php
                        session_start();
                        require_once './banco-chamado.php';
                        require_once './banco-mensagens.php';
                        $user = $_SESSION['nome'];
                        $cpf = pegaCpfUsuarioLogado($conexao, $user);
                        $_SESSION['cpfTecLog'] = $cpf;
                        mysqli_query($conexao, "SET NAMES 'utf8'");
                        mysqli_query($conexao, 'SET character_set_connection=utf8');
                        mysqli_query($conexao, 'SET character_set_client=utf8');
                        mysqli_query($conexao, 'SET character_set_results=utf8');
                        $contatos = listarContatos($conexao, $cpf, 1);
                        $cont = 0;
                        foreach ($contatos as $contato):
                            echo '<img class="rounded" src="' . $contato['foto'] . '" width="35%" height="30%">';
                            echo '<p class="p-large">' . ' <a href="pag_comentarios.php? msg=' . $cont . '">Conversar com ' . $contato['nome'] . '</p><br>';
                            $_SESSION['cpfCliMsg' . $cont] = $contato['cpf_cliente_fk'];
                            $cont++;
                        endforeach;
                        mysqli_close($conexao);
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>