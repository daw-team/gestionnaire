<template>
    <div class="container">

        <HeaderComp></HeaderComp>

        <div class="title">
            <div>
                <h1>Modules</h1>
                <p>You can find all your abcenses on this list </p>
                <input type="text"  placeholder="Search for a student">
            </div>
            <div class="img-src">
                    <img :src="getProfileUrl(user.imgSrc)" alt="">
            </div>
        </div>

        <div class="drawer">
            <ul
                v-for="(item , index) in drawerList"
                :key="index"
            >
                <li
                    @click="switchContent(index)"
                    :class="{'list-active': item.active}"
                >
                    {{ item.title }}
                </li>
            </ul>
            <div></div>
        </div>

        <component :is='compToRender'></component>

        <router-view></router-view>
    </div>
</template>

<script>
import JustifyForm from './AbsencesComps/JustifyForm.vue'
import PendingAbsences from './AbsencesComps/PendingAbsences.vue'
import UnjusAbsences from './AbsencesComps/UnjusAbsences.vue'
import AccAbsences from './AbsencesComps/AccAbsences.vue'
import HeaderComp from '../Header.vue'

export default {
    components:{
        JustifyForm,
        PendingAbsences,
        UnjusAbsences,
        AccAbsences,
        HeaderComp
    },
    data() {
        return{
            user: {
                id: this.$route.params.id,
                nom: '',
                prenom: '',
                username: '',
                currentPassword: '',
                imgSrc: '../../assets/user.png',
            },
            compToRender: 'UnjusAbsences',
            comps:[ 'UnjusAbsences', 'PendingAbsences', 'AccAbsences'],
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
            .post('http://localhost:8000/api/StudentInfo', {id:this.$route.params.id})
            .then( res => {
                this.user.nom = res.data[0].Nom_Etud
                this.user.prenom = res.data[0].Prenom_Etud
                this.user.username = res.data[0].UserName_Etud
                if(res.data[0].Photo_Etud !== null){
                    this.user.imgSrc = res.data[0].Photo_Etud
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
            this.drawerList[i].active = true
            this.compToRender = this.comps[i]
        }
    },

    setup() {

        const getProfileUrl = (name) => {
            return new URL(name, import.meta.url).href
        }

    return { getProfileUrl }
    }

}
</script>


<style scoped>
.container{
    margin: 0 5vw;
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
    margin-left: 8vw;
}

.title h1{
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 900;
    font-size: 50px;
}

.title div{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
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
    display: inline-flex
}

.drawer{
    display: flex;
    flex-direction: row;
    margin-top: 20px;
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
    border-radius: 5px 5px 0 0;
    color: #fff;
    background: linear-gradient(180deg, #14a24d, #2b5dbb);
}


</style>
