@extends('layouts/report_layout', ['vuePage' => 'cargoContainerizedMtRpt'])

@section('content')

    <div id="app">

        <horizontalbar2   title="Total MT for Containerized Cargo in {{ $year }}"
                :labels={{ $monthly->toJson() }}
                :value1={{ $import->toJson() }}
                :value2={{ $export->toJson() }}
                value1-label="Import MT" 
                value2-label="Export MT"
                height="500"
                width="1000"
        ></horizontalbar2>

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop