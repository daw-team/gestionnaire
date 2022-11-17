<template>
    <div class="dashboard">
        <TcSideBar></TcSideBar>
        <router-view></router-view>
    </div>
</template>

<script>
import TcSideBar from './TcSideBar.vue'
import TcHome from './TcHome.vue'
import TcProfile from './TcProfile.vue'
import TcAbsences from './TcAbsences.vue'

export default {
    components:{
        TcSideBar,
        TcHome,
        TcProfile,
        TcAbsences,
    }
}

</script>

<style scoped>

.dashboard{
    height: 100vh;
    width: 100%;
}

</style>
