<template>
    <div class="container pt-3 altezza">
       
        <router-link class="bottone rosso-background ombra fl-right" :to="{ name: 'create'}">Crea</router-link>

        <h1 class="mb-3">Dashboard</h1>

        <h3>i miei appartamenti</h3>
        <div class="row justify-content-between">

            <div class=" col-12 col-lg-5   my-2 card ombra" style="width: 18rem;" 
                v-for="app in apartments"
                :key="app.id">

                <img :src="'storage/'+app.imgs" class="card-img-top pt-3" :alt="app.title">
                <div class="card-body">
                    <h5 class="card-title">{{app.title}}</h5>
                    <div class="d-flex justify-content-end">

                        <router-link class="  bottone  rosso-background ombra mx-1" :to="{ name: 'show', params: { slug: app.slug }}">Show</router-link> 
                        <router-link class=" bottone rosso-background ombra  mx-1" :to="{ name: 'edit', params: { slug: app.slug }}">Edit</router-link>
                        <router-link class="  bottone  rosso-background ombra  mx-1" :to="{ name: 'stats'}">Statistiche</router-link>
                        <router-link class=" bottone  rosso-background ombra mx-1 " :to="{ name: 'email'}">Email</router-link>

                    </div>
                </div>
            </div>
        </div>

        
    </div>
</template>

<script>
    export default {
        name: 'Dashboard',
        data() {
            return{
                sponsored_apartments:[],
                apartments:[]
            }
        },
        mounted() {
            axios
                .get(
                    "/api/dashboard/" +
                        JSON.parse(this.$userId).id 
                )
                .then(response => {
                    
                    // questi sono gli apartments dell'utente loggato, divisi tra sponsored e non
                    this.sponsored_apartments = response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
                    console.log(this.sponsored_apartments);
                    console.log(this.apartments);
                })
                .catch(error => {
                    console.log(error);
                });

            console.log();
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
