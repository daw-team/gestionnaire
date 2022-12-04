<template>
    <div class="background" @click="goBack($event)">
            <form
            action=""
            method="POST"
            >
                <h1 class="form-title">Jusfication form</h1>
                <p></p>
                <label for="">Select your justification file:</label>
                <label for="file-upload" class="custom-file-upload">
                        <ion-icon name="camera"></ion-icon>
                        Upload Justification
                        <input id="file-upload" type="file" accept="image/*" @change="saveImage"/>
                </label>

                <textarea
                    type="textarea"
                    name="email"
                    placeholder="description"
                ></textarea>
                <input type="submit"    name="submit"    value="Submit"  @click.prevent="uploadImage">
            </form>
    </div>

</template>

<script>
export default {
  data() {
    return {
        box: null,
        image: '',
        description: ''
    }
  },

  mounted() {
    this.box = document.querySelector('form');
    },

    methods: {
        goBack(e) {
            if(!this.box.contains(e.target)){
                this.$router.go(-1)
            }
        },

        saveImage(e) {
            this.image = e.target.files[0]
        },

        uploadImage() {
            const formData = new FormData
            formData.set('image', this.image)
            formData.append('num', this.$route.params.absNum)
            axios
                .post('http://localhost:8000/api/uploadImage', formData)
                .then( () => {
                    this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'absence justified!',
                    showConfirmButton: false,
                    timer: 2500
                    })
                })
                .then(this.$router.go(-1))
        }


    },




}



</script>




<style  scoped>


@keyframes slideIn {
    0% {background: transparent;  left: -1500px;  opacity: 0;}
    50% {background: transparent; opacity: 0;}
    75% {background: transparent; opacity: 0}
    100% {background: linear-gradient(180deg, #14a24d5d, #2b5dbb43);  left: 0px;  opacity: 1;}
}

.background{
    background: linear-gradient(180deg, #14a24d5d, #2b5dbb43);
    width: 100%;
    height: 100vh;
    top: 0;
    left: 0;
    position: absolute;
    animation: slideIn .7s ease-in;
    opacity: 1;
}


form {
    width: 500px;
    height: 70%;
    padding: 10px 50px;
    transform: translateY(10%);
    margin: auto;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    border-radius: 15px;
}

.form-title{
    font-size: 60px;
    margin: 40px 0 60px 0;
    background-image: linear-gradient(180deg, #14a24d, #2b5dbb);
    -webkit-background-clip: text;
    color: transparent;
}

textarea{
    width: 70%;
    height: 100px;
    align-self: center;
    padding: 10px;
    border: 1px solid;
    outline: none;
    margin: 40px 0 10px 0;
    font-size: 14px;
    border-radius: 20px;

}

textarea:focus {
    border-bottom: solid #121212 1px;
    border: #2c4eb4 solid 1px;
}

.custom-file-upload > ion-icon{
    font-size: 30px;
    margin: auto 5px;
    color: rgb(122, 121, 121);
}

.custom-file-upload {
    width: 160px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-around;
    border: 1px solid rgb(0, 0, 0);
    padding: 6px 6px;
    cursor: pointer;
    color: #000;
    font-weight: 500;
    font-size: 13px;
    border-radius: 15px;
    margin: 10px auto;
}

input[ type="file" ]{
    display: none;
}

input[type = submit] {
    width: 140px;
    height: 40px;
    font-size: 18px;
    font-weight: 600;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 10px auto;
    transition: all ease-out .2s;
}

input[type = submit]:hover{
    background: linear-gradient(180deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease-in .2s;
}

form p {
    color: #ff0000;
    text-align: center;
    margin: auto;
}


</style>
