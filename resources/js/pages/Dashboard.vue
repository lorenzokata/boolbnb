<template>
    <div class="container pt-3">
        <h1 class="mb-3">Dashboard</h1>

        <router-link :to="{ name: 'create'}">Crea</router-link>
        <router-link :to="{ name: 'edit'}">Edit</router-link> <!-- da togliere -->
        <router-link :to="{ name: 'home'}">Home</router-link>
        <router-link :to="{ name: 'show'}">Show</router-link> 
        
        
    </div>
</template>

<script>
    export default {
        name: 'Dashboard',
        mounted() {
            axios
                .get(
                    "/api/dashboard/" +
                        JSON.parse(this.$userId).id 
                )
                .then(response => {
                    console.log(response.data.results);
    // questi sono gli apartments dell'utente loggato, divisi tra sponsored e non
                    this.sponsored_apartments = response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
                })
                .catch(error => {
                    console.log(error);
                });

            console.log();
        }
    }
</script>
