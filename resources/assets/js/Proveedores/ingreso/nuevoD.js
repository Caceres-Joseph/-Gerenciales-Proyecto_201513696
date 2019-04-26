export default function getDefaultData() {
    return {
        /*
               *Display items
               */
        search: "",

        e6: 1,
        items: [],
        medidas: [],

        itemEliminar: null,
        /*
         *Nueva medida
         */
        dialogNuevo: false,
        item: {
            checkCancelado:false,
            checkGasto:true
        },
        select: [],
        exitoso: false,
        requerido: true,
        image: "",
        imageName: "",
        files2: [],
        maskPrice: "credit-card",
        maskNumeric: "#####",

        categoriaModel: null,
        categorias: [],
        customFilter(item, queryText, itemText) {
            const hasValue = val => (val != null ? val : "");
            const text = hasValue(item.nombre);
            const query = hasValue(queryText);
            return (
                text
                    .toString()
                    .toLowerCase()
                    .indexOf(query.toString().toLowerCase()) > -1
            );
        },
        modelChekCategoria: false,

        MedidaModel: null,
        modelChekMedida: false,

        modelTab: "tab-2",
        subProductos: [],
        passwordInput: 0,

        idCategoriaPadre: null,
        idMedidaPadre: null,

        modelTabs: null,
        numTabsProductoHijo: -1,
        /* Para lugar-servir */
        modelChekLugarServir: false,
        lugarServirModel: false,
        lugarServirDatos: [],
        idLugarServirPadre: null,
        /*
         *subProductos
         */
        subProductosModel: null,
        modelChekSubProducto: false,

        articulosCombo: [],

        subProductoTemp: [],
        subProductoCantidad: 0,
        subProductoChipLenght: 0,

        //
        cbModelProductos: null,

        /*
         *Funciones
         */
        campoObligatorio: [v => !!v || "Este campo es obligatorio"],

        snackColor: "teal darken-4",
        snackStatus: false,
        sanckText: " ",

        /* Fecha */
        date: null,
        menu: false,
        modal: false,
        menu2: false,

        /* Fecha2 */
        date2: null,

        /* Para los proveedores */
        modelChekProveedor: false,
        modelChekBodega: false,
        proveedores: [],
        cbModelProveedor: null,
        idProveedorPadre: null,
        modelChekVencimiento: false,

        /* Para la tabla */
        subProductosItems: [],
        headers: [{
            text: "Cant.",
            value: "cantidad"
        },
            {
                text: "Nombre",
                value: "nombre"
            },
            {
                text: "Compra",
                value: "compra"
            },
            {
                text: "Total",
                value: "total"
            },
            {
                text: "Vencimiento",
                value: "fecha_vencimiento"
            },
            {
                text: "Acciones",
                sortable: false
            }
        ],
        dialogNuevoProducto: null,
        itemSubProducto: {},
        itemSubProductoActual: {},
        itemSubProductoTotal: "",

        dlgConfirmar: false

    }
}