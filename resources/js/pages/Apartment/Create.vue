<template>
    <div class="container">
        <h1 class="mt-3 mb-3">Create</h1>
        <div>
            <form class="form-group" action="../api/apartment/store" method="post" >

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
                    >
                    </textarea>
                </div>

                <hr>

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

                <hr>

                <h4>Dati casa</h4>

                <!-- stanze letti bagni metri -->
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="n_rooms">Numero stanze</label>
                        <input
                            id="n_rooms"
                            v-model="form.n_rooms"
                            type="number"
                            name="n_rooms"
                        />
                    </div>

                    <div class="form-group col-md-3">
                        <label for="n_beds">Numero letti</label>
                        <input
                            id="n_beds"
                            v-model="form.n_beds"
                            type="number"
                            name="n_beds"
                        />
                    </div>
                    <div class="form-group col-md-3">
                        <label for="n_baths">Numero bagni</label>
                        <input
                            id="n_baths"
                            v-model="form.n_baths"
                            type="number"
                            name="n_baths"
                        />
                    </div>

                    <div class="form-group col-md-3">
                        <label for="square_meters">Metri quadri</label>
                        <input
                            id="square_meters"
                            v-model="form.square_meters"
                            type="number"
                            name="square_meters"
                        />
                    </div>
                </div>

                <hr>

                <h4>Indirizzo</h4>

                <!-- indirizzo -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label class="d-block" for="city">Cittá</label>
                        <input
                            id="city"
                            v-model="form.city"
                            type="text"
                            name="city"
                        />
                    </div>

                    <div class="form-group col-md-3">
                        <label class="d-block" for="zip_code">CAP</label>
                        <input
                            id="zip_code"
                            v-model="form.zip_code"
                            type="number"
                            name="zip_code"
                        />
                    </div>
                    <div class="form-group col-md-3">
                        <label class="d-block" for="street">Indirizzo</label>
                        <input
                            id="street"
                            v-model="form.street"
                            type="text"
                            name="street"
                        />
                    </div>
                    <div class="form-group col-md-3">
                        <label class="d-block" for="address">Civico</label>
                        <input
                            id="address"
                            v-model="form.address"
                            type="text"
                            name="address"
                        />
                    </div>
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
                    <input type="text" name="user_id" :value="form.user_id">
                </div>

                <div class="mt-3">
                    <!-- <input type="submit" value="Submit"/> -->
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <router-link :to="{ name: 'dashboard'}">DASHBOARD</router-link>
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
                city: null,
                zip_code: null,
                street: null,
                address: null,
                visible: 1,
                SelectedServices: []
            },

            services: []
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
                console.log(this.services);
            })
            .catch(error => {
                console.log(error);
            });
    },

    // checkForm: function(e) {
    //     if (this.name && this.age) {
    //         return true;
    //     }
    //     this.errors = [];
    //     if (!this.name) {
    //         this.errors.push("Name required.");
    //     }
    //     if (!this.age) {
    //         this.errors.push("Age required.");
    //     }
    //     e.preventDefault();
    // }
};
</script>

<style lang="scss" scoped>
        
</style>

