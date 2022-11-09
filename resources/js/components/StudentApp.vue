<template>
    <div>
        <router-view></router-view>
    </div>
</template>




<script>
import StLandingPage from './Student/StLandingPage.vue'
import StDashboard from './Student/StDashboard.vue'
export default {
    components:{
        StLandingPage,
        StDashboard
    }
}
</script>