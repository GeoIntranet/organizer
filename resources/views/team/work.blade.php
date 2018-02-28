@extends('layouts.template')

@section('menu')
    <navbar></navbar>
@endsection


@section('content')

    <div class="container-fluid  ">
        <div class="row container-wrapper ">

            <div class="col-md-auto hidden-lg-up border">
                <calendar :week="9"></calendar>
            </div>

            <div class="col ">
                <week :week="8"></week>
            </div>

        </div>
    </div>
@endsection
