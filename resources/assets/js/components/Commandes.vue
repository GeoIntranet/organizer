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
            <div class="row item-fiche p-1" v-for="item in commandes">
                <div class="col " >
                    <i class="fa fa-circle mr-2" style="color:indianred"> </i>
                    {{item.id_cmd}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <small>{{item.client_delivered.nsoc | client}}</small>
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
            }
        },
        mounted() {
            for(let i=0 ; i<15 ; i++){
                this.dummy.push(i)
            }
            console.log('Component mounted.')
        },
        props:['commandes'],
        methods:{
            toggleCommande(){
                this.showCommande = ! this.showCommande
            }
        },
        filters:{
            client(client){
                return   _.upperFirst(_.lowerCase(client.substr(0,17)))
            },
        },
    }
</script>
