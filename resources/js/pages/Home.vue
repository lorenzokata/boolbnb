<template>
    <main>
        <div class="container-fluid">
            <div class="row ">
                <div class=" col-12 col-lg-7 col-xl-8 ricerca position-relative">
                    
                    <!-- btn dashboard -->
                    <div v-if="this.$userId" >
                        <router-link class="mt-2 bottone rosso-background ombra cream home-dash" :to="{ name: 'dashboard'}">Dashboard</router-link>
                    </div>

                    <!-- logo -->
                    <img src="https://cdn.freelogovectors.net/wp-content/uploads/2016/12/airbnb_logo.png" class="logo " alt="logo boolbnb">

                    <div class="box-cerca">
                            
                        <!-- input -->
                        <input class="form-ricerca text-center cream-background input mb-1"
                                v-model="userInput"
                                name="userInput"
                                type="text"
                                placeholder=""
                            @input="autoAddress()"/>

                        <!-- btn cerca -->
                        <router-link class="bottone rosso-background cream mb-1 ombra"
                                :to="{
                                    name: 'results',
                                    params: { userInput: userInput }
                                }"
                                >Cerca
                        </router-link>

                        <!-- suggerimenti -->
                        <div class="list-group suggeriti"
                                    :class="{ 'd-none': addressActive }"
                                    v-if="arrayAddress != []">

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


                </div>

                <!-- in primo piano -->
                <div class=" col-12 col-lg-5 col-xl-4 overflow-auto my-primo-piano align-items-center pb-2">
                    <h3 class="text-center pt-3 ">In Primo Piano</h3>
                        <div class="margin-t-4"
                        v-for="app in sponsor_apartment"
                        :key="app.id">

                        <router-link class="my-card margin-t-4 mx-auto ombra" :to="{ name: 'show', params: { slug: app.slug }}"><img :src="'storage/'+app.imgs" alt=""></router-link>
                        
                        </div>
                        
                </div>

            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            userInput: "",
            arrayAddress: [],
            addressActive: true,
            sponsored_apartments:[]
        };
    },
    mounted() {
        // sponsored_apartment contiene gli appartamenti sponsorizzati
        axios
            .get("/api/home")
            .then(response => {
                this.sponsored_apartments = response.data.results.sponsored_apartments;
            })
            .catch(error => {
                console.log(error);
            });

    },
    methods: {
        
        addressClick: function(id) {
            this.userInput = this.arrayAddress[id];
            this.addressActive = true;
        },
        autoAddress: function() {
            // caso attivo quando form.city !== '' (caso base, PASSO 1)
            axios
                .get("https://api.tomtom.com/search/2/search/.json?", {
                    params: {
                        key: "iYutMJyrnVArnI296DDnCsP4ZX15GiW2",
                        query: this.userInput,
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
        }
    },
};
</script>

<style lang="scss" scoped>

.ricerca {
    background-image: url(https://siviaggia.it/wp-content/uploads/sites/2/2019/08/tempio-in-bali.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: calc(100vh - 60px);
}

.box-cerca{
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translateX(-50%);
    width: 350px;

    .input{
        height: 41px;
        width: calc(100% - 70px);
    }

    router-link{
        height: 41px;
        width: 61px;
    }

    .suggeriti{
        max-height: 45vh;
        overflow-y: auto;
    }

}

.form-ricerca {
    width: 60%;
    align-items: center;
    border-radius: 200px;
    box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px,
        rgba(0, 0, 0, 0.23) 0px 6px 6px;
}

.logo {
    position: absolute;
    top: calc(40% - 150px);
    left: calc(50% - 50px);
    height: 100px;
    width: 100px;
    transform: rotate(180deg);
}

.my-card{
    /* background-image: url(https://pix10.agoda.net/hotelImages/4869553/0/35b103e869655a2959fac36f614fa08e.jpg?s=1024x768); */
    background-position: center;
    background-repeat:no-repeat;
    /* height: 80%; */
    width: 90%;
    border-radius: 1.25rem;
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        border-radius: 1.25rem;
    }
}

.my-primo-piano{
    height: calc(100vh - 60px);
    width: 100%;
    overflow-y: scroll;
}

.home-dash{
    position: absolute;
    top: 20px;
    right: 20px;
}
</style>
