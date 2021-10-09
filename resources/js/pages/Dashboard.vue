<template>
    <div class="container margin-nav pt-3">
        <h1 class="mb-3">Dashboard</h1>

        <div class="form-row justify-content-between">
            <div class="mega-bot col-sm-11 col-md-5 bottone rosso-background ombra">
                <router-link class="rou-link" :to="{ name: 'create'}">Crea</router-link>
            </div>

            <div class="mega-bot col-sm-11 col-md-5 bottone rosso-background ombra">
                <router-link class="rou-link" :to="{ name: 'edit'}">Edit</router-link> <!-- da togliere -->
            </div>

            <div class="mega-bot col-sm-11 col-md-5 bottone rosso-background ombra">
                <router-link class="rou-link" :to="{ name: 'home'}">Home</router-link>
            </div>

            <div class="mega-bot col-sm-11 col-md-5 bottone rosso-background ombra">
                <router-link class="rou-link" :to="{ name: 'show'}">Show</router-link> 
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        name: 'Dashboard',
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style lang="scss" scoped>
    .mega-bot{
        font-size: 5rem;
        text-align: center;
        padding: 5rem;
        margin-top: 3rem;
        margin-bottom: 3rem;
        border-radius: 3rem;


        .rou-link {
        color: white;
        text-align: center;
        text-decoration: none;
        }
    }


</style>
