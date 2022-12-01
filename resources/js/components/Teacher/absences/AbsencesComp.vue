<template>
    <div class="abs-container">

        <div class="selects">

            <div class="dates">
                <label for="">Select date:</label>
                <select name="" id="" v-model="dateSelected" @change="dateChanged">
                    <option value="all time">all time</option>
                    <option
                        v-for="(date, index) in dates"
                        :key="index"
                        :value="date.Date_Abs"
                    >
                    {{ date.Date_Abs }}
                    </option>
                </select>
            </div>

            <div class="comps">
                <label for="">Select Absence type:</label>
                <select v-model="compToRender" @change="dateChanged">
                    <option
                        v-for="(item , index) in compsList"
                        :key="index"
                        :value="item.comp"
                    >
                        {{ item.title }}
                    </option>
                </select>
            </div>

        </div>

        <div class="the-table">
            <div class="table-container">
                <table>
                    <tr class="table-header">
                        <th>Family name</th>
                        <th>First name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th v-if="compToRender === 'PenAbsencesEns' || compToRender === 'acceptedAbsences' ">justification</th>
                    </tr>
                    <tr
                        v-for="(absence, index) in absences"
                        :key="index"
                        class="absence"
                    >

                        <td>
                            <p>{{ absence.Prenom_Etud }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Nom_Etud }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Date_Abs }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Hour_Abs }}</p>
                        </td>

                        <td v-if="compToRender === 'PenAbsencesEns' || compToRender === 'acceptedAbsences' ">
                            <a :href="`/teacher=${$route.params.id}/dashboard/absences/justification=${absence.Num_Abs}`"><p>View Justification</p></a>
                        </td>

                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>



<script>

import TcViewJustification from '../TcViewJustification.vue'

export default {

    components:{
        TcViewJustification
    },

    data() {
        return {
            absences:[],
            dates: [],
            dateSelected: 'all time',
            compToRender: 'NonJusAbsences',
            compsList: [
                {title: 'Unjustified', comp: 'NonJusAbsences'},
                {title: 'Pending', comp: 'PenAbsencesEns'},
                {title: 'Accepted', comp: 'acceptedAbsences'},
            ]
        }
    },

    mounted() {
        this.dateChanged()

        axios
            .post('http://localhost:8000/api/absentDate', { id: this.$route.params.id})
            .then(response => this.dates = response.data )
    },

    methods: {
        compChanged(){

        },

        dateChanged(){
            if(this.dateSelected === 'all time'){
            axios
                .post('http://localhost:8000/api/getAll' + this.compToRender, { id: this.$route.params.id } )
                .then(response => this.absences = response.data )
        }
        else{
            axios
                .post('http://localhost:8000/api/get' + this.compToRender , { id: this.$route.params.id, date: this.dateSelected})
                .then(response => this.absences = response.data )
        }
        }
    },
}

</script>



<style scoped>
.abs-container{
    padding-top: 10px;
    margin: 0 5vw;
}

.selects{
    width: 80%;
    min-width: 350px;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin: 20px 0;
}

label {
    color: #032011;
    font-weight: 500;
}

select{
    margin-right: 25px;
    margin-left: 7px;
    width: 120px;
    padding: 5px 15px;
    height: 38px;
    border-radius: 15px;
    border: #75757593 1px solid;
}


.the-table{
    width: 100%;
    height: 368px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 368px;
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
    height: 368px;
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
    background: #fff;
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

.absence{
    margin: auto;
    height: 70px;
    background-color: rgb(201, 201, 201);
    color: #fff;
    margin-bottom: 10px;
    font-weight: 900;
}



@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

</style>
