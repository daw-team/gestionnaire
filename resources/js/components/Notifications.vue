<template>
    <div class="notif-container">
        <!-- <div class="list-container"> -->
            <div class="notif-list">
                <h3>Notifications</h3>
                <ul>
                    <li v-for="(notif, index) in notifications" :key="index" :class="{'unseen': notif.Is_Seen === 0}">
                        <div class="notif-img" v-if="insertImg(notif.Text_Not, 0)">
                            <img src="../assets/accepted.png" >
                        </div>

                        <div class="notif-img" v-if="insertImg(notif.Text_Not, 1)">
                            <img src="../assets/absences.png" >
                        </div>

                        <div class="notif-img" v-if="insertImg(notif.Text_Not, 2)">
                            <img src="../assets/excluded.png">
                        </div>

                        <div class="notif-img" v-if="insertImg(notif.Text_Not, 3)">
                            <img src="../assets/module.png">
                        </div>
                        <p>{{ notif.Text_Not }}</p>

                    </li>
                </ul>
            </div>
        <!-- </div> -->
    </div>
</template>

<script>

export default {
    data() {
        return {
            notifications:[],
            picsArray: [ 'accepted', 'unjustified', 'rejected', 'exluded'],
            new: 0,
        }
    },

    mounted() {
        if( this.$route.fullPath.includes('student=') ) {
            axios
                .post('http://localhost:8000/api/unseenStudentNotifNbr',{ id: this.$route.params.id })
                .then( res => {
                    res.data = this.new
                    this.$emit('newNotif', this.new )
                })

            axios
                .post('http://localhost:8000/api/getStudentNotif', { id: this.$route.params.id })
                .then( res =>{
                    this.notifications = res.data
                    // this.notifications.forEach(element => {
                    //     if(element.Is_Seen === 0){
                    //         this.new = true
                    //     }
                    // });
                    // this.$emit('newNotif', this.new )
                })
        }else if( this.$route.fullPath.includes('admin=') ) {
            axios
                .post('http://localhost:8000/api/unseenTeacherNotifNbr',{ id: this.$route.params.id })
                .then( res => {
                    res.data = this.new
                    this.$emit('newNotif', this.new )
                })

            axios
                .post('http://localhost:8000/api/getTeacherNotif', { id: this.$route.params.id })
                .then( res =>{
                    this.notifications = res.data
                    // this.$emit('userNotif', "teacher")
                })

        }else if( this.$route.fullPath.includes('admin=') ) {
            axios
                .post('http://localhost:8000/api/unseenStudentNotifNbr',{ id: this.$route.params.id })
                .then( res => {
                    res.data = this.new
                })
            axios
                .post('http://localhost:8000/api/getAdminNotif', { id: this.$route.params.id })
                .then( res =>{
                    this.notifications = res.data
                })


        }
    },

    methods: {

        insertImg(text, i){
            if( text.includes(this.picsArray[i]) ) return true
            else { return false }
        }

    },
}

</script>


<style scoped>

.notif-list{
    width: 300px;
    padding: 10px;
    height: 400px;
    background: #fff;
    border-radius: 15px;
    background: #F6F7F6;
    box-shadow: 2px 2px 8px 2px rgba(23, 32, 17, 0.484);
    overflow-y: auto;
    overflow-x: hidden;
}

.list-container{
    width: 100%;
    padding-right: 17px;
    box-sizing: content-box;
    overflow-x: hidden;
}

h3{
    width: 100%;
    padding: 10px 25px;
}

ul{
    list-style: none;
}

li{
    border-radius: 15px;
    background: #fff;
    margin: 8px auto;
    padding: 2px 4px;
    width: calc(100% - 8px);
    height: 60px;
    display: flex;
    flex-direction: row;
    padding: 4px;
    align-items: center;
    font-weight: 400;
}

.notif-img{
    width: 55px;
    height: 55px;
    display: flex;
    overflow: hidden;
    align-items: center;
    justify-content: space-around;
    margin-right: 10px;
}

.notif-img img{
    width: 100%;
    height: auto;
}

.unseen{
    background: linear-gradient(180deg, #14a24d54, #2b5dbb3c);
}

</style>
