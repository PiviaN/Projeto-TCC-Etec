<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script>alert("Você já está relacionado a um chamado.");</script>
        <title>Cancelar chamado</title>
    </head>
    <body>
        <?php
            if ($_SESSION['log'] != "ativo") {
                session_destroy();
                header("location: index.php");
            }
        ?>
        <form method="post" action="cancelaChamado.php">
            Você deseja cancelar o chamado?<br>
            <input type="radio" name="rb" value="sim" required> Sim<br>
            <input type="radio" name="rb" value="nao" checked required> Não<br>
            <input type="submit" value="Cancelar" name="btn"><br>
        </form>

    </body>
</html>
