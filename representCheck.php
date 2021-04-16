<?php
session_start();
require_once("dbClass.php");
require_once("org_representClass.php");

$db = new dbClass();

/*  ------------------ Represent Sign In ---------------- */

//Represent Sign In Check
if(isset($_POST['sign'])) {
    $info=array("rep_name"=>$_POST['rep_name'],"rep_password"=>$_POST['rep_password']);
    $represent = new org_representClass();
    $represent->setUsername($info['rep_name']);
    $represent->setPassword($info['rep_password']);
    $_SESSION['usr_info']['signupcheck']=1;
    die($db->representSignIn($represent));
}

/*  ------------------ Manager Sign In ---------------- */

//Manager Sign In Check
if(isset($_POST['managerSign'])) {
    
    $info=array("rep_name"=>$_POST['rep_name'],"rep_password"=>$_POST['rep_password']);
    //check if the username is the same as in The Session
    if($info['rep_name']!=$_SESSION['usr_info']['organization_username'])
        die("שם משתמש לא נכון!");
    $represent = new org_representClass();
    $represent->setUsername($info['rep_name']);
    $represent->setPassword($info['rep_password']);
    die($db->managerSignIn($represent));
}

/*  ------------------ Manager Sign Up ---------------- */

//Manager Sign Up
if(isset($_POST['updatemanager'])) {
    
$info=array("managermail"=>$_POST['managermail'],"pass1"=>$_POST['pass1'],"pass2"=>$_POST['pass2']);

    
    //Check if All Inputs Valida
    if($info['managermail'] == "" || $info['pass1'] == "" || $info['pass2'] == "")
            die("חובה למלא את כל השדות");
    
    
    //Check Email Validation 
    if (!filter_var($info['managermail'], FILTER_VALIDATE_EMAIL))
        die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    
    //Check Length of The passwrod
    if(strlen($info['pass1'])<6)
        die("הסיסמה חייבת להיות מורכבת מ-6 תווים לפחות ,נא להכניס שנית");
    
    //Check Passwords Validation
    if($info['pass1'] != $info['pass2'])
            die("הסיסמאות לא זהים ,נסה שנית");
    
    
    $MngMail=$db->getOrgManagersMail();
    
    //check if the Organization Name exist in the DataBase
   foreach($MngMail as $value)
   {
        if(!strcmp($value['manager_mail'],$info['managermail']))
            die("המייל שהכנסת כבר קיים במערכת ,נא להכניס מייל חדש");
   }

    //Create New Object Of Represent
    $manager = new org_representClass();
    $manager->setUsername($_SESSION['usr_info']['organization_username']);
    $manager->setPassword($info['pass1']);
    $manager->setManagerMail($info['managermail']);
    
    //Function To ADD Manager In The DataBase
    die($db->managerSignUp($manager));
}

/*  ------------------ Delete Expired Date's Appointments ---------------- */

//Delete Expired Date's Appointments
if(isset($_POST['delExpApp'])) 
{
    die($db->delExpApp($_POST['username']));
}

?>