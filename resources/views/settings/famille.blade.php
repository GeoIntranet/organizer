@extends('layouts.template')


@section('menu')

    <navbar
            v-if="{{json_encode(auth()->user())}}"
            :year="{{carbon('y')}}"
            :month="{{carbon('m')}}"
            :day="{{carbon('d')}}"
    >
    </navbar>

    <auth-user v-if="{{json_encode(auth()->user() == null)}}"> </auth-user>

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
                <user-content-setting></user-content-setting>
                <famille-liste
                        :familles="{{$familles}}"
                >

                </famille-liste>
            </div>

            <div class=" col-information col-md-auto " >
                <commandes
                        v-if="{{json_encode(auth()->user())}}"
                        :commandes="{{$commandes}}"
                >
                </commandes>
            </div>

            <flash-message></flash-message>

        </div>
    </div>
@endsection
