<template> 
      <router-view></router-view> 
</template>

<script>

export default {
    props: ['ip'],
  data () {
    return {
    }
  },
  methods: {

  },
  created () {
    //this.$log.info("hla "); 
    this.$router.push({ name: "ordenes" });
    // this.$http.get('/users').then(({data}) => console.log(data))
  }
}
</script>

