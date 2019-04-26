<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('login');
}
);

Route::get('/', function () {
    return view('login');
});


Route::group(['middleware' => ['admin']], function () {
    Route::get('/home', function () {
        return view('home');
    }
    );
    Route::get('/peoples', function () {
        return view('peoples');
    }
    );
    Route::get('/mesas', function () {
        return view('mesas');
    }
    );
    Route::get('/ingreso', function () {
        return view('ingreso');
    }
    );

    Route::get('/ordenes', function () {
        return view('ordenes');
    }
    );
    Route::get('/cobrar', function () {
        return view('cobrar');
    }
    );

    Route::get('/reporte', function () {
        return view('reporte');
    }
    );

    Route::get('/utensilios', function () {
        return view('utensilios');
    }
    );


    Route::get('/proveedores', function () {
        return view('proveedores');
    });



    Route::get('/planilla', function () {
        return view('planilla');
    });



    Route::get('/bienvenido', function () {
        return view('welcome');
    }
    )->name('bienvenido');

    Route::post('upload', 'imagen_controller@upload')->name('upload');

    Route::resource('categoria', 'categoria_controller');//le asigno el controlador correspondiente

    //categoria
    Route::get('categoria_items', 'categoria_controller@getItems')->name('categoria_items');
    Route::get('categoria_getitem/{id}', 'categoria_controller@getItem');
    Route::get('categoria_getItemIdPadre/{id}', 'categoria_controller@getItemIdPadre');
    Route::post('categoria_update/{id}', 'categoria_controller@actualizar');
    Route::get('categoria_delete/{id}', 'categoria_controller@deletItem');
    Route::get('categoria_getIdCategoriaPadre/{id}', 'categoria_controller@getIdCategoriaPadre');


    //Media
    Route::post('Medida_insert/', 'medida_controller@insertItem');
    Route::post('Medida_update/{id}', 'medida_controller@updateItem');
    Route::get('Medida_items/', 'medida_controller@getItems');
    Route::get('Medida_item/{id}', 'medida_controller@getItem');
    Route::get('Medida_delete/{id}', 'medida_controller@deleteItem');
    Route::get('Medida_latest/', 'medida_controller@getLatestItem');

    //Articulos
    Route::post('Articulo_insert/', 'articulo_controller@insertItem');
    Route::post('Articulo_update/{id}', 'articulo_controller@updateItem');
    Route::get('Articulo_items/', 'articulo_controller@getItems');
    Route::get('Articulo_item/{id}', 'articulo_controller@getItem');
    Route::get('Articulo_itemIdCategoria/{id}', 'articulo_controller@getItemIdCategoria');

    Route::get('Articulo_hayExistenciaId/{id}', 'articulo_controller@hayExistenciaIdArticulo');

    //


    //getItemIdCategoria
    Route::get('Articulo_NombreItem/{id}', 'articulo_controller@getNameItem');
    Route::get('Articulo_itemsCombo/', 'articulo_controller@getItemsCombo');
    Route::get('Articulo_delete/{id}', 'articulo_controller@deleteItem');
    Route::get('Articulo_latest/', 'articulo_controller@getLatestItem');

    //ArticuloDetalle insertMultipleItems
    Route::post('ArticuloDetalle_insert/', 'articuloDetalle_controller@insertItem');
    Route::post('ArticuloDetalle_insertMultipleItems/', 'articuloDetalle_controller@insertMultipleItems');
    Route::post('ArticuloDetalle_updateMultipleItems/{id}', 'articuloDetalle_controller@updateItem');
    Route::get('ArticuloDetalle_getItemsHijos/{id}', 'articuloDetalle_controller@getItemsHijos');

    //lugarServir
    Route::get('LugarServir_items/', 'lugar_servir_controller@getItems');
    Route::get('LugarServir_item/{id}', 'lugar_servir_controller@getItem');

    //SESSION
    Route::get('session_get', 'SessionController@accessSessionData');
    Route::post('session_set', 'SessionController@storeSessionData');

    //Rol
    Route::post('Rol_insert/', 'rol_controller@insertItem');
    Route::post('Rol_update/{id}', 'rol_controller@updateItem');
    Route::get('Rol_items/', 'rol_controller@getItems');
    Route::get('Rol_items1/', 'rol_controller@getItems1');
    Route::get('Rol_item/{id}', 'rol_controller@getItem');
    Route::get('Rol_delete/{id}', 'rol_controller@deleteItem');
    Route::get('Rol_latest/', 'rol_controller@getLatestItem');

    //Persona
    Route::post('Persona_insert/', 'persona_controller@insertItem');
    Route::post('Persona_update/{id}', 'persona_controller@updateItem');
    Route::get('Persona_items/', 'persona_controller@getItems');
    Route::get('Persona_items2/', 'persona_controller@getItems2');
    Route::get('Persona_items3/{id}', 'persona_controller@getItems3');
    Route::get('Persona_item/{id}', 'persona_controller@getItem');
    Route::get('Persona_delete/{id}', 'persona_controller@deleteItem');
    Route::get('Persona_latest/', 'persona_controller@getLatestItem');
    Route::get('Persona_proveedores/', 'persona_controller@getProveedores');


    //Usuario
    Route::post('Usuario_insert/', 'usuario_controller@insertItem');
    Route::post('Usuario_update/{id}', 'usuario_controller@updateItem');
    Route::get('Usuario_items/', 'usuario_controller@getItems');
    Route::get('Usuario_itemsId/', 'usuario_controller@getItemsId');
    Route::get('Usuario_item/{id}', 'usuario_controller@getItem');
    Route::get('Usuario_delete/{id}', 'usuario_controller@deleteItem');
    Route::get('Usuario_latest/', 'usuario_controller@getLatestItem');
    Route::get('Usuario_actual/', 'usuario_controller@usuarioActual');

    //Lugar de las mesas
    Route::post('Lugar_insert/', 'lugar_controller@insertItem');
    Route::post('Lugar_update/{id}', 'lugar_controller@updateItem');
    Route::get('Lugar_items/', 'lugar_controller@getItems');
    Route::get('Lugar_item/{id}', 'lugar_controller@getItem');
    Route::get('Lugar_delete/{id}', 'lugar_controller@deleteItem');
    Route::get('Lugar_latest/', 'lugar_controller@getLatestItem');

    //Mesas
    Route::post('Mesa_Silla_insertMultipleItems/{id}', 'mesa_sillas_controller@insertMultipleItems');
    Route::get('Mesa_Silla_items/{id}', 'mesa_sillas_controller@getItems');

    //Bodega Ingreso
    Route::post('Bodega_insert/', 'bodega_ingreso_controller@insertItem');
    Route::post('Bodega_update/{id}', 'bodega_ingreso_controller@updateItem');
    Route::get('Bodega_update2/{id}', 'bodega_ingreso_controller@updateItem2');
    Route::get('Bodega_items/', 'bodega_ingreso_controller@getItems');
    Route::post('Bodega_items2/', 'bodega_ingreso_controller@getItemsIdProveedor');


    Route::get('Bodega_item/{id}', 'bodega_ingreso_controller@getItem');
    Route::get('Bodega_delete/{id}', 'bodega_ingreso_controller@deleteItem');
    Route::get('Bodega_latest/', 'bodega_ingreso_controller@getLatestItem');


    //Mesa
    Route::post('Mesa_insert/', 'mesa_controller@insertItem');
    Route::post('Mesa_update/{id}', 'mesa_controller@updateItem');
    Route::get('Mesa_items/', 'mesa_controller@getItems');
    Route::get('Mesa_item/{id}', 'mesa_controller@getItem');
    Route::get('Mesa_itemIdLugar/{id}', 'mesa_controller@getItemLugar');
    Route::get('Mesa_itemIdLugarOcupada/{id}', 'mesa_controller@getMesasIdLugarOcupada');
    Route::get('Mesa_delete/{id}', 'mesa_controller@deleteItem');
    Route::get('Mesa_latest/', 'mesa_controller@getLatestItem');

    //Imprimir
    Route::get('Escribir_orden/', 'imprimir_controller@escribirOrden');
    Route::get('Imprimir_CocinaBarraOrden/{id}', 'imprimir_controller@imprimirCocinaBarra');
    Route::get('Imprimir_Cuenta/{id}', 'imprimir_controller@imprimirCuenta');
    Route::get('Imprimir_Prueba/', 'imprimir_controller@pruebasDeImpresion');
    Route::post('Imprimir_ConstanciaCobro/{id}', 'imprimir_controller@imprimirConstanciaCobro');
    Route::post('Imprimir_ConstanciaCortesia/{id}', 'imprimir_controller@imprimirConstanciaCortesia');
    Route::post('Imprimir_CierreCaja/', 'imprimir_controller@imprimirCierreCaja');
    Route::get('Imprimir_AbonoCajaActual/', 'imprimir_controller@imprimirAbonosCajaActual');
    Route::get('Imprimir_GastoCajaActual/', 'imprimir_controller@imprimirGastosCajaActual');
    Route::get('Imprimir_VentaCajaActual/', 'imprimir_controller@imprimirVentasCajaActual');
    Route::get('Reimprimir_Cuenta/{id}', 'imprimir_controller@reimprimirCuenta');

    //Reportes
    Route::post('Imprimir_DiaVentaCocina/', 'imprimir_controller@DiaVentaCocina');
    Route::post('Imprimir_DiaVentaBarra/', 'imprimir_controller@DiaVentaBarra');
    Route::post('Imprimir_DiaOrdenCortesia/', 'imprimir_controller@DiaOrdenCortesia');
    Route::post('Imprimir_DiaVentaBarraOpcion/', 'imprimir_controller@DiaVentaBarraOpcion');


    //Reportes   
    Route::post('Imprimir_reporteDiaConUsuarios/', 'imprimir_controller@reporteDiaConUsuario');
    Route::get('Imprimir_Stock_Barra/', 'imprimir_controller@ReporteStockBarra');


    //Orden
    Route::post('Orden_insert/', 'orden_controller@insertItem');
    Route::post('Orden_update/{id}', 'orden_controller@updateItem');
    Route::post('Orden_updateTotal/{id}', 'orden_controller@updateItem');
    Route::get('Orden_itemsActualUser/', 'orden_controller@getItemsIdActual');
    Route::get('Orden_idOrdenesActualUser/{id}', 'orden_controller@getOrdenesIdActual');
    Route::get('Orden_ordenesEnCeroMesero/', 'orden_controller@ordenesEnCeroMesero');
    Route::get('Orden_ordenesSinCobrar/', 'orden_controller@getOrdenesSinCobrar');
    Route::get('Orden_itemId/{id}', 'orden_controller@getOrdenId');
    Route::get('Orden_usuarioPorMesa/{id}', 'orden_controller@getUsersForTable');
    Route::get('Orden_deleteOrden/{id}', 'orden_controller@deleteOrden');
    Route::get('Orden_countMesa/{id}', 'orden_controller@getCountOrdensForTable');
    Route::get('Orden_ordenesIdsSinCobrar/{id}', 'orden_controller@getOrdenesIDSinCobrar');
    Route::post('Orden_setDevolucion/', 'orden_controller@setDevolucion');
    Route::post('Orden_setRecuperar/', 'orden_controller@setRecuperar');


    //getCountOrdensForTable
    /* Route::get  ('Mesa_items/'          ,'mesa_controller@getItems');
    Route::get  ('Mesa_item/{id}'       ,'mesa_controller@getItem' );
    Route::get  ('Mesa_itemIdLugar/{id}','mesa_controller@getItemLugar' );
   
    Route::get  ('Mesa_latest/'         ,'mesa_controller@getLatestItem' ); */

    //Orden detalle 
    Route::post('detalle_orden_insertMultiple/{id}', 'detalle_orden_controller@insertMultipleItems');


    //DetalleOrdenIndividual
    Route::post('DetalleOrdenIndividual_insert/', 'detalle_orden_individual_controller@insertItem');
    Route::post('DetalleOrdenIndividual_update/{id}', 'detalle_orden_individual_controller@updateItem');
    Route::post('DetalleOrdenIndividual_updateObservacion/{id}', 'detalle_orden_individual_controller@updateObservacionItem');
    Route::post('DetalleOrdenIndividual_updateObservacionGrupal/{id}', 'detalle_orden_individual_controller@updateObservacionGrupalItem');
    Route::get('DetalleOrdenIndividual_getOrden/{id}', 'detalle_orden_individual_controller@getOrden');
    Route::get('DetalleOrdenIndividual_delteItemDetalleIndividual/{id}', 'detalle_orden_individual_controller@deleteItemDetalleIndividual');
    Route::get('DetalleOrdenIndividualEliminar_getOrden/{id}', 'detalle_orden_individual_controller@getOrdenEliminar');
    Route::post('DetalleOrdenIndividual_editIndividual/{id}', 'detalle_orden_individual_controller@editOrdenIndividual');
    Route::post('DetalleOrdenIndividual_dividirOrden/', 'detalle_orden_individual_controller@dividirOrden');
    Route::get('DetalleOrdenIndividual_idOrdenAgrupados/{id}', 'detalle_orden_individual_controller@getIdOrdenAgrupado');


    //Observaciones
    Route::post('Observacion_insertMultiple/', 'observacion_controller@insertMultipleItems');
    Route::get('Observacion_items/', 'observacion_controller@getItems');

    //editOrdenIndividual
    /* Route::get  ('DetalleOrdenIndividual_items/'        ,'detalle_orden_individual_controller@getItems');
    Route::get  ('DetalleOrdenIndividual_item/{id}'     ,'detalle_orden_individual_controller@getItem' );
    Route::get  ('DetalleOrdenIndividual_delete/{id}'   ,'detalle_orden_individual_controller@deleteItem' );
    Route::get  ('DetalleOrdenIndividual_latest/'       ,'detalle_orden_individual_controller@getLatestItem' );
    */

    //Cuenta getConstancias
    Route::post('ConstanciaPago_insert/', 'constancia_pago_controller@insertItem');
    Route::post('ConstanciaPago_diaUsuarioTotal/', 'constancia_pago_controller@DiaUsuarioTotal');
    Route::post('ConstanciaPago_diaUsuarioDetalle/', 'constancia_pago_controller@DiaUsuarioDetalle');
    Route::get('ConstanciaPago_getConstancias/', 'constancia_pago_controller@getConstancias');


    //caja
    Route::post('Caja_abrirCaja/', 'caja_controller@aperturaCaja');
    Route::post('Caja_cerrarCaja/', 'caja_controller@cierreCaja');
    Route::get('Caja_obtenerUltimaCajaAbierta/', 'caja_controller@obtenerUltimaCajaAbierta');
    Route::get('Caja_obtenerUltimaCajaAbiertaDatos/', 'caja_controller@obtenerUltimaCajaAbiertaDatos');
    Route::post('Caja_ticketParaCierre/', 'caja_controller@ticketParaCierre');
    Route::get('Caja_EfectivoAdejarCajaAnterior/', 'caja_controller@obtenerEfectivoADejarUltimaCajaCerrada');



    //abono 
    Route::post('Abono_insertItem/', 'bono_controller@insertItem');
    Route::get('Abono_getAbonos/', 'bono_controller@getBonos');


    //gasto    getGasto
    Route::post('Gasto_insertItem/', 'gasto_controller@insertItem');
    Route::get('Gasto_getGastos/', 'gasto_controller@getGasto');

    //Detalle Ingreso
    Route::post('DetalleIngreso_insertMultiple/{id}', 'ingreso_detalles_controller@insertMultipleItems');
    Route::get('DetalleIngreso_getItemsIdIngreso/{id}', 'ingreso_detalles_controller@getItemsIdBodega');


    //imprimiIngreso
    Route::post('ingresoImprimir_reimprimirIngresoId/', 'ingresoImprimir_controller@IngresoReimpresion');
    Route::post('ingresoImprimir_reimprimirIngresoIdCancelado/', 'ingresoImprimir_controller@IngresoRempresionCancelado');

    //Reportes
    Route::post('dia_ventasPorEmpleado/', 'reportes_controller@DiaVentasPorEmpleado');
    Route::post('dia_ventaGeneral/', 'reportes_controller@DiaVentaGeneral');
    Route::post('dia_ordenesGeneral/', 'reportes_controller@DiaOrdenGeneral');
    Route::post('dia_ventaBarra/', 'reportes_controller@DiaVentaBarra');
    Route::post('dia_ventaCocina/', 'reportes_controller@DiaVentaCocina');
    Route::post('dia_ordenesCortesia/', 'reportes_controller@DiaOrdenCortesia');
    Route::post('dia_gastos/', 'reportes_controller@DiaGastos');
    Route::post('dia_abonos/', 'reportes_controller@DiaAbonos');
    Route::post('dia_ventaBarraOpcion/', 'reportes_controller@DiaVentaBarraOpcion');
    Route::post('dia_cuarentena/', 'reportes_controller@DiaCuarentena');
    Route::post('dia_devolucion/', 'reportes_controller@DiaDevolucion');

    Route::post('semana_historialProductoDetalle/', 'reportes_controller@SemanaHistorialProductoDetalle');


    Route::get('stock_items/', 'stock_articulos_controller@getItems');


    //Reportes
    Route::post('cuarentena_insertItem/', 'cuarentena_controller@insertarCuarentena');
    Route::get('cuarentena_getItemsActualUsuario/', 'cuarentena_controller@getItemsActualUsuario');
    Route::get('cuarentena_getItems/', 'cuarentena_controller@getItems');
    Route::post('cuarentena_setDevolucion/', 'cuarentena_controller@setDevolucion');


    //ReportesImprimir

    Route::post('reportesImprimir_diaDevolucion/', 'reportesImprimir_controller@Imprimir_DiaDevolucion');
    Route::post('reportesImprimir_diaDeMesero/', 'reportesImprimir_controller@Imprimir_DiaDeMesero');
    Route::post('reportesImprimir_historialProductoDetalle/', 'reportesImprimir_controller@Imprimir_HistorialSemanalProducto');

    //Inventario
    Route::post('inventario_getMovimientoDeLaSemana/', 'inventario_controller@getProductos');
    Route::post('inventario_insertItems/', 'inventario_controller@insertItems');
    Route::get('inventario_items/', 'inventario_controller@getItems');
    Route::post('inventario_consultaPruebaConteo/', 'inventario_controller@getConsultaPrueba');


    //InventarioImprimir
    Route::post('inventarioImprimir_preTicket/', 'inventarioImprimir_controller@inventarioImprimir_preTicket');
    Route::post('inventarioImprimir_actualizado/', 'inventarioImprimir_controller@inventarioImprimir_InventarioActualizado');
    Route::post('inventarioImprimir_reimpresion/', 'inventarioImprimir_controller@inventarioImprimir_InventarioReimpresion');

    //DetalleInventario
    Route::get('detalleInventario_getItemsId/{id}', 'inventarioDetalle_controller@getItemsId');
    Route::post('detalleInventario_getItemsInvAnte/', 'inventarioDetalle_controller@getItemsUltimoInventario');
    Route::post('detalleInventario_getItemsMerma/', 'inventarioDetalle_controller@getItemsMerma');

    //ingredientes
    Route::get('ingredientes_getItems/{id}', 'ingredientes_controller@getAllProducts');
    Route::post('ingredientes_insertItems/', 'ingredientes_controller@insertItems');

    //graficas
    Route::post('grafica_ventasDia/', 'Graficas\c_ventas_dia@ventasDia');
    Route::post('grafica_abonoGastoDia/', 'Graficas\c_ventas_dia@abonoGastoDia');
    Route::post('grafica_meserosDia/', 'Graficas\c_ventas_dia@meserosDia');
    Route::post('grafica_mermasDia/', 'Graficas\c_ventas_dia@mermasDia');
    Route::post('grafica_diferenciaDia/', 'Graficas\c_ventas_dia@diferenciaDia');
    Route::post('grafica_meserosDia2/', 'Graficas\c_ventas_dia@meserosDia2');
    Route::post('grafica_propinaMesero/', 'Graficas\c_ventas_dia@propinaMesero');


    //Utensilios categoria
    Route::post('uCategoria_insertItem/', 'Modulos\Utensilios\categoria_controller@insertItem');
    Route::get( 'uCategoria_getItems/{id}'  , 'Modulos\Utensilios\categoria_controller@getItems');
    Route::get( 'uCategoria_getItems2/'  , 'Modulos\Utensilios\categoria_controller@getItems2');
    Route::get( 'uCategoria_getItem/{id}', 'Modulos\Utensilios\categoria_controller@getItem');
    Route::post('uCategoria_update/{id}', 'Modulos\Utensilios\categoria_controller@updateItem');
    Route::get( 'uCategoria_delete/{id}', 'Modulos\Utensilios\categoria_controller@deletItem');

    //Utensilios
    Route::post('uUtensilio_insertItem/'   ,'Modulos\Utensilios\utensilio_controller@insertItem');
    Route::get( 'uUtensilio_getItems/'     ,'Modulos\Utensilios\utensilio_controller@getItems');
    Route::get( 'uUtensilio_getItem2/{id}' ,'Modulos\Utensilios\utensilio_controller@getItem1');
    Route::post('uUtensilio_update/{id}'   ,'Modulos\Utensilios\utensilio_controller@updateItem');
    Route::get( 'uUtensilio_delete/{id}'   ,'Modulos\Utensilios\utensilio_controller@deleteItem');


    //Bodega Utensilios
    Route::post('uBodega_insert/', 'Modulos\Utensilios\ingreso_controller@insertItem');
    Route::post('uBodega_update/{id}', 'Modulos\Utensilios\ingreso_controller@updateItem');
    Route::get('uBodega_items/', 'Modulos\Utensilios\ingreso_controller@getItems');
    Route::get('uBodega_item/{id}', 'Modulos\Utensilios\ingreso_controller@getItem');
    Route::get('uBodega_delete/{id}', 'Modulos\Utensilios\ingreso_controller@deleteItem');
    Route::get('uBodega_latest/', 'Modulos\Utensilios\ingreso_controller@getLatestItem');


    //Inventario
    Route::get( 'uInventario_getItems/'     ,'Modulos\Utensilios\inventario_controller@getItems');
    Route::post('uInventario_insertItems/', 'Modulos\Utensilios\inventario_controller@insertItems');
    Route::post('uInventario_getItemsInvAnte/', 'Modulos\Utensilios\inventario_controller@getItemsUltimoInventario');

    //Persona
    Route::post('proveedor_insert/'   ,'Modulos\Proveedores\proveedor_controller@insertItem');
    Route::get( 'proveedor_getItems/' ,'Modulos\Proveedores\proveedor_controller@getItems');
    Route::get( 'proveedor_item/{id}'  , 'Modulos\Proveedores\proveedor_controller@getItem');
    Route::post('proveedor_update/{id}', 'Modulos\Proveedores\proveedor_controller@updateItem');
    Route::get( 'proveedor_delete/{id}', 'Modulos\Proveedores\proveedor_controller@deletItem');


    //caja correo
    Route::post('Caja_enviarCorreo/', 'caja_mail_controller@enviarCorreo');
    Route::get('Correo_IdCaja/{id}', 'Pdf\pdf_Cierre@enviarIdCaja');


    //bugs

    Route::post('Bug_insert/'   ,'Modulos\Master\Bugs@insertItem');

    //sueldo

    Route::get( 'sueldo_getTrabajadores/'     ,'Modulos\Personas\sueldo_controller@getTrabajadores');
    Route::post('sueldo_insertar/'   ,'Modulos\Personas\sueldo_controller@insertItem');
    Route::get( 'sueldo_getItems/' ,'Modulos\Personas\sueldo_controller@getItems');
    Route::get( 'sueldo_item/{id}'  , 'Modulos\Personas\sueldo_controller@getItem');


    //planillas

    Route::post('planilla_asistencia/'   ,'Modulos\Planilla\empleados_controller@getAsistencia');
    Route::post('planilla_asistenciaImprimir/'   ,'Modulos\Planilla\empleados_controller@imprimirAsistencia');






});

Route::get( 'planilla_getItems/' ,'Modulos\Planilla\empleados_controller@getItems');
Route::post('Usuario_validation/', 'usuario_controller@validation');
Route::get('Persona_meseros/', 'persona_controller@getMeseros');
Route::get('session_remove', 'SessionController@deleteSessionData');