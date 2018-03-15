<template>
    <div  v-if="showAllFiche" class="col-12"
         style="  position: absolute; z-index: 9990">
        <div class="row p-1" >
           <div  class="col " style="background-color: white; min-height: 88vh;">
               <div class="row">
                   <div  class="col text-left">
                       <i @click="closeAllFicheWindow" class="fa fa-times fa-2x mr-3"> </i>
                       <span style="font-size: 2em">Liste des fiches en cours</span>
                   </div>
               </div>
               <div class="row p-3 " v-if="isLoading">
                   <div class="col text-center align-middle" style="height: 50vh">
                       <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-3x mr-3"> </i>
                       <span style="margin-top: -10px;">Chargement des fiches en cours</span>
                   </div>

               </div>
               <div class="row p-3" v-else>
                   <div class="col-6 border" v-for="col in fiches">
                      <div class="row border" v-for="bl in col">
                          <div class="col">
                              {{bl.id_cmd}} / {{bl.clientDelivered.id}}
                          </div>
                      </div>
                   </div>
               </div>
           </div>
        </div>


    </div>
</template>

<script>
    export default {
        data(){
            return {
                isLoading:false,
                search: '',
                showAllFiche: false,
                fiches:[],
            }
        },
        mounted() {
            Event.$on('closeSearch',(data)=>{
                this.showAllFiche = false;
                Event.$emit('resetSearch')
            })

            Event.$on('showAllFicheWindow',(data)=>{
                this.showAllFiche = true;
               this.isLoading = true;
                this.init()
            })

        },
        methods:{
            init(){
                axios.get('/fiches').then(
                    response => {
                        this.fiches =  response.data;
                        this.isLoading = false;
                    }
                );
            },
            closeAllFicheWindow(){
                this.showAllFiche = false;
                Event.$emit('resetSearch')
            },
        }
    }
</script>