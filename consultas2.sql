CREATE DATABASE RestauranteMirador6;
USE RestauranteMirador6;

INSERT INTO lugar_servirs  
SELECT *
FROM RestauranteMirador5.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM RestauranteMirador5.medidas;

INSERT INTO categorias  
SELECT *
FROM RestauranteMirador5.categorias;

INSERT INTO articulos  
SELECT *
FROM RestauranteMirador5.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM RestauranteMirador5.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM RestauranteMirador5.rols;

INSERT INTO personas  
SELECT *
FROM RestauranteMirador5.personas;

INSERT INTO usuarios  
SELECT *
FROM RestauranteMirador5.usuarios;

INSERT INTO lugars  
SELECT *
FROM RestauranteMirador5.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM RestauranteMirador5.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM RestauranteMirador5.mesas;


INSERT INTO ordens  
SELECT *
FROM RestauranteMirador5.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM RestauranteMirador5.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM RestauranteMirador5.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM RestauranteMirador5.observacions;

INSERT INTO cajas  
SELECT *
FROM RestauranteMirador5.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM RestauranteMirador5.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM RestauranteMirador5.abonos;

INSERT INTO gastos  
SELECT *
FROM RestauranteMirador5.gastos;

INSERT INTO cortesias  
SELECT *
FROM RestauranteMirador5.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM RestauranteMirador5.cuarentenas;


INSERT INTO bodega_ingresos  
SELECT *
FROM RestauranteMirador5.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM RestauranteMirador5.ingreso_detalles;