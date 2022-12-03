<template>
    <div    class="container">
        <HeaderComp></HeaderComp>
        <div class="title">
            <div>
                <h1>Abcenses</h1>
                <p>You can find all your abcenses on this list </p>
            </div>
            <div class="img-src">
                    <img :src="getImageUrl(user.imgSrc)" alt="">
            </div>
        </div>

        <div class="drawer">
            <ul
            >
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

        <component :is="compToRender"></component>
        <router-view></router-view>
    </div>
</template>

<script>
import PendingComp from './absences/Pending.vue'
import UnjustifiedComp from './absences/Unjustified.vue'
import AcceptedComp from './absences/Accepted.vue'

import AdViewJustification from './AdViewJustification.vue'

import HeaderComp from '../Header.vue'


export default {
    components:{
        HeaderComp,
        PendingComp,
        UnjustifiedComp,
        AcceptedComp,
        AdViewJustification
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
            comps:[ 'UnjustifiedComp', 'PendingComp', 'AcceptedComp'],
            compToRender: 'UnjustifiedComp',
            drawerList: [
                {title: 'Unjustified', active: false},
                {title: 'Pending', active: false},
                {title: 'Accepted', active: false},
            ]
        }
    },

    mounted() {
        this.switchContent(0);

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

ul{
    display: inline-flex
}

.drawer{
    display: flex;
    flex-direction: row;
    margin: 20px 10vw 10px 10vw;
}

.list-active{
    border: #000 solid 1px;
    color: #fff;
    border-radius: 5px;
    background: linear-gradient(180deg, #14a24d, #2b5dbb);
    border: none;
    margin: 0 2vw;
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
