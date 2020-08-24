<?php

//include('banco-usuario.php');
//include('conexao.php');
//
//session_start();
//
//$email = 'leandrorevolve@gmail.com';
//$login = 'teste';
//$senha = '123';
//
//
//require_once("PHPMailerAutoload.php");
//
//$mail = new PHPMailer();
//$mail->isSMTP();
//$mail->Host='127.0.0.1';
//$mail->Port=587;
//$mail->SMTPSecure ='tls';
//$mail->SMTPAuth = true;
//$mail->Username = "leandrorevolve@gmail.com"; // email e senha de quem vai enviar
//$mail->Password = "Leandro24";
//
//$mail->setFrom("leandrorevolve@gmail.com", "TecFind");  // quem vai enviar
//$mail->addAddress("gilzequipamentos@gmail.com"); 		// destinatario
//$mail->Subject = "Recuperação de senha - TecFind"; 		// assunto
//$mail->msgHTML('Login: '.$login.' Senha: '.$senha); 	// corpo do email
//
//if($mail->send()){
//	echo "Mensagem enviada com Sucesso";
//    // header("Location: index.php");
//} else {
//
//	echo error_get_last();
//    // header("Location: index.php");
//
//}


//$email = 'leandrorevolve@gmail.com'; // @$_POST['txte'];
//
//$Login = 'ass';
//$senha = 'asd';
//
//$headers = "";
//
//$corpo = ' TecFind'
//        . 'Olá, aqui está seu login e senha'
//        . 'Login: '.$Login
//        . 'Senha: '.$senha;
//
//$headers = "MIME-Version :1.0\r\n";
//$headers .= "Content-type: text/html; charset=iso-8859-1\r\m";
//$headers .= "From: Tecfind";
//
//if(mail($email, "TecFind - Senha", $corpo, $headers, $message)){
//    echo 'FOI';
//} ELSE {
//    ECHO ' ava';
//}

#inclui a classe PHPMAILER
include("PHPMailerAutoload.php");
#instancia o objeto
$mail = new PHPMailer();
#enviar via SMTP
$mail->IsSMTP();
#seu servidor smtp / dominio no meu caso "mail" mas pode mudar verifique o seu!
$mail->Host = "localhost";
#habilita smtp autenticado
$mail->SMTPAuth = true;
#usuário deste servidor smtp. Aqui esta a solucao
$mail->Username = "leandrorevolve@gmail.com";
$mail->Password = "Leandro24"; // senha
#email utilizado para o envio, pode ser o mesmo de username
$mail->From = "leandrorevolve@gmail.com";
$mail->FromName = "Tec Find - Recuperação de senha";

#Enderecos que devem receber a mensagem
$mail->AddAddress("leandrorevolve@gmail.com","Vendas");
#wrap seta o tamanhdo do texto por linha
$mail->WordWrap = 50;
$mail->IsHTML(true); //enviar em HTML

#recebendo os dados do formulario
if(isset($_POST['txte'])){
 $email = $_POST['txte'];
 $nome = "Jorge";

 #informando a quem devemos responder. o mail inserido no formulario
 $mail->AddReplyTo("$email","$nome");
 #criando o codigo html para enviar no email, voce pode utilizar qualquer tag html
 $msg = "Contato Site";
 $msg .= " Nome: $nome";
 $msg .= " E-mail: $email";
 $msg .= " Mensagem: aaa";
 }

$mail->Subject = "ASSUNTO DO EMAIL";
#adicionando o html no corpo do email
$mail->Body = $msg;
#enviando e retornando o status de envio
if(!$mail->Send())
{
echo "houve um erro ao enviar o email! erro: $mail->ErrorInfo";
#$mail->ErrorInfo informa onde ocorreu o erro, o uso opcional
exit;
}
echo "Mensagem enviada ok";
