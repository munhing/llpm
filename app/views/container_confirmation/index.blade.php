@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/app/jquery-timepicker-1.3.2/jquery.timepicker.min.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

<?php
	$role = Auth::user()->roles->first();

	$allowContainerConfirmation = '';
	$allowContainerConfirmationBypass = '';
	$allowContainerConfirmationCancel = '';

		// dd(Auth::user()->roles->first()->permissions);
	if(! $role->permissions->isEmpty()) {
	    foreach($role->permissions as $permission) {
	        if($permission->route_name == 'action.container.confirmation') {
	            $allowContainerConfirmation = 'hidden';
	        }
	        if($permission->route_name == 'action.container.confirmation.bypass') {
	            $allowContainerConfirmationBypass = 'hidden';
	        }

	        // if($permission->route_name == 'action.container.confirmation.cancel') {
	        //     $allowContainerConfirmationCancel = 'hidden';
	        // }	        	        
	    }
	}

?>

	<h3 class="page-title">
		Containers Confirmation <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Confirmation
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="icon-anchor"></i>Containers Confirmation
		</div>
		<div class="tools">

		</div>
	</div>
	<div class="portlet-body">
		<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th></th>
							<th>Container #</th>
							<th>Size</th>
							<th>Work Order #</th>
							<th>Movement</th>
							<th>CP1</th>
							<th>CP2</th>
							<th>CP3</th>
							<th>CP4</th>
							<th>Carrier</th>
							<th>Lifter</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1;?>
						@foreach($containers as $container)
                		<?php $movement =  $container->movement; ?>
                		<?php $id = $container->id . ',' . $container->content . ',' . $container->current_movement . ',' . $movement; ?>
                		<?php $pivotInfo = $container->workorders->filter(function($workorder) use ($container) {return $workorder->id == $container->current_movement;});?>
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ $container->container_no }}</td>
							<td>{{ $container->size . $container->content }}</td>
							<td>{{ $container->current_movement }}</td>
							<td>{{ $movement }}</td>
                    		<td class="{{ ($check_points[$movement]->cp1 == $container->to_confirm_by && $container->check_point == 1) ? 'cp':'' }}">{{ $check_points[$movement]->cp1 }}</td>
                    		<td class="{{ ($check_points[$movement]->cp2 == $container->to_confirm_by && $container->check_point == 2) ? 'cp':'' }}">{{ $check_points[$movement]->cp2 }}</td>
                    		<td class="{{ ($check_points[$movement]->cp3 == $container->to_confirm_by && $container->check_point == 3) ? 'cp':'' }}">{{ $check_points[$movement]->cp3 }}</td>
                    		<td class="{{ ($check_points[$movement]->cp4 == $container->to_confirm_by && $container->check_point == 4) ? 'cp':'' }}">{{ $check_points[$movement]->cp4 }}</td>
		                    <td>{{ $pivotInfo->first()->pivot->vehicle }}</td>
		                    <td>{{ $pivotInfo->first()->pivot->lifter }}</td>
							<td>
								<div class="{{ $allowContainerConfirmation }}">
		                            <button class='btn btn-sm btn-primary' type='button' data-toggle="modal" data-target="#formModal" data-confirmation-id="{{$id}}" data-cp="{{ $container->to_confirm_by }}" data-carrier="{{ $pivotInfo->first()->pivot->vehicle }}" data-lifter="{{ $pivotInfo->first()->pivot->lifter }}">
		                                Confirm
		                            </button>								
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
		</div>
	</div>
</div>


<div class="modal fade edit-modal-sm" id="formModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                        {{ Form::open() }}                    
                        {{ Form::hidden('a_confirmation','', ['id'=>'a_confirmation']) }}
                          <div class="alert alert-warning {{ $allowContainerConfirmationBypass }}" role="alert">
                                 {{ Form::checkbox('bypass', 'true') }}
                                 {{ Form::label('bypass','Bypass all check points') }}
                          </div> 

                          <div class="form-group">
                                 {{ Form::label('operator','Operator In Charge') }}
                                 {{ Form::select('a_operator', [], 0, ['class' => 'form-control select2me', 'placeholder' => 'Select Operator', 'id'=>'a_operator', 'spinner']) }}
                          </div>                                      
                          <div class="form-group">
                                 {{ Form::label('a_date','Date') }}
                                 {{ Form::text('a_date','', ['class'=>'form-control date-picker']) }}
                          </div>    
                          <div class="form-group">
                                 {{ Form::label('confirmed_at','Confirmed At') }}
                                 {{ Form::text('a_confirmed_at','', ['id'=>'a_confirmed_at', 'class'=>'form-control']) }}
                          </div>                       
                          <div class="form-group">
                                 {{ Form::label('carrier','Carrier') }}
                                 {{ Form::text('a_carrier','', ['id'=>'a_carrier', 'class'=>'form-control']) }}
                          </div>
                          <div class="form-group">
                                 {{ Form::label('lifter','Lifter') }}
                                 {{ Form::text('a_lifter','', ['id'=>'a_lifter', 'class'=>'form-control']) }}
                          </div>
                          {{ Form::hidden('a_cp','', ['id'=>'a_cp']) }}                    
                          <button class="btn btn-lg btn-success btn-block edit-btn" data-confirm>
                                Confirm
                          </button>
                        {{ Form::close() }}
                </div>
          </div>
    </div>
</div>


@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/app/bootstrap-datepicker-1.4.0-dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

@stop

@section('page_level_scripts')

@stop

@section('scripts')

	jQuery(document).ready(function(){

		$('#formModal').on('show.bs.modal', function (event) {
		
			var button = $(event.relatedTarget); // Button that triggered the modal
			var confirmation_id = button.data('confirmation-id'); // Extract info from data-* attributes
            var cp = button.data('cp'); // Extract info from data-* attributes
            var carrier = button.data('carrier'); // Extract info from data-* attributes
			var lifter = button.data('lifter'); // Extract info from data-* attributes
			// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			var modal = $(this);
            modal.find('#a_confirmation').val(confirmation_id);
            modal.find('#a_carrier').val(carrier);
			modal.find('#a_lifter').val(lifter);
			modal.find('#a_cp').val(cp);

			$.ajax({
				url: '{{ route('users.find') }}',
				dataType: 'json',
			    type: 'GET',
			    data: {'cp': cp }, // need to provide current check point
			    success: function(data) {
			    	console.log(data);

                    $('#a_operator').select2('data', null); // clear the current elements in select box
					$('#a_operator').empty(); // clear the current elements in select box

					for (row in data) {
						$('#a_operator').append($('<option></option>').attr('value', data[row].id).text(data[row].name));
					}

					// console.log(options);

			    },
			    error: function(jqXHR, textStatus, errorThrown) {
			        alert(errorThrown);
			    }
			});		  
		});

		$('#a_confirmed_at').timepicker({ 
			template: false,
	        minuteStep: 1,
	        showSeconds: false,
	        showMeridian: false
		});

		$('.date-picker').datepicker({
		    format: "yyyy-mm-dd",
		    todayBtn: "linked",
		    autoclose: true,
		    todayHighlight: true
		});

		$(".date-picker").datepicker().on('show.bs.modal', function(event) {
		    // prevent datepicker from firing bootstrap modal "show.bs.modal"
		    event.stopPropagation(); 
		});

		$('.date-picker').datepicker('update', new Date());

		$('input[type="checkbox"]').click(function(e) {

			if(this.checked) {
	  			if(confirm( "Are you sure you want to bypass all check points?" )) {
	  				$('input[type="checkbox"]').prop('checked', true);
	  			} else {
	  				$('input[type="checkbox"]').prop('checked', false);
	  			}			
			}
		});

    });
@stop