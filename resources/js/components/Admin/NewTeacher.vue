<template>
    <div class="background" @click="goBack($event)">
            <form
            action="./api/uploadImage"
            method="POST"
            >
                <h1 class="form-title">New teacher</h1>

                <div class="two">
                    <div class="firstname">
                        <label for="">First name:</label>
                        <input type="text" v-model="firstname">
                    </div>

                    <div class="lastname">
                        <label for="">Last name:</label>
                        <input type="text" v-model="lastname">
                    </div>
                </div>

                <div class="email">
                    <label for="">Email:</label>
                    <input type="text" v-model="email">
                </div>

                <div class="two">
                    <div class="password">
                        <label for="">Password:</label>
                        <input type="text" v-model="password">
                    </div>

                    <div class="confirm-password">
                        <label for="">Confirm Password:</label>
                        <input type="text" v-model="confirmPassword">
                    </div>
                </div>

                <input type="submit"    name="submit"    value="Submit"  @click.prevent="">
            </form>
    </div>

</template>

<script>
export default {
  data() {
    return {
        box: null,
        firstname: '',
        lastname: '',
        email: '',
        password: '',
        confirmPassword: '',
    }
  },

  mounted() {
    this.box = document.querySelector('form');
    },

    methods: {
        goBack(e) {
            if(!this.box.contains(e.target)){
                this.$router.go(-1)
            }
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
    background-color: #00000093;
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    position: absolute;
    animation: slideIn .7s ease-in;
    opacity: 1;

}


form {
    width: 500px;
    height: 70%;
    padding: 10px 50px;
    transform: translateY(10%);
    margin: auto;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-around;
}

.two{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    flex-wrap: wrap;
}

.form-title{
    font-size: 60px;
    margin: 40px 0 60px 0;
    color: rgb(126, 125, 125)
}

.firstname , .lastname , .password , .confirm-password{
    width: 40%;
}

.email{
    width: 100%;
}

input[ type = text ] {
    width: calc(100% - 30px);
    padding: 5px 15px;
    height: 27px;
    border-radius: 15px;
    border: #75757593 1px solid;
}


input[type = submit] {
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 40px auto;
    transition: all ease-out .2s;
}

input[type = submit]:hover{
    background: linear-gradient(180deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease-in .2s;
}


</style>
