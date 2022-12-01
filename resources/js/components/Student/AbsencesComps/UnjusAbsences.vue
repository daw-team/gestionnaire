<template>
    <div class="abs-container">

        <div class="the-table">
            <div class="table-container">
                <table>
                    <tr class="table-header">
                        <th>Module</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Justify</th>
                    </tr>
                    <tr
                        v-for="(absence, index) in absences"
                        :key="index"
                        class="absence"
                    >
                        <td>
                            <p>{{ absence.Abrv_Mod }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Date_Abs }}</p>
                        </td>

                        <td>
                            <p>{{ absence.Hour_Abs }}</p>
                        </td>

                        <td><button @click="showForm(absence.Num_Abs)">Justify</button></td>

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
            log: { id: this.$route.params.id},
            absences:[],
        }
    },

    mounted() {

        axios
            .post('http://localhost:8000/api/nonJusAbsences', this.log)
            .then(response => {
                this.absences = response.data ;
            })
    },

    methods: {
        showForm(num) {
            this.$router.push(this.$route.fullPath + '/num=' + num)
        }
    },
}
</script>

<style scoped>

.abs-container{
    padding-top: 50px;
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
    width: 100%;
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

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

</style>
