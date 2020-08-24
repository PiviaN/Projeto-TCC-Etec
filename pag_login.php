<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Tela de Login</title>
    </head>
    <body>
        <form method="post" action="verificaLogin.php">
            Usuário: <input type="text" name="txtu"><br>
            Senha:   <input type="password" name="txts"><br>
            <input type="submit" value="Logar">         
        </form>
        <form method="post" action="pag_cadastrar_cliente.php">
          <input type="submit" value="Cadastrar-se"><br>          
        </form>

        
    </body>
</html>
