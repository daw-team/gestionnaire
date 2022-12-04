<template>
    <div class="dashboard"
    :class="{'small':menuChange}"
    >
        <TcSideBar></TcSideBar>
        <router-view></router-view>
    </div>
</template>

<script>
import TcSideBar from './TcSideBar.vue'
import TcHome from './TcHome.vue'
import TcProfile from './TcProfile.vue'
import TcAbsences from './TcAbsences.vue'
import TcStudentsList from './TcStudentsList.vue'

import bus from '../../EventBus'

export default {
    components:{
        TcSideBar,
        TcHome,
        TcProfile,
        TcAbsences,
        TcStudentsList,
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
    width: calc(100% - 70px) ! important;
    padding-left: 70px;
    min-height: 100vh;
    overflow: hidden;
    transition: all ease .4s;
    background: #F6F7F6;
}

.small {
    width: calc(100% - 260px) ! important;
    padding-left: 260px;
}

</style>
