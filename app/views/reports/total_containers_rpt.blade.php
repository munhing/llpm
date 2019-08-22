@extends('layouts/report_layout', ['vuePage' => 'totalContainersRpt'])

@section('content')

    <div id="app">

        <bar2   title="Total Containers in the yard as at {{ date('d/m/Y g:i A') }}"
                :labels=["Total"]
                :value1=[{{ $count_loc_1 }}]
                :value2=[{{ $count_loc_3 }}]
                value1-label="CY 1" 
                value2-label="CY 3" 
        ></bar2>

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop