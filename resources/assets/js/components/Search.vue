<template>
    <div class="col">
        <form >
            <input
                    ref="search_input"
                    id="search_input"
                    autofocus
                    autocomplete="off" name="search" v-model="search"
                    @keyup="autocomplete"
                    @keyup.esc="closeSearch"
                    @keyup.delete="checkSearch"
                    class="form-control col-12 "
                    type="text" placeholder="Recherche">
        </form>
    </div>

</template>

<script>
    export default {
        data(){
            return {
                search: '',
                hasData: false,
                data: {},
                errorSearch: '',
            }
        },
        computed: {

        },

        methods: {
            checkSearch(){
                console.log('je delete')
                if(this.search.length < 2 ){
                    Event.$emit('closeSearch', this.search)
                }

            },
            closeSearch(){
               Event.$emit('closeSearch');
            },
            resetData(){
                this.hasData = false;
                this.search = '';
                this.data = {};
            },
            readyForSearch(){
                return this.search !== '' ? false : true;
            },
            inputfocus(){
                this.focus = true;
                this.activeComplete = '';
            },
            emptySearch(){
                if (this.search === '') {
                    this.resetData();
                }
            },
            inputOutfocus(){
                this.focus = false;
                this.activeComplete = 'none';
                this.resetData();
            },

            autocomplete(){
                if(this.search.length >= 2 ){
                    Event.$emit('activeResultWindow', this.search)
                }
                else{
                    //Event.$emit('closeSearch', this.search)
                }
            }
        },
        mounted() {
            Event.$on('resetSearch',(data)=>{
                this.search = '';
                this.$refs.search_input.focus();
            })

            Event.$on('focusSearchDelais',(data)=>{
                this.search = 'del'+data.id;
                this.$refs.search_input.focus();
            })
        }
    }
</script>
