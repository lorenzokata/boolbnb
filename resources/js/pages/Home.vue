<template>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Home page</h1>
            </div>
        </div>

        <div v-if="this.$userId">
            <router-link :to="{ name: 'dashboard'}">DASHBOARD</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Home",
    mounted() {
        console.log("Component mounted.");
    }
};
</script>
