<?php

class organizationClass{
	
	private $organizationName; //Organization Name
    private $organizationUserName; //Organization Username
    private $organizationEmail; //Organization Mail
    private $organizationPassword;  //Organization Password
    
	
//------------- Get Data -----------------------------
    
    public function getOrganizationName() //Get Organization Name
	{
		return $this->organizationName;
	}
    
    public function getOrganizationUserName()   //Get Organization Username
	{
		return $this->organizationUserName;
	}
    
    public function getOrganizationEmail()  //Get Organization Mail
	{
		return $this->organizationEmail;
	}
    
    public function getOrganizationPassword()   //Get Organization Password
	{
		return $this->organizationPassword;
	}

//------------- Set Data -----------------------------
    
	public function setOrganizationName($name){	//Set Organization Name
		$this->organizationName=$name;
	}
    
    public function setOrganizationUserName($username){ //Set Organization Username	    
		$this->organizationUserName=$username;
	}
    
	public function setOrganizationEmail($email){  //Set Organization Mail	
		$this->organizationEmail=$email;
	}

	public function setOrganizationPassword($pass){    //Set Organization Password	
		$this->organizationPassword=$pass;
	}
}
?>