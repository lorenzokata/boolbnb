<template>
    <div class="container altezza margin-nav">
        <div class="my-nav fixed-top altezza-nav"></div>
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

                <div class="form-row d-flex justify-content-between align-items-center">
                    <div class="form-group mb-3 col-md-12 col-sm-12">
                        <label for="title "><h4>Titolo*</h4></label>
                        <input
                            class="form-control my-form"
                            type="text"
                            id="title"
                            v-model="form.title"
                            name="title"
                            required
                        />
                    </div>
                </div>
                <div class="ml-3 mr-3 d-none">>
                    <label for="visible">Visibile</label>
                    <input id="visible" v-model="form.visible" type="checkbox" name="visible"/>
                </div>
                <div class="form-group">
                    <label for="desc"><h4>Descrizione*</h4></label>
                    <textarea
                        class="form-control my-form"
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

                    </div>
                </div>

                <hr />

                <h4>Dati casa</h4>

                <!-- stanze letti bagni metri -->
                <div class="form-row">
                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block " for="n_rooms"
                            >Numero stanze*</label
                        >
                        <input
                            id="n_rooms"
                            v-model="form.n_rooms"
                            type="number"
                            name="n_rooms"
                            min="1"
                            max="16"
                            required
                        />
                    </div>

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block " for="n_beds">Numero letti*</label>
                        <input
                            id="n_beds"
                            v-model="form.n_beds"
                            type="number"
                            name="n_beds"
                            required
                            min="1"
                            max="20"
                        />
                    </div>
                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block " for="n_baths"
                            >Numero bagni*</label
                        >
                        <input
                            id="n_baths"
                            v-model="form.n_baths"
                            type="number"
                            name="n_baths"
                            required
                            min="1"
                            max="16"
                        />
                    </div>

                    <div class="form-group col-6 col-lg-3">
                        <label class="d-block " for="square_meters"
                            >Metri quadri*</label
                        >
                        <input
                            id="square_meters"
                            v-model="form.square_meters"
                            type="number"
                            name="square_meters"
                            required
                            min="10"
                            max="1500"
                        />
                    </div>
                </div>

                <hr/>

                <h4>Indirizzo*</h4>
                <!-- <div class="form-row d-flex justify-content-between "> -->

                <!-- indirizzo -->
                <div v-if="!cityActive" @click="clean" class="address_nav">
                    <!-- <i class="fas fa-arrow-left"></i> -->
                     Indietro 
                </div>
                <h3>{{city}} {{via}} {{civico}}</h3>
                <div class="form-group" v-if="cityActive">
                    <label class="d-block address_l" for="address">città:</label>
                    <input
                        id="city"
                        class="form-control"
                        v-model="city"
                        type="text"
                        autocomplete="off"
                        required
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
                        required
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
                        required
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
                
                <hr />

                <!-- immagine -->
                <h4>Foto</h4>
                <div
                    class="form-row d-flex justify-content-between align-items-center"
                >
                
                    <!-- foto -->
                    <div class="input-group mb-3 col-md-6 col-sm-12">
                        <div class="form-group">

                            <input
                                style="padding: 3px;"
                                type="file"
                                class="form-control-file form-control"
                                name="imgs"
                                id="exampleFormControlFile1"
                            />
                        </div>
                    </div>

                    <div class="float-right ">
                        <div class=" float-right mb-3 mr-3">
                            <button type="submit" class="bottone rosso-background ombra">
                                <i class="fas fa-save"></i>
                            </button>
                        </div>

                    </div>
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
                n_rooms: 1,
                n_beds: 1,
                n_baths: 1,
                square_meters: 10,
                address: "",
                visible: 1,
                SelectedServices: [],
                image: null
            },
            query: "",
            city: '',
            via : '',
            civico:'',
            services: [],
            arrayAddress: [],
            addressActive: true,
            cityActive: true,
            viaActive: false,
            civicoActive: false,
            selected:{
                city:'',
                via:'',
                civico:''
            },
            complete: false
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

        addressClick: function(id , type) {
            if(type == 0){
                // this.city = this.arrayAddress[id];
                this.query = this.arrayAddress[id];
                this.city = this.query.city;
                this.cityActive = false;
                this.viaActive = true;
                this.arrayAddress = [];
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
                            if(element.address.streetNumber && element.address.municipality == this.city && element.address.streetName == this.via){
                                // if(element.address.municipality == this.selected.city){
                                    let output = { 'city': element.address.municipality, 'via': element.address.streetName , 'civico' :element.address.streetNumber};
                                    arr.push(output);
                                // }
                                
                            }
                            
                        }
                        
                        
                        
                        this.arrayAddress = arr;

                    });
                        
                })
                .catch(error => {
                    console.log(error);
                });
            this.addressActive = false;
        },
        
        submit: function(e) {
            if(this.complete){
                var form = document.getElementById("form");
                var formData = new FormData(form);
                formData.append("user_id", JSON.parse(this.$userId).id);
                var address = this.query.city + ' ' + this.query.via + ' ' + this.query.civico;
                formData.append("address", address);
                axios
                    .post("/api/apartment/store", formData)
                    .then(response => {
                        this.$router.push("../dashboard");
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        
        ServiceActive: function(serve_id){
            this.form.SelectedServices.push(serve_id);
  
        },
        ServiceDisable: function(serve_id){
            this.form.SelectedServices.splice(serve_id,1);
           
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
