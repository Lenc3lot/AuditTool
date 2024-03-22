<template>
  <main>
    <div style="border: solid 1px; margin-top: 1%;">
      <h2>Ajouter un service</h2>
    </div>
    <section name="deroulant" id="deroulant">
      <button style="width: 15%; padding: 1%; margin: 2%;" @click="$router.push('/clients/'+this.idClient)">Retour</button>
      <div class="btnDeroulant" @click="show = !show">
        <p>Accès Internet &#8595;</p>
      </div>
      <Transition name="slide-fade">
        <section v-show="show">
          <div class="accesInternetSection">
            <h1>Accès Internet de {{ dataStore.dataClient.nomClient }}</h1>
            <div class="mainDiv">
              <p @click="value2 = false, value1 = true, fontWeight1 = 'bold', fontWeight2 = 'normal', textDecoration1 = 'underline', textDecoration2 = 'none'"
                v-bind:style="{ fontWeight: fontWeight1, textDecoration: textDecoration1 }">Ajouter un service Internet
              </p>
              <p @click="value2 = true, value1 = false, fontWeight1 = 'normal', fontWeight2 = 'bold', textDecoration1 = 'none', textDecoration2 = 'underline'"
                v-bind:style="{ fontWeight: fontWeight2, textDecoration: textDecoration2 }">Consulter les accès internet
              </p>
              <Transition name="testSlide">
                <div class="Service" v-show="value1">
                  <h1>SERVICE</h1>
                  <form>
                    <!-- Type de lien -->
                    <label>Type de lien</label>
                    <select required @change=" getTypeLien($event)">
                      <option hidden>TYPE DE LIEN</option>
                      <option>Lien principal du site</option>
                      <option>Lien supplémentaire (agréga ou backup)</option>
                      <option>Service OTB</option>
                    </select>
                    <!-- Souscription SNS -->
                    <label for="isSNSSub">Souscris chez SNS <input type="checkbox" id='isSNSSub'
                        @change="getSNSSub($event)"></label>
                    <!-- Selection FOURNISSEUR -->
                    <!-- Fournisseur SI SNSSUB = true -->
                    <label>Fournisseur</label>
                    <select required v-if="dataAccesInternet.isSNSSub" @change="setFrsSelected($event)">
                      <option hidden>FOURNISSEUR</option>
                      <option v-for="item in frsSNS" :value="item" :key="item">{{ item }}</option>
                      <option>AUTRE</option>
                    </select>
                    <!-- Fournisseur SI !SNSSUB -->
                    <select required v-else @change="setFrsSelected($event)">
                      <option hidden>FOURNISSEUR</option>
                      <option v-for="item in frs" :value="item" :key="item">{{ item }}</option>
                      <option>AUTRE</option>
                    </select>
                    <!-- Opérateur (SI SOUSCRIS SNS) -->
                    <label v-if="dataAccesInternet.isSNSSub">Opérateur</label>
                    <select required v-if="dataAccesInternet.isSNSSub" @change="setOperateurSelected($event)">
                      <option hidden>OPERATEUR</option>
                      <option v-for="item in frs" :value="item" :key="item">{{ item }}</option>
                    </select>
                    <!-- TYPE D'OFFRE (si pas souscris SNS) -->
                    <label v-if="!dataAccesInternet.isSNSSub">Type d'offre</label>
                    <select required v-if="!dataAccesInternet.isSNSSub" @change="setTypeOffre($event)">
                      <option hidden>TYPE D'OFFRE</option>
                      <option>Grand Public</option>
                      <option>Professionnel</option>
                    </select>
                    <!-- OFFRE (si SNS Souscris) -->
                    <label v-if="dataAccesInternet.isSNSSub">Offre</label>
                    <input placeholder="Offre" required v-if="dataAccesInternet.isSNSSub" @change="getOffre($event)">
                    <!-- TYPE D'ACCES (commun) -->
                    <label>Type d'accès</label>
                    <select required @change="setTypeAcces($event)">
                      <option hidden>TYPE D'ACCES</option>
                      <option v-for="item in typeAcces" :value="item" :key="item">{{ item }}</option>
                    </select>
                    <!-- REFERENCE FOURNISSEUR DU LIEN -->
                    <label>Référence fournisseur du lien</label>
                    <input @change="getRefFrsLien($event)" v-if="dataAccesInternet.frsSelected != 'UNYC'" type="text"
                      placeholder="Référence fournisseur du lien">
                    <input @change="getRefFrsLien($event)" v-else-if="dataAccesInternet.typeAccesSelected != '4G'"
                      placeholder='IP-XXXXXX-XXXXXX'>
                    <input @change="getRefFrsLien($event)" v-else type="number" placeholder="Numéro">
                    <!-- N° Support-->
                    <label>N° Suppport</label>
                    <input @change="getNumSupport($event)" type="text" maxlength="10"
                      v-if="dataAccesInternet.isSNSSub && dataAccesInternet.frsSelected != 'STARLINK' && dataAccesInternet.typeAccesSelected != '4G'"
                      placeholder='N°SUPPORT' pattern="/^[0-9]{10}/gm">
                    <input @change="getNumSupport($event)" type="text" maxlength="10"
                      v-else-if="!dataAccesInternet.isSNSSub" placeholder='N°SUPPORT' pattern="/^[0-9]{10}/gm">
                    <input @change="getNumSupport($event)" type="text" v-else placeholder='N°SUPPORT' disabled>
                    <!-- GTR (commun)-->
                    <label for="GTR"> GTR <input type="checkbox" id="GTR" @change="getGTR($event)"></label>
                    <!-- Saisie GTR si OUI -->
                    <input @change="getGTRTexte($event)" type="text" placeholder="Saisie GTR"
                      v-if="dataAccesInternet.isGTR">
                    <!-- IP FIXE (commun) -->
                    <label for="ipFixe"> IP Fixe <input type="checkbox" id="ipFixe" @change="getIsIPFixe($event)">
                    </label>
                    <!--Saisie IP si fixe-->
                    <input @change="getIPFixe($event)" type="text" placeholder="IP FIXE : xxx.xxx.xxx.xxx" minlength="7"
                      maxlength="15" size="15" v-if="dataAccesInternet.isIPFixe"
                      pattern="/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/">
                    <!-- TYPE D'AUTHENTIFICATION DU LIEN (Commun)-->
                    <label>Type d'authentification du lien</label>
                    <select required @change="setAuthLien($event)">
                      <option hidden>TYPE D'AUTHENTIFICATION DU LIEN</option>
                      <option>PPOE</option>
                      <option>IP</option>
                      <option>DHCP</option>
                      <option>Modem Opérateur</option>
                      <option>APN</option>
                    </select>
                    <!-- Info d'authentification cdt isSNSSub-->
                    <label>Informations d'authentification</label>
                    <input @change="getInfoAuth($event)" type="text" placeholder="Login PPOE" value="Login : "
                      v-if="dataAccesInternet.authLien == 'PPOE' && dataAccesInternet.isSNSSub">
                    <input @change="getInfoAuth($event)" type="text" placeholder="Password PPOE" value=" Password : "
                      v-if="dataAccesInternet.authLien == 'PPOE' && dataAccesInternet.isSNSSub">
                    <input @change="getInfoAuth($event)" type="text" placeholder="IP : xxx.xxx.xxx.xxx" value=" IP : "
                      v-if="dataAccesInternet.authLien == 'IP' && dataAccesInternet.isSNSSub">
                    <input @change="getInfoAuth($event)" type="text" placeholder="Info auth" value=" Infos auth : "
                      disabled
                      v-if="(dataAccesInternet.authLien == 'APN' || dataAccesInternet.authLien == 'Modem Opérateur') && dataAccesInternet.isSNSSub">
                    <!-- Info d'authentification cdt !isSNSSub-->
                    <input @change="getInfoAuth($event)" type="text" placeholder="Info auth" value=" Infos auth : "
                      v-if="!dataAccesInternet.isSNSSub">
                    <!--DATE SOUSCRIPTION (commun)-->
                    <label>Date de souscription</label>
                    <input @change="getDateSouscription($event)" type="text" placeholder="Date de souscription"
                      @focus="(this.type = 'date')" @blur="(this.type = 'text')">
                    <!-- EQUIPEMENT D'ARRIVEE (commun) -->
                    <label>Equipement d'arrivée</label>
                    <select @change="setEquipementArrive($event)">
                      <option hidden>EQUIPEMENT D'ARRIVEE (DTI)</option>
                      <option>ONT</option>
                      <option>Coaxial</option>
                      <option>SIM</option>
                    </select>
                    <input @change="setSIMArrive($event)" type="text" v-if="dataAccesInternet.equipementArrive == 'SIM'"
                      placeholder="Numéro de tel" value="Tel : ">
                    <input @change="setSIMArrive($event)" type="text" v-if="dataAccesInternet.equipementArrive == 'SIM'"
                      placeholder="ICCID SIM" value="ICCID SIM : ">
                    <input @change="setSIMArrive($event)" type="text" v-if="dataAccesInternet.equipementArrive == 'SIM'"
                      placeholder="PIN" value="PIN">
                    <input @change="setSIMArrive($event)" type="text" v-if="dataAccesInternet.equipementArrive == 'SIM'"
                      placeholder="PUK" value="PUK">
                    <!-- LOCALISATION (commun)-->
                    <label>Localisation</label>
                    <input @change="getLocalisation($event)" type="text" placeholder="Localisation">
                    <!-- EQUIPEMENT D'AUTHENTIFICATION (commun)-->
                    <label>Equipement d'authentification</label>
                    <select required @change="getEquipementAuth($event)">
                      <option hidden>EQUIPEMENT D'AUTHETIFICATION</option>
                      <option>Modem Opérateur</option>
                      <option>Routeur SNS</option>
                      <option>Authetification sur Firewall</option>
                    </select>
                    <!-- ASCENDANT RESEAU (commun) -->
                    <label>Ascendant Réseau</label>
                    <select required @change="getAscendantRsx($event)">
                      <option hidden>ASCENDANT RESEAU</option>
                      <option>Routeur</option>
                      <option>Firewall</option>
                      <option>OTB</option>
                      <option>SWITCH</option>
                    </select>
                  </form>
                  <button @click="sendData()">AJOUTER</button>
                </div>
              </Transition>
              <!--  -->
              <!-- CONSULTATION DES ACCES INTERNET -->
              <!--  -->
              <Transition name="testSlide">
                <div class="Utilisateurs" v-show="value2">
                  <h1>Liste des accès internet</h1>
                  <table id="tableAccesInternet">
                    <tr>
                      <th>ID</th>
                      <th>Type de lien</th>
                      <th>Souscris à SNS</th>
                      <th>Fournisseur</th>
                      <th>Plus</th>
                    </tr>
                    <LigneServiceAccesIntrnt @recupFullData="getAccesInternetData(serviceInternet.auto_s)"
                      v-for="serviceInternet in listeAccesInternet" :key="serviceInternet.auto_s"
                      :highlight="selectedID == serviceInternet.auto_s" :serviceInternet="serviceInternet" />
                  </table>
                  <div v-show="selectedID !== ''" ref="focusDiv">
                    <section>
                      <section v-for="(value, name) in dataThisAccesInternet" v-bind:key="name">
                        <span>
                          {{ name }} :
                          <input @change="addModif($event, name, selectedID)" type='text' :value="value"
                            :disabled="!editMode" v-if="value && name !== 'Souscris SNS' && name !== 'ID'" />
                          <span v-if="name === 'ID'">{{ value }}</span>
                          <span v-if="name === 'Souscris SNS' && value">&#10004;</span>
                          <span
                            v-if="(name === 'Souscris SNS' || name === 'GTR' || name === 'IP Fixe' || name === 'Numéro support') && !value">&#10006;</span>
                        </span>
                      </section>
                    </section>
                    <button @click="editAcces()" v-if="!editMode"> &#9998; Editer</button>
                    <button @click="storeToArchive()" v-if="!editMode"> &#9851; Supprimer </button>
                    <button v-if="editMode" style="background-color: limegreen; color: white"
                      @click="validateEdit()">&#10004; Valider </button>
                    <button v-if="editMode" style="background-color: red; color: white" @click="cancelEdit()">&#10006;
                      Annuler </button>
                  </div>
                </div>
              </Transition>
            </div>
          </div>
        </section>
      </Transition>
      <div class="btnDeroulant" @click="showContact = !showContact">
        <p>Contacts &#8595;</p>
      </div>
      <Transition name="slide-fade">
        <section v-show="showContact">
          <div class="accesInternetSection">
            <h1>Contacts de {{ dataStore.dataClient.nomClient }}</h1>
          </div>
        </section>
      </Transition>
      <div class="btnDeroulant" @click="showArchive = !showArchive">
        <p>Archive &#8595;</p>
      </div>
      <Transition name="slide-fade">
        <section v-show="showArchive">
          <div class="accesInternetSection">
            <h1>Archives de {{ dataStore.dataClient.nomClient }}</h1>
            <table id="tableAccesInternet">
              <tr>
                <th>ID</th>
                <th>Type de lien</th>
                <th>Souscris à SNS</th>
                <th>Fournisseur</th>
                <th>Plus</th>
              </tr>
              <LigneArchive @restoreData="restoreFromArchive(archiveInternet.auto_s)"
                v-for="archiveInternet in listeArchiveInternet" :key="archiveInternet.auto_s"
                :highlight="selectedID == archiveInternet.auto_s" :archiveInternet="archiveInternet" />
            </table>
          </div>
        </section>
      </Transition>
    </section>
  </main>
</template>

<script>
/* eslint-disable */
import store from '@/store'
import LigneServiceAccesIntrnt from '@/components/LigneServiceAccesIntrnt.vue'
import LigneArchive from '@/components/LigneArchive.vue'
export default {
  name: 'AuditView',
  head() {
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
    LigneServiceAccesIntrnt,
    LigneArchive
  },
  props: {
    // props here
  },
  watch: {
    // variables to watch here
  },
  data() {
    return {
      // variables here
      dataStore: store,
      value1: false,
      value2: true,
      fontWeight1: 'normal',
      fontWeight2: 'bold',
      textDecoration1: 'none',
      textDecoration2: 'underline',
      show: false,
      showContact: false,
      showArchive: false,
      frsSNS: ['UNYC', 'SEWAN', 'OVH', 'STARLINK'],
      frs: ['ORANGE', 'SFR', 'BOUYGUES', 'FREE', 'STARLINK'],
      typeAcces: ['ADSL', 'VDSL', 'SDSL', 'Fibre mutalisée (coaxial)', 'FFTH', 'FFTO', '4G', 'Satellite'],
      dataAccesInternet: {
        typeLien: '',
        isSNSSub: '',
        frsSelected: '',
        typeOffre: '',
        numSupport: '',
        offre: '',
        refFournisseurLien: '',
        isIPFixe: '',
        IPFixe: '',
        isGTR: '',
        gtrTexte: '',
        infoAuth: '',
        dateSouscription: '',
        localisation: '',
        equipementAuth: '',
        operateurSelected: '',
        typeAccesSelected: '',
        authLien: '',
        equipementArrive: '',
        simArrive: '',
        ascendantRsx: '',
        idClient: ''
      },
      listeAccesInternet: [],
      listeArchiveInternet: [],
      dataThisAccesInternet: [],
      nomClient: '',
      selectedID: '',
      editMode: false,
      editedData: {},
      dataNameTab: {
        'Type de lien': 'typeLien',
        'Fournisseur': 'fournisseur',
        'Type offre': 'typeOffre',
        'Type accès': 'typeAcces',
        'Offre': 'offre',
        'Référence fournisseur Lien': 'refFournisseurLien',
        'Numéro support': 'numSupport',
        'GTR': 'gtrTexte',
        'IP Fixe': 'ipFixeNum',
        'Type authentification lien': 'typeAuthLien',
        'Info authentification': 'infoAuth',
        'Date souscription': 'dateSouscription',
        'Equipement d arrivee': 'equipementArrivee',
        'Equipement authentification': 'equipementAuth',
        'Ascendant Reseau': 'ascendantRsx',
        'Localisation': 'localisation'
      }
    }
  },
  methods: {
    tester() {
      console.log('coucou')
    },
    getAscendantRsx(event) {
      this.dataAccesInternet.ascendantRsx = event.target.value
    },
    getEquipementAuth(event) {
      this.dataAccesInternet.equipementAuth = event.target.value
    },
    getLocalisation(event) {
      this.dataAccesInternet.localisation = event.target.value
    },
    getDateSouscription(event) {
      this.dataAccesInternet.dateSouscription = event.target.value
    },
    getInfoAuth(event) {
      this.dataAccesInternet.infoAuth += ' ' + event.target.value
    },
    getIPFixe(event) {
      this.dataAccesInternet.IPFixe = event.target.value
    },
    getGTRTexte(event) {
      this.dataAccesInternet.gtrTexte = event.target.value
    },
    getNumSupport(event) {
      this.dataAccesInternet.numSupport = event.target.value
    },
    getRefFrsLien(event) {
      this.dataAccesInternet.refFournisseurLien = event.target.value
    },
    getOffre(event) {
      this.dataAccesInternet.offre = event.target.value
    },
    getTypeLien(event) {
      this.dataAccesInternet.typeLien = event.target.value
    },
    // methods here
    getSNSSub(event) {
      this.dataAccesInternet.isSNSSub = event.target.checked
    },
    setTypeOffre(event) {
      this.dataAccesInternet.typeOffre = event.target.value
    },
    getIsIPFixe(event) {
      this.dataAccesInternet.isIPFixe = event.target.checked
    },
    getGTR(event) {
      console.log(event.target.checked)
      this.dataAccesInternet.isGTR = event.target.checked
    },
    setFrsSelected(event) {
      this.dataAccesInternet.frsSelected = event.target.value
      console.log(this.dataAccesInternet.frsSelected)
    },
    setTypeAcces(event) {
      this.dataAccesInternet.typeAccesSelected = event.target.value
    },
    setAuthLien(event) {
      this.dataAccesInternet.authLien = event.target.value
    },
    setEquipementArrive(event) {
      this.dataAccesInternet.equipementArrive = event.target.value
      console.log(this.dataAccesInternet.equipementArrive)
    },
    setSIMArrive(event) {
      this.dataAccesInternet.simArrive += event.target.value + ' '
    },
    setOperateurSelected(event) {
      this.dataAccesInternet.operateurSelected = event.target.value
    },
    /**
     * Summary : Envoie les données rentrées dans le formulaire d'ajout en base de données.
     * @returns none
     */
    sendData() {
      // const body = this.$genFD()
      const formData = new FormData()
      for (const [key, value] of Object.entries(this.dataAccesInternet)) {
        console.log(key + ':' + value)
        formData.append(key, value)
      }
      formData.append('idClient', this.idClient)
      formData.append('req','serviceInfo')
      formData.append('action','postData')
      console.log(formData)
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
          location.reload()
        })
        .catch(error => {
          console.log('plop')
          console.error(error)
        })
    },
    /**
     * Summary : Permet d'obtenir et de set les infos minimales des services internet du client en consultation
     * @returns none
     */
    getAccesInternet() {
      const formData = new FormData()
      formData.append('idClient', this.idClient)
      formData.append('action', 'getAccesInternet')
      formData.append('req','serviceInfo')
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
          this.listeAccesInternet = response.data
        })
    },
    /**
     * Summary : Permet d'obtenir et de set le nom du client en cours de consultation.
     */
    getNom() {
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
    },
    /**
     * Summary : Permet de récupérer l'intégralité des infos d'un accès internet d'un client.
     * @param {*} idService | ID du service à récupérer
     * @param {*} idClient | ID du client en consultation
     */
    getAccesInternetData(idService, keepId = false) {
      this.$nextTick(() => {
        console.log(this.$refs.focusDiv)
        this.$refs.focusDiv.focus();
      })  
      if (this.selectedID == idService && !keepId) {
        this.selectedID = ''
        return
      }
      if (this.selectedID !== idService && this.editMode) {
        this.$swal({
          icon: 'error',
          title: 'ATTENTION !',
          text: 'Enregistrez vos modifications avant de changer de service !'
        })
        idService = this.selectedID
      }
      this.selectedID = idService
      const body = new FormData()
      console.log(idService)
      body.append('idService', idService)
      body.append('idClient', this.idClient)
      body.append('action', 'getAccesInternetDetails')
      body.append('req','serviceInfo')
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          if (response.status === 200) {
            this.dataThisAccesInternet = response.data[0]
            // console.log(this.dataThisAccesInternet)
            this.sortData(this.dataThisAccesInternet)
          }
        })
        .catch(error => console.error(error))
    },
    /**
     * Summary : Retourne si la donnée est souscris chez SNS
     * @param {String} data | Référence la clé de souscription à SNS
     * @returns boolean
     */
    checkSNSSub(data) {
      if (data === 'OUI') {
        data = true
      } else {
        data = false
      }
      return data
    },
    /**
     * Summary : Filtre les données d'un array donné
     * @param {Array} dataArray | Reference de l'array de comp
     */
    sortData(dataArray) {
      let controlKey = ''
      let lastControlKey = ''
      let valueControlKey = ''
      for (const [key, value] of Object.entries(dataArray)) {
        controlKey = key.split('_')
        if (controlKey[1] === 'verif' && controlKey !== undefined) {
          lastControlKey = controlKey[0]
          if (value === '0') {
            valueControlKey = value
          }
          delete dataArray[key]
        } else {
          if (key === lastControlKey && valueControlKey === '0') {
            dataArray[key] = false
          }
          if (key === 'Souscris SNS') {
            dataArray[key] = this.checkSNSSub(value)
          }
          if(key === 'Numéro support' && value !== ''){
            dataArray[key] = false
          }
        }
      }
    },
    /**
     * Summary : Permet l'archivage du service en cours de consultation
     */
    storeToArchive() {
      this.$swal({
        title: "Voulez vous archiver le service ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Archiver"
      }).then((result) => {
        if (result.isConfirmed) {
          this.$swal({
            toast: true,
            position: 'top-right',
            title: "Archivé !",
            icon: 'success'
          })
          const body = new FormData()
          body.append('action', 'putStoreToArchive')
          body.append('req','service')
          body.append('idService', this.selectedID)
          console.log(body)
          fetch(this.dataStore.baseUrl, {
            method: 'POST',
            body: body
          })
            .then(response => response.json())
            .then(response => {
              if (response.status === 200) {
                console.log('plop')
                this.getAccesInternet()
                this.getArchiveInternet()
                this.selectedID = ''
              } else {
                console.log('plip')
              }
            })
            .catch(error => console.error(error))
        }
      })
    },
    /**
     * Summary : Permet de récupérer les services archivés du client en cours de consultation
     */
    getArchiveInternet() {
      const formData = new FormData()
      formData.append('idClient', this.idClient)
      formData.append('action', 'getArchiveInternet')
      formData.append('req','serviceInfo')
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
          this.listeArchiveInternet = response.data
        })
    },
    /**
     * Summary : Permet de repasser un service en utilisation et de le sortir de l'archivage
     * @param {int} idService | Id du service que l'on souhaite restaurer
     */
    restoreFromArchive(idService) {
      this.$swal({
        title: "Voulez vous restorez le service ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Restaurer"
      }).then((result) => {
        if (result.isConfirmed) {
          this.$swal({
            toast: true,
            position: 'top-right',
            title: "Restauré !",
            icon: 'success'
          })
          const body = new FormData()
          body.append('idService', idService)
          body.append('action', 'putRestoreFromArchive')
          body.append('req','service')
          fetch(this.dataStore.baseUrl, {
            method: 'POST',
            body: body
          })
            .then(response => response.json())
            .then(response => {
              if (response.status === 200) {
                console.log(response)
                this.getAccesInternet()
                this.getArchiveInternet()
              }
            })
            .catch(error => console.error(error))
        }
      })
    },
    /**
     * Summary : Permet de passer le service en cours en mode édition
     */
    editAcces() {
      const body = new FormData()
      let nomModif = ''
      let PnomModif = ''
      body.append('action','getIsInUse')
      body.append('req','service')
      body.append('idService',this.selectedID)
      fetch(this.dataStore.baseUrl,{
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          console.log(response.data[0])
          if(response.data[0].isInEdit === '1'){
            const formData = new FormData()
            formData.append('req','service')
            formData.append('action','getConsolutantModif')
            formData.append('idService',this.selectedID)
            fetch(this.dataStore.baseUrl,{
              method: 'POST',
              body: formData
            })
              .then(response => response.json())
              .then(response => {
                nomModif = response.data[0]['nomEditeur']
                PnomModif = response.data[0]['PnomEditeur']
                this.$swal({
                  title:'Attention !',
                  icon: 'error',
                  text: nomModif + ' ' + PnomModif +' est déjà en train de modifier cette fiche !'
                })
              })
          } else {
            const decodedToken = this.$decodeToken(localStorage.token)
            console.log(decodedToken[0]['NomConsultant'])
            this.editMode = true
            this.editedData['idService'] = this.selectedID
            const formDat = new FormData()
            formDat.append('action','putSetInUse')
            formDat.append('req','service')
            formDat.append('idService',this.selectedID)
            formDat.append('token', localStorage.token)
            fetch(this.dataStore.baseUrl, {
              method: 'POST',
              body: formDat 
            })
              .then(response => response.json())
              .then(response => {
                console.log(response)
              })
          }
        })
    },
    /**
     * Summary : Repasse à la valeur 0 le champ isInUse en BD
     */
    unsetIsInUse () {
      const body = new FormData()
      body.append('action','putUnsetIsInUse')
      body.append('req','service')
      body.append('idService',this.selectedID)
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          console.log(response)
        })
    },
    /**
     * Summary : Annule les modifications et désactive le mode édition
     */
    cancelEdit() {
      this.editMode = false
      this.editedData = {}
      this.unsetIsInUse()
    },
    /**
     * Summary : Modifie l'objet 'editedData' = stocke les modifications du service en cours d'édition
     * @param {String} event | Evènement de la modification, permet de récupérer la valeur de la modification
     * @param {String} name | Nom de la donnée modifiée
     * @param {Int} idService | ID du service modifié
     */
    addModif(event, name, idService) {
      if (this.editedData.idService === idService) {
        //Utilise la liste de correspondance pour mettre directement la valeur qui correspond en BD
        this.editedData[this.dataNameTab[name]] = event.target.value
      }
    },
    /**
     * Summary : Valide l'édition avec un popup de confirmation et envoie la modification en base de donnée
     */
    validateEdit() {
      // console.log(this.editedData)
      this.$swal({
        title: "Voulez vous modifier le service ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Modifier"
      }).then((result) => {
        if (result.isConfirmed) {
          this.$swal({
            toast: true,
            position: 'top-right',
            title: "Modifié !",
            icon: 'success'
          })
          const body = this.$genFD(this.editedData)
          console.log(body)
          body.append('action', 'putData')
          body.append('req', 'serviceInfo')
          fetch(this.dataStore.baseUrl, {
            method: 'POST',
            body: body
          })
            .then(response => response.json())
            .then(response => {
              if (response.status === 200) {
                console.log(response)
                this.getAccesInternetData(this.selectedID, true)
                this.editMode = false
                this.unsetIsInUse()
                this.getAccesInternet()
              }
            })
            .catch(error => console.error(error))
        }
      })
    },
    /**
     * Summary : Activée uniquement si recherche, affiche au chargement de la page les données du service sélectionné
     */
    goToSelectedSearch () {
      this.show = true
      this.getAccesInternetData (localStorage.searchServiceID)
    }
  },
  mounted() {
    // mounted here
    this.idClient = this.$route.params.id
    this.getAccesInternet()
    this.getArchiveInternet()
    this.getNom()
    if (localStorage.theresASearch) {
      console.log('UYFBvzufbbgfuzrbzuf')
      this.goToSelectedSearch ()
    }
    for (const [key, value] of Object.entries(localStorage)) {
        if (key !== 'token') {
          localStorage.removeItem(key)
        }
      }
  },
  created() {
    // created here
  }
}
</script>

<style scoped>
/* Style here */

main>div {
  margin-bottom: 1%;
}

#deroulant {
  padding-top: 1%;
  padding-left: 1%;
  padding-right: 1%;
  display: flex;
  flex-direction: column;
}

.btnDeroulant {
  display: flex;
  border: solid 1px;
  align-items: center;
  width: 20%;
  justify-content: flex-start;
  padding-left: 1%;
  margin-bottom: 1%;
}

.testSlide-enter-active {
  transition: all 0.3s ease-out;
}

.testSlide-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.testSlide-enter-from,
.testSlide-leave-to {
  transform: translateX(-200px);
  opacity: 0;
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateY(-200px);
  opacity: 0;
}

.mainDiv {
  height: 100%;
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
}

.mainDiv>div {
  width: 95%;
  border: solid 1px;
}

.accesInternetSection {
  display: flex;
  border: solid 1px;
  margin-bottom: 1%;
  flex-direction: column;
}

.Service {
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-content: center;
  margin-bottom: 1%;
  padding-bottom: 1%;
}

.mainDiv>p {
  flex: 1 1 50%;
}

p:hover {
  cursor: pointer;
  ;
}

.Service>form {
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  flex-direction: row;
  align-content: center;
  align-items: center;
}

.Service>form>input,
label,
select {
  flex: 1 1 100%;
  padding: 1%;
  margin: 0px 1% 0px 1%;
  width: 20%;
}

.Service>form>label {
  /* flex: 1 1 20%; */
  text-align: left;
  font-weight: bold;
}

.Service>button {
  width: 10%;
  margin-left: 1%;
  margin: 1%;
  margin-bottom: 0px;
  padding: 1%;
}

.Service>h1:nth-child(1) {
  text-align: left;
  margin: 1%;
}

.Utilisateurs {
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  justify-content: center;
  margin-bottom: 1%;
  padding: 1%
}

.Utilisateurs>p {
  flex: 1 1 50%;
}

.Utilisateurs>form {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  width: 100%;
}

.Utilisateurs>form>input,
select {
  /* flex: 1 1 75%; */
  /* width: 80% ; */
  padding: 1%;
}

#tableAccesInternet {
  border: solid 1px;
  width: 100%;
  margin-top: 1%;
  border-collapse: collapse;

}

th {
  border: solid 1px;
  /* padding: 10px; */
}

.Utilisateurs>div {
  display: flex;
  width: 100%;
  flex-wrap: wrap;
}

.Utilisateurs>div>button {
  flex: 1 1 45%;
  width: 10%;
  padding: 1%;
  margin: 1%;
}

.Utilisateurs>div>section {
  flex: 1 1 100%;
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  align-content: center;
  align-items: center;
  justify-content: left;
  background-color: lightgray;
  margin-top: 1%;
}

div>section>section {
  flex: 1 1 33%;
  margin: 1%;
  width: 100%;
}

div>section>section>span>input {
  width: 99%;
  height: 100%;
  padding: 1%;
}

#deroulant>section:nth-child(6)>div:nth-child(1) {
  width: 100%;
  padding: 1%;
}

.editClass {
  background-color: rgba(14, 175, 14, 0.408);
}</style>
