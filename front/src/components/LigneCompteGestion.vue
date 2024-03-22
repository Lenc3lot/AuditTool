<template>
    <tr>
        <td>{{compteGestion.idGestion}}</td>
        <td>{{compteGestion.adresseCompte}}</td>
        <td>{{compteGestion.description}}</td>
        <td>{{compteGestion.login}}</td>
        <td>{{compteGestion.password}}</td>
    </tr>
</template>

<script>
// import store from '@/store'
export default {
  name: 'LigneCompteGestion',
  head () {
    return {
      title: 'Document',
      meta: [
        {
          hid: 'description',
          name: 'description',
          content: 'Your Page Description'
        }
      ]
    }
  },
  components: {
    // components here
  },
  props: {
    // props here
    compteGestion: Object
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      // variables here
      // dataStore: store
    }
  },
  methods: {
    // methods here
  },
  mounted () {
    // mounted here
  },
  created () {
    // created here
  }
}
</script>

<style scoped>
/* Style here */
td{
  border: solid 1px;
}
tr{
  border: solid 1px;
}
</style>
