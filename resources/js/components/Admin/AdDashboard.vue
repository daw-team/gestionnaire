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
import AdModulesList from './AdModulesList.vue'
import AdStudentsList from './AdStudentsList.vue'
import AdTeachersList from './AdTeachersList.vue'

export default {
    components:{
        AdSideBar,
        AdHome,
        AdProfile,
        AdAbsences,
        AdModulesList,
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
