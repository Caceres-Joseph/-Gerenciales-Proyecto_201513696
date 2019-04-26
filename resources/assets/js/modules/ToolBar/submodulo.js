


export class submodulo{


    constructor(router){
        this.router=router;
        this.jsonModulos=[];
        this.jsonAtajos=[];

        this.crearAtajo("Nuevo", "CTRL + N");
        this.crearAtajo("Recargar", "CTRL + R");
        this.crearAtajo("Buscar", "CTRL + F");
    }


    /*
    |--------------------------------------------------------------------------
    | Sub Modulos
    |--------------------------------------------------------------------------
    */
    tituloSimple(nombre, path, tecla, combinacion) {

        var json = {
            'id':this.jsonModulos.length,
            'nombre': nombre,
            'path': path,
            'shortcut':tecla,
            'combinacion':combinacion
        };


        if(tecla!=""){
            this.shortcut(tecla,path);
            this.crearAtajo(nombre, combinacion);
        }


        this.jsonModulos.push(json);
    }

    crearAtajo(nombre, combinacion){
        var json = {
            'tipo':1,
            'id':this.jsonAtajos.length,
            'nombre': nombre,
            'combinacion':combinacion
        };

        this.jsonAtajos.push(json);
    }
    crearAtajoTitulo(nombre){

        var json = {
            'tipo':2,
            'nombre': nombre,
        };

        this.jsonAtajos.push(json);
    }

    shortcut(tecla, ruta){

        window.addEventListener("keydown", e => {

            if (e.ctrlKey && e.altKey && e.code === tecla) {
                //Clientes
                this.router.push({
                    path: ruta
                });
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Funciones
    |--------------------------------------------------------------------------
    */
    getJson(){
        return this.jsonModulos;
    }

    getAtajos(){
        return this.jsonAtajos;
    }

}