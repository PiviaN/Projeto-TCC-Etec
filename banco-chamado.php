<?php

include ("conexao.php");

function verificaChamadoAbertoCliente($conexao, $cpf) {
    $sql = "select count(cpf_cliente) cpf_usuario from tbl_contrato where cpf_cliente = '$cpf' and estadoContrato = 'Em espera'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

    return $row["cpf_usuario"];
}

function verificaChamadoAbertoTecnico($conexao, $cpf) {
    $sql = "select count(cpf_tecnico) cpf_usuario from tbl_contrato where cpf_cliente = '$cpf' and estadoContrato = 'Em espera'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

    return $row["cpf_usuario"];
}

function pegaCpfUsuarioLogado($conexao, $user) {
    $sql = "select cpf_usuario from tbl_login where usuario = '$user'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

    return $row["cpf_usuario"];
}

function cancelaChamadoCliente($conexao, $cpf) {
    $sql = "update tbl_contrato SET estadoContrato='Cancelado' WHERE cpf_usuario='$cpf'";

    return mysqli_query($conexao, $sql);
}

function cancelaChamadoTecnico($conexao, $cpf) {
    $sql = "update tbl_contrato SET estadoContrato='Cancelado' WHERE cpf_usuario='$cpf'";

    return mysqli_query($conexao, $sql);
}

function pegaTipoUsuario($conexao, $cpf) {
    $sql = "select id_tp_usuario as tipo from tbl_usuario where cpf = '$cpf'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

    return $row["tipo"];
}

function listarChamadosAbertos($conexao, $lugar, $nomeLugar) {
    $chamados = array();
    $sql = "select * from listarChamados where $lugar = '$nomeLugar' and estadoContrato = 'Em espera'";
    $resultado = mysqli_query($conexao, $sql);

    while ($chamado = mysqli_fetch_assoc($resultado)) {
        array_push($chamados, $chamado);
    }
    return $chamados;
}

function listarChamadosDistancia($conexao) {
    $chamados = array();
    $sql = "select * from listarChamados where estadoContrato = 'Em espera'";
    $resultado = mysqli_query($conexao, $sql);
    while ($chamado = mysqli_fetch_assoc($resultado)) {
        array_push($chamados, $chamado);
    }
    return $chamados;
}

function pegaLugardoUsuario($conexao, $lugar, $cpf) {
    $sql = "select tbl_endereco.$lugar as lugar from tbl_endereco
                   inner join tbl_usuario on tbl_usuario.cpf = tbl_endereco.cpf_usuario where cpf = '$cpf'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

    return $row["lugar"];
}

function verificaCandidatura($conexao, $cpf) {
    $sql = "select estadoContrato from tbl_contrato where cpf = $cpf and estadoContrato = 'Em analise'";
    return mysqli_query($conexao, $sql);
}

function candidatarSe($conexao, $cpf, $idContrato) {
    $sql = "update tbl_contrato SET estadoContrato='Em analise', cpf_tecnico=$cpf WHERE id_contrato=$idContrato";
    return mysqli_query($conexao, $sql);
}

function inserirChamadoCliente($conexao, $data_acertada, $detalhes, $cpf_cliente) {
    $sql = "insert into tbl_contrato (estadoContrato, data_solicitado, data_acertada, detalhes, cpf_cliente, cpf_tecnico)"
            . " values ('Em espera', now(), '$data_acertada', '$detalhes', $cpf_cliente, null)";
    $result = mysqli_query($conexao, $sql);
    return $result;
}

function pegarProblema($op) {
    $resultado = "";
    switch ($op) {
        case 1:
            $resultado = 'Computador reiniciando';
            break;
        case 2:
            $resultado = 'Computador liga, mas fica com tela preta com beeps';
            break;
        case 3:
            $resultado = 'Computador não reconhece a capacidade total da(s) memória(s)';
            break;
        case 4:
            $resultado = 'Computador só entra em modo de segurança';
            break;
        case 5:
            $resultado = 'Impressora com engasgo do papel';
            break;
        case 6:
            $resultado = 'Máquina não reconhece teclado e/ou mouse';
            break;
        case 7:
            $resultado = 'Máquina não conecta à Internet';
            break;
        case 8:
            $resultado = 'Portas USB não reconhecidas';
            break;
        case 9:
            $resultado = 'Computador liga, mas não gera';
            break;
        case 10:
            $resultado = 'Computador não emite som';
            break;
        default :
            
            break;
    }
    return $resultado;
}
