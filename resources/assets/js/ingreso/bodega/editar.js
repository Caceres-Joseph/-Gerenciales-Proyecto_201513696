export default {
    props: ['ip'],
    data: () => ({
        /* 
         *Display items
         */
        search: "",

        dialog: false,
        headers: [{
                text: "Nombre",
                value: "nombre"
            },
            {
                text: "Prefijo",
                value: "prefijo"
            },
            {
                texto: "Acciones",
                value: ""
            }
        ],
        items: [],
        medidas: [],

        itemEliminar: null,
        /* 
         *Nueva medida
         */
        dialogNuevo: false,
        item: {},
        exitoso: false,
        requerido: true,
        image: "",
        imagenGlobal: "",
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
        medidas: [],
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
        subProductosModel: [],
        subProductosModel2: [],
        modelChekSubProducto: false,

        articulosCombo: [],

        subProductoTemp: [],
        subProductoCantidad: 0,
        subProductoChipLenght: 0,
        /* 
         *Modificar medida
         */
        dialogModificar: false,
        itemM: {},
        getSearchItem: "",
        /* 
         *Funciones
         */
        campoObligatorio: [v => !!v || "Este campo es obligatorio"],

        snackColor: "teal darken-4",
        snackStatus: false,
        sanckText: " "
    }),

    computed: {},

    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    created() {
        this.inicializar();
        setTimeout(() => {
            this.$nextTick(this.$refs.focoNuevoNombre.focus);
        }, 500);
    },
    /*
|*************************************************************************
| Metodos
|*************************************************************************
    */
    methods: {
        inicializar() {
            let uri = this.ip + "Medida_items";
            this.axios.get(uri).then(response => {});
            //
        },
        editItem(item) {
            this.dialogModificar = true;
            this.itemM.nombre = item.nombre;
            this.itemM.prefijo = item.prefijo;
            this.itemM.idMedida = item.idMedida;
            this.getSearchItem = item;
            /*         this.$router.push({
                name: "categoria_editar",
                params: { id: item.idCategoria }
              }); */
        },

        deleteItem(item) {
            this.itemEliminar = item;
            this.dialog = true;
        },

        close() {
            this.dialog = false;
        },
        eliminar() {
            let uri = this.ip + `Medida_delete/${
          this.itemEliminar.idMedida
        }`;
            this.axios
                .get(uri)
                .then(response => {
                    //this.$log.info(index);
                    if (index > -1) {
                        this.medidas.splice(index, 1);
                    }
                    this.mensajeInfo("Item eliminado exitosamente");
                })
                .catch(error => {
                    this.mensajeError("No se pudo eliminar el item");
                });

            this.close();
        },
        /*
        +------------------------------------------------+
        |   Insertar
        +------------------------------------------------+
        */
        insertar() {
            var seInsertoBienElPadre = true;
            if (this.item.nombre != null) {
                let uri = this.ip + `Articulo_update/${this.$route.params.id}`;
                //let uri = this.ip + "Articulo_update";
                //let uri2 = this.ip + "ArticuloDetalle_insert";
                /* Validando campos */

                if (this.image == null) {
                    this.item.imagen = "nada.png";
                } else {

                    if (!this.files2.length) {
                        //solo se guarda como ruta, jajaja
                        //this.$log.info("hay que guardarla imagen prro");
                        this.item.imagen = this.imagenGlobal;
                        //this.item.imagen = this.imagen;
                    } else {
                        this.subirImag(this.files2[0]); //con est estoy subiendo la imagen al servidor
                        this.item.imagen = this.imageName;
                    }
                }
                if (this.idCategoriaPadre == null) {
                    this.item.idCategoria = 1;
                } else {
                    this.item.idCategoria = this.idCategoriaPadre;
                }

                if (this.idMedidaPadre == null) {
                    this.item.idMedida = 1;
                } else {
                    this.item.idMedida = this.idMedidaPadre;
                }
                if (this.idLugarServirPadre==null) {
                    this.item.idLugarServir = 1;
                } else {
                    this.item.idLugarServir = this.idLugarServirPadre;
                }
                
                /* Insertando el articulo */
                //this.$log.info(this.item);
                this.axios
                    .post(uri, this.item)
                    .then(response => {
                        let uri3 = this.ip + `ArticuloDetalle_updateMultipleItems/${this.$route.params.id}`;
                        this.axios.post(uri3, this.subProductoTemp).then(response => {
                            this.$log.info("Modificado");
                            this.$router.push({
                                name: "articulo"
                            });
                        }).catch(error => {
                            this.mensajeError("Error al modificar sub-articulos");
                         
                        }); 
                    }).catch(error => {
                        this.mensajeError("Error al modificar el articulo"); 
                    }); 

                //this.$log.info(this.subProductoTemp);
                /*                 this.axios
                                    .post(uri, this.item)
                                    .then(response => {
                                        let uri3 =
                                            this.ip + "ArticuloDetalle_insertMultipleItems";
                                        //this.$log.info(this.subProductos);
                                        this.axios.post(uri3, this.subProductoTemp).then(response => {
                                            //this.$log.info("Insertado con hijos correctamente");
                                            this.mensajeInfo("Modificado exitosamente!");
                                            //Limpiar variables
                                            this.limpiarCampos();

                                            setTimeout(() => {
                                                this.$nextTick(this.$refs.focoNuevoNombre.focus);
                                            }, 500);
                                        });
                                    })
                                    .catch(error => {
                                        this.mensajeError("Error al modificar el articulo");
                                        seInsertoBienElPadre = false;
                                    }); */


                /* hay que limpria variables */
                this.requerido = false;
            } else {
                this.mensajeAdvertencia("Tiene que colocar el nombre del artículo");
            }
            this.dialogNuevo = false;
        },
        /*
        +------------------------------------------------+
        |   Imagen
        +------------------------------------------------+
        */
        subirImagen() {
            if (!this.files2.length) return;
            this.subirImag(this.files2[0]);
        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            this.files2 = e.target.files || e.dataTransfer.files;
            this.imageName = files[0].name;

            this.$log.info(files[0].name);

            if (!files.length) return;
            this.createImage(files[0]);
        },
        subirImag(file) {
            let formData = new FormData();
            let uri = this.ip + "upload";
            formData.append("file", file);

            this.axios
                .post(uri, formData)
                .then(function () {
                    //this.$log.info("SUCCESS!!");
                })
                .catch(function () {
                    //this.$log.info("FAILURE!!");
                });
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = e => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.image = null;
            this.files2 = [];
        },
        /*
        +------------------------------------------------+
        |   Cargas a los combos
        +------------------------------------------------+
        */
        cargarCategoriaPadre() {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "categoria_items";
            this.axios.get(uri).then(response => {
                this.categorias = response.data;
            });
        },
        cargarMedida() {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "Medida_items";
            this.axios.get(uri).then(response => {
                this.medidas = response.data;
            });
        },
        cargarArticuloCombo() {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "Articulo_itemsCombo";
            this.axios.get(uri).then(response => {
                this.articulosCombo = response.data;
            });
        },
        cargarArticuloComboInicial(idArticulo) {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "Articulo_itemsCombo";
            this.axios.get(uri).then(response => {
                this.articulosCombo = response.data;
                this.llenandoSubProductos(idArticulo);

            });
        },
        cargarLugarServirCombo() {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "LugarServir_items";
            this.axios.get(uri).then(response => {
                this.lugarServirDatos = response.data;
            });
        },
        /*
        +------------------------------------------------+
        |   CheckBox
        +------------------------------------------------+
        */
        checkBoxCategoria(e) {
            if (!e) {
                //si es falso
                this.categoriaModel = null;
                this.idCategoriaPadre = null;
            } else {
                this.cargarCategoriaPadre();
            }
            /* this.$nextTick(this.$refs.focoNuevoCategoria.focus); */
        },
        checkBoxMedida(e) {
            if (!e) {
                //si es falso
                this.MedidaModel = null;

                this.idMedidaPadre = null;
            } else {
                this.cargarMedida();
                // this.$nextTick(this.$refs.focoMedida.focus); 
            }
        },
        checkBoxSubProducto(e) {
            if (!e) {
                //si es falso
                this.subProductosModel = [];
                this.subProductoTemp = [];
                this.subProductoChipLenght = 0;
            } else {
                this.cargarArticuloCombo();
                //this.cargarMedida();
                /* this.$nextTick(this.$refs.focoMedida.focus); */
            }
        },
        checkBoxLugarServir(e) {
            if (!e) {
                //si es falso
                this.lugarServirDatos = [];
                this.idLugarServirPadre = null;
            } else {
                this.cargarLugarServirCombo();
                //this.cargarMedida();
                /* this.$nextTick(this.$refs.focoMedida.focus); */
            }
        },
        /*
        +------------------------------------------------+
        |   Cambio de combo box
        +------------------------------------------------+
        */
        cbCambioNuevoCategoria(e) {

            if (e == parseInt(e, 10)) { //es numero
                this.idCategoriaPadre = e;
                //this.$log.info(e);
            }


        },
        cbCambioNuevoMedida(e) {
            if (e == parseInt(e, 10)) { //es numero
                //this.$log.info(e);
                this.idMedidaPadre = e;
            }


        },
        cbCambioNuevoLugarServir(e) {
            //this.$log.info(e);
            if (e == parseInt(e, 10)) { //es numero
                this.idLugarServirPadre = e;
            }    
        },
        cbCambioNuevoSubProducto(e) {
            if (e.length > -1) {
                //Parasaber si se esta eliminando un item 
                if (this.subProductoChipLenght < e.length) {
                    var person = prompt(" Ingrese la cantidad de productos2");
                    if (e.length >= 0) {
                        //validando que se haya ingresado un número y no  una letra, jejeje
                        //var isNum=!Number.isInteger(person);  
                        var regexp = /^\d+\.?\d{0,3}$/;
                        if (regexp.test(person)) {
                            if (person < 0) {
                                this.mensajeError("El numero tiene que ser positivo");
                                e.pop();
                            } else {
                                e[e.length - 1].idCategoria = parseFloat(person);
                                this.$log.info(e[e.length - 1].idCategoria);
                            }
                        } else {
                            this.mensajeError("Ingrese un valor válido");
                            e.pop();
                        } 
                        //this.$log.info(this.subProductoTemp);
                    }
                }
                this.subProductoTemp = e;
                this.subProductoChipLenght = e.length;
            }
/*             //this.idMedidaPadre = e.idMedida; 
            //this.$log.info(e);
            if (e.length >= 0) {
                //Parasaber si se esta eliminando un item 
                if (this.subProductoChipLenght < e.length) {
                    var person = prompt(" Ingrese la cantidad de productos");
                    if (e.length >= 0) {
                        //validando que se haya ingresado un número y no  una letra, jejeje
                        //var isNum=!Number.isInteger(person); 
                        if (person == parseInt(person, 10)) {
                            if (person > 0) {
                                e[e.length - 1].idCategoria = parseInt(person, 10);
                            } else {
                                e[e.length - 1].idCategoria = 1;
                                this.mensajeAdvertencia("El numero tiene que ser igual o mayor que 1");

                            }

                        } else {
                            e[e.length - 1].idCategoria = 1;
                            this.mensajeAdvertencia("Ingrese un número entero positivo!")

                        }


                    }

                } this.subProductoTemp = e;

                this.subProductoChipLenght = e.length; 
            } */
           
        },
        //cbCambioNuevoSubProducto
        cbCambioProductoHijo(e) {
            if (e.idArticulo != null) {
                //Hay que validar que no este en otro combo, jejeje

                for (let i = 0; i < this.subProductos.length; i++) {
                    var element = this.subProductos[i];
                    if (e.idArticulo == element.idArticulo) {

                        this.mensajeAdvertencia("El subproducto ya estaba agregado");
                        this.subProductos.splice(this.numTabsProductoHijo, 1);
                        this.numTabsProductoHijo--;
                        this.modelTabs = i.toString();
                        return;
                    }
                }
                this.subProductos[this.modelTabs].modelArticuloHijo = e.nombre;
                this.subProductos[this.modelTabs].idArticulo = e.idArticulo;
                /* var index = this.articulosCombo.indexOf(e);
                  //this.$log.info(index);
                  if (index > -1) {
                    this.articulosCombo.splice(index, 1);
                  } */
            }
            //this.$log.info(this.subProductos);
        },
        /*
        +------------------------------------------------+
        |   Limpiando
        +------------------------------------------------+
        */
        limpiarCampos() {
            /* this.item = []; */
            this.item.nombre = "";
            this.item.descripcion = "";
            this.item.codigo = "";
            this.item.stockMinimo = "";
            this.item.precioCompraDefecto = "";
            this.item.precioVentaDefecto = "";

            this.modelChekCategoria = false;
            this.categoriaModel = null;
            this.idCategoriaPadre = null

            this.modelChekMedida = false;
            this.MedidaModel = null;
            this.idMedidaPadre = null

            this.modelChekSubProducto = false;
            this.subProductosModel = [];
            this.subProductoTemp = [];

            this.removeImage();
        },
        cancelar() {
            this.$router.push({
                name: "articulo"
            });
        },
        getLatestItem() {
            let uri = this.ip + "Articulo_latest";
            this.axios.get(uri).then(response => {
                this.getSearchItem = response.data;
                //this.$log.info(this.getSearchItem.idMedida);
            });
        },
        /*
        +------------------------------------------------+
        |   Mensajes
        +------------------------------------------------+
        */
        mensajeError(mensaje) {
            this.snackColor = "red";
            this.sanckText = "[Error] " + mensaje;
            this.snackStatus = true;
        },
        mensajeInfo(mensaje) {
            this.snackColor = "light-blue darken-4";
            this.sanckText = mensaje;
            this.snackStatus = true;
        },
        mensajeAdvertencia(mensaje) {
            this.snackColor = "amber darken-4";
            this.sanckText = "[Advertencia] " + mensaje;
            this.snackStatus = true;
        },
        /*
        +------------------------------------------------+
        |   Main, para cargar los valores
        +------------------------------------------------+
        */
        principal() {
            //hay que traer el dato de la base de datos, jejeje
            let uri = this.ip + `Articulo_item/${
                this.$route.params.id
            }`;
            this.axios.get(uri).then(response => {
                var respuesta = response.data;
                //this.$log.info(response.data);

                this.item.nombre = respuesta.nombre;
                this.item.descripcion = respuesta.descripcion;
                this.item.codigo = respuesta.codigo;
                this.item.stockMinimo = respuesta.stockMinimo;
                this.item.precioCompraDefecto = respuesta.precioCompraDefecto;
                this.item.precioVentaDefecto = respuesta.precioVentaDefecto;
                //
                //this.$log.info(respuesta);
                if (respuesta.idCategoria != 1) { //vino categoria
                    this.modelChekCategoria = true;
                    this.cargarCategoriaPadre();
                    this.categoriaModel = respuesta.idCategoria;
                    this.idCategoriaPadre = respuesta.idCategoria;
                }


                if (respuesta.idMedida != 1) { //no vino categoria
                    this.modelChekMedida = true;
                    this.cargarMedida();
                    this.MedidaModel = respuesta.idMedida;
                    this.idMedidaPadre = respuesta.idMedida;

                }

                if (respuesta.idLugarServir != 1) { //no vino idLugar
                    this.modelChekLugarServir = true;
                    this.cargarLugarServirCombo();
                    this.lugarServirModel = respuesta.idLugarServir;
                    this.idLugarServirPadre = respuesta.idLugarServir;

                }


                // this.$log.info(respuesta.imagen);
                if (
                    respuesta.imagen != "/storage/images/categorias/nada.png"
                ) {
                    this.image = respuesta.imagen;
                    this.imagenGlobal = respuesta.imagen;
                    //this.$log.info(this.imagenGlobal);
                } else {
                    this.image = null;
                }


                this.cargarArticuloComboInicial(respuesta.idArticulo);

                /*  setTimeout(() => {
                    this.llenandoSubProductos(respuesta.idArticulo);
                }, 4000);  */




            });


        },
        llenandoSubProductos(idArticulo) {
            let uri3 = this.ip + `ArticuloDetalle_getItemsHijos/${idArticulo}`;
            this.axios.get(uri3).then(response => {
                var temp = response.data;
                //this.$log.info(response.data[0].idArticulo);
                let indice = 0;
                for (let k = 0; k < temp.length; k++) {
                    var elementSubProducto = temp[k];
                    var dat = {
                        idArticulo: elementSubProducto.idArticulo,
                        idCategoria: 1,
                        nombre: "sfa"
                    };
                    for (let j = 0; j < this.articulosCombo.length; j++) {
                        var temp2 = this.articulosCombo[j];
                        if (temp2.idArticulo == dat.idArticulo) {
                            temp2.idCategoria = elementSubProducto.cantidad;
                            dat.nombre = temp2.nombre;
                            dat.idCategoria = temp2.idCategoria;
                            //this.$log.info(dat);
                            this.subProductosModel2[k] = dat;
                            break;
                        }
                    }
                }
                /*  var vectorProductos = [];
                 var dat = {
                     idArticulo: 3739,
                     idCategoria: 1,
                     nombre: "sfa"
                 };  
                 dat.idArticulo = temp[0].idArticulo;
                 //this.forSubProductos(indice, temp, vectorProductos);
                 this.$log.info(temp);

                 for (let j = 0; j < this.articulosCombo.length; j++) {
                     var temp2 = this.articulosCombo[j];
                     if (temp2.idArticulo == dat.idArticulo) {
                         temp2.idCategoria = temp[0].cantidad;
                         dat.nombre = temp2.nombre;
                         dat.idCategoria = temp2.idCategoria;
                         this.$log.info(dat);
                         this.subProductosModel2[0] = dat;
                         break;
                     } 
                 }  */

                this.subProductosModel = this.subProductosModel2;
                if (this.subProductosModel2.length > 0) {
                    this.modelChekSubProducto = true;
                }
                this.subProductoTemp = this.subProductosModel2;
                this.subProductoChipLenght = this.subProductoTemp.length;
                /* setTimeout(() => {
                    this.$log.info("insertado");
                    this.subProductosModel[0] = dat;
                }, 4000); */
                /* var dat = {
                    idArticulo: 3739,
                    idCategoria: 1,
                    nombre: "sfa"
                };
                 */


                /* for (let index = 0; index < temp.length; index++) {
                    var element = temp[index];
                    //this.subProductosModel[0] = dat;
                    var dat = {
                        idArticulo: 3739,
                        idCategoria: 1,
                        nombre: "sfa"
                    };
                    dat.idArticulo = element.idArticulo;
                    var boolean = false;
                    setTimeout(() => {
                        let uri3 = this.ip + `Articulo_NombreItem/${dat.idArticulo}`;
                        this.axios.get(uri3).then(response1 => {
                            dat.nombre = response1.data.nombre;
                            dat.idCategoria = response1.data.idCategoria;
                            this.subProductosModel[indiceModelSubProducto] = dat;
                            indiceModelSubProducto++;

                            this.$log.info(dat.idArticulo);

                            boolean = true;
                        });


                    }, 1000);


                    //
                } */

                //this.$log.info(temp[0]);
                //var dat = {idArticulo: 3698, idCategoria:1,nombre:"jhosef"};
                /* dat.idArticulo = temp[0].idArticulo;
                dat.idCategoria = temp[0].catidad;
                dat.nombre="jhosef" */
                //this.subProductosModel[0] = dat;
                //this.subProductosModel[0] = response.data[0].idArticulo;

                //this.subProductosModel[0].idCategoria = 23;
                /* let uri = this.ip + `Articulo_item/${
                    temp.idArticulo
                }`;
                this.axios.get(uri).then(response2 => {
                    this.subProductosModel[0]=response2.data;
                });
                 */
            });
        },
        colocar(indice, dat) {

        },
        forSubProductos(indice, temp, vectorProductos) {
            var longitud = temp.length;
            var element = temp[indice];
            if (indice < longitud) { //ejecutar el ciclo, de lo contrario salir


                //dat.idArticulo = element.idArticulo;
                var tempAxios;
                let uri3 = this.ip + `Articulo_NombreItem/${element.idArticulo}`;
                this.axios.get(uri3).then(response1 => {
                    //tempAxios = response1.data;
                    //this.$log.info(tempAxios);
                    //vectorProductos.push(response1.data);
                    this.subProductosModel2[indice] = response1.data;
                    indice++;
                    this.forSubProductos(indice, temp, vectorProductos);
                });


                //dat.idArticulo = element.idArticulo;
                /*   for (let j = 0; j < this.articulosCombo.length; j++) {
                      var temp2 = this.articulosCombo[j];
                      if (temp2.idArticulo==dat.idArticulo) {
                          dat.nombre = temp2.nombre;
                          dat.idCategoria = temp2.idCategoria;
                          this.subProductosModel[indice] = dat;
                          break;
                      }
                      
                  }  */

                //dat.nombre = response1.data.nombre;
                //dat.idCategoria = response1.data.idCategoria;

            } else {

                /* for (let index = 0; index < vectorProductos.length; index++) {
                    var vectorElement = vectorProductos[index];
                    var dat = {
                        idArticulo: 3739,
                        idCategoria: 1,
                        nombre: "sfa"
                    };
                    dat.idArticulo = vectorElement.idArticulo;
                    dat.idCategoria = vectorElement.idCategoria;
                    dat.nombre = vectorElement.nombre;
                    this.subProductosModel[index] = vectorElement;
                    //this.$log.info(vectorElement);
                } */
                this.subProductosModel = this.subProductosModel2;

            }
        },
        accionDespues() {
            this.subProductosModel[0].idCategoria = 100;
        },
        sleep(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        }

    },
    created: function () {
        this.principal();
    },
    /* 
    |--------------------------------------------------------------------------
    | Refrescando subproductos
    |--------------------------------------------------------------------------
    */
    refrescarSubProductos() {
        this.cargarArticuloCombo();
    }
};