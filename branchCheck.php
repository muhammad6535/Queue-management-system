<?php
session_start();
require_once("dbClass.php");
require_once("branchClass.php");
require_once("serviceClass.php");


$db = new dbClass();

/*  ------------------ Update Branch Information ---------------- */

//Edit Branch Information
if(isset($_POST['editsnif'])) 
{
     $info=array("editbranchName"=>$_POST['editbranchName'],"editbranchMail"=>$_POST['editbranchMail'],"editbranchTel"=>$_POST['editbranchTel'],"editbranchAddress"=>$_POST['editbranchAddress']);
    
    $id=$_POST['brID']; //Id Of the Branch that we want to change his Information
    
    if($info['editbranchName'] == "" || $info['editbranchMail'] == "" || $info['editbranchTel'] == "" || $info['editbranchAddress'] == "")
        die("נא להכניס הנתונים החסרים");
    
    //Check Email Validation
    if($info['editbranchMail'] != "")
    {
        if(!filter_var($info['editbranchMail'], FILTER_VALIDATE_EMAIL))
            die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    }
    
    //Check Phone Number Validation
    if($info['editbranchTel'] != "")
    {
        if(!preg_match('/^((\+972|972)|0)( |-)?([1-468-9]( |-)?\d{7}|(5|7)[0-9]( |-)?\d{7})$/', $info['editbranchTel']) ) 
         die('בבקשה הכנס מספר טלפון תקין');
    }
    
    //Check If The Inputs Are Exsits In The DataBase
    $branches=$db->getAllBranches();
    foreach($branches as $br)
    {
        
        //Check Branch Name
        if(!strcmp($br['branch_name'],$info['editbranchName']) && $br['branch_id']!=$id)
            die("שם הסניף שהוכנסת כבר קיים במערכת ,נא להכניס שם אחר");
        
        //Check Branch Mail
        if(!strcmp($br['branch_mail'],$info['editbranchMail']) && $br['branch_id']!=$id)
            die('המייל שהכנסת נמצא כבר במערכת ,נא להכניס מייל אחר');
        
        //Check Branch Tel
        if(!strcmp($br['branch_tel'],$info['editbranchTel']) && $br['branch_id']!=$id)
            die('מספר הטלפון שהכנסת נמצא כבר במערכת ,נא להכניס מייל אחר');
    }
    
    
    $br = new branchClass();
    $br->setBranchName($info['editbranchName']);
    $br->setBranchMail($info['editbranchMail']);
    $br->setBranchTel($info['editbranchTel']);
    $br->setBranchAddress($info['editbranchAddress']);

    die($db->editBranch($br,$id));
}

/*  ------------------ Update Organization Information ---------------- */

//Edit Organization Information
if(isset($_POST['editorganization'])) 
{
     $info=array("editorgaName"=>$_POST['editorgaName'],"editorgaMail"=>$_POST['editorgaMail'],"orgPass"=>$_POST['orgPass']);
    
    $username=$_POST['usernameOrga']; //Username OF The Organization that we want to change his Information
    
    if($info['editorgaName'] == "" || $info['editorgaMail'] == "" || $info['orgPass'] == "")
        die("נא להכניס הנתונים החסרים");
    
    //Check Email Validation
    if($info['editorgaMail'] != "")
    {
        if(!filter_var($info['editorgaMail'], FILTER_VALIDATE_EMAIL))
            die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    }
    
    //Check If The Inputs Are Exsits In The DataBase
    $orgs=$db->getAllOrgs();
    foreach($orgs as $org)
    {
        
        //Check Branch Name
        if(!strcmp($org['organization_name'],$info['editorgaName']) && $org['organization_username']!=$username)
            die("שם הסניף שהוכנסת כבר קיים במערכת ,נא להכניס שם אחר");
        
        //Check Branch Mail
        if(!strcmp($org['organization_email'],$info['editorgaMail']) && $org['organization_username']!=$username)
            die('המייל שהכנסת נמצא כבר במערכת ,נא להכניס מייל אחר');
    }
    
    
    $org = new organizationClass();
    $org->setOrganizationName($info['editorgaName']);
    $org->setOrganizationEmail($info['editorgaMail']);
    $org->setOrganizationPassword($info['orgPass']);

    die($db->editorganization($org,$username));
}

/*  ------------------ Update Manager Information ---------------- */

//Edit Manager Information
if(isset($_POST['managerEdit'])) 
{
     $info=array("cur_password"=>$_POST['cur_password'],"password1"=>$_POST['password1'],"password2"=>$_POST['password2'],"managerMail"=>$_POST['managerMail']);
    
    //Query To Check If The Current Password is The Same as Original Password
    if($db->checkManagerPass($info['cur_password'],$_SESSION['usr_info']['organization_username'])!=1)
        die("הסיסמה הנוכחית שהזנת אינה תואמת לסיסמה המקורית");
    if($info['password1']!=$info['password2'])
        die("הסיסמה החדשה שהזנת אינה תואמת את הסיסמה השניה");
    
    //Check Email Validation
    if($info['managerMail'] != "")
    {
        if(!filter_var($info['managerMail'], FILTER_VALIDATE_EMAIL))
            die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    }
    //Check Length of The passwrod
    if($info['password1'] != "")
    {
        if(strlen($info['password1'])<6)
            die("הסיסמה חייבת להיות מורכבת מ-6 תווים לפחות ,נא להכניס שנית");
    }
    
    //Create New Object Of Represent
    $represent = new org_representClass();
    $represent->setPassword($info['password1']);
    $represent->setManagerMail($info['managerMail']);
    
    //Function To Update Manager Information
    die($db->updateManagerInfo($represent,$_SESSION['usr_info']['organization_username']));
}

/*  ------------------ Insert New Branch Into DataBase ---------------- */

//Add Branch into Organization
if(isset($_POST['addsnif'])) {
    
    $hoursArr=$_POST['daysArr'];
    $info=array("branchID"=>$_POST['branchID'],"branchName"=>$_POST['branchName'],"branchMail"=>$_POST['branchMail'],"branchTel"=>$_POST['branchTel'],"branchAddress"=>$_POST['branchAddress']);
        
    if($info['branchID'] == "" || $info['branchName'] == "" || $info['branchMail'] == "" || $info['branchTel'] == "" || $info['branchAddress'] == "")
        die("חובה למלא כל השדות");
    
    
    //Check BranchID Validation
    if(!is_numeric($info['branchID']))
        die("מספר המזהה לא תקין ,נא לוודה שקלט מורכב רק ממספרים");
    
    //Check Email Validation
    if(!filter_var($info['branchMail'], FILTER_VALIDATE_EMAIL))
        die("המייל שהכנסת לא תקין ,נא להכניס מייל תקין");
    
    //Check TelePhone Number Validation
    if(!preg_match('/^((\+972|972)|0)( |-)?([1-468-9]( |-)?\d{7}|(5|7)[0-9]( |-)?\d{7})$/', $info['branchTel']) ) 
     die('בבקשה הכנס מספר טלפון תקין');
    
    
    //Check If The Inputs Are Exsits In The DataBase
    $branches=$db->getAllBranches();
    foreach($branches as $br)
    {
        //Chech Branch ID
        if(!strcmp($br['branch_id'],$info['branchID']))
            die("מספר הסניף שהוכנס כבר קיים במערכת ,נא להכניס מספר אחר");
        
        //Check Branch Mail
        if(!strcmp($br['branch_mail'],$info['branchMail']))
            die('המייל שהכנסת נמצא כבר במערכת ,נא להכניס מייל אחר');
        
        //Check Branch Tel
        if(!strcmp($br['branch_tel'],$info['branchTel']))
            die('מספר הטלפון שהכנסת נמצא כבר במערכת ,נא להכניס מייל אחר');
    }
    
     
    //Check Validety of Working Hours Of The Branch
    for($i=0;$i<count($hoursArr);$i++)
    {
        for($j=0,$count=0;$j<4;$j++)
            if($hoursArr[$i][$j]!="")
                $count++;
        
        //Check If There Is Something Wrong With The Open And Close Time Of The Branch
        if($count==2 && !($hoursArr[$i][0] && $hoursArr[$i][3]))
        {
            switch ($i) {
                case 0: die("שגיאה ביום ראשון ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 1: die("שגיאה ביום שני ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 2: die("שגיאה ביום שלישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 3: die("שגיאה ביום רביעי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 4: die("שגיאה ביום חמישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 5: die("שגיאה ביום שישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 6: die("שגיאה ביום שבת ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
            }
        }
        
        //Check If There Is No Missing Time
        if($count!=4 && $count!=0 && $count!=2)
        {
            switch ($i) {
                 case 0: die("שגיאה ביום ראשון ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 1: die("שגיאה ביום שני ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 2: die("שגיאה ביום שלישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 3: die("שגיאה ביום רביעי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 4: die("שגיאה ביום חמישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 5: die("שגיאה ביום שישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 6: die("שגיאה ביום שבת ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
            }
        }
        
        //Check If This Day Is Day Off OR NOT
        if($count==4 || ($hoursArr[$i][0] && $hoursArr[$i][3]))
        {
            $hoursArr[$i][4]=$i+1;
            $hoursArr[$i][5]=1; //if it Is 1 So it Is Not Day Off
        }
        else
        {
            $hoursArr[$i][4]=$i+1;
            $hoursArr[$i][5]=0; //if it Is 0 So it Is Day Off
        }
    }
    
    //Create New Object Of Branch
    $br = new branchClass();
    $br->setBranchID($info['branchID']);
    $br->setBranchName($info['branchName']);
    $br->setBranchMail($info['branchMail']);
    $br->setBranchTel($info['branchTel']);
    $br->setBranchAddress($info['branchAddress']);
    
    //Function To Insert This Branch Object Into DataBase
    die($db->insertBranch($br,$hoursArr));
}

/*  ------------------ Insert New Service In Specific Branch Into DataBase ---------------- */

//Add Services Into A Branch
if(isset($_POST['serv']))
{
    //check if Inserted Value Into Service Array
    if(isset($_POST['arr']))
    {
         
      
        $info=$_POST['arr'];
        
        if(count($info) == 0)
            die("נא להכניס סוג שירות!");
         
        $_SESSION['usr_info']['branch_id']=$_POST['brID'];
        $id = $_SESSION['usr_info']['branch_id'];

        //To Get All The Services Of Specific Branch
        $serv = $db->getSpecificServ($id);
        for($i=0;$i<count($info) ;$i++)
        {
            foreach($serv as $s)
            { //Check To Avoid Duplicate Service In This Branch
                if($info[$i][0] == $s['service_name'])
                {
                    die("סוג השירות ".$info[$i][0]." קיים כבר בסניף הזה");
                }
            }
        }
        
        //Create Service Object For Each Service Inserted
        foreach($info as $value)
        {
            if($value)
            {   
                $sr = new serviceClass();
                $sr->setServiceName($value[0]);
                $sr->setBranchID($id);
                $sr->setTimeAvg($value[1]);
                
                //Insert The Service Into DataBase
                $db->insertService($sr);
            }
        }
    }
    else
        die("נא להכניס סוג שירות!");
}

/*  ------------------ Update Working Hours Of Specific Branch ---------------- */

//Update Working Hours For Branchs
if(isset($_POST['editbranchour']))
{
    $hours=$_POST['daysArr'];
    
    //Check Validety of Working Time Inserted For Each Day
    for($i=0;$i<count($hours);$i++)
    {
        for($j=0,$count=0;$j<4;$j++)
            if($hours[$i][$j]!="" && $hours[$i][$j]!="00:00" && $hours[$i][$j]!="00:00:00")
                $count++; //Count The Amount Of Cells Left Blank Or Have Been Filled By Zero
        
        //Check If Something Worng With The Open And Close Time Value
        if($count==2 && ($hours[$i][0]=="" || $hours[$i][3]=="" || $hours[$i][0]=="00:00" || $hours[$i][0]=="00:00:00" || $hours[$i][3]=="00:00" || $hours[$i][3]=="00:00:00"))
        {
            switch ($i) {
                case 0: die("שגיאה ביום ראשון ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 1: die("שגיאה ביום שני ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 2: die("שגיאה ביום שלישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 3: die("שגיאה ביום רביעי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 4: die("שגיאה ביום חמישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 5: die("שגיאה ביום שישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 6: die("שגיאה ביום שבת ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
            }
        }
        
        //Check If There Is An Empty Cell That It Has To Be Filled
        if(($count==3 && $hours[$i][0]=="00:00" && $hours[$i][3]=="00:00" && $hours[$i][0]=="" && $hours[$i][3]=="") || $count==1)
        {
            switch ($i) {
                 case 0: die("שגיאה ביום ראשון ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 1: die("שגיאה ביום שני ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 2: die("שגיאה ביום שלישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 3: die("שגיאה ביום רביעי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 4: die("שגיאה ביום חמישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 5: die("שגיאה ביום שישי ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
                case 6: die("שגיאה ביום שבת ,נא להגדיר את השעות בצורה תקינה ,חובה להגדיר שעת פתיחה ושעת סגירה"); break;
            }
        }
        
        //Check If This Day Is Day Off OR NOT
        if($count==4 || ($hours[$i][0] && $hours[$i][3] && $hours[$i][0]!="00:00" && $hours[$i][3]!="00:00" && $hours[$i][0]!="00:00:00" && $hours[$i][3]!="00:00:00"))
        {
            $hours[$i][4]=$i+1;
            $hours[$i][5]=1; //if it Is 1 So it Is Not Day Off
        }
        else
        {
            $hours[$i][4]=$i+1;
            $hours[$i][5]=0; //if it Is 0 So it Is Day Off
        }
    }
    die($db->editHours($hours,$_POST['brID']));
}

/*  ------------------ Set The Information Of The Selected Branch In The Appropriate Places ---------------- */

//Set The Current Branch info into Fields
if(isset($_POST['braID']))
{
    die($db->fillFields($_POST['braID']));
}

/*  ------------------ Set The Information Of Working Hours Of The Selected Branch In The Appropriate Places ---------------- */

//Set The Current Branch Working Hours Info
if(isset($_POST['updateHours']))
{
    die($db->fillHours($_POST['brID']));
}

/*  ------------------ Get All The Services That Linked The Selected Branch ---------------- */

//To Get All The Services That Linked to Specific Branch
if(isset($_POST['editServ']))
{
    die($db->getServiceInfo($_POST['selectedBranchID']));
}
    
/*  ------------------ Get All The Current Manager Information ---------------- */

if(isset($_POST['editmanager']))
{
    die($db->getManagerInfo($_POST['usernameOrg']));
}

/*  ------------------ Get All The Current Organization Information ---------------- */

if(isset($_POST['editorga']))
{
    die($db->getOrgaInfo($_POST['usernameOrga']));
}

/*  ------------------ Set The Information Of The Selected Service In The Appropriate Places ---------------- */

//To Set The Current Info Of Selected Service 
if(isset($_POST['setValues']))
{
    if(!(isset($_POST['selectedServ'])) || $_POST['selectedServ']=="---")
        die("נא לבחור סוג שירות");
    die($db->setServiceInfo($_POST['selectedServ']));
}

/*  ------------------ Update The Service ---------------- */

//Update The Service Name Or Average Time In DataBase
if(isset($_POST['updateServ']))
{
    if(!(isset($_POST['selectedServID'])))
        die("נא לבחור סוג שירות שברצונך לעדכן");
    
    die($db->updateServiceInfo($_POST['selectedServID'],$_POST['selectedServName'],$_POST['selectedAvg']));
}

/*  ------------------ Delete Specific Service ---------------- */

//Delete The Service From The DB
if(isset($_POST['deleteServ']))
{
    if(!(isset($_POST['selectedServID'])))
        die("נא לבחור סוג שירות שברצונך לעדכן");
    
    die($db->deleteServiceInfo($_POST['selectedServID']));
}

/*  ------------------ Delete Specific Branch ---------------- */

//Delete Branch From The DB
if(isset($_POST['deleteBranch']))
{
    //Function To Delete Branch 
    die($db->deleteBranch($_POST['selectedBranch']));
}

/*  ------------------ Delete Specific Organization ---------------- */

//Delete Organization From The DB
if(isset($_POST['deleteOrg']))
{
    //Function To Delete Branch 
    die($db->deleteOrg($_POST['selectedOrg']));
}



?>