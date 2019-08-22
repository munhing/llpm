@if ($errors->any())
	<div class="alert alert-danger">
		@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</div>
@endif


 
@if (Session::get('infos') != null)
	<div class="alert alert-info">
		@foreach (Session::get('infos') as $info)
			<li>{{ $info }}</li>
		@endforeach
	</div>
@endif