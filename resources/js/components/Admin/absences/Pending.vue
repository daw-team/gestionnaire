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
                        <th>Justification</th>
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

                        <td>
                            <p>View Justification</p>
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
            .get('http://localhost:8000/api/pendingAbsences')
            .then(response => this.absences = response.data )
    },
}

</script>



<style scoped>
.abs-container{
    padding-top: 10px;
    margin: 0 5vw;
}


.the-table{
    width: 100%;
    height: 450px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 450px;
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
    height: 450px;
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
