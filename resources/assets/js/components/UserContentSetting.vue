<template>
    <div class="row border" v-if="isShow">
        <div class="col " style="min-height: 500px">
           <h1>Paramètre utilisateur</h1>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                name:'user_setting',
                isShow:false,
                user:window.organizer.user,
                signed:window.organizer.signedIn,
                csrf:window.organizer.csrfToken,
            }
        },

        mounted() {
            Event.$on('ShowModule', function(data){
                return data === this.name ? this.isShow = ! this.isShow : this.isShow;
            })
        }
    }
</script>
