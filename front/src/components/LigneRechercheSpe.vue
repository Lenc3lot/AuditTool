<template>
    <ul>
        <li>{{ src.nomClient }}</li>
        <li>{{ src.nomService }}</li>
        <li>{{ src.description }}</li>
        <li> {{ src.Recherche }}</li>
        <li><button @click="send(src.clientID,src.serviceID)">&#8505;</button></li>
    </ul>
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
    src: Object
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

ul{
    display: flex;
    flex-direction: row;
    justify-content: center;
    text-align: center;
    list-style: none;
    padding: 1%;
    border: solid gray;
    align-items: center;
    flex-wrap: wrap;
}

li{
    padding: 1%;
    margin: 1%;
}

button{
  border-radius: 50%;
  aspect-ratio: 1;
  padding: 0.8em;
  font-size: 100%;
  justify-content: center;
  align-items: center;
}
</style>
