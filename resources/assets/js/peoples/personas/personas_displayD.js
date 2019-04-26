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
            {text: "Nombre", value: "nombre"},
            {text: "Telefono", value: "telefono"},
            {text: "Tipo", value: "tipo_documento"},
            {text: "Numero Doc.", value: "num_documento"},
            {text: "Direccion", value: "direccion"},
            {text: "Correo", value: "cerreo"},
            {text: "Rol", value: "rol"},
            {
                text: "Acciones", sortable: false,
                align: 'center'
            }
        ],
        items: [],
        dlgEliminar: false
    }
}