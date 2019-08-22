@extends('layouts/report_layout', ['vuePage' => 'agentTop'])

@section('content')

    <div id="app">
        <horizontalbar   
                title='Top Agents in {{ $year }}'
                :labels='{{ $name->toJson() }}'
                :value={{ $count->toJson() }}
                value-label="Agent Count" 
                height="500"
                width="1000"
        ></horizontalbar>

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop