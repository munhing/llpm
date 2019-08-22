@extends('layouts/report_layout', ['vuePage' => 'totalVesselRpt'])

@section('content')

    <div id="app">

        <bar    title = "Total Vessels in {{ $year }}"
                :labels={{ $monthly->toJson() }} 
                :value={{ $values->toJson() }}
                value-label="Vessels" 
        ></bar>
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop