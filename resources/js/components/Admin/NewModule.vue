<template>
    <div class="background" @click="goBack($event)">
            <form
            action=""
            method="POST"
            >
                <h1 class="form-title">Add new Module</h1>

                <div class="name">
                    <label for="">Name:</label>
                    <input type="text" v-model="newModule.name" >
                </div>

                <div class="abrv">
                    <label for="">Abbreviation:</label>
                    <input type="text" v-model="newModule.abriviation" >
                </div>

                <div class="two">
                    <div class="coeff">
                        <label for="">Coefficient:</label>
                        <input type="text" v-model="newModule.coefficient" >
                    </div>

                    <div class="credit">
                        <label for="">Credit:</label>
                        <input type="text" v-model="newModule.credit" >
                    </div>

                </div>


                <input type="submit"    name="submit"    value="Submit"  @click.prevent="create">
            </form>
    </div>

</template>

<script>
export default {
  data() {
    return {
        box: null,
        newModule:{
            name: '',
            abriviation: '',
            coefficient: '',
            credit: '',
        }
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

        checkForEmptyFields(){
            let check = false;
            Object.keys(this.newModule).forEach( element => {
                if( this.newModule[element] === '' ) {
                    check = true
                }
            })
            return check
        },

        create(){
            if(this.checkForEmptyFields()){
                this.msg = `You can't leave empty fields`
            }
            else{
                axios
                .post('http://localhost:8000/api/CreateModule', this.newModule)
                .then(res => console.log(res.data))

                this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Module created successfully',
                    showConfirmButton: false,
                    timer: 2000
                })
                this.$router.go(-1)
            }

        }

    },




}



</script>




<style  scoped>

@keyframes slideIn {
    0% {background: transparent;  left: -1500px;  opacity: 0;}
    50% {background: transparent; opacity: 0;}
    75% {background: transparent; opacity: 0}
    100% {background: linear-gradient(180deg, #14a24d5d, #2b5dbb43);  left: 0px;  opacity: 1;}
}

.background{
    background: linear-gradient(180deg, #14a24d5d, #2b5dbb43);
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    position: absolute;
    animation: slideIn .7s ease-in;
    opacity: 1;
}


form {
    width: 65vw;
    max-width: 500px;
    height: 70%;
    padding: 10px 50px;
    transform: translateY(10%);
    margin: auto;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-around;
    border-radius: 15px;
}

.coeff, .credit{
    width: 100px;
}

.two{
    width: 100%;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}

.credit{
    margin: 0 auto;
}

.form-title{
    font-size: 40px;
    font-weight: 900;
    margin: 40px 0 60px 0;
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
}

.name{
    width: 400px;
}

input[ type = text ] {
    width: 100%;
    padding: 10px 15px;
    height: 12px;
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
