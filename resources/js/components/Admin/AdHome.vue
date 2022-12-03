<template>
    <div
        class="home"
    >
        <div class="home-container">

        <div class="container-right">
            <div class="account-container card">
                <p>ADMIN</p>
                <img :src="getImageUrl(user.imgSrc)" alt="" @click="showProfileCard = !showProfileCard">
                <h3>{{ user.prenom}} {{ user.nom}}</h3>
                <p>{{ user.username }}</p>

                <a :href="`/admin=${$route.params.id}/dashboard/profile`"   class="view-profile">
                    <button>View profile</button>
                </a>

                <a href="/logout" class="logout">
                    <button>Log out</button>
                </a>
            </div>

                <div class="card">
                        <div>
                            <h5>TOTAL STUDENTS</h5>
                            <span>{{ homeInfo.students }}</span>
                        </div>
                        <img src="../../assets/totalstud.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>TOTAL TEACHERS</h5>
                            <span>{{ homeInfo.teachers }}</span>
                        </div>
                        <img src="../../assets/totalteach.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>TOTAL MODULES</h5>
                            <span>{{ homeInfo.modules }}</span>
                        </div>
                        <img src="../../assets/totalmod.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>TOTAL ABSENCES</h5>
                            <span>{{ homeInfo.absences }}</span>
                        </div>
                        <img src="../../assets/totalabs.png" alt="">
                </div>
            </div>


            <div class="container-left">

                <HeaderComp class="header-comp"></HeaderComp>

                <div class="card2-container">
                    <div class="card-2">
                        <h1>List of students</h1>
                        <div class="card2-info">
                            <p>edit and delete list of students and
                            create a new student</p>
                            <a :href="`/admin=${$route.params.id}/dashboard/students`"><button>Check</button></a>
                        </div>
                    </div>

                    <div class="card-2">
                        <h1>List of teachers</h1>
                        <div class="card2-info">
                            <p>edit and delete list of teachers and
                            create a new teacher</p>
                            <a :href="`/admin=${$route.params.id}/dashboard/teachers`"><button>Check</button></a>
                        </div>
                    </div>

                    <div class="card-2">
                        <h1>List of modules</h1>
                        <div class="card2-info">
                            <p>edit and delete list of modules and
                            create a new module</p>
                            <a :href="`/admin=${$route.params.id}/dashboard/modules`"><button>Check</button></a>
                        </div>
                    </div>

                    <div class="card-2">
                        <h1>List of absences</h1>
                        <div class="card2-info">
                                <p>consult list of absences:
                                unjustified, pending and accepted</p>
                            <a :href="`/admin=${$route.params.id}/dashboard/absences`"><button>Check</button></a>
                        </div>
                    </div>
                </div>

                <div class="long-card"
                >
                    <h5>SEND EMAIL</h5>

                    <div class="the-table">
                        <div class="table-container">
                            <table>
                                <tr
                                    :href="`mailto:${contact.UserName_Ens}`"
                                    v-for="(contact, index) in contacts"
                                    :key="index"
                                >
                                    <td>
                                        <div>
                                            <p>{{ contact.Nom_Ens }} {{ contact.Prenom_Ens }}</p>
                                            <span>{{ contact.Abrv_mod }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        <p>{{ contact.UserName_Ens }}</p>
                                    </td>

                                    <td>
                                        <img src="../../assets/mailSend.png" alt="">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</template>

<script>

import HeaderComp from '../Header.vue'

export default {

    components: {
        HeaderComp,
    },

    data() {
        return {
            menuChange: false,
            showProfileCard: false,
            contacts:[],
            user:{
                nom:'',
                prenom: '',
                username: '',
                imgSrc: '../../assets/AdminProfil.png'
            },
            homeInfo: {
                teachers: 0, students: 0, absences: 0, modules: 0
            },
        }
    },


    mounted() {
        axios
            .post('http://localhost:8000/api/AdminInfo', {id:this.$route.params.id})
            .then( res => {
                this.user.nom = res.data[0].Nom_Adm
                this.user.prenom = res.data[0].Prenom_Adm
                this.user.username = res.data[0].UserName_Adm
                if(res.data[0].Photo_Adm !== null ){
                    this.user.imgSrc = res.data[0].Photo_Adm
                }
            })

        axios
            .get('http://localhost:8000/api/TotalTeachersNbr')
            .then( res => {
                this.homeInfo.teachers = res.data
            })

        axios
            .get('http://localhost:8000/api/TotalStudentsNbr')
            .then( res => {
                this.homeInfo.students = res.data
            })

        axios
            .get('http://localhost:8000/api/TotalAbsencesNbr')
            .then( res => {
                this.homeInfo.absences = res.data
            })

        axios
            .get('http://localhost:8000/api/TotalModulesNbr')
            .then( res => {
                this.homeInfo.modules = res.data
            })

        axios
            .get('http://localhost:8000/api/sendTeacherEmail')
            .then( res => {
                this.contacts = res.data
            })

    },

    methods: {

    },


    setup() {
    const getImageUrl = (name) => {
        return new URL(name, import.meta.url).href
    }
    return { getImageUrl }
    }
}


</script>


<style scoped>
.home{
    width:100%;
}

.home-container{
    display: flex;
    flex-flow: row-reverse wrap;
    min-height: 90vh;
    justify-content: space-around;
}

.container-right{
    min-width: 200px;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
    padding: 10px 20px;
}

.container-left{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    min-height: 100vh;
    flex-grow: 1;
}

.header{
    padding: 0 20px !important;
    width: calc(98% - 40px) !important;
    align-items: center;
    height: 60px !important;
    box-shadow: none !important;
    margin: 7px 20px 40px 20px!important;
}


.header :nth-child(1){
    width: 55px;
    height: auto ;
}


.header :nth-child(3){
    width: 35px ;
    height: auto;
}

input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #ffffff79 solid 1px;
    color: #e8e8e8;
    border-radius: 20px;
    font-size: 14px;
    background: linear-gradient(0deg, #2b5dbb64, #14a24d5c);
}

.account-container {
    width: 100% !important;
    flex-direction: column !important;
    font-size: 15px;
    height: 300px !important;
    padding: 0 !important;
    align-items: center;
    justify-content: space-around !important;
}

.account-container::after{
    content: none !important;
}

.account-container :nth-child(4){
    margin-bottom: auto;
    color: gray;
    font-weight: 900;
    font-size: 13px;
}

.account-container :nth-child(1){
    margin-top: auto;
    margin-bottom: 10px;
    font-size: 18px;
    color: gray;
    font-weight: 900;
    font-size: 13px;
}

.account-container .logout{
    margin-top: auto;
    margin-bottom: 10px;
    font-size: 18px;
    color: gray;
    font-weight: 900;
    font-size: 13px;
}

.account-container button{
    height: 40px;
    width: 100%;
    background: transparent;
    border: none;
}

.view-profile button{
    margin-bottom: 0 !important;
    color: #fff !important;
}

.account-container :nth-child(5) {
    width: 80%;
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 10px;
}

.account-container :nth-child(5):hover {
    background: linear-gradient(0deg, #1e4881, #106e3a);
}


.account-container .logout {
    width: 70%;
    font-weight: 500;
}

.account-container .logout button{
    width: 100%;
    border-radius: 10px;
    border: none;
}

.account-container .logout button:hover{
    box-shadow: #000 1px 1px 5px;
    transition: all ease .4s;
}

.card{
    min-width: 200px;
    width: calc(100% - 40px);
    height: 80px;
    background-color: #fcfcfc;
    box-shadow: rgb(94 94 94) 5px 5px 10px;
    padding: 15px 20px;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-left: auto;
    position: relative;
}

.card::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 15px;
  border: 2px solid transparent;
  background: linear-gradient(0deg, #2b5dbb, #14a24d);
  -webkit-mask:
    linear-gradient(#fff 0 0) padding-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
}

.account-container img {
    height: 70px !important;
    width: 70px !important;
    border-radius: 50% !important;
}

.card img {
    height: 70px;
    width: auto;
}

h5 {
    color: gray;
    font-weight: 900;
    margin-bottom: 10px;
    font-size: 13px;
}

.card span {
    font-size: 30px;
    font-weight: 700;
}

.card2-container{
    min-height: 340px;
    flex-direction: row;
    flex-wrap: wrap;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    justify-content: space-around;
    grid-gap: 20px;
    align-items: center;
    margin: 0 6vw;
}

.card-2{
    min-width: 300px;
    height: 120px;
    background-color: #fcfcfc;
    padding: 15px 20px;
    border-radius: 15px;
    margin-left: auto;
    position: relative;
}

.card-2 h1{
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 900;
    font-size: 30px;
}

.card2-info{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.card-2 p{
    padding: 5px 10px;
}

.card2-info button{
    width: 100px;
    height: 30px;
    border: none;
    background: #fff;
    position: relative;
    border-radius: 15px;
    z-index: 99;
    cursor: pointer;
    transition: all ease .4s ;

}

.card-2 button::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 15px;
  border: 1px solid transparent;
  background: linear-gradient(0deg, #2b5dbb, #14a24d);
  -webkit-mask:
    linear-gradient(#fff 0 0) padding-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
}

.card-2 button:hover{
    border-radius: 5px;
    color: #fff;
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    transition: all ease .4s ;
}

.long-card{
    flex-direction: column;
    padding: 0;
    height: auto;
    box-shadow: none;
    border-radius: 15px;
    min-width: 350px;
    margin: 20px 6vw;
    flex-grow: 1;
    overflow-x: hidden;
}

.long-card h5{
    color: rgb(255 255 255);
    padding: 0 20px;
    width: calc(100% - 40px);
    height: 80px;
    font-size: 20px;
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    font-size: 20px;
}

.the-table{
    width: 100%;
    height: 300px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 300px;
    height: 100%;
    overflow-x: auto;
    padding-bottom: 17px;
    box-sizing: content-box;
    overflow-y: hidden;
}


table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    display: inline-block;
    overflow-y: auto;
    height: 300px;
    border-radius: 15px;
}

td img{
    color: #000;
    width: 20px;
    height: auto;
}

tr{
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    margin: 10px 0;
    background: #c9c6c6;
    padding: 8px 0;
    color: #fff;
    font-weight: 800;
    position: relative;
}

td{
    text-align: center;
    width: 100%;
}

tr:hover{
    box-shadow: 3px 3px 8px rgb(94, 94, 94);
    border-radius: 0px;
    background: rgba(0, 0, 0, 0.1);
    transition: all ease .4s;
    cursor: pointer;
}

tr:hover::before{
    position: absolute;
    content: '';
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    width: 10px;
    height: 100%;
    left: 0;
    transition: all ease .4s;
}

td span{
    color: gray;
    font-weight: 900;
    font-size: 13px;
}

a{
    text-decoration: none;
}

a:visited{
    text-decoration: none;
}

@media (max-width: 1072px) {
    .header-comp{
        display: none;
    }
    .long-card{
        margin: 20px auto;
        width: 300px;
    }
    table {
    width: 1000px;
    }
}
</style>
