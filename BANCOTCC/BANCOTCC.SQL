create database tec_Find DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

drop database tec_find;

use tec_Find;

SET SQL_SAFE_UPDATES=0;

create table if not exists tbl_endereco(
id_end int not null auto_increment,
constraint id_end_fk primary key(id_end),
logradouro nvarchar(60) not null,
bairro nvarchar(50) not null,
cidade nvarchar(40) not null,
estado nvarchar(30) not null,
cep decimal(8) not null,
num int not null,
complemento nvarchar(200),
cpf_usuario varchar(11) not null unique,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_telefone(
id_tel int not null auto_increment,
constraint id_tel_pk primary key(id_tel),
ddd varchar(2),
numero varchar(15) not null,
tipo_telefone varchar(15) not null,
cpf_usuario varchar(11) not null unique,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_tipoUsuario(
id_tp_usuarioFk int not null auto_increment,
constraint id_tpUser_pk primary key(id_tp_usuarioFk),
tipo nvarchar(15)
);

create table if not exists tbl_email(
id_email int not null auto_increment,
constraint id_email_pk primary key(id_email),
email varchar(100) not null,
cpf_usuario varchar(11) not null unique,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_usuario(
cpf varchar(11) not null,
constraint cpf_usuario_pk primary key (cpf),
nome nvarchar(20) not null,
sobrenome nvarchar(20) not null,
data_nascimento date not null,
data_hora_reg datetime null DEFAULT NOW() not null,
contaStatus nvarchar(15) not null,
foto nvarchar(255),
id_tp_usuario int not null,
constraint id_tpUser_fk foreign key (id_tp_usuario) references tbl_tipoUsuario on delete cascade on update cascade
);

create table if not exists tbl_login(
id_login int not null auto_increment,
constraint id_login_fk primary key (id_login),
senha nvarchar(16) not null,
usuario nvarchar(50) not null,
conf_senha nvarchar(16) not null,
cpf_usuario varchar(11) not null unique,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_formacao(
id_form int not null auto_increment,
constraint id_form_pk primary key(id_form),
instituicao nvarchar(100) not null,
curso nvarchar(100) not null,
cpf_usuario varchar(11) not null,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_contrato(
id_contrato int not null auto_increment,
constraint id_contrato_pk primary key (id_contrato),
estadoContrato nvarchar(20) not null,
data_solicitado datetime null DEFAULT NOW() not null,
data_acertada date,
detalhes nvarchar(50),
cpf_cliente varchar(11) not null,
constraint cpf_cliente_fk foreign key (cpf_cliente) references tbl_usuario on delete cascade on update cascade,
cpf_tecnico varchar(11),
constraint cpf_tecnico_fk foreign key (cpf_tecnico) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_avaliacao(
id_avaliacao int not null auto_increment,
constraint id_avaliacao_pk primary key(id_avaliacao),
cpf_votado varchar(11),
constraint cpf_votado_fk foreign key (cpf_votado) references tbl_usuario on delete cascade on update cascade,
cpf_votante varchar(11),
constraint cpf_votante_fk foreign key (cpf_votante) references tbl_usuario on delete cascade on update cascade,
data_hora_reg datetime null DEFAULT NOW() not null,
valor_voto int
);

create table if not exists tbl_notificacao(
id_not int not null auto_increment,
constraint id_not_pk primary key(id_not),
id_contrato_fk int unique,
constraint id_contrato_fk foreign key (id_contrato_fk) references tbl_contrato on delete cascade on update cascade,
data_hora_reg_not datetime,
data_hora_reg_not_tc datetime,
estadoVisu nvarchar(20)
);

create table if not exists tbl_mensagem(
id_msg int not null auto_increment,
constraint id_msg_pk primary key(id_msg),
cpf_cliente_fk varchar(11) unique,
constraint cpf_cliente_fk foreign key (cpf_cliente_fk) references tbl_usuario on delete cascade on update cascade,
cpf_tecnico_fk varchar(11) unique,
constraint cpf_tecnico_fk foreign key (cpf_tecnico_fk) references tbl_usuario on delete cascade on update cascade,
caminho_xml nvarchar(255),
estadoContato varchar(20)
);

insert into tbl_mensagem(cpf_cliente_fk, cpf_tecnico_fk, caminho_xml,estadoContato) values
						(50374864837, 40488409837, null, 'ativo');

insert into tbl_tipoUsuario(tipo) values
('Tecnico'),
('Cliente');

insert into tbl_endereco(logradouro, bairro, cidade, estado, cep, complemento, num, cpf_usuario) values
-- clientes
('Rua Omã','Outeiro de Passargada','Cotia','São Paulo',06719650,'',190, 67334593880),
('Rua Azulão','Jd. Nova Coimbra','Cotia','São Paulo',06703420,'', 693, 50374864837),
('Rua João Paulo','Jardim Semíramis','Cotia','São Paulo',06709370,'', 61, 35215475822),
('Rua Padre Rocha','Jd. Tatu','Cotia','São Paulo',06717215,'', 150, 86923008883),
('Rua do Exército','Parque Bahia','Cotia','São Paulo',06717140,'' , 189, 43164154844),
-- tecnicos
('Avenida Brasil','Parque Bahia','Cotia','São Paulo',06700-270,'', 200, 43187118895),
('Rua Ágata','Parque Bahia','Cotia','São Paulo',06717095,'', 1200, 00183825845),
('Rua Santa Luzia','Parque Bahia','Cotia','São Paulo',06700287,'', 987 , 44351851805),
('Rua Santa Teresa', 'Parque Bahia','Cotia','São Paulo',06717175,'', 772, 98167345831),
('Rua Pelicano','Pq. Turiguara','Cotia','São Paulo',06703450,'', 938, 40488409837);

insert into tbl_telefone(ddd, numero, tipo_telefone, cpf_usuario) values
-- clientes
(12,123456789, 'telefone', 67334593880),
(12,365235621, 'celular', 50374864837),
(56,445465566, 'telefone', 35215475822),
(56,123587692, 'celular', 86923008883),
(24,598965472, 'telefone', 43164154844),
-- tecnicos
(25,165874968, 'celular', 43187118895),
(51,584862632, 'telefone', 00183825845),
(85,541586269, 'celular', 44351851805),
(65,551151515, 'telefone', 98167345831),
(98,124525132, 'celular', 40488409837);

insert into tbl_usuario(nome, sobrenome, data_nascimento, id_tp_usuario, cpf, contaStatus, foto) values
-- clientes
('Pedro', 'Vinicius', '2001-01-25', 2, 67334593880, 'ativa', null),
('Leandro', 'Damasceno', '2000-03-24', 2, 50374864837, 'ativa', null),
('Juan', 'Alves', '2000-03-27', 2, 35215475822, 'ativa', null),
('João', 'Brito', '2000-02-13', 2, 86923008883, 'ativa', null),
('Gabriel', 'Henrique', '2000-01-22', 2, 43164154844, 'ativa', null),
-- tecnicos
('Thomas', 'Jefferson', '1988-05-01', 1, 43187118895, 'ativa', null),
('Cleber', 'Tanide', '1985-08-15', 1, 00183825845, 'ativa', null),
('Talles', 'Moreira', '1995-01-24', 1, 44351851805, 'ativa', null),
('Lucas', 'Silva', '1998-05-25', 1, 98167345831, 'ativa', null),
('Jorge', 'Albuquerque', '1993-10-13', 1, 40488409837, 'ativa', null);

insert into tbl_formacao(instituicao, curso, cpf_usuario) values
-- tecnicos
('Etec de Cotia', 'Tecnico em Informatica',43187118895),
('Etec de Campinas', 'Tecnico em Informatica',00183825845),
('Etec de Cotia', 'Tecnico em Informatica',44351851805),
('Senai', 'Tecnico em Informatica',98167345831),
('Senai', 'Tecnico em Redes',40488409837);

insert into tbl_contrato (estadoContrato, data_acertada, detalhes, cpf_cliente, cpf_tecnico)values
('Em espera', '2018-05-25', 'Computador não reconhece Impressora', 67334593880, 43187118895),
('Em espera', '2018-06-02', 'Computador desligando sozinho', 50374864837, 40488409837);
select * from tbl_contrato;
select * from tbl_notificacao;
truncate tbl_contrato;
truncate tbl_notificacao;
update tbl_contrato set estadoContrato = 'Em analise', data_solicitado = now() where id_contrato = 1;						
update tbl_contrato set estadoContrato = 'Confirmado', data_solicitado = now() where id_contrato = 2;

insert into tbl_login (senha, conf_senha, cpf_usuario, usuario) values
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 67334593880, 'pedro'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 50374864837, 'leandro'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 35215475822, 'juan'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 86923008883, 'joao'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 43164154844, 'gabriel'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 43187118895, 'thomas'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 00183825845, 'cleber'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 44351851805, 'talles'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 98167345831, 'lucas'),
('MTIzNDU2Nzg=','MTIzNDU2Nzg=', 40488409837, 'jorge');

insert into tbl_email(email, cpf_usuario) values
-- clientes
('pedro@gmail.com', 67334593880),
('leandro@gmail.com', 50374864837),
('juan@gmail.com', 35215475822),
('joao@gmail.com', 86923008883),
('gabriel@gmail.com', 43164154844),
-- tecnicos
('thomas@gmail.com', 43187118895),
('cleber@gmail.com', 00183825845),
('talles@gmail.com', 44351851805),
('lucas@gmail.com', 98167345831),
('jorge@gmail.com', 40488409837);

insert into tbl_notificacao(id_contrato_fk, data_hora_reg_not, data_hora_reg_not_tc, estadoVisu) values 
						   (1, null, now(), 'VisualizadoTec1'),
                           (2, now(), null, 'VisualizadoCli1');			

-- Views

-- listar informaçoes do tecnico 

create view listarTecnico as 
		select tbl_usuario.nome, tbl_usuario.cpf, tbl_usuario.sobrenome, tbl_usuario.foto,
        tbl_telefone.ddd, tbl_telefone.numero, date_format(tbl_usuario.data_nascimento,"%d/%m/%Y") as data_nascimento,
        tbl_telefone.tipo_telefone, tbl_formacao.instituicao, tbl_formacao.curso, tbl_avaliacao.valor_voto,
        tbl_email.email, tbl_endereco.bairro, tbl_endereco.cep, tbl_endereco.cidade, tbl_endereco.complemento, tbl_login.senha,
        tbl_endereco.estado, tbl_endereco.logradouro, tbl_endereco.num
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
       tbl_telefone.numero, tbl_usuario.nome, tbl_usuario.sobrenome
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
    
-- atualizar usuário

DELIMITER //
drop procedure if exists atualizaUsuario //
CREATE PROCEDURE atualizaUsuario (
in v_cpf varchar(11),
in v_logradouro varchar(255),
in v_numero varchar(255),
in v_cep decimal(8,0) zerofill,
in v_bairro varchar(255),
in v_cidade varchar(255),
in v_estado varchar(255),
in v_numCasa int,
in v_ddd varchar(2),
in v_complemento varchar(255),
in v_email varchar(255),
in v_senha varchar(255),
in v_tipo_telefone varchar(15),
in v_foto varchar(255))
BEGIN
update tbl_email set email=v_email where cpf_usuario = v_cpf;
update tbl_endereco set logradouro = v_logradouro, cep = v_cep, bairro = v_bairro, 
cidade = v_cidade, estado = v_estado, num = v_numCasa, complemento = v_complemento where cpf_usuario = v_cpf;
update tbl_telefone set ddd=v_ddd, numero = v_numero, tipo_telefone = v_tipo_telefone where cpf_usuario = v_cpf;
update tbl_login set senha = v_senha, conf_senha = v_senha where cpf_usuario = v_cpf;
UPDATE tbl_usuario SET foto = IF(foto!=null, foto, v_foto) where cpf = v_cpf;
END//
DELIMITER ;

-- atualizar tecnico

DELIMITER //
drop procedure if exists atualizaTecnico //
CREATE PROCEDURE atualizaTecnico (
in v_cpf varchar(11),
in v_logradouro varchar(255),
in v_telefone varchar(255),
in v_cep decimal(8,0) zerofill,
in v_bairro varchar(255),
in v_cidade varchar(255),
in v_estado varchar(255),
in v_numCasa int,
in v_numero int,
in v_ddd varchar(2),
in v_complemento varchar(255),
in v_email varchar(255),
in v_senha varchar(255),
in v_tipo_telefone varchar(15),
in v_instituicao varchar(100),
in v_curso varchar(100),
in v_foto varchar(255)
)
BEGIN
update tbl_email set email=v_email where cpf_usuario = v_cpf;
update tbl_endereco set logradouro = v_logradouro, cep = v_cep, bairro = v_bairro, 
cidade = v_cidade, estado = v_estado, num = v_numCasa, complemento = v_complemento where cpf_usuario = v_cpf;
update tbl_telefone set ddd=v_ddd, numero = v_numero, tipo_telefone = v_tipo_telefone where cpf_usuario = v_cpf;
update tbl_login set senha = v_senha, conf_senha = v_senha where cpf_usuario = v_cpf;
update tbl_formacao set instituicao = v_instituicao, curso = v_curso where cpf_usuario = v_cpf;
UPDATE tbl_usuario SET foto = IF(foto!=null, foto, v_foto) where cpf = v_cpf;
END//
DELIMITER ;

-- procedure para criar um contato na tabela mensagem

DELIMITER //
drop procedure if exists criaContato //
CREATE PROCEDURE criaContato (
in v_cpf_tecnico varchar(11),
in v_cpf_cliente varchar(11),
in v_caminho_xml varchar(255)
)
BEGIN
	set @caminho := (select caminho_xml from tbl_mensagem where cpf_tecnico = v_cpf_tecnico and cpf_cliente = v_cpf_cliente);
    set @cpftec := (select cpf_tecnico from tbl_mensagem where cpf_tecnico = v_cpf_tecnico and cpf_cliente = v_cpf_cliente);
    set @cpfcli := (select cpf_cliente from tbl_mensagem where cpf_tecnico = v_cpf_tecnico and cpf_cliente = v_cpf_cliente);
    
	IF ((@a is null) and (@cpftec is null) and (@cpfcli is null)) THEN 
		insert into tbl_mensagem(cpf_cliente, cpf_tecnico, caminho_xml) values
						(v_cpf_tecnico, v_cpf_cliente, v_caminho_xml);
	ELSE
		update tbl_mensagem set caminho_xml = v_caminho_xml where cpf_cliente = v_cpf_cliente and cpf_tecnico = v_cpf_cliente;
    END IF; 
END//
DELIMITER ;

-- trigger para criar uma notificação sobre um contrato

DELIMITER //
drop trigger if exists trg_notificacao //
CREATE TRIGGER trg_notificacao AFTER insert on tbl_contrato

For each row

BEGIN	

SET @id_contrato := NEW.id_contrato;
       
insert into tbl_notificacao(id_contrato_fk, data_hora_reg_not, data_hora_reg_not_tc, estadoVisu) values
						   (@id_contrato, null, null, 'naoVisu');
	
END//
DELIMITER ;

-- trigger para atualizar a notificação							

DELIMITER //
drop trigger if exists trg_notificacaoUpdate //
CREATE TRIGGER trg_notificacaoUpdate AFTER update on tbl_contrato

For each row

BEGIN	

SET @id_contrato := NEW.id_contrato;
SET @estadoContrato := NEW.estadoContrato;

	IF @estadoContrato = 'Em analise' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoTec1', data_hora_reg_not_tc = now(), data_hora_reg_not = null where id_contrato_fk = @id_contrato;
    ELSEIF @estadoContrato = 'Confirmado' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoCli1', data_hora_reg_not = now(), data_hora_reg_not_tc = null where id_contrato_fk = @id_contrato;
	ELSEIF @estadoContrato = 'ConfirmadoTecnico' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoTec2', data_hora_reg_not_tc = now(), data_hora_reg_not = null where id_contrato_fk = @id_contrato;
	ELSEIF @estadoContrato = 'Em espera' THEN 
		update tbl_notificacao set estadoVisu='naoVisu', data_hora_reg_not = null, data_hora_reg_not_tc = null where id_contrato_fk = @id_contrato;
    END IF;
       	
END//
DELIMITER ;

-- procedure para cadastrar usuário

DELIMITER //
drop procedure if exists cadastroUsuario //
create procedure cadastroUsuario (
in v_cpf varchar(11),
in v_nome nvarchar(20),
in v_sobrenome nvarchar(20),
in v_data_nascimento date,
-- in v_data_hora_reg datetime,
-- in v_contaStatus nvarchar(15),
in v_email varchar(100),

in v_logradouro nvarchar(60),
in v_bairro nvarchar(50),
in v_cidade nvarchar(40),
in v_estado nvarchar(30),
in v_cep decimal(8),
in v_num int,
in v_complemento nvarchar(200),

in v_ddd varchar(2),
in v_numero varchar(15),
in v_tipo_telefone varchar(15),

in v_senha nvarchar(16),
in v_usuario nvarchar(50),
in v_conf_senha nvarchar(16),
in v_tipo_usuario int,
out msgCPF nvarchar(255),
out msgUsu nvarchar(225),
out msg nvarchar(255)
)
begin

declare t_cpf varchar(11);
declare t_nome nvarchar(20);
declare t_sobrenome nvarchar(20);
declare t_data_nascimento date;
-- declare t_data_hora_reg datetime;
-- declare t_contaStatus nvarchar(15);
-- declare t_foto varchar(255);

declare t_email varchar(100);
declare t_logradouro nvarchar(60);
declare t_bairro nvarchar(50);
declare t_cidade nvarchar(40);
declare t_estado nvarchar(30);
declare t_cep decimal(8);
declare t_num int;
declare t_complemento nvarchar(200);

declare t_ddd varchar(2);
declare t_numero varchar(15);
declare t_senha nvarchar(16);
declare t_usuario nvarchar(50);
declare t_conf_senha nvarchar(16);
declare t_msg nvarchar(255);



 set t_cpf= (select cpf from tbl_usuario where cpf=v_cpf);
-- set t_nome=(select nome from tbl_usuario where nome=v_cpf);

set t_email = (select email from tbl_email where email=v_email);
set t_logradouro= (select logradouro from tbl_endereco where logradouro=v_logradouro and cpf_usuario = v_cpf);
set t_bairro= (select bairro from tbl_endereco where bairro=v_bairro and cpf_usuario = v_cpf);
 set t_cidade= (select cidade from tbl_endereco where cidade=v_cidade and cpf_usuario = v_cpf);
 set t_num= (select num from tbl_endereco where num=v_num and cpf_usuario = v_cpf);
 set t_complemento= (select complemento from tbl_endereco where complemento = v_complemento and cpf_usuario = v_cpf);
 set t_numero= (select numero from tbl_telefone where numero=v_numero and cpf_usuario = v_cpf);
set t_ddd=(select ddd from tbl_telefone where ddd=v_ddd and cpf_usuario = v_cpf);
--  set t_senha=(select senha from tbl_login where senha=v_senha and cpf_usuario = v_cpf);
set t_usuario=(select usuario from tbl_login where usuario=v_usuario and cpf_usuario = v_cpf);


if ( (t_cpf = v_cpf) &&( t_usuario = v_usuario)) then
set msgCPF = 'erro';
else
set msgUsu = 'sucesso';
insert into tbl_login(senha, usuario, conf_senha, cpf_usuario)values
(v_senha, v_usuario, v_conf_senha, v_cpf);

end if;

if (t_cpf = v_cpf) then
set msgCPF = 'erro';
else
set msgCPF = 'sucesso';
insert into tbl_usuario(cpf, nome, sobrenome, data_nascimento, data_hora_reg, contaStatus, id_tp_usuario) values
(v_cpf, v_nome, v_sobrenome, v_data_nascimento, now(), 'Ativa', v_tipo_usuario);
end if;

if ((t_cpf = v_cpf) &&(t_email = v_email)) then
set @emailF = 'erro';
else
set @emailF = 'sucesso';

insert into tbl_email(email, cpf_usuario) values
(v_email, v_cpf);

end if;

if ( (t_cpf = v_cpf) &&(t_logradouro = v_logradouro) && (t_bairro = v_bairro) && (t_cidade = v_cidade) 
		&& (t_estado = v_estado) && (t_cep = v_cep) && (t_num = v_num)) then
 
set @enderecoF = 'erro';

else 
set @enderecoF = 'sucesso';

insert into tbl_endereco(logradouro, bairro, cidade, estado, cep, complemento, num, cpf_usuario) values
(v_logradouro, v_bairro, v_cidade, v_estado, v_cep, v_complemento, v_num, v_cpf);

end if;

if ( (t_cpf = v_cpf) && (t_ddd = v_ddd) && (t_numero = v_numero)) then
set @telefoneF= 'erro';
else
set @telefoneV= 'sucesso';
insert into tbl_telefone(ddd, numero, tipo_telefone, cpf_usuario) values
(v_ddd, v_numero, v_tipo_telefone, v_cpf);
end if;


if ( (t_cpf = v_cpf) && (t_ddd = v_ddd) && (t_numero = v_numero) && (t_logradouro = v_logradouro) && (t_bairro = v_bairro) 
	&& (t_cidade = v_cidade) && (t_estado = v_estado) && (t_cep = v_cep) && (t_num = v_num) && (t_email = v_email) 
		&& ( t_usuario = v_usuario) ) then
       
set msg = 'erro';
else 
set msg = 'sucesso';

end if;

end//
DELIMITER ;

set @msgCPF = '';
SET @msgUsu = '';
set @msgVerifica = '';

call cadastroUsuario('12345678914', 'Jorge', 'Cleiton', '2056-02-06','jorgin@gmail.com', 'Avenida das flores', 'Jd. Cotia', 
'Cotia', 'São Paulo', 12345679, 23, '', '23', '123456789','celular', '123','jorgin','123',2,@msgCPF, @msgUsu, @msgVerifica);

select * from tbl_usuario;
delete from tbl_usuario where cpf = 12345678921;

select * from tbl_email;
delete from tbl_email where cpf_usuario = 12345678920;

select * from tbl_telefone;
delete from tbl_telefone where cpf_usuario = 12345678920;

select * from tbl_login;
delete from tbl_login where cpf_usuario = 12345678920;

select * from tbl_endereco;
delete from tbl_endereco where cpf_usuario = 12345678921;


