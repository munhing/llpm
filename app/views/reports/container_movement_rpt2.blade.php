@extends('layouts/report_layout')


@section('header')

    <div class="row">
        <div class="col-xs-8">
            <h2 class="text-left no-margin">Container Movement
                <span class="muted">
                    report
                </span>
            </h2>
        </div>
        <div class="col-xs-4">
            <h2 class="text-right no-margin">
                Date: {{ $info['date']->format('d/m/Y') }}
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-payment">
                <ul class="list-unstyled">
                    <li>
                        <strong>Locations:</strong> {{ $info['locations'] }}
                    </li>                   
                </ul>
            </div>              
        </div>
    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table table-striped table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Container #</th>
                        <th>Size</th>
                        <th>Work Order</th>
                        <th>Movement</th>
                        <th>Location</th>
                        <th>Activity</th>
                        <th>Carrier</th>
                        <th>Handler</th>
                    </tr>
                </thead>
            <tbody>
            <?php $no = 1; ?>
            @foreach($rpt as $row)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $row['confirmed_at'])->format('d/m/Y') }}</td>
                <td>{{ DateTime::createFromFormat('Y-m-d H:i:s', $row['confirmed_at'])->format('H:i') }}</td>
                <td>{{ $row['container_no'] }}</td>
                <td>
                    @if(isset($row['size']))
                           {{ $row['size'] }}
                    @endif
                </td>
                <td>{{ $row['workorder'] }}</td>
                <td>
                    @if ($row['movement'] == 'HI')
                        {{ $row['movement'] }} - {{ $row['vessel_name'] }} {{ $row['voyage_no_arrival']}}
                    @elseif ($row['movement'] == 'HE')
                        {{ $row['movement'] }} - {{ $row['vessel_name'] }} {{ $row['voyage_no_departure']}}
                    @else
                        {{ $row['movement'] }}
                    @endif
                </td>    
                <td>{{ $row['location'] }}</td>
                <td>
                    @if(isset($row['activity']))
                           {{ $row['activity'] }}
                    @endif                    
                </td>
                <td>{{ $row['vehicle'] }}</td>
                <td>{{ $row['lifter'] }}</td>
            </tr>
            <?php $no++; ?>
            @endforeach                                     
            </tbody>
            </table>
        </div>
    </div>

@stop