<template>
    <div class="teachers-list">
        <div class="title">
            <div>
                <h1>List of teachers</h1>
                <p>You can find all the teachers on this list </p>
                <input type="text"  placeholder="Search for a teacher">
            </div>
        </div>

        <table>
            <tr>
                <th>Teacher</th>
                <th>Module</th>
                <th>Edit/Delete</th>
                <th>Email</th>
            </tr>
            <tr
                v-for="(teacher, index) in teachers"
                :key="index"
                class="teacher"
            >
                <td>
                    <p>{{ teacher.Nom_Ens }} {{ teacher.Prenom_Ens }}</p>
                </td>

                <td>
                    <p>{{ teacher.Abrv_mod }}</p>
                </td>

                <td>
                    <div>
                        <img src="../../assets/edit.png" alt="">&nbsp;
                        <img src="../../assets/delete.png" alt="">
                    </div>
                </td>

                <td>
                    <img src="../../assets/mailSend.png" alt="">
                </td>
            </tr>
        </table>
        <div
            class="add"
            @mouseover="buttonHovered = true"
            :class="{'add-expand': buttonHovered}"
            @mouseleave="buttonHovered = false"
        >
            <ion-icon name="add-outline"></ion-icon>
            <transition name="appear">
                <h3 v-if="buttonHovered">New teacher</h3>
            </transition>
        </div>

    </div>
</template>

<script>

export default {
    data() {
        return {
            teachers:[],
            buttonHovered: false
        }
    },

    mounted() {
        axios
            .get('http://localhost:8000/api/AllModules')
            .then( res => {
                console.log(res.data);
                this.teachers = res.data
            })
    },
}

</script>

<style scoped>
.appear-enter{
    opacity: 0;
}

.appear-enter-active{
    transition: opacity 1s;
}


.teachers-list{
    margin: 0 17vw;

}

.title {
    margin: 50px 0;
    height: 200px;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}

.title div{
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}

.title p{
    margin-bottom: auto;
}

.title div input{
    margin-bottom: auto;
}

.title input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #00000079 solid 1px;
    border-radius: 20px;
    background-color: rgb(201 201 201 / 29%);
    font-size: 14px;
}


table{
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}
td{
    text-align: center;
}

td img{
    width: 20px;
    height: auto ;
    cursor: pointer;
}

.teacher{
    padding: 5px 15px;
    margin: auto;
    height: 70px;
    background-color: rgb(201, 201, 201);
    color: #fff;
    margin-bottom: 10px;
    font-weight: 900;
}

.add {
    width: 60px;
    height: 60px;
    position: absolute;
    bottom: 30px;
    right: 30px;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: space-around;
    flex-direction: row;
    transition: all ease .3s;
    color: #fff;
}

.add-expand{
    width: 180px;
    border-radius: 15px;
    background: linear-gradient(-70deg, #1f3782, #027224);
    transition: all ease .3s;
}

ion-icon{
    font-size: 40px;
    color: #fff;
}

</style>
