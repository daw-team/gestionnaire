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
                            v-if="compToRender === 'PenAbsencesEns' || compToRender === 'acceptedAbsences' "
                        >
                            justification
                        </th>
                        <th style="width: 40%; cursor:pointer;">
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

                        <td v-if="compToRender === 'PenAbsencesEns' || compToRender === 'acceptedAbsences' ">
                            <a :href="`/teacher=${$route.params.id}/dashboard/absences/justification=${absence.Num_Abs}`"><p>View Justification</p></a>
                        </td>
                        <td>
                            <img src="../../../assets/delete.png" alt="" @click="deleteAbsence(absence.Num_Abs)">
                        </td>

                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>



<script>


export default {

    components:{
    },

    data() {
        let sortOrders = {};
        let columns = [
            {label: 'Family name', name: 'Prenom_Etud', type: 'string'  },
            {label: 'First name', name: 'Nom_Etud', type: 'string'},
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
            compToRender: 'NonJusAbsences',
            compsList: [
                {title: 'Unjustified', comp: 'NonJusAbsences'},
                {title: 'Pending', comp: 'PenAbsencesEns'},
                {title: 'Accepted', comp: 'acceptedAbsences'},
            ],
            columns: columns,
            sortKey: 'Date_Abs',
            sortOrders: sortOrders,
            length: 10,
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
                .post('http://localhost:8000/api/getAll' + this.compToRender, { id: this.$route.params.id } )
                .then(response => this.absences = response.data )
        }
        else{
            axios
                .post('http://localhost:8000/api/get' + this.compToRender , { id: this.$route.params.id, date: this.dateSelected})
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
    padding-top: 10px;
    margin: 0 5vw;
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
    margin-bottom: 20px;
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

a{
    text-decoration: none;
}

a p{
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
    font-weight: 700;
}

a p:hover{
    background-image: linear-gradient(180deg, #0d7336, #1d4081);
    -webkit-background-clip: text;
    color: transparent;
}

a:visited{
    text-decoration: none;

}

@media (max-width: 1425px) {
    table{
        width: 1200px
    }
}

.sorting {
    background-image: url('../../../assets/sort_both.png');
    background-repeat: no-repeat;
    background-position: center right;
}
.sorting_asc {
    background-image: url('../../../assets/sort_asc.png');
    background-repeat: no-repeat;
    background-position: center right;
}
.sorting_desc {
    background-image: url('../../../assets/sort_desc.png');
    background-repeat: no-repeat;
    background-position: center right;
}

</style>
