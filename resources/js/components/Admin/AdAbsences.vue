<template>
    <div    class="container">
        <HeaderComp></HeaderComp>
        <div class="title">
            <div>
                <h1>Abcenses</h1>
                <p>You can find all your abcenses on this list </p>
                <input type="text"  placeholder="Search for a student">
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
    width: 100%;
}


h2{
    margin: 20px;
}

.title {
    margin: 20px 0;
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
