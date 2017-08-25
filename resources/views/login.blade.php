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
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>

                <ul class="nav navbar-nav pull-right">
                    <li class="active"><a href="/loginPage">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="padding-top: 160px;" class="section-content col-md-4 col-md-offset-4">
        <div class="panel-body panel-default">
            <h3>Log in to </h3> <h2>Humble Restaurants</h2>
            <div class="form-main">
                <div class="form-group">
                    <input id="email" type="text" class="form-control inputSign" placeholder="Email" required="required">
                    <input id="password" type="password" class="form-control inputSign" placeholder="Password" required="required">
                    <button id="signIn" class="btn btn-block signin">Sign In</button>
                </div>
                <div style="float: left;">
                    <i class="fa fa-unlock-alt"></i>
                    <a href="/forgetPass" id="forgot">Forgot password?</a>
                </div>
                <div style="float: right;">
                    <i class="fa fa-check"></i>
                    <a href="/signUpPage" id="signup">Sign Up</a>
                </div>
            </div>
        </div>
    </div>

    <div id="alertMsg" class="alert alert-danger"></div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/signIn.js"></script>
</body>
</html>