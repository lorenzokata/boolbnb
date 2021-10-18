<template>
    <div class="container pt-5">
        <!-- <h1 class="pt-3 mb-3">Create</h1> -->
        <div>
            <div class="d-flex justify-content-between align-items-center pt-3">
                <h2>Crea un nuovo appartamento</h2>
                <router-link class="bottone rosso-background ombra" :to="{ name: 'dashboard' }"
                    ><i class="fas fa-arrow-right"></i></router-link
                >
            </div>

            <form
                id="form"
                class="form-group"
                action="../api/apartment/store"
                @submit.prevent="submit"
                method="post"
                enctype="multipart/form-data"
            >
                <!-- <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
                </p> -->
                <div class="form-row d-flex justify-content-between align-items-center">
                    <div class="form-group mb-3 col-md-8 col-sm-12">
                        <label for="title ">Titolo</label>
                        <input
                            class="form-control"
                            type="text"
                            id="title"
                            v-model="form.title"
                            name="title"
                            required
                        />
                    </div>

                    <div class="ml-3 mr-3">>
                        <label for="visible">Visibile</label>
                        <input
                            id="visible"
                            v-model="form.visible"
                            type="checkbox"
                            name="visible"
                        />
                    </div>
            </div>

                <div class="form-group">
                    <label for="desc">Descrizione</label>
                    <textarea
                        class="form-control"
                        id="desc"
                        v-model="form.description"
                        type="text"
                        name="description"
                        required
                    >
                    </textarea>
                </div>

                <hr />

                <h4>Servizi</h4>

                <!-- select di vue -->
                <div class="row row-cols-2  row-cols-sm-3 row-cols-lg-5">
                    <div
                        class="col"
                        v-for="service in services"
                        :key="service.id"
                    >
                        <input class="d-none"
                            type="checkbox"
                            :id="service.name"
                            :value="service.id"
                            v-model="form.SelectedServices"
                            name="SelectedServices[]"
                        />

                       <!--  <label :for="service.name">{{ service.name }}</label> -->
                        <label  v-if="form.SelectedServices.includes(service)" :for="service.name"><div   class="bottone  my-1 py-2 bott-active-serv" @click="ServiceDisable(form.SelectedServices.indexOf(service))">{{service.name}}</div></label>
                        <label v-else  :for="service.name"><div   class="bottone my-1 py-2 bott-serv opal" @click="ServiceActive(service)" >{{service.name}}</div></label>


                       <!--  <div v-if="SelectedServices.includes(service)"  class="bottone  my-1 py-2 bott-active-serv" @click="ServiceDisable(filter_serve.indexOf(service))">{{service.name}}</div>
                        <div v-else  class="bottone my-1 py-2 bott-serv opal" @click="ServiceActive(service)" >{{service.name}}</div> -->
                    </div>
                </div>

                <hr />

                <h4>Dati casa</h4>

                <!-- stanze letti bagni metri -->
                <div class="form-row">
                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_rooms"
                            >Numero stanze</label
                        >
                        <input
                            id="n_rooms"
                            v-model="form.n_rooms"
                            type="number"
                            name="n_rooms"
                            required
                        />
                    </div>

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_beds">Numero letti</label>
                        <input
                            id="n_beds"
                            v-model="form.n_beds"
                            type="number"
                            name="n_beds"
                            required
                        />
                    </div>
                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_baths"
                            >Numero bagni</label
                        >
                        <input
                            id="n_baths"
                            v-model="form.n_baths"
                            type="number"
                            name="n_baths"
                            required
                        />
                    </div>

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="square_meters"
                            >Metri quadri</label
                        >
                        <input
                            id="square_meters"
                            v-model="form.square_meters"
                            type="number"
                            name="square_meters"
                            required
                        />
                    </div>
                </div>

                <hr />

                <h4>Indirizzo e Foto</h4>
                <div class="form-row d-flex justify-content-between ">


                <!-- indirizzo -->
                <div class="form-group col-md-8 col-sm-12">
                    <label class="d-block" for="address">Indirizzo</label>
                    <input
                        id="address"
                        class="form-control"
                        v-model="form.address"
                        type="text"
                        name="address"
                        required
                        @input="autoAddress()"
                    />
                    <!-- Autocomp -->
                    <div
                        class="list-group"
                        :class="{ 'd-none': addressActive }"
                        v-if="arrayAddress != []"
                    >
                        <ul>
                            <li
                                class="list-group-item input-group"
                                v-for="(address, id) in arrayAddress"
                                :key="id"
                                :v-model="arrayAddress[id]"
                                @click="addressClick(id)"
                            >
                                {{ address }}
                            </li>
                        </ul>
                    </div>
                </div>

                   <div class="input-group col-md-4 col-sm-12">
                        <div class="form-group">
                            <label class="d-block" for="exampleFormControlFile1">Foto</label>
                            <input
                                type="file"
                                class="form-control-file form-control"
                                name="imgs"
                                id="exampleFormControlFile1"
                            />
                        </div>
                    </div>
                </div>

        <!--         <h4>Indirizzo</h4>


                <div class="form-group">
                    <label class="d-block" for="address">Indirizzo</label>
                    <input
                        id="address"
                        class="form-control"
                        v-model="form.address"
                        type="text"
                        name="address"
                        required
                        @input="autoAddress()"
                    />
                     Autocomp
                    <div
                        class="list-group"
                        :class="{ 'd-none': addressActive }"
                        v-if="arrayAddress != []"
                    >
                        <ul>
                            <li
                                class="list-group-item input-group"
                                v-for="(address, id) in arrayAddress"
                                :key="id"
                                :v-model="arrayAddress[id]"
                                @click="addressClick(id)"
                            >
                                {{ address }}
                            </li>
                        </ul>
                    </div>
                </div> -->

                <hr />

                <!-- immagine -->

                <div
                    class="form-row d-flex justify-content-between align-items-center"
                >
                  <!--  form vecchio img
                       <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="form-group">

                            <input
                                type="file"
                                class="form-control-file form-control"
                                name="imgs"
                                id="exampleFormControlFile1"
                            />
                        </div>
                    </div> -->

                    <div class="d-flex justify-content-between">
                        <div class="mb-3 mr-3">
                            <!-- <input type="submit" value="Submit"/> -->
                            <button type="submit" class="bottone rosso-background ombra">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>

                       <!--  <div class="mb-3">
                            <router-link
                                class="bottone rosso-background ombra"
                                :to="{ name: 'dashboard' }"
                                >Pannello di controllo</router-link
                            >
                        </div> -->
                    </div>
                </div>

                <!-- user id display:none - non toccare -->
                <!-- <div class="d-none">
                    <input type="text" name="user_id" :value="form.user_id" />
                </div> -->
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "Create",

    data() {
        return {
            form: {
                title: null,
                description: null,
                n_rooms: 1,
                n_beds: 1,
                n_baths: 1,
                square_meters: 1,
                address: "",
                visible: 1,
                SelectedServices: [],
                image: null
            },

            services: [],
            arrayAddress: [],
            addressActive: true
        };
    },

    mounted() {
        // services contiene elenco di tutti i servizi disponibili

        // api per elenco servizi
        axios
            .get("/api/apartment/create")
            .then(response => {
                this.services = response.data.results;
            })
            .catch(error => {
                console.log(error);
            });
    },

    methods: {
        addressClick: function(id) {
            this.form.address = this.arrayAddress[id];
            this.addressActive = true;
        },

        autoAddress: function() {
            // caso attivo quando form.city !== '' (caso base, PASSO 1)
            axios
                .get("https://api.tomtom.com/search/2/search/.json?", {
                    params: {
                        key: "iYutMJyrnVArnI296DDnCsP4ZX15GiW2",
                        query: this.form.address,
                        // entityTypeSet: "Municipality",
                        language: "it-IT",
                        typeahead: 1,
                        countrySet: "IT"
                    }
                })
                .then(response => {
                    let arr = [];
                    response.data.results.forEach(element => {
                        arr.push(element.address.freeformAddress);
                    });
                    this.arrayAddress = arr;
                    console.log(this.arrayAddress);
                })
                .catch(error => {
                    console.log(error);
                });
            this.addressActive = false;
        },
        submit: function(e) {
            var form = document.getElementById("form");
            var formData = new FormData(form);
            formData.append("user_id", JSON.parse(this.$userId).id);
            axios
                .post("/api/apartment/store", formData)
                .then(response => {
                    this.$router.push("../dashboard");
                })
                .catch(error => {
                    console.log(error);
                });
        },
        ServiceActive: function(serve_id){
            this.form.SelectedServices.push(serve_id);
            console.log(this.form.SelectedServices);
        },
        ServiceDisable: function(serve_id){
            this.form.SelectedServices.splice(serve_id,1);
            console.log(this.form.SelectedServices);
           
        }
    }
};
</script>

<style lang="scss" scoped>
    .bott-serv:hover{
    color: white;
    background-color:#42424286 ;
}
.bott-active-serv{
    
    color: white;
    background-color:#424242 ;
}
</style>
