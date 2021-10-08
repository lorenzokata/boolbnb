<template>
    <div>
        
        <h1>SEARCH RESULTS</h1>
        <div class="card">
            
        </div>
        <div class="div">
        <p v-for="post_spons  in sponsored_apartments" :key='post_spons.id'>{{post_spons.title}}</p> 

        </div>
        <div class="div">
        <p v-for="(post, i) in apartments" :key='i'>{{post.title}}</p> 

        </div>
        
    </div>
</template>

<script>
export default {

    name: "SearchResults",

    data(){
        return{
            sponsored_apartments :[],
            apartments :[]
        }
    },

    mounted() {
        console.log("Component mounted.");
        console.log(this.$route.params.userInput)
        // api per elenco servizi
        axios
            .get('/api/home/' + this.$route.params.userInput )
            .then(response => {
                this.sponsored_apartments = response.data.results.sponsored_appartments;
                this.apartments = response.data.results.apartments;
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>
