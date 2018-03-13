<template>
    <div class="col">
        <div class="row">
            <div class="col-md-auto" style="cursor:default" @click=" editItem(work) ">
                {{work.id_cmd}}
            </div>

        </div>
        <div class="row">
            <div class="col" style="font-size: 0.8em">
                {{work.client.nsoc | client}}
            </div>
        </div>
        <div class="row pb-1 pt-1">
            <div class="col text-right" style="font-size: 0.9em">
                <i v-if="work.da == 1" class="fa fa-dollar ml-1"> </i>
                <i v-if="work.inc == 1" class="fa fa-bell ml-1"> </i>
                <i v-if="work.devis == 1" class="fa fa-ban ml-1"> </i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                element : [],
            }
        },
        props:['work'],
        mounted() {
            this.element = this.work
        }
        ,
        filters:{
            client(client){
                return   _.upperFirst(_.lowerCase(client.substr(0,25)))
            },
        },
        methods:{
            getClient(client){

                return 'test_'+client
            },
            editItem(data){
                Event.$emit('editItem',data)
                Event.$emit('focusSearchDelais',data)
            },
        }
    }
</script>
