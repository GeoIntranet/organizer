@extends('layouts.template')

@section('menu')
    <navbar
            :year="{{carbon('y')}}"
            :month="{{carbon('m')}}"
            :day="{{carbon('d')}}">
    </navbar>
@endsection


@section('content')

    <div class="container-fluid  ">
        <div class="row container-wrapper ">

            <div class="col-md-auto hidden-lg-up border" >
                <calendar > </calendar>
            </div>

            <div class="col ">
                <week
                    :year="{{carbon('y')}}"
                    :month="{{carbon('m')}}"
                    :day="{{carbon('d')}}">
                >
                </week>
            </div>
            <div class="border col-md-auto" >
                <h4>INFORMATION</h4>
            </div>

        </div>
    </div>
@endsection
