<template>
    <div
        class="container"
        :class="{'small':menuChange}"
    >
        <HeaderComp></HeaderComp>
        <div class="modules-list">
            <div class="title">
                <div>
                    <h1>List of modules</h1>
                    <p>You can find all the modules on this list </p>
                    <input type="text"  placeholder="Search for a module">
                </div>
            </div>

            <div class="the-table">
                <div class="table-container">
                    <table>
                        <tr class="table-header">
                            <th>Module</th>
                            <th>Abbreviation</th>
                            <th>Edit/Delete</th>
                        </tr>
                        <tr
                            v-for="(module, index) in modules"
                            :key="index"
                            class="module"
                        >
                            <td>
                                <p>{{ module.Nom_Ens }} {{ module.Prenom_Ens }}</p>
                            </td>

                            <td>
                                <p>{{ module.Abrv_mod }}</p>
                            </td>

                            <td>
                                <div>
                                    <img src="../../assets/edit.png" alt="" @click="goToEditPage()" >&nbsp;
                                    <img src="../../assets/delete.png" alt="">
                                </div>
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
            <div
                class="add"
                @mouseover="buttonHovered = true"
                :class="{'add-expand': buttonHovered}"
                @mouseleave="buttonHovered = false"
                @click="goToAddPage"
            >
                <ion-icon name="add-outline"></ion-icon>
                <transition name="appear">
                    <h3 v-if="buttonHovered">New module</h3>
                </transition>
            </div>

        </div>
        <router-view></router-view>
    </div>
</template>

<script>
import EditModule from './EditComps/EditModule.vue'
import NewModule from './NewModule.vue'
import HeaderComp from '../Header.vue'
import bus from '../../EventBus'


export default {

    components:{
        EditModule,
        NewModule,
        HeaderComp
    },

    data() {
        return {
            menuChange: false,
            modules:[],
            buttonHovered: false
        }
    },

    created() {
        bus.$on('changeMenu', (value) => {
            this.menuChange = value;
        })
    },

    mounted() {
        axios
            .get('http://localhost:8000/api/AllModules')
            .then( res => {
                console.log(res.data);
                this.modules = res.data
            })
    },

    methods:{
        goToEditPage(id){

        },

        goToAddPage(){
            this.$router.push(this.$route.fullPath + '/new')
        }
    }
}

</script>

<style scoped>
.appear-enter{
    opacity: 0;
}

.appear-enter-active{
    transition: opacity 1s;
}


.modules-list{
    margin: 0 5vw;
}

.container {
    padding-left: 70px;
    width: calc(100% - 70px);
    transition: all ease .4s;
}

.small {
    width: calc(100% - 260px) !important;
    padding-left: 260px !important;
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
    width: 1200px;
    border-collapse: separate;
    border-spacing: 0 10px;
    display: inline-block;
    overflow-y: auto;
    height: 300px;
    border-radius: 15px;
}

td ,th{
    text-align: center;
    width: 100%;
}

.table-header{
    position: sticky;
    top: 0;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    height: 40px;
    color: #fff;
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

.module{
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

</style>
