<template>
    <div    class="container">
        <HeaderComp></HeaderComp>

        <div class="title">
            <div>
                <h1>List of modules</h1>
                <p>You can find all the modules on this list </p>
                <input type="text"  placeholder="Search for a module">
            </div>
            <div class="img-src">
                <img :src="getImageUrl(user.imgSrc)" alt="">
            </div>
        </div>

        <div class="modules-list">

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
                                <p>{{ module.Nom_Mod }}</p>
                            </td>

                            <td>
                                <p>{{ module.Abrv_Mod }}</p>
                            </td>

                            <td>
                                <div>
                                    <img src="../../assets/edit.png" alt="" @click="editModule(module.Num_Mod)" >&nbsp;
                                    <img src="../../assets/delete.png" alt="" @click="deleteModule(module.Num_Mod)">
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


export default {

    components:{
        EditModule,
        NewModule,
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
            menuChange: false,
            modules:[],
            buttonHovered: false
        }
    },

    mounted() {
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


        axios
            .get('http://localhost:8000/api/modulesList')
            .then( res => this.modules = res.data)
    },

    methods:{
        editModule(id){
            this.$router.push(this.$route.fullPath + '/num=' + id )
        },
        deleteModule(id){
            this.$swal.fire({
                title: 'Are you sure you want to delete this student?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete('http://localhost:8000/api/deleteModule', { data:{ id: id } })
                        .then(() => this.$router.go(0))

                    this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Student Deleted!',
                    showConfirmButton: false,
                    timer: 2500
                    })
                }
            })

        },

        goToAddPage(){
            this.$router.push(this.$route.fullPath + '/new')
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
    height: 40px;
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
