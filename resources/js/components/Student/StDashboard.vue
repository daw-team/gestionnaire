<template>
    <div class="home">
        <StSideBar></StSideBar>
        <div    class="background">
            hi
        </div>
    </div>
</template>

<script>
import StSideBar from './StSideBar.vue'
export default {
    components:{
        StSideBar
    }
}

</script>

<style scoped>

.home{
    height: 100vh;
    width: 70%;
}
.background{
    width: 100%;
    height: 40%;
    background-color: #2c4eb4;
}
</style>
