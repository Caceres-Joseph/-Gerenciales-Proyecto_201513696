CREATE DATABASE -Gamer6;
USE -Gamer6;

INSERT INTO lugar_servirs  
SELECT *
FROM -Gamer5.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM -Gamer5.medidas;

INSERT INTO categorias  
SELECT *
FROM -Gamer5.categorias;

INSERT INTO articulos  
SELECT *
FROM -Gamer5.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM -Gamer5.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM -Gamer5.rols;

INSERT INTO personas  
SELECT *
FROM -Gamer5.personas;

INSERT INTO usuarios  
SELECT *
FROM -Gamer5.usuarios;

INSERT INTO lugars  
SELECT *
FROM -Gamer5.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM -Gamer5.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM -Gamer5.mesas;


INSERT INTO ordens  
SELECT *
FROM -Gamer5.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM -Gamer5.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM -Gamer5.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM -Gamer5.observacions;

INSERT INTO cajas  
SELECT *
FROM -Gamer5.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM -Gamer5.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM -Gamer5.abonos;

INSERT INTO gastos  
SELECT *
FROM -Gamer5.gastos;

INSERT INTO cortesias  
SELECT *
FROM -Gamer5.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM -Gamer5.cuarentenas;


INSERT INTO bodega_ingresos  
SELECT *
FROM -Gamer5.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM -Gamer5.ingreso_detalles;