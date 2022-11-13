<template>
    <div
        class="home"
        :class="{'small-home':menuChange}"
    >
        <div    class="background">
            <div class="account">
                <div class="left">
                    <input type="text" name="search" value="Search ...">
                </div>
                <div class="right">
                    <ion-icon name="notifications-outline"></ion-icon>
                    <img src="../../assets/user.png" alt="" @click="showProfileCard = !showProfileCard">
                    <h3>John Snow</h3>
                </div>
            </div>
        </div>

        <div
            class="profile-card"
            v-if="showProfileCard"
        >
            <img src="../../assets/user.png" alt="">
            <h3>John Snow</h3>
            <div class="info">

            </div>
            <button>Logout</button>
        </div>

        <div class="cards">
            <div class="card">
                <div class="row-one">
                    <div>
                        <h5>TOTAL ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/absences.png" alt="">
                </div>
                <div class="row-two">
                    <button>CHECK <ion-icon name="chevron-forward-outline"></ion-icon> </button>
                </div>
            </div>

            <div class="card">
                <div class="row-one">
                    <div>
                        <h5>PENDING ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/pending.png" alt="">
                </div>
                <div class="row-two">
                    <button>CHECK <ion-icon name="chevron-forward-outline"></ion-icon> </button>
                </div>
            </div>

            <div class="card">
                <div class="row-one">
                    <div>
                        <h5>JUSTIFIED ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/accepted.png" alt="">
                </div>
                <div class="row-two">
                    <button>CHECK <ion-icon name="chevron-forward-outline"></ion-icon> </button>
                </div>
            </div>

            <div class="card"
                :class="{'card-4':menuChange}"
            >
                <div class="row-one">
                    <div>
                        <h5>HEIGHEST MODEL</h5>
                        <span>DAW</span>
                    </div>
                    <img src="../../assets/module.png" alt="">
                </div>
                <div class="row-two">
                    <button>CHECK <ion-icon name="chevron-forward-outline"></ion-icon> </button>
                </div>
            </div>


            <div class="card" id="absences">
                <h5>ABSENCES:</h5>
                <div
                    v-for="(item, index) in absences"
                    :key="index"

                >
                    <div class="absence">
                        <p>{{ item.module }}</p>
                        <p>{{ item.date }}</p>
                    </div>
                    <hr>
                </div>
            </div>


            <div class="card contact"
                :class="{'.contact-2': menuChange}"
            >
                <h5>SEND EMAIL</h5>
                <div
                    v-for="(contact, index) in contacts"
                    :key="index"

                >
                    <div class="teacher">
                        <div>
                            <p>{{ contact.name }}</p>
                            <span>{{ contact.module }}</span>
                        </div>
                        <a :href="`mailto:${contact.email}`"><ion-icon class="mail-icon" name="mail-outline"></ion-icon></a>
                    </div>
                    <hr>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import bus from '../../EventBus'

export default {
    data() {
        return {
            menuChange: false,
            showProfileCard: false,
            absences:[
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'}
            ],
            contacts:[
                {name: 'Yamane Houfani', module: 'TEC', email: 'yamane.houfani@univ-constantine2.dz'},
                {name: 'Yamane Houfani', module: 'TEC', email: 'yamane.houfani@univ-constantine2.dz'},
                {name: 'Yamane Houfani', module: 'TEC', email: 'yamane.houfani@univ-constantine2.dz'},
                {name: 'Yamane Houfani', module: 'TEC', email: 'yamane.houfani@univ-constantine2.dz'},
            ]
        }
    },

    created() {
        bus.$on('changeMenu', (value) => {
            this.menuChange = value;
        })
    }
}


</script>


<style scoped>
.home{
    width: calc(100% - 70px) ! important;
    padding-left: 70px;
    min-height: 300px;
    padding-bottom: 40px;
    overflow: hidden;
    transition: all ease .5s;
}

.small-home {
    width: calc(100% - 260px) ! important;
    padding-left: 260px;


}

input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #ffffff79 solid 1px;
    color: #fff;
    border-radius: 20px;
    background-color: rgba(255, 255, 255, 0.174);
    font-size: 14px;
}

.background{
    width: 100%;
    height: 150px;
    /* background-color: #2c4eb4; */
      background: linear-gradient(70deg, #2c4eb4, #305748);
    /* #008828 */
    left: 0;
    z-index: 0;

}

.profile-card{
    position: absolute;
    top: 70px;
    right: 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 300px;
    height: 500px;
    background: #dcd9d9;
}

.profile-card img{
    width: auto;
    height: 65px;
    margin-top: auto;
}

.profile-card h3{
    margin-bottom: auto;
}

.profile-card button {
    margin-bottom: auto;
}

.account {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    align-items: center;
    margin-right: 30px;
    color: #fff;
    font-size: 15px;
    padding-top: 20px;
}

.account img {
    width: auto;
    height: 50px;
}

.account h3 {
    margin-left: 8px;
}

.right{
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    align-items: center;
}
.left{
    margin-left: 150px;
}

.cards {
    margin-top: -30px;
    display: grid;
    grid-gap: 20px;
    grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));
    justify-content: space-around;
    flex-wrap: wrap;
    width: 100%;
    max-height: 900px;
    grid-row-gap: 50px;
    z-index: 2;
}
.card{
    min-width: 250px;
    margin: 0 30px;
    width: auto;
    height: 100px;
    background-color: #fff;
    box-shadow: 5px 5px 10px rgb(94, 94, 94);
    border-radius: 5px;
    padding: 15px 20px;
}

.row-one {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}

.row-one img {
    height: 70px;
    width: auto;
}

 h5 {
    color: gray;
    font-weight: 900;
    margin-bottom: 10px;
    font-size: 13px;
}

.row-one span {
    font-size: 30px;
    font-weight: 700;
}

.row-two{
    margin-top: 8px;
}

.row-two button{
    border-right: #000;
    border-bottom: #000;
    border-left: none;
    border-top: none;
    display: flex;
    justify-content: end;
    align-items: center;
    width: 100px;
    height: 30px;
    background: #fff;
    color: #305748;
    border-radius: 5px;
    font-weight: 600;

}

.row-two button:hover{
    width: 260px;
    cursor: pointer;
    box-shadow: 2px 2px 2px #0000003f;
    border-radius: 2px;
    transition: all ease .3s;
}

.row-two ion-icon{
    color: #305748;

}

#absences{
    height: auto;
    grid-column: span 2;
}

.absence{
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin: 10px 0;
    padding: 5px 15px;
    cursor: pointer;
}

.absence:hover{
    box-shadow: 3px 3px 8px rgb(94, 94, 94);
    border-radius: 0px;
    /* background: rgba(0, 0, 0, 0); */
    background: rgba(0, 0, 0, 0.1);

    transition: all ease .4s;
}

ion-icon{
    color: #fff;
    margin-right: 30px;
    font-size: 25px;
    contain: inherit;

}

.card-4{
    grid-column: span 3;
}

@media (max-width: 1400px) {
    .cards :nth-child(4){
        grid-column: 1/ -1;
    }
    .contact{
        grid-column: 1/2 !important;
    }
}

@media (max-width: 800px) {
    #absences{
        grid-column-start: 1;
        grid-column-end: 2;
    }
}

.contact{
    height: auto;
    grid-column: 3/5;
    justify-self: center;
    min-width: 300px;
}

.contact-2{
    grid-column: span 1 !important;
    grid-row: 3;
}

.mail-icon{
    color: #000;
    font-size: 40px;
}

.teacher{
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin: 10px 0;
    padding: 5px 15px;
    cursor: pointer;
    border-radius: 8px;
}

.teacher span{
    color: gray;
    font-weight: 900;
    font-size: 13px;
}
</style>
