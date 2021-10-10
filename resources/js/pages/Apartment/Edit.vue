<template>
    <div class="container margin-nav mb-3">

        <div class="d-flex justify-content-between align-items-center pt-3">
            <h4 class="">Edit</h4>
            <div>
                <router-link class="btn btn-primary" :to="{ name: 'dashboard'}">Dashboard</router-link>
            </div>
        </div>

        <div>
            <h1 class="viola"> {{apartment.title}} </h1>
            <form class="form-group" action="../api/apartment/store" method="post" >

                <!-- <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
                    </ul>
                </p> -->
                
                <div class="form-row d-flex justify-content-between align-items-center">

                    <!-- indirizzo -->
                    <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Modifica titolo</span>
                        </div>
                        <input id="title" v-model="apartment.title" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
                    </div>   
                    
                    <div class="ml-3 mr-3">
                        <label for="visible">Visibile</label>
                        <input
                            id="visible"
                            v-model="apartment.visible"
                            type="checkbox"
                            name="visible"
                        />
                    </div>  
                </div>
                
                <!-- <div class="input-group mb-3 col-md-6 col-sm-12">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input  v-model="apartment.visible" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                    </div>
                    <input id="visible" type="text" class="form-control" aria-label="Text input with checkbox">
                </div>                                               -->

                <!-- qui stampo la foto -->
                <div>
                    <img class="my-w-100" :src="apartment.imgs" alt="apartment.title">
                </div>

                <h4 class="mt-3">Descrizione</h4>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Modifica descrizione</span>
                    </div>
                    <textarea v-model="apartment.description" id="desc" class="form-control" aria-label="With textarea" name="description" required></textarea>
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

                    <div class="input-group mb-3 col-md-3 col-sm-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="address">N. stanze</span>
                        </div>
                        <input id="address" v-model="apartment.n_rooms" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="n_rooms" required>
                    </div>   

                    <div class="input-group mb-3 col-md-3 col-sm-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="address">N. letti</span>
                        </div>
                        <input id="address" v-model="apartment.n_beds" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="n_beds" required>
                    </div> 

                    <div class="input-group mb-3 col-md-3 col-sm-6 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="address">N. bagni</span>
                        </div>
                        <input id="address" v-model="apartment.n_baths" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="n_baths" required>
                    </div>                    

                    <div class="input-group mb-3 col-md-3 col-sm-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="address">Metri quadri</span>
                        </div>
                        <input id="address" v-model="apartment.square_meters" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="square_meters" required>
                    </div>                    

                </div>

                <hr>

                <h4>Indirizzo</h4>

                <!-- indirizzo -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="address">Modifica indirizzo</span>
                    </div>
                    <input id="address" v-model="apartment.address" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
                </div>

                <hr>

                <!-- immagine -->
                <h4>Cambia foto</h4>
                <div class="form-row d-flex justify-content-between align-items-center">
                    <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Scegli file...</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="mb-3 mr-3">
                            <!-- <input type="submit" value="Submit"/> -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        <div class="mb-3">
                            <router-link class="btn btn-primary" :to="{ name: 'dashboard'}">Dashboard</router-link>
                        </div>

                    </div>
                </div>


                <!-- user id display:none - non toccare -->
                <div class="d-none">
                    <input type="text" name="user_id" :value="form.user_id">
                </div>
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

            id: '11',
            apartment: [],

            services: []
            // errors: [],
        };
    },

    mounted() {
        // console.log("Component mounted.");

        // api per elenco servizi
        // axios
        //     .get("/api/apartment/create")
        //     .then(response => {
        //         this.services = response.data.results;
        //         console.log(this.services);
        //     })
        //     .catch(error => {
        //         console.log(error);
        //     });

        // api per dati appartamento
        axios
            .get("/api/apartment/" + this.id + "/edit")
            .then(respo => {
                this.apartment = respo.data.results;
                console.log(this.apartment);
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



