<template>
    <div class="dashboard">
        <StSideBar></StSideBar>
        <router-view></router-view>
    </div>
</template>

<script>
import StSideBar from './StSideBar.vue'
import StHome from './StHome.vue'
import StNotifications from './StNotifications.vue'
import StProfile from './StProfile.vue'
import StAbsences from './StAbsences.vue'
import StModules from './StModules.vue'

export default {
    components:{
        StSideBar,
        StHome,
        StNotifications,
        StProfile,
        StAbsences,
        StModules,
    }
}

</script>

<style scoped>

.dashboard{
    height: 100vh;
    width: 100%;
}

</style>
