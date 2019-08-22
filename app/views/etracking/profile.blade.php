@extends('layouts/etracking')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/select2/select2.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<!-- END PAGE LEVEL STYLES -->
@stop

@section('header_title')
    PROFILE
@stop

@section('content')

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-green-sharp">
            <i class="fa fa-user font-green-sharp"></i>
            <span class="caption-subject bold uppercase"> My Profile</span>
            <span class="caption-helper">info</span>
        </div>
        <div class="actions">
            <button class='btn btn-default btn-sm' data-toggle="modal" data-target="#myModal_user_password" data-user-id="{{ Auth::user()->id }}">
                <i class="fa fa-key"></i> Change Password 
            </button>   
            <button class='btn btn-default btn-sm' data-toggle="modal" data-target="#myModal_user" data-user-id="{{ Auth::user()->id }}" data-name="{{ Auth::user()->name }}" data-username="{{ Auth::user()->username }}" data-email="{{ Auth::user()->email }}" data-company="{{ Auth::user()->company }}">
                <i class="fa fa-pencil"></i> Edit 
            </button>                  
        </div>
    </div>
    <div class="portlet-body">
        <div class="row static-info">
            <div class="col-md-5 name">
                 Name:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->name }}
            </div>
        </div>
        <div class="row static-info">
            <div class="col-md-5 name">
                 Username:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->username }}
            </div>
        </div>        
        <div class="row static-info">
            <div class="col-md-5 name">
                 Email:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->email }}
            </div>
        </div>
        <div class="row static-info">
            <div class="col-md-5 name">
                 Company:
            </div>
            <div class="col-md-7 value">
                 {{ Auth::user()->company }}
            </div>
        </div>        
    </div>    
</div>

<div class="row">

{{ Form::open(['route'=>['etracking.profile.update'], 'id' => 'form_user_update']) }}   

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
                                <label class="control-label col-md-2">Company</label>
                                <div class="col-md-6">
                                    {{ Form::text('company','', ['id'=>'company', 'class'=>'form-control']) }}
                                </div>                                  
                            </div>  
                        </div>                                                                                
                        <div class="row">
                            <div class="form-group">
                                <label class="control-label col-md-2">Username</label>
                                <div class="col-md-10">
                                    {{ Form::text('username','', ['id'=>'username','class'=>'form-control']) }}
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

{{ Form::open(['route'=>['etracking.profile.password'], 'id' => 'form_user_update_password']) }} 

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


@stop

@section('scripts')

    $('#myModal_user').on('show.bs.modal', function (e) {

        $button = $(e.relatedTarget);
        $userId = $button.data('user-id');
        $name = $button.data('name');
        $username = $button.data('username');
        $email = $button.data('email');
        $company = $button.data('company');

        $('#user_id').val($userId);
        $('#name').val($name);
        $('#username').val($username);
        $('#email').val($email);
        $('#company').val($company);

    });

    $('#myModal_user_password').on('show.bs.modal', function (e) {

        $button = $(e.relatedTarget);
        $userId = $button.data('user-id');

        $('#password_user_id').val($userId);

    });
@stop