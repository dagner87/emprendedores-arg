/var/www/html/emprendedores/sistema

CREATE TRIGGER ELIMINAR_AD AFTER DELETE ON emprendedor FOR EACH ROW DELETE FROM `emp_asoc` WHERE `emp_asoc`.`id_padre` = OLD.id_emp


CREATE TRIGGER INSERTA_AI AFTER INSERT ON emprendedor FOR EACH ROW 
INSERT INTO  emp_cap (id_emp,id_cap,evaluacion_video) VALUES (NEW.id_emp,1,0)

CREATE TRIGGER ELIM_EMP_ASOC_AD AFTER DELETE ON emprendedor FOR EACH ROW 
DELETE FROM `emp_cap` WHERE `emp_asoc`.`id_emp` = OLD.id_emp

DELETE FROM `emp_cap` WHERE `emp_cap`.`id_emp_cap` = 1


ALTER TABLE `combo` ADD `estado_combo` CHAR(1) NOT NULL DEFAULT '1' AFTER `costo`;
ALTER TABLE  `promo` ADD  `estado_promo` CHAR( 1 ) NOT NULL DEFAULT  '1' AFTER  `descuento` ;



DROP TABLE `capacitacion`, `carrito`, `emprendedor`, `emp_asoc`, `orden_compra`, `producto

delimiter //

CREATE TRIGGER update_alumnos AFTER INSERT ON Alumnos
FOR EACH ROW BEGIN
INSERT INTO Procesos VALUES (new.id,1,1);
INSERT INTO Validar_residencia VALUES (new.id,0,'sin observaciones');
END;//

delimiter ;