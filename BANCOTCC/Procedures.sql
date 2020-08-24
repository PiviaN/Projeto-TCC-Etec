	   
-- atualizar usuário

 '', 'leandro@gmail.com', 'MTIzNDU2Nzg=', '', 'fotos/1cba966f22b5603b16b929a45170b48e.png');
DELIMITER //
drop procedure if exists atualizaUsuario //
CREATE PROCEDURE atualizaUsuario (
in v_cpf varchar(11),
in v_logradouro varchar(255),
in v_cep decimal(8,0) zerofill,
in v_bairro varchar(255),
in v_cidade varchar(255),
in v_estado varchar(255),
in v_numCasa int,
in v_numero varchar(15),
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
in v_cep decimal(8,0) zerofill,
in v_bairro varchar(255),
in v_cidade varchar(255),
in v_estado varchar(255),
in v_numCasa int,
in v_telefone varchar(15),
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
update tbl_telefone set ddd=v_ddd, numero = v_telefone, tipo_telefone = v_tipo_telefone where cpf_usuario = v_cpf;
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