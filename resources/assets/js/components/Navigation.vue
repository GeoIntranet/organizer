<template>
        <ul class="nopuce " style="font-size:15px">
            <li class="title-nav"><i class="fa fa-compass fa-2x"> </i> Navigation</li>
            <li class="item-nav">En cours</li>
            <li>
                <span @click="toggleSubOne" class="header-sub-nav">{{iconeOne}} &nbsp; Fiches</span>
                <ul v-if="showSubOne">
                    <li>test 2-1</li>
                    <li>test 2-2</li>
                    <li>test 2-3</li>
                </ul>
            </li>
            <li >
                <span @click="toggleSubTwo" class="header-sub-nav">{{iconeTwo}} &nbsp; Achats</span>
                <ul v-if="showSubTwo">
                    <li>test 2-4</li>
                    <li>test 2-5</li>
                    <li>test 2-6</li>
                </ul>
            </li>
            <li >
                <span @click="toggleSubThree" class="header-sub-nav">{{iconeThree}} &nbsp; Stock</span>
                <ul v-if="showSubThree">
                    <li>test 2-4</li>
                    <li>test 2-5</li>
                    <li>test 2-6</li>
                </ul>
            </li>
            <li >
                <span @click="toggleSubFour" class="header-sub-nav"> {{iconeFour}} &nbsp; Administration</span>
                <ul v-if="showSubFour">
                    <li>test 2-4</li>
                    <li>test 2-5</li>
                    <li>test 2-6</li>
                </ul>
            </li>

        </ul>
</template>

<script>
    export default {
        data(){
            return{
                showSubOne:false,
                showSubTwo:false,
                showSubThree:false,
                showSubFour:false,
                iconeOne:'+',
                iconeTwo:'+',
                iconeThree:'+',
                iconeFour:'+',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        computed:{
          sigleFour(){
              return '-'
            }
        },
        methods:{
            toggleSubFour(){
                this.showSubFour = ! this.showSubFour
                this.toggleIcone(4);
            },
            toggleSubThree(){
                this.showSubThree = ! this.showSubThree
                this.toggleIcone(3);
            },
            toggleSubTwo(){
                this.showSubTwo = ! this.showSubTwo
                this.toggleIcone(2);
            },
            toggleSubOne(){
                this.showSubOne = ! this.showSubOne
                this.toggleIcone(1);
            },
            toggleIcone(icone){
                if(icone  === 4) this.iconeFour = this.iconeFour === '+' ? '-' :'+'
                if(icone  === 3) this.iconeThree = this.iconeThree === '+' ? '-' :'+'
                if(icone  === 2) this.iconeTwo = this.iconeTwo === '+' ? '-' :'+'
                if(icone  === 1) this.iconeOne = this.iconeOne === '+' ? '-' :'+'
            }
        }
    }
</script>
