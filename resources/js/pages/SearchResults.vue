<template>
    <div class="container margin-nav">
        
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
                    <router-link class="btn btn-primary" :to="{ name: 'show', params: { slug: s_app.slug }}">Dettagli</router-link>
                </div>
            </div>
        </div>

        <h2 class="viola">Results</h2>


        <div class="row">
            <div
                class="col-12 col-md-5 card bordo-card rounded  mx-4 my-4"
                style="width: 18rem;"
                v-for="app in apartments"
                :key="app.id"
            >
                <img :src="app.imgs" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title text-truncate viola font-weight-bold text-uppercase">{{ app.title }}</h5>
                    <p class="card-text text-truncate">{{ app.description }}</p>
                    <router-link class="bottone rosso-background ombra cream" :to="{ name: 'show', params: { slug: app.slug }}">Dettagli</router-link>
                </div>
            </div>
        </div>

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
            radius: 20000,
        };
    },
    beforeCreate(){
      console.log("Component beforeCreated.");
    },
    created(){
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
                    "/api/home/" +
                        this.$route.params.userInput +
                        "/" +
                        radius.toString()
                )
                .then(response => {
                    console.log(response.data.results);
                    this.sponsored_apartments =
                        response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
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
