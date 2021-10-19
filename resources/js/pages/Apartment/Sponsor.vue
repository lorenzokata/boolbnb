<template>
    <div class="container">
        <h1>Sponsorizza il tuo appartamento</h1>

        <div class="row justify-content-around my-3">

            <div class="col-12 col-md mx-2 ombra base-box p-3 rounded">
                <h3 class="nome-spons  mb-3"><strong>Base</strong></h3>
                <div class="costo my-3"><strong>2.99</strong> <i class="fas fa-euro-sign"></i></div>
                <div class="opal durata my-3">24h ore di sponsorizzazione</div>
                <div class="bottone rosso-background fl-right " @click="pagamentoBase('Base','2.99')">Vai al pagamento</div>
            </div>

            <div class="col-12 col-md mx-2 ombra sponsor-box p-3 rounded">
                <h3 class="nome-spons viola mb-3"><strong>Advance</strong></h3>
                <div class="costo my-3"><strong>5.99</strong> <i class="fas fa-euro-sign"></i></div>
                <div class="opal durata my-3">72h ore di sponsorizzazione</div>
                <div class="bottone rosso-background fl-right " @click="pagamentoBase('Advance','5.99')">Vai al pagamento</div>
            </div>

            <div class="col-12 col-md mx-2 ombra sponsor-box p-3 rounded gold-box">
                <h3 class="nome-spons "><strong>Gold</strong></h3>
                <div class="costo my-3"><strong>9.99</strong> <i class="fas fa-euro-sign"></i></div>
                <div class="opal durata my-3">144h ore di sponsorizzazione</div>
                <div class="bottone rosso-background fl-right " @click="pagamentoBase('Gold','9.99')">Vai al pagamento</div>
            </div>

        </div>

            <h2>pagamento</h2>
        <div id="paga" v-if="attivo" class="row align-items-center flex-column " >
            <h2>{{pagamento[0].nome}} {{pagamento[0].costo}} <i class="fas fa-euro-sign"></i></h2>
            <form action="" class="d-flex flex-column my-2">
                <input  class="my-2" type="number">
                <input  class="my-2" type="text">
                <button class="bottone rosso-background">submit</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                pagamento:[
                    {
                    nome:null,
                    costo:null
                    }
                ],
                attivo:false
            }
        },
        methods:{
            pagamentoBase(tipo,valore){
                this.pagamento[0].nome=tipo;
                this.pagamento[0].costo=valore;
                this.attivo=true;
            },
        },
    }
</script>

<style lang="scss" scoped>
    .sponsor-box{
        border: 3px solid #a93f55;
        color:#a93f55 ;
        width: 30%;
    }
    .base-box{
        border: 3px solid #19323c;
        width: 30%;
         color:#19323c ;
    }
    .gold-box{
         border: 3px solid #ffd700;
         width: 30%;
         color:#e7c502 ;
    }
    .nome-spons{
        padding-left:20px ;
    }
    .costo{
        font-size: 26px;
        
        padding-left:20px ;
    }

    .durata{
        font-size: 20px;
        
    }
</style>
