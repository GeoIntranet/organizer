<template>
    <div>

        <div class="row" >
            <div class="col border" v-for="date in cal">
                {{date.dn | capitalize}}
                <br>
                <h1>{{date.dnu.substr(-2)}}</h1>
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
                cal : [] ,
            }
        },
        mounted() {
            this.weeksShort.shift();
            this.weeksShort.pop();
            this.cal = this.getDayOfWeek();

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
            getDayOfWeek(){

                let start = this.selectedDateSession.startOf('week');
                let i;
                let calendar = [] ;

                for(i=0; i<5; i++)
                {
                    if( i > 0 ){
                        calendar[i] = {
                            'dn' : this.weeksShort[i],
                            'dnu' : start.add(1,'day').format('Y-MM-D')
                        };
                    }
                    else{
                        calendar[i] = {
                            'dn' : this.weeksShort[i],
                            'dnu' : start.format('Y-MM-D')
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
