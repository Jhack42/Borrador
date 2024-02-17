CREATE DATABASE prueba;
USE prueba;

CREATE TABLE Productos (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  Nombre VARCHAR(255) NOT NULL,
  Categoria INT NOT NULL,
  Ventas INT NOT NULL DEFAULT 0,
  Estado TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE Categoria (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  Nombre VARCHAR(255) NOT NULL,
  Ventas INT NOT NULL DEFAULT 0
);

DELIMITER //

CREATE PROCEDURE sp_venta(
  IN p_id_usuario INT,
  IN p_id_producto INT,
  IN p_cantidad INT
)
BEGIN
  DECLARE v_usuario_activo INT;
  DECLARE v_producto_activo INT;

  SELECT estado INTO v_usuario_activo FROM Usuario WHERE ID = p_id_usuario;
  SELECT estado INTO v_producto_activo FROM Productos WHERE ID = p_id_producto;

  IF v_usuario_activo = 1 AND v_producto_activo = 1 THEN
    UPDATE Productos SET Ventas = Ventas + p_cantidad WHERE ID = p_id_producto;
    UPDATE Categoria SET Ventas = Ventas + p_cantidad WHERE ID = (SELECT Categoria FROM Productos WHERE ID = p_id_producto);
    SELECT "Venta realizada correctamente";
  ELSE
    IF v_usuario_activo = 0 THEN
      SELECT "El usuario se encuentra deshabilitado";
    ELSE
      SELECT "El producto se encuentra deshabilitado";
    END IF;
  END IF;
END //

DELIMITER ;

CALL sp_venta(1, 2, 3);
