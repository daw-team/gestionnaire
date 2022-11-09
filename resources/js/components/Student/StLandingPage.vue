<template>
    <div    class="student">
        <div class="container">
            <div class="welcome">
                <h1>Welcome Mr</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta
                    tempora quibusdam voluptatibus laborum, veritatis eaque veniam modi,
                    natus rerum aliquam laudantium praesentium perferendis,
                    reiciendis nulla officia laboriosam molestiae minima dolorum.
                </p>
                <button class="get-started" @click="goToDashboard">Get started</button>
            </div>
            <div class="container-img">
                <img src="../../assets/student.png" alt="">
            </div>
        </div>
    </div>


</template>


<script>

export default {
    components: {
    },
    methods:{
        goToDashboard() {
            this.$router.push('/student/dashboard')
        }
    }

}
</script>


<style scoped>
.student {
    background: url('../../assets/student-backgroup.png') no-repeat center;
    background-size: cover;
    height: 100vh;
    width: 100%;
    position: fixed;
}

.container{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
    width: 100%;
    height: 75vh;
    margin-top: 7vw;
}

.welcome {
    height: 100%;
    min-width: 300px;
    width: 30%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    align-items: flex-start;
    color: #fff;
}

.welcome h1 {
    font-size: 40px;
    margin-left: 20px;
}

.get-started{
  margin-left: 20px;
  width: 200px;
  height: 50px;
  font-size: 20px;
  font-weight: 700;
  background: linear-gradient(-90deg, #2c4eb477, #00882982) ;
  border: 1px solid;
  border-radius: 30px;
  color: #fff;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.476);
  transition: all ease .7s;
}

.get-started:hover {
  box-shadow: none;
  border: 1px solid #ffffff83;
  background: rgb(44,78, 180);
  transition: all ease .5s;
}


.container-img {
    min-width: 300px;
    width: 45%;
    height: 100%;
}

.container-img img {
    width: auto;
    height: 100%;
}
</style>

