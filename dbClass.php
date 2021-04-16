<?php
require_once("appointmentClass.php");
require_once("organizationClass.php");
require_once("org_representClass.php");
require_once("serviceClass.php");

class dbClass
{	
	private $host;
	private $db;
	private $charset;
	private $user;
	private $pass;
	private $opt = array(
	
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
	
	private $connection;
	
    
	public function __construct($host="localhost",$db="management", $charset= "utf8", $user = "root", $pass="")
	{
		$this->host=$host;
		$this->db=$db;
		$this->charset=$charset;
		$this->user=$user;
		$this->pass=$pass;
	}

    
    
	private function connect()
    {
		$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
		$this->connection = new PDO($dsn,$this->user,$this->pass,$this->opt);	
	}
	
	
     
    private function disconnect()
    {	
		$this->connection = null;
	}
    
    
    
    public function execute($sql,$info)
    {
        $this->connect();
        $this->connection->prepare($sql)->execute($info);
        $this->disconnect();
    }
    
    public function getInfo($sql,$info)
    {
        $this->connect();
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($info);
        $data = $stmt->fetchAll();
        
        $this->disconnect();
        
        return $data;    
    }
    
//------------------- Organization Functions --------------------------------------------------------------------------------    
    
    //Insert New Organization
    public function insertOrganization(organizationClass $info)
    {
        $values = array();
        
        //Query To insert Into Organization Table
        $sqlInsert = "INSERT INTO organization(organization_name,organization_username,organization_email,organization_password) VALUES('".$info->getOrganizationName()."','".$info->getOrganizationUserName()."','".$info->getOrganizationEmail()."','".$info->getOrganizationPassword()."')";
        
        //Query To Update Data into Org_Represent Table
        $sqlUpdate="INSERT INTO org_represent(username,password) VALUES('".$info->getOrganizationUserName()."','".$info->getOrganizationPassword()."')";
        
        $this->execute($sqlInsert,$values);
        $this->execute($sqlUpdate,$values);
        
        //Set Session To Continue Using Them In The Other Pages 
        $_SESSION['usr_info']['organization_name']=$info->getOrganizationName();
        $_SESSION['usr_info']['organization_username']=$info->getOrganizationUserName();
        $_SESSION['usr_info']['organization_email']=$info->getOrganizationEmail();
        $_SESSION['usr_info']['organization_password']=$info->getOrganizationPassword();
    }
    
    //Sign In As A Represent For an Organization
    public function representSignIn(org_representClass $info)
    {
        //Set Values In The Array
        $values = array($info->getUsername(),$info->getPassword());
        
        //Query To Select All The Information Of Specific Organization
        $sqlRep="SELECT o.* FROM organization o INNER JOIN org_represent orep ON orep.username=o.organization_username WHERE username=? AND password=?";
        $checkRep=$this->getInfo($sqlRep,$values);
        
        //Query To Select All The Information Of Specific Organization
        $sqlManager="SELECT o.* FROM organization o INNER JOIN org_manager orep ON orep.username=o.organization_username WHERE username=? AND password=?";
        $checkManager=$this->getInfo($sqlManager,$values);
        
        //If Password Of Represent Entered It Will Open A Page Branches
        if(count($checkRep)) 
        {           
            $_SESSION['usr_info']=$checkRep[0];
            $this->execute($sqlRep,$values);
            die("rep");
        }
        else //Else It Will Open A Page Manager
        {
            if(count($checkManager))
            {
                $_SESSION['usr_info']=$checkManager[0];
                $this->execute($sqlManager,$values);
                die("manager");
            }
            else //Else There Is Something Wrong
                die('שם המשתמש או הסיסמה לא נכונים ,נסה שוב');
        }
    }
    
    //Sign In As A Manager For an Organization 
    public function managerSignIn(org_representClass $info)
    {
        //Query To Select All The Information Of Specific Organization
        $sql="SELECT o.* FROM organization o INNER JOIN org_manager orep ON orep.username=o.organization_username WHERE username=? AND password=?";
        $values = array($info->getUsername(),$info->getPassword());
        
        $check=$this->getInfo($sql,$values);
        
        //Check The Validety Of Entered Data (If The Manager Exist)
        if(count($check)) 
        {   //Save In The Session If Everything Okay To Use This Info In Another Page       
            $_SESSION['usr_info']=$check[0];
            $this->execute($sql,$values);
        }
        else 
            die('שם המשתמש או הסיסמה לא נכונים ,נסה שוב');
    }
    
    //Sign Up Manager For an Organization 
    public function managerSignUp(org_representClass $info)
    {
        $values = array();
        
        //Query To Insert Manager Information Into DataBase 
        $sqlInsert = "INSERT INTO org_manager(username,password,manager_mail) VALUES('".$info->getUsername()."','".$info->getPassword()."','".$info->getManagerMail()."')";
        
        $values = array($info->getUsername(),$info->getPassword(),$info->getManagerMail());
        
        $this->execute($sqlInsert,$values);
    }
    
    
    
    //Function To Get All Organizations Informations
    public function getAllOrganizations()
    {
        $sql = "SELECT * FROM organization";
        $values=array();
        $org=$this->getInfo($sql,$values);
        return $org;
    }
    
    
   
    //Function To Get All Organization Managers Mail
    public function getOrgManagersMail()
    {
        $sql = "SELECT manager_mail FROM org_manager";
        $values=array();
        
        $mng=$this->getInfo($sql,$values);

        return $mng;
    }
    
    
    
    //Function To Get All Organizations into organization.php
    public function getOrganizations()
    {
        //Query To Get Specific Information From DataBase of Organzation Table
        $sql = "SELECT organization_username,organization_name,organization_email FROM organization";
        $values=array();
        
        $organizations=$this->getInfo($sql,$values);
        
        //Paste Code Organization Card Code Into The Organization Page With The Data From The DataBase
        foreach($organizations as $org)
        {
            $i=$org['organization_username'];
        ?>

        <div class="col-xs-12 col-sm-6 col-md-3 organizations">
            <div class="mainflip">
                <div class="frontside">
                    <div class="card">
                        <div class="card-body text-center">
                            <p><img class=" img-fluid" src="pictures/orgIcon.jpg" alt="card image"></p>
                            <h4 class="card-title"><?php echo $org['organization_name']; ?></h4>
                            <p class="card-text">מייל : <?php echo $org['organization_email']; ?></p>
                            <button value="<?php echo $org['organization_name']; ?>" name='<?php echo $i; ?>' class="orgUsername btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#registerModal">לחץ כאן</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        }
    }
    
    
   
//----------------------- Appointment Functions ------------------------------------------------------------------
    
    //Function To check if There Is An Appointment Exist In The Same Organization And The Same Branch With The Same DateTime
    public function checkDateTime($username,$branch_id,$date,$time)
    {
        $values=array($username,$branch_id,$date,$time);
        
        $check=$this->getInfo("SELECT count(*) as nt FROM appointment WHERE username=? AND branch_id=? AND appointment_date=? AND appointment_time=?",$values);

        //Return The Answer We Got From The Query
        return $check[0]['nt'];
    }
    //
    public function checkShiftNight($username,$branch_id,$date,$time)
    {
        //Convert The Day To Number Type
        $day=date('D', strtotime($date));
            switch ($day) {
                case "Sun": $day=1; break;
                case "Mon": $day=2; break;
                case "Tue": $day=3; break;
                case "Wed": $day=4; break;
                case "Thu": $day=5; break;
                case "Fri": $day=6; break;
                case "Sat": $day=7; break;
            }
        //Query To Get Working Hours Of Specific Day Of Specific Branch
        $sqlGetsche="SELECT * FROM work_hours WHERE branch_id=? AND day=?";
        $values=array($branch_id,$day);
        $sche=$this->getInfo($sqlGetsche,$values);
        
        if($sche[0]['startA']>"12:00" && $sche[0]['endB']>="00:00" && $sche[0]['endB']<="12:00")
        {
            $checkTime=strtotime($sche[0]['endB'])-strtotime($time);
            if($checkTime>=0)
                    {
                $date++;
                return $date;
            }
             else
                return $date;
        }
        return $date;
    }
    
    //Function To Check If The Customer ID Is Exist In The Same Organization And The Same Branch
    public function isCustomerIDEXist($username,$branch_id,$cusID)
    {
        $values=array($username,$branch_id,$cusID);
        
        $check=$this->getInfo("SELECT count(*) as nt FROM appointment WHERE username=? AND branch_id=? AND customer_id=?",$values);

        return $check[0]['nt'];
    }
    
    //Insert Appointment Into The DataBase
    public function insertAppointment(appointmentClass $info,$username)
    {
        $values = array();
        
        //Query To insert Appointment Into Appointment Table In The DataBase
        $sqlInsert = "INSERT INTO appointment(customer_name,customer_id,customer_mail,branch_id,service_id,appointment_date,appointment_time,username) VALUES('".$info->getCustomerName()."','".$info->getCustomerID()."','".$info->getCustomerMail()."','".$info->getBranchName()."','".$info->getApointmentService()."','".$info->getAppointment_date()."','".$info->getAppointment_time()."','".$username."')";
        
        $this->execute($sqlInsert,$values);
        
        $values = array($info->getCustomerID(),$info->getCustomerMail());
        
        //Check If The Appointment Inserted In The Table In The DataBase
        $check=$this->getInfo("SELECT count(*) as nt FROM appointment WHERE customer_id=? AND customer_mail=?",$values);
        //Get The Appointment  Data To Us In Mail Message
        $queueData=$this->getInfo("SELECT * FROM appointment WHERE customer_id=? AND customer_mail=?",$values);
        
        //If EveryThing Okay We Send A Message Contain The Appointment Data 
        if($check[0]['nt'])
        {
            //Send  Email
            $to = $info->getCustomerMail();
            $subject = "Queue Order";
            $message = "Hi ".$info->getCustomerName().".\nYour Queue Is Set , Thanks for Choosing Q.S.M \nQueue Date: ".$info->getAppointment_date()."\nQueue Time: ".$info->getAppointment_time()."\nYour Queue ID : ".$queueData[0]['appointment_id']." ";
            $headers = 'From: Q.S.M@Company.com'."\r\n".'X-Mailer: PHP/'.phpversion();
    
            mail($to, $subject, $message, $headers);
            die('התור הוגדר בהצלחה , נשלחה הודעה למייל');
        }
        else 
            die('התור לא הוגדר');
    }
    
    
    
    //Cancel Appointment And Delete It From The DataBase
    public function cancelAppointment(appointmentClass $info)
    {
        //Query To Delete The Appointment From The DataBase
        $sql = "DELETE FROM appointment WHERE customer_id=? AND appointment_id=? AND customer_mail=?";
        $values = array($info->getCustomerID(),$info->getAppointmentID(),$info->getCustomerMail());
        
        //Check If The Appointment Still Exist In The DataBase
        $check=$this->getInfo("SELECT * FROM appointment WHERE customer_id=? AND appointment_id=? AND customer_mail=?",$values);
        
        //If EveryThing Okay We Send A Message Conatain Confirm Deletion
        if($check)
        {
            $this->execute($sql,$values);
            
            //Send  Email
            $to = $info->getCustomerMail();
            $subject = "Queue Order";
            $message = "Hi ".$check[0]['customer_name']."\n Your Queue Is Canceled , Thanks for Choosing Q.S.M ";
            $headers = 'From: Q.S.M@Company.com'."\r\n".'X-Mailer: PHP/'.phpversion();
    
            mail($to, $subject, $message, $headers);
                die("התור בוטל בהצלחה ,נשלחה הודעה למייל");
        }
        else 
            die('התור לא קיים');
    }
    
    
    //Function To Get All Services From DataBase Of Specific Branch
    public function getServiceInfo($BraID)
    {
        //Query To Get All Services Information From The DataBase Of Specific Branch By Branch ID
        $sql="SELECT * FROM service s INNER JOIN service_branch sb ON s.service_id=sb.service_id WHERE branch_id=?";
        $values=Array($BraID);
        $services=$this->getInfo($sql,$values);
        
        //Paste Services Name Into The Selection
        ?>  
            <option value="---">---</option>
        <?php
        foreach($services as $i)
        {
                    $id=$i['service_id'];
                    ?>  
                    <option value="<?php echo $id ?>"><?php echo $i['service_name']; ?></option>
                  <?php
        }
    }
    
    //Function To Get All Information Of The Current Manager
    public function getManagerInfo($Username)
    {
        //Query To Get All Manager Information From The DataBase
        $sql="SELECT * FROM org_manager WHERE username=?";
        $values=Array($Username);
        $manager=$this->getInfo($sql,$values);
        
        //Fill Manager Information
        ?>  
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="card-title">עדכון פרטי מנהל</h4>

            <!-- form-Enter-Current-Password// -->
            <div class="form-group">
                <div class="input-group">
                    <input id="cur_password" type="password" required="" class="form-control" placeholder="סיסמה נוכחית" name='pass' />
                </div>
            </div>

            <!-- form-Enter-New-Password// -->
            <div class="form-group">
                <div class="input-group">
                    <input id="password1" type="password" required="" class="form-control" placeholder="סיסמה חדשה" name='pass' />
                </div>

                <div class="input-group">
                    <input id="password2" type="password" required="" class="form-control" placeholder="הקש שוב סיסמה חדשה" name='pass' />
                </div>
            </div>

            <!-- form-Mail// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input id="managerMail" name="managerMail" class="form-control" value= "<?php echo $manager[0]['manager_mail']; ?>" type="email">
            </div>

            <div class="form-group">
                <button type="submit" id="editManager" class="btn btn-primary btn-block">בצע</button>
            </div>
            <!-- form-Button// -->
        <?php
        
    }
    
    //Function To Get All Information Of The Current Organization
    public function getOrgaInfo($Username)
    {
        //Query To Get All Organization Information From The DataBase
        $sql="SELECT * FROM organization WHERE organization_username=?";
        $values=Array($Username);
        $orga=$this->getInfo($sql,$values);
        
        //Fill Organization Information
        ?>  
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="card-title">עדכון פרטי ארגון</h4>
            <!-- Organization-Name// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
                <input id="editorgaName" name="editorgaName" class="form-control" value= "<?php echo $orga[0]['organization_name']; ?>" type="text">
            </div>
            <!-- Organization-Mail// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input id="editorgaMail" name="editorgaMail" class="form-control" value= "<?php echo $orga[0]['organization_email']; ?>" type="email">
            </div>
            <!-- form-Enter-Current-Password// -->
            <div class="form-group">
                <div class="input-group">
                    <input id="orgPass" name="orgPass" class="form-control" value= "<?php echo $orga[0]['organization_password']; ?>" type="text">
                </div>
            </div>
            <!-- Submit-Btn// -->
            <div class="form-group">
                <button type="submit" id="editorga" class="btn btn-primary btn-block">בצע</button>
            </div>
        <?php
    }
    
    //Function To Get All The Information Of Specific Services
    public function setServiceInfo($servID)
    {
        $sql="SELECT * FROM service WHERE service_id=?";
        $values=Array($servID);
        $services=$this->getInfo($sql,$values);
        
        //After We Choose Specific Service We Show The Old Information
        ?>
            <div class="form-group timeAvg">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                 </div>
                <input id="updatedServ" class="servType minAvg form-control" type="text" value= "<?php echo $services[0]['service_name']; ?>" />
             </div>

            <div class="form-group timeAvg">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                 </div>
                <input id="updatedAvg" class="servType minAvg form-control" type="number" name="apAvg" min="1" max="59" value= "<?php echo $services[0]['app_time_avg']; ?>" />
             </div>
        <?php
    }
    
        
    //Update The Service Name Into The DB
    public function updateServiceInfo($servID,$servName,$servAvg)
    {
        $sqlUpdate="UPDATE service SET service_name= '".$servName."',app_time_avg= '".$servAvg."' WHERE service_id ='".$servID."' ";
        $this->execute($sqlUpdate,$values);
    }
    
    //Delete The Service From The DB
    public function deleteServiceInfo($servID)
    {
        //First Delete From Appointment Table
        $sqlDelete = "DELETE FROM appointment WHERE service_id=?";
        $values = array($servID);
        $this->execute($sqlDelete,$values);
        //Delete From Service_Branch Table
        $sqlDelete = "DELETE FROM service_branch WHERE service_id=?";
        $values = array($servID);
        $this->execute($sqlDelete,$values);
        //Delete Service From Service Table
        $sqlDelete = "DELETE FROM service WHERE service_id=?";
        $values = array($servID);
        $this->execute($sqlDelete,$values);
    }
    
    
    //Function To Get All Queues List of Specific (Orgnization,Branch_name,Service) And Current Date
    public function getQueList($org_user,$branch_ID,$appServ,$date)
    {   
        //Query To Get All Appointments From DB 
        $sqlGetQue="SELECT * FROM appointment WHERE username=? AND branch_id=? AND service_id=? AND appointment_date=?";
        $values=array($org_user,$branch_ID,$appServ,$date);
        $queList=$this->getInfo($sqlGetQue,$values);
        
        //Query To Get Service Data
        $sqlGetData="SELECT * FROM service WHERE service_id=?";
        $values=array($appServ);
        $servData=$this->getInfo($sqlGetData,$values);

        //Sort The Queue Array By The Appointment Time
        usort($queList, function($a1, $a2) {
           $v1 = strtotime($a1['appointment_time']);
           $v2 = strtotime($a2['appointment_time']);
           return $v1 - $v2;
        });
        //Paste The Table Code Into The Table Area With The Sorted Appointments From The DataBase
        ?>
        <?php
        foreach($queList as $que)
        {
            $avgTime=$servData[0]['app_time_avg'];
            $plusTime='+'.$avgTime.' minutes';
            $time = strtotime($que['appointment_time']);
            $endTime = date("H:i", strtotime($plusTime, $time));
                    ?>
                    <tr>
                        <td><?php echo $que['appointment_id']; ?></td>
                        <td><?php echo $que['customer_name']; ?></td>
                        <td><?php echo $que['appointment_date']; ?></td>
                        <td><?php echo $que['appointment_time']; ?></td>
                        <td><?php echo $endTime.":00"; ?></td>
                        <td><?php echo $servData[0]['service_name']; ?></td>
                        <td><button name="<?php echo $que['appointment_id']; ?>" class='btn btn-edit' data-toggle='modal' data-target='#editModal'>עדכון</button></td>
                        <td><button name="<?php echo $que['appointment_id']; ?>" class="btn btn-del">מחיקה</button></td>
                    </tr>
                    <?php
        }
        ?>
        <?php
    }
    
    //Delete Appointment By The Appointment ID
    public function delCurrentQue($queID)
    {
        $sql = "DELETE FROM appointment WHERE appointment_id=? ";
        $values = array($queID);
        
        $this->execute($sql,$values);
    }
    
    //Set Current Value Of Specific Appointment From DataBase
    public function setAppointmentValues($queID)
    {
        //Query To Get The Values Of Specific Appointment
        $sql = "SELECT * FROM appointment WHERE appointment_id=? ";
        $values = array($queID);
        $app=$this->getInfo($sql,$values);
        //Fill The Modal With The Old Data Of Specific Appointment That The Represent Choosed To Update
        ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="card-title">עדכון פרטים</h4>
           <!-- name input-->
                    <div class="form-group">
                        <div class=""> 
                            <input id="client_name" name="client_name" value= "<?php echo $app[0]['customer_name']; ?>" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <!-- Id input-->
                    <div class="form-group">
                        <div class="">
                            <input id="client_id" name="client_id" value= "<?php echo $app[0]['customer_id']; ?>" class="form-control input-md" type="text">
                        </div>
                    </div>
                    <!--Mail Input-->
                    <div class="form-group">
                        <div class="">
                            <input id="client_email" name="client_email" value= "<?php echo $app[0]['customer_mail']; ?>"  class="form-control input-md" type="text">
                        </div>
                    </div>
        <?php
        
    }
    
    
    
//----------------------- Branches Functions ------------------------------------------------------------------
    
    //Insert New Branch
    public function insertBranch(branchClass $info,$times)
    {
        $values = array();
        
        //Query To insert Branch Into Branch Table
        $sqlInsert = "INSERT INTO branch(branch_id,branch_mail,branch_name,branch_tel,branch_address,org_username) VALUES('".$info->getBranchID()."','".$info->getBranchMail()."','".$info->getBranchName()."','".$info->getBranchTel()."','".$info->getBranchAddress()."','".$_SESSION['usr_info']['organization_username']."')";
        
        $this->execute($sqlInsert,$values);
        //Insert All The 7 Days Of Work
        foreach($times as $day)
        {
            $sqldates = "INSERT INTO work_hours(day,startA,endA,startB,endB,dayOFF,branch_id) VALUES('".$day[4]."','".$day[0]."','".$day[1]."','".$day[2]."','".$day[3]."','".$day[5]."','".$info->getBranchID()."')";

            $this->execute($sqldates,$values);
        }
    }
    
   
    //Function To Update Working  Hours In The DB
    public function editHours($times,$brID)
    {
        $values = array();
        //Update The Working Hours By The Values From Array Times
        foreach($times as $day)
        {
            $sqlUpdate="UPDATE work_hours SET startA= '".$day[0]."',endA= '".$day[1]."',startB='".$day[2]."',endB='".$day[3]."',dayOFF='".$day[5]."'
                WHERE branch_id ='".$brID."' AND day ='".$day[4]."'";
            $this->execute($sqlUpdate,$values);
        }
    }
    
    

    //Set The Current Branch Working Hours Info Of Specific Day
    public function fillHours($brID)
    {
        //Query To Get The Old Data Of The Branch WorkingDay Hours
        $sql = "SELECT * FROM work_hours WHERE branch_id=?";
        $values=array($brID);
        $workDay=$this->getInfo($sql,$values);
        //Fill the Modal With The Working Hours Information Of Every Day From The DataBase Of The Branch That Represent Choosed
        ?>
            <thead>
                <tr>
                <!-- First column header is not rotated -->
                <th></th>
                <!-- Following headers are rotated -->
                <th class="rotate"><div><span>פתיחת הסניף</span></div></th>
                <th class="rotate"><div><span>הפסקה</span></div></th>
                <th class="rotate"><div><span>סיום הפסקה</span></div></th>
                <th class="rotate"><div><span>סגירת הסניף</span></div></th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <th class="row-header">ראשון</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[0]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[0]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[0]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[0]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">שני</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[1]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[1]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[1]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[1]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">שלישי</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[2]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[2]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[2]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[2]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">רביעי</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[3]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[3]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[3]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[3]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">חמישי</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[4]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[4]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[4]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[4]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">שישי</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[5]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[5]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[5]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[5]['endB']; ?>"></td>
                </tr>
                <tr>
                    <th class="row-header">שבת</th>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[6]['startA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[6]['endA']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[6]['startB']; ?>"></td>
                    <td><input type="time" class="editday" value= "<?php echo $workDay[6]['endB']; ?>"></td>
                </tr>
            </tbody>
        <?php
        
    }
    
    
    //Set The Current Branch info into Fields
    public function fillFields($brID)
    {
        //Query To Get The Old Data Of The Branch
        $sql = "SELECT * FROM branch WHERE branch_id=?";
        $values=array($brID);
        $branche=$this->getInfo($sql,$values);
        //Fill the Modal With The Branch Information Of The Specific Branch That Represent Choosed
    ?>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="card-title">עדכון פרטים</h4>
        <!-- Branch-Name// -->
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
            </div>
            <input id="editbranchName" name="editbranchName" class="form-control" value= "<?php echo $branche[0]['branch_name']; ?>" type="text">
        </div>
        <!-- Branch-Mail// -->
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
            </div>
            <input id="editbranchMail" name="editbranchMail" class="form-control" value= "<?php echo $branche[0]['branch_mail']; ?>" type="email">
        </div>
        <!-- Branch-Phone// -->
        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
            </div>

            <input id="editbranchTel" name="editbranchTel" class="form-control" value= "<?php echo $branche[0]['branch_tel']; ?>" type="text">
        </div>
        <!-- Branch-Address// -->

        <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
            </div>
            <input id="editbranchAddress" name="editbranchAddress" class="form-control" value= "<?php echo $branche[0]['branch_address']; ?>" type="text">
        </div>
        <!-- Submit-Btn// -->
        <div class="form-group">
            <button type="submit" id="editBranch" class="btn btn-primary btn-block">בצע</button>
        </div>
    <?php
    }
    
    //Edit Exist Branch By The Branch ID
    public function editBranch(branchClass $info,$id)
    {
        $values = array();
        //Query To Update Branch Into Branch Table
        $sqlUpdate="UPDATE branch SET branch_mail= '".$info->getBranchMail()."',branch_name= '".$info->getBranchName()."',branch_tel='".$info->getBranchTel()."',branch_address='".$info->getBranchAddress()."',org_username='".$_SESSION['usr_info']['organization_username']."'
        WHERE branch_id ='".$id."' ";
        
        $this->execute($sqlUpdate,$values);
    }

    //Edit Exist Organization By Username
    public function editorganization(organizationClass $info,$username)
    {
        $values = array();
        //Query To Update Branch Into Branch Table
        $sqlUpdate="UPDATE organization SET organization_email= '".$info->getOrganizationEmail()."',organization_name= '".$info->getOrganizationName()."',organization_password='".$info->getOrganizationPassword()."' WHERE organization_username ='".$username."' ";
        
        //Query To Update Represent Password Into Org_Represent Table
        $sqlUpdateRepresent="UPDATE org_represent SET password= '".$info->getOrganizationPassword()."' WHERE username ='".$username."' ";
        
        $this->execute($sqlUpdate,$values);
        
        $this->execute($sqlUpdateRepresent,$values);
    }
    
    
    //Function To Check The Validety of the Current Password That Entered
    public function checkManagerPass($pass,$username)
    {
        $sql = "SELECT * FROM org_manager WHERE username=?";
        $values=array($username);
        $check=$this->getInfo($sql,$values);
        if($check[0]['password']!=$pass)
            return 0;
        return 1;
    }
    
    public function updateManagerInfo(org_representClass $info,$username)
    {
        //To Get All The Original Informaion OF This Manager
        $sql = "SELECT * FROM org_manager WHERE username=?";
        $values=array($username);
        $check=$this->getInfo($sql,$values);
        
        //Fill The Missing Information With The Current Data
        if($info->getPassword()=="")
            $info->setPassword($check[0]['password']);
        if($info->getManagerMail()=="")
            $info->setManagerMail($check[0]['manager_mail']);
        
        //Query To Update Manager Info
        $sqlUpdate="UPDATE org_manager SET password= '".$info->getPassword()."',manager_mail= '".$info->getManagerMail()."' WHERE username ='".$username."' ";
        
        $this->execute($sqlUpdate,$values);
    }
    
    //Function To Get All Branches Informations We Use It To Avoid Duplicate Branch Data
    public function getAllBranches()
    {
        $sql = "SELECT * FROM branch";
        $values=array();
        
        $branches=$this->getInfo($sql,$values);

        return $branches;
    }
    
    //Function To Get All Organization Informations We Use It To Avoid Duplicate Organization Data
    public function getAllOrgs()
    {
        $sql = "SELECT * FROM organization";
        $values=array();
        
        $orgs=$this->getInfo($sql,$values);

        return $orgs;
    }
    
    
    //Function To Show All The Branches into Branches.php
    public function getBranches($organization_username)
    {
        //Query To Get All The Services Of Specific Branch To Fill Into The Selection Box
        $sqlGetServices="SELECT * FROM service s INNER JOIN service_branch sb ON s.service_id=sb.service_id WHERE branch_id=?";
        
        $sql = "SELECT branch_id,branch_name FROM branch WHERE org_username=?";
        
        $values=array($organization_username);
        
        $branches=$this->getInfo($sql,$values);
        
        //Paste The Card's Code Of Every Branch With Its Own Service List
        foreach($branches as $branch)
        {
            $values=array($branch['branch_id']);
            $services=$this->getInfo($sqlGetServices,$values);
        ?>
    <div class="col-xs-12 col-sm-6 col-md-3 branches">
        <div class="mainflip">
                <div class="frontside">
                    <div class="card">
                        <div class="card-body text-center">
                            <p><img class=" img-fluid" src="pictures/orgIcon.jpg" alt="card image"></p>
                            <h4 class="card-title">
                                <?php echo $branch['branch_name']; ?>
                            </h4>
                            <!-- Select TypeOfService -->
                            <div class="form-group ">
                                <label class=" control-label " for="selectbasic ">סוג שירות</label>
                                <div class="">

                                    <select id="<?php echo $branch['branch_id']; ?>" name="services" class="servlist form-control">
                                    <?php
                                        ?>
                                        <option value="---">---</option>
                                        <?php
                                        for($i=0;$i<count($services);$i++)
                                        {
                                          ?>  
                                            <option value="<?php echo $services[$i]['service_id']; ?>"><?php echo $services[$i]['service_name']; ?></option>
                                          <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <!-- endSelect -->
                            <center>
                                <button class="queSys btn btn-sm btn-primary btn-block" value='<?php echo $branch['branch_id']; ?>' name='<?php echo $branch['branch_name']; ?>'>בצע</button>
                            </center>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php
        }
    }
    
    //Function To Show All The Branches into Manager.php
    public function getBranchesManager($organization_username)
    {
        $sql = "SELECT branch_id,branch_name FROM branch WHERE org_username=?";
        $values=array($organization_username);
        
        $branches=$this->getInfo($sql,$values);
        
        //Paste The Card's Code Of Every Branch With Its Own Option Menu
        foreach($branches as $branch)
        {
            $i=$branch['branch_id'];
        ?>
        <div class="col-xs-12 col-sm-6 col-md-3 branches">
            <div class="mainflip">
                    <div class="frontside">
                        <div class="card">
                            <i class="fa fa-trash"></i>
                            <div class="card-body text-center">
                                <p><img class=" img-fluid" src="pictures/orgIcon.jpg" alt="card image"></p>
                                <h4 class="card-title">
                                    <?php echo $branch['branch_name']; ?>
                                    <?php echo $i; ?>
                                </h4>
                                <center>
                                    <div class="btn-group">
                                      <button type="button" value='<?php echo $organization_username; ?>' class="br options" data-toggle="dropdown">
                                        אפשרויות   <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu m" role="menu">
                                        <li><button name='<?php echo $i; ?>' class="br" data-toggle="modal" data-target="#addService">הוספת שירות</button></li>
                                        <li id="edBranch"><button name='<?php echo $i; ?>' class="br" data-toggle="modal" data-target="#editSnif">עדכון פרטים</button></li>
                                        <li id="edHours"><button name='<?php echo $i; ?>' class="br" data-toggle="modal" data-target="#edithours">עדכון שעות עבודה</button></li>
                                        <li id="edServ"><button name='<?php echo $i; ?>' class="br editSr" data-toggle="modal" data-target="#editServ" val='<?php echo $i; ?>'>עדכון/מחיקת סוג שירות</button></li>
                                          <li role="separator" class="divider"></li>
                                        <li id="delBranch"><button name='<?php echo $i; ?>' class="br delBranch" val='<?php echo $i; ?>'>מחיקת סניף</button></li>
                                      </ul>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <?php
        }
    }
    
    //Function To Delete Specifc Branch By ID
    public function deleteBranch($brID)
    {
        $values=array($brID);
        //First We Check If There Is No Appointments Available In The DataBase linked to This Branch
        $check=$this->getInfo("SELECT count(*) as nt FROM appointment WHERE branch_id=?",$values);

        if($check[0]['nt'])
            die("לא ניתן למחוק סניף שעבורו נקבע תור");
        
        //Delete From work_hours Table All The data That Linked To This Branch
        $sqlDel="DELETE FROM work_hours WHERE branch_id=?";
        $this->execute($sqlDel,$values);
        
        //Query To Get All The Services That Linked To This Branch
        $sql="SELECT service_id FROM service_branch WHERE branch_id=?";
        $sID=$this->getInfo($sql,$values);
        
        //Delete From service_branch Table All The data That Linked To This Branch
        $sqlDel="DELETE FROM service_branch WHERE branch_id=?";
        $this->execute($sqlDel,$values);
        
        foreach($sID as $s)
        {
            //Delete From service Table All The data That Linked To This Branch
            $sqlDel="DELETE FROM service WHERE service_id=?";
            $values=array($s['service_id']);
            $this->execute($sqlDel,$values);
            
        }
        
        //Delete From branch Table All The data That Linked To This Branch
        $sqlDel="DELETE FROM branch WHERE branch_id=?";
        $values=array($brID);
        $this->execute($sqlDel,$values);
        
        echo("סניף מספר ".$brID." נמחק בהצלחה!\n");
    }
    
    //Function To Delete Organization From The DataBase
     public function deleteOrg($orgUsername)
    {
        $values=array($orgUsername);
        
         //Check If There Is Appointment In The DB That Linked To This Organization
        $check=$this->getInfo("SELECT count(*) as nt FROM appointment WHERE username=?",$values);

        if($check[0]['nt'])
            die("לא ניתן למחוק ארגון שעבורו נקבע תור");
        
        //Query To Get All The Branches ID's Of This Organization 
        $sqlSelect ="SELECT branch_id FROM branch WHERE org_username=?";
        $branches=$this->getInfo($sqlSelect,$values);
         
         foreach($branches as $br)
         {
             $this->deleteBranch($br['branch_id']);
         }
         
        //Delete From org_represent Table All The data That Linked To This Organization
        $sqlDel="DELETE FROM org_represent WHERE username=?";
        $this->execute($sqlDel,$values);
        
        //Delete From org_manager Table All The data That Linked To This Organization
        $sqlDel="DELETE FROM org_manager WHERE username=?";
        $this->execute($sqlDel,$values);
         
        //Delete From organization Table All The data That Linked To This Organization
        $sqlDel="DELETE FROM organization WHERE organization_username=?";
        $this->execute($sqlDel,$values);
        
        die("בוצע בהצלחה");
    }
    
    

//----------------------- Services Functions ------------------------------------------------------------------
    
    //Insert New Service Into The DataBase
    public function insertService(serviceClass $info)
    {
        $values=array();
        //Query To insert Service Into Service Table
        $sqlInsert = "INSERT INTO service(service_name,app_time_avg) VALUES('".$info->getServiceName()."','".$info->getTimeAvg()."')";
        $this->execute($sqlInsert,$values);
        
        //Query To Get The ID Of The service That Got The Same service_name
        $sqlSelect ="SELECT service_id FROM service WHERE service_name=?";
        $values=array($info->getServiceName());
        $service_id=$this->getInfo($sqlSelect,$values);
        
        //Insert ID Into Parameter
        $id=end($service_id);
        
        //Query To Update The service_branch Table
        $values=array();
        $sqlInsert = "INSERT INTO service_branch(branch_id,service_id) VALUES('".$info->getBranchID()."','".$id["service_id"]."')";
        $this->execute($sqlInsert,$values);
    }
    
    //Function To Get All Branches List of Specific Organization
    public function getBranchesList($organization_username)
    {
        $sqlGetBranches="SELECT * FROM branch WHERE org_username=?";
        
        $values=array($organization_username);
        
        $branches=$this->getInfo($sqlGetBranches,$values);
        //To Fill Out The Selection Box By Branches List Of Specific Organization
        ?>
        <?php
                    ?>  
                    <option>---</option>
                  <?php
        foreach($branches as $branch)
        {
                    $i=$branch['branch_id'];
                    ?>  
                    <option name="<?php echo $i; ?>" value="<?php echo $i; ?>"><?php echo $branch['branch_name']; ?></option>
                  <?php
        }
        ?>
        <?php
    }
    
    
    //Function To Get All Services List of Specific Branch
    public function getSpecificServ($brID)
    {
        //Query To Get All The Services Using It To Avoid Duplicte Service Into Specific Branch 
        $sqlGetServices="SELECT service_name FROM service s INNER JOIN service_branch sb ON s.service_id=sb.service_id WHERE branch_id=?";
        $values = Array($brID);
        $services=$this->getInfo($sqlGetServices,$values);
        
        return $services;
    }
    
    //Function To Get All Services List of Specific Branch
    public function getServicesList($org_user,$branch_id)
    {
        //Query To Get Service ID's List Of Specific Branch
        $sqlGetServiceID="SELECT * FROM service s INNER JOIN service_branch sb ON s.service_id=sb.service_id WHERE branch_id=?";
        $values=array($branch_id);
        $serviceID=$this->getInfo($sqlGetServiceID,$values);
        //To Fill Out The Selection Box By Services List Of Specific Branch
        ?>
        <?php
                    ?>  
                    <option>---</option>
                  <?php
        foreach($serviceID as $i)
        {
                    $id=$i['service_id'];
                    ?>  
                    <option value="<?php echo $id; ?>"><?php echo $i['service_name']; ?></option>
                  <?php
        }
        ?>
        <?php
    }
    
    
    
    //Function To Get All The Working Hours List of Specific Branch
    public function getworkingTable($org_user,$branch_id)
    {   
        //Query To Get Branch information
        $sqlGetInfo="SELECT * FROM branch WHERE branch_id=? AND org_username=?";
        $values=array($branch_id,$org_user);
        $brInformaion=$this->getInfo($sqlGetInfo,$values);
        
        //Query To Get Working List Of Specific Branch
        $sqlGetTable="SELECT * FROM work_hours WHERE branch_id=?";
        $values=array($branch_id);
        $table=$this->getInfo($sqlGetTable,$values);
        
        $found=0;
        /* Fill The Table By The Data We Got From The DataBase Of Working Hours BY Day
            With Some Checks About Day Off And Break Time */
        ?>
            <thead>             
                <tr>
                    <th class="days">יום</th>
                    <th class="days"><div><span>פתיחה</span></div></th>
                    <th class="days"><div><span>סגירה</span></div></th>
                    <th class="days"><div><span>הפסקה</span></div></th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                      <th class="days">ראשון</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==1 && $d['dayOFF']==1) //Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                <tr>
                      <th class="days">שני</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==2 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1; //This Mean This Day Is Not Day Off
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                <tr>
                      <th class="days">שלישי</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==3 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                        {
                                            $found=1;//This Mean This Day Is Not Day Off
                                            ?>
                                                  <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                                  <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                                  <td><small><label>אין הפסקה</label></small></td>
                                            <?php
                                        }
                                        else
                                        {
                                            $found=1;
                                            ?>
                                                  <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                                  <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                                  <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                            <?php
                                        }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                
                <tr>
                      <th class="days">רביעי</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==4 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1;//This Mean This Day Is Not Day Off
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                
                <tr>
                      <th class="days">חמישי</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==5 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1;//This Mean This Day Is Not Day Off
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                <tr>
                      <th class="days">שישי</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==6 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1;//This Mean This Day Is Not Day Off
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
         
                 <tr>
                      <th class="days">שבת</th>
                        <?php 
                            foreach($table as $d)
                            {
                                if($d['day']==7 && $d['dayOFF']==1)//Check If It Is Not DayOff
                                {
                                    if($d['endA']=="00:00:00" && $d['startB']=="00:00:00")//Check If There Is No BreakTime
                                    {
                                        $found=1;//This Mean This Day Is Not Day Off
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label>אין הפסקה</label></small></td>
                                        <?php
                                    }
                                    else
                                    {
                                        $found=1;
                                        ?>
                                              <td><small><label><?php echo $d['startA']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endB']; ?></label></small></td>
                                              <td><small><label><?php echo $d['endA']; ?> - <?php echo $d['startB']; ?></label></small></td>
                                        <?php
                                    }
                                }
                            }
                            if($found==0)//Its Mean This Is Day Off Work
                                {
                                    ?>
                                          <td><label></label></td>
                                          <td><label>סגור</label></td>
                                          <td><label></label></td>
                                    <?php
                                }
                            $found=0;
                          ?>
                </tr>
                <tr>
                    <th class="days" style=color:black;>פרטי סניף</th>
                    <th class="days" style=color:black;><div><span class="glyphicon glyphicon-map-marker"><?php echo $brInformaion[0]['branch_address']; ?></span></div></th>
                    <th class="days" style=color:black;><div><span class="glyphicon glyphicon-phone-alt"><?php echo $brInformaion[0]['branch_tel']; ?></span></div></th>
                    <th class="days" style=color:black;><div><span class="glyphicon glyphicon-envelope"><?php echo $brInformaion[0]['branch_mail']; ?></span></div></th>
                </tr>

              </tbody>
        <?php
    }
        
    
    
    
    
    //Function To Get All The Times After Add The Average Minutes Time
    public function create_time_range($start, $end, $interval = '30 mins', $format = '24') {
        
        //Convert The Time To Time Value
        $startTime = strtotime($start); 
        $endTime   = strtotime($end);
        $returnTimeFormat = ($format == '12')?'g:i:s A':'G:i:s'; //Set The Format Of Time That We Want To Use

        $current   = time(); //Get The Current Time To Get The Differnce After Add The Average Time 
        $addTime   = strtotime('+'.$interval, $current); 
        $diff      = $addTime - $current; //Diffrence Time

        $times = array(); 
        while ($startTime < $endTime) { 
            $times[] = date($returnTimeFormat, $startTime); 
            $startTime += $diff; 
        } 
        $times[] = date($returnTimeFormat, $startTime); 
        return $times; 
    }    
    

    //Function To Get All The Available Time From The DB
    public function fillTime($dayNum,$branch_id,$serv,$org_user,$date)
    {   
        //Flag T Check If It Is ShiftNight
        $nightFlag=0;
        //Query To Get Working Hours Of Specific Day Of Specific Branch
        $sqlGetsch="SELECT * FROM work_hours WHERE branch_id=? AND day=?";
        $values=array($branch_id,$dayNum);
        $sch=$this->getInfo($sqlGetsch,$values);
        
        //Query To Get The Average Time Of Service
        $sqlGetServiceID="SELECT app_time_avg FROM service WHERE service_id=?";
        $values=array($serv);
        $getAvg=$this->getInfo($sqlGetServiceID,$values);
        $avgTime=$getAvg[0]['app_time_avg'];
        $avg='+'.$avgTime.' minutes';
        
        //Check If It Is Night Shifts
        if($sch[0]['startA']>"12:00" && $sch[0]['endB']>="00:00" && $sch[0]['endB']<="12:00")
        {
            $nightFlag=1;
            $freeTime1 = $this->create_time_range($sch[0]['startA'], "23:59" , $avg);
            //To Add Avg And Avoid Duplication Cell
            $time = strtotime(end($freeTime1));
            $avoidTime = date("H:i", strtotime($avg, $time));
            $freeTime2 = $this->create_time_range($avoidTime, $sch[0]['endB'] , $avg);
            $freeTime = array_merge($freeTime1, $freeTime2);
        }
        else // So It Is Morning Shifts
        {
            $freeTime = $this->create_time_range($sch[0]['startA'], $sch[0]['endB'], $avg);
        }
        
        $minTime='-'.$avgTime.' minutes'; //To Get Out The Dates That Are Less Than the Average Appointment Time
        
        //loop To Take out all The Break Time 
        for($i=0;$i<count($freeTime);$i++)
        {
            if(isset($freeTime[$i]))//If this index exists
            {
                $t = date("H:i",strtotime($freeTime[$i]));
                $time = strtotime($sch[0]['endA']);
                $endA = date("H:i", strtotime($minTime, $time));
                $startB = date("H:i",strtotime($sch[0]['startB']));
                if($startB=="00:00")
                    $startB="23:59";
                $time = strtotime($sch[0]['endB']);
                $endB = date("H:i", strtotime($minTime, $time));
                if($t>=$endA && $t<$startB)
                    unset($freeTime[$i]);
            }
        }
        //Query To Get All The Appointment Of Specific Day Of Specific Branch With Specific Service
        $sqlGetAllApp="SELECT appointment_time FROM appointment WHERE branch_id=? AND service_id=? AND appointment_date=?";
        $values=array($branch_id,$serv,$date);
        $apps=$this->getInfo($sqlGetAllApp,$values);


        //loop To Take out all The Exists Time 
        for($i=0;$i<count($freeTime);$i++)
        {
            if(isset($freeTime[$i]))//If this index exists
            {
                $t = date("H:i",strtotime($freeTime[$i]));
                foreach($apps as $p)
                {
                    $time = date("H:i",strtotime($p['appointment_time']));
                    if($t==$time)
                        unset($freeTime[$i]);
                }
            }
        }
        //IF Its NightShift So We Remove ALl The Queues In The Next Day
        if($nightFlag==1)
        {
            $newDate=date($date);
            $newDate++;
            //Query To Get All The Appointment Of Specific Day Of Specific Branch With Specific Service
            $sqlGetAllApp="SELECT appointment_time FROM appointment WHERE branch_id=? AND service_id=? AND appointment_date=?";
            $values=array($branch_id,$serv,$newDate);
            $apps=$this->getInfo($sqlGetAllApp,$values);


            //loop To Take out all The Exists Time 
            for($i=0;$i<count($freeTime);$i++)
            {
                if(isset($freeTime[$i]))//If this index exists
                {
                    $t = date("H:i",strtotime($freeTime[$i]));
                    foreach($apps as $p)
                    {
                        $time = date("H:i",strtotime($p['appointment_time']));
                        if($t==$time)
                            unset($freeTime[$i]);
                    }
                }
            }
        }
        
        //Paste The Selection List Code Of Time Except The Last One
        foreach($freeTime as $time)
        {
            if($time!=end($freeTime))//Except the ending time
            {
            $startAp = date("H:i",strtotime($time));
          ?>  
            <option value="<?php echo $startAp; ?>"><?php echo $startAp; ?></option>
          <?php
          
            }
        }
    }
    
    //Edit Exist Appointment By Appointment ID
    public function editAppointMent(appointmentClass $info,$id)
    {   
        $values = array();
         $sqlUpdate="UPDATE appointment SET customer_name='".$info->getCustomerName()."',customer_mail='".$info->getCustomerMail()."',customer_id='".$info->getCustomerID()."',appointment_time='".$info->getAppointment_time()."',appointment_date='".$info->getAppointment_date()."' WHERE appointment_id='".$id."'";
         $this->execute($sqlUpdate,$values);
    }

    //Function To Get All Appointments
    public function getAllApp()
    {
        $sql = "SELECT * FROM appointment";
        $values=array();
        
        $ap=$this->getInfo($sql,$values);

        return $ap;
    }    
    
    //Delete Exist Appointment By Organization Represent
    public function delAppointMent(appointmentClass $info)
    { 
        $values=array($info->getAppointmentID());
        $sqlDel="DELETE FROM appointment WHERE appointment_id=?";
        $this->execute($sqlDel,$values);
    }
    
    //Delete Epired Date's Appointments Of Specific Organization
    public function delExpApp($username)
    { 
        $values=array();
        $dateNow=date('Y-m-d');
        $timeNow=date('H:i:s');
        $sqlDel="DELETE FROM appointment WHERE (username = '".$username."') AND ((appointment_date < '".$dateNow."') OR (appointment_date < '".$dateNow."' AND appointment_time<'".$timeNow."'))";
        $this->execute($sqlDel,$values);
    }

}
?>
