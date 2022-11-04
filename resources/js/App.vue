<template>
    <div id="app">
        <router-view    :key="$route.fullPath"></router-view>
    </div>
  </template>

  <script>
  import LandingPageApp from './components/LandingPage.vue'


  export default {
    name: 'App',
    components: {
      LandingPageApp,
    },
    data() {
        return {

        }
    },

  }
  </script>

  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  *{
    padding: 0px;
    margin: 0px;
  }

  </style>
