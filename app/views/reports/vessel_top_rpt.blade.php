@extends('layouts/report_layout', ['vuePage' => 'vesselTop'])

@section('content')

    <div id="app">
        <horizontalbar   
                title="Top Vessels in {{ $year }}"
                :labels='{{ $vessel_name->toJson() }}'
                :value={{ $count->toJson() }}
                value-label="Vessel Count" 
                height="500"
                width="1000"
        ></horizontalbar>

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop