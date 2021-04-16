<?php
//Programmers: Ashraf Hijazy - Mohammad Mhameed
session_start();

// Set Cookies By Session To Use them In The JavaScript Page
if (isset($_SESSION['usr_info']['organization_username']) && isset($_SESSION['usr_info']['currDate']) && isset($_SESSION['usr_info']['brID']) && isset($_SESSION['usr_info']['brServiceID'])) {
    setcookie("username", $_SESSION['usr_info']['organization_username']);
    setcookie("curDate", $_SESSION['usr_info']['currDate']);
    setcookie("brID", $_SESSION['usr_info']['brID']);
    setcookie("brServID", $_SESSION['usr_info']['brServiceID']);
} 
else {
    header("Location: index.php");
}

?>

    <html>

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/npm.js"></script>

        <script src="js/queSystem.js"></script>


        <link rel="stylesheet" href="css/bootstrap.min.css">

        <link href="css/queuingStyles.css" type="text/css" rel="stylesheet">



    </head>

    <body>

        <header>
            <!--Navigation Bar --------------------------------------------------------------------------------------------------------------------------->
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
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">אפשרויות<span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <!-- Link trigger modal -->
                                    <li><a href="branches.php">חזרה לדף מנהל תורים</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="exit.php">יציאה</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse --------------------------------------------------------------------------------------------------------------->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>





        <!-- Date Change -------------------------------------------------------------------------------------------------------------------------->
        <div class="container">
            <div class="row">
                <form class="form-horizontal col-sm-7 col-sm-offset-2" action="" method="post">
                    <div class="form-group registration-date">
                        <div class="input-group registration-date-time">
                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                            <input id="date" class="form-control input-md" name="registration_date" id="registration-date" type="date">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="searchDate"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> חיפוש</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <hr>

            <div class="row">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title">תורים</h3>
                        <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> חיפוש</button>
                        </div>
                    </div>
                    <table id="tableque" class="table">
                        <thead>
                            <tr class="filters">
                                <th><input type="text" class="form-control" placeholder="#" disabled></th>
                                <th><input type="text" class="form-control" placeholder="שם לקוח" disabled></th>
                                <th><input type="text" class="form-control" placeholder="תאריך" disabled></th>
                                <th><input type="text" class="form-control" placeholder="זמן הגעה" disabled></th>
                                <th><input type="text" class="form-control" placeholder="זמן סיום" disabled></th>
                                <th><input type="text" class="form-control" placeholder="סוג שירות" disabled></th>
                            </tr>
                        </thead>
                        <tbody class="que">
                            <!-- Show All The Appointments That Linked To Specific (Branch/Service/Date) -->
                        </tbody>
                    </table>
                </div>
                <center>
                    <div class="cen">
                        <div class="well">
                            <!-- Show The First Appointment -->
                        </div>
                    </div>
                </center>
            </div>
        </div>



        <!-- Edit An Appointement ----------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                                <div class="card-body text-center">
                                                    <div id="editApp">


                                                    </div>
                                                    <!-- Date&Time -->
                                                    <div class="form-group">
                                                        <label class=" control-label" for="textinput">תאריך ושעה</label>
                                                        <div class="">
                                                            <input id="dateCh" class="form-control input-md" name="registration_date" type="date">
                                                            <select id="timeCh" class="form-control">
                                                            
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Submit--Button //-->
                                                    <div class="form-group ">
                                                        <center>
                                                            <button id="ApEdit" name="editAp " class="btn btn-sm btn-primary btn-block">בצע</button>
                                                        </center>
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
