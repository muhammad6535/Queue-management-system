<?php
session_start();
require_once("dbClass.php");
require_once("organizationClass.php");

$db = new dbClass();

/*  ------------------ Organization Register Check ---------------- */

if(isset($_POST['org'])) {
    
    $info=array("org_name"=>$_POST['org_name'],"org_username"=>$_POST['org_username'],"org_email"=>$_POST['org_email'],"org_password1"=>$_POST['org_password1'],"org_password2"=>$_POST['org_password2']);
    
    $orgs=$db->getAllOrganizations();
    
    //Check If One Of The Inputs Empty
    if($info['org_name'] == "" || $info['org_username'] == "" || $info['org_password1'] == "" || $info['org_password2'] == "" ||              $info['org_email'] == "")
            die("חובה למלא את כל השדות");
    
    
     //Check Name Of The Organization Validation
    if(strlen($info['org_name'])<3)
        die("שם הארגון חייב להיות מורכב מ-3 תווים ,נא להכניס שנית");
    
    
    
    //Check UserName Of The Organization Validation
    if(strlen($info['org_username'])<3)
        die("שם המשתמש חייב להיות מורכב מ-5 תווים לפחות ,נא להכניס שנית");
        
    
    
    //Check Email Validation 
    if (!filter_var($info['org_email'], FILTER_VALIDATE_EMAIL))
        die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    
    
    
    //Check Password Validation
    if($info['org_password1'] != $info['org_password2'])
            die("הסיסמאות לא זהים ,נסה שנית");
    
    
    //Check Length of The passwrod
    if(strlen($info['org_password1'])<6)
        die("הסיסמה חייבת להיות מורכבת מ-6 תווים לפחות ,נא להכניס שנית");
    
    
    
    //check if the Organization Informatios exists in the DataBase
   foreach($orgs as $value)
   {
       //Check Organization User Name
        if(!strcmp($value['organization_name'],$info['org_name']))
            die("שם הארגון שהכנסת כבר קיים במערכת ,נא להכניס שם אחר");
       
       //Check Organization userName
       if(!strcmp($value['organization_username'],$info['org_username']))
            die("שם המשתמש שהכנסת כבר קיים במערכת ,נא להכניס שם משתמש אחר");
       
       //Check Organization Email
       if(!strcmp($value['organization_email'],$info['org_email']))
            die("האימייל שהכנסת כבר קיים במערכת ,נא להכניס אימייל אחר");
   }
    
    //Create New Organization Object
    $_SESSION['usr_info']['signupcheck']=1;
    $org = new organizationClass();
    $org->setOrganizationName($info['org_name']);
    $org->setOrganizationUserName($info['org_username']);
    $org->setOrganizationEmail($info['org_email']);
    $org->setOrganizationPassword($info['org_password1']);
    
    //Function To ADD New Organization Into DataBase
    die($db->insertOrganization($org));
}

/*  ------------------ Show Branches List Into Manager Page (Manager.php) ---------------- */

//Show Branches List Into Organization's Manager Page
if(isset($_POST['show_branchesManager']))
{
    die($db->getBranchesManager($_POST['show_branchesManager']));
}

/*  ------------------ Show Branches List Into Represent Page (Branches.php) ---------------- */

//Show Branches List Into Organization's Represent Page
if(isset($_POST['show_branches']))
{
    die($db->getBranches($_POST['show_branches']));
}

/*  -- -- -- -- -- -- -- -- -- -- Functions That Linked To Organizations Page -- -- -- -- -- -- -- -- -- */

/*  ------------------ Show Organizations Into Organization Page ---------------- */
//To Get All The Organizations List 
if(isset($_POST['show_organization']))
{
    die($db->getOrganizations());
}

/*  ------------------ Get Branches List Of Specific Organization ---------------- */

//To Get Specific Organization Branches List
if(isset($_POST['show_bra']))
{
    die($db->getBranchesList($_POST['show_bra']));
}

/*  ------------------ Get Services List Of Specific Branch ---------------- */

//To Get All The Services That Linked to Specific Organization And Branch
if(isset($_POST['show_serv']))
{
    die($db->getServicesList($_POST['orgUser'],$_POST['show_serv']));
}

/*  ------------------ Get Working Hours Table Of Specific Branch ---------------- */

//To Get All The Working Hours Table From DB
if(isset($_POST['sbra']))
{
    die($db->getworkingTable($_POST['orgUser'],$_POST['sbra']));
}

/*  ------------------ Fill The Available Appointments Time ---------------- */

//To Get All The Available Time From The DB
if(isset($_POST['fillTime']))
{
    if($_POST['selectDate']=="" || !(isset($_POST['brID'])) || $_POST['sServ']=="---" || $_POST['sServ']=="")
    {
        die("נא לבחור סניף ושירות מתאים");
    }
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
    die($db->fillTime($day,$_POST['brID'],$_POST['sServ'],$_POST['orgUser'],$_POST['selectDate']));
}



?>