<template>
    <div class="container altezza margin-nav ">
       <div class="my-nav fixed-top altezza-nav"></div>
        <router-link class="bottone mt-4 rosso-background ombra float-right" :to="{ name: 'create'}">Crea</router-link>

        <h1 class="mb-3">Pannello di controllo</h1>
        <!-- <h3 class="rosso">Appartamenti sponsorizzati</h3>
        <div class="row justify-content-between">

            <div class=" col-12 col-lg-5 my-2 card ombra" style="width: 18rem;" 
                v-for="s_app in sponsored_apartments"
                :key="s_app.id">

                <img :src="'storage/'+s_app.imgs" class="card-img-top pt-3 max" :alt="s_app.title">
                <div class="card-body">
                    <h5 class="card-title">{{s_app.title}}</h5>
                    <div class="d-flex justify-content-end">

                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'show', params: { slug: s_app.slug }}">Dettagli</router-link> 
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'edit', params: { slug: s_app.slug }}">Modifica</router-link> -->
                        <!-- <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'sponsor'}">Sponsorizza</router-link> -->
                        <!-- <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'stats'}">Statistiche</router-link> -->
                        <!-- <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'email'}">E-mail</router-link>

                    </div>
                </div>
            </div>
        </div> -->

        <h3 v-if="apartments.length != 0" class="rosso">Appartamenti</h3>
        <h3 v-else class="rosso">Non ci sono appartamenti</h3>

        <div class="row justify-content-between">

              <!-- <div class=" col-12 col-lg-5 my-2 card ombra" 
                v-for="s_app in sponsored_apartments"
                :key="s_app.id">

                <img :src="'storage/'+s_app.imgs" class="card-img-top pt-3 max" :alt="s_app.title">
                <div class="card-body">
                    <h5 class="card-title">{{s_app.title}}</h5>
                    <div class="d-flex justify-content-end">

                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'show', params: { slug: s_app.slug }}">Dettagli</router-link> 
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'edit', params: { slug: s_app.slug }}">Modifica</router-link> 
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'sponsor'}">Sponsorizza</router-link>
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'stats'}">Statistiche</router-link>
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'email', params: { id: s_app.id }}">E-mail</router-link> -->
<!-- 
                    </div>
                </div>
            </div> -->


            <div class=" col-12 col-lg-5 my-2 card ombra" 
                v-for="app in apartments"
                :key="app.id"
                :class="app.visible ? '' :'d-none'"
                >

                <img :src="'storage/'+app.imgs" class="card-img-top pt-3 max" :alt="app.title">
                <div class="card-body">
                    <h5 class="card-title">{{app.title}}</h5>
                    <div class="d-flex justify-content-end">

                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'show', params: { slug: app.slug }}">Dettagli</router-link> 
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'edit', params: { slug: app.slug }}">Modifica</router-link>
                        <!-- <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'sponsor'}">Sponsorizza</router-link> -->
                        <!-- <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'stats'}">Statistiche</router-link> -->
                        <router-link class="bottone rosso-background ombra mx-1" :to="{ name: 'email', params: { id: app.id }}">E-mail</router-link>

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
                // sponsored_apartments:[],
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
                    // this.sponsored_apartments = response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
                    console.log(this.apartments)
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
</script>

<style lang="scss" scoped>

        .max{
            max-height: 266px;
        }

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
