<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-7 altezza">
            <h1 class="viola text-center"> {{apartment.title}} </h1>
            <div class="margin-l-7 indirizzo opal">{{apartment.address}}</div>
            <!-- qui stampo la foto -->
                    <div class="img-show ombra">
                        <!-- aggiungere v-if img c'é -->
                        <img :src="apartment.imgs" alt="apartment.title">
                    </div>
            </div>
            <div class="col-12 col-lg-5 my-descrizione">

                <!-- <h3 class="d-block viola">Dettagli casa</h3> -->

                <div class="d-flex justify-content-between align-items-center ">
                    <h3 class="d-block viola">Dettagli casa</h3>
                    <div>
                        <router-link class=" bottone rosso-background ombra" :to="{ name: 'dashboard'}">Dashboard</router-link>
                    </div>
                </div>

                <div>
                    <ul class="dettagli d-inline-block">
                        <li class="d-flex align-items-center"><i class="fas fa-door-open viola icone my-2 mr-md-2"></i>     numero camere:{{apartment.n_rooms}}</li>
                        <li class="d-flex align-items-center"><i class="fas fa-bed viola icone my-2 mr-md-2"></i>     numero letti:{{apartment.n_beds}} </li>
                        <li class="d-flex align-items-center"><i class="fas fa-toilet viola icone my-2 mr-md-2"></i>    numero bagni:{{apartment.n_baths}} </li>
                        <li class="d-flex align-items-center"><i class="fas fa-home viola icone my-2 mr-md-2"></i>    numero metri quadri:{{apartment.square_meters}}</li>
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
                        <!-- <div id="map" style="width: 100px; height: 100px;"></div> -->
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
        name:"Show",

        data(){
           return{
               /*  form: {
                    title: null,
                    description: null,
                    user_id: JSON.parse(this.$userId).id,
                    n_rooms: 1,
                    n_beds: 1,
                    n_baths: 1,
                    square_meters: null,
                    city: null,
                    zip_code: null,
                    street: null,
                    address: null,
                    visible: 1,
                    SelectedServices: []
                }, */
              
               id: '12',
               apartment: [],
           }

        },
        mounted() {
            console.log('Component mounted.')

            // api show appartamenti
         axios
            .get("/api/apartment/" + this.$route.params.slug)
            .then(response => {
                this.apartment = response.data.results;
                console.log(this.apartment);
                console.log(this.apartment.title);
            })
            .catch(error => {
                console.log(error);
            });

    },
    }
</script>

<style lang="scss" scoped>
.indirizzo{
    text-decoration: underline;
    font-size: 18px;

}
.icone{
    font-size: 25px;
}

   .img-show{
            width: 100%;
            height: 83%;
       img{
           height: 100%;
            width: 100%;    
            object-fit: cover;
       }
    }
    .dettagli{
        list-style-type:none;
          
    }
    .my-descrizione{
         height: calc(100vh - 60px);
        width: 100%;
        overflow-y: scroll;
        padding-top:60px ;
    }
</style>