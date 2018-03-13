<template>
<div class="col-md-auto toolbar" v-if="showToolbar">
    
    <div class="row p-0">
        <calendar></calendar>
    </div>
    <div class="row p-2">
        <navigation></navigation>
    </div>
</div>

</template>

<script>
    export default {
        data(){
          return{
              showToolbar:true,
          }
        },
        props:['commandes'],
        mounted() {
            Event.$on('toggleToolbar',(data)=>{
                this.showToolbar = ! this.showToolbar;
            })
        },
        methods:{

        }
    }
</script>
