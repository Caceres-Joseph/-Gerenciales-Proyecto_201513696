


export class encabezado{


    constructor(){
        this.jsonHeader=[];
    }


    /*
    |--------------------------------------------------------------------------
    | Preguntas
    |--------------------------------------------------------------------------
    */
    tituloSimple(texto, valor) {
        var json = {
            'text': texto,
            'value': valor,
            align: 'center'
        };
        this.jsonHeader.push(json);
    }


    tituloSimpleLeft(texto, valor) {
        var json = {
            'text': texto,
            'value': valor,
            align: 'center'
        };
        this.jsonHeader.push(json);
    }


    tituloSimpleRight(texto, valor) {
        var json = {
            'text': texto,
            'value': valor,
            align: 'center'
        };
        this.jsonHeader.push(json);
    }

    tituloAccion(){

        var json = {
            text: "Acciones",
            sortable: false,
            align: 'center'
        };
        this.jsonHeader.push(json);
    }


    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */
    getJsonEncabezado(){
        return this.jsonHeader;
    }

}