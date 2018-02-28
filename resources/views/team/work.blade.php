@extends('layouts.template')

@section('content')

    <div class="container-fluid  ">
        <div class="row container-wrapper ">

            <div class="col-md-auto hidden-lg-up border">
                <calendar></calendar>
            </div>

            <div class="col ">
                <week></week>
                <hello></hello>

                <div class="row">
                    @foreach($week->getWeek() as $index => $day)
                        <div class="col border">
                            @if(isset($delais[$day->format('Y-m-d')]))
                                @php $delais_ = $delais[$day->format('Y-m-d')] ; @endphp

                                @foreach($delais_ as $indexD => $work)
                                    <div class="row">
                                        <div class="col">
                                            @php $bl = $work->id_cmd @endphp
                                            {{$bl}}
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
