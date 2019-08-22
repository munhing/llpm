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
<title>LLPM | Work Order</title>
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
html, body {
	margin:0px 0px 0px 10px;

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
	padding-bottom:300px; /* Height of the footer element */
}

#footer {
	display:block;
	width:100%;
	height:300px;
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

.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
  padding: 1px;
}

.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
  border-top: 0px solid #ddd;
}
.table > thead > tr > th {
  border-bottom: 0px solid #ddd;
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
				</div>
			</div>		
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h1 class="text-left no-margin"><b>Delivery List</b>
						<span class="muted">
							Import
						</span>
					</h1>
				</div>
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<h2 class="text-right no-margin">
						No: {{ $importCargo->dl_no }}
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="invoice-payment">
						<ul class="list-unstyled">
							<li>
								<strong>Consignee:</strong> {{ $importCargo->consignee->name }}
							</li>
							<li>
								<strong>Vessel:</strong> {{ $schedule->vessel->name }} v.{{ $schedule->voyage_no_arrival }}
							</li>
							<li>
								<strong>Date of Arrival:</strong> {{ $schedule->eta->format('d/m/Y') }}
							</li>
						</ul>
					</div>				
				</div>
			</div>
		</div>

		<hr style="margin:0px; padding-bottom:5px;">

		<!-- Table -->
		<div id="content">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-striped table-condensed table-hover">
						<thead>
							<tr>
								<th>
									 B/L #
								</th>
								<th class="hidden-480">
									 Description
								</th>
								<th class="hidden-480">
									 MT
								</th>
								<th class="hidden-480">
									 M3
								</th>								
								<th class="hidden-480">
									 Markings
								</th>
								<th class="hidden-480">
									 Container #
								</th>								
							</tr>
						</thead>
					<tbody>
						<tr>
							<td>{{ $importCargo->bl_no }}</td>
							<td>{{ $importCargo->description }}</td>
							<td>{{ number_format($importCargo->mt, 2) }}</td>
							<td>{{ number_format($importCargo->m3, 2) }}</td>
							<td>{{ $importCargo->markings }}</td>
							<td>
								@foreach($importCargo->m_containers as $container)
									{{ $container->container_no }}
								@endforeach
							</td>
						</tr>			
					</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="clear"></div>

		<!-- Signature -->
		<div id="footer">
			<div class="row">
				<div class="col-xs-8">
					I ___________________ NRIC No _____________________
					as owner/agent of M/s _____________________________ hereby
					declare that I have vide this document taken delivery of the description
					and quantity appearing therein.
				</div>
				<div class="col-xs-4">
					D/L Issued and Quantity
					certified correct. <br>
					Rec No:
				</div>	
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12">
					Date DL Issued: {{ $importCargo->issued_date->format('d/m/Y') }}
				</div>
			</div>

			<br>

			<div class="row">
				<div class="col-xs-6">
					For Custom Reference _________________
				</div>
				<div class="col-xs-3" style="text-align: center">
					_________________<br>
					Sign & Chop
				</div>
				<div class="col-xs-3" style="text-align: center">
					_________________<br>
					Warehouse/Container Yard Supervisor
				</div>						
			</div>
			
			<br><br>

			<div class="row">
				<div class="col-xs-6" style="text-align: right">
					Main Gate Verification:
				</div>
				<div class="col-xs-3" style="text-align: center">
					_________________<br>
					Sign & Chop
				</div>
				<div class="col-xs-3" style="text-align: center">
					_________________<br>
					Date
				</div>						
			</div>		
		</div>
	</div>

</body>
<!-- END BODY -->
</html>