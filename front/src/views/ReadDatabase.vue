<template>
  <main>
    <h1>Liste clients</h1>
    <table>
      <tr>
        <th scope="col">Id Client</th>
        <th scope="col">Nom Client</th>
      </tr>
      <LigneClients v-for="client in clientsList" :key="client.clientId" :client="client"/>
    </table>
  </main>
</template>

<script>
import store from '@/store'
import LigneClients from '@/components/LigneClients.vue'
export default {
  name: 'ReadDatabase',
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
    LigneClients
  },
  props: {
    // props here
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      clientsList: [],
      dataStore: store
    }
  },
  methods: {
    /**
     * Summary : Permet de lire la liste des différents clients
     */
    readDataBase () {
      // Ajoute dns les donnees de l'appel ajax que le type de données sélectionnée est 'clients'
      const formData = new FormData()
      formData.append('action', 'getClients')
      formData.append('req', 'client')
      // Appel ajax du script de lecture des clients de la BDD en POST
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        // Si réponse positive à la promesse, on crée dynamiquement un tableau
        // qui contient les ids des clients ainsi que leur nom
        .then(response => {
          console.log(response)
          this.clientsList = response.data
        })
        .catch(error => console.error(error))
    }
  },
  mounted () {
    // mounted here
    this.readDataBase()
  },
  created () {
    // created here
  }
}
</script>

<style scoped>
main{
  display: flex;
  flex-direction: column;
  align-items: center;
}

table{
  border-collapse: collapse;
  border: 2px solid rgb(140 140 140);
  /* width: 50%; */
  flex: 1 1 100%;
}

td{
  text-align: center;
  border: 1px solid rgb(140 140 140);
  padding: 1%;
  width: 25%;
}

th[scope='col'] {
  background-color: #505050;
  color: #fff;
}

tr:nth-of-type(even) {
  background-color: #eee;
}
</style>
