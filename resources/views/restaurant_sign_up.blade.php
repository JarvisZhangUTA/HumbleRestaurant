<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Humble Restaurants</title>

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Humble Restaurants</a>
            </div>
        </div>
    </nav>
    <div class="container" style="padding-top: 90px;">
        <div class="col-xs-12 col-sm-4">
            <h1>Basic Info</h1>
            <label for="email">Email</label>
            <input id="email" type="text" class="form-control" name="email" size="50">

            <label for="password">Password</label>
            <input id="password" type="password" class="form-control" name="password" size="50">

            <label for="confirm">Confirm Password</label>
            <input id="confirm" type="password" class="form-control" name="confirm" size="50">

        </div>

        <div class="col-xs-12 col-sm-6">
            <h1>Restaurant Info</h1>
            <label for="restaurantName">Restaurant Name</label>
            <input id="restaurantName" type="text" class="form-control" name="restaurantName" size="50">
            <label for="address">Restaurant Location</label>
            <img id="address_loading" src="img/loading.gif" style="margin-bottom:3px;height:12px; width:12px; display: none;">
            <input id="address" type="text" class="form-control" name="address" size="50">
            <label for="summary">A brief introduction to your restaurant</label>
            <textarea id="summary" class="form-control" rows="5" style="z-index: 0; resize: none;"></textarea>

            <br>
            <button id="signUp" type="button" class="btn btn-primary pull-right">Sign Up</button>
        </div>
    </div>

    <div id="alertMsg" class="alert alert-danger"></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/signUpRestaurant.js"></script>
</body>
</html>
