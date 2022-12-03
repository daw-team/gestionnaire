<template>
    <div class="abs-container">

        <input type="text"  placeholder="Search for a student" v-model="search">

        <div class="the-table">
            <div class="table-container">
                <table>
                    <tr class="table-header">
                        <!-- <th>Module</th>
                        <th>Date</th>
                        <th>Time</th> -->
                        <th
                            v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                            :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                            style="width: 40%; cursor:pointer;"
                        >
                            {{column.label}}
                        </th>
                        <th style="width: 40%; cursor:pointer;" >Upload</th>
                    </tr>
                    <tr
                        v-for="(absence, index) in filteredUsers"
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

                        <td><button @click="showForm(absence.Num_Abs)">Justification</button></td>

                    </tr>
                </table>
            </div>
        </div>

    </div>
</template>

<script>

export default {

    data() {
        let sortOrders = {};
        let columns = [
            {label: 'Module', name: 'Abrv_Mod', type: 'string'},
            {label: 'Date', name: 'Date_Abs', type: 'date'},
            {label: 'Time', name: 'Hour_Abs', type: 'number'},
        ];
        columns.forEach((column) => {
            sortOrders[column.name] = 1;
        });
        return {
            log: { id: this.$route.params.id},
            absences:[],

            columns: columns,
            sortKey: 'Abrv_Mod',
            sortOrders: sortOrders,
            search: '',
            tableShow: {
                showdata: true,
            },
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
    padding-top: 50px;
}

.abs-container > input{
    width: 200px;
    height: 12px;
    padding: 10px 20px;
    border: #0000003c solid 1px;
    border-radius: 8px;
    font-size: 14px;
    float: right;
    margin-bottom: 20px;
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
    width: 100%;
    padding-left: 30px;
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
    text-align: left;
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

button{
    width: auto;
    list-style: none;
    font-size: 18px;
    font-weight: 800;
    border: none;
    padding: 5px 20px;
    cursor: pointer;
    border-radius: 5px;
    background-image: linear-gradient(180deg, #0c602e, #1a3972);
    -webkit-background-clip: text;
    color: transparent;
    position: relative;
    transition: all ease .3s;
}

button::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 5px;
  border: 1px solid transparent;
  background: linear-gradient(0deg, #2b5dbb, #14a24d);
  -webkit-mask:
    linear-gradient(#fff 0 0) padding-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
}

button:hover{
    border: #000 solid 1px;
    color: #fff;
    border-radius: 5px;
    background: linear-gradient(180deg, #14a24d, #2b5dbb);
    border: none;
    transition: all ease .3s;
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
