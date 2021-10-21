<template>
    <div class="container altezza margin-nav">
        <div class="my-nav fixed-top altezza-nav"></div>

        <!-- ricerca avanzata -->
        <div>
            <!-- cerca e dropdown icon -->
            <div class="d-flex justify-content-between align-items-center">

                <h1 class="rosso">Risultati ricerca</h1>

                <div
                    @click="dropDown"
                    class="dropdown bottone rosso-background cream ombra"
                >
                    <i class="fas fa-sort-amount-down fa-lg"></i>
                </div>
            </div>

            <!-- menu dropdown al click -->
            <div
                :class="drop == false ? 'd-none' : ''"
                class="border-rad ombra row row-cols-2 mt-3 mb-5"
            >
                <div v-if="success_F" class="alert alert-success _alert">filtrato</div>
                <!-- stanze e letti -->
                <div class="col p-3">
                    <h2 class="rosso">Stanze e letti</h2>

                    <div class="d-inline-block mt-1 mr-4">
                        <h5>Stanze</h5>
                        <select v-model="n_rooms" class="form-control sel-room">
                            <option v-for="n in 10" :key="n">{{ n }}</option>
                        </select>
                    </div>

                    <div class="d-inline-block mt-1 mr-4">
                        <h5>Letti</h5>
                        <select v-model="n_beds" class="form-control sel-room">
                            <option v-for="n in 10" :key="n">{{ n }}</option>
                        </select>
                    </div>
                </div>

                <!-- distanza -->
                <div class="col p-3">
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
                        @click="loadApartments(radius , true)"
                    >
                        Applica filtro
                    </div>
                </div>

                <!-- servizi aggiuntivi - sistemare-->
                <div class="col-12 pl-3">
                    <h2 class="rosso">Servizi aggiuntivi</h2>
                    <div class="row row-cols-5">
                        <div
                            class="col"
                            v-for="service in services"
                            :key="service.id"
                        >
                            <div v-if="filter_serve.includes(service.id)"  class="bottone  my-1 py-2 bott-active-serv" @click="ServiceDisable(filter_serve.indexOf(service.id))">{{service.name}}</div>
                            <div v-else  class="bottone my-1 py-2 bott-serv opal" @click="ServiceActive(service.id)" >{{service.name}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- sponsored apartments -->
        <!-- <div> -->
            <!-- <input type="num" v-model="radius" @input="loadApartments(radius)"> -->
            <!-- <h2
                v-if="Object.keys(sponsored_apartments).length != 0"
                class="rosso mt-3"
            >
                Appartamenti sponsorizzati: {{sponsored_apartments.length}} risultati
            </h2>

               <div 
                v-for="s_app in sponsored_apartments"
                :key="s_app.apartment.id"
                class="row ombra py-3 my-5 border-rad my-bottone-hv"
            >
                <div class="col-12 col-md-6 col-lg-4 block mt-4">
                    <img :src="'../../storage/'+s_app.apartment.imgs" alt="" />
                </div>

                <div class="col-12 col-md-6 col-lg-4 block ">
                    <h3>{{ s_app.apartment.title }}</h3>
                    <div class="my-3">{{ s_app.apartment.address }}</div>
                    <div class="my-3 d-flex align-items-center">
                        <i class="fas fa-door-open my-2 mr-2"></i>camere:{{
                            s_app.apartment.n_rooms
                        }}  
                        <i class="fas fa-bed my-2 ml-2 mr-2"></i>letti:{{
                            s_app.apartment.n_beds
                        }}
                    </div>
                    <div class="mt-5 d-inline-block d-lg-none float-right"><router-link class="bottone rosso-background ombra mx-1 slide-in-elliptic-top-fwd  my-disp" :to="{ name: 'show', params: { slug: s_app.apartment.slug }}">Dettagli</router-link></div>
                </div>

                <div class="col-4 block d-none d-lg-block my-bottone-hv">
                    <div class="mb-4">{{ s_app.apartment.description.substring(0,300) }}</div>
                    <router-link class="mt-5 float-right bottone rosso-background ombra mx-1 slide-in-elliptic-top-fwd  my-disp" :to="{ name: 'show', params: { slug: s_app.apartment.slug }}">Dettagli</router-link>
                </div>
            </div> -->

        <!-- apartments -->
        <div>
            <h2 class="rosso mt-3" v-if="Object.keys(apartments).length != 0">Ci sono {{apartments.length}} risultati</h2>
            <h2 class="rosso mt-3" v-else>Al momento non ci sono appartamenti in questa città</h2>
            <div
                v-for="app in apartments"
                :key="app.apartment.id"
                class="row ombra py-3 my-5 border-rad my-bottone-hv"
            >
                <div class="col-12 col-md-6 col-lg-4 block mt-4">
                    <img :src="'../../storage/'+app.apartment.imgs" alt="" />
                </div>

                <div class="col-12 col-md-6 col-lg-4 block">
                    <h3>{{ app.apartment.title }}</h3>
                    <div class="my-3">{{ app.apartment.address }}</div>
                    <div class="my-3  d-flex align-items-center">
                        <i class="fas fa-door-open my-2 mr-md-2"></i>camere:{{
                            app.apartment.n_rooms
                        }}   
                        <i class="fas fa-bed my-2 ml-2 mr-md-2"></i>letti:{{
                            app.apartment.n_beds
                        }}
                    </div>
                    <div class="mt-5 d-inline-block d-lg-none float-right"><router-link class=" bottone rosso-background ombra mx-1 slide-in-elliptic-top-fwd  my-disp" :to="{ name: 'show', params: { slug: app.apartment.slug }}">Dettagli</router-link></div>
                </div>

                <div class="col-4 block d-none d-lg-block">
                    <div class="mb-4">{{ app.apartment.description.substring(0,300) }}...</div>
                    <router-link class="mt-5 float-right bottone rosso-background ombra mx-1 slide-in-elliptic-top-fwd  my-disp" :to="{ name: 'show', params: { slug: app.apartment.slug }}">Dettagli</router-link>
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
            // sponsored_apartments: [],
            apartments: [],
            services:[],
            filter_serve:[],
            radius: 20000,
            drop: false,
            n_rooms: 1,
            n_beds: 1,
            filterS:'',
            success_F: false,
        };
    },
    mounted() {
        // api per elenco servizi

        this.loadApartments(this.radius, false);

    },

    methods: {
        switchAlertOff: function(){
            this.success_F = false;
            console.log('calback');
        },

        loadApartments: function(radius, filtro) {
            // il raggio della ricerca è espresso in metri
            
            this.filterS = '';
            
            if(this.filter_serve.length > 0){
                for(let i=0 ; i < this.filter_serve.length; i++){
                    if(i != this.filter_serve.length - 1){
                        this.filterS += this.filter_serve[i] + '%'; 
                    }else{
                        this.filterS += this.filter_serve[i]; 
                    }
                    
                }
            }else{
                this.filterS = 'null';
            }
                    

            axios
                .get(
                    "/api/search-results/" +
                        this.$route.params.userInput + "/" +
                        radius.toString() + "/" +
                        this.n_beds.toString() + "/" +
                        this.n_rooms.toString() + "/" +
                        this.filterS 
                )
                .then(response => {
                    // console.log(response.data.results);
                    // this.sponsored_apartments =
                    //     response.data.results.sponsored_apartments;
                    this.apartments = response.data.results.apartments;
                    this.services = response.data.results.services;
                    if(filtro == true){
                        this.success_F = true;
                        setTimeout(() => this.success_F = false, 2000);
                    }
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
        },

        ServiceActive: function(serve_id){
            this.filter_serve.push(serve_id);
        },
        ServiceDisable: function(serve_id){
            this.filter_serve.splice(serve_id,1);
           
        }
    }
};
</script>

<style lang="scss" scoped>
    .block{ 
        height: 250px;
            margin: auto 0;
        img{
            height: 90%;
            width: 90%;
            margin: auto 0;
        }
    }
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

.bott-serv:hover{
    color: white;
    background-color:#42424286 ;
}
.bott-active-serv{
    
    color: white;
    background-color:#424242 ;
}
.rosso-background:hover{
     text-decoration: none;
    background-color:#f11e28;
    border: 3px solid rgba(0, 0, 0, 0);
    transition: 0.5s;
    color: white;
}

.my-disp{display: none;}

.my-bottone-hv{

    .slide-out-elliptic-top-bck {
        -webkit-animation: slide-out-elliptic-top-bck 0.7s ease-in both;
                animation: slide-out-elliptic-top-bck 0.7s ease-in both;
    }
}

.my-bottone-hv:hover{
    .my-disp{display: inline-block;}
    .slide-in-elliptic-top-fwd {
	-webkit-animation: slide-in-elliptic-top-fwd 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
	        animation: slide-in-elliptic-top-fwd 0.7s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}
}

////////////////////////////////////////////////

@-webkit-keyframes slide-in-elliptic-top-fwd {
  0% {
    -webkit-transform: translateY(-600px) rotateX(-30deg) scale(0);
            transform: translateY(-600px) rotateX(-30deg) scale(0);
    -webkit-transform-origin: 50% 100%;
            transform-origin: 50% 100%;
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0) rotateX(0) scale(1);
            transform: translateY(0) rotateX(0) scale(1);
    -webkit-transform-origin: 50% 1400px;
            transform-origin: 50% 1400px;
    opacity: 1;
  }
}
@keyframes slide-in-elliptic-top-fwd {
  0% {
    -webkit-transform: translateY(-600px) rotateX(-30deg) scale(0);
            transform: translateY(-600px) rotateX(-30deg) scale(0);
    -webkit-transform-origin: 50% 100%;
            transform-origin: 50% 100%;
    opacity: 0;
  }
  100% {
    -webkit-transform: translateY(0) rotateX(0) scale(1);
            transform: translateY(0) rotateX(0) scale(1);
    -webkit-transform-origin: 50% 1400px;
            transform-origin: 50% 1400px;
    opacity: 1;
  }
}

@-webkit-keyframes slide-out-elliptic-top-bck {
  0% {
    -webkit-transform: translateY(0) rotateX(0) scale(1);
            transform: translateY(0) rotateX(0) scale(1);
    -webkit-transform-origin: 50% 1400px;
            transform-origin: 50% 1400px;
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-600px) rotateX(-30deg) scale(0);
            transform: translateY(-600px) rotateX(-30deg) scale(0);
    -webkit-transform-origin: 50% 100%;
            transform-origin: 50% 100%;
    opacity: 1;
  }
}
@keyframes slide-out-elliptic-top-bck {
  0% {
    -webkit-transform: translateY(0) rotateX(0) scale(1);
            transform: translateY(0) rotateX(0) scale(1);
    -webkit-transform-origin: 50% 1400px;
            transform-origin: 50% 1400px;
    opacity: 1;
  }
  100% {
    -webkit-transform: translateY(-600px) rotateX(-30deg) scale(0);
            transform: translateY(-600px) rotateX(-30deg) scale(0);
    -webkit-transform-origin: 50% 100%;
            transform-origin: 50% 100%;
    opacity: 1;
  }
}
._alert{
    position: fixed;
    top: 100px;
    left: 50%;
    transform: translateX(-50%);
    width: 50%;
    z-index: 999999999;
}
</style>
