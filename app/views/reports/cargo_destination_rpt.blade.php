@extends('layouts/report_layout', ['vuePage' => 'cargo_destination_rpt'])

@section('content')

    <div id="app">

        <h1 style="text-align:center">Top Country for Export Cargo in {{$year}}</h1>

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
                @foreach($destinations as $destination)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $destination->name ? $destination->name : "NA" }}</td>
                        <td align="right">{{ number_format($destination->total_mt, 2) }}</td>
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