<template>
    <div class="container margin-t-4">
        <h1 class="mt-3 mb-3">Dashboard</h1>

        <router-link :to="{ name: 'create'}">Crea</router-link>
        <router-link :to="{ name: 'edit'}">Edit</router-link> <!-- da togliere -->
        <router-link :to="{ name: 'home'}">Home</router-link>
        <router-link :to="{ name: 'show',params:{slug:'casa-bella'}}">Show</router-link> 
        
        
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
