<template>
    <div class="container altezza margin-nav">
        <div class="my-nav fixed-top altezza-nav"></div>
        <div class="d-flex justify-content-between align-items-center pt-3">
            <h4 class="">Modifica appartemento</h4>
            <div>
                <router-link class="bottone rosso-background ombra" :to="{ name: 'dashboard'}"><i class="fas fa-arrow-right"></i></router-link>
            </div>
        </div>

        <div>
            <h1 class="rosso" > {{exApartmentTitle}} </h1>
            <form id="form" class="form-group" @submit.prevent="submit" action="../api/apartment/update" method="post" enctype="multipart/form-data">
                
                <div class="form-row d-flex justify-content-between align-items-center">

                    <!-- indirizzo -->
                   <!--  <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Modifica titolo</span>
                        </div>
                        <input name="title" id="title" v-model="apartment.title" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
                    </div>   
         -->
                    <div class="form-group mb-3 col-md-8 col-sm-12">
                        <label for="title ">Titolo</label>
                        <input
                            class="form-control"
                            type="text"
                            id="title"
                            v-model="apartment.title"
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

                <!-- foto -->
               <!--  <div class="d-flex justify-content-center">
                    <img class="foto" :src="apartment.imgs" alt="apartment.title">
                </div> -->

                <h4 class="mt-3">Modifica Descrizione</h4>

                <div class="input-group">
                    <textarea
                        class="form-control"
                        id="desc"
                        v-model="apartment.description"
                        type="text"
                        name="description"
                        required
                    >
                    </textarea>
                </div>                

                <hr>

                <h4 class="mb-1">Servizi</h4>

                <!-- select di vue -->
                <div class="row row-cols-2  row-cols-sm-3 row-cols-lg-5">
                    <div
                        class="col"
                        v-for="(service) in services"
                        :key="service.id"
                    >
                        <input class="d-none"
                            type="checkbox"
                            :id="service.name"
                            :value="service.id"
                            v-model="activeservice"
                            name="SelectedServices[]"
                           
                        />

                       <!--  <label :for="service.name">{{ service.name }}</label> -->
                        <label v-if=" activeservice.includes(service.id) " :for="service.name"><div   class="bottone  my-1 py-2 bott-active-serv" @click="ServiceDisable(myPosition(service,SelectedServices),myPosition(service.id,activeservice))">{{service.name}}</div></label>
                        <label v-else  :for="service.name"><div   class="bottone my-1 py-2 bott-serv opal" @click="ServiceActive(service)" >{{service.name}}</div></label>


                       <!--  <div v-if="SelectedServices.includes(service)"  class="bottone  my-1 py-2 bott-active-serv" @click="ServiceDisable(filter_serve.indexOf(service))">{{service.name}}</div>
                        <div v-else  class="bottone my-1 py-2 bott-serv opal" @click="ServiceActive(service)" >{{service.name}}</div> -->
                    </div>
                </div>
                <hr>

                <h4>Dati casa</h4>

                <!-- <div v-for="(service, index) in apartment.services" :key="index">
                     {{ service.name }}
                </div> -->

                <!-- stanze letti bagni metri -->
                <div class="form-row">

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_rooms"
                            >Numero stanze</label
                        >
                        <input
                            id="n_rooms"
                            v-model="apartment.n_rooms"
                            type="number"
                            name="n_rooms"
                            required
                            min="1"
                            max="16"
                        />
                    </div> 

                     <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_beds">Numero letti</label>
                        <input
                            id="n_beds"
                            v-model="apartment.n_beds"
                            type="number"
                            name="n_beds"
                            required
                            min="1"
                            max="20"
                        />
                    </div>

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="n_baths"
                            >Numero bagni</label
                        >
                        <input
                            id="n_baths"
                            v-model="apartment.n_baths"
                            type="number"
                            name="n_baths"
                            required
                            min="1"
                            max="16"
                        />
                    </div>                   

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block" for="square_meters"
                            >Metri quadri</label
                        >
                        <input
                            id="square_meters"
                            v-model="apartment.square_meters"
                            type="number"
                            name="square_meters"
                            required
                            min="10"
                            max="1500"
                        />
                    </div>                   

                </div>

                <hr>

                <h4>Indirizzo</h4>

                <!-- indirizzo -->
 <!--                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="address">Modifica indirizzo</span>
                    </div>
                    <input @input="autoAddress()" id="address" v-model="apartment.address" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="address" required>

                    
                </div>

                     suggeriti -->
                   <!--  <div class="list-group suggeriti"
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
                    </div> --> 
                    
                    <div class="form-row d-flex justify-content-between ">


                <!-- indirizzo -->
                <div class="form-group col-md-8 col-sm-12">
                    <label class="d-block" for="address">Indirizzo</label>
                    <input
                        id="address"
                        class="form-control"
                        v-model="apartment.address"
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
                <hr>

                <!-- immagine -->
                <!-- <h4>Cambia foto</h4> -->
                <div class="float-right form-row d-flex justify-content-between align-items-center">
                    <!-- <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="custom-file">
                            <input name="imgs" type="file" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Scegli file...</label>
                        </div>
                    </div>
 -->
                    <div class="d-flex justify-content-between">
                        <div class="mb-3 mr-3">
                            <!-- <input type="submit" value="Submit"/> -->
                            <button type="submit" class="bottone rosso-background ombra">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>

                        <!-- <div class="mb-3">
                            <router-link class="bottone rosso-background ombra" :to="{ name: 'dashboard'}">Pannello di controllo</router-link>
                        </div> -->

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
            activeservice:[],
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

                this.form.SelectedServices=respo.data.results.apartment.services;

                respo.data.results.apartment.services.forEach(serve => {
                        this.activeservice.push(serve.id)
                });
                
                /*  this.form.SelectedServices = respo.data.results.apartment.services.id; */
                 console.log(this.form.SelectedServices);
                console.log(respo.data.results.apartment.services);
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
        },

            ServiceActive: function(serve_id){
                if(!this.form.SelectedServices.includes(serve_id)){
                    this.form.SelectedServices.push(serve_id);
                    this.activeservice.push(serve_id.id);
                }
            console.log(this.form.SelectedServices);
            console.log(this.activeservice);
            /* console.log(this.form.SelectedServices); */
        },
        ServiceDisable: function(posselect,posid ){
            /* console.log(serve_id); */
            this.form.SelectedServices.splice(posselect,1);
            this.activeservice.splice(posid,1)


            console.log(this.form.SelectedServices);
            console.log(this.activeservice);
           
        },

        myInclude: function(serve){
            for(var i=0;i<this.form.SelectedServices.length;i++){
                if(this.form.SelectedServices[i].id==serve.id){
                    console.log('ciao');
                   return true
                }
            }
            if(this.form.SelectedServices.includes(serve)){
                console.log('ciao');
                   return true

            }
            console.log('no ciao');
            return false
        },
        myPosition: function(serve,array){
            for(var i=0;i<array.length;i++){
                if(array[i].id==serve.id){
                    console.log('ciao');
                   return i
                }
            }
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



