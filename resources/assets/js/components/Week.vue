<template>
    <div>
        <div class="row wrapper-weeks" >
            <div class="col-md-auto col-week-number">
                {{weekNumber}}
            </div>
            <div class="col col-day" v-for="(date,index) in cal">

                <div class="row week">
                    <div class="col">
                        {{date.dn | capitalize}}
                        <br>
                        <h1>{{date.dnu.substr(-2)}}</h1>
                    </div>
                </div>

                <div class="row work">
                   <div class="col"><h4>test</h4></div>
                </div>
                <div class="row work">
                    <div class="col"><h4>test</h4></div>
                </div>
                <div class="row work">
                    <div class="col"><h4>test</h4></div>
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
                weeksLong : moment.weekdays(),
                weeksDay : [],
                weekNumber : moment().week(),
                work : [],
                cal : [] ,
                dayN : [] ,
                yearN: [] ,
                monthN : [] ,
                dt :moment(),
            }
        },
        props:['year','day','month'],
        mounted() {
            Event.$on('addWeek',(data)=>{
                this.syncDate(data)
            })

            Event.$on('subWeek',(data)=>{
               this.syncDate(data)
            })

            Event.$on('resetWeek',(data)=>{
                this.syncDate(data)
            })

            Event.$on('chooseDate',(data)=>{
                this.dt = moment(data);
                this.syncDate( this.dt)
            })

            this.dayN = parseInt(this.day);
            this.monthN = parseInt(this.month);
            this.yearN = parseInt(this.year);

            // ATTENTION dans moment les mont c'est de 0 a 11 ! - c'est pk on sub un month
            this.dt = moment([this.year,this.month,this.day]).subtract(1,'month');
            this.weekNumber = this.dt.week()

            this.fitDayNumber();



            this.cal = this.getDayOfWeek();

        },
        filters:{
            capitalize: function (value) {

                if (!value) return ''
                return _.capitalize(value);
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
            fitDayNumber(){

                this.weeksShort.shift();
                this.weeksShort.pop();

                this.weeksLong.shift();
                this.weeksLong.pop();
            },
            syncDate(data){
                this.dt = data
                this.weekNumber = data.week();
                this.cal = this.getDayOfWeek();

                Event.$emit('getWorks', this.weekNumber )
            },
            getWorksWeek(){
                axios.get('/team/get/work/'+this.weekNumber).then(
                    response => {
                      this.work =  response.data;
                    }
                );
            },
            getDayOfWeek(){

                let start_ = this.dt.startOf('week');
                let start = this.dt.startOf('week');

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
