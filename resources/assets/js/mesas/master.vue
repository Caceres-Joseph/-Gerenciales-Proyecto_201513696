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
      this.$router.push({ name: "mesas" }); 
    // this.$http.get('/users').then(({data}) => console.log(data))
  }
}
</script>

