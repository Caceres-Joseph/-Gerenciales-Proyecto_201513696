CREATE DATABASE -Gamer7;
USE -Gamer7;

INSERT INTO lugar_servirs  
SELECT *
FROM -Gamer6.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM -Gamer6.medidas;

INSERT INTO categorias  
SELECT *
FROM -Gamer6.categorias;

INSERT INTO articulos  
SELECT *
FROM -Gamer6.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM -Gamer6.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM -Gamer6.rols;

INSERT INTO personas  
SELECT *
FROM -Gamer6.personas;

INSERT INTO usuarios  
SELECT *
FROM -Gamer6.usuarios;

INSERT INTO lugars  
SELECT *
FROM -Gamer6.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM -Gamer6.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM -Gamer6.mesas;


INSERT INTO ordens  
SELECT *
FROM -Gamer6.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM -Gamer6.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM -Gamer6.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM -Gamer6.observacions;

INSERT INTO cajas  
SELECT *
FROM -Gamer6.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM -Gamer6.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM -Gamer6.abonos;

INSERT INTO gastos  
SELECT *
FROM -Gamer6.gastos;

INSERT INTO cortesias  
SELECT *
FROM -Gamer6.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM -Gamer6.cuarentenas;


INSERT INTO bodega_ingresos  
SELECT *
FROM -Gamer6.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM -Gamer6.ingreso_detalles;