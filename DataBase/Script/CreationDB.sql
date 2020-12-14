-- Creación base de datos
CREATE SCHEMA `pagoonline` ;

-- Tabla de Productos
CREATE TABLE `pagoonline`.`producto` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `precio` DECIMAL NOT NULL,
  `descipcion` VARCHAR(250) NULL,
  PRIMARY KEY (`idProducto`));

INSERT INTO `pagoonline`.`producto` (`nombre`, `precio`, `descipcion`) VALUES ('Monitor', '20000', 'Monitor HD');
INSERT INTO `pagoonline`.`producto` (`nombre`, `precio`, `descipcion`) VALUES ('Teclado', '1333', 'Telcado PC ');



--Tabla de Estados
CREATE TABLE `pagoonline`.`estado` (
  `idEstado` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(100) NULL,
  `orden` INT NOT NULL,
  PRIMARY KEY (`idEstado`));

INSERT INTO `pagoonline`.`estado` (`nombre`, `descripcion`, `orden`) VALUES ('Nuevo', 'Pedido creado recientemente', '1');
INSERT INTO `pagoonline`.`estado` (`nombre`, `descripcion`, `orden`) VALUES ('Pendiente de Pago', '', '2');
INSERT INTO `pagoonline`.`estado` (`nombre`, `descripcion`, `orden`) VALUES ('Pagado', 'Finalizado', '3');
INSERT INTO `pagoonline`.`estado` (`nombre`, `orden`) VALUES ('Cancelada', '3');



-- Tabla de Pedidos
CREATE TABLE `pagoonline`.`pedido` (
  `idPedido` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NULL,
  `idEstado` INT NOT NULL,
  `idProducto` INT NOT NULL,
  `idUsuario` INT NOT NULL DEFAULT 1,
  `urlPago` VARCHAR(120) NULL,
  `fechaCreacion` DATETIME NULL,
  `transactionId` VARCHAR(200) NULL,
  `baja` BIT(1) NULL DEFAULT 0,
  PRIMARY KEY (`idPedido`));

  ALTER TABLE `pagoonline`.`pedido` 
  ADD INDEX `idEstado_idx` (`idEstado` ASC);
  ALTER TABLE `pagoonline`.`pedido` 
  ADD CONSTRAINT `idEstado`
    FOREIGN KEY (`idEstado`)
    REFERENCES `pagoonline`.`estado` (`idEstado`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE;

    ALTER TABLE `pagoonline`.`pedido` 
ADD INDEX `idProducto_idx` (`idProducto` ASC);
ALTER TABLE `pagoonline`.`pedido` 
ADD CONSTRAINT `idProducto`
  FOREIGN KEY (`idProducto`)
  REFERENCES `pagoonline`.`producto` (`idProducto`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;

