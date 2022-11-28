<template>
    <div class="background" @click="goBack($event)">
            <form
            action=""
            method="POST"
            >
                <h1 class="form-title">Add new Module</h1>

                <div class="name">
                    <label for="">Name:</label>
                    <input type="text" v-model="module.name" >
                </div>

                <div class="abrv">
                    <label for="">Abbreviation:</label>
                    <input type="text" v-model="module.abriviation" >
                </div>

                <div class="two">
                    <div class="coeff">
                        <label for="">Coefficient:</label>
                        <input type="text" v-model="module.coefficient" >
                    </div>

                    <div class="credit">
                        <label for="">Credit:</label>
                        <input type="text" v-model="module.credit" >
                    </div>

                </div>

                <div class="two">
                    <input type="reset"     name="reset"    value="Cancel"  @click.prevent="funcExit">
                    <input type="submit"    name="submit"    value="Submit"  @click.prevent="edit">
                </div>
            </form>
    </div>

</template>

<script>
export default {
  data() {
    return {
        box: null,
        module:{
            id: 0,
            name: '',
            abriviation: '',
            coefficient: '',
            credit: '',
        }
    }
  },

  mounted() {
    this.box = document.querySelector('form');

    axios
        .post('http://localhost:8000/api/moduleInformation', {"id": this.$route.params.MdNum})
        .then( res => {
            this.module.id = res.data[0].Num_Mod
            this.module.name = res.data[0].Nom_Mod
            this.module.abriviation = res.data[0].Abrv_Mod
            this.module.coefficient = res.data[0].Coeff_Mod
            this.module.credit = res.data[0].Credit_Mod
        })

    },

    methods: {
        goBack(e) {
            if(!this.box.contains(e.target)){
                this.$router.go(-1)
            }
        },

        checkForEmptyFields(){
            let check = false;
            Object.keys(this.module).forEach( element => {
                if( this.module[element] === '' ) {
                        check = true
                }
            })
            return check
        },

        edit(){
            if( this.checkForEmptyFields() ){
                this.msg = `You can't leave empty fields`
            }
            else{
                console.log(this.module);
                axios
                .post('http://localhost:8000/api/updateModuleInfo', this.module)
                .then(res => console.log(res.data))

                this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'informations updated successfully',
                    showConfirmButton: false,
                    timer: 2500
                })
                this.$router.go(-1)
            }
        },

        funcExit(){
            this.$router.go(-1)
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

input[ type = reset]{
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: #757575;
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 10px auto;
    transition: all ease .5s;
}

input[ type = reset]:hover{
    background: linear-gradient(0deg, #838383, #bb2b2b);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: none;
    margin: 10px auto;
    transition: all ease .5s;
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
    margin: 10px auto;
    transition: all ease-out .2s;
}

input[type = submit]:hover{
    background: linear-gradient(180deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease-in .2s;
}



</style>
