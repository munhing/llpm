@extends('layouts/report_layout', ['vuePage' => 'cargo_top_import_rpt'])

@section('content')

    <div id="app">
    @if(count($cargoes))
        <h1 style="text-align:center">Import Cargo List by {{ $consignee }} in {{$year}}</h1>

        <h3 style="text-align:center">Total MT: {{ number_format($total_mt,2) }}</h3>

 

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>BL #</th>
                    <th>MT</th>
                    <th>M3</th>
                    <th>Description</th>
                    <th>Containerized</th>
                    <th>Received On</th>
                    <th>Vessel</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach($cargoes as $c)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $c->bl_no }}</td>
                        <td align="right">{{ number_format($c->mt,2) }}</td>
                        <td align="right">{{ number_format($c->m3,2) }}</td>
                        <td>{{ $c->description }}</td>
                        <td>{{ listContainersInString2($c->m_containers) }}</td>
                        <td>{{ $c->received_date->format('d/m/Y') }}</td>
                        <td>{{ $c->vessel_schedule_import }}</td>
                    </tr>
                <?php $i++ ?>
                @endforeach                
            </tbody>
        </table>

    @else
        <h1 style="text-align:center">Import Cargo List Not Available</h1>
    @endif

    </div>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('js/app.js') }}"></script>

@stop