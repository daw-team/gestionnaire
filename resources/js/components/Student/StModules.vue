<template>
    <div>
        <div class="grid-container">
            <div
                class="card"
                v-for="(module, index) in modules" :key="index"
            >
                <div class="row-one">
                    <div class="right">
                        <h1>{{ module.Abrv_Mod }}</h1>
                        <p>{{ module.Nom_Mod }}</p>
                    </div>
                    <div class="left">
                        <img :src="getImageUrl(module.Abrv_Mod)" alt="">
                    </div>
                </div>
                <div class="row-two">
                    <p>Enseignant: {{ module.Ens_Nom }} {{ module.Ens_Prenom }}</p>
                    <p>Coefficient: {{ module.Mod_Coef }}</p>
                    <p>Credit: {{ module.Mod_Cred }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            modules: [
                {Abrv_Mod: 'DAW', Nom_Mod: 'sdfhslfdsflksdjf', Ens_Prenom: 'asfdklfj', Ens_Nom: 'dsfhj', Mod_Coef: 4, Mod_Cred: 10}
            ],
        }
    },

    setup() {
    const getImageUrl = (name) => {
        name = `../../assets/` + name.toLowerCase() + ".png"
        return new URL(name, import.meta.url).href
    }
    return { getImageUrl }
    }
}
</script>

<style scoped>

.card{
    width: 300px;
    height: 300px;
    background-color: #fcfcfc;
    box-shadow: rgb(94 94 94) 5px 5px 10px;
    padding: 15px 20px;
    border-radius: 15px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-left: auto;
    position: relative;
}

</style>
