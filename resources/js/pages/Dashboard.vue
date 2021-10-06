<template>
    <div>
        <h1>DASHBOARD</h1>

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
