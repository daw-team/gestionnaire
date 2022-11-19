<template>
    <div class="dashboard">
        <AdSideBar></AdSideBar>
        <router-view></router-view>
    </div>
</template>

<script>
import AdSideBar from './AdSideBar.vue'
import AdHome from './AdHome.vue'
import AdProfile from './AdProfile.vue'
import AdAbsences from './AdAbsences.vue'
import AdModules from './AdModules.vue'
import AdStudentsList from './AdStudentsList.vue'
import AdTeachersList from './AdTeachersList.vue'

export default {
    components:{
        AdSideBar,
        AdHome,
        AdProfile,
        AdAbsences,
        AdModules,
        AdStudentsList,
        AdTeachersList
    }
}

</script>

<style scoped>

.dashboard{
    height: 100vh;
    width: 100%;
}

</style>
