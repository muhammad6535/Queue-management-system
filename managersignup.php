<?php

session_start();
if (!isset($_SESSION['usr_info']['signupcheck'])) {
    header("Location: index.php");
}

?>


<html>

<head>
    <!--    Programmers: Ashraf Hijazy - Mohammad Mhameed -->
    <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="js/npm.js"></script>

    <script src="js/managerSignUp.js"></script>
    <link href="css/manager.css" type="text/css" rel="stylesheet">

</head>

<body>
    <header>
        <!--Navigation Bar----------->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <a class="navbar-brand" href="index.php">דף הבית</a>
                </div>

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h5 class="hclass"> הגדרת פרטי חשבון המנהל</h5>
                        <!-- Manager--Mail// -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input id="managermail" type="text" class="form-control" placeholder="מייל של המנהל" name='managermail' />
                            </div>
                        </div>
                        <!-- Manager--Password// -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                <input id="pass1" type="password" required="" class="form-control" placeholder="סיסמה" name='pass1' />
                                <input id="pass2" type="password" required="" class="form-control" placeholder="אישור סיסמה" name='pass2' />
                            </div>
                        </div>
                        <!-- Submit--Button// -->
                        <button id="updatemanager" class="btn btn-sm btn-primary btn-block" type="submit">בצע</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-distributed">

        <div class="footer-right">
            <a href="https://www.facebook.com/Queue-System-Management-349283112551101" target="_blank"><img src="pictures/iconfinder_facebook-square-social-media_764909.png"></a>
            <a href="https://www.instagram.com/queuesys/" target="_blank"><img src="pictures/iconfinder_instagram-square-social-media_764856.png"></a>
            <a href="https://twitter.com/QsmQueue" target="_blank"><img src="pictures/iconfinder_twitter-square-social-media_764881.png"></a>
        </div>

        <div class="footer-left">

            <p class="footer-links">
                Queue System Management &copy; 2018

            </p>


        </div>

    </footer>


</body>

</html>
