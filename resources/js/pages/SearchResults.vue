<template>
    <div class="container">
        
        <h1>Search results</h1>

          <div class="form-group">
            <label for="formControlRange">raggio</label>
            <input
                type="range"
                min="20000"
                max="100000"
                step="1000"
                class="form-control-range"
                id="formControlRange"
                v-model="radius"
                
            /> 
            <span>{{radius/1000}}Km</span>
            <div class="bottone rosso-background" @click="loadApartments(radius)">applica filtro</div>
          </div>

        <!-- <input type="num" v-model="radius" @input="loadApartments(radius)"> -->
        <h2 class="viola">Sponsored Apartments</h2>

        <div class="row row-cols-4 gx-5">
            <div
                class="col card border border-danger rounded"
                style="width: 18rem;"
                v-for="s_app in sponsored_apartments"
                :key="s_app.id"
            >
                <img src="" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">{{ s_app.title }}</h5>
                    <p class="card-text">{{ s_app.description }}</p>
                    <router-link
                        class="btn btn-primary"
                        :to="{ name: 'show', params: { slug: s_app.slug } }"
                        >Dettagli</router-link
                    >
                </div>
            </div>
        </div>

        <h2 class="viola">Results</h2>


        <div class="row my-4 ombra">
                <div class="col-12 col-md-6 col-lg-4 block"></div>
                <div class="col-12 col-md-6 col-lg-4 block">
                    <h3>{{ apartment.title }}</h3>
                    <div>{{ apartment.address }}</div>
                    <div><i class="fas fa-door-open my-2 mr-md-2"></i>camere:{{apartment.n_rooms}} <i class="fas fa-bed my-2 mr-md-2"></i>letti:{{apartment.n_beds}}</div>
                    <div class="d-inline-block d-lg-none">bottone</div>
                </div>
                <div class="col-4 block d-none d-lg-block">
                    <div>{{ apartment.description }}</div>
                    <div>bottone</div>
                </div>
            </div>
            <div class="row ombra">

                    <div class="col-12 col-md-6 col-lg-4 block">
                        <img :src="apartment.imgs" alt="">
                    </div>
                <div class="col-12 col-md-6 col-lg-4 block">
                    <h3>{{ apartment.title }}</h3>
                    <div>{{ apartment.address }}</div>
                    <div><i class="fas fa-door-open my-2 mr-md-2"></i>camere:{{apartment.n_rooms}} <i class="fas fa-bed my-2 mr-md-2"></i>letti:{{apartment.n_beds}}</div>
                    <div class="d-inline-block d-lg-none">bottone</div>
                </div>
                <div class="col-4 block d-none d-lg-block">
                    <div>{{ apartment.description }}</div>
                    <div>bottone</div>
                </div>
            </div>



          <!--   <div
                class="col-12 col-md-5 card bordo-card rounded  mx-4 my-4 "
                style="width: 18rem;"  
            >
                <img :src="'storage/'+apartment.imgs" class="card-img-top " :alt=" apartment.title" >
                <div class="card-body">
                    <h5 class="card-title text-truncate viola font-weight-bold text-uppercase">{{ apartment.title }}</h5>
                    <p class="card-text text-truncate">{{ apartment.description }}</p>
                    <router-link class="bottone rosso-background ombra cream" :to="{ name: 'show', params: { slug: apartment.slug }}">Dettagli</router-link>
                </div>
            </div> -->

        <!-- <div class="div">
        <p v-for="(post, i) in apartments" :key='i'>{{post.title}}</p>  -->
    </div>
</template>

<script>
export default {
    name: "SearchResults",

    data() {
        return {
            sponsored_apartments: [],
            apartments: [],
            apartment:null,
            radius: 20000
        };
    },
    beforeCreate() {
        console.log("Component beforeCreated.");
    },
    created() {
        console.log("Component created.");
    },
    mounted() {
        console.log("Component mounted.");
        console.log(this.$route.params.userInput);
        // api per elenco servizi
        this.loadApartments(this.radius);
    },

    methods: {
        loadApartments: function(radius) {
            // il raggio della ricerca è espresso in metri
            console.log(radius);
            axios
                .get(
                    "/api/search-results/" +
                        this.$route.params.userInput +
                        "/" +
                        radius.toString()
                )
                .then(response => {
                    this.sponsored_apartments = response.data.results.sponsored_apartments;
                    console.log(response.data.results);
                    this.apartment = response.data.results.apartments[0].apartment;
                    console.log(this.apartment);
                })
                .catch(error => {
                    console.log(error);
                });
        }
        // creare la funzione che fa chiamata axios verso homecontroller@home
        // parametri saranno userInput e radius
        // la funzione sará chiamata su mounted con parametro fisso a 20km convertiti
        // la funzione verrá chiamata al click del tasto 'applica' della sezione filtri
    }
};
</script>

<style lang="scss" scoped>
    .block{
        height: 200px;
        background-color: red;
        border: 2px solid black;
    }
</style>
