<template>
<div class="col-md-auto toolbar">
    <div class="row p-0">
        <calendar></calendar>
    </div>
    <commandes :commandes="commandes" ></commandes>

</div>

</template>

<script>
    export default {
        data(){
          return{
          }
        },
        props:['commandes'],
        mounted() {
        }
    }
</script>
