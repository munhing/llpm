<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Datepicker</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
    <div class="container" id="app">

        <h1>Datepicker App</h1> 

        <datepicker :readonly="true" format="YYYY-MM-DD"></datepicker>
        <datepicker format="YYYY-M-D" value="2015-9-5"></datepicker>
        <datepicker :readonly="true" format="MMM/D/YYYY" width="100px"></datepicker>       

    </div>


  <script src="js/app.js"></script>

</body>
</html>