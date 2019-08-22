@extends('layouts/default')

@section('page_level_styles')
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
@stop

@section('content')

	<h3 class="page-title">
		Dashboard <small>reports & statistics</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Dashboard
			</li>
		</ul>
	</div>	

	<!-- BEGIN DASHBOARD STATS -->
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat blue-madison">
				<div class="visual">
					<i class="fa fa-cube"></i>
				</div>
				<div class="details">
					<div class="number counter" id="containers-in-yard">
						 0
					</div>
					<div class="desc">
						 Containers in Yard
					</div>
				</div>
				<a class="more" href="{{ URL::route('containers') }}">
				View more <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat red-intense">
				<div class="visual">
					<i class="fa fa-file-text"></i>
				</div>
				<div class="details">
					<div class="number counter" id="total-workorders-today">
						 0
					</div>
					<div class="desc">
						 Total Work Orders Today
					</div>
				</div>
				<a class="more" href="{{ URL::route('workorders') }}">
				View more <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat green-haze">
				<div class="visual">
					<i class="fa fa-check-square-o"></i>
				</div>
				<div class="details">
					<div class="number counter" id="pending-container-confirmation">
						 0
					</div>
					<div class="desc">
						 Pending Container Confirmation
					</div>
				</div>
				<a class="more" href="{{ URL::route('confirmation') }}">
				View more <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="dashboard-stat purple-plum">
				<div class="visual">
					<i class="fa fa-user"></i>
				</div>
				<div class="details">
					<div class="number counter" id="pending-portusers-confirmation">
						 0
					</div>
					<div class="desc">
						 Pending Port User Confirmation
					</div>
				</div>
				<a class="more" href="{{ URL::route('portusers_access') }}">
				View more <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>		
	</div>
	<!-- END DASHBOARD STATS -->

    <!-- BEGIN VESSEL SCHEDULE -->
    <div class="row">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-share font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">Vessel Calling</span>
                    <span class="caption-helper">schedule</span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-hover" id="vessel-schedule">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vessel</th>
                            <th>ETA</th>
                            <th>ETD</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end VESSEL SCHEDULE -->

	<div class="clearfix">
@stop


@section('page_level_scripts')
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
	<script src="{{ URL::asset('assets/app/js/jquery.counterup.js') }}"></script>
@stop

@section('scripts')

// ajax query: get total containers in the port

$.ajax({
    url: '{{ route('statistics.dashboard') }}',
    dataType: 'json',
    type: 'GET',
    success: function(data) {

        console.log(data);
        console.log(data.vessel_schedule);

        var i = 1;

        for(row in data.vessel_schedule) {
            
            console.log(data.vessel_schedule[row].name);

            var meta = data.vessel_schedule[row].eta.split(/[- :]/);
            var metd = data.vessel_schedule[row].etd.split(/[- :]/);
            // var jeta = new Date(meta[0], meta[1]-1, meta[2], meta[3], meta[4], meta[5]);
            var jeta = new Date(meta[0], meta[1]-1, meta[2], meta[3], meta[4], meta[5]);
            var jetd = new Date(metd[0], metd[1]-1, metd[2], metd[3], metd[4], metd[5]);

            $("#vessel-schedule tbody").append( 
                "<tr>" +
                    "<td>" + i + "</td>" +
                    "<td>" + data.vessel_schedule[row].name + " v." + data.vessel_schedule[row].voyage_no_arrival + " <a href='" + window.location.origin + "/admin/manifest/schedule/" + data.vessel_schedule[row].id + "/import'>Import</a>  | <a href='" + window.location.origin + "/admin/manifest/schedule/" + data.vessel_schedule[row].id + "/export'>Export</a></td>" +
                    "<td>" + jeta.getDate() + "/" + (jeta.getMonth() + 1) + "/" + jeta.getFullYear() + "</td>" +
                    "<td>" + jetd.getDate() + "/" + (jetd.getMonth() + 1) + "/" + jetd.getFullYear() + "</td>" +
                "</tr>"
            );
            i++;
        }

        $('#containers-in-yard').text(data.containers);
        $('#total-workorders-today').text(data.workorders);
        $('#pending-container-confirmation').text(data.pending_containers);
        $('#pending-portusers-confirmation').text(data.pending_portusers);

        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
        
    },
    error: function(jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
    }
});


@stop