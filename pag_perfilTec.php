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
                    <li class="active p-small"><a href="pag_perfilTec.php">Meu Perfil</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
                        ?>
                    </li>
                    <li class="p-small"><a href="pag_listar_chamados.php">Chamados</a>
                        <?php
                        $_SESSION['log'] = 'ativoTecnico';
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
        require_once 'banco-chamado.php';
        require_once 'banco-usuario.php';
        require_once 'banco-mensagens.php';
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
                        $_SESSION['cpfTecLog'] = $cpf;
                        $tecnicos = pegaInformacoesTecnicoPerfil($conexao, $cpf);
                        $avaliacao = verificaVoto($conexao, null, $cpf, null, 'perfil');


                        foreach ($tecnicos as $tecnico):
                            ?>
                            <tr>
                            <h1 class="text-center">
                                <img src="<?php echo $tecnico['foto'] ?>" class="rounded" width="70%" height="70%">
                            </h1>
                            <form>

                                <fieldset class="scheduler-border">
                                    <legend class="h1-large">Dados Pessoais</legend>
                                    <p class="p-large">Nome Completo: <?php echo $tecnico['nome'] ?> <?php echo $tecnico['sobrenome'] ?></p>
                                    <p class="p-large">Data de Nascimento: <?php echo $tecnico['data_nascimento'] ?></p>
                                </fieldset>      
                                <legend class="h1-large">Contatos</legend>

                                <p class="p-large">DDD: <?php echo $tecnico['ddd'] ?></p>
                                <p class="p-large">Número de Contato: <?php echo $tecnico['numero'] ?></p>
                                <p class="p-large">E-mail: <?php echo $tecnico['email'] ?></p>
                                <legend class="h1-large">Endereço</legend>

                                <p class="p-large">Rua: <?php echo $tecnico['logradouro'] ?></p>
                                <p class="p-large">Estado: <?php echo $tecnico['estado'] ?></p>
                                <p class="p-large">Bairro: <?php echo $tecnico['bairro'] ?></p>
                                <p class="p-large">CEP: <?php echo $tecnico['cep'] ?></p>
                                <p class="p-large">Cidade: <?php echo $tecnico['cidade'] ?></p>
                                <p class="p-large">Número: <?php echo $tecnico['num'] ?></p> 
                                <p class="p-large">Complemento: <?php echo $tecnico['complemento']; ?></p> 
                                <legend class="h1-large">Dados de login</legend>

                                <p class="p-large">Senha: <?php echo base64_decode($tecnico['senha']) ?></p>
                                <p class="p-large">Avaliação Geral: <?php echo $avaliacao ?></p>
                                <div class="text-center">
                                    <br>
                                    <p class="p-large"><a class="btn btn-lg btn-primary p-large botao" href="pag_alterarDadosTec.php">Alterar meu Dados <img src="Images/pencil-icon.png" width="8%" height="8%"></a></p>
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
</form>
</body>
</html>



