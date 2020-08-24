
-- Views

-- lilistartecnicolistartecnicolistartecnicolistarnotificacaoteclistartecnicolistartecnicolistartecnicolistartecnicocarregarcontatoclistar informaçoes do tecnico 

create view listarTecnico as 
		select tbl_usuario.nome, tbl_usuario.cpf, tbl_usuario.sobrenome, tbl_usuario.foto, tbl_usuario.id_tp_usuario,
        tbl_telefone.ddd, tbl_telefone.numero, date_format(tbl_usuario.data_nascimento,"%d/%m/%Y") as data_nascimento,
        tbl_telefone.tipo_telefone, tbl_formacao.instituicao, tbl_formacao.curso, tbl_avaliacao.valor_voto,
        tbl_email.email, tbl_endereco.bairro, tbl_endereco.cep, tbl_endereco.cidade, tbl_endereco.complemento, tbl_login.senha,
        tbl_endereco.estado, tbl_endereco.logradouro, tbl_endereco.num, ST_AsText(coordenadas) as coord
        from tbl_usuario 
        left join tbl_telefone  on tbl_telefone.cpf_usuario = tbl_usuario.cpf  
        left join tbl_formacao  on tbl_formacao.cpf_usuario = tbl_usuario.cpf
        left join tbl_endereco  on tbl_endereco.cpf_usuario = tbl_usuario.cpf
        left join tbl_login     on tbl_login.cpf_usuario = tbl_usuario.cpf
        left join tbl_email     on tbl_email.cpf_usuario = tbl_usuario.cpf
        left join tbl_avaliacao on tbl_avaliacao.cpf_votado = tbl_usuario.cpf;-- where nome = 'João' and sobrenome = 'Brito';
        
-- pesquisar chamados abertos

create view listarChamados as 
	   select tbl_contrato.data_solicitado, tbl_contrato.id_contrato, tbl_contrato.detalhes, tbl_contrato.estadoContrato, tbl_endereco.logradouro, tbl_endereco.estado, 
	   tbl_endereco.bairro, tbl_endereco.cep, tbl_endereco.cidade, tbl_endereco.num, tbl_endereco.complemento, tbl_telefone.ddd,
       tbl_telefone.numero, tbl_usuario.nome, tbl_usuario.sobrenome, tbl_usuario.foto, tbl_contrato.cpf_cliente as cpf_cli, ST_AsText(coordenadas) as coord
	   from tbl_usuario 
	   left join tbl_telefone on tbl_telefone.cpf_usuario = tbl_usuario.cpf  
	   left join tbl_endereco on tbl_endereco.cpf_usuario = tbl_usuario.cpf
	   left join tbl_contrato on tbl_contrato.cpf_cliente = tbl_usuario.cpf;-- where cidade = 'aa' and estadoContrato = 'Em espera';

-- listar informaçoes do cliente

create view listarCliente as 
		select tbl_usuario.nome, tbl_usuario.cpf, tbl_usuario.sobrenome, date_format(tbl_usuario.data_nascimento,"%d/%m/%Y") as data_nascimento,
        tbl_telefone.ddd, tbl_telefone.numero, tbl_usuario.foto,
        tbl_telefone.tipo_telefone, tbl_email.email, tbl_login.senha,
        tbl_endereco.bairro, tbl_endereco.cep, tbl_endereco.cidade, tbl_endereco.complemento,
        tbl_endereco.estado, tbl_endereco.logradouro, tbl_endereco.num
        from tbl_usuario 
        left join tbl_telefone on tbl_telefone.cpf_usuario = tbl_usuario.cpf  
        left join tbl_login on tbl_login.cpf_usuario = tbl_usuario.cpf
        left join tbl_email on tbl_email.cpf_usuario = tbl_usuario.cpf
        left join tbl_endereco on tbl_endereco.cpf_usuario = tbl_usuario.cpf; -- where nome = 'Lucas' and sobrenome = 'Silva';
        
-- listar notificacoes

create view listarNotificacaoTec as 
select tbl_contrato.id_contrato, tbl_contrato.estadoContrato, tbl_contrato.detalhes, tbl_contrato.data_solicitado, tbl_contrato.data_acertada,
    tbl_contrato.cpf_tecnico, tbl_contrato.cpf_cliente, tbl_usuario.nome, tbl_usuario.foto, tbl_usuario.sobrenome, tbl_notificacao.estadoVisu,
    tbl_notificacao.id_contrato_fk, tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not_tc as datareg
    from tbl_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_cliente
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato;-- where v_tipoCpf = v_cpf and estadoContrato = 'v_estadoContrato';

create view listarNotificacaoCli as 
select tbl_contrato.id_contrato, tbl_contrato.estadoContrato, tbl_contrato.detalhes, tbl_contrato.data_solicitado, tbl_contrato.data_acertada,
    tbl_contrato.cpf_tecnico, tbl_contrato.cpf_cliente, tbl_usuario.nome, tbl_usuario.foto, tbl_usuario.sobrenome, tbl_notificacao.estadoVisu,
    tbl_notificacao.id_contrato_fk, tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not as datareg
    from tbl_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_tecnico
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato;

-- carregar notificações

create view carregarNotificacaoCli as
select tbl_contrato.cpf_cliente, tbl_contrato.cpf_tecnico, tbl_contrato.id_contrato, tbl_notificacao.estadoVisu, tbl_notificacao.id_contrato_fk,
	tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not as datareg
	from tbl_contrato
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_cliente; -- where cpf_tecnico = 12345678912 and estadoVisu = 'VisualizadoCli1' or estadoVisu = null;

create view carregarNotificacaoTec as
select tbl_contrato.cpf_cliente, tbl_contrato.cpf_tecnico, tbl_contrato.id_contrato, tbl_notificacao.estadoVisu, tbl_notificacao.id_contrato_fk,
	tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not as datareg
	from tbl_contrato
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_tecnico; -- where cpf_tecnico = 12345678912 and estadoVisu = 'VisualizadoCli1' or estadoVisu = null;
    
-- carregar contatos    
    
create view carregarContatoCli as 
	select tbl_usuario.*, tbl_mensagem.*
    from tbl_usuario
    left join tbl_mensagem on tbl_mensagem.cpf_cliente_fk = tbl_usuario.cpf; -- where cpf = 50374864837;

create view carregarContatoTec as 
	select tbl_usuario.*, tbl_mensagem.*
    from tbl_usuario
    left join tbl_mensagem on tbl_mensagem.cpf_tecnico_fk = tbl_usuario.cpf;

create view listarEnderecoMapa as 
	select tbl_endereco.bairro, tbl_endereco.cep, tbl_endereco.cidade, tbl_endereco.complemento,
        tbl_endereco.estado, tbl_endereco.logradouro, tbl_endereco.num, ST_AsText(coordenadas) as coord, tbl_contrato.*, tbl_usuario.*
	from tbl_endereco
	inner join tbl_usuario on tbl_usuario.cpf = tbl_endereco.cpf_usuario
	inner join tbl_contrato on tbl_contrato.cpf_cliente = tbl_usuario.cpf;
