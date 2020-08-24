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
        <title>TecFind</title>
    </head>

    <body class="body">

        <nav class="navbar navbar-default fundo">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="sr-only">Alternar Navegação</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span> 
                    </button>

                    <a href="index.php"><img class="navbar-brand" src="Images/computer.png"></a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active p-small"><a href="index.php">Home</a></li>
                        <li class="p-small"><a href="sign-up-form.html">Cadastro</a></li>
                        <li class="p-small"><a href="#">Sobre Nós</a></li>
                    </ul>

                </div>
            </div>

        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-5 col-centered text-center"> 
                            <br>

                            <h1 class="h1-large">Olá!</h1>
                            <p class="p-large">Fique a vontade, pois aqui você encontrará a maneira mais rápida e fácil de resolver os problemas do seu computador onde quer que você esteja! Precisa de um técnico? Deixe que ele vá até você!</p>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4 col-centered text-center">
                                <div class="well">
                                    <form class="form-signin" method="post" action="verificaLogin.php">
                                        <h1 class="h1-large">Login</h1>
                                        <label for="inputEmail" class="sr-only">Endereço de E-mail</label>
                                        <input type="text" name="txtu" maxlength="50" class="form-control" placeholder="Nome de Usuário"/>
                                        <br>
                                        <label for="inputPassword" class="sr-only">Senha</label>
                                        <input type="password" name="txts" class="form-control" placeholder="Senha">
                                        <br>
                                        <!-- captcha -->
<!--                                        <img src="captcha.php?l=150&a=50&tf=20&ql=5"><br>
                                        <br>
                                        <input class="form-control" type="text" name="palavra"  placeholder="Digite a palavra acima"/>
                                        <br> -->
                                        <div class="checkbox mb-3">
                                            <label class="p-small">
                                                <input type="checkbox" value="remember-me"> Lembrar minha senha
                                            </label>
                                        </div>
                                        <button class="btn btn-lg btn-primary btn-block p-large botao" type="submit">Entrar</button>
                                        <br>

                                        <p class="p-small">Ainda não possui uma conta no TecFind?</p>
                                        <img src="Images/arrow.jpg" width="10px" height="20px">
                                        <br>
                                    </form>
                                    <form method="post" action="sign-up-form.html">
                                        <button class="btn btn-lg btn-primary btn-block p-large botao" type="submit">Cadastrar-se</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>           

    </body>
</html>