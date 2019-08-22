@extends('layouts/default_login')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div style="text-align:center;">
			<h3>Welcome!</h3>
			<p>
				Please Enter <a href="{{ URL::route('home') }}">here</a> to begin.
			</p>
		</div>
	</div>
</div>

@stop
