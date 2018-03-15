<template>
    <div  v-if="showResultWindow" class="col-12"
         style="  position: absolute; z-index: 9990">
        <div class="row p-1" >
           <div  class="col " style="background-color: white; min-height: 88vh;">
               <div class="row">
                   <div @click="closeResultWindow" class="col text-left"><i class="fa fa-times fa-2x"> </i></div>
               </div>
               <div class="row p-3 ">
                   <div class="col">
                       <h2>Votre recherche</h2>
                       <div class="row">
                           <div class="col">
                              {{search}}
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
                activeCalendar :true,
            }
        },
        mounted() {
            Event.$on('activeResultWindow',(data)=>{
                this.search = data;
                this.showResultWindow = true;

            })
            Event.$on('closeSearch',(data)=>{
                this.showResultWindow = false;
                Event.$emit('resetSearch')
            })
        },
        methods:{
            closeResultWindow(){
                this.showResultWindow = false;
                Event.$emit('resetSearch')
            },
        }
    }
</script>