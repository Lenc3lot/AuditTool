<template>
  <main id="loginDiv">
    <div id="saisieDiv">
      <h2>Espace connexion</h2>
      <section>
        <input type="text" placeholder="Login" @change="setLogin($event)">
        <input type="password" placeholder="Password" @change="setPwd">
        <button class="button-29" @click="doLogin()">Se connecter</button>
      </section>
    </div>
    <div id="logo">
    <img src="../assets/logoSNS.png">
    <figcaption>Merci de vous connecter avec vos identifiants GPI !</figcaption>
    </div>
  </main>
</template>

<script>
/* eslint-disable */
import store from '@/store'
export default {
  name: 'LoginView',
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
      loginSNS: '',
      pwd: ''
    }
  },
  methods: {
    // methods here
    setLogin (event) {
      this.loginSNS = event.target.value
    },
    setPwd (event) {
      this.pwd = event.target.value
    },
    doLogin () {
      const body = new FormData()
      body.append('loginSNS', this.loginSNS)
      body.append('pwd', this.pwd)
      body.append('req', 'login')
      body.append('action', 'getSNSAccount')
      fetch(this.dataStore.baseUrl, {
        method: 'POST',
        body: body
      })
        .then(response => response.json())
        .then(response => {
          if (response.status === 200) {
            console.log(response)
            localStorage.token = response.token
            console.log(this.$decodeToken(localStorage.token)[0].idConsultant)
            this.$router.push('/')
          } else {
            this.$swal({
              toast: true,
              position: 'bottom-end',
              title: 'Une petite erreur a eu lieu...',
              text: 'Login ou mot de passe incorrect ! ',
              icon: 'error'
            })
          }
        })
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
#loginDiv{
  display: flex;
  /* border: solid 1px; */
  align-items: center;
  text-align: left;
  height: 41rem;
  background: linear-gradient(270deg, rgba(0,30,83,1) 3%, rgba(9,9,121,1) 34%, rgba(5,90,175,1) 59%, rgba(0,212,255,1) 100%);
}

#loginDiv>:nth-child(1){
  width: 45%;
}

#loginDiv>#saisieDiv{
  display: flex;
  border: solid 1px;
  border-radius: 10px;
  padding: 1%;
  margin: 1%;
  background-color: rgb(255, 255, 255);
  width: 65%;
  height: 65%;
  text-align: center;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

#logo{
  display: flex;
  text-align: center;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

section{
  width: 65%;
  display: flex;
  height: 50%;
  align-items: center;
  /* text-align: left; */
  /* justify-content: center; */
  flex-direction: column;
}

img{
  background-color: white;
  border-radius: 10px;
  width: 80%;
}

section>input{
  margin: 3%;
  padding: 3%;
  width: 90%;
  border-radius: 5px;
}

.button-29 {
  margin-top: 2%;
  align-items: center;
  appearance: none;
  background-image: radial-gradient(100% 100% at 100% 0, #5adaff 0, #5468ff 100%);
  border: 0;
  border-radius: 6px;
  box-shadow: rgba(45, 35, 66, .4) 0 2px 4px,rgba(45, 35, 66, .3) 0 7px 13px -3px,rgba(58, 65, 111, .5) 0 -3px 0 inset;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-flex;
  height: 48px;
  justify-content: center;
  line-height: 1;
  list-style: none;
  overflow: hidden;
  padding-left: 16px;
  padding-right: 16px;
  position: relative;
  text-align: left;
  text-decoration: none;
  transition: box-shadow .15s,transform .15s;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  white-space: nowrap;
  will-change: box-shadow,transform;
  font-size: 18px;
}

.button-29:focus {
  box-shadow: #3c4fe0 0 0 0 1.5px inset, rgba(45, 35, 66, .4) 0 2px 4px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
}

.button-29:hover {
  box-shadow: rgba(45, 35, 66, .4) 0 4px 8px, rgba(45, 35, 66, .3) 0 7px 13px -3px, #3c4fe0 0 -3px 0 inset;
  transform: translateY(-2px);
}

.button-29:active {
  box-shadow: #3c4fe0 0 3px 7px inset;
  transform: translateY(2px);
}
figcaption {
  background-color: #222;
  color: #fff;
  font: italic smaller sans-serif;
  padding: 3px;
  text-align: center;
}
</style>
