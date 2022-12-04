<template>
    <div class="dashboard">
        <StSideBar></StSideBar>
        <div class="dashboard-view"
        :class="{'small':menuChange}"
        >
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import StSideBar from './StSideBar.vue'
import StHome from './StHome.vue'
import StProfile from './StProfile.vue'
import StAbsences from './StAbsences.vue'
import StModules from './StModules.vue'

import bus from '../../EventBus'


export default {
    components:{
        StSideBar,
        StHome,
        StProfile,
        StAbsences,
        StModules,
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
    min-height: 100vh;
    width: 100%;
    background: #F6F7F6;
}

.dashboard-view{
    width: calc(100% - 70px) ! important;
    padding-left: 70px;
    min-height: 300px;
    overflow: hidden;
    transition: all ease .4s;
}

.small {
    width: calc(100% - 260px) ! important;
    padding-left: 260px;
}


</style>
