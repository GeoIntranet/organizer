<template>
    <div>

        <div class="row " v-if="isLoading">
            <div class="col-md-auto col-week-number" style="color:black ; min-height: 87vh;">
                {{weekNumber}}
            </div>
            <div v-for="(dayWeeks,index) in weeksList"
                 style="min-height: 87vh;"
                 class="pt-3 col  col-work-week text-center "
            >
                <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x"> </i>
            </div>
        </div>

        <div v-else class="row">
            <div class="col-md-auto col-week-number" style="color:black">
                {{weekNumber}}
            </div>
            <div
                    v-for="(dayWeeks,index) in weeksList"
                    class="col col-work-week"
                    style=" min-height: 87vh;"
            >

                <draggable
                        :list="weeksList[index]"
                        style=" min-height: 87vh;"
                        v-model="weeksList[index]"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row "
                >

                    <transition-group type="transition" :name="'flip-list'" class="col" :id="index">

                        <div
                                class="row work"
                                v-for="element in weeksList[index]"
                                :key="element.id"
                                style="height: 75px;"

                        >
                            <element-work :work="element"></element-work>

                        </div>
                    </transition-group>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        name: 'work',
        components: {
            draggable,
        },
        data() {
            return {
                lodash :_,
                isLoading : false,
                weeksList : [],
                work:[],
                editable: true,
                isDragging: false,
                delayedDragging: false,
                selectedElement: '',
                replaceElement: 'add_in_new_column',
                selectedColElement: '',
                selectedNewIndexElement:'',
                weekNumber:moment().week()
            }
        },
        props: ['semaine'],
        mounted(){

            for (let i=0; i<5; i++) {
                this.weeksList.push([]);
            }

            Event.$on('getWorks',(data)=>{
                this.weekNumber = data;
                this.getWorksWeek()
            })

            Event.$on('refreshWork',(data)=>{
                this.getWorksWeek()
            })

            Event.$on('removeElement',(data)=>{

                this.work.forEach(function(element){
                   element.forEach(function(item,index){
                       if(item.id === data ){
                           element.splice(index,1);
                       }
                   })
                })
                //this.getWorksWeek()
            })

            Event.$on('resetResultWork',(data)=>{
                this.isLoading = true;

                this.weeksList.forEach(function(element){
                    return [];
                });

            })

            this.getWorksWeek()
        },

        methods: {


            getWorksWeek(){
                this.isLoading = true;
                axios.get('/team/get/work/'+this.weekNumber)
                    .then(
                    response => {
                        this.work =  response.data;

                        let arrayElement = []
                        response.data.forEach(function(element) {
                            arrayElement.push(element);
                        });

                        this.weeksList = arrayElement;
                        this.isLoading = false;
                    }
                );
            },
            onStart(event, oEvent) {

            },
            onEnd: function (/**Event*/evt) {
                var itemEl = evt.item;  // dragged HTMLElement
                var colFrom = evt.from.getAttribute('id')
                var colTo = evt.to.getAttribute('id')
                this.selectedColElement = colTo;
                this.selectedNewIndexElement = evt.newIndex+1

                axios.get('/team/'+this.semaine+'/'+this.selectedElement+'/'+this.selectedNewIndexElement+'/'+this.selectedColElement).then(
                    response => {
                        //console.log(response.data)
                    }
                );


            },
            onAdd(event, oEvent) {
                //console.log(event['to'].getAttribute('id'));
            },
            orderList() {
                this.list = this.list.sort((one, two) => {
                    return one.order - two.order;
                })
            },
            onMove(event, oEvent) {

                const relatedElement = event.relatedContext;
                const draggedElement = event.draggedContext;

                this.selectedElement = draggedElement.element.id;

                this.replaceElement = 'add_in_new_column';

                if (typeof event.relatedContext.element !== 'undefined')
                    this.replaceElement = event.relatedContext.element.id;

                return (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
            }
        },
        computed: {

            dragOptions() {
                return {
                    animation: 0,
                    group: 'description',
                    disabled: !this.editable,
                    ghostClass: 'ghost'
                };
            },
        },
        watch: {
            isDragging(newValue) {
                if (newValue) {
                    this.delayedDragging = true
                    return
                }
                this.$nextTick(() => {
                    this.delayedDragging = false
                })
            }
        }
    }
</script>

<style>
    .flip-list-move {
        transition: transform 0.5s;
    }

    .no-move {
        transition: transform 0s;
    }

    .ghost {

        background-color: lightgrey;
        color: lightgrey;
        //background: #C8EBFB;
    }
    .sortable-chosen{

    }
    .list-group {
        min-height: 20px;
        border: solid 1px red;
    }

    .list-group-item {

    }

    .list-group-item i {

    }
</style>