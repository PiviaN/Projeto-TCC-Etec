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
        <title>TecFind - Fazer um Chamado</title>
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
                    <li class="p-small"><a href="pag_pesquisarTec.php">Pesquisar Técnicos</a>
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
                    <li class="active p-small"><a href="pag_cadastrar_chamado.php">Fazer um Chamado</a>
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
        <?php
        session_start();
        if ($_SESSION['log'] != "ativo") {
            session_destroy();
            header("location: index.php");
        }
        $_SESSION['log'] = 'ativo';
        ?>
       
    

    <br>
    <div class="col-md-6 col-centered text-center">
        <h1 class="h1-large">Crie um chamado!</h1>
        <p class="p-large">É fácil criar um chamado. Basta inserir alguns dados
            que os técnicos já estarão a caminho!</p>
        <br>
    </div>
    <div class="col-md-4 col-centered">
        <div class="well">
            <form method="post" action="inserirChamado.php" id="cad">
                <div class="form-group">
                    <label class="p-small" for="sel1">Selecione seu problema:</label>
                    <select class="form-control" id="sel1" name="cbProblema"> 
                        <option class="p-small" value="0">Selecione...</option>  
                        <option class="p-small" value="1">Computador reiniciando</option>
                        <option class="p-small" value="2">Computador liga, mas fica com tela preta com beeps</option>
                        <option class="p-small" value="3">Computador não reconhece a capacidade total da(s) memória(s)</option>
                        <option class="p-small" value="4">Computador só entra em modo de segurança</option>
                        <option class="p-small" value="5">Impressora com engasgo do papel</option>
                        <option class="p-small" value="6">Máquina não reconhece teclado e/ou mouse</option>
                        <option class="p-small" value="7">Máquina não conecta à Internet</option>
                        <option class="p-small" value="8">Portas USB não reconhecidas</option>
                        <option class="p-small" value="9">Computador liga, mas não gera</option>
                        <option class="p-small" value="10">Computador não emite som</option>
                    </select>
                </div>

                <label class="p-small" for="sel1">Não achou o seu problema? Descreva-o:</label>
                <input class="form-control p-small" type="text" name="txtDesc" placeholder="Descrição do problema">
                <br>
                <br>
                <label class="p-small" for="sel1">Data para o técnico comparecer ao seu endereço:</label>
                <input class="form-control p-small" type="date" name="txtDat" id="data" required="Esse campo é necessário!" >
                <br>
                <br>
                <button class="btn btn-lg btn-primary btn-block p-large botao" type="submit" id="btn1" onclick='validarFormulario(this.form);'>Cadastrar</button>
            </form>
        </div>
    </div>
 <script type="text/javascript">
            
                

                var verif = false;

                function validadata(dia) {
                    var data = document.getElementById("data").value; // pega o valor do input
                    data = data.replace(/\//g, "-"); // substitui eventuais barras (ex. IE) "/" por hífen "-"
                    var data_array = data.split("-"); // quebra a data em array
                    var dia = data_array[2];
                    var mes = data_array[1];
                    var ano = data_array[0];

                    // para o IE onde será inserido no formato dd/MM/yyyy
                    if (data_array[0].length != 4) {
                        dia = data_array[0];
                        mes = data_array[1];
                        ano = data_array[2];
                    }

                    var hoje = new Date();
                    var d1 = hoje.getDate();
                    var m1 = hoje.getMonth() + 1;
                    var a1 = hoje.getFullYear();

                    var d1 = new Date(a1, m1, d1);
                    var d2 = new Date(ano, mes, dia);

                    var diff = d2.getTime() - d1.getTime();
                    diff = diff / (1000 * 60 * 60 * 24);

                    if (diff < 0) {
                        alert("Data não pode ser anterior ao dia de hoje!");
                        event.preventDefault();
                        return;
                    } else if (diff > 7) {
                        alert("Data não pode ser maior que uma semana!");
                        event.preventDefault();
                        return;
                    }
                    verif = true;
                }
                function validarFormulario(cad) {
//                     validadata(cad.txtDat.value);
//                     if(verif == true){
//                         window.location = "inserirChamado.php";
//                     } else {
//                         window.location = "pag_cadastrar_chamado.php";
//                     }
//                     
                        
                    if (cad.txtDat.value.length !== 10) {
                        alert("Formato de datas inválido."
                                + " Por favor, preencha-o corretamente.");
                        return;
                    }

                    if (!validadata(cad.txtDat.value)) 
                        return;
                

                    cad.submit();
                    return false;
                }
           
            
        </script>
</body>
</html>
