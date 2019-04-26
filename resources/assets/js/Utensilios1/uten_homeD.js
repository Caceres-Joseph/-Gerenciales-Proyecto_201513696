export default function getDefaultData() {
    return {
        tabs: -1,
        searchParent: "",
        dlgAtajos: false,
        dlgBug: false,
        itemBug: {},
        colorDefecto: "orange darken-4",
        srcImagen: "",
        srcLogo: "",
        inicial: "-",


        itemsPersonas: [],
        itemsRols: [],
        itemsUsuarios: [],

        //permisos
        permisos: {
            roles: {
                permiso: false
            },
            personas: {
                permiso: false
            },
            usuarios: {
                permiso: false
            }
        }
    }
}