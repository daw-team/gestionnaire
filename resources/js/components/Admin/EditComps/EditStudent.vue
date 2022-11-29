<template>
    <div class="background" @click="goBack($event)">
            <form
            action=""
            method="POST"
            >
            <h1 class="form-title">Add new student</h1>

            <div class="two">
                <div class="firstname">
                    <label for="">First name:</label>
                    <input type="text" v-model="student.fname">
                </div>

                <div class="lastname">
                    <label for="">Last name:</label>
                    <input type="text" v-model="student.lname">
                </div>
            </div>

            <div class="groupe">
                <label for="">Groupe:</label>
                <input type="text" v-model="student.groupe">
            </div>

            <div class="email">
                <label for="">Email:</label>
                <input type="text" v-model="student.email">
            </div>

            <div class="change-password-btn">
                <h4>Change password</h4>
                <div class="toggle-btn"
                        @click="changePasswordActive = ! changePasswordActive"
                        :class="{'btn-active': changePasswordActive }"
                    >
                    <div class="circle-btn"
                        :class="{'circle-active': changePasswordActive}"
                    >
                    </div>
                </div>
            </div>

            <div class="two" :class="{'input-desabled': !changePasswordActive}">
                <div class="password">
                    <label for="">Password:</label>
                    <input type="password" v-model="student.password" >
                </div>
                <div class="confirm-password">
                    <label for="">Confirm Password:</label>
                    <input type="password" v-model="confirmPassword"  :class="{'input-desabled': !changePasswordActive}">
                </div>
            </div>

            <p>{{ msg }}</p>
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
            student: {
                id: this.$route.params.StNum,
                fname: '',
                lname: '',
                email: '',
                password: '',
                groupe: ''
            },
            confirmPassword: '',
            changePasswordActive: false,
            msg: ''
        }
    },

    mounted() {
        this.box = document.querySelector('form');
        console.log(this.$route.params.StNum);
        axios
            .post('http://localhost:8000/api/studentInformation', {id: this.$route.params.StNum } )
            .then(res => {
                this.student.lname = res.data[0].Nom_Etud
                this.student.fname = res.data[0].Prenom_Etud
                this.student.email = res.data[0].UserName_Etud
                this.student.groupe = res.data[0].Group_Etud
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
            Object.keys(this.student).forEach( element => {
                if( !this.changePasswordActive && this.student[element] === '' ) {
                    if(element !== 'password'){
                        check = true
                    }
                }
            })
            return check
        },

        edit(){
            if(this.checkForEmptyFields()){
                this.msg = `You can't leave empty fields`
            }
            else if(this.student.password !== this.confirmPassword){
                this.msg = 'Passwords do not match'
            }
            else{
                axios
                .post('http://localhost:8000/api/updateStudentInfo', this.student)
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

label{
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
    width: 48%;
    min-width: 200px;
}

.groupe{
    width: 100px ;
    display: flex;
    flex-direction: column;
}

.email {
    width: 100%;
}

input[ type = text ], input[ type = password ] {
    width: calc(100% - 30px);
    padding: 5px 15px;
    height: 27px;
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

.change-password-btn{
    display: flex;
    align-items: center;
    width: 200px;
    justify-content: space-between;
    margin: 20px auto;
    color: #000000;

}

.circle-btn {
    width: 21px;
    height: 21px;
    background: #fff;
    left: 0;
    border-radius: 50%;
    margin: auto 2px;
    position: absolute;
    transition: all ease .3s;
}

.btn-active{
    background: #fff;
    border: #027224 1px solid;
    transition: all ease .5s;
}

.circle-active {
    left: 50%;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    box-shadow: 1px 1px 10px #027224;
    transition: all ease .3s;
}

.toggle-btn{
    width: 50px;
    height: 24px;
    background: rgb(163, 163, 163);
    border-radius: 12px;
    display: flex;
    align-items: center;
    position: relative;
    border: #1f3782 1px solid;
    transition: all ease .5s;
}

.input-desabled{
    pointer-events: none;
    color: #818181;
    opacity: 0.5;
    z-index: -1;
    transition: all ease .3s;
}


form p{
    color: #ff0000;
    font-weight: 500;
}

</style>
