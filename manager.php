<?php
//Programmers: Ashraf Hijazy - Mohammad Mhameed
session_start();

// Set Cookies By Session To Use them In The JavaScript Page
if (isset($_SESSION['usr_info']['organization_username']) && isset($_SESSION['usr_info']['organization_name'])) {
    setcookie("username", $_SESSION['usr_info']['organization_username']);
    setcookie("orgName", $_SESSION['usr_info']['organization_name']);
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
        <script src="js/manager.js"></script>
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

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <form class="navbar-form navbar-left">
                            <div class="form-group">
                                <input type="text" id="searchVal" class="form-control" placeholder="... חיפוש סניף">
                            </div>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">אפשרויות מנהל <span class="caret"></span></a>
                                <ul class="dropdown-menu">

                                    <!-- Link trigger modal -->
                                    <li><a href="#addSnif" data-toggle="modal" data-target="#addSnif">הוספת סניף</a></li>
                                    <li><a href="#editManage" id="manageinfoedit" data-toggle="modal" data-target="#editManage">עדכון פרטי מנהל</a></li>
                                    <li><a href="#editOrga" id="orgainfoedit" data-toggle="modal" data-target="#editOrga">עדכון פרטי ארגון</a></li>
                                    <li><a href="branches.php">חזרה לדף הנהלת תורים</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="exit.php">יציאה</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a id="delorg">מחיקת ארגון</a></li>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>

        <!-- Branches -->
        <section id="team" class="pb-5">
            <div class="container">
                <div class="row branch_list">
                    <!-- Branches -->

                    <!-- Here We Show The List Of Branches That We Got From The DataBase
                    
                    <!-- ./Branch -->
                </div>
            </div>
        </section>



        <!-- Modal Add Branch ----------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="addSnif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="edit-modal">
                <div class="modal-content" style="background:transparent;">


                    <div class="modal-body">
                        <section id="team" class="pb-5">
                            <div class="row">
                                <div class="modal-body">
                                    <div id="myTabContent" class="tab-content">
                                        <!-------------------------------------Add Branch Modal ------------------------------------------------->
                                        <div class="tab-pane fade active in" id="addb">
                                            <div class="mainflip">
                                                <div class="frontside">
                                                    <div class="card">
                                                        <div id="add-branche" class="card-body text-center">


                                                            <!-- Exit--Button// -->
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="card-title">הוספת סניף</h4>

                                                            <!-- Branch--ID// -->
                                                            <div class="form-group input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                                </div>
                                                                <input id="branchID" name="branchID" class="form-control" placeholder="מספר סניף" type="text">
                                                            </div>

                                                            <!-- Branch--Name// -->
                                                            <div class="form-group input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                                </div>
                                                                <input id="branchName" name="branchName" class="form-control" placeholder="שם הסניף" type="text">
                                                            </div>

                                                            <!-- Branch--Mail// -->
                                                            <div class="form-group input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                                                </div>
                                                                <input id="branchMail" name="branchMail" class="form-control" placeholder="מייל" type="email">
                                                            </div>

                                                            <!-- Branch--Phone// -->
                                                            <div class="form-group input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                                                                </div>
                                                                <input id="branchTel" name="branchTel" class="form-control" placeholder="מספר טלפון" type="text">
                                                            </div>

                                                            <!-- Branch--Address// -->
                                                            <div class="form-group input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                                </div>
                                                                <input id="branchAddress" name="branchAddress" class="form-control" placeholder="כתובת" type="text">
                                                            </div>

                                                            <!-- Continue--Button// -->
                                                            <div class="form-group">
                                                                <button href="#workhours" id="con" class="btn btn-primary btn-block" data-toggle="tab">המשך</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------------------------------------------------------------------------------------------------------->
                                        <div class="tab-pane fade in" id="workhours">
                                            <div class="mainflip">
                                                <div class="frontside">
                                                    <div class="card">

                                                        <a href="#addb" id="back" role="button" data-toggle="tab"> <span class="glyphicon glyphicon-chevron-left" style="margin-right: 95%;"></span></a>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="card-title">שעות עבודה של הסניף</h4>

                                                        <div class="control">
                                                            <table class="table table-header-rotated">
                                                                <thead>
                                                                    <tr>
                                                                        <!-- First column header is not rotated -->
                                                                        <th></th>
                                                                        <!-- Following headers are rotated -->
                                                                        <th class="rotate">
                                                                            <div><span>פתיחת הסניף</span></div>
                                                                        </th>
                                                                        <th class="rotate">
                                                                            <div><span>הפסקה</span></div>
                                                                        </th>
                                                                        <th class="rotate">
                                                                            <div><span>סיום הפסקה</span></div>
                                                                        </th>
                                                                        <th class="rotate">
                                                                            <div><span>סגירת הסניף</span></div>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <!-- Day 1 -->
                                                                        <th class="row-header">ראשון</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 2 -->
                                                                        <th class="row-header">שני</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 3 -->
                                                                        <th class="row-header">שלישי</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 4 -->
                                                                        <th class="row-header">רביעי</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 5 -->
                                                                        <th class="row-header">חמישי</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 6 -->
                                                                        <th class="row-header">שישי</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <!-- Day 7 -->
                                                                        <th class="row-header">שבת</th>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                        <td><input type="time" class="days"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <hr>
                                                            <!-- Submit--Button// -->
                                                            <button type="submit" id="addBranch" class="btn btn-primary btn-block">בצע</button>
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

        <!---------- Modal Edit Organization Information ---------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="editOrga" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                                <div id="edit-orga" class="card-body text-center">


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

        <!---------- Modal Edit Manager Information ---------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="editManage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                                <div id="edit-manager" class="card-body text-center">


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


        <!-- Modal Add Service To Branch ------------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="addService" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="edit-modal">
                <div class="modal-content" style="background:transparent;">

                    <div class="modal-body">
                        <section id="team" class="pb-5">
                            <div class="row">
                                <!-- Branch -->
                                <div class="col-md-12">
                                    <div class="mainflip">
                                        <div class="frontside">
                                            <div class="card">
                                                <div id="add-branche" class="card-body text-center">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="card-title"> הוספת שירות לסניף </h4>

                                                    <!-- Service--Name// -->
                                                    <div class="form-group input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                            <input class="servType form-control" type="text" name="checkListItem" placeholder=" סוג שירות " />
                                                        </div>
                                                    </div>

                                                    <!-- Service--Average--Time// -->
                                                    <div class="form-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                        </div>
                                                        <input class="servType minAvg form-control" type="number" name="apAvg" min="1" max="59" placeholder="זמן ממוצע לכל תור בדקות 1-59" />
                                                    </div>
                                                    <!-- ADD--Service--Button// -->
                                                    <button type="button" id="add" class="btn btn-info">הוספת שירות</button>
                                                    <!-- Clear--Deleted--Services--Button// -->
                                                    <button type="button" id="clear" title="Clear checked items" class="btn btn-default">נקה רשימה</button>
                                                    <br><br>
                                                    <div class="list">
                                                        <!-- Here We Put The List Of Services That Entered! -->
                                                    </div>
                                                </div>
                                                <!-- Submit--Button// -->
                                                <div class="form-group">
                                                    <button type="submit" id="serv" class="btn btn-primary btn-block">בצע</button>
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

        <!-- Modal Edit Branch Information ----------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="editSnif" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
                                                <div id="edit-branche" class="card-body text-center">

                                                    <!-- Here We Put The Inputs With The Current Values Of The Selected Branch -->

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

        <!-- Modal Edit Work Hours  ----------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="edithours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="edit-modal">
                <div class="modal-content hour" style="background:transparent;">


                    <div class="modal-body">
                        <section id="team" class="pb-5">
                            <div class="row">
                                <!-- Branch A -->
                                <div class="col-md-12">
                                    <div class="mainflip">
                                        <div class="frontside">
                                            <div class="card">
                                                <div id="edit-Hours" class="card-body text-center">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="card-title">עדכון שעות עבודה</h4>

                                                    <div class="control">

                                                        <table id="ediHours" class="table table-header-rotated">
                                                            <!-- Here We Put The Hours Input With The Current Values Of The Selected Branch Woriking Hours -->
                                                        </table>
                                                        <hr>
                                                        <!-- Submit--Button// -->
                                                        <button type="submit" id="edithour" class="btn btn-primary btn-block">בצע</button>
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

        <!------------ Modal Edit/Delete Service To Branch --------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="editServ" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="edit-modal">
                <div class="modal-content" style="background:transparent;">

                    <div class="modal-body">
                        <section id="team" class="pb-5">
                            <div class="row">
                                <!-- Branch -->
                                <div class="col-md-12">
                                    <div class="mainflip">
                                        <div class="frontside">
                                            <div class="card">
                                                <div id="add-branche" class="card-body text-center">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="card-title"> עדכון/מחיקת סוג שירות </h4>


                                                    <!-- Select TypeOfService -->
                                                    <div class="form-group ">
                                                        <label class=" control-label " for="selectbasic ">סוג שירות</label>
                                                        <select id="servSelect" class="serv_list form-control">
                                                            <!-- Here We Put All The Services Of The Selected Branch -->
                                                        </select>
                                                    </div>

                                                    <div id="setServInfo">
                                                        <!-- Here We Put The Inputs With The Current Services Info Of The Selected Service -->
                                                    </div>

                                                    <!-- Update--Service--Button// -->
                                                    <button type="button" id="editSr" class="btn btn-info">עדכון</button>
                                                    <!-- Delete--Service--Button// -->
                                                    <button type="button" id="delSr" title="Clear checked items" class="btn btn-default">מחיקה</button>
                                                    <br><br>
                                                    <div class="list">
                                                        <!-- Here We Put The List Of Services That Entered! -->
                                                    </div>
                                                </div>
                                                <!-- Submit--Button// -->
                                                <div class="form-group">
                                                    <button type="submit" id="edSub" class="btn btn-primary btn-block">בצע</button>
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
