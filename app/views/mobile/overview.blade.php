@extends('layouts/mobile_layout')

@section('content')

<!-- carrier modal -->

<div class="modal fade edit-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Edit</h4>
                </div>
          <div class="modal-body">
                <form class="form-edit">
                      <div class="form-group">
                             {{ Form::label('carrier','Carrier') }}
                             {{ Form::text('carrier','', ['id'=>'carrier', 'class'=>'form-control']) }}
                      </div>
                      <div class="form-group">
                             {{ Form::label('lifter','Lifter') }}
                             {{ Form::text('lifter','', ['id'=>'lifter', 'class'=>'form-control']) }}
                      </div>                          
                      <button class="btn btn-lg btn-success btn-block edit-btn">
                            Save
                      </button>                  
                </form>
          </div>

          </div>
    </div>
</div>

<!-- password modal -->

<div class="modal fade password-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
          <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">Please enter your password</h4>
                </div>
          <div class="modal-body">
                <form class="form-password">
                      <div class="form-group">
                            {{ Form::password('password', ['id'=>'password', 'class'=>'form-control']) }}
                      </div>
                      <button class="btn btn-lg btn-primary btn-block password-btn">
                            Submit
                      </button>                  
                </form>
          </div>

          </div>
    </div>
</div>

<!-- Table -->

<div class="form-confirmation">
    {{ Form::open(['route'=>'mobile.confirm', 'method'=>'post', 'id'=>'mobile-form-confirm']) }}
    <div class="table">
        <table id="container_table" class="display" cellspacing="0">
            <thead>
                <th></th>
                <th>Container No</th>
                <th>Size</th>
                <th>WO</th>
                <th>Movement</th>
                <th>CP1</th>
                <th>CP2</th>
                <th>CP3</th>
                <th>CP4</th>
                <th>Tranporter</th>
                <th>Lifter</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($containers as $container)
                <?php $movement =  $container->workorders->last()->movement; ?>
                <?php $id = $container->id . ',' . $container->content . ',' . $container->current_movement . ',' . $movement; ?>
                <?php if(!in_array($role, json_decode($container->workorders->last()->who_is_involved))) {continue;} ?>
                <tr>
                    <td>
                        @if($role == $container->to_confirm_by)
                            {{ Form::checkbox('confirmationId[]', $id) }}
                        @endif
                    </td>
                    <td>{{ $container->container_no }}</td>
                    <td>{{ $container->size . $container->content }}</td>
                    <td>{{ $container->current_movement }}</td>
                    <td>{{ $movement }}</td>
                    <td class="{{ $check_points[$movement]->cp1 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp1 }}</td>
                    <td class="{{ $check_points[$movement]->cp2 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp2 }}</td>
                    <td class="{{ $check_points[$movement]->cp3 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp3 }}</td>
                    <td class="{{ $check_points[$movement]->cp4 == $container->to_confirm_by ? 'cp':'' }}">{{ $check_points[$movement]->cp4 }}</td>
                    <td>{{ $container->workorders->last()->pivot->vehicle }}</td>
                    <td>{{ $container->workorders->last()->pivot->lifter }}</td>
                    <td>
                        @if($role == $container->to_confirm_by)
                            <a href="#">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <button class="btn btn-lg btn-primary btn-block mobile-btn-confirm">
            Confirm
        </button>        
    </div>

    {{ Form::hidden('a_confirmation', '', ['id'=>'a_confirmation']) }}
    {{ Form::hidden('a_carrier', '', ['id'=>'a_carrier']) }}
    {{ Form::hidden('a_lifter', '', ['id'=>'a_lifter']) }} 
      
    {{ Form::close() }}
</div>


@stop

@section('scripts')

jQuery(document).ready(function(){

    var t = $('#container_table').dataTable({
        "paging": false,
        "ordering": true,
        "info": true
    });

    var urlFind = "{{ route('mobile.find') }}";
    var urlConfirm = "{{ route('mobile.confirm') }}";
    var urlPwdCheck = "{{ route('mobile.pwdcheck') }}";

    var info = {
        "url_find": urlFind,
        "url_confirm": urlConfirm,
        "url_pwd_check": urlPwdCheck
    };

    MobileView.init(info, t);

    $("a:contains('Edit')").on('click', function(e) {
        // stop from submitting
        e.preventDefault();           
    });

    $('#container_table tbody').on( 'click', 'td', function () {
     
        var el = $(this).children();

        row = t.fnGetPosition( this );

        if(el.is('a') == true) {
            showEditForm();

            // fill value to input
            // fillValue(row);
            console.log('Clicked on edit');
            console.log(row);
        }

        if(el.is(':checked') == true && t.fnGetData( row[0], 9 ) == '') {
            showEditForm();
        }

    });

    function showEditForm()
    {
        $('.edit-modal-sm').modal('show');
        fillValue();
    }

    function fillValue() {
        console.log(row);
        console.log(t.fnGetData( row[0],9 ));
        console.log(t.fnGetData( row[0],10 ));

        var c = t.fnGetData( row[0],9 );
        var l = t.fnGetData( row[0],10 );

        $('#carrier').val(c);
        $('#lifter').val(l);
    }

    $('.edit-modal-sm').on('shown.bs.modal', function () {
        $('#carrier').focus();
    });

    $('.edit-modal-sm').on('hidden.bs.modal', function () {

        if(t.fnGetData( row[0], 9 ) == '') {

            cb = t.fnGetData(row[0],0);

            checkbox = $("input[value='"+ $(cb).val() + "']");

            checkbox.prop('checked', false);
        } 
    })

    $('.edit-btn').on('click', function(e){

        // stop from submitting
        e.preventDefault();
        console.log(row);

        // get carrier value
        var carrier = $('#carrier').val();
        // get lifter value
        var lifter = $('#lifter').val();

        // save to the table
        console.log(carrier + ' - ' + lifter);
        t.fnUpdate( carrier, row[0], 9 );
        t.fnUpdate( lifter, row[0], 10 );

        // Clear the fields
        $('#carrier').val('');
        $('#lifter').val('');

        // hide modal dialog
        $('.edit-modal-sm').modal('hide');
              
    });

});

@stop



