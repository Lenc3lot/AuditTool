<template>
  <main>
    <h1>Outils recherche</h1>
    <div id="barreRecherche">
        <button class="btn-search"><img src="../assets/image.png"></button>
        <input type="text" class="input-search" placeholder="Rechercher ..." @input="searchItem($event)">
        <button class="btn-search">&#8645;</button>
        <select @change="changeSortMethod($event)">
          <option selected hidden>Trier par...</option>
          <option value='NomClient'> Client </option>
          <option value='NomSrvc'> Fournisseur</option>
        </select>
        <button class="rechercheAvancee" @click="this.advSearchDisp = !this.advSearchDisp">Recherche avancée</button>
    </div>
    <Transition name="slide-fade">
      <form v-show="advSearchDisp" id="advSearchDisp" name="advSearchDisp" @submit="getFormData($event)">
        <h2>Recherche avancée</h2>
        <button class="btn-search"><img src="../assets/imageSrch.png"></button>
        <!-- NB : AJOUTER LES DIFFERENTES OPTIONS DE RECHERCHE AVANCEE -->
        <select>
          <option selected hidden>Rechercher par...</option>
          <option value="typeAcces.3" >Type d'accès</option>
          <option value="offre.3" >Offre</option>
          <option value="equipementAuth.3" >Equipement d'authentification</option>
        </select>
        <input style="width: 30%" type="text" placeholder="Contient..." @input="showDiv($event)">
        <input type="submit" value="Rechercher">
      </form>
    </Transition>
    <Transition name="slide-fade">
      <section v-show="!display" id="sectionRecherche">
            <div id="rechercheDiv">
              <label>Afficher page :</label>
              <select name="pagination" id="pagination" @change="changePage($event)">
                <option v-for="i in nbPages" :key="i">{{ i }}</option>
              </select>
              <h2 id="errorMsg">{{ errorMsg }}</h2>
              <table>
                <tr>
                  <th scope="col">Client</th>
                  <th scope="col">Fournisseur</th>
                  <th scope="col">Type de service</th>
                  <th scope="col" v-if="searchedDataAdv">{{ searchedDataAdvValue }}</th>
                  <th scope="col"> </th>
                </tr>
                <LigneRecherche @selectedSearch="sendToFiche($event)" v-for="info in selectedData" :key="info.serviceID" :info="info"/>
              </table>
            </div>
      </section>
    </Transition>
    <Transition name="slide-fade">
      <section v-show="display" id="sectionRecherchePrecise">
            <div id="rechercheDiv">
              <table>
                <tr>
                  <th scope="col">Client</th>
                  <th scope="col">Fournisseur</th>
                  <th scope="col">Type de service</th>
                  <th scope="col" v-if="searchedDataAdv">{{ searchedDataAdvValue }}</th>
                  <th scope="col"> </th>
                </tr>
                <LigneRecherche @selectedSearch="sendToFiche($event)" v-for="info in sortedData" :key="info.serviceID" :info="info"/>
              </table>
              <section  v-if="searchedDataAdv"><LigneRechercheSpe @selectedSearch="sendToFiche($event)" v-for="src in advancedSelectionData" :key="src.serviceID" :src="src"/></section>
            </div>
          </section>
    </Transition>
  </main>
</template>
<script>
import store from '@/store'
import LigneRecherche from '@/components/LigneRecherche.vue'
import LigneRechercheSpe from '@/components/LigneRechercheSpe.vue'
export default {
  name: 'RechercheView',
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
    LigneRecherche,
    LigneRechercheSpe
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
      display: false,
      allData: [],
      advancedSelectionData: [],
      selectedData: [],
      sortedData: [],
      perPage: 10,
      currentPage: 1,
      nbLignes: 0,
      nbPages: 0,
      sortByMethod: 'NomClient',
      advSearch: '',
      advSearchDisp: false,
      errorMsg: '',
      searchedDataAdv: false,
      searchedDataAdvValue: ''
    }
  },
  methods: {
    // methods here
    /**
     * Summary : Récupère l'ensemble des données de tout les clients
     */
    getAllData () {
      const body = new FormData()
      body.append('action', 'getAllData')
      body.append('req', 'recherche')
      body.append('sortBy', this.sortByMethod)
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
          this.allData = response.data
          this.nbLignes = this.allData.length
          this.nbPages = Math.ceil(this.nbLignes / this.perPage)
          console.log(this.nbPages)
          for (let i = (this.currentPage * 10) - 10; i < this.currentPage * 10; i++) {
            if (this.allData[i] !== undefined) {
              this.selectedData.push(this.allData[i])
            }
          }
        })
        .catch(error => console.error(error))
    },
    /**
     * Summary : Permet de changer l'affichage de la page en cours.
     * @param {*} event | Numéro de page sélectionné
     */
    changePage (event) {
      this.selectedData = []
      this.currentPage = event.target.value
      console.log(this.currentPage)
      this.getAllData()
    },
    /**
     * Summary : Change le type de tri des données
     * @param {*} event | Type de tri sélectionné
     */
    changeSortMethod (event) {
      this.selectedData = []
      this.sortByMethod = event.target.value
      this.getAllData()
    },
    /**
     * Summary : Permet d'effectuer une recherche parmis les données nom,fournisseur et type de service. Affiche dynamiquement le résultat.
     * @param {String} event | Mot clé recherché
     */
    searchItem (event) {
      // eslint-disable-next-line
      const regexp = new RegExp("^(\\w*|\\W*|.*)(" + event.target.value.toLowerCase() + ")(\\w*|\\W*|.*)$", 'g')
      this.sortedData = []
      let test = false
      this.allData.forEach(element => {
        if (element.NomSrvc.toLowerCase().match(regexp) || element.NomClient.toLowerCase().match(regexp) || element.typeService.toLowerCase().match(regexp)) {
          this.sortedData.push(element)
          test = true
          console.log(test)
        } else {
          test = false
        }
      })
      // eslint-disable-next-line
      console.log(event.target.value)
      if (event.target.value === '') {
        this.sortedData = []
        this.display = false
      } else {
        this.display = true
        if (this.sortedData.length === 0) {
          this.display = false
          this.errorMsg = 'Rien ne semble correspondre à votre recherche'
        } else {
          this.errorMsg = ''
        }
      }
    },
    /**
     * Summary : Envoi sur la page du service sélectionné.
     * @param {event} e | Event contenant les informations du service sélectionné.
     */
    sendToFiche (e) {
      // eslint-disable-next-line
      for (const [key, value] of Object.entries(localStorage)) {
        if (key !== 'token') {
          localStorage.removeItem(key)
        }
      }
      localStorage.searchClientID = e.clientID
      localStorage.searchServiceID = e.serviceID
      localStorage.theresASearch = true
      this.$router.push('/clients/' + e.clientID + '/services')
    },
    /**
     * Summary : Affiche la catégorie de recherche avancée.
     */
    affichAvance () {
      this.$swal({
        title: 'Recherche Avancée',
        input: 'select',
        inputOptions: {
          acces: "Type d'accès",
          offre: 'Offre',
          epmntAuth: "Equipement d'authentification"
        },
        inputPlaceholder: 'Rechercher par...',
        inputValidator: (value) => {
          return new Promise((resolve) => {
            this.advSearch = value
            console.log(this.advSearch)
            resolve()
          })
        }
      })
    },
    getFormData (e) {
      const infoSearch = e.target[1].value
      const champBD = infoSearch.split('.')
      console.log(champBD)
      const body = new FormData()
      body.append('champ', champBD[0])
      body.append('auto_ts', champBD[1])
      body.append('value', e.target[2].value)
      body.append('action', 'advSearch')
      body.append('req', 'recherche')
      console.log(body)
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
          this.display = !this.display
          this.searchedDataAdv = true
          this.searchedDataAdvValue = champBD[0]
          this.advancedSelectionData = response.data
          console.log(this.advancedSelectionData)
        })
        .catch(error => {
          console.log(error)
        })
    },
    showDiv (e) {
      console.log(e.target.value)
      if (!e.target.value) {
        this.display = false
        this.searchedDataAdv = false
        this.searchedDataAdvValue = ''
      }
    }
  },
  mounted () {
    // mounted here
    this.getAllData()
    // console.log(this.allData)
  },
  created () {
    // created here
    // console.log(this.allData)
  }
}
</script>

<style scoped>
/* Style here */

#barreRecherche{
    display: flex;
    justify-content: center;
}
.btn-search{
    border-right: 0px;
    border-top: solid 1px;
    border-bottom: solid 1px;
    border-left: solid 1px;
    border-bottom-left-radius: 10px;
    border-top-left-radius: 10px;
    width: 5%;
}
.btn-search>img{
    padding: 0px;
    margin: 0px;
}

.input-search{
    border-top: solid 1px;
    border-bottom: solid 1px;
    border-right: solid 1px;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    border-left: 0px;
    padding: 1%;
    width: 30%;
    margin-right: 1%;
    color: black;
    background-color: lightgray;
}
select{
    border-radius: 10px;
    margin-right: 1%;
    border-radius: 0px;
    border-right: solid 1px;
    border-top: solid 1px;
    border-bottom: solid 1px;
    border-bottom-right-radius: 10px;
    border-top-right-radius: 10px;
    width: 30%;
    padding: 1%;
    background-color: lightgray;
}
.rechercheAvancee{
    border: solid 1px;
    border-radius: 10px;
    padding: 1%;
}
.slide-fade-enter-active {
  transition: all 0s ease-out;
}

.slide-fade-leave-active {
  transition: all 0s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-200px);
  opacity: 0;
}

#sectionRecherche{
  margin-top: 1%;
  border: solid 1px;
  width: 100%;
  height: 100%;
}

#sectionRecherchePrecise{
  margin-top: 1%;
  border: solid 1px;
  width: 100%;
  height: 100%;
}

#rechercheDiv{
  display: flex;
  flex-direction: row;
  justify-content: center;
  flex-wrap: wrap;
  background-color: lightgray;
  width: 100%;
  height: 100%;
  align-items: center;
}

#rechercheDiv>*{
  margin: 1%;
}

#rechercheDiv>input{
  flex: 1 1 40%;
  height: 20%;
  width: 1%;
  padding: 1%;
  margin-left: 0px;
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

#pagination{
  background-color: white;
  width: 5%;
  /* text-align: center; */
  border-radius: 10px;
  padding: 1em;
  margin: 0;
}

#advSearchDisp>h2{
  flex: 1 1 100%;
}

#advSearchDisp{
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  border: solid 1px;
  margin: 1%;
  padding: 1%;
}

#advSearchDisp>button{
  padding: 1%;
  /* margin: 1%; */
}

#errorMsg{
  flex:1 1 100%
}
</style>
