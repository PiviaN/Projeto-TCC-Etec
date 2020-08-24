<!--Essa página destroi todas as sessões abertas-->
<?php
//Inicializando a sessão...
session_start();
//Destruindo a sessão
session_destroy();
//Redireciona
//O utilizador depois da destruição da sessão...
header("Location: index.php");
