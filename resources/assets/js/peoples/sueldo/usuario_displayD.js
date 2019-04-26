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
            {text: "ID", value: "idUsuario"},
            {text: "Persona", value: "nombre"},
            {text: "Horas al día", value: "horasAlDia"},
            {text: "Sueldo/Hora", value: "sueldoHora"},
            {text: "Sueldo/Hora_extra", value: "sueldoExtra"},
            {text: "Contraseña", value: "password"},/*
            {text: "Acciones", sortable: false, align: 'center'}*/
        ],
        items: [],
        dlgEliminar: false
    }
}