CREATE TABLE localizacao (coordenadas GEOMETRY);

INSERT INTO localizacao (coordenadas) VALUES (ST_GeomFromText('POINT(-23.5990514 -46.912299)'));

select * from tbl_mensagem;

select id_msg as id  from tbl_mensagem where cpf_cliente_fk = 50374864837 and cpf_tecnico_fk = 40488409837;

set @a := (SELECT coordenadas coordenadas FROM tbl_endereco where cpf_usuario = 77086603007);

select ST_AsText(@a);
select * from listarTecnico where cpf = 40488409837 and id_tp_usuario = 1;
select * from listarTecnico where cpf <> 50374864837 and id_tp_usuario = 1;

select ST_AsText(coordenadas) as coord from tbl_endereco where cpf_usuario = 50374864837;
select cpf_usuario, ST_AsText(coordenadas) from tbl_endereco;
-- serve transformar o campo em texto 
-- ST_AsText(coordenadas)

-- serve para transformar as coordenadas em um formato que o sistema entenda
-- ST_GeomFromText
