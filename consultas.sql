CREATE DATABASE -Gamer5;
USE -Gamer5;

INSERT INTO lugar_servirs  
SELECT *
FROM -Gamer4.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM -Gamer4.medidas;

INSERT INTO categorias  
SELECT *
FROM -Gamer4.categorias;

INSERT INTO articulos  
SELECT *
FROM -Gamer4.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM -Gamer4.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM -Gamer4.rols;

INSERT INTO personas  
SELECT *
FROM -Gamer4.personas;

INSERT INTO usuarios  
SELECT *
FROM -Gamer4.usuarios;

INSERT INTO lugars  
SELECT *
FROM -Gamer4.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM -Gamer4.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM -Gamer4.mesas;

 
INSERT INTO ordens (idOrden,idMesa,idUsuario,subTotal,propina,total,observacion,cancelada,estado,created_at,updated_at) 
SELECT idOrden,idMesa,idUsuario,subTotal,propina,total,observacion,cancelada,estado,created_at,updated_at
FROM -Gamer4.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM -Gamer4.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM -Gamer4.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM -Gamer4.observacions;

INSERT INTO cajas  
SELECT *
FROM -Gamer4.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM -Gamer4.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM -Gamer4.abonos;

INSERT INTO gastos  
SELECT *
FROM -Gamer4.gastos;

INSERT INTO cortesias  
SELECT *
FROM -Gamer4.cortesias;