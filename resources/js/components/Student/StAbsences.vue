<template>
    <div class="container">

        <HeaderComp></HeaderComp>
        <div class="student-absences">
            <div class="title">
                <div>
                    <h1>Absences</h1>
                    <p>You can find all your abcenses on this list </p>
                </div>
                <div class="img-src">
                        <img :src="getProfileUrl(user.imgSrc)" alt="">
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
            </div>

            <component :is='compToRender'></component>
        </div>

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
.student-absences{
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


</style>
