<template>
  <tr>
    <td>{{ service.serviceId }}</td>
    <td>{{ service.serviceName }}</td>
    <td>{{ service.address }}</td>
    <td>{{ service.serviceDescription }}</td>
    <td>{{ service.typeServiceName }}</td>
    <td>{{ service.version }}</td>
    <td><button @click="goToUser(service.serviceName)">Utilisateurs</button> <button @click="getLicenceData(service.serviceId, this.idClient)">Infos licence</button> <button @click="$router.push(this.$route.fullPath + '/' + service.serviceId + '/cptgestion')">Comptes gestion</button></td>
  </tr>
</template>

<script>
import store from '@/store'
export default {
  name: 'LigneService',
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
    service: Object
  },
  watch: {
    // variables to watch here
  },
  data () {
    return {
      // variables here
      dataStore: store,
      infoLicence: [],
      idClient: this.$route.params.id
    }
  },
  methods: {
    // methods here
    getLicenceData (idService, idClient) {
      console.log(idService)
      console.log(idClient)
      const formData = new FormData()
      formData.append('type', 'detailsLicence')
      formData.append('clientId', idClient)
      formData.append('serviceId', idService)
      // Appel ajax du script de lecture des clients de la BDD en POST
      fetch(this.dataStore.baseUrl + 'readDB.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          if (response.status === 200) {
            this.licenceList = response.data
            const myHTML = `
              <li> Id licence : ` + this.licenceList[0].licenceId + `</li>\n
              <li> Type :` + this.licenceList[0].type + ` </li>\n
              <li> Clé licence :` + this.licenceList[0].cleLicence + ` </li>\n
              <li> Date d'achat :` + this.licenceList[0].buyDate + ` </li>\n
              <li> Date expiration :` + this.licenceList[0].expirationDate + ` </li>\n
              `
            console.log(this.licenceList[0])
            this.$swal({
              icon: 'info',
              title: 'Info Licence : ' + this.service.serviceName,
              html: myHTML,
              confirmButtonText: 'Fermer'
            })
          } else {
            console.error('ERREUR : ' + response)
          }
        })
        .catch(error => console.error(error))
    },
    goToUser (nomService) {
      this.dataStore.dataClient.nomService = nomService
      console.log(this.dataStore.dataClient.nomService)
      this.$router.push(this.$route.fullPath + '/' + this.service.serviceId + '/users')
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
  border: solid 1px;
}
tr{
  border: solid 1px;
}
th{
  border: solid 1px;
}

</style>
