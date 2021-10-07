<template>
    <div>
        <h1>SHOW</h1>
        <!-- <p>{{apartment.title}}</p> -->
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')

            // api show appartamenti
        axios
            .get("/api/apartment/show")
            .then(response => {
                this.apartments = response.data.results;
                console.log(this.apartments);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
</script>
