

<template>
  <div class="landing-page">
    <!-- <router-view></router-view> -->
    <component :is="compToRender"></component>
    <div class="logo">
      <img class="logo-img" alt="Vue logo" src="../assets/logo.png">
      <h3>Constantine University 2</h3>
      <h3>ABDELHAMID MEHRI</h3>
      <h3>IFA - TI</h3>
    </div>

    <h1 class="title">Gestionnaire des absences</h1>
    <p>
        this is the official website of The Faculty of Information and Communication Technology of
        ABDELHAMID MEHRI Constantine 2 university to manage students absences
    </p>

    <button
      class="login"
      @click="goToLogin"
    >Login</button>







  </div>

</template>

<script>
  import LoginComp from './Login/LoginComp.vue';

  export default {
    components:{
      LoginComp,
    },
    data() {
      return {
        compToRender: '',
      }
    },

    mounted() {
        if(this.$route.path == '/login'){
            this.compToRender = 'LoginComp';
        }
    },

    methods: {
        goToLogin() {
            this.$router.push('/login')
        }
    },

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.landing-page {
  background: url('../assets/homepage-background.jpg') no-repeat center;
  background-size: cover;
  height: 100vh;
  width: 100%;
  text-align: center;

}

.landing-page p{
    margin: 0 16vw;
    color: #d2d8e5;
    font-size: 18px;
    font-weight: 500;
}

.logo :nth-child(n){
  margin-top: 15px;
  color: #fff;
}

.logo-img{
  width: 100px;
  height: auto;
  padding: 40px;
}

.title{
  margin: 30px;
  font-size: 7vw;
  color: #fff;
  font-family: 'Roboto', sans-serif;
}

button {
  margin-top: 40px;
  width: 200px;
  height: 50px;
  font-size: 20px;
  font-weight: 700;
  background: linear-gradient(-90deg, #2c4eb477, #00882982) ;
  border: 1px solid;
  border-radius: 30px;
  color: #fff;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.476);
  transition: all ease .7s;

}

button:hover {
  box-shadow: none;
  border: 1px solid #ffffff83;
  background: #2c4eb4;
  transition: all ease .5s;
}
</style>
