<template>
    <div class="container margin-nav">
        <h1 class="pt-3 mb-3">Create</h1>
        <div>
            <form class="form-group" action="../api/apartment/store" method="post" enctype="multipart/form-data" >

                <!-- <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
                </p> -->

                <div class="form-group">
                    <label for="title">Titolo</label>
                    <input
                        class="form-control"
                        type="text"
                        id="title"
                        v-model="form.title"
                        name="title"
                        required
                    />
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
                <div class="row row-cols-3">
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

                        <label :for="service.name">{{ service.name }}</label>
                    </div>
                </div>

                <hr />

                <h4>Dati casa</h4>

                <!-- stanze letti bagni metri -->
                <div class="form-row">
                    <div class="form-group col-md-3">
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

                    <div class="form-group col-md-3">
                        <label class="d-block" for="n_beds">Numero letti</label>
                        <input
                            id="n_beds"
                            v-model="form.n_beds"
                            type="number"
                            name="n_beds"
                            required
                        />
                    </div>
                    <div class="form-group col-md-3">
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

                    <div class="form-group col-md-3">
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

                <h4>Indirizzo</h4>

                <!-- indirizzo -->
                <div class="form-group">
                    <label class="d-block" for="address">Indirizzo</label>
                    <input
                        id="address"
                        class="d-block w-100 p-3 rounded-pill border border-light"
                        v-model="form.address"
                        type="text"
                        name="address"
                        required
                        @input="autoAddress()"
                    />
                    <!-- AGGIUNTO PER TEST -->
                    <div
                        class="list-group"
                        :class="{ 'd-none': addressActive }"
                        v-if="arrayAddress != []"
                    >
                        <ul>
                            <li
                                class="list-group-item"
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

                <hr>
                
                <!-- immagine -->
                <div class="form-group">
                    <label for="imgIn">Carica foto</label>
                    <input type="file" name="image" class="form-control-file" id="imgIn">
                </div>

                <hr>

                <div>
                    <label for="visible">Visibile</label>
                    <input
                        id="visible"
                        v-model="form.visible"
                        type="checkbox"
                        name="visible"
                    />
                </div>
                <div class="d-none">
                    <input type="text" name="user_id" :value="form.user_id" />
                </div>

                <div class="mt-3">
                    <!-- <input type="submit" value="Submit"/> -->
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </form>

            <router-link :to="{ name: 'dashboard' }">DASHBOARD</router-link>
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
                user_id: JSON.parse(this.$userId).id,
                n_rooms: 1,
                n_beds: 1,
                n_baths: 1,
                square_meters: null,
                address: "",
                visible: 1,
                SelectedServices: []
            },
            services: [],
            arrayAddress: [],
            addressActive: true
            // errors: [],
        };
    },

    mounted() {
        console.log("Component mounted.");

        // api per elenco servizi
        axios
            .get("/api/apartment/create")
            .then(response => {
                this.services = response.data.results;
                // console.log(this.services);
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
        }
    }

};
</script>

<style lang="scss" scoped></style>
