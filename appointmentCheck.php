<?php
session_start();
require_once("dbClass.php");
require_once("appointmentClass.php");

$db = new dbClass();

/*  ------------------ Insert Appointment ---------------- */

//Insert Appointment Into DataBase
if(isset($_POST['ord']))
{
    if(!(isset($_POST['selectedBranch']) && isset($_POST['selectedService'])))
        die("נא לבחור סניף מבוקש וסוג שירות מתאים");
    $info=array("client_name"=>$_POST['client_name'],"client_id"=>$_POST['client_id'],"client_email"=>$_POST['client_email'],"selectedBranch"=>$_POST['selectedBranch'],"selectedService"=>$_POST['selectedService'],"date"=>$_POST['date'],"time"=>$_POST['time'],"orgUser"=>$_POST['orgUser']);
    
    //Check If One Of The Inputs Empty
    if($info['client_name'] == "" || $info['client_id'] == "" || $info['client_email'] == "" || $info['client_email'] == "" ||              $info['selectedBranch'] == "" || $info['selectedService'] == "" || $info['selectedBranch'] == "---" || $info['selectedService'] == "---" || $info['date'] == "" || $info['time'] == "")
            die("חובה למלא את כל השדות");
    
    //Check client ID Validation
    if(strlen($info['client_id']) != 9 || !(ctype_digit($info['client_id'])) )
        die("נא להכניס קלט תקין , מספר תעודת הזהות חייב להיות מורכב מ-9 מספרים בדיוק");
    
    //Check Email Validation 
    if (!filter_var($info['client_email'], FILTER_VALIDATE_EMAIL))
        die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    
    //Check If The Customer ID Exsits In The DataBase in The Same Organization And Branch
    $customerIDExist=$db->isCustomerIDEXist($info['orgUser'],$info['selectedBranch'],$info['client_id']);
    if($customerIDExist)
        die("יש לך תור קיים בסניף הזה , על פי ת.ז שהכנסת , נא לבדוק שוב את פרטיך");
    
    if($info['date'] < date("Y-m-d"))
        die("נא לבחור תאריך תקין");
    
    if($info['date']==date("Y-m-d") && $info['time']< date('H:i'))
        die("נא לבחור תאריך ושעה תקינים");
    
    //Check That There Is No Appointment With The Same DateTime,Branch,Service
    $dateTimeExists=$db->checkDateTime($info['orgUser'],$info['selectedBranch'],$info['date'],$info['time']);
        if($dateTimeExists)
            die("לצערנו , התאריך והשעה שבהם ביקשת לא זמינים כעת , נא לבחור אחרת");
    
    //Update The Date If Its In ShiftNight And After 00:00 Clock
    $dateTimeShiftNight=$db->checkShiftNight($info['orgUser'],$info['selectedBranch'],$info['date'],$info['time']);
    //    Create New Object Of Appointment
    $appointment=new appointmentClass();
    
    $appointment->setCustomerID($info['client_id']);
    $appointment->setCustomerName($info['client_name']);
    $appointment->setBranchName($info['selectedBranch']);
    $appointment->setAppointmentService($info['selectedService']);
    $appointment->setAppointment_date($dateTimeShiftNight);
    $appointment->setAppointment_time($info['time']);
    $appointment->setCustomerMail($info['client_email']);
    
    //Function To Insert Appointment Into The DataBase
    die($db->insertAppointment($appointment,$info['orgUser']));
}

/*  ------------------ Delete Appointment ---------------- */

//Cancel AppointMent Check
if(isset($_POST['cancel']))
{   
    
    $info=array("customer_id"=>$_POST['customer_id'],"appointment_id"=>$_POST['appointment_id'],"email"=>$_POST['email']);
    
    //Check Customer ID Validation
    if(strlen($info['customer_id']) != 9)
        die("מספר תעודת הזהות חייב להיות מורכב מ-9 תווים בדיוק ,נא להכניס קלט תקין");
    //Check Customer Mail Validation
    if (!filter_var($info['email'], FILTER_VALIDATE_EMAIL))
        die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    //Create New Object Of Appointment
    $appointment=new appointmentClass();
    
    $appointment->setCustomerID($info['customer_id']);
    $appointment->setAppointmentID($info['appointment_id']);
    $appointment->setCustomerMail($info['email']);
    
    //Function To Delete Appointment From The DataBase
    die($db->cancelAppointment($appointment));
}

/*  ------------------ Fill Queues List ---------------- */

//To Get All The Queues That Linked to Specific Organization
if(isset($_POST['fill_Que']))
{
    $_SESSION['usr_info']['currDate']=$_POST['chDate'];
    setcookie("curDate", $_SESSION['usr_info']['currDate']);
    die($db->getQueList($_POST['fill_Que'],$_POST['braID'],$_POST['brService'],$_POST['chDate']));
}

/*  ------------------ Set Branch Name ---------------- */

//Set The Branch Name That Choosed By The User In SESSION
if(isset($_POST['brID']))
{
    if(isset($_POST['brServiceID']))
    {
        //check if the user selected a valid service
        if($_POST['brServiceID']=="---")
            die("נא לבחור סוג שירות מתאים");

        $_SESSION['usr_info']['brID']=$_POST['brID'];
        $_SESSION['usr_info']['brServiceID']=$_POST['brServiceID'];
    }
    else
        die("נא לבחור סוג שירות מתאים");
}

/*  ------------------ Delete The Finished Queue ---------------- */

if(isset($_POST['nextqueue']))
{
    die($db->delCurrentQue($_POST['queID']));
}

/*  ------------------ Update Appointment Information ---------------- */

//Edit Appointment Information
if(isset($_POST['editAp'])) 
{
     $info=array("client_name"=>$_POST['client_name'],"client_id"=>$_POST['client_id'],"client_email"=>$_POST['client_email'] ,"date"=>$_POST['date'],"time"=>$_POST['time'] ,"ApID"=>$_POST['ApID']);
    
    if($info['client_name'] == "" || $info['client_id'] == "" || $info['client_email'] == "")
        die("נא להזין את הנתונים שברצונך לעדכן");
    
    //Check Email Validation
    if($info['client_email'] != "")
    {
        if(!filter_var($info['client_email'], FILTER_VALIDATE_EMAIL))
            die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    }
    
    //Check Id Validation
    if($info['client_id'] != "")
    {
        if(strlen($info['client_id']) != 9)
            die("נא להכניס מספר תעודת זהות תקין ,המספר חייב להיות מורכב מ-9 ספרות");
    }
    
    //Check Date Validation
    if(!$info['date'] || $info['date'] < date("Y-m-d") || !$info['time'])
        die("נא לבחור תאריך ושעה תקינים");
    
    if($info['date']==date("Y-m-d") && $info['time']< date('H:i'))
        die("נא לבחור תאריך ושעה תקינים");
    
    //Check If The Inputs Are Exsits In The DataBase
    $Appointments=$db->getAllApp();
    foreach($Appointments as $ap)
    {
        //Check Client ID
        if(!strcmp($ap['customer_id'],$info['client_id']) && $ap['appointment_id']!=$info['ApID'])
            die('תעודת הזהות שהכנסת נמצאת כבר במערכת ,נא להכניס ת.ז אחרת');
    }
    //Create New Object Of Appointment
    $ap = new appointmentClass();
    $ap->setCustomerID($info['client_id']);
    $ap->setCustomerMail($info['client_email']);
    $ap->setCustomerName($info['client_name']); 
    $ap->setAppointment_date($info['date']);
    $ap->setAppointment_time($info['time']);             
    
    //Function To Update Specific Appointment
    die($db->editAppointMent($ap,$info['ApID']));
}

/*  ------------------ Delete Appointment By Represent ---------------- */

//Delete Appointment From DataBase
if(isset($_POST['delAp']))
{
     $info=array("ApID"=>$_POST['ApID']);
    
    $ap = new appointmentClass();
    $ap->setAppointmentID($info['ApID']);          
    
    die($db->delAppointMent($ap));
}

/*  ------------------ Set Appointment Value Into Modal ---------------- */

//Set Current Value Of Specific Appointment From DataBase
if(isset($_POST['EditAp']))
{        
    die($db->setAppointmentValues($_POST['ApID']));
}

/*  ------------------ Fill The Available Appointment Time Into The Selection Box ---------------- */

//To Get All The Available Time From The DB
if(isset($_POST['fillTimeQue']))
{
    $day=date('D', strtotime($_POST['selectDate']));
    switch ($day) {
                case "Sun": $day=1; break;
                case "Mon": $day=2; break;
                case "Tue": $day=3; break;
                case "Wed": $day=4; break;
                case "Thu": $day=5; break;
                case "Fri": $day=6; break;
                case "Sat": $day=7; break;
            }
    die($db->fillTime($day,$_POST['nameID'],$_POST['sServ'],$_POST['orgUser'],$_POST['selectDate']));
}














?>