<template>
  <tr>
    <td :id="serviceInternet.auto_s"  :class="highlight ? 'highlight' : ''" >{{ serviceInternet.auto_s }}</td>
    <td :class="highlight ? 'highlight' : ''">{{ serviceInternet.typeLien }}</td>
    <td :class="highlight ? 'highlight' : ''">{{ serviceInternet.souscrisSNS }}</td>
    <td :class="highlight ? 'highlight' : ''">{{ serviceInternet.fournisseur }}</td>
    <td :class="highlight ? 'highlight' : ''"><button @click="submit()"> &#8505; </button></td>
  </tr>
</template>

<script>
export default {
  name: 'LigneServiceAccesIntrnt',
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
    serviceInternet: Object,
    highlight: Boolean
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      // variables here
    }
  },
  methods: {
    submit () {
      this.$emit('recupFullData')
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
#test{
  background-color: black !important;
  background: black !important;
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
