@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Registered Users <small>list</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Users
			</li>					
		</ul>
	</div>	



<div class="portlet box blue-hoki">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-globe"></i>List of Users
		</div>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-striped table-bordered table-hover" id="sample_1">
		<thead>
		<tr>
			<th>Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Roles</th>			
			<th>Created At</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->name }}</td>
					<td>{{ $user->username }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->roles()->first()->description }}</td>					
					<td>{{ $user->created_at }}</td>
					<td>
						<button class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal_user" data-user-id="{{ $user->id }}" data-name="{{ $user->name }}" data-username="{{ $user->username }}" data-email="{{ $user->email }}" data-role="{{ $user->roles()->first()->id }}">
							<i class="fa fa-edit"></i> Edit
						</button>
			            <button class='btn btn-default btn-xs' data-toggle="modal" data-target="#myModal_user_password" data-user-id="{{ $user->id }}">
			                <i class="fa fa-key"></i> Change Password 
			            </button> 						
					</td>
				</tr>
			@endforeach
		</tbody>
		</table>
	</div>
</div>

    <div class="row">

    {{ Form::open(['route'=>['users.update'], 'id' => 'form_user_update']) }}	

    <div class="modal fade" id="myModal_user" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    				<h4 class="modal-title" id="myModalLabel">Update User Information</h4>
                    {{ Form::hidden('user_id', '', ['id'=>'user_id']) }}
    			</div>
    			<div class="modal-body">
                    <div class="container-fluid">
        				<div class="form-horizontal">
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Name</label>
            						<div class="col-md-6">
            							{{ Form::text('name','', ['id'=>'name', 'class'=>'form-control']) }}
            						</div>                                  
            					</div>	
                            </div>
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Email</label>
            						<div class="col-md-6">
            							{{ Form::text('email','', ['id'=>'email', 'class'=>'form-control']) }}
            						</div>                                  
            					</div>	
                            </div>  
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Role</label>
            						<div class="col-md-6">
            							{{ Form::select('role', [null => 'Please assign a role...'] + $roles->lists('description', 'id'), '', ['id'=>'role', 'class'=>'form-control']) }}
            						</div>                                  
            					</div>	
                            </div>                                                      
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-2">Username</label>
            						<div class="col-md-10">
            							{{ Form::text('username','', ['id'=>'username','class'=>'form-control', 'rows'=>'3']) }}
            						</div>
            					</div>
                            </div>										
        				</div>	
                    </div>
    				
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    				<input type="submit" class="btn btn-primary" id="but_user_update" data-confirm="Are you sure?">
    			</div>
    		</div>
    	</div>
    </div>

    {{ Form::close() }}
      
    </div>

    <div class="row">

    {{ Form::open(['route'=>['users.update.password'], 'id' => 'form_user_update_password']) }}	

    <div class="modal fade" id="myModal_user_password" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    	<div class="modal-dialog modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    				<h4 class="modal-title" id="myModalLabel">Change User Password</h4>
                    {{ Form::hidden('password_user_id', '', ['id'=>'password_user_id']) }}
    			</div>
    			<div class="modal-body">
                    <div class="container-fluid">
        				<div class="form-horizontal">
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-4">Password</label>
            						<div class="col-md-6">
            							{{ Form::password('password', ['id'=>'password', 'class'=>'form-control', 'autocomplete' => 'off']) }}
            						</div>                                  
            					</div>	
                            </div>
                            <div class="row">
            					<div class="form-group">
            						<label class="control-label col-md-4">Password Confirmation</label>
            						<div class="col-md-6">
            							{{ Form::password('password_confirmation', ['id'=>'password_confirmation', 'class'=>'form-control', 'autocomplete' => 'off']) }}
            						</div>                                  
            					</div>	
                            </div>  									
        				</div>	
                    </div>
    				
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
    				<input type="submit" class="btn btn-primary" id="but_user_update" data-confirm="Are you sure?">
    			</div>
    		</div>
    	</div>
    </div>

    {{ Form::close() }}
      
    </div>
@stop

@section('page_level_plugins')

<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }}"></script> 
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>

@stop

@section('page_level_scripts')

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }}"></script>

@stop

@section('scripts')
	TableAdvanced.init();

	$('#myModal_user').on('show.bs.modal', function (e) {

	    $button = $(e.relatedTarget);
	    $userId = $button.data('user-id');
	    $name = $button.data('name');
	    $username = $button.data('username');
	    $email = $button.data('email');
	    $role = $button.data('role');

	    $('#user_id').val($userId);
	    $('#name').val($name);
	    $('#username').val($username);
	    $('#email').val($email);
	    $('#role').val($role);

	});	

	$('#myModal_user_password').on('show.bs.modal', function (e) {

	    $button = $(e.relatedTarget);
	    $userId = $button.data('user-id');

	    $('#password_user_id').val($userId);

	});	

@stop