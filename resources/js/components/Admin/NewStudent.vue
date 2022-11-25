<template>
    <div class="background" @click="goBack($event)">
            <form
            action="./api/uploadImage"
            method="POST"
            >
                <h1 class="form-title">Jusfication form</h1>
                <p></p>
                <label for="">First Name:</label>
                <input type="text" >

                <label for="">First Name:</label>
                <input type="text" >

                <label for="">First Name:</label>
                <input type="text" >


                <input type="submit"    name="submit"    value="Submit"  @click.prevent="">
            </form>
    </div>

</template>

<script>
export default {
  data() {
    return {
        box: null,
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
}

.form-title{
    font-size: 60px;
    margin: 40px 0 60px 0;
    color: rgb(126, 125, 125)
}


input[type = submit] {
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(-70deg, rgb(44,78, 180), #2c4eb4, #008828);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 40px auto;
}

form p {
    color: #ff0000;
    text-align: center;
    margin: auto;
}


</style>
