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
        <title>TecFind - Perfil do Técnico</title>
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
                    <li class="p-small"><a href="pag_contratosCli.php">Voltar</a>
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
        header('Content-Type: text/html; charset=utf-8');
        require_once 'conexao.php';
        require_once 'banco-usuario.php';
        require_once 'banco-chamado.php';
        require_once 'banco-mensagens.php';

        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');

        if (isset($_GET['idTec'])) {
            $id = $_GET['idTec'];
            $cpfTec = $_SESSION['cpfTecProcurado' . $id];

            $user = $_SESSION['nome'];
            $cpf = pegaCpfUsuarioLogado($conexao, $user);
            $tecnicos = pegaInformacoesTecnicoPerfil($conexao, $cpfTec);
            $voto = verificaVoto($conexao, $cpf, $cpfTec, 0, 'carregando');



//        if(!empty($voto[0])){
//            header('location: pag_perfilAberto.php?valorVoto='.$voto[0]);
//        }
            ?>

            <script>
                function aoCarregar() {

                    //            meusite.com/?lang=pt&page=home
                    //            var query = location.search.slice(1);
                    //            var partes = query.split('&');
                    //            var data = {};
                    //            partes.forEach(function (parte) {
                    //             var chaveValor = parte.split('=');
                    //            var chave = chaveValor[0];
                    //            var valor = chaveValor[1];
                    //                data[chave] = valor;
                    //            });
                    //
                    //            console.log(data); // Object {lang: "pt", page: "home"}

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
            if ($tecnicos != null) {
                ?>
                <div class="container-fluid">

                    <div class="row-fluid vcenter">

                        <div class="col-md-7 col-centered">

                            <h1 class="h1-large text-center">Perfil do Técnico</h1>
                            <br>
                            <div class="well">

                                <?php
                                foreach ($tecnicos as $tecnico):
                                    ?> 
                                    <h1 class="text-center">
                                        <img src="<?php echo $tecnico['foto'] ?>" class="rounded" width="70%" height="70%">
                                    </h1>
                                    <form class="form-signin">
                                        <p class="h1-large text-center"><?php echo $tecnico['nome'] ?> <?php echo $tecnico['sobrenome'] ?></p>
                                        <p class="p-large">Data de Nascimento: <?php echo $tecnico['data_nascimento'] ?></p>   
                                        <p class="p-large">DDD: <?php echo $tecnico['ddd'] ?></p>
                                        <p class="p-large">Número de Contato: <?php echo $tecnico['numero'] ?></p>
                                        <p class="p-large">Tipo de Contato: <?php echo $tecnico['tipo_telefone'] ?></p>
                                        <p class="p-large">Rua: <?php echo $tecnico['logradouro'] ?></p>
                                        <p class="p-large">Estado: <?php echo $tecnico['estado'] ?></p>
                                        <p class="p-large">Bairro: <?php echo $tecnico['bairro'] ?></p>
                                        <p class="p-large">CEP: <?php echo $tecnico['cep'] ?></p>
                                        <p class="p-large">Cidade: <?php echo $tecnico['cidade'] ?></p>
                                        <p class="p-large">Complemento: <?php echo $tecnico['complemento']; ?></p>
                                        <p class="p-large">Instituição: <?php echo $tecnico['instituicao'] ?></p>
                                        <p class="p-large">Curso: <?php echo $tecnico['curso'] ?></p>
                                        <p class="p-large">Avaliação: <?php
                                            if (empty($voto[1])) {
                                                echo 'Não avaliado.';
                                            } else {
                                                echo $voto[1];
                                            }
                                            ?></p>
                                       

                                    </form>
                                    <br>
                                    <form class="text-center" method="get" action="#" >
                                        <p class="h1-small">Avalie esse técnico!</p>
                                        <input name="enviar" type="image" id="img#1" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id);
                                                            return false;" alt="avaliacao">
                                        <input name="enviar" type="image" id="img#2" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id);
                                                            return false;" alt="avaliacao">
                                        <input name="enviar" type="image" id="img#3" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id);
                                                            return false;" alt="avaliacao">
                                        <input name="enviar" type="image" id="img#4" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                                        <input name="enviar" type="image" id="img#5" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">

                                    </form>
                                    <?php
                                endforeach;
                            } else {
                                echo '<center> Não encontrado </center>';
                            }

                            if (isset($_GET['voto'])) {
                                $valorVoto = $_GET['voto'];
                                if (!empty($valorVoto)) {
                                    if (($valorVoto > 0) && ($valorVoto < 6)) {
                                        verificaVoto($conexao, $cpf, $cpfTec, $valorVoto, 'votando');
                                        unset($valorVoto);
                                    }
                                } else {
                                    echo '<script>alert("Erro ao votar")</script>';
                                    unset($valorVoto);
                                }
                            }
                            ?>
                            <br>
                            <h1 class="h1-large text-center">Mensagens</h1>
                            <div id = "b" class="well" style="background-color:white;">
                                <?php
                                $tipoUsuario = pegaTipoUsuario($conexao, $cpf);
                                $dom = new DOMDocument("1.0", "ISO-8859-7");
                                $root = lerXML($dom, $conexao, $cpf, $cpfTec, $tipoUsuario);
                                $dom = $_SESSION['dom'];
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $mensagem = $_POST['txtMsg'];
                                    $msg = addMensagem($dom, $mensagem, $cpf);
                                    $root->appendChild($msg);
                                    $dom->appendChild($root);
                                    $dom->save($_SESSION['nomeXML']);
                                    $_POST['txtMsg'] = null;
                                    unset($msg);
                                    $root = lerXML($dom, $conexao, $cpf, $cpfTec, $tipoUsuario);
                                    $dom = $_SESSION['dom'];
                                }
                                $ver = simplexml_import_dom($dom);
                                foreach ($ver as $xml):
                                    if (empty($xml->cpf_origem)) {
                                        echo '<p align="center">' . $xml->mensagem . '</p>';
                                    } else if ($xml->cpf_origem == $cpf) {
                                        echo '<p align="right">' . $xml->mensagem . '</p>';
                                        echo '<p align="right">' . $xml->data_envio . '</p>';
                                    } else {
                                        echo '<p align="left">' . $xml->mensagem . '</p>';
                                        echo '<p align="left">' . $xml->data_envio . '</p>';
                                    }
                                endforeach;
                                ?>
                            </div>

                            <form class="form-signin" action="#" method="post">
                                <input placeholder="Digite sua mensagem" class="form-control p-small" name="txtMsg" type="text"/>
                                <br>
                                <input class="btn btn-lg btn-primary p-small botao center-block" type="submit" value="Enviar"/>
                            </form>

                        </div>


                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
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
                window.location = "pag_perfilAbertoTec.php?voto=" + voto + "&idTec=<?php echo $id; ?>";
            }
            function enviarMsg() {
                window.location = "pag_perfilAbertoTec.php?idTec=<?php echo $id; ?>";
            }
        </script>

    </body>
</html>
