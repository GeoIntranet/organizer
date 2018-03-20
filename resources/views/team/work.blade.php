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
            <delais-specific></delais-specific>
            <commande-specific></commande-specific>
            <all-fiche></all-fiche>

            <toolbar > </toolbar>

            <div class="col">
                <week
                    :year="{{carbon('y')}}"
                    :month="{{carbon('m')}}"
                    :day="{{carbon('d')}}"
                >

                </week>
            </div>

            <div class=" col-information col-md-auto " >
                <commandes :commandes="{{$commandes}}" ></commandes>
            </div>

            <flash-message></flash-message>

        </div>
    </div>
@endsection
