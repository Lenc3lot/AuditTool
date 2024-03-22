<template>
  <tr>
    <td :id="archiveInternet.auto_s">{{ archiveInternet.auto_s }}</td>
    <td>{{ archiveInternet.typeLien }}</td>
    <td>{{ archiveInternet.souscrisSNS }}</td>
    <td>{{ archiveInternet.fournisseur }}</td>
    <td><button @click="submit()"> &#8634; </button></td>
  </tr>
</template>

<script>
// import store from '@/store'
export default {
  name: 'LigneInfo',
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
    archiveInternet: Object
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
    submit () {
      this.$emit('restoreData')
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
.highlight{
  background-color: rgb(79, 249, 60);
}

tr{
    border: solid 1px;
}

td{
    border: solid 1px;
}
tr>td:nth-child(5){
  display: flex;
  justify-content: center;
}
button {
  border-radius: 50%;
  aspect-ratio: 1;
  padding: 0.7em;
  font-size: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
