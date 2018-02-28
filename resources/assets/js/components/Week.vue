<template>
    <div>
        <div class="row" >
            <div class="col border" v-for="date in cal">
                {{date.dn | capitalize}}
                <br>
                <h1>{{date.dnu.substr(-2)}}</h1>
            </div>
        </div>

        <div class="row" >
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
                work : [],
                cal : [] ,
            }
        },
        mounted() {
            this.weeksShort.shift();
            this.weeksShort.pop();
            this.cal = this.getDayOfWeek();
            this.getWorksWeek();

        },
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
                axios.get('/team/get/work/9').then(
                    response => {
                      this.work =  response.data;
                    }
                );
            },
            getDayOfWeek(){

                let start = this.selectedDateSession.startOf('week');
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
            makeCalendar(){
                this.cal=[];
            },

            subYear(){
                this.selectedDateSession = this.selectedDateSession.clone().subtract(1,'years');
                axios.post('/configuration/calendar/set/session',{date:this.selectedDateSession});
                this.getMovement();
                this.makeCalendar();
            },
            addYear(){
                this.selectedDateSession = this.selectedDateSession.clone().add(1,'years');
                axios.post('/configuration/calendar/set/session',{date:this.selectedDateSession});
                this.makeCalendar();
            },
            subMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().subtract(1,'months');
                axios.post('/configuration/calendar/set/session',{date:this.selectedDateSession});
                this.makeCalendar();
            },
            addMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().add(1,'months');
                axios.post('/configuration/calendar/set/session',{date:this.selectedDateSession});
                this.makeCalendar();
            },
            reset(){
                this.selectedDateSession = moment();
                axios.post('/configuration/calendar/set/session',{date:this.selectedDateSession});
                this.makeCalendar();
            },
        }
    }
</script>
