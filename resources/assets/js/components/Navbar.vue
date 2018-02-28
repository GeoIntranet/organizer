<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="">

            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <a class="navbar-brand mr-4" href="/">
                        <img src="/images/light.png" width="30" height="30" class="d-inline-block align-top" alt="">
                        {{app}}
                    </a>
                    <a @click.prevent="resetWeek" class="ml-4 mr-4 navbar-brand" href="#">
                        Aujourd'hui
                    </a>
                    <a class="ml-4 navbar-brand" href="#">
                       Février 2018
                    </a>
                    <a class="navbar-brand" href="#" @click.prevent="subWeek">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="navbar-brand" href="#" @click.prevent="addWeek">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    <li v-if="!signed"><a class="nav-link" href="">Login</a></li>
                    <li v-if="!signed"><a class="nav-link" href="">Register</a></li>


                    <li class="nav-item dropdown">

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret">{{user.prenom}}</span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"><i class="fa fa-angle-right mr-3"> </i>xxx</a>
                            <a class="dropdown-item" href="#"><i class="fa fa-angle-right mr-3"> </i>xxx</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href=""
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off mr-2" style="color:indianred"> </i>Deconnexion
                            </a>

                            <form id="logout-form" action="" method="POST" style="display: none;">
                            </form>
                        </div>
                    </li>

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
                date:moment()
            }
        },
        props:['week','date'],
        mounted() {
            Event.$on('syncWeek',(data)=>{
                this.weekNumber = data;
            })
        },
        methods:{
            addWeek(){
                Event.$emit('addWeek', this.weekNumber )
            },
            subWeek(){
                Event.$emit('subWeek', this.weekNumber )
            },
            resetWeek(){
                Event.$emit('resetWeek')
            }
        }
    }
</script>
