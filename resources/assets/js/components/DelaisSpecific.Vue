<template>
    <div  v-if="showDelaisItem" class="col-12"
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
                               <pick-calendar :dtenvoie="search.date_envoie" > </pick-calendar>
                           </div>
                       </div>
                   </div>

                   <div class="col">
                       <h2>Fiche - {{search.id_cmd}}</h2>
                       <div class="row">
                           <div class="col">
                               Client - {{search.id_client}} <br>
                               Date d'envoie :  {{search.date_envoie}}
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
                showDelaisItem: false,
                activeCalendar :true,
            }
        },
        mounted() {
            Event.$on('desactivateUpdateCalendar',(data)=>{
                this.activeCalendar = ! this.activeCalendar;
            })

            Event.$on('closeSearch',(data)=>{
                this.showDelaisItem = false;
                Event.$emit('resetSearch')
            })

            Event.$on('editItem',(data)=>{
                this.showDelaisItem = true;
                this.search = data;
            })

            Event.$on('pick_dt_envoie',(data) =>{

                let dateEnvoie = moment(data)
                let week = dateEnvoie.clone().week()

                let refDateEnvoie = moment(this.search.date_envoie)
                let refWeek = refDateEnvoie.clone().week()



                axios.get('/team/'+ this.search.id+'/'+ dateEnvoie.format('Y-MM-DD') ).then(
                    response => {

                        if(week !== refWeek){
                            Event.$emit('removeElement',this.search.id);
                        }
                        else{
                            Event.$emit('refreshWork');
                        }
                    }
                );

                this.search.date_envoie = dateEnvoie.format('Y-MM-DD')
            });
        },
        methods:{
            changeDateEnvoie(){
                this.activeCalendar = !  this.activeCalendar;
            },
            closeResultWindow(){
                this.showDelaisItem = false;
                Event.$emit('resetSearch')

            },
        }
    }
</script>