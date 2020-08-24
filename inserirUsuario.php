<?php

include("conexao.php");
include("banco-usuario.php");
include("sign-up-form.html");
require_once './gerarCoordenadas.php';
session_start();

// Dados pessoais
if ($_POST) {
    if ($_POST["palavra"] == $_SESSION["palavra"]) {
        $nome = ($_POST['txtnome']);
        $sobrenome = ($_POST['txtsobrenome']);
        $data_nasc = ($_POST['txtdata_nasc']);
        $cpf = ($_POST['txtCPF']);

// Dados para contato
        $DDD = ($_POST['txtDDD']);
        $contato = ($_POST['txtContato']);
        $tipoContato = ($_POST['rbT']);
        $email = ($_POST['txtEmail1']);

//Dados do endereço
        $logra = ($_POST['txtRua']);
        $bairro = ($_POST['txtBairro']);
        $cidade = ($_POST['txtCidade']);
        $estado = ($_POST['cbEstado']);
        $numero = ($_POST['txtNumero']);
        $cep = ($_POST['txtCep']);
        $complemento = ($_POST['txtComplemento']);

// Dados da conta
        $tipoUsuario = ($_POST['rb']);
        if ($tipoUsuario == 'Tecnico') {
            $tipoUsuario = 1;
        } else {
            $tipoUsuario = 2;
        }
        $login = ($_POST['txtLogin']);
        $senha = ($_POST['txtsenha']);

// Variável com a senha guardada
        $senhaCriptografada = base64_encode($senha);
//echo base64_decode($senhaCriptografada); tira a criptografia

        $dataR = date('Y-m-d h:i:s');

// -----------------------------------------
//$resultado = cadastraUsuario($conexao, $cpf, $nome, $sobrenome, $data_nasc, $email, $logra, $bairro, $cidade, $estado, $cep, $numero, $complemento, $DDD, $contato, $tipoContato, $senhaCriptografada, $login, $senhaCriptografada, $tipoUsuario);        
//
//if($resultado === 'sucesso'){
//    echo 'b';
//    if($tipoUsuario === 2){
//        $_SESSION['log'] = 'ativo';
//        echo '<script> var r = confirm("Cadastrado com sucesso!")
//                            if (r === true) {
//                                window.location.assign("pag_menuCliente.php");                   
//                            } else {
//                                window.location.assign("pag_menuCliente.php");
//                            }
//                            </script>'; 
//    } else {
//        $_SESSION['log'] = 'ativoTecnico';
//        echo '<script> var r = confirm("Cadastrado com sucesso!")
//                            if (r === true) {
//                                window.location.assign("pag_menuTecnico.php");                   
//                            } else {
//                                window.location.assign("pag_menuTecnico.php");
//                            }
//                            </script>';
//    }
//} else {
//    echo 'b';
//    echo '<script> var r = confirm("Erro ao cadastrar")
//                            if (r === true) {
//                                window.location.assign("pag_cadastrar_cliente.php?erro='.$resultado.'");                   
//                            } else {
//                                window.location.assign("pag_cadastrar_cliente.php"erro='.$resultado.');
//                            }
//                            </script>';
//}

        $resultado = verificaDados($conexao, $cpf, $login);

        if ($resultado === 'sucesso') {
            if (inserirUsuario($conexao, $cpf, $nome, $sobrenome, $data_nasc, $dataR, $tipoUsuario)) {
                echo "Dado 1 inserido com sucesso!!" . "<br>";
                // $idUserCPF = $conexao->insert_id;
                $coordenadasEnd = gerarCoordenadas($logra . ',' . $cidade . '-' . $estado);
                // 0 = lat ; 1 = long
                $coordenadasEnd = 'POINT(' . $coordenadasEnd[0] . ' ' . $coordenadasEnd[1] . ')';

                if (inserirEndereco($conexao, $logra, $bairro, $cidade, $estado, $cep, $numero, $complemento, $cpf, $coordenadasEnd)) {
                    echo "Dado 2 inserido com sucesso!!" . "<br>";

                    if (inserirTelefone($conexao, $DDD, $numero, $tipoContato, $cpf)) {
                        echo "Dado 3 inserido com sucesso!!" . "<br>";

                        if (inserirLogin($conexao, $login, $senhaCriptografada, $senhaCriptografada, $cpf)) {
                            echo "Dado 4 inserido com sucesso!!" . "<br>";

                            if (inserirEmail($conexao, $email, $cpf)) {
                                echo "Dado 5 inserido com sucesso!!" . "<br>";

                                if ($tipoUsuario == 2) {
                                    $_SESSION['log'] = 'ativo';
                                    header('Location: pag_menuCliente.php');
                                    echo '<script> var r = confirm("Cadastrado com sucesso!")
                            if (r === true) {
                                window.location.assign("pag_contratosCli.php");                   
                            } else {
                                window.location.assign("pag_contratosCli.php");
                            }
                            </script>';
                                } else {
                                    $_SESSION['log'] = 'ativoTecnico';
                                    echo '<script> var r = confirm("Cadastrado com sucesso!")
                            if (r === true) {
                                window.location.assign("pag_contratosTec.php");                   
                            } else {
                                window.location.assign("pag_contratosTec.php");
                            }
                            </script>';
                                }
                                // else do inserirEmail   
                            } else {
                                $msg = mysqli_errno($conexao);
                                echo $msg;
                            }

                            // else do inserirLogin    
                        } else {
                            $msg = mysqli_errno($conexao);
                            echo $msg;
                        }

                        // else do inserirTelefone    
                    } else {
                        $msg = mysqli_errno($conexao);
                        echo $msg;
                    }
                    // else do inserirEndereco 
                } else {
                    $msg = mysqli_errno($conexao);
                    echo $msg;
                }
                // else do inserirUsuario  
            } else {
                $msg = mysqli_errno($conexao);
                echo $msg;
            }
        } else {
            echo '<script> var r = confirm("CPF ou Usuário já cadastrado!")
                            if (r === true) {
                                window.location.assign("sign-up-form.html");                   
                            } else {
                                window.location.assign("sign-up-form.html");
                            }
                            </script>';
        }
    } else {
        echo '<script> var r = confirm("Captcha errado!")
                            if (r === true) {
                                window.location.assign("sign-up-form.html");                   
                            } else {
                                window.location.assign("sign-up-form.html");
                            }
                            </script>';
    }
}

