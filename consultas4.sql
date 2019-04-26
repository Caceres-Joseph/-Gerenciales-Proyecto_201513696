CREATE DATABASE RestauranteMirador8;
USE RestauranteMirador8;

INSERT INTO lugar_servirs  
SELECT *
FROM RestauranteMirador7.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM RestauranteMirador7.medidas;

INSERT INTO categorias  
SELECT *
FROM RestauranteMirador7.categorias;

INSERT INTO articulos  
SELECT *
FROM RestauranteMirador7.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM RestauranteMirador7.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM RestauranteMirador7.rols;

INSERT INTO personas  
SELECT *
FROM RestauranteMirador7.personas;

INSERT INTO usuarios  
SELECT *
FROM RestauranteMirador7.usuarios;

INSERT INTO lugars  
SELECT *
FROM RestauranteMirador7.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM RestauranteMirador7.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM RestauranteMirador7.mesas;


INSERT INTO ordens  
SELECT *
FROM RestauranteMirador7.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM RestauranteMirador7.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM RestauranteMirador7.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM RestauranteMirador7.observacions;

INSERT INTO cajas  
SELECT *
FROM RestauranteMirador7.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM RestauranteMirador7.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM RestauranteMirador7.abonos;

INSERT INTO gastos  
SELECT *
FROM RestauranteMirador7.gastos;

INSERT INTO cortesias  
SELECT *
FROM RestauranteMirador7.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM RestauranteMirador7.cuarentenas;


INSERT INTO bodega_ingresos(comprobante,numComprobante,fechaComprobante,total,idProveedor,idPersona,estado,created_at,updated_at)  
SELECT comprobante,numComprobante,fechaComprobante,total,idProveedor,idPersona,estado,created_at,updated_at
FROM RestauranteMirador7.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM RestauranteMirador7.ingreso_detalles;

INSERT INTO ingrediente_detalles
SELECT *
FROM RestauranteMirador7.ingrediente_detalles;
 

INSERT INTO inventarios
SELECT *
FROM RestauranteMirador7.inventarios;


INSERT INTO inventario_detalles
SELECT *
FROM RestauranteMirador7.inventario_detalles;




INSERT INTO stock_historials
SELECT *
FROM RestauranteMirador7.stock_historials;
