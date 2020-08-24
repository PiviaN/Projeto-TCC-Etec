insert into tbl_mensagem(cpf_cliente_fk, cpf_tecnico_fk, caminho_xml,estadoContato) values
						(50374864837, 40488409837, null, 'ativo');

insert into tbl_tipoUsuario(tipo) values
('Tecnico'),
('Cliente');

insert into tbl_endereco(logradouro, bairro, cidade, estado, cep, complemento, num, cpf_usuario, coordenadas) values
-- clientes
('Rua Omã','Outeiro de Passargada','Cotia','São Paulo',06719650,'',190, 67334593880, ST_GeomFromText('POINT(-23.612038 -46.950037)')),
('Rua Azulão','Jd. Nova Coimbra','Cotia','São Paulo',06703420,'', 693, 50374864837, ST_GeomFromText('POINT(-23.5990514 -46.912299)') ),
('Rua João Paulo','Jardim Semíramis','Cotia','São Paulo',06709370,'', 61, 35215475822, ST_GeomFromText('POINT(-23.5990514 -46.911099)')),
('Rua Padre Rocha','Jd. Tatu','Cotia','São Paulo',06717215,'', 150, 86923008883, ST_GeomFromText('POINT(-23.5990514 -46.912219)')),
('Rua do Exército','Parque Bahia','Cotia','São Paulo',06717140,'' , 189, 43164154844, ST_GeomFromText('POINT(-23.5990514 -46.912099)')),
-- 																										     -23.612038, -46.950037
('Avenida Brasil','Parque Bahia','Cotia','São Paulo',06700-270,'', 200, 43187118895, ST_GeomFromText('POINT(-23.6114551 -46.9257989)')),
('Rua Ágata','Parque Bahia','Cotia','São Paulo',06717095,'', 1200, 00183825845, ST_GeomFromText('POINT(-23.6068145 -46.9167762)')),
('Rua Santa Luzia','Parque Bahia','Cotia','São Paulo',06700287,'', 987 , 44351851805, ST_GeomFromText('POINT(-23.6097763 -46.9227112)')),
('Rua Santa Teresa', 'Parque Bahia','Cotia','São Paulo',06717175,'', 772, 98167345831, ST_GeomFromText('POINT(-23.6054714 -46.9238732)')),
('Rua Pelicano','Jardim Nova Coimbra','Cotia','São Paulo',06703450,'', 938, 40488409837, ST_GeomFromText('POINT(-23.596780 -46.912516)'));

select * from tbl_mensagem;


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

-- update tbl_contrato set estadoContrato = 'Em analise', data_solicitado = now() where id_contrato = 1;						
-- update tbl_contrato set estadoContrato = 'Confirmado', data_solicitado = now() where id_contrato = 2;

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