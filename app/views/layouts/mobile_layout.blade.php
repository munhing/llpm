<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<title>LLPM | Cargo Information System</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>

<link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset('assets/mobile/jquery.dataTables.css') }}" rel="stylesheet" type="text/css"/>
<!-- <link rel="shortcut icon" href="favicon.ico"/> -->
<style>
    .cp {
        background-color:#337ab7;
        color: white;
    }
</style>
</head>

<body>

<div class="container">

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Confirmation</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
              <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
  @include('flash::message')
	@yield('content')
</div>

<script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/mobile/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/mobile/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/mobile/pusher.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/mobile/mobile2.js') }}" type="text/javascript"></script>


<script>
   @yield('scripts')
</script>

</body>
</html>