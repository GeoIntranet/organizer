<template>
    <div >
        <br>
        <div class="row ">
            <span class="borderr p-2"  :class="isActive(index)" v-for="page,index in familleCopy" @click="choosePage(index)">{{index+1}}</span>
        </div>
        <table class="table table-sm table-spec table-hover">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Thermique</th>
                    <th>Micro</th>
                    <th>PDT</th>
                    <th>Laser</th>
                    <th>Matricielle</th>
                    <th>AS400</th>
                    <th>Jet d'encre</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="famille,index in familleCopy[pageActive]">
                <td > {{famille.famille}} </td>
                <td @click="updateCol(famille,'therm',index)"> <i class="fa fa-check-circle green" v-if="famille.therm"></i> <span v-else>-</span></td>
                <td @click="updateCol(famille,'mic',index)">  <i class="fa fa-check-circle green" v-if="famille.mic"></i> <span v-else>-</span></td>
                <td @click="updateCol(famille,'pisto',index)">  <i class="fa fa-check-circle green" v-if="famille.pisto"></i> <span v-else>-</span> </td>
                <td @click="updateCol(famille,'las',index)">  <i class="fa fa-check-circle green" v-if="famille.las"></i> <span v-else>-</span> </td>
                <td @click="updateCol(famille,'mat',index)">  <i class="fa fa-check-circle green" v-if="famille.mat"></i> <span v-else>-</span> </td>
                <td @click="updateCol(famille,'as',index)">  <i class="fa fa-check-circle green" v-if="famille.as"></i> <span v-else>-</span> </td>
                <td @click="updateCol(famille,'jet',index)">  <i class="fa fa-check-circle green" v-if="famille.jet"></i> <span v-else>-</span> </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                pageActive :0,
                pageNumber :0,
                familleCopy:[],
            }
        },
        mounted() {
            this.familleCopy = window._.chunk(this.familles,20)
            this.pageNumber = this.familleCopy.length;
        },
        props:['familles'],
        methods:{
            updateCol(famille,col,index){
                console.log(famille.famille);
                console.log(col);
                console.log(famille[col]);

                let vue= this;

                axios.post('/api/famille/update',{
                    'famille' : famille.famille,
                    'column' : col,
                    'value' : ! famille[col],
                    '_method' : 'post',
                    '_token' : window.Laravel.csrfToken,
                })
                    .then(function(response){
                        vue.familleCopy[vue.pageActive][index][col] = +! famille[col] ;
                        Flash(response.data)
                    })
                    .catch(function(response){

                    });
            },
            isActive(index){
                if(this.pageActive === index) return 'bgc';
            },
            choosePage(index){
                this.pageActive = index;
            }
        },
        filters:{
        },
    }
</script>
