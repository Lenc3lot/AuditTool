<template>
  <main>
    <h1>{{ dataStore.dataClient.nomClient }}</h1>
    <h2>Comptes Utilisateurs</h2>
    <h3>Service : {{ serviceName }}</h3>
    <table>
      <tr>
        <th>Utilisateur Id</th>
        <th>Nom de famille</th>
        <th>Prenom</th>
        <th>Login</th>
        <th>Mdp</th>
      </tr>
      <LigneUtilisateurs v-for="utilisateur in userList" :key="utilisateur.utilisateurID" :utilisateur="utilisateur"/>
    </table>
  </main>
</template>

<script>
import store from '@/store'
import LigneUtilisateurs from '@/components/LigneUtilisateurs.vue'
export default {
  name: 'UserView',
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
    LigneUtilisateurs
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
      idService: this.$route.params.idService,
      userList: [],
      serviceName: ''
    }
  },
  methods: {
    // methods here
    getUserDetail () {
      // Ajoute dns les donnees de l'appel ajax que le type de données sélectionnée est 'clients'
      const formData = new FormData()
      formData.append('type', 'detailsUser')
      formData.append('clientId', this.idClient)
      formData.append('serviceId', this.idService)
      // Appel ajax du script de lecture des clients de la BDD en POST
      fetch(this.dataStore.baseUrl + 'readDB.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          if (response.status === 200) {
            this.userList = response.data
          } else {
            console.error('ERREUR :' + response)
          }
        })
        .catch(error => console.error(error))
    }
  },
  mounted () {
    // console.log(this.idService)
    this.getUserDetail()
    // this.serviceName = this.dataStore.dataClient.nomService
    this.serviceName = this.dataStore.dataClient.nomService
  },
  created () {
    // created here
  }
}
</script>

<style scoped>
/* Style here */
body{
    margin: 0px;
}
table{
    border: solid 1px;
    width: 100%;
}
th{
    border: solid 1px;
    /* padding: 10px; */
}
section{
    display: flex;
    justify-content: center;
    width: 100%;
}
</style>
