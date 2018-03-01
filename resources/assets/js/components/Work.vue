<template>
    <div>
        <div class="row" style="display: none;">
            <div class="col-md-auto">
                Element draggé :
                <pre>{{selectedElement}}</pre>
            </div>
            <div class="col-md-auto">
                Element remplacé:
                <pre>{{replaceElement}}</pre>
            </div>
            <div class="col-md-auto">
                Colonne déposé
                <pre>{{selectedColElement}}</pre>
            </div>
            <div class="col-md-auto">
                INDEX element deposer
                <pre>{{selectedNewIndexElement}}</pre>
            </div>
        </div>

        <div class="row">
            <div class="col-md-auto border" style="color:black">
                {{weekNumber}}
            </div>
            <div class="col border" style=" min-height: 87vh;"
            >
                <draggable
                        :list="wLun"
                        style=" min-height: 87vh;"
                        v-model="wLun"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row border"
                >

                    <transition-group type="transition" :name="'flip-list'" class="col " id="0">

                        <div
                                class="row "
                                v-for="element in wLun"
                                :key="element.id"
                                style="height: 60px;border-bottom:solid 1px lightgray"
                        >
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
            <div class="col border" style=" min-height: 87vh;"
            >
                <draggable
                        :list="wMar"
                        style=" min-height: 87vh;"
                        v-model="wMar"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row "
                >

                    <transition-group type="transition" :name="'flip-list'" class="col" id="1">

                        <div
                                class="row border"
                                v-for="element in wMar"
                                :key="element.id"
                                style="height: 60px;"
                        >
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


            <div class="col border" style=" min-height: 87vh;"
            >
                <draggable
                        :list="wMer"
                        style=" min-height: 87vh;"
                        v-model="wMer"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row "
                >

                    <transition-group type="transition" :name="'flip-list'" class="col" id="2">

                        <div
                                class="row border"
                                v-for="element in wMer"
                                :key="element.id"
                                style="height: 60px;"
                        >
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

            <div class="col border"  style=" min-height: 87vh;"
            >
                <draggable
                        :list="wJe"
                        style=" min-height: 87vh;"
                        v-model="wJe"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row "
                >

                    <transition-group type="transition" :name="'flip-list'" class="col " id="3">
                        <div
                                class="row border"
                                v-for="element in wJe"
                                :key="element.id"
                                style="height: 60px;"
                        >
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
            <div class="col border"  style=" min-height: 87vh;"
            >
                <draggable
                        :list="wVen"
                        style=" min-height: 87vh;"
                        v-model="wVen"
                        :options="dragOptions"
                        :move="onMove"
                        @start="onStart"
                        @end="onEnd"
                        @add="onAdd"
                        class=" row "
                >

                    <transition-group
                            type="transition"
                            :name="'flip-list'"
                            class="col "
                            id="4"
                    >

                        <div
                                class="row border"
                                v-for="element in wVen"
                                :key="element.id"
                                style="height: 60px; cursor: pointer;"
                        >
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
        <div class="row" style="display:none">
            <div class="col">
                <pre>{{lunString}}</pre>
            </div>
            <div class="col">
                <pre>{{marString}}</pre>
            </div>
            <div class="col">
                <pre>{{merString}}</pre>
            </div>
            <div class="col">
                <pre>{{jeString}}</pre>
            </div>
            <div class="col">
                <pre>{{venString}}</pre>
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
            Event.$on('getWorks',(data)=>{
                this.weekNumber = data;
                this.getWorksWeek()
            })

                this.getWorksWeek()
        },
        methods: {
            getWorksWeek(){
                axios.get('/team/get/work/'+this.weekNumber).then(
                    response => {
                        this.work =  response.data;

                        this.wLun = response.data[0];
                        this.wMar = response.data[1];
                        this.wMer = response.data[2];
                        this.wJe = response.data[3];
                        this.wVen = response.data[4];
                    }
                );
            },
            onStart(event, oEvent) {

            },
            onEnd: function (/**Event*/evt) {
                var itemEl = evt.item;  // dragged HTMLElement
                var colFrom = evt.from.getAttribute('id')
                var colTo = evt.to.getAttribute('id')
                console.log(colFrom);
                console.log(colTo);
                this.selectedColElement = colTo;
                //console.log(itemEl);    // target list
                //console.log(evt.to);    // target list
                //console.log(evt.from);  // previous list
                //console.log('OldIndex- '+evt.oldIndex);  // element's old index within old parent
                this.selectedNewIndexElement = evt.newIndex+1

                axios.get('/team/'+this.semaine+'/'+this.selectedElement+'/'+this.selectedNewIndexElement+'/'+this.selectedColElement).then(
                    response => {
                        console.log(response.data)
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
        opacity: .5;
        background: #C8EBFB;
    }

    .list-group {
        min-height: 20px;
        border: solid 1px red;
    }

    .list-group-item {
        cursor: pointer;
    }

    .list-group-item i {
        cursor: pointer;
    }
</style>