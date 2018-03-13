<template>
    <div>
        <div class="row" v-for="item in commandes">
            <div class="col item-fiche" >
                <i class="fa fa-circle mr-2" style="color:indianred"> </i>
                {{item.id_cmd}}
                &nbsp;&nbsp;&nbsp;&nbsp;
                <small>{{item.cd_cmd_cli}}</small>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:['commandes'],
    }
</script>
