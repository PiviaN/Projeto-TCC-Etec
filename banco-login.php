<?php

function efetuarLogin($conexao, $user, $senha) {
    $senhaCriptografada = base64_encode($senha);
    $sql = "select * from tbl_login where usuario='{$user}'"
            . "and senha='{$senhaCriptografada}'";
    $resultado = mysqli_query($conexao, $sql);

    return mysqli_fetch_assoc($resultado);
}

function verificaTipoUsuario($conexao, $user) {
    $sql = "select id_tp_usuario from tbl_usuario 
    inner join tbl_login on tbl_usuario.cpf = tbl_login.cpf_usuario where usuario = '$user'";
    $resultado = mysqli_query($conexao, $sql);

    return mysqli_fetch_assoc($resultado);
}
