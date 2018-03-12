<template>
    <div>

        <div class="row " v-if="isLoading">
            <div class="col-md-auto col-week-number" style="color:black ; min-height: 87vh;">
                {{weekNumber}}
            </div>
            <div style="min-height: 87vh;" class="pt-3 col  col-work-week text-center ">
                <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x"> </i>
            </div>
            <div style="min-height: 87vh;" class="pt-3 col  col-work-week text-center ">
                <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x"> </i>
            </div>
            <div style="min-height: 87vh;" class="pt-3 col  col-work-week text-center ">
                <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x"> </i>
            </div>
            <div style="min-height: 87vh;" class="pt-3 col  col-work-week text-center ">
                <i style="color:lightgray" class="fa fa-circle-o-notch fa-spin fa-2x"> </i>
            </div>
            <div style="min-height: 87vh;" class="pt-3 col col-work-week  text-center ">
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
                                style="height: 60px;"

                        >
                            <div class="col text-left " @click="editItem(element)">
                                <i class="fa fa-pencil"> </i>
                            </div>
                            <div class="col text-left ">
                                <b> {{element.id}}</b>
                            </div>
                            <div class="col">
                                {{element.id_cmd}}
                            </div>

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
                isLoading : false,
                weeksList : [],
                wLun: [],
                wMar: [],
                wMer: [],
                wJe: [],
                wVen: [],
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

            this.weeksList.push(this.wLun);
            this.weeksList.push(this.wMar);
            this.weeksList.push(this.wMer);
            this.weeksList.push(this.wJe);
            this.weeksList.push(this.wVen);


            Event.$on('getWorks',(data)=>{
                console.log(this.isLoading)

                this.weekNumber = data;
                this.wLun = [];
                this.wMar = [];
                this.wMer = [];
                this.wJe = [];
                this.wVen = [];
                this.getWorksWeek()
            })

            Event.$on('resetResultWork',(data)=>{
                this.isLoading = true;
                console.log('JE RESET ');
                this.weeksList = [];
                this.wLun = [];
                this.wMar = [];
                this.wMer = [];
                this.wJe = [];

                this.wVen = [];
                console.log(this.isLoading)

            })

            this.getWorksWeek()
        },
        methods: {

            editItem(data){
                Event.$emit('editItem',data)
                Event.$emit('focusSearchDelais',data)
            },

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
                //console.log(colFrom);
                //console.log(colTo);
                this.selectedColElement = colTo;
                //console.log(itemEl);    // target list
                //console.log(evt.to);    // target list
                //console.log(evt.from);  // previous list
                //console.log('OldIndex- '+evt.oldIndex);  // element's old index within old parent
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
            listString() {
                return JSON.stringify(this.list, null, 2);
            },
            lunString() {
                return JSON.stringify(this.wLun, null, 2);
            },
            marString() {
                return JSON.stringify(this.wMar, null, 2);
            },
            merString() {
                return JSON.stringify(this.wMer, null, 2);
            },
            jeString() {
                return JSON.stringify(this.wJe, null, 2);
            },
            venString() {
                return JSON.stringify(this.wVen, null, 2);
            },
            list2String() {
                return JSON.stringify(this.list2, null, 2);
            }
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