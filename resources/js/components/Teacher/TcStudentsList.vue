<template>
    <div    class="container">
        <header-comp></header-comp>

        <div class="title">
            <div>
                <h1>List of students</h1>
                <p>You can find all the students on this list </p>
                <input type="text"  placeholder="Search for a student">
            </div>
            <div class="img-src">
                <img :src="getImageUrl(user.imgSrc)" alt="">
            </div>
        </div>

        <div class="students-list">
            <div class="the-table">
                <div class="table-container">
                    <table>
                        <tr class="table-header">
                            <th>Student</th>
                            <th>Groupe</th>
                            <th>N of Unjustified Absences</th>
                            <th>N of accepted Absences</th>
                            <th>Email</th>
                        </tr>
                        <tr
                            v-for="(student, index) in students"
                            :key="index"
                            class="student"
                            :class="{'excluded': student.unjustified >= 3 || student.unjustified + student.justified >= 5}"
                        >
                            <td>
                                <p>{{ student.Nom_Etud }} {{ student.Prenom_Etud }}</p>
                            </td>

                            <td>
                                <p>{{ student.Group_Etud }}</p>
                            </td>

                            <td>
                                <p>{{ student.unjustified }}</p>
                            </td>

                            <td>
                                <p>{{ student.justified }}</p>
                            </td>

                            <td>
                                <a :href="`mailto:${student.UserName_Etud}`"><img src="../../assets/mailSend.png" alt=""></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <router-view></router-view>
    </div>
</template>

<script>

import HeaderComp from '../Header.vue'


export default {
    components:{
        HeaderComp
    },
    data() {
        return {
            user: {
                id: this.$route.params.id,
                nom: '',
                prenom: '',
                username: '',
                currentPassword: '',
                imgSrc: '../../assets/AdminProfil.png',
            },
            students:[],
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
            .post('http://localhost:8000/api/AllStudents', {id:this.$route.params.id})
            .then( res => {
                this.students = res.data
                console.log(res.data);
            })
    },

    methods:{

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

.excluded{
    background: #ff7575 !important;
}

.appear-enter{
    opacity: 0;
}

.appear-enter-active{
    transition: opacity 1s;
}


.students-list{
    margin: 35px 5vw;
}

.container {
    width: 100%;
}

.img-src{
    margin-right: 4vw;
    width: auto;
    height: 130px;
}

.img-src img{
    width: 130px;
    height: 130px;
    border-radius: 50%;
}

.title {
    height: 155px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    margin-left: 8vw;
}

.title div{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}

.title h1{
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 900;
    font-size: 50px;
}

.title p{
    margin-bottom: auto;
}

.title div input{
    margin-bottom: auto;
}

.title input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #00000079 solid 1px;
    border-radius: 20px;
    background-color: rgb(201 201 201 / 29%);
    font-size: 14px;
}

.the-table{
    width: 100%;
    height: 420px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 420px;
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
    height: 420px;
    border-radius: 15px;
}

td ,th{
    text-align: center;
    width: 100%;
}

.table-header{
    position: sticky;
    top: 0;
    height: 40px;
    background: #fff;
}

tr{
    width: 100%;
    display: flex;
    align-items: center;
}

td img{
    width: 20px;
    height: auto ;
    cursor: pointer;
}

.student{
    margin: auto;
    height: 70px;
    background-color: rgb(201, 201, 201);
    color: #fff;
    margin-bottom: 10px;
    font-weight: 900;
}

.add {
    width: 60px;
    height: 60px;
    position: absolute;
    bottom: 5%;
    right: 5%;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    box-shadow: 2px 2px 10px #000;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    flex-direction: row;
    transition: all ease .3s;
    color: #fff;
    cursor: pointer;
}

.add-expand{
    width: 180px;
    border-radius: 15px;
    background: linear-gradient(-70deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease .3s;
}

ion-icon{
    font-size: 40px;
    color: #fff;
}

@media (max-width: 500px) {
    .title{
        margin-left: 10px;
    }

    .img-src{
        height: 90px;
        margin: 0;
    }

    .img-src img {
        width: 90px;
        height: 90px;
    }

    .title h1{
        font-size: 30px;
    }

    .title input{
        width: 150px;
    }

}

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

</style>
