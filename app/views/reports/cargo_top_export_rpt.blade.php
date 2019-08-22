@extends('layouts/report_layout', ['vuePage' => 'cargo_top_export_rpt'])

@section('content')

    <div id="app">

        <h1 style="text-align:center">Top Export Cargoes in {{$year}}</h1>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Frequency</th>
                    <th>Amount</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($cargoes as $c)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $c->custom_tariff_code }}</td>
                        <td>{{ $c->description }}</td>
                        <td align="right">{{ $c->count }}</td>
                        <td align="right">{{ number_format($c->qty,2) }}</td>
                        <td>{{ $c->uoq }}</td>
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