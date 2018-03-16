<template>
    <div  v-if="showCommandeItem " class="col-12"
         style="  position: absolute; z-index: 9990">
        <div class="row p-1" >
           <div  class="col " style="background-color: white; min-height: 88vh;">
               <div class="row">
                   <div @click="closeResultWindow" class="col text-left"><i class="fa fa-times fa-2x"> </i></div>
               </div>
               <div class="row p-3 ">

                   <div class="col-md-auto" v-if="activeCalendar">
                       <div class="row">
                           <div class="col">
                               <h4>Modifier la date d'envoie</h4>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col">
                               <commande-calendar > </commande-calendar>
                           </div>
                       </div>
                   </div>

                   <div class="col">
                       <h2>Fiche - {{cmd.id_cmd}}</h2>
                       <div class="row">
                           <div class="col">
                               Client - {{cmd.client_delivered.nsoc}} <br>
                               Date d'envoie : ?
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
                search: '',
                showCommandeItem: false,
                activeCalendar :true,
                cmd:[],
            }
        },
        mounted() {
            Event.$on('desactivateUpdateCalendar',(data)=>{
                this.activeCalendar = ! this.activeCalendar;
            })

            Event.$on('closeSearch',(data)=>{
                this.showCommandeItem = false;
                Event.$emit('resetSearch')
            })

            Event.$on('editCommande',(data)=>{
                this.cmd = data;
                this.showCommandeItem = true;
                this.search = data;
            })

            Event.$on('create_cmd_date',(data) =>{
                axios.get('/delais/add/'+this.cmd.id_cmd+'/'+data)
                    .then(
                        response => {
                           Event.$emit('refreshWork');
                           Event.$emit('refreshCommandesListe');
                           this.showCommandeItem = false;
                        }
                    )
            });
        },
        methods:{
            changeDateEnvoie(){
                this.activeCalendar = !  this.activeCalendar;
            },
            closeResultWindow(){
                this.showCommandeItem = false;
                Event.$emit('resetSearch')

            },
        }
    }
</script>