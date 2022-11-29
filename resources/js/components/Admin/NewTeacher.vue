<template>
    <div class="background" @click="goBack($event)">
            <form
            action=""
            method="POST"
            >
                <h1 class="form-title">Add new teacher</h1>

                <div class="two">
                    <div class="firstname">
                        <label for="">First name:</label>
                        <input type="text" v-model="newTeacher.firstname">
                    </div>

                    <div class="lastname">
                        <label for="">Last name:</label>
                        <input type="text" v-model="newTeacher.lastname">
                    </div>
                </div>

                <div class="module">
                    <label for="">Module:</label>
                    <select name="" id="" v-model="newTeacher.module_abriviation">
                        <option v-for="(module, index) in modules" :key="index" :value="module.Abrv_Mod">{{ module.Abrv_Mod }}</option>
                    </select>
                </div>
                <div class="email">
                    <label for="">Email:</label>
                    <input type="text" v-model="newTeacher.email">
                </div>

                <div class="two">
                    <div class="password">
                        <label for="">Password:</label>
                        <input type="password" v-model="newTeacher.password">
                    </div>
                    <div class="confirm-password">
                        <label for="">Confirm Password:</label>
                        <input type="password" v-model="confirmPassword">
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
            newTeacher: {
                firstname: '',
                lastname: '',
                email: '',
                password: '',
                module_abriviation: ''
            },
            confirmPassword: '',
            modules: []
        }
    },

    mounted() {
        this.box = document.querySelector('form');

        axios
            .get('http://localhost:8000/api/modulesList')
            .then( res => {
                this.modules = res.data
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
            Object.keys(this.newTeacher).forEach( element => {
                if( this.newTeacher[element] === '' ) {
                    check = true
                }
            })
            return check
        },

        create(){
            console.log(this.newTeacher);
            if(this.checkForEmptyFields()){
                this.msg = `You can't leave empty fields`
            }
            else if(this.newTeacher.password !== this.confirmPassword){
                this.msg = 'Passwords do not match'
            }
            else{
                axios
                .post('http://localhost:8000/api/CreateTeacher', this.newTeacher)
                .then(res => console.log(res.data))

                this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student created successfully',
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

label {
    margin: 0 10px;
}

.two{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.form-title{
    font-size: 40px;
    font-weight: 900;
    margin: 40px 0 60px 0;
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
}

.firstname , .lastname , .password , .confirm-password{
    width: 49%;
    min-width: 200px;
}

.module{
    display: flex;
    flex-direction: column;
}


.email {
    width: 100%;
}



input[ type = text ], input[ type = password], select {
    width: calc(100% - 30px);
    padding: 5px 15px;
    height: 27px;
    border-radius: 15px;
    border: #75757593 1px solid;
}

select{
    width: 140px !important;
    height: 38px;
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
