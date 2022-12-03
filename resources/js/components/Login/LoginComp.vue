<template>
    <div class="background" @click="goHome($event)">
        <div class="login" >
            <div class="login-cover">
                <img class="login-img" src="../../assets/login-background.png">
                <div class="cover-text">
                    <h1>Welcome</h1>
                    <p>This form is dedicated to NTIC students.
                        &nbsp;&nbsp;Profissionnel Email is required to the login prosses
                    </p>

                </div>
            </div>

            <div    class="login-form">
                <form
                action="./api/login"
                method="POST"
                >
                    <h1 class="form-title">Login</h1>

                    <input
                        type="text"
                        name="email"
                        placeholder="Enter your Email"
                        v-model="login.username"
                    >

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your Password"
                        v-model="login.password"
                    >
                    <input type="submit"    name="submit"    value="Login"  @click.prevent="checkUser">
                    <p>  {{ msg }}</p>
                </form>
            </div>

        </div>
    </div>

</template>

<script>
export default {
  name: 'LoginComp',
  data() {
    return {
        box: null,
        login: {
                username: '',
                password: ''
            },
        msg: ''
    }
  },

  mounted() {
    this.box = document.querySelector('.login');
    },

    methods: {
        goHome(e) {
            if(!this.box.contains(e.target)){
                this.$router.push('/')
            }
        },
        checkUser() {



            axios
                .post('http://localhost:8000/api/login', this.login)
                .then(response => {
                    console.log(response.data);
                    if(response.data.msg == 'Etudiant') {
                        this.$router.push('/student=' + response.data.id)
                    }
                    else if (response.data.msg == 'Enseignant') {
                        this.$router.push('/teacher=' + response.data.id)
                    }
                    else if (response.data.msg == 'Administarteur') {
                        this.$router.push('/admin=' + response.data.id)
                    }
                    else{
                        this.msg = response.data.msg
                        this.login.username = ''
                        this.login.password = ''
                    }
                })


        },


        },


        }



</script>




<style  scoped>

@keyframes slideIn {
    0% {background-color: transparent;  left: -1500px;  opacity: 0;}
    50% {background-color: transparent; opacity: 0;}
    75% {background-color: transparent;}
    100% {background-color: #ffffff93;  left: 0px;  opacity: 1;}
}

.background{
    background-color: #ffffff93;
    width: 100%;
    height: 100vh;
    position: absolute;
    animation: slideIn .7s ease-in;
    opacity: 1;

}



.login {
    width: 700px;
    height: 70%;
    display: flex;
    flex-direction: row;
    transform: translateY(20%);
    margin: auto;
}

.login-cover{
    height: 100%;
    width: auto;
    position: relative;
}

.cover-text {
    width: 70%;
    height: 50%;
    padding: 20% 15%;
    text-align: start;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-around;
    position:absolute;
    top: 0;
}

.cover-text h1
{
    margin-top: 30px;
}
.cover-text p{
    width: 70%;
    font-style: italic;
}

.login-img{
    height: 100%;
    border-top-left-radius: 50px;
    border-bottom-left-radius: 50px;
}

.login-form{
    height: 100%;
    width: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    background-color: #fff;
    flex-grow: 1;
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    padding-left: 50px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.form-title{
    font-size: 60px;
    margin: 40px 0 60px 0;
    color: rgb(126, 125, 125)
}

input{
    width: 180px;
    height: 20px;
    padding: 10px;
    border: none;
    outline: none;
    border-bottom: solid #121212 1px;
    margin: 40px 0 10px 0;
    font-size: 14px;

}

input:focus {
    border-bottom: solid #121212 1px;
    border: #2c4eb4 solid 1px;
    border-radius: 20px;
}

input[type = submit] {
    width: 100px;
    height: 45px;
    font-size: 20px;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    font-weight: 700;
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 40px auto;
    transition: all ease-in .4s;
}

input[type = submit]:hover{
    background: linear-gradient(0deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease-in .4s;
}

form p {
    color: #ff0000;
    text-align: center;
    margin: auto;
}


</style>
