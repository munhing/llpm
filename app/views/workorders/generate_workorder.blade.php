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
	padding-bottom:120px; /* Height of the footer element */
}

#footer {
	display:block;
	width:100%;
	height:120px;
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


<?php $page_total = ceil(count($workOrder->containers) / 30); ?>
<?php $no = 1; ?>
<?php  $container_chunk = array_chunk($workOrder->containers->toArray(), 30, true) ?>

@for ($page_counter = 1; $page_counter < ($page_total + 1); $page_counter++)

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
				<div class="col-xs-8">
					<h1 class="text-left no-margin"><b>Work Order</b>
						<span class="muted">
							{{ $movement[$workOrder->movement] }}	
						</span>
					</h1>
				</div>
				<div class="col-xs-4">
					<h2 class="text-right no-margin">
						#: {{ $workOrder->id }}
					</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="invoice-payment">
						<ul class="list-unstyled">
							<li>
								<strong>Date:</strong> {{ $workOrder->date->toFormattedDateString() }}
							</li>
							<li>
								<strong>Handler:</strong> {{ $handler->name }}
							</li>
							<li>
								<strong>Carrier:</strong> {{ $carrier }}
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
									 #
								</th>
								<th>
									 Container #
								</th>
								<th class="hidden-480">
									 Size
								</th>
								<th class="hidden-480">
									 Status
								</th>
								<th class="hidden-480">
									 Remarks
								</th>
							</tr>
						</thead>
					<tbody>
					
					@foreach($container_chunk[$page_counter - 1] as $container)
					<tr>
						<td>
							 {{ $no }}
						</td>
						<td>
							 {{ $container['container_no'] }}
						</td>
						<td class="hidden-480">
							 {{ $container['size'] }}
						</td>
						<td class="hidden-480">
							 {{ $content[$container['pivot']['content']] }}
						</td>
						<td class="hidden-480">
							@if( $container['pivot']['lifter'] || $container['pivot']['vehicle'])
							 {{ $container['pivot']['lifter'] }} | {{ $container['pivot']['vehicle']}}
							@endif
						</td>
					</tr>
					<?php $no++; ?>
					@endforeach										
					</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="clear"></div>

		<!-- Signature -->
		<div id="footer">
			<div class="row">
				<div class="col-xs-4" style="text-align: center">
					<b>CY Supervisor</b>
				</div>
				<div class="col-xs-4" style="text-align: center">
					<b>Owner/Agent</b>
				</div>
				<div class="col-xs-4" style="text-align: center">
					<b>Handler</b>
				</div>						
			</div>

			<!-- Fineprints -->
			<div class="row fineprint">
				<p>
					Received the above in good order and condition.
				</p>
			</div>

			<div class="row fineprint">
				<p>
					<b>NOTE: </b>All operations to handling or storage of import and export of goods/containers within the storage area shall
					be under the directive and supervision of LABUAN LIBERTY PORT MANAGEMENT SDN.BHD. (LLPM) <br>
					No labour and equipments be brought into the storage area without prior authorization from LLPM.
				</p>
			</div>
			<div class="row fineprint">
				<p>
					Page {{ $page_counter }}/{{ $page_total }}
				</p>
			</div>			
		</div>
	</div>

	@if ($page_counter < $page_total)
		<div class="break"></div>
	@endif

@endfor
	


</body>
<!-- END BODY -->
</html>