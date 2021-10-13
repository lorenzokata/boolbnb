<template>
    <div class="container">
        <h1 class="pt-3 rosso">Risultati ricerca</h1>

        <!-- ricerca avanzata -->
        <div>
            <!-- cerca e dropdown icon -->
            <div class="d-flex justify-content-between align-items-center">
                <div class="cerca">
                    <!-- input -->
                    <!-- <input
                        class="form-ricerca text-center cream-background input mb-1"
                        v-model="userInput"
                        name="userInput"
                        type="text"
                        placeholder=""
                        @input="autoAddress()"
                    /> -->

                    <!-- btn cerca -->
                    <!-- <router-link
                        class="bottone rosso-background cream mb-1 ombra"
                        :to="{
                            name: 'results',
                            params: { userInput: userInput }
                        }"
                        >Cerca
                    </router-link> -->
                </div>

                <div
                    @click="dropDown"
                    class="dropdown bottone rosso-background cream mb-1 ombra"
                >
                    <i class="fas fa-sort-amount-down fa-lg"></i>
                </div>
            </div>

            <!-- menu dropdown al click -->
            <div
                :class="drop == false ? 'd-none' : ''"
                class="ombra row row-cols-2 mt-3 mb-3"
            >
                <!-- stanze e letti -->
                <div class="col p-3">
                    <h2 class="rosso">Stanze e letti</h2>

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
                <div class="col pl-3">
                    <h3 class="rosso">Distanza</h3>
                    <label for="formControlRange"
                        >Raggio {{ radius / 1000 }} Km</label
                    >
                    <input
                        type="range"
                        min="20000"
                        max="100000"
                        step="1000"
                        class="form-control-range"
                        id="formControlRange"
                        v-model="radius"
                    />

                    <div
                        class="bottone rosso-background bottom-right"
                        @click="loadApartments(radius)"
                    >
                        Applica filtro
                    </div>
                </div>

                <!-- servizi aggiuntivi - sistemare-->
                <!-- <div class="col pl-3">
                    <h2 class="rosso">Servizi aggiuntivi</h2>
                    <div class="row row-cols-4">
                        <div
                            class="col"
                            v-for="service in services"
                            :key="service.id"
                        >
                            <input
                                type="checkbox"
                                :id="service.name"
                                :value="service.id"
                                v-model="form.SelectedServices"
                                name="SelectedServices[]"
                            />

                            <label :for="service.name">{{
                                service.name
                            }}</label>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>

        <!-- sponsored apartments -->
        <div>
            <!-- <input type="num" v-model="radius" @input="loadApartments(radius)"> -->
            <h2
                v-if="Object.keys(sponsored_apartments).length != 0"
                class="rosso mt-3"
            >
                Appartamenti sponsorizzati
            </h2>

            <div class="row row-cols-4 gx-5">
                <div
                    class="col card border border-danger rounded"
                    style="width: 18rem;"
                    v-for="s_app in sponsored_apartments"
                    :key="s_app.apartment.id"
                >
                    <img src="" class="card-img-top" alt="" />
                    <div class="card-body">
                        <h5 class="card-title">{{ s_app.apartment.title }}</h5>
                        <p class="card-text">
                            {{ s_app.apartment.description }}
                        </p>
                        <router-link
                            class="btn btn-primary"
                            :to="{
                                name: 'show',
                                params: { slug: s_app.apartment.slug }
                            }"
                            >Dettagli</router-link
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- apartments -->
        <div>
            <h2 class="rosso mt-3">Risultati ricerca</h2>

            <div
                v-for="app in apartments"
                :key="app.apartment.id"
                class="row ombra"
            >
                <div class="col-12 col-md-6 col-lg-4 block">
                    <img :src="app.apartment.imgs" alt="" />
                </div>

                <div class="col-12 col-md-6 col-lg-4 block">
                    <h3>{{ app.apartment.title }}</h3>
                    <div>{{ app.apartment.address }}</div>
                    <div>
                        <i class="fas fa-door-open my-2 mr-md-2"></i>camere:{{
                            app.apartment.n_rooms
                        }}
                        <i class="fas fa-bed my-2 mr-md-2"></i>letti:{{
                            app.apartment.n_beds
                        }}
                    </div>
                    <div class="d-inline-block d-lg-none">bottone</div>
                </div>

                <div class="col-4 block d-none d-lg-block">
                    <div>{{ app.apartment.description }}</div>
                    <div>bottone</div>
                </div>
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
            radius: 20000,
            drop: false
        };
    },
    mounted() {
        // api per elenco servizi
        this.loadApartments(this.radius);
    },

    methods: {
        loadApartments: function(radius) {
            // il raggio della ricerca è espresso in metri
            axios
                .get(
                    "/api/search-results/" +
                        this.$route.params.userInput +
                        "/" +
                        radius.toString()
                )
                .then(response => {
                    this.sponsored_apartments =
                        response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
                })

                .catch(error => {
                    console.log(error);
                });
        },

        dropDown: function() {
            if (this.drop == false) {
                this.drop = true;
            } else {
                this.drop = false;
            }
        }
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

.sel-room {
    width: 60px;
}

.bottom-right {
    float: right;
}

.form-group {
    margin-bottom: 0 !important;
}
</style>
