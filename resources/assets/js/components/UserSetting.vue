<template>
    <div class="row">
        <div class="col" ">
            user setting
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                user:window.organizer.user,
                signed:window.organizer.signedIn,
                csrf:window.organizer.csrfToken,
            }
        },
        methods:{
            showModule(name){
              Event.emit('showModule',name)
            },
        },
        mounted() {

        }
    }
</script>
