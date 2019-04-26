export default function getDefaultData() {
    return {
        /*
        |------------------
        | Items temporal
        |-------------------
        */
        itemEliminar: 0,
        /*
        |------------------
        | Items
        |-------------------
        */
        headers: [
            {text: "Usuario", value: "nombre"},
            {text: "Persona", value: "persona"},
            {text: "Activo", sortable: false, align: 'center'},
            {text: "Acciones", sortable: false, align: 'center'}
        ],
        items: [],
        dlgEliminar: false
    }
}