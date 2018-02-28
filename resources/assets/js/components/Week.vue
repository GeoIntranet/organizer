<template>
    <div>
        <div class="row" >
            <div class="col border" v-for="(date,index) in cal">
                {{date.dn | capitalize}}
                <br>
                <h1>{{date.dnu.substr(-2)}}</h1>
            </div>
        </div>

        <div class="row" style="display: none;">
            <div class="col border" v-for="content in work">

                <div class="row p-1 border" v-if="content !== 0 " v-for="cmd in content">
                    <div class="col ">
                        <div class="row">
                            <div class="col text-left"><i class="fa fa-angle-left"> </i></div>
                            <div class="col-md-auto"> {{cmd.id_cmd}}</div>
                            <div class="col text_right"><i class="fa fa-angle-right"> </i></div>
                        </div>

                    </div>
                </div>
                <div class="row" v-if="content === 0 ">
                    <div class="col">Empty</div>
                </div>
            </div>
        </div>
        <work :semaine="weekNumber"></work>
    </div>

</template>

<style>
    .size--date{
        font-size: 0.7em;
    }
</style>

<script>
    import {isLeapYear} from "moment";

    export default {
        data(){
            return{
                selectedDateSession :moment(),
                today :moment(),
                yearLeap: false,
                weeks : moment.weekdays(),
                weeksShort : moment.weekdaysShort(),
                weeksDay : [],
                weekNumber : moment().week(),
                work : [],
                cal : [] ,
            }
        },
        mounted() {

            Event.$on('addWeek',(data)=>{
                this.weekNumber = data+1;
                this.cal = this.getDayOfWeek();
                Event.$emit('syncWeek', this.weekNumber )
                Event.$emit('getWorks', this.weekNumber )
            })

            Event.$on('subWeek',(data)=>{
                this.weekNumber = data-1;
                this.cal = this.getDayOfWeek();
                Event.$emit('syncWeek', this.weekNumber )
                Event.$emit('getWorks', this.weekNumber )

            })

            Event.$on('resetWeek',(data)=>{
                this.resetWeek();
                this.cal = this.getDayOfWeek();
                Event.$emit('syncWeek', this.weekNumber )
            })

            this.weeksShort.shift();
            this.weeksShort.pop();
            this.weekNumber = this.week;
            this.cal = this.getDayOfWeek();

        },
        props:['week'],
        filters:{
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },
            formated(data){
                return data.toUpperCase().replace('.','').substr(0,1);
            },
            dateCalendar(data){
                let date = data.format('MMMM YYYY');

                return date.substring(0,1).toUpperCase() +
                    date.substring(1,date.length)
            },
            dayCalendar(data){
                return data.format('DD MMMM YYYY');
            },
            substrDay(data){
                return data.substr(-2);
            }
        },
        methods: {
            getWorksWeek(){
                axios.get('/team/get/work/'+this.weekNumber).then(
                    response => {
                      this.work =  response.data;
                    }
                );
            },
            getDayOfWeek(){
                //console.log(dayWeek);
                let start_ = this.selectedDateSession.startOf('week');
                let start = moment().startOf('year').add(this.weekNumber, 'weeks');

                let i;
                let calendar = [] ;

                for(i=0; i<5; i++)
                {
                    if( i > 0 ){
                        calendar[i] = {
                            'dn' : this.weeksShort[i],
                            'dnu' : start.add(1,'day').format('Y-MM-DD')
                        };
                    }
                    else{
                        calendar[i] = {
                            'dn' : this.weeksShort[i],
                            'dnu' : start.format('Y-MM-DD')
                        };
                    }
                }
                return calendar;
            },
            isLEap(){
                let date_y = this.selectedDateSession.format('Y');
                return ((date_y % 4 === 0) && (date_y % 100 !== 0)) || (date_y % 400 === 0);
            },
            subWeek(){
            },
            addWeek(){
            },
            resetWeek(){
                this.weekNumber = this.today.week();
            },
        }
    }
</script>
