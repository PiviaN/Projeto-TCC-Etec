<?php

header('Content-Type: text/html; charset=utf-8');

function listarContatos($conexao, $cpf, $tipo) {
    $contatos = array();
    if ($tipo == 2) {
        $sql = "select * from carregarContatoTec where cpf_cliente_fk = $cpf";
    } else {
        $sql = "select * from carregarContatoCli where cpf_tecnico_fk = $cpf";
    }
    $resultado = mysqli_query($conexao, $sql);
    while ($contato = mysqli_fetch_assoc($resultado)) {
        array_push($contatos, $contato);
    }
    return $contatos;
}

function addMensagem($documento, $mensagem, $cpf_origem) {
    // criar msg
    $msg = $documento->createElement("msg");
    // criar nó data
    $data = date('j/n/Y H:i:s');
    $dataElm = $documento->createElement("data_envio", $data);
    // criar nó origem
    $cpf_origemElm = $documento->createElement("cpf_origem", $cpf_origem);
    // criar nó mensagem (texto)
    $mensagemElm = $documento->createElement("mensagem", $mensagem);

    $msg->appendChild($dataElm);
    $msg->appendChild($cpf_origemElm);
    $msg->appendChild($mensagemElm);
    return $msg;
}

function gerarNomeXML() {
    $dir = "xml_msg";
    $novonome = $dir . "/" . md5(uniqid(time())) . ".xml";
    return $novonome;
}

function lerXML($dom, $conexao, $cpfCli, $cpfTec, $tipo) {
    criarContato($conexao, $cpfCli, $cpfTec);
    if ($tipo === 2) {
        $sql = "select caminho_xml as xml from tbl_mensagem where cpf_cliente_fk = $cpfCli and cpf_tecnico_fk = $cpfTec";
    } else {
        $sql = "select caminho_xml as xml from tbl_mensagem where cpf_cliente_fk = $cpfCli and cpf_tecnico_fk = $cpfTec";
    }
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
    $nomeArquivo = $row["xml"];
    if (!file_exists($nomeArquivo)) {
        $novonome = gerarNomeXML();
        guardarXML($conexao, $novonome, $cpfCli, $cpfTec, $tipo);
        $msg = addMensagem($dom, "Conectados!", null);
        // criando nó principal
        $root = $dom->createElement("mensagens");
        // adiciona a mensagem ao root
        $root->appendChild($msg);
        // adiciona o root ao xml
        $dom->appendChild($root);
        // retirar os espaços em branco
        $dom->preserveWhiteSpace = false;
        // gerar código ??
        $dom->formatOutput = true;
        $_SESSION['nomeXML'] = $novonome;
        $dom->save($novonome);
        $_SESSION['dom'] = $dom;
        return $root;
    } else {
        // carrega o arquivo
        $dom->load($nomeArquivo);
        $_SESSION['nomeXML'] = $nomeArquivo;
        // recupera nó principal
        $root = $dom->documentElement;
        $_SESSION['dom'] = $dom;
        return $root;
    }
}

function guardarXML($conexao, $caminho, $cpfCli, $cpfTec, $tipo) {
    if ($tipo == 2) {
        $sql = "update tbl_mensagem set caminho_xml = '$caminho' where cpf_cliente_fk = $cpfCli and cpf_tecnico_fk = $cpfTec";
    } else {
        $sql = "update tbl_mensagem set caminho_xml = '$caminho' where cpf_cliente_fk = $cpfCli and cpf_tecnico_fk = $cpfTec";
    }
    $resultado = mysqli_query($conexao, $sql);
    return $resultado;
}

function listarCpfMensagens($conexao, $cpf) {
    $cpfs = array();
    $sql = "select cpf_cliente_fk as cpf from tbl_mensagem where cpf_tecnico_fk = $cpf";
    $resultado = mysqli_query($conexao, $sql);
    while ($cpf = mysqli_fetch_assoc($resultado)) {
        array_push($cpfs, $cpf);
    }
    return $cpfs;
}

function criarContato($conexao, $cpfCli, $cpfTec) {
    $sql = "select id_msg as id from tbl_mensagem where cpf_cliente_fk = $cpfCli and cpf_tecnico_fk = $cpfTec";
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    if (!empty($row['id'])) {
        return true;
    } else {
        $sql = "insert into tbl_mensagem (cpf_cliente_fk, cpf_tecnico_fk, caminho_xml, estadoContato) values "
                . "($cpfCli, $cpfTec, null, 'ativo')";
        $resultado = mysqli_query($conexao, $sql);
        return $resultado;
    }
}

function pegarNomeCli($conexao, $cpf) {
    $sql = "select nome from tbl_usuario where cpf = $cpf";
    $resultado = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

    $sqll = "select sobrenome from tbl_usuario where cpf = $cpf";
    $resultado1 = mysqli_query($conexao, $sqll);
    $row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);

    return $row['nome'] . ' ' . $row1['sobrenome'];
}
