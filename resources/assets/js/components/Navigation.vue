<template>
        <ul class="nopuce " style="font-size:15px">
            <li class="title-nav"><i class="fa fa-compass fa-2x"> </i> Navigation</li>
            <li>
                <span @click="toggleSubOne" class="header-sub-nav">{{iconeOne}} &nbsp; Fiches</span>
                <ul v-if="showSubOne">
                    <li @click="showAllFiche">en cours</li>
                    <li @click="showAllFiche">attente de virement </li>
                    <li>du groupe</li>
                    <li>expedié la veille</li>
                </ul>
            </li>
            <li >
                <span @click="toggleSubTwo" class="header-sub-nav">{{iconeTwo}} &nbsp; les groupes</span>
                <ul v-if="showSubTwo">
                    <li>thermique</li>
                    <li>pdt</li>
                    <li>micro</li>
                    <li>laser</li>
                    <li>matricielle</li>
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
            showAllFiche(){
                Event.$emit('showAllFicheWindow');
            },
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
