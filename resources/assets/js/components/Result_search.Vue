<template>
    <div  v-if="showResultWindow" class="col-12"
         style="  position: absolute; z-index: 9990">
        <div class="row p-1" >
           <div  class="col " style="background-color: white; min-height: 88vh;">
               <div class="row p-3 ">

                   <div @click="closeResultWindow" class="col-md-auto"><i class="fa fa-times fa-2x"> </i></div>

                   <div class="col-2" v-if="activeCalendar">
                        <pick-calendar :dtenvoie="search.date_envoie" > </pick-calendar>
                   </div>

                   <div class="col">
                       <h2>votre recherche </h2>
                       <div class="row">
                           <div class="col">
                               {{search.id_cmd}} - {{search.id_client}} <br>
                               <i class="fa fa-pencil mr-2 " @click="changeDateEnvoie"> </i> {{search.date_envoie}}
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
                showResultWindow: false,
                activeCalendar :false,
            }
        },
        mounted() {


            Event.$on('desactivateUpdateCalendar',(data)=>{
                this.activeCalendar = ! this.activeCalendar;
            })

            Event.$on('activeResultWindow',(data)=>{
                this.search = data;
                this.showResultWindow = true;

            })
            Event.$on('closeSearch',(data)=>{
                this.showResultWindow = false;
                Event.$emit('resetSearch')
            })

            Event.$on('editItem',(data)=>{
                this.showResultWindow = true;
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
                this.showResultWindow = false;
                Event.$emit('resetSearch')

            },
        }
    }
</script>