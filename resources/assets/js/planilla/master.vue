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
    this.$router.push({ name: "planilla" });
  }
}
</script>

