<template>
    <div class="container pt-3">
        <div class="row">
            <h1>Messaggi Dell'Appartamento</h1>
        </div>
            <form class="row">
                <div class="col-12 col-md-5 mx-3 my-4 ombra  big-box rounded"
                v-for="mail in email"
                :key="mail.id">
                    <h3 class=" box-mess my-2 px-3 rounded text-center">{{mail.sender_fullname}}</h3>
                    <div class="box-mess my-2 px-3 rounded">{{mail.sender_email}}</div>
                    <div class="box-mess my-2 px-3 rounded mess">{{mail.msg}}</div>
                    <div class="fl-right opal">{{mail.created_at}}</div>
                </div>

                <!-- <div class="col-12 col-md-5 mx-3 my-4 ombra  big-box rounded">
                    <h3 class=" box-mess my-2 px-3 rounded text-center">Nome e Cognome</h3>
                    <div class="box-mess my-2 px-3 rounded">Robertoanfuso@gmail.com</div>
                    <div class="box-mess my-2 px-3 rounded mess">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Assumenda, totam quisquam. Dolorum consequatur reiciendis, ipsam ullam quibusdam nisi repellat fugit, ad deserunt nam ab earum, at nulla consectetur laudantium aut.</div>
                    <div class="fl-right opal">13/10/2021</div>
                </div>
                   <div class="col-12 col-md-5 mx-3 my-4 ombra  big-box rounded">
                    <h3 class=" box-mess my-2 px-3 rounded text-center">Nome e Cognome</h3>
                    <div class="box-mess my-2 px-3 rounded">Robertoanfuso@gmail.com</div>
                    <div class="box-mess my-2 px-3 rounded mess">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Assumenda, totam quisquam. Dolorum consequatur reiciendis, ipsam ullam quibusdam nisi repellat fugit, ad deserunt nam ab earum, at nulla consectetur laudantium aut.</div>
                    <div class="fl-right opal">13/10/2021</div>
                </div>
                   <div class="col-12 col-md-5 mx-3 my-4 ombra  big-box rounded">
                    <h3 class=" box-mess my-2 px-3 rounded text-center">Nome e Cognome</h3>
                    <div class="box-mess my-2 px-3 rounded">Robertoanfuso@gmail.com</div>
                    <div class="box-mess my-2 px-3 rounded mess">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Assumenda, totam quisquam. Dolorum consequatur reiciendis, ipsam ullam quibusdam nisi repellat fugit, ad deserunt nam ab earum, at nulla consectetur laudantium aut.</div>
                    <div class="fl-right opal">13/10/2021</div>
                </div> -->
            </form>
        
    </div>
</template>

<script>
    export default {

        data(){
            return{
                email: ''
            }
        },

        mounted() {
            console.log(this.$route.params.id);
            axios
            .get("/api/apartment/myEmails/" + this.$route.params.id)
            .then(response => {
                // console.log(response);  
                this.email = response.data.results;
                console.log(this.email);
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
</script>

<style lang="scss" scoped>
      .mess{
           
            max-height: 0px;
            overflow-y: auto;
            opacity: 0;
            transition: opacity 1s ease-out;
        }

    .box-mess{
        background-color: white;
    }
    .big-box{
        border: 3px solid #ced1cc;
        max-height: 105px;
    }
    .big-box:hover{
            background-color: #ced1cc;
            transition: 1s;
            max-height: 206px;
            .mess{
                transition: opacity 1s ease-out;
                transition: 1s ease-out;
                opacity: 1;
                max-height: 100px;
            }
        }
</style>
