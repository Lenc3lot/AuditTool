<template>
  <main>
    <div v-if="nbServices > 0">
      <h1>{{ dataStore.dataClient.nomClient }}</h1>
      <h2>Services</h2>
      <!-- <button @click="$router.push($route.fullPath + '/audit')"> Ajouter un service</button> ‎ -->
      <!-- <select v-model="valueOption">
        <option hidden value='' selected>Rechercher par type</option>
        <option value=''>Tous</option>
        <TypeOptions/>
      </select> -->
      <!-- <section id="sectionService">
          <table id="tableService">
              <tr>
                  <th>Id Service</th>
                  <th>Nom service</th>
                  <th>Adresse</th>
                  <th>Description</th>
                  <th>Type Service</th>
                  <th>Version</th>
                  <th>Plus d'infos</th>
              </tr>
              <LigneService v-for="service in filteredData" :key="service.serviceId" :service="service"/>
          </table>
        --> <AuditView/>
      <!-- </section> -->
    </div>
    <div v-else>
      <button @click="$router.push($route.fullPath + '/audit')">Démarrer l'audit</button>
    </div>
  </main>
</template>

<script>
import store from '@/store'
// import LigneService from '@/components/LigneService.vue'
// import TypeOptions from '@/components/TypeOptions.vue'
import AuditView from './AuditView.vue'
export default {
  name: 'ServiceView',
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
    // LigneService,
    // TypeOptions,
    AuditView
  },
  props: {
    // props here
  },
  watch: {
    // variables to watch here
    // valueOption (newVal) {
    //   // const returnTab = []
    //   this.filteredData = this.fullData.filter(elem => {
    //     if (newVal !== '') {
    //       return elem.typeServiceName === newVal
    //     } else {
    //       return true
    //     }
    //   })
    //   if (this.filteredData.length === 0) {
    //     console.error('No result')
    //     this.$swal({
    //       toast: true,
    //       title: 'Oh ! Une erreur est survenue.',
    //       text: 'Il semblerait qu\'aucun service ne corresponde au type sélectionné !',
    //       confirmButtonText: 'Fermer',
    //       icon: 'info',
    //       position: 'top-end',
    //       timer: 5000,
    //       timerProgressBar: true
    //     })
    //   }
    // }
  },
  data () {
    return {
      // variables here
      fullData: [],
      filteredData: [],
      idClient: this.$route.params.id,
      dataStore: store,
      valueOption: '',
      licenceList: [],
      testBool: true,
      nbServices: 1
    }
  },
  methods: {
    // methods here
    /**
     * Summary : Récupère la totalité des données liées aux services du client choisi
     */
    // getFullData () {
    //   // Ajoute dns les donnees de l'appel ajax que le type de données sélectionnée est 'clients'
    //   const formData = new FormData()
    //   formData.append('type', 'detailsServices')
    //   formData.append('clientId', this.idClient)
    //   // Appel ajax du script de lecture des clients de la BDD en POST
    //   fetch(this.dataStore.baseUrl, {
    //     method: 'POST',
    //     body: formData
    //   })
    //     .then(response => response.json())
    //     .then(response => {
    //       if (response.status === 200) {
    //         this.fullData = response.data
    //         this.filteredData = response.data
    //         this.nbServices = response.nbServices
    //       } else {
    //         console.error('ERREUR :' + response)
    //       }
    //     })
    //     .catch(error => console.error(error))
    // }
  },
  mounted () {
    // this.getFullData()
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
#tableService{
    border: solid 1px;
    width: 100%;
    margin-top: 1%;
}
th{
    border: solid 1px;
    /* padding: 10px; */
}
#sectionService{
    width: 100%;
}
</style>
