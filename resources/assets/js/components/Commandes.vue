<template>
    <div >
        <div v-if="showCommande">
            <div class="row item-fiche p-2" style="height: 75px;">
                <div class="col-md-auto toggle-commande" @click="toggleCommande">
                    <i class="fa fa-angle-right"> </i>
                </div>
                <div class="col pt-3">
                    <h5>Fiches en cours</h5>
                </div>
            </div>
            <div class="row pt-3" v-if="isLoading">
                <div class="col text-center">
                    <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x mr-3"> </i>
                </div>
            </div>
             <div class="row item-fiche p-1 commande-row" v-for="commande in commandes_" v-else>
                <div class="col commande-item" @click="showCommandeItem(commande)">
                    <i v-if="commande.delais" class="fa fa-circle mr-2" style="color:mediumaquamarine"> </i>
                    <i  class="fa fa-circle mr-2" style="color:indianred" v-else> </i>
                    <span class="bl">{{commande.id_cmd}}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <small>{{commande.client_delivered.nsoc | client}}</small>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row item-fiche p-2" style="height: 75px;">
                <div class="col-md-auto toggle-commande"  @click="toggleCommande">
                    <i class="fa fa-angle-left"> </i>
                </div>
            </div>

            <div class="row item-fiche p-1 dummyrow" v-for="item in dummy">
                <div class="col " >
                   <span style="color:lightgrey"> . . .</span>
                </div>
            </div>

        </div>
    </div>


</template>

<script>
    export default {
        data(){
            return{
                isLoading : false,
                showCommande : true,
                dummy:[],
                commandes_:[]
            }
        },
        mounted() {
            this.commandes_  = this.commandes;

            for(let i=0 ; i<15 ; i++){
                this.dummy.push(i)
            }

            Event.$on('refreshCommandesListe',(data)=>{
               this.refreshList()
            })
        },
        props:['commandes'],
        methods:{
            refreshList(){
                this.isLoading = true;
                axios.get('/works').then(
                    response => {
                        //this.commandes_ =  response.data;
                        this.isLoading = false;
                        this.commandes_= response.data;
                    }
                );
            },
            toggleCommande(){
                this.showCommande = ! this.showCommande
            },
            showCommandeItem(commande){
                Event.$emit('editCommande',commande)
            }
        },
        filters:{
            client(client){
                return   _.upperFirst(_.lowerCase(client.substr(0,17)))
            },
        },
    }
</script>
