<template>
    <div class="new-container">
        <div class="groups">
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
                                <input type="checkbox" :value="student.Num_Etud" v-model="newAbsence.ids" >
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

            <form
            action=""
            method="POST"
            >
                <h3>New absence informations:</h3>
                <div class="date" :class="{'add-desabled': newAbsence.ids.length == 0}">
                    <label for="">Date:</label>
                    <input type="date" v-model="newAbsence.date" >
                </div>

                <div class="from" :class="{'add-desabled': newAbsence.ids.length == 0}">
                    <label for="">From:</label>
                    <input type="time" v-model="timeFrom">
                </div>

                <div class="to" :class="{'add-desabled': newAbsence.ids.length == 0}">
                    <label for="">To:</label>
                    <input type="time" v-model="timeTo">
                </div>

                <input
                    type="submit"
                    class="create"
                    :class="{'create-desabled': newAbsence.ids.length == 0}"
                    value="create new absence"
                    @click.prevent="create"
                >

                <p>{{ msg }}</p>

            </form>

            <!-- <div

                :class="{'add-desabled': ids.length == 0}"
                @click="goToAddPage"
            >
                <ion-icon name="add-outline"></ion-icon>
                <transition name="appear">
                    <h3>New teacher</h3>
                </transition>
            </div> -->


    </div>
</template>

<script>

export default {

    data() {

        return {
            groupSelected: 'all groups',
            groups: [],
            students: [],
            timeFrom: '',
            timeTo: '',
            msg: '',
            newAbsence: {
                num_ens: this.$route.params.id,
                num_module: '',
                "ids": [],
                date: '',
                hour: ''
            }

        }
    },

    mounted() {
        axios
            .get('http://localhost:8000/api/groupsList')
            .then( res => this.groups = res.data )

        axios
            .post('http://localhost:8000/api/TeacherInfo', {id:this.$route.params.id})
            .then( res => {
                this.newAbsence.num_module = res.data[0].Num_Mod
            })

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

        create(){
            this.newAbsence.hour = `${this.timeFrom} - ${this.timeTo}`

            if(this.checkForEmptyFields() || this.timeFrom === '' || this.timeTo === ''){

                this.$swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'You cannot leave empty fields',
                showConfirmButton: false,
                timer: 3500
                })
            }
            else{
                console.log(this.newAbsence);
                axios
                    .post('http://localhost:8000/api/createAbs', this.newAbsence)
                    .then( res => {
                        if( res.data.msg === 'information inserted successfuly' ) {
                        this.$swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Absences created successfully',
                        showConfirmButton: false,
                        timer: 3500
                        })
                    }else{
                        this.$swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'something went wrong ..please try again later',
                        showConfirmButton: false,
                        timer: 3500
                        })
                    }
                    })
            }

        },

        checkForEmptyFields(){
            let check = false;
            Object.keys(this.newAbsence).forEach( element => {
                if( this.newAbsence[element] === '' ) {
                    console.log(element);
                    check = true
                }
            })
            return check
        },

        sortBy(key) {
            this.resetPagination();
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },
    },
}
</script>

<style scoped>
.new-container{
    margin: 0 5vw;
    transition: all ease .5s;
}

.groups{
    float: right;
}

label {
    font-weight: 500;
}

select{
    margin: 10px;
    width: 130px;
    padding: 5px 15px;
    height: 38px;
    font-weight: 700;
    border-radius: 15px;
    border: #0000003c solid 1px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
    margin-top: 0;
}

.the-table{
    width: 100%;
    height: 350px;
    overflow: hidden;
}

.table-container{
    width: 100%;
    min-width: 350px;
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
    height: 350px;
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
}

.add-desabled{
    color: #bababa !important;
    box-shadow: none !important;
    pointer-events: none;
    transition: all ease .3s;
}

.add-desabled input{
    border: #0000003c solid 1px !important;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
    color: #bababa !important;
    border-radius: 15px !important;
    transition: all ease .3s;
}

form{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}

form p{
    width: 100%;
    text-align: center;
    font-weight: 500;
    color: #ff0000;
}

.date, .to, .from{
    transition: all ease .3s;
}

form  h3{
    width: 100%;
    margin: 20px 0 10px 0 !important;
}

form > * {
    margin: 0 10px 10px 10px;
}

input[ type = 'date']{
    width: 180px;
    padding: 5px 10px;
    margin: 0 10px;
    border-radius: 0;
    border-bottom: #000 1px solid;
    border-top: none;
    border-left: none;
    border-right: none;
    font-size: 18px;
    text-align: center;
    transition: all ease .3s;
}

input[ type = 'time'] {
    width: 100px;
    padding: 5px 10px;
    margin: 0 10px;
    border-radius: 0;
    border-bottom: #000 1px solid;
    border-top: none;
    border-left: none;
    border-right: none;
    font-size: 18px;
    text-align: center;
    transition: all ease .3s;
}

.create{
    width: 200px;
    height: 50px;
    border: none;
    box-shadow: 2px 2px 10px #000;
    display: flex;
    align-items: center;
    justify-content: space-around;
    flex-direction: row;
    color: #fff;
    cursor: pointer;
    border-radius: 15px;
    background: linear-gradient(-70deg, #1f3782, #027224);
    font-size: 15px;
    font-weight: 600;
    transition: all ease .3s;
}

.create-desabled{
    background: #ececec;
    color: #8d8d8d !important;
    box-shadow: none;
    transition: all ease .3s;

}

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

</style>
