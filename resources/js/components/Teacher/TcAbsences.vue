<template>
    <div    class="container">
        <HeaderComp></HeaderComp>
        <div class="title" v-if="compToRender == 'AbsencesComp'">
            <div>
                <h1>Abcenses</h1>
                <p>You can find all your abcenses on this list </p>
                <input type="text"  placeholder="Search for a student">
            </div>
            <div class="img-src">
                    <img :src="getImageUrl(user.imgSrc)" alt="">
            </div>
        </div>

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
            <div></div>
        </div>

        <component :is="compToRender"></component>
        <router-view></router-view>
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
                imgSrc: '../../assets/AdminProfil.png',
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
.container {
    width: 100%;
}


h2{
    margin: 20px;
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
    margin-left: 10vw;
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

ul{
    display: inline-flex;
}

.drawer{
    display: flex;
    flex-direction: row;
    margin: 20px 10vw 10px 10vw;
}

.drawer div{
    flex-grow: 1;
    border-bottom: #000 solid 1px;

}

li{
    width: auto;
    list-style: none;
    font-size: 18px;
    font-weight: 800;
    border-bottom: #000 solid 1px;
    padding: 5px 20px;
    cursor: pointer;
}

.list-active{
    border-top: #000 solid 1px;
    border-right: #000 solid 1px;
    border-left: #000 solid 1px;
    border-bottom: none;
    color: #fff;
    border-radius: 5px 5px 0 0;
    background: linear-gradient(180deg, #14a24d, #2b5dbb);
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
