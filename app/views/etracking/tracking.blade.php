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
<title>LLPM | Container History</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<link href="{{ URL::asset('assets/admin/pages/css/invoice.css') }}" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css" id="style_components"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="favicon.ico"/>

<style>
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
					<h5 class="text-center">
						Container History as at <?php echo date('d/m/Y'); ?>
					</h5>
				</div>
			</div>
		</div>


		<!-- Table -->
		<div id="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<table class="table table-striped table-bordered table-hover table-condensed">
			<thead>
			<tr>
				<th style="text-align:center;vertical-align:middle">#</th>
				<th style="text-align:center;vertical-align:middle">Container #</th>
				<th style="text-align:center;vertical-align:middle">Size</th>
				<th style="text-align:center;vertical-align:middle">WO In</th>
				<th style="text-align:center;vertical-align:middle">Inward Carrier</th>
				<th style="text-align:center;vertical-align:middle">Date In</th>
				<th style="text-align:center;vertical-align:middle">Status In</th>
				<th style="text-align:center;vertical-align:middle">Unstuff</th>
				<th style="text-align:center;vertical-align:middle">Stuffing</th>
				<th style="text-align:center;vertical-align:middle">Status Out</th>
				<th style="text-align:center;vertical-align:middle">Date Out</th>
				<th style="text-align:center;vertical-align:middle">Outward Carrier</th>
				<th style="text-align:center;vertical-align:middle">WO Out</th>
						
			</tr>
			</thead>
			<tbody>
				@if($info)
					<?php $i = 0; $count=0;?>
					@foreach($info['containers'] as $ctnInfo)
						<tr>
							<?php 
								$rowCount = $infoCount[$ctnInfo['container_no']]; 

								if($i == 0) {
									$count++;
								}

								if($rowCount > 1) {
									$i++;
								}
							?>
							@if($i < 2)
								<td rowspan={{ $rowCount }}>{{ $count }}</td>
								<td rowspan={{ $rowCount }}>{{ $ctnInfo['container_no'] }}</td>
								<td rowspan={{ $rowCount }}>{{ $ctnInfo['size'] }}</td>
							@endif

							<td>{{ $ctnInfo['in_workorder'] }}</td>
							<td>{{ $ctnInfo['in_carrier'] }}</td>
							<td>
								@if($ctnInfo['in_date'] != '')
									{{ $ctnInfo['in_date']->format('d/m/Y') }}
								@endif
							</td>
							<td>{{ $ctnInfo['in_content'] }}</td>
							<td>
								@if($ctnInfo['us_date'] != '')
									{{ $ctnInfo['us_date']->format('d/m/Y') }}
								@endif							
							</td>

							<td>
								@if($ctnInfo['st_date'] != '')
									{{ $ctnInfo['st_date']->format('d/m/Y') }}
								@endif							
							</td>
							<td>{{ $ctnInfo['out_content'] }}</td>
							<td>
								@if($ctnInfo['out_date'] != '')
									{{ $ctnInfo['out_date']->format('d/m/Y') }}
								@endif								
							</td>
							<td>{{ $ctnInfo['out_carrier'] }}</td>
							<td>{{ $ctnInfo['out_workorder'] }}</td>

							<?php
								if($i == $rowCount) {
									$i=0;
								}
							?>
						</tr>
					@endforeach
				@endif


			</tbody>
			</table>
				@if($info['containers_not_found'])
					<div class="alert alert-warning">
						<strong>No history for these containers:</strong>  {{ json_encode($info['containers_not_found']) }}
					</div>
				@endif
				</div>
			</div>
		</div>

		<div class="clear"></div>


	</div>

</body>
<!-- END BODY -->
</html>