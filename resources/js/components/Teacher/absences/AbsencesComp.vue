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
                <select v-model="absenceType" @change="dateChanged">
                    <option
                        v-for="(item , index) in compsList"
                        :key="index"
                        :value="item.comp"
                    >
                        {{ item.title }}
                    </option>
                </select>
            </div>

            <input type="text" v-model="search" placeholder="Search for a student">

        </div>
        <div class="the-table" v-if="absences.length !== 0">
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
                        <th
                            style="width: 40%; cursor:pointer;"
                            v-if="absenceType === 'PenAbsencesEns' || absenceType === 'acceptedAbsences' "
                        >
                            justification
                        </th>
                        <th
                            style="width: 40%; cursor:pointer;"
                            v-if="absenceType === 'PenAbsencesEns'"
                        ></th>
                        <th
                            style="width: 40%; cursor:pointer;"
                            v-if="absenceType === 'NonJusAbsences'"
                        >
                            Delete
                        </th>
                    </tr>
                    <tr
                        v-for="(absence, index) in filteredUsers"
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

                        <td v-if="absenceType === 'PenAbsencesEns' || absenceType === 'acceptedAbsences' ">
                            <p
                                @click="showJustification(absence.Num_Abs)"
                                class="justify"
                            >View Justification</p>
                        </td>

                        <td v-if="absenceType === 'PenAbsencesEns'">
                            <div>
                                <img
                                    src="../../../assets/accept.png"
                                    class="edit-img"
                                    name="checkmark-done-circle-outline"
                                    @click="acceptJustification(absence.Num_Abs)"
                                >&nbsp;&nbsp;&nbsp;&nbsp;
                                <img
                                    src="../../../assets/reject.png"
                                    class="edit-img"
                                    name="close-circle-outline"
                                    @click="refuseJustification(absence.Num_Abs)"
                                >
                                </div>
                        </td>

                        <td v-if="absenceType === 'NonJusAbsences'">
                            <img src="../../../assets/delete.png" alt="" @click="deleteAbsence(absence.Num_Abs)">
                        </td>

                    </tr>
                </table>
            </div>
        </div>

        <component
            :is="compActive"
            :compToActive="compActive"
            :idAbs="absenceId"
            @compDesactive="compActive = $event"
        ></component>

    </div>
</template>



<script>
import justificationComp from '../TcViewJustification.vue'

export default {

    components:{
        justificationComp
    },

    data() {
        let sortOrders = {};
        let columns = [
            {label: 'First name', name: 'Prenom_Etud', type: 'string'  },
            {label: 'Family name', name: 'Nom_Etud', type: 'string'},
            {label: 'Date', name: 'Date_Abs', type: 'date'},
            {label: 'Time', name: 'Hour_Abs', type: 'number'},
        ];
        columns.forEach((column) => {
            sortOrders[column.name] = -1;
        });
        return {
            absences:[],
            dates: [],
            dateSelected: 'all time',
            absenceType: 'NonJusAbsences',
            compsList: [
                {title: 'Unjustified', comp: 'NonJusAbsences'},
                {title: 'Pending', comp: 'PenAbsencesEns'},
                {title: 'Accepted', comp: 'acceptedAbsences'},
            ],
            compActive: '',
            absenceId: null,

            columns: columns,
            sortKey: 'Date_Abs',
            sortOrders: sortOrders,
            search: '',
            tableShow: {
                showdata: true,
            },
        }
    },

    mounted() {
        this.dateChanged()

        axios
            .post('http://localhost:8000/api/absentDate', { id: this.$route.params.id})
            .then(response => this.dates = response.data )
    },

    methods: {

        dateChanged(){
            if(this.dateSelected === 'all time'){
            axios
                .post('http://localhost:8000/api/getAll' + this.absenceType, { id: this.$route.params.id } )
                .then(response => this.absences = response.data )
        }
        else{
            axios
                .post('http://localhost:8000/api/get' + this.absenceType , { id: this.$route.params.id, date: this.dateSelected})
                .then(response => this.absences = response.data )
        }
        },

        deleteAbsence(id){
            this.$swal.fire({
                title: 'Are you sure you want to delete this absence?',
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
                        .delete('http://localhost:8000/api/deleteAbs', { data:{ id: id } })
                        .then(() => this.$router.go(0))

                    this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Absence Deleted!',
                    showConfirmButton: false,
                    timer: 2500
                    })
                }
            })
        },

        showJustification(id){
            this.absenceId = id
            this.compActive = 'justificationComp'
        },

        acceptJustification(id){
            this.$swal.fire({
                title: 'Are you sure you want to accept this absence?',
                text: "You won't be able to revert this!",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post('http://localhost:8000/api/acceptJust', { id: id })
                        .then( res => {
                            if(res.data.msg === 'absence accepted'){
                                this.$swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Absence accepted successfully',
                                showConfirmButton: false,
                                timer: 2500
                                })
                                this.$router.go(-1);
                            }
                        })
                }
            })
        },

        refuseJustification(id){
            this.$swal.fire({
                title: 'Are you sure you want to refuse this absence?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, refuse it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post('http://localhost:8000/api/rejectJust', { id: id })
                        .then( res => {
                            if(res.data.msg === 'absence rejected'){
                                this.$swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Absence accepted successfully',
                                showConfirmButton: false,
                                timer: 2500
                                })
                                this.$router.go(-1);
                            }
                        })
                }
            })

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
            let absences = this.absences;
            if (this.search) {
                absences = absences.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                });
            }
            let sortKey = this.sortKey;
            let order = this.sortOrders[sortKey] || 1;
            if (sortKey) {
                absences = absences.slice().sort((a, b) => {
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
            return absences;
        },
    }
}

</script>



<style scoped>
.abs-container{
    padding: 20px 2vw;
    margin: 20px;
    background: #ffffff;
    border-radius: 15px;
}

.selects{
    width: 100%;
    min-width: 350px;
    display: flex;
    flex-direction: row;
    height: auto;
    flex-wrap: wrap;
    justify-content: space-between;
    align-content: space-around;
}

.selects > *{
    margin: 20px 0;
}

label {
    color: #032011;
    font-weight: 500;
}

select{
    margin-right: 25px;
    margin-left: 7px;
    width: 130px;
    padding: 5px 15px;
    height: 38px;
    font-weight: 700;
    border-radius: 15px;
    border: #0000003c solid 1px;
    border-radius: 8px;
    font-size: 14px;
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
    width: 100%;
    padding-left: 30px;
}

.table-header{
    position: sticky;
    top: 0;
    height: 40px;
    background: linear-gradient(180deg, #499564, #2a719e);
    color: #fff;
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

.edit-img{
    width: 35px;
}

.accept{
    color: #499372;
}

.refuse{
    color: crimson;
}

.absence{
    margin: auto;
    height: 70px;
    background-color: #f8fdfb;
    color: #595959;
    margin-bottom: 10px;
    font-weight: 500;
}

input[ type = 'text']{
    width: 180px;
    padding: 5px 15px;
    height: 28px;
    border-radius: 15px;
    border: #0000003c solid 1px;
    border-radius: 8px;
    font-size: 14px;
    margin-bottom: 20px;
}

.justify{
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 700;
    cursor: pointer;
}

.justify:hover{
    background-image: linear-gradient(180deg, #0d7336, #1d4081);
    -webkit-background-clip: text;
    color: transparent;
}

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

.sorting {
    background-image: url('../../../assets/sort_both.png');
    background-repeat: no-repeat;
    background-position: center left;
}
.sorting_asc {
    background-image: url('../../../assets/sort_asc.png');
    background-repeat: no-repeat;
    background-position: center left;
}
.sorting_desc {
    background-image: url('../../../assets/sort_desc.png');
    background-repeat: no-repeat;
    background-position: center left;
}

</style>
