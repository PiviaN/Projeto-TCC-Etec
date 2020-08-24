// é pra executar com os truncates mesmo
truncate tbl_mensagem;
truncate tbl_contrato;
truncate tbl_notificacao;

insert into tbl_mensagem(cpf_cliente_fk, cpf_tecnico_fk, caminho_xml,estadoContato) values
						(50374864837, 40488409837, null, 'ativo'),
                        (67334593880, 40488409837, null, 'ativo'),
                        (35215475822, 40488409837, null, 'ativo'),
                        (86923008883, 40488409837, null, 'ativo'),
                        (43164154844, 40488409837, null, 'ativo');
				
insert into tbl_contrato (estadoContrato, data_acertada, detalhes, cpf_cliente, cpf_tecnico)values
('Em espera', null, 'Computador não reconhece Impressora', 67334593880, null),
('Em analise', '2018-07-10', 'Computador desligando sozinho', 50374864837, 98167345831),
('Confirmado', '2018-07-08', 'Máquina não conecta à Internet', 86923008883, 40488409837),
('Finalizado', '2018-05-15', 'Computador reiniciando', 50374864837, 40488409837);

