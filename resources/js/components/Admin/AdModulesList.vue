<template>
    <div    class="container">
        <HeaderComp></HeaderComp>

        <div class="title">
            <div>
                <h1>List of modules</h1>
                <p>You can find all the modules on this list </p>
                <input type="text"  placeholder="Search for a module" v-model="search">
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
                            <th
                                v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                                :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                                style="width: 40%; cursor:pointer;"
                            >
                            {{column.label}}
                            </th>
                            <th style="width: 40%; cursor:pointer;" >Edit/Delete</th>
                        </tr>
                        <tr
                            v-for="(module, index) in filteredUsers"
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
        let sortOrders = {};
        let columns = [
            {label: 'Module', name: 'Nom_Mod', type: 'string'  },
            {label: 'Abbreviation', name: 'Abrv_Mod', type: 'string'},
        ];
        columns.forEach((column) => {
            sortOrders[column.name] = 1;
        });
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
            buttonHovered: false,

            columns: columns,
            sortKey: 'Nom_Mod',
            sortOrders: sortOrders,
            search: '',
            tableShow: {
                showdata: true,
            },
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
        },

        sortBy(key) {
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },

    },


    computed: {
        filteredUsers() {
            let modules = this.modules;
            if (this.search) {
                modules = modules.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                });
            }
            let sortKey = this.sortKey;
            let order = this.sortOrders[sortKey] || 1;
            if (sortKey) {
                modules = modules.slice().sort((a, b) => {
                    let index = this.getIndex(this.columns, 'name', sortKey);
                    a = String(a[sortKey]).toLowerCase();
                    b = String(b[sortKey]).toLowerCase();
                    if (this.columns[index].type && this.columns[index].type === 'date') {
                        return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
                    } else if (this.columns[index].type && this.columns[index].type === 'number') {
                        return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
                    } else {
                        return (a === b ? 0 : a > b ? 1 : -1) * order;
                    }
                });
            }
            return modules;
        },
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
    margin: 10px 5vw;
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
    width: 100%;
    padding-left: 30px;
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
    text-align: left;
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

.sorting {
    background-image: url('../../assets/sort_both.png');
    background-repeat: no-repeat;
    background-position: center left;
}
.sorting_asc {
    background-image: url('../../assets/sort_asc.png');
    background-repeat: no-repeat;
    background-position: center left;
}
.sorting_desc {
    background-image: url('../../assets/sort_desc.png');
    background-repeat: no-repeat;
    background-position: center left;
}

</style>
