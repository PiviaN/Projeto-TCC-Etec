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
        <title>TecFind - Perfil do Cliente</title>
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

            </div>
            <div class="collapse navbar-collapse" id="navbar-principal">
                <ul class="nav navbar-nav navbar-left">>
                    <li class="p-small"><a href="pag_listar_chamados.php">Voltar</a>
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
        header('Content-Type: text/html; charset=utf-8');
        require_once 'conexao.php';
        require_once 'banco-usuario.php';
        require_once 'banco-chamado.php';

        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');
        try {
            $op = $_SESSION['abrirPerfilCliente'];
            switch ($op) {
                case 'contratos':
                    $cpf = $_SESSION['cpf_perfilCliente'];
                    $_SESSION['cpfVoto'] = $cpf;
                    break;
                case 'comentario':
                    $cpf = $_SESSION['cpfCliTec'];
                    $_SESSION['cpfVoto'] = $cpf;
                    break;
                case 'chamado':
                    $id = $_GET['id'];
                    $cpf = $_SESSION['cpfCli' . $id];
                    $_SESSION['cpfVoto'] = $cpf;
                    break;
                case 'voto':
                    $cpf = $_SESSION['cpfVoto'];
                    break;
            }
        } catch (Exception $ex) {
            echo $ex;
        }
        $user = $_SESSION['nome'];
        $cpfTec = pegaCpfUsuarioLogado($conexao, $user);
        $clientes = pegaInformacoesCliente($conexao, $cpf);
        $voto = verificaVoto($conexao, $cpfTec, $cpf, 0, 'carregando');
        ?>

        <script>
            function aoCarregar() {
                var voto = <?php echo $voto[0]; ?>;

                console.log("voto = ", voto)
                if (voto === 1) {
                    document.getElementById("img#1").src = "estrelaCheia.jpg"
                } else if (voto === 2) {
                    for (var i = 1; i < 3; i++) {
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else if (voto === 3) {
                    for (var i = 1; i < 4; i++) {
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else if (voto === 4) {
                    for (var i = 1; i < 5; i++) {
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else if (voto === 5) {
                    for (var i = 1; i < 6; i++) {
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else {

                }
            }
        </script>

        <?php
        if ($clientes != null) {
            ?>
            <div class="container-fluid">

                <div class="row-fluid vcenter">

                    <div class="col-md-7 col-centered">

                        <h1 class="h1-large text-center">Perfil do Cliente</h1>
                        <br>
                        <div class="well">

                            <?php
                            foreach ($clientes as $cliente):
                                ?>   
                                <h1 class="text-center">
                                    <img src="<?php echo $cliente['foto'] ?>" class="rounded" width="70%" height="70%">
                                </h1>
                                <form class="form-signin">
                                    <p class="h1-large text-center"><?php echo $cliente['nome'] ?> <?php echo $cliente['sobrenome'] ?></p>
                                    <p class="p-large">Data de Nascimento: <?php echo $cliente['data_nascimento'] ?></p>   
                                    <p class="p-large">DDD: <?php echo $cliente['ddd'] ?></p>
                                    <p class="p-large">Número de Contato: <?php echo $cliente['numero'] ?></p>
                                    <p class="p-large">Tipo de Telefone: <?php echo $cliente['tipo_telefone'] ?></p>
                                    <p class="p-large">Rua: <?php echo $cliente['logradouro'] ?></p>
                                    <p class="p-large">Estado: <?php echo $cliente['estado'] ?></p>
                                    <p class="p-large">Bairro: <?php echo $cliente['bairro'] ?></p>
                                    <p class="p-large">CEP: <?php echo $cliente['cep'] ?></p>
                                    <p class="p-large">Cidade: <?php echo $cliente['cidade'] ?></p>
                                    <p class="p-large">Complemento: <?php echo $cliente['complemento']; ?></p>
                                    <p class="p-large">Avaliação: <?php echo $voto[1] ?></p>
                                </form>
                            <br>
                                <form class="text-center" method="get" action="#" >
                                    <p class="h1-small">Avalie esse cliente!</p>
                                    <input name="enviar" type="image" id="img#1" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                                    <input name="enviar" type="image" id="img#2" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                                    <input name="enviar" type="image" id="img#3" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                                    <input name="enviar" type="image" id="img#4" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                                    <input name="enviar" type="image" id="img#5" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">

                                </form>

                            </div>
                        </div>
                    </div>
                </div>


                <?php
            endforeach;
            ?>

            <?php
        } else {
            echo '<center> Não encontrado </center>';
        }

        if (isset($_GET['voto'])) {
            $valorVoto = $_GET['voto'];
            if (!empty($valorVoto)) {
                if (($valorVoto > 0) && ($valorVoto < 6)) {
                    verificaVoto($conexao, $cpfTec, $cpf, $valorVoto, 'votando');
                    unset($valorVoto);
                }
            } else {
                echo '<script>alert("Erro ao votar")</script>';
                unset($valorVoto);
            }
        }
        ?>
    </body>


    <script>
        function mouseDentro(id) {
            document.getElementById(id).src = "estrelaCheia.jpg"
            if (id === "img#2") {
                document.getElementById("img#1").src = "estrelaCheia.jpg"
                document.getElementById("img#2").src = "estrelaCheia.jpg"
            } else if (id === "img#3") {
                for (var i = 1; i < 4; i++) {
                    document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            } else if (id === "img#4") {
                for (var i = 1; i < 5; i++) {
                    document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            } else if (id === "img#5") {
                for (var i = 1; i < 6; i++) {
                    document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            }
        }
        function mouseFora() {
            for (var i = 1; i < 6; i++) {
                document.getElementById("img#" + i).src = "estrelaVazia.jpg"
            }
        }

        function mouseClick(id) {
            var valorVoto = document.getElementById(id).id;
            var voto = valorVoto[4];
<?php $_SESSION['abrirPerfilCliente'] = 'voto'; ?>
            window.location = "pag_perfilAbertoCli.php?voto=" + voto;
        }

    </script>   


</html>