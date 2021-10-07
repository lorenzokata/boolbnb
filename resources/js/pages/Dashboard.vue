<template>
    <div class="container margin-t-4">
        <h1 class="mt-3 mb-3">Dashboard</h1>

        <router-link :to="{ name: 'create'}">CREA</router-link>
        <router-link :to="{ name: 'home'}">HOME</router-link>
        
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
