<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>LLPM | Report</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<link href="{{ URL::asset('assets/admin/pages/css/invoice.css') }}" rel="stylesheet" type="text/css"/>

<link href="{{ URL::asset('assets/global/css/components.css') }}" rel="stylesheet" type="text/css" id="style_components"/>
<link href="{{ URL::asset('assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>

<link rel="shortcut icon" href="favicon.ico"/>

<style>
html, body {
	margin:0px 20px 0px 50px;
	padding:0;
	height:100%;
}

body {
	display: flex;
	justify-content: center;
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

@if (isset($vuePage))
<component is="{{ $vuePage }}">
@endif

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

		@yield('header')

	</div>

	<hr style="margin:0px; padding-bottom:5px;">

	<div id="content">

		@yield('content')

	</div>

</div>

@yield('page_level_scripts')

</component>

</body>
<!-- END BODY -->
</html>