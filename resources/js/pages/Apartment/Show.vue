<template>
    <div class="container-fluid pippo margin-nav">
        <div class="row altezza">
            <div class="col-12 col-lg-8 col-xl-7">
            <h1 class="viola text-center"> {{apartment.title}} </h1>
            <div class="margin-l-4 ">{{apartment.city}} {{apartment.street}} {{apartment.adddress}}</div>
            <!-- qui stampo la foto -->
                    <div class="img-show ombra">
                        <!-- aggiungere v-if img c'é -->
                        <img :src="apartment.imgs" alt="">
                    </div>

            </div>
            <div class="col-12 col-lg-4 col-xl-5 margin-t-5 my-primo-piano">
                <h3 class="d-block viola">Dettagli casa</h3>
                <div>
                    <ul class="dettagli d-inline-block">
                        <li>numero camere:{{apartment.n_rooms}} <i class="fas fa-door-open viola"></i></li>
                        <li>numero letti:{{apartment.n_beds}} <i class="fas fa-bed viola"></i></li>
                        <li>numero bagni:{{apartment.n_baths}} <i class="fas fa-toilet viola"></i></li>
                        <li>numero metri quadri:{{apartment.square_meters}} <i class="fas fa-home viola"></i></li>
                    </ul>
                    <h3 class="d-block viola mt-3">Servizi della casa</h3>
                    <div>
                        <div>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque, illum accusamus rem ad expedita architecto saepe magnam? Dolores quia iste cumque culpa unde ducimus sint vel dolorum dolorem, quam est.</div>
                    </div>
                </div>
                <h3 class="d-block viola mt-3">Descrizione</h3>
                <p>{{apartment.description}} Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis quisquam commodi magni exercitationem corporis odio, asperiores totam illo rem doloribus! Debitis inventore asperiores eum, unde distinctio accusantium quisquam ducimus cupiditate? Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut eaque beatae minima nemo eligendi quos facere molestias vitae laudantium quaerat iste quasi voluptas incidunt totam nam iure, voluptatum veritatis dolores?</p>

                 <h3 class="d-block viola mt-3">Locazione della casa</h3>
                    <div class="img-show">
                        <img src="https://developers.google.com/codelabs/maps-platform/webgl/img/webgl_pin_final.png" alt="">
                    </div>

                    <h3 class="d-block viola mt-3">Invia un mail al propietario</h3>
                            <form action="" class="d-flex flex-column">
                                <label for="" class="mt-2">Nome e Cognome</label>
                                <input type="text">
                                <label for="" class="mt-2">email</label>
                                <input type="text">
                                <label for="" class="mt-2">Messaggio</label>
                                <textarea></textarea>
                                <button type="submit" class="bottone rosso-background cream mt-3">Invia</button>
                            </form>
                    
            </div>
        </div>
            </div>
</template>

<script>
    export default {
        data(){
           return{
               id: '13',
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
.altezza{
    height: 100%;
    
}
.pippo{
    height: calc(100vh - 56px);
    margin-top: 55px;
    // margin-top: 56px;
}
    .img-show{
            width: 100%;
       img{
            width: 100%;    
       }
    }
    .dettagli{
        list-style-type:none;
          
    }
</style>