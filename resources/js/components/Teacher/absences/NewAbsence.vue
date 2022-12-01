<template>
    <div class="new-container">
        <div class="goups">
            <label for="">Select group:</label>
            <select name="" id="" v-model="groupSelected" @change="groupChanged">
                <option value="all groups">all groups</option>
                <option
                    v-for="(group, index) in groups"
                    :key="index"
                    :value="group.Group_Etud"
                >
                {{ group.Group_Etud }}
                </option>
            </select>
        </div>

        <div class="the-table">
                <div class="table-container">
                    <table>
                        <tr class="table-header">
                            <th class="check"><input type="checkbox"> Select all</th>
                            <th>Prenom</th>
                            <th>Nom</th>
                            <th>Groupe</th>
                        </tr>
                        <tr
                            v-for="(student, index) in students"
                            :key="index"
                            class="student"
                        >

                            <td class="check">
                                <input type="checkbox" :value="student.Num_Etud" v-model="ids" @change="addtolist">
                            </td>

                            <td>
                                <p>{{ student.Nom_Etud }}</p>
                            </td>

                            <td>
                                <p>{{ student.Prenom_Etud }}</p>
                            </td>

                            <td>
                                <p>{{ student.Group_Etud }}</p>
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
            groupSelected: 'all groups',
            groups: [],
            students: [],
            ids: []
        }
    },

    mounted() {
        axios
            .get('http://localhost:8000/api/groupsList')
            .then( res => this.groups = res.data )

        this.groupChanged()
    },

    methods: {
        groupChanged(){
            if(this.groupSelected === 'all groups'){
                axios
                    .get('http://localhost:8000/api/studentsList')
                    .then( res => this.students = res.data )
            }
            else{
                axios
                    .post('http://localhost:8000/api/studentsOfGroup', { id: this.groupSelected})
                    .then( res => this.students = res.data )

            }
        },

        addtolist(){
            console.log(this.ids);
        }
    },
}
</script>

<style scoped>
.new-container{
    margin: 0 5vw;
    height: 100vh;
    transition: all ease .5s;

}

label {
    color: #032011;
    font-weight: 500;
}

select{
    margin: 25px 10px;
    width: 120px;
    padding: 5px 15px;
    height: 38px;
    border-radius: 15px;
    border: #75757593 1px solid;
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

.check{
    width: 280px;
    text-align: left;
    padding-left: 20px;
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
.student{
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
