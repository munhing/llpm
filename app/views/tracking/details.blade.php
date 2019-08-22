<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.1
Version: 3.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>LLPM | Container Status</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<link href="{{ URL::asset('assets/admin/pages/css/invoice.css') }}" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css" id="style_components"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="favicon.ico"/>

<style>

@media print{a[href]:after{content:none}}

html, body {
	margin:0px 10px 0px 10px;
	padding:0;
	height:100%;
}

#wrapper {
	min-height:100%;
	position:relative;
}

#header {

}

#content {
	padding-bottom:50px; /* Height of the footer element */
}

#footer {
	display:block;
	width:100%;
	height:50px;
	position:absolute;
	bottom:0;
	left:0;
}
.page-content-wrapper .page-content {
  margin-left: 0px;
}

.fineprint {
	font-size: xx-small;
	text-align: center;
}

.muted {
	font-size: 18px;
}

.muted2 {
	font-size: 12px;
}

.clear {
	clear:both;
}



.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  text-align: center;
}


.break {
	page-break-after: always;
}

</style>

</head>

<body>


	<div id="wrapper">

		<div id="header">
			<div class="row">
				<div class="col-xs-12">
					<h4 class="text-center">
						<b>Labuan Liberty Port Management</b>
						<span class="muted2">
							(Reg. No. 468085T)
						</span>						
					</h4>
					<h4 class="text-center">
						{{ $container->container_no . ' ( ' . $container->size . '\' )'}}
					</h4>
				</div>
			</div>
		</div>


		<!-- Table -->
		<div id="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Work Order #</th>
								<th>Movement</th>
								<th>Issue Date</th>
								<th>Confirmed On</th>
								<th>Confirmed By</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@foreach($container->workorders as $workorder)
							<?php $confirmed_at = DateTime::createFromFormat('Y-m-d H:i:s', $workorder->pivot->confirmed_at); ?>
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $workorder->id }} {{ $workorder->pivot->remark == 'BYPASS' ? '<span class="label label-sm label-danger">bypass</span>' : '' }}</td>
								<td>{{ $workorder->movement }}</td>
								<td>{{ $workorder->date->format('d/m/Y') }}</td>
								<td>
									@if($workorder->pivot->confirmed == 1)
										{{ $confirmed_at->format('d/m/Y H:i') }}
									@endif
								</td>
								<td>
									@if($workorder->pivot->confirmed == 1)
										{{ $workorder->users_name }}
									@endif
								</td>
							</tr>
							<?php $i++ ?>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>

		<div class="clear"></div>


	</div>

</body>
<!-- END BODY -->
</html>