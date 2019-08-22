@extends('layouts/mobile_layout')

@section('content')

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

    <!-- Confirmation Form -->

	<div class="form-confirmation">

        {{ Form::open(['route'=>'mobile.confirm', 'method'=>'post', 'id'=>'mobile-form-confirm']) }}

            <h2 class="form-confirmation-heading text-center">Container No</h2>

            <div class="table">
                <table id="container_table" class="display" cellspacing="0">
                    <thead>
                        <th></th>
                        <th>Container No</th>
                        <th>Carrier</th>
                        <th>Lifter</th>
                        <th></th>
                    </thead>
                    <tbody>
                    @foreach($containers as $container)
                    <?php $id=$container->id . ',' . $container->content . ',' . $container->current_movement . ',' . $container->workorders->last()->movement; ?>
                        <tr>
                            <td id="id-{{$id}}">{{ Form::checkbox('confirmationId[]', $id) }}</td>
                            <td id="ctn-{{$id}}">{{ $container->container_no }}</td>
                            <td id="car-{{$id}}">{{ $container->workorders->last()->pivot->vehicle }}</td>
                            <td id="lif-{{$id}}">{{ $container->workorders->last()->pivot->lifter }}</td>
                            <td><a href=''>Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <button class="btn btn-lg btn-primary btn-block mobile-btn-confirm">
                Confirm
            </button>

            {{ Form::hidden('a_confirmation', '', ['id'=>'a_confirmation']) }}
            {{ Form::hidden('a_carrier', '', ['id'=>'a_carrier']) }}
            {{ Form::hidden('a_lifter', '', ['id'=>'a_lifter']) }}

        {{ Form::close() }}

	</div>



@stop

@section('scripts')

jQuery(document).ready(function(){

   var row = [];

   var t = $('#container_table').dataTable({
     "paging": false,
     "ordering": false,
     "info": false
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

   $("a:contains('Edit')").on('click', function(e){

     // stop from submitting
     e.preventDefault();
                   
   });

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
     t.fnUpdate( carrier, row[0], 2 );
     t.fnUpdate( lifter, row[0], 3 );

     // Clear the fields
     $('#carrier').val('');
     $('#lifter').val('');

     // hide modal dialog
     $('.edit-modal-sm').modal('hide');
                  
   });

   $('.edit-modal-sm').on('shown.bs.modal', function () {
      $('#carrier').focus();
   });

   $('.edit-modal-sm').on('hidden.bs.modal', function () {

      if(t.fnGetData( row[0], 2 ) == '') {

         cb = t.fnGetData(row[0],0);
         
         checkbox = $("input[value='"+ $(cb).val() + "']");

         checkbox.prop('checked', false);
      } 
   })

   var pusher = new Pusher('{{ $pusher_var['key'] }}');
   var channel = pusher.subscribe('LLPM');

   $('#container_table tbody').on( 'click', 'td', function () {
      //console.log( t.fnGetData( this, 0 ) );
      //alert( t.fnGetPosition( this ) );

      var el = $(this).children();
      // console.log(checkbox.is(':checked') == true);

      row = t.fnGetPosition( this );

      // console.log(row[0]);

      // console.log(t.fnGetData( row[0], 2 ));

      if(el.is('a') == true) {
         showEditForm();
         // $('.edit-modal-sm').modal('show');

         // fill value to input
         // fillValue(row);
         console.log('Clicked on edit');
         console.log(row);
      }

      if(el.is(':checked') == true && t.fnGetData( row[0], 2 ) == '') {       
         console.log('Clicked on checkbox');
         // console.log('Blank');

         showEditForm();

      }
   });

   function fillValue() {
      console.log(row);
      console.log(t.fnGetData( row[0],2 ));
      console.log(t.fnGetData( row[0],3 ));

      var c = t.fnGetData( row[0],2 );
      var l = t.fnGetData( row[0],3 );

      $('#carrier').val(c);
      $('#lifter').val(l);
   }

   function showEditForm()
   {
      $('.edit-modal-sm').modal('show');
      fillValue();
   }

   // Escapes special characters and returns a valid jQuery selector
   function jqSelector(str)
   {
      return str.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1');
   }

   channel.bind('{{ $pusher_var['event'] }}', function(data){

      // ajax call to get latest container list

      $.ajax({
          url: "{{ route('mobile.refresh') }}",
          async: true,
          type: 'GET',
          data: {
                     "cp": "{{ $pusher_var['event'] }}"
                },
          success: function(data) {
              
            console.log(data);
            var json = JSON.parse(data);
            $.each(json, function(key, value){
               //alert(value.id);

               if($("input[value='" + value.id +"']").val() == undefined){

                  console.log(value);

                  t.fnAddData([
                     '<input type="checkbox" name="confirmationId[]" value='+ value.id +' />',
                     value.container_no,
                     value.vehicle,
                     value.lifter,
                     '<a href="#">Edit</a>'
                  ]);

                  console.log('New: ' + value.id);
                  console.log('New: ' + value.container_no);                  
                  console.log('New: ' + value.vehicle);                  
                  console.log('New: ' + value.lifter);                  
               }

               //console.log('Listed: ' + value.id);
               //console.log('Listed: ' + value.container_no);

            });
            
        
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert(errorThrown);
          }
      });      

   });    
});

@stop



