<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
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

        mysqli_query($conexao, "SET NAMES 'utf8'");
        mysqli_query($conexao, 'SET character_set_connection=utf8');
        mysqli_query($conexao, 'SET character_set_client=utf8');
        mysqli_query($conexao, 'SET character_set_results=utf8');

        $cpfTec = $_SESSION['cpfTecProcurado'];
        $user = $_SESSION['nome'];
        $cpf = pegaCpfUsuarioLogado($conexao, $user);
        $tecnicos = pegaInformacoesTecnicoPerfil($conexao, $cpfTec);
        $voto = verificaVoto($conexao, $cpf, $cpfTec, 0, 'carregando');
//        if(!empty($voto[0])){
//            header('location: pag_perfilAberto.php?valorVoto='.$voto[0]);
//        }
        
        ?>
        
        <script>
        function aoCarregar(){
            
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
            if(voto === 1){
                document.getElementById("img#1").src = "estrelaCheia.jpg"
            } else if(voto === 2){
                for (var i = 1; i < 3; i++){
                document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            } else if(voto === 3){
                for (var i = 1; i < 4; i++){
                    document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            } else if(voto === 4){
                for (var i = 1; i < 5; i++){
                    document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                }
            } else if(voto === 5){
                for (var i = 1; i < 6; i++){
                    document.getElementById("img#" + i).src  = "estrelaCheia.jpg"
                }
            } else {
                alert("Erro ao carregar voto!") 
            }
        }
        </script>
        
        <?php
        if ($tecnicos != null) {
            ?>
            <table border = "1">
                <tr>
                    <td>Foto</td>
                    <td>Nome</td>
                    <td>Sobrenome</td>
                    <td>Data de Nascimento</td>
                    <td>Logradouro</td>
                    <td>Estado</td>
                    <td>Bairro</td>
                    <td>Cep</td>
                    <td>Cidade</td>
                    <td>Numero Da Casa</td>
                    <td>Complemento</td>
                    <td>DDD</td>
                    <td>Número</td>
                    <td>Tipo de telefone</td>
                    <td>Instituição</td>
                    <td>Curso</td>
                    <td>Avaliação</td>
                </tr>


                <?php
                foreach ($tecnicos as $tecnico):
                    ?>   
                    <tr>
                        <td><img src="<?php $tecnico['foto'] ?>" height="40" width="40"></td>
                        <td><?php echo $tecnico['nome'] ?></td>
                        <td><?php echo $tecnico['sobrenome'] ?></td>
                        <td><?php echo $tecnico['data_nascimento'] ?></td>
                        <td><?php echo $tecnico['logradouro'] ?></td>
                        <td><?php echo $tecnico['estado'] ?></td>
                        <td><?php echo $tecnico['bairro'] ?></td>
                        <td><?php echo $tecnico['cep'] ?></td>
                        <td><?php echo $tecnico['cidade'] ?></td>
                        <td><?php echo $tecnico['num'] ?></td>
                        <td><?php echo $tecnico['complemento'] ?></td>   
                        <td><?php echo $tecnico['ddd'] ?></td>
                        <td><?php echo $tecnico['numero'] ?></td>
                        <td><?php echo $tecnico['tipo_telefone'] ?></td>
                        <td><?php echo $tecnico['instituicao'] ?></td>
                        <td><?php echo $tecnico['curso'] ?></td>
                        <td><?php echo $voto[1] ?> </td>
                    </tr>
                </table></br>
                <form method="get" action="#" >
                    Dê sua avaliação sobre esse técnico.</br>
                    <input name="enviar" type="image" id="img#1" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                    <input name="enviar" type="image" id="img#2" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
                    <input name="enviar" type="image" id="img#3" src="estrelaVazia.jpg" onload="aoCarregar()" onmouseover="mouseDentro(id)" onmouseout="mouseFora()" onclick="mouseClick(id); return false;" alt="avaliacao">
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
                if(($valorVoto > 0) && ($valorVoto<6)){
                verificaVoto($conexao, $cpf, $cpfTec, $valorVoto, 'votando');
                unset($valorVoto);
                }
            } else {
                echo '<script>alert("Erro ao votar")</script>';
                unset($valorVoto);
            }
        }
        ?>
        <input type="submit" value="Voltar" onclick="voltar()" name="btn"><br>
        <script>
           function voltar(){ 
            window.location = "pag_contratosTec.php"
           }

            function mouseDentro(id){
                document.getElementById(id).src = "estrelaCheia.jpg"
                if (id === "img#2"){
                    document.getElementById("img#1").src = "estrelaCheia.jpg"
                    document.getElementById("img#2").src = "estrelaCheia.jpg"
                } else if (id === "img#3"){
                    for (var i = 1; i < 4; i++){
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else if (id === "img#4"){
                    for (var i = 1; i < 5; i++){
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                } else if (id === "img#5"){
                    for (var i = 1; i < 6; i++){
                        document.getElementById("img#" + i).src = "estrelaCheia.jpg"
                    }
                }
            }
            function mouseFora(){
                for (var i = 1; i < 6; i++){
                    document.getElementById("img#" + i).src = "estrelaVazia.jpg"
                }
            }

            function mouseClick(id){
                var valorVoto = document.getElementById(id).id;
                var voto = valorVoto[4];
                    window.location = "pag_perfilAberto.php?voto=" + voto;
            }
            </script>

    </body>
</html>
