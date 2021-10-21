<template>
    <main>
        <div class="container-fluid">
            <div class="row ">
                <div
                    class=" col-12 col-lg-8 col-xl-9 ricerca position-relative"
                >
                    <div class="darker_gradient "></div>
                    <!-- btn dashboard -->
                    <div v-if="this.$userId">
                        <router-link
                            class="mt-2 bottone cream home-dash"
                            :to="{ name: 'dashboard' }"
                            ><i class="far fa-user-circle"></i></router-link
                        >
                    </div>

                    <!-- logo -->
                    

                    <div class="box-cerca ">
                        <!-- input --><!-- btn cerca -->
    <!--boolflix seachbar -->
                    <h2 class="search-text text-align-center" >Dove vuoi andare?</h2>
                        <form class=" search_box"  
                                >
                            <input 
                                v-model="userInput"
                                @input="autoAddress()"
                                id="search" class="search" type="text"
                                autocomplete="off"
                                @focus="focus = true"
                                @enter="enterRoute()"
                                @blur="focusActions()"
                            >

                            <router-link
                                    class="bottone rosso-background cream mb-1 ombra"
                                    :to="{
                                        name: 'results',
                                        params: { userInput: userInput }
                                    }"
                                    >
                                    <i class="fas fa-search"></i>
                            </router-link>
                            <div
                                class="list-group suggeriti"
                                
                                v-if="arrayAddress != [] && userInput.length > 1 "
                                
                                
                            >
                                <ul>
                                    <label
                                        class="list-group-item"
                                        v-for="(address, id) in arrayAddress"
                                        :key="id"
                                        :v-model="arrayAddress[id]"
                                        @click="addressClick(id)"
                                        
                                    >
                                       <label for="search">{{ address }}</label> 
                                    </label>
                                </ul>
                            </div>
                        </form>                        
                    </div>
                </div>
<!-- :to="{
                                            name: 'results',
                                            params: { userInput: userInput }
                                        }" -->
                <!-- in primo piano -->

                <div
                    class=" col-12 col-lg-4 col-xl-3 my-primo-piano align-items-center pb-2"
                >
                    <h3 class="pl-3 pt-3">In Primo Piano</h3>
                    <!-- <div
                        class="margin-t-4"
                        v-for="app in sponsored_apartments"
                        :key="app.id"
                    >
                        <router-link
                            class="my-card margin-t-4 mx-auto ombra"
                            :to="{ name: 'show', params: { slug: app.slug } }"
                            ><img :src="'storage/' + app.imgs" alt=""
                        /></router-link>
                    </div>` -->

                    <!-- card importata -->
                    <!--style="background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.2)), url('https://i1.wp.com/handluggageonly.co.uk/wp-content/uploads/2015/05/IMG_2813-s.jpg?w=1600&ssl=1');"-->
                    <div class="overflow-auto scroll_container" >
                        <div
                            class="card position-relative slide-in-top"
                            v-for="app in sponsored_apartments"
                            :key="app.id"
                        >
                            <div class="bg_img">
                                <img :src="'storage/' + app.imgs" alt="" />
                                <div class="lay_over"></div>
                            </div>
                            <div class="card-category">{{ app.address }}</div>
                            <div class="card-description">
                                <h2>{{ app.title }}</h2>
                                <!-- <p class="">{{ app.description }}</p> -->
                            </div>
                            <router-link
                                class="card-link"
                                :to="{
                                    name: 'show',
                                    params: { slug: app.slug }
                                }"
                                >
                            </router-link>
                        </div>
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
            sponsored_apartments: [],
            focus : false,
            inp:''
        };
    },
    mounted() {
        // sponsored_apartment contiene gli appartamenti sponsorizzati
        axios
            .get("/api/home")
            .then(response => {
                this.sponsored_apartments =
                    response.data.results.sponsored_apartments;
            })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        addressClick: function(id) {
            this.userInput = this.arrayAddress[id];
            this.addressActive = false;
            this.focus = false;
            this.$router.push({
                name: 'results', 
                params: { userInput: this.userInput }
            });
            // this.inp = document.getElementById('search');
            
            // this.inp.focus();
            
            
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
            this.addressActive = true;
            this.focus = true;
        },
        focusActions: function(){
            this.focus = false;
            // this.arrayAddress = [];           
        },
        enterRoute: function(){
            
            this.router.push({ name: 'results', params: { userInput: this.userInput } });
        }

    }
};
</script>

<style lang="scss" scoped>
.ricerca {
    background-image: url(https://images.wallpaperscraft.com/image/single/city_aerial_view_road_156925_3840x2400.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    height: calc(100vh);
    position: relative;
}

.box-cerca {
    position: absolute;
    top: 37%;
    left: 50%;
    transform: translateX(-50%);
    width: 350px;
    height: 40px;
    // background-color: white;
    border-radius: 30px;

    .suggeriti {
        max-height: 40vh;
        width: 320px;
        overflow-y: auto;
        scrollbar-width: none;
        border-radius: 10px;
            &::-webkit-scrollbar {
                display: none;
            }
            .list-group-item:last-child{
                border-bottom-right-radius: 10px;
                border-bottom-left-radius: 10px; 
            }
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

.my-card {
    /* background-image: url(https://pix10.agoda.net/hotelImages/4869553/0/35b103e869655a2959fac36f614fa08e.jpg?s=1024x768); */
    background-position: center;
    background-repeat: no-repeat;
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

.my-primo-piano {
    height: calc(100vh - 46px);
    width: 100%;
}

.home-dash {
    position: absolute;
    top: 50px;
    right: 50px;
}

.fa-user-circle{
    height: 3rem;
    width: 3rem;
}

// STYLE IMPORTATO DA SITO WEB
.avatar {
    width: 30px;
    border-radius: 50%;
}
.avatar-bordered {
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    border: white 1px solid;
}
.avatar-large {
    width: 50px;
}
.card {
    height: 250px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.6);
    background-size: cover !important;
    color: white;
    position: relative;
    border-radius: 20px;
    margin-bottom: 20px;
    max-width: 500px;
    margin: 3rem auto;
}
.card-user {
    position: absolute;
    right: 10px;
    top: 10px;
}
.card-category {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 20px;
}
.card-description {
    position: absolute;
    bottom: 10px;
    left: 10px;
}
.card-description h2 {
    font-size: 22px;
}
.card-description p {
    font-size: 15px;
}
.card-link {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
    z-index: 2;
    background: black;
    opacity: 0;
    border-radius: 20px;
}
.card-link:hover {
    opacity: 0.1;
}

.bg_img {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    &:hover img{
            transform:  scale(2, 2);    
            transition: 1s;
        }
    img {
        height: 100%;
        width: 100%;
        border-radius: 20px;
        transition: 1s;
        
    }
    .lay_over{
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        position: absolute;
        top: 0;
        left: 0;
        border-radius: 20px;
        &:hover{
            background-color:rgba(0, 0, 0, 0.1);
            
        }
    }


    
    
}
.darker_gradient {
        background: #ebffff13;
        width: 100%;
        height: 100%;
        position: absolute;
        top:0;
        left: 0;
        
    }
    
.scroll_container {
    height: 100%;
    scrollbar-width: none;
    &::-webkit-scrollbar {
                display: none;
            }
}



// boolflix classes

.search_box{
    height: 50px;
    width: 400px;
    
    
    font-weight: 700;
    color: #3a3a3a;
    font-size: 20px;
        &:hover .search{
            width: 300px;
            transition:  ease-in-out 0.5s ;
            transition-delay: 0.1s;
            background-color: white;
            padding: 4px 10px;
            border-radius: 1000px;
            color: black;
        }
}

.search{
    width: 0px;
    
    background-color: rgba(255, 255, 255, 0);
    box-sizing: content-box;
    border: 0px solid rgba(255, 255, 255, 0);
    height: 70%;
    border-radius: 1000px;
    padding: 4px 0px;
    color: rgba(0, 0, 0, 0);
    // transition: padding 0.4s;
    transition: ease-out 0.4s;
        &:focus{
            width: 300px;
            background-color: white;
            padding: 4px 10px;
            border-radius: 20px;
            border: 0px;
            outline: none;
            color: black;
        } 
}



.search-text{
    color: white;
}

.slide-in-top {
	-webkit-animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
	        animation: slide-in-top 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
}
</style>
