@extends('layouts/report_layout', ['vuePage' => 'containerTransferToCY3Rpt'])

@section('content')

    <div id="app">

        <bar2   title="Total Containers Transfer from CY1 to CY3 in {{ $year }}"
                :labels={{ $monthly->toJson() }} 
                :value1={{ $container_count_20->toJson() }}
                :value2={{ $container_count_40->toJson() }}
                value1-label="20'" 
                value2-label="40'" 
        ></bar2>        

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop