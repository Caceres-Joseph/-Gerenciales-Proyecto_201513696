CREATE DATABASE RestauranteMirador7;
USE RestauranteMirador7;

INSERT INTO lugar_servirs  
SELECT *
FROM RestauranteMirador6.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM RestauranteMirador6.medidas;

INSERT INTO categorias  
SELECT *
FROM RestauranteMirador6.categorias;

INSERT INTO articulos  
SELECT *
FROM RestauranteMirador6.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM RestauranteMirador6.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM RestauranteMirador6.rols;

INSERT INTO personas  
SELECT *
FROM RestauranteMirador6.personas;

INSERT INTO usuarios  
SELECT *
FROM RestauranteMirador6.usuarios;

INSERT INTO lugars  
SELECT *
FROM RestauranteMirador6.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM RestauranteMirador6.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM RestauranteMirador6.mesas;


INSERT INTO ordens  
SELECT *
FROM RestauranteMirador6.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM RestauranteMirador6.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM RestauranteMirador6.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM RestauranteMirador6.observacions;

INSERT INTO cajas  
SELECT *
FROM RestauranteMirador6.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM RestauranteMirador6.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM RestauranteMirador6.abonos;

INSERT INTO gastos  
SELECT *
FROM RestauranteMirador6.gastos;

INSERT INTO cortesias  
SELECT *
FROM RestauranteMirador6.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM RestauranteMirador6.cuarentenas;


INSERT INTO bodega_ingresos  
SELECT *
FROM RestauranteMirador6.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM RestauranteMirador6.ingreso_detalles;