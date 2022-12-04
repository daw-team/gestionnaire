<template>
    <div    class="container">
        <HeaderComp></HeaderComp>
            <div class="title">
                <div>
                    <h1>Abcenses</h1>
                    <!-- <p>You can find all your abcenses on this list </p> -->
                    <div class="drawer">
                        <ul>
                            <li
                                v-for="(item , index) in drawerList"
                                :key="index"
                                @click="switchContent(index)"
                                :class="{'list-active': item.active}"
                            >
                                {{ item.title }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="img-src">
                        <img :src="getImageUrl(user.imgSrc)" alt="">
                </div>
            </div>

        <div class="display-section">


            <component :is="compToRender"></component>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

import AbsencesComp from './absences/AbsencesComp.vue'
import NewAbsence from './absences/NewAbsence.vue'

import HeaderComp from '../Header.vue'


export default {
    components:{
        HeaderComp,
        AbsencesComp,
        NewAbsence
    },
    data() {
        return{
            user: {
                id: this.$route.params.id,
                nom: '',
                prenom: '',
                username: '',
                currentPassword: '',
                imgSrc: '../../assets/teacherProfil.png'
            },
            comps: ['AbsencesComp', 'NewAbsence'],
            compToRender: 'AbsencesComp',
            drawerList: [
                {title: 'view absences', active: false},
                {title: 'Create new Absence', active: false},
            ]
        }
    },

    mounted() {
        this.switchContent(0);

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
    },

    methods: {
        showForm(num) {
            this.$router.push(this.$route.fullPath + '/num=' + num)
        },
        switchContent(i){
            this.drawerList.forEach(element => {
                element.active = false
            });
            this.compToRender = this.comps[i]
            this.drawerList[i].active = true
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

.desappear-enter{
    opacity: 0;
}

.desappear-enter-active{
    transition: opacity 1s;
}

.desappear-leave{
    height: 100%;
}

.desappear-leave-active{
    opacity: 0;
    transform: translateY(-200px);
    transition: all 1s;
}

.container {
    width: 100%;
}


h2{
    margin: 20px;
}

.img-src{
    width: auto;
    height: 100px;;
}

.img-src img{
    width: 100px;
    height: 100px;
    border-radius: 50%;
}

.title {
    display: flex;
    margin: 20px;
    padding: 20px 0;
    border-radius: 15px;
    width: calc(100% - 40px);
    background: #ffffff;
    flex-direction: row;
    justify-content: space-between;
}

.title div{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    margin: 0 10vw;
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

ul{
    display: inline-flex;
}

.drawer{
    display: flex;
    flex-direction: row;
    margin: 0 !important;
}

.list-active{
    border: #000 solid 1px;
    color: #fff;
    border-radius: 5px;
    background: linear-gradient(180deg, #14a24d, #2b5dbb);
    border: none;
    transition: all ease .3s;
}

li {
    width: auto;
    list-style: none;
    margin: 0 0.6vw;
    font-size: 18px;
    font-weight: 800;
    border: none;
    padding: 5px 20px;
    cursor: pointer;
    border-radius: 5px;
    background-image: linear-gradient(180deg, #0c602e, #1a3972);
    -webkit-background-clip: text;
    color: transparent;
    position: relative;
    transition: all ease .3s;
}

li::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 5px;
  border: 1px solid transparent;
  background: linear-gradient(0deg, #2b5dbb, #14a24d);
  -webkit-mask:
    linear-gradient(#fff 0 0) padding-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
}

@media (max-width: 500px) {
    .title div{
        margin: 0;
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
        font-size: 35px;
    }

    .title input{
        width: 150px;
    }
    .drawer{
        margin: 10px 0;
    }
}


</style>
