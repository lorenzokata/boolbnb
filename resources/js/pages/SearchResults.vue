<template>
    <div class="container">
        
        <h1 class="pt-3 rosso">Risultati ricerca</h1>

        <!-- ricerca avanzata -->
        <div>

            <!-- cerca e dropdown icon -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="cerca">

                    <!-- input -->
                    <input class="form-ricerca text-center cream-background input mb-1"
                            v-model="userInput"
                            name="userInput"
                            type="text"
                            placeholder=""
                        @input="autoAddress()"/>

                    <!-- btn cerca -->
                    <router-link class="bottone rosso-background cream mb-1 ombra"
                            :to="{
                                name: 'results',
                                params: { userInput: userInput }
                            }"
                            >Cerca
                    </router-link>

                </div>

                <div class="dropdown bottone rosso-background cream mb-1 ombra">
                    <i class="fas fa-sort-amount-down fa-lg"></i>
                </div>

            </div>

            <!-- menu dropdown al click -->
            <div class="ombra row row-cols-2 mt-3 mb-3">

                <!-- stanze e letti -->
                <div class="col p-3">
                    <h3 class="rosso">Stanze e letti</h3>

                    <div class="d-inline-block mt-3 mr-4">
                        <h5>Stanze</h5>
                        <select class="form-control sel-room">
                            <option v-for="n in 10" :key="n">{{ n }}</option>
                        </select>   
                    </div>

                    <div class="d-inline-block mt-3 mr-4">
                        <h5>Letti</h5>
                        <select class="form-control sel-room">
                            <option v-for="n in 10" :key="n">{{ n }}</option>
                        </select>   
                    </div>

                </div>

                <!-- distanza -->
                <div class="form-group col p-3">

                    <h3 class="rosso">Distanza</h3>
                    <label for="formControlRange">Raggio {{radius/1000}} Km</label>
                    <input
                        type="range"
                        min="20000"
                        max="100000"
                        step="1000"
                        class="form-control-range"
                        id="formControlRange"
                        v-model="radius"
                    /> 

                    <div class="bottone rosso-background bottom-right" @click="loadApartments(radius)">Applica filtro</div>

                </div>

                <!-- servizi aggiuntivi -->
                <div></div>

            </div>

        </div>


        <!-- <input type="num" v-model="radius" @input="loadApartments(radius)"> -->
        <h2 class="rosso">Sponsored Apartments</h2>

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

        <h2 class="rosso">Results</h2>


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
                    console.log(response.data.results.apartments);
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

.form-ricerca {
    width: 300px;
    height: 41px;
    align-items: center;
    border-radius: 200px;
    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px,
        rgba(0, 0, 0, 0.23) 0px 6px 6px;
}

.sel-room{
    width: 60px;
}

.bottom-right{
    float: right;
}

.form-group{
    margin-bottom: 0 !important;
}

</style>
