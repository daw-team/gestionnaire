<template>
    <div class="grid">

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
        <div class="grid-container">
            <div
                class="card"
                v-for="(module, index) in modules" :key="index"
            >
                <div class="row-one">
                    <div class="left">
                        <h1>{{ module.Abrv_mod }}</h1>
                        <p>{{ module.Nom_Mod }}</p>
                    </div>
                    <div class="right">
                        <img :src="getImageUrl(module.Abrv_mod)" alt="">
                    </div>
                </div>
                <div class="row-two">
                    <p>Enseignant: {{ module.Nom_Ens }} {{ module.Prenom_Ens }}</p>
                    <p>Coefficient: {{ module.Coeff_Mod }}</p>
                    <p>Credit: {{ module.Credit_Mod }}</p>
                </div>
                <!-- <div class="row-three">
                    <p>{{ module.total }}</p>
                    <p>unjustified: {{ module.unjustified }}</p>
                    <p>justified: {{ module.justified }}</p>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import HeaderComp from '../Header.vue'

export default {
    components: {
        HeaderComp,
    },

    data() {
        return {
            user: {
                id: this.$route.params.id,
                nom: '',
                prenom: '',
                username: '',
                currentPassword: '',
                imgSrc: '../../assets/user.png',
            },
            modules: [],
        }
    },

    mounted() {
        axios
            .get('http://localhost:8000/api/AllModules')
            .then( res => {
                this.modules = res.data
            })

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

        // axios
        //     .post('http://localhost:8000/api/AllModulesAbsences', {id:this.$route.params.id})
        //     .then( res => {
        //         // this.modules.forEach(module => {
        //         //     console.log(res.data);
        //         //     res.data.forEach(element => {
        //         //         if(element.Num_Mod === module.Num_Mod){
        //         //             module.unjustified = element.unjustified
        //         //             module.justified = element.justified
        //         //             module.total = element.total
        //         //         }else{
        //         //             module.unjustified = 0
        //         //             module.justified = 0
        //         //             module.total = 0
        //         //         }

        //         //     });
        //         // });
        //         console.log(res.data);
        //         this.modules = res.data
        //     })
    },

    setup() {
    const getImageUrl = (name) => {
        name = `../../assets/` + name + ".png"
        return new URL(name, import.meta.url).href
    }

    const getProfileUrl = (name) => {
        return new URL(name, import.meta.url).href
    }

    return { getImageUrl, getProfileUrl }
    }
}
</script>

<style scoped>

.grid{
    width: 95%;
    margin: auto;
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

.grid-container{
    width: 100%;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    justify-content: space-around;
    grid-gap: 20px;
    align-items: center;
    margin-top: 20px;
}

.card{
    width: calc(100% - 40px);
    height: 300px;
    background-color: #fcfcfc;
    box-shadow: rgb(94 94 94) 5px 5px 10px;
    padding: 15px 20px;
    border-radius: 15px;
    display: flex;
    flex-direction: column;
    margin-left: auto;
    position: relative;
}

.row-one{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    height: 50%;
}

.right{
    padding: 20px;
    width: auto;
    height: calc(100% - 40px);
}

.left{
    padding: 20px;
}

.left h1{
    font-size: 50px;
}

.left p {
    color: #979797;
    font-weight: 700;
}


.right img{
    width: auto;
    height: 100%;
}

.row-two{
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}

.row-three{
    display: flex;
    flex-direction: row;
    color: #830000;
}

</style>
