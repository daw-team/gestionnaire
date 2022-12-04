<template>
    <div
        class="dashboard"
    >
        <AdSideBar></AdSideBar>

        <div
            class="container-router"
            :class="{'small':menuChange}"
        >
            <router-view></router-view>
        </div>
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

import bus from '../../EventBus'


export default {
    components:{
        AdSideBar,
        AdHome,
        AdProfile,
        AdAbsences,
        AdModulesList,
        AdStudentsList,
        AdTeachersList
    },

    data() {
        return {
            menuChange: false,

        }
    },

    created() {
        bus.$on('changeMenu', (value) => {
            this.menuChange = value;
        })
    },
}

</script>

<style scoped>

.dashboard{
    width: 100%;
    min-height: 100vh;
    background: #F6F7F6;
}

.container-router{
    width: calc(100% - 70px) ! important;
    padding-left: 70px;
    transition: all ease .4s;

}

.small {
    width: calc(100% - 260px) !important;
    padding-left: 260px !important;
}

</style>
