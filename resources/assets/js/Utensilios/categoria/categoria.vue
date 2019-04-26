<template>


    <router-view
            :buscar="buscar"
    ></router-view>


</template>

<script>
    export default {
        props: {
            ip: String,
            buscar: String
        },
        data() {
            return {};
        },

        methods: {
            nuevaCategoria: function (e) {
                this.$router.push({name: 'categoria_nuevo'});
            }
        }
    };
</script>