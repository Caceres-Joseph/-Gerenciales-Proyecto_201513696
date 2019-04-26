export default function getDefaultData() {
    return {

        /* SnackBar */
        snackColor: "teal darken-4",
        snackStatus: false,
        sanckText: " ",


        /* Dia */
        day: null,
        menu: false,


        /* Dia2 */
        day2: null,
        menu2: false,


        itemEnviar: {}

        ,


        /* TABLA */

        headers: [
            {
                text: "Fecha.",
                value: "fecha"
            },
            {
                text: "Entrada",
                value: "entrada"
            },
            {
                text: "Salida",
                value: "salida"
            },
            {
                text: "Tiempo HH:mm:ss",
                value: "horas"
            }
        ],
        ventas: [],


    }
}