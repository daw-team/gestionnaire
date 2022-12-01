<template>
    <div    class="home">
        <div class="home-container">

        <div class="container-right">
            <div class="account-container card">
                <p>TEACHER</p>
                <img :src="getImageUrl(user.imgSrc)" alt="" @click="showProfileCard = !showProfileCard">
                <h3>{{ user.prenom}} {{ user.nom}}</h3>
                <p>{{ user.username }}</p>
                <a :href="`/teacher=${$route.params.id}/dashboard/profile`"   class="view-profile">
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
                        <img src="../../assets/absences.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>TOTAL GROUPS</h5>
                            <span>{{ homeInfo.groups }}</span>
                        </div>
                        <img src="../../assets/pending.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>TOTAL ABSENCES</h5>
                            <span>{{ homeInfo.absences }}</span>
                        </div>
                        <img src="../../assets/module.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>EXCLUDED STUDENTS</h5>
                            <span>{{ homeInfo.excluded }}</span>
                        </div>
                        <img src="../../assets/accepted.png" alt="">
                </div>

            </div>


            <div class="container-left">

                <HeaderComp></HeaderComp>

                <div class="absences long-card">
                        <h5>RECENT ABSENCES:</h5>
                    <div class="card-column-title">
                        <p>Module</p>
                        <p>Date</p>
                        <p>Time</p>
                        <p>justification</p>
                    </div>
                    <div  class="card-container">
                        <div class="absence"
                        v-for="(item, index) in absences"
                        :key="index"
                        >
                            <p>{{ item.module }}</p>
                            <p>{{ item.date }}</p>
                            <p>{{ item.time }}</p>
                            <img v-if="item.accepted" src="../../assets/Yellowdot.png" alt="">
                            <img v-if="!item.accepted" src="../../assets/reddot.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="contact long-card">
                    <h5>SEND EMAIL</h5>
                    <div class="the-table">
                        <div class="table-container">
                            <table>
                                <a
                                    :href="`mailto:${contact.UserName_Etud}`"
                                    v-for="(contact, index) in contacts"
                                    :key="index"
                                >
                                    <tr>
                                        <td>
                                            <p>{{ contact.Nom_Etud }} {{ contact.Prenom_Etud }}</p>
                                        </td>

                                        <td>
                                            <p>{{ contact.UserName_Etud }}</p>
                                        </td>

                                        <td>
                                            <img src="../../assets/mailSend.png" alt="">
                                        </td>
                                    </tr>
                                </a>
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
            showProfileCard: false,
            absences:[
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'}
            ],
            contacts:[],
            user: {
                nom:'',
                prenom: '',
                username: '',
                imgSrc: '../../assets/AdminProfil.png'
            },
            homeInfo:{
                students: 0, absences: 0, excluded: 0, groups: 0
            }
        }
    },

    mounted() {
        axios
            .post('http://localhost:8000/api/TeacherInfo', {id:this.$route.params.id})
            .then( res => {
                this.user.nom = res.data[0].Nom_Ens
                this.user.prenom = res.data[0].Prenom_Ens
                this.user.username = res.data[0].UserName_Ens
                if(res.data[0].Photo_Ens !== null ){
                    this.user.imgSrc = res.data[0].Photo_Ens
                }
            })
        axios
            .get( 'http://localhost:8000/api/studentsList' )
            .then( res => this.contacts = res.data)

            axios
            .post('http://localhost:8000/api/exludedStudents', { id: this.$route.params.id })
            .then( res => this.homeInfo.excluded = res.data )

        axios
            .get('http://localhost:8000/api/totalGroups')
            .then( res => this.homeInfo.groups = res.data )

        axios
            .post('http://localhost:8000/api/totalAbs', { id: this.$route.params.id })
            .then( res => this.homeInfo.absences = res.data )

        axios
            .get('http://localhost:8000/api/TotalStudentsNbr')
            .then( res => this.homeInfo.students = res.data )
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
    width: 100%;
    min-height: 300px;
    padding-bottom: 40px;
    overflow: hidden;
    background: #fff;
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
    height: 100vh;
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

.card-info{
    display: flex;
    flex-direction: row;
    width: 100%;
    align-items: center;
    justify-content: space-around;
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

.card-column-title{
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    margin: 10px 25px;
}

.long-card{
    flex-direction: column;
    padding: 0;
    height: auto;
    box-shadow: none;
    border-radius: 15px;
    min-width: 200px;
    margin: 20px 6vw;
    flex-grow: 1;
    overflow-x: visible;
}

.long-card h5{
    color: rgb(255 255 255);
    padding: 0 20px;
    width: calc(100% - 40px);
    height: 60px;
    font-size: 20px;
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    font-size: 20px;
}



.card-container{
    height: 200px;
    background: #fff;
    overflow-y: auto;
    overflow-x: visible;
}

.card-container {
    background: #fff;
}

.absence{
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    padding: 0 15px;
    margin-bottom: 5px;
    cursor: pointer;
    font-weight: 800;
    color: #fff;
    background: #c9c6c6;
    position: relative;
}

.absence:hover{
    box-shadow: 3px 3px 8px rgb(94, 94, 94);
    border-radius: 0px;
    background: rgba(0, 0, 0, 0.1);
    transition: all ease .4s;
}

.absence:hover::before{
    position: absolute;
    content: '';
    background: linear-gradient(0deg, #2b5dbb, #14a24d);
    width: 10px;
    height: 100%;
    left: 0;
    transition: all ease .4s;
}

.absence img{
    width: auto;
    height: 20px;
}

.mail-icon{
    color: #000;
    font-size: 40px;
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

.mail-icon{
    color: #000;
    font-size: 40px;
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
</style>
