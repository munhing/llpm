@extends('layouts/report_layout', ['vuePage' => 'consignee_top_rpt'])

@section('content')

    <div id="app">

        <h1 style="text-align:center">Top Consignor in {{$year}}</h1>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Frequency</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($consignors as $c)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $c->name }}</td>
                        <td align="right">{{ $c->count }}</td>
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