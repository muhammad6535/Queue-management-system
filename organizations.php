<?php
//Programmers: Ashraf Hijazy - Mohammad Mhameed 
session_start();

?>


    <html>

    <head>
        <script type="text/javascript" src="js/jquery-3.2.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="js/npm.js"></script>
        <link href="css/orgStyles.css" type="text/css" rel="stylesheet">

        <script src="js/organizations.js"></script>


    </head>

    <body>



        <!--Navigation Bar----------->
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


        <!-- Organization -->
        <section id="team" class="pb-5">
            <h3 id="searchLabel" class="section-title h3">בבקשה לבחור את החברה המבוקשת</h3>
            <div class="container">
                <div class="row org_list">
                    <!-- Organization member -->

                    <!-- Here We Fill All The Organization Cards From The DataBase
                    
                    <!-- ./Organization member -->
                </div>
            </div>
        </section>


        <!-- Modal Make a meeting ----------------------------------------------------------------------------------------------------->
        <div class="modal fade bs-example-modal-sm" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" id="order-modal">
                <div class="modal-content registerContent" style="background:transparent;">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h3 class="modal-title" id="myModalLabel"></h3>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-xs-6 ltr">
                                <p class="lead">שעות עבודה של סניף : <span id="braName">בחר סניף</span></p>
                                <table id="workhours" class="table table-header-rotated">

                                    <!--Here We Show The Working Hours Table That We Get From The DataBase-->

                                </table>
                            </div>

                            <div class="col-xs-6">
                                <div class="mainflip">
                                    <div class="frontside">
                                        <div class="card">
                                            <div id="orderForm" class="card-body text-center">
                                                <fieldset>
                                                    <!-- name input-->
                                                    <div class="form-group">
                                                        <div class="">
                                                            <input id="client_name" name="client_name" placeholder="שם מלא" class="form-control input-md" type="text">
                                                        </div>
                                                    </div>
                                                    <!-- Id input-->
                                                    <div class="form-group">
                                                        <div class="">
                                                            <input id="client_id" name="client_id" placeholder="תעודת זהות" class="form-control input-md" type="text">
                                                        </div>
                                                    </div>
                                                    <!--Mail Input-->
                                                    <div class="form-group">
                                                        <div class="">
                                                            <input id="client_email" name="client_email" placeholder="מייל: example@---.com" class="form-control input-md" type="text">
                                                        </div>
                                                    </div>
                                                    <!-- Select Organization's Branch -->
                                                    <div class="form-group ">
                                                        <label class=" control-label " for="selectbasic ">סניף</label>

                                                        <select id="braSelect" class="bra_list form-control">
                                                        <!--Here We Fill The Branches List Of Specific Organization That We Get From The DataBase-->
                                                    </select>

                                                    </div>
                                                    <!-- Select TypeOfService -->
                                                    <div class="form-group ">
                                                        <label class=" control-label " for="selectbasic ">סוג שירות</label>

                                                        <select id="servSelect" class="serv_list form-control">
                                                            <!--Here We Fill The Services List Of Specific Branch That We Get From The DataBase-->
                                                        </select>

                                                    </div>
                                                    <!-- Date&Time -->
                                                    <div class="form-group">
                                                        <label class=" control-label" for="textinput">תאריך ושעה</label>
                                                        <div class="">
                                                            <input id="date" class="form-control input-md" name="registration_date" type="date">
                                                            <select id="timeSelect" class="form-control">
                                                            <!--Here We Fill The Available Appointment Time List Of Specific Organization That We Get From The DataBase-->
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <!-- Button -->
                                                    <div class="form-group ">
                                                        <center>
                                                            <button id="sub" name="orderBtn " class="btn btn-sm btn-primary btn-block">בצע</button>
                                                        </center>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>


        <!---------------------------------------------------------------------------------------------------------------------------------------------------->

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
