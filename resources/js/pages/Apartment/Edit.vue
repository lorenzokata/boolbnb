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

                    <div class="form-group mb-3 col-md-8 col-sm-12">
                        <label for="title "><h4>Titolo</h4></label>
                        <input
                            class="form-control my-form"
                            type="text"
                            id="title"
                            v-model="apartment.title"
                            name="title"
                            required
                        />
                    </div>

                    <div class="ml-3 mr-3 d-none">
                        <label for="visible">Visibile</label>
                        <input id="visible" v-model="form.visible" type="checkbox" name="visible"/>
                    </div>
                    
                </div>

                <h4 class="mt-3">Modifica Descrizione</h4>

                <div class="input-group">
                    <textarea
                        class="form-control my-form"
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

                    </div>
                </div>
                <hr>

                <h4>Dati casa</h4>

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

                 <!-- indirizzo -->
                <div v-if="!cityActive" @click="clean" class="address_nav"> Indietro </div>
                <h3 v-if="focus">{{city}} {{via}} {{civico}}</h3>
                <h3 v-else>{{apartment.address}}</h3>
                <div class="form-group" v-if="cityActive">
                    <label class="d-block address_l" for="address">città:</label>
                    <input
                        id="city"
                        class="form-control"
                        v-model="city"
                        type="text"
                        autocomplete="off"
                        @focus="focus = true"
                        @input="autoAddress(0)"
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
                                @click="addressClick(id , 0)"
                            >
                                {{ address.city }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group" v-if="viaActive">
                    <label class="d-block address_l" for="address">via:</label>
                    <input
                        id="city"
                        class="form-control"
                        v-model="via"
                        type="text"
                        autocomplete="off"
                        
                        @input="autoAddress(1)"
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
                                @click="addressClick(id, 1)"
                            >
                                {{ address.city }} {{ address.via }} 
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="form-group" v-if="civicoActive">
                    <label class="d-block address_l" for="address">civico:</label>
                    <input
                        id="city"
                        class="form-control"
                        v-model="civico"
                        type="text"
                        autocomplete="off"
                      
                        @input="autoAddress(2)"
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
                                @click="addressClick(id, 2)"
                            >
                                {{ address.city }} {{ address.via }} {{ address.civico }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="input-group col-md-4 col-sm-12" style="padding-left: 0">
                    <div class="form-group">
                        <h4>Foto:</h4>
                        <!-- <label class="d-block" for="exampleFormControlFile1">Foto:</label> -->
                        <input
                            style="padding: 3px;"
                            type="file"
                            class="form-control-file form-control"
                            name="imgs"
                            id="exampleFormControlFile1"
                        />
                    </div>

                </div>
                <div class="col-md-4 col-sm-12" style="padding-left: 0">
                    <img style="height:200px" :src="apartment.imgs" alt="">
                </div>
                <hr>

                <!-- immagine -->
                <div class="float-right form-row d-flex justify-content-between align-items-center">

                    <div class="d-flex justify-content-between">
                        <div class="mb-3 mr-3">
                            <!-- <input type="submit" value="Submit"/> -->
                            <button type="submit" class="bottone rosso-background ombra">
                                <i class="fas fa-save"></i>
                            </button>
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
                
                visible: 1,
                SelectedServices: []
            },
            focus: false,
            query: "",
            city: '',
            via : '',
            civico:'',
            exApartmentTitle: '',
            apartment: [],
            arrayAddress: [],
            activeservice:[],
            addressActive: true,
            services: [],
            cityActive: true,
            viaActive: false,
            civicoActive: false,
            selected:{
                city:'',
                via:'',
                civico:''
            },
            complete: true
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

                // console.log(this.apartment.services);
                this.exApartmentTitle = this.apartment.title;

            })
            .catch(error => {
                console.log(error);
            });
            this.query = this.apartment.address;

    },
    methods: {
        clean: function(){
            this.cityActive = true;
            this.viaActive = false;
            this.civicoActive = false;
            this.form.address = '';
            this.query = '';
            this.city= '';
            this.civico='',
            this.via='',
            this.arrayAddress =[];
            this.complete = false;
        },
        addressClick: function(id, type) {
            if(type == 0){
                // this.city = this.arrayAddress[id];
                this.query = this.arrayAddress[id];
                this.city = this.query.city;
                this.cityActive = false;
                this.viaActive = true;
                this.arrayAddress = [];
                this.complete = false;
                this.form.address = this.query;
            }else if(type == 1){
                this.query = this.arrayAddress[id];
                this.viaActive = false;
                this.via = this.query.via;
                this.civicoActive = true;
                this.arrayAddress = [];
                this.form.address = this.query;
            }else if(type == 2){
                this.query = this.arrayAddress[id];
                this.civicoActive = false;
                this.civico = this.query.civico;
                this.arrayAddress = [];
                this.form.address = this.query;
                this.complete = true;
            }
            
            this.addressActive = true;
        },
        autoAddress: function(type) {
            // caso attivo quando form.city !== '' (caso base, PASSO 1)
            if(type == 0){
                this.query = this.city;
            }
            if(type == 1 ){
                this.query = this.city + ' ' + this.via;
            }
            if(type == 2){
                this.query = this.city + ' ' + this.via + ' ' + this.civico;
            }
            axios
                .get("https://api.tomtom.com/search/2/search/.json?", {
                    params: {
                        key: "iYutMJyrnVArnI296DDnCsP4ZX15GiW2",
                        query: this.query,
                        // entityTypeSet: "Municipality",
                        language: "it-IT",
                        typeahead: 1,
                        countrySet: "IT"
                    }
                })
                .then(response => {
                    let arr = [];
                    response.data.results.forEach(element => {
                        if(type == 0){
                            let output =  { 'city' : element.address.municipality, 'via' : '' , 'civico' : '' };
                            arr.push(output);
                        }
                        if(type == 1 ){
                            if(element.address.streetName && element.address.municipality == this.city){
                                let output = { 'city': element.address.municipality, 'via': element.address.streetName , 'civico':''};
                                arr.push(output);
                            }
                        }
                        if(type == 2){

                            if(element.address.streetNumber && element.address.municipality == this.city ){
                                // if(element.address.municipality == this.selected.city){
                                    let output = { 'city': element.address.municipality, 'via': element.address.streetName , 'civico':element.address.streetNumber};
                                    arr.push(output);
                                // }
                                
                            }
                            
                        }
                        this.arrayAddress = arr;
                    });
                    this.arrayAddress = arr;
                })
                .catch(error => {
                    console.log(error);
                });
            this.addressActive = false;
        },
        submit: function(e){
            if(this.complete){
                var form = document.getElementById('form');
                var formData = new FormData(form);
                if(this.cityActive && !this.focus){
                    var address = this.apartment.address;
                }else{
                   var address = this.query.city + ' ' + this.query.via + ' ' + this.query.civico; 
                }
                
                formData.append('user_id', JSON.parse(this.$userId).id);
                formData.append('slug', this.apartment.slug);
                formData.append("address", address);
                axios.post('/api/apartment/update', formData)
                .then((response) => {
                    this.$router.push('../dashboard') 
                })
                .catch((error) =>{
                    console.log(error);
                })
            }
            
        },

        ServiceActive: function(serve_id){
            if(!this.form.SelectedServices.includes(serve_id)){
                this.form.SelectedServices.push(serve_id);
                this.activeservice.push(serve_id.id);
            }

        /* console.log(this.form.SelectedServices); */
        },
        ServiceDisable: function(posselect,posid ){
            /* console.log(serve_id); */
            this.form.SelectedServices.splice(posselect,1);
            this.activeservice.splice(posid,1)


           
        },

        myInclude: function(serve){
            for(var i=0;i<this.form.SelectedServices.length;i++){
                if(this.form.SelectedServices[i].id==serve.id){

                   return true
                }
            }
            if(this.form.SelectedServices.includes(serve)){

                   return true

            }
            return false
        },
        myPosition: function(serve,array){
            for(var i=0;i<array.length;i++){
                if(array[i].id==serve.id){

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
.address_nav{
    
    display: inline-block;
    cursor: pointer;
    padding:4px 10px ;
    border-radius: 20px;
    border: 2px solid black;
    margin: 10px 0;
    &:hover{
        border: 2px solid rgba(255, 255, 255, 0.055);
        background-color:#f2545b ;
        color: white;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }
}

.address_l{
    font-size: 20px;
    text-transform: capitalize;
}
</style>
