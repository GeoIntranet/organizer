<template>
<div class="container">
    <div class="row">
        <div class="col">
            auth
        </div>
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

        mounted() {
            console.log('auth component')
        }
    }
</script>
