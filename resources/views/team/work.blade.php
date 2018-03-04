@extends('layouts.template')


@section('menu')
   
    <navbar
            :year="{{carbon('y')}}"
            :month="{{carbon('m')}}"
            :day="{{carbon('d')}}"
            >
    </navbar>
@endsection


@section('content')

    <div class="container-fluid  ">
        <div class="row container-wrapper ">

            <result-search></result-search>

            <calendar > </calendar>


            <div class="col ">
                <week
                    :year="{{carbon('y')}}"
                    :month="{{carbon('m')}}"
                    :day="{{carbon('d')}}"
                >

                </week>
            </div>
            <div class=" col-information col-md-auto p-2" >
                <h4>INFORMATION</h4>
            </div>

        </div>
    </div>
@endsection
