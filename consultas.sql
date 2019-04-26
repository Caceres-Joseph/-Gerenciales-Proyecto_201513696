CREATE DATABASE RestauranteMirador5;
USE RestauranteMirador5;

INSERT INTO lugar_servirs  
SELECT *
FROM RestauranteMirador4.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM RestauranteMirador4.medidas;

INSERT INTO categorias  
SELECT *
FROM RestauranteMirador4.categorias;

INSERT INTO articulos  
SELECT *
FROM RestauranteMirador4.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM RestauranteMirador4.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM RestauranteMirador4.rols;

INSERT INTO personas  
SELECT *
FROM RestauranteMirador4.personas;

INSERT INTO usuarios  
SELECT *
FROM RestauranteMirador4.usuarios;

INSERT INTO lugars  
SELECT *
FROM RestauranteMirador4.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM RestauranteMirador4.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM RestauranteMirador4.mesas;

 
INSERT INTO ordens (idOrden,idMesa,idUsuario,subTotal,propina,total,observacion,cancelada,estado,created_at,updated_at) 
SELECT idOrden,idMesa,idUsuario,subTotal,propina,total,observacion,cancelada,estado,created_at,updated_at
FROM RestauranteMirador4.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM RestauranteMirador4.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM RestauranteMirador4.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM RestauranteMirador4.observacions;

INSERT INTO cajas  
SELECT *
FROM RestauranteMirador4.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM RestauranteMirador4.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM RestauranteMirador4.abonos;

INSERT INTO gastos  
SELECT *
FROM RestauranteMirador4.gastos;

INSERT INTO cortesias  
SELECT *
FROM RestauranteMirador4.cortesias;