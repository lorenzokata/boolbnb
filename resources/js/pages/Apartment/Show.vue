<template>
    <div class="container-fluid pippo margin-nav">
        <div class="row">
            <div class="col-12 col-lg">
            <h1 class=" viola text-center"> {{apartment.title}} </h1>
            <!-- qui stampo la foto -->
                    <div class="img-show">
                        <!-- aggiungere v-if img c'é -->
                        <img :src="apartment.imgs" alt="">
                    </div>

            </div>
            <div class="col-12 col-lg-5">
                <h3 class="d-block viola">dettagli casa</h3>
                <div>
                    <ul class="dettagli d-inline-block">
                        <li>numero camere:{{apartment.n_rooms}} <i class="fas fa-door-open viola"></i></li>
                        <li>numero letti:{{apartment.n_beds}} <i class="fas fa-bed viola"></i></li>
                        <li>numero bagni:{{apartment.n_baths}} <i class="fas fa-toilet viola"></i></li>
                        <li>numero metri quadri:{{apartment.square_meters}} <i class="fas fa-home viola"></i></li>
                    </ul>
                    <div></div>
                </div>
                <h3 class="d-block viola">Descrizione</h3>
                <p>{{apartment.description}}</p>
            </div>
        </div>
            </div>
</template>

<script>
    export default {
        data(){
           return{
               id: '12',
                apartment: [],

           }

        },
        mounted() {
            console.log('Component mounted.')

            // api show appartamenti
         axios
            .get("/api/apartment/" + this.id + "/edit")
            .then(respo => {
                this.apartment = respo.data.results;
                console.log(this.apartment);
            })
            .catch(error => {
                console.log(error);
            });

    },
    }
</script>

<style lang="scss" scoped>
.pippo{
    height: calc(100vh - 56px);
    // margin-top: 56px;
}
    .img-show{
         height: 90%;
            width: 100%;
       margin: auto;
    }
    .dettagli{
        list-style-type:none;
          
    }
</style>