@extends('layouts/report_layout', ['vuePage' => 'totalTeusRpt'])

@section('content')

    <div id="app">

        <bar    title = "Total TEUs in {{ $year }}"
                :labels={{ $monthly->toJson() }} 
                :value={{ $total_teus->toJson() }}
                value-label="TEUs" 
        ></bar>  

        <bar2   title="Total Import & Export TEUs in {{ $year }}"
                :labels={{ $monthly->toJson() }} 
                :value1={{ $teus_import->toJson() }}
                :value2={{ $teus_export->toJson() }}
                value1-label="Import" 
                value2-label="Export" 
        ></bar2>

        <bar2   title="Total Containers Handled in {{ $year }}"
                :labels={{ $monthly->toJson() }} 
                :value1={{ $teus_count_20->toJson() }}
                :value2={{ $teus_count_40->toJson() }}
                value1-label="20'" 
                value2-label="40'" 
        ></bar2>        

      
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop