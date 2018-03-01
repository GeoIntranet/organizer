<template>
    <div class="row calendar-wrapper">
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

</template>

<style>

</style>

<script>
    import {isLeapYear} from "moment";

    export default {
        data(){
            return{
                cal : [],
                selectedDateSession :moment(),
                selectedDate:'',
                today :moment(),
                yearLeap: false,
                weeks : moment.weekdays(),
                weeksShort : moment.weekdaysShort(),
            }
        },
        mounted() {
            let Sunday = [this.weeksShort.shift()]
            this.weeksShort = this.weeksShort.concat(Sunday);
            this.yearLeap = this.isLEap();
            this.makeCalendar();

            Event.$on('subWeek',(data)=>{

                this.selectedDateSession = data;
                this.selectedDate = data.format('Y-MM-DD');
                this.yearLeap = this.isLEap();
                this.makeCalendar();
            })

            Event.$on('addWeek',(data)=>{

                this.selectedDateSession = data;
                this.selectedDate = data.format('Y-MM-DD');
                this.yearLeap = this.isLEap();
                this.makeCalendar();
            })

            Event.$on('resetWeek',(data)=>{

                this.selectedDateSession = data;
                this.selectedDate = data.format('Y-MM-DD');
                this.yearLeap = this.isLEap();
                this.makeCalendar();
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
        methods: {

            isEqualMonth(date){
              return date.substr(5,2) !== this.selectedDateSession.format('Y-MM-DD').substr(5,2);
            },
            isLEap(){
               let date_y = this.selectedDateSession.format('Y');
                return ((date_y % 4 === 0) && (date_y % 100 !== 0)) || (date_y % 400 === 0);
            },
            makeCalendar(){

                this.cal=[];
                let dateMutable = this.selectedDateSession;

                let startWeek = moment(dateMutable).startOf('month').startOf('week').week();
                let startDayWeek = moment(dateMutable).startOf('month').startOf('week');
                let endDayWeek = moment(dateMutable).endOf('month').endOf('week');
                let endWeek = endDayWeek.week();
                let diffWeek = startWeek-endWeek;

                console.log(startDayWeek.format('Y-MM-DD'))
                console.log(diffWeek);
                //console.log(dateMutable.format('Y-MM-DD'))
                //console.log(startWeek)
                //console.log(endWeek)


                /*
                  *  problematique de confition jamais remplie
                  *  on ne rentre jamais dans la boucle car depart 52 fin 5 , condition 52 <= 5 jamais valider.
                 * */
                let diff = startDayWeek.weeksInYear() - startWeek + endWeek + 1;
                var w = startWeek ;
                let lastWeekOnYear =  startWeek > endWeek ;

                // test années bisextile ( jour décallé )
                if(this.yearLeap){
                    if(lastWeekOnYear)
                    {
                        startDayWeek.subtract(1,'days');
                        for( var test = 1 ; test <= diff ; test++ )
                        {
                            if( w > startDayWeek.weeksInYear() ) w = w - startDayWeek.weeksInYear();

                            this.cal.push({
                                week:week,
                                date: Array(7) .fill(-1) .map( (n, i) => startDayWeek.add(1, 'day').format('YYYY-MM-DD'), )
                            });

                            w++;
                        };
                    }
                    else{
                        /*
                         * PROBLEME DE GESTION DES SEMAINE voir changement d'année !
                         * */
                        for( var week = startWeek; week <= endWeek  ; week++ ) {
                            if(week > startDayWeek.weeksInYear()) week = week - startDayWeek.weeksInYear();
                            this.cal.push({
                                week:week,
                                date:
                                    Array(7) .fill(-1)
                                        .map(
                                            (n, i) =>
                                                moment() .year(startDayWeek.year()) .week(week) .startOf('week') .clone()
                                                    .add(n + i, 'day')
                                                    .format('YYYY-MM-DD')
                                            ,
                                        )
                            })
                        }
                    }
                }
                else{
                    if(lastWeekOnYear)
                    {
                        startDayWeek.subtract(1,'days');
                        for( var test = 1 ; test <= diff ; test++ )
                        {
                            if( w > startDayWeek.weeksInYear() ) w = w - startDayWeek.weeksInYear();

                            this.cal.push({
                                week:week,
                                date: Array(7) .fill(0) .map( (n, i) => startDayWeek.add(1, 'day').format('YYYY-MM-DD'), )
                            });

                            w++;
                        };
                    }
                    else{
                        /*
                         * PROBLEME DE GESTION DES SEMAINE voir changement d'année !
                         * */
                        for( var week = startWeek; week <= endWeek  ; week++ ) {
                            if(week > startDayWeek.weeksInYear()) week = week - startDayWeek.weeksInYear();
                            this.cal.push({
                                week:week,
                                date:
                                    Array(7) .fill(0)
                                        .map(
                                            (n, i) =>
                                                moment() .year(startDayWeek.year()) .week(week) .startOf('week') .clone()
                                                    .add(n + i, 'day')
                                                    .format('YYYY-MM-DD')
                                            ,
                                        )
                            })
                        }
                    }
                }
            },

            subMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().subtract(1,'months');
                this.yearLeap=this.isLEap();
                this.makeCalendar();
            },
            addMonth(){
                this.selectedDateSession = this.selectedDateSession.clone().add(1,'months');
                this.yearLeap=this.isLEap();
                this.makeCalendar();
            },
            reset(){
                this.selectedDateSession = moment();
                this.yearLeap=this.isLEap();
                this.makeCalendar();
            },
            chooseDate(date){
                this.selectedDate = date
                Event.$emit('chooseDate',date);
            }
        }
    }
</script>
