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
                @newNotif="getNewNotif"
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
        if(this.userNotif === 'student'){

        }else if(this.userNotif === 'student'){

        }else{

        }
    },

    methods: {
        notifActive(){
            showNotifications = !showNotifications
            axios
                .post('',)
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
    bottom: -3px;
    right: 23px;
    font-size: 15px;
    font-weight: 500;
}

</style>
