<template>
    <div>
        <div class="row p-1" >
            <div class="col">
                <div class="row" >
                    <div class="col-md-6 p-1  ">
                        <b>{{ selectedDateSession | dateCalendar}}</b>
                    </div>
                    <div class="col-md-6 text-right ">
                        <a href="" @click.prevent="subMonth"> <i class="fa fa-angle-left mr-2 b"> </i> </a>
                        <a href="" @click.prevent="addMonth"> <i class="fa fa-angle-right b ml-2"> </i> </a>
                    </div>
                </div>

                <div class="row " >
                    <div class="col " v-for="(jour,index) in weeksShort ">
                         {{ jour | formated }}
                    </div>
                </div>

            </div>
        </div>

        <div class="row" v-for="week in cal">
            <div class="col size--date" v-for="date in week.date">
                <div v-if="date === today.format('Y-MM-DD')">
                    <span style="background-color: indianred;">
                        {{date | substrDay }}
                    </span>
                </div>
                <div v-else>
                     <span>
                        {{date | substrDay }}
                    </span>
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
                cal : [],
                selectedDateSession :moment(),
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

                /*
                  *  problematique de confition jamais remplie
                  *  on ne rentre jamais dans la boucle car depart 52 fin 5 , condition 52 <= 5 jamais valider.
                 * */
                let diff = startDayWeek.weeksInYear() - startWeek + endWeek + 1;
                var w = startWeek ;
                let lastWeekOnYear =  startWeek > endWeek ;

                console.log(this.yearLeap);

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
