<template>
    <tr @click="$router.push('/clients/'+client.clientId)">
        <td>{{ client.clientId }}</td>
        <td>{{ client.clientName }}</td>
    </tr>
</template>

<script>
// import store from '@/store'
export default {
  name: 'LigneClients',
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
    client: Object
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
tr{
    border: solid 1px;
}

td{
  text-align: center;
  border: 1px solid rgb(140 140 140);
  padding: 1%;
}

tr>:nth-child(2){
  width: 50%;
}
</style>
