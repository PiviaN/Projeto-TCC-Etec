<?php

require_once 'gerarCoordenadas.php';

function inserirUsuario($conexao, $cpf, $nome, $sobrenome, $data_nasc, $dataR, $tipoUsuario) {
    $sql = "insert into tbl_usuario" . "(cpf,nome,sobrenome,data_nascimento,data_hora_reg,contaStatus,id_tp_usuario)" .
            "values($cpf,'$nome','$sobrenome','$data_nasc','$dataR','ativo',$tipoUsuario)";
    return mysqli_query($conexao, $sql);
}

function inserirTelefone($conexao, $ddd, $numero, $tipo_tel, $cpf) {
    $sql = "insert into tbl_telefone" . "(ddd,numero,tipo_telefone,cpf_usuario)" .
            "values('$ddd','$numero','$tipo_tel',$cpf)";
        echo $sql;
    return mysqli_query($conexao, $sql);
}

function inserirEndereco($conexao, $logradouro, $bairro, $cidade, $estado, $cep, $numero, $complemento, $cpf, $coordenadas) {
    $sql = "insert into tbl_endereco" . "(logradouro,bairro,cidade,estado,cep,num,complemento,cpf_usuario, coordenadas)" .
            "values('$logradouro','$bairro','$cidade',',$estado',$cep,$numero,'$complemento',$cpf, ST_GeomFromText('$coordenadas'))";
    return mysqli_query($conexao, $sql);
}

function inserirEmail($conexao, $email, $cpf) {
    $sql = "insert into tbl_email" . "(email,cpf_usuario)" .
            "values('$email',$cpf)";
    return mysqli_query($conexao, $sql);
}

function inserirLogin($conexao, $usuario, $senha, $cSenha, $cpf) {
    $sql = "insert into tbl_login" . "(usuario,senha,conf_senha,cpf_usuario)" .
            "values('$usuario','$senha','$cSenha',$cpf)";
    return mysqli_query($conexao, $sql);
}

function inserirFormacao($conexao, $instituicao, $curso, $cpf) {
    $sql = "insert into tbl_login" . "(usuario,senha,conf_senha,cpf_usuario)" .
            "values('$usuario','$senha','$cSenha',$cpf)";
    return mysqli_query($conexao, $sql);
}

function verificaDados($conexao, $cpf, $user) {
    $rs = array();
    $resultado1 = mysqli_query($conexao, "select cpf from tbl_usuario where cpf = $cpf");
    if($resultado1 === true){
        $msg1 = mysqli_fetch_array($resultado1);
        $row = mysqli_fetch_array($msg1, MYSQLI_ASSOC);
        $rs[0] = $row["cpf"];
    } else {
        $rs[0] = null;
    }

    $resultado2 = mysqli_query($conexao, "select usuario as user from tbl_login where usuario = $user");
    if($resultado2 === true){    
        $msg2 = mysqli_fetch_array($resultado2);
        $row2 = mysqli_fetch_array($msg2, MYSQLI_ASSOC);
        $rs[1] = $row2["user"];
    } else {
        $rs[1] = null;
    }
    
    if(($rs[0] != null) || ($rs[1] != null)){
        return 'erro';
    } else {
        return 'sucesso';
    }
    
}

function cadastraUsuario($conexao, $cpf, $nome, $sobrenome, $data_nasc, $email, $logra, $bairro, $cidade, $estado, $cep, $numero, $complemento, $ddd, $contato, $tipoContato, $senhaCriptografada, $login, $senhaCriptografada, $tipousuario) {
    $sql = "call cadastroUsuario('$cpf', '$nome', '$sobrenome', '$data_nasc', '$email', '$logra', '$bairro', '$cidade', '$estado', $cep, $numero, '$complemento', '$ddd', '$contato', '$tipoContato', '$senhaCriptografada', '$login', '$senhaCriptografada', $tipousuario, @msgCPF, @msgUsu, @msgVerifica)";
    echo $sql;
    $resultado = mysqli_query($conexao, $sql);
    if ($resultado === true) {
        $rs = array();
        echo 'c';
        $resultado2 = mysqli_query($conexao, "select @msgCPF as cpf");
        $msg = mysqli_fetch_array($resultado2);
        $row = mysqli_fetch_array($msg, MYSQLI_ASSOC);
        $rs[0] = $row["cpf"];
        // 
        $resultado3 = mysqli_query($conexao, "select @msgUsu as user");
        $msg1 = mysqli_fetch_array($resultado3);
        $row2 = mysqli_fetch_array($msg1, MYSQLI_ASSOC);
        $rs[1] = $row2["user"];
        //
        $resultado4 = mysqli_query($conexao, "select @msgVerifica as msg");
        $msg2 = mysqli_fetch_array($resultado4);
        $row3 = mysqli_fetch_array($msg2, MYSQLI_ASSOC);
        $rs[2] = $row3["msg"];
        for ($i = 0; $i < 4; $i++) {
            if ($rs[$i] === "erro") {
                switch ($rs[i]) {
                    case 0:
                        return 'cpf';
                        break;
                    case 1:
                        return 'user';
                        break;
                    case 2:
                        return 'erro';
                        break;
                }
            }
        }
        mysqli_query($conexao, "set @msgCPF = ''");
        mysqli_query($conexao, "set @msgUsu = ''");
        mysqli_query($conexao, "set @msgVerifica = ''");
        return 'sucesso';
    } else {
        echo 'd';
        mysqli_query($conexao, "set @msgCPF = ''");
        mysqli_query($conexao, "set @msgUsu = ''");
        mysqli_query($conexao, "set @msgVerifica = ''");
        return 'cpf';
    }
}

function pegaInformacoesTecnico($conexao, $nome, $sobrenome) {
    $tecnicos = array();
    $sql = "select * from listarTecnico where nome like '%$nome%' and sobrenome like '%$sobrenome%'";
    $resultado = mysqli_query($conexao, $sql);
    while ($tecnico = mysqli_fetch_assoc($resultado)) {
        array_push($tecnicos, $tecnico);
    }
    return $tecnicos;

    //  printf("Result set has %d rows.\n",$rowcount);
    //  $rowcount=mysqli_num_rows($resultado);
    //  echo $sql;
}

function listarTecnicoOpcao($conexao, $cpf, $opcao){
    switch ($opcao){
                case 3:
                    $tecnicos = calcularDistancia($conexao, $cpf);
                    return $tecnicos;
                break;
                case 5:
                    $tecnicos = calcularDistancia($conexao, $cpf);
                    return $tecnicos;
                break;
                case 10:
                    $tecnicos = calcularDistancia($conexao, $cpf);
                    return $tecnicos;
                break;
                case 'cidade':
                    
                break;
                default :
                    return null;
                break;
            }
}

function pegaInformacoesCliente($conexao, $cpf) {
    $clientes = array();
    $sql = "select * from listarCliente where cpf = $cpf";
    $resultado = mysqli_query($conexao, $sql);

    while ($cliente = mysqli_fetch_assoc($resultado)) {
        array_push($clientes, $cliente);
    }
    return $clientes;
}

function pegaInformacoesTecnicoPerfil($conexao, $cpf) {
    $tecnicos = array();
    $sql = "select * from listarTecnico where cpf = $cpf";
    $resultado = mysqli_query($conexao, $sql);
    while ($tecnico = mysqli_fetch_assoc($resultado)) {
        array_push($tecnicos, $tecnico);
    }
    return $tecnicos;
}

function alteraClienteUsuario($conexao, $cpf, $logradouro, $cep, $bairro, $cidade, $estado, $numCasa, $tel, $ddd, $complemento, $email, $senha, $tipo_tel, $foto) {
    $senha = base64_encode($senha);
    $sql = "call atualizaUsuario ($cpf, '$logradouro', $cep, '$bairro', '$cidade', '$estado', $numCasa, '$tel','$ddd', '$complemento', '$email', '$senha', '$tipo_tel', '$foto')";
    return mysqli_query($conexao, $sql);
}

function alteraTecnicoUsuario($conexao, $cpf, $logradouro, $cep, $bairro, $cidade, $estado, $numCasa, $tel, $ddd, $complemento, $email, $senha, $tipo_tel, $instituicao, $curso, $foto) {
    $senha = base64_encode($senha);
    $sql = "call atualizaTecnico ($cpf, '$logradouro', $cep, '$bairro', '$cidade', '$estado', $numCasa, '$tel', '$ddd', '$complemento', '$email', '$senha', '$tipo_tel', '$instituicao', '$curso', '$foto')";
    return mysqli_query($conexao, $sql);
}

function verificaUsuarioExistente($conexao, $nome) {
    $sql = "select count(usuario) as usuario from tbl_login where usuario = '$nome'";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
    return $row["usuario"];
}

function verificaCpfExistente($conexao, $cpf) {
    $sql = "select count(cpf) as cpf from tbl_usuario where cpf = $cpf";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
    return $row["cpf"];
}

function verificaVoto($conexao, $cpfUser, $cpfTec, $voto, $estado) {

    if (($estado == 'votando') || ($estado == 'carregando')) {
        $sql = "select count(valor_voto) as valor_voto  from tbl_avaliacao where cpf_votado = $cpfTec and cpf_votante = $cpfUser";
        $return = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_array($return, MYSQLI_ASSOC);

        if ($estado == 'votando') {
            if ($row['valor_voto'] != 0) {
                $sql = "update tbl_avaliacao set valor_voto = $voto where cpf_votado = $cpfTec and cpf_votante = $cpfUser";
                return mysqli_query($conexao, $sql);
            } else {
                $sql = "insert into tbl_avaliacao(cpf_votante, cpf_votado, data_hora_reg, valor_voto) values ($cpfUser, $cpfTec, now(), $voto)";
                return mysqli_query($conexao, $sql);
            }
        } else if ($estado == 'carregando') {

            if ($row['valor_voto'] != 0) {
                //verifica se já foi votado
                $sql = "select valor_voto from tbl_avaliacao where cpf_votado = $cpfTec and cpf_votante = $cpfUser";
                $return = mysqli_query($conexao, $sql);
                $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
                //conta os votos que o técnico recebeu
                $sql2 = "select count(valor_voto) as qtd_votos from tbl_avaliacao where cpf_votado = $cpfTec;";
                $return = mysqli_query($conexao, $sql2);
                $row2 = mysqli_fetch_array($return, MYSQLI_ASSOC);
                $qtdVotos = $row2["qtd_votos"];
                //soma os votos recebidos pelo técnico
                $sql3 = "select sum(valor_voto) as soma_votos from tbl_avaliacao where cpf_votado = $cpfTec;";
                $return = mysqli_query($conexao, $sql3);
                $row3 = mysqli_fetch_array($return, MYSQLI_ASSOC);
                $somaVotos = $row3["soma_votos"];
                // calcula a avaliação geral
                if (($qtdVotos != 0) && ($somaVotos != 0)) {
                    $avalFinal = number_format($somaVotos / $qtdVotos, 1, '.', '');
                } else {
                    $avalFinal = 'Não avaliado';
                }
                $voto = array($row["valor_voto"], $avalFinal);
                return $voto;
            }
        }
    } else if ($estado == 'perfil') {

        //conta os votos que o técnico recebeu
        $sql2 = "select count(valor_voto) as qtd_votos from tbl_avaliacao where cpf_votado = $cpfTec;";
        $return = mysqli_query($conexao, $sql2);
        $row2 = mysqli_fetch_array($return, MYSQLI_ASSOC);
        $qtdVotos = $row2["qtd_votos"];
        //soma os votos recebidos pelo técnico
        $sql3 = "select sum(valor_voto) as soma_votos from tbl_avaliacao where cpf_votado = $cpfTec;";
        $return = mysqli_query($conexao, $sql3);
        $row3 = mysqli_fetch_array($return, MYSQLI_ASSOC);
        $somaVotos = $row3["soma_votos"];
        // calcula a avaliação geral
        if (($qtdVotos != 0) && ($somaVotos != 0)) {
            $avalFinal = number_format($somaVotos / $qtdVotos, 1, '.', '');
        } else {
            $avalFinal = 'Não avaliado';
        }
        return $avalFinal;
    }
}

function geraNovoNomeFoto() {
    foreach ($_FILES["pictures"] ["error"] as $key => $error) {//pictures é o campo que busca a foto
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["pictures"]["tmp_name"][$key]; //Buscando nome temporário da foto
            $name = $_FILES ["pictures"]["name"][$key]; //Atribuindo novo nome a foto
            move_uploaded_file($tmp_name, "fotos/$name"); //Fazendo o upload da foto para a pasta arquivo 
            //OBS: a pasta deve ser criada dentro do projeto
            $var = "fotos/$name";

            $ext = $var;
            $ext = substr($ext, -4); //Buscando a extensão da foto
            if ($ext[0] == '.') {
                $ext = substr($ext, -3);
            }
            $novonome = "fotos/" . md5(uniqid(time())) . "." . $ext; //Dando a foto um nome unico com base no tempo - md5 criptografa esse nome

            rename($var, $novonome); //Renomenado o arquivo
            // echo $novonome;
            return $novonome;
        }
    }
}

function listarNotificacaoTec($conexao, $cpfUsuario, $tipoCPF, $estado1, $estado2) {
    $notificacoes = array();
    if ($estado1 == null) {
        $sql = "select * from listarNotificacaoTec where datareg is null and estadoVisu <> 'naoVisu' and $tipoCPF = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    } else if ($estado2 == 'id') {
        $notificacoes = array();
        $sql = "select * from listarNotificacaoCli where $tipoCPF = $cpfUsuario and id_contrato = $estado1";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    } else {
        $notificacoes = array();
        $sql = "select * from listarNotificacaoTec where $tipoCPF = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    }
}

function listarNotificacaoCli($conexao, $cpfUsuario, $tipoCPF, $estado1, $estado2) {
    if ($estado1 == null) {
        $notificacoes = array();
        $sql = "select * from listarNotificacaoCli where datareg is null and estadoVisu <> 'naoVisu' and $tipoCPF = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    } else if ($estado2 == 'id') {
        $notificacoes = array();
        $sql = "select * from listarNotificacaoCli where $tipoCPF = $cpfUsuario and id_contrato = $estado1";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    } else {
        $notificacoes = array();
        $sql = "select * from listarNotificacaoCli where $tipoCPF = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        while ($notificacao = mysqli_fetch_assoc($return)) {
            array_push($notificacoes, $notificacao);
        }
        return $notificacoes;
    }
}

function carregarNotificacao($conexao, $cpfUsuario, $tipoCPF, $estado1, $estado2) {
    if ($tipoCPF === 'cpf_cliente') {
        $sql = "select count(estadoVisu) as notificacao from carregarNotificacaoTec where datareg is null and estadoVisu <> 'naoVisu' and cpf_cliente = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
        return $row['notificacao'];
    } else if ($tipoCPF === 'cpf_tecnico') {
        $sql = "select count(estadoVisu) as notificacao from carregarNotificacaoTec where datareg is null and estadoVisu <> 'naoVisu' and cpf_tecnico = $cpfUsuario";
        $return = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
        return $row['notificacao'];
    }
}

function atualizarEstadoContratoTec($conexao, $cpfUsuario, $cpfTecnico, $valor, $id) {
    if ($valor == 'conf') {
        $sql = "update tbl_contrato set estadoContrato = 'ConfirmadoTecnico' where cpf_cliente = $cpfUsuario and cpf_tecnico = $cpfTecnico and estadoContrato = 'Confirmado'";
        return mysqli_query($conexao, $sql);
    } else if ($valor == 'cancel') {
        $sql = "update tbl_contrato set estadoContrato = 'Em espera', data_acertada = null, cpf_tecnico = null where cpf_cliente = $cpfUsuario and cpf_tecnico = $cpfTecnico and id_contrato = $id";
        return mysqli_query($conexao, $sql);
    } else if ($valor === 'apagar'){
        $sql = "update tbl_contrato set estadoContrato = 'Em espera', data_acertada = null, cpf_tecnico = null where id_contrato = $id";
        return mysqli_query($conexao, $sql);
    }
}

function atualizarEstadoContratoCli($conexao, $cpfUsuario, $cpfTecnico, $valor, $id) {
    if ($valor == 'conf') {
        $sql = "update tbl_contrato set estadoContrato = 'Confirmado' where cpf_cliente = $cpfUsuario and cpf_tecnico = $cpfTecnico and estadoContrato = 'Em analise'";
        echo $sql;
        return mysqli_query($conexao, $sql);
    } else if ($valor == 'cancel') {
        $sql = "update tbl_contrato set estadoContrato = 'Em espera', data_acertada = null, cpf_tecnico = null where cpf_cliente = $cpfUsuario and cpf_tecnico = $cpfTecnico and id_contrato = $id";
        return mysqli_query($conexao, $sql);
    }
}

function atualizarEstadoNot($conexao, $id, $coluna) {
    if ($coluna === null) {
        $sql = "update tbl_notificacao set data_hora_reg_not = now() where id_contrato_fk = $id";
        return mysqli_query($conexao, $sql);
    } else if ($coluna === 'tec') {
        $sql = "update tbl_notificacao set data_hora_reg_not_tc = now() where id_contrato_fk = $id";
        return mysqli_query($conexao, $sql);
    }
}

function apagarContrato($conexao, $idcontrato){
    $sql = "update tbl_contrato set estadoContrato = 'Apagado' where id_contrato = $idcontrato";
    return mysqli_query($conexao, $sql);
}

function puxarFoto($conexao, $cpf){
    $sql = "select foto from tbl_usuario where cpf = $cpf";
    $return = mysqli_query($conexao, $sql);
    $row = mysqli_fetch_array($return, MYSQLI_ASSOC);
    return $row['foto'];
}
