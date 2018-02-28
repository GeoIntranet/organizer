<template>
    <div >
       <div class="row">

           <div  class="col border" style="height: 400px;"
           >
               <draggable
                       :list="lun"
                       style="min-height: 400px;"
                       v-model="lun"
                       :options="dragOptions"
                       :move="onMove"
                       @start="onStart"
                       @end="onEnd"
                       @add="onAdd"
                       class=" row border"
               >

                   <transition-group type="transition" :name="'flip-list'"  class="col " id="0">

                       <div
                               class="row border"
                               v-for="element in lun"
                               :key="element.order"
                               style="height: 60px;"
                       >
                           <div class="col text-left ">
                               <b> {{element.order}}</b>
                           </div>
                           <div class="col">
                               {{element.name}}
                           </div>

                       </div>
                   </transition-group>
               </draggable>
           </div>
           <div  class="col border" style="height: 400px;"
           >
               <draggable
                       :list="mar"
                       style="min-height: 400px;"
                       v-model="mar"
                       :options="dragOptions"
                       :move="onMove"
                       @start="onStart"
                       @end="onEnd"
                       @add="onAdd"
                       class=" row "
               >

                   <transition-group type="transition" :name="'flip-list'"  class="col" id="1">

                       <div
                               class="row border"
                               v-for="element in mar"
                               :key="element.order"
                               style="height: 60px;"
                       >
                           <div class="col text-left ">
                               <b> {{element.order}}</b>
                           </div>
                           <div class="col">
                               {{element.name}}
                           </div>

                       </div>
                   </transition-group>
               </draggable>
           </div>
           <div  class="col border" style="height: 400px;"
           >
               <draggable
                       :list="mer"
                       style="min-height: 400px;"
                       v-model="mer"
                       :options="dragOptions"
                       :move="onMove"
                       @start="onStart"
                       @end="onEnd"
                       @add="onAdd"
                       class=" row "
               >

                   <transition-group type="transition" :name="'flip-list'"  class="col" id="2">

                       <div
                               class="row border"
                               v-for="element in mer"
                               :key="element.order"
                               style="height: 60px;"
                       >
                           <div class="col text-left ">
                               <b> {{element.order}}</b>
                           </div>
                           <div class="col">
                               {{element.name}}
                           </div>

                       </div>
                   </transition-group>
               </draggable>
           </div>

           <div  class="col border" style="height: 400px;" >
               <draggable
                       :list="je"
                       style="min-height: 400px;"
                       v-model="je"
                       :options="dragOptions"
                       :move="onMove"
                       @start="onStart"
                       @end="onEnd"
                       @add="onAdd"
                       class=" row "
               >

                   <transition-group type="transition" :name="'flip-list'"  class="col " id="3">
                       <div
                               class="row border"
                               v-for="element in je"
                               :key="element.order"
                               style="height: 60px;"
                       >
                           <div class="col text-left ">
                               <b> {{element.order}}</b>
                           </div>
                           <div class="col">
                               {{element.name}}
                           </div>

                       </div>
                   </transition-group>
               </draggable>
           </div>
           <div  class="col border" style="height: 400px;"
           >
               <draggable
                       :list="ven"
                       style="min-height: 400px;"
                       v-model="ven"
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
                               v-for="element in ven"
                               :key="element.order"
                               style="height: 60px; cursor: pointer;"

                       >
                           <div class="col text-left ">
                              <b> {{element.order}}</b>
                           </div>
                           <div class="col">
                               {{element.name}}
                           </div>

                       </div>
                   </transition-group>
               </draggable>
           </div>

       </div>
       <div class="row" style="display:none">
           <div class="col"> <pre>{{lunString}}</pre>  </div>
           <div class="col"> <pre>{{marString}}</pre>  </div>
           <div class="col"> <pre>{{merString}}</pre>  </div>
           <div class="col"> <pre>{{jeString}}</pre>  </div>
           <div class="col"> <pre>{{venString}}</pre>  </div>
       </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    const lundi = [ '111', '222', '333', ]
    const mardi = [ '111-2', '222-2', ]
    const mercredi = [ '111-3', '222-3', ]
    const jeudi = [ '111-4', '222-4',  ]
    const vendredi = ['111-5',]

    const message = [ 'vue.draggable', 'draggable', 'component', 'for', 'vue.js 2.0', 'based' , 'on', 'Sortablejs' ]
    const message2 = [ 'vue.draggable', 'draggable', 'component', 'for', 'vue.js 2.0', 'based' , 'on', 'Sortablejs' ]

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
                list: message.map( (name,index) => {return {name, order: index+1, fixed: false}; }),
                list2:message2.map( (name,index) => {return {name, order: index+1, fixed: false}; }),
                editable:true,
                isDragging: false,
                delayedDragging:false,
                selectedElement:'',
                replaceElement:'add_in_new_column',
                selectedColElement:''
            }
        },
        methods:{
            onStart (event, oEvent) {

            },
            onEnd: function (/**Event*/evt) {
                var itemEl = evt.item;  // dragged HTMLElement

                //console.log(itemEl);    // target list
                //console.log(evt.to);    // target list
                //console.log(evt.from);  // previous list
                //console.log('OldIndex- '+evt.oldIndex);  // element's old index within old parent
                //console.log('OldIndex- '+evt.newIndex);  // element's new index within new parent
            },
            onAdd (event, oEvent) {
                this.selectedColElement = event['to'].getAttribute('id')
                //console.log(event['to'].getAttribute('id'));
            },
            orderList () {
                this.list = this.list.sort((one,two) =>{return one.order-two.order; })
            },
            onMove (event, oEvent) {

                const relatedElement = event.relatedContext;
                const draggedElement = event.draggedContext;

                this.selectedElement = draggedElement.element.name;

                console.log(typeof this.replaceElement.element)

                this.replaceElement = 'add_in_new_column';

                if(typeof event.relatedContext.element !== 'undefined')
                    this.replaceElement = event.relatedContext.element.name;

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
            lunString(){
                return JSON.stringify(this.lun, null, 2);
            },
            marString(){
                return JSON.stringify(this.mar, null, 2);
            },
            merString(){
                return JSON.stringify(this.mer, null, 2);
            },
            jeString(){
                return JSON.stringify(this.je, null, 2);
            },
            venString(){
                return JSON.stringify(this.ven, null, 2);
            },
            list2String(){
                return JSON.stringify(this.list2, null, 2);
            }
        },
        watch: {

            isDragging (newValue) {
                if (newValue){
                    this.delayedDragging = true
                    return
                }
                this.$nextTick( () =>{
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
        border:solid 1px red;
    }
    .list-group-item {
        cursor: pointer;
    }
    .list-group-item i{
        cursor: pointer;
    }
</style>