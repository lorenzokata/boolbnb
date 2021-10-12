<template>
    <div class="container pt-3 altezza">
       
        <router-link class="bottone rosso-background ombra fl-right" :to="{ name: 'create'}">Crea</router-link>

        <h1 class="mb-3">Dashboard</h1>

        <h3>i miei appartamenti</h3>
        <div class="row ">
            <div class=" col-12 col-lg-6 col-xl-4 card" style="width: 18rem;">
                <img src="" class="card-img-top" alt="Nome Appartamento">
                <div class="card-body">
                    <h5 class="card-title">Nome Appartamento</h5>
                    <div class="">

                        <router-link class="  bottone  rosso-background ombra " :to="{ name: 'show'}">Show</router-link> 
                        <router-link class=" bottone rosso-background ombra  " :to="{ name: 'edit'}">Edit</router-link>
                        <router-link class="  bottone  rosso-background ombra  " :to="{ name: 'stats'}">Statistiche</router-link>
                        <router-link class=" bottone  rosso-background ombra  " :to="{ name: 'email'}">Email</router-link>

                    </div>
                </div>
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
  /*   .mega-bot{
        font-size: 5rem;
        text-align: center;
        padding: 5rem;
        margin-top: 3rem;
        margin-bottom: 3rem;
        border-radius: 3rem;
        } */

        .rou-link {
            font-size: 5rem;
            text-align: center;
            padding: 4rem;
            margin-top: 3rem;
            margin-bottom: 3rem;
            border-radius: 3rem;
            color: white;
            text-align: center;
            text-decoration: none;
        }

</style>
