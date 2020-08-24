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
        <title>TecFind - Mensagens</title>
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
                    <li class="p-small"><a href="pag_mensagens.php">Voltar</a>
                    </li>
                </ul>
            </div>


        </nav>
        <div class="container-fluid">
            <div class="col-md-7 col-centered text-center">
                <h1 class="h1-large text-center">Mensagens</h1>
                <div id = "b" class="well">
                    <?php
                    session_start();
                    require_once './banco-mensagens.php';
                    require_once './conexao.php';
                    require_once './banco-chamado.php';

                    $cpf = $_SESSION['cpfTecLog'];
                    if (isset($_GET['msg'])) {
                        $id = $_GET['msg'];

                        if (isset($_SESSION['cpfCliMsg' . $id])) {
                            $cpfCli = $_SESSION['cpfCliMsg' . $id];
                            $nome = pegarNomeCli($conexao, $cpfCli);
                            echo '<p>Contato: ' . $nome . ' </p>'
                            . '<a href="pag_perfilAbertoCli.php">Visitar perfil</a>';
                            $dom = new DOMDocument("1.0", "ISO-8859-7");
                            $root = lerXML($dom, $conexao, $cpfCli, $cpf, 1);
                            $dom = $_SESSION['dom'];
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $mensagem = $_POST['txtMsg'];
                                $msg = addMensagem($dom, $mensagem, $cpf);
                                $root->appendChild($msg);
                                $dom->appendChild($root);
                                # Para salvar o arquivo, descomente a linha
                                $dom->save($_SESSION['nomeXML']);
                                $_POST['txtMsg'] = null;
                                unset($msg);
                                $root = lerXML($dom, $conexao, $cpfCli, $cpf, 1);
                                $dom = $_SESSION['dom'];
                            }
                            // $dom = $_SESSION['dom'];
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
                            $_SESSION['cpfCliTec'] = $cpfCli;
                            $_SESSION['abrirPerfilCliente'] = 'comentario';
                            ?>

                            <form method = "POST" action = "pag_comentarios.php?msg=<?php echo $id; ?>">
                                <input class="form-control" type = "text" name="txtMsg">
                                <br>
                                <input class="btn btn-primary btn-lg p-small botao center-block" type = "submit" value = "Enviar">
                            </form>
                        </div>
                    </div>
                </div>


                <?php
            } else {
                echo '<center>Erro ao abrir comentários!</center>';
            }
        }
        ?>
    </body>
</html>
