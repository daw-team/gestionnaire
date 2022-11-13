<template>
    <div>
        <div class="title">
            <h1>Abcenses</h1>
            <p>You can find all the abcenses on this list </p>
            <input type="text"  placeholder="Search for a student">
        </div>
        <div
            v-for="(absence, index) in absences"
            :key="index"
            class="absences">
            <p>{{ absence.Abrv_mod }}</p>
            <p>{{ absence.Date_Abs }}</p>
            <button @click="showForm(absence.Num_Abs)">Justify</button>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
import JustifyForm from './AbsencesComps/JustifyForm.vue'

export default {
    components:{
        JustifyForm,
    },
    data() {
        return {
            log: { id: this.$route.params.id},
            absences:[]
        }
    },

    mounted() {

        axios
            .post('http://localhost:8000/api/absences', this.log)
            .then(response => {
                console.log(response.data);
                this.absences = response.data ;
            })
    },

    methods: {
        showForm(num) {
            console.log(this.$route.fullPath);
            this.$router.push(this.$route.fullPath + '/num=' + num)
        }
    },
}
</script>


<style scoped>

.title {
    margin: 50px 0 50px 120px;
    height: 150px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.title p{
    margin-bottom: auto;
}

.title input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #00000079 solid 1px;
    border-radius: 20px;
    background-color: rgba(255, 255, 255, 0.174);
    font-size: 14px;
}

.absences{
    padding: 5px 15px;
    margin: auto;
    width: 60%;
    height: 70px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    background-color: #0000000e;
}

button{
    border-left: none;
    border-top: none;
    width: 100px;
    height: 30px;
    background: #fff;
    box-shadow: 1px 1px 3px #000;
    color: #305748;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    font-size: 15px;
}

button:hover{
    border: 1px;
    box-shadow: none;
    transition: ease all .4s;
}

</style>
