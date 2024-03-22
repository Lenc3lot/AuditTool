<template>
  <main>
    <h1>{{ nomCli }}</h1>
    <section>
      <div @click="$router.push('/clients/'+ this.idClient + '/services')"><h2>Services</h2></div>
      <div><h2>Architecture</h2></div>
    </section>
  </main>
</template>

<script>
import store from '@/store'
export default {
  name: 'CliDetails',
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
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      // variables here
      dataStore: store,
      idClient: this.$route.params.id,
      nomCli: ''
    }
  },
  methods: {
    // methods here
    /**
     * Summary : Vient définir la variable nomCli
     */
    getNom () {
      const formData = new FormData()
      formData.append('action', 'getNomCli')
      formData.append('req', 'client')
      formData.append('clientId', this.idClient)
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          const clinom = response.data[0].name
          this.nomCli = clinom
          this.dataStore.dataClient.nomClient = clinom
        })
    }
  },
  mounted () {
    console.log(this.idClient)
    this.getNom()
    this.dataStore.dataClient.idDuClient = this.idClient
  },
  created () {
    // created here
  }
}
</script>

<style scoped>
body{
  margin: 0px;
}

section>div {
  color: black;
  flex: 0 0 40%;
  background-color: lightgray;
  border-radius: 20px 20px 20px 20px;
  border: solid;
}

section{
    display: flex;
    justify-content: space-evenly;
    align-items: center;
}

section>div:hover {
  /* flex: 0 0 50%; */
  background-color: gray;
  border-radius: 20px 20px 20px 20px;
  border: solid;
}
</style>
