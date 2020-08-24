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
        <title>TecFind - Pesquisar Técnicos</title>
        <title></title>
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
                    <li class="active p-small"><a href="pag_pesquisarTec.php">Pesquisar Técnicos</a>
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

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <br>

                    <div class="col-md-6 col-centered text-center">
                        <h1 class="h1-large">Pesquise seu Técnico!</h1>
                        <p class="p-large">Aqui é a área em que você pode localizar o técnico que desejar!
                            Insira algumas informações e veja a ajuda a caminho!</p>
                        <br>
                    </div>
                    <div class="col-md-4 col-centered text-center">
                        <div class="well">
                            <form class="form-signin" method="post" action="pag_TecEncontrado.php">

                                <form method="post" action="pag_TecEncontrado.php">
                                    <label class="p-large sr-only">Nome do Técnico</label>
                                    <input name="txtnome" maxlength="50" class="form-control p-small" placeholder="Nome do Técnico"/>
                                    <br>
                                    <label class="p-large sr-only">Sobrenome do Técnico</label>
                                    <input name="txtsobre" class="form-control p-small" placeholder="Sobrenome do Técnico">
                                    <br>
                                    <i class="p-small">Nome e sobrenome são opcionais</i><br>
                                    <br>
                                    <select class="p-small rounded" name="cbEstado">
                                        <option class="p-small rounded" value="a">Filtro</option>
                                        <option class="p-small rounded" value="3">Até 3km de mim</option>
                                        <option class="p-small rounded" value="5">Até 5km de mim</option>
                                        <option class="p-small rounded" value="10">Até 10km de mim</option>
                                        <option class="p-small rounded" value="15">Até 15km de mim</option>
                                    </select> 
                                    <br>
                                    <br>
                                    <button class="btn btn-lg btn-primary btn-block p-large botao" type="submit">Pesquisar</button><br> 

                                </form>
                                <?php
                                $_SESSION['log'] = 'ativo';
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
