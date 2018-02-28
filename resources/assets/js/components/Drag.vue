<template>
<div class="row p-0">

    <div  class="col p-0">
        <draggable element="span" v-model="lun" :options="dragOptions" :move="onMove">
            <transition-group name="no" class=" list-group" tag="ul">
                <li class=" list-group-item" v-for="element in lun" :key="element.order">
                    {{element.name}}
                    <span class="badge">{{element.order}}</span>
                </li>
            </transition-group>
        </draggable>
    </div>

    <div  class="col p-0">
        <draggable element="span" v-model="mar" :options="dragOptions" :move="onMove">
            <transition-group name="no" class="list-group" tag="ul">
                <li class="list-group-item" v-for="element in mar" :key="element.order">
                    {{element.name}}
                    <span class="badge">{{element.order}}</span>
                </li>
            </transition-group>
        </draggable>
    </div>

    <div  class="col p-0">
        <draggable element="span" v-model="mer" :options="dragOptions" :move="onMove">
            <transition-group name="no" class="list-group" tag="ul">
                <li class="list-group-item" v-for="element in mer" :key="element.order">
                    {{element.name}}
                    <span class="badge">{{element.order}}</span>
                </li>
            </transition-group>
        </draggable>
    </div>
    <div  class="col p-0">
        <draggable element="span" v-model="je" :options="dragOptions" :move="onMove">
            <transition-group name="no" class="list-group" tag="ul">
                <li class="list-group-item" v-for="element in je" :key="element.order">
                    {{element.name}}
                    <span class="badge">{{element.order}}</span>
                </li>
            </transition-group>
        </draggable>
    </div>

    <div  class="col p-0">
        <draggable element="span" v-model="ven" :options="dragOptions" :move="onMove">
            <transition-group name="no" class="list-group" tag="ul">
                <li class="list-group-item" v-for="element in ven" :key="element.order">
                    {{element.name}}
                    <span class="badge">{{element.order}}</span>
                </li>
            </transition-group>
        </draggable>
    </div>

</div>

</template>

<script>
    import draggable from 'vuedraggable'

    const lundi = [ '111', '222', '333',]
    const mardi = [ '111-2', '222-2', '333-2', ]
    const mercredi = [ '111-3', '222-3', '333-3', ]
    const jeudi = [ '111-4', '222-4', '333-4', ]
    const vendredi = [ '111-5', '222-5', '333-5',  ]

    export default {
        name: 'hello',
        components: {
            draggable,
        },
        data () {
            return {
                lun :lundi.map( (name,index) => {return {name, order: name+'-'+index,col:1, fixed: false}; }),
                mar :mardi.map( (name,index) => {return {name, order: name+'-'+index,col:2, fixed: false}; }),
                mer :mercredi.map( (name,index) => {return {name, order: name+'-'+index,col:3, fixed: false}; }),
                je :jeudi.map( (name,index) => {return {name, order: name+'-'+index,col:4, fixed: false}; }),
                ven :vendredi.map( (name,index) => {return {name, order: name+'-'+index,col:5, fixed: false}; }),
                editable:true,
                isDragging: false,
                delayedDragging:false
            }
        },
        methods:{
            orderList () {
                this.list = this.list.sort((one,two) =>{return one.order-two.order; })
            },
            onMove ({relatedContext, draggedContext}) {

                const relatedElement = relatedContext.element;
                const draggedElement = draggedContext.element;

                console.log('element '+draggedContext.element.name+' est en train de se deplacer');
                //console.log('pour prendre la place de '+relatedContext.element.name);
                //console.log('dans la colonne n°'+relatedContext.element.col);

                return (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
            }
        },
        computed: {
            dragOptions () {
                return  {
                    animation: 0,
                    group: 'description',
                    disabled: !this.editable,
                    ghostClass: 'ghost'
                };
            },
            listString(){
                return JSON.stringify(this.list, null, 2);
            },
            list2String(){
                return JSON.stringify(this.list2, null, 2);
            }
        },
        watch: {
            isDragging (newValue) {
                if (newValue){
                    this.delayedDragging= true
                    return
                }
                this.$nextTick( () =>{
                    this.delayedDragging =false
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
        background: grey;
    }
    .list-group {
        min-height: 20px;
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item i{
        cursor: pointer;
    }
</style>