<template>
    <div  v-if="showResultWindow" class="col-12"
         style="  position: absolute; z-index: 9990">
        <div class="row p-1" >
           <div  class="col " style="background-color: white; min-height: 88vh;">
               <div class="row p-3 ">
                   <div @click="closeResultWindow" class="col-md-auto"><i class="fa fa-times fa-2x"> </i></div>
                   <div class="col"><h2>votre recherche :{{search}}</h2></div>
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

            Event.$on('editItem',(data)=>{
                this.showResultWindow = true;
                this.search = data;
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