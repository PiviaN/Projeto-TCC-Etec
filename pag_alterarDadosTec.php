<!DOCTYPE html>
<?php
session_start();
/* Esse código analisa se a sessão verifica é diferente do valor ativo
  Se verifica estiver diferente de ativo, o if vai destruir a sessão e
  redirecionar para a tela de login */
if ($_SESSION['log'] != 'ativoTecnico') {
    session_destroy();
    header("location: index.php");
}

require_once 'conexao.php';
require_once 'banco-chamado.php';
require_once 'banco-usuario.php';

mysqli_query($conexao, "SET NAMES 'utf8'");
mysqli_query($conexao, 'SET character_set_connection=utf8');
mysqli_query($conexao, 'SET character_set_client=utf8');
mysqli_query($conexao, 'SET character_set_results=utf8');
$user = $_SESSION['nome'];
$cpf = pegaCpfUsuarioLogado($conexao, $user);
$tecnicos = pegaInformacoesTecnicoPerfil($conexao, $cpf);
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
        <link rel="icon" href="Images/logo.png" type="image/x-icon" />
        <title>TecFind - Alterar Dados</title>
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
                <ul class="nav navbar-nav navbar-left">
                    <li class="p-small"><a href="pag_perfilTec.php">Voltar</a>
                    </li>
                </ul>
            </div>


        </nav>
        <div class="container-fluid">
            <div class="row">


                <div class="col-md-12">

                    <!--<div class="well">-->

                    <div class="row vcenter">
                        <div class="col-md-6 col-centered">
                            <center>
                                <br>
                                <br>
                                <h1 class="h1-large">Alterar meus Dados</h1>
                                <br>
                            </center>
                            <div class="well">
                                <form class="form-group" method="post" action="verificaAlteracao.php" enctype="multipart/form-data">
                                    <?php
                                    foreach ($tecnicos as $tecnico):
                                        ?>
                                        <p class="p-large">Logradouro: </p><input type="text" id="inputText" name="txtlogra" class="form-control p-small" maxlength="40"
                                                                                  value="<?php echo $tecnico['logradouro'] ?>" />
                                        <p class="p-large">Estado: </p><input type="text" id="inputText" name="txtestado" class="form-control p-small" maxlength="40"
                                                                              value="<?php echo $tecnico['estado'] ?>" />
                                        <p class="p-large">Bairro: </p><input type="text" id="inputText" name="txtbairro" class="form-control p-small" maxlength="40"
                                                                              value="<?php echo $tecnico['bairro'] ?>" />
                                        <p class="p-large">CEP: </p><input type="text" id="inputText" name="txtcep" class="form-control p-small" maxlength="40"
                                                                           value="<?php echo $tecnico['cep'] ?>" />
                                        <p class="p-large">Cidade: </p><input type="text" id="inputText" name="txtcidade" class="form-control p-small" maxlength="40"
                                                                              value="<?php echo $tecnico['cidade'] ?>" />
                                        <p class="p-large">Número da residência: </p><input type="text" id="inputText" name="txtnumCasa" class="form-control p-small" maxlength="40"
                                                                                            value="<?php echo $tecnico['num'] ?>" />
                                        <p class="p-large">Complemento: </p><input type="text" id="inputText" name="txtcomplemento" class="form-control p-small" maxlength="40"
                                                                                   value="<?php echo $tecnico['complemento'] ?>" />
                                        <p class="p-large">DDD: </p><input type="text" id="inputText" name="txtddd" class="form-control p-small" maxlength="40"
                                                                           value="<?php echo $tecnico['ddd'] ?>" />
                                        <p class="p-large">Número de Contato: </p><input type="text" id="inputText" name="txttel" class="form-control p-small" maxlength="40"
                                                                                         value="<?php echo $tecnico['numero'] ?>" />
                                        <p class="p-large">Tipo de Contato: </p><input type="text" id="inputText" name="txttipo" class="form-control p-small" maxlength="40"
                                                                                       value="<?php echo $tecnico['tipo_telefone'] ?>" />
                                        <p class="p-large">E-mail: </p><input type="text" id="inputText" name="txtemail" class="form-control p-small" maxlength="40"
                                                                              value="<?php echo $tecnico['email'] ?>" />
                                        <p class="p-large">Senha: </p><input type="text" id="inputText" name="txtsenha" class="form-control p-small" maxlength="40"
                                                                             value="<?php echo base64_decode($tecnico['senha']) ?>" />
                                        <p class="p-large">Instituição: </p><input type="text" id="inputText" name="txtinst" class="form-control p-small" maxlength="40"
                                                                                   value="<?php echo $tecnico['instituicao'] ?>" />
                                        <p class="p-large">Curso: </p><input type="text" id="inputText" name="txtcurso" class="form-control p-small" maxlength="40"
                                                                             value="<?php echo $tecnico['curso'] ?>" />
                                        <p class="p-large">Foto: </p><input class="form-control-file" type="file" name="pictures[]"/><br>
                                        <button type="submit" class="btn btn-primary btn-lg p-large botao center-block" name="btn">Alterar</button>
                                        <?php
                                    endforeach;
                                    ?>
                                </form>

                                </body>
                                </html>