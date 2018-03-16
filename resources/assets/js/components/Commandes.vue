<template>
    <div >
        <div v-if="showCommande">
            <div class="row item-fiche p-2" style="height: 75px;">
                <div class="col-md-auto pt-3" >
                    <i class="fa fa-angle-right" @click="toggleCommande"> </i>
                </div>
                <div class="col pt-3">
                    <h5>Fiches en cours</h5>
                </div>
            </div>
            <div class="row item-fiche p-1" v-for="commande in commandes_">
                <div class="col " @click="showCommandeItem(commande)">
                    <i v-if="commande.delais" class="fa fa-circle mr-2" style="color:mediumaquamarine"> </i>
                    <i v-else class="fa fa-circle mr-2" style="color:indianred"> </i>
                    {{commande.id_cmd}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <small>{{commande.client_delivered.nsoc | client}}</small>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row item-fiche p-2" style="height: 75px;">
                <div class="col-md-auto pt-3"  @click="toggleCommande">
                    <i class="fa fa-angle-left"> </i>
                </div>
            </div>

            <div class="row item-fiche p-1" v-for="item in dummy">
                <div class="col " >
                   <span style="color:lightgrey">...</span>
                </div>
            </div>

        </div>
    </div>


</template>

<script>
    export default {
        data(){
            return{
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
                axios.get('/works').then(
                    response => {
                        this.commandes_ =  response.data;
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
