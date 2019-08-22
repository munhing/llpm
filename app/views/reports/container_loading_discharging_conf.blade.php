@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Container Loading & Discharging By Vessel <small>report</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ URL::route('reports') }}">Reports</a>
                <i class="fa fa-angle-right"></i>
			</li>	
            <li>
                Report Settings
            </li>            				
		</ul>
	</div>	

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-green-sharp">
                        <span class="caption-subject bold uppercase">Settings</span>
                    </div>    
                </div>
                <div class="portlet-body">

                    {{ Form::open() }}

                    <div class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                {{ Form::label('vessel_id','Vessel', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-10">
                                {{ Form::text('vessel_id','', ['class'=>'form-control']) }}
                                <span class="help-block">Choose a vessel</span>
                                </div>
                            </div> 
                            <div class="form-group">
                                {{ Form::label('schedule_id','Vessel Schedule', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-10">
                                {{ Form::select('schedule_id', [], null, ['class' => 'form-control']) }}
                                <span class="help-block">Choose a schedule</span>
                                </div>
                            </div>   
                            <div class="form-group">
                                {{ Form::label('movement','Movement', ['class'=>'control-label col-md-2']) }}
                                <div class="col-md-10">
                                {{ Form::select('movement', [null => 'Import & Export', 'HI' => 'Only Import', 'HE' => 'Only Export'], null, ['class' => 'form-control']) }}
                                <span class="help-block">Choose a movement</span>
                                </div>
                            </div>                                                           
                        </div>
                        <div class="form-actions">
                            <div class="row"><div class="col-md-offset-2 col-md-9">
                                <button class="btn btn-primary" id="but_generate">Generate</button>
                            </div></div>
                        </div>
                    </div>  

                    {{ Form::close() }}

                </div>
            </div>
        </div>   
    </div>

@stop

@section('scripts')

select2Plugin('#vessel_id', "{{route('manifest.vessels.list')}}", "", "Please select a vessel");

$('#vessel_id').on('change', function(){
   loadSchedule($(this).val(), "{{ route('manifest.schedule.search') }}"); 
});

$('#but_generate').on('click', function(e){
    e.preventDefault();
    console.log($('#schedule_id').val() );  

    if( $('#schedule_id').val() != null ) {
        window.open("{{ route('reports.container.loading.discharging.rpt') }}?schedule_id=" + $('#schedule_id').val() + "&movement=" + $('#movement').val(), "_newtab");
    }
});

function loadSchedule(vesselId, url)
{
    console.log('loadSchedule function: ' + vesselId);

    $.ajax({
        url: url,
        dataType: 'json',
        type: 'GET',
        data: {vessel_id : vesselId },
        success: function(data) {

            console.log(data);
            var date;

            $('#schedule_id').empty(); // clear the current elements in select box

            for (row in data) {

                var date;
                var dateParts1 = data[row].eta.split("-");
                var dateParts2 = dateParts1[2].split(" ");

                date = dateParts2[0] + "/" + dateParts1[1] + "/" +  dateParts1[0];

                console.log(date);


                $('#schedule_id').append($('<option></option>').attr('value', data[row].id).text(
                    'V.' + data[row].voyage_no_arrival + ' ETA: ' + date
                ));
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
        }
    });     
}

@stop