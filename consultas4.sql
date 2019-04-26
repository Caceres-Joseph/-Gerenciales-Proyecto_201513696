CREATE DATABASE -Gamer8;
USE -Gamer8;

INSERT INTO lugar_servirs  
SELECT *
FROM -Gamer7.lugar_servirs;

INSERT INTO medidas  
SELECT *
FROM -Gamer7.medidas;

INSERT INTO categorias  
SELECT *
FROM -Gamer7.categorias;

INSERT INTO articulos  
SELECT *
FROM -Gamer7.articulos;

INSERT INTO articulo_detalles  
SELECT *
FROM -Gamer7.articulo_detalles;

INSERT INTO rols  
SELECT *
FROM -Gamer7.rols;

INSERT INTO personas  
SELECT *
FROM -Gamer7.personas;

INSERT INTO usuarios  
SELECT *
FROM -Gamer7.usuarios;

INSERT INTO lugars  
SELECT *
FROM -Gamer7.lugars;

INSERT INTO mesa_sillas  
SELECT *
FROM -Gamer7.mesa_sillas;

INSERT INTO mesas  
SELECT *
FROM -Gamer7.mesas;


INSERT INTO ordens  
SELECT *
FROM -Gamer7.ordens;


INSERT INTO detalle_ordens  
SELECT *
FROM -Gamer7.detalle_ordens;

INSERT INTO detalle_orden_individuals  
SELECT *
FROM -Gamer7.detalle_orden_individuals;

INSERT INTO observacions  
SELECT *
FROM -Gamer7.observacions;

INSERT INTO cajas  
SELECT *
FROM -Gamer7.cajas;

INSERT INTO constancia_pagos  
SELECT *
FROM -Gamer7.constancia_pagos;

INSERT INTO abonos  
SELECT *
FROM -Gamer7.abonos;

INSERT INTO gastos  
SELECT *
FROM -Gamer7.gastos;

INSERT INTO cortesias  
SELECT *
FROM -Gamer7.cortesias;

INSERT INTO cuarentenas  
SELECT *
FROM -Gamer7.cuarentenas;


INSERT INTO bodega_ingresos(comprobante,numComprobante,fechaComprobante,total,idProveedor,idPersona,estado,created_at,updated_at)  
SELECT comprobante,numComprobante,fechaComprobante,total,idProveedor,idPersona,estado,created_at,updated_at
FROM -Gamer7.bodega_ingresos;

INSERT INTO ingreso_detalles
SELECT *
FROM -Gamer7.ingreso_detalles;

INSERT INTO ingrediente_detalles
SELECT *
FROM -Gamer7.ingrediente_detalles;
 

INSERT INTO inventarios
SELECT *
FROM -Gamer7.inventarios;


INSERT INTO inventario_detalles
SELECT *
FROM -Gamer7.inventario_detalles;




INSERT INTO stock_historials
SELECT *
FROM -Gamer7.stock_historials;
