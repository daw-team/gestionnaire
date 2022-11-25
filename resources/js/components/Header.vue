<template>
    <div>
        <div class="header">
            <img src="../assets/logo.png" alt="">
            <h4>E-learning - Université Constantine 2</h4>

            <img src="../assets/notif.png" alt="">
        </div>
    </div>
</template>

<script>
export default {

}
</script>


<style scoped>
.header{
    padding: 0 20px;
    width: calc(98% - 40px);
    height: 60px;
    margin: 10px auto;
    min-width: 200px;
    background-color: #fcfcfc;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    position: relative;
}


.header :nth-child(1){
    width: 55px;
    height: auto ;
}

.header :nth-child(3){
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

</style>
