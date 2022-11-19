<template>
    <div class="student-profile-container">
        <div class="header">
            <div class="card">
                    <img src="../../assets/logo.png" alt="">
                    <h4>E-learning - Université Constantine 2</h4>
                    <input type="text" name="search" value="Search ...">
                    <img src="../../assets/notif.png" alt="">
            </div>
            <div
                class="profile-image"
            >
                <div
                    class="edit-profil-pic"
                    v-if="EditModeActive"

                >
                    <ion-icon name="create-outline"></ion-icon>
                    <label for="file-upload" class="custom-file-upload">
                        <ion-icon name="camera"></ion-icon>
                        Upload profile picture
                        <input id="file-upload" type="file" accept="image/*" @change="saveImage"/>
                    </label>
                </div>
                <div class="img-src">
                    <img :src="getImageUrl(user.imgSrc)" alt="">
                </div>
            </div>
            <h2>{{ user.nom }} {{ user.prenom}}</h2>
        </div>
        <div class="edit-container">
            <h4>Edit profile</h4>
            <div class="toggle-btn"
                    @click="EditModeActive = ! EditModeActive ,changePasswordActive = false"
                    :class="{'btn-active': EditModeActive}"
                >
                <div class="circle-btn"
                    :class="{'circle-active': EditModeActive}"
                ></div>
            </div>
        </div>

        <section class="profile-info">
            <div class="name-psw">
                <div class="input-container">
                    <label for="">First Name</label>
                    <input type="text" v-model="user.nom" :class="{'input-desabled': !EditModeActive}">
                </div>
                <div class="input-container">
                    <label for="">Family Name</label>
                    <input type="text" v-model="user.prenom" :class="{'input-desabled': !EditModeActive}">
                </div>
            </div>
                <div class="input-container email-input">
                    <label for="">Email</label>
                    <input type="text" v-model="user.username" :class="{'input-desabled': !EditModeActive}">
                </div>

            <div class="change-password-btn">
                <h4>Change password</h4>
                <div class="toggle-btn"
                        @click="changePasswordActive = ! changePasswordActive"
                        :class="{'btn-active': changePasswordActive , 'input-desabled': !EditModeActive}"
                    >
                    <div class="circle-btn"
                        :class="{'circle-active': changePasswordActive}"
                    >
                    </div>
                </div>
            </div>
            <div class="change-password" v-if="changePasswordActive">
                <div class="input-container">
                    <label>New password</label>
                    <input type="password" v-model="changePassword.newPassword">
                </div>
                <div class="input-container">
                    <label>Confirm new password</label>
                    <input type="password" v-model="changePassword.confirmNewPassword" @focusout="checkPassword">
                    <p>{{ pswMsg }}</p>
                </div>
            </div>
            <p :class="{'p-true': updated}">{{ msg }}</p>
            <div class="password-save-changes" v-if="EditModeActive">
                <div class="input-container" >
                        <label>Inter your current password to save changes</label>
                        <input type="password" v-model="user.currentPassword" >
                </div>
                <button :class="{'button-disabled': user.currentPassword == '' }" @click="sendInfo">Save changes</button>
            </div>
        </section>

    </div>
</template>

<script>


export default {

    data() {
        return {
            user: {
                id: this.$route.params.id,
                nom: '',
                prenom: '',
                username: '',
                currentPassword: '',
                imgSrc: '../../assets/user.png',
            },
            EditModeActive: false,
            changePasswordActive: false,
            changePassword: {
                newPassword: '',
                confirmNewPassword: ''
            },
            pswMsg: '',
            msg: '',
            updated:'',
            image: ''
        }
    },
    mounted() {
        axios
            .post('http://localhost:8000/api/StudentInfo', {id:this.$route.params.id})
            .then( res => {
                this.user.nom = res.data[0].Nom_Etud
                this.user.prenom = res.data[0].Prenom_Etud
                this.user.username = res.data[0].UserName_Etud
                if(res.data[0].Photo_Etud !== null){
                    this.user.imgSrc = res.data[0].Photo_Etud
                }
            })
    },
    methods: {
        sendInfo(){
            if(this.changePasswordActive === true) {
                if(this.changePassword.newPassword === this.changePassword.confirmNewPassword){
                    this.user.newPassword = this.changePassword.newPassword
                }
            }

            this.user.imgSrc = '../../../../storage/app/public/profileImages/student' + this.$route.params.id + '.' + this.image.name.split('.')[1]
            const formData = new FormData
            formData.set('image', this.image)
            formData.append('id', this.user.id)
            formData.append('nom', this.user.nom)
            formData.append('prenom', this.user.prenom)
            formData.append('username', this.user.username)
            formData.append('currentPassword', this.user.currentPassword)
            formData.append('imgSrc', this.user.imgSrc)
            formData.append('newPassword', this.user.newPassword)
            if(this.checkForEmptyFields()){
                this.msg = `You can't leave empty fields`
            }
            else{
                axios
                .post('http://localhost:8000/api/changeStudentInfo', formData)
                .then( res => {
                    console.log(res.data);
                    this.EditModeActive = false
                    this.msg = this.res.data
                })
            }
        },

        checkForEmptyFields(){
            let check = false;
            Object.keys(this.user).forEach( element => {
                if( this.user[element] === '' ) {
                    console.log(element);
                    check = true
                }
            })
            return check
        },

        checkPassword() {
            console.log('entrer');
            if(this.changePassword.newPassword !== this.changePassword.confirmNewPassword){
                this.pswMsg = 'Passwords do not match'
            }
            else{
                this.pswMsg = ''
            }
        },

        saveImage(e) {
            this.image = e.target.files[0]
            this.user.imgSrc = URL.createObjectURL(e.target.files[0])
        },
    },

    setup() {
    const getImageUrl = (name) => {
        return new URL(name, import.meta.url).href
    }
    return { getImageUrl }
    }
}

</script>


<style scoped>
.student-profile-container{
    margin-left: 70px;
    height: 100vh;
    width: calc(100% - 70px);

}
.header{
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: center;
}

.img-src{
    width: auto;
    height: 200px;
}

.img-src img{
    width: 200px;
    height: 200px;
    border-radius: 50%;
}

.header h2 {
    font-size: 35px;
}

.card{
    padding: 0 20px;
    width: calc(98% - 40px);
    height: 60px;
    margin: 10px 20px 40px 20px;
    min-width: 200px;
    background-color: #fcfcfc;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    position: relative;
    z-index: -1;
}

.card::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 15px;
  border: 2px solid transparent;
  background: linear-gradient(-70deg, #1f3782, #027224);
  -webkit-mask:
    linear-gradient(#fff 0 0) padding-box,
    linear-gradient(#fff 0 0);
  -webkit-mask-composite: destination-out;
  mask-composite: exclude;
}

.profile-image{
    position: relative;
}

.edit-profil-pic{
    position: absolute;
    width: 200px;
    left: 88%;
    display: flex;
    align-items: center;
}

.edit-profil-pic label{
    color: #000;
    font-weight: 500;
    font-size: 13px;
    border-radius: 15px;
}

.edit-profil-pic > ion-icon{
    font-size: 30px;
    margin: auto 5px;
    color: rgb(122, 121, 121);
}

.custom-file-upload {
    border: 1px solid rgb(0, 0, 0);
    display: inline-block;
    padding: 6px 6px;
    cursor: pointer;
}

input[ type="file" ]{
    display: none;
}

.card :nth-child(1){
    width: 55px;
    height: auto ;
}

.card :nth-child(4){
    width: 35px ;
    height: auto;
    margin-left: 15px;
}

.card h4{
    font-family: 'Audiowide', cursive;
    margin-right: auto;
    color: #02722476;
}

.card input{
    width: 280px;
    height: 20px;
    padding: 10px 20px;
    border: #ffffff79 solid 1px;
    color: #e8e8e8;
    border-radius: 20px;
    font-size: 14px;
    background: linear-gradient(6deg, #1f378233, #02722438);}

.edit-container{
    width: 150px;
    height: 40px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    position: absolute;
    right: 41%;
    top: 355px;
    padding: 5px 15px;
    border-radius: 25px;
}

.toggle-btn{
    width: 50px;
    height: 24px;
    background: rgb(163, 163, 163);
    border-radius: 12px;
    display: flex;
    align-items: center;
    position: relative;
    border: #1f3782 1px solid;
    transition: all ease .5s;

}

.circle-btn {
    width: 21px;
    height: 21px;
    background: #fff;
    left: 0;
    border-radius: 50%;
    margin: auto 2px;
    position: absolute;
    transition: all ease .3s;
}

.btn-active{
    background: #fff;
    border: #027224 1px solid;
    transition: all ease .5s;
}

.circle-active {
    left: 50%;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    box-shadow: 1px 1px 10px #027224;

    transition: all ease .3s;
}

.profile-info{
    width: 80%;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    align-items: flex-start;
    margin: auto;
    margin-top: 80px;
}

.profile-info p {
    font-size: 15px;
    font-weight: 800;
    color: #ff0000;
}

.p-true {
    color: #027224;
}

.profile-info > *{
    margin: 15px 0;
}

.email-input{
    width: 70%;
    min-width: 300px;
}

.email-input input{
    width: 100% !important;
}

.profile-info input{
    width: 250px;
    height: 20px;
    padding: 10px;
    border: none;
    outline: none;
    border-bottom: solid #121212 1px;
    font-size: 14px;
    font-size: 20px;
    transition: all ease .3s;

}

.profile-info .input-desabled{
    pointer-events: none;
    border: #818181 solid 1px;
    border-radius: 20px;
    opacity: 0.5;
    z-index: -1;
    transition: all ease .3s;
}

.profile-info input:focus {
    border-bottom: solid #121212 1px;
    border: #2c4eb4 solid 1px;
    border-radius: 20px;
}

.name-psw{
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.name-psw > *{
    width: 42%;
    min-width: 200px;
}

.name-psw input{
    width: 100%;
}

.input-container{
    display: flex;
    flex-direction: column;
    margin: 0 20px;
}

label{
    color: #818181;
    font-weight: 600;
    font-size: 17px;
}

.change-password-btn{
    display: flex;
    align-items: center;
    width: 200px;
    justify-content: space-between;
    margin: 30px 35px;
    color: #818181;
}

.change-password{
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}

.password-save-changes{
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-evenly;
    align-items: center;
    flex-wrap: wrap;
}

.password-save-changes label{
    color: #ff0000;
}

.password-save-changes button {
  margin-right: 40px;
  width: 200px;
  height: 50px;
  font-size: 20px;
  font-weight: 700;
  background: linear-gradient(90deg, #14a24d, #2b5dbb);
  border: 1px solid;
  border-radius: 30px;
  color: #fff;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.476);
  transition: all ease .7s;
}

.button-disabled{
    background: linear-gradient(-90deg, #2c4eb477, #00882982) !important ;
    pointer-events: none;
}

button:hover {
  box-shadow: none;
  border: 1px solid #ffffff83;
  background: linear-gradient(90deg, #106e3a, #1e4881);
  transition: all ease .5s;
}

@media (max-width: 670px) {
    .card h4{
        display: none;
    }
}
</style>
