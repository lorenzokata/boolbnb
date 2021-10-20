<template>
    <div class="container pt-3 margin-nav">
        <div class="row">
            <h1 v-if="email != ''">Messaggi appartamento - <strong>{{apartment.title}}</strong> </h1>
            <h1 class="mt-5 rosso" v-if="email == ''">Non ci sono messaggi per l'appartamento <br> <strong>{{apartment.title}}</strong></h1>
        </div>
            <form class="row">
                <div class="col-12 col-md-5 mx-3 my-4 p-2 ombra big-box r20"
                v-for="mail in email"
                :key="mail.id"
                >

                    <h4 class="p-2 gunmetal cream">Dati mittente</h4>

                    <h5 class="box-mess my-2 py-2 px-3 no_w">Nome e cognome: <br> {{mail.sender_fullname}} </h5>
                    <!-- <h5 class="box-mess my-2 py-2 px-3 no_w">{{mail.sender_fullname}}</h5> -->

                    <div class="box-mess my-2 py-2 px-3 no_w">E-mail: <br> {{mail.sender_email}}</div>
                    <!-- <div class="box-mess my-2 py-2 px-3 no_w"></div> -->

                    <div class="box-mess my-2 py-2 px-3 no_w mess">Messaggio: <br> {{mail.msg}}</div>
                    <!-- <div class="box-mess my-2 py-2 px-3 no_w mess"></div> -->

                    <div class="p-2 fl-right gunmetal cream">{{mail.created_at.substring(0,10)}}  -  {{mail.created_at.substring(11,16)}}  </div>  
                </div>

            </form>
        
    </div>
</template>

<script>
    export default {

        data(){
            return{
                email: '',
                apartment:[],
            }
        },

        mounted() {
    
            axios
            .get("/api/apartment/myEmails/" + this.$route.params.id)
            .then(response => {
                
                this.email = response.data.results.messages;
                this.apartment = response.data.results.apartment;
                // console.log(this.apartment);
                // console.log(this.email);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
</script>

<style lang="scss" scoped>

    .box-mess{
        background-color: white;
    }

    .big-box{
        background-color: #f2545b ;

        .mess{
            max-height: 100px;
            overflow-y: auto;
        }
    }

    .r20{
        border-radius: 20px;
    }

    .no_w{
        width: auto;
        border-radius: 20px;

    }
</style>
