
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
