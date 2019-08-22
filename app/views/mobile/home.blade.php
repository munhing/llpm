@extends('layouts/mobile_layout')

@section('content')
	<h1>Pusher Awesomeness!</h1>
@stop

@section('scripts')

	(function(){
		var pusher = new Pusher('{{ $pusher_var['key'] }}');
		var channel = pusher.subscribe('LLPM');

		channel.bind('some_event', function(data){

			console.log(data);

			//var jsonObj = JSON.stringify(data);
			//var json = JSON.parse(jsonObj);
			alert(data['name']);
		});
	})();

@stop