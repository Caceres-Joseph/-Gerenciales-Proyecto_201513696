export default {
    props: ['ip'],
    /*
|--------------------------------------------------------------------------
| Data
|--------------------------------------------------------------------------
    */

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
        subProductosModel: null,
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
|--------------------------------------------------------------------------
| Metodos
|--------------------------------------------------------------------------
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
         *Nueva medida
         */
        nuevaCategoria() {
            //this.dialogNuevo = true;
            //this.$nextTick(this.$refs.focoNuevoNombre.focus);
            this.$log.info(this.$snack);
        },
        insertarMuchos() {
            for (let index = 0; index < 3; index++) {
                setTimeout(() => {
                    this.insertar();
                }, 400);
            }
        },
        insertar() {
            var seInsertoBienElPadre = true;
            if (this.item.nombre != null) {
                let uri = this.ip + "Articulo_insert";
                //let uri2 = this.ip + "ArticuloDetalle_insert";
                /* Validando campos */

                if (!this.files2.length) {
                    this.item.imagen = "nada.png";
                } else {
                    this.subirImag(this.files2[0]); //con est estoy subiendo la imagen al servidor
                    this.item.imagen = this.imageName;
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

                if (this.idLugarServirPadre == null) {
                    this.item.idLugarServir = 1;
                } else {
                    this.item.idLugarServir = this.idLugarServirPadre;
                }

                var tCompraDefecto= this.item.precioCompraDefecto
                this.item.precioCompraDefecto = this.formatDecimalMascara(tCompraDefecto);

                var tVentaDefecto= this.item.precioVentaDefecto
                this.item.precioVentaDefecto = this.formatDecimalMascara(tVentaDefecto);



                /* Insertando el articulo */

                this.axios
                    .post(uri, this.item)
                    .then(response => {
                        let uri3 =
                            this.ip + "ArticuloDetalle_insertMultipleItems";
                        //this.$log.info(this.subProductos);
                        this.axios.post(uri3, this.subProductoTemp).then(response => {
                            //this.$log.info("Insertado con hijos correctamente");
                            this.mensajeInfo("Insertado exitosamente!");
                            //Limpiar variables
                            this.limpiarCampos();

                            setTimeout(() => {
                                this.$nextTick(this.$refs.focoNuevoNombre.focus);
                            }, 500);
                        });
                    })
                    .catch(error => {
                        this.mensajeError("Error al inserta el articulo");
                        seInsertoBienElPadre = false;
                    });
                /* hay que limpria variables */
                this.requerido = false;
            } else {
                this.mensajeAdvertencia("Tiene que colocar el nombre del artículo");
            }
            this.dialogNuevo = false;
        },
        sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        },
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
            this.image = "";
            this.files2 = [];
        },
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
            let uri = this.ip + "Articulo_items";
            this.axios.get(uri).then(response => {
                this.articulosCombo = response.data;
            });
        },
        cargarLugarServirCombo() {
            //this.$log.info('Se cargo, jejeje');
            let uri = this.ip + "LugarServir_items";
            this.axios.get(uri).then(response => {
                this.lugarServirDatos = response.data;
            });
        },
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
                /* this.$nextTick(this.$refs.focoMedida.focus); */
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
        addSubproducto() {
            var productoHijo = {
                modelCantidad: null,
                modelArticuloHijo: null,
                idArticulo: 0
            };
            this.subProductos.push(productoHijo);

            this.numTabsProductoHijo++;
            if (this.numTabsProductoHijo == 0) {
                this.cargarArticuloCombo();
            }
            //
            this.modelTabs = this.numTabsProductoHijo.toString();

            //this.modelTabs = (modelTabs < 2 ? modelTabs + 1 : 0).toString()

            //this.$log.info(this.subProductos);
        },
        removeSubproducto(item) {
            /* this.$log.info(item); */
            var index = this.subProductos.indexOf(item);
            //this.$log.info(index);
            if (index > -1) {
                this.subProductos.splice(index, 1);
                this.numTabsProductoHijo--;
                //this.$log.info(this.modelTabs);
                this.modelTabs = this.numTabsProductoHijo.toString();
            }
        },
        cbCambioNuevoCategoria(e) {

            if (e.idCategoria == parseInt(e.idCategoria, 10)) { //es numero
                this.idCategoriaPadre = e.idCategoria;
            }


        },
        cbCambioNuevoMedida(e) {
            if (e.idMedida == parseInt(e.idMedida, 10)) { //es numero
                this.idMedidaPadre = e.idMedida;
            }
        },
        cbCambioNuevoLugarServir(e) {
            if (e.idLugarServir == parseInt(e.idLugarServir, 10)) { //es numero
                this.idLugarServirPadre = e.idLugarServir;
            }
        },
        cbCambioNuevoSubProducto(e) {
            //this.idMedidaPadre = e.idMedida;
            /*  */ 
            if (e.length > -1) { 
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
        limpiarCampos() {
            /* this.item = []; */
            this.item.nombre = null;
            this.item.descripcion = null;
            this.item.codigo = null;
            this.item.stockMinimo = null;
            this.item.precioCompraDefecto = null;
            this.item.precioVentaDefecto = null;

            this.modelChekCategoria = false;
            this.categoriaModel = null;
            this.idCategoriaPadre = null

            this.modelChekMedida = false;
            this.MedidaModel = null;
            this.idMedidaPadre = null

            this.modelChekSubProducto = false;
            this.subProductosModel = [];
            this.subProductoTemp = [];

            this.modelChekLugarServir = false;
            this.lugarServirModel = null;
            this.idLugarServirPadre = null;

            this.removeImage();
        },
        cancelar() {
            this.limpiarCampos();
            setTimeout(() => {
                this.$nextTick(this.$refs.focoNuevoNombre.focus);
            }, 500);

        },
        getLatestItem() {
            let uri = this.ip + "Articulo_latest";
            this.axios.get(uri).then(response => {
                this.getSearchItem = response.data;
                //this.$log.info(this.getSearchItem.idMedida);
            });
        },
        /* 
         *Mensajes medida
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
        |--------------------------------------------------------------------------
        | CHIP
        |--------------------------------------------------------------------------
        */
        clickChip(e) {
            this.$log.info(e);
        },
        /* 
        |--------------------------------------------------------------------------
        | Refrescando subproductos
        |--------------------------------------------------------------------------
        */
        refrescarSubProductos() {
            this.cargarArticuloCombo();
        }, 
         /* 
        |--------------------------------------------------------------------------
        | Para arreglar lo de la mascara
        |--------------------------------------------------------------------------
        */
        formatDecimalMascara(entrada) {
            var entrada2 = String(entrada);
            var array = entrada2.split('.');
            var join1 = array.join('');
            var array2 = join1.split(',');
            var retorno = array2[0] + "." + array2[1];
            var retorno1=parseFloat(retorno);
            return retorno1;
        },
    }
};