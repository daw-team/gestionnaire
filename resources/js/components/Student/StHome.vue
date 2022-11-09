<template>
    <div
        class="home"
        :class="{'small-home':menuChange}"
    >
        <div    class="background">
            <div class="account">
                <img src="../../assets/user.png" alt="">
                <h3>John Snow</h3>
            </div>
        </div>
        <div class="cards">
            <div class="card total-absences">
                <div class="row-one">
                    <div>
                        <h5>TOTAL ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/absences.png" alt="">
                </div>
                <div class="row-two">
                    <span>+5</span>
                    <span>Since last month</span>
                </div>
            </div>

            <div class="card total-absences">
                <div class="row-one">
                    <div>
                        <h5>PENDING ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/pending.png" alt="">
                </div>
                <div class="row-two">
                    <span>+5</span>
                    <span>Since last month</span>
                </div>
            </div>

            <div class="card total-absences">
                <div class="row-one">
                    <div>
                        <h5>JUSTIFIED ABSENCES</h5>
                        <span>5</span>
                    </div>
                    <img src="../../assets/accepted.png" alt="">
                </div>
                <div class="row-two">
                    <span>+5</span>
                    <span>Since last month</span>
                </div>
            </div>

            <div class="card total-absences">
                <div class="row-one">
                    <div>
                        <h5>HEIGHEST MODEL ABSENCES</h5>
                        <span>DAW</span>
                    </div>
                    <img src="../../assets/module.png" alt="">
                </div>
                <div class="row-two">
                    <span>+5</span>
                    <span>Since last month</span>
                </div>
            </div>

            <div class="card" id="absences">
                <h5>Abcenses:</h5>
                <div
                    v-for="(item, index) in absences"
                    :key="index"
                    class="absence"
                >
                    <p>{{ item.module }}</p>
                    <p>{{ item.date }}</p>
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
            absences:[
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'},
                {module: 'daw', date: '14/21/2021'}
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
    width: calc(100% - 100px) ! important;
    padding-left: 100px;
    min-height: 300px;
    padding-bottom: 40px;
    overflow: hidden;
}

.small-home {
    width: calc(100% - 280px) ! important;
    padding-left: 280px;
}

.background{
    width: 100%;
    height: 150px;
    /* background-color: #2c4eb4; */
      background: linear-gradient(70deg, #2c4eb4, #305748);
    /* #008828 */
    position: absolute;
    left: 0;
    z-index: -1;

}

.account {
    display: flex;
    justify-content: flex-end;
    flex-direction: row;
    align-items: center;
    margin-right: 30px;
    color: #fff;
    font-size: 15px;
    margin-top: 10px;
}

.account img {
    width: auto;
    height: 50px;
}

.account h3 {
    margin-left: 8px;
}

.cards {
    padding-top: 100px;
    /* display: flex; */
    display: grid;
    grid-gap: 20px;
    grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));
    justify-content: space-around;
    flex-wrap: wrap;
    width: 100%;
    max-height: 900px;
}
.card{
    /* min-width: 200px; */
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

}

.row-one span {
    font-size: 30px;
    font-weight: 700;
}

.row-two{
    margin-top: 8px;
}

.row-two :nth-child(1){
    margin: 0 10px;
    color: #ff0000;
    font-weight: 400;
}

#absences{
    height: auto;
    grid-column-start: 2;
  grid-column-end: 4;
}

.absence{
    height: 50px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    padding: 5px 15px;
    background: rgba(0, 0, 0, 0.232);
    cursor: pointer;
    border-radius: 8px;

}
.absence:hover{
    box-shadow: 3px 3px 8px rgb(94, 94, 94);
    border-radius: 0px;
    background: rgba(0, 0, 0, 0);
    transition: all ease .4s;
}

@media (max-width: 800px) {
    #absences{
        grid-column-start: 1;
        grid-column-end: 2;
    }
}

</style>
