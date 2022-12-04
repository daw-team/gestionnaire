<template>
    <div>
        <div class="header">
            <img src="../assets/logo.png" alt="" class="logo">
            <h4>E-learning - Université Constantine 2</h4>
            <div class="notification-container">
                <div class="notif-num" v-if="getNewNotif !== 0">
                    <p>{{ getNewNotif }}</p>
                </div>
                <img src="../assets/notif.png" alt="" class="notif-icon" @click="notifActive">
            </div>

            <NotificationsComp
                v-if="showNotifications"
                class="notif"
            ></NotificationsComp>
        </div>

    </div>
</template>

<script>
import NotificationsComp from './Notifications.vue'

export default {

    components:{
        NotificationsComp
    },

    data() {
        return {
            showNotifications: false,
            getNewNotif: 0
        }
    },

    mounted() {
        if( this.$route.fullPath.includes('student=') ){
            this.user = 'Student'
            axios
                .post('http://localhost:8000/api/unseenStudentNotifNbr',{ id: this.$route.params.id })
                .then( res => this.getNewNotif = res.data )

        }else if(this.$route.fullPath.includes('teacher=')){
            this.user = 'Teacher'
            axios
                .post('http://localhost:8000/api/unseenTeacherNotifNbr',{ id: this.$route.params.id })
                .then( res => this.getNewNotif = res.data )

        }else{

        }
    },

    methods: {
        notifActive(){
            this.showNotifications = !this.showNotifications
            if( this.showNotifications === false){
                axios
                    .post('http://localhost:8000/api/see' + this.user + 'Notif', { id: this.$route.params.id })
                    .then(res => res.data)
                }
                this.getNewNotif = 0
        }
    },

}
</script>


<style scoped>
.header{
    padding: 0 20px;
    width: calc(98% - 40px);
    height: 60px;
    margin: 10px auto;
    min-width: 200px;
    background: #fff;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    position: relative;
}


.logo{
    width: 55px;
    height: auto ;
}

.notification-container{
    position: relative;
    display: flex;
    flex-direction: row;
}

.notif-icon{
    width: 35px ;
    height: auto;
    margin-left: 15px;
    cursor: pointer;
}

.header h4{
    font-family: 'Audiowide', cursive;
    margin-right: auto;
    color: #52a34fd1;
}

.notif{
    position: absolute;
    bottom: -420px;
    right: 22px;
    z-index: 20;
}

.notif-num{
    background: red;
    color: #fff;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    bottom: 20px;
    right: -3px;
    font-size: 15px;
    font-weight: 500;
}

</style>
