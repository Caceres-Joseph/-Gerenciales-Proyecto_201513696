


export class preguntas{


    constructor(){
        this.jsonPreguntas=[];
    }


    /*
    |--------------------------------------------------------------------------
    | Preguntas
    |--------------------------------------------------------------------------
    */
    preguntaSimple(nombre, texto, obligatorio) {

        var json = {
            'id':this.jsonPreguntas.length,
            'tipo': 0,
            'nombre': nombre,
            'texto': texto,
            'obligatorio':obligatorio
        };

        this.jsonPreguntas.push(json);
    }

    preguntaMonetaria(nombre, texto, obligatorio){

        var json={
            'id':this.jsonPreguntas.length,
            'tipo': 1,
            'nombre': nombre,
            'texto': texto,
            'obligatorio':obligatorio
        }
        this.jsonPreguntas.push(json);
    }

    preguntaMultiple(nombre, texto, valores, obligatorio) {
        var json = {
            'id':this.jsonPreguntas.length,
            'tipo': 2,
            'nombre':nombre,
            'valores': valores,
            'texto': texto,
            'obligatorio':obligatorio
        };


        this.jsonPreguntas.push(json);
    }

    preguntaMultipleCheck(nombre, texto, valores, obligatorio) {
        var json = {
            'id':this.jsonPreguntas.length,
            'tipo': 3,
            'nombre':nombre,
            'valores': valores,
            'texto': texto,
            'obligatorio':obligatorio,
            'check':false
        };

        this.jsonPreguntas.push(json);
    }


    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */
    getJson(){
        return this.jsonPreguntas;
    }

}