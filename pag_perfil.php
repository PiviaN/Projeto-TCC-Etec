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
        <title>TecFind - Meu Perfil</title>
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
                    <li class="p-small"><a href="pag_contratosCli.php">Contratos</a>
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
                    <li class="active p-small"><a href="pag_perfil.php">Meu Perfil</a>
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
        $_SESSION['log'] = 'ativo';
        require_once 'banco-chamado.php';
        require_once 'banco-usuario.php';
        require_once 'conexao.php';
        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');
        ?> 

        <div class="container-fluid">

            <div class="row-fluid vcenter">

                <div class="col-md-8 col-centered">

                    <h1 class="h1-large text-center">Meu Perfil</h1>
                    <br>
                    <div class="well">

                        <?php
                        $user = $_SESSION['nome'];
                        $cpf = pegaCpfUsuarioLogado($conexao, $user);
                        $clientes = pegaInformacoesCliente($conexao, $cpf);

                        foreach ($clientes as $cliente):
                            ?>
                            <h1 class="text-center">
                                <img src="<?php echo $cliente['foto'] ?>" class="rounded" width="70%" height="70%">
                            </h1>
                            <form>

                                <fieldset class="scheduler-border">
                                    <legend class="h1-large">Dados Pessoais</legend>
                                    <p class="p-large">Nome Completo: <?php echo $cliente['nome'] ?> <?php echo $cliente['sobrenome'] ?></p>
                                    <p class="p-large">Data de Nascimento: <?php echo $cliente['data_nascimento'] ?></p>
                                </fieldset>      
                                <legend class="h1-large">Contatos</legend>

                                <p class="p-large">DDD: <?php echo $cliente['ddd'] ?></p>
                                <p class="p-large">Número de Contato: <?php echo $cliente['numero'] ?></p>
                                <p class="p-large">E-mail: <?php echo $cliente['email'] ?></p>
                                <legend class="h1-large">Endereço</legend>

                                <p class="p-large">Rua: <?php echo $cliente['logradouro'] ?></p>
                                <p class="p-large">Estado: <?php echo $cliente['estado'] ?></p>
                                <p class="p-large">Bairro: <?php echo $cliente['bairro'] ?></p>
                                <p class="p-large">CEP: <?php echo $cliente['cep'] ?></p>
                                <p class="p-large">Cidade: <?php echo $cliente['cidade'] ?></p>
                                <p class="p-large">Número: <?php echo $cliente['num'] ?></p> 
                                <p class="p-large">Complemento: <?php echo $cliente['complemento']; ?></p>
                                <legend class="h1-large">Dados de login</legend>

                                <p class="p-large">Senha: <?php echo base64_decode($cliente['senha']) ?></p>
                                <div class="text-center">
                                    <br>
                                    <p class="p-large"><a class="btn btn-lg btn-primary p-large botao" href="pag_alterarDadosCliente.php">Alterar meu Dados <img src="Images/pencil-icon.png" width="8%" height="8%"></a></p>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>



