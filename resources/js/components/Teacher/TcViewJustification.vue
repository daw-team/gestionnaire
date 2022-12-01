<template>
    <div class="background" @click="goBack($event)">
        <div class="image-container">
            <img :src="getImageUrl(imgSrc)" alt="">
            <div class="two">
                <button class="refuse"  @click="refuseJustification">Refuse</button>
                <button class="accept"  @click="acceptJustification">Accept</button>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data() {
        return {
            box: null,
            imgSrc: '',
            id: this.$route.params.JsNum
        }
    },

    mounted() {
        this.box = document.querySelector('.image-container');
        axios
            .post('http://localhost:8000/api/absenceInformation', { id: this.id } )
            .then( res => this.imgSrc = res.data[0].Just_Abs )

    },

    methods: {
        goBack(e) {
            if(!this.box.contains(e.target)){
                this.$router.go(-1)
            }
        },

        acceptJustification(){
            axios
                .post('/acceptJust', { id: this.$route.params.JsNum })
                .then( res => {
                    if(res.msg === 'informations updated successfully'){
                        this.$swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Absence accepted successfully',
                        showConfirmButton: false,
                        timer: 2500
                        })
                        this.$router.go(-1);
                }
                })
        },

        acceptJustification(){

        }


    },

    setup() {
        const getImageUrl = (name) => {
            return new URL(name, import.meta.url).href
        }
        return { getImageUrl }
    }



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

.image-container{
    width: 60%;
    min-width: 400px;
    height: 70%;
    transform: translateY(10%);
    margin: auto;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-around;
    border-radius: 15px;
    overflow-y: auto;
}

.image-container img {
    width: 100%;
    height: auto;
}

.two{
    width: 100%;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}

.refuse{
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: #757575;
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 10px auto;
    transition: all ease .5s;
}

.refuse:hover{
    background: linear-gradient(0deg, #838383, #bb2b2b);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: none;
    margin: 10px auto;
    transition: all ease .5s;
}


.accept {
    width: 100px;
    height: 40px;
    font-size: 20px;
    font-weight: 700;
    background: linear-gradient(0deg, #14a24d, #2b5dbb);
    border: 1px solid;
    border-radius: 20px;
    color: #fff;
    box-shadow: 5px 5px 10px black;
    margin: 10px auto;
    transition: all ease-out .2s;
}

.accept:hover{
    background: linear-gradient(180deg, #1f3782, #027224);
    box-shadow: none;
    transition: all ease-in .2s;
}


</style>
