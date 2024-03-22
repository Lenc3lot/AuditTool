<template>
    <tr>
        <td>{{ info.NomClient }}</td>
        <td>{{ info.NomSrvc }}</td>
        <td>{{ info.typeService }}</td>
        <td><button @click="send(info.clientID,info.serviceID)">&#8505;</button></td>
    </tr>
</template>

<script>
// import store from '@/store'
export default {
  name: 'LigneRecherche',
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
    info: Object
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
    send (clientID, serviceID) {
      this.$emit('selectedSearch', { clientID: clientID, serviceID: serviceID })
    }
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
  text-align: center;
  border: 1px solid rgb(140 140 140);
  /* padding: 1%; */
}

tr>td:nth-child(4){
  display: flex;
  justify-content: center;
  align-items: center;
  align-content: center;
}

button{
  border-radius: 50%;
  aspect-ratio: 1;
  padding: 0.7em;
  font-size: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
