create database tec_Find DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

drop database tec_Find;

use tec_Find;

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
cpf_usuario varchar(11) not null,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

create table if not exists tbl_telefone(
id_tel int not null auto_increment,
constraint id_tel_pk primary key(id_tel),
ddd varchar(2),
numero varchar(15) not null,
tipo_telefone varchar(15) not null,
cpf_usuario varchar(11) not null,
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
cpf_usuario varchar(11) not null,
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
cpf_usuario varchar(11) not null,
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade
);

select * from tbl_login;

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
constraint id_contrato_fk primary key (id_contrato),
estadoContrato nvarchar(20) not null,
data_solicitado datetime null DEFAULT NOW() not null,
data_acertada date not null,
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
data_hora_reg_not datetime null DEFAULT NOW(),
estadoVisu nvarchar(20)
);

insert into tbl_notificacao(id_contrato_fk, data_hora_reg_not, estadoVisu) values 
						   (1, now(), 'NaoVisu'),
                           (2, now(), 'VisualizadoTec2');

select * from tbl_notificacao;

select tbl_contrato.id_contrato, tbl_contrato.estadoContrato, tbl_contrato.detalhes, tbl_contrato.data_solicitado, tbl_contrato.data_acertada,
    tbl_contrato.cpf_tecnico, tbl_contrato.cpf_cliente, tbl_usuario.nome, tbl_usuario.foto, tbl_usuario.sobrenome, tbl_notificacao.id_contrato_fk,
    tbl_notificacao.estadoVisu
    from tbl_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_tecnico
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato where estadoVisu = 'VisualizadoTec1';



update tblmarca set nomemarca='Le cheval' where idmarca=2;
-- aaaaaaaaaa

insert into tbl_tipoUsuario(tipo) values
('Tecnico'),
('Cliente');

select * from listarTecnico where nome like '%João%' and sobrenome like '%Brito%';

insert into tbl_endereco(logradouro, bairro, cidade, estado, cep, complemento, num, cpf_usuario) values
('Rua de osasco','Jd Das Flores','Osasco','São Paulo',12345678,'',1, 12345678911),
('Rua Damasco','Jd Semiramis','Cotia','São Paulo',87456123,'', 2, 12345678912),
('Avenida do carmo','Bairro da luz','São Paulo','São Paulo',23598741,''),
('Avenida Taubaté','Jd. Tatu','Embu das Artes','São Paulo',23598845,''),
('Rua Paraiba','Dona Creusa','Itapecerica','São Paulo',25252525,''),
('Rua dos Alemãos','Bairro da Sombra','Zona Leste','São Paulo',12546327,''),
('Rua Socorro','Jd. Me Ajude','Carapicuiba','São Paulo',24956213,''),
('Rua Malandro','Jd. Dos Sapos','Taubaté','São Paulo',46162898,''),
('Avenida Juracema','Jd. Tiburcio','Cotia','São Paulo',87456932,''),
('Rua da Pipoca','Bairro do Galvão','Itapevi','São Paulo',11112589,''),
('Rua Sérginho Groizzman','Bairro Altas Horas','São Paulo','São Paulo',66445522,''),
('Rua das Miçangas','Bairro da Conceição','Itapecerica da Serra','São Paulo',99825063,''),
('Campinho das Castanhas','Jd. Falcão','Campinas','São Paulo',98563012,''),
('Rua das Cachoeiras','Bairro Norte','São Bernardo dos Campos','São Paulo',85741236,''),
('Avenida do Sofrimento','Bairro das Dores','Diadema','São Paulo',16589317,''),
('Rua Luciano Hulk','Jd. Das Pontas','Barueri','São Paulo',87643925,''),
('Avenida Torino','Bairro das Bermudas','Santo André','São Paulo',64782503,''),
('Avenida do Limão','Jd. das Flores','Cotia','São Paulo',16547893,''),
('Rua da Laranja','Bairro do Tamarindo','Santos','São Paulo',25698763,''),
('Avenida São João','Jd. Cleber','Osasco','São Paulo',54795556,'');

insert into tbl_telefone(ddd, numero, tipo_telefone, cpf_usuario) values
(12,123456789, 'telefone', 12345678911),
(12,365235621, 'celular', 12345678912),
(56,445465566),
(56,123587692),
(24,598965472),
(25,165874968),
(51,584862632),
(85,541586269),
(65,551151515),
(54,514548655),
(98,124525132),
(45,942547574),
(15,954563210),
(21,541546553),
(54,484182158),
(94,841813358),
(93,848128483),
(96,848541584),
(95,481812941),
(84,941851892),
(84,954965222);

insert into tbl_usuario(nome, sobrenome, data_nascimento, id_tp_usuario, cpf, contaStatus) values
('Leandro', 'Damaiscedo', '2000-03-24', 2, 12345678911, 'ativa'),
('João', 'Brito', '2000-11-13', 1, 12345678912, 'ativa'),
('Pedro', 'Vinicius', '2001-01-25', 2, 12345678913, 'ativa'),
('Gabriel', 'Chewbacca', '2000-08-22', 2, 12345678914, 'ativa'),
('Samuel', 'Tolisso', '1992-03-27', 2, 12345678915, 'ativa'),
('Thomas', 'Jefferson', '1988-05-01', 2, 12345678916, 'ativa'),
('Cleber', 'Tanide', '1985-08-15', 2, 12345678917, 'ativa'),
('Talles', 'Moreira', '2001-01-24', 2, 12345678918, 'ativa'),
('Lucas', 'Silva', '1998-05-25', 2, 12345678919, 'ativa'),
('Pedro', 'Albuquerque', '1969-10-13', 2, 12345678920, 'ativa'),
('Cleber', 'Pinto', '1997-11-16', 1, 12345678921, 'ativa'),
('Juca', 'Nepomuceno', '1979-08-30', 1, 12345678922, 'ativa'),
('Fausto', 'Salgado', '2000-07-29', 1, 12345678923, 'ativa'),
('Paloma', 'Alves', '1995-10-24', 1, 12345678924, 'ativa'),
('Fabricio', 'Gabriel', '1958-04-23', 1, 12345678925, 'ativa'),
('Joberson', 'Benites', '2001-04-19', 1, 12345678926, 'ativa'),
('Tonio', 'Maverick', '1985-03-14', 1, 12345678927, 'ativa'),
('Matheus', 'Paulo', '1977-02-25', 1, 12345678928, 'ativa'),
('Lucas', 'Emanuel', '1969-09-19', 1, 12345678929, 'ativa'),
('Gustavo', 'Pimentel', '1982-01-12', 1, 12345678930, 'ativa');

insert into tbl_formacao(instituicao, curso, cpf_usuario) values
('Etec de Cotia', 'Tecnico em Informatica',12345678912),
('Etec de Campinas', 'Tecnico em Informatica',2),
('Colégio Rio Branco', 'Tecnico em Informatica',3),
('Samuel da Silva Filho', 'Tecnico em Informatica',4),
('Senai', 'Tecnico em Redes',5),
('Etec de Taubaté', 'Tecnico em Informatica',6),
('São Judas', 'Tecnico em Informatica',7),
('Etec de São Bernardo do Campo', 'Tecnico em Redes',8),
('Etec de Itapevi', 'Tecnico em Informatica',9),
('Etec de São Bernardo do Campo', 'Tecnico em Informatica',10);

select * from tbl_contrato;

select * from tbl_notificacao;

update tbl_contrato set estadoContrato = 'Em analise' where id_contrato = 1;

truncate tbl_contrato;

select * from tbl_notificacao;

insert into tbl_contrato (estadoContrato, data_acertada, detalhes, cpf_cliente, cpf_tecnico)values
('Em analise','2013-02-25','Computador não reconhece Impressora',12345678911, 12345678912),
('Confirmado','2017-03-02','Instalar servidor local',12345678911,12345678912),
('Confirmado','2017-09-05','Notebook não reconhece USB',3,3),
('Finalizado','2017-11-08','Computador nao liga',4,4),
('Confirmado','2017-06-12','Instalar rede interna',5,5),
('Em espera','2017-08-11','Limpeza notebook',6, null),
('Confirmado','2017-09-11','Meu computador não dá video',7,7),
('Finalizado','2017-06-06','Preciso formatar meu pc',8,8),
('Confirmado','2017-06-07','Computador queimou',9,9),
('Em espera','2017-09-18','Notebook não quer ligar',10, null);

insert into tbl_login (senha, conf_senha, cpf_usuario, usuario) values
('MTIzNA==','MTIzNA==', 12345678911, 'admin1'),
('MTIyMw==','MTIyMw==', 12345678912, 'admin2');

select * from listarCliente where cpf = 12345678911;

-- Consulta Contrato

select tbl_contrato.*, a.cpf as 'CPF do Técnico', cli.cpf as 'CPF do Cliente'
from tbl_contrato
left join tbl_tecnico t on t.id_tecnico = tbl_contrato.id_tecnico_fk
left join tbl_usuario a on a.id_usuario = t.id_usuario_fk
left join tbl_cliente c on c.id_cliente = tbl_contrato.id_cliente_fk
left join tbl_usuario cli on cli.id_usuario = c.id_usuario_fk;



select c.id_contrato as id, c.estado as estado, c.data_solicitado as dataS, c;

select c.*, u.cpf as CPF_Cliente, u.cpf as CPF_tecnico 
from tbl_contrato as c
left join tbl_usuario as u 
on c.id_cliente_fk=u.id_usuario 
left join tbl_tecnico as t
on t.id_usuario_fk=u.id_usuario;

--  Consulta Formaçao

select tbl_usuario.nome, tbl_usuario.sobrenome, tbl_usuario.data_nascimento, tbl_formacao.*
from tbl_formacao
inner join tbl_tecnico on tbl_tecnico.id_tecnico = tbl_formacao.id_tecnico_fk
inner join tbl_usuario on tbl_usuario.id_usuario = tbl_tecnico.id_usuario_fk;

-- Consulta Técnico por cidade
 
select * from tbl_usuario 
inner join tbl_tecnico t on t.id_usuario_fk = tbl_usuario.id_usuario
inner join tbl_endereco e on e.id_end = tbl_usuario.id_end_fk where e.cidade = 'Cotia';

--  

select * from tbl_contrato;

select tbl_usuario.nome, tbl_usuario.sobrenome, tbl_formacao.*
from tbl_formacao
inner join tbl_usuario on tbl_usuario.cpf = tbl_formacao.cpf_usuario where cpf='';

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

ALTER TABLE tbl_endereco CHANGE `numero` `num` int;

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
        left join tbl_endereco on tbl_endereco.cpf_usuario = tbl_usuario.cpf;-- where nome = 'Leandro' and sobrenome = 'Damaiscedo';
        
-- listar notificacoes

create view listarNotificacaoTec as 
select tbl_contrato.id_contrato, tbl_contrato.estadoContrato, tbl_contrato.detalhes, tbl_contrato.data_solicitado, tbl_contrato.data_acertada,
    tbl_contrato.cpf_tecnico, tbl_contrato.cpf_cliente, tbl_usuario.nome, tbl_usuario.foto, tbl_usuario.sobrenome, tbl_notificacao.estadoVisu,
    tbl_notificacao.id_contrato_fk, tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not as datareg
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

create view carregarNotificacao as
select tbl_contrato.cpf_cliente, tbl_contrato.cpf_tecnico, tbl_contrato.id_contrato, tbl_notificacao.estadoVisu, tbl_notificacao.id_contrato_fk,
	tbl_notificacao.id_not, tbl_notificacao.data_hora_reg_not as datareg
	from tbl_contrato
    left join tbl_notificacao on tbl_notificacao.id_contrato_fk = tbl_contrato.id_contrato
    left join tbl_usuario on tbl_usuario.cpf = tbl_contrato.cpf_cliente;-- where cpf_tecnico = 12345678912 and estadoVisu = 'VisualizadoTec1' or estadoVisu = null;

update tbl_email set email='leandrorevolve@gmail.com', cpf_usuario = 12345678911 where id_email = 1;

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

select * from tbl_contrato;

select * from carregarNotificacao where cpf_cliente = 12345678911 AND estadoVisu = 'VisualizadoTec1' or estadoVisu = 'VisualizadoCli1';

select * from tbl_notificacao;

-- update tbl_usuario set foto = load_file('fotos/a5a4a6c892cac8aef07f2c29ad64b78b.jpg') where cpf = 12345678911;

-- select foto into outfile 'fotos/a5a4a6c892cac8aef07f2c29ad64b78b.jpg' from tbl_usuario;

ALTER TABLE tbl_avaliacao CONVERT TO CHARACTER SET utf8 COLLATE 'utf8_general_ci';

DELIMITER //
drop trigger if exists trg_notificacao //
CREATE TRIGGER trg_notificacao AFTER insert on tbl_contrato

For each row

BEGIN	

SET @id_contrato := NEW.id_contrato;
       
insert into tbl_notificacao(id_contrato_fk, data_hora_reg_not, estadoVisu) values
						   (@id_contrato, null, 'naoVisu');
	
END//
DELIMITER ;

SET SQL_SAFE_UPDATES=0;

DELIMITER //
drop trigger if exists trg_notificacaoUpdate //
CREATE TRIGGER trg_notificacaoUpdate AFTER update on tbl_contrato

For each row

BEGIN	

SET @id_contrato := NEW.id_contrato;
SET @estadoContrato := NEW.estadoContrato;

	IF @estadoContrato = 'Em analise' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoTec1' where id_contrato_fk = @id_contrato;
    ELSEIF @estadoContrato = 'Confirmado' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoCli1' where id_contrato_fk = @id_contrato;
	ELSEIF @estadoContrato = 'ConfirmadoTecnico' THEN 
		update tbl_notificacao set estadoVisu='VisualizadoTec2' where id_contrato_fk = @id_contrato;
	ELSEIF @estadoContrato = 'Em espera' THEN 
		update tbl_notificacao set estadoVisu='naoVisu', data_hora_reg_not = null  where id_contrato_fk = @id_contrato;
    END IF;
       	
END//
DELIMITER ;

select * from listarNotificacaoCli where cpf_cliente = 12345678911;

select * from tbl_notificacao;


