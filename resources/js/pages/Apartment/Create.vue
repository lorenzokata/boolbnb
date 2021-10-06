<template>
    <div>
        <h1>Create</h1>
        <div class="container">
            <form
                action="../api/apartment/store"
                method="post"
            >
                <!-- <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
                </p> -->

                <p>
                    <label for="title">Title</label>
                    <input
                        type="text"
                        id="title"
                        v-model="form.title"
                        name="title"
                    />
                </p>

                <p>
                    <label for="desc">Description</label>
                    <textarea
                        id="desc"
                        v-model="form.description"
                        type="text"
                        name="description"
                    >
                    </textarea>
                </p>

                <!-- select di vue -->
                <div class="row row-cols-2">
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

                <p>
                    <label for="n_rooms">Numero stanze</label>
                    <input
                        id="n_rooms"
                        v-model="form.n_rooms"
                        type="number"
                        name="n_rooms"
                    />
                </p>
                <p>
                    <label for="n_beds">Numero letti</label>
                    <input
                        id="n_beds"
                        v-model="form.n_beds"
                        type="number"
                        name="n_beds"
                    />
                </p>
                <p>
                    <label for="n_baths">Numero bagni</label>
                    <input
                        id="n_baths"
                        v-model="form.n_baths"
                        type="number"
                        name="n_baths"
                    />
                </p>
                <p>
                    <label for="square_meters">Metri quadri</label>
                    <input
                        id="square_meters"
                        v-model="form.square_meters"
                        type="number"
                        name="square_meters"
                    />
                </p>
                <p>
                    <label for="city">Cittá</label>
                    <input
                        id="city"
                        v-model="form.city"
                        type="text"
                        name="city"
                    />
                </p>
                <p>
                    <label for="zip_code">CAP</label>
                    <input
                        id="zip_code"
                        v-model="form.zip_code"
                        type="number"
                        name="zip_code"
                    />
                </p>
                <p>
                    <label for="street">Indirizzo</label>
                    <input
                        id="street"
                        v-model="form.street"
                        type="text"
                        name="street"
                    />
                </p>
                <p>
                    <label for="address">Civico</label>
                    <input
                        id="address"
                        v-model="form.address"
                        type="text"
                        name="address"
                    />
                </p>
                <p>
                    <label for="visible">Visibile</label>
                    <input
                        id="visible"
                        v-model="form.visible"
                        type="checkbox"
                        name="visible"
                    />
                </p>
                <p class="d-none">
                    <input type="text" name="user_id" :value="form.user_id">
                </p>

                <p>
                    <input type="submit" value="Submit"/>
                </p>
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
