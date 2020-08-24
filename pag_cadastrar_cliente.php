<!DOCTYPE html>
<?php
///*Esse código analisa se a sessão verifica é diferente do valor ativo
//Se verifica estiver diferente de ativo, o if vai destruir a sessão e
//redirecionar para a tela de login*/
//if ($_SESSION['verifica'] !="ativo") {
//session_destroy();
//header("location: pag_login.php");
//}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>

    </head>

    <body>
    <?php
        if (isset($_GET['erro'])) {
            $erro = $_GET['erro'];
            switch ($erro){
                    case 'cpf':
                        //
                        echo '<script> alert("CPF já cadastrado!"); </script>';
                        break;
                    case 'user':
                        //
                        echo '<script> alert("Usuário já cadastrado!"); </script>';
                        break;
                    case 'erro':
                        //
                        echo '<script> alert("Erro ao cadastrar!"); </script>';
                        break;
                }
        }
    ?>
        <form id="cad" method="post" action="inserirUsuario.php">
            <pre>

    <h3>Dados pessoais</h3>
    Nome:                <input type="text" name="txtnome"><br>
    Sobrenome:           <input type="text" name="txtsobrenome"><br>
    Data de nascimento:  <input type="date" name="txtdata_nasc"  ><br>
    CPF:                 <input type="text" name="txtCPF" maxlength="14" /><br>  
    
    <h3>Dados para Contato</h3>
    DDD:      <input type="text"  name="txtDDD" placeholder="Ex: (##)"  maxlength="2" /><br>
    Tipo:     <input type="radio" name="rbT" value="Celular" checked > Celular<br>
              <input type="radio" name="rbT" value="Telefone"> Telefone<br>   
    Numero:   <input type="text"  name="txtContato"  maxlength="9" /><br>  
    Email:    <input type="text"  name="txtEmail"  /><br>

     <h3>Dados do Endereço</h3>
    Logradouro:    <input type="text" name="txtRua"><br>
    Bairro:        <input type="text" name="txtBairro"><br>
    Cidade:        <input type="text" name="txtCidade"><br>
    Estado:        <select name="cbEstado">
                   <option>Selecione</option>
                   <option>São Paulo</option>
                   </select> <br>
    Número:        <input type="text" name="txtNumero"><br>
    Cep:           <input type="text" name="txtCep" placeholder="Ex: #####-###" maxlength="8"><br>
    Complemento:   <input type="text" name="txtComplemento"><br>
    
    <h3>Dados da conta</h3>
                           <input type="hidden" id="action" name="action" />
    Nome de usuário:       <input type="text" name="txtLogin" id="txtLogin"><br>
    Senha:                 <input type="password" name="txtsenha"><br>
    Confirmação da senha:  <input type="password" name="txtCsenha"><br>  
    Tipo de usuário: 
              <input type="radio" name="rb" value="Usuario" checked > Cliente<br>
              <input type="radio" name="rb" value="Tecnico"> Técnico<br>
                                          
    <input type="submit" value="Cadastrar" name="btn"><br>
            </pre>
            <!--
                    </form>
            
                    <script>
                        function teste() {
                            var user = document.getElementById('txtLogin').value
                            var cpf = document.getElementById('txtCPF').value
                            if (user != ''){
                                window.location = "pag_cadastrar_cliente.php?user=" + user;
                            } else if (cpf != ''){
                                window.location = "pag_cadastrar_cliente.php?cpf=" + cpf;
                            } else {
                                window.location = "pag_cadastrar_cliente.php?user=" + user +"&cpf=" +cpf;
                            }
                        }
                    </script>
            <?php
//        require_once 'conexao.php';
//        require_once 'banco-usuario.php';
//        if(isset($_GET['user'])){
//            $user = $_GET['user'];
//            $qtd = verificaUsuarioExistente($conexao, $user);
//            if($qtd != 0){
//                echo '<script>alert("Usuário já cadastrado")</script>';
//            }
//        }
//        if(isset($_GET['cpf'])){
//            $cpf = $_GET['cpf'];
//            $qtd = verificaCpfExistente($conexao, $cpf);
//            if($qtd != 0){
//                echo '<script>alert("CPF já cadastrado")</script>';
//            }
//        }
            ?>
            -->
    </body>
</html>
