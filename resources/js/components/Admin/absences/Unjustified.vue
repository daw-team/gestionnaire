<template>
    <div class="abs-container">

        <div class="the-table">
            <div class="table-container">
                <table>
                    <tr class="table-header">
                        <th>Student</th>
                        <th>Module</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                    <tr
                        v-for="(absence, index) in absences"
                        :key="index"
                        class="absence"
                    >

                        <td>
                            <p>{{ absence.Prenom_Etud }} {{ absence.Nom_Etud }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Abrv_Mod }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Date_Abs }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Hour_Abs }}</p>
                        </td>

                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data() {
        return {
            absences:[],
        }
    },

    mounted() {

        axios
            .get('http://localhost:8000/api/unjustifiedAbsences')
            .then(response => {
                console.log(response.data);
                this.absences = response.data ;
            })
    },

    methods: {

    },
}
</script>

<style scoped>

.abs-container{
    padding-top: 40px;
    margin: 0 5vw;
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
