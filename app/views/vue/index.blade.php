<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/keen-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Vue App</title>
</head>

<body>
    <div class="container">

        <hr />

        <div class="row">
            <div class="col-md-1">
                <ui-button @click="alert">Hello world!</ui-button>
            </div>
            <div class="col-md-4">
                <ui-autocomplete
                    label="Work Order #" :suggestions="workorders" :value.sync="workorder_id"
                    name="workorder" help-text="Pick a Work Order #"
                    placeholder="Enter a Work Order #"
                ></ui-autocomplete>
            </div>
        </div>

        <pre>@{{ workorders | json }}</pre>
    </div>


    <script src="js/vueapp.js"></script>

</body>
</html>