@extends('layouts/default')

@section('page_level_styles')
<!-- BEGIN PAGE LEVEL STYLES -->
<!-- END PAGE LEVEL STYLES -->
@stop
@section('content')

	<h3 class="page-title">
		Tracking <small>container</small>
	</h3>

	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ URL::route('home') }}">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				Tracking
			</li>					
		</ul>
	</div>

	<div class="portlet box blue-hoki">
		<div class="portlet-title">
			<div class="caption">
				Selected Containers
			</div>
			<div class="tools">

			</div>
		</div>
		<div class="portlet-body" align="center">

		<form name=theform method="post" action="status.php">


				<table>
					<tr>
						<td align=center>Input Container #</td>
						<td class=text align=center></td>
						<td align=center>Current List</td>
						<td class=text align=center></td>
						<td align=center>Memory List</td>
					</tr>
					<tr>
						<td valign=top>{{ $textfields }}</td>
						<td style="padding:10px"><input type=button value=" >> " class="btn btn-xs" onclick="input('ctnlist');"></td>
						<td align=center valign=top>
							{{ Form::select('ctnlist',[],'',['id'=>'ctnlist', 'multiple','size'=>'19']) }}
							<br><br>
							<input type="button" value="Clear" onClick="clearSelectedButton('ctnlist');" class="btn btn-sm">
							<input type="button" value="Clear All" onClick="if(!window.confirm('Clear All ?')) {return false;} clearAllButton('ctnlist');" class="btn btn-sm">
						</td>
						<td style="padding:10px" align=center>
							<input style="margin:5px" type=button class="btn btn-xs" value=" >> " onclick="transferall('ctnlist','cache');"><br />
							<input style="margin:5px" type=button class="btn btn-xs" value="  >  " onclick="transferselected('ctnlist','cache');"><br>
							<input style="margin:5px" type=button class="btn btn-xs" value="  <  " onclick="transferselected('cache','ctnlist');"><br>
							<input style="margin:5px" type=button class="btn btn-xs" value=" << " onclick="transferall('cache','ctnlist');">
						</td>
						<td align=center valign=top>
							{{ Form::select('cache',[],'',['id'=>'cache', 'multiple','size'=>'19']) }}
							<br><br>
							<input type="button" value="Clear" onClick="clearSelectedButton('cache');" class="btn btn-sm">
							<input type="button" value="Clear All" onClick="if(!window.confirm('Clear All ?')) {return false;} clearAllButton('cache');" class="btn btn-sm">
						</td>
					</tr>
				</table>

		<br /> 

		<p>
			<input type="button" name=status value="Status" onClick="submitform('status', '{{ $url }}');" class="btn btn-sm blue">
			<input type="button" name=history value="History" onClick="submitform('history', '{{ $url }}')" class="btn btn-sm blue">
			<input type="button" name=charges value="Charges" onClick="submitform('charges', '{{ $url }}')" class="btn btn-sm blue hide">
		</p>


		</form>

		</div>
	</div>

@stop

@section('page_level_plugins')
	<script type="text/javascript" src="{{ URL::asset('assets/app/js/jscript.js') }}"></script>
@stop

@section('page_level_scripts')
@stop

@section('scripts')

	console.log(readCookie('ctnlist'));
	console.log(readCookie('cache'));

	if(readCookie('ctnlist') != '') {
		<!-- alert(readCookie('ctnlist')); -->
		// fill options with containers in cookies
		fillOptions('ctnlist');
	}

	if(readCookie('cache') != '' ) {
		<!-- alert(readCookie('ctnlist')); -->
		// fill options with containers in cookies
		fillOptions('cache');
	}



@stop	