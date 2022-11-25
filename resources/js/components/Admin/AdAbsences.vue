<template>
    <div
        class="container"
        :class="{'small':menuChange}"
    >
        <HeaderComp></HeaderComp>
        <div class="title">
            <div>
                <h1>Abcenses</h1>
                <p>You can find all your abcenses on this list </p>
                <input type="text"  placeholder="Search for a student">
            </div>
            <img v-if="compToRender == 'NonJusAbsences'" src="../../assets/pending-title.png" alt="">
            <img v-if="compToRender == 'JustifiedAbsences'" src="../../assets/justified-title.png" alt="">
            <img v-if="compToRender == 'AccAbsences'" src="../../assets/accepted-title.png" alt="">
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

        <!-- <component :is="compToRender"></component> -->

        <router-view></router-view>
    </div>
</template>

<script>
// import JustifiedAbsences from './AbsencesComps/JustifiedAbsences.vue'
// import NonJusAbsences from './AbsencesComps/NonJusAbsences.vue'
// import AccAbsences from './AbsencesComps/AccAbsences.vue'
import HeaderComp from '../Header.vue'
import bus from '../../EventBus'


export default {
    components:{
    //     JustifiedAbsences,
    //     NonJusAbsences,
    //     AccAbsences,
        HeaderComp
    },
    data() {
        return{
            menuChange: false,
            comps:[ 'NonJusAbsences', 'JustifiedAbsences', 'AccAbsences'],
            compToRender: 'NonJusAbsences',
            drawerList: [
                {title: 'Not Justified', active: false},
                {title: 'Justified', active: false},
                {title: 'Accepted', active: false},
            ]
        }
    },

    created() {
        bus.$on('changeMenu', (value) => {
            this.menuChange = value;
        })
    },

    mounted() {
        this.switchContent(0);
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
}
</script>


<style scoped>
.container {
    padding-left: 70px;
    width: calc(100% - 70px);
    transition: all ease .4s;

}

.small {
    width: calc(100% - 260px) !important;
    padding-left: 260px !important;
}


h2{
    margin: 20px;
}

.title {
    margin: 50px 0;
    height: 200px;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
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
    margin: 0 100px;
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
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
}


</style>
