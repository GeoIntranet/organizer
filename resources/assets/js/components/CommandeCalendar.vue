<template>
    <div v-if="showCalendar" class="col-md-auto hidden-lg-up column-calendar" >
        <div class="row calendar-wrapper ">
            <div class="col">

                <div class="row " >
                    <div class="col ">
                        <div class="row" >
                            <div class="col-m-auto ">
                                <b>{{ selectedDateSession | dateCalendar}}</b>
                            </div>

                            <div class="col text-right">
                                <a href="" @click.prevent="subMonth"> <i class="fa fa-angle-left  mr-1 b"> </i> </a>
                                <a href="" @click.prevent="addMonth"> <i class="fa fa-angle-right b ml-1"> </i> </a>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col  text-center size--date-day" v-for="(jour,index) in weeksShort ">
                                {{ jour | formated }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row bg-" v-for="week in cal">
                    <div class="col size--date-number " v-for="date in week.date">
                        <span
                                v-if="date === today.format('Y-MM-DD')"
                                @click.prevent="chooseDate(date)"
                                class="rounded-circle "
                                style="background-color: cornflowerblue; color:white ; font-weight: bold;"
                        >
                            {{date | substrDay }}
                        </span>

                        <span
                                v-else
                                class="rounded-circle"
                                @click.prevent="chooseDate(date)"
                                :class="{ 'rounded-circle': true, 'bg-warning': date === selectedDate,'b': date === selectedDate, 'lightgrey':  isEqualMonth(date),}"
                        >
                            {{date | substrDay }}
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </div>

</template>

<style>

</style>

<script>
    import {isLeapYear} from "moment";

    export default {
        data(){
            return{
                showCalendar:true,
                cal : [],
                selectedDateSession :moment(),
                selectedDate:'',
                today :moment(),
                weeks : moment.weekdays(),
                weeksShort : moment.weekdaysShort(),
                weekNumber:''
            }
        },
        mounted() {
            let Sunday = [this.weeksShort.shift()]
            this.weeksShort = this.weeksShort.concat(Sunday);
            this.selectedDateSession = moment(this.dtenvoie);
            this.selectedDate = moment(this.dtenvoie).format('Y-MM-DD');


            this.makeCalendar();



            Event.$on('toggleCalendar',(data)=>{
                this.showCalendar = ! this.showCalendar;
            })
            Event.$on('subWeek',(data)=>{
                this.modifyDate(data)
            })

            Event.$on('addWeek',(data)=>{
                this.modifyDate(data)
            })

            Event.$on('resetWeek',(data)=>{
                this.modifyDate(data)
            })

        },
        filters:{
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
        props:['dtenvoie'],
        methods: {
            modifyDate(data){
                this.selectedDateSession = data;
                this.selectedDate = data.format('Y-MM-DD');
                this.makeCalendar();
            },

            isEqualMonth(date){
                return date.substr(5,2) !== this.selectedDateSession.format('Y-MM-DD').substr(5,2);
            },

            defineRefDate(year,start){

                if(start >=0 && start<=12)
                    return moment().year(year).startOf('year').month(start-1).startOf('month').startOf('week')
                        ;

                return moment().year(year).startOf('month').startOf('week')
            },

            makeCalendar(){
                // di = 0  /  lun = 1 / mar = 2  / mer = 3  / je = 4 / ven = 5 / sam = 6 .
                //declaration de la date de reference

                let dateMutable = this.selectedDateSession;
                let startDayWeek = moment(dateMutable).startOf('month').startOf('week');
                let refDate = startDayWeek

                //refDate =   this.defineRefDate('2018',12);

                this.cal = [];
                for(let w=0 ; w<=5 ; w++){
                    this.cal.push({
                        date: Array(7)
                            .fill(0)
                            .map( function(n, i){

                                if(i === 0 && w ===0){
                                    return refDate.format('Y-MM-DD')
                                }
                                else{
                                    return refDate.add(1,'day').format('Y-MM-DD')
                                }
                                return w
                            }, [w])
                    });
                }
                //console.log(this.cal);
            },

            subMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().subtract(1,'months');
                this.makeCalendar();
            },
            addMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().add(1,'months');
                this.makeCalendar();
            },
            reset(){
                this.selectedDateSession = moment();
                this.makeCalendar();
            },
            chooseDate(date){

               Event.$emit('create_cmd_date',date);



                let dateTMP = moment(date);
                let diffMonth = _.parseInt(date.substr(5,2)) !== this.selectedDateSession.month()+1;
                let diffWeek  = dateTMP.week() !== this.selectedDateSession.week()


                this.selectedDateSession = moment(date);
                this.selectedDate = date;

                if(diffWeek)
                {

                }

                if(diffMonth)
                    this.makeCalendar();

            }
        }
    }
</script>
