<template>
    <div class="container margin-nav pt-3">
        <h1 class="mb-3">Dashboard</h1>

        <div class="form-row justify-content-between">
  
                <router-link class="rou-link col-sm-11 col-md-5 bottone rosso-background ombra mega-bot bottone rosso-background ombra" :to="{ name: 'create'}">Crea</router-link>
           

            
                <router-link class="rou-link col-sm-11 col-md-5 bottone rosso-background ombra mega-bot bottone rosso-background ombra" :to="{ name: 'edit'}">Edit</router-link> <!-- da togliere -->
    

       
                <router-link class="rou-link col-sm-11 col-md-5 bottone rosso-background ombra mega-bot bottone rosso-background ombra" :to="{ name: 'home'}">Home</router-link>
       

      
                <router-link class="rou-link col-sm-11 col-md-5 bottone rosso-background ombra mega-bot bottone rosso-background ombra" :to="{ name: 'show'}">Show</router-link> 
           
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
