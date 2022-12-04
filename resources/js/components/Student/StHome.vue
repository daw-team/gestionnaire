<template>
    <div
        class="home"
    >
        <div class="home-container">

        <div class="container-right">
            <div class="account-container card">
                <p>STUDENT</p>
                <img :src="getImageUrl(user.imgSrc)" alt="" @click="showProfileCard = !showProfileCard">
                <h3>{{ user.prenom}} {{ user.nom}}</h3>
                <p>{{ user.username }}</p>
                <button @click="goToProfile">View profile</button>
                <a href="/logout"><button>Log out</button></a>
            </div>

                <div class="card">
                        <div>
                            <h5>TOTAL ABSENCES</h5>
                            <span>{{ absencesInfo.totalAbsences }}</span>
                        </div>
                        <img src="../../assets/absences.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>PENDING ABSENCES</h5>
                            <span>{{ absencesInfo.pendingAbsences }}</span>
                        </div>
                        <img src="../../assets/pending.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>JUSTIFIED ABSENCES</h5>
                            <span>{{ absencesInfo.justifiedAbsences }}</span>
                        </div>
                        <img src="../../assets/accepted.png" alt="">
                </div>

                <div class="card">
                        <div>
                            <h5>EXCLUDED MODEL</h5>
                            <span>DAW</span>
                        </div>
                        <img src="../../assets/module.png" alt="">
                </div>
            </div>


            <div class="container-left">

                <HeaderComp class="head"></HeaderComp>

                <div class="contact long-card">
                    <h5>RECENT ABSENCES:</h5>
                    <div class="the-table">
                        <div class="table-container">
                            <table>
                                <tr class="table-header">
                                    <th>Module</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Stat</th>
                                </tr>

                                <tr
                                    v-for="(absence, index) in absences"
                                    :key="index"
                                    class="table-row"
                                >
                                    <td>
                                        <p>{{ absence.Abrv_Mod }}</p>
                                    </td>

                                    <td>
                                        <p>{{ absence.Date_Abs }}</p>
                                    </td>

                                    <td>
                                        <p>{{ absence.Hour_Abs }}</p>
                                    </td>

                                    <td>
                                        <div class="unjustified" v-if="absence.Just_Abs == null && absence.Type_Abs === 'nonJustifié'">
                                            <p>UNJUSTIFIED</p>
                                        </div>
                                        <div class="justified" v-if="absence.Just_Abs != null  && absence.Type_Abs === 'nonJustifié'">
                                            <p>PENDING</p>
                                        </div>
                                        <div class="accepted" v-if="absence.Type_Abs === 'justifié'">
                                            <p>ACCEPTED</p>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="contact long-card">
                    <h5>SEND EMAIL</h5>
                    <div class="the-table">
                        <div class="table-container">
                            <table>
                                <a
                                    :href="`mailto:${contact.UserName_Ens}`"
                                    v-for="(contact, index) in contacts"
                                    :key="index"
                                >
                                    <tr class="table-row">
                                        <td>
                                            <div>
                                                <p>{{ contact.Nom_Ens }} {{ contact.Prenom_Ens }}</p>
                                                <span>{{ contact.Abrv_mod }}</span>
                                            </div>
                                        </td>

                                        <td>
                                            <p>{{ contact.UserName_Ens }}</p>
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
            absences:[],
            contacts:[],
            user:{
                nom:'',
                prenom: '',
                username: '',
                imgSrc: '../../assets/user.png'
            },
            absencesInfo: {
                totalAbsences: 0, pendingAbsences: 0, justifiedAbsences: 0
            }
        }
    },

    mounted() {
        axios
            .post('http://localhost:8000/api/StudentInfo', {id:this.$route.params.id})
            .then( res => {
                this.user.nom = res.data[0].Nom_Etud
                this.user.prenom = res.data[0].Prenom_Etud
                this.user.username = res.data[0].UserName_Etud
                if(res.data[0].Photo_Etud !== null){
                    this.user.imgSrc = res.data[0].Photo_Etud
                }
            })

        axios
            .post('http://localhost:8000/api/totalAbsNbr', {id:this.$route.params.id})
            .then( res => {
                this.absencesInfo.totalAbsences = res.data
            })

        axios
            .post('http://localhost:8000/api/totalJustAbsNbr', {id:this.$route.params.id})
            .then( res => {
                this.absencesInfo.justifiedAbsences = res.data
            })

        axios
            .post('http://localhost:8000/api/totalNonJustAbsNbr', {id:this.$route.params.id})
            .then( res => {
                this.absencesInfo.pendingAbsences = res.data
            })


        axios
            .get('http://localhost:8000/api/sendTeacherEmail')
            .then( res => {
                this.contacts = res.data
            })

        axios
            .post('http://localhost:8000/api/getRecentAbs', {id: this.$route.params.id})
            .then( res => this.absences = res.data)
        },

        methods: {
            goToProfile(){
                this.$router.push(`/student=${this.$route.params.id}/dashboard/profile`)
            }
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
a{
    text-decoration: none;
}

a:visited{
    text-decoration: none;
}

.home{
    width: 100%;
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

input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #ffffff79 solid 1px;
    color: #e8e8e8;
    border-radius: 20px;
    font-size: 14px;
    background: linear-gradient(6deg, #1f378233, #02722438);
}

.background{
    width: calc(100% + 50px);
    margin-left: -50px;
    height: 150px;
    background: linear-gradient(70deg, #2c4eb4, #305748);
    left: 0;
    z-index: 0;

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

.account-container img{
    border-radius: 50%;
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



.account-container button{
    height: 40px;
    margin: 5px auto;
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


.account-container a {
    width: 70%;
    font-weight: 500;
    background: linear-gradient#fff;
}

.account-container a button{
    width: 100%;
    border-radius: 10px;
    border: none;
}

.account-container a button:hover{
    box-shadow: #000 1px 1px 5px;
    transition: all ease .4s;
}



.card{
    min-width: 200px;
    width: calc(100% - 40px);
    height: 80px;
    background-color: #ffffff;
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
  background: linear-gradient(-70deg, #1f3782, #027224);
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
    width: 70px;
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

.long-card{
    flex-direction: column;
    padding: 0;
    height: auto;
    box-shadow: none;
    border-radius: 15px;
    min-width: 200px;
    margin: 20px 3vw;
    flex-grow: 1;
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
    border-radius: 5px;
}

.the-table{
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 280px;
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
    height: 280px;
    border-radius: 15px;
}

.table-header{
    width: 100%;
    position: sticky;
    z-index: 10;
    top: 0;
    height: 40px;
    background: #fcfcfc;
}

tr{
    width: 100%;
    display: flex;
    align-items: center;
    text-align: left;
    margin-bottom: 5px;
}

td img{
    color: #000;
    width: 20px;
    height: 20px;
}

td, th {
    width: calc(100% - 60px);
    padding: 0 20px;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
}

.table-row{
    background: #fff;
    height: 50px;
    width: 100%;
    padding: 8px 0;
    display: flex;
    align-items: center;
    text-align: left;
    color: rgb(61, 61, 61);
    position: relative;
}

.table-row:hover{
    box-shadow: 3px 3px 8px rgb(94, 94, 94);
    border-radius: 0px;
    background: rgba(0, 0, 0, 0.1);
    transition: all ease .4s;
}

.table-row:hover::before{
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

.unjustified{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #9D2A22;
    padding: 5px;
    background: #F1A4A4;
    border-radius: 5px;
}

.justified{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #8045B9;
    padding: 5px;
    background: #D8B4FE;
    border-radius: 5px;
}

.accepted{
    width: 83px;
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    color: #3D7A47;
    padding: 5px;
    background: #86EFAC;
    border-radius: 5px;
}

a{
    text-decoration: none;
}

a:visited{
    text-decoration: none;
}

@media (max-width: 1000px) {
    .head{
        display: none;
    }
}
</style>
