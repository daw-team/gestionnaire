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
    },
    beforeCreate(){
		axios
		        .get('http://localhost:8000/api/student')
		        .then(response => {
		        if(response.data.msg == 'no sessions') {
                        this.$router.push('/login')
                    }})

    },
}
</script>
