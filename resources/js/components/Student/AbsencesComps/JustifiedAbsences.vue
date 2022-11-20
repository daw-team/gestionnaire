<template>
    <div>

        <div class="column-names">
            <p>Module</p>
            <p>Date and Time</p>
            <p>Justify</p>
        </div>

        <div
            v-for="(absence, index) in absences"
            :key="index"
            class="absences">
            <p>{{ absence.Abrv_mod }}</p>
            <p>{{ absence.Date_Abs }}</p>
        </div>
    </div>
</template>



<script>
export default {
    data() {
        return {
            log: { id: this.$route.params.id},
            absences:[
                {Abrv_mod: 'DAW', Date_Abs: '2022-11-14 00:04:37', Num_Abs: ''},
                {Abrv_mod: 'TEC', Date_Abs: '2022-11-14 00:04:37', Num_Abs: ''},
                {Abrv_mod: 'ACS', Date_Abs: '2022-11-14 00:04:37', Num_Abs: ''},
            ],
        }
    },

    mounted() {

        axios
            .post('http://localhost:8000/api/absences', this.log)
            .then(response => {
                // this.absences = response.data ;
            })
    },
}

</script>



<style scoped>
.column-names{
    padding: 5px 15px;
    font-weight: 500;
    margin: auto;
    width: 60%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.column-names :nth-child(2){
    margin-right: 78px;
}

.column-names :nth-child(3){
    margin-right: 30px;
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
    background-color: rgb(201, 201, 201);
    color: #fff;
    font-weight: 900;
    margin-bottom: 10px;
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
