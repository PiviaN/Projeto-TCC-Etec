
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
constraint cpf_usuario_fk foreign key (cpf_usuario) references tbl_usuario on delete cascade on update cascade,
-- novo campo
coordenadas geometry
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
sobrenome nvarchar(30) not null,
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
-- Em espera, Em analise, Confirmado, ConfirmadoTecnico, Finalizado, Cancelado.
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
cpf_cliente_fk varchar(11), 
constraint cpf_cliente_fk foreign key (cpf_cliente_fk) references tbl_usuario on delete cascade on update cascade,
cpf_tecnico_fk varchar(11),
constraint cpf_tecnico_fk foreign key (cpf_tecnico_fk) references tbl_usuario on delete cascade on update cascade,
caminho_xml nvarchar(255),
estadoContato varchar(20)
);