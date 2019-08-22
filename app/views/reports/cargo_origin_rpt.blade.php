@extends('layouts/report_layout', ['vuePage' => 'cargo_origin_rpt'])

@section('content')

    <div id="app">

        <h1 style="text-align:center">Top Country for Import Cargo in {{$year}}</h1>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Total Import (MT)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($origins as $origin)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $origin->name ? $origin->name : "NA"}}</td>
                        <td align="right">{{ number_format($origin->total_mt, 2) }}</td>
                    </tr>
                <?php $i++ ?>
                @endforeach
            </tbody>
            
        </table>
    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop