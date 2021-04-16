<?php
//Programmers: Ashraf Hijazy - Mohammad Mhameed
session_start();

//Set Session Of Current Day To Use On Open The Page For The First Time
$_SESSION['usr_info']['currDate']=date('Y-m-d');

// Set Cookies By Session To Use them In The JavaScript Page


if (isset($_SESSION['usr_info']['organization_username']) && isset($_SESSION['usr_info']['currDate'])) {
    setcookie("username", $_SESSION['usr_info']['organization_username']);
    setcookie("curDate", $_SESSION['usr_info']['currDate']);
} 
else {
    header("Location: index.php");
}

?>

    <html>

    <head>
        <meta charset="utf-8">

        <title></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/npm.js"></script>
        <script src="js/branches.js"></script>
        <link href="css/orgStyles.css" type="text/css" rel="stylesheet">

    </head>

    <body>


        <!--Navigation Bar----------->
        <header>
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

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" id="searchVal" class="form-control" placeholder="... חיפוש סניף">
                            </div>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">אפשרויות<span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <!-- Link trigger modal -->
        
                                    <li><a href="exit.php">יציאה</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>


        <!-- Button trigger modal -->
        <button type="button" id="add" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#managersign">כניסה כמנהל</button>



        <!-- Branches -->
        <section id="team" class="pb-5">
            <h3 class="section-title h3">בבקשה לבחור את הסניף וסוג השירות המתאים</h3>
            <div class="container">
                <div class="row branch_list">

                </div>
            </div>
        </section>

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

        <!------------------------ MODALS -------------------------------------------------------------------------------------------------------------------->

        <!-- Modal Sign In Into Manager -->
        <div class="modal fade bs-example-modal-sm" id="managersign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="edit-modal">
                <div class="modal-content" style="background:transparent;">


                    <div class="modal-body">
                        <section id="team" class="pb-5">
                            <div class="row">
                                <!-- Branch A -->
                                <div class="col-md-12">
                                    <div class="mainflip">
                                        <div class="frontside">
                                            <div class="card">
                                                <div id="add-branche" class="card-body text-center">
                                                    <div id="modal">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="card-title">כניסה כמנהל</h4>
                                                        <!-- form-Username -->
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input id="rep_name" required="" type="text" name="user" class="form-control" placeholder="שם משתמש" />
                                                            </div>
                                                        </div>

                                                        <!-- form-Password -->
                                                        <div class="form-group input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                            </div>
                                                            <input id="rep_password" required="" type="password" name="pass" class="form-control" placeholder="סיסמה" />
                                                        </div>
                                                        <!-- form-Button -->
                                                        <div class="form-group">
                                                            <button type="submit" id="managerSign" class="btn btn-primary btn-block">בצע</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>
