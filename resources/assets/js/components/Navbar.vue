<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container-fluid">
            <a class="navbar-brand" href="">

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav  col-6">
                    <a @click.prevent="hideToolbar" class="navbar-brand mr-3" href="/">
                       <i class="fa fa-bars"> </i>
                    </a>
                    <a class="navbar-brand mr-4 ml-3" href="/">
                        <img src="/images/euro.png" width="30" height="30" class="d-inline-block align-top" alt="">
                        <b>O</b><i><u>rg</u></i><b>anizer</b>
                    </a>
                    <a @click.prevent="getTodayWork" class="ml-4 mr-4 navbar-brand" href="#">
                        Aujourd'hui
                    </a>
                    <a class="ml-4  mr-1 navbar-brand" href="#" @click.prevent="subWeek">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="ml-1 navbar-brand" href="#" @click.prevent="addWeek">
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a class="navbar-brand" href="#">
                       {{displayMonth | capitalize}} {{year}}
                    </a>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav mr-auto  col-6">

                    <search></search>

                    <!-- Authentication Links -->
                    <li v-if="!signed"><a class="nav-link" href="">Login</a></li>
                    <li v-if="!signed"><a class="nav-link" href="">Register</a></li>


                    <a  class="navbar-brand col-md-auto ml-2 p-0" href="/"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    >
                        {{user.prenom}} <i class="fa fa-power-off ml-2" style="color:indianred"> </i>
                    </a>

                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data(){
            return{
                user:window.organizer.user,
                signed:window.organizer.signedIn,
                csrf:window.organizer.csrfToken,
                app:window.organizer.app,
                weekNumber:moment().week(),
                dt:'',
                monthN : 0,
                dayN : 0,
                yearN : 0,
                displayMonth : 0,
                displayDate : '',
            }
        },
        props:['year','month','day'],
        mounted() {
            this.dayN = parseInt(this.day);
            this.monthN = parseInt(this.month);
            this.yearN = parseInt(this.year);

            // ATTENTION dans moment les mont c'est de 0 a 11 ! - c'est pk on sub un month
            this.dt = moment([this.year,this.month,this.day]).subtract(1,'month');
            this.weekNumber = this.dt.week()
            this.displayMonth = moment.months()[this.monthN-1]
            this.displayDate  =  this.dt.format('Y-MM-DD');

            Event.$on('syncWeekNavbar',(data)=>{
                this.weekNumber = data;
            })

            Event.$on('chooseDate',(data)=>{

                this.dt = moment(data);
                this.weekNumber = this.dt.week()
                this.monthN = parseInt(this.dt.month());
                this.displayMonth = moment.months()[this.monthN]
                this.displayDate  =  this.dt.format('Y-MM-DD');
            })

        },
        methods:{
            hideToolbar(){
                Event.$emit('toggleToolbar', true )
            },
            addWeek(){
                this.dt = this.dt.add(1, 'week' )
                this.displayMonth = moment.months()[this.dt.month()]
                Event.$emit('addWeek', this.dt )
            },
            subWeek(){
                this.dt = this.dt.subtract(1, 'week' )
                this.displayMonth = moment.months()[this.dt.month()]
                Event.$emit('subWeek', this.dt )
            },
            getTodayWork(){
                let diffWeek = this.dt.week() !== moment().week();
                if(diffWeek){
                    this.dt = moment();
                    this.displayMonth = moment.months()[this.dt.month()]
                    Event.$emit('resetWeek', this.dt )
                }
            }
        },
        filters:{
            capitalize: function (value) {
                if (!value) return ''
                value = value.toString()
                return value.charAt(0).toUpperCase() + value.slice(1)
            },
        },

    }
</script>
