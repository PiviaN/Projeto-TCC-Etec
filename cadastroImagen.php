<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Foto de perfil</title>
    </head>
    <body>
        <form action="#" method="post" enctype="multipart/form-data">
            <!--Importante deixa o enctype como multipart/form-data para o formulário aceitar arquivos-->

            <p>Selecione uma foto para o seu perfil:<br>
                <input type="file" name="pictures[]" /><br><br>
                <input type="submit" value="Enviar"/>
                <img src="fotos/a5a4a6c892cac8aef07f2c29ad64b78b.jpg" height="40" width="40">
                <br><br>
            </p>            

        </form>
    </body>
</html>
<?php
require_once 'conexao.php'; //Arquivo de Conexão
if (isset($_FILES["pictures"])) {
    foreach ($_FILES["pictures"] ["error"] as $key => $error) {//pictures é o campo que busca a foto
        if ($error == UPLOAD_ERR_OK) {

            $tmp_name = $_FILES["pictures"]["tmp_name"][$key]; //Buscando nome temporário da foto
            $name = $_FILES ["pictures"]["name"][$key]; //Atribuindo novo nome a foto
            move_uploaded_file($tmp_name, "fotos/$name"); //Fazendo o upload da foto para a pasta arquivo 
            //OBS: a pasta deve ser criada dentro do projeto
            $var = "fotos/$name";

            $ext = $var;
            $ext = substr($ext, -4); //Buscando a extensão da foto
            if ($ext[0] == '.') {
                $ext = substr($ext, -3);
            }
            $novonome = "fotos/" . md5(uniqid(time())) . "." . $ext; //Dando a foto um nome unico com base no tempo - md5 criptografa esse nome
            rename($var, $novonome); //Renomenado o arquivo
            $sql = "update tbl_usuario set foto = '$novonome' where cpf = 12345678911;";
            echo $sql;
            $sql = mysqli_query($conexao, $sql); //Inserindo na tabela
            if ($sql) {
                echo "Cadastrado com Sucesso!";
            } else {
                $msg = mysqli_errno($conexao);
                echo $msg;
            }
        }
    }
}
?>