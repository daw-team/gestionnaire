<template>
    <div>
        <router-view></router-view>
    </div>
</template>




<script>
import AdLandingPage from './Admin/AdLandingPage.vue'
import AdDashboard from './Admin/AdDashboard.vue'
export default {
    components:{
        AdLandingPage,
        AdDashboard
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
