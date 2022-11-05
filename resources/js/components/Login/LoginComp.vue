<template>
    <div class="background">
        <div class="login">
            <div class="login-cover">
                <img class="login-img" src="../../assets/login-background.png">
                <div class="cover-text">
                    <h1>Welcome</h1>
                    <p>This form is dedicated to NTIC students
                        Profissionnel Email is to the login prosses
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
                    <p>  {{ msg }}</p>
                    <input type="submit"    name="submit"    value="Login"  @click.prevent="checkUser">
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
        login: {
                username: '',
                password: ''
            },
        msg: ''
    }
  },

  mounted() {
    },

    methods: {
        checkUser() {



            axios
                .post('http://localhost:8000/api/login', this.login)
                .then(response => {
                    console.log(response.data);
                    if(response.data.msg == 'welcome') {
                        this.$router.push('/student')
                    }
                    else{
                        this.msg = response.data.msg
                        this.login.username = ''
                        this.login.password = ''
                    }
                })


        }
    },
}

 // axios
            // .get('http://localhost:8000/api/students')
            // .then(response => {
            //     const datas = response.data;
            //     datas.forEach(element => {
            //         if (element['UserName_Etud'] == this.login.username) {
            //             if(element['PassWord_Etud'] == this.login.password){
            //                 alert('welcome');
            //             }
            //         }
            //     });
            // })
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
    padding: 20%;
    text-align: start;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    position:absolute;
    top: 0;
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

/* input[type = password]{
    width: 180px;
    height: 20px;
    border: none;
    outline: none;
    border-bottom: solid #121212 1px;
    margin: 40px 0 10px 0;
    font-size: 18px;


} */

input[type = submit] {
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(-70deg, rgb(44,78, 180), rgb(44,78, 180), rgb(0,136, 40));
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: auto;
    position: absolute;
    bottom: 18%;
}

form p {
    color: #ff0000;
}


</style>
