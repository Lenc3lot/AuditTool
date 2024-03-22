<template>
  <main>
    <h1>{{ dataStore.dataClient.nomClient }}</h1>
    <h2>Gestion comptes</h2>
    <table>
        <tr>
            <th>Id compte</th>
            <th>Adresse</th>
            <th>Description</th>
            <th>Login</th>
            <th>Mot de passe</th>
        </tr>
    <LigneCompteGestion v-for="compteGestion in compteGestionList" :key="compteGestion.idGestion" :compteGestion="compteGestion"/>
    </table>
  </main>
</template>

<script>
import store from '@/store'
import LigneCompteGestion from '@/components/LigneCompteGestion.vue'
export default {
  name: 'CompteGestion',
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
    LigneCompteGestion
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
      compteGestionList: []
    }
  },
  methods: {
    // methods here
    getCompteGestionData () {
      // Ajoute dns les donnees de l'appel ajax
      const formData = new FormData()
      formData.append('type', 'detailsGestion')
      formData.append('clientId', this.idClient)
      formData.append('serviceId', this.idService)
      // Appel ajax du script de lecture des clients de la BDD en POST
      fetch(this.dataStore.baseUrl + 'readDB.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        // Si réponse positive à la promesse, on crée dynamiquement un tableau
        .then(response => {
          if (response.status === 200) {
            this.compteGestionList = response.data
          } else {
            console.error('ERREUR : \n' + response)
          }
        })
        .catch(error => console.error(error))
    }
  },
  mounted () {
    // mounted here
    this.getCompteGestionData()
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
