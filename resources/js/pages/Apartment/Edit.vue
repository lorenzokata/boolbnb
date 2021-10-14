<template>
    <div class="container mb-3">

        <div class="d-flex justify-content-between align-items-center pt-3">
            <h4 class="">Modifica appartemento</h4>
            <div>
                <router-link class="bottone rosso-background ombra" :to="{ name: 'dashboard'}">Pannello di controllo</router-link>
            </div>
        </div>

        <div>
            <h1 class="rosso" > {{exApartmentTitle}} </h1>
            <form id="form" class="form-group" @submit.prevent="submit" action="../api/apartment/update" method="post" enctype="multipart/form-data">
                
                <div class="form-row d-flex justify-content-between align-items-center">

                    <!-- indirizzo -->
                    <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Modifica titolo</span>
                        </div>
                        <input name="title" id="title" v-model="apartment.title" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
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

                <!-- foto -->
                <div class="d-flex justify-content-center">
                    <img class="foto" :src="apartment.imgs" alt="apartment.title">
                </div>

                <h4 class="mt-3">Descrizione</h4>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Modifica descrizione</span>
                    </div>
                    <textarea v-model="apartment.description" id="desc" class="form-control" aria-label="With textarea" name="description" required></textarea>
                </div>                

                <hr>

                <h4 class="mb-1">Servizi</h4>

                <!-- select di vue -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4">
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

                <div v-for="(service, index) in apartment.services" :key="index">
                     {{ service.name }}
                </div>

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
                    <input @input="autoAddress()" id="address" v-model="apartment.address" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="address" required>

                    
                </div>

                    <!-- suggeriti -->
                    <div class="list-group suggeriti"
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
                    
                <hr>

                <!-- immagine -->
                <h4>Cambia foto</h4>
                <div class="form-row d-flex justify-content-between align-items-center">
                    <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="custom-file">
                            <input name="imgs" type="file" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Scegli file...</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="mb-3 mr-3">
                            <!-- <input type="submit" value="Submit"/> -->
                            <button type="submit" class="bottone rosso-background ombra">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>

                        <div class="mb-3">
                            <router-link class="bottone rosso-background ombra" :to="{ name: 'dashboard'}">Pannello di controllo</router-link>
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
    name: "Edit",

    data() {
        return {
            form: {
                title: null,
                description: null,
    
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

            exApartmentTitle: '',
            apartment: [],
            arrayAddress: [],
            addressActive: true,
            services: []
            // errors: [],
        };
    },

    mounted() {

        // api per dati appartamento
        axios
            .get("/api/apartment/" + this.$route.params.slug + "/edit")
            .then(respo => {
                this.apartment = respo.data.results.apartment;
                this.services = respo.data.results.services;
                // console.log(this.apartment.services);
                this.exApartmentTitle = this.apartment.title;
                console.log(this.exApartmentTitle);
            })
            .catch(error => {
                console.log(error);
            });

        
        
        

    },
    methods: {
        addressClick: function(id) {
            this.apartment.address = this.arrayAddress[id];
            this.addressActive = true;
        },
        autoAddress: function() {
            // caso attivo quando form.city !== '' (caso base, PASSO 1)
            axios
                .get("https://api.tomtom.com/search/2/search/.json?", {
                    params: {
                        key: "iYutMJyrnVArnI296DDnCsP4ZX15GiW2",
                        query: this.apartment.address,
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
                })
                .catch(error => {
                    console.log(error);
                });
            this.addressActive = false;
        },
        submit: function(e){
            var form = document.getElementById('form');
            var formData = new FormData(form);
            formData.append('user_id', JSON.parse(this.$userId).id);
            formData.append('slug', this.apartment.slug);
            axios.post('/api/apartment/update', formData)
            .then((response) => {
                this.$router.push('../dashboard') 
            })
            .catch((error) =>{
                console.log(error);
            })
        }
    }
};
</script>

<style lang="scss" scoped>

.suggeriti{
    margin: 0 132px;
    min-width: 200px;
    max-height: 200px;
    overflow-y: auto;
}

@media screen and (max-width: 768px) {
    .suggeriti{
    margin: 0 0 0 132px;
    }
}

.foto{
    max-width: 700px;
    width: 100%;
}

</style>



