<template>
  <nav>
    <img src="./assets/logoSNS.png">
    <router-link to="/">Outil Audit</router-link>
    <router-link to="/recherche">Recherche</router-link>
    <router-link to="/login" @click="deco()">Deconnexion</router-link>
  </nav>
  <router-view/>
</template>

<script>
export default {
  data () {
    return {
      // variables here
      isCo: localStorage.token
    }
  },
  methods: {
    deco () {
      localStorage.clear()
    }
  }
}
</script>

<style>
* {
  box-sizing: border-box;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

body {
  font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: 0%;
}

nav {
  padding: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
}

nav>img{
  /* flex-grow: 1 100%; */
  width: 35%;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  /* border: solid 1px; */
  padding: 1%;
  text-decoration: underline;
}

a:hover{
  cursor: pointer;
}

nav a.router-link-exact-active {
  color: rgb(66, 135, 245);
}

img{
    width: 50%;
  }
</style>
