<template>
    <div class="container">
        <div class="row  flex-column">
            <h1 class="margin-t-6 text-center viola"> {{apartment.title}} </h1>
            <!-- qui stampo la foto -->
                    <div class="img-show">
                        <!-- aggiungere v-if img c'é -->
                        <img :src="apartment.imgs" alt="">
                    </div>
        </div>
        <div class="row flex-column">
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
    .img-show{
        
       margin: auto;
        img{
            height: 70%;
            width: 70%;
            
        }
    }
    .dettagli{
        list-style-type:none;
          
    }
</style>