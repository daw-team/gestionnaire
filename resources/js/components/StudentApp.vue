<template>
    <div    class="student">
        <div class="container">
            <div class="welcome">
                <h1>Welcome Mr</h1>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta
                    tempora quibusdam voluptatibus laborum, veritatis eaque veniam modi,
                    natus rerum aliquam laudantium praesentium perferendis,
                    reiciendis nulla officia laboriosam molestiae minima dolorum.</p>
            </div>
            <div class="container-img">
                <img src="../assets/student.png" alt="">
            </div>
        </div>
    </div>
</template>


<script>
export default {

    beforeCreate(){
		axios	
		        .get('http://localhost:8000/api/student')
		        .then(response => {console.log(response.data);
		        if(response.data.msg == 'no sessions') {
                        this.$router.push('/login')
                    }})

}

}
</script>

<style scoped>
.student {
    background: url('../assets/student-backgroup.png') no-repeat center;
    background-size: cover;
    height: 100vh;
    width: 100%;
    text-align: center;
    position: fixed;
}

.container{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    flex-wrap: wrap;
    width: 100%;
    height: 75vh;
    margin-top: 10vw;
}

.welcome {
    height: 100%;
    min-width: 300px;
    width: 30%;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    color: #fff;
}

.welcome h1 {
    margin: 30px 0;
}


.container-img {
    min-width: 300px;
    width: 50%;
    height: 100%;
}

.container-img img {
    width: auto;
    height: 100%;
}
</style>
