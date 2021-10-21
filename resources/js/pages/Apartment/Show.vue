<template>
    <div class="container-fluid altezza margin-nav ">
        <div class="my-nav fixed-top altezza-nav"></div>
        <div class="row">
            <div class="col-12 col-lg-7 altezza">
                <h1 class="rosso pt-3">{{ apartment.title }}</h1>
                <div class="indirizzo opal">
                    {{ apartment.address }}
                </div>
                <!-- qui stampo la foto -->
                <div class="img-show ombra">
                    <!-- aggiungere v-if img c'é -->
                    <img :src="apartment.imgs" alt="apartment.title" />
                </div>
            </div>
            <div class="col-12 col-lg-5 my-descrizione">
                
                <!-- v-if="JSON.parse(this.$userId).id !== 'undefined'" -->
                <div class="d-flex justify-content-between align-items-center ">
                    <h3 class="d-block rosso">Dettagli casa</h3>
                    <div>
                        <router-link
                            v-if="this.$userId != ''"
                            class=" bottone rosso-background ombra"
                            :to="{ name: 'dashboard' }"
                            ><i class="fas fa-arrow-right"></i></router-link
                        >
                    </div>
                </div>

                <div>
                    <ul class="dettagli d-inline-block">
                        <li class="d-flex align-items-center">
                            <i
                                class="fas fa-door-open rosso icone my-2 mr-md-2"
                            ></i>
                            numero camere:{{ apartment.n_rooms }}
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-bed rosso icone my-2 mr-md-2"></i>
                            numero letti:{{ apartment.n_beds }}
                        </li>
                        <li class="d-flex align-items-center">
                            <i
                                class="fas fa-toilet rosso icone my-2 mr-md-2"
                            ></i>
                            numero bagni:{{ apartment.n_baths }}
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-home rosso icone my-2 mr-md-2"></i>
                            numero metri quadri:{{ apartment.square_meters }}
                        </li>
                    </ul>
                    <h3 class="d-block rosso mt-3">Servizi della casa</h3>
                    <div class="w-100">
                        <span class="mr-3 my-2 badge badge-pill badge-dark myfont" 
                            v-for="serve in activeservice" :key="serve.service_id"
                        >
                            {{serve.name}}
                        </span>
                    </div>
                </div>
                <h3 class="d-block rosso mt-3">Descrizione</h3>
                <p>
                    {{ apartment.description }} 
                </p>

                <h3 class="d-block rosso mt-3">Locazione della casa</h3>
                <div id="map" style="height: 400px;" class="map"></div>

                <h3 class="d-block rosso mt-5">Invia un' e-mail al proprietario</h3>
                <div v-if="success" class="alert alert-success">
                    Massaggio inviato
                </div>
                <form @submit.prevent="sendForm" class="d-flex flex-column form-group">
                    
                    <label for="senderfullname" class="mt-2 form-group">Nome e Cognome</label>
                    <input required v-model="sender_fullname" name="senderfullname" type="text" class="form-control my-form" id="sender_fullname" />

                    <label for="senderemail" class="mt-2 form-group">E-mail</label>
                    <input required v-model="sender_email" name="senderemail" type="email" class="form-control my-form" id="sender_email"  />

                    <label for="msg" class="mt-2 form-group">Messaggio</label>
                    <textarea required v-model="msg" name="msg" id="msg" class="form-control my-form"></textarea>

                    <button
                        type="submit"
                        class="bottone rosso-background cream mt-3"
                    >
                        {{ sending ? 'Invio in corso' : 'Invia'}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import tt from "@tomtom-international/web-sdk-maps";

export default {
    name: "Show",

    data() {
        return {
            apartment: [],
            sender_fullname: '',
            sender_email: '',
            msg: '',
            apartment_id: 'apartment.id', //se tolgo apartment.id non vá...
            errors: {},
            sending: false,
            success: false,
            activeservice:[],
            user:''
        };
    },

    methods: {
        sendForm(){
            this.sending = true,
            this.success = false,
            axios.post('/api/apartment/email', {
                'sender_fullname': this.sender_fullname,
                'sender_email': this.sender_email,
                'msg': this.msg,
                'apartment_id': this.apartment.id,
            })
                .then(response => {
                    this.success = true, 
                    this.sending = false, 
                    this.sender_fullname = '',
                    this.sender_email = '',
                    this.msg = '',
                    this.apartment.id = '',
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    },

    mounted() {
        // l'appartamento é in apartment
        // i services del appartamento sono in apartment.services (array)
        if(this.$userId){
            this.user = JSON.parse(this.$userId);
            this.sender_email = this.user.email;
            this.sender_fullname = this.user.name + ' ' + this.user.surname;
        };
        
        

        axios
            .get("/api/apartment/show/" + this.$route.params.slug)
            .then(response => {
                this.apartment = response.data.results;
                this.activeservice=response.data.results.services;
                console.log(this.apartment);
                console.log(this.activeservice);

                const map = tt.map({
                    key: "OAL2BjJEi54pYkhRoSNH7o8ZTRp5E21p",
                    container: "map",
                    center: [
                        parseFloat(this.apartment.lon),
                        parseFloat(this.apartment.lat)
                    ],
                    zoom: 12
                });

                map.doubleClickZoom.disable();
                map.dragPan.disable();
                map.dragRotate.disable();
                map.scrollZoom.disable();

               /*  var marker = new tt.Marker()
                .setLngLat([parseFloat(this.apartment.lon), parseFloat(this.apartment.lat)])
                .addTo(map); */
                
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>

<style lang="scss" scoped>
.myfont{
    
   font-size: 15px;
}

.indirizzo {
    text-decoration: underline;
    font-size: 18px;
}
.icone {
    font-size: 25px;
}

.img-show {
    width: 100%;
    height: 80%;
    img {
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
}
.dettagli {
    list-style-type: none;
}
.my-descrizione {
    height: calc(100vh - 60px);
    width: 100%;
    overflow-y: scroll;
    padding-top: 60px;
    scrollbar-width: none;
    &::-webkit-scrollbar {
        display: none;
    }
}
</style>
