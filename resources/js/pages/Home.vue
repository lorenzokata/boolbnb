<template>
    <main>
        <div class="container-fluid">
            <div class="row ">
                <div class=" col-12 col-lg ricerca d-flex flex-column  align-items-center">
                    <img src="https://cdn.freelogovectors.net/wp-content/uploads/2016/12/airbnb_logo.png" class="logo margin-t-10" alt="">
                    <div class="d-flex flex-row test">
                        <div class="mt-3 d-flex flex-row test justify-content-center">
                            <input v-model='userInput' name='userInput' type="text" class="form-ricerca text-center cream-background d-inline-block" placeholder="">
                            <router-link class="bottone rosso-background cream" :to="{ name: 'results', params: { userInput: userInput }}">cerca</router-link>
                        </div>
                    </div>
                        <div v-if="this.$userId" class="mt-2 bottone rosso-background ombra">
                            <router-link class="cream" :to="{ name: 'dashboard'}">DASHBOARD</router-link>
                        </div>
                </div>
                <div class=" col-12 col-lg-4 d-flex flex-column  align-items-center">
                    <h3 class="text-center margin-t-6">In Primo Piano</h3>
                    <div class="overflow-auto my-primo-piano">
                        <div class="my-card margin-t-4 mx-auto"></div>
                        <div class="my-card margin-t-4 mx-auto"></div>
                        <div class="my-card margin-t-4 mx-auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>


</template>

<script>
export default {
    name: "Home",
    data(){
        return{
            userInput:''
        }
    },
    mounted() {
        console.log("Component mounted.");
    }
};
</script>

<style lang="scss" scoped>
    .ricerca{
    background-image: url(https://siviaggia.it/wp-content/uploads/sites/2/2019/08/tempio-in-bali.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: 100vh;
}

.test{
    width: 100%;
}

.form-ricerca{
    width: 60%;
    align-items: center;
    border-radius: 200px;
    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
}

.logo{
    text-align: center;
    height: 100px;
    width: 100px;
    transform: rotate(180deg);
}

.my-card{
    background-image: url(https://pix10.agoda.net/hotelImages/4869553/0/35b103e869655a2959fac36f614fa08e.jpg?s=1024x768);
    background-position: center;
    height: 90%;
    width: 80%;
    border-radius: 1.25rem;
}

.my-primo-piano{
    height: 84vh;
    width: 100%;
    overflow-y: scroll;
}
</style>