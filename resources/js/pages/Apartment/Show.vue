<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-7 altezza">
                <h1 class="rosso text-center pt-3">{{ apartment.title }}</h1>
                <div class="margin-l-7 indirizzo opal">
                    {{ apartment.address }}
                </div>
                <!-- qui stampo la foto -->
                <div class="img-show ombra">
                    <!-- aggiungere v-if img c'é -->
                    <img :src="apartment.imgs" alt="apartment.title" />
                </div>
            </div>
            <div class="col-12 col-lg-5 my-descrizione">
                <!-- <h3 class="d-block rosso">Dettagli casa</h3> -->
                
<!-- v-if="JSON.parse(this.$userId).id !== 'undefined'" -->
                <div class="d-flex justify-content-between align-items-center ">
                    <h3 class="d-block rosso">Dettagli casa</h3>
                    <div>
                        <router-link 
                            v-if="this.$userId != ''"
                            class=" bottone rosso-background ombra"
                            :to="{ name: 'dashboard' }"
                            >Pannello di controllo</router-link
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
                    <div>
                        <div>
                            Lorem ipsum dolor sit amet consectetur, adipisicing
                            elit. Eaque, illum accusamus rem ad expedita
                            architecto saepe magnam? Dolores quia iste cumque
                            culpa unde ducimus sint vel dolorum dolorem, quam
                            est.
                        </div>
                    </div>
                </div>
                <h3 class="d-block rosso mt-3">Descrizione</h3>
                <p>
                    {{ apartment.description }} Lorem, ipsum dolor sit amet
                    consectetur adipisicing elit. Facilis quisquam commodi magni
                    exercitationem corporis odio, asperiores totam illo rem
                    doloribus! Debitis inventore asperiores eum, unde distinctio
                    accusantium quisquam ducimus cupiditate? Lorem ipsum dolor
                    sit amet consectetur adipisicing elit. Ut eaque beatae
                    minima nemo eligendi quos facere molestias vitae laudantium
                    quaerat iste quasi voluptas incidunt totam nam iure,
                    voluptatum veritatis dolores?
                </p>

                <h3 class="d-block rosso mt-3">Locazione della casa</h3>
                <div class="img-show">
                    <!-- <div id="map" style="width: 100px; height: 100px;"></div> -->
                    <img
                        src="https://developers.google.com/codelabs/maps-platform/webgl/img/webgl_pin_final.png"
                        alt=""
                    />
                </div>

                <h3 class="d-block rosso mt-3">Invia un' e-mail al proprietario</h3>
                <form @submit.prevent="sendForm" class="d-flex flex-column">
                    
                    <label for="senderfullname" class="mt-2">Nome e Cognome</label>
                    <input v-model="sender_fullname" name="senderfullname" type="text" class="form-control" id="sender_fullname" />

                    <label for="senderemail" class="mt-2">E-mail</label>
                    <input v-model="sender_email" name="senderemail" type="text" class="form-control" id="sender_email"  />

                    <label for="msg" class="mt-2">Messaggio</label>
                    <textarea v-model="msg" name="msg" id="msg" class="form-control"></textarea>

                    <!-- maniera poco carina per passare apartment_id -->
                    <textarea v-model="apartment_id" name="" id="apartment_id" class="d-none"></textarea>

                    <button
                        type="submit"
                        class="bottone rosso-background cream mt-3"
                    >
                        Invia
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Show",

    data() {
        return {
            apartment: [],
            sender_fullname: '',
            sender_email: '',
            msg: '',
            apartment_id: '1', //da passare in maniera dinamica
            errors: {}
        };
    },

    methods: {
        sendForm(){
            axios.post('/api/apartment/email', {
                'sender_fullname': this.sender_fullname,
                'sender_email': this.sender_email,
                'msg': this.msg,
                'apartment_id': this.apartment_id
            })
                .then(response =>
                    console.log(response)
                )
                .catch(error => {
                    console.log(error);
                })
        }
    },

    mounted() {

        // l'appartamento é in apartment
        // i services del appartamento sono in apartment.services (array)
        
        axios
            .get("/api/apartment/show/" + this.$route.params.slug)
            .then(response => {
                this.apartment = response.data.results;
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>

<style lang="scss" scoped>
.indirizzo {
    text-decoration: underline;
    font-size: 18px;
}
.icone {
    font-size: 25px;
}

.img-show {
    width: 100%;
    height: 83%;
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
}
</style>
