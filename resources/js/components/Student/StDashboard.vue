<template>
    <div class="dashboard">
        <StSideBar></StSideBar>
        <StHome></StHome>
    </div>
</template>

<script>
import StSideBar from './StSideBar.vue'
import StHome from './StHome.vue'

export default {
    components:{
        StSideBar,
        StHome
    }
}

</script>

<style scoped>

.dashboard{
    height: 100vh;
    width: 100%;
}

</style>
