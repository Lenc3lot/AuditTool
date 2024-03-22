<template>
    <tr>
      <td>{{ utilisateur.utilisateurID }}</td>
      <td>{{ utilisateur.lastName }}</td>
      <td>{{ utilisateur.firstName }}</td>
      <td>{{ utilisateur.userLogin }}</td>
      <td>{{ utilisateur.password }}</td>
    </tr>
</template>

<script>
// import store from '@/store'
export default {
  name: 'LigneUtilisateurs',
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
    utilisateur: Object
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
tr{
    border: solid 1px;
}

td{
    border: solid 1px;
}
</style>
