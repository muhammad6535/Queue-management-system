<?php
//Programmers: Ashraf Hijazy - Mohammad Mhameed

require_once("dbClass.php");
require_once("appointmentClass.php");

$db = new dbClass();


?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">

        <title></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script type="text/javascript" src="js/jquery-3.2.0.js"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <script src="js/bootstrap.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/npm.js"></script>
        <link href="css/styles.css" type="text/css" rel="stylesheet">

        <script src="js/index.js"></script>



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

        <div id="fullscreen_bg" class="fullscreen_bg" />
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-12 col-sm-8 col-xs-9 bhoechie-tab-container">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                        <ul class="list-group">
                            <a href="#" class="list-group-item active">
                              <br/><br/><i class="glyphicon glyphicon-home"></i> הזמנת תור<br/><br/>
                            </a>
                            <a href="#" class="list-group-item ">
                              <br/><br/><i class="glyphicon glyphicon-tasks"></i> נציג ארגון<br/><br/>
                            </a>
                            <a href="#" class="list-group-item ">
                              <br/><br/><i class="glyphicon glyphicon-transfer"></i> הרשמת ארגון<br/><br/>
                            </a>
                            <a href="#" class="list-group-item">
                              <br/><br/><h4 class="glyphicon glyphicon-wrench"></h4> ביטול תור<br/><br/>
                            </a>
                        </ul>
                    </div>

                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">

                        <!------ הזמנת תור ---------->
                        <div class="bhoechie-tab-content active">
                            <center>
                                <h1 class="glyphicon glyphicon-user" style="font-size:14em;color:#00001a"></h1>
                                <h2 style="margin-top: 0;color:#00001a">ברוכים הבאים</h2>
                                <h3 style="margin-top: 0;color:#00001a">לאתר הזמנת תורים</h3>
                                <h2 style="margin-top: 0;color:#00001a"><button class="order btn btn-sm btn-primary btn-block">לחץ כאן להזמין תור</button></h2>
                            </center>
                        </div>


                        <!------ נציג ארגון---------->
                        <div class="bhoechie-tab-content">
                            <center>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3 class="text-center">
                                            כניסה לדף הארגון</h3>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                                </span>
                                                <input id="rep_name" required="" type="text" name="user" class="form-control" placeholder="שם משתמש" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input id="rep_password" required="" type="password" name="pass" class="form-control" placeholder="סיסמה" />
                                            </div>
                                        </div>
                                        <button id="signbtn" class="btn btn-sm btn-primary btn-block" type="submit">בצע</button>
                                    </div>
                                </div>
                            </center>
                        </div>


                        <!------ הרשמת ארגון---------->
                        <div class="bhoechie-tab-content">
                            <center>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3 class="text-center">
                                            הרשמת ארגון</h3>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                                </span>
                                                <input id="org_name" require="" type="text" required="" class="form-control" placeholder="שם ארגון" name='org_name' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                                </span>
                                                <input id="org_username" required="" type="text" name="user" class="form-control" placeholder="שם משתמש" name='org_username' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                                <input id="org_email" require="" type="text" required="" class="form-control" placeholder="מייל" name='mail' />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input id="org_password1" type="password" required="" class="form-control" placeholder="סיסמה" name='pass' />
                                                <input id="org_password2" type="password" required="" class="form-control" placeholder="אימות סיסמה" name='pass' />
                                            </div>
                                        </div>
                                        <button id="org_btn" class="btn btn-sm btn-primary btn-block" type="submit">בצע</button>

                                    </div>
                                </div>
                            </center>
                        </div>


                        <!-------ביטול תור--------->
                        <div class="bhoechie-tab-content">
                            <center>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <h3 class="text-center">
                                            ביטול תור</h3>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>
                                                </span>
                                                <input type="text" required="" id="customer_id" name="customer_id" class="form-control" placeholder="תעודת זהות" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                                <input type="text" required="" id="appointment_id" name="appointment_id" class="form-control" placeholder="מספר מזהה של התור" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                                <input type="text" required="" id="email" name="email" class="form-control" placeholder="מייל" />
                                            </div>
                                        </div>
                                        <button id="checkbtn" type="button" class="btn btn-sm btn-primary btn-block">בצע</button>
                                    </div>
                                </div>
                            </center>
                        </div>


                    </div>
                </div>
                <div class="col-lg-5 content"></div>
            </div>
        </div>
        <br>
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
